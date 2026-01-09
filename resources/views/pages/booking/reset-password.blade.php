<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Atur Ulang Password - Booking Tower Management</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />

    <style>
        :root {
            --bg-light-main: #F8FAFC;
            --primary-blue: #0F172A;
            --accent-orange: #FF5F00;
        }

        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background: var(--bg-light-main);
            color: var(--primary-blue);
        }

        .input-light {
            background-color: #F1F5F9;
            border: 1px solid #E2E8F0;
            transition: all 0.2s;
        }

        .input-light:focus {
            background-color: #FFFFFF;
            border-color: var(--accent-orange);
            box-shadow: 0 0 0 4px rgba(255, 95, 0, 0.1);
            outline: none;
        }

        /* Gaya khusus untuk input email yang dikunci */
        .input-readonly {
            background-color: #E2E8F0;
            color: #64748B;
            border: 1px solid #CBD5E1;
            cursor: not-allowed;
        }

        .btn-orange {
            background: linear-gradient(135deg, #FF5F00 0%, #FF8A00 100%);
            color: white;
            box-shadow: 0 4px 15px rgba(255, 95, 0, 0.3);
        }

        .btn-orange:hover {
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

        <div class="text-center mb-8">
            <div
                class="w-16 h-16 bg-orange-500 rounded-2xl flex items-center justify-center mx-auto mb-4 shadow-lg shadow-orange-200">
                <i class="fa-solid fa-key text-white text-2xl"></i>
            </div>
            <h1 class="text-3xl font-extrabold mb-2 tracking-tight text-slate-900">
                Password <span class="text-orange-500">Baru</span>
            </h1>
            <p class="text-sm font-medium text-slate-400">Silakan buat password baru yang kuat untuk akun Anda</p>
        </div>

        {{-- Notifikasi Error --}}
        @if ($errors->any())
            <div class="bg-red-50 text-red-600 text-sm rounded-xl p-4 mb-6 border border-red-100 shadow-sm">
                @foreach ($errors->all() as $error)
                    <div class="flex items-center mb-1 font-semibold">
                        <i class="fas fa-circle-exclamation mr-2"></i> {{ $error }}
                    </div>
                @endforeach
            </div>
        @endif

        {{-- Form Reset Password --}}
        <form method="POST" action="{{ route('booking.reset.password.post') }}" class="space-y-5">
            @csrf

            {{-- Token Keamanan (Wajib ada untuk Laravel) --}}
            <input type="hidden" name="token" value="{{ $token }}">

            <div class="space-y-2">
                <label class="text-sm font-bold text-slate-700 ml-1">Email Anda (Terkunci)</label>
                <div class="relative">
                    <span class="absolute inset-y-0 left-4 flex items-center text-slate-400">
                        <i class="fa-solid fa-envelope"></i>
                    </span>
                    {{-- Menggunakan request email agar otomatis terisi dari URL link email --}}
                    <input name="email" type="email" value="{{ request()->email ?? old('email') }}"
                        class="w-full rounded-xl py-3.5 pl-12 pr-4 input-light font-medium input-readonly"
                        placeholder="nama@email.com" required readonly>
                </div>
                <p class="text-[10px] text-slate-400 ml-1">* Email tidak dapat diubah demi alasan keamanan</p>
            </div>

            <div class="space-y-2">
                <label class="text-sm font-bold text-slate-700 ml-1">Password Baru</label>
                <div class="relative">
                    <span class="absolute inset-y-0 left-4 flex items-center text-slate-400">
                        <i class="fa-solid fa-lock"></i>
                    </span>
                    <input name="password" id="password_field" type="password"
                        class="w-full rounded-xl py-3.5 pl-12 pr-12 input-light font-medium"
                        placeholder="Minimal 8 karakter" required autofocus>
                    <span
                        class="absolute inset-y-0 right-4 flex items-center text-slate-400 cursor-pointer hover:text-orange-500"
                        onclick="togglePasswordVisibility()">
                        <i id="toggleIcon" class="fa-solid fa-eye text-sm"></i>
                    </span>
                </div>
            </div>

            <div class="space-y-2">
                <label class="text-sm font-bold text-slate-700 ml-1">Konfirmasi Password</label>
                <div class="relative">
                    <span class="absolute inset-y-0 left-4 flex items-center text-slate-400">
                        <i class="fa-solid fa-lock"></i>
                    </span>
                    <input name="password_confirmation" id="password_confirm_field" type="password"
                        class="w-full rounded-xl py-3.5 pl-12 pr-4 input-light font-medium"
                        placeholder="Ulangi password baru" required>
                </div>
            </div>

            <button type="submit" id="submit-btn"
                class="w-full py-4 rounded-xl btn-orange font-bold text-sm tracking-widest uppercase transition-all duration-300 shadow-lg">
                Perbarui Password <i class="fa-solid fa-shield-halved ml-2"></i>
            </button>
        </form>

        <div class="text-center mt-8 pt-6 border-t border-slate-50">
            <a href="{{ route('booking.login') }}"
                class="text-xs font-bold text-slate-400 hover:text-orange-500 transition-colors uppercase tracking-widest">
                <i class="fa-solid fa-arrow-left mr-2"></i> Batal dan Kembali
            </a>
        </div>
    </div>

    <script>
        // Fungsi untuk melihat/menyembunyikan password
        function togglePasswordVisibility() {
            const passwordField = document.getElementById('password_field');
            const confirmField = document.getElementById('password_confirm_field');
            const toggleIcon = document.getElementById('toggleIcon');

            const type = passwordField.type === 'password' ? 'text' : 'password';

            passwordField.type = type;
            confirmField.type = type; // Menyamakan keduanya agar mudah dicek

            if (type === 'text') {
                toggleIcon.classList.replace('fa-eye', 'fa-eye-slash');
            } else {
                toggleIcon.classList.replace('fa-eye-slash', 'fa-eye');
            }
        }

        // Mencegah klik ganda saat memproses password baru
        const form = document.querySelector('form');
        const btn = document.querySelector('#submit-btn');

        form.addEventListener('submit', function() {
            btn.innerHTML = 'Memproses... <i class="fa-solid fa-circle-notch fa-spin ml-2"></i>';
            btn.style.pointerEvents = 'none';
            btn.classList.add('opacity-70');
        });
    </script>
</body>

</html>
