@extends('admin.layouts.app')

@section('title', 'Edit Fasilitas')

@section('content')

    <!DOCTYPE html>
    <html lang="id">

    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Edit Fasilitas</title>
        <script src="https://cdn.tailwindcss.com"></script>
        <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">

        <style>
            /* Definisi Warna Kustom (Tower Theme) */
            .text-dark-tower { color: #2C3E50; }
            .bg-dark-tower { background-color: #2C3E50; }
            .text-accent-tower { color: #FF8C00; }
            .bg-accent-tower { background-color: #FF8C00; }
            .hover\:bg-accent-dark:hover { background-color: #E67E22; }
            .focus\:ring-accent-tower:focus { ring-color: #FF8C00; }
            .shadow-soft { box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08); }

            body {
                font-family: 'Poppins', sans-serif;
                background-color: #f0f2f5;
            }

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
                        <i class="fas fa-edit text-accent-tower mr-2"></i> Edit Fasilitas: <span class="ml-2">{{ $facility->name }}</span>
                    </h1>

                    {{-- Tombol Kembali --}}
                    <a href="{{ route('admin.facilities.index') }}"
                        class="bg-gray-200 text-dark-tower px-4 py-2 rounded-lg font-semibold hover:bg-gray-300 transition-colors duration-200 flex items-center space-x-2 text-sm shadow-sm">
                        <i class="fas fa-arrow-left"></i>
                        <span>Kembali ke Daftar</span>
                    </a>
                </div>

                {{-- Form Edit Fasilitas --}}
                <form action="{{ route('admin.facilities.update', $facility->id) }}" method="POST"
                    enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    {{-- Nama Fasilitas --}}
                    <div class="mb-5">
                        <label for="name" class="block text-sm font-medium text-dark-tower mb-1">Nama Fasilitas <span class="text-red-500">*</span></label>
                        <input type="text" name="name" id="name" required
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-accent-tower focus:border-accent-tower transition @error('name') border-red-500 @enderror"
                            value="{{ old('name', $facility->name) }}" placeholder="Masukkan nama fasilitas">
                        @error('name')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Foto Fasilitas --}}
                    <div class="mb-5">
                        <label for="image" class="block text-sm font-medium text-dark-tower mb-1">Foto Fasilitas (Kosongkan jika tidak ingin diubah)</label>
                        <input type="file" name="image" id="image"
                            class="w-full border border-gray-300 rounded-lg text-sm text-gray-700 focus:outline-none focus:ring-2 focus:ring-accent-tower focus:border-accent-tower transition @error('image') border-red-500 @enderror">

                        @if($facility->image)
                            <div class="mt-4 p-3 bg-gray-50 rounded-lg border border-gray-200 inline-block">
                                <p class="text-xs text-dark-tower font-medium mb-2">Foto Saat Ini:</p>
                                {{-- Penyesuaian Path: Mengecek apakah path dari seeder (assets/...) atau upload (storage/...) --}}
                                @php
                                    $imagePath = str_contains($facility->image, 'assets/') ? asset($facility->image) : asset('storage/' . $facility->image);
                                @endphp
                                <img src="{{ $imagePath }}" alt="Foto Fasilitas"
                                    class="w-24 h-24 object-cover rounded-md shadow-sm border border-gray-300">
                            </div>
                        @endif

                        @error('image')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Deskripsi --}}
                    <div class="mb-5">
                        <label for="description" class="block text-sm font-medium text-dark-tower mb-1">Deskripsi <span class="text-red-500">*</span></label>
                        <textarea name="description" id="description" rows="5" required
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-accent-tower focus:border-accent-tower transition @error('description') border-red-500 @enderror" placeholder="Jelaskan detail fasilitas...">{{ old('description', $facility->description) }}</textarea>
                        @error('description')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Jenis Fasilitas (Disesuaikan dengan Seeder) --}}
                    <div class="mb-6">
                        <label for="type" class="block text-sm font-medium text-dark-tower mb-1">Jenis Fasilitas <span class="text-red-500">*</span></label>
                        <select name="type" id="type" required
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-accent-tower focus:border-accent-tower transition @error('type') border-red-500 @enderror">
                            <option value="" disabled>Pilih Jenis Fasilitas</option>
                            <option value="Peralatan Pabrikasi" {{ old('type', $facility->type) == 'Peralatan Pabrikasi' ? 'selected' : '' }}>Peralatan Pabrikasi</option>
                            <option value="Peralatan Maintenance" {{ old('type', $facility->type) == 'Peralatan Maintenance' ? 'selected' : '' }}>Peralatan Maintenance</option>
                            <option value="Kendaraan Operasional" {{ old('type', $facility->type) == 'Kendaraan Operasional' ? 'selected' : '' }}>Kendaraan Operasional</option>
                        </select>
                        @error('type')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Tombol Perbarui --}}
                    <div class="flex items-center justify-end pt-4 border-t border-gray-200">
                        <button type="submit"
                            class="bg-accent-tower text-white px-8 py-2 rounded-lg font-semibold hover:bg-accent-dark transition-colors duration-200 shadow-md">
                            <i class="fas fa-sync-alt mr-2"></i> Perbarui Fasilitas
                        </button>
                    </div>
                </form>
            </div>
        </div>

    </body>

    </html>

@endsection
