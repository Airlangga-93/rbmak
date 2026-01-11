@extends('layouts.app')

@section('title', 'Tentang Kami | PT RIZQALLAH BOER MAKMUR')

@section('content')
    @php
        use Illuminate\Support\Str;
        $hasImages = isset($mainImages) && $mainImages->isNotEmpty();

        $aboutLinks = [
            [
                'title' => 'Sejarah Perusahaan',
                'description' =>
                    'Dedikasi kami dalam membangun konektivitas bangsa sejak awal berdiri di industri tower.',
                'url' => '/history',
                'icon' => 'fa-history',
                'accent' => 'from-blue-600 to-blue-800',
            ],
            [
                'title' => 'Visi & Misi',
                'description' =>
                    'Target strategis kami untuk menjadi pilar utama penyedia infrastruktur digital Indonesia.',
                'url' => '/vision',
                'icon' => 'fa-bullseye',
                'accent' => 'from-orange-500 to-red-600',
            ],
        ];

        $features = [
            [
                'title' => 'Infrastruktur Kokoh',
                'desc' =>
                    'Standar keamanan tinggi dengan material baja berkualitas industri yang telah tersertifikasi SNI dan ISO.',
                'icon' => 'fa-broadcast-tower',
                'bg' => 'bg-blue-50',
                'text' => 'text-blue-600',
                'hover' => 'group-hover:bg-blue-600',
            ],
            [
                'title' => 'Legalitas Terjamin',
                'desc' =>
                    'Kepastian izin resmi (SITAC/IMB) dari pemerintah dan koordinasi masyarakat setempat untuk setiap titik tower.',
                'icon' => 'fa-file-signature',
                'bg' => 'bg-orange-50',
                'text' => 'text-orange-600',
                'hover' => 'group-hover:bg-orange-600',
            ],
            [
                'title' => 'Maintenance Berkala',
                'desc' =>
                    'Tim teknis profesional siap siaga menjaga kualitas konektivitas melalui pemeliharaan preventif 24/7.',
                'icon' => 'fa-tools',
                'bg' => 'bg-emerald-50',
                'text' => 'text-emerald-600',
                'hover' => 'group-hover:bg-emerald-600',
            ],
            [
                'title' => 'Solusi End-to-End',
                'desc' =>
                    'Mendukung ekspansi jaringan provider hingga ke area tersulit di pelosok negeri dengan survei koordinat akurat.',
                'icon' => 'fa-network-wired',
                'bg' => 'bg-purple-50',
                'text' => 'text-purple-600',
                'hover' => 'group-hover:bg-purple-600',
            ],
        ];
    @endphp

    {{-- WRAPPER UTAMA TANPA KOTAK TAMBAHAN --}}
    <div class="bg-slate-50 min-h-screen">
        {{-- HERO SECTION --}}
        <section class="relative h-[60vh] md:h-[70vh] overflow-hidden bg-[#161f36]">
            @if ($hasImages)
                <div x-data="{ activeSlide: 1, totalSlides: {{ $mainImages->count() }} }" x-init="setInterval(() => { activeSlide = activeSlide % totalSlides + 1 }, 5000)" class="h-full">
                    @foreach ($mainImages as $image)
                        <div x-show="activeSlide === {{ $loop->iteration }}"
                            x-transition:enter="transition ease-out duration-1000"
                            x-transition:enter-start="opacity-0 scale-105" x-transition:enter-end="opacity-100 scale-100"
                            x-transition:leave="transition ease-in duration-1000" x-transition:leave-start="opacity-100"
                            x-transition:leave-end="opacity-0" class="absolute inset-0">
                            <img src="{{ Str::contains($image->path, 'http') ? $image->path : Storage::url($image->path) }}"
                                alt="Hero Image" class="w-full h-full object-cover">
                            <div class="absolute inset-0 bg-gradient-to-b from-transparent via-[#161f36]/40 to-[#161f36]">
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                {{-- BREADCRUMB OVERLAY --}}
                <div class="absolute bottom-0 left-0 w-full z-20">
                    <div class="max-w-screen-xl mx-auto px-4 sm:px-6 lg:px-8 pb-10">
                        <nav class="flex mb-4" aria-label="Breadcrumb">
                            <ol
                                class="inline-flex items-center space-x-3 bg-white/10 backdrop-blur-md px-6 py-3 rounded-2xl border border-white/10 shadow-2xl">
                                <li class="inline-flex items-center">
                                    <a href="/"
                                        class="text-sm font-medium text-slate-300 hover:text-white transition-colors">Home</a>
                                </li>
                                <li class="flex items-center gap-3">
                                    <i class="fas fa-chevron-right text-[10px] text-[#FF7518]"></i>
                                    <span class="text-sm font-bold text-white tracking-wide">About Us</span>
                                </li>
                            </ol>
                        </nav>
                        <h1 class="text-4xl md:text-6xl font-black text-white">Tentang <span
                                class="text-[#FF7518]">Kami.</span>
                        </h1>
                    </div>
                </div>
        </section>
        @endif

        {{-- MAIN CONTENT: FEATURES --}}
        <section class="relative z-30 -mt-10 reveal">
            <div class="max-w-screen-xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="bg-white rounded-[3rem] shadow-xl p-8 md:p-16 border border-slate-100">
                    <div class="grid grid-cols-1 lg:grid-cols-12 gap-16 items-start">
                        {{-- Sisi Kiri --}}
                        <div class="lg:col-span-5">
                            <div class="w-16 h-1.5 bg-[#FF7518] mb-8 rounded-full"></div>
                            <h2 class="text-3xl md:text-4xl font-black text-[#161f36] leading-tight mb-6">
                                Membangun Pondasi <br>Masa Depan Digital Indonesia
                            </h2>
                            <p class="text-gray-500 text-lg leading-relaxed mb-8">
                                PT Rizqallah Boer Makmur bukan sekadar penyedia infrastruktur; kami adalah mitra strategis
                                dalam mempercepat transformasi digital nasional melalui pembangunan infrastruktur tower yang
                                kokoh, aman, dan berkelanjutan.
                            </p>
                            <div class="flex items-center gap-6">
                                <div class="flex flex-col">
                                    <span class="text-3xl font-black text-[#161f36]">15+</span>
                                    <span class="text-xs font-bold text-gray-400 uppercase tracking-widest">Tahun
                                        Pengalaman</span>
                                </div>
                                <div class="w-px h-10 bg-slate-200"></div>
                                <div class="flex flex-col">
                                    <span class="text-3xl font-black text-[#FF7518]">500+</span>
                                    <span class="text-xs font-bold text-gray-400 uppercase tracking-widest">Titik
                                        Proyek</span>
                                </div>
                            </div>
                        </div>

                        {{-- Sisi Kanan --}}
                        <div class="lg:col-span-7 grid grid-cols-1 md:grid-cols-2 gap-8">
                            @foreach ($features as $f)
                                <div class="group reveal">
                                    <div
                                        class="w-14 h-14 {{ $f['bg'] }} {{ $f['text'] }} rounded-2xl flex items-center justify-center mb-5 {{ $f['hover'] }} group-hover:text-white transition-all duration-300 shadow-sm group-hover:rotate-6">
                                        <i class="fas {{ $f['icon'] }} text-xl"></i>
                                    </div>
                                    <h4
                                        class="text-xl font-bold text-[#161f36] mb-3 group-hover:text-[#FF7518] transition-colors">
                                        {{ $f['title'] }}</h4>
                                    <p class="text-gray-500 text-sm leading-relaxed">{{ $f['desc'] }}</p>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </section>

        {{-- COMPANY INFO CARDS --}}
        <section class="py-20 reveal">
            <div class="max-w-screen-xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center mb-16">
                    <span class="text-[#FF7518] font-bold uppercase tracking-[0.3em] text-xs">Explore More</span>
                    <h2 class="text-4xl font-black text-[#161f36] mt-4 italic uppercase">Informasi Perusahaan</h2>
                    <div class="w-24 h-1 bg-[#161f36] mx-auto mt-4 rounded-full"></div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    @foreach ($aboutLinks as $item)
                        <a href="{{ url($item['url']) }}"
                            class="group relative overflow-hidden bg-white rounded-[2.5rem] p-1 shadow-sm hover:shadow-2xl transition-all duration-500">
                            <div
                                class="bg-[#161f36] rounded-[2.4rem] p-10 h-full flex flex-col md:flex-row items-center gap-8 relative overflow-hidden">
                                <div
                                    class="absolute -right-10 -top-10 w-40 h-40 bg-white/5 rounded-full blur-3xl group-hover:bg-[#FF7518]/20 transition-colors duration-500">
                                </div>

                                <div class="flex-1 text-center md:text-left z-10">
                                    <h3 class="text-2xl font-black text-white mb-2 uppercase">{{ $item['title'] }}</h3>
                                    <p class="text-slate-400 leading-relaxed text-sm">{{ $item['description'] }}</p>
                                    <div
                                        class="mt-6 inline-flex items-center gap-2 text-[#FF7518] font-bold text-sm group-hover:translate-x-2 transition-transform">
                                        Selengkapnya <i class="fas fa-arrow-right text-xs"></i>
                                    </div>
                                </div>

                                <div
                                    class="w-20 h-20 shrink-0 bg-white/10 rounded-3xl flex items-center justify-center backdrop-blur-md group-hover:rotate-12 group-hover:scale-110 transition-all duration-500">
                                    <i class="fas {{ $item['icon'] }} text-3xl text-white"></i>
                                </div>
                            </div>
                        </a>
                    @endforeach
                </div>
            </div>
        </section>

        {{-- CSS & SCRIPT TETAP DI DALAM WRAPPER --}}
        <style>
            .reveal {
                opacity: 0;
                transform: translateY(30px);
                transition: all 0.8s ease-out;
            }

            .reveal.show {
                opacity: 1;
                transform: translateY(0);
            }

            [x-cloak] {
                display: none !important;
            }
        </style>

        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const revealElements = document.querySelectorAll('.reveal');

                function handleScroll() {
                    revealElements.forEach(el => {
                        const windowHeight = window.innerHeight;
                        const revealTop = el.getBoundingClientRect().top;
                        const revealPoint = 100;

                        if (revealTop < windowHeight - revealPoint) {
                            el.classList.add('show');
                        }
                    });
                }

                window.addEventListener('scroll', handleScroll);
                handleScroll(); // Trigger on load
            });
        </script>
    </div>
@endsection
