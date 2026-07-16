<?php

namespace App\Http\Controllers;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use App\Http\Requests\StoreCategoryRequest;
use App\Http\Requests\UpdateCategoryRequest;


class CategoryController extends Controller
{
    public function index(){ 
        $categories = Category::latest()->get();
        return view('admin.categories', compact('categories'));
    }


public function store(StoreCategoryRequest $request)
{
    Category::create($request->validated());

    return back()->with('success', 'New toy category added successfully! 🎉');
}

public function update(UpdateCategoryRequest $request, Category $category)
{
    $category->update($request->validated());

    return back()->with('success', 'Category updated successfully! 🎉');
}

public function destroy(Category $category)
{
    // 🔒 GUARD: Check if the category has any products
    // (Assuming your Category model has a 'products' relationship defined)
    if ($category->products()->exists()) {
        return back()->with('error', "Cannot delete '{$category->name}' because it still has products assigned to it! Please reassign or delete those products first. 🧸");
    }

    // If no products are attached, safe to delete!
    $category->delete();

    return back()->with('success', 'Category deleted successfully! 🗑️');
}
}
