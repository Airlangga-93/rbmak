@extends('admin.layouts.app')

@section('content')
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" />
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">

    <style>
        body {
            font-family: 'Poppins', sans-serif;
        }

        :root {
            --accent: #FF8C00;
            --dark: #161f36;
        }

        .fade-up {
            opacity: 0;
            transform: translateY(14px);
            animation: fadeUp .8s cubic-bezier(.22, .61, .36, 1) forwards;
        }

        @keyframes fadeUp {
            to {
                opacity: 1;
                transform: none;
            }
        }

        .tower-card {
            border-left: 5px solid var(--accent);
            transition: .28s ease;
        }

        .tower-card:hover {
            background: #F9FAFB;
            box-shadow: 0 14px 30px rgba(0, 0, 0, .08);
            transform: translateY(-3px);
        }

        .divider {
            height: 1px;
            background: linear-gradient(to right, transparent, #E5E7EB, transparent);
        }
    </style>

    <div class="min-h-screen bg-[#F0F2F5] px-8 py-10">
        <div class="max-w-7xl mx-auto space-y-12">

            {{-- HEADER --}}
            <header class="bg-white rounded-2xl border px-8 py-7 flex flex-col md:flex-row justify-between shadow-sm">
                <div class="space-y-2">
                    <div class="flex items-center gap-3">
                        <span class="w-2 h-10 bg-[var(--accent)] rounded-full"></span>
                        <h1 class="text-2xl font-semibold text-[var(--dark)]">
                            Dashboard Admin
                        </h1>
                    </div>
                    <p class="text-sm text-gray-600 pl-5">
                        Kelola sistem, pengguna, dan aktivitas website dari satu tempat.
                    </p>
                </div>

                <div class="mt-4 md:mt-0 flex items-center gap-3 text-gray-600 text-sm">
                    <div class="w-10 h-10 flex items-center justify-center rounded-lg bg-gray-100">
                        <i class="fas fa-calendar-alt"></i>
                    </div>
                    <span id="current-date" class="font-medium"></span>
                </div>
            </header>

            {{-- BANNER --}}
            <section class="relative bg-white border rounded-2xl overflow-hidden shadow-lg group isolate">

                <!-- Image -->
                <img src="{{ asset('assets/img/background-admin.jpg') }}"
                    class="w-full h-[420px] object-cover
               transition-transform duration-[1200ms] ease-out
               group-hover:scale-110"
                    alt="Admin Dashboard Banner">

                <!-- Dark cinematic overlay -->
                <div
                    class="absolute inset-0
               bg-gradient-to-br
               from-[#0f172a]/70 via-[#161f36]/30 to-[#020617]/70
               transition-opacity duration-700
               group-hover:opacity-85">
                </div>

                <!-- Accent light sweep -->
                <div
                    class="absolute inset-0 opacity-0 group-hover:opacity-100
               transition duration-1000
               bg-gradient-to-r
               from-transparent via-white/10 to-transparent
               translate-x-[-100%] group-hover:translate-x-[100%]
               ease-out">
                </div>

                <!-- Vignette -->
                <div class="absolute inset-0
               bg-radial-gradient
               pointer-events-none">
                </div>

                <!-- Bottom depth shadow -->
                <div
                    class="absolute bottom-0 left-0 right-0 h-32
               bg-gradient-to-t from-black/40 to-transparent">
                </div>
            </section>


            {{-- TITLE --}}
            <div class="fade-up" style="animation-delay:.15s">
                <h2 class="text-lg font-semibold text-[var(--dark)]">
                    Manajemen Sistem & Pengguna
                </h2>
                <div class="divider mt-4"></div>
            </div>

            {{-- GRID MENU --}}
            <section class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-8">

                @foreach ([
            ['admin.users.index', 'fa-users', 'Manajemen User', 'Kelola akun pengguna, status aktif/nonaktif, serta hak akses sistem.'],
            ['admin.booking.index', 'fa-calendar-check', 'Manajemen Booking', 'Kelola data booking, status pesanan, dan jadwal klien.'],
            ['admin.products.index', 'fa-box', 'Produk & Layanan', 'Kelola layanan, harga, dan detail produk yang ditampilkan di website.'],
            ['admin.facilities.index', 'fa-building', 'Manajemen Fasilitas', 'Kelola fasilitas gedung, area umum, parkir, dan sarana pendukung.'],
            ['admin.news.index', 'fa-newspaper', 'Artikel & Berita', 'Kelola konten berita, pengumuman, dan update perusahaan.'],
            ['admin.testimonials.index', 'fa-quote-right', 'Testimoni Pelanggan', 'Moderasi dan tampilkan ulasan dari pelanggan.'],
            ['admin.feedbacks.index', 'fa-comment-dots', 'Feedback & Kritik', 'Pantau masukan pengguna untuk peningkatan layanan.'],
            ['admin.partners.index', 'fa-handshake', 'Mitra & Partner', 'Kelola daftar mitra bisnis dan kerja sama perusahaan.'],
            ['admin.galleries.index', 'fa-images', 'Galeri Media', 'Kelola gambar & dokumentasi visual website.'],
            ['admin.abouts.index', 'fa-info-circle', 'Profil Perusahaan', 'Atur informasi tentang perusahaan, visi, dan misi.'],
        ] as $i => $c)
                    <a href="{{ route($c[0]) }}" class="tower-card bg-white rounded-xl p-6 border fade-up"
                        style="animation-delay: {{ 0.2 + $i * 0.05 }}s">

                        <div class="flex items-start gap-4 mb-4">
                            <div
                                class="w-10 h-10 flex items-center justify-center rounded-md bg-[var(--accent)] text-white">
                                <i class="fas {{ $c[1] }}"></i>
                            </div>
                            <h3 class="font-semibold text-[var(--dark)] leading-snug">
                                {{ $c[2] }}
                            </h3>
                        </div>

                        <p class="text-sm text-gray-600 leading-relaxed">
                            {{ $c[3] }}
                        </p>

                        <div class="mt-5 text-sm font-semibold text-[var(--dark)] flex items-center gap-2">
                            Buka Menu
                            <i class="fas fa-arrow-right text-xs text-[var(--accent)]"></i>
                        </div>
                    </a>
                @endforeach
            </section>
        </div>

        <script>
            document.addEventListener('DOMContentLoaded', () => {
                document.getElementById('current-date').textContent =
                    new Intl.DateTimeFormat('id-ID', {
                        weekday: 'long',
                        year: 'numeric',
                        month: 'long',
                        day: 'numeric'
                    }).format(new Date());
            });
        </script>
    </div>
@endsection
