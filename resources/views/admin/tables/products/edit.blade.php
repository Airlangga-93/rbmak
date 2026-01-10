@extends('admin.layouts.app')

@section('title', 'Edit Produk - ' . $product->name)

@section('content')

{{-- Tambahkan Style yang Diperlukan --}}
<style>
    :root {
        --dark-tower: #2C3E50;
        --accent-tower: #FF8C00;
    }

    .text-dark-tower { color: var(--dark-tower); }
    .bg-dark-tower { background-color: var(--dark-tower); }
    .text-accent-tower { color: var(--accent-tower); }
    .shadow-soft { box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08); }

    .form-input-focus:focus {
        border-color: var(--accent-tower);
        border-width: 2px;
        outline: none;
        box-shadow: 0 0 0 3px rgba(255, 140, 0, 0.2);
    }
</style>

<div class="container mx-auto p-4 sm:p-6">
    <div class="max-w-4xl mx-auto">

        {{-- Header --}}
        <div class="flex items-center justify-between mb-6">
            <div>
                <h1 class="text-3xl font-bold text-dark-tower">Edit Produk</h1>
                <p class="text-sm text-gray-500">Perbarui informasi produk <strong>{{ $product->name }}</strong>.</p>
            </div>
            <a href="{{ route('admin.products.index') }}" class="text-sm font-semibold text-gray-500 hover:text-dark-tower transition-colors">
                <i class="fas fa-times mr-1"></i> Batal
            </a>
        </div>

        {{-- Pesan Error Validasi --}}
        @if ($errors->any())
            <div class="bg-red-50 border-l-4 border-red-500 p-4 mb-6 rounded-r-lg shadow-sm">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <i class="fas fa-exclamation-circle text-red-500"></i>
                    </div>
                    <div class="ml-3">
                        <h3 class="text-sm font-bold text-red-800">Ada kesalahan input:</h3>
                        <ul class="mt-1 list-disc list-inside text-xs text-red-700">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        @endif

        <div class="bg-white rounded-xl shadow-soft overflow-hidden">
            <form action="{{ route('admin.products.update', $product->id) }}" method="POST" enctype="multipart/form-data" class="p-6 md:p-8">
                @csrf
                @method('PUT')

                <div class="space-y-6">

                    {{-- 🛑 Tipe Produk --}}
                    <div>
                        <label class="block text-sm font-bold text-dark-tower mb-3">Tipe Produk <span class="text-red-500">*</span></label>
                        <div class="flex gap-6">
                            <label class="inline-flex items-center cursor-pointer group">
                                <input type="radio" name="type" value="barang" class="w-4 h-4 text-accent-tower focus:ring-accent-tower border-gray-300"
                                    {{ old('type', $product->type) == 'barang' ? 'checked' : '' }} required>
                                <span class="ml-2 text-sm text-gray-700 group-hover:text-dark-tower transition-colors font-medium">Barang</span>
                            </label>
                            <label class="inline-flex items-center cursor-pointer group">
                                <input type="radio" name="type" value="jasa" class="w-4 h-4 text-accent-tower focus:ring-accent-tower border-gray-300"
                                    {{ old('type', $product->type) == 'jasa' ? 'checked' : '' }} required>
                                <span class="ml-2 text-sm text-gray-700 group-hover:text-dark-tower transition-colors font-medium">Jasa</span>
                            </label>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        {{-- Nama Produk --}}
                        <div class="col-span-1">
                            <label for="name" class="block text-sm font-bold text-dark-tower mb-1">Nama Produk <span class="text-red-500">*</span></label>
                            <input type="text" name="name" id="name" value="{{ old('name', $product->name) }}"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg text-sm form-input-focus" required>
                        </div>

                        {{-- Harga --}}
                        <div class="col-span-1">
                            <label for="price" class="block text-sm font-bold text-dark-tower mb-1">Harga (Rp) <span class="text-red-500">*</span></label>
                            <div class="relative">
                                <span class="absolute inset-y-0 left-0 pl-3 flex items-center text-gray-500 text-sm font-semibold">Rp</span>
                                <input type="number" name="price" id="price" value="{{ old('price', $product->price) }}"
                                    class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg text-sm form-input-focus font-bold text-gray-700" required>
                            </div>
                        </div>
                    </div>

                    {{-- Deskripsi --}}
                    <div>
                        <label for="description" class="block text-sm font-bold text-dark-tower mb-1">Deskripsi <span class="text-red-500">*</span></label>
                        <textarea name="description" id="description" rows="4"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg text-sm form-input-focus" required>{{ old('description', $product->description) }}</textarea>
                    </div>

                    {{-- Upload Gambar --}}
                    <div class="bg-gray-50 p-4 rounded-lg border border-gray-200">
                        <label class="block text-sm font-bold text-dark-tower mb-3">Gambar Produk</label>
                        <div class="flex flex-col md:flex-row gap-6 items-start">
                            {{-- Preview Lama --}}
                            <div class="text-center">
                                <p class="text-[10px] uppercase font-bold text-gray-400 mb-2">Gambar Saat Ini</p>
                                @if($product->image)
                                    @php
                                        // PERBAIKAN LOGIKA PATH:
                                        if (str_contains($product->image, 'assets/')) {
                                            $imageUrl = asset($product->image);
                                        } else {
                                            // Menyesuaikan folder 'produk' sesuai standar Controller baru
                                            $imageUrl = asset('storage/' . $product->image);
                                        }
                                    @endphp
                                    <img src="{{ $imageUrl }}"
                                         class="w-24 h-24 object-cover rounded-lg border shadow-sm bg-white p-1"
                                         onerror="this.src='https://via.placeholder.com/150?text=No+Image';">
                                @else
                                    <div class="w-24 h-24 bg-gray-200 rounded-lg flex items-center justify-center text-gray-400">
                                        <i class="fas fa-image"></i>
                                    </div>
                                @endif
                            </div>

                            {{-- Input File --}}
                            <div class="flex-1 w-full">
                                <p class="text-[10px] uppercase font-bold text-gray-400 mb-2">Ganti Gambar Baru</p>
                                <input type="file" name="image" id="image"
                                    class="block w-full text-xs text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-xs file:font-bold file:bg-dark-tower file:text-white hover:file:bg-gray-700 transition-all">
                                <p class="mt-2 text-[10px] text-gray-400 italic font-medium"><i class="fas fa-info-circle mr-1"></i> Kosongkan jika tidak ingin mengganti gambar. (Maks 2MB).</p>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Footer Form / Tombol Aksi --}}
                <div class="mt-10 pt-6 border-t border-gray-100 flex justify-between items-center">
                    <p class="text-[11px] text-gray-400 italic">* Kolom wajib diisi.</p>
                    <div class="flex gap-3">
                        <a href="{{ route('admin.products.index') }}"
                            class="px-6 py-2 border border-gray-300 rounded-lg text-sm font-semibold text-gray-600 hover:bg-gray-50 transition-all">
                            Batal
                        </a>
                        <button type="submit"
                            class="px-8 py-2 bg-accent-tower text-white rounded-lg text-sm font-bold hover:bg-opacity-90 transition-all shadow-md" style="background-color: #FF8C00;">
                            <i class="fas fa-save mr-2"></i> Simpan Perubahan
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection
