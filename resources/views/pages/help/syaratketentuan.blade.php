@extends('layouts.app')

@section('title', 'Syarat & Ketentuan - PT. RBM')

@section('content')
    {{-- Google Fonts, Alpine.js, & AOS --}}
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">

    <div class="bg-[#F4F7FA] min-h-screen font-['Poppins'] text-[#161f36]" x-data="{ activeSchedules: [1] }">

        {{-- 🌌 HERO BANNER: Konsisten dengan Produk & FAQ --}}
        <section class="relative pt-32 pb-20 lg:pt-40 lg:pb-28 overflow-hidden bg-[#161f36]">
            <div class="absolute inset-0 z-0">
                {{-- Background Pattern --}}
                <div class="absolute inset-0 opacity-10"
                    style="background-image: radial-gradient(#FF7518 0.5px, transparent 0.5px); background-size: 24px 24px;">
                </div>
                <div class="absolute inset-0 bg-gradient-to-b from-transparent to-[#161f36]"></div>
            </div>

            <div class="relative z-10 max-w-7xl mx-auto px-6 text-center">
                <nav class="flex justify-center mb-6" aria-label="Breadcrumb">
                    <ol class="inline-flex items-center space-x-2 text-[10px] uppercase tracking-[0.3em] font-bold">
                        <li><a href="/" class="text-gray-500 hover:text-white transition">Home</a></li>
                        <li class="text-gray-600"><i class="fas fa-chevron-right text-[8px] mx-1"></i></li>
                        <li class="text-[#FF7518]">Terms & Conditions</li>
                    </ol>
                </nav>
                <h1 class="text-3xl md:text-5xl font-black text-white uppercase tracking-tight" data-aos="fade-up">
                    Syarat & <span class="text-[#FF7518]">Ketentuan</span>
                </h1>
                <p class="text-gray-400 text-xs lg:text-sm mt-6 max-w-2xl mx-auto leading-relaxed uppercase tracking-widest font-medium"
                    data-aos="fade-up" data-aos-delay="100">
                    Pedoman resmi mengenai hak, kewajiban, dan standar operasional antara PT. RBM dan mitra kerja.
                </p>
            </div>
        </section>

        {{-- 🏗️ MAIN CONTENT --}}
        <section class="py-16 lg:py-24">
            <div class="max-w-4xl mx-auto px-6">

                {{-- Search/Filter Simple --}}
                <div class="mb-12 flex items-center justify-between border-b border-gray-200 pb-6" data-aos="fade-up">
                    <div class="hidden md:block">
                        <p class="text-[10px] font-black text-[#FF7518] uppercase tracking-[0.2em]">Update Terakhir</p>
                        <p class="text-sm font-bold text-gray-400 uppercase">20 Desember 2025</p>
                    </div>
                    <div class="flex gap-4">
                        <button @click="activeSchedules = [1,2,3,4,5,6,7,8,9]"
                            class="text-[9px] font-black uppercase tracking-widest text-[#161f36] hover:text-[#FF7518]">Buka
                            Semua</button>
                        <span class="text-gray-300">|</span>
                        <button @click="activeSchedules = []"
                            class="text-[9px] font-black uppercase tracking-widest text-[#161f36] hover:text-[#FF7518]">Tutup
                            Semua</button>
                    </div>
                </div>

                <div class="space-y-12">

                    {{-- KATEGORI 1 --}}
                    <div data-aos="fade-up">
                        <div class="flex items-center gap-4 mb-6">
                            <span
                                class="flex-shrink-0 w-12 h-12 bg-[#161f36] text-[#FF7518] rounded-2xl flex items-center justify-center font-black text-xl shadow-lg shadow-navy-900/20">01</span>
                            <h2 class="text-lg font-black uppercase tracking-tight text-[#161f36]">Ketentuan Kontrak & Umum
                            </h2>
                        </div>

                        <div class="space-y-3">
                            {{-- Item 1 --}}
                            <div class="group bg-white rounded-2xl border border-gray-100 transition-all duration-300 overflow-hidden"
                                :class="activeSchedules.includes(1) ? 'shadow-xl ring-1 ring-[#FF7518]/20' : 'shadow-sm'">
                                <button
                                    @click="activeSchedules.includes(1) ? activeSchedules = activeSchedules.filter(i => i !== 1) : activeSchedules.push(1)"
                                    class="w-full p-6 text-left flex items-center justify-between">
                                    <span class="text-sm font-extrabold uppercase tracking-tight"
                                        :class="activeSchedules.includes(1) ? 'text-[#FF7518]' : 'text-[#161f36]'">Persetujuan
                                        Kontrak Resmi</span>
                                    <i class="fas fa-plus text-[10px] transition-transform duration-500"
                                        :class="activeSchedules.includes(1) ? 'rotate-45 text-[#FF7518]' : 'text-gray-300'"></i>
                                </button>
                                <div x-show="activeSchedules.includes(1)" x-collapse x-cloak
                                    class="px-6 pb-6 text-sm text-gray-500 leading-relaxed">
                                    <p>Semua proyek dan layanan besar memerlukan penandatanganan <strong
                                            class="text-[#161f36]">Perjanjian Layanan Tertulis (Kontrak)</strong>. Penawaran
                                        atau Purchase Order (PO) dianggap sebagai persetujuan awal atas S&K yang berlaku.
                                    </p>
                                </div>
                            </div>

                            {{-- Item 2 --}}
                            <div class="group bg-white rounded-2xl border border-gray-100 transition-all duration-300 overflow-hidden"
                                :class="activeSchedules.includes(2) ? 'shadow-xl ring-1 ring-[#FF7518]/20' : 'shadow-sm'">
                                <button
                                    @click="activeSchedules.includes(2) ? activeSchedules = activeSchedules.filter(i => i !== 2) : activeSchedules.push(2)"
                                    class="w-full p-6 text-left flex items-center justify-between">
                                    <span class="text-sm font-extrabold uppercase tracking-tight"
                                        :class="activeSchedules.includes(2) ? 'text-[#FF7518]' : 'text-[#161f36]'">Kewajiban
                                        Data Teknis & Lokasi</span>
                                    <i class="fas fa-plus text-[10px] transition-transform duration-500"
                                        :class="activeSchedules.includes(2) ? 'rotate-45 text-[#FF7518]' : 'text-gray-300'"></i>
                                </button>
                                <div x-show="activeSchedules.includes(2)" x-collapse x-cloak
                                    class="px-6 pb-6 text-sm text-gray-500 leading-relaxed">
                                    <p>Klien wajib menyediakan data teknis, spesifikasi, dan akses lokasi proyek yang
                                        lengkap. PT. RBM tidak bertanggung jawab atas kesalahan yang timbul akibat data yang
                                        tidak valid.</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- KATEGORI 2 --}}
                    <div data-aos="fade-up">
                        <div class="flex items-center gap-4 mb-6">
                            <span
                                class="flex-shrink-0 w-12 h-12 bg-[#161f36] text-[#FF7518] rounded-2xl flex items-center justify-center font-black text-xl shadow-lg shadow-navy-900/20">02</span>
                            <h2 class="text-lg font-black uppercase tracking-tight text-[#161f36]">Pembayaran & Penagihan
                            </h2>
                        </div>

                        <div class="space-y-3">
                            {{-- Item 4 --}}
                            <div class="group bg-white rounded-2xl border border-gray-100 transition-all duration-300 overflow-hidden"
                                :class="activeSchedules.includes(4) ? 'shadow-xl ring-1 ring-[#FF7518]/20' : 'shadow-sm'">
                                <button
                                    @click="activeSchedules.includes(4) ? activeSchedules = activeSchedules.filter(i => i !== 4) : activeSchedules.push(4)"
                                    class="w-full p-6 text-left flex items-center justify-between">
                                    <span class="text-sm font-extrabold uppercase tracking-tight"
                                        :class="activeSchedules.includes(4) ? 'text-[#FF7518]' : 'text-[#161f36]'">Syarat
                                        Pembayaran & Termin</span>
                                    <i class="fas fa-plus text-[10px] transition-transform duration-500"
                                        :class="activeSchedules.includes(4) ? 'rotate-45 text-[#FF7518]' : 'text-gray-300'"></i>
                                </button>
                                <div x-show="activeSchedules.includes(4)" x-collapse x-cloak
                                    class="px-6 pb-6 text-sm text-gray-500 leading-relaxed">
                                    <p>Pembayaran dilakukan dalam 3 tahap utama:</p>
                                    <ul class="mt-4 space-y-2">
                                        <li class="flex items-start gap-3">
                                            <i class="fas fa-check-circle text-[#FF7518] mt-1 text-[10px]"></i>
                                            <span><strong class="text-[#161f36]">Termin 1 (DP):</strong> Mobilisasi tim dan
                                                material.</span>
                                        </li>
                                        <li class="flex items-start gap-3">
                                            <i class="fas fa-check-circle text-[#FF7518] mt-1 text-[10px]"></i>
                                            <span><strong class="text-[#161f36]">Termin 2 (Progress):</strong> Berdasarkan
                                                pencapaian target kerja.</span>
                                        </li>
                                        <li class="flex items-start gap-3">
                                            <i class="fas fa-check-circle text-[#FF7518] mt-1 text-[10px]"></i>
                                            <span><strong class="text-[#161f36]">Termin 3 (Final):</strong> Pelunasan
                                                setelah serah terima (FHO).</span>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- KATEGORI 3 --}}
                    <div data-aos="fade-up">
                        <div class="flex items-center gap-4 mb-6">
                            <span
                                class="flex-shrink-0 w-12 h-12 bg-[#161f36] text-[#FF7518] rounded-2xl flex items-center justify-center font-black text-xl shadow-lg shadow-navy-900/20">03</span>
                            <h2 class="text-lg font-black uppercase tracking-tight text-[#161f36]">Garansi & Jaminan</h2>
                        </div>

                        <div class="space-y-3">
                            <div class="group bg-white rounded-2xl border border-gray-100 transition-all duration-300 overflow-hidden"
                                :class="activeSchedules.includes(8) ? 'shadow-xl ring-1 ring-[#FF7518]/20' : 'shadow-sm'">
                                <button
                                    @click="activeSchedules.includes(8) ? activeSchedules = activeSchedules.filter(i => i !== 8) : activeSchedules.push(8)"
                                    class="w-full p-6 text-left flex items-center justify-between">
                                    <span class="text-sm font-extrabold uppercase tracking-tight"
                                        :class="activeSchedules.includes(8) ? 'text-[#FF7518]' : 'text-[#161f36]'">Periode
                                        & Batasan Garansi</span>
                                    <i class="fas fa-plus text-[10px] transition-transform duration-500"
                                        :class="activeSchedules.includes(8) ? 'rotate-45 text-[#FF7518]' : 'text-gray-300'"></i>
                                </button>
                                <div x-show="activeSchedules.includes(8)" x-collapse x-cloak
                                    class="px-6 pb-6 text-sm text-gray-500 leading-relaxed">
                                    <p>Semua pengerjaan dilindungi garansi operasional selama 6-12 bulan. Garansi tidak
                                        berlaku jika terjadi modifikasi oleh pihak ketiga tanpa persetujuan tertulis dari
                                        PT. RBM.</p>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>


                <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
                <script>
                    document.addEventListener('DOMContentLoaded', function() {
                        AOS.init({
                            duration: 1000,
                            once: true
                        });
                    });
                </script>

                <style>
                    [x-cloak] {
                        display: none !important;
                    }

                    /* Custom Scrollbar */
                    ::-webkit-scrollbar {
                        width: 8px;
                    }

                    ::-webkit-scrollbar-track {
                        background: #F4F7FA;
                    }

                    ::-webkit-scrollbar-thumb {
                        background: #161f36;
                        border-radius: 10px;
                        border: 2px solid #F4F7FA;
                    }

                    ::-webkit-scrollbar-thumb:hover {
                        background: #FF7518;
                    }
                </style>
            @endsection
