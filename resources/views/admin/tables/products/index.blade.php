@extends('admin.layouts.app')

@section('title', 'Daftar Produk')

@section('content')

{{-- Library pendukung --}}
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet">

<style>
    .text-dark-tower { color: #2C3E50; }
    .bg-dark-tower { background-color: #2C3E50; }
    .text-accent-tower { color: #FF8C00; }
    .bg-accent-tower { background-color: #FF8C00; }
    .hover\:bg-accent-dark:hover { background-color: #E67E22; }
    .shadow-soft { box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08); }

    /* Perbaikan Efek pada Ikon Aksi */
    .action-icon {
        transition: all 0.2s ease;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 32px;
        height: 32px;
        border-radius: 8px;
        background-color: #f8f9fa;
    }
    .action-icon:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 6px rgba(0,0,0,0.1);
    }

    .stat-card { transition: all 0.3s ease; }
    .stat-card:hover { transform: translateY(-3px); }
</style>

<div class="main-content flex-1 p-4 sm:p-6 bg-[#f0f2f5] min-h-screen">
    <div class="bg-white rounded-xl shadow-soft p-4 sm:p-6">

        {{-- Header --}}
        <div class="flex flex-col sm:flex-row justify-between items-center mb-6 gap-4 border-b pb-4 border-gray-100">
            <h1 class="text-2xl font-bold text-dark-tower flex items-center">
                <i class="fas fa-boxes text-accent-tower mr-3"></i> Daftar Produk
            </h1>

            <div class="flex flex-col sm:flex-row items-center gap-3 w-full sm:w-auto">
                <div class="relative w-full sm:w-64">
                    <span class="absolute inset-y-0 left-0 flex items-center pl-3">
                        <i class="fas fa-search text-gray-400"></i>
                    </span>
                    <input type="search" id="productSearch" placeholder="Cari produk..."
                        class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg text-sm text-gray-700 focus:outline-none focus:ring-2 focus:ring-accent-tower transition duration-200">
                </div>
                <a href="{{ route('admin.products.create') }}"
                    class="bg-accent-tower text-white px-6 py-2 rounded-lg font-bold hover:bg-accent-dark transition-all flex items-center justify-center space-x-2 w-full sm:w-auto shadow-md">
                    <i class="fas fa-plus"></i>
                    <span>Tambah Produk</span>
                </a>
            </div>
        </div>

        {{-- Notifikasi --}}
        @if(session('success'))
            <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6 rounded-lg shadow-sm" role="alert">
                <p class="font-bold"><i class="fas fa-check-circle mr-2"></i>{{ session('success') }}</p>
            </div>
        @endif

        {{-- Statistik Produk --}}
        @php
            $totalProducts = \App\Models\Product::count();
            $totalBarang = \App\Models\Product::where('type', 'barang')->count();
            $totalJasa = \App\Models\Product::where('type', 'jasa')->count();
        @endphp

        <div class="mb-8 grid grid-cols-1 sm:grid-cols-3 gap-4">
            <div class="bg-white p-4 rounded-xl shadow-sm flex items-center space-x-4 border border-gray-100 stat-card">
                <div class="bg-dark-tower text-white rounded-lg h-12 w-12 flex items-center justify-center flex-shrink-0 shadow-lg">
                    <i class="fas fa-cubes fa-lg"></i>
                </div>
                <div>
                    <p class="text-[10px] uppercase tracking-wider text-gray-400 font-bold">Total Produk</p>
                    <p class="text-2xl font-black text-dark-tower">{{ $totalProducts }}</p>
                </div>
            </div>

            <div class="bg-indigo-50 p-4 rounded-xl shadow-sm flex items-center space-x-4 border border-indigo-100 stat-card">
                <div class="bg-indigo-600 text-white rounded-lg h-12 w-12 flex items-center justify-center flex-shrink-0 shadow-lg">
                    <i class="fas fa-box fa-lg"></i>
                </div>
                <div>
                    <p class="text-[10px] uppercase tracking-wider text-indigo-400 font-bold">Produk Barang</p>
                    <p class="text-2xl font-black text-indigo-700">{{ $totalBarang }}</p>
                </div>
            </div>

            <div class="bg-emerald-50 p-4 rounded-xl shadow-sm flex items-center space-x-4 border border-emerald-100 stat-card">
                <div class="bg-emerald-600 text-white rounded-lg h-12 w-12 flex items-center justify-center flex-shrink-0 shadow-lg">
                    <i class="fas fa-concierge-bell fa-lg"></i>
                </div>
                <div>
                    <p class="text-[10px] uppercase tracking-wider text-emerald-400 font-bold">Layanan Jasa</p>
                    <p class="text-2xl font-black text-emerald-700">{{ $totalJasa }}</p>
                </div>
            </div>
        </div>

        {{-- Tab Filter --}}
        <div class="flex space-x-6 mb-6 border-b border-gray-100">
            <a href="{{ route('admin.products.index') }}"
               class="pb-3 px-1 text-xs font-bold uppercase tracking-widest {{ !request('type') ? 'border-b-2 border-accent-tower text-dark-tower' : 'text-gray-400 hover:text-gray-600' }}">
                Semua
            </a>
            <a href="{{ route('admin.products.index', ['type' => 'barang']) }}"
               class="pb-3 px-1 text-xs font-bold uppercase tracking-widest {{ request('type') == 'barang' ? 'border-b-2 border-accent-tower text-dark-tower' : 'text-gray-400 hover:text-gray-600' }}">
                Barang
            </a>
            <a href="{{ route('admin.products.index', ['type' => 'jasa']) }}"
               class="pb-3 px-1 text-xs font-bold uppercase tracking-widest {{ request('type') == 'jasa' ? 'border-b-2 border-accent-tower text-dark-tower' : 'text-gray-400 hover:text-gray-600' }}">
                Jasa
            </a>
        </div>

        {{-- Tabel --}}
        <div class="overflow-x-auto rounded-xl border border-gray-200">
            <table class="min-w-full table-auto border-collapse">
                <thead>
                    <tr class="bg-dark-tower text-white uppercase text-[11px] tracking-wider">
                        <th class="py-4 px-6 text-left w-16">No.</th>
                        <th class="py-4 px-6 text-left">Nama Produk</th>
                        <th class="py-4 px-6 text-left">Tipe</th>
                        <th class="py-4 px-6 text-left">Harga Estimasi</th>
                        <th class="py-4 px-6 text-left">Foto</th>
                        <th class="py-4 px-6 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="text-gray-700 text-sm" id="productTableBody">
                    @forelse($products as $product)
                        <tr class="border-b border-gray-50 hover:bg-gray-50 transition-all product-row">
                            <td class="py-4 px-6 text-left font-bold text-gray-300">
                                {{ $loop->iteration + ($products->currentPage() - 1) * $products->perPage() }}
                            </td>
                            <td class="py-4 px-6 text-left">
                                <span class="font-bold text-dark-tower block">{{ $product->name }}</span>
                                <span class="text-[10px] text-gray-400 uppercase tracking-tighter">{{ Str::limit($product->description, 40) }}</span>
                            </td>
                            <td class="py-4 px-6 text-left">
                                @if($product->type == 'barang')
                                    <span class="bg-indigo-100 text-indigo-700 py-1 px-3 rounded-full text-[10px] font-black uppercase border border-indigo-200">
                                        <i class="fas fa-box mr-1"></i> Barang
                                    </span>
                                @else
                                    <span class="bg-emerald-100 text-emerald-700 py-1 px-3 rounded-full text-[10px] font-black uppercase border border-emerald-200">
                                        <i class="fas fa-concierge-bell mr-1"></i> Jasa
                                    </span>
                                @endif
                            </td>
                            <td class="py-4 px-6 text-left font-bold text-gray-800">
                                Rp {{ number_format($product->price, 0, ',', '.') }}
                            </td>
                            <td class="py-4 px-6 text-left">
                                @if($product->image)
                                    @php
                                        // Perbaikan jalur gambar agar mendukung folder 'produk' di dalam storage
                                        if (str_contains($product->image, 'assets/')) {
                                            $pathFinal = asset($product->image);
                                        } elseif (str_contains($product->image, 'produk/')) {
                                            $pathFinal = asset('storage/' . $product->image);
                                        } else {
                                            $pathFinal = asset('storage/produk/' . $product->image);
                                        }
                                    @endphp
                                    <img src="{{ $pathFinal }}" alt="{{ $product->name }}"
                                         class="w-14 h-14 object-cover rounded-lg border border-gray-100 shadow-sm"
                                         onerror="this.src='https://via.placeholder.com/150?text=No+Image';">
                                @else
                                    <div class="w-14 h-14 bg-gray-100 rounded-lg flex items-center justify-center border border-dashed text-gray-300">
                                        <i class="fas fa-image"></i>
                                    </div>
                                @endif
                            </td>
                            <td class="py-4 px-6 text-center">
                                <div class="flex items-center justify-center space-x-3">
                                    <a href="{{ route('admin.products.show', $product->id) }}"
                                       class="action-icon text-gray-400 hover:text-blue-500 hover:bg-blue-50" title="Detail">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('admin.products.edit', $product->id) }}"
                                       class="action-icon text-gray-400 hover:text-orange-500 hover:bg-orange-50" title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('admin.products.destroy', $product->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus produk ini?');" class="inline">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="action-icon text-gray-400 hover:text-red-500 hover:bg-red-50" title="Hapus">
                                            <i class="fas fa-trash-alt"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="py-20 text-center text-gray-300 font-bold italic text-lg">
                                <i class="fas fa-box-open mb-4 block text-5xl opacity-20"></i>
                                Belum ada data produk tersedia.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Pagination --}}
        @if($products->hasPages())
            <div class="mt-8 py-4">
                {{ $products->links() }}
            </div>
        @endif
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const searchInput = document.getElementById('productSearch');
        const rows = document.querySelectorAll('.product-row');

        searchInput.addEventListener('input', function() {
            const term = this.value.toLowerCase();
            rows.forEach(row => {
                const name = row.cells[1].textContent.toLowerCase();
                row.style.display = name.includes(term) ? '' : 'none';
            });
        });
    });
</script>

@endsection
