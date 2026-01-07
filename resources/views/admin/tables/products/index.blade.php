@extends('admin.layouts.app')

@section('title', 'Daftar Produk')

@section('content')
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        .text-dark-tower { color: #2C3E50; }
        .bg-dark-tower { background-color: #2C3E50; }
        .text-accent-tower { color: #FF8C00; }
        .bg-accent-tower { background-color: #FF8C00; }
        .shadow-soft { box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08); }
        body { font-family: 'Poppins', sans-serif; background-color: #f0f2f5; }
        .action-icon { transition: all 0.2s ease; }
        .action-icon:hover { transform: scale(1.2); }
    </style>
</head>
<body class="bg-gray-100">
    <div class="main-content flex-1 p-4 sm:p-6">
        <div class="bg-white rounded-xl shadow-soft p-4 sm:p-6">
            {{-- Header --}}
            <div class="flex flex-col sm:flex-row justify-between items-center mb-6 gap-4 border-b pb-4 border-gray-100">
                <h1 class="text-3xl font-bold text-dark-tower">Daftar Produk</h1>
                <div class="flex flex-col sm:flex-row items-center gap-3 w-full sm:w-auto">
                    <div class="relative w-full sm:w-64">
                        <span class="absolute inset-y-0 left-0 flex items-center pl-3">
                            <i class="fas fa-search text-gray-400"></i>
                        </span>
                        <input type="search" id="productSearch" placeholder="Cari produk..."
                            class="w-full pl-10 pr-4 py-2 border rounded-lg text-sm text-gray-700 focus:outline-none focus:ring-2 focus:ring-accent-tower">
                    </div>
                    <a href="{{ route('admin.products.create') }}"
                        class="bg-accent-tower text-white px-4 py-2 rounded-lg font-semibold hover:bg-orange-600 transition-colors duration-200 flex items-center justify-center space-x-2 w-full sm:w-auto shadow-md">
                        <i class="fas fa-plus"></i>
                        <span>Tambah Produk</span>
                    </a>
                </div>
            </div>

            {{-- Notifikasi --}}
            @if(session('success'))
                <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6 rounded-lg shadow-sm" role="alert">
                    <p class="font-medium"><i class="fas fa-check-circle me-2"></i>{{ session('success') }}</p>
                </div>
            @endif

            {{-- Tabel --}}
            <div class="overflow-x-auto rounded-lg shadow-lg border border-gray-200">
                <table class="w-full table-auto border-collapse">
                    <thead>
                        <tr class="bg-dark-tower text-white uppercase text-[11px] tracking-wider leading-normal">
                            <th class="py-3 px-4 text-left w-10">No.</th>
                            <th class="py-3 px-4 text-left">Nama Produk</th>
                            <th class="py-3 px-4 text-left">Tipe</th>
                            <th class="py-3 px-4 text-left">Harga</th>
                            <th class="py-3 px-4 text-left">Gambar</th>
                            <th class="py-3 px-4 text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="text-gray-700 text-sm font-light" id="productTableBody">
                        @forelse($products as $product)
                            <tr class="border-b border-gray-200 hover:bg-gray-50 transition-colors duration-200 product-row">
                                <td class="py-4 px-4 text-left font-medium">
                                    {{ $loop->iteration + ($products->currentPage() - 1) * $products->perPage() }}
                                </td>
                                <td class="py-4 px-4 text-left font-semibold text-dark-tower">
                                    {{ $product->name }}
                                </td>
                                <td class="py-4 px-4 text-left">
                                    <span class="{{ $product->type == 'barang' ? 'bg-indigo-100 text-indigo-700' : 'bg-emerald-100 text-emerald-700' }} py-1 px-3 rounded-full text-[10px] font-bold uppercase">
                                        {{ $product->type }}
                                    </span>
                                </td>
                                <td class="py-4 px-4 text-left font-bold">
                                    Rp {{ number_format($product->price, 0, ',', '.') }}
                                </td>
                                <td class="py-4 px-4 text-left">
                                    @php
                                        // LOGIKA PERBAIKAN: Sesuaikan dengan folder di VS Code (image_06529b.png)
                                        if (str_contains($product->image, 'assets/')) {
                                            $path = asset($product->image);
                                        } elseif ($product->type == 'barang') {
                                            // Jika tipenya barang, cari di folder pabrikasi sesuai gambar VS Code kamu
                                            $path = asset('assets/img/pabrikasi/' . $product->image);
                                        } else {
                                            $path = asset('storage/' . $product->image);
                                        }
                                    @endphp
                                    <img src="{{ $path }}" class="w-12 h-12 object-cover rounded-lg border shadow-sm"
                                         onerror="this.onerror=null;this.src='https://via.placeholder.com/150?text=No+Image';">
                                </td>
                                <td class="py-4 px-4 text-center">
                                    <div class="flex items-center justify-center space-x-3">
                                        <a href="{{ route('admin.products.edit', $product->id) }}" class="action-icon text-amber-400"><i class="fas fa-edit"></i></a>
                                        <form action="{{ route('admin.products.destroy', $product->id) }}" method="POST" class="inline">
                                            @csrf @method('DELETE')
                                            <button type="submit" class="action-icon text-red-400" onclick="return confirm('Hapus?')"><i class="fas fa-trash"></i></button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="6" class="py-12 text-center text-gray-400">Data Kosong</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="mt-4">{{ $products->links() }}</div>
        </div>
    </div>
</body>
</html>
@endsection