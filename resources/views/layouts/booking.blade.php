<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>@yield('title', 'PT RIZQALLAH BOER MAKMUR')</title>

    {{-- Script & Style Dasar --}}
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <meta name="csrf-token" content="{{ csrf_token() }}">

    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            -webkit-tap-highlight-color: transparent;
        }
        [x-cloak] { display: none !important; }

        /* Smooth Scrollbar */
        ::-webkit-scrollbar { width: 4px; height: 4px; }
        ::-webkit-scrollbar-track { background: #f8fafc; }
        ::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 10px; }
        ::-webkit-scrollbar-thumb:hover { background: #2563eb; }

        /* Sidebar Glassmorphism effect */
        .sidebar-transition { transition: width 0.3s cubic-bezier(0.4, 0, 0.2, 1); }

        /* Fix for mobile height */
        .h-screen-safe { height: 100vh; height: 100dvh; }

        @yield('styles')
    </style>
</head>

<body class="bg-[#F8FAFC] text-slate-700 antialiased" x-data="{ sidebarOpen: true, mobileSidebar: false }">

    <div class="flex h-screen-safe overflow-hidden">

        {{-- MOBILE SIDEBAR OVERLAY --}}
        <div x-show="mobileSidebar"
             x-cloak
             class="fixed inset-0 z-[60] flex md:hidden">

            <div x-show="mobileSidebar"
                 x-transition:enter="transition-opacity ease-linear duration-300"
                 x-transition:enter-start="opacity-0"
                 x-transition:enter-end="opacity-100"
                 x-transition:leave="transition-opacity ease-linear duration-300"
                 x-transition:leave-start="opacity-100"
                 x-transition:leave-end="opacity-0"
                 @click="mobileSidebar = false"
                 class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm"></div>

            <div x-show="mobileSidebar"
                 x-transition:enter="transition ease-in-out duration-300 transform"
                 x-transition:enter-start="-translate-x-full"
                 x-transition:enter-end="translate-x-0"
                 x-transition:leave="transition ease-in-out duration-300 transform"
                 x-transition:leave-start="translate-x-0"
                 x-transition:leave-end="-translate-x-full"
                 class="relative flex w-full max-w-[280px] flex-1 flex-col bg-white shadow-2xl">

                <div class="flex h-16 items-center justify-between px-6 border-b border-slate-50">
                    <div class="flex items-center space-x-2">
                        <div class="w-8 h-8 bg-blue-600 rounded-lg flex items-center justify-center text-white font-bold shadow-blue-200 shadow-lg">R</div>
                        <span class="font-bold text-slate-800 text-sm tracking-tight">PORTAL CLIENT</span>
                    </div>
                    <button @click="mobileSidebar = false" class="p-2 -mr-2 text-slate-400 hover:text-slate-600">
                        <i class="fa-solid fa-xmark text-xl"></i>
                    </button>
                </div>

                <nav class="flex-1 space-y-1.5 p-4 overflow-y-auto no-scrollbar">
                    <a href="{{ route('booking.index') }}"
                        class="flex items-center px-4 py-3 rounded-xl text-sm font-semibold transition-all {{ request()->routeIs('booking.index') ? 'bg-blue-600 text-white shadow-md shadow-blue-100' : 'text-slate-500 hover:bg-slate-50' }}">
                        <i class="fa-solid fa-calendar-plus w-5 mr-3"></i> Booking Baru
                    </a>
                    <a href="{{ route('booking.riwayat') }}"
                        class="flex items-center px-4 py-3 rounded-xl text-sm font-semibold transition-all {{ request()->routeIs('booking.riwayat') ? 'bg-blue-600 text-white shadow-md shadow-blue-100' : 'text-slate-500 hover:bg-slate-50' }}">
                        <i class="fa-solid fa-receipt w-5 mr-3"></i> Riwayat Pesanan
                    </a>
                    <div class="border-t my-4 border-slate-100"></div>
                    <a href="{{ route('chat.index') }}"
                        class="flex items-center px-4 py-3 rounded-xl text-sm font-semibold transition-all {{ request()->routeIs('chat.*') ? 'bg-blue-600 text-white shadow-md' : 'text-slate-500 hover:bg-slate-50' }}">
                        <i class="fa-solid fa-headset w-5 mr-3"></i> Konsultasi Admin
                    </a>
                </nav>

                <div class="p-4 border-t border-slate-50 bg-slate-50/50">
                    <form method="POST" action="{{ route('booking.logout') }}">
                        @csrf
                        <button type="submit"
                            class="flex w-full items-center px-4 py-3 rounded-xl text-sm font-bold text-red-500 hover:bg-red-100/50 transition-all">
                            <i class="fa-solid fa-power-off w-5 mr-3"></i> Log Out
                        </button>
                    </form>
                </div>
            </div>
        </div>

        {{-- DESKTOP SIDEBAR --}}
        <aside class="hidden md:flex flex-col bg-white border-r border-slate-200 sidebar-transition sticky top-0 h-screen shrink-0 z-40"
            :class="sidebarOpen ? 'w-64 lg:w-72' : 'w-20'">

            <div class="h-16 flex items-center px-5 border-b border-slate-50 shrink-0" :class="sidebarOpen ? 'justify-between' : 'justify-center'">
                <div class="flex items-center space-x-3 overflow-hidden" x-show="sidebarOpen" x-transition:enter.duration.300ms>
                    <div class="w-9 h-9 bg-blue-600 rounded-xl flex items-center justify-center text-white font-black shadow-lg shadow-blue-100">R</div>
                    <span class="font-extrabold text-[10px] lg:text-[11px] tracking-wider whitespace-nowrap text-slate-800 uppercase">PELANGGAN RIZQALLAH</span>
                </div>
                <button @click="sidebarOpen = !sidebarOpen" class="text-slate-400 hover:text-blue-600 p-2 rounded-xl hover:bg-slate-50 transition-all">
                    <i class="fa-solid fa-bars-staggered" :class="sidebarOpen ? '' : 'rotate-180'"></i>
                </button>
            </div>

            <nav class="flex-1 px-3 py-6 space-y-1.5 overflow-y-auto no-scrollbar">
                <a href="{{ route('booking.index') }}"
                    class="flex items-center px-4 py-3 rounded-xl text-sm font-semibold transition-all group
                {{ request()->routeIs('booking.index') ? 'bg-blue-600 text-white shadow-md shadow-blue-100' : 'text-slate-500 hover:bg-slate-50 hover:text-blue-600' }}">
                    <i class="fa-solid fa-calendar-plus w-5 shrink-0" :class="sidebarOpen ? 'mr-3' : 'mx-auto'"></i>
                    <span x-show="sidebarOpen" class="whitespace-nowrap transition-opacity duration-300">Booking Baru</span>
                </a>

                <a href="{{ route('booking.riwayat') }}"
                    class="flex items-center px-4 py-3 rounded-xl text-sm font-semibold transition-all group
                {{ request()->routeIs('booking.riwayat') ? 'bg-blue-600 text-white shadow-md shadow-blue-100' : 'text-slate-500 hover:bg-slate-50 hover:text-blue-600' }}">
                    <i class="fa-solid fa-receipt w-5 shrink-0" :class="sidebarOpen ? 'mr-3' : 'mx-auto'"></i>
                    <span x-show="sidebarOpen" class="whitespace-nowrap transition-opacity duration-300">Riwayat Booking</span>
                </a>

                <div class="border-t border-slate-100 my-4 mx-2" x-show="sidebarOpen"></div>

                <a href="{{ route('chat.index') }}"
                    class="flex items-center px-4 py-3 rounded-xl text-sm font-semibold transition-all group
                {{ request()->routeIs('chat.*') ? 'bg-blue-600 text-white shadow-md' : 'text-slate-500 hover:bg-blue-50 hover:text-blue-600' }}">
                    <i class="fa-solid fa-headset w-5 shrink-0" :class="sidebarOpen ? 'mr-3' : 'mx-auto'"></i>
                    <span x-show="sidebarOpen" class="whitespace-nowrap transition-opacity duration-300">Konsultasi Admin</span>
                </a>
            </nav>

            {{-- PROFILE SECTION SIDEBAR --}}
            <div class="p-4 border-t border-slate-50 space-y-2 bg-slate-50/30 shrink-0">
                <div class="flex items-center bg-white border border-slate-100 rounded-xl p-2.5 shadow-sm transition-all overflow-hidden"
                    :class="sidebarOpen ? 'space-x-3' : 'justify-center'">
                    <div class="w-8 h-8 bg-gradient-to-br from-blue-500 to-blue-700 rounded-lg flex items-center justify-center text-white text-xs font-bold shrink-0 shadow-sm uppercase">
                        {{ substr(auth()->user()->name, 0, 1) }}
                    </div>
                    <div class="min-w-0" x-show="sidebarOpen" x-transition:enter.duration.300ms>
                        <p class="text-[10px] font-bold text-slate-800 truncate leading-none mb-1 uppercase tracking-tighter">
                            {{ auth()->user()->name }}
                        </p>
                        <div class="flex items-center">
                            <span class="w-1.5 h-1.5 bg-emerald-500 rounded-full mr-1.5 animate-pulse"></span>
                            <span class="text-[8px] text-emerald-600 font-bold uppercase tracking-wider">Online</span>
                        </div>
                    </div>
                </div>

                <form method="POST" action="{{ route('booking.logout') }}">
                    @csrf
                    <button type="submit"
                        class="flex items-center w-full px-4 py-2.5 rounded-xl text-xs font-bold text-red-500 hover:bg-red-50 transition-all group"
                        :class="sidebarOpen ? '' : 'justify-center'">
                        <i class="fa-solid fa-power-off w-5 shrink-0" :class="sidebarOpen ? 'mr-2' : ''"></i>
                        <span x-show="sidebarOpen" class="whitespace-nowrap transition-opacity duration-300">Log Out</span>
                    </button>
                </form>
            </div>
        </aside>

        {{-- MAIN CONTENT AREA --}}
        <div class="flex-1 flex flex-col min-w-0 h-screen overflow-hidden">

            {{-- HEADER NAVBAR --}}
            <header class="h-16 bg-white border-b border-slate-200 flex items-center justify-between px-4 sm:px-6 sticky top-0 z-30 shrink-0">
                <div class="flex items-center">
                    <button class="md:hidden text-slate-500 hover:text-blue-600 p-2 -ml-2 transition-colors" @click="mobileSidebar = true">
                        <i class="fa-solid fa-bars-staggered text-xl"></i>
                    </button>

                    <div class="ml-2 md:ml-0">
                        <h1 class="text-sm md:text-base font-extrabold text-slate-800 tracking-tight uppercase line-clamp-1">
                            @yield('header_title', 'Dashboard')
                        </h1>
                        <p class="hidden xs:block text-[9px] md:text-[10px] text-slate-400 font-medium">
                            <span class="hidden sm:inline">Selamat datang, </span>
                            <span class="text-blue-600 font-bold uppercase">{{ auth()->user()->name }}</span>
                        </p>
                    </div>
                </div>

                {{-- TOP PROFILE RIGHT --}}
                <div class="flex items-center space-x-2 sm:space-x-4">
                    <div class="hidden sm:flex flex-col text-right">
                        <p class="text-xs font-black text-slate-800 leading-none mb-0.5 uppercase">{{ auth()->user()->name }}</p>
                        <p class="text-[9px] text-blue-600 font-bold tracking-tight truncate max-w-[120px]">{{ auth()->user()->email }}</p>
                    </div>
                    <div class="w-9 h-9 sm:w-10 sm:h-10 border-2 border-slate-100 rounded-full flex items-center justify-center bg-blue-50 text-blue-600 font-bold shadow-sm uppercase text-sm">
                        {{ substr(auth()->user()->name, 0, 1) }}
                    </div>
                </div>
            </header>

            {{-- MAIN CONTENT SCROLLABLE --}}
            <main class="flex-1 overflow-y-auto bg-[#F8FAFC] scroll-smooth">
                <div class="max-w-[1400px] mx-auto px-4 sm:px-6 lg:px-8 py-6 md:py-10">
                    <div class="animate-in fade-in slide-in-from-bottom-4 duration-500">
                        @yield('content')
                    </div>
                </div>

                <footer class="mt-auto px-6 py-8 border-t border-slate-100">
                    <div class="max-w-7xl mx-auto flex flex-col md:flex-row justify-between items-center gap-4">
                        <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest text-center md:text-left">
                            &copy; {{ date('Y') }} PT Rizqallah Boer Makmur
                        </p>
                        <div class="flex items-center space-x-4">
                            <span class="text-[9px] text-slate-300 font-bold uppercase tracking-tighter italic">Secured Infrastructure System</span>
                        </div>
                    </div>
                </footer>
            </main>

        </div>
    </div>

    @yield('scripts')

</body>
</html>
