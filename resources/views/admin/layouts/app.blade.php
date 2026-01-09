<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,initial-scale=1.0">
    <link rel="icon" type="image/png" href="{{ asset('assets/img/image.png') }}">
    <title>@yield('title', 'Admin - PT Rizqallah Boer Makmur')</title>

    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/@alpinejs/collapse@3.x.x/dist/cdn.min.js"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap"
        rel="stylesheet">

    <style>
        :root {
            --primary: #FF7518;
            --sidebar-bg: #FCFDFE;
            --main-bg: #F2F4F8;
        }

        body {
            font-family: "Plus Jakarta Sans", sans-serif;
            background: var(--main-bg);
            color: #1e293b;
        }

        [x-cloak] {
            display: none !important;
        }

        .sidebar-transition {
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .custom-scrollbar::-webkit-scrollbar {
            width: 4px;
        }

        .custom-scrollbar::-webkit-scrollbar-thumb {
            background: #E2E8F0;
            border-radius: 10px;
        }

        .no-scrollbar::-webkit-scrollbar {
            display: none;
        }
    </style>
</head>

<body x-data="{
    mobileMenu: false,
    editorOpen: {{ collect([
        'admin.abouts.*',
        'admin.news.*',
        'admin.products.*',
        'admin.facilities.*',
        'admin.galleries.*',
        'admin.partners.*',
        'admin.testimonials.*',
        'admin.feedbacks.*',
    ])->contains(fn($r) => request()->routeIs($r))
        ? 'true'
        : 'false' }}
}" class="antialiased">

    <div x-show="mobileMenu" x-cloak x-transition.opacity @click="mobileMenu = false"
        class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm z-[40] lg:hidden"></div>

    <aside :class="mobileMenu ? 'translate-x-0' : '-translate-x-full lg:translate-x-0'"
        class="sidebar-transition fixed top-0 left-0 h-screen bg-[var(--sidebar-bg)] border-r border-slate-200 z-[50] flex flex-col shadow-2xl lg:shadow-none"
        style="width:280px">

        <div class="p-6">
            <div
                class="flex items-center gap-3 p-3 rounded-2xl bg-white border border-slate-100 shadow-sm border-l-4 border-l-[var(--primary)]">
                <img src="{{ asset('assets/img/image.png') }}" class="w-10 h-10 rounded-xl object-cover">
                <div class="overflow-hidden">
                    <p class="font-black text-[11px] uppercase leading-tight">PT RIZQALLAH</p>
                    <p class="text-[9px] text-orange-500 font-bold uppercase tracking-widest mt-0.5">Admin Panel</p>
                </div>
            </div>
        </div>

        <nav class="flex-1 overflow-y-auto px-4 custom-scrollbar space-y-1">

            <div class="text-[10px] font-black uppercase text-slate-400 px-3 mb-2 mt-4 tracking-[2px]">
                Menu Utama
            </div>

            <a href="{{ route('admin.dashboard') }}"
                class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all
                {{ request()->routeIs('admin.dashboard') ? 'bg-orange-50 text-[var(--primary)] font-bold shadow-sm' : 'text-slate-500 hover:bg-slate-50' }}">
                <i class="bi bi-grid-1x2-fill"></i>
                <span class="text-sm">Dashboard</span>
            </a>

            <a href="{{ route('admin.users.index') }}"
                class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all
                {{ request()->routeIs('admin.users.*') ? 'bg-orange-50 text-[var(--primary)] font-bold shadow-sm' : 'text-slate-500 hover:bg-slate-50' }}">
                <i class="bi bi-people-fill"></i>
                <span class="text-sm">Manajemen User</span>
            </a>

            <div class="pt-1">
                <button @click="editorOpen = !editorOpen"
                    class="w-full flex justify-between items-center px-4 py-3 rounded-xl transition-all"
                    :class="editorOpen ? 'bg-slate-50 text-slate-900 shadow-sm' : 'hover:bg-slate-50 text-slate-500'">
                    <span class="flex items-center gap-3">
                        <i class="bi bi-pencil-square"></i>
                        <span class="text-sm font-medium">Manajeman public</span>
                    </span>
                    <i class="bi bi-chevron-right text-[10px] transition-transform duration-300"
                        :class="editorOpen ? 'rotate-90' : ''"></i>
                </button>

                <div x-show="editorOpen" x-collapse x-cloak class="mt-1 ml-4 border-l-2 border-slate-100 space-y-1">
                    @php
                        $submenus = [
                            ['route' => 'admin.abouts.index', 'icon' => 'bi-info-circle', 'label' => 'Tentang Kami'],
                            ['route' => 'admin.news.index', 'icon' => 'bi-newspaper', 'label' => 'Berita & Artikel'],
                            ['route' => 'admin.products.index', 'icon' => 'bi-box-seam', 'label' => 'Produk & Jasa'],
                            ['route' => 'admin.galleries.index', 'icon' => 'bi-images', 'label' => 'Galeri Foto'],
                            ['route' => 'admin.partners.index', 'icon' => 'bi-hand-thumbs-up', 'label' => 'Our Customer'],
                            ['route' => 'admin.testimonials.index', 'icon' => 'bi-chat-quote', 'label' => 'Testimoni'],
                            ['route' => 'admin.feedbacks.index', 'icon' => 'bi-envelope-paper', 'label' => 'Feedback'],
                            ['route' => 'admin.booking.list', 'icon' => 'bi-calendar2-check', 'label' => 'Daftar Booking'],
                            ['route' => 'admin.facilities.index', 'icon' => 'bi-building-gear', 'label' => 'Fasilitas'],

                        ];
                    @endphp
                    @foreach ($submenus as $menu)
                        <a href="{{ route($menu['route']) }}"
                            class="block py-2 px-6 text-xs rounded-r-lg transition-all
                            {{ request()->routeIs($menu['route']) ? 'text-[var(--primary)] font-bold bg-orange-50/50' : 'text-slate-500 hover:text-slate-900 hover:bg-slate-50' }}">
                            <i class="{{ $menu['icon'] }} me-2"></i>{{ $menu['label'] }}
                        </a>
                    @endforeach
                </div>
            </div>

            <div class="text-[10px] font-black uppercase text-slate-400 px-3 py-6 tracking-[2px]">
                Komunikasi
            </div>

            <a href="{{ route('admin.booking.index') }}"
                class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all
                {{ request()->routeIs('admin.booking.index') ? 'bg-orange-50 text-[var(--primary)] font-bold shadow-sm' : 'text-slate-500 hover:bg-slate-50' }}">
                <i class="bi bi-calendar2-check-fill"></i>
                <span class="text-sm">Daftar Booking</span>
            </a>

            <a href="{{ route('admin.booking.index') }}"
                class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all
                {{ request()->routeIs('admin.booking.index') ? 'bg-orange-50 text-[var(--primary)] font-bold shadow-sm' : 'text-slate-500 hover:bg-slate-50' }}">
                <i class="bi bi-chat-dots-fill"></i>
                <span class="text-sm">Chat Booking</span>
            </a>
        </nav>

        <div class="p-6 border-t border-slate-100 space-y-3 bg-white/50">
            <a href="{{ url('/') }}" target="_blank"
                class="flex items-center justify-center gap-2 w-full py-3 rounded-xl bg-slate-900 text-white text-xs font-black hover:bg-[var(--primary)] transition-all shadow-lg shadow-slate-200">
                <i class="bi bi-globe"></i> LIHAT WEBSITE
            </a>

            <form method="POST" action="{{ route('admin.logout') }}">
                @csrf
                <button
                    class="flex items-center justify-center gap-2 w-full py-3 rounded-xl border border-slate-200 text-slate-500 text-xs font-bold hover:text-red-600 hover:bg-red-50 hover:border-red-100 transition-all">
                    <i class="bi bi-box-arrow-right"></i> LOGOUT
                </button>
            </form>
        </div>
    </aside>

    <header
        class="lg:hidden fixed top-0 left-0 right-0 h-16 bg-white border-b border-slate-200 px-4 flex items-center justify-between z-[40]">
        <div class="flex items-center gap-3">
            <img src="{{ asset('assets/img/image.png') }}" class="w-8 h-8 rounded-lg">
            <span class="font-black text-xs tracking-tight uppercase">PT RIZQALLAH</span>
        </div>
        <button @click="mobileMenu = true" class="p-2 bg-slate-50 rounded-xl border border-slate-100 text-slate-600">
            <i class="bi bi-list text-2xl"></i>
        </button>
    </header>

    <main class="sidebar-transition min-h-screen pt-20 lg:pt-0 lg:ml-[280px]">
        <div class="p-6 md:p-8 lg:p-10 max-w-[1600px] mx-auto">
            @yield('content')
        </div>
    </main>

    @yield('scripts')
</body>

</html>
