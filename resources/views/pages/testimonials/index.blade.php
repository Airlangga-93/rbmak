@extends('layouts.app')

@section('title', 'Testimonials - PT. RBM')

@section('content')
    {{-- 🏔️ PREMIUM BREADCRUMB --}}
    <div class="bg-[#161f36] py-8 border-b border-white/5">
        <div class="max-w-7xl mx-auto px-6">
            <nav class="flex items-center gap-4 text-[10px] font-black uppercase tracking-[0.3em]">
                <a href="/" class="text-white/40 hover:text-[#FF7518] transition-colors">Home</a>
                <i class="fas fa-chevron-right text-[8px] text-white/20"></i>
                <span class="text-[#FF7518]">Testimonials</span>
            </nav>
            <h1 class="text-3xl md:text-4xl font-black text-white uppercase tracking-tighter mt-4">
                Client <span class="text-[#FF7518]">Voices</span>
            </h1>
        </div>
    </div>

    <div class="bg-[#F8FAFC] min-h-screen pb-24">
        <div class="container mx-auto px-6 -mt-8">

            {{-- 📦 MAIN CONTAINER --}}
            <div class="bg-white rounded-[2.5rem] shadow-2xl shadow-slate-200/50 border border-slate-100 overflow-hidden">

                {{-- 🎭 HEADER SECTION --}}
                <div class="px-8 md:px-12 py-10 border-b border-slate-50 flex flex-col md:flex-row md:items-center justify-between gap-6">
                    <div class="max-w-xl">
                        <div class="flex items-center gap-3 mb-2">
                            <span class="w-8 h-[2px] bg-[#FF7518]"></span>
                            <span class="text-[10px] font-black text-[#FF7518] uppercase tracking-[0.2em]">Kredibilitas & Kepercayaan</span>
                        </div>
                        <h2 class="text-2xl md:text-3xl font-black text-[#161f36] uppercase tracking-tight leading-none">
                            Apa Kata Mereka Tentang <br class="hidden md:block"> Layanan PT. RBM
                        </h2>
                    </div>
                    <div class="hidden lg:flex w-16 h-16 rounded-3xl bg-slate-50 items-center justify-center border border-slate-100 rotate-3 group hover:rotate-0 transition-transform duration-500">
                        <i class="fas fa-quote-right text-[#FF7518] text-2xl opacity-40"></i>
                    </div>
                </div>

                {{-- 🃏 TESTIMONIALS GRID --}}
                <div class="p-8 md:p-12 bg-slate-50/30">
                    @if ($testimonials->count() > 0)
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                            @foreach ($testimonials as $testimonial)
                                <div class="bg-white rounded-[2rem] p-8 shadow-sm border border-slate-100 hover:shadow-xl hover:-translate-y-1 transition-all duration-500 flex flex-col justify-between group">
                                    <div>
                                        {{-- Rating Stars --}}
                                        <div class="flex gap-1 mb-6">
                                            @for ($i = 0; $i < 5; $i++)
                                                <i class="fas fa-star text-[10px] text-[#FF7518]"></i>
                                            @endfor
                                        </div>

                                        {{-- Message --}}
                                        <div class="relative">
                                            <i class="fas fa-quote-left absolute -top-2 -left-2 text-slate-100 text-4xl -z-10"></i>
                                            <p class="text-slate-500 text-sm leading-[1.8] italic relative z-10">
                                                "{!! nl2br(e($testimonial->message)) !!}"
                                            </p>
                                        </div>
                                    </div>

                                    {{-- User Identity --}}
                                    <div class="mt-8 pt-8 border-t border-slate-50 flex items-center gap-4">
                                        @if ($testimonial->image)
                                            <img src="{{ asset('storage/' . $testimonial->image) }}"
                                                 alt="{{ $testimonial->name }}"
                                                 class="w-12 h-12 rounded-2xl object-cover ring-4 ring-slate-50">
                                        @else
                                            <div class="w-12 h-12 rounded-2xl bg-[#161f36] flex items-center justify-center text-white text-xs">
                                                <i class="fas fa-user-tie"></i>
                                            </div>
                                        @endif

                                        <div class="overflow-hidden">
                                            <h5 class="font-black text-[#161f36] text-sm uppercase truncate">{{ $testimonial->name }}</h5>
                                            @if ($testimonial->company)
                                                <p class="text-[9px] font-black text-[#FF7518] uppercase tracking-widest mt-0.5 truncate">
                                                    {{ $testimonial->company }}
                                                </p>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        {{-- 📭 EMPTY STATE --}}
                        <div class="py-24 flex flex-col items-center text-center">
                            <div class="w-24 h-24 bg-white rounded-[2rem] shadow-inner flex items-center justify-center mb-6">
                                <i class="fas fa-comments text-4xl text-slate-200"></i>
                            </div>
                            <h5 class="text-xl font-black text-[#161f36] uppercase tracking-tight mb-2">Belum Ada Testimonial</h5>
                            <p class="text-slate-400 text-sm max-w-sm leading-relaxed">
                                Suara pelanggan kami sedang dalam proses moderasi. Jadilah yang pertama memberikan ulasan!
                            </p>
                        </div>
                    @endif
                </div>

                {{-- 🚀 FOOTER CTA --}}
                <div class="p-12 text-center bg-gradient-to-b from-white to-slate-50/50">
                    <div class="max-w-2xl mx-auto">
                        <p class="text-[10px] font-black text-slate-400 uppercase tracking-[0.3em] mb-4">Ingin berbagi pengalaman?</p>
                        <h3 class="text-2xl font-black text-[#161f36] uppercase tracking-tight mb-8">
                            Kepuasan Anda Adalah <br> Prioritas Infrastruktur Kami
                        </h3>

                        <a href="{{ route('send.testimonial') }}"
                           class="inline-flex items-center gap-4 px-10 py-5 bg-[#161f36] text-white rounded-2xl font-black uppercase text-[10px] tracking-[0.2em] hover:bg-[#FF7518] hover:shadow-2xl hover:shadow-[#FF7518]/30 transition-all duration-500 group">
                            <i class="fas fa-pen-nib group-hover:rotate-12 transition-transform"></i>
                            Kirim Testimonial Anda
                        </a>
                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection
