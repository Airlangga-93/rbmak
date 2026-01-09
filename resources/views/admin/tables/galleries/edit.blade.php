@extends('admin.layouts.app')

@section('title', 'Edit Galeri')

@section('content')

{{-- Definisi Warna Kustom --}}
<style>
    .text-dark-tower { color: #2C3E50; } /* Biru Tua/Primary */
    .bg-dark-tower { background-color: #2C3E50; }
    .text-accent-tower { color: #FF8C00; } /* Oranye/Accent */
    .bg-accent-tower { background-color: #FF8C00; }
    .hover\:bg-accent-dark:hover { background-color: #E67E22; }
    .shadow-soft { box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08); }

    /* Gaya khusus untuk input file */
    input[type="file"]::file-selector-button {
        background-color: #F1F5F9;
        color: #475569;
        border: 1px solid #E2E8F0;
        padding: 0.5rem 1rem;
        margin-right: 1rem;
        border-radius: 0.5rem;
        cursor: pointer;
        font-weight: 600;
        transition: all 0.2s;
    }

    input[type="file"]::file-selector-button:hover {
        background-color: #E2E8F0;
        color: #1E293B;
    }
</style>

<div class="container mx-auto p-6">

    {{-- Header Halaman --}}
    <div class="mb-6 flex items-center justify-between max-w-2xl mx-auto">
        <h4 class="text-2xl font-black text-dark-tower uppercase tracking-tighter">Edit Dokumentasi</h4>
        <a href="{{ route('admin.galleries.index') }}" class="inline-flex items-center text-sm font-bold text-gray-400 hover:text-accent-tower transition-colors">
            <i class="bi bi-arrow-left mr-2"></i> KEMBALI
        </a>
    </div>

    <div class="bg-white rounded-3xl shadow-soft p-6 md:p-8 max-w-2xl mx-auto border border-gray-100">
        <form action="{{ route('admin.galleries.update', $gallery->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="space-y-6">

                {{-- 1. Input Judul --}}
                <div class="w-full">
                    <label for="title" class="block text-sm font-bold text-dark-tower mb-2 uppercase tracking-widest">Judul Dokumentasi <span class="text-red-500">*</span></label>
                    <input type="text" name="title" id="title"
                           value="{{ old('title', $gallery->title) }}"
                           required
                           class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-4 focus:ring-orange-500/10 focus:border-accent-tower outline-none transition-all font-semibold"
                           placeholder="Masukkan judul proyek">
                    @error('title')
                        <p class="text-red-500 text-xs mt-1 font-medium">{{ $message }}</p>
                    @enderror
                </div>

                {{-- 2. Tampilan Gambar Saat Ini --}}
                <div class="w-full">
                    <label class="block text-sm font-bold text-dark-tower mb-2 uppercase tracking-widest">Pratinjau Gambar</label>
                    <div class="relative w-full h-64 bg-gray-50 rounded-2xl overflow-hidden border-2 border-dashed border-gray-200 flex items-center justify-center group">

                        {{-- Logika Cek Path Gambar (Sama seperti Index) --}}
                        @php
                            $imagePath = '';
                            if($gallery->image) {
                                if (str_starts_with($gallery->image, 'assets/')) {
                                    $imagePath = asset($gallery->image);
                                } elseif (str_starts_with($gallery->image, 'gallery/')) {
                                    $imagePath = asset('assets/img/' . $gallery->image);
                                } else {
                                    $imagePath = asset('storage/' . $gallery->image);
                                }
                            }
                        @endphp

                        @if($gallery->image)
                            <img src="{{ $imagePath }}"
                                 class="w-full h-full object-cover transition duration-500"
                                 id="current-img"
                                 alt="{{ $gallery->title }}">
                        @else
                            <div class="text-center" id="no-image-placeholder">
                                <i class="bi bi-image text-gray-300 text-5xl"></i>
                                <p class="text-gray-400 text-xs mt-2 font-bold uppercase tracking-widest">Tidak ada gambar</p>
                            </div>
                        @endif

                        <div class="absolute inset-0 bg-black/40 opacity-0 group-hover:opacity-100 flex items-center justify-center transition-opacity pointer-events-none">
                            <span class="text-white text-xs font-bold uppercase tracking-widest">Ganti Gambar Dibawah</span>
                        </div>
                    </div>
                </div>

                {{-- 3. Input Gambar Baru --}}
                <div class="w-full">
                    <label for="image" class="block text-sm font-bold text-dark-tower mb-2 uppercase tracking-widest">Unggah Gambar Baru</label>
                    <div class="border-2 border-dashed border-gray-200 rounded-2xl p-4 hover:border-accent-tower transition-colors bg-slate-50/50">
                        <input type="file" name="image" id="image" accept="image/*"
                               class="w-full text-sm text-gray-500 file:font-semibold cursor-pointer @error('image') border-red-500 @enderror">
                    </div>

                    @error('image')
                        <p class="text-red-500 text-xs mt-1 font-medium">{{ $message }}</p>
                    @enderror

                    <div class="mt-3 flex items-start space-x-2 px-1">
                        <i class="bi bi-info-circle-fill text-accent-tower text-xs mt-0.5"></i>
                        <p class="text-[10px] text-gray-500 leading-tight font-medium uppercase tracking-tight">Kosongkan jika tidak ingin mengganti. Format: JPG, PNG, WEBP (Maks. 4MB).</p>
                    </div>
                </div>

            </div>

            {{-- Tombol Aksi --}}
            <div class="mt-8 flex items-center justify-end space-x-4 pt-6 border-t border-gray-100">
                <a href="{{ route('admin.galleries.index') }}"
                   class="px-6 py-3 rounded-xl font-bold text-gray-400 hover:text-gray-600 transition-all text-xs uppercase tracking-widest">
                    Batal
                </a>

                <button type="submit"
                        class="bg-accent-tower text-white px-8 py-3 rounded-xl font-bold hover:bg-accent-dark transition-all duration-300 shadow-lg shadow-orange-500/20 flex items-center space-x-2 text-xs uppercase tracking-widest">
                    <i class="bi bi-cloud-check-fill text-lg"></i> <span>Simpan Perubahan</span>
                </button>
            </div>
        </form>
    </div>
</div>

{{-- Script Live Preview --}}
<script>
    const imageInput = document.getElementById('image');
    const currentImg = document.getElementById('current-img');
    const placeholder = document.getElementById('no-image-placeholder');

    imageInput.onchange = evt => {
        const [file] = imageInput.files;
        if (file) {
            // Jika sebelumnya tidak ada gambar, kita buat elemen img
            if(!currentImg) {
                location.reload(); // Cara termudah untuk merefresh placeholder menjadi img
            } else {
                currentImg.src = URL.createObjectURL(file);
                currentImg.classList.add('animate-pulse');
                setTimeout(() => currentImg.classList.remove('animate-pulse'), 1000);
            }
        }
    }
</script>

@endsection
