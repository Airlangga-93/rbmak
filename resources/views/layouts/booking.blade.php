<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'PT RIZQALLAH BOER MAKMUR')</title>

    {{-- Script & Style Dasar --}}
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;700;800&display=swap" rel="stylesheet">

    <meta name="csrf-token" content="{{ csrf_token() }}">

    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
        [x-cloak] { display: none !important; }
        .sidebar-transition { transition: all 0.3s ease; }
        ::-webkit-scrollbar { width: 5px; }
        ::-webkit-scrollbar-track { background: #f1f1f1; }
        ::-webkit-scrollbar-thumb { background: #2563eb; border-radius: 10px; }
        @yield('styles')
    </style>
</head>

<body class="bg-slate-50 text-slate-700" x-data="{ sidebarOpen: true, mobileSidebar: false }">

    <div class="flex min-h-screen overflow-hidden">

        {{-- MOBILE SIDEBAR OVERLAY --}}
        <div x-show="mobileSidebar" x-cloak class="fixed inset-0 z-50 flex md:hidden" role="dialog" aria-modal="true">
            <div class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm" @click="mobileSidebar = false"
                x-transition:enter="transition-opacity ease-linear duration-300" x-transition:enter-start="opacity-0"
                x-transition:enter-end="opacity-100" x-transition:leave="transition-opacity ease-linear duration-300"
                x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"></div>

            <div class="relative flex w-full max-w-xs flex-1 flex-col bg-white"
                x-transition:enter="transition ease-in-out duration-300 transform" x-transition:enter-start="-translate-x-full"
                x-transition:enter-end="translate-x-0" x-transition:leave="transition ease-in-out duration-300 transform"
                x-transition:leave-start="translate-x-0" x-transition:leave-end="-translate-x-full">

                <div class="flex h-16 items-center justify-between px-6 border-b">
                    <div class="flex items-center space-x-2">
                        <div class="w-8 h-8 bg-blue-600 rounded-lg flex items-center justify-center text-white font-bold">R</div>
                        <span class="font-extrabold text-slate-800 text-sm tracking-tight">PORTAL PELANGGAN</span>
                    </div>
                    <button @click="mobileSidebar = false" class="text-slate-500">
                        <i class="fa-solid fa-xmark text-xl"></i>
                    </button>
                </div>

                <nav class="flex-1 space-y-2 p-4 overflow-y-auto">
                    <a href="{{ route('booking.index') }}"
                        class="flex items-center px-4 py-3 rounded-xl text-sm font-semibold {{ request()->routeIs('booking.index') ? 'bg-blue-50 text-blue-600' : 'text-slate-500' }}">
                        <i class="fa-solid fa-calendar-plus w-5 mr-3"></i> Booking Baru
                    </a>
                    <a href="{{ route('booking.riwayat') }}"
                        class="flex items-center px-4 py-3 rounded-xl text-sm font-semibold {{ request()->routeIs('booking.riwayat') ? 'bg-blue-50 text-blue-600' : 'text-slate-500' }}">
                        <i class="fa-solid fa-receipt w-5 mr-3"></i> Riwayat Pesanan
                    </a>
                    <div class="border-t my-4 border-slate-100"></div>
                    <a href="{{ route('chat.index') }}"
                        class="flex items-center px-4 py-3 rounded-xl text-sm font-semibold {{ request()->routeIs('chat.*') ? 'bg-blue-600 text-white shadow-lg shadow-blue-200' : 'text-slate-500' }}">
                        <i class="fa-solid fa-headset w-5 mr-3"></i> Konsultasi Admin
                    </a>
                </nav>

                <div class="p-4 border-t">
                    <form method="POST" action="{{ route('booking.logout') }}">
                        @csrf
                        <button type="submit"
                            class="flex w-full items-center px-4 py-3 rounded-xl text-sm font-semibold text-red-500 hover:bg-red-50 transition">
                            <i class="fa-solid fa-power-off w-5 mr-3"></i> Log Out
                        </button>
                    </form>
                </div>
            </div>
        </div>

        {{-- DESKTOP SIDEBAR --}}
        <aside class="hidden md:flex flex-col bg-white border-r border-slate-200 sidebar-transition sticky top-0 h-screen shrink-0"
            :class="sidebarOpen ? 'w-72' : 'w-20'">

            <div class="h-16 flex items-center justify-between px-5 border-b shrink-0">
                <div class="flex items-center space-x-3 overflow-hidden" x-show="sidebarOpen" x-transition>
                    <div class="w-10 h-10 bg-blue-600 rounded-xl flex items-center justify-center text-white font-black shadow-lg shadow-blue-100">
                        R
                    </div>
                    <span class="font-extrabold text-[11px] tracking-wider whitespace-nowrap text-slate-800 uppercase">PELANGGAN RIZQALLAH</span>
                </div>
                <button @click="sidebarOpen = !sidebarOpen" class="text-slate-400 hover:text-blue-600 p-2 rounded-lg transition-colors mx-auto">
                    <i class="fa-solid fa-bars-staggered" :class="sidebarOpen ? '' : 'rotate-180'"></i>
                </button>
            </div>

            <nav class="flex-1 px-3 py-6 space-y-2 overflow-y-auto">
                <a href="{{ route('booking.index') }}"
                    class="flex items-center px-4 py-3 rounded-xl text-sm font-semibold transition group
               {{ request()->routeIs('booking.index') ? 'bg-blue-50 text-blue-600 shadow-sm' : 'text-slate-500 hover:bg-slate-50 hover:text-blue-600' }}">
                    <i class="fa-solid fa-calendar-plus w-5 shrink-0" :class="sidebarOpen ? 'mr-3' : 'mx-auto'"></i>
                    <span x-show="sidebarOpen" class="whitespace-nowrap">Booking Baru</span>
                </a>

                <a href="{{ route('booking.riwayat') }}"
                    class="flex items-center px-4 py-3 rounded-xl text-sm font-semibold transition group
               {{ request()->routeIs('booking.riwayat') ? 'bg-blue-50 text-blue-600 shadow-sm' : 'text-slate-500 hover:bg-slate-50 hover:text-blue-600' }}">
                    <i class="fa-solid fa-receipt w-5 shrink-0" :class="sidebarOpen ? 'mr-3' : 'mx-auto'"></i>
                    <span x-show="sidebarOpen" class="whitespace-nowrap">Riwayat Booking</span>
                </a>

                <div class="border-t border-slate-100 my-4" x-show="sidebarOpen"></div>

                <a href="{{ route('chat.index') }}"
                    class="flex items-center px-4 py-3 rounded-xl text-sm font-semibold transition group
                {{ request()->routeIs('chat.*') ? 'bg-blue-600 text-white shadow-lg shadow-blue-200' : 'text-slate-500 hover:bg-blue-50 hover:text-blue-600' }}">
                    <i class="fa-solid fa-headset w-5 shrink-0" :class="sidebarOpen ? 'mr-3' : 'mx-auto'"></i>
                    <span x-show="sidebarOpen" class="whitespace-nowrap">Konsultasi Admin</span>
                </a>
            </nav>

            {{-- USER PROFILE SECTION SIDEBAR (IDENTITAS PELANGGAN) --}}
            <div class="p-4 border-t border-slate-50 space-y-2 shrink-0 bg-slate-50/50">
                <div class="flex items-center bg-white border border-slate-100 rounded-xl p-3 shadow-sm"
                    :class="sidebarOpen ? 'space-x-3' : 'justify-center'">
                    <div class="w-9 h-9 bg-gradient-to-br from-blue-500 to-blue-700 rounded-lg flex items-center justify-center text-white font-bold shrink-0 shadow-sm uppercase">
                        {{ substr(auth()->user()->name, 0, 1) }}
                    </div>
                    <div class="overflow-hidden" x-show="sidebarOpen" x-transition>
                        {{-- Mengambil Nama User Langsung dari Database --}}
                        <p class="text-[11px] font-bold text-slate-800 truncate leading-none mb-1 uppercase tracking-tighter">
                            {{ auth()->user()->name }}
                        </p>
                        <div class="flex items-center">
                            <span class="w-1.5 h-1.5 bg-emerald-500 rounded-full mr-1.5 animate-pulse"></span>
                            <span class="text-[9px] text-emerald-600 font-bold uppercase tracking-wider">Akun Pelanggan</span>
                        </div>
                    </div>
                </div>

                <form method="POST" action="{{ route('booking.logout') }}">
                    @csrf
                    <button type="submit"
                        class="flex items-center w-full px-4 py-3 rounded-xl text-sm font-bold text-red-500 hover:bg-red-50 transition-all group"
                        :class="sidebarOpen ? '' : 'justify-center'">
                        <i class="fa-solid fa-power-off w-5 shrink-0 group-hover:-translate-x-1 transition-transform"
                            :class="sidebarOpen ? 'mr-3' : ''"></i>
                        <span x-show="sidebarOpen">Log Out</span>
                    </button>
                </form>
            </div>
        </aside>

        {{-- MAIN CONTENT AREA --}}
        <div class="flex-1 flex flex-col h-screen overflow-hidden">

            {{-- HEADER NAVBAR --}}
            <header class="h-16 bg-white border-b border-slate-200 flex items-center justify-between px-6 sticky top-0 z-30 shrink-0">
                <div class="flex items-center space-x-3">
                    <button class="md:hidden text-slate-500 hover:text-blue-600 p-2" @click="mobileSidebar = true">
                        <i class="fa-solid fa-bars-staggered text-xl"></i>
                    </button>

                    <div class="hidden sm:block">
                        <h1 class="text-sm font-extrabold text-slate-800 tracking-tight uppercase">@yield('header_title', 'Dashboard')</h1>
                        <p class="text-[10px] text-slate-400 font-medium">Sesi Login: <span class="text-blue-600 font-bold uppercase">{{ auth()->user()->name }}</span></p>
                    </div>
                </div>

                {{-- TOP PROFILE RIGHT (DATA USER LOGIN) --}}
                <div class="flex items-center space-x-3 bg-slate-50 px-3 py-1.5 rounded-2xl border border-slate-100">
                    <div class="text-right hidden sm:block">
                        {{-- Nama & Email Otomatis dari User yang Login --}}
                        <p class="text-xs font-black text-slate-800 leading-none mb-0.5 uppercase">{{ auth()->user()->name }}</p>
                        <p class="text-[9px] text-blue-600 font-bold tracking-tight">{{ auth()->user()->email }}</p>
                    </div>
                    <div class="w-9 h-9 bg-white border border-blue-200 rounded-xl flex items-center justify-center text-blue-600 font-bold shadow-sm uppercase">
                        {{ substr(auth()->user()->name, 0, 1) }}
                    </div>
                </div>
            </header>

            {{-- MAIN CONTENT SCROLLABLE --}}
            <main class="flex-1 overflow-y-auto bg-[#F8FAFC]">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 py-8">
                    @yield('content')
                </div>

                <footer class="max-w-7xl mx-auto px-6 py-6 text-center">
                    <p class="text-[10px] font-bold text-slate-300 uppercase tracking-[0.2em]">
                        &copy; {{ date('Y') }} PT Rizqallah Boer Makmur • Secured Infrastructure System
                    </p>
                </footer>
            </main>

        </div>
    </div>

    @yield('scripts')

</body>
</html>
