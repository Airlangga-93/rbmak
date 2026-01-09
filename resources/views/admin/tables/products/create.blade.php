@extends('admin.layouts.app')

@section('title', 'Tambah Produk')

@section('content')

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
        padding: 0.75rem 1.5rem;
        transition: all 200ms ease-in-out;
        font-size: 1rem;
        font-weight: 500;
        cursor: pointer;
        border-bottom: 3px solid transparent;
    }
    .active-tab-style {
        border-bottom: 3px solid var(--accent-tower);
        color: var(--dark-tower) !important;
        font-weight: 600;
        background-color: rgba(255, 140, 0, 0.05);
    }
</style>

<div class="container mx-auto p-4 sm:p-6">
    <div class="bg-white rounded-xl shadow-soft p-6 md:p-8">

        <h4 class="text-3xl font-bold mb-8 text-dark-tower border-b pb-4 border-gray-100">
            <i class="fas fa-cubes me-2 text-accent-tower"></i> Tambah Produk Baru
        </h4>

        {{-- Pesan error validasi --}}
        @if ($errors->any())
            <div class="bg-red-100 border-l-4 border-red-500 text-red-700 px-4 py-3 rounded-lg relative mb-6 shadow-md">
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

            {{-- 1. Tombol Tab --}}
            <div class="border-b border-gray-200 mb-6">
                <nav class="-mb-px flex space-x-4">
                    {{-- Input type ini yang menentukan logic di controller --}}
                    <input type="hidden" name="type" id="product-type-input" value="{{ old('type', 'barang') }}">

                    <button type="button" id="btn-barang" data-tab-target="barang" class="tab-button text-gray-500">
                        <i class="fas fa-box me-2"></i> Produk Barang
                    </button>
                    <button type="button" id="btn-jasa" data-tab-target="jasa" class="tab-button text-gray-500">
                        <i class="fas fa-briefcase me-2"></i> Produk Jasa
                    </button>
                </nav>
            </div>

            {{-- 2. Konten Tab: Barang --}}
            <div id="tab-barang" class="tab-content space-y-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-dark-tower mb-1">Nama Produk Barang <span class="text-red-500">*</span></label>
                        <input type="text" name="name_barang" id="name_barang" class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-accent-tower outline-none" 
                               value="{{ old('type') == 'barang' ? old('name') : old('name_barang') }}">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-dark-tower mb-1">Harga (Rp) <span class="text-red-500">*</span></label>
                        <input type="number" name="price_barang" id="price_barang" class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-accent-tower outline-none"
                               value="{{ old('type') == 'barang' ? old('price') : old('price_barang') }}">
                    </div>
                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-dark-tower mb-1">Deskripsi <span class="text-red-500">*</span></label>
                        <textarea name="description_barang" id="description_barang" rows="3" class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-accent-tower outline-none">{{ old('type') == 'barang' ? old('description') : old('description_barang') }}</textarea>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-dark-tower mb-1">Gambar Produk Barang <span class="text-red-500">*</span></label>
                        <input type="file" name="image_barang" id="image_barang" accept="image/*" class="w-full border p-2 rounded-lg text-sm">
                        <p class="text-xs text-gray-500 mt-1">Format: JPG, PNG. Maks: 4MB. Foto akan disimpan ke folder: <strong>storage/app/public/produk</strong></p>
                    </div>
                </div>
            </div>

            {{-- 3. Konten Tab: Jasa --}}
            <div id="tab-jasa" class="tab-content space-y-6" style="display: none;">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-dark-tower mb-1">Nama Layanan Jasa <span class="text-red-500">*</span></label>
                        <input type="text" name="name_jasa" id="name_jasa" class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-accent-tower outline-none"
                               value="{{ old('type') == 'jasa' ? old('name') : old('name_jasa') }}">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-dark-tower mb-1">Harga Estimasi (Rp) <span class="text-red-500">*</span></label>
                        <input type="number" name="price_jasa" id="price_jasa" class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-accent-tower outline-none"
                               value="{{ old('type') == 'jasa' ? old('price') : old('price_jasa') }}">
                    </div>
                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-dark-tower mb-1">Deskripsi Layanan <span class="text-red-500">*</span></label>
                        <textarea name="description_jasa" id="description_jasa" rows="3" class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-accent-tower outline-none">{{ old('type') == 'jasa' ? old('description') : old('description_jasa') }}</textarea>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-dark-tower mb-1">Gambar Layanan (Opsional)</label>
                        <input type="file" name="image_jasa" id="image_jasa" accept="image/*" class="w-full border p-2 rounded-lg text-sm">
                        <p class="text-xs text-gray-500 mt-1">Jika kosong, akan menggunakan gambar default jasa.</p>
                    </div>
                </div>
            </div>

            {{-- Tombol Aksi --}}
            <div class="mt-10 flex items-center space-x-3 pt-6 border-t">
                <button type="submit" class="bg-dark-tower text-white px-8 py-3 rounded-xl font-bold hover:bg-opacity-90 transition shadow-md">
                    <i class="fas fa-save me-2"></i> Simpan ke Database
                </button>
                <a href="{{ route('admin.products.index') }}" class="bg-gray-200 text-gray-700 px-8 py-3 rounded-xl font-bold hover:bg-gray-300 transition">
                    Batal
                </a>
            </div>
        </form>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const form = document.getElementById('product-form');
        const productTypeInput = document.getElementById('product-type-input');

        // Mapping dari name dummy ke name asli yang diharapkan Controller
        const nameMapping = {
            'name_barang': 'name', 'price_barang': 'price', 'description_barang': 'description', 'image_barang': 'image',
            'name_jasa': 'name', 'price_jasa': 'price', 'description_jasa': 'description', 'image_jasa': 'image'
        };

        function activateTab(targetType) {
            // 1. Toggle Tampilan Konten
            document.getElementById('tab-barang').style.display = targetType === 'barang' ? 'block' : 'none';
            document.getElementById('tab-jasa').style.display = targetType === 'jasa' ? 'block' : 'none';

            // 2. Toggle Atribut Input agar hanya yang aktif yang dikirim
            document.querySelectorAll('.tab-content').forEach(content => {
                const contentType = content.id.replace('tab-', '');
                const isActive = contentType === targetType;

                content.querySelectorAll('input, textarea').forEach(input => {
                    if (isActive) {
                        input.removeAttribute('disabled');
                        // Image jasa opsional, lainnya wajib
                        if (input.id !== 'image_jasa') {
                            input.setAttribute('required', 'required');
                        }
                    } else {
                        input.setAttribute('disabled', 'disabled');
                        input.removeAttribute('required');
                    }
                });
            });

            // 3. Update Style Tombol Tab
            document.querySelectorAll('.tab-button').forEach(btn => {
                btn.classList.remove('active-tab-style');
                if (btn.getAttribute('data-tab-target') === targetType) {
                    btn.classList.add('active-tab-style');
                }
            });

            // 4. Update Hidden Input Type
            productTypeInput.value = targetType;
        }

        // Event Listener Tombol
        document.getElementById('btn-barang').addEventListener('click', () => activateTab('barang'));
        document.getElementById('btn-jasa').addEventListener('click', () => activateTab('jasa'));

        // Inisialisasi awal (berguna jika ada error validasi kembali ke halaman ini)
        activateTab(productTypeInput.value);

        // Sebelum Submit: Ubah nama input dummy menjadi 'name', 'price', dll sesuai mapping
        form.addEventListener('submit', function() {
            const activeType = productTypeInput.value;
            const activeContent = document.getElementById(`tab-${activeType}`);

            activeContent.querySelectorAll('input, textarea').forEach(input => {
                const dummyName = input.getAttribute('name');
                if (nameMapping[dummyName]) {
                    input.setAttribute('name', nameMapping[dummyName]);
                }
            });
        });
    });
</script>

@endsection