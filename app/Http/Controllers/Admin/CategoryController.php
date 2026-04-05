<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index(Request $request)
    {
        $query = Category::withCount(['products', 'products as active_products_count' => fn($q) => $q->where('is_active', true)])->orderBy('name');

        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        $filter = $request->get('status', 'active');
        if ($filter === 'inactive') {
            $query->where('is_active', false);
        } elseif ($filter === 'all') {
            // no filter
        } else {
            $query->where('is_active', true);
        }

        $categories = $query->paginate(15)->withQueryString();

        $all = Category::withCount('products')->get();
        $stats = [
            'total'          => $all->count(),
            'with_products'  => $all->where('products_count', '>', 0)->where('is_active', true)->count(),
            'empty'          => $all->where('products_count', 0)->where('is_active', true)->count(),
            'total_products' => $all->where('is_active', true)->sum('products_count'),
        ];

        return view('categories.index', compact('categories', 'stats', 'filter'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:100|unique:categories,name',
        ]);

        Category::create(['name' => $request->name]);

        return redirect()->route('admin.categories')->with('success', 'Kategori berhasil ditambahkan.');
    }

    public function update(Request $request, Category $category)
    {
        $request->validate([
            'name' => 'required|string|max:100|unique:categories,name,' . $category->id,
        ]);

        $category->update(['name' => $request->name]);

        return redirect()->route('admin.categories')->with('success', 'Kategori berhasil diperbarui.');
    }

    public function destroy(Category $category)
    {
        $category->update(['is_active' => false]);

        return redirect()->route('admin.categories')->with('success', 'Kategori "' . $category->name . '" berhasil dinonaktifkan.');
    }

    public function toggleActive(Category $category)
    {
        $category->update(['is_active' => !$category->is_active]);

        $msg = $category->is_active ? 'diaktifkan' : 'dinonaktifkan';
        return redirect()->route('admin.categories')->with('success', 'Kategori "' . $category->name . '" berhasil ' . $msg . '.');
    }
}
