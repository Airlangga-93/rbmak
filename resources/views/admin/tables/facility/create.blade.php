@extends('admin.layouts.app')

@section('title', 'Tambah Fasilitas')

@section('content')

    <!DOCTYPE html>
    <html lang="id">

    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Tambah Fasilitas</title>
        <script src="https://cdn.tailwindcss.com"></script>
        <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">

        <style>
            /* Definisi Warna Kustom (Tower Theme) */
            .text-dark-tower { color: #2C3E50; } /* Biru Tua/Dark Blue */
            .bg-dark-tower { background-color: #2C3E50; }
            .text-accent-tower { color: #FF8C00; } /* Oranye/Emas */
            .bg-accent-tower { background-color: #FF8C00; }
            .hover\:bg-accent-dark:hover { background-color: #E67E22; } /* Hover gelap */
            .focus\:ring-accent-tower:focus { ring-color: #FF8C00; }
            .shadow-soft { box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08); }

            body {
                font-family: 'Poppins', sans-serif;
                background-color: #f0f2f5;
            }

            /* Gaya khusus untuk input file agar lebih mudah di-styling dengan Tailwind */
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
        </style>
    </head>

    <body class="bg-gray-100">

        <div class="main-content flex-1 p-6">
            <div class="bg-white rounded-xl shadow-soft p-6 md:p-8">

                {{-- Header Form --}}
                <div class="flex justify-between items-center mb-8">
                    <h1 class="text-2xl font-bold text-dark-tower flex items-center">
                        <i class="fas fa-plus-circle text-accent-tower mr-2"></i> Tambah Fasilitas Baru
                    </h1>

                    {{-- Tombol Kembali --}}
                    <a href="{{ route('admin.facilities.index') }}"
                        class="bg-gray-200 text-dark-tower px-4 py-2 rounded-lg font-semibold hover:bg-gray-300 transition-colors duration-200 flex items-center space-x-2 text-sm shadow-sm">
                        <i class="fas fa-arrow-left"></i>
                        <span>Kembali ke Daftar</span>
                    </a>
                </div>

                {{-- Form Tambah Fasilitas --}}
                <form action="{{ route('admin.facilities.store') }}" method="POST" enctype="multipart/form-data">
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
                        <input type="file" name="image" id="image" required
                            class="w-full border border-gray-300 rounded-lg text-sm text-gray-700 focus:outline-none focus:ring-2 focus:ring-accent-tower focus:border-accent-tower transition @error('image') border-red-500 @enderror">
                        @error('image')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Deskripsi --}}
                    <div class="mb-5">
                        <label for="description" class="block text-sm font-medium text-dark-tower mb-1">Deskripsi <span class="text-red-500">*</span></label>
                        <textarea name="description" id="description" rows="5" required
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-accent-tower focus:border-accent-tower transition @error('description') border-red-500 @enderror" placeholder="Jelaskan detail dan fungsi fasilitas...">{{ old('description') }}</textarea>
                        @error('description')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Jenis Fasilitas (Dropdown BARU) --}}
                    <div class="mb-6">
                        <label for="type" class="block text-sm font-medium text-dark-tower mb-1">Jenis Fasilitas <span class="text-red-500">*</span></label>
                        <select name="type" id="type" required
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-accent-tower focus:border-accent-tower transition @error('type') border-red-500 @enderror">
                            <option value="" disabled selected>Pilih Jenis Fasilitas</option>
                            {{-- Opsi Baru Anda --}}
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
                        <button type="submit"
                            class="bg-accent-tower text-white px-8 py-2 rounded-lg font-semibold hover:bg-accent-dark transition-colors duration-200 shadow-md">
                            <i class="fas fa-save mr-2"></i> Simpan Fasilitas
                        </button>
                    </div>
                </form>
            </div>
        </div>

    </body>

    </html>

@endsection
