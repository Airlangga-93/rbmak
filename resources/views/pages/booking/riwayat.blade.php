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
    </style>
@endsection

@section('content')
    {{-- STATS MINI --}}
    <div class="flex gap-4 mb-8">
        <div class="bg-white border border-slate-200 p-4 rounded-3xl flex items-center space-x-4 shadow-sm">
            <div class="w-12 h-12 bg-orange-50 text-orange-600 rounded-2xl flex items-center justify-center text-xl">
                <i class="fa-solid fa-box-archive"></i>
            </div>
            <div>
                <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">Total Booking</p>
                <h3 class="text-xl font-black text-slate-900">{{ $bookings->count() }}</h3>
            </div>
        </div>
    </div>

    {{-- TABLE RIWAYAT --}}
    <div class="bg-white border border-slate-200 rounded-[32px] overflow-hidden shadow-sm">
        <div class="overflow-x-auto">
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
                                    <span class="text-sm font-bold text-slate-800">
                                        {{ $booking->services ?? 'Layanan Custom' }}
                                    </span>
                                    <span class="text-[10px] font-bold text-slate-400 mt-1 uppercase tracking-tighter">
                                        ID: #BOK-{{ str_pad($booking->id, 5, '0', STR_PAD_LEFT) }}
                                    </span>
                                </div>
                            </td>
                            <td class="px-6 py-6">
                                <div class="flex flex-col">
                                    <div class="flex items-center text-xs font-bold text-slate-700">
                                        <i class="fa-regular fa-calendar-check mr-2 text-orange-500"></i>
                                        {{-- Penyesuaian ke Bahasa Indonesia & Format Tgl Indo --}}
                                        {{ \Carbon\Carbon::parse($booking->date)->locale('id')->settings(['formatFunction' => 'translatedFormat'])->format('d M Y') }}
                                    </div>
                                    <span class="text-[10px] text-slate-400 font-bold mt-1 ml-6">{{ $booking->time }} WIB</span>
                                </div>
                            </td>
                            <td class="px-6 py-6">
                                <span class="text-sm font-black text-slate-900">
                                    Rp{{ number_format((float) ($booking->total_price ?? 0), 0, ',', '.') }}
                                </span>
                            </td>
                            <td class="px-6 py-6">
                                @php $status = strtolower($booking->status ?? 'pending'); @endphp
                                @if ($status == 'pending')
                                    <span class="status-pulse inline-flex items-center px-3 py-1 rounded-full text-[9px] font-black bg-orange-50 text-orange-600 border border-orange-100">
                                        PENDING
                                    </span>
                                @elseif($status == 'proses')
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-[9px] font-black bg-blue-50 text-blue-600 border border-blue-100 uppercase">
                                        PROSES
                                    </span>
                                @elseif($status == 'selesai')
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-[9px] font-black bg-green-50 text-green-600 border border-green-100 uppercase">
                                        SELESAI
                                    </span>
                                @else
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-[9px] font-black bg-red-50 text-red-600 border border-red-100 uppercase">
                                        DIBATALKAN
                                    </span>
                                @endif
                            </td>
                            <td class="px-6 py-6 text-center">
                                <div class="flex items-center justify-center space-x-2">
                                    {{-- Chat Internal --}}
                                    <a href="{{ route('chat.index') }}"
                                       class="w-9 h-9 flex items-center justify-center bg-slate-900 text-white rounded-xl hover:bg-orange-600 transition-all shadow-md shadow-slate-200"
                                       title="Chat Admin">
                                        <i class="fa-solid fa-message text-xs"></i>
                                    </a>

                                    {{-- WhatsApp Shortcut --}}
                                    <a href="https://wa.me/6289502669582?text=Halo%20Admin,%20saya%20ingin%20tanya%20booking%20#BOK-{{ str_pad($booking->id, 5, '0', STR_PAD_LEFT) }}"
                                       target="_blank"
                                       class="w-9 h-9 flex items-center justify-center bg-green-500 text-white rounded-xl hover:bg-green-600 transition-all shadow-md shadow-green-100">
                                        <i class="fa-brands fa-whatsapp text-sm"></i>
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-24 text-center">
                                <div class="flex flex-col items-center">
                                    <div class="w-20 h-20 bg-slate-50 rounded-[30px] flex items-center justify-center mb-6 text-slate-200">
                                        <i class="fa-solid fa-folder-open text-3xl"></i>
                                    </div>
                                    <h4 class="text-sm font-bold text-slate-400">Belum ada riwayat pesanan</h4>
                                    <a href="{{ route('booking.index') }}" class="mt-6 px-6 py-3 bg-orange-600 text-white text-[10px] font-black uppercase tracking-widest rounded-2xl shadow-lg shadow-orange-200">Mulai Booking</a>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
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
