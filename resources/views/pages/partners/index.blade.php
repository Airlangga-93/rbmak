@extends('layouts.app')

@section('title', 'Mitra Industri - PT. Rizqallah Boer Makmur')

@section('content')
    {{-- Library pendukung --}}
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">

    <div class="bg-white min-h-screen font-sans text-[#161f36] selection:bg-[#FF7518]/30"
        x-data="{
            activeSector: 'all',
            search: '',
            isVisible(sector, name) {
                if (!sector) return false;
                const cleanSector = sector.trim().toUpperCase();
                const cleanActive = this.activeSector.trim().toUpperCase();
                const matchSector = this.activeSector === 'all' || cleanSector === cleanActive;
                const matchSearch = name.toLowerCase().includes(this.search.toLowerCase());
                return matchSector && matchSearch;
            }
        }">

        {{-- 🌌 HERO SECTION: BOLD & ARCHITECTURAL --}}
        <section class="relative h-[50vh] min-h-[450px] flex items-center bg-[#161f36] overflow-hidden">
            {{-- Background Elements --}}
            <div class="absolute inset-0 opacity-10" style="background-image: radial-gradient(#FF7518 1px, transparent 1px); background-size: 30px 30px;"></div>
            <div class="absolute top-0 right-0 w-1/2 h-full bg-[#FF7518]/5 -skew-x-12 translate-x-1/4"></div>

            <div class="container mx-auto px-6 relative z-10">
                <div class="max-w-4xl">
                    <div class="inline-flex items-center gap-3 px-4 py-2 rounded-full bg-white/10 backdrop-blur-md border border-white/20 mb-8" data-aos="fade-down">
                        <span class="w-2 h-2 bg-[#FF7518] rounded-full animate-ping"></span>
                        <span class="text-[10px] font-black text-white uppercase tracking-[0.4em]">Global Network</span>
                    </div>
                    <h1 class="text-5xl md:text-7xl font-black text-white leading-[0.85] uppercase tracking-tighter mb-8" data-aos="fade-right">
                        Trusted <br><span class="text-[#FF7518]">Partnership</span>
                    </h1>
                    <p class="text-slate-400 text-lg md:text-xl max-w-2xl font-medium leading-relaxed border-l-4 border-[#FF7518] pl-6" data-aos="fade-up" data-aos-delay="200">
                        Sinergi strategis bersama pemegang lisensi infrastruktur dan penyedia solusi teknologi terdepan di Indonesia.
                    </p>
                </div>
            </div>
        </section>

        {{-- 🛠️ SMART CONTROL BAR --}}
        <section class="relative z-30 -mt-12">
            <div class="container mx-auto px-6">
                <div class="bg-white rounded-[2.5rem] shadow-[0_20px_60px_-15px_rgba(0,0,0,0.1)] border border-slate-100 p-4 md:p-6" data-aos="zoom-in">
                    <div class="flex flex-col lg:flex-row items-center justify-between gap-8">
                        {{-- Filter Tabs --}}
                        <div class="flex flex-wrap justify-center gap-2 p-1.5 bg-slate-50 rounded-2xl w-full lg:w-auto">
                            <button @click="activeSector = 'all'"
                                :class="activeSector === 'all' ? 'bg-[#161f36] text-white shadow-lg scale-105' : 'text-slate-400 hover:text-[#161f36]'"
                                class="px-8 py-3 rounded-xl text-[10px] font-black uppercase tracking-widest transition-all duration-300">
                                All Partners
                            </button>
                            <button @click="activeSector = 'TOWER PROVIDER'"
                                :class="activeSector === 'TOWER PROVIDER' ? 'bg-[#FF7518] text-white shadow-lg scale-105' : 'text-slate-400 hover:text-[#161f36]'"
                                class="px-8 py-3 rounded-xl text-[10px] font-black uppercase tracking-widest transition-all duration-300">
                                Tower Provider
                            </button>
                            <button @click="activeSector = 'NON TOWER PROVIDER'"
                                :class="activeSector === 'NON TOWER PROVIDER' ? 'bg-[#FF7518] text-white shadow-lg scale-105' : 'text-slate-400 hover:text-[#161f36]'"
                                class="px-8 py-3 rounded-xl text-[10px] font-black uppercase tracking-widest transition-all duration-300">
                                Non-Tower
                            </button>
                        </div>

                        {{-- Search Input --}}
                        <div class="relative w-full lg:w-96 group">
                            <input type="text" x-model="search" placeholder="Cari Nama Perusahaan..."
                                class="w-full pl-14 pr-6 py-4 rounded-2xl bg-slate-50 border-transparent focus:bg-white focus:ring-2 focus:ring-[#FF7518]/20 focus:border-[#FF7518] text-sm font-bold tracking-tight transition-all">
                            <i class="fas fa-search absolute left-6 top-1/2 -translate-y-1/2 text-slate-300 group-focus-within:text-[#FF7518] transition-colors"></i>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        {{-- 📦 PARTNERS GRID --}}
        <section class="py-24 bg-slate-50/50">
            <div class="container mx-auto px-6">
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-8">
                    @forelse ($partners as $partner)
                        <div x-show="isVisible('{{ $partner->sector }}', '{{ $partner->name }}')"
                            x-transition:enter="transition ease-out duration-400"
                            x-transition:enter-start="opacity-0 translate-y-8"
                            x-transition:enter-end="opacity-100 translate-y-0"
                            class="group bg-white rounded-[3rem] border border-slate-100 p-8 shadow-sm hover:shadow-2xl hover:-translate-y-4 transition-all duration-500 flex flex-col h-full"
                            data-aos="fade-up" x-cloak>

                            {{-- Logo Container --}}
                            <div class="relative w-full h-48 mb-8 bg-slate-50 rounded-[2.5rem] p-8 flex items-center justify-center overflow-hidden border border-slate-50 transition-colors group-hover:bg-white">
                                {{-- Background Pattern inside logo box --}}
                                <div class="absolute inset-0 opacity-[0.03] group-hover:opacity-[0.07] transition-opacity" style="background-image: url('https://www.transparenttextures.com/patterns/carbon-fibre.png');"></div>

                                @php
                                    $logoPath = $partner->logo;
                                    $finalUrl = $logoPath ? (Str::startsWith($logoPath, ['http', 'cloudinary']) ? $logoPath : (Str::startsWith($logoPath, 'assets/') ? asset($logoPath) : asset('storage/' . $logoPath))) : null;
                                @endphp

                                @if ($finalUrl)
                                    <img src="{{ $finalUrl }}"
                                        class="max-h-full max-w-full object-contain transition-all duration-700 group-hover:scale-110 relative z-10"
                                        alt="{{ $partner->name }}">
                                @else
                                    <div class="text-slate-200 flex flex-col items-center relative z-10">
                                        <i class="fas fa-industry text-5xl mb-3"></i>
                                        <span class="text-[9px] font-black uppercase tracking-widest text-slate-300">No Logo</span>
                                    </div>
                                @endif
                            </div>

                            {{-- Info Content --}}
                            <div class="flex-grow flex flex-col">
                                <div class="flex items-center gap-3 mb-4">
                                    <span class="w-2 h-2 rounded-full {{ strtoupper(trim($partner->sector)) === 'TOWER PROVIDER' ? 'bg-blue-500' : 'bg-[#FF7518]' }}"></span>
                                    <span class="text-[10px] font-black uppercase tracking-[0.2em] text-slate-400">{{ $partner->sector }}</span>
                                </div>

                                <h3 class="text-xl font-black text-[#161f36] uppercase tracking-tighter leading-tight mb-4 group-hover:text-[#FF7518] transition-colors">
                                    {{ $partner->name }}
                                </h3>

                                <p class="text-slate-500 text-sm leading-relaxed line-clamp-3 font-medium mb-6">
                                    {{ $partner->description ?? 'Mitra strategis dalam pengembangan dan pemeliharaan infrastruktur telekomunikasi nasional.' }}
                                </p>

                                {{-- Footer --}}
                                <div class="mt-auto pt-6 border-t border-slate-50 flex items-center justify-between">
                                    <div class="flex items-center gap-2">
                                        <i class="fas fa-map-marker-alt text-[10px] text-[#FF7518]"></i>
                                        <span class="text-[11px] font-bold text-slate-400 uppercase tracking-tight">{{ $partner->city ?? 'Indonesia' }}</span>
                                    </div>
                                    <a href="{{ route('partners.show', $partner->id) }}" class="w-12 h-12 rounded-2xl bg-slate-50 text-[#161f36] flex items-center justify-center group-hover:bg-[#161f36] group-hover:text-white transition-all duration-300 transform group-hover:rotate-12">
                                        <i class="fas fa-arrow-right text-xs"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="col-span-full py-32 text-center">
                            <div class="inline-block p-10 bg-white rounded-[3rem] shadow-xl border border-slate-100">
                                <i class="fas fa-search text-5xl text-slate-100 mb-6 block"></i>
                                <h3 class="text-xl font-black text-slate-300 uppercase tracking-widest">Partner Not Found</h3>
                                <p class="text-slate-400 text-xs mt-2 uppercase tracking-widest">Coba gunakan kata kunci pencarian lain.</p>
                            </div>
                        </div>
                    @endforelse
                </div>
            </div>
        </section>

        {{-- 📢 CALL TO ACTION --}}
        <section class="py-24 bg-white">
            <div class="container mx-auto px-6">
                <div class="relative bg-[#161f36] rounded-[4rem] p-12 md:p-20 text-center overflow-hidden">
                    {{-- Decorative Blur --}}
                    <div class="absolute -top-24 -left-24 w-64 h-64 bg-[#FF7518]/20 rounded-full blur-[100px]"></div>

                    <div class="relative z-10 max-w-3xl mx-auto">
                        <h2 class="text-4xl md:text-5xl font-black text-white uppercase tracking-tighter mb-8">
                            Bangun Konektivitas <br> <span class="text-[#FF7518]">Bersama PT. RBM</span>
                        </h2>
                        <p class="text-slate-400 text-lg mb-12 font-medium italic">
                            "Menyatukan keahlian teknis dan integritas layanan untuk masa depan digital Indonesia."
                        </p>
                        <a href="{{ route('contact') }}" class="inline-flex items-center gap-4 bg-[#FF7518] text-white px-12 py-5 rounded-2xl font-black text-[11px] uppercase tracking-[0.3em] shadow-xl shadow-orange-500/20 hover:bg-white hover:text-[#161f36] transition-all duration-500">
                            Join Our Network
                            <i class="fas fa-handshake"></i>
                        </a>
                    </div>
                </div>
            </div>
        </section>
    </div>

    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            AOS.init({ duration: 1000, once: true, easing: 'ease-out-quint' });
        });
    </script>
    <style>
        [x-cloak] { display: none !important; }
        .line-clamp-3 {
            display: -webkit-box;
            -webkit-line-clamp: 3;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }
    </style>
@endsection
