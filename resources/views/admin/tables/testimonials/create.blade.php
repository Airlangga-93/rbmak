@extends('admin.layouts.app')

@section('title', 'Tambah Testimoni - PT. RBM')

@section('content')

{{-- Definisi Warna Kustom (Konsisten dengan RBM Theme) --}}
<style>
    .text-dark-tower { color: #1e3a8a; } /* Biru Navy RBM */
    .bg-dark-tower { background-color: #1e3a8a; }
    .text-accent-tower { color: #FF7518; } /* Oranye RBM */
    .bg-accent-tower { background-color: #FF7518; }
    .hover\:bg-accent-dark:hover { background-color: #e66a15; }
    .shadow-soft { box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08); }

    input[type="file"]::file-selector-button {
        background-color: #f1f5f9;
        color: #1e3a8a;
        border: 1px solid #e2e8f0;
        padding: 0.5rem 1rem;
        margin-right: 1rem;
        border-radius: 0.5rem;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.2s;
    }

    input[type="file"]::file-selector-button:hover {
        background-color: #e2e8f0;
    }
</style>

<div class="container mx-auto p-6 max-w-4xl">
    <div class="bg-white rounded-2xl shadow-soft p-6 md:p-10 border border-gray-100">

        {{-- Header --}}
        <div class="mb-8">
            <h4 class="text-2xl font-black text-dark-tower uppercase tracking-tight">Tambah Testimoni Baru</h4>
            <p class="text-sm text-gray-500 italic mt-1">Input data klien secara manual untuk ditampilkan di website.</p>
        </div>

        <form action="{{ route('admin.testimonials.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                {{-- Nama --}}
                <div class="col-span-1">
                    <label for="name" class="block text-xs font-black text-gray-400 uppercase tracking-widest mb-2">Nama Lengkap <span class="text-red-500">*</span></label>
                    <input type="text" name="name" id="name" required
                           placeholder="Contoh: Budi Santoso"
                           class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-orange-500/20 focus:border-orange-500 transition @error('name') border-red-500 @enderror"
                           value="{{ old('name') }}">
                    @error('name')
                        <p class="text-red-500 text-[10px] mt-1 font-bold uppercase">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Perusahaan/Jabatan --}}
                <div class="col-span-1">
                    <label for="company" class="block text-xs font-black text-gray-400 uppercase tracking-widest mb-2">Perusahaan / Jabatan</label>
                    <input type="text" name="company" id="company"
                           placeholder="Contoh: Direktur PT. Energi Bangsa"
                           class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-orange-500/20 focus:border-orange-500 transition"
                           value="{{ old('company') }}">
                </div>

                {{-- Foto --}}
                <div class="col-span-1">
                    <label for="image" class="block text-xs font-black text-gray-400 uppercase tracking-widest mb-2">Foto Klien</label>
                    <input type="file" name="image" id="image" accept="image/*"
                           class="w-full border border-gray-200 rounded-xl text-sm text-gray-500 focus:outline-none focus:ring-2 focus:ring-orange-500/20 transition">
                    <p class="text-[10px] text-gray-400 mt-2 italic">Format: JPG, PNG. Rekomendasi 1:1 (Square).</p>
                    @error('image')
                        <p class="text-red-500 text-[10px] mt-1 font-bold uppercase">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Status Moderasi --}}
                <div class="col-span-1">
                    <label for="status" class="block text-xs font-black text-gray-400 uppercase tracking-widest mb-2">Status Publikasi</label>
                    <select name="status" id="status"
                            class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-orange-500/20 focus:border-orange-500 transition">
                        <option value="pending" {{ old('status') == 'pending' ? 'selected' : '' }}>Moderasi (Pending)</option>
                        <option value="approved" {{ old('status') == 'approved' ? 'selected' : '' }}>Langsung Publish (Approved)</option>
                    </select>
                </div>

                {{-- Pesan --}}
                <div class="md:col-span-2">
                    <label for="message" class="block text-xs font-black text-gray-400 uppercase tracking-widest mb-2">Pesan Testimoni <span class="text-red-500">*</span></label>
                    <textarea name="message" id="message" rows="5" required
                              placeholder="Tuliskan testimoni klien di sini..."
                              class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-orange-500/20 focus:border-orange-500 transition @error('message') border-red-500 @enderror">{{ old('message') }}</textarea>
                    @error('message')
                        <p class="text-red-500 text-[10px] mt-1 font-bold uppercase">{{ $message }}</p>
                    @enderror
                </div>

            </div>

            {{-- Tombol Aksi --}}
            <div class="mt-10 flex flex-col md:flex-row items-center gap-4 pt-6 border-t border-gray-50">
                <button type="submit"
                        class="w-full md:w-auto bg-dark-tower text-white px-10 py-3 rounded-xl font-bold hover:bg-orange-600 transition-all duration-300 shadow-lg shadow-blue-900/10 flex items-center justify-center space-x-2 text-xs uppercase tracking-widest">
                    <i class="fas fa-save text-sm"></i> <span>Simpan Testimoni</span>
                </button>

                <a href="{{ route('admin.testimonials.index') }}"
                   class="w-full md:w-auto bg-gray-100 text-gray-500 px-10 py-3 rounded-xl font-bold hover:bg-gray-200 transition-all duration-300 text-xs uppercase tracking-widest text-center">
                    Batal
                </a>
            </div>
        </form>
    </div>
</div>

@endsection
