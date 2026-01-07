@extends('layouts.app')

@section('content')
{{-- Load Font Premium --}}
<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

@php
    $brandOrange = '#FF7518';
    $brandDark = '#161f36';
    $hasGallery = isset($newsImages) && $newsImages->isNotEmpty();

    $fallbackHero = collect($randomNews ?? [])
        ->filter(fn($n) => !empty($n->image))
        ->first();
@endphp

<style>
    body { font-family: 'Plus Jakarta Sans', sans-serif; background-color: #F8FAFC; }
    .article-content { color: #475569; line-height: 1.8; }
    .article-content h2 { color: #161f36; font-weight: 800; margin-top: 2.5rem; margin-bottom: 1.25rem; font-size: 1.75rem; tracking-tight; }
    .article-content p { margin-bottom: 1.5rem; font-size: 1.1rem; }
    .article-content img { border-radius: 2.5rem; margin: 3rem 0; box-shadow: 0 25px 50px -12px rgba(0,0,0,0.08); }

    /* Animasi halus saat scroll */
    .reveal { opacity: 0; transform: translateY(30px); transition: all 0.8s ease-out; }
    .reveal.active { opacity: 1; transform: translateY(0); }
</style>

<div>
    {{-- ================= 🌌 HERO HEADER ================= --}}
    <section class="relative w-full h-[35vh] lg:h-[45vh] bg-[#161f36] overflow-hidden">
        @if (!empty($news->image))
            <img src="{{ asset('storage/'.$news->image) }}" alt="{{ $news->title }}" class="w-full h-full object-cover opacity-40 scale-110 blur-[2px]">
        @elseif ($fallbackHero)
            <img src="{{ asset('storage/'.$fallbackHero->image) }}" alt="{{ $fallbackHero->title }}" class="w-full h-full object-cover opacity-30 blur-sm">
        @endif

        <div class="absolute inset-0 bg-gradient-to-b from-[#161f36]/80 via-[#161f36]/40 to-transparent"></div>

        <div class="absolute inset-0 flex items-center justify-center">
            <div class="max-w-screen-xl mx-auto px-6 w-full text-center">
                <nav class="mb-4 flex justify-center">
                    <ol class="inline-flex items-center space-x-3 text-[10px] font-black uppercase tracking-[0.4em] text-slate-400">
                        <li><a href="/" class="hover:text-white transition">Home</a></li>
                        <li><span class="w-1 h-1 bg-slate-500 rounded-full"></span></li>
                        <li><a href="{{ route('news.index') }}" class="hover:text-white transition">News Detail</a></li>
                    </ol>
                </nav>
                <h2 class="text-white text-xs font-black uppercase tracking-[0.5em] opacity-60">Article Reader</h2>
            </div>
        </div>
    </section>

    {{-- ================= 🏗️ MAIN CONTENT AREA ================= --}}
    {{-- Margin top (mt-20) memberikan jarak yang cukup agar tidak menempel ke banner --}}
    <main class="max-w-screen-xl mx-auto px-6 pb-24 relative z-20 mt-12 lg:mt-20">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 lg:gap-16">

            {{-- 📝 KOLOM KIRI: ARTIKEL --}}
            <div class="lg:col-span-8">
                <div class="bg-white rounded-[3rem] p-8 lg:p-16 shadow-[0_40px_100px_-20px_rgba(0,0,0,0.04)] border border-slate-100">

                    {{-- Judul & Label --}}
                    <div class="mb-10 text-center lg:text-left">
                        <span class="inline-block bg-[#FF7518]/10 text-[#FF7518] px-4 py-1.5 rounded-full text-[10px] font-black uppercase tracking-widest mb-6">
                            Warta Terbaru
                        </span>
                        <h1 class="text-3xl lg:text-5xl font-black text-[#161f36] leading-[1.2] tracking-tighter mb-8">
                            {{ $news->title }}
                        </h1>
                    </div>

                    {{-- Metadata Bar --}}
                    <div class="flex flex-wrap items-center gap-8 py-8 mb-12 border-y border-slate-50 justify-center lg:justify-start">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-xl bg-slate-50 flex items-center justify-center text-[#FF7518]">
                                <i class="far fa-calendar-alt"></i>
                            </div>
                            <span class="text-sm font-bold text-slate-600">{{ \Carbon\Carbon::parse($news->date_published)->translatedFormat('d F Y') }}</span>
                        </div>
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-xl bg-slate-50 flex items-center justify-center text-[#161f36]">
                                <i class="far fa-user"></i>
                            </div>
                            <span class="text-sm font-bold text-slate-600">Oleh: <span class="text-[#161f36]">{{ $news->publisher ?? 'Admin' }}</span></span>
                        </div>
                    </div>

                    {{-- Foto Utama Artikel (Jika Ada) --}}
                    @if (!empty($news->image))
                    <div class="mb-12">
                        <img src="{{ asset('storage/'.$news->image) }}" alt="{{ $news->title }}" class="w-full rounded-[2.5rem] shadow-xl">
                    </div>
                    @endif

                    {{-- Isi Artikel --}}
                    <article class="article-content prose prose-slate max-w-none">
                        {!! $news->description !!}
                    </article>

                    {{-- 📸 GALERI --}}
                    @if ($hasGallery)
                    <div class="mt-20 pt-16 border-t border-slate-50" x-data="{ open:false, img:'' }">
                        <h3 class="text-2xl font-black text-[#161f36] uppercase tracking-tight mb-10 flex items-center gap-4 italic">
                            <span class="w-10 h-[2px] bg-[#FF7518]"></span> Documentations
                        </h3>

                        <div class="grid grid-cols-2 md:grid-cols-3 gap-6">
                            @foreach ($newsImages as $img)
                            <div @click="img='{{ asset('storage/'.$img->path) }}';open=true"
                                 class="group aspect-square rounded-[2rem] overflow-hidden cursor-pointer bg-slate-100 relative">
                                <img src="{{ asset('storage/'.$img->path) }}" class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110">
                                <div class="absolute inset-0 bg-[#161f36]/40 opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center text-white">
                                    <i class="fas fa-search-plus text-2xl"></i>
                                </div>
                            </div>
                            @endforeach
                        </div>

                        {{-- Lightbox Modal --}}
                        <div x-show="open" x-cloak class="fixed inset-0 z-[100] bg-[#161f36]/95 backdrop-blur-md flex items-center justify-center p-6" @click.self="open=false">
                            <button @click="open=false" class="absolute top-8 right-8 text-white text-3xl"><i class="fas fa-times"></i></button>
                            <img :src="img" class="max-h-[90vh] rounded-[2rem] shadow-2xl border border-white/10 transition-all">
                        </div>
                    </div>
                    @endif
                </div>
            </div>

            {{-- ⚡ KOLOM KANAN: SIDEBAR --}}
            <aside class="lg:col-span-4 space-y-10">

                {{-- Tombol Navigasi --}}
                <div class="bg-white rounded-[2.5rem] p-6 shadow-sm border border-slate-100">
                    <a href="{{ route('news.index') }}"
                       class="flex items-center justify-center w-full py-4 bg-[#161f36] text-white rounded-2xl font-black text-[10px] uppercase tracking-[0.2em] hover:bg-[#FF7518] transition-all group shadow-lg shadow-slate-200">
                        <i class="fas fa-arrow-left mr-3 group-hover:-translate-x-2 transition-transform"></i> Kembali ke Berita
                    </a>
                </div>

                {{-- Berita Terkait --}}
                <div class="bg-white rounded-[3rem] p-8 shadow-sm border border-slate-100">
                    <h3 class="text-xs font-black uppercase tracking-[0.3em] text-slate-400 mb-8 flex items-center gap-3">
                        <span class="w-1.5 h-1.5 bg-[#FF7518] rounded-full"></span> Recommended
                    </h3>

                    <div class="space-y-8">
                        @foreach ($randomNews ?? [] as $item)
                            <a href="{{ route('news.show', $item->id) }}" class="group flex items-center gap-5">
                                <div class="w-20 h-20 flex-shrink-0 rounded-2xl overflow-hidden bg-slate-50 border border-slate-100">
                                    @if (!empty($item->image))
                                        <img src="{{ asset('storage/'.$item->image) }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                                    @else
                                        <div class="w-full h-full flex items-center justify-center text-slate-200"><i class="fas fa-image"></i></div>
                                    @endif
                                </div>
                                <div class="flex-1">
                                    <h4 class="text-xs font-black text-[#161f36] group-hover:text-[#FF7518] transition-colors line-clamp-2 uppercase leading-snug mb-2">
                                        {{ $item->title }}
                                    </h4>
                                    <p class="text-[9px] font-bold text-slate-400 uppercase tracking-widest">
                                        {{ \Carbon\Carbon::parse($item->date_published)->diffForHumans() }}
                                    </p>
                                </div>
                            </a>
                        @endforeach
                    </div>
                </div>

            </aside>
        </div>
    </main>
</div>

<script>
    // Reveal effect on scroll
    window.addEventListener('scroll', () => {
        let reveals = document.querySelectorAll('.reveal');
        reveals.forEach(reveal => {
            let windowHeight = window.innerHeight;
            let revealTop = reveal.getBoundingClientRect().top;
            if (revealTop < windowHeight - 100) { reveal.classList.add('active'); }
        });
    });
</script>

@endsection
