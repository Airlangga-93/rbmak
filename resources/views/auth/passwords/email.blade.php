<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Forgot Password - Tower Management</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />

    <style>
        /* ------------------------------
            TOWER LIGHT MODE - BLUE & ORANGE
        -------------------------------*/
        :root {
            --bg-light-main: #F8FAFC;
            /* Latar belakang utama (putih kebiruan) */
            --bg-card: #FFFFFF;
            /* Putih bersih */
            --primary-blue: #0F172A;
            /* Navy Gelap untuk teks/aksen */
            --accent-orange: #FF5F00;
            /* Oranye menyala sesuai screenshot */
            --accent-blue: #3B82F6;
            /* Biru pendukung */
            --text-muted: #64748B;
            /* Abu-abu teks */
        }

        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background: var(--bg-light-main);
            color: var(--primary-blue);
        }

        /* Styling Card Info */
        .card-info {
            background-color: var(--bg-card);
            border-radius: 1.25rem;
            border: 1px solid #E2E8F0;
            transition: all .3s ease;
        }

        .card-info:hover {
            transform: translateY(-3px);
            box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.05);
            border-color: var(--accent-orange);
        }

        /* Input Field Styling */
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
        }

        /* Gradient Button */
        .btn-orange {
            background: linear-gradient(135deg, #FF5F00 0%, #FF8A00 100%);
            color: white;
            box-shadow: 0 4px 15px rgba(255, 95, 0, 0.3);
        }

        .btn-orange:hover {
            box-shadow: 0 6px 20px rgba(255, 95, 0, 0.4);
            transform: translateY(-1px);
        }

        /* Animation */
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

<body class="min-h-screen flex">

    <div class="flex flex-1 min-h-screen">

        {{-- LEFT PANEL (INFO & STATS) --}}
        <div
            class="hidden md:flex flex-1/2 lg:w-2/3 bg-white p-12 flex-col justify-between fade-in border-r border-slate-100">

            <div class="max-w-xl mx-auto w-full h-full flex flex-col justify-between">

                <header class="flex items-center space-x-4 mt-4">
                    <div
                        class="w-12 h-12 bg-orange-500 rounded-xl flex items-center justify-center shadow-lg shadow-orange-200">
                        <i class="fa-solid fa-tower-broadcast text-white text-xl"></i>
                    </div>
                    <div class="leading-tight">
                        <p class="text-xl font-extrabold tracking-tight text-slate-800">PT Rizkallah Boer Makmur</p>
                        <p class="text-[10px] font-bold uppercase tracking-widest text-orange-500">Premium Tower
                            Infrastructure</p>
                    </div>
                </header>

                <div class="flex-1 flex flex-col justify-center space-y-8 py-10">

                    {{-- Info Cards --}}
                    <div class="grid grid-cols-2 gap-6 w-full">
                        <div class="card-info flex items-center p-6 space-x-4 border-l-4 border-orange-500">
                            <div class="w-12 h-12 bg-orange-50 rounded-lg flex items-center justify-center">
                                <i class="fas fa-envelope text-xl text-orange-500"></i>
                            </div>
                            <div>
                                <p class="font-bold text-slate-800 text-sm">Password Recovery</p>
                                <p class="text-xs text-slate-400">Reset link akan dikirim ke email Anda</p>
                            </div>
                        </div>

                        <div class="card-info flex items-center p-6 space-x-4 border-l-4 border-blue-500">
                            <div class="w-12 h-12 bg-blue-50 rounded-lg flex items-center justify-center">
                                <i class="fas fa-shield-alt text-xl text-blue-500"></i>
                            </div>
                            <div>
                                <p class="font-bold text-slate-800 text-sm">Secure Process</p>
                                <p class="text-xs text-slate-400">Proses reset password yang aman</p>
                            </div>
                        </div>
                    </div>
                </div>

                <footer class="mt-8 text-[10px] font-bold uppercase tracking-widest text-slate-400 mb-4">
                    &copy; {{ date('Y') }} PT Rizkallah Boer Makmur • Secure Access Point
                </footer>
            </div>

        </div>

        {{-- RIGHT PANEL FORGOT PASSWORD FORM --}}
        <div
            class="w-full md:w-1/2 lg:w-1/3 bg-white flex flex-col justify-center px-10 py-16 shadow-[-20px_0_50px_rgba(0,0,0,0.03)] relative z-10">

            <div class="max-w-md mx-auto w-full">
                <div class="mb-10 text-left">
                    <h1 class="text-4xl font-extrabold mb-2 tracking-tight text-slate-900">
                        Reset <span class="text-orange-500">Password.</span>
                    </h1>
                    <p class="text-sm font-medium text-slate-400">Masukkan email untuk menerima link reset</p>
                    <div class="w-12 h-1.5 bg-orange-500 mt-4 rounded-full"></div>
                </div>

                @if (session('status'))
                    <div
                        class="bg-green-50 text-green-600 text-xs rounded-xl p-4 mb-6 border border-green-100 flex items-center">
                        <i class="fas fa-check-circle mr-2"></i> {{ session('status') }}
                    </div>
                @endif

                @if ($errors->any())
                    <div
                        class="bg-red-50 text-red-600 text-xs rounded-xl p-4 mb-6 border border-red-100 flex flex-col gap-1">
                        @foreach ($errors->all() as $error)
                            <div><i class="fas fa-circle-exclamation mr-2"></i> {{ $error }}</div>
                        @endforeach
                    </div>
                @endif

                <form method="POST" action="{{ route('password.email') }}" class="space-y-5">
                    @csrf

                    <div class="space-y-2">
                        <label class="text-[10px] font-bold uppercase tracking-widest text-slate-400 ml-1">Email
                            Address</label>
                        <div class="relative">
                            <span class="absolute inset-y-0 left-4 flex items-center text-slate-400">
                                <i class="fa-solid fa-envelope-open"></i>
                            </span>
                            <input name="email" type="email" value="{{ old('email') }}"
                                class="w-full rounded-xl py-4 pl-12 pr-4 input-light font-medium focus:ring-0 text-sm"
                                placeholder="name@company.com" required autofocus>
                        </div>
                    </div>

                    <button type="submit"
                        class="w-full py-4 rounded-xl btn-orange font-extrabold text-sm tracking-widest uppercase transition-all duration-300">
                        Send Reset Link <i class="fa-solid fa-paper-plane ml-2"></i>
                    </button>
                </form>

                <div class="text-center mt-10 space-y-4">
                    <a href="{{ route('login') }}"
                        class="text-sm font-bold text-slate-400 hover:text-orange-500 transition-colors">
                        <i class="fa-solid fa-arrow-left mr-2"></i> Back to Login
                    </a>
                    <p class="text-[10px] font-bold text-slate-300 uppercase tracking-[0.2em]">Secured by RBM Node
                    </p>
                </div>
            </div>
        </div>

    </div>

</body>

</html>
