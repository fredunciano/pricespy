<?php

namespace App\Http\Controllers;

use App\Category;
use App\CsvErrorProduct;
use App\Exports\PriceUpdateTemplate;
use App\Exports\ProductPriceHistoryExport;
use App\Jobs\ProcessImportableFiles;
use App\Product;
use App\ProductBinding;
use App\ProductPriceEntry;
use App\Source;
use App\User;
use Barryvdh\DomPDF\Facade as PDF;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Input;
use Maatwebsite\Excel\Facades\Excel;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class ProductsController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */

    public function index()
    {
        $importFailedProducts = CsvErrorProduct::where('user_id', auth()->user()->id)->get()->count();
        $stores = auth()->user()->sources()->where('is_main', 1)->get();
        return view('products.index', compact('stores', 'importFailedProducts'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */

    public function create()
    {
        $stores = auth()->user()->sources()->where('is_main', 1)->get();
        if ($stores->count() == 0) {
            return redirect()->back()->with('error', 'main_shop_not_found');
        }
        $categories = auth()->user()->categories;
        if ($categories->isEmpty()) {
            return redirect('/')->with('error', 'please-create-categories');
        }
        return view('products.create', compact('stores', 'categories'));
    }

    public function bulkUpload()
    {
        return view('products.bulk-upload');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return Response
     */

    public function store(Request $request)
    {
        $request->validate(Product::$validation);
        $data = $request->input();
        if ($request->hasFile('image')) {
            $data['image'] = User::saveFile($request->file('image'), 'products/' . auth()->id(), $request->image);
        }
        if (!Source::where('user_id', auth()->user()->user_id)->where('id', $request->source_id)->count()) {
            abort(422);
        }
        Product::add($data);

        return redirect()->route('products.my')->with('success', 'product.create.success');
    }

    public function csvStore(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:csv,txt'
        ], ['file.mimes' => 'File type must be: CSV', 'file.required' => 'You have not chose any file']);

        $shopType = $request->input('shop_system');

        $f = fopen($request->file('file'), 'r');
        $firstLine = fgets($f); //get first line of csv file
        fclose($f); // close file
        if (in_array($shopType, [1, 2, 3, 6])) {
            $headings = str_getcsv(trim($firstLine), ',', '"'); //parse to array
            $header = implode(',', $headings);
        } else {
            $headings = str_getcsv(trim($firstLine), ';', '"'); //parse to array
            $header = implode(';', $headings);
        }

        $headingValidateError = Product::validateProductImportHeaderRow($headings, (int)$shopType);
        if ($headingValidateError) {
            $v = \Validator::make([], []);
            $v->errors()->add('file', trans('general.columns_validation_error'));
            return back()->withErrors($v->errors()->messages());
        }

        $path = request()->file('file')->getRealPath();
        $file = file($path);
        $data = array_slice($file, 1);
        $parts = array_chunk($data, 1000);
        $folderPath = public_path() . '/custom_storage/products/' . auth()->user()->user_id;
        File::makeDirectory($folderPath, 0777, true, true);
        $userName = auth()->user()->name;
        foreach ($parts as $i => $line) {
            array_unshift($line, $header . "\r\n");
            $filename = $folderPath . '/' . $userName . $i . '.csv';
            file_put_contents($filename, $line);
            $import = [
                'shop_type' => $shopType,
                'enable_price_override' => $request->input('enable_price_override'),
                'user_id' => auth()->user()->user_id,
                'csv_path' => $filename
            ];
            dispatch(new ProcessImportableFiles($import, $headings));
        }

        return back()->with('success', 'queued_import');
    }

    public function fixBulkUpload(Request $request)
    {
        $bulkProductUploadHasError = CsvErrorProduct::where('user_id', auth()->user()->id)->paginate(10);
        $params = $request->all();
        if ($request->has('page') && count($params) == 1) {
            return response()->json($bulkProductUploadHasError);
        } else if (count($params) == 1 && !$request->has('page')) {
            $count = CsvErrorProduct::where('user_id', auth()->user()->id)->get()
                ->map(function ($item) {
                    $item = $item['description_as_array'];
                    $item['name'] = strtoupper($item['name']);
                    $item['category_name'] = $item['category_name'] ? strtoupper($item['category_name']) : null;
                    return $item;
                })
                ->where(array_keys($params)[0], strtoupper(array_values($params)[0]))->count();
            return response()->json($count);
        } else {
            $shops = auth()->user()->sources()->get();
            $categories = auth()->user()->categories()->get();
            $auth_id = auth()->user()->user_id;

            return view('products.fix-bulk-upload', compact('bulkProductUploadHasError', 'shops',
                'categories', 'auth_id'));
        }
    }

    public function updateBulkUploadProductDataByFilter(Request $request)
    {
        $categories = Category::where('user_id', auth()->user()->user_id)->select('id', 'name')->get()->values()->toArray();

        $whereColumn = $request->input('where_column');
        $whereValue = $request->input('where_column_value');

        CsvErrorProduct::where('user_id', auth()->user()->id)->orderBy('id', 'asc')->get()
            ->map(function ($item) {
                $item = $item['description_as_array'];
                $item['name'] = strtoupper($item['name']);
                $item['category_name'] = $item['category_name'] ? strtoupper($item['category_name']) : null;
                return $item;
            })
            ->where($whereColumn, strtoupper($whereValue))
            ->each(function ($item) use ($request, $categories) {
                $setColumn = $request->input('set_column');
                $setValue = $request->input('set_column_value');
                $item["$setColumn"] = $setValue;

                if ($setColumn == 'category_name') {
                    $category = collect($categories)->where('name', strtoupper($setValue))->first();
                    if ($category) {
                        $item['category_id'] = $category['id'];
                        $item['category_name'] = $category['name'];
                        // removing category error key from errors collection
                        if (in_array('category_not_found', $item['errors'])) {
                            $key = array_keys($item['errors'], 'category_not_found')[0];
                            unset($item['errors'][$key]);
                        }
                    }
                } else if ($setColumn == 'price') {
                    $vatDivisor = 19 / 100 + 1;
                    $item['price'] = (float)$item['price'];
                    $item['vat_price'] = round((float)$item['price'] * $vatDivisor, 2);
                    $item['system_calculated_vat_price'] = round((float)$item['price'] * $vatDivisor, 2);
                    // removing pricing error key from errors collection
                    if (in_array('product_gross_price_wrong', $item['errors'])) {
                        $key = array_keys($item['errors'], 'product_gross_price_wrong')[0];
                        unset($item['errors'][$key]);
                    }
                } else if ($setColumn == 'vat_price') {
                    $vatDivisor = 19 / 100 + 1;
                    $item['price'] = round((float)priceToFloat($item['vat_price']) / $vatDivisor, 2);
                }
                $products = [
                    'temp_id' => $item['temp_id'],
                    'user_id' => $item['user_id'],
                    'description' => json_encode($item)
                ];

                CsvErrorProduct::where('user_id', auth()->user()->id)->where('temp_id', $item['temp_id'])->update($products);

            });

        return redirect('/products/fix-bulk-upload?page=1');
    }


    /*
     * Pagination function for array
     */
    public function paginate($items, $perPage, $request)
    {
        $page = Input::get('page', 1); // Get the current page or default to 1

        $offset = ($page * $perPage) - $perPage;

        return new LengthAwarePaginator(
            array_slice($items, $offset, $perPage, true),
            count($items), $perPage, $page,
            ['path' => $request->url(), 'query' => $request->query()]
        );
    }

    public function removeProductFromErrorList(Request $request)
    {
        $this->removeProductByTemporaryId($request->temp_id);
    }

    public function removeProductByTemporaryId($tempId)
    {
        if (is_array($tempId)) {
            CsvErrorProduct::where('user_id', auth()->user()->user_id)->whereIn('temp_id', $tempId)->delete();
        } else {
            CsvErrorProduct::where('user_id', auth()->user()->user_id)->where('temp_id', $tempId)->delete();
        }
        return true;
    }

    public function saveProductFromCsvFix(Request $request)
    {
        $row = $request->product;
        $categories = Category::where('user_id', auth()->user()->user_id)->select('id', 'name')->get()->toArray();
        if ($row['category_id'] == null) {
            $category = collect($categories)->where('name', ucwords($row['category_name']))->first();
            if ($category == null) {
                $category = Category::create(['name' => $row['category_name'], 'user_id' => auth()->user()->user_id, 'slug' => slugify($row['category_name'])]);
                $row['category_id'] = $category->id;
            } else {
                $row['category_id'] = $category['id'];
            }
        }
        $productNameExits = Product::where('name', $row['name'])->where('user_id', $row['user_id'])->first();
        $row['product_name_exist'] = $productNameExits == null ? false : true;
        $validateResult = Product::validateAndSetErrors($row);

        if ($validateResult === true) {
            Product::addFromCsv($row);
            $this->removeProductByTemporaryId($row['temp_id']);
            $row = null;
        }
        return response()->json(['index' => $request->index, 'product' => $row]);
    }

    public function updateCsvStore(Request $request)
    {
        try {
            $rows = $request->all();
            $categories = Category::where('user_id', auth()->user()->user_id)->select('id', 'name')->get()->toArray();
            $products = Product::where('user_id', auth()->user()->user_id)->get();

            $productStatus = [];
            $tempIdArray = [];
            foreach ($rows as $index => $row) {
                if ($row['category_id'] == null) {
                    $category = collect($categories)->where('name', ucwords($row['category_name']))->first();
                    if ($category == null) {
                        $category = Category::create(['name' => $row['category_name'], 'user_id' => auth()->user()->user_id, 'slug' => slugify($row['category_name'])]);
                        array_push($categories, ['id' => $category->id, 'name' => $category->name]);
                        $row['category_id'] = $category->id;
                    } else {
                        $row['category_id'] = $category['id'];
                    }
                }
                $productNameExits = collect($products)->where('name', strtoupper($row['name']))->first();
                $row['product_name_exist'] = $productNameExits == null ? false : true;
                $validateResult = Product::validateAndSetErrors($row);

                if ($validateResult === true) {
                    Product::addFromCsv($row);
                    array_push($tempIdArray, $row['temp_id']);
                    $row = null;
                }
                array_push($productStatus, ['index' => $index, 'product' => $row]);
            }
            if (count($tempIdArray) > 0) {
                $this->removeProductByTemporaryId($tempIdArray);
            }
            return response()->json($productStatus);
        } catch (\Throwable $throwable) {
            return response()->json(['message' => $throwable->getMessage()], 500);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param Request $request
     * @param Product $product
     * @return Response
     */

    public function show(Request $request, Product $product)
    {
        if ($request->has('from')) {
            return response()->json($product->getHistory());
        }
        $history = $product->getHistory();
        $categories = auth()->user()->categories;
        $stores = auth()->user()->sources;
        $selected = collect($history['datasets'])->map(function ($item) {
            return explode(': ', $item['label'])[0];
        })->toArray();
        $startDate = json_encode($product->created_at->format('d.m.Y'));
        return view('products.show', compact('product', 'history', 'categories', 'stores', 'selected', 'startDate'));
    }

    /**
     * Generate Excel Report.
     *
     * @param Product $product
     * Returns Excel File
     * @return BinaryFileResponse
     */

    public function getCsv(Request $request, Product $product)
    {
        $history = $product->getHistory();
        $history['linked'] = (int)$request->linked;
        $history['product_name'] = $product->name;
        return Excel::download(new ProductPriceHistoryExport($history), "Product_" . $product->name . "_Graph_" . date('d.m.Y') . '.xlsx');
    }

    /**
     * Generate Excel Report.
     *
     * @param Request $request
     * @param Product $product
     * Returns PDF File
     * @return
     */

    public function getPdf(Request $request, Product $product)
    {
        $history = $product->getHistory();
        $history['linked'] = (int)$request->linked;
        $history['product_name'] = $product->name;
        $exportData = (new ProductPriceHistoryExport($history))->setData();
        $exportData['linked'] = $request->linked;
//        return view('templates.product-price-history-chart-data', compact('exportData'));
        $pdf = PDF::loadView('templates.product-price-history-chart-data', compact('exportData'));
        return $pdf->setPaper('a4', 'landscape')->download("Product_" . $product->name . "_Graph_" . date('d.m.Y') . '.pdf');
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param Product $product
     * @return Response
     */

    public function edit(Product $product)
    {
        if (!$product->source->is_main) {
            abort(404);
        }
        $stores = auth()->user()->sources()->where('is_main', 1)->get();
        $categories = auth()->user()->categories;
        return view('products.edit', compact('product', 'stores', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param Product $product
     * @return Response
     */

    public function update(Request $request, Product $product)
    {
        if (!Source::where('user_id', auth()->id())->where('id', $request->source_id)->count()) {
            abort(422);
        }
        $request->validate(Product::$validation);
        $data = $request->input();
        if ($request->hasFile('image')) {
            $data['image'] = User::saveFile($request->file('image'), 'products/' . auth()->id(), $request->image);
        }
        if (($request->has('delete-image') && $request->hasFile('image')) || $request->has('delete-image')) {
            User::deleteFile($product->image);
            $data['image'] = null;
        }
        $product->modify($data);
        return back()->with('success', 'product.update.success');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return Response
     */

    public function destroy($id)
    {
        //
    }

    /**
     * Delete a binding between products
     *
     * @param ProductBinding $binding
     * @return int
     */

    public function deleteBinding(ProductBinding $binding)
    {
        if ($binding) {
            $binding->delete();
            return 1;
        }
        return 0;
    }

    /**
     * @param Request $request
     * @param Product $product
     * @return \Illuminate\Http\RedirectResponse
     */

    public function uploadImage(Request $request, Product $product)
    {
        $request->validate([
            'image' => 'nullable|image|max:2000',
        ]);
        $data = $request->input();
        if ($request->hasFile('image')) {
            $data['image'] = User::saveFile($request->file('image'), 'products/' . auth()->id(), $product->image);
        } elseif ($request->has('delete-image')) {
            User::deleteFile(auth()->user()->image);
            $data['image'] = null;
        }
        $product->update($data);
        return back()->with('success', 'product.update.success');
    }

    public function bulkPriceUpdate()
    {
        return view('products.bulk-price-update');
    }

    public function exportProductTemplate()
    {
        $products = Product::with('category:id,name')->with('source:id,name')->orderBy('source_id', 'asc')
            ->whereHas('source')
            ->select('id', 'name', 'category_id', 'source_id', 'price', 'vat_price')
            ->get();
        $dataSet = [];
        foreach ($products as $product) {
            $data = [
                $product->source->name, $product->category->name, $product->id, $product->name, $product->price, $product->vat_price
            ];
            array_push($dataSet, $data);
        }
        $headings = ['Store', 'Category', 'Product Id', 'Product Name', 'Netto', 'Brutto'];
        return Excel::download(new PriceUpdateTemplate($headings, $dataSet), 'PriceFeed-Vorlage_'
            . str_replace(' ', '_', t('Price_Update_Template')) . '_' . date('d.m.Y') . '.csv',
            \Maatwebsite\Excel\Excel::CSV);
    }

    public function updateProductPriceByFile(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:csv,txt'
        ], ['file.mimes' => 'File type must be: CSV', 'file.required' => 'You have not chose any file']);

        $shopType = 1;

        $f = fopen($request->file('file'), 'r');
        $firstLine = fgets($f); //get first line of csv file
        fclose($f); // close file
        if (in_array($shopType, [1, 2, 3, 6])) {
            $headings = str_getcsv(trim($firstLine), ',', '"'); //parse to array
            $header = implode(',', $headings);
        } else {
            $headings = str_getcsv(trim($firstLine), ';', '"'); //parse to array
            $header = implode(';', $headings);
        }

        $headingValidateError = Product::validateProductImportHeaderRow($headings, (int)$shopType, true);
        if ($headingValidateError) {
            $v = \Validator::make([], []);
            $v->errors()->add('file', trans('general.columns_validation_error'));
            return back()->withErrors($v->errors()->messages());
        }

        $path = request()->file('file')->getRealPath();
        $file = file($path);
        $data = array_slice($file, 1);
        $parts = array_chunk($data, 1000);
        $folderPath = public_path() . '/custom_storage/products/' . auth()->user()->user_id;
        File::makeDirectory($folderPath, 0777, true, true);
        $userName = auth()->user()->name;
        foreach ($parts as $i => $line) {
            array_unshift($line, $header . "\r\n");
            $filename = $folderPath . '/' . $userName . $i . '.csv';
            file_put_contents($filename, $line);
            $import = [
                'shop_type' => $shopType,
                'enable_price_override' => false,
                'user_id' => auth()->user()->user_id,
                'csv_path' => $filename,
                'is_update' => true,
            ];
            dispatch(new ProcessImportableFiles($import, $headings));
        }

        return back()->with('success', 'queued_import');

//        $request->validate([
//            'file' => 'required|mimes:csv,txt,xlsx'
//        ], ['file.mimes' => 'File type must be: CSV or EXCEL', 'file.required' => 'You have not chose any file']);
//
//        $headings = (new HeadingRowImport())->toArray($request->file('file'));
//        $headingValidate = Product::validatePriceUpdateHeaderRow($headings[0][0]);
//        if ($headingValidate['hasError']) {
//            $v = \Validator::make([], []);
//            $v->errors()->add('file', trans('general.columns_validation_error'));
//            return back()->withErrors($v->errors()->messages());
//        }
//
//        $solutionType = $headingValidate['solutionType'];
//        $extension = $request->file->getClientOriginalExtension();
//        if ($extension == 'xlsx') {
//            Excel::import(new ProductPriceUpdate($solutionType), $request->file('file'), null, \Maatwebsite\Excel\Excel::XLSX);
//        } else {
//            Excel::import(new ProductPriceUpdate($solutionType), $request->file('file'), null, \Maatwebsite\Excel\Excel::CSV);
//        }
//
//        $bulkPriceUpdate = [];
//        if (session()->exists('bulkPriceUpdate')) {
//            $bulkPriceUpdate = json_decode(session()->get('bulkPriceUpdate'));
//            session()->forget('bulkPriceUpdate');
//        }
//        $shops = auth()->user()->sources;
//        $categories = auth()->user()->categories;
//        return view('products.bulk-price-update', compact('solutionType', 'bulkPriceUpdate', 'shops', 'categories'));
    }

    public function updateProductPriceFromList(Request $request)
    {
        try {
            $rows = $request->input('data');
            $solutionType = $request->input('solution_type');
            foreach ($rows as $row) {
                if ($solutionType == 2) {
                    $categoryId = Category::where('name', $row['category'])->value('id');
                    if ($categoryId == null && $row['create_category_if_not_exist'] == true) {
                        $category = Category::create(['name' => $row['category'], 'user_id' => auth()->user()->user_id, 'slug' => slugify($row['category'])]);
                        $categoryId = $category->id;
                    }
                    $row['category_id'] = $categoryId;
                    if ($categoryId != null && $row['product_id'] == null && $row['create_product_if_not_exist'] == true && $row['source_id'] !== null) {
                        $row['origin'] = 'csv';
                        $row['user_id'] = auth()->user()->user_id;
                        $row['is_manual'] = 1;
                        $product = Product::addFromCsv($row);
                        $row['product_id'] = $product->id;
                    }
                }
                $validateResult = Product::validateUpdatePriceDataRequest($row);
                if ($validateResult) {
                    Product::updatePrice($row);
                }
            }
            $bulkPriceUpdate = [];
            if (session()->exists('bulkPriceUpdate')) {
                $bulkPriceUpdate = json_decode(session()->get('bulkPriceUpdate'));
                session()->forget('bulkPriceUpdate');
            }
            return response()->json($bulkPriceUpdate);
        } catch (\Throwable $throwable) {
            return response()->json(['message' => $throwable->getMessage()], 500);
        }
    }

    public function priceUpdate(Request $request, Product $product)
    {
        $request->validate([
            'price' => 'required'
        ]);
        $afterVat = auth()->user()->after_tax_price;
        $vatDivisor = $product->source->vat / 100 + 1;
        if ($afterVat) {
            $vatPrice = (float)$request->price;
            $price = round($vatPrice / $vatDivisor, 2);
        } else {
            $price = (float)$request->price;
            $vatPrice = round($price * $vatDivisor, 2);
        }
        $data['product_id'] = $product->id;
        $data['price'] = $price;
        $data['vat_price'] = $vatPrice;
        Product::updatePrice($data);
        return response()->json(true);
    }

    public function updateProductInfo(Request $request, Product $product)
    {
        $request->validate([
            'price' => 'required',
            'image' => 'nullable|image|max:2000'
        ]);
        $afterVat = auth()->user()->after_tax_price;
        $vatDivisor = $product->source->vat / 100 + 1;
        if ($afterVat) {
            $vatPrice = (float)$request->price;
            $price = round($vatPrice / $vatDivisor, 2);
        } else {
            $price = (float)$request->price;
            $vatPrice = round($price * $vatDivisor, 2);
        }
        if ($request->hasFile('image')) {
            $image = User::saveFile($request->file('image'), 'products/' . auth()->id(), $request->image);
            User::deleteFile($product->image);
            $product->image = $image;
        }
        $product->description = $request->description;
        $product->link = $request->link;
        $product->manual_override = $request->manual_override ? 1 : 0;
        $product->price = $price;
        $product->vat_price = $vatPrice;

        $product->save();

        $exists = ProductPriceEntry::where(['product_id' => $product->id])->whereDate('fetched_at', Carbon::now()->toDateString())->first();
        if (!$exists) {
            $new = new ProductPriceEntry();
            $new->product_id = $product->id;
            $new->price = $price;
            $new->vat_price = $vatPrice;
            $new->fetched_at = Carbon::now();
            $new->save();
        }
        return response()->json(true);
    }
}
