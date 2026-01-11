@extends('layouts.app')

@section('title', 'Katalog Layanan & Infrastruktur - PT. RBM')

@section('content')
    {{-- Resource & Fonts --}}
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>

    @php
        /**
         * 🛠️ LOGIKA SMART IMAGE HANDLER
         */
        $getImg = function($path) {
            if (!$path) return 'https://images.unsplash.com/photo-1544380904-c686119ec4f5?q=80&w=2000';
            
            if (filter_var($path, FILTER_VALIDATE_URL)) return $path;
            
            if (str_starts_with($path, 'assets/')) return asset($path);
            
            return asset('storage/' . $path);
        };

        $photos = $items->map(fn($item) => $getImg($item->image))->toArray();

        $heroImage1 = $photos[0] ?? 'https://images.unsplash.com/photo-1504307651254-35680f356dfd?q=80&w=2000';
        $heroImage2 = $photos[1] ?? 'https://images.unsplash.com/photo-1581092160562-40aa08e78837?q=80&w=2000';
        $heroImage3 = $photos[2] ?? 'https://images.unsplash.com/photo-1486406146926-c627a92ad1ab?q=80&w=2000';

        $gridPhoto1 = $photos[0] ?? $heroImage1;
        $gridPhoto2 = $photos[1] ?? $heroImage2;
        $gridPhoto3 = $photos[2] ?? $heroImage3;
    @endphp

    {{-- 🌌 1. HERO SLIDER --}}
    <section class="relative w-full h-[650px] overflow-hidden bg-[#161f36] font-['Plus_Jakarta_Sans']">
        <div x-data="{ activeSlide: 1, totalSlides: 3 }"
             x-init="setInterval(() => { activeSlide = activeSlide % totalSlides + 1 }, 7000)"
             class="h-full">

            <div x-show="activeSlide === 1"
                 x-transition:enter="transition opacity duration-1000"
                 x-transition:leave="transition opacity duration-1000"
                 class="absolute inset-0">
                <img src="{{ $heroImage1 }}" class="w-full h-full object-cover opacity-50 scale-110 transition-transform duration-[15000ms] ease-in-out" :class="activeSlide === 1 ? 'scale-100' : 'scale-110'">
                <div class="absolute inset-0 bg-gradient-to-t from-[#161f36] via-transparent flex items-center">
                    <div class="max-w-7xl mx-auto px-8 w-full">
                        <span class="inline-block px-4 py-1.5 bg-[#FF7518] text-white text-[10px] font-black uppercase tracking-[0.3em] mb-6 rounded-lg">Premium Infrastructure</span>
                        <h2 class="text-white text-5xl md:text-8xl font-black uppercase leading-[0.9] max-w-3xl tracking-[-0.05em]">
                            Built to <br><span class="text-[#FF7518]">Last</span>
                        </h2>
                    </div>
                </div>
            </div>

            <div x-show="activeSlide === 2"
                 x-transition:enter="transition opacity duration-1000"
                 x-transition:leave="transition opacity duration-1000"
                 class="absolute inset-0" x-cloak>
                <img src="{{ $heroImage2 }}" class="w-full h-full object-cover opacity-50 scale-110 transition-transform duration-[15000ms] ease-in-out" :class="activeSlide === 2 ? 'scale-100' : 'scale-110'">
                <div class="absolute inset-0 bg-gradient-to-t from-[#161f36] via-transparent flex items-center">
                    <div class="max-w-7xl mx-auto px-8 w-full">
                        <span class="inline-block px-4 py-1.5 bg-[#FF7518] text-white text-[10px] font-black uppercase tracking-[0.3em] mb-6 rounded-lg">Industrial Solution</span>
                        <h2 class="text-white text-5xl md:text-8xl font-black uppercase leading-[0.9] max-w-3xl tracking-[-0.05em]">
                            Power <br><span class="text-[#FF7518]">Connectivity</span>
                        </h2>
                    </div>
                </div>
            </div>

            <div x-show="activeSlide === 3"
                 x-transition:enter="transition opacity duration-1000"
                 x-transition:leave="transition opacity duration-1000"
                 class="absolute inset-0" x-cloak>
                <img src="{{ $heroImage3 }}" class="w-full h-full object-cover opacity-50 scale-110 transition-transform duration-[15000ms] ease-in-out" :class="activeSlide === 3 ? 'scale-100' : 'scale-110'">
                <div class="absolute inset-0 bg-gradient-to-t from-[#161f36] via-transparent flex items-center">
                    <div class="max-w-7xl mx-auto px-8 w-full">
                        <span class="inline-block px-4 py-1.5 bg-[#FF7518] text-white text-[10px] font-black uppercase tracking-[0.3em] mb-6 rounded-lg">Expert Support</span>
                        <h2 class="text-white text-5xl md:text-8xl font-black uppercase leading-[0.9] max-w-3xl tracking-[-0.05em]">
                            Quality <br><span class="text-[#FF7518]">Materials</span>
                        </h2>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- 🍞 2. BREADCRUMB --}}
    <div class="bg-[#111827] py-5 font-['Plus_Jakarta_Sans']">
        <div class="max-w-7xl mx-auto px-8">
            <nav class="flex items-center gap-4 text-[10px] font-black uppercase tracking-[0.2em]">
                <a href="/" class="text-white/40 hover:text-[#FF7518] transition-colors">Home</a>
                <i class="fas fa-chevron-right text-[7px] text-[#FF7518]"></i>
                <span class="text-white">Our Collections</span>
            </nav>
        </div>
    </div>

    {{-- 🏗️ 3. DYNAMIC GRID SECTION (PERBAIKAN ESTETIKA FOTO & RESPONSIVE HP) --}}
    <section class="py-20 lg:py-32 bg-white relative overflow-hidden font-['Plus_Jakarta_Sans']">
        <div class="max-w-7xl mx-auto px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-16 lg:gap-24 items-center">
                
                {{-- FOTO SECTION: Diperbaiki agar rapi di HP dan estetik di Laptop --}}
                <div class="relative flex justify-center items-center h-[350px] lg:h-[500px]">
                    <div class="absolute left-0 lg:left-0 w-32 lg:w-44 h-52 lg:h-72 rounded-[2rem] overflow-hidden shadow-xl -rotate-6 z-0 border-4 border-white transition-transform hover:rotate-0 duration-500">
                        <img src="{{ $gridPhoto1 }}" class="h-full w-full object-cover">
                    </div>
                    
                    <div class="absolute z-20 w-48 lg:w-64 h-64 lg:h-[28rem] rounded-[2.5rem] overflow-hidden shadow-2xl border-[6px] lg:border-[10px] border-white ring-1 ring-slate-100">
                        <img src="{{ $gridPhoto2 }}" class="h-full w-full object-cover scale-105 hover:scale-110 transition-transform duration-700">
                        <div class="absolute inset-0 bg-gradient-to-t from-black/30 to-transparent"></div>
                    </div>

                    <div class="absolute right-0 lg:right-10 w-32 lg:w-44 h-52 lg:h-72 rounded-[2rem] overflow-hidden shadow-xl rotate-6 z-10 border-4 border-white transition-transform hover:rotate-0 duration-500">
                        <img src="{{ $gridPhoto3 }}" class="h-full w-full object-cover">
                    </div>
                </div>

                <div class="text-center lg:text-left space-y-8">
                    <div class="inline-flex items-center gap-3">
                        <span class="w-12 h-[3px] bg-[#FF7518]"></span>
                        <span class="text-[12px] font-black text-[#FF7518] uppercase tracking-[0.3em]">Quality Assurance</span>
                    </div>
                    <h2 class="text-4xl md:text-6xl font-black text-[#161f36] leading-[1.1] uppercase tracking-[-0.05em]">
                        Infrastruktur <br> Tanpa Kompromi
                    </h2>
                    <p class="text-slate-500 leading-relaxed font-medium text-lg max-w-xl mx-auto lg:mx-0">
                        Kami mengintegrasikan teknologi terkini dengan material grade-A untuk memastikan aset telekomunikasi Anda bertahan puluhan tahun.
                    </p>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 pt-4">
                        <div class="flex items-center justify-center lg:justify-start gap-4 font-black text-[#161f36] text-sm uppercase tracking-tight group cursor-default">
                            <span class="w-12 h-12 rounded-2xl bg-slate-50 flex items-center justify-center text-[#FF7518] shadow-sm group-hover:bg-[#FF7518] group-hover:text-white transition-all duration-300">
                                <i class="fas fa-shield-halved"></i>
                            </span>
                            Durabilitas Standar Internasional
                        </div>
                        <div class="flex items-center justify-center lg:justify-start gap-4 font-black text-[#161f36] text-sm uppercase tracking-tight group cursor-default">
                            <span class="w-12 h-12 rounded-2xl bg-slate-50 flex items-center justify-center text-[#FF7518] shadow-sm group-hover:bg-[#FF7518] group-hover:text-white transition-all duration-300">
                                <i class="fas fa-tools"></i>
                            </span>
                            Pengerjaan Presisi Tinggi
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- 🏷️ 4. CATALOG SECTION --}}
    <section class="py-24 bg-[#F8FAFC] font-['Plus_Jakarta_Sans']" x-data="{ activeTab: 'all' }">
        <div class="max-w-7xl mx-auto px-8">
            <div class="flex flex-col md:flex-row justify-between items-end mb-20 gap-8 border-b border-slate-200 pb-12">
                <div class="max-w-md">
                    <h2 class="text-4xl font-black text-[#161f36] uppercase tracking-tighter">Katalog <span class="text-[#FF7518]">Unggulan</span></h2>
                    <p class="text-slate-400 mt-3 font-bold text-xs uppercase tracking-widest leading-relaxed">Solusi infrastruktur yang dapat disesuaikan dengan kebutuhan proyek Anda.</p>
                </div>
                <div class="flex gap-2 bg-white p-2 rounded-2xl shadow-sm border border-slate-100 overflow-x-auto no-scrollbar">
                    @foreach(['all' => 'Semua', 'barang' => 'Barang', 'jasa' => 'Jasa'] as $key => $label)
                        <button @click="activeTab = '{{ $key }}'"
                                :class="activeTab === '{{ $key }}' ? 'bg-[#161f36] text-white shadow-lg shadow-slate-900/20' : 'text-slate-400 hover:text-[#161f36]'"
                                class="px-8 py-3 rounded-xl text-[10px] font-black uppercase transition-all duration-300 tracking-widest whitespace-nowrap">
                            {{ $label }}
                        </button>
                    @endforeach
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-10">
                @forelse ($items as $item)
                    <div x-show="activeTab === 'all' || activeTab === '{{ strtolower($item->type) }}'"
                         x-transition:enter="transition ease-out duration-500 transform"
                         x-transition:enter-start="opacity-0 translate-y-12"
                         x-transition:enter-end="opacity-100 translate-y-0"
                         class="group bg-white rounded-[2.5rem] overflow-hidden shadow-sm hover:shadow-2xl hover:-translate-y-2 transition-all duration-500 border border-slate-100">

                        <div class="relative h-80 overflow-hidden bg-slate-200">
                            <img src="{{ $getImg($item->image) }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-1000">
                            <div class="absolute top-6 left-6">
                                <span class="bg-white/95 backdrop-blur-md px-4 py-2 rounded-xl text-[9px] font-black uppercase text-[#161f36] shadow-xl tracking-widest">
                                    {{ $item->type }}
                                </span>
                            </div>
                        </div>

                        <div class="p-10">
                            <h3 class="text-2xl font-black text-[#161f36] mb-3 group-hover:text-[#FF7518] transition-colors line-clamp-1">{{ $item->name }}</h3>
                            <p class="text-slate-400 text-sm leading-relaxed line-clamp-2 mb-8 font-medium italic">
                                {{ $item->description }}
                            </p>

                            <div class="flex justify-between items-center pt-8 border-t border-slate-50">
                                <div>
                                    <p class="text-[9px] font-black text-slate-300 uppercase tracking-widest mb-1">Estimasi Biaya</p>
                                    <span class="text-[#161f36] font-black text-xl tracking-tight">Rp {{ number_format($item->price, 0, ',', '.') }}</span>
                                </div>
                                <a href="{{ route('product.show', $item->id) }}" class="w-14 h-14 bg-slate-50 rounded-2xl flex items-center justify-center text-[#161f36] hover:bg-[#FF7518] hover:text-white transition-all duration-300 shadow-inner">
                                    <i class="fas fa-arrow-right-long"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-span-full py-20 text-center">
                        <i class="fas fa-box-open text-6xl text-slate-100 mb-6"></i>
                        <p class="text-slate-400 font-black uppercase tracking-[0.3em] text-sm">Belum ada item katalog tersedia</p>
                    </div>
                @endforelse
            </div>
        </div>
    </section>

    {{-- 📞 5. CTA FINAL --}}
    <section class="py-24 px-8 font-['Plus_Jakarta_Sans']">
        <div class="max-w-7xl mx-auto bg-[#161f36] rounded-[4rem] p-16 md:p-32 text-center relative overflow-hidden shadow-2xl">
            <div class="absolute -top-24 -right-24 w-96 h-96 bg-[#FF7518] opacity-10 rounded-full blur-[100px]"></div>
            <div class="absolute -bottom-24 -left-24 w-96 h-96 bg-blue-600 opacity-10 rounded-full blur-[100px]"></div>

            <div class="relative z-10 space-y-10">
                <h2 class="text-4xl md:text-7xl font-black text-white leading-[1] uppercase tracking-[-0.05em]">
                    Elevating <br> <span class="text-[#FF7518]">Connectivity</span>
                </h2>
                <p class="text-white/50 max-w-2xl mx-auto font-medium leading-relaxed text-lg">
                    Mari bangun masa depan telekomunikasi Indonesia bersama PT. RBM. Hubungi kami untuk konsultasi infrastruktur hari ini.
                </p>
                <div class="pt-4">
                    <a href="{{ route('booking.index') }}" class="inline-flex items-center gap-4 bg-[#FF7518] text-white px-14 py-6 rounded-[2rem] font-black text-[11px] uppercase tracking-[0.3em] hover:bg-white hover:text-[#161f36] transition-all duration-500 shadow-2xl shadow-orange-600/30">
                        <i class="fas fa-calendar-check"></i>
                        Book Project Now
                    </a>
                </div>
            </div>
        </div>
    </section>

    <style>
        [x-cloak] { display: none !important; }
        .no-scrollbar::-webkit-scrollbar { display: none; }
        .no-scrollbar { -ms-overflow-style: none; scrollbar-width: none; }
    </style>
@endsection