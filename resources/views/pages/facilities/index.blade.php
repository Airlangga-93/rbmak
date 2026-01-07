@extends('layouts.app')

@section('title', 'Katalog Fasilitas - PT. RBM')

@section('content')
    {{-- Resource & Fonts --}}
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>

    @php
        /**
         * Helper untuk mengambil URL gambar yang fleksibel
         */
        function getFacilityImageUrl($facility)
        {
            $default = 'https://images.unsplash.com/photo-1581091226825-a6a2a5aee158?q=80&w=2000';

            if (!$facility || !$facility->image) {
                return $default;
            }

            // 1. Jika URL utuh (http/https)
            if (filter_var($facility->image, FILTER_VALIDATE_URL)) {
                return $facility->image;
            }

            // 2. Jika path dari Seeder (dimulai dengan assets/)
            if (str_starts_with($facility->image, 'assets/')) {
                return asset($facility->image);
            }

            // 3. Jika path lokal dari Upload (Public Storage)
            return asset('storage/' . $facility->image);
        }

        // Ambil data untuk Hero & Dynamic Grid
        $fHero1 = getFacilityImageUrl($facilities->where('type', 'Peralatan Pabrikasi')->first() ?? $facilities->first());
        $fHero2 = getFacilityImageUrl($facilities->where('type', 'Kendaraan Operasional')->first() ?? $facilities->last());

        $fGrid1 = $facilities->skip(0)->first() ? getFacilityImageUrl($facilities->skip(0)->first()) : $fHero1;
        $fGrid2 = $facilities->skip(1)->first() ? getFacilityImageUrl($facilities->skip(1)->first()) : $fHero2;
        $fGrid3 = $facilities->skip(2)->first() ? getFacilityImageUrl($facilities->skip(2)->first()) : $fHero1;
    @endphp

    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; background-color: #fcfcfc; }
        .heading-tight { letter-spacing: -0.04em; }
        .text-orange-main { color: #FF7518; }
        .bg-orange-main { background-color: #FF7518; }
        .bg-navy { background-color: #161f36; }
        @keyframes slow-zoom { 0%, 100% { transform: scale(1); } 50% { transform: scale(1.05); } }
        .animate-slow-zoom { animation: slow-zoom 20s infinite ease-in-out; }
        .no-scrollbar::-webkit-scrollbar { display: none; }
        .no-scrollbar { -ms-overflow-style: none; scrollbar-width: none; }
    </style>

    {{-- 🌌 1. HERO SLIDER --}}
    <section class="relative w-full h-[450px] overflow-hidden">
        <div x-data="{ activeSlide: 1, totalSlides: 2 }" x-init="setInterval(() => { activeSlide = activeSlide % totalSlides + 1 }, 5000)" class="h-full">
            <div x-show="activeSlide === 1" x-transition.opacity.duration.1000ms class="absolute inset-0">
                <img src="{{ $fHero1 }}" class="w-full h-full object-cover animate-slow-zoom">
                <div class="absolute inset-0 bg-[#161f36]/60 flex items-center justify-center">
                    <h2 class="text-white text-4xl md:text-6xl font-extrabold uppercase heading-tight text-center px-4">
                        Industrial <span class="text-orange-main">Facilities</span>
                    </h2>
                </div>
            </div>
            <div x-show="activeSlide === 2" x-transition.opacity.duration.1000ms class="absolute inset-0">
                <img src="{{ $fHero2 }}" class="w-full h-full object-cover animate-slow-zoom">
                <div class="absolute inset-0 bg-[#161f36]/60 flex items-center justify-center">
                    <h2 class="text-white text-4xl md:text-6xl font-extrabold uppercase heading-tight text-center px-4">
                        Operation <span class="text-orange-main">Support</span>
                    </h2>
                </div>
            </div>
        </div>
    </section>

    {{-- 🍞 2. BREADCRUMB --}}
    <div class="bg-[#2D2D2D] py-4">
        <div class="max-w-7xl mx-auto px-6">
            <nav class="flex text-sm font-bold uppercase tracking-widest text-gray-400 items-center">
                <a href="/" class="hover:text-white transition-colors">Home</a>
                <span class="mx-3 text-white">/</span>
                <span class="text-white">Our Facilities</span>
            </nav>
        </div>
    </div>

    {{-- 🏗️ 3. DYNAMIC GRID SECTION --}}
    <section class="py-24 bg-white">
        <div class="max-w-7xl mx-auto px-6">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-16 items-center">
                <div class="flex items-end justify-center lg:justify-start gap-4">
                    <div class="h-48 w-28 rounded-2xl overflow-hidden shadow-xl bg-gray-100">
                        <img src="{{ $fGrid1 }}" class="h-full w-full object-cover">
                    </div>
                    <div class="h-80 w-40 rounded-2xl overflow-hidden shadow-2xl border-4 border-white -mb-10 bg-gray-100">
                        <img src="{{ $fGrid2 }}" class="h-full w-full object-cover">
                    </div>
                    <div class="h-64 w-32 rounded-2xl overflow-hidden shadow-xl bg-gray-100">
                        <img src="{{ $fGrid3 }}" class="h-full w-full object-cover">
                    </div>
                </div>

                <div class="text-center lg:text-left">
                    <div class="w-20 h-1.5 bg-orange-main mb-6 mx-auto lg:mx-0"></div>
                    <h2 class="text-3xl md:text-5xl font-extrabold text-[#161f36] heading-tight uppercase mb-6">Aset & Armada <br> Terstandarisasi</h2>
                    <p class="text-gray-500 leading-relaxed mb-8 font-medium italic">Kami didukung oleh infrastruktur modern dan peralatan kelas industri untuk menjamin presisi di setiap pengerjaan proyek.</p>
                    <div class="flex flex-wrap gap-6 justify-center lg:justify-start">
                        <div class="flex items-center gap-2 font-black text-[#161f36] text-xs uppercase">
                            <i class="fas fa-tools text-orange-main"></i> High Precision
                        </div>
                        <div class="flex items-center gap-2 font-black text-[#161f36] text-xs uppercase">
                            <i class="fas fa-truck-moving text-orange-main"></i> Fast Response
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- 🏷️ 4. STICKY FILTER & CATALOG --}}
    <div x-data="{ activeTab: 'all', search: '' }">
        <section class="py-20 bg-[#fcfcfc]">
            <div class="max-w-7xl mx-auto px-6">

                {{-- Filter bar --}}
                <div class="flex flex-col lg:flex-row gap-6 justify-between items-center mb-16 bg-white p-4 rounded-[2.5rem] shadow-sm border border-gray-100">
                    <div class="relative w-full lg:w-1/3">
                        <i class="fas fa-search absolute left-6 top-1/2 -translate-y-1/2 text-orange-main"></i>
                        <input type="text" x-model="search" placeholder="Cari fasilitas..."
                            class="w-full pl-14 pr-6 py-4 bg-gray-50 border-none rounded-full text-sm focus:ring-2 focus:ring-orange-main/20 font-bold">
                    </div>

                    <div class="flex gap-2 overflow-x-auto no-scrollbar w-full lg:w-auto p-1">
                        <button @click="activeTab = 'all'"
                            :class="activeTab === 'all' ? 'bg-[#161f36] text-white shadow-lg' : 'bg-gray-100 text-gray-500'"
                            class="px-8 py-3 rounded-full text-[10px] font-black uppercase tracking-widest transition-all whitespace-nowrap">Semua</button>
                        <button @click="activeTab = 'Peralatan Pabrikasi'"
                            :class="activeTab === 'Peralatan Pabrikasi' ? 'bg-orange-main text-white shadow-lg' : 'bg-gray-100 text-gray-500'"
                            class="px-8 py-3 rounded-full text-[10px] font-black uppercase tracking-widest transition-all whitespace-nowrap">Pabrikasi</button>
                        <button @click="activeTab = 'Peralatan Maintenance'"
                            :class="activeTab === 'Peralatan Maintenance' ? 'bg-orange-main text-white shadow-lg' : 'bg-gray-100 text-gray-500'"
                            class="px-8 py-3 rounded-full text-[10px] font-black uppercase tracking-widest transition-all whitespace-nowrap">Maintenance</button>
                        <button @click="activeTab = 'Kendaraan Operasional'"
                            :class="activeTab === 'Kendaraan Operasional' ? 'bg-orange-main text-white shadow-lg' : 'bg-gray-100 text-gray-500'"
                            class="px-8 py-3 rounded-full text-[10px] font-black uppercase tracking-widest transition-all whitespace-nowrap">Kendaraan</button>
                    </div>
                </div>

                <div class="space-y-24">
                    @php
                        $categories = [
                            'Peralatan Pabrikasi' => 'Peralatan Pabrikasi',
                            'Peralatan Maintenance' => 'Peralatan Maintenance',
                            'Kendaraan Operasional' => 'Kendaraan Operasional',
                        ];
                    @endphp

                    @foreach ($categories as $label => $dbValue)
                        @php $filtered = $facilities->where('type', $dbValue); @endphp

                        @if ($filtered->count() > 0)
                            <div x-show="activeTab === 'all' || activeTab === '{{ $dbValue }}'" x-transition:enter.duration.500ms>
                                <div class="flex items-center gap-4 mb-10">
                                    <h3 class="text-2xl font-black text-[#161f36] uppercase tracking-tighter">{{ $label }}</h3>
                                    <div class="flex-1 h-[1px] bg-gray-100"></div>
                                    <span class="bg-gray-50 px-4 py-1 rounded-full text-[10px] font-bold text-gray-400 uppercase tracking-widest border border-gray-100">{{ $filtered->count() }} Items</span>
                                </div>

                                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
                                    @foreach ($filtered as $f)
                                        <div x-show="search === '' || '{{ strtolower($f->name) }}'.includes(search.toLowerCase())"
                                            class="group bg-white rounded-[2rem] overflow-hidden border border-gray-50 shadow-sm hover:shadow-2xl transition-all duration-500">
                                            <div class="relative aspect-square overflow-hidden bg-gray-100">
                                                <img src="{{ getFacilityImageUrl($f) }}"
                                                    class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700">
                                            </div>
                                            <div class="p-6">
                                                <h4 class="text-sm font-black text-[#161f36] mb-2 group-hover:text-orange-main transition-colors uppercase leading-tight line-clamp-1">{{ $f->name }}</h4>
                                                <p class="text-gray-400 text-[10px] leading-relaxed mb-6 italic line-clamp-2">"{{ $f->description }}"</p>
                                                <div class="pt-4 border-t border-gray-50 flex justify-between items-center">
                                                    <span class="text-[9px] font-bold text-gray-300 uppercase">ASET-{{ str_pad($f->id, 3, '0', STR_PAD_LEFT) }}</span>
                                                    <a href="{{ route('facilities.show', $f->id) }}"
                                                        class="w-8 h-8 bg-[#161f36] text-white rounded-xl flex items-center justify-center hover:bg-orange-main transition-all">
                                                        <i class="fas fa-chevron-right text-[10px]"></i>
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endif
                    @endforeach
                </div>
            </div>
        </section>
    </div>

    {{-- 📞 5. CTA FINAL --}}
    <section class="pb-24 px-6">
        <div class="max-w-7xl mx-auto bg-[#161f36] rounded-[4rem] p-12 md:p-24 text-center relative overflow-hidden shadow-2xl">
            <div class="absolute -top-24 -right-24 w-96 h-96 bg-orange-main opacity-20 rounded-full blur-[120px]"></div>
            <div class="relative z-10">
                <h2 class="text-3xl md:text-6xl font-extrabold text-white mb-8 uppercase heading-tight">Build with <br>
                    <span class="text-orange-main">Expertise</span>
                </h2>
                <p class="text-gray-400 mb-14 max-w-xl mx-auto font-medium opacity-80 italic">Kualitas hasil kerja ditentukan oleh kualitas alat dan keahlian tim kami.</p>
                <a href="/contact"
                    class="bg-orange-main text-white px-16 py-5 rounded-[2rem] font-black text-xs uppercase tracking-[0.2em] hover:bg-white hover:text-[#161f36] transition-all duration-300 shadow-xl">Contact Us Now</a>
            </div>
        </div>
    </section>
@endsection
