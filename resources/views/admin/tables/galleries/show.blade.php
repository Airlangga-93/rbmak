@extends('admin.layouts.app')

@section('title', 'Detail - Galeri')

@section('content')

{{-- Definisi Warna Kustom --}}
<style>
    .text-dark-tower { color: #2C3E50; } /* Biru Tua/Primary */
    .bg-dark-tower { background-color: #2C3E50; }
    .text-accent-tower { color: #FF8C00; } /* Oranye/Accent */
    .bg-accent-tower { background-color: #FF8C00; }
    .hover\:bg-accent-dark:hover { background-color: #E67E22; }
    .shadow-soft { box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08); }
</style>

<div class="container mx-auto p-6">

    {{-- Breadcrumb / Navigasi --}}
    <div class="mb-6 flex items-center justify-between max-w-4xl mx-auto">
        <div>
            <h4 class="text-2xl font-black text-dark-tower uppercase tracking-tighter">Detail Dokumentasi</h4>
            <p class="text-xs text-gray-400 font-bold uppercase tracking-widest mt-1">ID Proyek: #GLR-{{ sprintf('%03d', $gallery->id) }}</p>
        </div>
        <a href="{{ route('admin.galleries.index') }}" class="inline-flex items-center text-sm font-bold text-gray-400 hover:text-accent-tower transition-colors">
            <i class="bi bi-arrow-left mr-2"></i> KEMBALI
        </a>
    </div>

    {{-- Card Detail --}}
    <div class="bg-white rounded-3xl shadow-soft overflow-hidden max-w-4xl mx-auto border border-gray-100">
        <div class="flex flex-col">

            {{-- 1. Area Tampilan Gambar --}}
            <div class="w-full bg-gray-50 p-4 md:p-8 flex items-center justify-center border-b border-gray-100">
                @if($gallery->image)
                    {{-- Logika Deteksi Path Gambar --}}
                    @php
                        if (str_starts_with($gallery->image, 'assets/')) {
                            $imagePath = asset($gallery->image);
                        } elseif (str_starts_with($gallery->image, 'gallery/')) {
                            $imagePath = asset('assets/img/' . $gallery->image);
                        } else {
                            $imagePath = asset('storage/' . $gallery->image);
                        }
                    @endphp

                    <div class="relative group">
                        <img src="{{ $imagePath }}"
                             class="rounded-2xl shadow-2xl max-w-full h-auto border-4 border-white transition duration-500 group-hover:scale-[1.01]"
                             alt="{{ $gallery->title }}"
                             style="max-height: 550px; object-fit: contain;">

                        {{-- Overlay Badge --}}
                        <div class="absolute top-4 right-4 bg-dark-tower/80 backdrop-blur-md text-white px-4 py-2 rounded-xl text-[10px] font-black uppercase tracking-widest border border-white/20">
                            HQ Preview
                        </div>
                    </div>
                @else
                    <div class="py-20 text-center">
                        <i class="bi bi-image-alt text-gray-200 text-8xl"></i>
                        <p class="mt-4 text-gray-400 font-bold uppercase tracking-widest">Gambar tidak ditemukan</p>
                    </div>
                @endif
            </div>

            {{-- 2. Area Informasi --}}
            <div class="p-8 bg-white">
                <div class="flex flex-col md:flex-row md:items-center justify-between gap-6">
                    <div class="space-y-2">
                        <span class="bg-orange-100 text-accent-tower text-[10px] font-black px-3 py-1 rounded-full uppercase tracking-widest">Judul Proyek</span>
                        <h2 class="text-3xl font-black text-dark-tower uppercase tracking-tight leading-none">
                            {{ $gallery->title ?? 'TANPA JUDUL' }}
                        </h2>
                        <div class="flex items-center text-gray-400 text-xs font-bold uppercase tracking-widest pt-2">
                            <i class="bi bi-calendar-check mr-2 text-accent-tower"></i>
                            Diunggah pada: {{ $gallery->created_at->format('d F Y, H:i') }}
                        </div>
                    </div>

                    {{-- Tombol Aksi --}}
                    <div class="flex items-center gap-3">
                        <a href="{{ route('admin.galleries.edit', $gallery->id) }}"
                           class="bg-accent-tower text-white px-6 py-3 rounded-xl font-bold hover:bg-accent-dark transition duration-300 shadow-lg shadow-orange-500/20 flex items-center space-x-2 text-xs uppercase tracking-widest">
                            <i class="bi bi-pencil-square text-sm"></i> <span>Edit</span>
                        </a>

                        <form action="{{ route('admin.galleries.destroy', $gallery->id) }}" method="POST"
                              onsubmit="return confirm('Hapus gambar ini secara permanen?')"
                              class="inline-block">
                            @csrf
                            @method('DELETE')
                            <button type="submit"
                                    class="bg-red-50 text-red-600 px-6 py-3 rounded-xl font-bold hover:bg-red-600 hover:text-white transition duration-300 flex items-center space-x-2 text-xs uppercase tracking-widest">
                                <i class="bi bi-trash3-fill text-sm"></i> <span>Hapus</span>
                            </button>
                        </form>
                    </div>
                </div>
            </div>

        </div>
    </div>

    {{-- Footer Info --}}
    <div class="max-w-4xl mx-auto mt-6 text-center">
        <p class="text-gray-400 text-[10px] font-bold uppercase tracking-[0.3em]">PT. SAYAP SEMBILAN SATU - Panel Administrasi Galeri</p>
    </div>
</div>

@endsection
