<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lupa Password - Booking Tower Management</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
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
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }
    </style>
</head>

<body class="min-h-screen flex items-center justify-center px-4 py-12">

    <div class="max-w-md w-full bg-white rounded-2xl shadow-xl p-8 fade-in">
        <div class="text-center mb-8">
            <div class="w-16 h-16 bg-orange-500 rounded-2xl flex items-center justify-center mx-auto mb-4 shadow-lg shadow-orange-200">
                <i class="fa-solid fa-paper-plane text-white text-2xl"></i>
            </div>
            <h1 class="text-3xl font-extrabold mb-2 tracking-tight text-slate-900">
                Lupa <span class="text-orange-500">Password?</span>
            </h1>
            <p class="text-sm font-medium text-slate-400 px-4">
                Masukkan email Anda dan kami akan mengirimkan link instruksi reset password.
            </p>
        </div>

        {{-- Pesan Error --}}
        @if ($errors->any())
            <div class="bg-red-50 text-red-600 text-sm rounded-xl p-4 mb-6 border border-red-100 shadow-sm">
                @foreach ($errors->all() as $error)
                    <div class="flex items-center font-semibold mb-1 last:mb-0">
                        <i class="fas fa-circle-exclamation mr-2"></i> {{ $error }}
                    </div>
                @endforeach
            </div>
        @endif

        {{-- Pesan Sukses (Gunakan 'status' karena default Laravel reset password kirim 'status') --}}
        @if (session('status') || session('success'))
            <div class="bg-green-50 text-green-700 text-sm rounded-xl p-4 mb-6 border border-green-100 shadow-sm">
                <div class="flex items-center font-bold">
                    <i class="fas fa-check-circle mr-2 text-lg"></i>
                    {{ session('status') ?? session('success') }}
                </div>
            </div>
        @endif

        <form method="POST" action="{{ route('booking.reset.post') }}" class="space-y-6" id="reset-form">
            @csrf
            <div class="space-y-2">
                <label class="text-sm font-bold text-slate-700 ml-1">Alamat Email</label>
                <div class="relative">
                    <span class="absolute inset-y-0 left-4 flex items-center text-slate-400">
                        <i class="fa-solid fa-envelope"></i>
                    </span>
                    <input name="email" type="email" value="{{ old('email') }}"
                        class="w-full rounded-xl py-3.5 pl-12 pr-4 input-light font-medium"
                        placeholder="nama@email.com" required autofocus>
                </div>
            </div>

            <button type="submit" id="submit-btn"
                class="w-full py-4 rounded-xl btn-orange font-bold text-sm tracking-widest uppercase transition-all duration-300">
                Kirim Link Reset <i class="fa-solid fa-paper-plane ml-2"></i>
            </button>
        </form>

        <div class="text-center mt-8 pt-6 border-t border-slate-50">
            <a href="{{ route('booking.login') }}"
                class="text-sm font-bold text-orange-500 hover:text-orange-600 transition-colors">
                <i class="fa-solid fa-arrow-left mr-2"></i> Kembali ke Halaman Masuk
            </a>
        </div>
    </div>

    <script>
        const form = document.getElementById('reset-form');
        const btn = document.getElementById('submit-btn');

        form.addEventListener('submit', function() {
            // Menghindari double submit
            btn.disabled = true;
            btn.innerHTML = 'Mengirim... <i class="fa-solid fa-circle-notch fa-spin ml-2"></i>';
            btn.classList.add('opacity-70', 'cursor-not-allowed');
        });
    </script>
</body>
</html>
