<?php

Route::get('logout', 'Auth\LoginController@logout');
Route::get('/user/verify/{token}', 'Auth\RegisterController@verifyUser');
Route::post('/password-set', 'Auth\ResetPasswordController@setPassword')->name('password.set');

Route::group(['middleware' => 'auth'], function () {
    Route::get('/logout-and-verify/{token}', 'Users\UserController@logoutAndVerify')->name('logout.and.verify');
    Route::get(r('logs'), '\Rap2hpoutre\LaravelLogViewer\LogViewerController@index')->name('logs');
    Route::get('/update-user-locale', 'SettingsController@updateUserLocale')->name('update.locale');
    Route::get('/', 'IndexController@index')->name('home');

    Route::view('/impressum', 'impressum');
    Route::view('/datenschutz', 'datenschutz');

    Route::get('/pie-chart-export', 'IndexController@pieChartExportData')->name('pie.chart.export');
    Route::get('/pie-chart-export-in-pdf', 'IndexController@pieChartExportInPdf')->name('pie.chart.export.in.pdf');

    Route::get('/get-line-chart-data', 'IndexController@getLineChartData')->name('get.line.chart.data');
    Route::get('/line-chart-export', 'IndexController@lineChartExportData')->name('line.chart.export');
    Route::get('/line-chart-export-in-pdf', 'IndexController@lineChartExportInPdf')->name('line.chart.export.in.pdf');
    Route::get(r('comparison'), 'Products\ComparisonController@index')->name('products.comparison.index');
    Route::get(r('getProductPerDay'), 'Products\ComparisonController@getProductPerDay')->name('products.comparison.getProductPerDay');
    Route::get(r('productDataWeek'), 'Products\ComparisonController@getProductPerWeek')->name('products.comparison.getProductsForWeek');
    Route::get(r('getProductByMonth'), 'Products\ComparisonController@getProductByMonth')->name('products.comparison.getProductByMonth');
    Route::get(r('binding'), 'Products\BindingsController@edit')->name('products.bindings.edit');
//    Route::get('test', 'testController@test');
//    Route::get('getTest' . '/{category}/', 'testController@testCategory')->name("test.category");

    Route::prefix(r('products'))->as('products.')->group(function () {
        Route::get('/', 'CompetitorsProductsController@index')->name('index'); // @toDo change into competitors.products.index
        Route::get(r('create'), 'ProductsController@create')->name('create')->middleware('product.create');
        Route::get('bulk-upload', 'ProductsController@bulkUpload')->name('csv.index');
        Route::get('fix-bulk-upload', 'ProductsController@fixBulkUpload')->name('fix.csv.upload');
        Route::post('update-bulk-upload-data-by-filter', 'ProductsController@updateBulkUploadProductDataByFilter')->name('update.bulk.upload.data.by.filter');

        Route::post('remove-product-from-error-list', 'ProductsController@removeProductFromErrorList')->name('remove.from.cache');
        Route::post('save-product-from-csv-fix', 'ProductsController@saveProductFromCsvFix')->name('remove.from.cache');

        Route::get('bulk-price-update', 'ProductsController@bulkPriceUpdate')->name('price.update');
        Route::post('price-update-by-file', 'ProductsController@updateProductPriceByFile')->name('price.update.by.file');
        Route::post('update-products-price-from-list', 'ProductsController@updateProductPriceFromList')->name('price.update.from.list');

        Route::get('export-price-update-template', 'ProductsController@exportProductTemplate')->name('price.update.template');

        Route::prefix('{product}')->group(function () {
            Route::get(r('edit'), 'ProductsController@edit')->name('edit')->middleware('product.edit');
            Route::get('/', 'ProductsController@show')->name('show');
            Route::get('/csv-export', 'ProductsController@getCsv')->name('product.chart.export');
            Route::get('/pdf-export', 'ProductsController@getPdf')->name('product.chart.export.in.pdf');
            Route::get('history', 'Product\HistoryController@show')->name('history.show');
        });
    });

    Route::prefix(r('categories'))->as('categories.')->group(function () {
        Route::get('/', 'CategoriesController@index')->name('index');
        Route::get(r('create'), 'CategoriesController@create')->name('create');

        Route::prefix('{category}')->group(function () {
            Route::get(r('edit'), 'CategoriesController@edit')->name('edit');
            Route::get('/', 'CategoriesController@show')->name('show');
            Route::get('history', 'CategoriesController@history')->name('history');
        });
    });

    Route::get(r('my-shop'), 'ProductsController@index')->name('products.my'); // @toDo change into products.index

    Route::prefix(r('competitors'))->as('competitors.')->group(function () {
        Route::get('/', 'CompetitorsController@index')->name('index');
        Route::get(r('request'), 'CompetitorRequestsController@create')->name('requests.create')->middleware('competitor.create');
        Route::get(r('products') . '/' . r('create'), 'CompetitorsProductsController@create')->name('products.create')->middleware('product.create');
        Route::get(r('products') . '/{product}', 'CompetitorsProductsController@edit')->name('products.edit')->middleware('product.edit');
    });

//    Route::get(r('logs'), 'LogsController@index')->name('logs');
    Route::get(r('logs.history'), 'LogsController@history')->name('logs.history');

    Route::prefix(r('statistics'))->as('statistics.')->group(function () {
        Route::get('/', 'Statistics\CompetitorsController@index')->name('competitors.index');
        Route::get('{sourceId}/' . r('categories'), 'Statistics\CompetitorCategoriesController@index')->name('competitor.categories.index');
        Route::get(r('categories') . '/{category}/', 'Statistics\CategoryCompetitorsController@index')->name('category.competitors.index');

        Route::get(r('own-best-prices'), 'Statistics\PriceComparisonController@ownBestPrices')->name('own.best.prices');
        Route::get('/own-best-prices-data', 'Statistics\PriceComparisonController@ownBestPricesData')->name('own.best.prices.data');
        Route::get(r('competitors-best-prices'), 'Statistics\PriceComparisonController@compBestPrices')->name('competitors.best.prices');
        Route::get('/competitors-best-prices-data', 'Statistics\PriceComparisonController@compBestPricesData')->name('competitors.best.prices.data');
        Route::get(r('detailed-product-price'), 'Statistics\PriceComparisonController@detailedProductPrice')->name('detailed.product.price');
        Route::get('/detailed-product-price-report-data', 'Statistics\PriceComparisonController@detailedProductPriceReportData')->name('detailed.product.price.report.data');

        Route::get(r('category-percentage-difference'), 'Statistics\PriceComparisonController@categoryPercentageDifference')->name('category.percentage.difference');
        Route::get(r('category-percentage-difference-in-csv'), 'Statistics\PriceComparisonController@getCsv')->name('category.percentage.difference.in.csv');
        Route::get(r('category-percentage-difference-in-pdf'), 'Statistics\PriceComparisonController@getPdf')->name('category.percentage.difference.in.pdf');

        Route::get('{competitor}/' . r('categories') . '/{category}', 'Statistics\CategoryProductsController@index')->name('category.competitors.products.index');
        Route::get(r('top-daily-categories'), 'Statistics\TrendingCategoryProductController@get')->name('trending.data.getCategories');
        Route::get(r('price-changes'), 'Statistics\TrendingDataController@priceChange')->name('trending.data.priceChange');
        Route::get(r('getProductCategories') . '/{category}/', 'Statistics\TrendingCategoryProductController@getProducts')->name('trending.data.showProducts');
        Route::get('priceDifference', 'Statistics\PriceDifferenceController@index')->name('priceDifferenceByCategory.index');
        Route::get('priceDifference/sortByCategory/{category}', 'Statistics\PriceDifferenceController@getDataForCategory')->name('priceDifferenceByCategory.category');
        Route::get('priceDifference/sortByCompetitor', 'Statistics\PriceDifferenceController@getDataForCompetitor')->name('priceDifferenceByCategory.competitor');

        Route::get('priceDifference/get-csv', 'Statistics\PriceDifferenceController@getCsv')->name('priceDifferenceByCategory.csv.export');
        Route::get('priceDifference/get-pdf', 'Statistics\PriceDifferenceController@getPdf')->name('priceDifferenceByCategory.pdf.export');

    });

    Route::prefix(r('pages'))->as('pages.')->group(function () {
        Route::get('/', 'PagesController@index')->name('index');
        Route::get(r('create'), 'PagesController@create')->name('create');
        Route::get('{page}', 'PagesController@show')->name('show');
        Route::get('{page}/' . r('edit'), 'PagesController@edit')->name('edit');
    });

    Route::post('pages/create', 'PagesController@store')->name('pages.store');
    Route::patch('pages/{page}', 'PagesController@update')->name('pages.update');
    Route::delete('pages/{page}', 'PagesController@destroy')->name('pages.destroy');

    Route::get(r('options_comparison'), 'OptionsController@getComparison')->name('options-comparison');
    Route::get(r('options_binding'), 'OptionsController@getBinding')->name('options-binding');
    Route::get(r('options_overview'), 'OptionsController@index')->name('options-overview');
    Route::post('option-binding', 'OptionsController@postBinding');
    Route::post('options/{option}/loadBindings', 'OptionsController@loadBindings');
    Route::post('option-binding/{binding}/delete', 'OptionsController@deleteBinding');

    Route::post('binding', 'Products\BindingsController@update')->name('products.bindings.update');
    Route::delete('binding/{binding}/delete', 'Products\BindingsController@destroy');

    Route::post('products-csv-store', 'ProductsController@csvStore')->name('products.csv.store');
    Route::post('update-products-csv-store', 'ProductsController@updateCsvStore')->name('update.products.csv.store');

    Route::post('products', 'ProductsController@store')->name('products.store');
    Route::post('competitors/products', 'CompetitorsProductsController@store')->name('competitors.products.store');
    Route::patch('competitors/products/{product}', 'CompetitorsProductsController@update')->name('competitors.products.update');
    Route::post('competitors/request', 'CompetitorRequestsController@store')->name('competitors.requests.store');

    Route::prefix('products/{product}')->as('products.')->group(function () {
        Route::patch('/', 'ProductsController@update')->name('update');
        Route::post('loadBindings', 'Products\BindingsController@load');
        Route::post('watch', 'Product\WatchController@store')->name('watch.store');
        Route::delete('watch', 'Product\WatchController@destroy')->name('watch.destroy');
        Route::patch('upload-image', 'ProductsController@uploadImage')->name('upload-image');
        Route::patch('product-price-update', 'ProductsController@priceUpdate')->name('update-price');
        Route::post('update-product-info', 'ProductsController@updateProductInfo')->name('update-product-info');
    });

    Route::post('categories', 'CategoriesController@store')->name('categories.store');
    Route::patch('categories/{category}', 'CategoriesController@update')->name('categories.update');
    Route::delete('categories/{category}', 'CategoriesController@destroy')->name('categories.destroy');

    Route::get('patch-notes', function () {
        return view('patch-notes');
    });

    Route::get(r('profile'), 'ProfilesController@edit')->name('profiles.edit');
    Route::patch('profile', 'ProfilesController@update')->name('profiles.update');
    Route::get(r('settings'), 'SettingsController@edit')->name('settings.edit');
    Route::patch('settings', 'SettingsController@update')->name('settings.update');

    Route::get('settings-for-mobile', 'SettingsController@index')->name('settings.for.mobile');

    //users
    Route::prefix('users')->as('users.')->group(function () {
        Route::get('/', 'Users\UserController@index')->name('index');
        Route::get('create', 'Users\UserController@create')->name('create')->middleware('user.create');
        Route::post('create', 'Users\UserController@store')->name('store');
        Route::get('{user}', 'Users\UserController@show')->name('show');
        Route::get('{user}/edit', 'Users\UserController@edit')->name('edit');
        Route::get('{user}/view', 'Users\UserController@show')->name('view');
        Route::post('{user}/edit', 'Users\UserController@update')->name('edit');
        Route::delete('{user}/destroy', 'Users\UserController@destroy')->name('destroy');
    });

    // ajax
    Route::prefix('load')->as('ajax.')->group(function () {
        Route::get('products', 'Ajax\ProductsController@index')->name('products.index');
        Route::get('competitors/products', 'Ajax\CompetitorsProductsController@index')->name('competitors.products.index');
        Route::get('{competitor}/products', 'Ajax\SelectorProductsController@index')->name('selector.products.index');
    });

});

// Clear application cache:
Route::get('/clear-cache', function () {
    Artisan::call('cache:clear');
    return back()->with('success', 'Application cache cleared');
});

// Localization
Route::get('/js/lang.js', function () {
    $strings = Cache::remember('lang.js', 30, function () {
        $lang = config('app.locale');

        $files = glob(resource_path('lang/' . $lang . '/*.php'));
        $strings = [];

        foreach ($files as $file) {
            $name = basename($file, '.php');
            $strings[$name] = require $file;
        }

        return $strings;
    });
    header('Content-Type: text/javascript');
    echo('window.i18n = ' . json_encode($strings) . ';');
    exit();
})->name('assets.lang');

Auth::routes();