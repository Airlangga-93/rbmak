@extends('admin.layouts.app')

@section('content')
<div class="p-6 bg-[#F8FAFC] min-h-screen">
    <div class="max-w-3xl mx-auto">

        {{-- BREADCRUMB --}}
        <div class="flex items-center gap-2 text-sm text-slate-500 mb-4">
            <a href="{{ route('admin.users.index') }}" class="hover:text-orange-500 transition-colors">Daftar Admin</a>
            <i class="bi bi-chevron-right text-[10px]"></i>
            <span class="text-slate-800 font-medium">Tambah Administrator Baru</span>
        </div>

        <div class="bg-white rounded-3xl shadow-sm border border-slate-100 overflow-hidden">
            {{-- HEADER FORM --}}
            <div class="p-8 border-b border-slate-50 bg-slate-50/50">
                <div class="flex items-center gap-4">
                    <div class="w-12 h-12 bg-orange-500 rounded-2xl flex items-center justify-center text-white shadow-lg shadow-orange-200">
                        <i class="bi bi-person-plus-fill text-xl"></i>
                    </div>
                    <div>
                        <h2 class="text-xl font-bold text-slate-800">Registrasi Admin</h2>
                        <p class="text-sm text-slate-500">Daftarkan akun administrator baru untuk sistem PT Sayap Sembilan Satu</p>
                    </div>
                </div>
            </div>

            {{-- FORM --}}
            <form action="{{ route('admin.users.store') }}" method="POST" class="p-8 space-y-6">
                @csrf

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    {{-- Nama Lengkap --}}
                    <div class="space-y-2">
                        <label class="text-sm font-bold text-slate-700 ml-1">Nama Lengkap</label>
                        <div class="relative">
                            <span class="absolute inset-y-0 left-4 flex items-center text-slate-400">
                                <i class="bi bi-person"></i>
                            </span>
                            <input type="text" name="name" value="{{ old('name') }}" required
                                class="w-full pl-11 pr-4 py-3 rounded-2xl border border-slate-200 focus:border-orange-500 focus:ring-4 focus:ring-orange-500/10 outline-none transition-all"
                                placeholder="Masukkan nama lengkap">
                        </div>
                        @error('name') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    {{-- No Telepon --}}
                    <div class="space-y-2">
                        <label class="text-sm font-bold text-slate-700 ml-1">No. Telepon (Opsional)</label>
                        <div class="relative">
                            <span class="absolute inset-y-0 left-4 flex items-center text-slate-400">
                                <i class="bi bi-telephone"></i>
                            </span>
                            <input type="text" name="phone" value="{{ old('phone') }}"
                                class="w-full pl-11 pr-4 py-3 rounded-2xl border border-slate-200 focus:border-orange-500 focus:ring-4 focus:ring-orange-500/10 outline-none transition-all"
                                placeholder="08xxxxxxxxxx">
                        </div>
                        @error('phone') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>
                </div>

                {{-- Email --}}
                <div class="space-y-2">
                    <label class="text-sm font-bold text-slate-700 ml-1">Alamat Email</label>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-4 flex items-center text-slate-400">
                            <i class="bi bi-envelope"></i>
                        </span>
                        <input type="email" name="email" value="{{ old('email') }}" required
                            class="w-full pl-11 pr-4 py-3 rounded-2xl border border-slate-200 focus:border-orange-500 focus:ring-4 focus:ring-orange-500/10 outline-none transition-all"
                            placeholder="admin@sayap91.com">
                    </div>
                    @error('email') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    {{-- Password --}}
                    <div class="space-y-2">
                        <label class="text-sm font-bold text-slate-700 ml-1">Password</label>
                        <div class="relative">
                            <span class="absolute inset-y-0 left-4 flex items-center text-slate-400">
                                <i class="bi bi-key"></i>
                            </span>
                            <input type="password" name="password" id="password" required
                                class="w-full pl-11 pr-12 py-3 rounded-2xl border border-slate-200 focus:border-orange-500 focus:ring-4 focus:ring-orange-500/10 outline-none transition-all"
                                placeholder="Minimal 8 karakter">
                            {{-- Icon Toggle --}}
                            <button type="button" onclick="togglePassword('password', 'eye-icon-1')" class="absolute inset-y-0 right-4 flex items-center text-slate-400 hover:text-orange-500 transition-colors">
                                <i id="eye-icon-1" class="bi bi-eye"></i>
                            </button>
                        </div>
                    </div>

                    {{-- Konfirmasi Password --}}
                    <div class="space-y-2">
                        <label class="text-sm font-bold text-slate-700 ml-1">Konfirmasi Password</label>
                        <div class="relative">
                            <span class="absolute inset-y-0 left-4 flex items-center text-slate-400">
                                <i class="bi bi-shield-check"></i>
                            </span>
                            <input type="password" name="password_confirmation" id="password_confirmation" required
                                class="w-full pl-11 pr-12 py-3 rounded-2xl border border-slate-200 focus:border-orange-500 focus:ring-4 focus:ring-orange-500/10 outline-none transition-all"
                                placeholder="Ulangi password">
                            {{-- Icon Toggle --}}
                            <button type="button" onclick="togglePassword('password_confirmation', 'eye-icon-2')" class="absolute inset-y-0 right-4 flex items-center text-slate-400 hover:text-orange-500 transition-colors">
                                <i id="eye-icon-2" class="bi bi-eye"></i>
                            </button>
                        </div>
                    </div>
                </div>
                @error('password') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror

                {{-- INFO BOX --}}
                <div class="p-4 bg-orange-50 rounded-2xl border border-orange-100">
                    <div class="flex gap-3">
                        <i class="bi bi-info-circle-fill text-orange-500"></i>
                        <p class="text-xs text-orange-700 leading-relaxed">
                            Secara default, akun yang dibuat melalui halaman ini akan memiliki role <strong>Administrator</strong> dan dapat mengakses seluruh fitur manajemen dashboard.
                        </p>
                    </div>
                </div>

                {{-- ACTION BUTTONS --}}
                <div class="pt-4 flex flex-col md:flex-row items-center gap-3">
                    <button type="submit" class="w-full md:flex-1 bg-orange-500 text-white py-4 rounded-2xl font-bold hover:bg-orange-600 transition-all shadow-lg shadow-orange-200 flex items-center justify-center gap-2">
                        <i class="bi bi-check-lg"></i> SIMPAN ADMIN BARU
                    </button>
                    <a href="{{ route('admin.users.index') }}" class="w-full md:w-auto px-8 py-4 bg-slate-100 text-slate-600 rounded-2xl font-bold hover:bg-slate-200 transition-all text-center">
                        BATAL
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- SCRIPT TOGGLE PASSWORD --}}
<script>
    function togglePassword(inputId, iconId) {
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
