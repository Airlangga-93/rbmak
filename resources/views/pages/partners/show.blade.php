@extends('layouts.app')

@section('title', $partner->name . ' - Detail Mitra Industri')

@section('content')
    {{-- Library pendukung --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" />
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <div class="font-['Poppins'] bg-[#F4F7FA] min-h-screen">

        {{-- 🌌 DYNAMIC HERO / BANNER SECTION --}}
        <section class="relative h-[350px] md:h-[500px] overflow-hidden bg-[#161f36]">
            {{-- Logika Gambar Banner --}}
            @php
                // Tentukan gambar utama untuk banner
                $logoPath = $partner->logo;
                if (!$logoPath) {
                    $heroImageUrl = null;
                } elseif (Str::startsWith($logoPath, ['http', 'cloudinary'])) {
                    $heroImageUrl = $logoPath;
                } elseif (Str::startsWith($logoPath, 'assets/')) {
                    $heroImageUrl = asset($logoPath);
                } else {
                    $heroImageUrl = asset('storage/' . $logoPath);
                }
            @endphp

            @if (isset($partnersImages) && $partnersImages->isNotEmpty())
                {{-- Jika ada Galeri Foto Tambahan --}}
                <div x-data="{ activeSlide: 0, total: {{ $partnersImages->count() }} }"
                     x-init="setInterval(() => { activeSlide = (activeSlide + 1) % total }, 5000)"
                     class="relative w-full h-full">
                    @foreach ($partnersImages as $index => $image)
                        <div x-show="activeSlide === {{ $index }}"
                            x-transition:enter="transition ease-out duration-1000"
                            x-transition:enter-start="opacity-0 scale-105"
                            x-transition:enter-end="opacity-100 scale-100"
                            x-transition:leave="transition ease-in duration-1000"
                            class="absolute inset-0">
                            <img src="{{ Storage::url($image->path) }}" class="w-full h-full object-cover opacity-50">
                        </div>
                    @endforeach
                </div>
            @elseif($heroImageUrl)
                {{-- Jika tidak ada galeri, tampilkan Logo sebagai Background Banner --}}
                <div class="absolute inset-0">
                    <img src="{{ $heroImageUrl }}" class="w-full h-full object-cover blur-sm opacity-30">
                    <div class="absolute inset-0 bg-gradient-to-b from-[#161f36]/50 to-[#161f36]"></div>
                </div>
            @else
                {{-- Default Fallback --}}
                <div class="absolute inset-0 bg-gradient-to-r from-[#161f36] to-[#2d3a5d] opacity-90"></div>
            @endif

            {{-- Breadcrumb & Title Overlay --}}
            <div class="absolute inset-0 flex flex-col justify-end pb-12">
                <div class="container mx-auto px-6">
                    <nav class="flex text-sm mb-4" aria-label="Breadcrumb">
                        <ol class="inline-flex items-center space-x-2 text-white/60">
                            <li><a href="/" class="hover:text-[#FF7518] transition-colors">Home</a></li>
                            <li><i class="fas fa-chevron-right text-[8px]"></i></li>
                            <li><a href="{{ route('partners.index') }}" class="hover:text-[#FF7518] transition-colors">Partners</a></li>
                            <li><i class="fas fa-chevron-right text-[8px]"></i></li>
                            <li class="text-[#FF7518] font-bold">Detail</li>
                        </ol>
                    </nav>
                    <h1 class="text-3xl md:text-5xl font-black text-white uppercase tracking-tight">
                        Informasi <span class="text-[#FF7518]">Mitra</span>
                    </h1>
                </div>
            </div>
        </section>

        {{-- 📦 MAIN CONTENT --}}
        <section class="relative z-10 -mt-10 pb-24">
            <div class="container mx-auto px-6">
                <div class="flex flex-col lg:flex-row gap-12">

                    {{-- LEFT COLUMN: MITRA DETAIL --}}
                    <div class="lg:w-2/3">
                        <div class="bg-white rounded-[2.5rem] shadow-2xl shadow-gray-200/50 border border-gray-100 overflow-hidden">

                            {{-- Header Profile Card --}}
                            <div class="p-8 md:p-12 border-b border-gray-50 flex flex-col md:flex-row items-center gap-10">
                                <div class="w-48 h-48 flex-shrink-0 bg-white rounded-[2.5rem] p-6 shadow-2xl shadow-gray-200 border border-gray-50 flex items-center justify-center overflow-hidden transition-transform hover:scale-105 duration-500">
                                    @if ($heroImageUrl)
                                        <img src="{{ $heroImageUrl }}" alt="{{ $partner->name }}" class="max-h-full max-w-full object-contain">
                                    @else
                                        <i class="fas fa-building text-6xl text-gray-100"></i>
                                    @endif
                                </div>

                                <div class="text-center md:text-left">
                                    <span class="px-5 py-2 bg-[#FF7518]/10 text-[#FF7518] rounded-full text-[11px] font-black uppercase tracking-widest mb-4 inline-block">
                                        {{ $partner->sector }}
                                    </span>
                                    <h2 class="text-3xl md:text-5xl font-black text-[#161f36] uppercase tracking-tight leading-tight mb-3">
                                        {{ $partner->name }}
                                    </h2>
                                    <div class="flex flex-wrap justify-center md:justify-start gap-4">
                                        <p class="text-gray-400 font-bold flex items-center gap-2 text-sm uppercase tracking-widest">
                                            <i class="fas fa-map-marker-alt text-[#FF7518]"></i>
                                            {{ $partner->city ?? 'Indonesia' }}
                                        </p>
                                        <p class="text-gray-400 font-bold flex items-center gap-2 text-sm uppercase tracking-widest">
                                            <i class="fas fa-calendar-alt text-[#FF7518]"></i>
                                            Sejak {{ $partner->partnership_date ? \Carbon\Carbon::parse($partner->partnership_date)->format('Y') : '-' }}
                                        </p>
                                    </div>
                                </div>
                            </div>

                            {{-- Content Body --}}
                            <div class="p-8 md:p-12">
                                <div class="flex items-center gap-4 mb-8">
                                    <h3 class="text-2xl font-black text-[#161f36] uppercase tracking-widest">Profil Bisnis</h3>
                                    <div class="h-1 flex-grow bg-gray-100 rounded-full relative overflow-hidden">
                                        <div class="absolute inset-0 w-24 bg-[#FF7518]"></div>
                                    </div>
                                </div>

                                <div class="prose prose-slate max-w-none text-gray-500 leading-relaxed text-lg mb-12">
                                    {!! nl2br(e($partner->description ?? 'Informasi detail mengenai mitra ini sedang dalam proses pembaruan.')) !!}
                                </div>

                                {{-- Info Grid --}}
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                    <div class="group bg-gray-50 p-8 rounded-[2rem] border border-gray-100 transition-all hover:bg-white hover:shadow-xl">
                                        <i class="fas fa-phone-alt text-[#FF7518] mb-4 text-xl"></i>
                                        <p class="text-[10px] font-black text-gray-400 uppercase tracking-[0.2em] mb-1">Kontak Perusahaan</p>
                                        <p class="text-[#161f36] font-bold text-lg">{{ $partner->company_contact ?? 'N/A' }}</p>
                                    </div>

                                    <div class="group bg-gray-50 p-8 rounded-[2rem] border border-gray-100 transition-all hover:bg-white hover:shadow-xl">
                                        <i class="fas fa-calendar-check text-[#FF7518] mb-4 text-xl"></i>
                                        <p class="text-[10px] font-black text-gray-400 uppercase tracking-[0.2em] mb-1">Tanggal Kerjasama</p>
                                        <p class="text-[#161f36] font-bold text-lg">
                                            {{ $partner->partnership_date ? \Carbon\Carbon::parse($partner->partnership_date)->translatedFormat('d F Y') : 'N/A' }}
                                        </p>
                                    </div>

                                    @if ($partner->website)
                                        <div class="md:col-span-2 group bg-[#161f36] p-8 rounded-[2rem] border border-[#161f36] transition-all hover:shadow-2xl">
                                            <i class="fas fa-globe text-[#FF7518] mb-4 text-xl"></i>
                                            <p class="text-[10px] font-black text-gray-400 uppercase tracking-[0.2em] mb-1">Kunjungi Website Resmi</p>
                                            <a href="{{ $partner->website }}" target="_blank" class="text-white font-black text-xl hover:text-[#FF7518] transition-colors flex items-center gap-3 break-all">
                                                {{ str_replace(['http://', 'https://'], '', $partner->website) }}
                                                <i class="fas fa-external-link-alt text-sm"></i>
                                            </a>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- RIGHT COLUMN: SIDEBAR --}}
                    <div class="lg:w-1/3">
                        <div class="sticky top-32 space-y-8">
                            {{-- Other Partners Card --}}
                            <div class="bg-white rounded-[2.5rem] p-8 shadow-xl border border-gray-50">
                                <h3 class="text-xl font-black text-[#161f36] uppercase tracking-widest mb-8 flex items-center gap-3">
                                    <span class="w-2 h-8 bg-[#FF7518] rounded-full"></span>
                                    Mitra Lainnya
                                </h3>

                                <div class="space-y-6">
                                    @forelse ($randomPartners as $suggested)
                                        <a href="{{ route('partners.show', $suggested->id) }}" class="flex items-center gap-5 group">
                                            <div class="w-20 h-20 flex-shrink-0 bg-gray-50 rounded-2xl p-3 flex items-center justify-center transition-all group-hover:bg-white group-hover:shadow-lg group-hover:-rotate-3 border border-transparent group-hover:border-gray-100">
                                                @php
                                                    $sLogo = $suggested->logo;
                                                    if (!$sLogo) $sUrl = null;
                                                    elseif (Str::startsWith($sLogo, ['http', 'cloudinary'])) $sUrl = $sLogo;
                                                    elseif (Str::startsWith($sLogo, 'assets/')) $sUrl = asset($sLogo);
                                                    else $sUrl = asset('storage/' . $sLogo);
                                                @endphp

                                                @if ($sUrl)
                                                    <img src="{{ $sUrl }}" class="max-h-full max-w-full object-contain">
                                                @else
                                                    <i class="fas fa-building text-gray-200"></i>
                                                @endif
                                            </div>
                                            <div class="overflow-hidden">
                                                <h4 class="font-black text-[#161f36] text-sm uppercase group-hover:text-[#FF7518] transition-colors truncate">
                                                    {{ $suggested->name }}
                                                </h4>
                                                <p class="text-[10px] text-gray-400 font-bold uppercase tracking-widest mt-1">
                                                    {{ $suggested->sector }}
                                                </p>
                                            </div>
                                        </a>
                                    @empty
                                        <p class="text-gray-400 text-xs italic text-center py-4">Data tidak tersedia</p>
                                    @endforelse
                                </div>

                                <a href="{{ route('partners.index') }}" class="mt-10 block text-center py-4 rounded-2xl border-2 border-gray-100 text-[#161f36] text-[10px] font-black uppercase tracking-widest hover:bg-[#161f36] hover:text-white transition-all">
                                    Lihat Semua Mitra
                                </a>
                            </div>

                            {{-- CTA Card --}}
                            <div class="bg-[#FF7518] rounded-[2.5rem] p-10 text-white relative overflow-hidden group">
                                <i class="fas fa-handshake absolute -right-4 -bottom-4 text-9xl text-white/10 group-hover:scale-110 transition-transform duration-700"></i>
                                <h3 class="text-2xl font-black uppercase leading-tight mb-4 relative z-10">Mulai Kolaborasi Sekarang</h3>
                                <p class="text-white/80 text-sm mb-8 relative z-10">Hubungi tim kami untuk mendiskusikan peluang kerjasama infrastruktur yang strategis.</p>
                                <a href="{{ route('contact') }}" class="inline-flex items-center gap-3 bg-[#161f36] text-white px-8 py-4 rounded-xl font-black text-[10px] uppercase tracking-widest hover:bg-white hover:text-[#161f36] transition-all shadow-lg relative z-10">
                                    Hubungi Kami <i class="fas fa-arrow-right"></i>
                                </a>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </section>
    </div>
@endsection
