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
            // Simpan ke storage/app/public/uploads/products
            $validated['image'] = $request->file('image')->store('uploads/products', 'public');
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
            // Hapus gambar lama HANYA jika gambar tersebut berada di folder storage (bukan assets/img)
            if ($product->image && !str_contains($product->image, 'assets/img')) {
                Storage::disk('public')->delete($product->image);
            }
            $validated['image'] = $request->file('image')->store('uploads/products', 'public');
        }

        $product->update($validated);
        return redirect()->route('admin.products.index')->with('success', '✅ Produk berhasil diperbarui!');
    }

    // Helper untuk membuat slug unik
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
        if ($product->image && !str_contains($product->image, 'assets/img')) {
            Storage::disk('public')->delete($product->image);
        }
        $product->delete();
        return redirect()->route('admin.products.index')->with('success', '🗑️ Produk berhasil dihapus!');
    }
}
