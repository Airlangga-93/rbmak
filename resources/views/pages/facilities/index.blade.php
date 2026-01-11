@extends('layouts.app')

@section('title', 'Katalog Fasilitas - PT. RBM')

@section('content')
    {{-- Resource & Fonts --}}
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>

    @php
        /**
         * Helper untuk mengambil URL gambar yang fleksibel
         */
        if (!function_exists('getFacilityImageUrl')) {
            function getFacilityImageUrl($facility)
            {
                $default = 'https://images.unsplash.com/photo-1581091226825-a6a2a5aee158?q=80&w=2000';

                if (!$facility || !$facility->image) {
                    return $default;
                }

                // Jika sudah berupa URL utuh
                if (filter_var($facility->image, FILTER_VALIDATE_URL)) {
                    return $facility->image;
                }

                // Cek di folder public (untuk data dari Seeder: assets/img/...)
                if (file_exists(public_path($facility->image))) {
                    return asset($facility->image);
                }

                // Cek di folder storage (untuk data dari Upload)
                return asset('storage/' . $facility->image);
            }
        }

        // Ambil data untuk Hero & Dynamic Grid berdasarkan tipe di Seeder (huruf kecil)
        $fHero1 = getFacilityImageUrl($facilities->where('type', 'pabrikasi')->first() ?? $facilities->first());
        $fHero2 = getFacilityImageUrl($facilities->where('type', 'kendaraan')->first() ?? $facilities->last());

        $fGrid1 = $facilities->values()->get(0) ? getFacilityImageUrl($facilities->values()->get(0)) : $fHero1;
        $fGrid2 = $facilities->values()->get(1) ? getFacilityImageUrl($facilities->values()->get(1)) : $fHero2;
        $fGrid3 = $facilities->values()->get(2) ? getFacilityImageUrl($facilities->values()->get(2)) : $fHero1;
    @endphp

    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background-color: #fcfcfc;
        }

        .heading-tight {
            letter-spacing: -0.04em;
        }

        .text-orange-main {
            color: #FF7518;
        }

        .bg-orange-main {
            background-color: #FF7518;
        }

        .animate-slow-zoom {
            animation: slow-zoom 20s infinite ease-in-out;
        }

        @keyframes slow-zoom {

            0%,
            100% {
                transform: scale(1);
            }

            50% {
                transform: scale(1.05);
            }
        }

        .no-scrollbar::-webkit-scrollbar {
            display: none;
        }

        [x-cloak] {
            display: none !important;
        }
    </style>

    {{-- 🌌 1. HERO SLIDER --}}
    <section class="relative w-full h-[450px] overflow-hidden">
        <div x-data="{ activeSlide: 1, totalSlides: 2 }" x-init="setInterval(() => { activeSlide = activeSlide % totalSlides + 1 }, 5000)" class="h-full">
            <div x-show="activeSlide === 1" x-transition.opacity.duration.1000ms class="absolute inset-0">
                <img src="{{ $fHero1 }}" class="w-full h-full object-cover animate-slow-zoom">
                <div class="absolute inset-0 bg-[#161f36]/60 flex items-center justify-center">
                    <h2 class="text-white text-4xl md:text-6xl font-extrabold uppercase text-center px-4">
                        Industrial <span class="text-orange-main">Facilities</span>
                    </h2>
                </div>
            </div>
            <div x-show="activeSlide === 2" x-transition.opacity.duration.1000ms class="absolute inset-0" x-cloak>
                <img src="{{ $fHero2 }}" class="w-full h-full object-cover animate-slow-zoom">
                <div class="absolute inset-0 bg-[#161f36]/60 flex items-center justify-center">
                    <h2 class="text-white text-4xl md:text-6xl font-extrabold uppercase text-center px-4">
                        Operation <span class="text-orange-main">Support</span>
                    </h2>
                </div>
            </div>
        </div>
    </section>

    {{-- 🍞 2. BREADCRUMB --}}
    <div class="bg-[#2D2D2D] py-4">
        <div class="max-w-7xl mx-auto px-6">
            <nav class="flex text-sm font-bold uppercase text-gray-400 items-center">
                <a href="/" class="hover:text-white transition-colors">Home</a>
                <span class="mx-3 text-white">/</span>
                <span class="text-white">Our Facilities</span>
            </nav>
        </div>
    </div>

    {{-- 🏗️ 3. DYNAMIC GRID --}}
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
                    <h2 class="text-3xl md:text-5xl font-extrabold text-[#161f36] uppercase mb-6">Aset & Armada <br>
                        Terstandarisasi</h2>
                    <p class="text-gray-500 italic mb-8">Infrastruktur modern dan peralatan kelas industri untuk menjamin
                        presisi setiap proyek.</p>
                </div>
            </div>
        </div>
    </section>

    {{-- 🏷️ 4. CATALOG DENGAN FILTER --}}
    <div x-data="{ activeTab: 'all', search: '' }">
        <section class="py-20 bg-[#fcfcfc]">
            <div class="max-w-7xl mx-auto px-6">

                {{-- Bar Filter --}}
                <div
                    class="flex flex-col lg:flex-row gap-6 justify-between items-center mb-16 bg-white p-4 rounded-[2.5rem] shadow-sm">
                    <div class="relative w-full lg:w-1/3">
                        <i class="fas fa-search absolute left-6 top-1/2 -translate-y-1/2 text-orange-main"></i>
                        <input type="text" x-model="search" placeholder="Cari fasilitas..."
                            class="w-full pl-14 pr-6 py-4 bg-gray-50 border-none rounded-full text-sm font-bold focus:ring-2 focus:ring-orange-main/20">
                    </div>

                    <div class="flex gap-2 overflow-x-auto no-scrollbar w-full lg:w-auto">
                        <button @click="activeTab = 'all'"
                            :class="activeTab === 'all' ? 'bg-[#161f36] text-white' : 'bg-gray-100 text-gray-500'"
                            class="px-8 py-3 rounded-full text-[10px] font-black uppercase whitespace-nowrap transition-all">Semua</button>
                        <button @click="activeTab = 'pabrikasi'"
                            :class="activeTab === 'pabrikasi' ? 'bg-orange-main text-white' : 'bg-gray-100 text-gray-500'"
                            class="px-8 py-3 rounded-full text-[10px] font-black uppercase whitespace-nowrap transition-all">Pabrikasi</button>
                        <button @click="activeTab = 'maintenance'"
                            :class="activeTab === 'maintenance' ? 'bg-orange-main text-white' : 'bg-gray-100 text-gray-500'"
                            class="px-8 py-3 rounded-full text-[10px] font-black uppercase whitespace-nowrap transition-all">Maintenance</button>
                        <button @click="activeTab = 'kendaraan'"
                            :class="activeTab === 'kendaraan' ? 'bg-orange-main text-white' : 'bg-gray-100 text-gray-500'"
                            class="px-8 py-3 rounded-full text-[10px] font-black uppercase whitespace-nowrap transition-all">Kendaraan</button>
                    </div>
                </div>

                {{-- Loop Kategori --}}
                <div class="space-y-24">
                    @php
                        // Menyesuaikan key dengan 'type' di Seeder Anda
                        $categories = [
                            'Pabrikasi' => 'pabrikasi',
                            'Maintenance' => 'maintenance',
                            'Kendaraan Operasional' => 'kendaraan',
                        ];
                    @endphp

                    @foreach ($categories as $label => $typeValue)
                        @php $filtered = $facilities->where('type', $typeValue); @endphp

                        @if ($filtered->count() > 0)
                            <div x-show="activeTab === 'all' || activeTab === '{{ $typeValue }}'" x-transition x-cloak>
                                <div class="flex items-center gap-4 mb-10">
                                    <h3 class="text-2xl font-black text-[#161f36] uppercase">{{ $label }}</h3>
                                    <div class="flex-1 h-[1px] bg-gray-200"></div>
                                    <span class="text-[10px] font-bold text-gray-400">{{ $filtered->count() }} Items</span>
                                </div>

                                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
                                    @foreach ($filtered as $f)
                                        <div x-show="search === '' || '{{ strtolower($f->name) }}'.includes(search.toLowerCase())"
                                            class="group bg-white rounded-[2rem] overflow-hidden border border-gray-100 shadow-sm hover:shadow-xl transition-all duration-500">
                                            <div class="relative aspect-square overflow-hidden bg-gray-200">
                                                <img src="{{ getFacilityImageUrl($f) }}"
                                                    class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700">
                                            </div>
                                            <div class="p-6">
                                                <h4
                                                    class="text-sm font-black text-[#161f36] mb-2 uppercase group-hover:text-orange-main line-clamp-1">
                                                    {{ $f->name }}</h4>
                                                <p class="text-gray-400 text-[10px] italic line-clamp-2 mb-6">
                                                    "{{ $f->description }}"</p>
                                                <div class="pt-4 border-t border-gray-50 flex justify-between items-center">
                                                    <span class="text-[9px] font-bold text-gray-300">ID:
                                                        {{ $f->id }}</span>
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

    {{-- 📞 5. CTA --}}
    <section class="pb-24 px-6">
        <div
            class="max-w-7xl mx-auto bg-[#161f36] rounded-[3rem] md:rounded-[4rem] p-10 md:p-24 text-center relative overflow-hidden shadow-2xl">
            <h2 class="text-3xl md:text-6xl font-extrabold text-white mb-8 uppercase">
                Build with <span class="text-orange-main">Expertise</span>
            </h2>

            {{-- Tombol dengan ukuran responsif (px-8 di HP, px-16 di Laptop) --}}
            <a href="/contact"
                class="inline-block bg-orange-main text-white px-8 md:px-16 py-4 md:py-5 rounded-full font-black text-[10px] md:text-xs uppercase tracking-widest hover:bg-white hover:text-[#161f36] transition-all shadow-xl whitespace-nowrap">
                Contact Us Now
            </a>
        </div>
    </section>
@endsection
