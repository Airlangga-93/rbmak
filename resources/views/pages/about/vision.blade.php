@extends('layouts.app')

@section('content')
    @php
        $hasImages = isset($mainImages) && $mainImages->isNotEmpty();
        $darkBlue = '#161f36';
        $accentOrange = '#FF7518';
    @endphp

    <div class="antialiased bg-white">
        {{-- HERO SECTION - STYLISH & SHARP --}}
        <section class="relative h-[60vh] min-h-[500px] flex items-center overflow-hidden bg-[#161f36]">
            @if ($hasImages)
                <div x-data="{ activeSlide: 1, totalSlides: {{ $mainImages->count() }} }" x-init="setInterval(() => { activeSlide = activeSlide % totalSlides + 1 }, 5000)" class="absolute inset-0 z-0">
                    @foreach ($mainImages as $image)
                        <div x-show="activeSlide === {{ $loop->iteration }}"
                            x-transition:enter="transition duration-1000 ease-out"
                            x-transition:enter-start="opacity-0 scale-110" x-transition:enter-end="opacity-100 scale-100"
                            x-transition:leave="transition duration-1000 ease-in" class="absolute inset-0">
                            <img src="{{ Storage::url($image->path) }}" class="w-full h-full object-cover">
                            <div class="absolute inset-0 bg-gradient-to-r from-[#161f36] via-[#161f36]/70 to-transparent">
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="absolute inset-0 bg-gradient-to-br from-[#161f36] to-slate-900"></div>
            @endif

            <div class="container mx-auto px-6 relative z-10">
                <div class="max-w-3xl">
                    <div
                        class="inline-flex items-center gap-3 px-4 py-2 rounded-full bg-white/10 backdrop-blur-md border border-white/20 mb-8">
                        <span class="w-2 h-2 bg-[#FF7518] rounded-full animate-ping"></span>
                        <span class="text-[10px] font-black text-white uppercase tracking-[0.4em]">Our Purpose</span>
                    </div>
                    <h1 class="text-6xl md:text-8xl font-black text-white leading-[0.85] uppercase tracking-tighter mb-6">
                        Vision <br>& <span class="text-[#FF7518]">Mission</span>
                    </h1>
                    <p
                        class="text-slate-300 text-lg md:text-xl max-w-xl font-medium leading-relaxed border-l-4 border-[#FF7518] pl-6">
                        Komitmen kami dalam menghadirkan infrastruktur telekomunikasi yang menjadi urat nadi digitalisasi
                        bangsa.
                    </p>
                </div>
            </div>

            {{-- Decorative Element --}}
            <div class="absolute bottom-0 right-0 w-1/2 h-24 bg-gradient-to-t from-white to-transparent opacity-10"></div>
        </section>

        {{-- BREADCRUMB - MINIMALIST --}}
        <div class="bg-slate-50 border-b border-slate-100">
            <div class="max-w-screen-xl mx-auto px-6 py-5">
                <nav class="flex items-center gap-4 text-[11px] font-black uppercase tracking-widest">
                    <a href="/" class="text-slate-400 hover:text-[#FF7518] transition-colors">Home</a>
                    <span class="w-1 h-1 bg-slate-300 rounded-full"></span>
                    <a href="{{ route('about') }}" class="text-slate-400 hover:text-[#FF7518] transition-colors">About</a>
                    <span class="w-1 h-1 bg-[#FF7518] rounded-full"></span>
                    <span class="text-[#161f36]">Vision & Mission</span>
                </nav>
            </div>
        </div>

        {{-- VISION SECTION - MODERN GRID --}}
        <section class="py-32 relative overflow-hidden">
            {{-- Background Pattern --}}
            <div
                class="absolute top-0 right-0 -translate-y-1/2 translate-x-1/4 w-[600px] h-[600px] bg-slate-50 rounded-full blur-3xl -z-10">
            </div>

            <div class="container mx-auto max-w-7xl px-6">
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-20 items-center">
                    <div class="relative">
                        <div
                            class="absolute -top-10 -left-10 text-[12rem] font-black text-slate-50 leading-none select-none">
                            VISION</div>
                        <div class="relative z-10">
                            <span class="text-[#FF7518] font-bold uppercase tracking-[0.3em] text-xs">The Ultimate
                                Goal</span>
                            <h2
                                class="mt-4 text-5xl md:text-6xl font-black text-[#161f36] leading-none uppercase tracking-tighter">
                                Visi Kami <br>Masa Depan.
                            </h2>
                            <div class="w-20 h-2 bg-[#FF7518] mt-10 rounded-full"></div>
                        </div>
                    </div>

                    <div class="relative">
                        <div class="absolute -inset-6 bg-[#161f36] rounded-[3rem] rotate-2 scale-105 opacity-5"></div>
                        <div class="relative bg-white p-12 md:p-16 rounded-[3rem] shadow-2xl border border-slate-50">
                            <i class="fas fa-quote-left text-4xl text-[#FF7518]/20 mb-6"></i>
                            <p class="text-2xl md:text-3xl font-bold text-[#161f36] leading-tight italic">
                                "Menjadi Perusahaan pendukung Industri
                                Telekomunikasi dengan pelayanan terbaik dan mampu
                                memberi solusi menguntungkan bagi pelanggan"
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        {{-- MISSION SECTION - FEATURE GRID --}}
        <section class="py-32 bg-[#161f36] rounded-[4rem] md:rounded-[6rem] mx-4 my-8">
            <div class="container mx-auto max-w-7xl px-6">
                <div class="text-center max-w-3xl mx-auto mb-24">
                    <h2 class="text-4xl md:text-5xl font-black text-white uppercase tracking-tighter mb-6">
                        Misi <span class="text-[#FF7518]">Strategis</span>
                    </h2>
                    <p class="text-slate-400 text-lg">Pilar-pilar utama yang kami jalankan setiap hari untuk mencapai visi
                        besar perusahaan.</p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
                    @php
                        $missions = [
                            [
                                'icon' => 'fa-microchip',
                                'title' => 'Inovasi Teknologi',
                                'desc' => 'Memberi respon dan solusi yang cepat kepada 
pelanggan, meningkatkan kesejahteraan kepada 
karyawan dan melakukan efisiensi dalam bekerja
',
                            ],
                        ];
                    @endphp

                    @foreach ($missions as $index => $m)
                        <div
                            class="group relative p-10 bg-white/5 rounded-[2.5rem] border border-white/10 hover:bg-white hover:shadow-2xl transition-all duration-500 hover:-translate-y-4">
                            <div
                                class="w-16 h-16 bg-[#FF7518] text-white rounded-2xl flex items-center justify-center mb-10 shadow-lg group-hover:rotate-12 transition-transform duration-500">
                                <i class="fas {{ $m['icon'] }} text-2xl"></i>
                            </div>
                            <h3
                                class="text-xl font-black text-white group-hover:text-[#161f36] transition-colors mb-4 uppercase leading-tight">
                                {{ $m['title'] }}</h3>
                            <p class="text-slate-400 group-hover:text-slate-600 transition-colors text-sm leading-relaxed">
                                {{ $m['desc'] }}</p>

                            <div
                                class="absolute top-8 right-8 text-4xl font-black text-white/5 group-hover:text-[#161f36]/5 transition-colors italic">
                                0{{ $index + 1 }}
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>

        {{-- CTA - REFINED --}}
        <section class="py-32">
            <div class="container mx-auto px-6">
                <div class="relative bg-slate-50 rounded-[4rem] p-12 md:p-24 overflow-hidden text-center">
                    {{-- Decorative Shapes --}}
                    <div class="absolute top-0 left-0 w-32 h-32 bg-[#FF7518]/10 rounded-br-full"></div>
                    <div class="absolute bottom-0 right-0 w-32 h-32 bg-[#161f36]/5 rounded-tl-full"></div>

                    <div class="relative z-10">
                        <h2 class="text-3xl md:text-5xl font-black text-[#161f36] uppercase tracking-tighter mb-8">
                            Siap Berkolaborasi <br>Dengan Kami?
                        </h2>
                        <p class="text-slate-500 text-lg mb-12 max-w-2xl mx-auto italic font-medium">
                            "Membangun infrastruktur bukan hanya soal baja dan beton, tapi soal menghubungkan harapan
                            masyarakat."
                        </p>
                        <a href="{{ route('contact') }}"
                            class="group inline-flex items-center gap-4 bg-[#FF7518] text-white px-10 py-5 rounded-2xl font-black uppercase tracking-widest hover:bg-[#161f36] transition-all shadow-xl hover:shadow-[#161f36]/20">
                            Hubungi Tim Kami
                            <i class="fas fa-arrow-right group-hover:translate-x-2 transition-transform"></i>
                        </a>
                    </div>
                </div>
            </div>
        </section>
    </div>

    <style>
        /* Smooth Scroll & Font Enhancement */
        html {
            scroll-behavior: smooth;
        }

        .antialiased {
            -webkit-font-smoothing: antialiased;
        }
    </style>
@endsection
