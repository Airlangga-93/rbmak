<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Verifikasi Kode - Tower Management</title>

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
            transition: .2s;
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

        .btn-orange:hover {
            transform: translateY(-1px);
            box-shadow: 0 6px 20px rgba(255, 95, 0, 0.4);
        }
    </style>
</head>

<body class="min-h-screen flex items-center justify-center px-6">

    <div class="w-full max-w-md bg-white rounded-2xl p-10 shadow-xl">

        <div class="mb-8 text-center">
            <div
                class="mx-auto w-14 h-14 bg-orange-500 rounded-xl flex items-center justify-center shadow-lg shadow-orange-200 mb-4">
                <i class="fa-solid fa-shield-check text-white text-xl"></i>
            </div>

            <h1 class="text-3xl font-extrabold tracking-tight">
                Verifikasi <span class="text-orange-500">Kode</span>
            </h1>
            <p class="text-sm text-slate-400 mt-2">
                Kode dikirim ke: <br>
                <span class="font-bold text-slate-700">{{ request('email') }}</span>
            </p>
        </div>

        @if (session('status'))
            <div class="bg-emerald-50 border border-emerald-100 text-emerald-600 text-xs rounded-xl p-4 mb-6">
                <i class="fa-solid fa-circle-check mr-2"></i>{{ session('status') }}
            </div>
        @endif

        @if ($errors->any())
            <div class="bg-red-50 border border-red-100 text-red-600 text-xs rounded-xl p-4 mb-6 space-y-1">
                @foreach ($errors->all() as $error)
                    <div><i class="fa-solid fa-circle-exclamation mr-2"></i>{{ $error }}</div>
                @endforeach
            </div>
        @endif

        <form method="POST" action="{{ route('password.verify.post') }}" class="space-y-6">
            @csrf

            <input type="hidden" name="email" value="{{ request('email') }}">

            <div class="space-y-2">
                <label class="text-[10px] font-bold uppercase tracking-widest text-slate-400 ml-1">
                    6-Digit Security Code
                </label>
                <div class="relative">
                    <span class="absolute inset-y-0 left-4 flex items-center text-slate-400">
                        <i class="fa-solid fa-key"></i>
                    </span>
                    <input type="text" name="code" maxlength="6" required autofocus
                        class="w-full rounded-xl py-4 pl-12 pr-4 input-light text-center tracking-[0.4em] font-bold text-lg focus:ring-0"
                        placeholder="••••••" value="{{ old('code') }}">
                </div>
            </div>

            <button type="submit"
                class="w-full py-4 rounded-xl btn-orange font-extrabold text-sm tracking-widest uppercase transition-all">
                Verifikasi Kode
                <i class="fa-solid fa-arrow-right ml-2"></i>
            </button>
        </form>

        <div class="mt-8 text-center space-y-4">
            <p class="text-xs text-slate-400">
                Tidak menerima kode?
                <a href="{{ route('password.request') }}" class="text-orange-500 font-bold hover:underline">Kirim Ulang</a>
            </p>

            <div class="pt-4 border-t border-slate-50">
                <a href="{{ route('login') }}"
                    class="text-xs font-bold text-slate-300 uppercase tracking-widest hover:text-orange-500 transition">
                    <i class="fa-solid fa-arrow-left mr-1"></i> Back to Login
                </a>
            </div>

            <p class="text-[10px] font-bold text-slate-300 uppercase tracking-[0.3em] pt-2">
                Secured by Sayap 91 Node
            </p>
        </div>

    </div>

</body>

</html>
