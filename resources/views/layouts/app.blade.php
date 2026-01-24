<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=0" name="viewport" />

    <link rel="icon" type="image/png" href="{{ asset('assets/img/image.png') }}">
    <link rel="shortcut icon" type="image/png" href="{{ asset('assets/img/image.png') }}">

    <title>@yield('title', 'PT. Rizqallah Boer Makmur - Tower Infrastructure')</title>

    @yield('extra_head')

    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" />
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&family=Times+New+Roman&display=swap" rel="stylesheet" />

    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        'rbm-dark': '#161f36',
                        'rbm-accent': '#FF7518',
                        'rbm-light-text': '#b3b9c6',
                    },
                    fontFamily: {
                        'sans': ['Poppins', 'sans-serif'],
                        'times': ['"Times New Roman"', 'serif'],
                    }
                }
            }
        }
    </script>

    <style>
        :root { --accent: #FF7518; --dark: #161f36; }
        body { font-family: 'Poppins', sans-serif; font-weight: 500; scroll-behavior: smooth; }
        [x-cloak] { display: none !important; }

        /* --- PRELOADER --- */
        #preloader { position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: white; z-index: 9999; display: flex; flex-direction: column; align-items: center; justify-content: center; transition: opacity 0.5s ease; }
        .loader-logo { width: 60px; margin-bottom: 20px; animation: pulse 1.5s infinite ease-in-out; }
        .loader-bar { width: 120px; height: 3px; background: #f3f3f3; border-radius: 10px; overflow: hidden; position: relative; }
        .loader-bar::after { content: ''; width: 40%; height: 100%; background: var(--accent); position: absolute; left: -100%; animation: loading 1.5s infinite ease; }
        @keyframes loading { 0% { left: -40%; } 50% { left: 100%; } 100% { left: 100%; } }
        @keyframes pulse { 0%, 100% { transform: scale(1); opacity: 1; } 50% { transform: scale(1.1); opacity: 0.7; } }

        /* Navbar Styling */
        .nav-link { @apply relative text-gray-700 px-2 py-2 transition-all duration-300 flex items-center text-[11px] xl:text-[13px] font-bold uppercase tracking-wider whitespace-nowrap; }
        .nav-link::after { content: ''; background-color: var(--accent); @apply absolute left-1/2 -bottom-1 w-0 h-[3px] transition-all duration-300 ease-in-out -translate-x-1/2 rounded-full; }
        .nav-link:hover { color: var(--accent); }
        .nav-link:hover::after, .nav-active::after { @apply w-full; }
        .nav-active { color: var(--accent) !important; }

        /* Dropdown Desktop */
        .dropdown-content { opacity: 0; transform: translateY(10px); visibility: hidden; transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1); }
        .group:hover .dropdown-content { opacity: 1; transform: translateY(0); visibility: visible; }
    </style>
</head>

<body class="bg-gray-50 font-sans text-gray-900 pt-[70px] lg:pt-[110px]">

    {{-- PRELOADER --}}
    <div id="preloader">
        <img src="{{ asset('assets/img/image.png') }}" alt="Logo" class="loader-logo">
        <div class="loader-bar"></div>
    </div>

    @php
        $whatsappNumber = '6281394884596';
    @endphp

    <div x-data="{ searchModalOpen: false, mobileMenuOpen: false }" @keydown.escape.window="searchModalOpen = false">

        {{-- MODAL SEARCH --}}
        <div x-show="searchModalOpen" x-transition:enter="transition-opacity ease-out duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-cloak class="fixed inset-0 z-[100] flex items-start justify-center pt-20 px-4">
            <div @click="searchModalOpen = false" class="fixed inset-0 bg-rbm-dark/90 backdrop-blur-md"></div>
            <div class="relative w-full max-w-2xl bg-white rounded-2xl shadow-2xl overflow-hidden animate-in fade-in zoom-in duration-300">
                <form action="{{ route('search') }}" method="GET" class="relative">
                    <input type="text" name="query" class="w-full text-lg md:text-xl py-5 md:py-6 pl-12 md:pl-14 pr-6 focus:ring-0 border-none outline-none font-sans" placeholder="Cari layanan..." autofocus>
                    <i class="fa-solid fa-magnifying-glass absolute left-5 top-1/2 -translate-y-1/2 text-gray-400"></i>
                </form>
            </div>
        </div>

        {{-- HEADER --}}
        <header class="fixed top-0 z-50 w-full shadow-sm bg-white border-b border-gray-100">
            <div class="max-w-screen-xl mx-auto flex items-center justify-between px-4 sm:px-6 lg:px-8 py-3">
                {{-- LOGO & BRAND --}}
                <a href="/" class="flex items-center gap-2 md:gap-3 group shrink-0">
                    <img src="{{ asset('assets/img/image.png') }}" alt="Logo" class="h-9 w-auto md:h-11 transition-transform group-hover:scale-105">
                    <div class="flex flex-col border-l border-gray-200 pl-2 md:pl-3">
                        <span class="text-rbm-dark font-times text-[10px] sm:text-sm md:text-lg font-bold leading-tight uppercase tracking-tighter">
                            PT RIZQALLAH BOER MAKMUR
                        </span>
                        <span class="text-[7px] md:text-xs font-sans text-gray-500 font-medium tracking-[0.2em] uppercase opacity-80">
                            Tower Infrastructure
                        </span>
                    </div>
                </a>

                {{-- DESKTOP ACTION --}}
                <div class="hidden lg:flex items-center space-x-4">
                    <button @click="searchModalOpen = true" class="text-gray-500 hover:text-rbm-accent transition-all p-2 bg-gray-50 rounded-full">
                        <i class="fa-solid fa-magnifying-glass"></i>
                    </button>
                    <a href="https://wa.me/{{ $whatsappNumber }}" target="_blank" class="bg-rbm-accent text-white px-5 py-2 rounded-full font-bold hover:bg-orange-600 transition-all text-[11px] shadow-md flex items-center gap-2">
                        <i class="fab fa-whatsapp"></i> HUBUNGI KAMI
                    </a>
                </div>

                {{-- MOBILE ACTION BUTTONS --}}
                <div class="lg:hidden flex items-center gap-1">
                    <button @click="searchModalOpen = true" class="text-gray-600 p-2"><i class="fa-solid fa-magnifying-glass"></i></button>
                    <button @click="mobileMenuOpen = !mobileMenuOpen" class="text-xl text-rbm-dark p-2 focus:outline-none transition-transform" :class="mobileMenuOpen ? 'rotate-90' : ''">
                        <i class="fa-solid" :class="mobileMenuOpen ? 'fa-xmark' : 'fa-bars-staggered'"></i>
                    </button>
                </div>
            </div>

            {{-- MAIN NAV DESKTOP --}}
            <nav class="hidden lg:block bg-white border-t border-gray-50">
                <div class="max-w-screen-xl mx-auto flex items-center justify-center gap-x-6 xl:gap-x-8 px-4 h-11">
                    <a href="/" class="nav-link {{ Request::is('/') ? 'nav-active' : '' }}">Home</a>

                    <div class="relative group h-full flex items-center">
                        <button class="nav-link">Perusahaan <i class="fa-solid fa-chevron-down ml-1 text-[8px]"></i></button>
                        <div class="absolute top-full dropdown-content bg-white shadow-2xl border border-gray-100 rounded-b-xl py-2 w-52 overflow-hidden z-[60]">
                            <a href="{{ route('about') }}" class="block px-5 py-3 text-sm text-gray-600 hover:bg-orange-50 hover:text-rbm-accent transition-colors">Tentang Kami</a>
                            <a href="{{ route('gallery.index') }}" class="block px-5 py-3 text-sm text-gray-600 hover:bg-orange-50 hover:text-rbm-accent transition-colors">Galeri Proyek</a>
                            <a href="{{ route('partners.index') }}" class="block px-5 py-3 text-sm text-gray-600 hover:bg-orange-50 hover:text-rbm-accent transition-colors">Customer Kami</a>
                            <a href="{{ route('testimonials.index') }}" class="block px-5 py-3 text-sm text-gray-600 hover:bg-orange-50 hover:text-rbm-accent transition-colors">Testimonial</a>
                        </div>
                    </div>

                    <a href="{{ route('products') }}" class="nav-link {{ Request::is('products*') ? 'nav-active' : '' }}">Produk</a>
                    <a href="{{ route('news.index') }}" class="nav-link {{ Request::is('news*') ? 'nav-active' : '' }}">Berita</a>
                    <a href="{{ route('facilities.index') }}" class="nav-link {{ Request::is('facilities*') ? 'nav-active' : '' }}">Fasilitas</a>
                    <a href="{{ route('kontak') }}" class="nav-link {{ Request::is('kontak*') ? 'nav-active' : '' }}">Kontak</a>

                    <div class="relative group h-full flex items-center">
                        <button class="nav-link">Bantuan <i class="fa-solid fa-chevron-down ml-1 text-[8px]"></i></button>
                        <div class="absolute top-full dropdown-content bg-white shadow-2xl border border-gray-100 rounded-b-xl py-2 w-48 overflow-hidden z-[60]">
                            <a href="{{ route('faq') }}" class="block px-5 py-3 text-sm text-gray-600 hover:bg-orange-50 hover:text-rbm-accent transition-colors">FAQs</a>
                            <a href="{{ route('syaratketentuan') }}" class="block px-5 py-3 text-sm text-gray-600 hover:bg-orange-50 hover:text-rbm-accent transition-colors">Legalitas</a>
                            <a href="{{ route('feedback.create') }}" class="block px-5 py-3 text-sm text-gray-600 hover:bg-orange-50 hover:text-rbm-accent transition-colors">Feedback</a>
                        </div>
                    </div>
                </div>
            </nav>

            {{-- MOBILE MENU PANEL --}}
            <div x-show="mobileMenuOpen" x-cloak x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 -translate-y-2" x-transition:enter-end="opacity-100 translate-y-0" class="lg:hidden bg-white w-full border-t border-gray-100 shadow-2xl overflow-y-auto max-h-[85vh]">
                <div class="p-4 space-y-1">
                    <a href="/" class="block px-4 py-3 rounded-xl text-[13px] font-bold {{ Request::is('/') ? 'bg-orange-50 text-rbm-accent' : 'text-gray-700' }}">HOME</a>

                    <div x-data="{ open: false }">
                        <button @click="open = !open" class="w-full flex justify-between items-center px-4 py-3 text-gray-700 font-bold text-[13px] uppercase">
                            <span>Perusahaan</span>
                            <i class="fa-solid fa-chevron-down text-[10px] transition-transform" :class="{ 'rotate-180': open }"></i>
                        </button>
                        <div x-show="open" x-collapse class="bg-gray-50 rounded-xl mx-2 my-1 overflow-hidden">
                            <a href="{{ route('about') }}" class="block px-6 py-3 text-[12px] text-gray-600 font-medium">Tentang Kami</a>
                            <a href="{{ route('gallery.index') }}" class="block px-6 py-3 text-[12px] text-gray-600 font-medium">Galeri Proyek</a>
                            <a href="{{ route('partners.index') }}" class="block px-6 py-3 text-[12px] text-gray-600 font-medium">Customer Kami</a>
                            <a href="{{ route('testimonials.index') }}" class="block px-6 py-3 text-[12px] text-gray-600 font-medium">Testimonial</a>
                        </div>
                    </div>

                    <a href="{{ route('products') }}" class="block px-4 py-3 text-gray-700 font-bold text-[13px] uppercase {{ Request::is('products*') ? 'text-rbm-accent' : '' }}">Produk</a>
                    <a href="{{ route('news.index') }}" class="block px-4 py-3 text-gray-700 font-bold text-[13px] uppercase {{ Request::is('news*') ? 'text-rbm-accent' : '' }}">Berita</a>
                    <a href="{{ route('facilities.index') }}" class="block px-4 py-3 text-gray-700 font-bold text-[13px] uppercase">Fasilitas</a>
                    <a href="{{ route('kontak') }}" class="block px-4 py-3 text-gray-700 font-bold text-[13px] uppercase">Kontak</a>

                    <div x-data="{ open: false }">
                        <button @click="open = !open" class="w-full flex justify-between items-center px-4 py-3 text-gray-700 font-bold text-[13px] uppercase">
                            <span>Bantuan</span>
                            <i class="fa-solid fa-chevron-down text-[10px] transition-transform" :class="{ 'rotate-180': open }"></i>
                        </button>
                        <div x-show="open" x-collapse class="bg-gray-50 rounded-xl mx-2 my-1 overflow-hidden">
                            <a href="{{ route('faq') }}" class="block px-6 py-3 text-[12px] text-gray-600 font-medium">FAQs</a>
                            <a href="{{ route('syaratketentuan') }}" class="block px-6 py-3 text-[12px] text-gray-600 font-medium">Legalitas</a>
                            <a href="{{ route('feedback.create') }}" class="block px-6 py-3 text-[12px] text-gray-600 font-medium">Feedback</a>
                        </div>
                    </div>

                    <div class="pt-4 px-2">
                        <a href="https://wa.me/{{ $whatsappNumber }}" target="_blank" class="w-full flex items-center justify-center bg-rbm-accent text-white font-bold py-3.5 rounded-xl shadow-lg gap-2 text-[12px]">
                            <i class="fab fa-whatsapp text-lg"></i> HUBUNGI WHATSAPP
                        </a>
                    </div>
                </div>
            </div>
        </header>

        <main class="min-h-[60vh]">
            {{-- FLOATING ACTIONS --}}
            <div class="fixed bottom-6 right-4 md:right-6 z-40 flex flex-col gap-3">
                <button x-data="{ shown: false }" x-init="window.addEventListener('scroll', () => { shown = window.scrollY > 400 })" x-show="shown" x-transition @click="window.scrollTo({ top: 0, behavior: 'smooth' })"
                    class="w-11 h-11 bg-rbm-accent text-white shadow-2xl rounded-full flex items-center justify-center border border-orange-600 hover:bg-orange-600 transition transform active:scale-90">
                    <i class="fas fa-arrow-up"></i>
                </button>
                <a href="https://wa.me/{{ $whatsappNumber }}" target="_blank" class="w-11 h-11 bg-green-500 text-white shadow-2xl rounded-full flex items-center justify-center hover:bg-green-600 transition transform hover:scale-110 active:scale-90">
                    <i class="fab fa-whatsapp text-xl"></i>
                </a>
            </div>

            @yield('content')
        </main>

        {{-- FOOTER --}}
        <footer class="bg-rbm-dark text-white pt-12 md:pt-16 mt-auto">
            <div class="max-w-screen-xl mx-auto px-6 lg:px-8 pb-12">
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-10 lg:gap-8">
                    <div class="space-y-6">
                        <div class="inline-block bg-white p-2.5 rounded-xl">
                            <img src="{{ asset('assets/img/image.png') }}" alt="Logo" class="h-9 w-auto">
                        </div>
                        <p class="text-rbm-light-text text-[13px] leading-relaxed">
                            Berdedikasi untuk memberikan layanan konstruksi dan suplai material kualitas tinggi di seluruh wilayah Indonesia.
                        </p>
                    </div>

                    <div class="lg:pl-8">
                        <h4 class="font-bold text-white text-sm mb-6 relative inline-block uppercase tracking-wider">
                            Navigasi <span class="absolute -bottom-2 left-0 w-8 h-0.5 bg-rbm-accent rounded-full"></span>
                        </h4>
                        <ul class="space-y-3 text-[13px] text-rbm-light-text font-medium">
                            <li><a href="/" class="hover:text-white transition-colors flex items-center gap-2"><i class="fa-solid fa-chevron-right text-[8px] text-rbm-accent"></i> Beranda</a></li>
                            <li><a href="{{ route('about') }}" class="hover:text-white transition-colors flex items-center gap-2"><i class="fa-solid fa-chevron-right text-[8px] text-rbm-accent"></i> Tentang Kami</a></li>
                            <li><a href="{{ route('news.index') }}" class="hover:text-white transition-colors flex items-center gap-2"><i class="fa-solid fa-chevron-right text-[8px] text-rbm-accent"></i> Berita Terbaru</a></li>
                            <li><a href="{{ route('gallery.index') }}" class="hover:text-white transition-colors flex items-center gap-2"><i class="fa-solid fa-chevron-right text-[8px] text-rbm-accent"></i> Galeri Proyek</a></li>
                        </ul>
                    </div>

                    <div>
                        <h4 class="font-bold text-white text-sm mb-6 relative inline-block uppercase tracking-wider">
                            Pusat Bantuan <span class="absolute -bottom-2 left-0 w-8 h-0.5 bg-rbm-accent rounded-full"></span>
                        </h4>
                        <ul class="space-y-3 text-[13px] text-rbm-light-text font-medium">
                            <li><a href="{{ route('faq') }}" class="hover:text-white transition-colors flex items-center gap-2"><i class="fa-solid fa-chevron-right text-[8px] text-rbm-accent"></i> FAQ</a></li>
                            <li><a href="{{ route('kontak') }}" class="hover:text-white transition-colors flex items-center gap-2 group"><i class="fa-solid fa-chevron-right text-[8px] text-rbm-accent group-hover:translate-x-1 transition-transform"></i> Hubungi Kami</a></li>
                            <li><a href="{{ route('syaratketentuan') }}" class="hover:text-white transition-colors flex items-center gap-2"><i class="fa-solid fa-chevron-right text-[8px] text-rbm-accent"></i> Syarat & Ketentuan</a></li>
                            <li><a href="{{ route('feedback.create') }}" class="hover:text-white transition-colors flex items-center gap-2"><i class="fa-solid fa-chevron-right text-[8px] text-rbm-accent"></i> Feedback</a></li>
                        </ul>
                    </div>

                    <div>
                        <h4 class="font-bold text-white text-sm mb-6 relative inline-block uppercase tracking-wider">
                            Lokasi <span class="absolute -bottom-2 left-0 w-8 h-0.5 bg-rbm-accent rounded-full"></span>
                        </h4>
                        <div class="space-y-4 text-[12px] text-rbm-light-text">
                            <div class="flex gap-3">
                                <i class="fas fa-map-marker-alt text-rbm-accent text-base shrink-0"></i>
                                <span class="leading-relaxed">Menara Palma Lantai 12, Jl. HR. Rasuna Said Kav. 6 Blok X-2, Jakarta Selatan 12950</span>
                            </div>
                            <div class="flex gap-3">
                                <i class="fas fa-map-marker-alt text-rbm-accent text-base shrink-0"></i>
                                <span class="leading-relaxed">Jl. Cilembu Haurngombong RT.01, RW.03 Kec. Pamulihan, Sumedang 45365</span>
                            </div>
                            <div class="flex gap-3 items-center">
                                <i class="fas fa-envelope text-rbm-accent text-base shrink-0"></i>
                                <a href="mailto:project@rbmak.co.id" class="hover:text-white transition">project@rbmak.co.id</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="border-t border-white/5 py-6 bg-black/20">
                <div class="max-w-screen-xl mx-auto px-6 text-center">
                    <p class="text-[9px] text-gray-500 font-bold uppercase tracking-[0.2em]">
                        &copy; {{ date('Y') }} PT. RIZQALLAH BOER MAKMUR. All rights Reserved.
                    </p>
                </div>
            </div>
        </footer>
    </div>

    <script>
        window.addEventListener('load', () => {
            const preloader = document.getElementById('preloader');
            setTimeout(() => {
                preloader.style.opacity = '0';
                setTimeout(() => { preloader.style.display = 'none'; }, 500);
            }, 600);
        });
    </script>
</body>
</html>
