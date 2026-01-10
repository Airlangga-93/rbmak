@extends('layouts.booking')

@section('title', 'Riwayat Booking - PT RIZQALLAH')
@section('header_title', 'Riwayat Pesanan')
@section('header_subtitle', 'Pantau status layanan Anda secara real-time')

@section('styles')
    <style>
        /* Animasi pulse untuk status pending */
        @keyframes pulse-orange {
            0% { box-shadow: 0 0 0 0 rgba(249, 115, 22, 0.4); }
            70% { box-shadow: 0 0 0 10px rgba(249, 115, 22, 0); }
            100% { box-shadow: 0 0 0 0 rgba(249, 115, 22, 0); }
        }
        .status-pulse { animation: pulse-orange 2s infinite; }

        /* Hide scrollbar for cleaner look on mobile */
        .no-scrollbar::-webkit-scrollbar { display: none; }
    </style>
@endsection

@section('content')
    {{-- STATS MINI --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4 mb-8">
        <div class="bg-white border border-slate-200 p-5 rounded-3xl flex items-center space-x-4 shadow-sm">
            <div class="w-12 h-12 bg-orange-50 text-orange-600 rounded-2xl flex items-center justify-center text-xl shrink-0">
                <i class="fa-solid fa-box-archive"></i>
            </div>
            <div>
                <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">Total Booking</p>
                <h3 class="text-xl font-black text-slate-900">{{ $bookings->count() }}</h3>
            </div>
        </div>

        {{-- Tombol Booking Baru khusus Mobile --}}
        <div class="sm:hidden">
            <a href="{{ route('booking.index') }}" class="flex items-center justify-center w-full h-full py-4 bg-slate-900 text-white rounded-3xl font-bold text-xs uppercase tracking-widest gap-2 shadow-lg shadow-slate-200 active:scale-95 transition-transform">
                <i class="fa-solid fa-plus"></i> Booking Baru
            </a>
        </div>
    </div>

    {{-- CONTAINER RIWAYAT --}}
    <div class="bg-white border border-slate-200 rounded-[32px] overflow-hidden shadow-sm">

        {{-- 🖥️ TAMPILAN TABEL (Hanya muncul di Desktop/Tablet - Layar MD ke atas) --}}
        <div class="hidden md:block overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-50/50">
                        <th class="px-6 py-5 text-[10px] font-black text-slate-400 uppercase tracking-widest">Detail Layanan</th>
                        <th class="px-6 py-5 text-[10px] font-black text-slate-400 uppercase tracking-widest">Jadwal (WIB)</th>
                        <th class="px-6 py-5 text-[10px] font-black text-slate-400 uppercase tracking-widest">Total Biaya</th>
                        <th class="px-6 py-5 text-[10px] font-black text-slate-400 uppercase tracking-widest">Status</th>
                        <th class="px-6 py-5 text-[10px] font-black text-slate-400 uppercase tracking-widest text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($bookings as $booking)
                        <tr class="hover:bg-slate-50/30 transition-colors">
                            <td class="px-6 py-6">
                                <div class="flex flex-col">
                                    <span class="text-sm font-bold text-slate-800">{{ $booking->services ?? 'Layanan Custom' }}</span>
                                    <span class="text-[10px] font-bold text-slate-400 mt-1 uppercase tracking-tighter">ID: #BOK-{{ str_pad($booking->id, 5, '0', STR_PAD_LEFT) }}</span>
                                </div>
                            </td>
                            <td class="px-6 py-6">
                                <div class="flex flex-col">
                                    <div class="flex items-center text-xs font-bold text-slate-700">
                                        <i class="fa-regular fa-calendar-check mr-2 text-orange-500"></i>
                                        {{ \Carbon\Carbon::parse($booking->date)->locale('id')->settings(['formatFunction' => 'translatedFormat'])->format('d M Y') }}
                                    </div>
                                    <span class="text-[10px] text-slate-400 font-bold mt-1 ml-6">{{ $booking->time }} WIB</span>
                                </div>
                            </td>
                            <td class="px-6 py-6">
                                <span class="text-sm font-black text-slate-900">Rp{{ number_format((float) ($booking->total_price ?? 0), 0, ',', '.') }}</span>
                            </td>
                            <td class="px-6 py-6">
                                @php $status = strtolower($booking->status ?? 'pending'); @endphp
                                @if ($status == 'pending')
                                    <span class="status-pulse inline-flex items-center px-3 py-1 rounded-full text-[9px] font-black bg-orange-50 text-orange-600 border border-orange-100 uppercase">PENDING</span>
                                @elseif($status == 'proses')
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-[9px] font-black bg-blue-50 text-blue-600 border border-blue-100 uppercase">PROSES</span>
                                @elseif($status == 'selesai')
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-[9px] font-black bg-green-50 text-green-600 border border-green-100 uppercase">SELESAI</span>
                                @else
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-[9px] font-black bg-red-50 text-red-600 border border-red-100 uppercase">BATAL</span>
                                @endif
                            </td>
                            <td class="px-6 py-6 text-center">
                                <div class="flex items-center justify-center space-x-2">
                                    <a href="{{ route('chat.index') }}" class="w-9 h-9 flex items-center justify-center bg-slate-900 text-white rounded-xl hover:bg-orange-600 transition-all shadow-md shadow-slate-200">
                                        <i class="fa-solid fa-message text-xs"></i>
                                    </a>
                                    <a href="https://wa.me/6289502669582?text=Halo%20Admin" target="_blank" class="w-9 h-9 flex items-center justify-center bg-green-500 text-white rounded-xl hover:bg-green-600 transition-all shadow-md shadow-green-100">
                                        <i class="fa-brands fa-whatsapp text-sm"></i>
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @empty
                        {{-- Empty state desktop diatur di bawah --}}
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- 📱 TAMPILAN KARTU (Hanya muncul di HP - Layar di bawah MD) --}}
        <div class="md:hidden divide-y divide-slate-100">
            @forelse($bookings as $booking)
                <div class="p-5 space-y-4">
                    <div class="flex justify-between items-start">
                        <div class="max-w-[70%]">
                            <p class="text-[9px] font-black text-slate-400 uppercase tracking-widest mb-1">ID: #BOK-{{ $booking->id }}</p>
                            <h4 class="text-sm font-extrabold text-slate-800 leading-tight uppercase">{{ $booking->services ?? 'Layanan Custom' }}</h4>
                        </div>
                        <div class="shrink-0">
                            @php $status = strtolower($booking->status ?? 'pending'); @endphp
                            @if ($status == 'pending')
                                <span class="status-pulse px-2.5 py-1 rounded-full text-[8px] font-black bg-orange-50 text-orange-600 border border-orange-100">PENDING</span>
                            @elseif($status == 'proses')
                                <span class="px-2.5 py-1 rounded-full text-[8px] font-black bg-blue-50 text-blue-600 border border-blue-100">PROSES</span>
                            @elseif($status == 'selesai')
                                <span class="px-2.5 py-1 rounded-full text-[8px] font-black bg-green-50 text-green-600 border border-green-100">SELESAI</span>
                            @else
                                <span class="px-2.5 py-1 rounded-full text-[8px] font-black bg-red-50 text-red-600 border border-red-100">BATAL</span>
                            @endif
                        </div>
                    </div>

                    <div class="grid grid-cols-2 gap-4 bg-slate-50 p-4 rounded-2xl border border-slate-100">
                        <div>
                            <p class="text-[8px] font-black text-slate-400 uppercase mb-1">Jadwal Pelaksanaan</p>
                            <p class="text-[11px] font-bold text-slate-700 leading-none">{{ \Carbon\Carbon::parse($booking->date)->format('d M Y') }}</p>
                            <p class="text-[9px] text-slate-500 font-medium mt-1">{{ $booking->time }} WIB</p>
                        </div>
                        <div class="text-right">
                            <p class="text-[8px] font-black text-slate-400 uppercase mb-1">Estimasi Biaya</p>
                            <p class="text-[13px] font-black text-slate-900 leading-none">Rp{{ number_format((float) ($booking->total_price ?? 0), 0, ',', '.') }}</p>
                        </div>
                    </div>

                    <div class="flex gap-2 pt-1">
                        <a href="{{ route('chat.index') }}" class="flex-1 bg-slate-900 text-white text-center py-3 rounded-xl text-[10px] font-black uppercase tracking-widest flex items-center justify-center gap-2 active:scale-95 transition-transform shadow-sm">
                            <i class="fa-solid fa-message"></i> Chat Admin
                        </a>
                        <a href="https://wa.me/6289502669582" target="_blank" class="flex-1 bg-green-500 text-white text-center py-3 rounded-xl text-[10px] font-black uppercase tracking-widest flex items-center justify-center gap-2 active:scale-95 transition-transform shadow-sm shadow-green-100">
                            <i class="fa-brands fa-whatsapp"></i> WhatsApp
                        </a>
                    </div>
                </div>
            @empty
                {{-- Empty state mobile diatur di bawah --}}
            @endforelse
        </div>

        {{-- EMPTY STATE (Global) --}}
        @if($bookings->isEmpty())
            <div class="px-6 py-20 text-center flex flex-col items-center">
                <div class="w-20 h-20 bg-slate-50 rounded-[30px] flex items-center justify-center mb-6 text-slate-200">
                    <i class="fa-solid fa-folder-open text-3xl"></i>
                </div>
                <h4 class="text-sm font-bold text-slate-400 uppercase tracking-widest">Belum ada riwayat pesanan</h4>
                <a href="{{ route('booking.index') }}" class="mt-6 px-8 py-3.5 bg-orange-600 text-white text-[10px] font-black uppercase tracking-[0.2em] rounded-2xl shadow-xl shadow-orange-200 hover:bg-orange-700 transition-all active:scale-95">Mulai Booking</a>
            </div>
        @endif
    </div>
@endsection

@section('scripts')
    <script>
        function bookingApp() {
            return {
                sidebarOpen: true,
            }
        }
    </script>
@endsection
