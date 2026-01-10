@extends('admin.layouts.app')

@section('content')
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" />
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">

    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background: #F0F2F5;
        }

        :root {
            --accent: #FF8C00;
            --dark: #161f36;
        }

        /* Animasi masuk */
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

        /* Efek kartu tower */
        .tower-card {
            border-left: 5px solid var(--accent);
            transition: all .3s ease;
        }

        .tower-card:hover {
            background: #F9FAFB;
            box-shadow: 0 14px 30px rgba(0, 0, 0, .08);
            transform: translateY(-5px);
        }

        .divider {
            height: 1px;
            background: linear-gradient(to right, transparent, #E5E7EB, transparent);
        }

        /* Perbaikan overlay gradien radial agar lebih halus */
        .bg-radial-gradient {
            background: radial-gradient(circle at center, transparent 0%, rgba(0,0,0,0.4) 100%);
        }
    </style>

    {{-- Container utama yang responsif --}}
    <div class="min-h-screen bg-[#F0F2F5] px-4 sm:px-6 lg:px-8 py-6 md:py-10">
        <div class="max-w-7xl mx-auto space-y-6 md:space-y-10">

            {{-- HEADER: Responsif stack di mobile, flex di desktop --}}
            <header class="bg-white rounded-2xl border px-6 py-5 md:px-8 md:py-7 flex flex-col md:flex-row justify-between items-start md:items-center shadow-sm gap-4">
                <div class="space-y-1 md:space-y-2">
                    <div class="flex items-center gap-3">
                        <span class="w-1.5 h-8 md:w-2 md:h-10 bg-[var(--accent)] rounded-full"></span>
                        <h1 class="text-xl md:text-2xl font-bold text-[var(--dark)] tracking-tight">
                            Dashboard Admin
                        </h1>
                    </div>
                    <p class="text-xs md:text-sm text-gray-500 pl-4 md:pl-5 font-medium">
                        Sistem manajemen infrastruktur dan konten terpadu.
                    </p>
                </div>

                <div class="flex items-center gap-3 text-gray-600 text-xs md:text-sm bg-gray-50 md:bg-transparent px-3 py-2 md:p-0 rounded-xl w-full md:w-auto border md:border-none shadow-sm md:shadow-none">
                    <div class="w-8 h-8 md:w-10 md:h-10 flex items-center justify-center rounded-lg bg-white md:bg-gray-100 shadow-sm md:shadow-none text-[var(--accent)]">
                        <i class="fas fa-calendar-alt"></i>
                    </div>
                    <span id="current-date" class="font-semibold tracking-wide"></span>
                </div>
            </header>

            {{-- BANNER: Ketinggian dinamis berdasarkan ukuran layar --}}
            <section class="relative bg-white border rounded-2xl md:rounded-[2rem] overflow-hidden shadow-xl group isolate">
                <img src="{{ asset('assets/img/background-admin.jpg') }}"
                    class="w-full h-64 sm:h-80 md:h-[400px] lg:h-[450px] object-cover
                    transition-transform duration-[1500ms] ease-out
                    group-hover:scale-110"
                    alt="Admin Dashboard Banner">

                <div class="absolute inset-0 bg-gradient-to-br from-[#0f172a]/70 via-transparent to-[#020617]/80 opacity-60 group-hover:opacity-40 transition-opacity duration-700"></div>
                <div class="absolute inset-0 bg-radial-gradient opacity-50"></div>

                <div class="absolute bottom-6 left-6 md:bottom-10 md:left-10 text-white z-10">
                    <p class="text-[var(--accent)] font-bold text-xs md:text-sm uppercase tracking-[0.3em] mb-1">Rizqallah Portal</p>
                    <h2 class="text-lg md:text-3xl font-black uppercase tracking-tight">PT Rizqallah Boer Makmur</h2>
                </div>
            </section>

            {{-- TITLE SECTION --}}
            <div class="fade-up" style="animation-delay:.15s">
                <div class="flex items-center gap-4">
                    <h2 class="text-base md:text-lg font-bold text-[var(--dark)] uppercase tracking-widest">
                        Navigasi Manajemen
                    </h2>
                    <div class="flex-grow h-[1px] bg-gray-200"></div>
                </div>
            </div>

            {{-- GRID MENU: Otomatis berubah jumlah kolom berdasarkan layar --}}
            <section class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-4 md:gap-6 lg:gap-8 pb-10">

                @php
                    $menus = [
                        ['admin.users.index', 'fa-users', 'Manajemen User', 'Kelola akun, status, serta hak akses sistem.'],
                        ['admin.booking.index', 'fa-calendar-check', 'Manajemen Booking', 'Kelola jadwal klien dan status pesanan.'],
                        ['admin.products.index', 'fa-box', 'Produk & Layanan', 'Atur layanan dan harga produk website.'],
                        ['admin.facilities.index', 'fa-building', 'Manajemen Fasilitas', 'Kelola sarana pendukung dan area umum.'],
                        ['admin.news.index', 'fa-newspaper', 'Artikel & Berita', 'Update konten berita dan pengumuman.'],
                        ['admin.testimonials.index', 'fa-quote-right', 'Testimoni', 'Moderasi ulasan dari pelanggan setia.'],
                        ['admin.feedbacks.index', 'fa-comment-dots', 'Feedback & Kritik', 'Pantau masukan untuk peningkatan layanan.'],
                        ['admin.partners.index', 'fa-handshake', 'Mitra & Partner', 'Kelola daftar kerja sama perusahaan.'],
                        ['admin.galleries.index', 'fa-images', 'Galeri Media', 'Dokumentasi visual proyek website.'],
                        ['admin.abouts.index', 'fa-info-circle', 'Profil Perusahaan', 'Atur visi, misi, dan info perusahaan.'],
                    ];
                @endphp

                @foreach ($menus as $i => $c)
                    <a href="{{ route($c[0]) }}"
                       class="tower-card bg-white rounded-xl p-5 md:p-6 border border-gray-100 flex flex-col justify-between fade-up shadow-sm hover:border-[var(--accent)]/30"
                       style="animation-delay: {{ 0.2 + $i * 0.05 }}s">

                        <div>
                            <div class="flex items-center gap-4 mb-4">
                                <div class="w-10 h-10 md:w-12 md:h-12 shrink-0 flex items-center justify-center rounded-xl bg-[var(--accent)] text-white shadow-lg shadow-orange-100">
                                    <i class="fas {{ $c[1] }} text-sm md:text-base"></i>
                                </div>
                                <h3 class="font-bold text-[var(--dark)] text-sm md:text-base leading-tight">
                                    {{ $c[2] }}
                                </h3>
                            </div>

                            <p class="text-[11px] md:text-xs text-gray-500 leading-relaxed font-medium">
                                {{ $c[3] }}
                            </p>
                        </div>

                        <div class="mt-6 pt-4 border-t border-gray-50 text-[10px] md:text-xs font-bold text-[var(--dark)] flex items-center justify-between uppercase tracking-widest">
                            <span>Buka Menu</span>
                            <div class="w-6 h-6 rounded-full bg-gray-50 flex items-center justify-center group-hover:bg-[var(--accent)] transition-colors">
                                <i class="fas fa-arrow-right text-[10px] text-[var(--accent)] group-hover:text-white"></i>
                            </div>
                        </div>
                    </a>
                @endforeach
            </section>
        </div>

        <script>
            document.addEventListener('DOMContentLoaded', () => {
                const options = { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' };
                document.getElementById('current-date').textContent = new Date().toLocaleDateString('id-ID', options);
            });
        </script>
    </div>
@endsection
