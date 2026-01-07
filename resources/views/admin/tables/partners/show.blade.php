@extends('admin.layouts.app')

@section('title', 'Detail Mitra Industri: ' . ($partner->name ?? ''))

@section('content')
<div class="main-content flex-1 p-4 md:p-6 font-['Poppins']">
    <div class="bg-white rounded-xl shadow-lg p-6 md:p-8">

        {{-- Header & Tombol Navigasi --}}
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-8 border-b pb-6 border-gray-100 gap-4">
            <div>
                <h1 class="text-3xl font-bold text-[#2C3E50] flex items-center">
                    <i class="fas fa-building text-[#FF8C00] mr-3"></i> Profil Mitra
                </h1>
                <p class="text-gray-500 text-sm mt-1">Detail informasi lengkap kemitraan industri.</p>
            </div>

            <div class="flex flex-wrap gap-2">
                <a href="{{ route('admin.partners.index') }}"
                    class="bg-gray-100 text-[#2C3E50] px-4 py-2 rounded-lg font-semibold hover:bg-gray-200 transition-all flex items-center space-x-2 text-sm">
                    <i class="fas fa-arrow-left"></i>
                    <span>Kembali</span>
                </a>
                <a href="{{ route('admin.partners.edit', $partner->id) }}"
                    class="bg-[#FF8C00] text-white px-4 py-2 rounded-lg font-semibold hover:bg-[#E67E22] transition-all flex items-center space-x-2 text-sm shadow-md">
                    <i class="fas fa-edit"></i>
                    <span>Edit</span>
                </a>
                <form action="{{ route('admin.partners.destroy', $partner->id) }}" method="POST"
                    onsubmit="return confirm('Apakah Anda yakin ingin menghapus mitra ini?');" class="inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit"
                        class="bg-red-500 text-white px-4 py-2 rounded-lg font-semibold hover:bg-red-600 transition-all flex items-center space-x-2 text-sm shadow-md">
                        <i class="fas fa-trash-alt"></i>
                        <span>Hapus</span>
                    </button>
                </form>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

            {{-- Kolom Kiri: Logo & Badge --}}
            <div class="lg:col-span-1 flex flex-col items-center p-8 border border-gray-100 rounded-2xl bg-gray-50/50">
                <div class="relative group">
                    @php
                        // Logika pengecekan lokasi gambar
                        $imagePath = $partner->logo;
                        if ($imagePath && !str_contains($imagePath, 'assets/img')) {
                            $imageUrl = asset('storage/' . $imagePath);
                        } elseif ($imagePath) {
                            $imageUrl = asset($imagePath);
                        } else {
                            $imageUrl = null;
                        }
                    @endphp

                    @if($imageUrl)
                        <img src="{{ $imageUrl }}" alt="{{ $partner->name }}"
                            class="w-56 h-56 object-contain rounded-2xl shadow-xl border-4 border-white bg-white p-4 transition-transform duration-300 group-hover:scale-105">
                    @else
                        <div class="w-56 h-56 bg-gray-200 flex flex-col items-center justify-center rounded-2xl border-2 border-dashed border-gray-300">
                            <i class="fas fa-image fa-4x text-gray-400 mb-2"></i>
                            <p class="text-xs text-gray-500 font-medium">Tanpa Logo</p>
                        </div>
                    @endif
                </div>

                <div class="mt-8 text-center">
                    <h2 class="text-2xl font-bold text-[#2C3E50] mb-2">{{ $partner->name }}</h2>

                    @php
                        $sector = strtoupper($partner->sector ?? '');
                        $badgeStyle = match($sector) {
                            'TOWER PROVIDER' => 'bg-blue-100 text-blue-700 border-blue-200',
                            'NON TOWER PROVIDER' => 'bg-orange-100 text-orange-700 border-orange-200',
                            default => 'bg-emerald-100 text-emerald-700 border-emerald-200',
                        };
                    @endphp

                    <span class="inline-flex items-center px-4 py-1.5 rounded-full text-xs font-bold border {{ $badgeStyle }}">
                        <i class="fas fa-tag mr-2"></i> {{ $sector ?: 'UMUM' }}
                    </span>
                </div>
            </div>

            {{-- Kolom Kanan: Detail Informasi --}}
            <div class="lg:col-span-2 space-y-6">

                {{-- Detail Table --}}
                <div class="overflow-hidden border border-gray-100 rounded-2xl shadow-sm bg-white">
                    <div class="bg-gray-50 px-6 py-4 border-b border-gray-100">
                        <h3 class="font-bold text-[#2C3E50] flex items-center">
                            <i class="fas fa-info-circle text-[#FF8C00] mr-2"></i> Informasi Perusahaan
                        </h3>
                    </div>
                    <div class="p-6">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-y-6 gap-x-8">
                            <div>
                                <label class="text-xs font-bold text-gray-400 uppercase tracking-wider">Kota Lokasi</label>
                                <p class="text-[#2C3E50] font-semibold flex items-center mt-1">
                                    <i class="fas fa-map-marker-alt text-red-500 mr-2 w-4"></i> {{ $partner->city ?? '-' }}
                                </p>
                            </div>
                            <div>
                                <label class="text-xs font-bold text-gray-400 uppercase tracking-wider">Kontak Perusahaan</label>
                                <p class="text-[#2C3E50] font-semibold flex items-center mt-1">
                                    <i class="fas fa-phone-alt text-blue-500 mr-2 w-4"></i> {{ $partner->company_contact ?? '-' }}
                                </p>
                            </div>
                            <div>
                                <label class="text-xs font-bold text-gray-400 uppercase tracking-wider">Tanggal Kerja Sama</label>
                                <p class="text-[#2C3E50] font-semibold flex items-center mt-1">
                                    <i class="fas fa-calendar-check text-emerald-500 mr-2 w-4"></i>
                                    {{ $partner->partnership_date ? \Carbon\Carbon::parse($partner->partnership_date)->translatedFormat('d F Y') : '-' }}
                                </p>
                            </div>
                            <div>
                                <label class="text-xs font-bold text-gray-400 uppercase tracking-wider">Diterbitkan Oleh</label>
                                <p class="text-[#2C3E50] font-semibold flex items-center mt-1">
                                    <i class="fas fa-user-edit text-purple-500 mr-2 w-4"></i> {{ $partner->publisher ?? 'Administrator' }}
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Deskripsi --}}
                <div class="border border-gray-100 rounded-2xl shadow-sm bg-white overflow-hidden">
                    <div class="bg-gray-50 px-6 py-4 border-b border-gray-100">
                        <h3 class="font-bold text-[#2C3E50] flex items-center">
                            <i class="fas fa-file-alt text-[#FF8C00] mr-2"></i> Tentang Mitra
                        </h3>
                    </div>
                    <div class="p-6">
                        <div class="prose max-w-none text-gray-600 leading-relaxed italic">
                            {!! nl2br(e($partner->description ?? 'Tidak ada deskripsi yang tersedia untuk mitra ini.')) !!}
                        </div>
                    </div>
                </div>

                <div class="text-right text-xs text-gray-400 italic">
                    Terakhir diperbarui: {{ $partner->updated_at->diffForHumans() }}
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap');

    .main-content {
        animation: fadeIn 0.5s ease-in-out;
    }

    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(10px); }
        to { opacity: 1; transform: translateY(0); }
    }
</style>
@endsection
