@extends('layouts.app')

@section('title', 'Knowledge Center - PT. RBM')

@section('content')
    {{-- Google Fonts & Resources --}}
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap"
        rel="stylesheet">
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">

    <div class="bg-[#FAFBFF] min-h-screen font-['Plus_Jakarta_Sans'] text-[#161f36]" x-data="{
        search: '',
        activeTab: 'all',
        activeFaq: null,
        faqs: [
            {{-- UMUM --}} {
                id: 1,
                cat: 'umum',
                q: 'DI MANA LOKASI KANTOR PT. RBM?',
                a: 'Kantor pusat kami berlokasi di Menara Palma Lantai 12, JL. HR. Rasuna Said Kav. 6 Blok X-2, Jakarta Selatan. Dan Second office kami berada di Jl. Cilembu Haur Ngombong (Perempatan Warung Kawat) RT .01, RW .03 Kec.Pamulihan Sumedang 45365. ' }, 
                { id: 2, cat: 'umum', q: 'APA VISI UTAMA PT. RBM DALAM INDUSTRI INI?', a: 'Menjadi mitra strategis terdepan dalam penyediaan solusi infrastruktur tower dan general trading yang mengedepankan inovasi teknis serta standar keamanan internasional.' },
    
                {{-- TEKNIS --}} { id: 3, cat: 'teknis', q: 'STANDAR MATERIAL APA YANG DIGUNAKAN PADA TOWER?', a: 'Kami menggunakan baja High-Tensile Grade dengan lapisan Hot Dip Galvanized (HDG) sesuai standar ASTM A123 untuk memastikan ketahanan terhadap korosi hingga 20+ tahun.' },
                { id: 4, cat: 'teknis', q: 'APAKAH PRODUK TOWER MEMILIKI SERTIFIKASI SNI?', a: 'Tentu. Semua produk fabrikasi kami memenuhi standar SNI dan melalui pengujian beban (Load Test) serta pengecekan ultrasonik pada titik pengelasan.' },
                { id: 5, cat: 'teknis', q: 'BISA KAH PT. RBM MELAKUKAN CUSTOM DESIGN?', a: 'Sangat bisa. Tim engineering kami menggunakan software pemodelan 3D terkini untuk merancang struktur sesuai koordinat geografis dan beban angin spesifik lokasi Anda.' },
    
                {{-- KERJASAMA --}} { id: 6, cat: 'kerjasama', q: 'BAGAIMANA PROSEDUR PENGAJUAN PENAWARAN (RFQ)?', a: 'Silakan kirimkan BoQ (Bill of Quantity) dan TOR proyek Anda ke email marketing@rbmak.co.id. Tim kami akan memberikan estimasi penawaran dalam 2x24 jam kerja.' },
                { id: 7, cat: 'kerjasama', q: 'APAKAH PT. RBM MENERIMA KEMITRAAN SUB-KONTRAKTOR?', a: 'Kami terbuka untuk kolaborasi vendor yang memiliki sertifikasi K3 dan track record yang terverifikasi. Silakan hubungi bagian pengadaan kami.' },
    
                {{-- LOGISTIK --}} { id: 8, cat: 'logistik', q: 'BAGAIMANA JANGKAUAN PENGIRIMAN MATERIAL?', a: 'Kami melayani pengiriman door-to-door ke seluruh pelosok Indonesia, termasuk area remote (tambang/hutan) menggunakan armada darat dan laut khusus.' },
                { id: 9, cat: 'logistik', q: 'BAGAIMANA JAMINAN KEAMANAN SAAT PENGIRIMAN?', a: 'Setiap pengiriman dilengkapi dengan asuransi transit dan sistem tracking berkala untuk memastikan material sampai tanpa cacat di lokasi proyek.' },
    
                {{-- K3 & LEGAL --}} { id: 10, cat: 'k3', q: 'APAKAH TIM LAPANGAN MEMILIKI SERTIFIKASI K3?', a: 'Wajib. Seluruh personil lapangan kami memiliki sertifikasi K3 Teknisi Menara Telekomunikasi dan dilengkapi dengan APD standar Level 3.' }
            ],
            get filteredFaqs() {
                return this.faqs.filter(f =>
                    (this.activeTab === 'all' || f.cat === this.activeTab) &&
                    f.q.toLowerCase().includes(this.search.toLowerCase())
                );
            }
        }">

        {{-- 🌌 ULTRA MODERN HERO --}}
        <section class="relative pt-32 pb-40 lg:pt-48 lg:pb-56 bg-[#161f36] overflow-hidden">
            {{-- Animated Background Elements --}}
            <div class="absolute inset-0 overflow-hidden pointer-events-none">
                <div
                    class="absolute top-0 right-0 w-[500px] h-[500px] bg-[#FF7518]/10 rounded-full blur-[120px] translate-x-1/2 -translate-y-1/2">
                </div>
                <div
                    class="absolute bottom-0 left-0 w-[500px] h-[500px] bg-blue-600/10 rounded-full blur-[120px] -translate-x-1/2 translate-y-1/2">
                </div>
                <div
                    class="absolute inset-0 bg-[url('https://www.transparenttextures.com/patterns/carbon-fibre.png')] opacity-10">
                </div>
            </div>

            <div class="relative z-10 max-w-screen-xl mx-auto px-6 text-center">
                <div
                    class="inline-flex items-center gap-2 px-4 py-2 bg-white/5 backdrop-blur-xl border border-white/10 rounded-2xl mb-8 animate-bounce">
                    <span class="w-2 h-2 bg-[#FF7518] rounded-full"></span>
                    <span class="text-white text-[10px] font-black uppercase tracking-[0.3em]">Smart Support Center</span>
                </div>

                <h1 class="text-5xl md:text-7xl font-black text-white uppercase tracking-tighter mb-10 leading-none"
                    data-aos="fade-up">
                    Pusat <span class="text-[#FF7518] italic">Informasi</span><br>PT. RBM
                </h1>

                {{-- 🔍 FLOATING SEARCH CARD --}}
                <div class="relative max-w-3xl mx-auto translate-y-1/2" data-aos="zoom-in" data-aos-delay="200">
                    <div
                        class="bg-white p-3 rounded-[2.5rem] shadow-[0_30px_100px_rgba(0,0,0,0.2)] flex flex-col md:flex-row gap-2">
                        <div class="flex-1 relative">
                            <i class="fas fa-search absolute left-6 top-1/2 -translate-y-1/2 text-gray-400 text-xl"></i>
                            <input type="text" x-model="search"
                                placeholder="Cari spesifikasi teknis, prosedur, atau lokasi..."
                                class="w-full pl-16 pr-6 py-5 bg-transparent border-none focus:ring-0 text-lg font-medium text-[#161f36]">
                        </div>
                        <button
                            class="bg-[#161f36] text-white px-10 py-5 rounded-[2rem] font-black text-xs uppercase tracking-widest hover:bg-[#FF7518] transition-all duration-500 shadow-xl">
                            Cari Sekarang
                        </button>
                    </div>
                </div>
            </div>
        </section>

        {{-- 🏗️ KNOWLEDGE BASE GRID --}}
        <section class="pt-32 pb-24">
            <div class="max-w-screen-xl mx-auto px-6">

                {{-- Category Selector --}}
                <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-4 mb-20" data-aos="fade-up">
                    <template x-for="cat in ['all', 'umum', 'teknis', 'kerjasama', 'logistik', 'k3']">
                        <button @click="activeTab = cat; activeFaq = null"
                            class="flex flex-col items-center p-6 rounded-[2rem] border-2 transition-all duration-500 group"
                            :class="activeTab === cat ?
                                'bg-white border-[#FF7518] shadow-2xl shadow-orange-500/10 -translate-y-2' :
                                'bg-transparent border-slate-100 hover:border-slate-200'">
                            <div class="w-12 h-12 rounded-2xl flex items-center justify-center mb-4 transition-all duration-500"
                                :class="activeTab === cat ? 'bg-[#FF7518] text-white' :
                                    'bg-slate-100 text-slate-400 group-hover:bg-slate-200'">
                                <i class="fas"
                                    :class="{
                                        'fa-th-large': cat === 'all',
                                        'fa-info-circle': cat === 'umum',
                                        'fa-cogs': cat === 'teknis',
                                        'fa-handshake': cat === 'kerjasama',
                                        'fa-truck': cat === 'logistik',
                                        'fa-hard-hat': cat === 'k3'
                                    }"></i>
                            </div>
                            <span class="text-[10px] font-black uppercase tracking-widest"
                                :class="activeTab === cat ? 'text-[#161f36]' : 'text-slate-400'" x-text="cat"></span>
                        </button>
                    </template>
                </div>

                <div class="grid grid-cols-1 lg:grid-cols-12 gap-16">

                    {{-- Left: FAQ Accordion --}}
                    <div class="lg:col-span-8 space-y-6">
                        <div x-show="filteredFaqs.length === 0" x-cloak
                            class="text-center py-24 bg-white rounded-[3rem] border-2 border-dashed border-slate-100">
                            <div
                                class="w-20 h-20 bg-slate-50 rounded-full flex items-center justify-center mx-auto mb-6 text-slate-200">
                                <i class="fas fa-search text-3xl"></i>
                            </div>
                            <h4 class="text-xl font-bold text-slate-400">Data tidak ditemukan</h4>
                            <p class="text-slate-300">Coba gunakan kata kunci yang lebih umum.</p>
                        </div>

                        <template x-for="faq in filteredFaqs" :key="faq.id">
                            <div class="group" data-aos="fade-up">
                                <div class="bg-white rounded-[2rem] border border-slate-50 overflow-hidden transition-all duration-500"
                                    :class="activeFaq === faq.id ? 'shadow-2xl shadow-slate-200 ring-2 ring-[#FF7518]' :
                                        'shadow-sm hover:shadow-xl'">
                                    <button @click="activeFaq === faq.id ? activeFaq = null : activeFaq = faq.id"
                                        class="w-full flex items-center justify-between p-8 text-left">
                                        <div class="flex items-center gap-6">
                                            <span class="text-2xl font-black opacity-10"
                                                :class="activeFaq === faq.id ? 'text-[#FF7518] opacity-100' : ''"
                                                x-text="faq.id < 10 ? '0'+faq.id : faq.id"></span>
                                            <h3 class="text-sm md:text-base font-extrabold uppercase tracking-tight text-[#161f36]"
                                                x-text="faq.q"></h3>
                                        </div>
                                        <div class="w-10 h-10 rounded-full flex items-center justify-center bg-slate-50 text-[#161f36] transition-transform duration-500"
                                            :class="activeFaq === faq.id ? 'rotate-180 bg-[#FF7518] text-white' : ''">
                                            <i class="fas fa-chevron-down text-xs"></i>
                                        </div>
                                    </button>

                                    <div x-show="activeFaq === faq.id" x-collapse x-cloak>
                                        <div class="px-8 pb-10 pl-20 relative">
                                            <div class="absolute left-12 top-0 bottom-10 w-[2px] bg-[#FF7518]/20"></div>
                                            <p class="text-slate-500 leading-relaxed text-base font-medium" x-text="faq.a">
                                            </p>
                                            <div class="mt-6 flex gap-2">
                                                <span
                                                    class="px-3 py-1 bg-slate-100 rounded-lg text-[9px] font-black uppercase text-slate-400 tracking-tighter"
                                                    x-text="'Category: ' + faq.cat"></span>
                                                <span
                                                    class="px-3 py-1 bg-orange-50 rounded-lg text-[9px] font-black uppercase text-[#FF7518] tracking-tighter">Verified
                                                    Info</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </template>
                    </div>

                    {{-- Right: Sidebar Help --}}
                    <div class="lg:col-span-4">
                        <div class="sticky top-10 space-y-8">
                            {{-- Live Contact Card --}}
                            <div class="bg-[#161f36] rounded-[3rem] p-10 text-white relative overflow-hidden shadow-2xl">
                                <h4 class="text-2xl font-black mb-6 uppercase italic tracking-tighter">Butuh Respon <span
                                        class="text-[#FF7518] not-italic underline decoration-2">Cepat?</span></h4>
                                <p class="text-slate-400 text-sm leading-relaxed mb-8 font-medium">Jika pertanyaan Anda
                                    tidak terjawab di sini, hubungi konsultan teknis kami secara langsung.</p>

                                <div class="space-y-4">
                                    <a href="https://wa.me/6281394884596"
                                        class="flex items-center justify-center gap-4 bg-[#FF7518] py-5 rounded-2xl font-black text-[10px] uppercase tracking-widest hover:bg-white hover:text-[#161f36] transition-all duration-500 group">
                                        <i class="fab fa-whatsapp text-lg group-hover:rotate-12 transition-transform"></i>
                                        WhatsApp Priority
                                    </a>
                                    <a href="mailto:marketing@rbmak.co.id"
                                        class="flex items-center justify-center gap-4 bg-white/5 border border-white/10 py-5 rounded-2xl font-black text-[10px] uppercase tracking-widest hover:bg-white/10 transition-all duration-500">
                                        <i class="far fa-envelope text-lg"></i> Official Email
                                    </a>
                                </div>

                                <div class="mt-10 pt-10 border-t border-white/5 text-center">
                                    <p class="text-[9px] font-black text-slate-500 uppercase tracking-[0.3em]">Jam
                                        Operasional</p>
                                    <p class="text-xs font-bold text-white mt-2">Mon - Fri: 08:00 - 17:00</p>
                                </div>
                            </div>

                            {{-- Quick Link Card --}}
                            <div class="bg-white rounded-[3rem] p-10 border border-slate-100 shadow-sm">
                                <h5 class="text-xs font-black uppercase tracking-[0.2em] text-slate-400 mb-6">Prasyarat
                                    Dokumen</h5>
                                <ul class="space-y-4">
                                    <li
                                        class="flex items-center gap-3 text-sm font-bold text-[#161f36] hover:text-[#FF7518] cursor-pointer transition">
                                        <i class="fas fa-file-pdf text-red-500"></i> Company Profile PT. RBM
                                    </li>
                                    <li
                                        class="flex items-center gap-3 text-sm font-bold text-[#161f36] hover:text-[#FF7518] cursor-pointer transition">
                                        <i class="fas fa-file-invoice text-blue-500"></i> Prosedur Kemitraan Vendor
                                    </li>
                                    <li
                                        class="flex items-center gap-3 text-sm font-bold text-[#161f36] hover:text-[#FF7518] cursor-pointer transition">
                                        <i class="fas fa-certificate text-orange-500"></i> Portofolio Proyek 2025
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </section>
    </div>

    <style>
        [x-cloak] {
            display: none !important;
        }

        .faq-shadow {
            shadow: 0 50px 100px -20px rgba(22, 31, 54, 0.15);
        }

        ::-webkit-scrollbar {
            width: 10px;
        }

        ::-webkit-scrollbar-track {
            background: #FAFBFF;
        }

        ::-webkit-scrollbar-thumb {
            background: #161f36;
            border-radius: 20px;
            border: 3px solid #FAFBFF;
        }

        ::-webkit-scrollbar-thumb:hover {
            background: #FF7518;
        }
    </style>

    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            AOS.init({
                duration: 1000,
                once: true,
                offset: 50
            });
        });
    </script>
@endsection
