@extends('admin.layouts.app')

@section('title', 'Detail Produk - ' . $product->name)

@section('content')

{{-- Perbaikan: Menghapus tag HTML/Body karena sudah ada di layout utama --}}
<style>
    :root {
        --dark-tower: #2C3E50;
        --accent-tower: #FF8C00;
    }
    .text-dark-tower { color: #2C3E50; }
    .bg-dark-tower { background-color: #2C3E50; }
    .text-accent-tower { color: #FF8C00; }
    .shadow-soft { box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08); }
</style>

<div class="main-content flex-1 p-4 sm:p-6">
    <div class="max-w-5xl mx-auto">

        {{-- Breadcrumb & Tombol Kembali --}}
        <div class="flex justify-between items-center mb-6">
            <nav class="text-sm font-medium text-gray-500">
                <a href="{{ route('admin.products.index') }}" class="hover:text-accent-tower transition-colors">Produk</a>
                <span class="mx-2">/</span>
                <span class="text-dark-tower">Detail Produk</span>
            </nav>
            <a href="{{ route('admin.products.index') }}" class="flex items-center text-sm font-semibold text-gray-600 hover:text-dark-tower transition-colors">
                <i class="fas fa-arrow-left mr-2"></i> Kembali
            </a>
        </div>

        <div class="bg-white rounded-xl shadow-soft overflow-hidden border border-gray-100">
            <div class="flex flex-col md:flex-row">

                {{-- Bagian Kiri: Gambar --}}
                <div class="w-full md:w-2/5 bg-gray-50 p-6 flex flex-col items-center justify-center border-r border-gray-100">
                    @if($product->image)
                        @php
                            /** * LOGIKA PATH GAMBAR (SINKRON DENGAN CONTROLLER BARU)
                             * Jika dari assets bawaan: asset('assets/...')
                             * Jika dari upload baru: asset('storage/produk/...')
                             */
                            if (str_contains($product->image, 'assets/')) {
                                $imageUrl = asset($product->image);
                            } else {
                                $imageUrl = asset('storage/' . $product->image);
                            }
                        @endphp
                        <div class="relative group w-full">
                            <img src="{{ $imageUrl }}"
                                 alt="{{ $product->name }}"
                                 class="w-full h-80 object-contain rounded-lg shadow-md bg-white p-2"
                                 onerror="this.onerror=null;this.src='https://via.placeholder.com/400?text=Image+Not+Found';">
                        </div>
                    @else
                        <div class="w-full h-80 bg-gray-200 rounded-lg flex flex-col items-center justify-center border-2 border-dashed border-gray-300 text-gray-400">
                            <i class="fas fa-image fa-4x mb-4"></i>
                            <p class="text-sm">Tidak ada gambar produk</p>
                        </div>
                    @endif
                </div>

                {{-- Bagian Kanan: Detail Informasi --}}
                <div class="w-full md:w-3/5 p-8 flex flex-col">
                    <div class="mb-4">
                        @if($product->type == 'barang')
                            <span class="bg-indigo-100 text-indigo-700 py-1 px-3 rounded-full text-[10px] font-bold uppercase tracking-wider">
                                <i class="fas fa-box mr-1"></i> Barang
                            </span>
                        @else
                            <span class="bg-emerald-100 text-emerald-700 py-1 px-3 rounded-full text-[10px] font-bold uppercase tracking-wider">
                                <i class="fas fa-concierge-bell mr-1"></i> Jasa
                            </span>
                        @endif
                    </div>

                    <h1 class="text-4xl font-bold text-dark-tower mb-2">{{ $product->name }}</h1>
                    <p class="text-3xl font-bold text-accent-tower mb-6">
                        Rp {{ number_format($product->price, 0, ',', '.') }}
                    </p>

                    <div class="space-y-6 flex-grow">
                        {{-- Info Ringkas --}}
                        <div class="grid grid-cols-2 gap-4">
                            <div class="bg-gray-50 p-3 rounded-lg border border-gray-100">
                                <p class="text-[10px] uppercase font-semibold text-gray-400">ID Produk</p>
                                <p class="text-sm font-medium text-gray-700">#PRD-{{ str_pad($product->id, 4, '0', STR_PAD_LEFT) }}</p>
                            </div>
                            <div class="bg-gray-50 p-3 rounded-lg border border-gray-100">
                                <p class="text-[10px] uppercase font-semibold text-gray-400">Slug</p>
                                <p class="text-sm font-medium text-gray-700 truncate" title="{{ $product->slug }}">{{ $product->slug ?: '-' }}</p>
                            </div>
                        </div>

                        {{-- Deskripsi --}}
                        <div>
                            <h3 class="text-sm font-bold text-dark-tower uppercase tracking-widest mb-2 border-b pb-1">Deskripsi</h3>
                            <div class="text-gray-600 leading-relaxed text-sm">
                                {!! nl2br(e($product->description)) ?: '<span class="italic text-gray-400">Belum ada deskripsi untuk produk ini.</span>' !!}
                            </div>
                        </div>
                    </div>

                    {{-- Metadata --}}
                    <div class="mt-8 pt-6 border-t border-gray-100 flex flex-col sm:flex-row gap-4 text-[11px] text-gray-400">
                        <span class="flex items-center"><i class="far fa-calendar-plus mr-2"></i> Dibuat: {{ $product->created_at->format('d M Y, H:i') }}</span>
                        <span class="flex items-center"><i class="far fa-edit mr-2"></i> Diupdate: {{ $product->updated_at->format('d M Y, H:i') }}</span>
                    </div>

                    {{-- Tombol Aksi --}}
                    <div class="mt-8 flex gap-3">
                        <a href="{{ route('admin.products.edit', $product->id) }}"
                           class="flex-1 bg-dark-tower text-white text-center py-3 rounded-lg font-semibold hover:bg-opacity-90 transition-all flex items-center justify-center shadow-md">
                            <i class="fas fa-edit mr-2"></i> Edit Produk
                        </a>
                        <form action="{{ route('admin.products.destroy', $product->id) }}" method="POST" onsubmit="return confirm('Hapus produk ini secara permanen?');" class="flex-1">
                            @csrf @method('DELETE')
                            <button type="submit" class="w-full bg-red-50 text-red-600 border border-red-100 py-3 rounded-lg font-semibold hover:bg-red-600 hover:text-white transition-all flex items-center justify-center">
                                <i class="fas fa-trash-alt mr-2"></i> Hapus
                            </button>
                        </form>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>

@endsection
