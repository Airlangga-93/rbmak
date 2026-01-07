@extends('layouts.app')

@section('content')
    @php
        $hasImages = isset($mainImages) && $mainImages->isNotEmpty();
        $themeDark = '#161f36';
        $themeAccent = '#FF7518';
    @endphp

    <div class="bg-white">
        {{-- HERO SECTION - MODERN CINEMATIC --}}
        <section class="relative h-[70vh] min-h-[500px] overflow-hidden bg-[#161f36]">
            @if ($hasImages)
                <div x-data="{ activeSlide: 1, totalSlides: {{ $mainImages->count() }} }" x-init="setInterval(() => { activeSlide = activeSlide % totalSlides + 1 }, 5000)" class="h-full">
                    @foreach ($mainImages as $image)
                        <div x-show="activeSlide === {{ $loop->iteration }}"
                             x-transition:enter="transition ease-out duration-1000" x-transition:enter-start="opacity-0 scale-110"
                             x-transition:enter-end="opacity-100 scale-100" x-transition:leave="transition ease-in duration-1000"
                             class="absolute inset-0">
                            <img src="{{ Storage::url($image->path) }}" alt="Hero" class="w-full h-full object-cover">
                            {{-- Overlay Gradasi Ganda --}}
                            <div class="absolute inset-0 bg-gradient-to-r from-[#161f36] via-[#161f36]/60 to-transparent"></div>
                            <div class="absolute inset-0 bg-gradient-to-t from-[#161f36] via-transparent to-transparent"></div>
                        </div>
                    @endforeach
                </div>
            @endif

            {{-- Hero Content --}}
            <div class="absolute inset-0 z-10 flex items-center">
                <div class="max-w-screen-xl mx-auto px-6 md:px-12 w-full">
                    <div class="max-w-2xl">
                        <div class="inline-flex items-center gap-3 px-4 py-2 rounded-full bg-white/10 backdrop-blur-md border border-white/20 mb-6">
                            <span class="w-2 h-2 bg-[#FF7518] rounded-full animate-pulse"></span>
                            <span class="text-[10px] font-bold text-white uppercase tracking-[0.3em]">Legacy of Excellence</span>
                        </div>
                        <h1 class="text-5xl md:text-7xl font-black text-white leading-[0.9] uppercase tracking-tighter mb-6">
                            Our <br><span class="text-[#FF7518]">History</span>
                        </h1>
                        <p class="text-slate-300 text-lg md:text-xl font-medium leading-relaxed border-l-4 border-[#FF7518] pl-6">
                            Membangun masa depan telekomunikasi Indonesia melalui dedikasi dan inovasi infrastruktur tanpa henti.
                        </p>
                    </div>
                </div>
            </div>
        </section>

        {{-- BREADCRUMB - FLOATING STYLE --}}
        <div class="relative z-20 -mt-8">
            <div class="max-w-screen-xl mx-auto px-6">
                <nav class="inline-flex items-center bg-white shadow-xl rounded-2xl px-8 py-5 border border-slate-100">
                    <ol class="flex items-center space-x-4 text-[11px] font-black uppercase tracking-widest">
                        <li><a href="/" class="text-slate-400 hover:text-[#FF7518] transition-colors">Home</a></li>
                        <li class="text-slate-300">/</li>
                        <li><a href="{{ route('about') }}" class="text-slate-400 hover:text-[#FF7518] transition-colors">About</a></li>
                        <li class="text-slate-300">/</li>
                        <li class="text-[#161f36]">History</li>
                    </ol>
                </nav>
            </div>
        </div>

        {{-- STRATEGY SECTION (3 CARDS) --}}
        <section class="py-24 bg-white overflow-hidden">
            <div class="max-w-screen-xl mx-auto px-6">
                <div class="flex flex-col lg:flex-row gap-16 items-start mb-20">
                    <div class="lg:w-1/2">
                        <h2 class="text-4xl md:text-5xl font-black text-[#161f36] leading-none uppercase mb-8">
                            Jejak Langkah <br><span class="text-[#FF7518]">Profesionalisme</span>
                        </h2>
                    </div>
                    <div class="lg:w-1/2">
                        <p class="text-gray-500 text-lg leading-relaxed">
                            PT. RIZQALLAH BOER MAKMUR telah bertransformasi dari penyedia jasa konstruksi lokal menjadi mitra strategis nasional dalam pengembangan menara telekomunikasi dan suplai material baja.
                        </p>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                    {{-- Card 1 --}}
                    <div class="group relative p-10 bg-slate-50 rounded-[2.5rem] border border-slate-100 hover:bg-[#161f36] transition-all duration-500 hover:-translate-y-3">
                        <div class="w-16 h-16 bg-white text-[#FF7518] rounded-2xl shadow-sm flex items-center justify-center mb-8 group-hover:bg-[#FF7518] group-hover:text-white transition-all duration-500 group-hover:rotate-12">
                            <i class="fas fa-rocket text-2xl"></i>
                        </div>
                        <h3 class="text-xl font-black text-[#161f36] uppercase mb-4 group-hover:text-white transition-colors">Awal Mula</h3>
                        <p class="text-gray-500 group-hover:text-slate-400 transition-colors leading-relaxed text-sm">
                            Berdiri dengan visi menyatukan konektivitas di seluruh pelosok Indonesia, kami memulai langkah dengan fokus pada kualitas konstruksi pondasi menara.
                        </p>
                    </div>

                    {{-- Card 2 --}}
                    <div class="group relative p-10 bg-slate-50 rounded-[2.5rem] border border-slate-100 hover:bg-[#161f36] transition-all duration-500 hover:-translate-y-3">
                        <div class="w-16 h-16 bg-white text-[#FF7518] rounded-2xl shadow-sm flex items-center justify-center mb-8 group-hover:bg-[#FF7518] group-hover:text-white transition-all duration-500 group-hover:rotate-12">
                            <i class="fas fa-broadcast-tower text-2xl"></i>
                        </div>
                        <h3 class="text-xl font-black text-[#161f36] uppercase mb-4 group-hover:text-white transition-colors">Ekspansi</h3>
                        <p class="text-gray-500 group-hover:text-slate-400 transition-colors leading-relaxed text-sm">
                            Memperluas lini bisnis ke fabrikasi baja mandiri dan penyediaan unit Combat untuk memenuhi kebutuhan mendesak provider telekomunikasi.
                        </p>
                    </div>

                    {{-- Card 3 --}}
                    <div class="group relative p-10 bg-slate-50 rounded-[2.5rem] border border-slate-100 hover:bg-[#161f36] transition-all duration-500 hover:-translate-y-3">
                        <div class="w-16 h-16 bg-white text-[#FF7518] rounded-2xl shadow-sm flex items-center justify-center mb-8 group-hover:bg-[#FF7518] group-hover:text-white transition-all duration-500 group-hover:rotate-12">
                            <i class="fas fa-award text-2xl"></i>
                        </div>
                        <h3 class="text-xl font-black text-[#161f36] uppercase mb-4 group-hover:text-white transition-colors">Standarisasi</h3>
                        <p class="text-gray-500 group-hover:text-slate-400 transition-colors leading-relaxed text-sm">
                            Kini kami menerapkan standar Engineering Design internasional untuk menjamin setiap infrastruktur aman dan berdaya tahan tinggi.
                        </p>
                    </div>
                </div>
            </div>
        </section>

        {{-- CONTENT DETAIL - CLEAN TYPOGRAPHY --}}
        <section class="py-24 bg-slate-50">
            <div class="max-w-4xl mx-auto px-6">
                <div class="text-center mb-16">
                    <h2 class="text-3xl font-black text-[#161f36] uppercase tracking-tighter italic">Laporan Perjalanan</h2>
                    <div class="inline-block w-12 h-1 bg-[#FF7518] mt-2"></div>
                </div>

                <div class="relative group">
                    {{-- Decorative Elements --}}
                    <div class="absolute -inset-4 bg-gradient-to-tr from-[#FF7518]/10 to-transparent rounded-[3rem] blur-2xl opacity-0 group-hover:opacity-100 transition-opacity duration-700"></div>

                    <div class="relative bg-white p-10 md:p-20 rounded-[3rem] shadow-sm border border-slate-100">
                        @if ($historyContent)
                            <article class="prose prose-lg prose-slate max-w-none
                                prose-headings:text-[#161f36] prose-headings:font-black prose-headings:uppercase
                                prose-p:text-gray-600 prose-p:leading-relaxed
                                prose-strong:text-[#FF7518] prose-strong:font-bold
                                prose-img:rounded-3xl prose-img:shadow-lg">
                                {!! $historyContent->content !!}
                            </article>
                        @else
                            <div class="flex flex-col items-center py-12 text-slate-300">
                                <i class="fas fa-hourglass-half text-4xl mb-4 animate-spin-slow"></i>
                                <p class="italic font-medium">Menyusun data sejarah...</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </section>
    </div>

    <style>
        @keyframes spin-slow {
            from { transform: rotate(0deg); }
            to { transform: rotate(360deg); }
        }
        .animate-spin-slow {
            animation: spin-slow 8s linear infinite;
        }
    </style>
@endsection
