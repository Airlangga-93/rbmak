@extends('admin.layouts.app')

@section('title', 'Manajemen Booking')

@section('content')
    {{-- Memastikan Library Ikon Termuat --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">

    <div class="container mx-auto px-4 sm:px-6 lg:px-8 py-8">

        {{-- Header Halaman --}}
        <div class="flex flex-col md:flex-row md:items-center justify-between mb-8 gap-4">
            <div>
                <h1 class="text-2xl md:text-3xl font-extrabold text-slate-800 tracking-tight">
                    <i class="fas fa-calendar-check me-2 text-orange-500"></i> Manajemen Booking
                </h1>
                <p class="text-slate-500 text-sm mt-1">Pantau reservasi pelanggan dan kelola status layanan secara terpusat.</p>
            </div>
            <div class="flex gap-3">
                <span class="bg-slate-800 text-white px-5 py-2.5 rounded-2xl text-xs md:text-sm font-black shadow-lg shadow-slate-200 flex items-center shrink-0 uppercase tracking-widest">
                    Total: {{ $reservations->total() }} Pesanan
                </span>
            </div>
        </div>

        {{-- Notifikasi --}}
        @if (session('success'))
            <div class="bg-emerald-50 border border-emerald-100 text-emerald-700 p-4 rounded-2xl mb-6 shadow-sm flex items-center">
                <div class="w-8 h-8 bg-emerald-500 text-white rounded-lg flex items-center justify-center mr-3 shrink-0">
                    <i class="fas fa-check text-xs"></i>
                </div>
                <p class="text-xs md:text-sm font-bold">{{ session('success') }}</p>
            </div>
        @endif

        {{-- CONTAINER UTAMA --}}
        <div class="bg-white rounded-[2.5rem] shadow-xl shadow-slate-200/60 border border-slate-100 overflow-hidden">

            {{-- 🖥️ DESKTOP VIEW (MD ke Atas) --}}
            <div class="hidden md:block overflow-x-auto">
                <table class="min-w-full border-collapse">
                    <thead>
                        <tr class="bg-slate-50/50 border-b border-slate-100">
                            <th class="px-6 py-5 text-center text-[10px] font-black text-slate-400 uppercase tracking-[0.2em]">No</th>
                            <th class="px-6 py-5 text-left text-[10px] font-black text-slate-400 uppercase tracking-[0.2em]">Pelanggan</th>
                            <th class="px-6 py-5 text-left text-[10px] font-black text-slate-400 uppercase tracking-[0.2em]">Layanan & Harga</th>
                            <th class="px-6 py-5 text-left text-[10px] font-black text-slate-400 uppercase tracking-[0.2em]">Jadwal</th>
                            <th class="px-6 py-5 text-center text-[10px] font-black text-slate-400 uppercase tracking-[0.2em]">Status Kontrol</th>
                            <th class="px-6 py-5 text-center text-[10px] font-black text-slate-400 uppercase tracking-[0.2em]">Aksi Cepat</th>
                        </tr>
                    </thead>

                    <tbody class="divide-y divide-slate-50">
                        @forelse($reservations as $reservation)
                            <tr class="hover:bg-slate-50/40 transition-colors group">
                                <td class="px-6 py-4 text-center text-slate-300 font-black text-[10px]">
                                    {{ ($reservations->currentPage() - 1) * $reservations->perPage() + $loop->iteration }}
                                </td>

                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-4">
                                        <div class="w-11 h-11 bg-orange-100 text-orange-600 rounded-2xl flex items-center justify-center font-black text-sm relative shrink-0 border border-orange-200/50">
                                            {{ strtoupper(substr($reservation->user->name ?? 'U', 0, 1)) }}

                                            @if ($reservation->user && $reservation->user->unread_messages_count > 0)
                                                <span class="absolute -top-1.5 -right-1.5 flex h-5 w-5">
                                                    <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-red-400 opacity-75"></span>
                                                    <span class="relative inline-flex rounded-full h-5 w-5 bg-red-600 border-2 border-white text-[9px] text-white items-center justify-center font-black">
                                                        {{ $reservation->user->unread_messages_count }}
                                                    </span>
                                                </span>
                                            @endif
                                        </div>
                                        <div class="min-w-0">
                                            <div class="font-bold text-slate-800 truncate group-hover:text-orange-600 transition-colors">
                                                {{ $reservation->user->name ?? 'User Terhapus' }}
                                            </div>
                                            <div class="text-[10px] text-slate-400 font-bold uppercase tracking-widest mt-0.5">
                                                #BOK-{{ str_pad($reservation->id, 5, '0', STR_PAD_LEFT) }}
                                            </div>
                                        </div>
                                    </div>
                                </td>

                                <td class="px-6 py-4">
                                    <div class="text-xs font-bold text-slate-700 leading-tight uppercase">
                                        {{ $reservation->services }}
                                    </div>
                                    <div class="text-orange-600 font-black text-xs mt-1">
                                        Rp{{ number_format($reservation->total_price, 0, ',', '.') }}
                                    </div>
                                </td>

                                <td class="px-6 py-4">
                                    <div class="text-xs font-bold text-slate-700">
                                        {{ \Carbon\Carbon::parse($reservation->date)->translatedFormat('d M Y') }}
                                    </div>
                                    <div class="text-[10px] text-slate-400 font-bold uppercase tracking-tighter">
                                        <i class="far fa-clock mr-1 text-orange-400"></i> {{ $reservation->time }} WIB
                                    </div>
                                </td>

                                <td class="px-6 py-4 text-center">
                                    <form action="{{ route('admin.booking.update', $reservation->id) }}" method="POST">
                                        @csrf @method('PUT')
                                        <select name="status" onchange="this.form.submit()"
                                            class="text-[9px] font-black uppercase border-2 rounded-xl px-3 py-2 cursor-pointer outline-none transition-all shadow-sm
                                        @if ($reservation->status == 'pending') bg-orange-50 text-orange-600 border-orange-100
                                        @elseif($reservation->status == 'proses') bg-blue-50 text-blue-600 border-blue-100
                                        @elseif($reservation->status == 'selesai') bg-emerald-50 text-emerald-600 border-emerald-100
                                        @else bg-red-50 text-red-600 border-red-100 @endif">
                                            <option value="pending" {{ $reservation->status == 'pending' ? 'selected' : '' }}>Pending</option>
                                            <option value="proses" {{ $reservation->status == 'proses' ? 'selected' : '' }}>Proses</option>
                                            <option value="selesai" {{ $reservation->status == 'selesai' ? 'selected' : '' }}>Selesai</option>
                                            <option value="batal" {{ $reservation->status == 'batal' ? 'selected' : '' }}>Batal</option>
                                        </select>
                                    </form>
                                </td>

                                <td class="px-6 py-4">
                                    {{-- PERBAIKAN TOMBOL AKSI DISINI --}}
                                    <div class="flex items-center justify-center gap-3">
                                        @if($reservation->user)
                                            <a href="{{ route('admin.booking.chat', $reservation->user_id) }}"
                                                class="h-10 w-10 flex items-center justify-center bg-slate-900 text-white rounded-xl hover:bg-orange-600 transition-all shadow-md active:scale-90" title="Kirim Pesan">
                                                <i class="fas fa-paper-plane text-xs"></i>
                                            </a>
                                        @endif

                                        <form action="{{ route('admin.booking.destroy', $reservation->id) }}" method="POST" onsubmit="return confirm('Hapus data booking ini?')">
                                            @csrf @method('DELETE')
                                            <button type="submit" class="h-10 w-10 flex items-center justify-center bg-white border border-slate-200 text-slate-400 hover:text-red-600 hover:border-red-200 hover:bg-red-50 rounded-xl transition-all shadow-sm active:scale-90" title="Hapus Data">
                                                <i class="fas fa-trash-alt text-xs"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="6" class="py-20 text-center text-slate-400 font-bold italic">Belum ada data reservasi.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{-- 📱 MOBILE VIEW (OPTIMIZED CARDS) --}}
            <div class="md:hidden divide-y divide-slate-100">
                @forelse($reservations as $reservation)
                    <div class="p-6 space-y-5">
                        <div class="flex justify-between items-start">
                            <div class="flex gap-4">
                                <div class="w-12 h-12 bg-orange-100 text-orange-600 rounded-[1.25rem] flex items-center justify-center font-black text-base relative border border-orange-200">
                                    {{ strtoupper(substr($reservation->user->name ?? 'U', 0, 1)) }}
                                    @if ($reservation->user && $reservation->user->unread_messages_count > 0)
                                        <span class="absolute -top-1 -right-1 h-4 w-4 bg-red-600 rounded-full border-2 border-white"></span>
                                    @endif
                                </div>
                                <div class="min-w-0">
                                    <div class="font-bold text-slate-800 text-sm leading-tight truncate">{{ $reservation->user->name ?? 'User N/A' }}</div>
                                    <div class="text-[10px] font-black text-slate-400 uppercase tracking-widest mt-1">ID: #BOK-{{ $reservation->id }}</div>
                                </div>
                            </div>
                            <div class="text-right shrink-0">
                                <div class="text-xs font-black text-orange-600">Rp{{ number_format($reservation->total_price, 0, ',', '.') }}</div>
                                <div class="text-[9px] font-bold text-slate-400 uppercase tracking-tighter mt-1">{{ $reservation->time }} WIB</div>
                            </div>
                        </div>

                        <div class="bg-slate-50 rounded-2xl p-4 border border-slate-100 flex items-center justify-between">
                            <div class="min-w-0">
                                <p class="text-[8px] font-black text-slate-400 uppercase tracking-widest mb-1">Layanan Terpilih</p>
                                <p class="text-[11px] font-bold text-slate-700 uppercase leading-tight truncate">{{ $reservation->services }}</p>
                            </div>
                        </div>

                        <div class="flex items-center gap-3">
                            <div class="flex-1">
                                <form action="{{ route('admin.booking.update', $reservation->id) }}" method="POST">
                                    @csrf @method('PUT')
                                    <select name="status" onchange="this.form.submit()" class="w-full text-[10px] font-black uppercase border-2 rounded-xl px-3 py-3 shadow-sm outline-none">
                                        <option value="pending" {{ $reservation->status == 'pending' ? 'selected' : '' }}>Pending</option>
                                        <option value="proses" {{ $reservation->status == 'proses' ? 'selected' : '' }}>Proses</option>
                                        <option value="selesai" {{ $reservation->status == 'selesai' ? 'selected' : '' }}>Selesai</option>
                                        <option value="batal" {{ $reservation->status == 'batal' ? 'selected' : '' }}>Batal</option>
                                    </select>
                                </form>
                            </div>
                            <div class="flex gap-2">
                                <a href="{{ route('admin.booking.chat', $reservation->user_id) }}" class="h-11 w-11 flex items-center justify-center bg-slate-900 text-white rounded-xl shadow-lg active:scale-90 transition-transform">
                                    <i class="fas fa-paper-plane text-xs"></i>
                                </a>
                                <form action="{{ route('admin.booking.destroy', $reservation->id) }}" method="POST">
                                    @csrf @method('DELETE')
                                    <button class="h-11 w-11 flex items-center justify-center bg-red-50 text-red-500 rounded-xl border border-red-100 active:scale-90 transition-transform">
                                        <i class="fas fa-trash-alt text-xs"></i>
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="p-16 text-center text-slate-400 font-bold italic text-sm">Belum ada data reservasi masuk.</div>
                @endforelse
            </div>
        </div>

        <div class="mt-8">
            {{ $reservations->links() }}
        </div>
    </div>
@endsection
