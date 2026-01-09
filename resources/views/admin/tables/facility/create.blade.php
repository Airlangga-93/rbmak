@extends('admin.layouts.app')

@section('title', 'Tambah Fasilitas')

@section('content')
{{-- Load CSS Kustom --}}
<style>
    /* Definisi Warna Kustom (Tower Theme) */
    .text-dark-tower { color: #2C3E50; }
    .bg-dark-tower { background-color: #2C3E50; }
    .text-accent-tower { color: #FF8C00; }
    .bg-accent-tower { background-color: #FF8C00; }
    .hover\:bg-accent-dark:hover { background-color: #E67E22; }
    .focus\:ring-accent-tower:focus { ring-color: #FF8C00; }
    .shadow-soft { box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08); }

    /* Gaya khusus untuk input file agar lebih bersih */
    input[type="file"]::file-selector-button {
        background-color: #e0e0e0;
        color: #333;
        border: none;
        padding: 0.5rem 1rem;
        margin-right: 1rem;
        border-radius: 0.375rem;
        cursor: pointer;
        transition: background-color 0.2s;
    }

    input[type="file"]::file-selector-button:hover {
        background-color: #d0d0d0;
    }

    /* Animasi Loading saat submit untuk mencegah double post */
    .btn-loading {
        position: relative;
        color: transparent !important;
        pointer-events: none;
    }
    .btn-loading::after {
        content: "";
        position: absolute;
        width: 20px;
        height: 20px;
        top: 50%;
        left: 50%;
        margin: -10px 0 0 -10px;
        border: 3px solid rgba(255,255,255,0.3);
        border-radius: 50%;
        border-top-color: #fff;
        animation: spin 0.8s ease-in-out infinite;
    }
    @keyframes spin { to { transform: rotate(360deg); } }
</style>

<div class="main-content flex-1 p-6 bg-gray-100 min-h-screen">
    <div class="bg-white rounded-xl shadow-soft p-6 md:p-8 max-w-4xl mx-auto">

        {{-- Header Form --}}
        <div class="flex justify-between items-center mb-8">
            <h1 class="text-2xl font-bold text-dark-tower flex items-center">
                <i class="fas fa-plus-circle text-accent-tower mr-2"></i> Tambah Fasilitas Baru
            </h1>

            {{-- Tombol Kembali --}}
            <a href="{{ route('admin.facilities.index') }}"
                class="bg-gray-200 text-dark-tower px-4 py-2 rounded-lg font-semibold hover:bg-gray-300 transition-colors duration-200 flex items-center space-x-2 text-sm shadow-sm">
                <i class="fas fa-arrow-left"></i>
                <span>Kembali</span>
            </a>
        </div>

        {{-- Form Tambah Fasilitas --}}
        <form action="{{ route('admin.facilities.store') }}" method="POST" enctype="multipart/form-data" id="facilityForm">
            @csrf

            {{-- Nama Fasilitas --}}
            <div class="mb-5">
                <label for="name" class="block text-sm font-medium text-dark-tower mb-1">Nama Fasilitas <span class="text-red-500">*</span></label>
                <input type="text" name="name" id="name" required
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-accent-tower focus:border-accent-tower transition @error('name') border-red-500 @enderror"
                    value="{{ old('name') }}" placeholder="Contoh: Mesin Las TIG 200A">
                @error('name')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- Foto Fasilitas --}}
            <div class="mb-5">
                <label for="image" class="block text-sm font-medium text-dark-tower mb-1">Foto Fasilitas <span class="text-red-500">*</span></label>
                <div class="relative">
                    <input type="file" name="image" id="image" required
                        class="w-full border border-gray-300 rounded-lg text-sm text-gray-700 focus:outline-none focus:ring-2 focus:ring-accent-tower focus:border-accent-tower transition @error('image') border-red-500 @enderror"
                        accept="image/*"
                        onchange="previewImage(event)">
                </div>
                <p class="text-gray-400 text-[10px] mt-1 italic">Format: JPG, PNG, WEBP. Maksimal 2MB.</p>
                @error('image')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
                {{-- Preview Area --}}
                <div id="imagePreviewContainer" class="hidden mt-3">
                    <img id="imgPreview" src="#" alt="Preview" class="h-32 rounded-lg shadow-md border border-gray-200">
                </div>
            </div>

            {{-- Deskripsi --}}
            <div class="mb-5">
                <label for="description" class="block text-sm font-medium text-dark-tower mb-1">Deskripsi <span class="text-red-500">*</span></label>
                <textarea name="description" id="description" rows="5" required
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-accent-tower focus:border-accent-tower transition @error('description') border-red-500 @enderror" 
                    placeholder="Jelaskan detail dan fungsi fasilitas...">{{ old('description') }}</textarea>
                @error('description')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- Jenis Fasilitas --}}
            <div class="mb-6">
                <label for="type" class="block text-sm font-medium text-dark-tower mb-1">Jenis Fasilitas <span class="text-red-500">*</span></label>
                <select name="type" id="type" required
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-accent-tower focus:border-accent-tower transition @error('type') border-red-500 @enderror">
                    <option value="" disabled selected>Pilih Jenis Fasilitas</option>
                    <option value="Peralatan Pabrikas" {{ old('type') == 'Peralatan Pabrikas' ? 'selected' : '' }}>Peralatan Pabrikas</option>
                    <option value="Peralatan Maintenance" {{ old('type') == 'Peralatan Maintenance' ? 'selected' : '' }}>Peralatan Maintenance</option>
                    <option value="Kendaraan Operasional" {{ old('type') == 'Kendaraan Operasional' ? 'selected' : '' }}>Kendaraan Operasional</option>
                </select>
                @error('type')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- Tombol Simpan --}}
            <div class="flex items-center justify-end pt-4 border-t border-gray-200">
                <button type="submit" id="submitBtn"
                    class="bg-accent-tower text-white px-8 py-2 rounded-lg font-semibold hover:bg-accent-dark transition-all duration-200 shadow-md flex items-center">
                    <i class="fas fa-save mr-2"></i> 
                    <span id="btnText">Simpan Fasilitas</span>
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    // Preview gambar sebelum upload
    function previewImage(event) {
        const reader = new FileReader();
        const preview = document.getElementById('imgPreview');
        const container = document.getElementById('imagePreviewContainer');
        
        reader.onload = function(){
            preview.src = reader.result;
            container.classList.remove('hidden');
        }
        reader.readAsDataURL(event.target.files[0]);
    }

    // Tambahkan efek loading saat submit untuk mencegah delay visual & double submit
    const form = document.getElementById('facilityForm');
    const btn = document.getElementById('submitBtn');
    const btnText = document.getElementById('btnText');

    form.addEventListener('submit', function() {
        btn.classList.add('btn-loading');
        btnText.textContent = 'Menyimpan...';
    });
</script>

@endsection