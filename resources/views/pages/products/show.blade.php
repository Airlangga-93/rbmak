@extends('layouts.app')

@section('title', $product->name . ' - PT. RBM')

@section('content')
{{-- Menggunakan Plus Jakarta Sans untuk look yang lebih modern & clean --}}
<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

@php
    $getProductImage = function($imagePath) {
        if (!$imagePath) return null;
        if (str_contains($imagePath, 'assets/')) {
            return asset($imagePath);
        }
        return asset('storage/' . $imagePath);
    };

    $mainImage = $getProductImage($product->image);
@endphp

<div class="bg-[#F8FAFC] min-h-screen font-['Plus_Jakarta_Sans']">

    {{-- 🌌 1. HERO BANNER --}}
    <section class="relative w-full h-[40vh] lg:h-[45vh] flex items-center overflow-hidden bg-[#161f36]">
        <div class="absolute inset-0 z-0">
            @if ($mainImage)
                <img src="{{ $mainImage }}" class="w-full h-full object-cover object-center opacity-20 blur-sm scale-110" alt="Banner">
            @endif
            <div class="absolute inset-0 bg-gradient-to-r from-[#161f36] via-[#161f36]/80 to-transparent"></div>
        </div>

        <div class="relative z-10 w-full max-w-7xl mx-auto px-6 lg:px-12">
            <nav class="flex mb-4">
                <ol class="inline-flex items-center space-x-3 text-[10px] uppercase tracking-[0.4em] font-extrabold text-slate-400">
                    <li><a href="/" class="hover:text-[#FF7518] transition-colors">Home</a></li>
                    <li><span class="w-1 h-1 bg-slate-600 rounded-full"></span></li>
                    <li><a href="{{ route('products') }}" class="hover:text-[#FF7518] transition-colors">Products</a></li>
                </ol>
            </nav>
            <h1 class="text-4xl md:text-6xl font-black text-white uppercase tracking-tighter leading-none italic">
                PRODUCT<span class="text-[#FF7518] block mt-2 not-italic">SPECIFICATION</span>
            </h1>
        </div>
    </section>

    {{-- 🏗️ 2. MAIN CONTENT AREA --}}
    {{-- Menambahkan padding-top (pt-24) dan margin-top (-mt-16) untuk jarak yang lebih dinamis --}}
    <section class="relative z-20 pb-24 pt-10 lg:pt-16 -mt-16">
        <div class="max-w-7xl mx-auto px-6 lg:px-12">
            <div class="flex flex-col lg:flex-row gap-10">

                {{-- KOLOM KIRI (8/12): FOTO & DETAIL --}}
                <div class="lg:w-8/12">
                    <div class="bg-white rounded-[3rem] shadow-[0_20px_60px_-15px_rgba(0,0,0,0.05)] overflow-hidden border border-white/60 backdrop-blur-sm">
                        <div class="flex flex-col md:flex-row">

                            {{-- FOTO PRODUK --}}
                            <div class="md:w-5/12 bg-slate-50/50 p-8 flex items-center justify-center relative">
                                <div class="relative w-full aspect-square bg-white rounded-[2.5rem] shadow-sm overflow-hidden flex items-center justify-center p-6 border border-slate-100 group">
                                    @if ($mainImage)
                                        <img src="{{ $mainImage }}" alt="{{ $product->name }}" class="max-w-full max-h-full object-contain group-hover:scale-110 transition-transform duration-700 ease-out">
                                    @else
                                        <i class="fas fa-image text-6xl text-slate-200"></i>
                                    @endif
                                </div>
                            </div>

                            {{-- DESKRIPSI & INFO --}}
                            <div class="md:w-7/12 p-10 lg:p-12 flex flex-col justify-between">
                                <div>
                                    <div class="flex items-center gap-3 mb-6">
                                        <span class="bg-[#FF7518]/10 text-[#FF7518] px-4 py-1.5 rounded-full text-[10px] font-black uppercase tracking-widest border border-[#FF7518]/20">
                                            {{ $product->type }}
                                        </span>
                                    </div>

                                    <h2 class="text-3xl lg:text-4xl font-black text-[#161f36] uppercase tracking-tight mb-8 leading-[1.1]">
                                        {{ $product->name }}
                                    </h2>

                                    <div class="space-y-6">
                                        <div>
                                            <h4 class="text-[11px] font-bold text-slate-400 uppercase tracking-[0.2em] mb-3 flex items-center gap-2">
                                                <span class="w-5 h-[1px] bg-[#FF7518]"></span> Informasi Produk
                                            </h4>
                                            <div class="text-slate-600 text-sm lg:text-base leading-relaxed">
                                                {!! nl2br(e($product->description)) !!}
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                {{-- HARGA & BOOKING CTA --}}
                                <div class="mt-12 pt-8 border-t border-slate-100 flex flex-wrap items-end justify-between gap-6">
                                    <div>
                                        <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-1">Estimasi Biaya</p>
                                        <h3 class="text-3xl font-black text-[#161f36]">
                                            <span class="text-[#FF7518] text-sm italic font-medium uppercase">Idr</span> {{ number_format($product->price, 0, ',', '.') }}
                                        </h3>
                                    </div>

                                    @php
                                        $waMessage = "Halo Admin PT. RBM, saya tertarik untuk booking jasa/produk " . $product->name . " (Type: " . $product->type . "). Mohon informasi jadwal dan prosedurnya.";
                                    @endphp
                                    <a href="https://wa.me/6281234567890?text={{ urlencode($waMessage) }}"
                                       target="_blank"
                                       class="bg-[#161f36] text-white px-8 py-4 rounded-2xl font-black text-[11px] uppercase tracking-widest hover:bg-[#FF7518] transition-all hover:shadow-[0_10px_30px_rgba(255,117,24,0.3)] transform hover:-translate-y-1 active:scale-95 flex items-center gap-3">
                                        <i class="fas fa-calendar-check text-base"></i> Booking Sekarang
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- KOLOM KANAN (4/12): SIDEBAR --}}
                <div class="lg:w-4/12 space-y-8">

                    {{-- Produk Serupa --}}
                    <div class="bg-white rounded-[2.5rem] p-8 lg:p-10 shadow-[0_15px_40px_rgba(0,0,0,0.03)] border border-slate-100">
                        <div class="flex items-center justify-between mb-8">
                            <h3 class="text-[#161f36] font-black uppercase tracking-widest text-xs flex items-center gap-3">
                                <span class="w-1.5 h-6 bg-[#FF7518] rounded-full"></span>
                                Produk Serupa
                            </h3>
                        </div>

                        <div class="space-y-6">
                            @forelse ($recommended_products as $item)
                                @php $recImage = $getProductImage($item->image); @endphp
                                <a href="{{ route('product.show', $item->id) }}" class="group flex items-center gap-5 transition-all">
                                    <div class="w-16 h-16 flex-shrink-0 rounded-2xl overflow-hidden bg-slate-50 border border-slate-100 p-2 group-hover:border-[#FF7518]/30 transition-colors">
                                        <img src="{{ $recImage ?? 'https://via.placeholder.com/100' }}" class="w-full h-full object-contain group-hover:scale-110 transition-transform duration-500">
                                    </div>
                                    <div class="flex-1">
                                        <h4 class="text-[11px] font-black text-[#161f36] group-hover:text-[#FF7518] transition-colors line-clamp-2 uppercase leading-tight mb-1">
                                            {{ $item->name }}
                                        </h4>
                                        <p class="text-[10px] font-bold text-[#FF7518]/80 italic">Rp {{ number_format($item->price, 0, ',', '.') }}</p>
                                    </div>
                                </a>
                            @empty
                                <div class="text-center py-6">
                                    <p class="text-slate-400 text-[10px] italic">Belum ada produk serupa</p>
                                </div>
                            @endforelse
                        </div>

                        <a href="{{ route('products') }}" class="mt-10 flex items-center justify-center w-full py-4 bg-slate-50 text-slate-500 rounded-2xl text-[10px] font-extrabold uppercase tracking-widest hover:bg-[#161f36] hover:text-white transition-all group border border-slate-100">
                            Lihat Semua Produk <i class="fas fa-arrow-right ml-2 transform group-hover:translate-x-1 transition-transform"></i>
                        </a>
                    </div>

                    {{-- Card Info Tambahan (Optional but modern) --}}
                    <div class="bg-[#161f36] rounded-[2.5rem] p-8 text-white relative overflow-hidden group">
                        <div class="relative z-10">
                            <p class="text-[10px] font-bold text-[#FF7518] uppercase tracking-[0.3em] mb-2">Butuh Bantuan?</p>
                            <h4 class="text-lg font-bold mb-4 leading-tight uppercase">Konsultasi Gratis Dengan Tim Ahli Kami</h4>
                            <a href="https://wa.me/6281234567890" class="text-[10px] font-black uppercase tracking-widest flex items-center gap-2 group-hover:gap-4 transition-all">
                                Hubungi Sekarang <i class="fas fa-chevron-right text-[8px]"></i>
                            </a>
                        </div>
                        <i class="fab fa-whatsapp absolute -bottom-4 -right-4 text-7xl opacity-10 group-hover:scale-125 transition-transform duration-700"></i>
                    </div>
                </div>

            </div>
        </div>
    </section>
</div>

<style>
    /* Smooth Animation */
    @keyframes fadeInUp {
        from { opacity: 0; transform: translateY(30px); }
        to { opacity: 1; transform: translateY(0); }
    }
    .relative.z-20 { animation: fadeInUp 1s cubic-bezier(0.22, 1, 0.36, 1) forwards; }

    /* Custom Scrollbar for better UX */
    ::-webkit-scrollbar { width: 8px; }
    ::-webkit-scrollbar-track { background: #F8FAFC; }
    ::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 10px; }
    ::-webkit-scrollbar-thumb:hover { background: #FF7518; }
</style>
@endsection
