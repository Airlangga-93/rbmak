@extends('layouts.app')
@section('title', 'Tentang Kami - PT. Rizqallah Boer Makmur')

@section('content')
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
<script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
<link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">

<div class="bg-[#F4F7FA] min-h-screen font-['Poppins'] text-[#161f36] overflow-x-hidden">

@php
    $about = \App\Models\About::first();
    $vision = $about?->vision ?? 'Menjadi perusahaan manajemen dan layanan teknis terdepan di Asia Tenggara yang dikenal atas keunggulan dan integritas.';
    $mission = $about?->mission ?? 'Menyediakan solusi yang inovatif dan terintegrasi. Membangun kemitraan jangka panjang berbasis kepercayaan. Mendorong pertumbuhan berkelanjutan bagi klien dan perusahaan.';
    $title = $about?->title ?? 'Mitra Solusi Manajemen Terpercaya';
    $description = $about?->description ?? 'PT. Rizqallah Boer Makmur (RBM) hadir sebagai penyedia layanan dan produk premium yang berfokus pada efisiensi, inovasi, dan hasil yang optimal.';
@endphp

{{-- 🌌 HERO --}}
<section class="relative pt-32 pb-20 lg:pt-48 lg:pb-32 bg-[#161f36] text-white overflow-hidden">
    <div class="container mx-auto px-6 text-center lg:text-left">
        <h1 class="text-4xl md:text-6xl font-black uppercase mb-6" data-aos="fade-up">
            Dedikasi, Inovasi & <span class="text-[#FF7518]">Kualitas Premium</span>
        </h1>
        <p class="text-gray-400 uppercase tracking-widest text-sm" data-aos="fade-up">
            “Membangun masa depan layanan manajemen dan teknis bersama Anda.”
        </p>
    </div>
</section>

{{-- 🏗️ STORY (HOVER FOTO TETAP ADA) --}}
<section class="py-20 -mt-10 relative z-20">
    <div class="container mx-auto px-6">
        <div class="bg-white rounded-[3rem] shadow-2xl overflow-hidden border border-gray-100 flex flex-col lg:flex-row">

            {{-- IMAGE WITH HOVER --}}
            <div class="lg:w-1/2 relative group overflow-hidden" data-aos="fade-right">
                <img
                    src="{{ $about?->image ? asset('storage/'.$about->image) : asset('assets/img/download.jpeg') }}"
                    class="w-full h-[400px] lg:h-full object-cover transition-transform duration-700 ease-out group-hover:scale-105"
                    alt="Profil Perusahaan">

                {{-- Overlay tetap --}}
                <div class="absolute inset-0 bg-gradient-to-t from-[#161f36]/60 to-transparent opacity-60"></div>
            </div>

            {{-- TEXT --}}
            <div class="lg:w-1/2 p-10 lg:p-20 flex flex-col justify-center" data-aos="fade-left">
                <h2 class="text-[10px] font-black text-[#FF7518] uppercase tracking-[0.4em] mb-4">
                    Profil Perusahaan
                </h2>
                <h3 class="text-3xl font-black uppercase leading-tight mb-8">
                    {{ $title }}
                </h3>
                <p class="text-gray-500 text-sm md:text-base leading-relaxed mb-10">
                    {{ $description }}
                </p>

                {{-- Quick Stats --}}
                <div class="grid grid-cols-2 gap-8 border-t border-gray-100 pt-10">
                    <div>
                        <p class="text-3xl font-black text-[#161f36]">100%</p>
                        <p class="text-[9px] font-bold text-gray-400 uppercase tracking-widest">Kualitas Terjamin</p>
                    </div>
                    <div>
                        <p class="text-3xl font-black text-[#FF7518]">24/7</p>
                        <p class="text-[9px] font-bold text-gray-400 uppercase tracking-widest">Dukungan Teknis</p>
                    </div>
                </div>
            </div>

        </div>
    </div>
</section>

{{-- 🎯 VISI & MISI --}}
<section class="py-20 bg-white" x-data="{ tab: 'visi' }">
    <div class="container mx-auto px-6 text-center">

        <h2 class="text-3xl font-black uppercase mb-16" data-aos="fade-up">
            Arah & <span class="text-[#FF7518]">Filosofi</span> Kami
        </h2>

        {{-- TAB --}}
        <div class="flex justify-center gap-4 mb-12 bg-[#F4F7FA] p-2 rounded-full w-fit mx-auto">
            <button @click="tab='visi'"
                :class="tab==='visi' ? 'bg-[#161f36] text-white shadow-xl' : 'text-gray-400 hover:text-[#161f36]'"
                class="px-8 py-3 rounded-full text-xs font-black uppercase tracking-widest transition">
                Visi
            </button>
            <button @click="tab='misi'"
                :class="tab==='misi' ? 'bg-[#161f36] text-white shadow-xl' : 'text-gray-400 hover:text-[#161f36]'"
                class="px-8 py-3 rounded-full text-xs font-black uppercase tracking-widest transition">
                Misi
            </button>
        </div>

        {{-- VISI --}}
        <div x-show="tab==='visi'" x-transition
            class="relative bg-gradient-to-br from-[#161f36] to-[#1f2a52] text-white p-12 lg:p-20 rounded-[3rem] overflow-hidden">
            <div class="absolute -top-10 -right-10 w-40 h-40 bg-[#FF7518]/20 rounded-full blur-3xl"></div>
            <div class="absolute -bottom-10 -left-10 w-40 h-40 bg-white/10 rounded-full blur-3xl"></div>

            <div class="relative z-10 text-center">
                <i class="fas fa-eye text-[#FF7518] text-4xl mb-6"></i>
                <p class="text-xl md:text-3xl italic leading-relaxed max-w-4xl mx-auto">
                    “{{ $vision }}”
                </p>
            </div>
        </div>

        {{-- MISI --}}
        <div x-show="tab==='misi'" x-transition
            class="bg-gradient-to-br from-[#F4F7FA] to-white p-12 lg:p-20 rounded-[3rem]">
            <div class="grid md:grid-cols-2 gap-8">
                @foreach (explode('.', $mission) as $index => $item)
                    @if(trim($item))
                    <div class="group relative bg-white p-8 rounded-3xl shadow-sm border hover:shadow-xl transition-all hover:-translate-y-2">
                        <div class="absolute -top-4 -left-4 w-10 h-10 bg-[#161f36] text-white rounded-xl flex items-center justify-center font-black shadow-lg">
                            {{ $index + 1 }}
                        </div>
                        <p class="text-gray-600 leading-relaxed mt-4">
                            {{ trim($item) }}
                        </p>
                    </div>
                    @endif
                @endforeach
            </div>
        </div>

    </div>
</section>

</div>

<script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
<script>
    AOS.init({ duration: 1000, once: true });
</script>

@endsection
