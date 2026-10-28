<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login Administrator • Bedah Rumah Kabupaten Bogor</title>
    <meta name="description" content="Masuk ke Panel Administrator Sistem Informasi Pelayanan Bedah Rumah Kabupaten Bogor.">

    <!-- Favicon - Lambang Tegar Beriman -->
    <link rel="icon" type="image/svg+xml" href="{{ asset('images/lambang-kabupaten-bogor.svg') }}">

    <!-- Fonts: Poppins via Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,400;1,600&display=swap" rel="stylesheet">

    <!-- Styles / Scripts via Vite -->
    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @else
        <!-- Fallback Tailwind CSS CDN -->
        <script src="https://cdn.tailwindcss.com"></script>
        <script>
            tailwind.config = {
                theme: {
                    extend: {
                        fontFamily: {
                            sans: ['Poppins', 'ui-sans-serif', 'system-ui', 'sans-serif'],
                        }
                    }
                }
            }
        </script>
    @endif

    <style>
        body {
            font-family: 'Poppins', sans-serif;
            -webkit-font-smoothing: antialiased;
        }
    </style>
</head>
<body class="h-full bg-slate-50 text-slate-800 flex flex-col justify-between antialiased">

    {{-- Main Login Card --}}
    <main class="w-full max-w-md mx-auto px-6 py-4 flex-1 flex flex-col justify-center">
        <div class="bg-white rounded-2xl border border-slate-200/90 shadow-sm p-6 sm:p-8">
            
            {{-- Header Card --}}
            <div class="text-center">
                <a href="{{ url('/') }}" class="inline-block mb-3">
                    <img src="{{ asset('images/lambang-kabupaten-bogor.svg') }}" alt="Lambang Kabupaten Bogor" class="h-16 w-auto mx-auto drop-shadow-xs" width="50" height="64" style="height: 64px; width: auto; max-width: 50px; object-fit: contain;">
                </a>
                <h1 class="text-lg sm:text-xl font-extrabold text-slate-900 tracking-tight">
                    Login Admin
                </h1>
                <p class="text-xs text-slate-500 mt-1">
                    Sistem Informasi Bedah Rumah (RTLH &amp; BSPS)
                </p>
            </div>

            {{-- Error / Status Alert --}}
            @if ($errors->any())
                <div class="mt-5 p-3 rounded-xl bg-rose-50 border border-rose-200 text-xs text-rose-700 font-medium space-y-1">
                    <div class="font-bold flex items-center gap-1.5">
                        <svg class="w-4 h-4 shrink-0 text-rose-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                        </svg>
                        <span>Gagal Masuk</span>
                    </div>
                    @foreach ($errors->all() as $error)
                        <p class="text-[11px] pl-5">{{ $error }}</p>
                    @endforeach
                </div>
            @endif

            @if (session('status'))
                <div class="mt-5 p-3 rounded-xl bg-emerald-50 border border-emerald-200 text-xs text-emerald-800 font-medium">
                    {{ session('status') }}
                </div>
            @endif

            {{-- Form Login --}}
            <form action="{{ route('login.post') }}" method="POST" class="mt-6 space-y-4">
                @csrf

                {{-- Input Email / Username --}}
                <div>
                    <label for="email" class="block text-xs font-bold text-slate-700 mb-1.5">
                        Email atau Username
                    </label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-slate-400">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                            </svg>
                        </div>
                        <input 
                            type="text" 
                            name="email" 
                            id="email" 
                            value="{{ old('email') }}" 
                            required 
                            autofocus 
                            placeholder="admin@bogorkab.go.id" 
                            class="w-full text-xs bg-white border border-slate-300 rounded-xl pl-9 pr-3 py-2.5 text-slate-800 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-teal-600 focus:border-teal-600 transition-all font-medium"
                        >
                    </div>
                </div>

                {{-- Input Password --}}
                <div>
                    <div class="flex items-center justify-between mb-1.5">
                        <label for="password" class="block text-xs font-bold text-slate-700">
                            Kata Sandi
                        </label>
                    </div>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-slate-400">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                            </svg>
                        </div>
                        <input 
                            type="password" 
                            name="password" 
                            id="password" 
                            required 
                            placeholder="••••••••" 
                            class="w-full text-xs bg-white border border-slate-300 rounded-xl pl-9 pr-10 py-2.5 text-slate-800 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-teal-600 focus:border-teal-600 transition-all font-medium"
                        >
                        <button 
                            type="button" 
                            onclick="togglePasswordVisibility()" 
                            class="absolute inset-y-0 right-0 pr-3 flex items-center text-slate-400 hover:text-slate-600"
                            aria-label="Tampilkan kata sandi"
                        >
                            <svg id="eye-icon" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                            </svg>
                            <svg id="eye-slash-icon" class="w-4 h-4 hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l18 18"/>
                            </svg>
                        </button>
                    </div>
                </div>

                {{-- Remember Me & Info --}}
                <div class="flex items-center justify-between text-xs pt-1">
                    <label class="flex items-center gap-2 cursor-pointer select-none text-slate-600 font-medium">
                        <input type="checkbox" name="remember" class="w-4 h-4 text-teal-700 rounded border-slate-300 focus:ring-teal-600">
                        <span>Ingat saya di perangkat ini</span>
                    </label>
                </div>

                {{-- Submit Button --}}
                <div class="pt-2">
                    <button 
                        type="submit" 
                        class="w-full bg-teal-700 hover:bg-teal-800 text-white font-bold py-2.5 px-4 rounded-xl text-xs sm:text-sm shadow-xs hover:shadow-md transition-all active:scale-[0.99] flex items-center justify-center gap-2"
                    >
                        <span>Masuk </span>
                    </button>
                </div>
            </form>
        </div>
    </main>

    {{-- Footer Simple --}}
    <footer class="w-full py-4 text-center text-slate-400 text-[11px]">
        <span>&copy; {{ date('Y') }} Pemerintah Kabupaten Bogor • Bidang Perumahan</span>
    </footer>

    <script>
        function fillAdminCredentials() {
            const emailInput = document.getElementById('email');
            const passwordInput = document.getElementById('password');
            if (emailInput && passwordInput) {
                emailInput.value = 'admin';
                passwordInput.value = 'admin123';
                emailInput.focus();
            }
        }

        function togglePasswordVisibility() {
            const passwordInput = document.getElementById('password');
            const eyeIcon = document.getElementById('eye-icon');
            const eyeSlashIcon = document.getElementById('eye-slash-icon');

            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                eyeIcon.classList.add('hidden');
                eyeSlashIcon.classList.remove('hidden');
            } else {
                passwordInput.type = 'password';
                eyeIcon.classList.remove('hidden');
                eyeSlashIcon.classList.add('hidden');
            }
        }
    </script>
</body>
</html>
