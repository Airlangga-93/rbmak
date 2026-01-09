<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Login Admin - Tower Management</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="icon" type="image/png" href="{{ asset('assets/img/image.png') }}">
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

        .password-toggle:hover {
            color: var(--accent-orange);
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
                        <p class="text-xl font-extrabold tracking-tight text-slate-800">PT Rizqallah Boer Makmur</p>
                        <p class="text-[10px] font-bold uppercase tracking-widest text-orange-500">Premium Tower
                            Infrastructure</p>
                    </div>
                </header>

                <div class="flex-1 flex flex-col justify-center space-y-8 py-10">

                    {{-- Image Card (Hero) --}}
                    <div
                        class="relative w-full h-[320px] rounded-[2rem] overflow-hidden shadow-2xl border border-slate-100 bg-[#0F172A]">
                        <img src="{{ asset('assets/img/bgtower.jpg') }}" alt="Hero"
                            class="w-full h-full object-cover object-center scale-105 transition-transform duration-500">

                        {{-- Overlay Gradient dipertebal di bawah agar teks putih tetap kontras --}}
                        <div
                            class="absolute inset-0 bg-gradient-to-t from-slate-900/90 via-slate-900/30 to-transparent">
                        </div>

                        <div class="absolute bottom-0 left-0 p-8 text-white z-10">
                            <span
                                class="bg-orange-600 text-[10px] font-bold px-3 py-1 rounded-full uppercase mb-3 inline-block">
                                System Active
                            </span>
                            <p class="text-3xl font-bold tracking-tight">Real-Time Monitoring</p>
                            <p class="text-sm mt-1 text-slate-200 font-light">
                                Akses terpusat kendali infrastruktur menara.
                            </p>
                            <a href="#"
                                class="text-sm font-bold mt-4 inline-flex items-center text-orange-400 hover:text-orange-300 transition-colors">
                                <i class="fa-solid fa-circle-dot mr-2 animate-pulse"></i> Cek Status Jaringan
                            </a>
                        </div>
                    </div>

                    {{-- Info Cards --}}
                    <div class="grid grid-cols-2 gap-6 w-full">
                        <div class="card-info flex items-center p-6 space-x-4 border-l-4 border-orange-500">
                            <div class="w-12 h-12 bg-orange-50 rounded-lg flex items-center justify-center">
                                <i class="fas fa-globe text-xl text-orange-500"></i>
                            </div>
                            <div>
                                <p class="font-bold text-slate-800 text-sm">Main Website</p>
                                <a href="/"
                                    class="text-xs font-semibold text-slate-400 hover:text-orange-500 transition-all">
                                    <i class="fa-solid fa-arrow-left mr-1"></i> Kembali
                                </a>
                            </div>
                        </div>

                        <div class="card-info flex items-center p-6 space-x-4 border-l-4 border-blue-500">
                            <div class="w-12 h-12 bg-blue-50 rounded-lg flex items-center justify-center">
                                <i class="fas fa-headset text-xl text-blue-500"></i>
                            </div>
                            <div>
                                <p class="font-bold text-slate-800 text-sm">Tech Support</p>
                                <a href="#"
                                    class="text-xs font-semibold text-slate-400 hover:text-blue-500 transition-all">
                                    <i class="fa-solid fa-phone mr-1"></i> Hubungi Kami
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

                <footer class="mt-8 text-[10px] font-bold uppercase tracking-widest text-slate-400 mb-4">
                    &copy; {{ date('Y') }} PT Rizqallah Boer Makmur • Secure Access Point
                </footer>
            </div>

        </div>

        {{-- RIGHT PANEL LOGIN FORM --}}
        <div
            class="w-full md:w-1/2 lg:w-1/3 bg-white flex flex-col justify-center px-10 py-16 shadow-[-20px_0_50px_rgba(0,0,0,0.03)] relative z-10">

            <div class="max-w-md mx-auto w-full">
                <div class="mb-10 text-left">
                    <h1 class="text-4xl font-extrabold mb-2 tracking-tight text-slate-900">
                        Sign <span class="text-orange-500">In.</span>
                    </h1>
                    <p class="text-sm font-medium text-slate-400">Otorisasi Administrator Tower</p>
                    <div class="w-12 h-1.5 bg-orange-500 mt-4 rounded-full"></div>
                </div>

                @if ($errors->any())
                    <div
                        class="bg-red-50 text-red-600 text-xs rounded-xl p-4 mb-6 border border-red-100 flex flex-col gap-1">
                        @foreach ($errors->all() as $error)
                            <div><i class="fas fa-circle-exclamation mr-2"></i> {{ $error }}</div>
                        @endforeach
                    </div>
                @endif

                <form method="POST" action="{{ route('login.post') }}" class="space-y-5">
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

                    <div class="space-y-2">
                        <div class="flex justify-between items-center px-1">
                            <label class="text-[10px] font-bold uppercase tracking-widest text-slate-400">Security
                                Password</label>
                            <a href="{{ route('password.request') }}"
                                class="text-[10px] font-bold text-orange-500 hover:underline">FORGOT?</a>
                        </div>
                        <div class="relative">
                            <span class="absolute inset-y-0 left-4 flex items-center text-slate-400">
                                <i class="fa-solid fa-shield-lock"></i>
                            </span>
                            <input name="password" id="password_field" type="password"
                                class="w-full rounded-xl py-4 pl-12 pr-12 input-light font-medium focus:ring-0 text-sm"
                                placeholder="••••••••" required>
                            <span class="absolute inset-y-0 right-4 flex items-center text-slate-400 password-toggle"
                                onclick="togglePasswordVisibility()">
                                <i id="toggleIcon" class="fa-solid fa-eye text-sm"></i>
                            </span>
                        </div>
                    </div>

                    <div class="flex items-center py-2">
                        <label class="flex items-center group cursor-pointer">
                            <input type="checkbox" name="remember"
                                class="h-4 w-4 border-slate-200 rounded text-orange-500 focus:ring-orange-500/20">
                            <span
                                class="ml-3 text-xs font-bold text-slate-400 group-hover:text-slate-600 transition-colors">Keep
                                me logged in</span>
                        </label>
                    </div>

                    <button type="submit"
                        class="w-full py-4 rounded-xl btn-orange font-extrabold text-sm tracking-widest uppercase transition-all duration-300">
                        Initialize Access <i class="fa-solid fa-arrow-right ml-2"></i>
                    </button>
                </form>

                <div class="text-center mt-10">
                    <p class="text-[10px] font-bold text-slate-300 uppercase tracking-[0.2em]">Secured by RBM Node</p>
                </div>
            </div>
        </div>

    </div>

    <script>
        function togglePasswordVisibility() {
            const passwordField = document.getElementById('password_field');
            const toggleIcon = document.getElementById('toggleIcon');

            if (passwordField.type === 'password') {
                passwordField.type = 'text';
                toggleIcon.classList.replace('fa-eye', 'fa-eye-slash');
            } else {
                passwordField.type = 'password';
                toggleIcon.classList.replace('fa-eye-slash', 'fa-eye');
            }
        }
    </script>
</body>

</html>
