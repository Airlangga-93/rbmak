@extends('layouts.app')

@section('title', $facility->name . ' - PT. RBM')

@section('content')
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    @php
        /**
         * Logika Gambar: Mendeteksi apakah path dari seeder atau upload storage
         */
        $imagePath = $facility->image
            ? (str_contains($facility->image, 'assets/') ? asset($facility->image) : asset('storage/' . $facility->image))
            : 'https://images.unsplash.com/photo-1581091226825-a6a2a5aee158?q=80&w=1000';
    @endphp

    <div class="bg-[#F9FBFF] min-h-screen font-['Poppins']">

        {{-- 🌌 HERO BANNER --}}
        <section class="relative h-[20vh] lg:h-[30vh] flex items-center overflow-hidden bg-[#161f36]">
            <div class="absolute inset-0 z-0">
                <img src="{{ $imagePath }}" class="w-full h-full object-cover opacity-30 blur-sm" alt="Background">
                <div class="absolute inset-0 bg-gradient-to-r from-[#161f36] to-transparent"></div>
            </div>

            <div class="relative z-10 max-w-7xl mx-auto px-6 w-full">
                <nav class="flex mb-4" aria-label="Breadcrumb">
                    <ol class="inline-flex items-center space-x-2 text-[10px] uppercase tracking-widest font-bold">
                        <li><a href="/" class="text-gray-400 hover:text-white transition">Home</a></li>
                        <li class="text-gray-500"><i class="fas fa-chevron-right text-[8px] mx-1"></i></li>
                        <li><a href="{{ route('facilities.index') }}" class="text-gray-400 hover:text-white transition">Facilities</a></li>
                        <li class="text-gray-500"><i class="fas fa-chevron-right text-[8px] mx-1"></i></li>
                        <li class="text-[#FF7518] truncate max-w-[150px]">{{ $facility->name }}</li>
                    </ol>
                </nav>
                <h1 class="text-2xl md:text-4xl font-black text-white uppercase tracking-tight">
                    Detail <span class="text-[#FF7518]">Fasilitas</span>
                </h1>
            </div>
        </section>

        {{-- 🏗️ MAIN CONTENT --}}
        <section class="py-12 lg:py-16">
            <div class="max-w-7xl mx-auto px-6">
                <div class="flex flex-col lg:flex-row gap-12">

                    {{-- KOLOM KIRI: Konten Utama --}}
                    <div class="lg:w-2/3">
                        {{-- Badge & Judul --}}
                        <div class="mb-8">
                            <span class="bg-[#FF7518]/10 text-[#FF7518] px-4 py-1.5 rounded-full text-[10px] font-black uppercase tracking-widest border border-[#FF7518]/20">
                                {{ $facility->type }}
                            </span>
                            <h2 class="mt-4 text-3xl lg:text-4xl font-black text-[#161f36] uppercase tracking-tight leading-tight">
                                {{ $facility->name }}
                            </h2>
                            <div class="flex items-center gap-4 mt-4 text-gray-400 text-xs font-medium uppercase tracking-widest">
                                <span class="flex items-center gap-2">
                                    <i class="far fa-calendar-alt text-[#FF7518]"></i>
                                    {{ $facility->created_at->translatedFormat('d M Y') }}
                                </span>
                                <span class="flex items-center gap-2">
                                    <i class="fas fa-fingerprint text-[#FF7518]"></i>
                                    ID: {{ str_pad($facility->id, 3, '0', STR_PAD_LEFT) }}
                                </span>
                            </div>
                        </div>

                        {{-- GAMBAR UTAMA --}}
                        <div class="mb-10 group">
                            <div class="relative overflow-hidden rounded-[2rem] shadow-2xl bg-white border border-gray-100 max-h-[500px] flex justify-center">
                                <img src="{{ $imagePath }}" alt="{{ $facility->name }}"
                                    class="w-full h-full object-contain bg-gray-50 group-hover:scale-105 transition-transform duration-700">
                            </div>
                        </div>

                        {{-- DESKRIPSI LENGKAP --}}
                        <div class="prose prose-blue max-w-none">
                            <h4 class="text-[#161f36] font-black uppercase tracking-widest text-sm mb-4 flex items-center gap-2">
                                <span class="w-8 h-[2px] bg-[#FF7518]"></span>
                                Deskripsi Teknis
                            </h4>
                            <div class="bg-white p-8 rounded-3xl border border-gray-100 shadow-sm text-gray-600 leading-relaxed text-sm lg:text-base">
                                {!! nl2br(e($facility->description)) !!}
                            </div>
                        </div>
                    </div>

                    {{-- KOLOM KANAN: Sidebar --}}
                    <div class="lg:w-1/3">
                        <div class="sticky top-28 space-y-8">

                            {{-- Kartu Info Perusahaan --}}
                            <div class="bg-[#161f36] rounded-[2rem] p-8 text-white relative overflow-hidden shadow-xl">
                                <div class="relative z-10">
                                    <h3 class="text-lg font-bold mb-4 uppercase tracking-tight">Butuh Informasi Lebih?</h3>
                                    <p class="text-gray-400 text-xs leading-relaxed mb-6 uppercase tracking-widest">
                                        Hubungi tim teknis kami untuk detail spesifikasi alat atau kunjungan kerja.
                                    </p>
                                    <a href="/contact"
                                        class="flex items-center justify-center gap-3 bg-[#FF7518] py-4 rounded-xl font-black text-[10px] uppercase tracking-[0.2em] hover:bg-white hover:text-[#161f36] transition-all">
                                        Contact Support <i class="fas fa-arrow-right text-[8px]"></i>
                                    </a>
                                </div>
                                <div class="absolute -bottom-10 -right-10 w-32 h-32 bg-white/5 rounded-full blur-2xl"></div>
                            </div>

                            {{-- Fasilitas Lainnya --}}
                            <div class="bg-white rounded-[2rem] p-8 border border-gray-100 shadow-sm">
                                <h3 class="text-[#161f36] font-black uppercase tracking-widest text-xs mb-6 pb-4 border-b border-gray-100">
                                    Fasilitas Terkait
                                </h3>

                                <div class="space-y-6">
                                    @forelse ($otherFacilities as $other)
                                        @php
                                            $otherImg = $other->image
                                                ? (str_contains($other->image, 'assets/') ? asset($other->image) : asset('storage/' . $other->image))
                                                : 'https://via.placeholder.com/150';
                                        @endphp
                                        <a href="{{ route('facilities.show', $other) }}" class="group flex items-center gap-4">
                                            <div class="w-16 h-16 flex-shrink-0 rounded-xl overflow-hidden bg-gray-100 border border-gray-50">
                                                <img src="{{ $otherImg }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                                            </div>
                                            <div class="flex-1">
                                                <p class="text-[8px] font-black text-[#FF7518] uppercase tracking-widest mb-1">{{ $other->type }}</p>
                                                <h4 class="text-xs font-bold text-[#161f36] group-hover:text-[#FF7518] transition-colors line-clamp-1 uppercase">
                                                    {{ $other->name }}
                                                </h4>
                                            </div>
                                        </a>
                                    @empty
                                        <p class="text-gray-400 text-[10px] uppercase text-center italic">Tidak ada data lain</p>
                                    @endforelse
                                </div>

                                <a href="{{ route('facilities.index') }}"
                                    class="mt-8 flex items-center justify-center w-full py-3 border-2 border-[#161f36] text-[#161f36] rounded-xl text-[9px] font-black uppercase tracking-[0.2em] hover:bg-[#161f36] hover:text-white transition-all">
                                    Lihat Semua Fasilitas
                                </a>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </section>
    </div>
@endsection
