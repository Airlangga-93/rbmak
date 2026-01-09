@extends('admin.layouts.app')

@section('title', 'Tambah Mitra Industri')

@section('content')
<div class="p-6 font-['Poppins']">
    {{-- Header Card --}}
    <div class="mb-6 flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <h1 class="text-2xl font-bold text-slate-800">Tambah Customer</h1>
            <p class="text-sm text-slate-500">Tambahkan partner baru ke dalam jaringan ekosistem perusahaan.</p>
        </div>
        <a href="{{ route('admin.partners.index') }}"
            class="inline-flex items-center px-4 py-2 bg-white border border-slate-200 rounded-xl text-sm font-semibold text-slate-600 hover:bg-slate-50 transition-all shadow-sm">
            <i class="fas fa-arrow-left mr-2 text-xs"></i>
            Kembali ke Daftar
        </a>
    </div>

    {{-- Form Card --}}
    <div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden">
        {{-- Logika: Enctype wajib ada untuk upload file --}}
        <form action="{{ route('admin.partners.store') }}" method="POST" enctype="multipart/form-data" class="p-6 md:p-8" id="partnerForm">
            @csrf

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">

                {{-- Left Column: Basic Info --}}
                <div class="space-y-6">
                    <div>
                        <label for="name" class="block text-sm font-semibold text-slate-700 mb-2">Nama Perusahaan / Customer <span class="text-red-500">*</span></label>
                        <input type="text" name="name" id="name" required
                            class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:ring-2 focus:ring-[#FF8C00]/20 focus:border-[#FF8C00] outline-none transition-all @error('name') border-red-500 @enderror"
                            placeholder="Contoh: PT. Tower Bersama" value="{{ old('name') }}">
                        @error('name') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label for="sector" class="block text-sm font-semibold text-slate-700 mb-2">Sektor Industri <span class="text-red-500">*</span></label>
                        <select name="sector" id="sector" required
                            class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:ring-2 focus:ring-[#FF8C00]/20 focus:border-[#FF8C00] outline-none transition-all appearance-none @error('sector') border-red-500 @enderror">
                            <option value="" disabled {{ !old('sector') ? 'selected' : '' }}>-- Pilih Kategori --</option>
                            <option value="TOWER PROVIDER" {{ old('sector') == 'TOWER PROVIDER' ? 'selected' : '' }}>TOWER PROVIDER</option>
                            <option value="NON TOWER PROVIDER" {{ old('sector') == 'NON TOWER PROVIDER' ? 'selected' : '' }}>NON TOWER PROVIDER</option>
                        </select>
                        @error('sector') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label for="city" class="block text-sm font-semibold text-slate-700 mb-2">Kota / Lokasi <span class="text-red-500">*</span></label>
                            <input type="text" name="city" id="city" required
                                class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:ring-2 focus:ring-[#FF8C00]/20 focus:border-[#FF8C00] outline-none transition-all @error('city') border-red-500 @enderror"
                                placeholder="Jakarta, Bogor, dll" value="{{ old('city') }}">
                            @error('city') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>
                        <div>
                            <label for="partnership_date" class="block text-sm font-semibold text-slate-700 mb-2">Tanggal Kerja Sama <span class="text-red-500">*</span></label>
                            <input type="date" name="partnership_date" id="partnership_date" required
                                class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:ring-2 focus:ring-[#FF8C00]/20 focus:border-[#FF8C00] outline-none transition-all @error('partnership_date') border-red-500 @enderror"
                                value="{{ old('partnership_date') }}">
                            @error('partnership_date') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>
                    </div>

                    <div>
                        <label for="company_contact" class="block text-sm font-semibold text-slate-700 mb-2">Kontak / Website (Opsional)</label>
                        <input type="text" name="company_contact" id="company_contact"
                            class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:ring-2 focus:ring-[#FF8C00]/20 focus:border-[#FF8C00] outline-none transition-all"
                            placeholder="Email atau link website" value="{{ old('company_contact') }}">
                    </div>
                </div>

                {{-- Right Column: Media & Description --}}
                <div class="space-y-6">
                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-2 text-center lg:text-left">Logo Customer <span class="text-red-500">*</span></label>
                        <div class="relative group">
                            <div class="w-full h-48 border-2 border-dashed border-slate-200 rounded-2xl flex flex-col items-center justify-center bg-slate-50 group-hover:bg-slate-100 transition-all overflow-hidden relative @error('logo') border-red-300 @enderror">
                                <i class="fas fa-cloud-upload-alt text-3xl text-slate-300 mb-2 group-hover:text-[#FF8C00] transition-colors"></i>
                                <span class="text-xs text-slate-400 font-medium">Klik untuk upload logo (PNG/JPG/WEBP)</span>

                                {{-- Input File: Ditambahkan atribut accept untuk membatasi tipe file di browser --}}
                                <input type="file" name="logo" id="logo" onchange="previewImage(this)"
                                    class="absolute inset-0 opacity-0 cursor-pointer z-10" required
                                    accept="image/png, image/jpeg, image/jpg, image/svg+xml, image/webp">

                                <img id="imgPreview" class="absolute inset-0 w-full h-full object-contain p-4 bg-white hidden z-0">
                            </div>
                        </div>
                        <p class="text-[10px] text-slate-400 mt-1 italic text-center lg:text-left">Max size: 2MB. Format: PNG, JPG, SVG, WEBP.</p>
                        @error('logo') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label for="description" class="block text-sm font-semibold text-slate-700 mb-2">Deskripsi Singkat</label>
                        <textarea name="description" id="description" rows="5"
                            class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:ring-2 focus:ring-[#FF8C00]/20 focus:border-[#FF8C00] outline-none transition-all"
                            placeholder="Jelaskan peran mitra ini dalam pengerjaan proyek...">{{ old('description') }}</textarea>
                    </div>
                </div>
            </div>

            {{-- Form Actions --}}
            <div class="mt-10 pt-6 border-t border-slate-100 flex flex-col md:flex-row items-center justify-between gap-4">
                <div class="flex items-center text-slate-400 text-xs italic">
                    <i class="fas fa-info-circle mr-2"></i>
                    Pastikan logo customer memiliki background transparan untuk hasil terbaik.
                </div>
                <button type="submit" id="submitBtn"
                    class="w-full md:w-auto px-10 py-3.5 bg-[#FF8C00] text-white rounded-xl font-bold shadow-lg shadow-orange-500/30 hover:bg-[#e67e00] active:scale-95 transition-all flex items-center justify-center">
                    <i class="fas fa-plus-circle mr-2" id="btnIcon"></i>
                    <span id="btnText">Simpan Customer Baru</span>
                </button>
            </div>
        </form>
    </div>
</div>

{{-- Preview Image Script & Loading Handler --}}
<script>
    function previewImage(input) {
        const preview = document.getElementById('imgPreview');
        if (input.files && input.files[0]) {
            const file = input.files[0];

            // Validasi tipe file di sisi klien
            if (!file.type.match('image.*')) {
                alert("Harap pilih file gambar!");
                input.value = "";
                return;
            }

            const reader = new FileReader();
            reader.onload = function(e) {
                preview.src = e.target.result;
                preview.classList.remove('hidden');
            }
            reader.readAsDataURL(file);
        }
    }

    // Menangani Loading saat submit agar tidak double click
    const form = document.getElementById('partnerForm');
    const btn = document.getElementById('submitBtn');
    const btnText = document.getElementById('btnText');
    const btnIcon = document.getElementById('btnIcon');

    form.addEventListener('submit', function() {
        if(form.checkValidity()) {
            btn.classList.add('opacity-80', 'cursor-not-allowed');
            btnIcon.classList.add('fa-spinner', 'fa-spin');
            btnIcon.classList.remove('fa-plus-circle');
            btnText.textContent = 'Memproses...';
        }
    });
</script>

<style>
    /* Custom Select Styling */
    select {
        background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 20 20'%3e%3cpath stroke='%236b7280' stroke-linecap='round' stroke-linejoin='round' stroke-width='1.5' d='M6 8l4 4 4-4'/%3e%3c/svg%3e");
        background-position: right 1rem center;
        background-repeat: no-repeat;
        background-size: 1.5em 1.5em;
    }

    /* Animasi kelancaran preview */
    #imgPreview {
        transition: opacity 0.3s ease-in-out;
    }
</style>
@endsection
