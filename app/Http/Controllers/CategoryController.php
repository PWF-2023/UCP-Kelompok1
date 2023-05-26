<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
//php artisan make:controller CategoryController
class CategoryController extends Controller
{
    public function index()
    {
        // Mengambil semua kategori yang dimiliki oleh pengguna yang terautentikasi, diurutkan berdasarkan tanggal dibuatnya kategori yang terbaru.
        $categories = Category::where('user_id', auth()->user()->id)
            ->orderBy('created_at', 'desc')
            ->get();
        
        // Mengembalikan tampilan 'category.index' dengan data kategori yang dikompak.
        return view('category.index', compact('categories'));
    }

    public function store(Request $request, Category $category)
    {
        // Memvalidasi permintaan (request) untuk memastikan bahwa bidang 'title' ada dan memiliki panjang maksimal 255 karakter.
        $request->validate([
            'title' => 'required|max:255',
        ]);
        
        // Membuat kategori baru dengan menggunakan data yang diterima dari permintaan (request) dan ID pengguna yang terautentikasi.
        $category = Category::create([
            'title' => ucfirst($request->title),
            'user_id' => auth()->user()->id,
        ]);
        
        // Mengalihkan pengguna ke rute 'category.index' dengan pesan sukses.
        return redirect()->route('category.index')->with('success', 'Category created successfully!');
    }

    public function create()
    {
        // Mengembalikan tampilan 'category.create' untuk membuat kategori baru.
        return view('category.create');
    }

    public function edit(Category $category)
    {
        // Memeriksa apakah pengguna yang terautentikasi memiliki izin untuk mengedit kategori yang diberikan.
        if (auth()->user()->id == $category->user_id) {
            // Mengembalikan tampilan 'category.edit' dengan data kategori yang dikompak.
            return view('category.edit', compact('categories'));
        } else {
            // Mengalihkan pengguna ke rute 'category.index' dengan pesan bahaya jika tidak memiliki izin untuk mengedit kategori.
            return redirect()->route('category.index')->with('danger', 'You are not authorized to edit this category!');
        }
    }

    public function update(Request $request, Category $category)
    {
        // Memvalidasi permintaan (request) untuk memastikan bahwa bidang 'title' ada dan memiliki panjang maksimal 255 karakter.
        $request->validate([
            'title' => 'required|max:255',
        ]);
        
        // Mengupdate data kategori yang diberikan dengan menggunakan data yang diterima dari permintaan (request).
        $category->update([
            'title' => ucfirst($request->title),
        ]);
        
        // Mengalihkan pengguna ke rute 'category.index' dengan pesan sukses.
        return redirect()->route('category.index')->with('success', 'Category updated successfully!');
    }

    public function destroy(Category $category)
    {
        // Memeriksa apakah pengguna yang terautentikasi memiliki izin untuk menghapus kategori yang diberikan.
        if (auth()->user()->id == $category->user_id) {
            // Menghapus kategori yang diberikan.
            $category->delete();
            
            // Mengalihkan pengguna ke rute 'category.index' dengan pesan sukses.
            return redirect()->route('category.index')->with('success', 'Category deleted successfully!');
        } else {
            // Mengalihkan pengguna ke rute 'category.index' dengan pesan bahaya jika tidak memiliki izin untuk menghapus kategori.
            return redirect()->route('category.index')->with('danger', 'You are not authorized to delete this category!');
        }
    }
}
