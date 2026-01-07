@extends('layouts.app')

@section('title', 'Layanan Kami - PT SAYAP SEMBILAN SATU')

@push('styles')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <style>
        :root {
            --accent: #D4AF37;
            /* Gold Metallic */
            --accent-dark: #B8860B;
            --primary-dark: #161f36;
            /* Navy Deep */
            --bg-soft: #F4F7FA;
            --text-main: #2D3436;
            --glass: rgba(255, 255, 255, 0.8);
        }

        body {
            background: var(--bg-soft);
            font-family: 'Plus Jakarta Sans', sans-serif;
        }

        /* -------------------------------------
           HERO SECTION: MODERN & BOLD
        ---------------------------------------*/
        .service-header {
            background: var(--primary-dark);
            padding: 160px 0 120px;
            position: relative;
            overflow: hidden;
            text-align: left;
        }

        .service-header::before {
            content: "";
            position: absolute;
            top: 0;
            right: 0;
            width: 40%;
            height: 100%;
            background: linear-gradient(to left, rgba(212, 175, 55, 0.1), transparent);
            clip-path: polygon(20% 0%, 100% 0%, 100% 100%, 0% 100%);
        }

        .service-header .tag {
            display: inline-block;
            background: rgba(212, 175, 55, 0.15);
            color: var(--accent);
            padding: 6px 16px;
            border-radius: 50px;
            font-size: 0.75rem;
            font-weight: 800;
            letter-spacing: 2px;
            margin-bottom: 20px;
            border: 1px solid rgba(212, 175, 55, 0.3);
        }

        .service-header h1 {
            font-size: 4rem;
            font-weight: 900;
            color: #fff;
            line-height: 1.1;
            letter-spacing: -2px;
        }

        .service-header p {
            color: #a0aec0;
            font-size: 1.1rem;
            max-width: 600px;
            margin-top: 20px;
        }

        /* -------------------------------------
           FILTER BAR: GLASSMORPHISM
        ---------------------------------------*/
        .sticky-filter {
            margin-top: -40px;
            position: relative;
            z-index: 10;
        }

        .filter-wrapper {
            background: var(--glass);
            backdrop-filter: blur(15px);
            padding: 25px 35px;
            border-radius: 20px;
            border: 1px solid rgba(255, 255, 255, 0.4);
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.05);
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        /* -------------------------------------
           SERVICE CARD: PREMIUM LOOK
        ---------------------------------------*/
        .service-card {
            background: #fff;
            border-radius: 24px;
            border: 1px solid #edf2f7;
            transition: all 0.5s cubic-bezier(0.4, 0, 0.2, 1);
            position: relative;
            overflow: hidden;
        }

        .img-container {
            position: relative;
            overflow: hidden;
            margin: 12px;
            border-radius: 18px;
        }

        .service-card img {
            height: 220px;
            width: 100%;
            object-fit: cover;
            transition: transform 0.6s ease;
        }

        .card-badge {
            position: absolute;
            top: 15px;
            left: 15px;
            background: var(--primary-dark);
            color: var(--accent);
            font-size: 0.65rem;
            font-weight: 800;
            padding: 5px 12px;
            border-radius: 8px;
            z-index: 2;
        }

        .service-card:hover {
            transform: translateY(-12px);
            border-color: var(--accent);
            box-shadow: 0 30px 60px rgba(22, 31, 54, 0.1);
        }

        .service-card:hover img {
            transform: scale(1.1);
        }

        .card-content {
            padding: 10px 25px 25px;
        }

        .service-card h5 {
            font-weight: 800;
            color: var(--primary-dark);
            font-size: 1.25rem;
            margin-bottom: 12px;
            letter-spacing: -0.5px;
        }

        .price-tag {
            background: #f8f9fa;
            padding: 15px;
            border-radius: 15px;
            margin-top: 20px;
            transition: all 0.4s;
        }

        .service-card:hover .price-tag {
            background: var(--primary-dark);
        }

        .price-tag .label {
            font-size: 0.7rem;
            font-weight: 700;
            color: #718096;
            text-transform: uppercase;
            display: block;
        }

        .price-tag .value {
            font-size: 1.3rem;
            font-weight: 900;
            color: var(--primary-dark);
        }

        .service-card:hover .value {
            color: #fff;
        }

        .service-card:hover .label {
            color: var(--accent);
        }

        /* Button Detail */
        .btn-detail {
            width: 50px;
            height: 50px;
            background: var(--accent);
            color: var(--primary-dark);
            border-radius: 15px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
            transition: all 0.4s;
            text-decoration: none;
        }

        .service-card:hover .btn-detail {
            background: #fff;
            transform: rotate(-45deg);
        }

        /* -------------------------------------
           LOAD MORE
        ---------------------------------------*/
        .load-more-btn {
            background: var(--primary-dark);
            color: #fff;
            border: none;
            padding: 16px 45px;
            border-radius: 15px;
            font-weight: 800;
            letter-spacing: 1px;
            transition: all 0.3s;
        }

        .load-more-btn:hover {
            background: var(--accent);
            color: var(--primary-dark);
            transform: scale(1.05);
        }

        @media(max-width: 767px) {
            .service-header h1 {
                font-size: 2.8rem;
            }

            .filter-wrapper {
                flex-direction: column;
                gap: 15px;
                text-align: center;
            }
        }
    </style>
@endpush

@section('content')

    {{-- Header --}}
    <section class="service-header">
        <div class="container">
            <div class="tag" data-aos="fade-right">PREMIUM SERVICES</div>
            <h1 data-aos="fade-right" data-aos-delay="100">Solusi Infrastruktur <br><span style="color: var(--accent)">Menara
                    Unggulan</span></h1>
            <p data-aos="fade-right" data-aos-delay="200">Menyediakan layanan fabrikasi, instalasi, dan pemeliharaan tower
                dengan standar keamanan tinggi dan ketepatan waktu maksimal.</p>
        </div>
    </section>

    {{-- Content --}}
    <section class="section-bg pb-5">
        <div class="container sticky-filter">
            {{-- Filter Bar --}}
            <div class="filter-wrapper mb-5" data-aos="zoom-in">
                <h4 class="m-0 fw-900" style="color: var(--primary-dark); font-weight: 800;">
                    <span class="text-muted fw-light">Total:</span> {{ count($items) }} Layanan
                </h4>
                <a href="#" class="btn py-2 px-4 rounded-pill fw-bold text-decoration-none"
                    style="background: rgba(212,175,55,0.1); color: var(--accent-dark);">
                    <i class="bi bi-sliders2-vertical me-2"></i>Kategori Layanan
                </a>
            </div>

            {{-- Grid Layanan --}}
            <div class="row g-4">
                @forelse($items as $service)
                    <div class="col-xl-3 col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="{{ $loop->index * 50 }}">
                        <div class="service-card h-100 d-flex flex-column">

                            <div class="img-container">
                                <span class="card-badge">TOWER TECH</span>
                                <a href="{{ route('service.show', $service->slug ?? $service->id) }}">
                                    <img src="{{ asset('storage/' . $service->image) }}" alt="{{ $service->name }}">
                                </a>
                            </div>

                            <div class="card-content flex-grow-1">
                                <div class="d-flex justify-content-between align-items-start mb-2">
                                    <h5 class="text-truncate" title="{{ $service->name }}">{{ $service->name }}</h5>
                                </div>

                                <div class="mb-3">
                                    @for ($i = 1; $i <= 5; $i++)
                                        <i class="bi bi-star-fill" style="color: var(--accent); font-size: 0.75rem;"></i>
                                    @endfor
                                    <span class="text-muted small ms-2">5.0</span>
                                </div>

                                <p class="text-muted small" style="line-height: 1.6; height: 45px; overflow: hidden;">
                                    {{ Str::limit(strip_tags($service->description ?? 'Deskripsi layanan konstruksi dan pemeliharaan infrastruktur menara profesional.'), 70) }}
                                </p>

                                <div class="d-flex align-items-center justify-content-between mt-auto">
                                    <div class="price-tag flex-grow-1 me-3">
                                        <span class="label">Mulai Dari</span>
                                        <span class="value">Rp {{ number_format($service->price, 0, ',', '.') }}</span>
                                    </div>
                                    <a href="{{ route('service.show', $service->slug ?? $service->id) }}"
                                        class="btn-detail">
                                        <i class="bi bi-arrow-right"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-12 text-center py-5">
                        <div class="py-5 bg-white rounded-4 border border-dashed">
                            <i class="bi bi-box-seam fs-1 mb-3 text-muted"></i>
                            <h5 class="fw-bold">Layanan Tidak Ditemukan</h5>
                            <p class="text-muted">Kami sedang memperbarui daftar layanan kami. Silakan kembali sesaat lagi.
                            </p>
                        </div>
                    </div>
                @endforelse
            </div>

            {{-- Load More --}}
            @if (count($items) > 8)
                <div class="text-center mt-5 pt-4">
                    <button class="load-more-btn shadow-lg">
                        JELAJAHI LEBIH BANYAK <i class="bi bi-chevron-down ms-2"></i>
                    </button>
                </div>
            @endif
        </div>
    </section>
@endsection
