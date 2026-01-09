@extends('layouts.app')

@section('title', 'Search Results')

@section('content')
@php
    // Warna identitas (bisa dipindahkan ke config atau CSS global)
    $rbmDark = '#161f36';
    $rbmAccent = '#FF7518';
@endphp

<div class="container mx-auto px-4 py-12">
    {{-- Header Section --}}
    <div class="mb-10 border-b border-gray-100 pb-6">
        <h1 class="text-3xl md:text-4xl font-extrabold" style="color: {{ $rbmDark }};">
            Hasil Pencarian: <span style="color: {{ $rbmAccent }};">"{{ $query }}"</span>
        </h1>
        <p class="text-gray-500 mt-2">
            Menemukan {{ $products->count() + $services->count() }} hasil yang relevan.
        </p>
    </div>

    @if($products->count() > 0 || $services->count() > 0)

        {{-- Section Produk --}}
        @if($products->count() > 0)
            <div class="mb-12">
                <div class="flex items-center mb-6">
                    <div class="w-2 h-8 mr-3" style="background-color: {{ $rbmAccent }};"></div>
                    <h2 class="text-2xl font-bold uppercase tracking-wide" style="color: {{ $rbmDark }};">Produk</h2>
                </div>
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
                    @foreach($products as $product)
                        <div class="group bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden hover:shadow-xl transition-all duration-300">
                            {{-- Image Wrapper --}}
                            <div class="relative overflow-hidden h-56">
                                @if($product->image)
                                    <img src="{{ asset('storage/' . $product->image) }}"
                                         alt="{{ $product->name }}"
                                         class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-110">
                                @else
                                    <div class="w-full h-full bg-slate-100 flex flex-col items-center justify-center">
                                        <i class="fas fa-image text-slate-300 text-4xl mb-2"></i>
                                        <span class="text-slate-400 text-xs font-bold uppercase">No Image</span>
                                    </div>
                                @endif
                            </div>

                            {{-- Content --}}
                            <div class="p-6">
                                <h3 class="text-xl font-bold mb-2 group-hover:text-orange-500 transition-colors" style="color: {{ $rbmDark }};">
                                    {{ $product->name }}
                                </h3>
                                <p class="text-gray-600 text-sm mb-6 line-clamp-2">
                                    {{ Str::limit(strip_tags($product->description), 120) }}
                                </p>
                                <a href="{{ route('product.show', $product->slug ?? $product->id) }}"
                                   class="inline-flex items-center font-bold text-sm uppercase tracking-wider group-hover:gap-2 transition-all"
                                   style="color: {{ $rbmAccent }};">
                                    Detail Produk <i class="fas fa-arrow-right ml-2"></i>
                                </a>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif

        {{-- Section Layanan --}}
        @if($services->count() > 0)
            <div class="mb-12">
                <div class="flex items-center mb-6">
                    <div class="w-2 h-8 mr-3" style="background-color: {{ $rbmDark }};"></div>
                    <h2 class="text-2xl font-bold uppercase tracking-wide" style="color: {{ $rbmDark }};">Layanan Kami</h2>
                </div>
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
                    @foreach($services as $service)
                        <div class="group bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden hover:shadow-xl transition-all duration-300">
                            <div class="relative overflow-hidden h-56">
                                @if($service->image)
                                    <img src="{{ asset('storage/' . $service->image) }}"
                                         alt="{{ $service->name }}"
                                         class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-110">
                                @else
                                    <div class="w-full h-full bg-slate-100 flex flex-col items-center justify-center">
                                        <i class="fas fa-concierge-bell text-slate-300 text-4xl mb-2"></i>
                                        <span class="text-slate-400 text-xs font-bold uppercase">No Image</span>
                                    </div>
                                @endif
                            </div>

                            <div class="p-6">
                                <h3 class="text-xl font-bold mb-2 group-hover:text-orange-500 transition-colors" style="color: {{ $rbmDark }};">
                                    {{ $service->name }}
                                </h3>
                                <p class="text-gray-600 text-sm mb-6 line-clamp-2">
                                    {{ Str::limit(strip_tags($service->description), 120) }}
                                </p>
                                <a href="{{ route('service.show', $service->slug ?? $service->id) }}"
                                   class="inline-flex items-center font-bold text-sm uppercase tracking-wider group-hover:gap-2 transition-all"
                                   style="color: {{ $rbmAccent }};">
                                    Lihat Layanan <i class="fas fa-arrow-right ml-2"></i>
                                </a>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif

    @else
        {{-- Empty State --}}
        <div class="bg-slate-50 rounded-[3rem] py-20 px-6 text-center border-2 border-dashed border-slate-200">
            <div class="inline-flex items-center justify-center w-24 h-24 rounded-full bg-white shadow-inner mb-6">
                <i class="fas fa-search-minus text-4xl text-slate-300"></i>
            </div>
            <h2 class="text-3xl font-black mb-3" style="color: {{ $rbmDark }};">Oops! Tidak Ditemukan</h2>
            <p class="text-gray-500 max-w-md mx-auto mb-10">
                Kami tidak menemukan hasil untuk <span class="font-bold">"{{ $query }}"</span>. Silakan coba kata kunci lain atau jelajahi kategori kami.
            </p>
            <div class="flex flex-col sm:flex-row justify-center gap-4">
                <a href="{{ route('products') }}"
                   class="px-8 py-3 rounded-xl text-white font-bold transition-transform hover:scale-105 shadow-lg"
                   style="background-color: {{ $rbmDark }};">
                    <i class="fas fa-box-open mr-2"></i> Semua Produk
                </a>
                <a href="{{ route('services') }}"
                   class="px-8 py-3 rounded-xl text-white font-bold transition-transform hover:scale-105 shadow-lg"
                   style="background-color: {{ $rbmAccent }};">
                    <i class="fas fa-tools mr-2"></i> Semua Layanan
                </a>
            </div>
        </div>
    @endif
</div>
@endsection
