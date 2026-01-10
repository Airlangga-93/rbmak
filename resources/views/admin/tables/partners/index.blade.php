@extends('admin.layouts.app')

@section('title', 'Daftar Our Customer')

@section('content')

{{-- Library pendukung untuk Ikon --}}
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">

<style>
    /* Definisi Warna Kustom (Tower Theme) */
    .text-dark-tower { color: #2C3E50; }
    .bg-dark-tower { background-color: #2C3E50; }
    .text-accent-tower { color: #FF8C00; }
    .bg-accent-tower { background-color: #FF8C00; }
    .hover\:bg-accent-dark:hover { background-color: #E67E22; }
    .focus\:ring-accent-tower:focus { --tw-ring-color: #FF8C00; }
    .shadow-soft { box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08); }

    .font-poppins {
        font-family: 'Poppins', sans-serif;
    }

    /* Styling tombol aksi agar lebih terlihat */
    .btn-action {
        width: 32px;
        height: 32px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        border-radius: 8px;
        transition: all 0.2s;
    }
</style>

<div class="main-content flex-1 p-4 sm:p-6 font-poppins bg-[#f8f9fa]">
    <div class="bg-white rounded-xl shadow-soft p-4 sm:p-6">
        {{-- Header --}}
        <div class="flex flex-col sm:flex-row justify-between items-center mb-6 gap-4 border-b pb-4 border-gray-100">
            <h1 class="text-3xl font-black text-dark-tower uppercase tracking-tighter">Daftar Customer</h1>
            <div class="flex flex-col sm:flex-row items-center gap-3 w-full sm:w-auto">
                <div class="relative w-full sm:w-64">
                    <span class="absolute inset-y-0 left-0 flex items-center pl-3">
                        <i class="fas fa-search text-gray-400"></i>
                    </span>
                    <input type="search" id="searchInput" placeholder="Cari berdasarkan nama..."
                        class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg text-sm text-gray-700 focus:outline-none focus:ring-2 focus:ring-accent-tower">
                </div>
                <a href="{{ route('admin.partners.create') }}"
                    class="bg-accent-tower text-white px-5 py-2 rounded-lg font-bold hover:bg-accent-dark transition-all duration-200 flex items-center justify-center space-x-2 w-full sm:w-auto shadow-md">
                    <i class="fas fa-plus"></i>
                    <span>Tambah Customer</span>
                </a>
            </div>
        </div>

        {{-- Notifikasi --}}
        @if(session('success'))
            <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6 rounded-lg shadow-sm flex items-center" role="alert">
                <i class="fas fa-check-circle mr-3"></i>
                <p class="font-bold">{{ session('success') }}</p>
            </div>
        @endif

        {{-- Statistik --}}
        <div class="mb-6 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
            <div class="bg-dark-tower text-white p-4 rounded-xl shadow-md flex items-center space-x-4">
                <div class="bg-accent-tower text-white rounded-lg h-12 w-12 flex items-center justify-center flex-shrink-0 shadow-inner">
                    <i class="fas fa-users fa-lg"></i>
                </div>
                <div>
                    <p class="text-xs uppercase font-bold opacity-75">Total Customer</p>
                    <p class="text-2xl font-black">{{ $partners->count() }}</p>
                </div>
            </div>

            <div class="bg-white p-4 rounded-xl shadow-sm flex items-center space-x-4 border border-gray-100">
                <div class="bg-blue-100 text-blue-600 rounded-lg h-12 w-12 flex items-center justify-center flex-shrink-0">
                    <i class="fas fa-broadcast-tower fa-lg"></i>
                </div>
                <div>
                    <p class="text-xs uppercase font-bold text-gray-400">Tower Provider</p>
                    <p class="text-2xl font-black text-gray-800">{{ $partners->filter(fn($p) => strtoupper($p->sector ?? '') === 'TOWER PROVIDER')->count() }}</p>
                </div>
            </div>

            <div class="bg-white p-4 rounded-xl shadow-sm flex items-center space-x-4 border border-gray-100">
                <div class="bg-orange-100 text-orange-600 rounded-lg h-12 w-12 flex items-center justify-center flex-shrink-0">
                    <i class="fas fa-lightbulb fa-lg"></i>
                </div>
                <div>
                    <p class="text-xs uppercase font-bold text-gray-400">Non Tower</p>
                    <p class="text-2xl font-black text-gray-800">{{ $partners->filter(fn($p) => strtoupper($p->sector ?? '') === 'NON TOWER PROVIDER')->count() }}</p>
                </div>
            </div>

            <div class="bg-white p-4 rounded-xl shadow-sm flex items-center space-x-4 border border-gray-100">
                <div class="bg-emerald-100 text-emerald-600 rounded-lg h-12 w-12 flex items-center justify-center flex-shrink-0">
                    <i class="fas fa-city fa-lg"></i>
                </div>
                <div>
                    <p class="text-xs uppercase font-bold text-gray-400">Total Kota</p>
                    <p class="text-2xl font-black text-gray-800">{{ $partners->whereNotNull('city')->unique('city')->count() }}</p>
                </div>
            </div>
        </div>

        {{-- Tabel --}}
        <div class="overflow-x-auto rounded-xl border border-gray-200 shadow-sm">
            <table class="w-full table-auto border-collapse">
                <thead>
                    <tr class="bg-dark-tower text-white uppercase text-[11px] tracking-widest font-black leading-normal">
                        <th class="py-4 px-4 text-left w-12">No.</th>
                        <th class="py-4 px-4 text-left">Customer</th>
                        <th class="py-4 px-4 text-left">Logo</th>
                        <th class="py-4 px-4 text-left">Sektor</th>
                        <th class="py-4 px-4 text-left">Kota</th>
                        <th class="py-4 px-4 text-left">Tgl Kerja Sama</th>
                        <th class="py-4 px-4 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="text-gray-700 text-sm" id="partnerTableBody">
                    @forelse($partners as $partner)
                        <tr class="border-b border-gray-100 hover:bg-slate-50 transition-all duration-200 partner-row">
                            <td class="py-4 px-4 text-left font-bold text-gray-300">{{ $loop->iteration }}</td>
                            <td class="py-4 px-4 text-left font-bold text-dark-tower uppercase tracking-tight">{{ $partner->name }}</td>
                            <td class="py-4 px-4 text-left">
                                @if($partner->logo)
                                    @php
                                        if (str_contains($partner->logo, 'assets/img')) {
                                            $finalLogoPath = asset($partner->logo);
                                        } else {
                                            $finalLogoPath = asset('storage/' . $partner->logo);
                                        }
                                    @endphp
                                    <img src="{{ $finalLogoPath }}" alt="Logo" class="w-12 h-12 object-contain rounded-lg border border-gray-200 bg-white p-1"
                                         onerror="this.src='https://via.placeholder.com/50?text=Error'">
                                @else
                                    <div class="w-12 h-12 flex items-center justify-center bg-gray-100 rounded-lg border border-dashed text-gray-300">
                                        <i class="fas fa-image"></i>
                                    </div>
                                @endif
                            </td>
                            <td class="py-4 px-4 text-left">
                                @php
                                    $sector = strtoupper($partner->sector ?? '');
                                    $badgeColor = match($sector) {
                                        'TOWER PROVIDER' => 'bg-blue-100 text-blue-700 border-blue-200',
                                        'NON TOWER PROVIDER' => 'bg-orange-100 text-orange-700 border-orange-200',
                                        default => 'bg-slate-100 text-slate-700 border-slate-200',
                                    };
                                @endphp
                                <span class="py-1 px-3 rounded-full text-[10px] font-black border {{ $badgeColor }}">
                                    {{ $sector ?: 'OTHERS' }}
                                </span>
                            </td>
                            <td class="py-4 px-4 text-left font-medium text-gray-500">{{ $partner->city ?? '-' }}</td>
                            <td class="py-4 px-4 text-left text-xs font-bold text-gray-400">
                                {{ $partner->partnership_date ? \Carbon\Carbon::parse($partner->partnership_date)->format('d M Y') : '-' }}
                            </td>
                            <td class="py-4 px-4 text-center">
                                <div class="flex items-center justify-center space-x-2">
                                    {{-- TOMBOL SHOW --}}
                                    <a href="{{ route('admin.partners.show', $partner->id) }}"
                                       class="btn-action bg-blue-50 text-blue-600 hover:bg-blue-600 hover:text-white"
                                       title="Lihat Detail">
                                        <i class="fas fa-eye text-xs"></i>
                                    </a>

                                    {{-- TOMBOL EDIT --}}
                                    <a href="{{ route('admin.partners.edit', $partner->id) }}"
                                       class="btn-action bg-orange-50 text-orange-600 hover:bg-orange-600 hover:text-white"
                                       title="Edit Data">
                                        <i class="fas fa-pencil-alt text-xs"></i>
                                    </a>

                                    {{-- TOMBOL DELETE --}}
                                    <form action="{{ route('admin.partners.destroy', $partner->id) }}" method="POST" onsubmit="return confirm('Hapus mitra ini secara permanen?');" class="inline">
                                        @csrf @method('DELETE')
                                        <button type="submit"
                                                class="btn-action bg-red-50 text-red-600 hover:bg-red-600 hover:text-white"
                                                title="Hapus Data">
                                            <i class="fas fa-trash-alt text-xs"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="py-20 text-center">
                                <i class="fas fa-folder-open text-gray-200 text-5xl mb-4"></i>
                                <p class="text-gray-400 font-bold italic">Belum ada data customer tersedia.</p>
                            </td>
                        </tr>
                    @endforelse
                    <tr id="no-results" class="hidden">
                         <td colspan="7" class="py-20 text-center text-gray-400 font-bold">Customer tidak ditemukan.</td>
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

        searchInput.addEventListener('input', function (e) {
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

            if (visibleRows === 0 && searchTerm !== "") {
                noResultsRow.classList.remove('hidden');
            } else {
                noResultsRow.classList.add('hidden');
            }
        });
    });
</script>

@endsection
