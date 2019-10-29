<?php

namespace App\Http\Controllers;

use App\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Validation\Rule;

class CategoriesController extends Controller
{
    /**
     * Display a listing of the category.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categories = Category::where('user_id', auth()->user()->id)->withCount(['pages', 'products'])->get();
        return view('categories.index', compact('categories'));
    }

    /**
     * Show the form for creating a new category.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('categories.create');
    }

    /**
     * Store the category in the database.
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $userId = auth()->user()->user_id;
        $this->validate($request, [
            'name' => [
                Rule::unique('categories')->where(function ($query) use ($request, $userId) {
                    return $query->where('user_id', $userId);
                }),
                'required',
            ],
            'description' => 'max:1000',
        ]);

        $data = $request->input();
        $data['slug'] = slugify($data['name']);
        $data['user_id'] = $userId;

        auth()->user()->categories()->create($data);
        Cache::forget('categories');

        return redirect()->route('categories.index')->with('success', 'category.create.success');
    }

    /**
     * Display the specified category.
     *
     * @param  Category $category
     * @return \Illuminate\Http\Response
     */
    public function show(Category $category)
    {
        // @toDo should be a better way to do this
        if ($category->user_id !== auth()->id()) {
            abort(404);
        }
        return view('categories.show', compact('category'));
    }

    /**
     * Show the form for editing the specified category.
     *
     * @param  Category $category
     * @return \Illuminate\Http\Response
     */
    public function edit(Category $category)
    {
        if ($category->user_id !== auth()->id()) {
            abort(404);
        }
        return view('categories.edit', compact('category'));
    }

    /**
     * Update the specified category in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  Category $category
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Category $category)
    {
        $this->validate($request, [
            'name' => [
                Rule::unique('categories')->where(function ($query) use ($request) {
                    return $query->where('user_id', $request->user_id);
                })->ignore($category->id),
                'required',
            ],
            'description' => 'max:1000',
        ]);

        $data = $request->input();
        $data['slug'] = slugify($data['name']);

        $category->update($data);
        Cache::forget('categories');
        return redirect()->route('categories.edit', $category->id)->with('success', 'category.update.success');
    }

    /**
     * Remove the specified category from storage.
     *
     * @param Category $category
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function destroy(Category $category)
    {
        if ($category->user_id !== auth()->id()) {
            abort(404);
        }
        $category->delete();
        Cache::forget('categories');
        return back()->with('info', 'category.destroy.success');
    }
}
