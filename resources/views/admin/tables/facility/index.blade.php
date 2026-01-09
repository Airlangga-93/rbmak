@extends('admin.layouts.app')

@section('title', 'Daftar Fasilitas')

@section('content')
{{-- Load Library pendukung agar desain tetap konsisten --}}
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet">
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">

<style>
    /* Desain Asli Anda */
    .text-dark-tower { color: #2C3E50; }
    .bg-dark-tower { background-color: #2C3E50; }
    .text-accent-tower { color: #FF8C00; }
    .bg-accent-tower { background-color: #FF8C00; }
    .hover\:bg-accent-dark:hover { background-color: #E67E22; }
    .shadow-soft { box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08); }

    .stat-card { transition: all 0.3s ease; border: 2px solid transparent; }
    .stat-card:hover { transform: translateY(-5px); }
</style>

<div class="main-content flex-1 p-4 sm:p-6 bg-[#f0f2f5] min-h-screen">
    <div class="bg-white rounded-xl shadow-soft p-4 sm:p-6">

        {{-- Header Section --}}
        <div class="flex flex-col sm:flex-row justify-between items-center mb-8 gap-4">
            <h1 class="text-2xl font-bold text-dark-tower flex items-center">
                <i class="fas fa-tools text-accent-tower mr-3"></i> Daftar Fasilitas
            </h1>

            <div class="flex flex-col sm:flex-row items-center gap-3 w-full sm:w-auto">
                <div class="relative w-full sm:w-64">
                    <span class="absolute inset-y-0 left-0 flex items-center pl-3">
                        <i class="fas fa-search text-gray-400"></i>
                    </span>
                    <input type="search" id="searchInput" placeholder="Cari fasilitas..."
                        class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg text-sm text-gray-700 focus:outline-none focus:ring-2 focus:ring-accent-tower transition duration-200">
                </div>

                <a href="{{ route('admin.facilities.create') }}"
                    class="bg-accent-tower text-white px-6 py-2 rounded-lg font-bold hover:bg-accent-dark transition-all flex items-center justify-center space-x-2 w-full sm:w-auto shadow-md">
                    <i class="fas fa-plus"></i>
                    <span>Tambah Fasilitas</span>
                </a>
            </div>
        </div>

        @if(session('success'))
            <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6 rounded-lg shadow-sm" role="alert">
                <p class="font-bold">{{ session('success') }}</p>
            </div>
        @endif

        {{-- PERBAIKAN LOGIKA TOTAL DATA --}}
        @php
            $totalFacilities = $facilities->count();
            
            // Filter menggunakan str_contains agar lebih fleksibel menangani 'Pabrikasi' atau 'Pabrikas'
            $pabrikasiCount = $facilities->filter(function($f) {
                $type = strtolower(trim($f->type));
                return str_contains($type, 'pabrikas');
            })->count();

            $maintenanceCount = $facilities->filter(function($f) {
                $type = strtolower(trim($f->type));
                return str_contains($type, 'maintenance');
            })->count();

            $kendaraanCount = $facilities->filter(function($f) {
                $type = strtolower(trim($f->type));
                return str_contains($type, 'kendaraan') || str_contains($type, 'operasional');
            })->count();
        @endphp

        {{-- Statistik Cards --}}
        <div class="mb-8 grid grid-cols-2 md:grid-cols-4 gap-4">
            <div class="bg-white p-4 rounded-xl shadow-sm flex items-center space-x-4 border-gray-100 stat-card">
                <div class="bg-dark-tower text-white rounded-lg h-12 w-12 flex items-center justify-center flex-shrink-0 shadow-lg">
                    <i class="fas fa-layer-group fa-lg"></i>
                </div>
                <div>
                    <p class="text-[10px] uppercase tracking-wider text-gray-400 font-bold">Total Data</p>
                    <p class="text-2xl font-black text-dark-tower">{{ $totalFacilities }}</p>
                </div>
            </div>

            <div class="bg-orange-50 p-4 rounded-xl shadow-sm flex items-center space-x-4 border-orange-100 stat-card">
                <div class="bg-orange-500 text-white rounded-lg h-12 w-12 flex items-center justify-center flex-shrink-0 shadow-lg">
                    <i class="fas fa-industry fa-lg"></i>
                </div>
                <div>
                    <p class="text-[10px] uppercase tracking-wider text-orange-400 font-bold">Pabrikasi</p>
                    <p class="text-2xl font-black text-orange-600">{{ $pabrikasiCount }}</p>
                </div>
            </div>

            <div class="bg-blue-50 p-4 rounded-xl shadow-sm flex items-center space-x-4 border-blue-100 stat-card">
                <div class="bg-blue-500 text-white rounded-lg h-12 w-12 flex items-center justify-center flex-shrink-0 shadow-lg">
                    <i class="fas fa-wrench fa-lg"></i>
                </div>
                <div>
                    <p class="text-[10px] uppercase tracking-wider text-blue-400 font-bold">Maintenance</p>
                    <p class="text-2xl font-black text-blue-600">{{ $maintenanceCount }}</p>
                </div>
            </div>

            <div class="bg-green-50 p-4 rounded-xl shadow-sm flex items-center space-x-4 border-green-100 stat-card">
                <div class="bg-green-500 text-white rounded-lg h-12 w-12 flex items-center justify-center flex-shrink-0 shadow-lg">
                    <i class="fas fa-truck fa-lg"></i>
                </div>
                <div>
                    <p class="text-[10px] uppercase tracking-wider text-green-400 font-bold">Kendaraan</p>
                    <p class="text-2xl font-black text-green-600">{{ $kendaraanCount }}</p>
                </div>
            </div>
        </div>

        {{-- Tabel Section --}}
        <div class="overflow-x-auto rounded-xl border border-gray-200">
            <table class="min-w-full table-auto">
                <thead class="bg-dark-tower text-white text-[11px] uppercase tracking-wider">
                    <tr>
                        <th class="py-4 px-6 text-left w-16">No.</th>
                        <th class="py-4 px-6 text-left">Nama Fasilitas</th>
                        <th class="py-4 px-6 text-left">Foto</th>
                        <th class="py-4 px-6 text-left">Deskripsi</th>
                        <th class="py-4 px-6 text-left">Jenis</th>
                        <th class="py-4 px-6 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="text-gray-700 text-sm" id="facilityTableBody">
                    @forelse($facilities as $facility)
                        <tr class="border-b border-gray-100 hover:bg-gray-50 transition-all facility-row">
                            <td class="py-4 px-6 text-left font-bold text-gray-300">{{ $loop->iteration }}</td>
                            <td class="py-4 px-6 text-left font-bold text-dark-tower">{{ $facility->name }}</td>
                            <td class="py-4 px-6 text-left">
                                @php
                                    $imagePath = $facility->image;
                                    $finalUrl = str_starts_with($imagePath, 'assets/') ? asset($imagePath) : asset('storage/' . $imagePath);
                                @endphp
                                <img src="{{ $finalUrl }}" 
                                     class="w-14 h-14 object-cover rounded-lg shadow-sm border border-gray-100"
                                     onerror="this.src='https://via.placeholder.com/150?text=No+Image'">
                            </td>
                            <td class="py-4 px-6 text-left max-w-xs">
                                <p class="text-xs text-gray-500 line-clamp-2 leading-relaxed">{{ $facility->description }}</p>
                            </td>
                            <td class="py-4 px-6 text-left">
                                @php
                                    $typeLower = strtolower(trim($facility->type));
                                    $badgeStyle = 'bg-gray-100 text-gray-600';
                                    
                                    if(str_contains($typeLower, 'pabrikas')) $badgeStyle = 'bg-orange-100 text-orange-600 border-orange-200';
                                    elseif(str_contains($typeLower, 'maintenance')) $badgeStyle = 'bg-blue-100 text-blue-600 border-blue-200';
                                    elseif(str_contains($typeLower, 'kendaraan') || str_contains($typeLower, 'operasional')) $badgeStyle = 'bg-green-100 text-green-600 border-green-200';
                                @endphp
                                <span class="px-3 py-1 text-[10px] font-black uppercase rounded-full border {{ $badgeStyle }}">
                                    {{ $facility->type }}
                                </span>
                            </td>
                            <td class="py-4 px-6 text-center">
                                <div class="flex items-center justify-center space-x-3">
                                    <a href="{{ route('admin.facilities.show', $facility->id) }}" class="text-gray-400 hover:text-blue-500 transition-all" title="Lihat">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('admin.facilities.edit', $facility->id) }}" class="text-gray-400 hover:text-orange-500 transition-all" title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('admin.facilities.destroy', $facility->id) }}" method="POST" onsubmit="return confirm('Hapus data ini?');" class="inline">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="text-gray-400 hover:text-red-500 transition-all" title="Hapus">
                                            <i class="fas fa-trash-alt"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="py-20 text-center text-gray-300 font-bold italic text-lg">
                                <i class="fas fa-folder-open mb-4 block text-5xl"></i>
                                Belum ada data fasilitas.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const searchInput = document.getElementById('searchInput');
        const rows = document.querySelectorAll('.facility-row');

        searchInput.addEventListener('input', function () {
            const q = this.value.toLowerCase();
            rows.forEach(row => {
                const name = row.cells[1].textContent.toLowerCase();
                row.style.display = name.includes(q) ? '' : 'none';
            });
        });
    });
</script>
@endsection