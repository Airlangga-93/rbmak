@extends('layouts.app')

@section('title', 'Kirim Feedback - PT. Rizqallah Boer Makmur')

@section('content')
    {{-- Load Premium Fonts & Animation --}}
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.css" />

    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background-color: #F8FAFC;
        }

        .text-gradient {
            background: linear-gradient(135deg, #2C3E50 0%, #4A6076 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        /* Tabel Input Wrapper */
        .input-wrapper {
            @apply bg-white border border-slate-200 rounded-2xl p-1 transition-all duration-300 shadow-sm;
        }

        .input-wrapper:focus-within {
            @apply border-[#FFC300] ring-4 ring-yellow-400/10 shadow-md;
        }

        .input-field {
            @apply w-full px-5 py-4 bg-transparent border-none focus:ring-0 outline-none text-[#2C3E50] font-medium placeholder-slate-400;
        }

        .floating-accent {
            position: absolute;
            border-radius: 50%;
            filter: blur(80px);
            z-index: 0;
            opacity: 0.15;
        }

        .btn-gradient {
            background: linear-gradient(135deg, #FFC300 0%, #FF9F00 100%);
        }

        .sidebar-card {
            background: linear-gradient(145deg, #ffffff, #f1f5f9);
        }

        /* Responsive Adjustments */
        @media (max-width: 768px) {
            .section-padding {
                @apply pt-24 pb-12 px-5;
            }

            .mobile-rounded {
                border-radius: 2rem !important;
            }
        }
    </style>

    <section class="relative min-h-screen section-padding pt-32 pb-20 overflow-hidden">
        {{-- Aksen Latar Belakang --}}
        <div class="floating-accent bg-[#FFC300] w-64 h-64 md:w-96 md:h-96 -top-10 -right-10 md:-top-20 md:-right-20"></div>
        <div class="floating-accent bg-blue-400 w-64 h-64 md:w-80 md:h-80 -bottom-10 -left-10 md:-bottom-20 md:-left-20">
        </div>

        <div class="relative z-10 max-w-6xl mx-auto">
            {{-- Header Section --}}
            <div class="text-center mb-10 md:mb-16">
                <nav class="flex justify-center mb-4 md:mb-6" data-aos="fade-down">
                    <span
                        class="px-4 py-1.5 rounded-full bg-yellow-400/10 text-yellow-700 text-[9px] md:text-[10px] font-black uppercase tracking-[0.2em] border border-yellow-200">
                        Customer Experience
                    </span>
                </nav>
                <h2 class="text-3xl md:text-6xl font-black text-gradient mb-4 md:mb-6 tracking-tighter" data-aos="fade-up">
                    Suara <span class="italic font-light">Anda</span>, Prioritas <br class="md:hidden"> <span
                        class="underline decoration-[#FFC300] decoration-4 md:decoration-8 underline-offset-4 md:underline-offset-8">Kami</span>
                </h2>
                <p class="text-slate-500 max-w-2xl mx-auto text-sm md:text-lg leading-relaxed font-medium px-4"
                    data-aos="fade-up" data-aos-delay="100">
                    Pendapat Anda sangat berarti bagi kami. Berikan masukan, saran, atau kritik untuk membantu kami
                    memberikan layanan yang lebih baik.
                </p>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 md:gap-12 items-start">
                {{-- Info Sidebar - Dipindah ke bawah Form di mobile jika ingin, tapi di sini tetap di atas --}}
                <div class="lg:col-span-4 space-y-6 order-2 lg:order-1" data-aos="fade-right">
                    <div
                        class="sidebar-card p-6 md:p-8 rounded-[2rem] md:rounded-[2.5rem] shadow-xl shadow-slate-200/50 border border-white">
                        <h4 class="text-lg md:text-xl font-bold text-[#2C3E50] mb-6 md:mb-8 flex items-center gap-3">
                            <span class="w-8 h-1 bg-[#FFC300] rounded-full"></span>
                            Insight
                        </h4>
                        <ul class="space-y-6 md:space-y-8">
                            <li class="flex gap-4 md:gap-5">
                                <div
                                    class="w-10 h-10 md:w-12 md:h-12 rounded-xl md:rounded-2xl bg-white flex items-center justify-center text-[#FFC300] shrink-0 shadow-sm border border-slate-100">
                                    <i class="fas fa-rocket text-sm md:text-lg"></i>
                                </div>
                                <div>
                                    <h5 class="font-bold text-[#2C3E50] text-xs md:text-sm">Inovasi</h5>
                                    <p class="text-[11px] md:text-xs text-slate-500 leading-relaxed mt-1">Mendorong
                                        pembaruan layanan berbasis kebutuhan pelanggan.</p>
                                </div>
                            </li>
                            <li class="flex gap-4 md:gap-5">
                                <div
                                    class="w-10 h-10 md:w-12 md:h-12 rounded-xl md:rounded-2xl bg-white flex items-center justify-center text-blue-500 shrink-0 shadow-sm border border-slate-100">
                                    <i class="fas fa-shield-alt text-sm md:text-lg"></i>
                                </div>
                                <div>
                                    <h5 class="font-bold text-[#2C3E50] text-xs md:text-sm">Kualitas</h5>
                                    <p class="text-[11px] md:text-xs text-slate-500 leading-relaxed mt-1">Meningkatkan
                                        standar operasional PT. RBM secara berkelanjutan.</p>
                                </div>
                            </li>
                            <li class="flex gap-4 md:gap-5">
                                <div
                                    class="w-10 h-10 md:w-12 md:h-12 rounded-xl md:rounded-2xl bg-white flex items-center justify-center text-emerald-500 shrink-0 shadow-sm border border-slate-100">
                                    <i class="fas fa-heart text-sm md:text-lg"></i>
                                </div>
                                <div>
                                    <h5 class="font-bold text-[#2C3E50] text-xs md:text-sm">Hubungan</h5>
                                    <p class="text-[11px] md:text-xs text-slate-500 leading-relaxed mt-1">Membangun
                                        kepercayaan jangka panjang dengan mitra kami.</p>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>

                {{-- Form Section --}}
                <div class="lg:col-span-8 order-1 lg:order-2" data-aos="fade-left">
                    <div
                        class="bg-white/60 backdrop-blur-xl rounded-[2rem] md:rounded-[3rem] shadow-2xl shadow-slate-200/60 p-6 md:p-12 border border-white mobile-rounded">
                        @if (session('success'))
                            <div
                                class="mb-6 bg-emerald-500 text-white px-5 py-3 rounded-xl flex items-center gap-3 shadow-lg shadow-emerald-200 animate-fade-in text-sm font-bold">
                                <i class="fas fa-check-circle"></i>
                                <span>{{ session('success') }}</span>
                            </div>
                        @endif

                        @if ($errors->any())
                            <div
                                class="mb-6 bg-red-50 border-l-4 border-red-500 text-red-800 px-5 py-3 rounded-r-xl shadow-sm">
                                <p class="font-bold text-xs mb-1">Mohon perbaiki kesalahan berikut:</p>
                                <ul class="list-disc list-inside text-[10px] opacity-80 space-y-0.5">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <form action="{{ route('feedback.store') }}" method="POST" class="space-y-6 md:space-y-8">
                            @csrf

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 md:gap-8">
                                {{-- Nama --}}
                                <div class="space-y-2">
                                    <label for="name"
                                        class="block text-[10px] md:text-[11px] font-black text-[#2C3E50] ml-1 uppercase tracking-[0.15em]">
                                        Nama Lengkap <span class="text-red-500">*</span>
                                    </label>
                                    <div class="input-wrapper">
                                        <input type="text" id="name" name="name" value="{{ old('name') }}"
                                            class="input-field text-sm md:text-base" placeholder="Masukkan nama Anda"
                                            required>
                                    </div>
                                </div>

                                {{-- Email --}}
                                <div class="space-y-2">
                                    <label for="email"
                                        class="block text-[10px] md:text-[11px] font-black text-[#2C3E50] ml-1 uppercase tracking-[0.15em]">
                                        Email Aktif <span class="text-red-500">*</span>
                                    </label>
                                    <div class="input-wrapper">
                                        <input type="email" id="email" name="email" value="{{ old('email') }}"
                                            class="input-field text-sm md:text-base" placeholder="Alamat email Anda"
                                            required>
                                    </div>
                                </div>
                            </div>

                            {{-- Subjek --}}
                            <div class="space-y-2">
                                <label for="subject"
                                    class="block text-[10px] md:text-[11px] font-black text-[#2C3E50] ml-1 uppercase tracking-[0.15em]">
                                    Subjek Feedback <span class="text-red-500">*</span>
                                </label>
                                <div class="input-wrapper">
                                    <input type="text" id="subject" name="subject" value="{{ old('subject') }}"
                                        class="input-field text-sm md:text-base"
                                        placeholder="Apa yang ingin Anda sampaikan?" required>
                                </div>
                            </div>

                            {{-- Pesan --}}
                            <div class="space-y-2">
                                <label for="message"
                                    class="block text-[10px] md:text-[11px] font-black text-[#2C3E50] ml-1 uppercase tracking-[0.15em]">
                                    Pesan Detail <span class="text-red-500">*</span>
                                </label>
                                <div class="input-wrapper">
                                    <textarea id="message" name="message" rows="4" class="input-field resize-none py-4 text-sm md:text-base"
                                        placeholder="Tuliskan pengalaman, saran, atau kritik Anda secara mendetail..." required>{{ old('message') }}</textarea>
                                </div>
                            </div>

                            {{-- Tombol --}}
                            <div class="flex flex-col sm:flex-row gap-4 pt-4 md:pt-6">
                                <button type="submit"
                                    class="w-full sm:flex-[2] btn-gradient text-[#2C3E50] font-black py-4 md:py-5 px-6 rounded-2xl transition-all transform hover:-translate-y-1 shadow-lg hover:shadow-yellow-400/40 uppercase tracking-[0.2em] text-[10px] md:text-xs flex items-center justify-center gap-3">
                                    <i class="fas fa-paper-plane"></i>
                                    Kirim Feedback
                                </button>
                                <a href="{{ route('home') }}"
                                    class="w-full sm:flex-1 bg-white text-slate-500 font-bold py-4 md:py-5 px-6 rounded-2xl border border-slate-200 hover:bg-slate-50 transition-all text-center uppercase tracking-[0.2em] text-[9px] md:text-[10px] flex items-center justify-center gap-2 shadow-sm">
                                    <i class="fas fa-arrow-left"></i>
                                    Kembali
                                </a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <div class="mt-12 md:mt-20 text-center" data-aos="fade-up">
                <div
                    class="inline-flex flex-col md:flex-row items-center gap-3 md:gap-4 px-6 py-3 md:px-8 md:py-4 bg-white/60 backdrop-blur-md rounded-2xl md:rounded-full shadow-sm border border-white/50 mx-4">
                    <div class="flex -space-x-2 md:-space-x-3">
                        <img src="https://ui-avatars.com/api/?name=User+1&background=2C3E50&color=fff"
                            class="w-8 h-8 md:w-10 md:h-10 rounded-full border-2 md:border-4 border-white">
                        <img src="https://ui-avatars.com/api/?name=User+2&background=FFC300&color=2C3E50"
                            class="w-8 h-8 md:w-10 md:h-10 rounded-full border-2 md:border-4 border-white">
                        <img src="https://ui-avatars.com/api/?name=User+3&background=E2E8F0&color=475569"
                            class="w-8 h-8 md:w-10 md:h-10 rounded-full border-2 md:border-4 border-white">
                    </div>
                    <p class="text-slate-500 text-[10px] md:text-xs font-semibold italic tracking-wide">
                        Feedback Anda diproses secara rahasia untuk peningkatan layanan.
                    </p>
                </div>
            </div>
        </div>
    </section>

    {{-- Load Scripts --}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            AOS.init({
                duration: 1000,
                once: true,
                easing: 'ease-out-cubic',
                disable: 'mobile' // Opsional: nonaktifkan AOS di mobile jika terasa berat
            });
        });
    </script>
@endsection
