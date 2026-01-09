@extends('layouts.app')
@section('title', 'Galeri Proyek & Portofolio - PT. RBM')

@section('content')
{{-- Library Assets --}}
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.4/css/lightbox.min.css" />
<script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
<link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">

<div class="bg-white min-h-screen font-sans text-[#161f36] selection:bg-[#FF7518]/30"
     x-data="{
        items: [
            @foreach($galleries as $gallery)
            @php
                // Logika Penentuan Path Gambar yang Fleksibel
                if (str_starts_with($gallery->image, 'assets/')) {
                    $finalImg = asset($gallery->image);
                } elseif (str_starts_with($gallery->image, 'gallery/')) {
                    $finalImg = asset('assets/img/' . $gallery->image);
                } else {
                    $finalImg = asset('storage/' . $gallery->image);
                }
            @endphp
            {
                id: {{ $gallery->id }},
                cat: '{{ strtolower($gallery->category ?? 'Proyek') }}',
                img: '{{ $finalImg }}',
                title: '{{ $gallery->title ?? 'Dokumentasi PT. RBM' }}'
            },
            @endforeach
        ],
        activeSlide: 0,
        slides: [],
        init() {
            // Ambil 3 gambar pertama untuk slider hero secara otomatis
            this.slides = this.items.slice(0, 3).map(i => i.img);

            if(this.slides.length > 0) {
                setInterval(() => {
                    this.activeSlide = (this.activeSlide + 1) % this.slides.length;
                }, 5000);
            }
        }
     }">

    {{-- 🌌 HERO SECTION: CINEMATIC DYNAMIC BANNER --}}
    <section class="relative h-[60vh] min-h-[500px] flex items-center bg-[#161f36] overflow-hidden">
        {{-- Background Slider --}}
        <template x-for="(slide, index) in slides" :key="index">
            <div x-show="activeSlide === index"
                 x-transition:enter="transition ease-out duration-1000"
                 x-transition:enter-start="opacity-0 scale-110"
                 x-transition:enter-end="opacity-30 scale-100"
                 x-transition:leave="transition ease-in duration-1000"
                 x-transition:leave-start="opacity-30"
                 x-transition:leave-end="opacity-0"
                 class="absolute inset-0 z-0">
                <img :src="slide" class="w-full h-full object-cover">
            </div>
        </template>

        {{-- Decorative Overlays --}}
        <div class="absolute inset-0 opacity-20" style="background-image: url('https://www.transparenttextures.com/patterns/carbon-fibre.png');"></div>
        <div class="absolute top-0 right-0 w-2/3 h-full bg-gradient-to-l from-[#FF7518]/10 to-transparent -skew-x-12 translate-x-1/4"></div>
        <div class="absolute inset-0 bg-gradient-to-r from-[#161f36] via-[#161f36]/60 to-transparent z-0"></div>

        <div class="container mx-auto px-6 relative z-10">
            <div class="max-w-4xl">
                <div class="inline-flex items-center gap-3 px-4 py-2 rounded-full bg-white/10 backdrop-blur-md border border-white/20 mb-8" data-aos="fade-right">
                    <span class="w-2 h-2 bg-[#FF7518] rounded-full animate-pulse"></span>
                    <span class="text-[10px] font-black text-white uppercase tracking-[0.4em]">Official Portfolio</span>
                </div>
                <h1 class="text-5xl md:text-7xl lg:text-8xl font-black text-white leading-[0.85] uppercase tracking-tighter mb-8" data-aos="zoom-out-right">
                    Visual <br><span class="text-[#FF7518]">Experience</span>
                </h1>
                <p class="text-slate-400 text-lg md:text-xl max-w-xl font-medium leading-relaxed border-l-4 border-[#FF7518] pl-6" data-aos="fade-up" data-aos-delay="200">
                    Eksplorasi dokumentasi proyek infrastruktur telekomunikasi kami yang tersebar di seluruh penjuru Indonesia.
                </p>
            </div>
        </div>
    </section>

    {{-- 🖼️ MODERN GALLERY GRID --}}
    <section class="py-24 bg-slate-50">
        <div class="container mx-auto px-6">
            {{-- Header Grid --}}
            <div class="flex items-end justify-between mb-16 border-b border-slate-200 pb-8">
                <div>
                    <h2 class="text-3xl font-black uppercase tracking-tight text-[#161f36]">Katalog Proyek</h2>
                    <p class="text-xs text-slate-500 uppercase tracking-widest mt-2">Menampilkan karya terbaik PT. RBM</p>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-x-10 gap-y-16">
                <template x-for="(item, index) in items" :key="item.id">
                    <div class="flex flex-col group" data-aos="fade-up" :data-aos-delay="index * 100">

                        {{-- 1. JUDUL (DI ATAS GAMBAR) --}}
                        <div class="mb-5">
                            <div class="flex items-center gap-3 mb-3">
                                <span class="text-[9px] font-black text-[#FF7518] uppercase tracking-[0.2em] bg-orange-100 px-3 py-1 rounded" x-text="item.cat"></span>
                                <div class="h-px flex-1 bg-slate-200"></div>
                            </div>
                            <h4 class="text-xl font-black text-[#161f36] leading-tight uppercase tracking-tight group-hover:text-[#FF7518] transition-colors duration-300" x-text="item.title"></h4>
                        </div>

                        {{-- 2. GAMBAR (DI BAWAH JUDUL) --}}
                        <div class="relative h-[380px] w-full rounded-[2.5rem] overflow-hidden shadow-sm group-hover:shadow-2xl transition-all duration-700 hover:-translate-y-2 border border-slate-100 bg-white">
                            <img :src="item.img" :alt="item.title" class="w-full h-full object-cover transition-transform duration-1000 group-hover:scale-110">

                            {{-- Minimalist Overlay --}}
                            <div class="absolute inset-0 bg-gradient-to-t from-[#161f36]/60 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-500 flex items-center justify-center">
                                <a :href="item.img" data-lightbox="rbm-gallery" :data-title="item.title"
                                   class="w-14 h-14 bg-white rounded-2xl flex items-center justify-center text-[#161f36] hover:bg-[#FF7518] hover:text-white transition-all transform scale-50 group-hover:scale-100 shadow-xl">
                                    <i class="fas fa-search-plus text-xl"></i>
                                </a>
                            </div>
                        </div>

                    </div>
                </template>
            </div>

            {{-- Empty State --}}
            <div x-show="items.length === 0" x-cloak class="py-40 text-center">
                <i class="fas fa-images text-slate-200 text-6xl mb-6"></i>
                <h3 class="text-xl font-bold text-slate-400 uppercase tracking-widest">Belum Ada Dokumentasi</h3>
            </div>
        </div>
    </section>

    {{-- 📞 CONTACT CTA --}}
    <section class="py-24 px-6 bg-white">
        <div class="container mx-auto max-w-6xl text-center">
            <div class="relative bg-[#161f36] rounded-[4rem] p-12 md:p-24 overflow-hidden shadow-2xl" data-aos="flip-up">
                <div class="absolute top-0 left-0 w-96 h-96 bg-[#FF7518]/20 rounded-full blur-[120px] -translate-x-1/2 -translate-y-1/2"></div>

                <div class="relative z-10">
                    <h2 class="text-4xl md:text-6xl font-black text-white uppercase tracking-tighter leading-[0.9] mb-8">
                        Siap Membangun <br> <span class="text-[#FF7518]">Bersama Kami?</span>
                    </h2>
                    <p class="text-slate-400 text-sm md:text-lg max-w-2xl mx-auto mb-12 font-medium">
                        Konsultasikan kebutuhan infrastruktur Anda dengan tim profesional kami sekarang.
                    </p>
                    <a href="{{ route('contact') }}" class="group inline-flex items-center px-12 py-5 bg-[#FF7518] text-white rounded-2xl font-black text-[11px] uppercase tracking-[0.2em] shadow-xl hover:bg-white hover:text-[#161f36] transition-all duration-500">
                        Mulai Konsultasi
                        <i class="fas fa-chevron-right ml-3 group-hover:translate-x-2 transition-transform"></i>
                    </a>
                </div>
            </div>
        </div>
    </section>
</div>

{{-- Scripts --}}
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.4/js/lightbox.min.js"></script>
<script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        AOS.init({ duration: 1000, once: true, easing: 'ease-out-quint' });

        lightbox.option({
            'resizeDuration': 400,
            'wrapAround': true,
            'showImageNumberLabel': false,
            'imageFadeDuration': 600
        });
    });
</script>

<style>
    [x-cloak] { display: none !important; }

    /* Custom Lightbox Styling */
    .lightboxOverlay { background: rgba(10, 15, 28, 0.98) !important; backdrop-filter: blur(10px); }
    .lb-data .lb-caption {
        font-family: inherit;
        font-weight: 900;
        text-transform: uppercase;
        color: #FF7518;
        font-size: 1.2rem;
        letter-spacing: 2px;
        padding-top: 20px;
    }
    .lb-outerContainer { border-radius: 2.5rem; background: transparent !important; }
    .lb-image { border-radius: 2.5rem; border: 4px solid rgba(255,255,255,0.1); }
</style>
@endsection
