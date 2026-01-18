@extends('layouts.booking')

@section('title', 'Booking Layanan - PT RIZQALLAH')
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="icon" type="image/png" href="{{ asset('assets/img/image.png') }}?v=1.0">
    <link rel="shortcut icon" type="image/png" href="{{ asset('assets/img/image.png') }}?v=1.0">

    <title>@yield('title', 'PT RIZQALLAH BOER MAKMUR')</title>

</head>
@section('header_title', 'Pilih Layanan')
@section('header_subtitle', 'Cari dan pilih produk atau jasa yang Anda butuhkan')

@section('styles')
<style>
    [x-cloak] { display: none !important; }

    /* Custom Scrollbar */
    .custom-scroll::-webkit-scrollbar { width: 6px; }
    .custom-scroll::-webkit-scrollbar-track { background: #f1f1f1; }
    .custom-scroll::-webkit-scrollbar-thumb { background: #f97316; border-radius: 10px; }

    /* Checkbox Card Animation */
    .card-content {
        transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        border: 2px solid #f1f5f9;
        background: white;
    }

    input:checked + .card-content {
        border-color: #f97316;
        background-color: #fffaf8;
        transform: translateY(-5px);
        box-shadow: 0 15px 30px -5px rgba(249, 115, 22, 0.15);
    }

    .check-container {
        position: absolute; top: 12px; right: 12px; width: 24px; height: 24px;
        border-radius: 50%; border: 2px solid #E2E8F0; background: white;
        display: flex; align-items: center; justify-content: center; z-index: 10;
        transition: all 0.3s ease;
    }

    input:checked + .card-content .check-container {
        background: #22C55E; border-color: #22C55E; transform: scale(1.1);
    }

    .floating-bar {
        box-shadow: 0 -10px 40px rgba(0, 0, 0, 0.2);
    }

    /* Fix for mobile modal */
    @media (max-width: 640px) {
        .booking-modal {
            border-bottom-left-radius: 0 !important;
            border-bottom-right-radius: 0 !important;
        }
    }
</style>
@endsection

@section('content')
<div x-data="bookingApp()" x-cloak class="pb-40">

    {{-- FILTER & SEARCH BAR --}}
    <div class="sticky top-0 md:top-16 z-30 bg-[#F8FAFC]/90 backdrop-blur-md py-4 mb-6 md:mb-10">
        <div class="flex flex-col md:flex-row gap-4 justify-between items-center">
            {{-- Category Switcher --}}
            <div class="bg-white p-1 md:p-1.5 rounded-2xl shadow-sm border flex w-full md:w-auto overflow-hidden">
                <button @click="filter='all'" :class="filter==='all'?'bg-orange-600 text-white shadow-md':'text-slate-500 hover:bg-slate-50'"
                    class="flex-1 md:flex-none px-4 md:px-8 py-2.5 text-[10px] md:text-xs font-black uppercase tracking-widest rounded-xl transition-all">Semua</button>
                <button @click="filter='barang'" :class="filter==='barang'?'bg-orange-600 text-white shadow-md':'text-slate-500 hover:bg-slate-50'"
                    class="flex-1 md:flex-none px-4 md:px-8 py-2.5 text-[10px] md:text-xs font-black uppercase tracking-widest rounded-xl transition-all">Barang</button>
                <button @click="filter='jasa'" :class="filter==='jasa'?'bg-orange-600 text-white shadow-md':'text-slate-500 hover:bg-slate-50'"
                    class="flex-1 md:flex-none px-4 md:px-8 py-2.5 text-[10px] md:text-xs font-black uppercase tracking-widest rounded-xl transition-all">Jasa</button>
            </div>

            {{-- Search --}}
            <div class="relative w-full md:w-80">
                <i class="fa-solid fa-magnifying-glass absolute left-5 top-1/2 -translate-y-1/2 text-slate-400"></i>
                <input type="text" x-model="search" placeholder="Cari layanan PT RBM..."
                    class="w-full pl-12 pr-5 py-3.5 rounded-2xl border-none shadow-sm focus:ring-2 focus:ring-orange-500 transition-all text-sm font-medium">
            </div>
        </div>
    </div>

    {{-- GRID PRODUK --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-5 md:gap-8">
        @php $allItems = collect($products)->merge($services); @endphp

        @foreach ($allItems as $item)
        <label x-show="shouldShow('{{ strtolower($item->type) }}', '{{ strtolower($item->name) }}')"
               x-transition.fade
               class="relative group cursor-pointer block h-full">

            <input type="checkbox" class="hidden"
                value="{{ $item->name }}"
                data-price="{{ $item->price }}"
                @change="updateSelection($event)"
                :checked="selectedItems.includes('{{ $item->name }}')">

            <div class="card-content h-full rounded-[30px] overflow-hidden flex flex-col relative">
                <div class="check-container">
                    <i class="fa-solid fa-check text-[10px] text-white" x-show="selectedItems.includes('{{ $item->name }}')"></i>
                </div>

                {{-- IMAGE SECTION --}}
                <div class="h-48 md:h-56 bg-slate-100 overflow-hidden relative">
                    @php
                        $url = null;
                        if ($item->image) {
                            if (str_starts_with($item->image, 'http')) {
                                $url = $item->image;
                            } else {
                                $finalPath = str_contains($item->image, 'assets/') ? $item->image : 'storage/'.$item->image;
                                $url = asset($finalPath);
                            }
                        }
                    @endphp

                    @if($url)
                        <img src="{{ $url }}"
                             class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110"
                             alt="{{ $item->name }}"
                             onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
                    @endif

                    <div class="placeholder-box h-full w-full flex flex-col items-center justify-center bg-slate-900 text-white"
                         style="{{ $url ? 'display:none;' : 'display:flex;' }}">
                        <i class="fa-solid fa-tower-broadcast text-4xl mb-2 text-orange-500 opacity-80"></i>
                        <span class="text-[8px] font-black uppercase tracking-[0.2em] text-slate-400">RBM Portal</span>
                    </div>

                    <div class="absolute bottom-3 left-3">
                        <span class="px-2.5 py-1 bg-black/60 backdrop-blur-md text-white text-[8px] font-black uppercase rounded-lg">
                            {{ $item->type }}
                        </span>
                    </div>
                </div>

                <div class="p-6 flex-grow flex flex-col">
                    <h3 class="font-bold text-slate-800 text-base md:text-lg leading-tight mb-2 group-hover:text-orange-600 transition-colors uppercase tracking-tight">
                        {{ $item->name }}
                    </h3>
                    <p class="text-xs text-slate-500 leading-relaxed mb-4 flex-grow">
                        {{ Str::limit($item->description, 80) }}
                    </p>
                    <div class="mt-auto pt-4 border-t border-slate-50 flex items-center justify-between">
                        <div>
                            <p class="text-[8px] font-black text-slate-400 uppercase tracking-widest mb-0.5">Estimasi Biaya</p>
                            <div class="text-lg font-black text-slate-900 tracking-tight">
                                Rp{{ number_format($item->price, 0, ',', '.') }}
                            </div>
                        </div>
                        <div class="w-9 h-9 rounded-xl bg-slate-50 flex items-center justify-center text-slate-300 group-hover:bg-orange-600 group-hover:text-white transition-all shadow-sm">
                            <i class="fa-solid fa-plus text-xs"></i>
                        </div>
                    </div>
                </div>
            </div>
        </label>
        @endforeach
    </div>

    {{-- EMPTY STATE --}}
    <div x-show="isEmpty()" class="py-20 text-center">
        <i class="fa-solid fa-search text-6xl text-slate-200 mb-4"></i>
        <p class="text-slate-400 font-bold uppercase tracking-widest text-sm">Layanan tidak ditemukan</p>
    </div>

    {{-- STEP 2: MODAL PENJADWALAN --}}
    <div x-show="step === 2"
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         class="fixed inset-0 z-[70] flex items-end sm:items-center justify-center px-0 sm:px-4">

        <div @click="step = 1" class="absolute inset-0 bg-slate-900/80 backdrop-blur-sm"></div>

        <div class="booking-modal relative bg-white w-full max-w-lg rounded-t-[35px] sm:rounded-[40px] shadow-2xl overflow-hidden animate-in slide-in-from-bottom duration-500">
            <div class="p-6 md:p-8 border-b border-slate-50 flex justify-between items-center bg-slate-50/50">
                <h2 class="text-xl md:text-2xl font-black text-slate-900 uppercase">Atur Jadwal</h2>
                <button @click="step = 1" class="w-10 h-10 bg-white rounded-xl shadow-sm flex items-center justify-center text-slate-400">
                    <i class="fa-solid fa-xmark"></i>
                </button>
            </div>

            <div class="p-6 md:p-8 space-y-6 md:space-y-8 max-h-[70vh] overflow-y-auto no-scrollbar">
                <div>
                    <label class="block text-[10px] font-black uppercase tracking-widest text-slate-400 mb-3">Pilih Tanggal</label>
                    <input type="date" x-model="bookingDate" min="{{ date('Y-m-d') }}"
                        class="w-full p-4 rounded-2xl border-2 border-slate-100 focus:border-orange-500 focus:ring-0 font-bold bg-slate-50 outline-none transition-all">
                </div>
                <div>
                    <label class="block text-[10px] font-black uppercase tracking-widest text-slate-400 mb-3">Pilih Jam</label>
                    <div class="grid grid-cols-3 gap-2 md:gap-3">
                        <template x-for="time in timeSlots" :key="time">
                            <button @click="bookingTime=time"
                                :class="bookingTime===time?'bg-orange-600 text-white shadow-lg border-orange-600':'bg-white border-slate-100 text-slate-600 hover:border-orange-200'"
                                class="p-3 md:p-4 rounded-xl text-[11px] font-black border-2 transition-all" x-text="time"></button>
                        </template>
                    </div>
                </div>
            </div>

            <div class="p-6 md:p-8 bg-slate-50 flex gap-3 md:gap-4">
                <button @click="step = 1" class="flex-1 py-4 font-bold text-slate-400 hover:text-slate-600 uppercase text-xs">Batal</button>
                <button @click="submitBooking()" :disabled="loading || !bookingDate || !bookingTime"
                    class="flex-[2] py-4 bg-orange-600 text-white rounded-2xl font-black shadow-xl disabled:opacity-50 flex items-center justify-center gap-3 transition-all hover:bg-orange-700 uppercase text-xs tracking-widest">
                    <span x-show="!loading">Konfirmasi</span>
                    <i x-show="loading" class="fa-solid fa-circle-notch animate-spin"></i>
                </button>
            </div>
        </div>
    </div>

    {{-- FLOATING BAR --}}
    <div class="fixed bottom-4 sm:bottom-8 left-1/2 -translate-x-1/2 w-[95%] max-w-5xl z-50 transition-all duration-500"
         :class="selectedItems.length > 0 ? 'translate-y-0 opacity-100' : 'translate-y-40 opacity-0 pointer-events-none'">
        <div class="floating-bar bg-slate-900 rounded-[30px] p-4 md:p-6 flex flex-row items-center justify-between gap-4 border border-white/10 backdrop-blur-xl">
            <div class="flex items-center gap-3 md:gap-5">
                <div class="w-10 h-10 md:w-14 md:h-14 bg-orange-600 rounded-xl md:rounded-2xl flex items-center justify-center text-white shadow-lg shrink-0">
                    <i class="fa-solid fa-cart-shopping text-sm md:text-xl"></i>
                </div>
                <div class="min-w-0">
                    <p class="text-slate-400 text-[8px] md:text-[10px] font-black uppercase tracking-widest mb-0.5"><span x-text="selectedItems.length"></span> Item Terpilih</p>
                    <h3 class="text-base md:text-3xl font-black text-white leading-none truncate" x-text="formatRupiah(totalPrice)"></h3>
                </div>
            </div>
            <div class="flex gap-2 shrink-0">
                <button @click="clearSelection()" class="hidden md:block px-6 py-3 text-slate-400 hover:text-red-400 text-xs font-black uppercase transition-colors">Reset</button>
                <button @click="step = 2"
                    class="px-6 md:px-12 py-3.5 md:py-5 bg-orange-600 hover:bg-orange-500 text-white rounded-xl md:rounded-[22px] font-black shadow-2xl transition-all flex items-center justify-center gap-2 text-[10px] md:text-xs uppercase tracking-widest">
                    Pesan <i class="fa-solid fa-arrow-right text-[10px]"></i>
                </button>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
function bookingApp() {
    return {
        step: 1,
        filter: 'all',
        search: '',
        selectedItems: [],
        totalPrice: 0,
        bookingDate: '',
        bookingTime: '',
        loading: false,
        timeSlots: ['09:00','10:00','11:00','13:00','14:00','15:00','16:00'],

        updateSelection(e) {
            const price = parseInt(e.target.dataset.price);
            const itemName = e.target.value;
            if (e.target.checked) {
                this.selectedItems.push(itemName);
                this.totalPrice += price;
            } else {
                this.selectedItems = this.selectedItems.filter(i => i !== itemName);
                this.totalPrice -= price;
            }
        },

        clearSelection() {
            this.selectedItems = [];
            this.totalPrice = 0;
            document.querySelectorAll('input[type="checkbox"]').forEach(el => el.checked = false);
        },

        shouldShow(type, name) {
            const matchFilter = this.filter === 'all' || type === this.filter;
            const matchSearch = name.includes(this.search.toLowerCase());
            return matchFilter && matchSearch;
        },

        isEmpty() {
            if (this.search === '') return false;
            let visible = false;
            document.querySelectorAll('label[x-show]').forEach(el => {
                if (window.getComputedStyle(el).display !== 'none') visible = true;
            });
            return !visible;
        },

        formatRupiah(n) {
            return new Intl.NumberFormat('id-ID', {
                style: 'currency', currency: 'IDR', minimumFractionDigits: 0
            }).format(n);
        },

        async submitBooking() {
            if(!this.bookingDate || !this.bookingTime) {
                alert("Pilih tanggal dan jam!"); return;
            }

            this.loading = true;
            try {
                const response = await fetch("{{ route('booking.riwayat.store') }}", {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json",
                        "X-CSRF-TOKEN": "{{ csrf_token() }}",
                        "Accept": "application/json"
                    },
                    body: JSON.stringify({
                        services: this.selectedItems.join(', '),
                        total_price: this.totalPrice,
                        date: this.bookingDate,
                        time: this.bookingTime,
                        status: 'pending'
                    })
                });

                if(response.ok) {
                    window.location.href = "{{ route('booking.riwayat') }}";
                } else {
                    const result = await response.json();
                    alert(result.message || "Gagal menyimpan.");
                }
            } catch (error) {
                alert("Kesalahan sistem!");
            } finally {
                this.loading = false;
            }
        }
    }
}
</script>
@endsection
