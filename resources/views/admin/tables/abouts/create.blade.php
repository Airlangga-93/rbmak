@extends('admin.layouts.app')
@section('title','Tambah Visi Misi Tujuan')

@section('content')

<div class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
    <h4 class="text-2xl font-bold text-gray-800 mb-6">Tambah Data Visi, Misi & Tujuan</h4>

    {{-- Pesan Error Validasi (Menggunakan Tailwind standard red/error) --}}
    @if ($errors->any())
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-lg relative mb-4" role="alert">
            <strong class="font-bold">Oops!</strong>
            <span class="block sm:inline"> Ada beberapa masalah dengan input Anda.</span>
            <ul class="mt-2 list-disc list-inside">
                @foreach ($errors->all() as $error)
                    {{-- Menangani kasus error 'goal field is required' jika ada --}}
                    @if(str_contains($error, 'goal') || str_contains($error, 'objective'))
                        <li>Perhatian: Data Tujuan (Objective) terdeteksi wajib diisi oleh sistem. Silakan isi atau pastikan konfigurasi validasi Anda di sisi server (Controller) sudah diatur ke 'nullable' jika memang opsional.</li>
                    @else
                        <li>{{ $error }}</li>
                    @endif
                @endforeach
            </ul>
        </div>
    @endif

    <div class="bg-white shadow-xl rounded-lg p-6 md:p-8">
        <form action="{{ route('admin.abouts.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

                {{-- Visi (Wajib) --}}
                <div>
                    <label for="vision" class="block text-sm font-bold text-gray-700 mb-2">
                        Visi <span class="text-red-500">*</span>
                    </label>
                    <textarea name="vision" id="vision" rows="4"
                              class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                              required>{{ old('vision') }}</textarea>
                    @error('vision')
                        <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Misi (Wajib) --}}
                <div>
                    <label for="mission" class="block text-sm font-bold text-gray-700 mb-2">
                        Misi <span class="text-red-500">*</span>
                    </label>
                    <textarea name="mission" id="mission" rows="4"
                              class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                              required>{{ old('mission') }}</textarea>
                    @error('mission')
                        <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Tujuan (Opsional) - TIDAK ADA ATRIBUT required --}}
                <div>
                    <label for="objective" class="block text-sm font-bold text-gray-700 mb-2">
                        Tujuan (Opsional)
                    </label>
                    <textarea name="objective" id="objective" rows="4"
                              class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                              placeholder="Masukkan Tujuan Properti (Jika ada)">{{ old('objective') }}</textarea>
                    @error('objective')
                        <p class="mt-1 text-xs text-red-500">
                            {{ $message }}
                            @if ($message === 'The objective field is required.' || $message === 'The goal field is required.')
                                <span class="font-semibold italic"> (Periksa validasi server, ini seharusnya opsional)</span>
                            @endif
                        </p>
                    @enderror
                </div>

                {{-- Gambar (Opsional) - TIDAK ADA ATRIBUT required --}}
                <div class="col-span-full">
                    <label for="image" class="block text-sm font-bold text-gray-700 mb-2">
                        Gambar Pendukung (Opsional)
                    </label>
                    <input type="file" name="image" id="image"
                           class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100">
                    <p class="mt-1 text-xs text-gray-500">Maksimal 4MB. Untuk ditampilkan di halaman "About".</p>
                    @error('image')
                        <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                    @enderror
                </div>

            </div>

            {{-- Tombol Aksi --}}
            <div class="mt-8 pt-4 border-t border-gray-200 flex justify-end space-x-3">

                {{-- Tombol Simpan (Warna Dark Tower: #2C3E50) --}}
                <button type="submit"
                        class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-[#2C3E50] hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500 transition duration-150 ease-in-out">
                    <i class="fas fa-save mr-2"></i> Simpan
                </button>

                {{-- Tombol Kembali --}}
                <a href="{{ route('admin.abouts.index') }}"
                   class="inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition duration-150 ease-in-out">
                    Kembali
                </a>
            </div>
        </form>
    </div>
</div>

@endsection
