<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $filterType = $request->input('type');
        $query = Product::latest();

        if ($filterType && in_array($filterType, ['barang', 'jasa'])) {
            $query->where('type', $filterType);
        }

        $products = $query->paginate(10);
        return view('admin.tables.products.index', compact('products', 'filterType'));
    }

    public function create()
    {
        return view('admin.tables.products.create');
    }

    public function store(Request $request)
    {
        $rules = [
            'type' => ['required', 'in:barang,jasa'],
            'name' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string'],
            'price' => ['required', 'numeric', 'min:0'],
            'image' => [$request->input('type') === 'barang' ? 'required' : 'nullable', 'image', 'max:4096'],
        ];

        $validated = $request->validate($rules);
        $validated['slug'] = $this->createUniqueSlug($validated['name']);

        if ($request->hasFile('image')) {
            // Path: storage/app/public/produk (lebih simple)
            $path = $request->file('image')->store('produk', 'public');
            $validated['image'] = basename($path); 
        }

        Product::create($validated);
        return redirect()->route('admin.products.index')->with('success', '✅ Produk berhasil ditambahkan!');
    }

    public function show(Product $product)
    {
        return view('admin.tables.products.show', compact('product'));
    }

    public function edit(Product $product)
    {
        return view('admin.tables.products.edit', compact('product'));
    }

    public function update(Request $request, Product $product)
    {
        $rules = [
            'type' => ['required', 'in:barang,jasa'],
            'name' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string'],
            'price' => ['required', 'numeric', 'min:0'],
            'image' => ['nullable', 'image', 'max:4096'],
        ];

        $validated = $request->validate($rules);

        if ($validated['name'] !== $product->name) {
            $validated['slug'] = $this->createUniqueSlug($validated['name'], $product->id);
        }

        if ($request->hasFile('image')) {
            // Hapus gambar lama jika ada di storage
            if ($product->image && Storage::disk('public')->exists('produk/' . $product->image)) {
                Storage::disk('public')->delete('produk/' . $product->image);
            }
            
            $path = $request->file('image')->store('produk', 'public');
            $validated['image'] = basename($path);
        }

        $product->update($validated);
        return redirect()->route('admin.products.index')->with('success', '✅ Produk berhasil diperbarui!');
    }

    private function createUniqueSlug($name, $id = null)
    {
        $slug = Str::slug($name);
        $query = Product::where('slug', $slug);
        if ($id) {
            $query->where('id', '!=', $id);
        }

        if ($query->exists()) {
            return $slug . '-' . time();
        }
        return $slug;
    }

    public function destroy(Product $product)
    {
        if ($product->image && Storage::disk('public')->exists('produk/' . $product->image)) {
            Storage::disk('public')->delete('produk/' . $product->image);
        }
        $product->delete();
        return redirect()->route('admin.products.index')->with('success', '🗑️ Produk berhasil dihapus!');
    }
}