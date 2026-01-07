@extends('admin.layouts.app')

@section('title', 'Daftar Fasilitas')

@section('content')

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Daftar Fasilitas</title>
    {{-- Tailwind CSS --}}
    <script src="https://cdn.tailwindcss.com"></script>
    {{-- Font Awesome untuk ikon --}}
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet">
    {{-- Google Fonts: Poppins --}}
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">

    <style>
        /* Definisi Warna Kustom (Tower Theme) */
        .text-dark-tower { color: #2C3E50; }
        .bg-dark-tower { background-color: #2C3E50; }
        .text-accent-tower { color: #FF8C00; }
        .bg-accent-tower { background-color: #FF8C00; }
        .hover\:bg-accent-dark:hover { background-color: #E67E22; }
        .focus\:ring-accent-tower:focus { ring-color: #FF8C00; }
        .border-accent-tower { border-color: #FF8C00; }
        .shadow-soft { box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08); }

        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f0f2f5;
        }

        input[type='search']::-webkit-search-decoration,
        input[type='search']::-webkit-search-cancel-button,
        input[type='search']::-webkit-search-results-button,
        input[type='search']::-webkit-search-results-decoration {
            -webkit-appearance: none;
        }
    </style>
</head>

<body class="bg-gray-100">

    <div class="main-content flex-1 p-4 sm:p-6">
        <div class="bg-white rounded-xl shadow-soft p-4 sm:p-6">

            {{-- Header --}}
            <div class="flex flex-col sm:flex-row justify-between items-center mb-6 gap-4">
                <h1 class="text-2xl font-bold text-dark-tower flex items-center">
                    <i class="fas fa-tools text-accent-tower mr-2"></i> Daftar Fasilitas
                </h1>

                <div class="flex flex-col sm:flex-row items-center gap-3 w-full sm:w-auto">
                    <div class="relative w-full sm:w-64">
                        <span class="absolute inset-y-0 left-0 flex items-center pl-3">
                            <i class="fas fa-search text-gray-400"></i>
                        </span>
                        <input type="search" id="searchInput" placeholder="Cari berdasarkan nama..."
                            class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg text-sm text-gray-700 focus:outline-none focus:ring-2 focus:ring-accent-tower focus:border-accent-tower transition duration-200">
                    </div>

                    <a href="{{ route('admin.facilities.create') }}"
                        class="bg-accent-tower text-white px-4 py-2 rounded-lg font-semibold hover:bg-accent-dark transition-colors duration-200 flex items-center justify-center space-x-2 w-full sm:w-auto shadow-md">
                        <i class="fas fa-plus"></i>
                        <span>Tambah Fasilitas</span>
                    </a>
                </div>
            </div>

            @if(session('success'))
                <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6 rounded-lg shadow-sm" role="alert">
                    <p class="font-medium">{{ session('success') }}</p>
                </div>
            @endif

            {{-- LOGIKA STATISTIK (Disesuaikan dengan Nama di Seeder) --}}
            @php
                $totalFacilities = $facilities->count();
                // Nama type disamakan dengan Seeder: 'Peralatan Pabrikasi', 'Peralatan Maintenance', 'Kendaraan Operasional'
                $pabrikasiCount = $facilities->filter(fn($f) => trim($f->type) === 'Peralatan Pabrikasi')->count();
                $maintenanceCount = $facilities->filter(fn($f) => trim($f->type) === 'Peralatan Maintenance')->count();
                $kendaraanCount = $facilities->filter(fn($f) => trim($f->type) === 'Kendaraan Operasional')->count();
            @endphp

            <div class="mb-6 grid grid-cols-2 md:grid-cols-4 gap-4">
                {{-- Card Total --}}
                <div class="bg-gray-50 p-4 rounded-xl shadow-sm flex items-center space-x-4 border border-gray-200 transition duration-200 hover:shadow-md">
                    <div class="bg-dark-tower text-white rounded-full h-12 w-12 flex items-center justify-center flex-shrink-0">
                        <i class="fas fa-cubes fa-lg"></i>
                    </div>
                    <div>
                        <p class="text-xs sm:text-sm text-gray-500">Total Fasilitas</p>
                        <p class="text-xl sm:text-2xl font-bold text-dark-tower">{{ $totalFacilities }}</p>
                    </div>
                </div>

                {{-- Card Pabrikasi --}}
                <div class="bg-gray-50 p-4 rounded-xl shadow-sm flex items-center space-x-4 border border-accent-tower/50 transition duration-200 hover:shadow-md">
                    <div class="bg-accent-tower text-white rounded-full h-12 w-12 flex items-center justify-center flex-shrink-0">
                        <i class="fas fa-hammer fa-lg"></i>
                    </div>
                    <div>
                        <p class="text-xs sm:text-sm text-gray-500">Peralatan Pabrikasi</p>
                        <p class="text-xl sm:text-2xl font-bold text-dark-tower">{{ $pabrikasiCount }}</p>
                    </div>
                </div>

                {{-- Card Maintenance --}}
                <div class="bg-gray-50 p-4 rounded-xl shadow-sm flex items-center space-x-4 border border-blue-500/50 transition duration-200 hover:shadow-md">
                    <div class="bg-blue-500 text-white rounded-full h-12 w-12 flex items-center justify-center flex-shrink-0">
                        <i class="fas fa-wrench fa-lg"></i>
                    </div>
                    <div>
                        <p class="text-xs sm:text-sm text-gray-500">Peralatan Maintenance</p>
                        <p class="text-xl sm:text-2xl font-bold text-dark-tower">{{ $maintenanceCount }}</p>
                    </div>
                </div>

                {{-- Card Kendaraan --}}
                <div class="bg-gray-50 p-4 rounded-xl shadow-sm flex items-center space-x-4 border border-green-500/50 transition duration-200 hover:shadow-md">
                    <div class="bg-green-500 text-white rounded-full h-12 w-12 flex items-center justify-center flex-shrink-0">
                        <i class="fas fa-truck fa-lg"></i>
                    </div>
                    <div>
                        <p class="text-xs sm:text-sm text-gray-500">Kendaraan Operasional</p>
                        <p class="text-xl sm:text-2xl font-bold text-dark-tower">{{ $kendaraanCount }}</p>
                    </div>
                </div>
            </div>

            {{-- Tabel Data --}}
            <div class="overflow-x-auto rounded-xl border border-gray-200 shadow-soft">
                <table class="min-w-full table-auto border-collapse">
                    <thead>
                        <tr class="bg-dark-tower text-white uppercase text-xs leading-normal">
                            <th class="py-3 px-6 text-left w-16">No.</th>
                            <th class="py-3 px-6 text-left">Nama Fasilitas</th>
                            <th class="py-3 px-6 text-left">Foto</th>
                            <th class="py-3 px-6 text-left">Deskripsi</th>
                            <th class="py-3 px-6 text-left">Jenis</th>
                            <th class="py-3 px-6 text-left">Penerbit</th>
                            <th class="py-3 px-6 text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="text-gray-700 text-sm font-light" id="facilityTableBody">
                        @forelse($facilities as $facility)
                            <tr class="border-b border-gray-100 hover:bg-gray-50 transition-colors duration-200 facility-row">
                                <td class="py-4 px-6 text-left font-medium">{{ $loop->iteration }}</td>
                                <td class="py-4 px-6 text-left font-semibold break-words">{{ $facility->name }}</td>
                                <td class="py-4 px-6 text-left">
                                    {{-- Menggunakan asset() untuk menampilkan gambar dari seeder --}}
                                    <img src="{{ asset($facility->image) }}" alt="{{ $facility->name }}"
                                        class="w-16 h-16 object-cover rounded-md shadow-md bg-gray-50 border border-gray-200"
                                        onerror="this.src='https://via.placeholder.com/150?text=No+Image'">
                                </td>
                                <td class="py-4 px-6 text-left max-w-xs break-words">
                                    <p class="line-clamp-3 text-xs text-gray-600">{{ $facility->description }}</p>
                                </td>
                                <td class="py-4 px-6 text-left break-words">
                                    @php
                                        // Dicocokkan dengan value di FacilitySeeder
                                        $badgeClass = match(trim($facility->type)) {
                                            'Peralatan Pabrikasi' => 'bg-accent-tower/20 text-accent-tower',
                                            'Peralatan Maintenance' => 'bg-blue-100 text-blue-700',
                                            'Kendaraan Operasional' => 'bg-green-100 text-green-700',
                                            default => 'bg-gray-100 text-gray-500',
                                        };
                                    @endphp
                                    <span class="px-3 py-1 text-xs font-medium rounded-full {{ $badgeClass }}">
                                        {{ $facility->type }}
                                    </span>
                                </td>
                                <td class="py-4 px-6 text-left break-words text-xs text-gray-500">{{ $facility->publisher }}</td>
                                <td class="py-4 px-6 text-center">
                                    <div class="flex items-center justify-center space-x-2">
                                        <a href="{{ route('admin.facilities.show', $facility->id) }}"
                                            class="w-8 h-8 flex items-center justify-center text-gray-500 hover:text-blue-600 rounded-full hover:bg-blue-50 transition-all duration-200" title="Lihat">
                                            <i class="fas fa-eye text-sm"></i>
                                        </a>
                                        <a href="{{ route('admin.facilities.edit', $facility->id) }}"
                                            class="w-8 h-8 flex items-center justify-center text-gray-500 hover:text-accent-tower rounded-full hover:bg-accent-tower/10 transition-all duration-200" title="Edit">
                                            <i class="fas fa-edit text-sm"></i>
                                        </a>
                                        <form action="{{ route('admin.facilities.destroy', $facility->id) }}" method="POST"
                                            onsubmit="return confirm('Apakah Anda yakin ingin menghapus?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                class="w-8 h-8 flex items-center justify-center text-gray-500 hover:text-red-600 rounded-full hover:bg-red-50 transition-all duration-200" title="Hapus">
                                                <i class="fas fa-trash-alt text-sm"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr id="no-data">
                                <td colspan="7" class="py-8 text-center text-gray-500">
                                    <i class="fas fa-tools text-accent-tower text-3xl mb-3"></i>
                                    <p class="text-lg font-semibold text-dark-tower">Belum ada fasilitas yang ditambahkan.</p>
                                </td>
                            </tr>
                        @endforelse
                        <tr id="no-results" class="hidden">
                            <td colspan="7" class="py-8 text-center text-gray-500">
                                <i class="fas fa-exclamation-circle text-red-500 text-3xl mb-3"></i>
                                <p class="text-lg font-semibold text-dark-tower">Fasilitas tidak ditemukan.</p>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const searchInput = document.getElementById('searchInput');
            const tableBody = document.getElementById('facilityTableBody');
            const allRows = tableBody.querySelectorAll('tr.facility-row');
            const noResultsRow = document.getElementById('no-results');
            const noDataRow = document.getElementById('no-data');

            searchInput.addEventListener('keyup', function (e) {
                const searchTerm = e.target.value.toLowerCase().trim();
                let visibleRows = 0;

                allRows.forEach(row => {
                    const name = row.cells[1].textContent.toLowerCase();
                    if (name.includes(searchTerm)) {
                        row.style.display = '';
                        visibleRows++;
                    } else {
                        row.style.display = 'none';
                    }
                });

                if (searchTerm.length > 0 && visibleRows === 0) {
                    noResultsRow.classList.remove('hidden');
                } else {
                    noResultsRow.classList.add('hidden');
                }
            });
        });
    </script>
</body>
</html>

@endsection
