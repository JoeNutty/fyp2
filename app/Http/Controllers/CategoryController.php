<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;

class CategoryController extends Controller
{
    public function store(Request $request)
{
    $request->validate([
        'name' => 'required|unique:categories',
        'admin_only' => 'required|boolean', 
    ]);

    $name = $request->input('name');
    $admin_only = $request->input('admin_only'); 

    $category = new Category();
    $category->name = $name;
    $category->admin_only = $admin_only; 

    return $category->save();
}


public function index(Request $request)
{
    $userRole = $request->input('user_role', null);

    if ($userRole === 'user') {
        // Exclude admin-only categories for users with the "user" role
        return Category::where('admin_only', false)->latest()->get();
    } else {
        
        return Category::latest()->get();
    }
}


    public function show(Category $category)
    {
        return $category;
    }

    public function update(Request $request, Category $category)
{
    $request->validate([
        'name' => 'required|unique:categories',
        'admin_only' => 'required|boolean', 
    ]);

    $name = $request->input('name');
    $admin_only = $request->input('admin_only'); 

    $category->name = $name;
    $category->admin_only = $admin_only; 

    return $category->save();
}


    public function destroy(Category $category)
    {
        return $category->delete();
    }
}