@extends('admin.layouts.app')

@section('content')
<div class="p-6 bg-[#F8FAFC] min-h-screen">
    <div class="max-w-2xl mx-auto">
        {{-- BREADCRUMB / BACK --}}
        <a href="{{ route('admin.users.index') }}" class="inline-flex items-center text-sm text-slate-500 hover:text-orange-600 mb-6 transition-colors font-medium">
            <i class="bi bi-arrow-left mr-2"></i> Kembali ke Daftar
        </a>

        <div class="bg-white rounded-3xl shadow-sm border border-slate-100 overflow-hidden">
            {{-- HEADER --}}
            <div class="bg-[#0F172A] p-6 text-white flex justify-between items-center">
                <div>
                    <h2 class="text-xl font-bold">Edit Profil Admin</h2>
                    <p class="text-slate-400 text-[13px]">ID Admin: #{{ $user->id }} — Sinkron dengan sistem login</p>
                </div>
                <div class="w-12 h-12 bg-white/10 rounded-2xl flex items-center justify-center text-orange-500 border border-white/10">
                    <i class="bi bi-shield-lock-fill text-xl"></i>
                </div>
            </div>

            <form action="{{ route('admin.users.update', $user->id) }}" method="POST" class="p-8 space-y-6">
                @csrf
                @method('PUT')

                {{-- Input Nama --}}
                <div class="space-y-2">
                    <label class="text-sm font-bold text-slate-700 ml-1">Nama Lengkap</label>
                    <div class="relative group">
                        <span class="absolute inset-y-0 left-4 flex items-center text-slate-400 group-focus-within:text-orange-500 transition-colors">
                            <i class="bi bi-person"></i>
                        </span>
                        <input type="text" name="name" value="{{ old('name', $user->name) }}" required
                            class="w-full pl-11 pr-4 py-3 rounded-xl border border-slate-200 focus:border-orange-500 focus:ring-4 focus:ring-orange-500/10 outline-none transition-all">
                    </div>
                    @error('name') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                {{-- Input No Telepon (Opsional) --}}
                <div class="space-y-2">
                    <label class="text-sm font-bold text-slate-700 ml-1">No. Telepon (Opsional)</label>
                    <div class="relative group">
                        <span class="absolute inset-y-0 left-4 flex items-center text-slate-400 group-focus-within:text-orange-500 transition-colors">
                            <i class="bi bi-telephone"></i>
                        </span>
                        <input type="text" name="phone" value="{{ old('phone', $user->phone) }}"
                            class="w-full pl-11 pr-4 py-3 rounded-xl border border-slate-200 focus:border-orange-500 focus:ring-4 focus:ring-orange-500/10 outline-none transition-all"
                            placeholder="08xxxxxxxxxx">
                    </div>
                    @error('phone') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                {{-- Input Email --}}
                <div class="space-y-2">
                    <label class="text-sm font-bold text-slate-700 ml-1">Alamat Email</label>
                    <div class="relative group">
                        <span class="absolute inset-y-0 left-4 flex items-center text-slate-400 group-focus-within:text-orange-500 transition-colors">
                            <i class="bi bi-envelope"></i>
                        </span>
                        <input type="email" name="email" value="{{ old('email', $user->email) }}" required
                            class="w-full pl-11 pr-4 py-3 rounded-xl border border-slate-200 focus:border-orange-500 focus:ring-4 focus:ring-orange-500/10 outline-none transition-all">
                    </div>
                    <p class="text-[10px] text-slate-400 ml-1 italic">*Email ini digunakan untuk login dan reset password.</p>
                    @error('email') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <hr class="border-slate-100">

                {{-- Password Section --}}
                <div class="bg-orange-50 p-4 rounded-2xl border border-orange-100">
                    <div class="flex items-start">
                        <i class="bi bi-info-circle-fill text-orange-500 mt-0.5 mr-3"></i>
                        <p class="text-xs text-orange-700 leading-relaxed font-medium">
                            Kosongkan kolom password jika tidak ingin mengubah kredensial login. Jika diubah, admin terkait harus login menggunakan password baru.
                        </p>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    {{-- Password Baru --}}
                    <div class="space-y-2">
                        <label class="text-sm font-bold text-slate-700 ml-1">Password Baru</label>
                        <div class="relative">
                            <input type="password" name="password" id="password_edit"
                                class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:border-orange-500 focus:ring-4 focus:ring-orange-500/10 outline-none transition-all"
                                placeholder="••••••••">
                            <button type="button" onclick="togglePasswordEdit('password_edit', 'eyeIconEdit1')" class="absolute inset-y-0 right-4 flex items-center text-slate-400 hover:text-orange-500 transition-colors">
                                <i id="eyeIconEdit1" class="bi bi-eye"></i>
                            </button>
                        </div>
                        @error('password') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    {{-- Konfirmasi Password --}}
                    <div class="space-y-2">
                        <label class="text-sm font-bold text-slate-700 ml-1">Konfirmasi Password</label>
                        <div class="relative">
                            <input type="password" name="password_confirmation" id="password_confirmation_edit"
                                class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:border-orange-500 focus:ring-4 focus:ring-orange-500/10 outline-none transition-all"
                                placeholder="••••••••">
                            <button type="button" onclick="togglePasswordEdit('password_confirmation_edit', 'eyeIconEdit2')" class="absolute inset-y-0 right-4 flex items-center text-slate-400 hover:text-orange-500 transition-colors">
                                <i id="eyeIconEdit2" class="bi bi-eye"></i>
                            </button>
                        </div>
                    </div>
                </div>

                {{-- Submit Section --}}
                <div class="pt-4 flex items-center justify-end space-x-4">
                    <a href="{{ route('admin.users.index') }}" class="px-6 py-3 text-sm font-bold text-slate-400 hover:text-slate-600 transition-colors text-center">
                        Batalkan
                    </a>

                    <button type="submit" class="px-10 py-3 bg-[#FF5F00] hover:bg-[#E55500] text-white font-bold rounded-xl shadow-lg shadow-orange-500/20 transition-all transform active:scale-95">
                        Update Kredensial
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- SCRIPT SHOW/HIDE PASSWORD --}}
<script>
    function togglePasswordEdit(inputId, iconId) {
        const passwordInput = document.getElementById(inputId);
        const eyeIcon = document.getElementById(iconId);

        if (passwordInput.type === 'password') {
            passwordInput.type = 'text';
            eyeIcon.classList.remove('bi-eye');
            eyeIcon.classList.add('bi-eye-slash');
        } else {
            passwordInput.type = 'password';
            eyeIcon.classList.remove('bi-eye-slash');
            eyeIcon.classList.add('bi-eye');
        }
    }
</script>
@endsection
