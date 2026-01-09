@extends('layouts.app')

@section('content')
{{-- Load Font Premium --}}
<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

@php
    $amaliahGreen = '#63cd00';
    $amaliahDark = '#161f36';
    $amaliahOrange = '#FF7518';

    $hasImages = isset($newsImages) && $newsImages->isNotEmpty();
    $bannerFromNews = isset($news) && $news->count() > 0 ? $news->firstWhere('image', '!=', null) : null;
@endphp

<style>
    body { font-family: 'Plus Jakarta Sans', sans-serif; }
    .glass-effect {
        background: rgba(255, 255, 255, 0.03);
        backdrop-filter: blur(10px);
        border: 1px solid rgba(255, 255, 255, 0.1);
    }
    .news-card:hover .news-image { transform: scale(1.08); }
    .news-card:hover .read-more-btn { gap: 12px; color: {{ $amaliahOrange }}; }
</style>

<div class="bg-[#FAFBFC] min-h-screen">

    {{-- ===================== 🌌 MODERN HERO BANNER ===================== --}}
    <section class="relative h-[450px] lg:h-[550px] overflow-hidden bg-[#161f36] flex items-center">
        {{-- Background Elements --}}
        <div class="absolute inset-0 z-0">
            @if ($hasImages)
                <div x-data="{ activeSlide: 1, totalSlides: {{ $newsImages->count() }} }" x-init="setInterval(() => { activeSlide = activeSlide % totalSlides + 1 }, 6000)" class="h-full">
                    @foreach ($newsImages as $image)
                        <div x-show="activeSlide === {{ $loop->iteration }}"
                             x-transition:enter="transition opacity duration-1000"
                             x-transition:leave="transition opacity duration-1000"
                             class="absolute inset-0">
                            <img src="{{ Storage::url($image->path) }}" class="w-full h-full object-cover opacity-40 scale-105">
                        </div>
                    @endforeach
                </div>
            @elseif ($bannerFromNews)
                <img src="{{ asset('storage/' . $bannerFromNews->image) }}" class="w-full h-full object-cover opacity-30 scale-105">
            @endif
            <div class="absolute inset-0 bg-gradient-to-t from-[#161f36] via-[#161f36]/60 to-transparent"></div>
        </div>

        {{-- Hero Content --}}
        <div class="relative z-10 max-w-screen-xl mx-auto px-6 w-full">
            <div class="max-w-2xl">
                <nav class="flex mb-6" aria-label="Breadcrumb">
                    <ol class="inline-flex items-center space-x-2 text-[10px] uppercase tracking-[0.3em] font-bold text-gray-400">
                        <li><a href="/" class="hover:text-white transition">Home</a></li>
                        <li><span class="opacity-50">/</span></li>
                        <li class="text-white">News</li>
                    </ol>
                </nav>
                <h1 class="text-5xl lg:text-7xl font-black text-white leading-none mb-6 italic uppercase tracking-tighter">
                    Lensa <span class="text-[#FF7518] not-italic">RBM</span>
                </h1>
                <p class="text-gray-300 text-lg lg:text-xl font-light leading-relaxed mb-8">
                    Menelusuri jejak inovasi, proyek strategis, dan kabar terbaru dari pusat operasional kami.
                </p>
            </div>
        </div>
    </section>

    {{-- ===================== 📰 CONTENT SECTION ===================== --}}
    <section class="relative z-20 -mt-20 pb-24">
        <div class="max-w-screen-xl mx-auto px-6">

            {{-- Header Berita --}}
            <div class="flex flex-col md:flex-row md:items-end justify-between mb-12 gap-6">
                <div class="md:w-1/2">
                    <h2 class="text-sm font-black uppercase tracking-[0.4em] text-[#FF7518] mb-2">Latest Updates</h2>
                    <h3 class="text-3xl lg:text-4xl font-extrabold text-[#161f36]">Warta Eksklusif</h3>
                </div>
                <div class="h-[1px] flex-grow bg-gray-200 hidden md:block mx-10 mb-4"></div>
                <div class="text-gray-400 text-sm font-medium">Menampilkan {{ $news->count() }} Berita Terbaru</div>
            </div>

            {{-- Grid Berita --}}
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 lg:gap-12">
                @forelse ($news as $item)
                    <article class="news-card group flex flex-col bg-white rounded-[2rem] overflow-hidden shadow-[0_10px_40px_rgba(0,0,0,0.03)] border border-gray-100 hover:shadow-[0_30px_60px_rgba(0,0,0,0.1)] transition-all duration-500">

                        {{-- Image Wrapper --}}
                        <div class="relative overflow-hidden h-[280px]">
                            <a href="{{ route('news.show', $item->slug ?? $item->id) }}" class="block h-full w-full">
                                @if ($item->image)
                                    <img src="{{ asset('storage/' . $item->image) }}" alt="{{ $item->title }}"
                                         class="news-image w-full h-full object-cover transition-transform duration-700 ease-out">
                                @else
                                    <div class="w-full h-full bg-slate-50 flex items-center justify-center">
                                        <i class="fa-solid fa-clipping-path text-slate-200 text-6xl"></i>
                                    </div>
                                @endif
                            </a>
                            {{-- Floating Date --}}
                            <div class="absolute top-6 left-6">
                                <div class="bg-white/90 backdrop-blur-md px-4 py-2 rounded-xl shadow-sm text-center">
                                    <span class="block text-lg font-black text-[#161f36] leading-none">
                                        {{ $item->date_published ? \Carbon\Carbon::parse($item->date_published)->format('d') : $item->created_at->format('d') }}
                                    </span>
                                    <span class="text-[9px] uppercase font-bold tracking-widest text-gray-500">
                                        {{ $item->date_published ? \Carbon\Carbon::parse($item->date_published)->format('M') : $item->created_at->format('M') }}
                                    </span>
                                </div>
                            </div>
                        </div>

                        {{-- Body Wrapper --}}
                        <div class="p-8 flex flex-col flex-grow">
                            <div class="flex items-center gap-3 mb-4">
                                <span class="w-8 h-[2px] bg-[#FF7518]"></span>
                                <span class="text-[10px] font-black uppercase tracking-widest text-gray-400">Press Release</span>
                            </div>

                            <a href="{{ route('news.show', $item->slug ?? $item->id) }}"
                                class="text-xl lg:text-2xl font-extrabold text-[#161f36] leading-tight hover:text-[#FF7518] transition-colors mb-4 line-clamp-2">
                                {{ $item->title }}
                            </a>

                            <p class="text-gray-500 text-sm leading-relaxed line-clamp-3 mb-8">
                                {{ strip_tags($item->description ?? $item->content) }}
                            </p>

                            <div class="mt-auto pt-6 border-t border-gray-50 flex items-center justify-between">
                                <a href="{{ route('news.show', $item->slug ?? $item->id) }}"
                                    class="read-more-btn flex items-center gap-2 text-sm font-black uppercase tracking-widest text-[#161f36] transition-all">
                                    Explore <i class="fas fa-arrow-right-long"></i>
                                </a>
                                <div class="flex -space-x-2">
                                    <div class="w-8 h-8 rounded-full border-2 border-white bg-gray-100 flex items-center justify-center text-[10px] font-bold text-gray-400">R</div>
                                    <div class="w-8 h-8 rounded-full border-2 border-white bg-[#FF7518] flex items-center justify-center text-[10px] font-bold text-white">B</div>
                                </div>
                            </div>
                        </div>
                    </article>
                @empty
                    <div class="col-span-full py-20 text-center bg-white rounded-[3rem] border-2 border-dashed border-gray-100">
                        <div class="bg-slate-50 inline-block p-8 rounded-full mb-6">
                            <i class="fa-solid fa-folder-open text-slate-200 text-6xl"></i>
                        </div>
                        <h4 class="text-xl font-bold text-[#161f36]">Belum Ada Warta</h4>
                        <p class="text-gray-400 mt-2">Nantikan informasi terbaru dari kami segera.</p>
                    </div>
                @endforelse
            </div>

            {{-- Custom Pagination --}}
            <div class="mt-20 flex justify-center">
                <div class="bg-white px-6 py-4 rounded-3xl shadow-sm border border-gray-100">
                    {{ $news->links() }}
                </div>
            </div>
        </div>
    </section>

    {{-- ===================== ✉️ NEWSLETTER SECTION ===================== --}}
    <section class="max-w-screen-xl mx-auto px-6 pb-24">
        <div class="bg-[#161f36] rounded-[3rem] p-10 lg:p-16 relative overflow-hidden">
            <div class="absolute top-0 right-0 w-1/2 h-full bg-[#FF7518]/10 skew-x-12 translate-x-20"></div>
            <div class="relative z-10 flex flex-col lg:flex-row items-center justify-between gap-10">
                <div class="lg:w-1/2 text-center lg:text-left">
                    <h2 class="text-3xl lg:text-4xl font-black text-white uppercase tracking-tighter mb-4">
                        Tetap <span class="text-[#FF7518]">Terhubung</span>
                    </h2>
                    <p class="text-gray-400">Dapatkan update mingguan mengenai proyek dan teknologi terbaru langsung ke email Anda.</p>
                </div>
                <div class="lg:w-1/2 w-full">
                    <form class="flex flex-col sm:flex-row gap-4">
                        <input type="email" placeholder="Alamat Email Anda"
                               class="flex-grow bg-white/5 border border-white/10 rounded-2xl px-6 py-4 text-white focus:outline-none focus:border-[#FF7518] transition">
                        <button class="bg-[#FF7518] text-white font-black uppercase tracking-widest px-8 py-4 rounded-2xl hover:bg-white hover:text-[#161f36] transition duration-300 shadow-lg shadow-[#FF7518]/20">
                            Subscribe
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </section>
</div>

{{-- Script for entrance animations --}}
<script src="https://unpkg.com/scrollreveal"></script>
<script>
    ScrollReveal().reveal('.news-card', {
        delay: 200,
        distance: '50px',
        interval: 100,
        origin: 'bottom',
        duration: 1000,
        easing: 'cubic-bezier(0.5, 0, 0, 1)'
    });
</script>

@endsection
