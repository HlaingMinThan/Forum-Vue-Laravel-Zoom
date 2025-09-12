<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Support\Str;

class CategoryController extends Controller
{
    public function index()
    {

        return inertia("Admin/Categories/Index", []);
    }

    public function create()
    {
        return inertia("Admin/Categories/CategoryForm", []);
    }
    public function store()
    {
        request()->validate([
            'name' => 'required',
            'description' => 'required',
        ]);

        $category = new Category();
        $category->name = request('name');
        $category->description = request('description');
        $category->slug = Str::of(request('name'))->slug('-');
        $category->save();
        return redirect()->route('categories.index');
    }

    public function update(Category $category)
    {
        request()->validate([
            'name' => 'required',
            'description' => 'required',
        ]);

        $category->name = request('name');
        $category->description = request('description');
        $category->slug = Str::of(request('name'))->slug('-');
        $category->save();
        return redirect()->route('categories.index');
    }

    public function edit(Category $category)
    {
        return inertia("Admin/Categories/CategoryForm", [
            'category' => $category
        ]);
    }

    public function destroy(Category $category)
    {
        $category->delete();
        return back();
    }
}
