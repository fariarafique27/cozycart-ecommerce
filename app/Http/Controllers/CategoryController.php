<?php

namespace App\Http\Controllers;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;


class CategoryController extends Controller
{
    public function index(){ 
        $categories = Category::latest()->get();
        return view('admin.categories', compact('categories'));
    }


public function store(Request $request)
{
    // 1. Convert the input name to a slug and merge it into the request data
    $request->merge([
        'slug' => Str::slug($request->name),
    ]);

    // 2. Validate both fields
    $request->validate([
        'name' => 'required|string|max:255|unique:categories,name',
        'slug' => 'unique:categories,slug', // 👈 This catches "slug collisions" (like "Teddy Bear" vs "Teddy-Bear")
    ], [
        'name.unique' => 'This category name already exists! 🧸',
        'slug.unique' => 'A category with a matching web link already exists (e.g. spaces vs hyphens)! 🧸',
    ]);

    // 3. Create the category (since it passed validation!)
    Category::create([
        'name' => $request->name,
        'slug' => $request->slug, // Use the generated slug
    ]);

    return back()->with('success', 'New toy category added successfully! 🎉');
}

public function update(Request $request, Category $category)
{
    // Generate slug before validation check
    $request->merge([
        'slug' => Str::slug($request->name),
    ]);

    $request->validate([
        'name' => 'required|string|max:255',
        // Ignore the current category's ID so it doesn't collide with itself
        'slug' => [
            'required',
            Rule::unique('categories', 'slug')->ignore($category->id)
        ],
    ], [
        'slug.unique' => 'This category name or slug is already in use by another category! 🧸',
    ]);

    $category->update([
        'name' => $request->name,
        'slug' => $request->slug,
    ]);

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
