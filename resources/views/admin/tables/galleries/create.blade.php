@extends('admin.layouts.app')

@section('title', 'Tambah Gambar - Galeri')

@section('content')

{{-- Definisi Warna Kustom --}}
<style>
    .text-dark-tower { color: #2C3E50; } /* Biru Tua/Primary */
    .bg-dark-tower { background-color: #2C3E50; }
    .text-accent-tower { color: #FF8C00; } /* Oranye/Accent */
    .bg-accent-tower { background-color: #FF8C00; }
    .hover\:bg-accent-dark:hover { background-color: #E67E22; }
    .shadow-soft { box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08); }

    /* Gaya khusus untuk input file agar lebih rapi */
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
    {{-- Breadcrumb / Tombol Kembali --}}
    <div class="mb-6">
        <a href="{{ route('admin.galleries.index') }}" class="inline-flex items-center text-sm text-gray-500 hover:text-accent-tower transition-colors font-medium">
            <i class="bi bi-arrow-left mr-2"></i> Kembali ke Daftar Galeri
        </a>
    </div>

    <div class="max-w-2xl mx-auto">
        <div class="bg-white rounded-2xl shadow-soft overflow-hidden border border-gray-100">
            {{-- Header --}}
            <div class="bg-dark-tower p-6 text-white flex justify-between items-center">
                <div>
                    <h2 class="text-xl font-bold uppercase tracking-tight">Tambah Koleksi Baru</h2>
                    <p class="text-slate-400 text-xs mt-1">Unggah dokumentasi proyek terbaru PT. RBM</p>
                </div>
                <div class="w-12 h-12 bg-white/10 rounded-2xl flex items-center justify-center text-accent-tower border border-white/10">
                    <i class="bi bi-camera-fill text-xl"></i>
                </div>
            </div>

            {{-- Form Input --}}
            <form action="{{ route('admin.galleries.store') }}" method="POST" enctype="multipart/form-data" class="p-8 space-y-6">
                @csrf

                {{-- Input Judul (Sesuai kolom 'title' di Database) --}}
                <div class="space-y-2">
                    <label for="title" class="text-sm font-bold text-dark-tower ml-1 uppercase tracking-wider">Judul Gambar / Proyek <span class="text-red-500">*</span></label>
                    <div class="relative group">
                        <span class="absolute inset-y-0 left-4 flex items-center text-gray-400 group-focus-within:text-accent-tower transition-colors">
                            <i class="bi bi-type"></i>
                        </span>
                        <input type="text" name="title" id="title" value="{{ old('title') }}" required
                            placeholder="Contoh: Pemasangan Tower BTS Site A"
                            class="w-full pl-11 pr-4 py-3 rounded-xl border border-gray-200 focus:border-accent-tower focus:ring-4 focus:ring-orange-500/10 outline-none transition-all font-semibold">
                    </div>
                    @error('title') <p class="text-red-500 text-xs mt-1 font-medium">{{ $message }}</p> @enderror
                </div>

                {{-- Kolom Upload Gambar --}}
                <div class="space-y-2">
                    <label for="image" class="text-sm font-bold text-dark-tower ml-1 uppercase tracking-wider">Pilih File Gambar <span class="text-red-500">*</span></label>
                    <div class="border-2 border-dashed border-gray-200 rounded-2xl p-4 hover:border-accent-tower transition-colors group bg-slate-50/50">
                        <input type="file" name="image" id="image" accept="image/*" required
                               class="w-full text-sm text-gray-500 file:font-semibold cursor-pointer">
                    </div>
                    <div class="flex justify-between items-center px-1">
                        <p class="text-[10px] text-gray-400 italic">*Format: JPG, PNG, WEBP (Maks. 4MB)</p>
                    </div>
                    @error('image') <p class="text-red-500 text-xs mt-1 font-medium">{{ $message }}</p> @enderror
                </div>

                {{-- Live Preview Gambar (JavaScript) --}}
                <div id="preview-container" class="hidden mt-4 animate-fade-in">
                    <p class="text-[10px] font-black text-gray-400 mb-2 uppercase tracking-[0.2em]">Pratinjau Unggahan:</p>
                    <div class="relative rounded-2xl overflow-hidden border-4 border-white shadow-md">
                        <img id="image-preview" src="#" alt="Preview" class="w-full h-64 object-cover">
                        <div class="absolute inset-0 bg-gradient-to-t from-black/20 to-transparent"></div>
                    </div>
                </div>

                {{-- Tombol Aksi --}}
                <div class="pt-6 flex items-center justify-end space-x-4 border-t border-gray-50">
                    <a href="{{ route('admin.galleries.index') }}" class="px-6 py-3 text-sm font-bold text-gray-400 hover:text-gray-600 transition-colors uppercase tracking-widest">
                        Batalkan
                    </a>
                    <button type="submit"
                        class="px-8 py-3 bg-accent-tower hover:bg-accent-dark text-white font-bold rounded-xl shadow-lg shadow-orange-500/20 transition-all transform active:scale-95 flex items-center uppercase tracking-widest text-xs">
                        <i class="bi bi-cloud-arrow-up-fill mr-2 text-lg"></i> Simpan Ke Galeri
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- Script Preview Gambar --}}
<script>
    const imageInput = document.getElementById('image');
    const previewContainer = document.getElementById('preview-container');
    const previewImage = document.getElementById('image-preview');

    imageInput.onchange = evt => {
        const [file] = imageInput.files;
        if (file) {
            previewImage.src = URL.createObjectURL(file);
            previewContainer.classList.remove('hidden');
        }
    }
</script>

<style>
    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(10px); }
        to { opacity: 1; transform: translateY(0); }
    }
    .animate-fade-in { animation: fadeIn 0.3s ease-out forwards; }
</style>

@endsection
