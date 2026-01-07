@extends('admin.layouts.app')

@section('title', 'Detail Testimoni - PT. RBM')

@section('content')

{{-- Definisi Warna Kustom (RBM Theme) --}}
<style>
    .text-dark-tower { color: #1e3a8a; } /* Biru Navy RBM */
    .bg-dark-tower { background-color: #1e3a8a; }
    .text-accent-tower { color: #FF7518; } /* Oranye RBM */
    .bg-accent-tower { background-color: #FF7518; }
    .hover\:bg-accent-dark:hover { background-color: #e66a15; }
    .shadow-soft { box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08); }
</style>

<div class="container mx-auto p-6 max-w-5xl">

    {{-- Header Halaman --}}
    <div class="flex items-center justify-between mb-8">
        <div>
            <h4 class="text-2xl font-black text-dark-tower uppercase tracking-tight">Detail Testimoni</h4>
            <p class="text-xs text-gray-500 mt-1 uppercase tracking-widest font-bold">ID Transaksi: #T-{{ $testimonial->id }}</p>
        </div>
        <a href="{{ route('admin.testimonials.index') }}"
           class="bg-gray-100 text-gray-600 px-4 py-2 rounded-xl font-bold hover:bg-gray-200 transition text-xs uppercase tracking-widest flex items-center gap-2">
            <i class="fas fa-arrow-left"></i> Kembali
        </a>
    </div>

    {{-- Card Detail Utama --}}
    <div class="bg-white rounded-3xl shadow-soft overflow-hidden border border-gray-100">
        <div class="flex flex-col md:flex-row">

            {{-- Sidebar Info Klien --}}
            <div class="w-full md:w-1/3 bg-gray-50/50 p-8 text-center border-b md:border-b-0 md:border-r border-gray-100">
                <div class="mb-6 relative inline-block">
                    @if($testimonial->image && Storage::disk('public')->exists($testimonial->image))
                        <img src="{{ asset('storage/'.$testimonial->image) }}"
                             class="w-40 h-40 rounded-full mx-auto shadow-xl object-cover border-4 border-white"
                             alt="Foto Klien">
                    @else
                        <div class="w-40 h-40 bg-blue-100 rounded-full flex items-center justify-center mx-auto border-4 border-white shadow-lg">
                            <i class="fas fa-user text-blue-300 text-6xl"></i>
                        </div>
                    @endif

                    {{-- Badge Status --}}
                    <div class="absolute bottom-2 right-2 px-3 py-1 rounded-full text-[10px] font-black uppercase shadow-sm
                        {{ $testimonial->status == 'approved' ? 'bg-green-500 text-white' : 'bg-orange-500 text-white' }}">
                        {{ $testimonial->status }}
                    </div>
                </div>

                <h5 class="text-xl font-black text-dark-tower leading-tight">{{ $testimonial->name }}</h5>
                <p class="text-orange-600 font-bold text-xs uppercase tracking-widest mt-1">{{ $testimonial->company ?? 'Personal Client' }}</p>

                <div class="mt-8 pt-6 border-t border-gray-200 flex flex-col gap-3 text-left">
                    <div class="flex items-center justify-between text-[11px]">
                        <span class="text-gray-400 font-bold uppercase">Diterima Pada:</span>
                        <span class="text-gray-700 font-semibold">{{ $testimonial->created_at->format('d M Y, H:i') }}</span>
                    </div>
                    <div class="flex items-center justify-between text-[11px]">
                        <span class="text-gray-400 font-bold uppercase">Terakhir Update:</span>
                        <span class="text-gray-700 font-semibold">{{ $testimonial->updated_at->format('d M Y') }}</span>
                    </div>
                </div>
            </div>

            {{-- Konten Pesan --}}
            <div class="w-full md:w-2/3 p-8 md:p-12 flex flex-col justify-center">
                <i class="fas fa-quote-left text-4xl text-orange-100 mb-4"></i>

                <blockquote class="text-xl md:text-2xl text-gray-700 leading-relaxed font-medium italic relative z-10">
                    "{!! nl2br(e($testimonial->message)) !!}"
                </blockquote>

                {{-- Action Buttons --}}
                <div class="mt-12 flex flex-wrap gap-4 pt-8 border-t border-gray-100">
                    {{-- Approve Button (Hanya tampil jika belum approved) --}}
                    @if($testimonial->status != 'approved')
                    <form action="{{ route('admin.testimonials.status', [$testimonial->id, 'approved']) }}" method="POST">
                        @csrf @method('PATCH')
                        <button class="bg-green-600 text-white px-6 py-3 rounded-xl font-bold hover:bg-green-700 transition shadow-lg shadow-green-600/20 text-xs uppercase tracking-widest flex items-center gap-2">
                            <i class="fas fa-check-circle"></i> Setujui & Publish
                        </button>
                    </form>
                    @endif

                    <a href="{{ route('admin.testimonials.edit', $testimonial->id) }}"
                       class="bg-dark-tower text-white px-6 py-3 rounded-xl font-bold hover:bg-blue-800 transition shadow-lg shadow-blue-900/10 text-xs uppercase tracking-widest flex items-center gap-2">
                        <i class="fas fa-edit"></i> Edit Konten
                    </a>

                    <form action="{{ route('admin.testimonials.destroy', $testimonial->id) }}" method="POST"
                          onsubmit="return confirm('Data akan dihapus permanen. Lanjutkan?')">
                        @csrf @method('DELETE')
                        <button type="submit"
                                class="bg-red-50 text-red-500 px-6 py-3 rounded-xl font-bold hover:bg-red-500 hover:text-white transition text-xs uppercase tracking-widest flex items-center gap-2 border border-red-100">
                            <i class="fas fa-trash-alt"></i> Hapus
                        </button>
                    </form>
                </div>
            </div>

        </div>
    </div>
</div>

@endsection
