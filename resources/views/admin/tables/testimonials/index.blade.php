@extends('admin.layouts.app')

@section('title', 'Testimoni - Admin PT. RBM')

@section('content')

{{-- Tambahkan Font Awesome untuk memastikan ikon muncul --}}
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

{{-- Inisialisasi Kustom Tailwind CSS --}}
<style>
    /* Warna Kustom PT. RBM */
    .text-dark-tower { color: #1e3a8a; }
    .bg-dark-tower { background-color: #1e3a8a; }
    .text-accent-tower { color: #FF7518; }
    .bg-accent-tower { background-color: #FF7518; }
    .hover\:bg-accent-dark:hover { background-color: #e66a15; }
    .shadow-soft { box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08); }

    /* Animasi Action Icon Persis Halaman Produk */
    .action-icon {
        transition: all 0.2s ease;
        display: inline-block;
    }
    .action-icon:hover {
        transform: scale(1.2);
    }
</style>

<div class="container mx-auto p-6">

    {{-- Header Halaman --}}
    <div class="flex flex-col md:flex-row md:items-center justify-between mb-8 gap-4">
        <div>
            <h1 class="text-3xl font-extrabold text-dark-tower tracking-tight uppercase">Manajemen Testimoni</h1>
            <p class="text-sm text-gray-500 mt-1">Kelola masukan pelanggan dan moderasi persetujuan tampilan.</p>
        </div>

        <div class="flex items-center gap-3">
            {{-- Tombol Tambah --}}
            <a href="{{ route('admin.testimonials.create') }}"
               class="bg-accent-tower hover:bg-accent-dark text-white px-5 py-2.5 rounded-xl font-bold transition duration-200 shadow-lg flex items-center justify-center space-x-2 text-sm uppercase tracking-wider">
                <i class="fas fa-plus-circle"></i> <span>Tambah Manual</span>
            </a>
        </div>
    </div>

    {{-- Statistik Ringkas --}}
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
        <div class="bg-white p-6 rounded-2xl shadow-soft border-l-4 border-blue-600">
            <p class="text-xs font-black text-gray-400 uppercase tracking-widest">Total Masuk</p>
            <p class="text-3xl font-bold text-dark-tower">{{ $testimonials->count() }}</p>
        </div>
        <div class="bg-white p-6 rounded-2xl shadow-soft border-l-4 border-green-500">
            <p class="text-xs font-black text-gray-400 uppercase tracking-widest">Disetujui (Live)</p>
            <p class="text-3xl font-bold text-green-600">{{ $testimonials->where('status', 'approved')->count() }}</p>
        </div>
        <div class="bg-white p-6 rounded-2xl shadow-soft border-l-4 border-orange-500">
            <p class="text-xs font-black text-gray-400 uppercase tracking-widest">Pending Moderasi</p>
            <p class="text-3xl font-bold text-orange-500">{{ $testimonials->where('status', 'pending')->count() }}</p>
        </div>
    </div>

    {{-- Alert Notifikasi --}}
    @if(session('success'))
        <div class="bg-green-50 border-l-4 border-green-500 text-green-800 px-4 py-4 rounded-xl relative mb-6 shadow-sm flex items-center">
            <i class="fas fa-check-circle mr-3 text-xl"></i>
            <span class="font-medium">{{ session('success') }}</span>
        </div>
    @endif

    {{-- Tabel Utama --}}
    <div class="bg-white rounded-2xl shadow-soft overflow-hidden border border-gray-100">
        <div class="overflow-x-auto">
            <table class="min-w-full">
                <thead>
                    <tr class="bg-dark-tower text-white uppercase text-[11px] tracking-wider">
                        <th class="px-6 py-4 text-left font-bold">Info Klien</th>
                        <th class="px-6 py-4 text-left font-bold">Pesan</th>
                        <th class="px-6 py-4 text-center font-bold">Status</th>
                        <th class="px-6 py-4 text-center font-bold">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($testimonials as $t)
                        <tr class="hover:bg-gray-50/50 transition">
                            {{-- Info Klien --}}
                            <td class="px-6 py-4">
                                <div class="flex items-center space-x-4">
                                    <div class="flex-shrink-0">
                                        @if($t->image && Storage::disk('public')->exists($t->image))
                                            <img src="{{ asset('storage/'.$t->image) }}" class="w-12 h-12 rounded-full object-cover border-2 border-gray-100 shadow-sm">
                                        @else
                                            <div class="w-12 h-12 rounded-full bg-blue-50 flex items-center justify-center">
                                                <i class="fas fa-user text-blue-300"></i>
                                            </div>
                                        @endif
                                    </div>
                                    <div>
                                        <div class="text-sm font-bold text-dark-tower">{{ $t->name }}</div>
                                        <div class="text-[10px] text-gray-400 font-medium uppercase tracking-tighter">{{ $t->company ?? 'Personal' }}</div>
                                    </div>
                                </div>
                            </td>

                            {{-- Pesan --}}
                            <td class="px-6 py-4">
                                <p class="text-sm text-gray-600 italic line-clamp-2 leading-relaxed">"{{ $t->message }}"</p>
                                <span class="text-[10px] text-gray-400 mt-1 block">{{ $t->created_at->format('d/m/Y H:i') }}</span>
                            </td>

                            {{-- Status --}}
                            <td class="px-6 py-4 text-center">
                                @if($t->status == 'approved')
                                    <span class="px-3 py-1 text-[10px] font-black uppercase bg-green-100 text-green-600 rounded-full">Disetujui</span>
                                @elseif($t->status == 'pending')
                                    <span class="px-3 py-1 text-[10px] font-black uppercase bg-orange-100 text-orange-600 rounded-full">Moderasi</span>
                                @else
                                    <span class="px-3 py-1 text-[10px] font-black uppercase bg-red-100 text-red-600 rounded-full">Ditolak</span>
                                @endif
                            </td>

                            {{-- Aksi (Gaya ikon persis produk) --}}
                            <td class="px-6 py-4 text-center">
                                <div class="flex justify-center items-center space-x-3">

                                    {{-- Tombol Detail (Show) --}}
                                    <a href="{{ route('admin.testimonials.show', $t->id) }}"
                                       class="action-icon text-blue-400 hover:text-blue-600" title="Detail">
                                        <i class="fas fa-eye fa-lg"></i>
                                    </a>

                                    {{-- Tombol Cepat Approve (Jika Status Pending) --}}
                                    @if($t->status == 'pending')
                                    <form action="{{ route('admin.testimonials.status', [$t->id, 'approved']) }}" method="POST" class="inline">
                                        @csrf @method('PATCH')
                                        <button type="submit" class="action-icon text-emerald-400 hover:text-emerald-600" title="Setujui">
                                            <i class="fas fa-check-circle fa-lg"></i>
                                        </button>
                                    </form>
                                    @endif

                                    {{-- Tombol Edit --}}
                                    <a href="{{ route('admin.testimonials.edit', $t->id) }}"
                                       class="action-icon text-amber-400 hover:text-amber-600" title="Edit">
                                        <i class="fas fa-edit fa-lg"></i>
                                    </a>

                                    {{-- Tombol Hapus --}}
                                    <form action="{{ route('admin.testimonials.destroy', $t->id) }}" method="POST" onsubmit="return confirm('Hapus permanen?')" class="inline">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="action-icon text-red-400 hover:text-red-600" title="Hapus">
                                            <i class="fas fa-trash-alt fa-lg"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-6 py-20 text-center">
                                <div class="opacity-20 mb-4">
                                    <i class="fas fa-comments text-6xl text-gray-300"></i>
                                </div>
                                <p class="text-gray-400 font-bold uppercase tracking-widest text-sm">Data Testimoni Kosong</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

@endsection
