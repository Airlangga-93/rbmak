@extends('admin.layouts.app')

@section('title', 'Edit Mitra Industri: ' . $partner->name)

@section('content')
<div class="p-6 font-['Poppins']">
    {{-- Header Card --}}
    <div class="mb-6 flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <h1 class="text-2xl font-bold text-slate-800">Edit Our Customer</h1>
            <p class="text-sm text-slate-500">Perbarui informasi kemitraan untuk <strong>{{ $partner->name }}</strong>.</p>
        </div>
        <a href="{{ route('admin.partners.index') }}"
            class="inline-flex items-center px-4 py-2 bg-white border border-slate-200 rounded-xl text-sm font-semibold text-slate-600 hover:bg-slate-50 transition-all shadow-sm">
            <i class="fas fa-arrow-left mr-2 text-xs"></i>
            Kembali ke Daftar
        </a>
    </div>

    {{-- Form Card --}}
    <div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden">
        <form action="{{ route('admin.partners.update', $partner->id) }}" method="POST" enctype="multipart/form-data" class="p-6 md:p-8">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">

                {{-- Left Column: Basic Info --}}
                <div class="space-y-6">
                    <div>
                        <label for="name" class="block text-sm font-semibold text-slate-700 mb-2">Nama Perusahaan / Customer <span class="text-red-500">*</span></label>
                        <input type="text" name="name" id="name" required
                            class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:ring-2 focus:ring-[#FF8C00]/20 focus:border-[#FF8C00] outline-none transition-all @error('name') border-red-500 @enderror"
                            placeholder="Contoh: PT. Tower Bersama" value="{{ old('name', $partner->name) }}">
                        @error('name') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label for="sector" class="block text-sm font-semibold text-slate-700 mb-2">Sektor Industri <span class="text-red-500">*</span></label>
                        <select name="sector" id="sector" required
                            class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:ring-2 focus:ring-[#FF8C00]/20 focus:border-[#FF8C00] outline-none transition-all appearance-none @error('sector') border-red-500 @enderror">
                            @php $currentSector = old('sector', $partner->sector); @endphp
                            <option value="TOWER PROVIDER" {{ $currentSector == 'TOWER PROVIDER' || $currentSector == 'Tower Provider' ? 'selected' : '' }}>TOWER PROVIDER</option>
                            <option value="NON TOWER PROVIDER" {{ $currentSector == 'NON TOWER PROVIDER' || $currentSector == 'Non Tower Provider' ? 'selected' : '' }}>NON TOWER PROVIDER</option>
                        </select>
                        @error('sector') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label for="city" class="block text-sm font-semibold text-slate-700 mb-2">Kota / Lokasi <span class="text-red-500">*</span></label>
                            <input type="text" name="city" id="city" required
                                class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:ring-2 focus:ring-[#FF8C00]/20 focus:border-[#FF8C00] outline-none transition-all"
                                placeholder="Jakarta, Bogor, dll" value="{{ old('city', $partner->city) }}">
                        </div>
                        <div>
                            <label for="partnership_date" class="block text-sm font-semibold text-slate-700 mb-2">Tanggal Kerja Sama <span class="text-red-500">*</span></label>
                            <input type="date" name="partnership_date" id="partnership_date" required
                                class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:ring-2 focus:ring-[#FF8C00]/20 focus:border-[#FF8C00] outline-none transition-all"
                                value="{{ old('partnership_date', \Carbon\Carbon::parse($partner->partnership_date)->format('Y-m-d')) }}">
                        </div>
                    </div>

                    <div>
                        <label for="company_contact" class="block text-sm font-semibold text-slate-700 mb-2">Kontak / Website (Opsional)</label>
                        <input type="text" name="company_contact" id="company_contact"
                            class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:ring-2 focus:ring-[#FF8C00]/20 focus:border-[#FF8C00] outline-none transition-all"
                            placeholder="Email atau link website" value="{{ old('company_contact', $partner->company_contact) }}">
                    </div>
                </div>

                {{-- Right Column: Media & Description --}}
                <div class="space-y-6">
                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-2">Logo Customer</label>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            {{-- Logo Saat Ini --}}
                            <div class="p-4 border border-slate-100 rounded-2xl bg-slate-50 flex flex-col items-center">
                                <span class="text-[10px] uppercase font-bold text-slate-400 mb-2">Logo Saat Ini</span>
                                <div class="w-full h-32 flex items-center justify-center bg-white rounded-xl border border-slate-200 overflow-hidden p-2">
                                    <img src="{{ str_contains($partner->logo, 'assets/img') ? asset($partner->logo) : asset('storage/' . $partner->logo) }}"
                                         class="max-h-full object-contain">
                                </div>
                            </div>

                            {{-- Upload Baru --}}
                            <div class="relative group">
                                <span class="text-[10px] uppercase font-bold text-slate-400 mb-2 block text-center md:text-left">Ganti Logo</span>
                                <div class="w-full h-32 border-2 border-dashed border-slate-200 rounded-2xl flex flex-col items-center justify-center bg-slate-50 group-hover:bg-slate-100 transition-all overflow-hidden relative">
                                    <i class="fas fa-cloud-upload-alt text-2xl text-slate-300 mb-1 group-hover:text-[#FF8C00]"></i>
                                    <span class="text-[10px] text-slate-400 text-center px-2">Klik/Drop logo baru</span>
                                    <input type="file" name="logo" id="logo" onchange="previewImage(this)"
                                        class="absolute inset-0 opacity-0 cursor-pointer z-10">
                                    <img id="imgPreview" class="absolute inset-0 w-full h-full object-contain p-2 bg-white hidden z-0">
                                </div>
                            </div>
                        </div>
                        @error('logo') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label for="description" class="block text-sm font-semibold text-slate-700 mb-2">Deskripsi Singkat</label>
                        <textarea name="description" id="description" rows="5"
                            class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:ring-2 focus:ring-[#FF8C00]/20 focus:border-[#FF8C00] outline-none transition-all"
                            placeholder="Jelaskan peran mitra ini dalam pengerjaan proyek...">{{ old('description', $partner->description) }}</textarea>
                    </div>
                </div>
            </div>

            {{-- Form Actions --}}
            <div class="mt-10 pt-6 border-t border-slate-100 flex flex-col md:flex-row items-center justify-end gap-4">
                <p class="text-slate-400 text-xs italic mr-auto">
                    <i class="fas fa-info-circle mr-1"></i> Biarkan logo kosong jika tidak ingin mengubahnya.
                </p>
                <button type="submit"
                    class="w-full md:w-auto px-10 py-3.5 bg-[#FF8C00] text-white rounded-xl font-bold shadow-lg shadow-orange-500/30 hover:bg-[#e67e00] active:scale-95 transition-all flex items-center justify-center">
                    <i class="fas fa-save mr-2"></i>
                    Simpan Perubahan
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    function previewImage(input) {
        const preview = document.getElementById('imgPreview');
        if (input.files && input.files[0]) {
            const reader = new FileReader();
            reader.onload = function(e) {
                preview.src = e.target.result;
                preview.classList.remove('hidden');
            }
            reader.readAsDataURL(input.files[0]);
        }
    }
</script>

<style>
    select {
        background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 20 20'%3e%3cpath stroke='%236b7280' stroke-linecap='round' stroke-linejoin='round' stroke-width='1.5' d='M6 8l4 4 4-4'/%3e%3c/svg%3e");
        background-position: right 1rem center;
        background-repeat: no-repeat;
        background-size: 1.5em 1.5em;
    }
</style>
@endsection
