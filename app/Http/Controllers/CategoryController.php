<?php

namespace App\Http\Controllers;

use App\Category;
use App\Http\Requests\Category\CategoryRequest;
use Illuminate\Http\Request;

class CategoryController extends Controller
{

    public function index()
    {
        $categories = Category::all();
        return view('category.home', compact('categories'));
    }

    public function create()
    {
        return view('category.create');
    }

    public function store(CategoryRequest $request)
    {
        Category::create([
            'title' => $request['name'],
        ]);

        return redirect()->route('categories.index')->with('success', 'Категория успешно создана!');
    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        $category = Category::findOrFail($id);
        return view('category.edit', compact('category'));
    }

    public function update(CategoryRequest $request, Category $category)
    {
        $category->update([
            'title' => $request['name'],
        ]);

        return redirect()->route('categories.index')->with('success', 'Категория успешно изменена!');
    }

    public function destroy(Category $category)
    {
        $category->delete();

        return redirect()->route('categories.index');
    }
}
