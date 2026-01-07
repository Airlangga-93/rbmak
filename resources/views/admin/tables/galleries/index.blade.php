@extends('admin.layouts.app')

@section('title', 'Galeri - Admin')

@section('content')

{{-- Inisialisasi Kustom Tailwind CSS --}}
<style>
    .text-dark-tower { color: #2C3E50; }
    .bg-dark-tower { background-color: #2C3E50; }
    .text-accent-tower { color: #FF8C00; }
    .bg-accent-tower { background-color: #FF8C00; }
    .hover\:bg-accent-dark:hover { background-color: #E67E22; }
    .shadow-soft { box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08); }

    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(-10px); }
        to { opacity: 1; transform: translateY(0); }
    }
    .animate-fade-in { animation: fadeIn 0.4s ease-out forwards; }
</style>

<div class="container mx-auto p-6">

    {{-- Header Halaman --}}
    <div class="flex flex-col md:flex-row md:items-center justify-between mb-8 gap-4">
        <div>
            <h1 class="text-3xl font-black text-dark-tower uppercase tracking-tighter">Galeri Proyek</h1>
            <p class="text-sm text-gray-500 mt-1">Daftar seluruh dokumentasi foto proyek PT. RBM</p>
        </div>

        <div class="flex items-center space-x-3">
            <a href="{{ route('admin.dashboard') }}"
               class="bg-gray-100 hover:bg-gray-200 text-gray-700 px-5 py-2.5 rounded-xl font-bold transition duration-200 flex items-center text-sm">
                <i class="bi bi-arrow-left mr-2"></i> Dashboard
            </a>

            <a href="{{ route('admin.galleries.create') }}"
               class="bg-accent-tower hover:bg-accent-dark text-white px-5 py-2.5 rounded-xl font-bold transition duration-200 shadow-lg shadow-orange-500/20 flex items-center space-x-2 text-sm">
                <i class="bi bi-plus-circle-fill mr-1"></i> <span>Tambah Gambar</span>
            </a>
        </div>
    </div>

    {{-- Alert sukses --}}
    @if(session('success'))
        <div class="bg-emerald-50 border border-emerald-200 text-emerald-700 px-6 py-4 rounded-2xl relative mb-6 shadow-sm flex items-center animate-fade-in" role="alert">
            <i class="bi bi-check-circle-fill text-xl mr-3"></i>
            <span class="block sm:inline font-bold uppercase text-xs tracking-wider">{{ session('success') }}</span>
        </div>
    @endif

    {{-- Tabel Galeri --}}
    <div class="bg-white rounded-3xl shadow-soft border border-gray-100 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-100">
                <thead class="bg-gray-50/50">
                    <tr class="text-gray-400 text-[10px] uppercase tracking-[0.2em] font-black">
                        <th class="px-6 py-5 text-center border-r border-gray-50" style="width: 80px;">No</th>
                        <th class="px-6 py-5 text-left border-r border-gray-50" style="width: 200px;">Pratinjau</th>
                        <th class="px-6 py-5 text-left border-r border-gray-50">Judul Dokumentasi</th>
                        <th class="px-6 py-5 text-center" style="width: 180px;">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50 bg-white">
                    @forelse($galleries as $gallery)
                        <tr class="hover:bg-slate-50/80 transition duration-150 group">
                            {{-- No. --}}
                            <td class="px-6 py-6 text-center text-sm font-bold text-gray-400">
                                {{ sprintf('%02d', $loop->iteration) }}
                            </td>

                            {{-- Gambar --}}
                            <td class="px-6 py-6 border-r border-gray-50">
                                @if($gallery->image)
                                    <a href="{{ route('admin.galleries.show', $gallery->id) }}" class="block relative w-40 h-24 overflow-hidden rounded-2xl border border-gray-100 shadow-sm bg-gray-50 group-hover:ring-2 group-hover:ring-accent-tower/30 transition-all">

                                        {{-- LOGIKA DETEKSI GAMBAR (ASSETS VS STORAGE) --}}
                                        @php
                                            if (str_starts_with($gallery->image, 'assets/')) {
                                                $finalPath = asset($gallery->image);
                                            } elseif (str_starts_with($gallery->image, 'gallery/')) {
                                                // Jika path di database "gallery/foto.jpg" tapi file fisik di "public/assets/img/gallery/"
                                                $finalPath = asset('assets/img/' . $gallery->image);
                                            } else {
                                                $finalPath = asset('storage/' . $gallery->image);
                                            }
                                        @endphp

                                        <img src="{{ $finalPath }}"
                                             class="w-full h-full object-cover group-hover:scale-110 transition duration-500"
                                             alt="{{ $gallery->title }}"
                                             onerror="this.src='https://placehold.co/600x400?text=Gambar+Tidak+Ditemukan'">

                                        <div class="absolute inset-0 bg-black/20 opacity-0 group-hover:opacity-100 flex items-center justify-center transition-opacity">
                                            <i class="bi bi-search text-white text-lg"></i>
                                        </div>
                                    </a>
                                @else
                                    <div class="w-40 h-24 bg-gray-50 rounded-2xl flex items-center justify-center border-2 border-dashed border-gray-100 italic text-[10px] text-gray-300">
                                        No Image
                                    </div>
                                @endif
                            </td>

                            {{-- Judul --}}
                            <td class="px-6 py-6 border-r border-gray-50">
                                <div class="text-base font-black text-dark-tower uppercase tracking-tight">
                                    {{ $gallery->title ?? 'TANPA JUDUL' }}
                                </div>
                                <div class="flex items-center mt-2 text-[10px] font-bold text-gray-400 uppercase tracking-widest">
                                    <i class="bi bi-calendar3 mr-2 text-accent-tower"></i>
                                    Terdaftar: {{ $gallery->created_at ? $gallery->created_at->format('d F Y') : '-' }}
                                </div>
                            </td>

                            {{-- Aksi --}}
                            <td class="px-6 py-6 text-center">
                                <div class="flex justify-center items-center space-x-2">
                                    <a href="{{ route('admin.galleries.show', $gallery->id) }}"
                                       class="w-9 h-9 flex items-center justify-center rounded-xl bg-blue-50 text-blue-500 hover:bg-blue-500 hover:text-white transition-all duration-300 shadow-sm"
                                       title="Lihat Detail">
                                        <i class="bi bi-eye-fill text-sm"></i>
                                    </a>

                                    <a href="{{ route('admin.galleries.edit', $gallery->id) }}"
                                       class="w-9 h-9 flex items-center justify-center rounded-xl bg-slate-100 text-slate-500 hover:bg-dark-tower hover:text-white transition-all duration-300 shadow-sm"
                                       title="Edit Data">
                                        <i class="bi bi-pencil-fill text-sm"></i>
                                    </a>

                                    <form action="{{ route('admin.galleries.destroy', $gallery->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Hapus gambar ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                                class="w-9 h-9 flex items-center justify-center rounded-xl bg-red-50 text-red-500 hover:bg-red-600 hover:text-white transition-all duration-300 shadow-sm"
                                                title="Hapus Gambar">
                                            <i class="bi bi-trash3-fill text-sm"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="text-center py-24 bg-gray-50/30">
                                <p class="text-gray-400 font-bold uppercase tracking-widest text-sm">Data galeri belum tersedia.</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

@endsection
