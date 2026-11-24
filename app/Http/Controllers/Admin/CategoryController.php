<?php

namespace App\Http\Controllers\Admin;

use App\Models\Category;
use App\Models\CategoryPost;
use App\Utilities\Helper;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCategoryRequest;
use App\Http\Requests\UpdateCategoryRequest;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $itemsPerPage = auth()->user()->preferences->items_per_page;
        $categories = Category::paginate($itemsPerPage);
        return view('admin.categories.index')->withCategories($categories);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.categories.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreCategoryRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreCategoryRequest $request)
    {
        Category::create([
            'name' => $request->input('name'),
            'description' => $request->input('description'),
            'position' => $request->input('position') ?? 0,
            'parent' => $request->input('parent') ?? 0,
            'display_in_navbar' => $request->input('display_in_navbar'),
        ]);

        Helper::clearSiteCache();

        return redirect()->route('admin_categories.index')->with(['success-message' => "Category created successfully."]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function show(int $id)
    {
        $category = Category::findOrFail($id);
        return view('admin.categories.show')->withCategory($category);
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function edit(Category $category)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateCategoryRequest  $request
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateCategoryRequest $request, int $id)
    {
        $category = Category::findOrFail($id);

        $category->update([
            'name' => $request->input('name'),
            'description' => $request->input('description'),
            'position' => $request->input('position') ?? 0,
            'parent' => $request->input('parent') ?? 0,
            'display_in_navbar' => $request->input('display_in_navbar'),
        ]);

        Helper::clearSiteCache();

        return redirect()->route('admin_categories.index')->with(['success-message' => "Category updated successfully."]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function destroy(int $id)
    {
        $category = Category::findOrFail($id);
        CategoryPost::where('category_id', $category->id)->delete();
        Category::destroy($id);
        Helper::clearSiteCache();
        return redirect()->route('admin_categories.index')->with(['success-message' => "Category deleted successfully."]);
    }
}
