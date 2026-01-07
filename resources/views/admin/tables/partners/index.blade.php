@extends('admin.layouts.app')

@section('title', 'Daftar Our Customer')

@section('content')

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Daftar Our Customer</title>
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
        .focus\:ring-accent-tower:focus { --tw-ring-color: #FF8C00; }
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
            <div class="flex flex-col sm:flex-row justify-between items-center mb-6 gap-4 border-b pb-4 border-gray-100">
                <h1 class="text-3xl font-bold text-dark-tower">Daftar Our Customer</h1>
                <div class="flex flex-col sm:flex-row items-center gap-3 w-full sm:w-auto">
                    <div class="relative w-full sm:w-64">
                        <span class="absolute inset-y-0 left-0 flex items-center pl-3">
                            <i class="fas fa-search text-gray-400"></i>
                        </span>
                        <input type="search" id="searchInput" placeholder="Cari berdasarkan nama..."
                            class="w-full pl-10 pr-4 py-2 border rounded-lg text-sm text-gray-700 focus:outline-none focus:ring-2 focus:ring-accent-tower">
                    </div>
                    <a href="{{ route('admin.partners.create') }}"
                        class="bg-accent-tower text-white px-4 py-2 rounded-lg font-semibold hover:bg-accent-dark transition-colors duration-200 flex items-center justify-center space-x-2 w-full sm:w-auto shadow-md">
                        <i class="fas fa-plus"></i>
                        <span>Tambah Customer</span>
                    </a>
                </div>
            </div>

            {{-- Notifikasi --}}
            @if(session('success'))
                <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6 rounded-lg shadow-sm" role="alert">
                    <p>{{ session('success') }}</p>
                </div>
            @endif

            {{-- Statistik --}}
            @php
                $totalPartners = $partners->count();
                $filledContacts = $partners->filter(fn($p) => !empty($p->company_contact))->count();
                $emptyContacts = $totalPartners - $filledContacts;
                $filledLogos = $partners->filter(fn($p) => !empty($p->logo))->count();
                $emptyLogos = $totalPartners - $filledLogos;
                $filledCities = $partners->filter(fn($p) => !empty($p->city))->count();
                $emptyCities = $totalPartners - $filledCities;

                $towerProviders = $partners->filter(fn($p) => strtoupper($p->sector ?? '') === 'TOWER PROVIDER')->count();
                $nonTowerProviders = $partners->filter(fn($p) => strtoupper($p->sector ?? '') === 'NON TOWER PROVIDER')->count();

                $otherSectors = $partners->filter(function($p) {
                    $sector = strtoupper($p->sector ?? '');
                    return !empty($sector) && $sector !== 'TOWER PROVIDER' && $sector !== 'NON TOWER PROVIDER';
                })->count();
            @endphp

            <div class="mb-6 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
                <div class="bg-dark-tower text-white p-4 rounded-lg shadow-md flex items-center space-x-4">
                    <div class="bg-accent-tower text-white rounded-full h-12 w-12 flex items-center justify-center flex-shrink-0">
                        <i class="fas fa-users fa-lg"></i>
                    </div>
                    <div>
                        <p class="text-sm opacity-75">Total Customer</p>
                        <p class="text-2xl font-bold">{{ $totalPartners }}</p>
                    </div>
                </div>

                <div class="bg-gray-50 p-4 rounded-lg shadow-sm flex items-center space-x-4 border border-gray-200">
                    <div class="bg-blue-100 text-blue-600 rounded-full h-12 w-12 flex items-center justify-center flex-shrink-0">
                        <i class="fas fa-broadcast-tower fa-lg"></i>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500">TOWER PROVIDER</p>
                        <p class="text-2xl font-bold text-gray-800">{{ $towerProviders }}</p>
                    </div>
                </div>

                <div class="bg-gray-50 p-4 rounded-lg shadow-sm flex items-center space-x-4 border border-gray-200">
                    <div class="bg-orange-100 text-orange-600 rounded-full h-12 w-12 flex items-center justify-center flex-shrink-0">
                        <i class="fas fa-lightbulb fa-lg"></i>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500">NON TOWER PROVIDER</p>
                        <p class="text-2xl font-bold text-gray-800">{{ $nonTowerProviders }}</p>
                    </div>
                </div>

                <div class="bg-gray-50 p-4 rounded-lg shadow-sm flex items-center space-x-4 border border-gray-200">
                    <div class="bg-gray-200 text-gray-700 rounded-full h-12 w-12 flex items-center justify-center flex-shrink-0">
                        <i class="fas fa-globe-americas fa-lg"></i>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500">Sektor Lainnya</p>
                        <p class="text-2xl font-bold text-gray-800">{{ $otherSectors }}</p>
                    </div>
                </div>
            </div>

            {{-- Grid Detail Statistik --}}
            <div class="mb-6 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
                <div class="bg-gray-50 p-4 rounded-lg shadow-sm flex items-center space-x-4 border border-gray-200">
                    <div class="bg-green-100 text-green-500 rounded-full h-12 w-12 flex items-center justify-center flex-shrink-0">
                        <i class="fas fa-check-circle fa-lg"></i>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500">Kontak Terisi</p>
                        <p class="text-2xl font-bold text-gray-800">{{ $filledContacts }}</p>
                    </div>
                </div>

                <div class="bg-gray-50 p-4 rounded-lg shadow-sm flex items-center space-x-4 border border-gray-200">
                    <div class="bg-purple-100 text-purple-500 rounded-full h-12 w-12 flex items-center justify-center flex-shrink-0">
                         <i class="fas fa-image fa-lg"></i>
                    </div>
                    <div>
                         <p class="text-sm text-gray-500">Logo Terpasang</p>
                         <p class="text-2xl font-bold text-gray-800">{{ $filledLogos }}</p>
                    </div>
                </div>

                <div class="bg-gray-50 p-4 rounded-lg shadow-sm flex items-center space-x-4 border border-gray-200">
                    <div class="bg-teal-100 text-teal-500 rounded-full h-12 w-12 flex items-center justify-center flex-shrink-0">
                    <i class="fas fa-map-marker-alt fa-lg"></i>
                </div>
                <div>
                    <p class="text-sm text-gray-500">Kota Terisi</p>
                    <p class="text-2xl font-bold text-gray-800">{{ $filledCities }}</p>
                </div>
                </div>
            </div>

            {{-- Tabel --}}
            <div class="overflow-x-auto rounded-lg shadow-lg border border-gray-200 mt-6">
                <table class="w-full table-auto border-collapse">
                    <thead>
                        <tr class="bg-dark-tower text-white uppercase text-sm leading-normal">
                            <th class="py-3 px-4 text-left w-10">No.</th>
                            <th class="py-3 px-4 text-left">Nama Customer</th>
                            <th class="py-3 px-4 text-left">Logo</th>
                            <th class="py-3 px-4 text-left">Deskripsi</th>
                            <th class="py-3 px-4 text-left">Sektor</th>
                            <th class="py-3 px-4 text-left">Kota</th>
                            <th class="py-3 px-4 text-left">Kontak</th>
                            <th class="py-3 px-4 text-left">Tgl Kerja Sama</th>
                            <th class="py-3 px-4 text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="text-gray-700 text-sm font-light" id="partnerTableBody">
                        @forelse($partners as $partner)
                            <tr class="border-b border-gray-200 hover:bg-gray-100 transition-colors duration-200 partner-row">
                                <td class="py-4 px-4 text-left font-medium">{{ $loop->iteration }}</td>
                                <td class="py-4 px-4 text-left font-semibold">{{ $partner->name }}</td>
                                <td class="py-4 px-4 text-left">
                                    @if($partner->logo)
                                        @php
                                            // LOGIKA LOGO: Jika path mengandung 'assets/img', gunakan asset().
                                            // Jika tidak (biasanya hasil upload admin), gunakan storage/
                                            $logoPath = str_contains($partner->logo, 'assets/img')
                                                        ? asset($partner->logo)
                                                        : asset('storage/' . $partner->logo);
                                        @endphp
                                        <img src="{{ $logoPath }}" alt="Logo" class="w-12 h-12 object-contain rounded-md shadow-sm bg-gray-50 border">
                                    @else
                                        <span class="text-xs text-red-500">No Logo</span>
                                    @endif
                                </td>
                                <td class="py-4 px-4 text-left max-w-xs">
                                    <p class="line-clamp-2 text-xs text-gray-500">{{ $partner->description ?? '-' }}</p>
                                </td>
                                <td class="py-4 px-4 text-left">
                                    @php
                                        $sector = strtoupper($partner->sector ?? '');
                                        $color = match($sector) {
                                            'TOWER PROVIDER' => 'bg-blue-100 text-blue-800',
                                            'NON TOWER PROVIDER' => 'bg-orange-100 text-orange-800',
                                            '' => 'bg-gray-300 text-gray-800',
                                            default => 'bg-green-100 text-green-800',
                                        };
                                    @endphp
                                    <span class="py-1 px-3 rounded-full text-[10px] font-bold {{ $color }}">
                                        {{ $sector ?: 'BELUM DIISI' }}
                                    </span>
                                </td>
                                <td class="py-4 px-4 text-left">{{ $partner->city ?? '-' }}</td>
                                <td class="py-4 px-4 text-left">{{ $partner->company_contact ?? '-' }}</td>
                                <td class="py-4 px-4 text-left text-xs">
                                    {{ $partner->partnership_date ? \Carbon\Carbon::parse($partner->partnership_date)->format('d M Y') : '-' }}
                                </td>
                                <td class="py-4 px-4 text-center">
                                    <div class="flex items-center justify-center space-x-2">
                                        <a href="{{ route('admin.partners.show', $partner->id) }}" class="text-gray-400 hover:text-blue-500"><i class="fas fa-eye"></i></a>
                                        <a href="{{ route('admin.partners.edit', $partner->id) }}" class="text-gray-400 hover:text-accent-tower"><i class="fas fa-edit"></i></a>
                                        <form action="{{ route('admin.partners.destroy', $partner->id) }}" method="POST" onsubmit="return confirm('Hapus mitra ini?');">
                                            @csrf @method('DELETE')
                                            <button type="submit" class="text-gray-400 hover:text-red-500"><i class="fas fa-trash-alt"></i></button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr id="no-data">
                                <td colspan="9" class="py-8 text-center text-gray-500">Belum ada customer.</td>
                            </tr>
                        @endforelse
                        <tr id="no-results" class="hidden">
                             <td colspan="9" class="py-8 text-center text-gray-500">Customer tidak ditemukan.</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const searchInput = document.getElementById('searchInput');
            const tableBody = document.getElementById('partnerTableBody');
            const allRows = tableBody.querySelectorAll('tr.partner-row');
            const noResultsRow = document.getElementById('no-results');

            searchInput.addEventListener('keyup', function (e) {
                const searchTerm = e.target.value.toLowerCase();
                let visibleRows = 0;

                allRows.forEach(row => {
                    const partnerName = row.cells[1].textContent.toLowerCase();
                    if (partnerName.includes(searchTerm)) {
                        row.style.display = '';
                        visibleRows++;
                    } else {
                        row.style.display = 'none';
                    }
                });

                noResultsRow.classList.toggle('hidden', visibleRows > 0 || searchTerm === "");
            });
        });
    </script>
</body>
</html>
@endsection
