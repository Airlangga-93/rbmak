@extends('admin.layouts.app')
@section('title','Detail Visi, Misi & Tujuan')

@section('content')

<div class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
    <h4 class="text-2xl font-bold text-[#2C3E50] mb-6 flex items-center">
        <i class="fas fa-info-circle text-[#FF8C00] mr-2 text-xl"></i> Detail Visi, Misi & Tujuan
    </h4>

    <div class="bg-white shadow-xl rounded-lg p-6 md:p-8">

        {{-- Konten Utama (Visi, Misi, Tujuan) --}}
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 border-b pb-6 mb-6 border-gray-100">

            {{-- Visi --}}
            <div>
                <h6 class="text-sm font-bold text-[#2C3E50] mb-1">Visi</h6>
                <p class="text-gray-600 leading-relaxed">{{ $about->vision ?? 'Belum ada Visi.' }}</p>
            </div>

            {{-- Misi --}}
            <div>
                <h6 class="text-sm font-bold text-[#2C3E50] mb-1">Misi</h6>
                <p class="text-gray-600 leading-relaxed">{{ $about->mission ?? 'Belum ada Misi.' }}</p>
            </div>

            {{-- Tujuan (Diasumsikan kolom: objective) --}}
            <div>
                <h6 class="text-sm font-bold text-[#2C3E50] mb-1">Tujuan</h6>
                <p class="text-gray-600 leading-relaxed">{{ $about->objective ?? 'Belum ada Tujuan.' }}</p>
            </div>
        </div>

        {{-- Gambar dan Waktu --}}
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 items-start">

            {{-- Gambar Pendukung --}}
            <div>
                <h6 class="text-sm font-bold text-[#2C3E50] mb-2">Gambar Pendukung</h6>
                @if($about->image)
                    <img src="{{ asset('storage/'.$about->image) }}" alt="Gambar Pendukung Visi Misi"
                         class="rounded-lg shadow-md object-cover w-40 h-40 border border-gray-200">
                @else
                    <div class="text-sm text-gray-500 italic p-4 bg-gray-50 rounded-md border border-dashed">
                        Tidak ada gambar pendukung.
                    </div>
                @endif
            </div>

            {{-- Waktu Pembuatan/Pembaruan --}}
            <div class="mt-4 md:mt-0">
                <h6 class="text-sm font-bold text-[#2C3E50] mb-2">Metadata</h6>

                <div class="text-sm text-gray-500 space-y-2">
                    <p class="flex items-center">
                        <i class="fas fa-clock w-4 h-4 mr-2 text-gray-400"></i>
                        Dibuat: <span class="ml-1 font-medium text-gray-700">{{ $about->created_at->isoFormat('D MMMM YYYY, H:mm') }}</span>
                    </p>
                    <p class="flex items-center">
                        <i class="fas fa-redo-alt w-4 h-4 mr-2 text-gray-400"></i>
                        Diperbarui: <span class="ml-1 font-medium text-gray-700">{{ $about->updated_at->isoFormat('D MMMM YYYY, H:mm') }}</span>
                    </p>
                </div>
            </div>
        </div>

        {{-- Tombol Aksi --}}
        <div class="mt-8 pt-6 border-t border-gray-200 flex flex-wrap justify-end gap-3">

            {{-- Tombol Edit (Warna Accent Tower: #FF8C00) --}}
            <a href="{{ route('admin.abouts.edit', $about->id) }}"
               class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-[#FF8C00] hover:bg-orange-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#FF8C00] transition duration-150 ease-in-out">
                <i class="fas fa-pencil-alt mr-2"></i> Edit
            </a>

            {{-- Tombol Hapus (Warna Merah standard/danger) --}}
            <form action="{{ route('admin.abouts.destroy', $about->id) }}" method="POST"
                  onsubmit="return confirm('Apakah Anda yakin ingin menghapus data ini secara permanen?')" class="inline">
                @csrf @method('DELETE')
                <button type="submit"
                        class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 transition duration-150 ease-in-out">
                    <i class="fas fa-trash-alt mr-2"></i> Hapus
                </button>
            </form>

            {{-- Tombol Kembali --}}
            <a href="{{ route('admin.abouts.index') }}"
               class="inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition duration-150 ease-in-out ml-auto">
                <i class="fas fa-arrow-left mr-2"></i> Kembali
            </a>
        </div>

    </div>
</div>

@endsection
