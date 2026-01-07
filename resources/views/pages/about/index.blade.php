@extends('layouts.app')

@section('content')
    @php
        $hasImages = isset($mainImages) && $mainImages->isNotEmpty();

        $aboutLinks = [
            [
                'title' => 'Sejarah Perusahaan',
                'description' => 'Dedikasi kami dalam membangun konektivitas bangsa sejak awal berdiri.',
                'url' => '/history',
                'icon' => 'fa-history',
                'accent' => 'from-blue-600 to-blue-800'
            ],
            [
                'title' => 'Visi & Misi',
                'description' => 'Target strategis kami untuk menjadi pilar utama infrastruktur digital.',
                'url' => '/vision',
                'icon' => 'fa-bullseye',
                'accent' => 'from-orange-500 to-red-600'
            ],
        ];
    @endphp

    <div class="bg-slate-50 min-h-screen">
        {{-- HERO SECTION WITH DYNAMIC SLIDER --}}
        <section class="relative h-[60vh] md:h-[70vh] overflow-hidden bg-[#161f36]">
            @if ($hasImages)
                <div x-data="{ activeSlide: 1, totalSlides: {{ $mainImages->count() }} }" x-init="setInterval(() => { activeSlide = activeSlide % totalSlides + 1 }, 5000)" class="h-full">
                    @foreach ($mainImages as $image)
                        <div x-show="activeSlide === {{ $loop->iteration }}"
                             x-transition:enter="transition ease-out duration-1000" x-transition:enter-start="opacity-0 scale-105"
                             x-transition:enter-end="opacity-100 scale-100" x-transition:leave="transition ease-in duration-1000"
                             x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
                             class="absolute inset-0">
                            <img src="{{ Str::contains($image->path, 'http') ? $image->path : Storage::url($image->path) }}"
                                 alt="Hero Image" class="w-full h-full object-cover">
                            <div class="absolute inset-0 bg-gradient-to-b from-transparent via-[#161f36]/40 to-[#161f36]"></div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="absolute inset-0 bg-gradient-to-br from-blue-900 via-[#161f36] to-slate-900">
                    <div class="absolute inset-0 opacity-10" style="background-image: url('https://www.transparenttextures.com/patterns/carbon-fibre.png');"></div>
                </div>
            @endif

            {{-- BREADCRUMB OVERLAY --}}
            <div class="absolute bottom-0 left-0 w-full z-20">
                <div class="max-w-screen-xl mx-auto px-4 sm:px-6 lg:px-8 pb-10">
                    <nav class="flex mb-4" aria-label="Breadcrumb">
                        <ol class="inline-flex items-center space-x-3 bg-white/10 backdrop-blur-md px-6 py-3 rounded-2xl border border-white/10 shadow-2xl">
                            <li class="inline-flex items-center">
                                <a href="/" class="text-sm font-medium text-slate-300 hover:text-white transition-colors">Home</a>
                            </li>
                            <li class="flex items-center gap-3">
                                <i class="fas fa-chevron-right text-[10px] text-[#FF7518]"></i>
                                <span class="text-sm font-bold text-white tracking-wide">About Us</span>
                            </li>
                        </ol>
                    </nav>
                    <h1 class="text-4xl md:text-6xl font-black text-white">Tentang <span class="text-[#FF7518]">Kami.</span></h1>
                </div>
            </div>
        </section>

        {{-- MAIN CONTENT: FEATURES --}}
        <section class="relative z-30 -mt-10">
            <div class="max-w-screen-xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="bg-white rounded-[3rem] shadow-xl p-8 md:p-16 border border-slate-100">
                    <div class="grid grid-cols-1 lg:grid-cols-12 gap-16 items-start">

                        {{-- Sisi Kiri: Headline --}}
                        <div class="lg:col-span-5">
                            <div class="w-16 h-1.5 bg-[#FF7518] mb-8 rounded-full"></div>
                            <h2 class="text-3xl md:text-4xl font-black text-[#161f36] leading-tight mb-6">
                                Membangun Pondasi <br>Masa Depan Digital Indonesia
                            </h2>
                            <p class="text-gray-500 text-lg leading-relaxed">
                                Kami bukan sekadar penyedia lahan; kami adalah mitra strategis dalam mempercepat transformasi digital nasional melalui pembangunan infrastruktur yang kokoh, aman, dan berkelanjutan.
                            </p>
                        </div>

                        {{-- Sisi Kanan: Grid Layanan --}}
                        <div class="lg:col-span-7 grid grid-cols-1 md:grid-cols-2 gap-8">
                            <div class="group">
                                <div class="w-14 h-14 bg-blue-50 text-blue-600 rounded-2xl flex items-center justify-center mb-5 group-hover:bg-blue-600 group-hover:text-white transition-all duration-300 shadow-sm">
                                    <i class="fas fa-broadcast-tower text-xl"></i>
                                </div>
                                <h4 class="text-xl font-bold text-[#161f36] mb-3">Infrastruktur Kokoh</h4>
                                <p class="text-gray-500 text-sm leading-relaxed">Standar keamanan tinggi dengan material berkualitas industri yang telah tersertifikasi.</p>
                            </div>

                            <div class="group">
                                <div class="w-14 h-14 bg-orange-50 text-orange-600 rounded-2xl flex items-center justify-center mb-5 group-hover:bg-orange-600 group-hover:text-white transition-all duration-300 shadow-sm">
                                    <i class="fas fa-shield-check text-xl"></i>
                                </div>
                                <h4 class="text-xl font-bold text-[#161f36] mb-3">Legalitas Terjamin</h4>
                                <p class="text-gray-500 text-sm leading-relaxed">Kepastian izin resmi dari pemerintah dan masyarakat setempat untuk setiap titik koordinat.</p>
                            </div>

                            <div class="group">
                                <div class="w-14 h-14 bg-emerald-50 text-emerald-600 rounded-2xl flex items-center justify-center mb-5 group-hover:bg-emerald-600 group-hover:text-white transition-all duration-300 shadow-sm">
                                    <i class="fas fa-tools text-xl"></i>
                                </div>
                                <h4 class="text-xl font-bold text-[#161f36] mb-3">Maintenance Berkala</h4>
                                <p class="text-gray-500 text-sm leading-relaxed">Tim teknis siap siaga menjaga kualitas konektivitas melalui pemeliharaan preventif.</p>
                            </div>

                            <div class="group">
                                <div class="w-14 h-14 bg-purple-50 text-purple-600 rounded-2xl flex items-center justify-center mb-5 group-hover:bg-purple-600 group-hover:text-white transition-all duration-300 shadow-sm">
                                    <i class="fas fa-network-wired text-xl"></i>
                                </div>
                                <h4 class="text-xl font-bold text-[#161f36] mb-3">Solusi End-to-End</h4>
                                <p class="text-gray-500 text-sm leading-relaxed">Mendukung ekspansi jaringan provider hingga ke area tersulit di pelosok negeri.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        {{-- COMPANY INFO CARDS --}}
        <section class="py-24">
            <div class="max-w-screen-xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center mb-16">
                    <span class="text-[#FF7518] font-bold uppercase tracking-[0.3em] text-xs">Explore More</span>
                    <h2 class="text-4xl font-black text-[#161f36] mt-4 italic">Informasi Perusahaan</h2>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    @foreach ($aboutLinks as $item)
                        <a href="{{ url($item['url']) }}"
                           class="group relative overflow-hidden bg-white rounded-[2.5rem] p-1 shadow-sm hover:shadow-2xl transition-all duration-500">
                            <div class="bg-[#161f36] rounded-[2.4rem] p-10 h-full flex flex-col md:flex-row items-center gap-8 relative overflow-hidden">

                                {{-- Background Glow --}}
                                <div class="absolute -right-10 -top-10 w-40 h-40 bg-white/5 rounded-full blur-3xl group-hover:bg-[#FF7518]/20 transition-colors duration-500"></div>

                                <div class="flex-1 text-center md:text-left z-10">
                                    <h3 class="text-2xl font-black text-white mb-2">{{ $item['title'] }}</h3>
                                    <p class="text-slate-400 leading-relaxed">{{ $item['description'] }}</p>
                                    <div class="mt-6 inline-flex items-center gap-2 text-[#FF7518] font-bold text-sm group-hover:translate-x-2 transition-transform">
                                        Selengkapnya <i class="fas fa-arrow-right text-xs"></i>
                                    </div>
                                </div>

                                <div class="w-20 h-20 shrink-0 bg-white/10 rounded-3xl flex items-center justify-center backdrop-blur-md group-hover:rotate-12 transition-transform duration-500">
                                    <i class="fas {{ $item['icon'] }} text-3xl text-white"></i>
                                </div>
                            </div>
                        </a>
                    @endforeach
                </div>
            </div>
        </section>
    </div>
@endsection
