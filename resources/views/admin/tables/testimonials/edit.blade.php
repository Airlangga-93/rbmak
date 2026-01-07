@extends('admin.layouts.app')

@section('title', 'Edit Testimoni - PT. RBM')

@section('content')

{{-- Definisi Warna Kustom (RBM Theme) --}}
<style>
    .text-dark-tower { color: #1e3a8a; } /* Biru Navy RBM */
    .bg-dark-tower { background-color: #1e3a8a; }
    .text-accent-tower { color: #FF7518; } /* Oranye RBM */
    .bg-accent-tower { background-color: #FF7518; }
    .hover\:bg-accent-dark:hover { background-color: #e66a15; }
    .shadow-soft { box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08); }

    input[type="file"]::file-selector-button {
        background-color: #f1f5f9;
        color: #1e3a8a;
        border: 1px solid #e2e8f0;
        padding: 0.5rem 1rem;
        margin-right: 1rem;
        border-radius: 0.5rem;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.2s;
    }
</style>

<div class="container mx-auto p-6 max-w-4xl">
    <div class="bg-white rounded-2xl shadow-soft p-6 md:p-10 border border-gray-100">

        {{-- Header --}}
        <div class="mb-8">
            <h4 class="text-2xl font-black text-dark-tower uppercase tracking-tight">Edit Data Testimoni</h4>
            <p class="text-sm text-gray-500 italic mt-1">Lakukan perubahan informasi klien atau status publikasi di bawah ini.</p>
        </div>

        <form action="{{ route('admin.testimonials.update', $testimonial->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                {{-- Nama --}}
                <div class="col-span-1">
                    <label for="name" class="block text-xs font-black text-gray-400 uppercase tracking-widest mb-2">Nama Lengkap <span class="text-red-500">*</span></label>
                    <input type="text" name="name" id="name" required
                           class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-orange-500/20 focus:border-orange-500 transition @error('name') border-red-500 @enderror"
                           value="{{ old('name', $testimonial->name) }}">
                    @error('name')
                        <p class="text-red-500 text-[10px] mt-1 font-bold uppercase">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Perusahaan/Jabatan --}}
                <div class="col-span-1">
                    <label for="company" class="block text-xs font-black text-gray-400 uppercase tracking-widest mb-2">Perusahaan / Jabatan</label>
                    <input type="text" name="company" id="company"
                           class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-orange-500/20 focus:border-orange-500 transition"
                           value="{{ old('company', $testimonial->company) }}">
                </div>

                {{-- Status Moderasi --}}
                <div class="col-span-1">
                    <label for="status" class="block text-xs font-black text-gray-400 uppercase tracking-widest mb-2">Status Publikasi</label>
                    <select name="status" id="status"
                            class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-orange-500/20 focus:border-orange-500 transition">
                        <option value="pending" {{ old('status', $testimonial->status) == 'pending' ? 'selected' : '' }}>Moderasi (Pending)</option>
                        <option value="approved" {{ old('status', $testimonial->status) == 'approved' ? 'selected' : '' }}>Tayangkan (Approved)</option>
                        <option value="rejected" {{ old('status', $testimonial->status) == 'rejected' ? 'selected' : '' }}>Tolak (Rejected)</option>
                    </select>
                </div>

                {{-- Foto (Pratinjau & Input) --}}
                <div class="col-span-1">
                    <label class="block text-xs font-black text-gray-400 uppercase tracking-widest mb-2">Foto Profil</label>
                    <div class="flex items-center gap-4 mb-2">
                        @if($testimonial->image && Storage::disk('public')->exists($testimonial->image))
                            <img src="{{ asset('storage/'.$testimonial->image) }}"
                                 class="w-12 h-12 rounded-full object-cover border-2 border-orange-500 shadow-sm">
                        @else
                            <div class="w-12 h-12 rounded-full bg-gray-100 flex items-center justify-center border border-gray-200">
                                <i class="fas fa-user text-gray-300 text-xs"></i>
                            </div>
                        @endif
                        <input type="file" name="image" id="image" accept="image/*"
                               class="flex-1 border border-gray-200 rounded-xl text-sm text-gray-500 focus:outline-none">
                    </div>
                    <p class="text-[10px] text-gray-400 italic">Biarkan kosong jika tidak ingin mengganti foto.</p>
                </div>

                {{-- Pesan --}}
                <div class="md:col-span-2">
                    <label for="message" class="block text-xs font-black text-gray-400 uppercase tracking-widest mb-2">Pesan Testimoni <span class="text-red-500">*</span></label>
                    <textarea name="message" id="message" rows="5" required
                              class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-orange-500/20 focus:border-orange-500 transition @error('message') border-red-500 @enderror">{{ old('message', $testimonial->message) }}</textarea>
                    @error('message')
                        <p class="text-red-500 text-[10px] mt-1 font-bold uppercase">{{ $message }}</p>
                    @enderror
                </div>

            </div>

            {{-- Tombol Aksi --}}
            <div class="mt-10 flex flex-col md:flex-row items-center gap-4 pt-6 border-t border-gray-50">
                <button type="submit"
                        class="w-full md:w-auto bg-dark-tower text-white px-10 py-3 rounded-xl font-bold hover:bg-orange-600 transition-all duration-300 shadow-lg shadow-blue-900/10 flex items-center justify-center space-x-2 text-xs uppercase tracking-widest">
                    <i class="fas fa-sync-alt"></i> <span>Simpan Perubahan</span>
                </button>

                <a href="{{ route('admin.testimonials.index') }}"
                   class="w-full md:w-auto bg-gray-100 text-gray-500 px-10 py-3 rounded-xl font-bold hover:bg-gray-200 transition-all duration-300 text-xs uppercase tracking-widest text-center">
                    Batal
                </a>
            </div>
        </form>
    </div>
</div>

@endsection
