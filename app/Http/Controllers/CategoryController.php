<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Repositories\CategoryRepository;

class CategoryController
{
    /**
     * @return \App\Support\View
     * @throws \App\Exceptions\ViewNotFoundException
     */
    public function index()
    {
        $categories = Category::select([]);

        return view('categories.index', ['categories' => $categories]);
    }

    /**
     * @return \App\Support\View
     * @throws \App\Exceptions\ViewNotFoundException
     */
    public function create()
    {
        auth()->user()->authorize('create', Category::class);

        return view('categories.create', ['category' => new Category()]);
    }

    /**
     * @return \App\Support\Redirect
     */
    public function store()
    {
        auth()->user()->authorize('create', Category::class);

        $title = request()->get('title');

        $repository = new CategoryRepository();

        $repository->store($title);

        return redirect()->back()->withMessage('New Category Added');
    }

    /**
     * @param Category $category
     *
     * @return \App\Support\View
     * @throws \App\Exceptions\ViewNotFoundException
     */
    public function edit(Category $category)
    {
        auth()->user()->authorize('edit', $category);

        return view('categories.edit', ['category' => $category]);
    }

    /**
     * @param Category $category
     *
     * @return \App\Support\Redirect
     */
    public function update(Category $category)
    {
        auth()->user()->authorize('edit', $category);

        $title = request()->get('title');

        $category->update(['title' => $title, 'slug' => str_slug($title)]);

        return redirect()->back()->withMessage('Update successful');
    }

    /**
     * @param Category $category
     *
     * @return \App\Support\Redirect
     */
    public function delete(Category $category)
    {
        auth()->user()->authorize('delete', $category);

        $category->delete();

        return redirect()->back();
    }
}
