@extends('layouts.app')

@section('title', 'Hubungi Kami - PT. Rizqallah Boer Makmur')

@section('content')
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">

    <style>
        /* Menerapkan font Inter ke seluruh section ini */
        #contact-section {
            font-family: 'Inter', sans-serif;
        }
    </style>

    <section id="contact-section" class="min-h-screen bg-[#F8F9FB] pt-32 pb-20 px-4">
        <div class="max-w-6xl mx-auto">

            {{-- Header Section --}}
            <div class="text-center mb-16">
                <h2 class="text-3xl md:text-5xl font-extrabold text-[#2C3E50] mb-4 tracking-tight" data-aos="fade-down">
                    Hubungi Kami
                </h2>
                <div class="w-20 h-1.5 bg-[#FFC300] mx-auto rounded-full mb-6"></div>
                <p class="text-[#7F8C8D] max-w-2xl mx-auto text-lg leading-relaxed" data-aos="fade-down"
                    data-aos-delay="100">
                    Tim kami siap membantu Anda dengan pertanyaan mengenai proyek, layanan, atau kemitraan bisnis.
                </p>
            </div>

            {{-- Main Contact Card --}}
            <div class="bg-white rounded-[3rem] shadow-2xl shadow-gray-200/50 border border-gray-100 overflow-hidden"
                data-aos="fade-up" data-aos-delay="200">
                <div class="grid grid-cols-1 lg:grid-cols-3 divide-y lg:divide-y-0 lg:divide-x divide-gray-100">

                    {{-- Kolom 1: Kontak & Sales --}}
                    <div class="p-8 md:p-10 flex flex-col">
                        <div class="flex items-center gap-3 mb-10">
                            <div class="w-2 h-8 bg-[#FFC300] rounded-full"></div>
                            <h3 class="text-xl font-bold text-[#2C3E50]">Kontak & Sales</h3>
                        </div>

                        <div class="space-y-10">
                            {{-- Customer Service --}}
                            <div class="flex items-start gap-4 group">
                                <div
                                    class="w-12 h-12 rounded-2xl bg-orange-50 flex items-center justify-center text-2xl text-[#FFC300] flex-shrink-0 transition-transform group-hover:scale-110">
                                    <i class="bi bi-headset"></i>
                                </div>
                                <div>
                                    <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-1">Customer
                                        Service</p>
                                    <a href="tel:+6281394884596"
                                        class="text-lg font-bold text-[#2C3E50] hover:text-[#FFC300] transition-colors block leading-tight">
                                        0813 9488 4596
                                    </a>
                                    <p class="text-xs font-medium text-[#7F8C8D] mt-1 uppercase tracking-tighter">Dwi Yudho
                                        M</p>
                                </div>
                            </div>

                            {{-- Sales Marketing --}}
                            <div class="flex items-start gap-4 group">
                                <div
                                    class="w-12 h-12 rounded-2xl bg-orange-50 flex items-center justify-center text-2xl text-[#FFC300] flex-shrink-0 transition-transform group-hover:scale-110">
                                    <i class="bi bi-briefcase"></i>
                                </div>
                                <div class="w-full">
                                    <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-3">Sales
                                        Marketing</p>
                                    <div class="space-y-4">
                                        <div>
                                            <a href="https://wa.me/6282121233261" target="_blank"
                                                class="text-base font-bold text-[#2C3E50] hover:text-[#FFC300] transition-colors block leading-tight">
                                                0821 2123 3261
                                            </a>
                                            <p class="text-xs font-medium text-[#7F8C8D] mt-1 uppercase tracking-tighter">
                                                Arif Endi</p>
                                        </div>
                                        <div>
                                            <a href="https://wa.me/6281394884596" target="_blank"
                                                class="text-base font-bold text-[#2C3E50] hover:text-[#FFC300] transition-colors block leading-tight">
                                                0813 9488 4596
                                            </a>
                                            <p class="text-xs font-medium text-[#7F8C8D] mt-1 uppercase tracking-tighter">
                                                Dwi Yudho M</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="flex items-start gap-4 group">
                                <div
                                    class="w-12 h-12 rounded-2xl bg-orange-50 flex items-center justify-center text-2xl text-[#FFC300] flex-shrink-0 transition-transform group-hover:scale-110">
                                    <i class="bi bi-gear-wide-connected"></i>
                                </div>
                                <div>
                                    <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-1">Project
                                        Coordinator</p>
                                    <a href="https://wa.me/6285222331343" target="_blank"
                                        class="text-lg font-bold text-[#2C3E50] hover:text-[#FFC300] transition-colors block leading-tight">
                                        0852 2233 1343
                                    </a>
                                    <p class="text-xs font-medium text-[#7F8C8D] mt-1 uppercase tracking-tighter">Delar</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Kolom 2: Operasional & Maps --}}
                    <div class="p-8 md:p-10 bg-gray-50/30 flex flex-col">
                        <div class="flex items-center gap-3 mb-10">
                            <div class="w-2 h-8 bg-[#FFC300] rounded-full"></div>
                            <h3 class="text-xl font-bold text-[#2C3E50]">Lokasi & Project</h3>
                        </div>

                        <div class="space-y-10">
                            {{-- Peta --}}
                            <div class="pt-2">
                                <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-4">Titik Lokasi
                                </p>
                                <div class="rounded-3xl overflow-hidden shadow-inner border border-gray-200 h-44 group">
                                    <iframe
                                        class="w-full h-full grayscale group-hover:grayscale-0 transition-all duration-700"
                                        src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3965.8975!2d107.8323199!3d-6.9113491!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e68dbb5021f6cbd%3A0x2b5772b4460f8ef9!2sWH%20RBM!5e0!3m2!1sid!2sid!4v1736400000000"
                                        style="border:0;" allowfullscreen loading="lazy">
                                    </iframe>
                                </div>
                                <p class="text-[10px] text-[#7F8C8D] mt-3 italic text-center">Mohon buat janji temu terlebih
                                    dahulu.</p>
                            </div>
                        </div>
                    </div>

                    {{-- Kolom 3: Digital & Media --}}
                    <div class="p-8 md:p-10 flex flex-col">
                        <div class="flex items-center gap-3 mb-10">
                            <div class="w-2 h-8 bg-[#FFC300] rounded-full"></div>
                            <h3 class="text-xl font-bold text-[#2C3E50]">Digital & Media</h3>
                        </div>

                        <div class="space-y-10">
                            {{-- Email --}}
                            <div class="flex items-start gap-4 group">
                                <div
                                    class="w-12 h-12 rounded-2xl bg-orange-50 flex items-center justify-center text-2xl text-[#FFC300] flex-shrink-0 transition-transform group-hover:scale-110">
                                    <i class="bi bi-envelope-at"></i>
                                </div>
                                <div>
                                    <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-1">Email
                                        Resmi</p>
                                    <div class="space-y-2">
                                        <a href="mailto:marketing@rbmak.co.id"
                                            class="text-sm md:text-base font-bold text-[#2C3E50] hover:text-[#FFC300] transition-colors block">
                                            marketing@rbmak.co.id
                                        </a>
                                        <a href="mailto:project@rbmak.co.id"
                                            class="text-sm md:text-base font-bold text-[#2C3E50] hover:text-[#FFC300] transition-colors block">
                                            project@rbmak.co.id
                                        </a>
                                    </div>
                                </div>
                            </div>

                            {{-- Alamat --}}
                            <div class="flex items-start gap-4 group">
                                <div
                                    class="w-12 h-12 rounded-2xl bg-orange-50 flex items-center justify-center text-2xl text-[#FFC300] flex-shrink-0 transition-transform group-hover:scale-110">
                                    <i class="bi bi-geo-alt"></i>
                                </div>
                                <div>
                                    <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-1">Kantor
                                        Utama</p>
                                    <span class="text-sm font-semibold text-[#2C3E50] leading-relaxed block">
                                        Menara Palma Lantai 12<br>
                                        Jl. HR. Rasuna Said Kav. 6 Blok X-2<br>
                                        Jakarta Selatan 12950F
                                    </span>
                                </div>
                            </div>

                            <div class="flex items-start gap-4 group">
                                <div
                                    class="w-12 h-12 rounded-2xl bg-orange-50 flex items-center justify-center text-2xl text-[#FFC300] flex-shrink-0 transition-transform group-hover:scale-110">
                                    <i class="bi bi-buildings"></i>
                                </div>
                                <div>
                                    <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-1">Warehouse
                                    </p>
                                    <span class="text-sm font-semibold text-[#2C3E50] leading-relaxed block">
                                        Jl. Cilembu Haurngombong<br>
                                        RT.01, RW.03 Kec. Pamulihan<br>
                                        Sumedang 45365
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </section>
@endsection
