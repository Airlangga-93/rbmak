@extends('admin.layouts.app')

@section('title', 'Tambah Produk')

@section('content')

{{-- Tambahkan Style yang Diperlukan di View ini --}}
<style>
    /* 🎨 Styling Kustom Tailwind (Tower Theme) */
    :root {
        --dark-tower: #2C3E50;
        --accent-tower: #FF8C00;
    }

    .text-dark-tower { color: var(--dark-tower); }
    .bg-dark-tower { background-color: var(--dark-tower); }
    .text-accent-tower { color: var(--accent-tower); }
    .focus\:ring-accent-tower:focus { --tw-ring-color: var(--accent-tower); }
    .shadow-soft { box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08); }

    .tab-button {
        /* Menggunakan @apply untuk menggabungkan kelas Tailwind */
        padding-top: 0.75rem; /* py-3 */
        padding-bottom: 0.75rem; /* py-3 */
        padding-left: 1rem; /* px-4 */
        padding-right: 1rem; /* px-4 */
        transition: all 200ms ease-in-out;
        font-size: 1rem; /* text-base */
        font-weight: 500; /* font-medium */
        cursor: pointer;
    }
    .active-tab-style {
        border-bottom: 3px solid var(--accent-tower);
        color: var(--dark-tower) !important;
        font-weight: 600;
    }
    .form-input-style:focus {
        border-color: var(--accent-tower);
    }
</style>

<div class="container mx-auto p-4 sm:p-6">
    <div class="bg-white rounded-xl shadow-soft p-6 md:p-8">

        <h4 class="text-3xl font-bold mb-8 text-dark-tower border-b pb-4 border-gray-100">
            <i class="fas fa-cubes me-2 text-accent-tower"></i> Tambah Produk Baru
        </h4>

        {{-- Pesan error validasi dari Laravel --}}
        @if ($errors->any())
            <div class="bg-red-100 border-l-4 border-red-500 text-red-700 px-4 py-3 rounded-lg relative mb-6 shadow-md" role="alert">
                <p class="font-bold">Terjadi kesalahan validasi!</p>
                <ul class="mt-2 text-sm list-disc list-inside">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data" id="product-form">
            @csrf

            {{-- 1. Tombol Tab Pilihan Produk --}}
            <div class="border-b border-gray-200 mb-6">
                <nav class="-mb-px flex space-x-8" aria-label="Tabs">
                    {{-- Hidden input untuk menyimpan tipe produk yang dipilih. Nilai default: 'barang' --}}
                    {{-- Kita perlu 'old('type')' di sini untuk menentukan tab mana yang aktif setelah error --}}
                    <input type="hidden" name="type" id="product-type-input" value="{{ old('type', 'barang') }}">

                    <button type="button" id="btn-barang" data-tab-target="barang"
                        class="tab-button text-gray-500 hover:text-dark-tower"
                        data-product-type="barang">
                        <i class="fas fa-box me-2"></i> Produk Barang
                    </button>
                    <button type="button" id="btn-jasa" data-tab-target="jasa"
                        class="tab-button text-gray-500 hover:text-dark-tower"
                        data-product-type="jasa">
                        <i class="fas fa-briefcase me-2"></i> Produk Jasa
                    </button>
                </nav>
            </div>

            {{-- 2. Konten Tab: Produk Barang --}}
            {{-- Tambahkan kelas 'hidden' untuk diatur oleh JS jika bukan tab awal --}}
            <div id="tab-barang" class="tab-content space-y-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                    {{-- Nama Produk Barang --}}
                    <div>
                        <label for="name_barang" class="block text-sm font-medium text-dark-tower mb-1">Nama Produk Barang <span class="text-red-500">*</span></label>
                        <input type="text" name="name_barang" id="name_barang"
                            class="form-input-style w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-accent-tower transition"

                            {{-- Tampilkan old('name') HANYA jika type-nya 'barang' atau jika belum ada old('type') sama sekali --}}
                            value="{{ old('type') == 'barang' || !old('type') ? old('name') : '' }}">
                    </div>

                    {{-- Harga Produk Barang --}}
                    <div>
                        <label for="price_barang" class="block text-sm font-medium text-dark-tower mb-1">Harga (Rp) Produk Barang <span class="text-red-500">*</span></label>
                        <input type="number" name="price_barang" id="price_barang"
                            class="form-input-style w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-accent-tower transition"
                           
                            {{-- LOGIKA OLD DATA --}}
                            value="{{ old('type') == 'barang' || !old('type') ? old('price') : '' }}">
                    </div>

                    {{-- Deskripsi Produk Barang --}}
                    <div class="md:col-span-2">
                        <label for="description_barang" class="block text-sm font-medium text-dark-tower mb-1">Deskripsi Produk Barang <span class="text-red-500">*</span></label>
                        <textarea name="description_barang" id="description_barang" rows="3"
                            class="form-input-style w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-accent-tower transition"
                            placeholder="Tuliskan deskripsi produk barang...">{{ old('type') == 'barang' || !old('type') ? old('description') : '' }}</textarea>
                    </div>

                    {{-- Gambar Produk Barang --}}
                    <div class="col-span-1">
                        <label for="image_barang" class="block text-sm font-medium text-dark-tower mb-1">Gambar Produk Barang <span class="text-red-500">*</span></label>
                        {{-- Catatan: old('image') tidak berfungsi untuk input type="file" --}}
                        <input type="file" name="image_barang" id="image_barang" accept="image/*"
                            class="w-full border border-gray-300 p-2 rounded-lg text-sm text-gray-700 focus:outline-none focus:ring-2 focus:ring-accent-tower transition">
                        <small class="text-xs text-gray-500 mt-1 block">Format: JPG, PNG. Ukuran maks: 4MB (Wajib diisi).</small>

                        {{-- Tampilkan notifikasi jika ada error validasi terkait gambar --}}
                        @if ($errors->has('image') && (old('type') == 'barang' || !old('type')))
                            <p class="text-red-500 text-xs mt-1">Harap unggah kembali gambar produk.</p>
                        @endif
                    </div>

                </div>
            </div>

            {{-- 3. Konten Tab: Produk Jasa --}}
            <div id="tab-jasa" class="tab-content space-y-6" style="display: none;">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                    {{-- Nama Produk Jasa --}}
                    <div>
                        <label for="name_jasa" class="block text-sm font-medium text-dark-tower mb-1">Nama Produk Jasa <span class="text-red-500">*</span></label>
                        <input type="text" name="name_jasa" id="name_jasa"
                            class="form-input-style w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-accent-tower transition"
                            placeholder="Contoh: Jasa Konsultasi Bisnis"
                            {{-- Tampilkan old('name') hanya jika type-nya 'jasa' --}}
                            value="{{ old('type') == 'jasa' ? old('name') : '' }}">
                    </div>

                    {{-- Harga Produk Jasa --}}
                    <div>
                        <label for="price_jasa" class="block text-sm font-medium text-dark-tower mb-1">Harga (Rp) Produk Jasa <span class="text-red-500">*</span></label>
                        <input type="number" name="price_jasa" id="price_jasa"
                            class="form-input-style w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-accent-tower transition"
                            placeholder="Contoh: 500000"
                            {{-- LOGIKA OLD DATA --}}
                            value="{{ old('type') == 'jasa' ? old('price') : '' }}">
                    </div>

                    {{-- Deskripsi Produk Jasa --}}
                    <div class="md:col-span-2">
                        <label for="description_jasa" class="block text-sm font-medium text-dark-tower mb-1">Deskripsi Produk Jasa <span class="text-red-500">*</span></label>
                        <textarea name="description_jasa" id="description_jasa" rows="3"
                            class="form-input-style w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-accent-tower transition"
                            placeholder="Tuliskan deskripsi produk jasa...">{{ old('type') == 'jasa' ? old('description') : '' }}</textarea>
                    </div>

                    {{-- Gambar Produk Jasa (Opsional) --}}
                    <div class="col-span-1">
                        <label for="image_jasa" class="block text-sm font-medium text-dark-tower mb-1">Gambar Produk Jasa (Opsional)</label>
                        <input type="file" name="image_jasa" id="image_jasa" accept="image/*"
                            class="w-full border border-gray-300 p-2 rounded-lg text-sm text-gray-700 focus:outline-none focus:ring-2 focus:ring-accent-tower transition">
                        <small class="text-xs text-gray-500 mt-1 block">Gambar representasi layanan (Opsional, maks: 4MB).</small>

                         {{-- Tampilkan notifikasi jika ada error validasi terkait gambar --}}
                        @if ($errors->has('image') && old('type') == 'jasa')
                            <p class="text-red-500 text-xs mt-1">Harap unggah kembali gambar produk.</p>
                        @endif
                    </div>

                </div>
            </div>

            {{-- Tombol Aksi --}}
            <div class="mt-10 flex items-center space-x-3 pt-6 border-t border-gray-100">
                <button type="submit"
                        class="bg-dark-tower text-white px-6 py-2.5 rounded-xl font-semibold hover:bg-gray-700 transition-colors duration-200 shadow-md flex items-center space-x-2 text-sm">
                    <i class="fas fa-save me-1"></i> <span>Simpan Produk</span>
                </button>
                <a href="{{ route('admin.products.index') }}"
                   class="bg-gray-200 text-dark-tower px-6 py-2.5 rounded-xl font-semibold hover:bg-gray-300 transition-colors duration-200 shadow-sm text-sm">
                    Kembali
                </a>
            </div>
        </form>

        {{-- SCRIPT INLINE (Logika untuk Tab Switching dan Name Mapping) --}}
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                const form = document.getElementById('product-form');
                const productTypeInput = document.getElementById('product-type-input');

                // Peta Nama Input: Nama input di Blade (kiri) ke nama input yang diharapkan Controller (kanan)
                const nameMapping = {
                    'name_barang': 'name', 'price_barang': 'price', 'description_barang': 'description', 'image_barang': 'image',
                    'name_jasa': 'name', 'price_jasa': 'price', 'description_jasa': 'description', 'image_jasa': 'image'
                };

                function activateTab(targetType) {
                    // 1. Tampilkan/Sembunyikan Konten
                    document.getElementById('tab-barang').style.display = targetType === 'barang' ? 'block' : 'none';
                    document.getElementById('tab-jasa').style.display = targetType === 'jasa' ? 'block' : 'none';

                    // 2. Mengatur Required Field
                    document.querySelectorAll('.tab-content').forEach(content => {
                        const contentType = content.id.replace('tab-', '');
                        const isActive = contentType === targetType;

                        content.querySelectorAll('input, textarea').forEach(input => {
                            // Cek apakah input adalah bagian dari tab aktif
                            if (isActive) {
                                // Teks/Angka: Selalu wajib di tab aktif
                                if (input.type !== 'file') {
                                    input.setAttribute('required', 'required');
                                } else {
                                    // File Gambar: Barang wajib, Jasa opsional
                                    if (input.id === 'image_barang' && contentType === 'barang') {
                                        input.setAttribute('required', 'required');
                                    } else {
                                        input.removeAttribute('required');
                                    }
                                }
                            } else {
                                // Non-aktifkan required untuk input di tab tersembunyi
                                input.removeAttribute('required');
                            }
                        });
                    });

                    // 3. Atur Tampilan Tombol
                    document.querySelectorAll('.tab-button').forEach(button => {
                        button.classList.remove('active-tab-style');
                        button.classList.add('text-gray-500', 'hover:text-dark-tower');
                    });
                    const activeBtn = document.querySelector(`button[data-tab-target="${targetType}"]`);
                    if (activeBtn) {
                        activeBtn.classList.add('active-tab-style');
                        activeBtn.classList.remove('text-gray-500', 'hover:text-dark-tower');
                    }

                    productTypeInput.value = targetType;
                }

                // Event listener untuk tombol tab
                document.getElementById('btn-barang').addEventListener('click', function() { activateTab('barang'); });
                document.getElementById('btn-jasa').addEventListener('click', function() { activateTab('jasa'); });

                // Inisialisasi: Aktifkan tab saat pemuatan (penting untuk menangani old data saat validasi gagal)
                const initialType = productTypeInput.value;
                activateTab(initialType);

                // --- LOGIC UTAMA PENGIRIMAN FORM (Mengubah Nama Input) ---
                // Saat tombol submit diklik, kita ubah nama input yang aktif
                form.addEventListener('submit', function() {
                    const activeTabId = `tab-${productTypeInput.value}`;

                    document.querySelectorAll('.tab-content').forEach(content => {
                        const isActive = content.id === activeTabId;

                        content.querySelectorAll('input, textarea').forEach(input => {
                            // Ambil nama asli (name_barang atau name_jasa)
                            const originalName = input.getAttribute('name') || input.getAttribute('data-temp-name');

                            if (isActive) {
                                // 1. Tab Aktif: Ganti nama ke nama standar (name, price, description, image)
                                if (originalName && nameMapping[originalName]) {
                                    input.setAttribute('data-temp-name', originalName); // Simpan nama asli
                                    input.setAttribute('name', nameMapping[originalName]); // Ganti ke nama standar
                                    input.removeAttribute('disabled');
                                }
                            } else {
                                // 2. Tab Non-Aktif: Hapus atribut 'name' agar tidak ikut terkirim ke server
                                if (originalName) {
                                    input.setAttribute('data-temp-name', originalName); // Simpan nama asli
                                    input.removeAttribute('name');
                                    // Nonaktifkan field agar tidak diproses server meskipun tidak ada 'name' (Best Practice)
                                    input.setAttribute('disabled', 'disabled');
                                }
                            }
                        });
                    });
                });

                // (Opsional) Fungsi untuk mengembalikan nama input setelah AJAX/Page Load
                // Jika halaman dimuat ulang (setelah validasi gagal), atribut name yang sudah diubah
                // pada saat submit sebelumnya akan dikembalikan agar JS bisa bekerja lagi dengan benar.
                // Logika ini sudah ada di kode Anda sebelumnya, dan ini adalah implementasi yang bagus.
                window.addEventListener('load', function() {
                    document.querySelectorAll('[data-temp-name]').forEach(input => {
                        if (input.getAttribute('data-temp-name')) {
                            input.setAttribute('name', input.getAttribute('data-temp-name'));
                            input.removeAttribute('data-temp-name');
                            input.removeAttribute('disabled');
                        }
                    });
                });
            });
        </script>
    </div>
</div>

@endsection
