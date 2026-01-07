@extends('layouts.app')

@section('title', 'PT RIZQALLAH BOER MAKMUR | Tower Infrastructure')

@section('content')

    @php
        use Illuminate\Support\Str;

        /**
         * ===============================
         * PASTIKAN DATA NEWS SELALU COLLECTION
         * ===============================
         */
        $latestNews = collect();
        try {
            $newsData = \App\Models\News::latest()->take(3)->get();
            if ($newsData instanceof \Illuminate\Support\Collection) {
                $latestNews = $newsData;
            }
        } catch (\Throwable $e) {
            $latestNews = collect();
        }

        /**
         * ===============================
         * DATA SLIDER DARI GALLERY
         * ===============================
         */
        $sliderGallery = collect();
        try {
            // Mengambil 4 foto terbaru dari galeri untuk banner
            $sliderGallery = \App\Models\Gallery::latest()->take(4)->get() ?? collect();
        } catch (\Exception $e) {
            $sliderGallery = collect();
        }

        $sliderImages = $sliderGallery->map(function ($g) {
            return asset('storage/' . $g->image);
        });

        // Fallback jika slider kosong agar count() tidak error
        if ($sliderImages->isEmpty()) {
            $sliderImages = collect([
                'https://images.unsplash.com/photo-1520640193369-2213303b19cd?w=1600',
                'https://images.unsplash.com/photo-1544724569-5f546fd6f2b5?w=1600',
                'https://images.unsplash.com/photo-1504307651254-35680f356dfd?w=1600',
                'https://images.unsplash.com/photo-1558618666-fcd25c85cd64?w=1600',
            ]);
        }

        // Color Variables
        $amaliahOrange = '#FF7518';
        $amaliahDark = '#161f36';
    @endphp

    {{-- ================= MODAL NEWS (SESSION BASED) ================= --}}
    @if ($latestNews->isNotEmpty())
        <div x-data="{
            currentIndex: 0,
            newsCount: {{ $latestNews->count() }},
            showModal: false,

            init() {
                if (!sessionStorage.getItem('news_popup_session')) {
                    setTimeout(() => {
                        this.showModal = true;
                        sessionStorage.setItem('news_popup_session', 'shown');
                    }, 800);
                }
            },

            next() {
                this.currentIndex++;
                if (this.currentIndex >= this.newsCount) {
                    this.showModal = false;
                }
            },

            closeAll() {
                this.showModal = false;
            }
        }" x-show="showModal" x-cloak
            class="fixed inset-0 z-[110] flex items-center justify-center p-4">

            {{-- OVERLAY --}}
            <div @click="closeAll()" class="fixed inset-0 bg-[#161f36]/50">
            </div>

            {{-- CARD --}}
            <div class="relative w-full max-w-md">
                @foreach ($latestNews as $index => $news)
                    <div x-show="currentIndex === {{ $index }}" x-transition:enter="transition ease-out duration-500"
                        x-transition:enter-start="opacity-0 scale-90 translate-y-6"
                        x-transition:enter-end="opacity-100 scale-100 translate-y-0"
                        class="bg-white rounded-[28px] shadow-2xl overflow-hidden">

                        {{-- IMAGE --}}
                        <div class="relative h-56 bg-gray-100">
                            @if (!empty($news->image))
                                <img src="{{ asset('storage/' . $news->image) }}" alt="{{ $news->title }}"
                                    class="w-full h-full object-cover">
                            @endif

                            {{-- CLOSE / NEXT --}}
                            <button @click="next()"
                                class="absolute top-4 right-4 w-9 h-9 flex items-center justify-center
                               rounded-full bg-white/90 hover:bg-red-500 hover:text-white
                               transition shadow">
                                <i class="fa-solid fa-xmark"></i>
                            </button>

                            {{-- PROGRESS INDICATOR --}}
                            <div class="absolute bottom-4 left-5 flex gap-1.5">
                                @for ($i = 0; $i < $latestNews->count(); $i++)
                                    <div
                                        class="h-1.5 rounded-full transition-all duration-500
                                {{ $i === $index ? 'w-8 bg-[#FF7518]' : 'w-2 bg-white/50' }}">
                                    </div>
                                @endfor
                            </div>
                        </div>

                        {{-- CONTENT --}}
                        <div class="p-7">
                            <span class="text-[10px] font-bold text-[#FF7518] tracking-widest uppercase">
                                Info Terkini
                            </span>

                            <h3 class="text-xl font-bold mt-2 mb-3 text-[#161f36] leading-tight">
                                {{ $news->title ?? '-' }}
                            </h3>

                            <p class="text-sm text-gray-500 mb-6 line-clamp-2">
                                {{ Str::limit(strip_tags($news->content ?? ''), 110) }}
                            </p>

                            <div class="flex items-center justify-between border-t pt-4">
                                <a href="{{ route('news.show', $news->slug ?? $news->id) }}"
                                    class="text-sm font-bold text-[#FF7518] hover:underline">
                                    Baca Artikel
                                </a>

                                <button @click="next()" class="text-xs font-bold text-gray-400 uppercase tracking-widest">
                                    {{ $index + 1 === $latestNews->count() ? 'Tutup' : 'Lanjut' }}
                                </button>
                            </div>
                        </div>

                    </div>
                @endforeach
            </div>
        </div>
    @endif

    {{-- ================= HERO SLIDER (DATA DARI GALLERY) ================= --}}
    <section class="relative h-[85vh] min-h-[600px] overflow-hidden bg-[#161f36]">
        <div x-data="{ activeSlide: 1, total: {{ $sliderImages->count() }} }" x-init="setInterval(() => activeSlide = activeSlide === total ? 1 : activeSlide + 1, 5000)" class="relative h-full">

            @foreach ($sliderImages as $i => $img)
                <div x-show="activeSlide === {{ $i + 1 }}" x-transition:enter="transition opacity-100 duration-1000"
                    x-transition:leave="transition opacity-0 duration-1000" class="absolute inset-0">
                    <img src="{{ $img }}" class="w-full h-full object-cover brightness-[0.3] blur-[1px]">
                </div>
            @endforeach

            {{-- Overlay Gradient --}}
            <div class="absolute inset-0 bg-gradient-to-r from-[#161f36] via-[#161f36]/60 to-transparent"></div>

            {{-- Hero Content --}}
            <div class="absolute inset-0 flex flex-col justify-center px-8 md:px-24">
                <span class="text-[#FF7518] font-black uppercase tracking-[0.4em] text-xs mb-4 block">
                    PT. Rizqallah Boer Makmur
                </span>
                <h1 class="text-white text-4xl md:text-7xl font-black leading-tight mb-6 uppercase tracking-tighter">
                    Strongly Connected <br><span class="text-[#FF7518]">With Telecommunications</span>
                </h1>
                <p class="text-gray-300 max-w-md text-sm md:text-lg font-medium leading-relaxed mb-8">
                   Terhubung Kuat dengan Telekomunikasi
                </p>
                <div class="flex flex-wrap gap-4">
                    <a href="{{ route('contact') }}"
                        class="bg-[#FF7518] text-white px-8 py-4 rounded-xl font-black text-[10px] uppercase tracking-widest hover:bg-white hover:text-[#161f36] transition-all shadow-lg shadow-orange-500/20">
                        Mulai Konsultasi
                    </a>
                </div>
            </div>

            {{-- Indicators --}}
            <div class="absolute bottom-32 right-10 flex gap-2 z-20">
                @foreach ($sliderImages as $i => $img)
                    <button @click="activeSlide = {{ $i + 1 }}"
                        :class="activeSlide === {{ $i + 1 }} ? 'w-8 bg-[#FF7518]' : 'w-3 bg-white/30'"
                        class="h-1.5 rounded-full transition-all duration-500"></button>
                @endforeach
            </div>
        </div>
    </section>



    @push('heads')
        <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
        <style>
            [x-cloak] {
                display: none !important;
            }
        </style>
    @endpush

    {{-- ================= FEATURE FLOAT ================= --}}
    <section class="relative -mt-20 z-30 px-6">
        <div class="max-w-7xl mx-auto grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-6">
            @php
                $fitur = [
                    [
                        'icon' => 'fa-user-plus',
                        'title' => 'Client Portal',
                        'desc' => 'Daftar & Booking survei',
                        'link' => route('booking.login'),
                        'color' => $amaliahOrange,
                    ],
                    [
                        'icon' => 'fa-industry',
                        'title' => 'Our Facilities',
                        'desc' => 'Armada & Peralatan',
                        'link' => route('facilities.index'),
                        'color' => $amaliahDark,
                    ],
                    [
                        'icon' => 'fa-file-alt',
                        'title' => 'Profile',
                        'desc' => 'Legalitas PT. RBM',
                        'link' => '/about',
                        'color' => $amaliahOrange,
                    ],
                    [
                        'icon' => 'fa-headset',
                        'title' => 'Consultation',
                        'desc' => 'Spesifikasi & Harga',
                        'link' => '/contact',
                        'color' => $amaliahDark,
                    ],
                    [
                        'icon' => 'fa-project-diagram',
                        'title' => 'Portfolio',
                        'desc' => 'Proyek Selesai',
                        'link' => route('gallery.index'),
                        'color' => $amaliahOrange,
                    ],
                ];
            @endphp

            @foreach ($fitur as $f)
                <a href="{{ $f['link'] ?? '#' }}"
                    class="modern-card p-8 text-center bg-white rounded-[2rem] shadow-xl border border-gray-50 flex flex-col items-center group">
                    <div class="w-14 h-14 mx-auto rounded-2xl flex items-center justify-center mb-6 shadow-lg group-hover:scale-110 transition-transform duration-300"
                        style="background:{{ $f['color'] }}">
                        <i class="fas {{ $f['icon'] }} text-white text-xl"></i>
                    </div>
                    <h3
                        class="text-xs font-black tracking-tight text-[#161f36] mb-2 uppercase group-hover:text-[#FF7518] transition-colors">
                        {{ $f['title'] }}
                    </h3>
                    <p class="text-[10px] text-gray-400 leading-relaxed font-bold uppercase tracking-tighter">
                        {{ $f['desc'] }}
                    </p>
                </a>
            @endforeach
        </div>
    </section>

    <div class="h-32"></div>

    {{-- ================= CTA SECTION ================= --}}
    <section class="py-12 px-6 md:px-24 mb-20">
        <div class="bg-[#161f36] rounded-[3rem] p-8 md:p-16 relative overflow-hidden shadow-2xl">
            <div class="absolute top-0 right-0 w-64 h-64 bg-[#FF7518]/10 rounded-full -mr-32 -mt-32"></div>

            <div class="relative z-10 flex flex-col lg:flex-row items-center justify-between gap-12">
                <div class="max-w-xl text-center lg:text-left">
                    <h2 class="text-white text-3xl md:text-5xl font-black uppercase leading-tight mb-6">
                        Mulai Proyek <span class="text-[#FF7518]">Tower Anda</span>
                    </h2>
                    <p class="text-gray-400 text-sm md:text-base leading-relaxed font-medium uppercase tracking-widest">
                        Tim profesional kami siap membantu kebutuhan infrastruktur telekomunikasi dengan standar kualitas tinggi.
                    </p>
                </div>

                <div class="flex flex-col sm:flex-row items-center gap-8">
                    <a href="{{ route('contact') }}"
                        class="bg-[#FF7518] text-white px-10 py-5 rounded-2xl font-black uppercase tracking-[0.2em] text-xs shadow-xl shadow-[#FF7518]/20 hover:bg-white hover:text-[#161f36] transition-all duration-300 hover:-translate-y-1">
                        Hubungi Kami
                    </a>

                    <div class="flex flex-col items-center sm:items-start gap-3">
                        <div class="flex -space-x-4 overflow-hidden">
                            @php
                                $ctaPartners = \App\Models\Partner::whereNotNull('logo')->latest()->take(4)->get();
                                $totalMitra = \App\Models\Partner::count();
                            @endphp

                            @foreach ($ctaPartners as $mitra)
                                @php
                                    $path = $mitra->logo;
                                    if (Str::startsWith($path, ['http', 'cloudinary'])) {
                                        $url = $path;
                                    } elseif (Str::startsWith($path, 'assets/')) {
                                        $url = asset($path);
                                    } else {
                                        $url = asset('storage/' . $path);
                                    }
                                @endphp
                                <div
                                    class="inline-block h-12 w-12 rounded-full ring-4 ring-[#161f36] bg-white overflow-hidden shadow-lg">
                                    <img class="h-full w-full object-contain p-1.5" src="{{ $url }}"
                                        alt="{{ $mitra->name }}"
                                        onerror="this.src='https://ui-avatars.com/api/?name={{ urlencode($mitra->name) }}&color=7F9CF5&background=EBF4FF'">
                                </div>
                            @endforeach

                            @if ($totalMitra > 4)
                                <div
                                    class="flex items-center justify-center h-12 w-12 rounded-full ring-4 ring-[#161f36] bg-gray-700 text-white text-[10px] font-black">
                                    +{{ $totalMitra - 4 }}
                                </div>
                            @endif
                        </div>

                        <div class="flex flex-col">
                            <span class="text-[#FF7518] text-xs font-black uppercase tracking-widest">{{ $totalMitra }}+
                                Mitra</span>
                            <span class="text-gray-400 text-[10px] font-bold uppercase tracking-widest">Terpercaya</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>



    {{-- ================= INTELLIGENT SOLUTION ================= --}}
    <section class="max-w-7xl mx-auto px-6 lg:px-12 mb-40 reveal">

        {{-- Header --}}
        <div class="mb-16">
            <h2 class="text-3xl md:text-5xl font-bold text-[#161f36] tracking-tight uppercase leading-tight">
                Intelligent <span class="text-[#FF7518]">Solution</span><br>
                For Your Infrastructure
            </h2>

            <div class="flex items-center gap-2 mt-5">
                <span class="w-16 h-[3px] bg-[#FF7518] rounded-full"></span>
                <span class="w-4 h-[3px] bg-[#161f36] rounded-full"></span>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-14 items-start">

            {{-- Left Content --}}
            <div class="space-y-10 reveal">
                <div class="relative pl-6 border-l-4 border-[#FF7518]">
                    <h3 class="text-xl font-bold text-[#161f36] mb-4">
                        PT Rizqallah Boer Makmur
                    </h3>

                    <p class="text-gray-700 text-base leading-relaxed">
                        Didirikan pada tahun 2005 di Jakarta sebagai perusahaan yang berdedikasi dalam penyediaan barang dan
                        jasa berkualitas tinggi. Kami memahami bahwa infrastruktur telekomunikasi adalah
                        tulang punggung konektivitas digital.
                        Oleh karena itu, <span class="text-[#FF7518] font-semibold">RBM</span> hadir memberikan solusi
                        komprehensif mulai dari pembangunan hingga pemeliharaan infrastruktur menara di seluruh wilayah
                        Indonesia.
                    </p>

                    <p class="mt-4 text-gray-500 text-sm leading-relaxed italic">
                        "Solusi infrastruktur profesional untuk konektivitas yang stabil, aman, dan berkelanjutan."
                    </p>
                </div>

                {{-- CTA Button --}}
                <div class="flex flex-col sm:flex-row gap-4">
                    <a href="{{ Route::has('products') ? route('products') : '/products' }}"
                        class="group inline-flex items-center justify-center px-8 py-4 rounded-xl bg-[#161f36] text-white font-semibold transition-all duration-300 hover:bg-[#FF7518] hover:shadow-lg hover:shadow-orange-500/30">
                        <span>LIHAT KATALOG</span>
                        <span
                            class="ml-4 p-2 rounded-lg bg-white/20 group-hover:bg-white group-hover:text-[#FF7518] transition">
                            <i class="fas fa-arrow-right text-sm"></i>
                        </span>
                    </a>

                    <a href="/about"
                        class="inline-flex items-center justify-center px-8 py-4 rounded-xl border border-[#161f36] text-[#161f36] font-semibold transition-all hover:bg-[#161f36] hover:text-white">
                        TENTANG KAMI
                    </a>
                </div>
            </div>

            {{-- Right Product & Service Grid (Bento Style - 5 Data) --}}
            <div class="grid grid-cols-2 md:grid-cols-3 auto-rows-[160px] gap-4 reveal">

                @php
                    // Gabungkan semua data agar slot ke-5 pasti terisi
                    $combined = collect();
                    if (isset($products)) {
                        $combined = $combined->concat($products);
                    }
                    if (isset($services)) {
                        $combined = $combined->concat($services);
                    }
                    if (isset($items)) {
                        $combined = $combined->concat($items);
                    }

                    // Pastikan kita mengambil 5 item untuk ditampilkan
                    $displayItems = $combined->take(5);
                @endphp

                @for ($i = 0; $i < 5; $i++)
                    @php
                        $item = $displayItems->get($i);

                        // Layout: Item 1 (Tinggi), Item 2 (Lebar & Tinggi), 3-5 (Kotak Standar)
                        $gridClass = $i === 0 ? 'md:row-span-2' : ($i === 1 ? 'md:col-span-2 md:row-span-2' : '');

                        // Penanganan Gambar
                        $imageUrl = null;
                        if ($item && $item->image) {
                            $cleanPath = ltrim($item->image, '/');
                            // Cek jika dari seeder (folder assets) atau upload (folder storage)
                            $imageUrl = str_contains($cleanPath, 'assets/')
                                ? asset($cleanPath)
                                : asset('storage/' . $cleanPath);
                        }
                    @endphp

                    <div
                        class="{{ $gridClass }} relative overflow-hidden rounded-2xl bg-[#161f36] group border border-transparent hover:border-[#FF7518] transition-all duration-500 shadow-lg">

                        @if ($item && $imageUrl)
                            {{-- Menampilkan Gambar --}}
                            <img src="{{ $imageUrl }}" alt="{{ $item->name }}"
                                class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110 opacity-80 group-hover:opacity-100"
                                onerror="this.onerror=null;this.src='https://placehold.co/600x400/161f36/white?text=Image+Not+Found';">

                            {{-- Overlay Info --}}
                            <div
                                class="absolute inset-0 bg-gradient-to-t from-[#161f36] via-transparent to-transparent opacity-0 group-hover:opacity-100 transition-all duration-500 flex flex-col justify-end p-5">
                                <span class="text-[#FF7518] text-[9px] font-bold uppercase tracking-widest mb-1">
                                    {{ isset($item->category_id) || isset($item->category) ? 'Produk' : 'Layanan' }}
                                </span>
                                <h4 class="text-white text-xs font-bold uppercase leading-tight">
                                    {{ $item->name }}
                                </h4>
                                <div class="w-0 group-hover:w-full h-[2px] bg-[#FF7518] mt-3 transition-all duration-500">
                                </div>
                            </div>

                            {{-- Link Detail --}}
                            <a href="/products/{{ $item->slug ?? $item->id }}" class="absolute inset-0 z-10"></a>
                        @else
                            {{-- Fallback jika data kurang dari 5 --}}
                            <div
                                class="w-full h-full flex flex-col items-center justify-center border border-dashed border-white/10 bg-[#1a243d]">
                                <i class="fas fa-tower-broadcast text-[#FF7518] text-xl opacity-20 mb-2"></i>
                                <span
                                    class="text-white/20 text-[9px] uppercase font-bold tracking-widest text-center px-2">
                                    DATA {{ $i + 1 }} <br> RBM INFRASTRUCTURE
                                </span>
                            </div>
                        @endif
                    </div>
                @endfor
            </div>
        </div>
    </section>


    {{-- ================= PARTNER SECTION (FIXED & STABLE) ================= --}}
    <section class="bg-white py-20 reveal">
        <div class="max-w-screen-xl mx-auto px-6 grid grid-cols-1 lg:grid-cols-2 gap-14 items-center">

            {{-- Sisi Kiri: Teks Deskripsi --}}
            <div>
                <h2 class="text-3xl md:text-4xl font-bold text-[#161f36] leading-tight">
                    Industry <br> Partner
                </h2>

                <div class="flex items-center gap-2 mt-4">
                    <span class="w-16 h-1 bg-[#FF7518] rounded-full"></span>
                    <span class="w-3 h-1 bg-[#FF7518] rounded-full"></span>
                </div>

                <p class="mt-6 text-gray-600 text-sm leading-relaxed max-w-md">
                    Kami bekerja sama dengan mitra industri untuk memberikan pengalaman nyata,
                    pengembangan skill, dan peluang profesional jangka panjang.
                </p>

                <a href="{{ route('partners.index') }}"
                    class="inline-flex items-center gap-4 mt-8 px-6 py-3 rounded-lg bg-[#FF7518] text-white font-semibold transition hover:scale-105 shadow-lg shadow-orange-500/20">
                    Selengkapnya
                    <i class="fas fa-arrow-right text-sm"></i>
                </a>
            </div>

            {{-- Sisi Kanan: Animasi Scrolling Logos --}}
            <div class="relative h-[30rem] overflow-hidden rounded-3xl bg-gray-50/50 border border-gray-100">

                {{-- Efek Fade Atas & Bawah --}}
                <div
                    class="absolute top-0 left-0 w-full h-20 bg-gradient-to-b from-white via-white/80 to-transparent z-10">
                </div>
                <div
                    class="absolute bottom-0 left-0 w-full h-20 bg-gradient-to-t from-white via-white/80 to-transparent z-10">
                </div>

                {{-- Container Animasi --}}
                <div class="animate-scroll-vertical flex flex-col gap-10 py-10">

                    @php
                        // Mengambil semua mitra dari database (Support Seeder & Admin Input)
                        $allPartners = \App\Models\Partner::all();
                    @endphp

                    @if ($allPartners->count() > 0)
                        {{-- LOOPING 1 --}}
                        <div class="grid grid-cols-2 gap-8 px-8">
                            @foreach ($allPartners as $partner)
                                @php
                                    $path = $partner->logo;
                                    // Cek apakah path adalah URL, folder assets, atau folder storage
                                    if (Str::startsWith($path, ['http', 'cloudinary'])) {
                                        $logoUrl = $path;
                                    } elseif (Str::startsWith($path, 'assets/')) {
                                        $logoUrl = asset($path);
                                    } else {
                                        $logoUrl = asset('storage/' . $path);
                                    }
                                @endphp
                                <div class="flex flex-col items-center group">
                                    <div
                                        class="bg-white p-4 rounded-2xl shadow-sm border border-gray-100 w-full aspect-square flex items-center justify-center transition-all duration-500 group-hover:shadow-md group-hover:-translate-y-1">
                                        {{-- Foto Asli tanpa Grayscale --}}
                                        <img src="{{ $logoUrl }}" alt="{{ $partner->name }}"
                                            class="max-h-16 w-auto object-contain transition-all duration-500"
                                            onerror="this.src='https://ui-avatars.com/api/?name={{ urlencode($partner->name) }}&background=random'">
                                    </div>
                                    <span
                                        class="mt-3 text-[9px] text-gray-400 uppercase tracking-[0.2em] font-bold text-center group-hover:text-[#FF7518] transition-colors">
                                        {{ $partner->name }}
                                    </span>
                                </div>
                            @endforeach
                        </div>

                        {{-- LOOPING 2 (Duplikasi untuk efek Infinite Scroll) --}}
                        <div class="grid grid-cols-2 gap-8 px-8" aria-hidden="true">
                            @foreach ($allPartners as $partner)
                                @php
                                    $path = $partner->logo;
                                    if (Str::startsWith($path, ['http', 'cloudinary'])) {
                                        $logoUrl = $path;
                                    } elseif (Str::startsWith($path, 'assets/')) {
                                        $logoUrl = asset($path);
                                    } else {
                                        $logoUrl = asset('storage/' . $path);
                                    }
                                @endphp
                                <div class="flex flex-col items-center group">
                                    <div
                                        class="bg-white p-4 rounded-2xl shadow-sm border border-gray-100 w-full aspect-square flex items-center justify-center">
                                        <img src="{{ $logoUrl }}" class="max-h-16 w-auto object-contain"
                                            onerror="this.src='https://ui-avatars.com/api/?name={{ urlencode($partner->name) }}&background=random'">
                                    </div>
                                    <span
                                        class="mt-3 text-[9px] text-gray-400 uppercase tracking-[0.2em] font-bold text-center">
                                        {{ $partner->name }}
                                    </span>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="flex items-center justify-center h-full text-gray-400 italic">
                            Belum ada data mitra.
                        </div>
                    @endif

                </div>
            </div>
        </div>
    </section>

    {{-- Pastikan CSS Animasi ini ada di dalam tag <style> halaman Anda --}}
    <style>
        @keyframes scroll-vertical {
            0% {
                transform: translateY(0);
            }

            100% {
                transform: translateY(-50%);
            }
        }

        .animate-scroll-vertical {
            animation: scroll-vertical 25s linear infinite;
        }

        .animate-scroll-vertical:hover {
            animation-play-state: paused;
        }
    </style>

    {{-- ================= STYLE ================= --}}
    <style>
        .reveal {
            opacity: 0;
            transform: translateY(40px);
            transition: all .8s ease;
        }

        .reveal.show {
            opacity: 1;
            transform: translateY(0);
        }

        @keyframes scroll {
            from {
                transform: translateY(0);
            }

            to {
                transform: translateY(-50%);
            }
        }

        .animate-scroll {
            animation: scroll 18s linear infinite;
        }

        .animate-scroll:hover {
            animation-play-state: paused;
        }
    </style>

    <script>
        document.addEventListener('scroll', () => {
            document.querySelectorAll('.reveal').forEach(el => {
                if (el.getBoundingClientRect().top < window.innerHeight - 100) {
                    el.classList.add('show');
                }
            });
        });
    </script>

    {{-- ================= FACILITIES SECTION (MOSAIC GALLERY) ================= --}}
    <section class="py-16 sm:py-24 reveal" style="background-color: {{ $amaliahDark ?? '#161f36' }};">
        {{-- Container Utama --}}
        <div class="max-w-screen-xl mx-auto px-4 sm:px-6 lg:px-8 relative">

            {{-- Dekorasi Titik --}}
            <div class="absolute top-8 left-8 md:left-12 flex items-center space-x-2 custom-none">
                <div class="w-3 h-3 bg-gray-600 rounded-full"></div>
                <div class="w-3 h-3 bg-gray-600 rounded-full"></div>
                <div class="w-3 h-3 bg-white rounded-full"></div>
            </div>

            {{-- Header Section --}}
            <div class="text-center">
                <h2 class="text-3xl md:text-4xl font-bold text-white uppercase tracking-tighter">Fasilitas <span
                        class="text-[#FF7518]">Kami</span></h2>
                
                <div class="w-24 h-px bg-[#FF7518] mx-auto mt-4"></div>
            </div>

            @php
                // Ambil 5 data fasilitas terbaru dari database
                $displayFacilities = \App\Models\Facility::latest()->take(5)->get();
            @endphp

            {{-- Galeri Gambar Mozaik Dinamis --}}
            <div class="mt-12 w-full h-[30rem] md:h-[35rem] grid grid-cols-2 md:grid-cols-4 grid-rows-2 gap-4">

                @foreach ($displayFacilities as $index => $item)
                    @php
                        // Logika URL Gambar (Handle Seeder & Admin)
                        $path = $item->image;
                        if (Str::startsWith($path, ['http', 'cloudinary'])) {
                            $imgUrl = $path;
                        } elseif (Str::startsWith($path, 'assets/')) {
                            $imgUrl = asset($path);
                        } else {
                            $imgUrl = asset('storage/' . $path);
                        }

                        // Tentukan class grid berdasarkan urutan (index)
                        $gridClass = '';
                        if ($index == 0) {
                            $gridClass = 'col-span-1 row-span-2';
                        }
                        // Gambar 1: Tinggi kiri
                        elseif ($index == 1) {
                            $gridClass = 'col-span-1 row-span-1';
                        }
                        // Gambar 2: Tengah Atas
                        elseif ($index == 2) {
                            $gridClass = 'col-span-1 md:col-span-2 row-span-1';
                        }
                        // Gambar 3: Kanan Atas lebar
                        elseif ($index == 3) {
                            $gridClass = 'col-span-1 row-span-1';
                        }
                        // Gambar 4: Tengah Bawah
                        elseif ($index == 4) {
                            $gridClass = 'col-span-1 md:col-span-2 row-span-1';
                        } // Gambar 5: Kanan Bawah lebar
                    @endphp

                    <div class="{{ $gridClass }} rounded-2xl overflow-hidden relative group border border-white/5">
                        <img src="{{ $imgUrl }}" alt="{{ $item->name }}"
                            class="w-full h-full object-cover transition-all duration-700 group-hover:scale-110"
                            style="filter: brightness(0.85);"
                            onerror="this.src='https://placehold.co/800x600/161f36/FFFFFF?text=Facility+Image'">

                        {{-- Overlay Info saat Hover --}}
                        <div
                            class="absolute inset-0 bg-gradient-to-t from-black/80 via-transparent to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300 flex flex-col justify-end p-6">
                            <span class="text-[#FF7518] text-[10px] font-black uppercase tracking-widest">Kategori
                                Fasilitas</span>
                            <h4 class="text-white font-bold text-sm uppercase">{{ $item->name }}</h4>
                        </div>
                    </div>
                @endforeach

                {{-- Fallback jika data kurang dari 5 --}}
                @for ($i = count($displayFacilities); $i < 5; $i++)
                    <div
                        class="bg-gray-800/50 rounded-2xl flex items-center justify-center border border-dashed border-gray-700">
                        <i class="fas fa-tools text-gray-700 text-2xl"></i>
                    </div>
                @endfor
            </div>

            {{-- Tombol Selengkapnya --}}
            <div class="text-right mt-8">
                <a href="{{ route('facilities.index') }}"
                    class="inline-flex items-center group bg-white/5 px-6 py-3 rounded-xl border border-white/10 hover:border-[#FF7518] transition-all">
                    <span
                        class="text-xs font-black text-white mr-4 uppercase tracking-widest group-hover:text-[#FF7518]">Lihat
                        Semua Fasilitas</span>
                    <div
                        class="bg-[#FF7518] rounded-full p-2 transition-transform duration-300 group-hover:rotate-[-45deg]">
                        <i class="fas fa-arrow-right text-white text-xs"></i>
                    </div>
                </a>
            </div>

        </div>
    </section>

    {{-- CSS Tambahan dipertahankan --}}
    <style>
        /* Styling scrollbar dan modal tetap sama seperti kode awal Anda */
        .scrollbar-hide::-webkit-scrollbar {
            display: none;
        }

        .scrollbar-hide {
            -ms-overflow-style: none;
            scrollbar-width: none;
        }

        .custom-scrollbar::-webkit-scrollbar {
            width: 4px;
        }

        .custom-scrollbar::-webkit-scrollbar-thumb {
            background: rgba(255, 117, 24, 0.3);
            border-radius: 10px;
        }
    </style>
    {{-- Testimonials Section - Interactive Blue & Orange --}}
    <section class="py-24 bg-gray-50 overflow-hidden">
        <div class="max-w-screen-xl mx-auto px-4 sm:px-6 lg:px-8">

            {{-- Title dengan Mix Warna Biru & Oranye --}}
            <div class="text-center mb-16">
                <h2 class="text-3xl md:text-5xl font-extrabold text-[#161f36] mb-4 tracking-tight">Testimoni</h2>
                <div class="flex justify-center gap-1.5">
                    <div class="w-16 h-2 bg-[#161f36] rounded-full"></div> {{-- Biru Tua --}}
                    <div class="w-4 h-2 bg-[#FF7518] rounded-full animate-pulse"></div> {{-- Oranye --}}
                    <div class="w-4 h-2 bg-[#FF7518]/50 rounded-full"></div>
                </div>
            </div>

            <div x-data="{
                skip: 1,
                atBeginning: true,
                atEnd: false,
                next() {
                    this.$refs.slider.scrollBy({ left: this.$refs.slider.firstElementChild.clientWidth + 24, behavior: 'smooth' })
                },
                prev() {
                    this.$refs.slider.scrollBy({ left: -(this.$refs.slider.firstElementChild.clientWidth + 24), behavior: 'smooth' })
                },
                checkPosition() {
                    this.atBeginning = this.$refs.slider.scrollLeft <= 5
                    this.atEnd = this.$refs.slider.scrollLeft + this.$refs.slider.clientWidth >= this.$refs.slider.scrollWidth - 5
                }
            }" class="relative px-4">

                {{-- Tombol Navigasi Interaktif --}}
                <div
                    class="absolute top-1/2 -translate-y-1/2 inset-x-0 z-30 flex justify-between pointer-events-none px-2 md:-mx-8">
                    <button @click="prev()"
                        class="pointer-events-auto w-12 h-12 bg-white text-[#161f36] border-2 border-[#161f36] rounded-full flex items-center justify-center hover:bg-[#161f36] hover:text-white transition-all duration-300 shadow-lg disabled:opacity-30 disabled:cursor-not-allowed"
                        :disabled="atBeginning">
                        <i class="fas fa-arrow-left"></i>
                    </button>

                    <button @click="next()"
                        class="pointer-events-auto w-12 h-12 bg-[#FF7518] text-white rounded-full flex items-center justify-center hover:bg-[#e66a15] transition-all duration-300 shadow-lg shadow-orange-200 disabled:opacity-30 disabled:cursor-not-allowed"
                        :disabled="atEnd">
                        <i class="fas fa-arrow-right"></i>
                    </button>
                </div>

                {{-- Slider Container --}}
                <div x-ref="slider" @scroll.debounce.10ms="checkPosition()"
                    class="flex gap-6 overflow-x-auto snap-x snap-mandatory no-scrollbar pb-10 pt-4">

                    @foreach ($testimonials as $testimonial)
                        <div class="min-w-full md:min-w-[calc(50%-12px)] snap-start group">
                            <div
                                class="bg-white p-10 rounded-[2rem] shadow-[0_4px_20px_rgba(0,0,0,0.05)] border-b-4 border-transparent hover:border-[#FF7518] h-full flex flex-col justify-between transition-all duration-500 hover:shadow-2xl hover:-translate-y-2 relative">

                                {{-- Ikon Kutipan Interaktif --}}
                                <div
                                    class="absolute top-6 left-8 text-gray-100 group-hover:text-orange-50 transition-colors duration-500">
                                    <i class="fas fa-quote-left text-6xl"></i>
                                </div>

                                <div class="relative z-10 mb-8">
                                    <p class="text-gray-600 leading-relaxed text-lg italic font-medium">
                                        "{{ $testimonial['message'] }}"
                                    </p>
                                </div>

                                {{-- Profil di Pojok Kanan Bawah --}}
                                <div class="flex items-center justify-end gap-5 border-t border-gray-50 pt-8">
                                    <div class="text-right">
                                        <h4
                                            class="font-bold text-[#161f36] text-xl group-hover:text-[#FF7518] transition-colors">
                                            {{ $testimonial['name'] }}</h4>
                                        @if ($testimonial['company'])
                                            <p class="text-gray-400 text-xs font-bold uppercase tracking-widest mt-1">
                                                {{ $testimonial['company'] }}</p>
                                        @endif
                                    </div>

                                    {{-- Avatar Biru dengan Border Oranye --}}
                                    <div
                                        class="w-20 h-20 rounded-2xl bg-[#161f36] border-2 border-transparent group-hover:border-[#FF7518] shadow-lg flex-shrink-0 overflow-hidden flex items-center justify-center text-white text-3xl font-bold transition-all duration-500 transform group-hover:rotate-3">
                                        @if (isset($testimonial['photo']) && $testimonial['photo'])
                                            <img src="{{ asset($testimonial['photo']) }}"
                                                class="w-full h-full object-cover">
                                        @else
                                            {{ strtoupper(substr($testimonial['name'], 0, 1)) }}
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            {{-- CTA Button --}}
            <div class="mt-8 text-center">
                <a href="{{ route('send.testimonial') }}"
                    class="inline-flex items-center gap-3 px-10 py-4 bg-[#161f36] text-white rounded-full font-bold hover:bg-[#FF7518] transition-all duration-300 shadow-xl group">
                    <i class="fas fa-comment-dots group-hover:scale-125 transition-transform"></i>
                    Bagi Pengalaman Anda
                </a>
            </div>
        </div>
    </section>

    <style>
        .no-scrollbar::-webkit-scrollbar {
            display: none;
        }

        .no-scrollbar {
            -ms-overflow-style: none;
            scrollbar-width: none;
        }
    </style>

    <section class="relative pt-32 pb-20 bg-slate-50 overflow-hidden animate-on-scroll">
        <div
            class="absolute top-0 right-0 -translate-y-1/2 translate-x-1/4 w-96 h-96 bg-orange-100 rounded-full blur-[120px] opacity-50">
        </div>
        <div
            class="absolute bottom-0 left-0 translate-y-1/2 -translate-x-1/4 w-72 h-72 bg-blue-100 rounded-full blur-[100px] opacity-50">
        </div>

        <div class="max-w-screen-xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
            <div class="flex flex-col lg:flex-row gap-16 items-start">

                <div class="lg:w-1/3 lg:sticky lg:top-32">
                    <div
                        class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-orange-50 border border-orange-100 mb-6">
                        <span class="relative flex h-2 w-2">
                            <span
                                class="animate-ping absolute inline-flex h-full w-full rounded-full bg-[#FF7518] opacity-75"></span>
                            <span class="relative inline-flex rounded-full h-2 w-2 bg-[#FF7518]"></span>
                        </span>
                        <span class="text-[10px] font-bold text-[#FF7518] uppercase tracking-[0.2em]">Support Center</span>
                    </div>

                    <h2 class="text-4xl md:text-5xl font-black text-[#161f36] leading-[1.1] mb-6">
                        Ada yang bisa <br> <span class="text-[#FF7518]">kami bantu?</span>
                    </h2>

                    <p class="text-gray-500 text-lg leading-relaxed mb-8">
                        Temukan solusi cepat terkait pembangunan infrastruktur tower dan layanan kami melalui ringkasan FAQ
                        di samping.
                    </p>

                    <div class="flex flex-col gap-4">
                        <a href="{{ route('faq') }}"
                            class="group inline-flex items-center justify-between p-4 bg-white rounded-2xl border border-slate-100 shadow-sm hover:shadow-md hover:border-[#FF7518] transition-all duration-300">
                            <span class="font-bold text-[#161f36]">Pusat Bantuan Lengkap</span>
                            <div
                                class="w-8 h-8 rounded-full bg-slate-50 flex items-center justify-center group-hover:bg-[#FF7518] group-hover:text-white transition-all">
                                <i class="fas fa-arrow-right text-xs"></i>
                            </div>
                        </a>
                    </div>
                </div>

                <div class="lg:w-2/3 grid grid-cols-1 md:grid-cols-2 gap-6">

                    <div
                        class="group p-8 bg-white/70 backdrop-blur-md rounded-[2rem] border border-white shadow-sm hover:shadow-xl hover:-translate-y-2 transition-all duration-500">
                        <div
                            class="w-14 h-14 bg-gradient-to-br from-blue-50 to-white rounded-2xl flex items-center justify-center mb-8 group-hover:scale-110 transition-transform duration-500 shadow-inner">
                            <i class="fas fa-shield-check text-[#161f36] text-xl"></i>
                        </div>
                        <h4 class="text-xl font-bold text-[#161f36] mb-4">Garansi Kualitas</h4>
                        <p class="text-gray-500 text-sm leading-relaxed">
                            Kami memberikan <span class="font-bold text-[#161f36]">jaminan kualitas </span>
                            untuk memastikan keamanan jangka panjang bagi setiap infrastruktur yang kami bangun.
                        </p>
                    </div>

                    <div
                        class="group p-8 bg-white/70 backdrop-blur-md rounded-[2rem] border border-white shadow-sm hover:shadow-xl hover:-translate-y-2 transition-all duration-500">
                        <div
                            class="w-14 h-14 bg-gradient-to-br from-green-50 to-white rounded-2xl flex items-center justify-center mb-8 group-hover:scale-110 transition-transform duration-500 shadow-inner">
                            <i class="fas fa-map-marked-alt text-green-600 text-xl"></i>
                        </div>
                        <h4 class="text-xl font-bold text-[#161f36] mb-4">Cakupan Wilayah</h4>
                        <p class="text-gray-500 text-sm leading-relaxed">
                            Layanan konstruksi dan suplai material kami tersedia untuk pengiriman serta pengerjaan di <span
                                class="font-bold text-[#161f36]">seluruh wilayah Indonesia</span>.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section class="py-20 bg-slate-50 animate-on-scroll">
        <div class="max-w-screen-xl mx-auto px-4 sm:px-6 lg:px-8">
            <div
                class="group relative bg-[#161f36] rounded-[3rem] p-8 md:p-16 shadow-2xl overflow-hidden border border-white/5">

                <div
                    class="absolute top-0 right-0 w-1/2 h-full bg-gradient-to-l from-[#FF7518]/10 to-transparent opacity-50">
                </div>
                <div
                    class="absolute -right-20 -top-20 w-64 h-64 bg-[#FF7518] rounded-full blur-[120px] opacity-20 group-hover:opacity-30 transition-opacity duration-700">
                </div>

                <div
                    class="absolute -right-4 -bottom-10 opacity-[0.03] rotate-12 transition-transform duration-1000 group-hover:rotate-0">
                    <i class="fas fa-file-shield text-[20rem]"></i>
                </div>

                <div class="relative z-10 flex flex-col lg:flex-row justify-between items-center gap-12">

                    <div class="lg:w-3/5 text-center lg:text-left">
                        <div
                            class="inline-flex items-center gap-3 px-4 py-2 rounded-2xl bg-white/5 border border-white/10 mb-8">
                            <div class="flex -space-x-2">
                                <div
                                    class="w-6 h-6 rounded-full bg-blue-500 border-2 border-[#161f36] flex items-center justify-center text-[10px]">
                                    <i class="fas fa-certificate text-white"></i></div>
                                <div
                                    class="w-6 h-6 rounded-full bg-orange-500 border-2 border-[#161f36] flex items-center justify-center text-[10px]">
                                    <i class="fas fa-shield-alt text-white"></i></div>
                            </div>
                            <span class="text-[11px] font-bold text-slate-300 uppercase tracking-widest">Standardized &
                                Certified</span>
                        </div>

                        <h3 class="text-3xl md:text-5xl font-black text-white mb-6 leading-tight">
                            Komitmen Kami pada <br>
                            <span class="text-transparent bg-clip-text bg-gradient-to-r from-white to-slate-400">Legalitas
                                & Keamanan</span>
                        </h3>

                        <p class="text-slate-400 text-lg leading-relaxed mb-10 max-w-2xl mx-auto lg:mx-0">
                            Keamanan investasi Anda adalah prioritas kami. Setiap proyek dipayungi oleh <span
                                class="text-white font-semibold">Surat Perintah Kerja (SPK)</span> resmi dan standar
                            material bersertifikasi internasional.
                        </p>

                        <div class="flex flex-wrap justify-center lg:justify-start gap-4">
                            <div
                                class="flex items-center gap-3 bg-white/5 backdrop-blur-sm border border-white/10 px-5 py-3 rounded-2xl group/item hover:bg-white/10 transition-colors">
                                <i class="fas fa-check-double text-[#FF7518] text-sm"></i>
                                <span class="text-xs font-bold text-slate-200 uppercase tracking-wider">Material ISO &
                                    SNI</span>
                            </div>
                            <div
                                class="flex items-center gap-3 bg-white/5 backdrop-blur-sm border border-white/10 px-5 py-3 rounded-2xl group/item hover:bg-white/10 transition-colors">
                                <i class="fas fa-gavel text-[#FF7518] text-sm"></i>
                                <span class="text-xs font-bold text-slate-200 uppercase tracking-wider">Proteksi Hukum
                                    SPK</span>
                            </div>
                        </div>
                    </div>

                    <div class="lg:w-2/5 flex flex-col items-center lg:items-end">
                        <div class="relative group/btn">
                            <div
                                class="absolute -inset-1 bg-[#FF7518] rounded-2xl blur opacity-30 group-hover/btn:opacity-60 transition duration-500">
                            </div>

                            <a href="{{ route('syaratketentuan') }}"
                                class="relative flex items-center gap-4 px-10 py-5 bg-[#FF7518] text-white rounded-2xl font-black text-sm uppercase tracking-widest hover:bg-orange-600 transition-all duration-300 shadow-2xl overflow-hidden">
                                <span>Baca Syarat & Ketentuan</span>
                                <i
                                    class="fas fa-chevron-right text-xs group-hover/btn:translate-x-1 transition-transform"></i>
                            </a>
                        </div>

                        <p class="mt-6 text-[10px] text-slate-500 font-bold uppercase tracking-[0.3em]">
                            Last Updated: {{ date('F Y') }}
                        </p>
                    </div>

                </div>
            </div>
        </div>
    </section>

    <section class="pt-12 pb-0 bg-slate-50 animate-on-scroll">
        <div class="max-w-screen-xl mx-auto px-4 sm:px-6 lg:px-8 mb-12">
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 items-center">
                <div class="lg:col-span-4 space-y-8">
                    <div>
                        <h3 class="text-3xl font-black text-[#282829]">Hubungi Kami</h3>
                        <p class="text-gray-500 mt-2">Siap melayani kebutuhan tower Anda.</p>
                    </div>
                    <div class="space-y-4">
                        <div class="p-6 bg-white rounded-2xl shadow-sm flex items-center gap-5">
                            <div class="w-12 h-12 rounded-xl bg-orange-50 flex items-center justify-center text-[#FF7518]">
                                <i class="fas fa-phone-alt"></i>
                            </div>
                            <div>
                                <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest">Telepon</p>
                                <p class="text-[#282829] font-bold text-sm">0813 9488 4596 / 0821 2123 3261</p>
                            </div>
                        </div>
                        <div class="p-6 bg-white rounded-2xl shadow-sm flex items-center gap-5">
                            <div class="w-12 h-12 rounded-xl bg-blue-50 flex items-center justify-center text-[#161f36]">
                                <i class="fas fa-envelope"></i>
                            </div>
                            <div>
                                <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest">Email</p>
                                <p class="text-[#282829] font-bold text-sm">project@rbmark.co.id</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="lg:col-span-8">
                    <div class="relative rounded-[2.5rem] overflow-hidden shadow-xl aspect-video lg:h-[450px] mb-[-2px]">
                        <iframe
                            src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3965.8975!2d107.8323199!3d-6.9113491!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e68dbb5021f6cbd%3A0x2b5772b4460f8ef9!2sWH%20RBM!5e0!3m2!1sid!2sid!4v1736400000000"
                            width="100%" height="100%" style="border:0;" allowfullscreen="" loading="lazy"
                            class="grayscale hover:grayscale-0 transition-all duration-1000"></iframe>

                        <div
                            class="absolute bottom-6 left-6 right-6 bg-white/90 backdrop-blur-md p-5 rounded-3xl flex flex-col md:flex-row justify-between items-center gap-4 border border-white/20 shadow-lg">
                            <div class="flex gap-4 items-start">
                                <div
                                    class="w-10 h-10 rounded-full bg-[#FF7518] flex items-center justify-center text-white shrink-0 shadow-lg">
                                    <i class="fas fa-map-marker-alt"></i>
                                </div>
                                <p class="text-xs text-[#282829] font-medium leading-tight">Jl. Cilembu Haur Ngombong<br>
                                    ( Perempatan Warung Kawat ) RT.01, RW.03 Kec. Pamulihan Sumedang 45365</p>
                            </div>
                            <a href="https://maps.app.goo.gl/..." target="_blank"
                                class="shrink-0 px-6 py-3 bg-[#161f36] text-white text-xs font-bold rounded-xl hover:bg-[#FF7518] transition-all">Buka
                                di Maps</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <div id="product-modal"
        class="hidden fixed inset-0 z-[999] flex items-center justify-center bg-black/50 backdrop-blur-sm">
        <div id="modal-content"
            class="bg-white p-8 rounded-2xl max-w-4xl w-full mx-4 max-h-[90vh] overflow-y-auto relative shadow-2xl">
            <button onclick="closeModal()" class="absolute top-4 right-4 text-gray-500 hover:text-black">
                <i class="fas fa-times text-xl"></i>
            </button>
            <div id="modal-body-inner"></div>
        </div>
    </div>
