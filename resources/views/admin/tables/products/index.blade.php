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
        .hover\:bg-accent-dark:hover { background-color: #E67E22; }
        .shadow-soft { box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08); }
        body { font-family: 'Poppins', sans-serif; background-color: #f0f2f5; }
        .action-icon { transition: all 0.2s ease; }
        .action-icon:hover { transform: scale(1.2); }
        nav[role="navigation"] { display: flex; justify-content: space-between; align-items: center; width: 100%; }
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
                        class="bg-accent-tower text-white px-4 py-2 rounded-lg font-semibold hover:bg-accent-dark transition-colors duration-200 flex items-center justify-center space-x-2 w-full sm:w-auto shadow-md">
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

            {{-- Statistik Produk --}}
            @php
                $totalProducts = \App\Models\Product::count();
                $totalBarang = \App\Models\Product::where('type', 'barang')->count();
                $totalJasa = \App\Models\Product::where('type', 'jasa')->count();
            @endphp

            <div class="mb-6 grid grid-cols-1 sm:grid-cols-3 gap-4">
                <div class="bg-dark-tower text-white p-4 rounded-lg shadow-md flex items-center space-x-4">
                    <div class="bg-accent-tower text-white rounded-full h-12 w-12 flex items-center justify-center flex-shrink-0">
                        <i class="fas fa-boxes fa-lg"></i>
                    </div>
                    <div>
                        <p class="text-sm opacity-75">Total Produk</p>
                        <p class="text-2xl font-bold">{{ $totalProducts }}</p>
                    </div>
                </div>

                <div class="bg-gray-50 p-4 rounded-lg shadow-sm flex items-center space-x-4 border border-gray-200">
                    <div class="bg-indigo-100 text-indigo-600 rounded-full h-12 w-12 flex items-center justify-center flex-shrink-0">
                        <i class="fas fa-box fa-lg"></i>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500">Produk Barang</p>
                        <p class="text-2xl font-bold text-gray-800">{{ $totalBarang }}</p>
                    </div>
                </div>

                <div class="bg-gray-50 p-4 rounded-lg shadow-sm flex items-center space-x-4 border border-gray-200">
                    <div class="bg-emerald-100 text-emerald-600 rounded-full h-12 w-12 flex items-center justify-center flex-shrink-0">
                        <i class="fas fa-concierge-bell fa-lg"></i>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500">Layanan Jasa</p>
                        <p class="text-2xl font-bold text-gray-800">{{ $totalJasa }}</p>
                    </div>
                </div>
            </div>

            {{-- Tab Filter --}}
            <div class="flex space-x-4 mb-6 border-b">
                <a href="{{ route('admin.products.index') }}"
                   class="pb-2 px-1 text-sm font-semibold {{ !request('type') ? 'border-b-2 border-accent-tower text-dark-tower' : 'text-gray-400 hover:text-gray-600' }}">
                   Semua
                </a>
                <a href="{{ route('admin.products.index', ['type' => 'barang']) }}"
                   class="pb-2 px-1 text-sm font-semibold {{ request('type') == 'barang' ? 'border-b-2 border-accent-tower text-dark-tower' : 'text-gray-400 hover:text-gray-600' }}">
                   Barang
                </a>
                <a href="{{ route('admin.products.index', ['type' => 'jasa']) }}"
                   class="pb-2 px-1 text-sm font-semibold {{ request('type') == 'jasa' ? 'border-b-2 border-accent-tower text-dark-tower' : 'text-gray-400 hover:text-gray-600' }}">
                   Jasa
                </a>
            </div>

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
                                    <p class="text-[10px] text-gray-400 font-normal mt-1">{{ Str::limit($product->description, 40) }}</p>
                                </td>
                                <td class="py-4 px-4 text-left">
                                    @if($product->type == 'barang')
                                        <span class="bg-indigo-100 text-indigo-700 py-1 px-3 rounded-full text-[10px] font-bold uppercase">
                                            <i class="fas fa-box me-1"></i> Barang
                                        </span>
                                    @else
                                        <span class="bg-emerald-100 text-emerald-700 py-1 px-3 rounded-full text-[10px] font-bold uppercase">
                                            <i class="fas fa-concierge-bell me-1"></i> Jasa
                                        </span>
                                    @endif
                                </td>
                                <td class="py-4 px-4 text-left font-bold text-gray-800">
                                    Rp {{ number_format($product->price, 0, ',', '.') }}
                                </td>
                                <td class="py-4 px-4 text-left">
                                    @if($product->image)
                                        @php
                                            $namaFile = trim($product->image);
                                            $pathFinal = "";

                                            if (file_exists(public_path('assets/img/pabrikasi/' . $namaFile))) {
                                                $pathFinal = asset('assets/img/pabrikasi/' . $namaFile);
                                            } elseif (file_exists(public_path('assets/img/produk barang/' . $namaFile))) {
                                                $pathFinal = asset('assets/img/produk barang/' . $namaFile);
                                            } elseif (file_exists(public_path('assets/img/produk jasa/' . $namaFile))) {
                                                $pathFinal = asset('assets/img/produk jasa/' . $namaFile);
                                            } else {
                                                $pathFinal = asset('storage/' . $namaFile);
                                            }
                                        @endphp
                                        <img src="{{ $pathFinal }}" alt="{{ $product->name }}" 
                                             class="w-12 h-12 object-cover rounded-lg border shadow-sm bg-white"
                                             onerror="this.onerror=null;this.src='https://via.placeholder.com/150?text=No+Image';">
                                    @else
                                        <div class="w-12 h-12 bg-gray-100 rounded-lg flex items-center justify-center border border-dashed">
                                            <i class="fas fa-image text-gray-300"></i>
                                        </div>
                                    @endif
                                </td>
                                <td class="py-4 px-4 text-center">
                                    <div class="flex items-center justify-center space-x-3">
                                        <a href="{{ route('admin.products.show', $product->id) }}"
                                           class="action-icon text-blue-400 hover:text-blue-600" title="Detail">
                                            <i class="fas fa-eye fa-lg"></i>
                                        </a>
                                        <a href="{{ route('admin.products.edit', $product->id) }}"
                                           class="action-icon text-amber-400 hover:text-amber-600" title="Edit">
                                            <i class="fas fa-edit fa-lg"></i>
                                        </a>
                                        <form action="{{ route('admin.products.destroy', $product->id) }}" method="POST" onsubmit="return confirm('Hapus produk ini?');" class="inline">
                                            @csrf @method('DELETE')
                                            <button type="submit" class="action-icon text-red-400 hover:text-red-600" title="Hapus">
                                                <i class="fas fa-trash-alt fa-lg"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="py-12 text-center text-gray-400">
                                    <i class="fas fa-box-open text-4xl mb-3"></i>
                                    <p>Belum ada data produk tersedia.</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if($products->hasPages())
                <div class="mt-8 py-4 border-t border-gray-100">
                    {{ $products->links('pagination::tailwind') }}
                </div>
            @endif
        </div>
    </div>

    <script>
        document.getElementById('productSearch').addEventListener('keyup', function(e) {
            const term = e.target.value.toLowerCase();
            const rows = document.querySelectorAll('.product-row');
            rows.forEach(row => {
                const name = row.cells[1].textContent.toLowerCase();
                row.style.display = name.includes(term) ? '' : 'none';
            });
        });
    </script>
</body>
</html>
@endsection