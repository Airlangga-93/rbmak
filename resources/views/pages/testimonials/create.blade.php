@extends('layouts.app')

@section('title', 'Kirim Testimoni - PT. RBM')

@section('content')
    {{-- 🏔️ PREMIUM BREADCRUMB --}}
    <div class="bg-[#161f36] py-8 border-b border-white/5">
        <div class="max-w-7xl mx-auto px-6">
            <nav class="flex items-center gap-4 text-[10px] font-black uppercase tracking-[0.3em]">
                <a href="/" class="text-white/40 hover:text-[#FF7518] transition-colors">Home</a>
                <i class="fas fa-chevron-right text-[8px] text-white/20"></i>
                <a href="{{ route('testimonials.index') }}" class="text-white/40 hover:text-[#FF7518] transition-colors">Testimonials</a>
                <i class="fas fa-chevron-right text-[8px] text-white/20"></i>
                <span class="text-[#FF7518]">Write A Review</span>
            </nav>
            <h1 class="text-3xl md:text-4xl font-black text-white uppercase tracking-tighter mt-4">
                Bagikan <span class="text-[#FF7518]">Pengalaman</span> Anda
            </h1>
        </div>
    </div>

    <div class="bg-[#F8FAFC] min-h-screen pb-24">
        <div class="container mx-auto px-6 -mt-8">
            <div class="max-w-4xl mx-auto">

                {{-- 📦 FORM CONTAINER --}}
                <div class="bg-white rounded-[2.5rem] shadow-2xl shadow-slate-200/50 border border-slate-100 overflow-hidden">

                    {{-- 🎭 HEADER SECTION --}}
                    <div class="px-8 md:px-12 py-10 border-b border-slate-50 flex flex-col md:flex-row md:items-center justify-between gap-6 bg-gradient-to-r from-white to-slate-50/50">
                        <div class="max-w-md">
                            <div class="flex items-center gap-3 mb-2">
                                <span class="w-8 h-[2px] bg-[#FF7518]"></span>
                                <span class="text-[10px] font-black text-[#FF7518] uppercase tracking-[0.2em]">Feedback Pelanggan</span>
                            </div>
                            <h2 class="text-2xl font-black text-[#161f36] uppercase tracking-tight">Formulir Testimoni</h2>
                            <p class="text-slate-500 text-xs mt-2 font-medium">Masukan Anda sangat berharga bagi peningkatan kualitas layanan infrastruktur kami.</p>
                        </div>
                        <div class="w-14 h-14 rounded-2xl bg-orange-50 flex items-center justify-center border border-orange-100 shadow-inner">
                            <i class="fas fa-pen-fancy text-[#FF7518] text-xl"></i>
                        </div>
                    </div>

                    {{-- 📝 FORM BODY --}}
                    <form action="{{ route('testimonial.store') }}" method="POST" enctype="multipart/form-data" class="p-8 md:p-12">
                        @csrf

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">

                            {{-- Field: Nama --}}
                            <div class="space-y-2">
                                <label for="name" class="block text-[10px] font-black text-[#161f36] uppercase tracking-widest ml-1">
                                    Nama Lengkap <span class="text-[#FF7518]">*</span>
                                </label>
                                <div class="relative group">
                                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-slate-400 group-focus-within:text-[#FF7518] transition-colors">
                                        <i class="fas fa-user text-xs"></i>
                                    </div>
                                    <input type="text" name="name" id="name" required value="{{ old('name') }}"
                                        placeholder="Contoh: Budi Santoso"
                                        class="w-full pl-10 pr-4 py-4 bg-slate-50 border border-slate-100 rounded-2xl focus:outline-none focus:ring-4 focus:ring-[#FF7518]/10 focus:border-[#FF7518] focus:bg-white transition-all duration-300 text-sm font-bold text-[#161f36] placeholder:text-slate-300 @error('name') border-red-500 @enderror">
                                </div>
                                @error('name')
                                    <p class="text-red-500 text-[10px] font-bold mt-1 uppercase tracking-tighter italic">{{ $message }}</p>
                                @enderror
                            </div>

                            {{-- Field: Perusahaan --}}
                            <div class="space-y-2">
                                <label for="company" class="block text-[10px] font-black text-[#161f36] uppercase tracking-widest ml-1">
                                    Instansi / Perusahaan
                                </label>
                                <div class="relative group">
                                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-slate-400 group-focus-within:text-[#FF7518] transition-colors">
                                        <i class="fas fa-building text-xs"></i>
                                    </div>
                                    <input type="text" name="company" id="company" value="{{ old('company') }}"
                                        placeholder="Contoh: PT. Telekomunikasi Indonesia"
                                        class="w-full pl-10 pr-4 py-4 bg-slate-50 border border-slate-100 rounded-2xl focus:outline-none focus:ring-4 focus:ring-[#FF7518]/10 focus:border-[#FF7518] focus:bg-white transition-all duration-300 text-sm font-bold text-[#161f36] placeholder:text-slate-300">
                                </div>
                            </div>

                            {{-- Field: Pesan Testimoni --}}
                            <div class="md:col-span-2 space-y-2">
                                <label for="message" class="block text-[10px] font-black text-[#161f36] uppercase tracking-widest ml-1">
                                    Pesan Testimoni <span class="text-[#FF7518]">*</span>
                                </label>
                                <textarea name="message" id="message" rows="5" required
                                    placeholder="Ceritakan pengalaman profesional Anda bekerja sama dengan PT. RBM..."
                                    class="w-full px-5 py-4 bg-slate-50 border border-slate-100 rounded-[2rem] focus:outline-none focus:ring-4 focus:ring-[#FF7518]/10 focus:border-[#FF7518] focus:bg-white transition-all duration-300 text-sm font-medium leading-relaxed text-slate-600 placeholder:text-slate-300 resize-none @error('message') border-red-500 @enderror">{{ old('message') }}</textarea>
                                @error('message')
                                    <p class="text-red-500 text-[10px] font-bold mt-1 uppercase tracking-tighter italic">{{ $message }}</p>
                                @enderror
                            </div>

                            {{-- Field: Upload Foto (Optional) --}}
                            <div class="md:col-span-2 space-y-2">
                                <label class="block text-[10px] font-black text-[#161f36] uppercase tracking-widest ml-1">
                                    Foto Profil (Opsional)
                                </label>
                                <div class="flex items-center justify-center w-full">
                                    <label for="image" class="flex flex-col items-center justify-center w-full h-32 border-2 border-slate-100 border-dashed rounded-[2rem] cursor-pointer bg-slate-50 hover:bg-slate-100 transition-all duration-300 group">
                                        <div class="flex flex-col items-center justify-center pt-5 pb-6">
                                            <i class="fas fa-cloud-upload-alt text-slate-300 group-hover:text-[#FF7518] mb-2 transition-colors"></i>
                                            <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">Klik untuk unggah foto profil</p>
                                        </div>
                                        <input id="image" name="image" type="file" class="hidden" accept="image/*" />
                                    </label>
                                </div>
                            </div>

                        </div>

                        {{-- 🛠️ BUTTON ACTIONS --}}
                        <div class="mt-12 pt-8 border-t border-slate-50 flex flex-col sm:flex-row items-center justify-between gap-6">
                            <div class="flex items-center gap-2 text-slate-400">
                                <i class="fas fa-shield-alt text-xs"></i>
                                <span class="text-[9px] font-bold uppercase tracking-widest">Data Anda akan ditinjau oleh tim admin kami</span>
                            </div>

                            <div class="flex items-center gap-4 w-full sm:w-auto">
                                <a href="{{ route('testimonials.index') }}"
                                    class="flex-1 sm:flex-none text-center px-8 py-4 rounded-xl font-black text-[10px] uppercase tracking-widest text-slate-400 hover:text-[#161f36] transition-colors">
                                    Batal
                                </a>

                                <button type="submit"
                                    class="flex-1 sm:flex-none inline-flex items-center justify-center gap-3 px-10 py-4 bg-[#161f36] text-white rounded-2xl font-black uppercase text-[10px] tracking-[0.2em] hover:bg-[#FF7518] hover:shadow-2xl hover:shadow-[#FF7518]/30 transition-all duration-500 transform active:scale-95">
                                    <i class="fas fa-paper-plane"></i>
                                    Kirim Sekarang
                                </button>
                            </div>
                        </div>
                    </form>
                </div>

                {{-- INFO FOOTER --}}
                <p class="text-center mt-8 text-[10px] font-black text-slate-300 uppercase tracking-[0.3em]">
                    PT. Rahayu Bangun Mandiri &copy; 2024
                </p>
            </div>
        </div>
    </div>
@endsection
