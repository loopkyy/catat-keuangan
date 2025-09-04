<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::all();
        return view('categories.index', compact('categories'));
    }

    public function create()
    {
        return view('categories.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => [
                'required',
                'string',
                'max:255',
                'regex:/^[A-Za-z\s]+$/'
            ],
        ], [
            'name.regex' => 'Nama kategori hanya boleh huruf dan spasi.'
        ]);

        // Format huruf pertama kapital
        $name = ucfirst(strtolower($request->name));

        Category::create([
            'name' => $name,
        ]);

        return redirect()->route('categories.index')->with('success', 'Kategori berhasil ditambahkan.');
    }

    public function edit(Category $category)
    {
        return view('categories.edit', compact('category'));
    }

    public function update(Request $request, Category $category)
    {
        $request->validate([
            'name' => [
                'required',
                'string',
                'max:255',
                'regex:/^[A-Za-z\s]+$/'
            ],
        ], [
            'name.regex' => 'Nama kategori hanya boleh huruf dan spasi.'
        ]);

        // Format huruf pertama kapital
        $name = ucfirst(strtolower($request->name));

        $category->update([
            'name' => $name,
        ]);

        return redirect()->route('categories.index')->with('success', 'Kategori berhasil diperbarui.');
    }

    public function destroy(Category $category)
    {
        $category->delete();
        return redirect()->route('categories.index')->with('success', 'Kategori berhasil dihapus.');
    }
}
