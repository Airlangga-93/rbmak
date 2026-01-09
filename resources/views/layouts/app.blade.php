<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1" name="viewport" />

    {{-- PERBAIKAN: Logo tab browser (Favicon) --}}
    <link rel="icon" type="image/png" href="{{ asset('assets/img/image.png') }}">
    <link rel="shortcut icon" type="image/png" href="{{ asset('assets/img/image.png') }}">

    <title>@yield('title', 'PT. Rizqallah Boer Makmur - Tower Infrastructure')</title>

    {{-- BARIS INI WAJIB ADA AGAR HALAMAN WELCOME BISA KIRIM LOGO/TAG TAMBAHAN --}}
    @yield('extra_head')

    <script src="https://cdn.tailwindcss.com"></script>

    {{-- Font Awesome --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" />

    {{-- Google Fonts --}}
    <link
        href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&family=Times+New+Roman&display=swap"
        rel="stylesheet" />

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
        :root {
            --accent: #FF7518;
            --dark: #161f36;
        }

        body {
            font-family: 'Poppins', sans-serif;
            font-weight: 500;
            scroll-behavior: smooth;
        }

        /* --- PRELOADER STYLING --- */
        #preloader {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: white;
            z-index: 9999;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            transition: opacity 0.5s ease;
        }

        .loader-logo {
            width: 80px;
            margin-bottom: 20px;
            animation: pulse 1.5s infinite ease-in-out;
        }

        .loader-bar {
            width: 150px;
            height: 4px;
            background: #f3f3f3;
            border-radius: 10px;
            overflow: hidden;
            position: relative;
        }

        .loader-bar::after {
            content: '';
            width: 40%;
            height: 100%;
            background: var(--accent);
            position: absolute;
            left: -100%;
            animation: loading 1.5s infinite ease;
        }

        @keyframes loading {
            0% {
                left: -40%;
            }

            50% {
                left: 100%;
            }

            100% {
                left: 100%;
            }
        }

        @keyframes pulse {

            0%,
            100% {
                transform: scale(1);
                opacity: 1;
            }

            50% {
                transform: scale(1.1);
                opacity: 0.7;
            }
        }

        /* Navbar Styling */
        .nav-link {
            @apply relative text-gray-700 px-2 py-2 transition-all duration-300 flex items-center text-[12px] xl:text-[13px] font-bold uppercase tracking-wider whitespace-nowrap;
        }

        .nav-link::after {
            content: '';
            background-color: var(--accent);
            @apply absolute left-1/2 -bottom-1 w-0 h-[3px] transition-all duration-300 ease-in-out -translate-x-1/2 rounded-full;
        }

        .nav-link:hover {
            color: var(--accent);
        }

        .nav-link:hover::after,
        .nav-active::after {
            @apply w-full;
        }

        .nav-active {
            color: var(--accent) !important;
        }

        .dropdown-content {
            opacity: 0;
            transform: translateY(10px);
            visibility: hidden;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .group:hover .dropdown-content {
            opacity: 1;
            transform: translateY(0);
            visibility: visible;
        }

        [x-cloak] {
            display: none !important;
        }
    </style>
</head>

<body class="bg-gray-50 font-sans text-gray-900 pt-[80px] lg:pt-[124px]">

    <div id="preloader">
        <img src="{{ asset('assets/img/image.png') }}" alt="Logo" class="loader-logo">
        <div class="loader-bar"></div>
        <p class="mt-4 text-[10px] tracking-[0.2em] text-gray-400 font-bold uppercase animate-pulse">Menyiapkan
            Infrastruktur...</p>
    </div>

    @php
        $rbmDarkColor = '#161f36';
        $whatsappNumber = '6281394884596';
        $whatsappMessage = 'Halo PT. Rizqallah Boer Makmur, saya ingin bertanya tentang layanan Anda.';
    @endphp

    <div x-data="{ searchModalOpen: false, mobileMenuOpen: false }" @keydown.escape.window="searchModalOpen = false">

        {{-- MODAL SEARCH --}}
        <div x-show="searchModalOpen" x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-cloak
            class="fixed inset-0 z-[100] overflow-y-auto">
            <div @click="searchModalOpen = false" class="fixed inset-0 bg-[#161f36]/90 backdrop-blur-md"></div>
            <div class="relative min-h-screen flex items-start justify-center pt-32 px-4">
                <div @click.away="searchModalOpen = false"
                    class="bg-white w-full max-w-2xl rounded-2xl shadow-2xl overflow-hidden">
                    <form action="{{ route('search') }}" method="GET" class="relative">
                        <input type="text" name="query"
                            class="w-full text-xl py-6 pl-14 pr-6 focus:ring-0 border-none outline-none font-sans"
                            placeholder="Ketik layanan atau produk..." autofocus>
                        <i
                            class="fa-solid fa-magnifying-glass absolute left-6 top-1/2 -translate-y-1/2 text-gray-400 text-xl"></i>
                    </form>
                </div>
            </div>
        </div>

        {{-- HEADER/NAVBAR --}}
        <header class="fixed top-0 z-50 w-full shadow-sm bg-white">
            <div class="max-w-screen-xl mx-auto flex items-center justify-between px-4 sm:px-6 lg:px-8 py-3">
                <a href="/" class="flex-shrink-0 flex items-center space-x-2 md:space-x-3 group">
                    <img src="{{ asset('assets/img/image.png') }}" alt="Logo PT RBM"
                        class="h-10 w-auto md:h-12 transition-transform group-hover:scale-105">
                    <div class="flex flex-col border-l border-gray-200 pl-2 md:pl-3">
                        <span
                            class="text-rbm-dark font-times text-[11px] sm:text-sm md:text-lg font-bold leading-tight uppercase tracking-tighter">
                            PT RIZQALLAH BOER MAKMUR
                        </span>
                        <span
                            class="text-[8px] md:text-xs font-sans text-gray-500 font-medium tracking-widest uppercase opacity-80">
                            Tower Infrastructure
                        </span>
                    </div>
                </a>

                <div class="hidden lg:flex items-center space-x-6">
                    <button @click="searchModalOpen = true"
                        class="text-gray-500 hover:text-rbm-accent transition-all p-2.5 bg-gray-100 rounded-full">
                        <i class="fa-solid fa-magnifying-glass text-base"></i>
                    </button>
                    <a href="https://wa.me/{{ $whatsappNumber }}?text={{ urlencode($whatsappMessage) }}" target="_blank"
                        rel="noopener noreferrer"
                        class="bg-rbm-accent text-white px-6 py-2.5 rounded-full font-bold hover:bg-orange-600 transition-all text-xs shadow-lg flex items-center gap-2 transform hover:-translate-y-1">
                        <i class="fab fa-whatsapp text-sm"></i> HUBUNGI KAMI
                    </a>
                </div>

                {{-- Hamburger Mobile --}}
                <div class="lg:hidden flex items-center space-x-2">
                    <button @click="searchModalOpen = true" class="text-gray-600 p-2"><i
                            class="fa-solid fa-magnifying-glass"></i></button>
                    <button @click="mobileMenuOpen = !mobileMenuOpen"
                        class="text-2xl text-rbm-dark p-2 focus:outline-none">
                        <i class="fa-solid" :class="mobileMenuOpen ? 'fa-xmark' : 'fa-bars-staggered'"></i>
                    </button>
                </div>
            </div>

            {{-- MAIN NAV DESKTOP --}}
            <nav class="hidden lg:block bg-white border-t border-gray-100 relative z-10">
                <div class="max-w-screen-xl mx-auto flex items-center justify-center gap-x-6 xl:gap-x-10 px-4 h-12">
                    <a href="/" class="nav-link {{ Request::is('/') ? 'nav-active' : '' }}">Home</a>

                    <div class="relative group h-full flex items-center">
                        <button class="nav-link">Perusahaan <i
                                class="fa-solid fa-chevron-down ml-1.5 text-[9px]"></i></button>
                        <div
                            class="absolute top-full dropdown-content bg-white shadow-xl border border-gray-100 rounded-b-xl py-2 w-52 overflow-hidden">
                            <a href="{{ route('about') }}"
                                class="block px-5 py-3 text-sm text-gray-600 hover:bg-orange-50 hover:text-rbm-accent transition-colors">Tentang
                                Kami</a>
                            <a href="{{ route('gallery.index') }}"
                                class="block px-5 py-3 text-sm text-gray-600 hover:bg-orange-50 hover:text-rbm-accent transition-colors">Galeri
                                Proyek</a>
                            <a href="{{ route('partners.index') }}"
                                class="block px-5 py-3 text-sm text-gray-600 hover:bg-orange-50 hover:text-rbm-accent transition-colors">Our
                                Customer</a>
                            <a href="{{ route('testimonials.index') }}"
                                class="block px-5 py-3 text-sm text-gray-600 hover:bg-orange-50 hover:text-rbm-accent transition-colors">Testimonial</a>
                        </div>
                    </div>

                    <a href="{{ route('products') }}"
                        class="nav-link {{ Request::is('products*') ? 'nav-active' : '' }}">Produk</a>
                    <a href="{{ route('news.index') }}"
                        class="nav-link {{ Request::is('news*') ? 'nav-active' : '' }}">Berita</a>
                    <a href="{{ route('facilities.index') }}"
                        class="nav-link {{ Request::is('facilities*') ? 'nav-active' : '' }}">Fasilitas</a>
                    <a href="{{ route('kontak') }}"
                        class="nav-link {{ Request::is('kontak*') ? 'nav-active' : '' }}">Kontak</a>
                    <a href="{{ route('feedback.create') }}"
                        class="nav-link {{ Request::is('feedback*') ? 'nav-active' : '' }}">Feedback</a>

                    <div class="relative group h-full flex items-center">
                        <button class="nav-link">Bantuan <i
                                class="fa-solid fa-chevron-down ml-1.5 text-[9px]"></i></button>
                        <div
                            class="absolute top-full dropdown-content bg-white shadow-xl border border-gray-100 rounded-b-xl py-2 w-48 overflow-hidden">
                            <a href="{{ route('faq') }}"
                                class="block px-5 py-3 text-sm text-gray-600 hover:bg-orange-50 hover:text-rbm-accent transition-colors">FAQs</a>
                            <a href="{{ route('syaratketentuan') }}"
                                class="block px-5 py-3 text-sm text-gray-600 hover:bg-orange-50 hover:text-rbm-accent transition-colors">Legalitas</a>
                        </div>
                    </div>
                </div>
            </nav>

            {{-- MOBILE MENU PANEL --}}
            <div x-show="mobileMenuOpen" x-cloak x-transition
                class="lg:hidden bg-white w-full border-b border-gray-200 shadow-xl overflow-y-auto max-h-[80vh]">
                <div class="flex flex-col p-5 space-y-1">
                    <a href="/"
                        class="px-4 py-3 rounded-xl text-gray-700 font-bold {{ Request::is('/') ? 'bg-orange-50 text-rbm-accent' : '' }}">HOME</a>

                    <div x-data="{ open: false }">
                        <button @click="open = !open"
                            class="w-full flex justify-between items-center px-4 py-3 text-gray-700 font-bold uppercase">
                            <span>Perusahaan</span>
                            <i class="fa-solid fa-chevron-down text-xs transition-transform"
                                :class="{ 'rotate-180': open }"></i>
                        </button>
                        <div x-show="open" class="bg-gray-50 rounded-xl mx-2 my-1 overflow-hidden">
                            <a href="{{ route('about') }}"
                                class="block px-6 py-3 text-sm text-gray-600 font-medium">Tentang Kami</a>
                            <a href="{{ route('gallery.index') }}"
                                class="block px-6 py-3 text-sm text-gray-600 font-medium">Galeri Proyek</a>
                            <a href="{{ route('partners.index') }}"
                                class="block px-6 py-3 text-sm text-gray-600 font-medium">Mitra Industri</a>
                            <a href="{{ route('testimonials.index') }}"
                                class="block px-6 py-3 text-sm text-gray-600 font-medium">Testimonial</a>
                        </div>
                    </div>

                    <a href="{{ route('products') }}" class="px-4 py-3 text-gray-700 font-bold uppercase">Produk</a>
                    <a href="{{ route('news.index') }}"
                        class="px-4 py-3 text-gray-700 font-bold uppercase">Berita</a>
                    <a href="{{ route('facilities.index') }}"
                        class="px-4 py-3 text-gray-700 font-bold uppercase">Fasilitas</a>
                    <a href="{{ route('kontak') }}" class="px-4 py-3 text-gray-700 font-bold uppercase">Kontak</a>

                    <a href="https://wa.me/{{ $whatsappNumber }}" target="_blank" rel="noopener noreferrer"
                        class="mt-4 block text-center bg-rbm-accent text-white font-bold py-4 rounded-2xl shadow-lg">
                        <i class="fab fa-whatsapp mr-2"></i> HUBUNGI WHATSAPP
                    </a>
                </div>
            </div>
        </header>

        <main class="flex flex-col min-h-[60vh]">
            {{-- FLOATING ACTIONS --}}
            <div class="fixed bottom-6 right-6 z-40 flex flex-col gap-3">
                <button x-data="{ shown: false }" x-init="window.addEventListener('scroll', () => { shown = window.scrollY > 400 })" x-show="shown" x-transition
                    @click="window.scrollTo({ top: 0, behavior: 'smooth' })"
                    class="w-12 h-12 bg-white text-rbm-dark shadow-xl rounded-full flex items-center justify-center border border-gray-100 hover:bg-gray-50 transition transform hover:-translate-y-1">
                    <i class="fas fa-arrow-up"></i>
                </button>
                <a href="https://wa.me/{{ $whatsappNumber }}" target="_blank" rel="noopener noreferrer"
                    class="w-12 h-12 bg-green-500 text-white shadow-xl rounded-full flex items-center justify-center hover:bg-green-600 transition transform hover:scale-110">
                    <i class="fab fa-whatsapp text-2xl"></i>
                </a>
            </div>

            @yield('content')
        </main>

        {{-- FOOTER --}}
        <footer style="background-color: #161f36;" class="text-white pt-16 mt-auto">
            <div class="max-w-screen-xl mx-auto px-6 sm:px-8 lg:px-8 pb-16">
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-12 lg:gap-8">
                    <div class="space-y-6">
                        <div class="inline-block bg-white p-3 rounded-xl shadow-sm">
                            <img src="{{ asset('assets/img/image.png') }}" alt="Logo PT RBM" class="h-10 w-auto">
                        </div>
                        <p class="text-rbm-light-text text-sm leading-relaxed">
                            Berdedikasi untuk memberikan layanan konstruksi dan suplai material kualitas tinggi di
                            seluruh wilayah Indonesia.
                        </p>
                        <div class="flex gap-4">
                            @foreach (['facebook-f', 'instagram', 'linkedin-in', 'youtube'] as $icon)
                                <a href="#"
                                    class="w-10 h-10 rounded-full border border-white/10 flex items-center justify-center text-gray-400 hover:text-rbm-accent hover:border-rbm-accent transition-all">
                                    <i class="fab fa-{{ $icon }} text-base"></i>
                                </a>
                            @endforeach
                        </div>
                    </div>

                    <div class="lg:pl-8">
                        <h4 class="font-bold text-white text-lg mb-8 relative inline-block uppercase">
                            Navigasi <span class="absolute -bottom-2 left-0 w-8 h-1 bg-rbm-accent rounded-full"></span>
                        </h4>
                        <ul class="space-y-4 text-sm text-rbm-light-text font-medium">
                            <li><a href="/"
                                    class="hover:text-white transition-colors flex items-center gap-2"><i
                                        class="fa-solid fa-chevron-right text-[10px] text-rbm-accent"></i> Beranda</a>
                            </li>
                            <li><a href="{{ route('about') }}"
                                    class="hover:text-white transition-colors flex items-center gap-2"><i
                                        class="fa-solid fa-chevron-right text-[10px] text-rbm-accent"></i> Tentang
                                    Kami</a></li>
                            <li><a href="{{ route('news.index') }}"
                                    class="hover:text-white transition-colors flex items-center gap-2"><i
                                        class="fa-solid fa-chevron-right text-[10px] text-rbm-accent"></i> Berita
                                    Terbaru</a></li>
                            <li><a href="{{ route('gallery.index') }}"
                                    class="hover:text-white transition-colors flex items-center gap-2"><i
                                        class="fa-solid fa-chevron-right text-[10px] text-rbm-accent"></i> Galeri
                                    Proyek</a></li>
                        </ul>
                    </div>

                    <div>
                        <h4 class="font-bold text-white text-lg mb-8 relative inline-block uppercase">
                            Pusat Bantuan <span
                                class="absolute -bottom-2 left-0 w-8 h-1 bg-rbm-accent rounded-full"></span>
                        </h4>
                        <ul class="space-y-4 text-sm text-rbm-light-text font-medium">
                            <li><a href="{{ route('faq') }}"
                                    class="hover:text-white transition-colors flex items-center gap-2"><i
                                        class="fa-solid fa-chevron-right text-[10px] text-rbm-accent"></i> FAQ</a></li>
                            <li>
                                <a href="https://wa.me/{{ $whatsappNumber }}" target="_blank"
                                    rel="noopener noreferrer"
                                    class="hover:text-white transition-colors flex items-center gap-2 group">
                                    <i
                                        class="fa-solid fa-chevron-right text-[10px] text-rbm-accent group-hover:translate-x-1 transition-transform"></i>
                                    <span>Hubungi Kami</span>
                                </a>
                            </li>
                            <li><a href="{{ route('syaratketentuan') }}"
                                    class="hover:text-white transition-colors flex items-center gap-2"><i
                                        class="fa-solid fa-chevron-right text-[10px] text-rbm-accent"></i> Syarat &
                                    Ketentuan</a></li>
                        </ul>
                    </div>

                    <div>
                        <h4 class="font-bold text-white text-lg mb-8 relative inline-block uppercase">
                            Kantor <span class="absolute -bottom-2 left-0 w-8 h-1 bg-rbm-accent rounded-full"></span>
                        </h4>
                        <div class="space-y-5 text-sm text-rbm-light-text">
                            <div class="flex gap-4">
                                <i class="fas fa-map-marker-alt text-rbm-accent text-lg mt-1"></i>
                                <span class="leading-relaxed text-[13px]">Menara Palma Lantai 12
                                    Jl. HR. Rasuna Said Kav. 6 Blok X-2
                                    Jakarta Selatan 12950</span>
                            </div>
                            <div class="flex gap-4">
                                <i class="fas fa-map-marker-alt text-rbm-accent text-lg mt-1"></i>
                                <span class="leading-relaxed text-[13px]">Jl. Cilembu Haurngombong
                                    ( Perempatan Warung Kawat )
                                    RT.01, RW.03 Kec. Pamulihan
                                    Sumedang 45365</span>
                            </div>
                            <div class="flex gap-4 items-center">
                                <i class="fas fa-envelope text-rbm-accent text-lg"></i>
                                <a href="mailto:project@rbmak.co.id"
                                    class="hover:text-white transition">project@rbmak.co.id</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="border-t border-white/5 py-8 bg-black/30">
                <div class="max-w-screen-xl mx-auto px-6 text-center">
                    <p class="text-[10px] text-gray-500 font-bold uppercase tracking-widest">
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
                setTimeout(() => {
                    preloader.style.display = 'none';
                }, 500);
            }, 600);
        });
    </script>
</body>

</html>
