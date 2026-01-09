<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Akun - Booking Tower Management</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />

    <style>
        :root {
            --bg-light-main: #F8FAFC;
            --bg-card: #FFFFFF;
            --primary-blue: #0F172A;
            --accent-orange: #FF5F00;
            --accent-blue: #3B82F6;
            --text-muted: #64748B;
        }

        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background: var(--bg-light-main);
            color: var(--primary-blue);
        }

        .input-light {
            background-color: #F1F5F9;
            border: 1px solid #E2E8F0;
            color: var(--primary-blue);
            transition: all 0.2s;
        }

        .input-light:focus {
            background-color: #FFFFFF;
            border-color: var(--accent-orange);
            box-shadow: 0 0 0 4px rgba(255, 95, 0, 0.1);
            outline: none;
        }

        .btn-orange {
            background: linear-gradient(135deg, #FF5F00 0%, #FF8A00 100%);
            color: white;
            box-shadow: 0 4px 15px rgba(255, 95, 0, 0.3);
        }

        .btn-orange:hover:not(:disabled) {
            box-shadow: 0 6px 20px rgba(255, 95, 0, 0.4);
            transform: translateY(-1px);
        }

        .fade-in {
            animation: fadeIn 0.8s cubic-bezier(0.4, 0, 0.2, 1);
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
    </style>
</head>

<body class="min-h-screen flex items-center justify-center px-4 py-12">

    <div class="max-w-md w-full bg-white rounded-2xl shadow-xl p-8 fade-in">

        {{-- Header --}}
        <div class="text-center mb-8">
            <div
                class="w-16 h-16 bg-orange-500 rounded-2xl flex items-center justify-center mx-auto mb-4 shadow-lg shadow-orange-200">
                <i class="fa-solid fa-user-plus text-white text-2xl"></i>
            </div>
            <h1 class="text-3xl font-extrabold mb-2 tracking-tight text-slate-900">
                Daftar <span class="text-orange-500">Akun</span>
            </h1>
            <p class="text-sm font-medium text-slate-400">Buat akun untuk mulai booking layanan</p>
        </div>

        {{-- Pesan Error dari Laravel --}}
        @if ($errors->any())
            <div class="bg-red-50 text-red-600 text-sm rounded-xl p-4 mb-6 border border-red-100">
                <ul class="list-none space-y-1">
                    @foreach ($errors->all() as $error)
                        <li><i class="fas fa-circle-exclamation mr-2"></i> {{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        {{-- Form Registrasi --}}
        <form method="POST" action="{{ route('booking.register.post') }}" class="space-y-4">
            @csrf

            {{-- Grid Nama Depan & Belakang --}}
            <div class="grid grid-cols-2 gap-4">
                <div class="space-y-1.5">
                    <label class="text-xs font-bold text-slate-700 uppercase tracking-wider ml-1">Nama Depan</label>
                    <input name="first_name" type="text" value="{{ old('first_name') }}"
                        class="w-full rounded-xl py-3 px-4 input-light font-medium"
                        placeholder="Contoh: Budi" required autofocus>
                </div>
                <div class="space-y-1.5">
                    <label class="text-xs font-bold text-slate-700 uppercase tracking-wider ml-1">Nama Belakang</label>
                    <input name="last_name" type="text" value="{{ old('last_name') }}"
                        class="w-full rounded-xl py-3 px-4 input-light font-medium"
                        placeholder="Santoso" required>
                </div>
            </div>

            {{-- Email --}}
            <div class="space-y-1.5">
                <label class="text-xs font-bold text-slate-700 uppercase tracking-wider ml-1">Alamat Email</label>
                <div class="relative">
                    <span class="absolute inset-y-0 left-4 flex items-center text-slate-400">
                        <i class="fa-solid fa-envelope"></i>
                    </span>
                    <input name="email" type="email" value="{{ old('email') }}"
                        class="w-full rounded-xl py-3 pl-12 pr-4 input-light font-medium"
                        placeholder="nama@email.com" required>
                </div>
            </div>

            {{-- Nomor Telepon --}}
            <div class="space-y-1.5">
                <label class="text-xs font-bold text-slate-700 uppercase tracking-wider ml-1">Nomor WhatsApp</label>
                <div class="relative">
                    <span class="absolute inset-y-0 left-4 flex items-center text-slate-400">
                        <i class="fa-solid fa-phone"></i>
                    </span>
                    <input name="phone" type="tel" value="{{ old('phone') }}"
                        class="w-full rounded-xl py-3 pl-12 pr-4 input-light font-medium"
                        placeholder="08xxxxxxxxxx" required>
                </div>
            </div>

            {{-- Password --}}
            <div class="space-y-1.5">
                <label class="text-xs font-bold text-slate-700 uppercase tracking-wider ml-1">Password</label>
                <div class="relative">
                    <span class="absolute inset-y-0 left-4 flex items-center text-slate-400">
                        <i class="fa-solid fa-lock"></i>
                    </span>
                    <input name="password" id="password_field" type="password"
                        class="w-full rounded-xl py-3 pl-12 pr-12 input-light font-medium"
                        placeholder="Minimal 8 karakter" required>
                    <span
                        class="absolute inset-y-0 right-4 flex items-center text-slate-400 cursor-pointer hover:text-orange-500"
                        onclick="togglePasswordVisibility('password_field', 'toggleIcon1')">
                        <i id="toggleIcon1" class="fa-solid fa-eye text-sm"></i>
                    </span>
                </div>
            </div>

            {{-- Konfirmasi Password --}}
            <div class="space-y-1.5">
                <label class="text-xs font-bold text-slate-700 uppercase tracking-wider ml-1">Ulangi Password</label>
                <div class="relative">
                    <span class="absolute inset-y-0 left-4 flex items-center text-slate-400">
                        <i class="fa-solid fa-shield-check"></i>
                    </span>
                    <input name="password_confirmation" id="password_confirmation_field" type="password"
                        class="w-full rounded-xl py-3 pl-12 pr-12 input-light font-medium"
                        placeholder="Konfirmasi password" required>
                    <span
                        class="absolute inset-y-0 right-4 flex items-center text-slate-400 cursor-pointer hover:text-orange-500"
                        onclick="togglePasswordVisibility('password_confirmation_field', 'toggleIcon2')">
                        <i id="toggleIcon2" class="fa-solid fa-eye text-sm"></i>
                    </span>
                </div>
            </div>

            {{-- Terms and Conditions --}}
            <div class="pt-2">
                <label class="flex items-start cursor-pointer group">
                    <input type="checkbox" name="terms" id="terms"
                        class="h-5 w-5 border-slate-200 rounded text-orange-500 focus:ring-orange-500/20 mt-0.5 transition-all">
                    <span class="ml-3 text-sm font-medium text-slate-600 leading-relaxed group-hover:text-slate-900 transition-colors">
                        Saya menyetujui <a href="#" class="text-orange-500 hover:underline">Syarat & Ketentuan</a> serta <a href="#" class="text-orange-500 hover:underline">Kebijakan Privasi</a> yang berlaku.
                    </span>
                </label>
            </div>

            {{-- Button Submit --}}
            <button type="submit" id="registerBtn"
                class="w-full py-4 rounded-xl btn-orange font-bold text-sm tracking-widest uppercase transition-all duration-300 disabled:opacity-50 disabled:cursor-not-allowed mt-4">
                Daftar Sekarang <i class="fa-solid fa-arrow-right ml-2"></i>
            </button>
        </form>

        {{-- Login Link --}}
        <div class="text-center mt-8 pt-6 border-t border-slate-100">
            <p class="text-sm text-slate-500">
                Sudah memiliki akun?
                <a href="{{ route('booking.login') }}"
                    class="font-bold text-orange-500 hover:text-orange-600 transition-colors">
                    Masuk Di Sini
                </a>
            </p>
        </div>

        {{-- Back to Home --}}
        <div class="text-center mt-4">
            <a href="{{ route('home') }}"
                class="text-xs font-bold text-slate-400 hover:text-slate-600 uppercase tracking-tighter transition-colors">
                <i class="fa-solid fa-house mr-1"></i> Kembali ke Beranda
            </a>
        </div>

    </div>

    <script>
        // Toggle visibility untuk dua field password berbeda
        function togglePasswordVisibility(fieldId, iconId) {
            const passwordField = document.getElementById(fieldId);
            const toggleIcon = document.getElementById(iconId);

            if (passwordField.type === 'password') {
                passwordField.type = 'text';
                toggleIcon.classList.replace('fa-eye', 'fa-eye-slash');
            } else {
                passwordField.type = 'password';
                toggleIcon.classList.replace('fa-eye-slash', 'fa-eye');
            }
        }

        // Logika checkbox terms
        const termsCheckbox = document.getElementById('terms');
        const registerBtn = document.getElementById('registerBtn');

        termsCheckbox.addEventListener('change', function() {
            registerBtn.disabled = !this.checked;
        });

        // Jalankan saat load pertama kali
        document.addEventListener('DOMContentLoaded', function() {
            registerBtn.disabled = !termsCheckbox.checked;
        });
    </script>

</body>

</html>
