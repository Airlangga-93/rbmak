<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $filterType = $request->input('type');
        $query = Product::latest();

        if ($filterType && in_array($filterType, ['barang', 'jasa'])) {
            $query->where('type', $filterType);
        }

        // Paginate dipercepat dengan simplePaginate jika data sangat banyak,
        // tapi tetap gunakan paginate(10) untuk tampilan standar.
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
            'image' => [$request->input('type') === 'barang' ? 'required' : 'nullable', 'image', 'max:2048'], // Max 2MB agar loading cepat
        ];

        $validated = $request->validate($rules);
        $validated['slug'] = $this->createUniqueSlug($validated['name']);

        if ($request->hasFile('image')) {
            // PERBAIKAN: Simpan path lengkap 'produk/namafile.jpg' ke database
            $path = $request->file('image')->store('produk', 'public');
            $validated['image'] = $path;
        }

        Product::create($validated);
        return redirect()->route('admin.products.index')->with('success', '✅ Produk berhasil ditambahkan!');
    }

    public function edit(Product $product)
    {
        return view('admin.tables.products.edit', compact('product'));
    }

    public function show(Product $product)
    {
        return view('admin.tables.products.show', compact('product'));
    }

    public function update(Request $request, Product $product)
    {
        $rules = [
            'type' => ['required', 'in:barang,jasa'],
            'name' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string'],
            'price' => ['required', 'numeric', 'min:0'],
            'image' => ['nullable', 'image', 'max:2048'],
        ];

        $validated = $request->validate($rules);

        if ($validated['name'] !== $product->name) {
            $validated['slug'] = $this->createUniqueSlug($validated['name'], $product->id);
        }

        if ($request->hasFile('image')) {
            // PERBAIKAN: Hapus gambar lama agar storage tidak penuh (bikin loading berat)
            if ($product->image && Storage::disk('public')->exists($product->image)) {
                Storage::disk('public')->delete($product->image);
            }

            // Simpan gambar baru dengan path lengkap
            $path = $request->file('image')->store('produk', 'public');
            $validated['image'] = $path;
        }

        $product->update($validated);
        return redirect()->route('admin.products.index')->with('success', ' Produk berhasil diperbarui!');
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
        // Hapus file fisik sebelum hapus record database
        if ($product->image && Storage::disk('public')->exists($product->image)) {
            Storage::disk('public')->delete($product->image);
        }

        $product->delete();
        return redirect()->route('admin.products.index')->with('success', ' Produk berhasil dihapus!');
    }
}
