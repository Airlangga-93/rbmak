@extends('admin.layouts.app')

@section('title', 'Profil & Deskripsi Properti')

@section('content')

    {{-- Gaya Kustom Didefinisikan Ulang sebagai Kelas Tailwind (Asumsi sudah ada di tailwind.config.js) --}}
    {{-- Jika belum dikonfigurasi di config, Anda harus menggunakan nilai hex inline seperti yang saya lakukan di beberapa tempat. --}}
    {{-- tower-dark: #2C3E50, tower-accent: #FF8C00 --}}

    <div class="p-4 md:p-8">

        {{-- Header Halaman & Tombol Aksi --}}
        <div class="flex items-center justify-between mb-6">
            <h1 class="text-2xl font-bold text-[#2C3E50] flex items-center">
                <i class="fas fa-info-circle text-[#FF8C00] mr-2 text-xl"></i> Profil & Deskripsi
            </h1>

            {{-- Tombol Tambah Data --}}
            {{-- Catatan: Hanya boleh ada satu data About di sistem CMS untuk Visi/Misi --}}
            {{-- Saya membiarkan tombol ini, tetapi di Controller/Model harus ada guard agar hanya 1 data yang bisa dibuat. --}}
            <a href="{{ route('admin.abouts.create') }}"
               class="px-4 py-2 text-white bg-[#FF8C00] rounded-lg font-semibold transition duration-300 hover:bg-opacity-90 shadow-md flex items-center">
                <i class="fas fa-plus-circle mr-1"></i> Tambah Data
            </a>
        </div>

        {{-- Alert Sukses (Menggunakan Tailwind standard green/success) --}}
        @if(session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-lg relative mb-4" role="alert">
                <span class="block sm:inline font-medium">{{ session('success') }}</span>
                <span class="absolute top-0 bottom-0 right-0 px-4 py-3 cursor-pointer" onclick="this.parentElement.style.display='none';">
                    <svg class="fill-current h-6 w-6 text-green-500" role="button" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><title>Close</title><path d="M14.348 14.849a1.2 1.2 0 01-1.697 0L10 11.819l-2.651 3.03a1.2 1.2 0 11-1.697-1.697l2.758-3.15L6.257 7.269a1.2 1.2 0 011.697-1.697l2.758 3.15 2.651-3.03a1.2 1.2 0 111.697 1.697l-2.758 3.15 2.758 3.15a1.2 1.2 0 010 1.697z"/></svg>
                </span>
            </div>
        @endif

        {{-- Alert Error (Menggunakan Tailwind standard red/error) --}}
        @if(session('error'))
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-lg relative mb-4" role="alert">
                <span class="block sm:inline font-medium">{{ session('error') }}</span>
                <span class="absolute top-0 bottom-0 right-0 px-4 py-3 cursor-pointer" onclick="this.parentElement.style.display='none';">
                    <svg class="fill-current h-6 w-6 text-red-500" role="button" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><title>Close</title><path d="M14.348 14.849a1.2 1.2 0 01-1.697 0L10 11.819l-2.651 3.03a1.2 1.2 0 11-1.697-1.697l2.758-3.15L6.257 7.269a1.2 1.2 0 011.697-1.697l2.758 3.15 2.651-3.03a1.2 1.2 0 111.697 1.697l-2.758 3.15 2.758 3.15a1.2 1.2 0 010 1.697z"/></svg>
                </span>
            </div>
        @endif

        {{-- Tabel Konten --}}
        <div class="bg-white rounded-xl shadow-lg mb-8 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead>
                        <tr class="bg-gray-50">
                            {{-- Header Kolom --}}
                            <th class="px-4 py-3 text-center text-xs font-bold text-[#2C3E50] uppercase tracking-wider border-b-2 border-[#FF8C00] w-[5%]">No</th>
                            <th class="px-4 py-3 text-left text-xs font-bold text-[#2C3E50] uppercase tracking-wider border-b-2 border-[#FF8C00] w-[35%]">Visi</th>
                            <th class="px-4 py-3 text-left text-xs font-bold text-[#2C3E50] uppercase tracking-wider border-b-2 border-[#FF8C00] w-[35%]">Misi</th>
                            <th class="px-4 py-3 text-center text-xs font-bold text-[#2C3E50] uppercase tracking-wider border-b-2 border-[#FF8C00] w-[15%]">Gambar Pendukung</th>
                            <th class="px-4 py-3 text-center text-xs font-bold text-[#2C3E50] uppercase tracking-wider border-b-2 border-[#FF8C00] w-[10%]">Aksi</th>
                        </tr>
                    </thead>

                    <tbody class="divide-y divide-gray-100">
                    @forelse($abouts as $index => $about)
                        <tr class="hover:bg-gray-50 transition duration-150">
                            {{-- No. --}}
                            <td class="px-4 py-4 text-center text-sm text-gray-500">{{ $index + 1 }}</td>

                            {{-- Konten Visi & Misi --}}
                            <td class="px-4 py-4 text-left text-sm text-[#2C3E50]">{{ Str::limit($about->vision, 90) }}</td>
                            <td class="px-4 py-4 text-left text-sm text-[#2C3E50]">{{ Str::limit($about->mission, 90) }}</td>

                            {{-- Gambar --}}
                            <td class="px-4 py-4 text-center">
                                @if($about->image)
                                    <img src="{{ asset('storage/'.$about->image) }}" width="50" height="50"
                                        class="rounded-full object-cover mx-auto shadow-sm border border-gray-200 h-12 w-12" alt="gambar">
                                @else
                                    <span class="text-gray-400 text-xs">N/A</span>
                                @endif
                            </td>

                            {{-- Aksi --}}
                            <td class="px-4 py-4 text-center">
                                <div class="flex justify-center space-x-2">
                                    {{-- Show (Menggunakan warna Dark Tower) --}}
                                    <a href="{{ route('admin.abouts.show', $about->id) }}"
                                       class="text-[#2C3E50] hover:text-[#FF8C00] p-2 rounded-full transition duration-150 hover:bg-gray-100" title="Detail">
                                        <i class="fas fa-eye text-base"></i>
                                    </a>

                                    {{-- Edit (Menggunakan warna Accent Tower) --}}
                                    <a href="{{ route('admin.abouts.edit', $about->id) }}"
                                       class="text-[#FF8C00] hover:text-[#2C3E50] p-2 rounded-full transition duration-150 hover:bg-gray-100" title="Edit">
                                        <i class="fas fa-pencil-alt text-base"></i>
                                    </a>

                                    {{-- Delete (Menggunakan warna Merah standard/danger) --}}
                                    <form action="{{ route('admin.abouts.destroy', $about->id) }}" method="POST" class="inline">
                                        @csrf @method('DELETE')
                                        <button type="submit"
                                                class="text-red-500 hover:text-red-700 p-2 rounded-full transition duration-150 hover:bg-red-50" title="Hapus"
                                                onclick="return confirm('Apakah Anda yakin ingin menghapus data ini secara permanen?')">
                                            <i class="fas fa-trash-alt text-base"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="py-12 text-center bg-gray-50">
                                <i class="fas fa-info-circle text-[#FF8C00] text-4xl mb-3"></i>
                                <h4 class="text-lg font-semibold text-[#2C3E50]">Data Visi & Misi belum tersedia.</h4>
                                <p class="text-sm text-gray-500">Silakan klik tombol 'Tambah Data' di atas untuk menambahkan informasi.</p>
                            </td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
