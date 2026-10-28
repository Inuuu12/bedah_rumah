<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full bg-slate-50">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Admin Panel') • Bedah Rumah Kab. Bogor</title>

    <!-- Favicon -->
    <link rel="icon" type="image/svg+xml" href="/images/lambang-kabupaten-bogor.svg">

    <!-- Fonts: Poppins via Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,300;0,400;0,500;0,600;0,700;0,800&display=swap" rel="stylesheet">

    <!-- Styles / Scripts via Vite or Tailwind CDN fallback -->
    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @else
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
        [x-cloak] { display: none !important; }
        .sidebar-logo-img {
            width: 36px !important;
            height: 45px !important;
            max-width: 36px !important;
            max-height: 45px !important;
            object-fit: contain !important;
            display: inline-block !important;
            flex-shrink: 0 !important;
        }
        /* Custom sleek scrollbar for sidebar */
        aside::-webkit-scrollbar {
            width: 4px;
        }
        aside::-webkit-scrollbar-track {
            background: rgba(15, 23, 42, 0.6);
        }
        aside::-webkit-scrollbar-thumb {
            background: rgba(51, 65, 85, 0.8);
            border-radius: 4px;
        }
        aside::-webkit-scrollbar-thumb:hover {
            background: rgba(16, 185, 129, 0.6);
        }
    </style>
</head>
<body class="min-h-screen bg-slate-50 text-slate-800 antialiased font-sans selection:bg-emerald-500 selection:text-white">

    {{-- Mobile Header --}}
    <div class="md:hidden bg-slate-900 text-white px-4 py-3 flex items-center justify-between border-b border-slate-800 sticky top-0 z-40">
        <div class="flex items-center gap-3">
            <img src="/images/lambang-kabupaten-bogor.svg" alt="Kabupaten Bogor" class="sidebar-logo-img" style="width: 28px; height: 35px; max-width: 28px; max-height: 35px;">
            <div>
                <span class="block text-xs font-bold tracking-tight text-white leading-tight">Admin Bedah Rumah</span>
                <span class="block text-[10px] text-emerald-400 font-medium">Kabupaten Bogor</span>
            </div>
        </div>
        <button
            type="button"
            onclick="toggleMobileSidebar()"
            class="p-2 rounded-lg bg-slate-800 text-slate-300 hover:text-white hover:bg-slate-700 focus:outline-none transition-colors"
            aria-label="Toggle Menu"
        >
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
            </svg>
        </button>
    </div>

    {{-- Backdrop for Mobile Sidebar --}}
    <div id="sidebar-backdrop" onclick="toggleMobileSidebar()" class="fixed inset-0 bg-slate-950/70 backdrop-blur-xs z-45 hidden md:hidden transition-opacity"></div>

    {{-- Sidebar Navigation (Fixed on Desktop, Off-canvas on Mobile) --}}
    <aside id="admin-sidebar" class="fixed inset-y-0 left-0 w-64 bg-slate-900 text-slate-300 flex flex-col justify-between border-r border-slate-800/80 z-50 transform -translate-x-full md:translate-x-0 transition-transform duration-300 ease-in-out shrink-0 overflow-y-auto shadow-2xl md:shadow-none">

        <div>
            {{-- Brand / Identity --}}
            <div class="p-5 border-b border-slate-800/80 flex items-center gap-3.5 bg-slate-950/40">
                <div class="w-10 h-10 rounded-xl bg-slate-800/80 border border-slate-700/60 flex items-center justify-center shrink-0 p-1 shadow-inner">
                    <img src="/images/lambang-kabupaten-bogor.svg" alt="Lambang Kabupaten Bogor" class="sidebar-logo-img drop-shadow" style="width: 32px; height: 40px; max-width: 32px; max-height: 40px;">
                </div>
                <div class="min-w-0">
                    <h1 class="text-sm font-extrabold text-white tracking-tight leading-tight truncate">BEDAH RUMAH</h1>
                    <div class="flex items-center gap-1.5 mt-0.5">
                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-400 animate-pulse"></span>
                        <p class="text-[11px] text-emerald-400 font-medium truncate">Kabupaten Bogor</p>
                    </div>
                    <p class="text-[11px] text-emerald-400 font-medium truncate mt-0.5">Kabupaten Bogor</p>
                </div>
            </div>

            {{-- Navigation Menu --}}
            <nav class="p-3 space-y-1.5 text-xs">
                <div class="px-3 pt-3 pb-1 text-[10px] font-semibold text-slate-400 uppercase tracking-wider">
                    Menu Utama
                </div>

                {{-- Dashboard Link --}}
                <a
                    href="{{ route('admin.dashboard') }}"
                    class="group relative flex items-center justify-between px-3.5 py-2.5 rounded-xl font-medium transition-all duration-200 {{ request()->routeIs('admin.dashboard') ? 'bg-gradient-to-r from-emerald-600 to-teal-600 text-white shadow-md shadow-emerald-950/30' : 'text-slate-300 hover:bg-slate-800/80 hover:text-white' }}"
                >
                    <div class="flex items-center gap-3">
                        <svg class="w-4 h-4 shrink-0 transition-transform group-hover:scale-110 {{ request()->routeIs('admin.dashboard') ? 'text-white' : 'text-emerald-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                        </svg>
                        <span>Ringkasan Dashboard</span>
                    </div>
                    @if (request()->routeIs('admin.dashboard'))
                        <span class="w-1.5 h-1.5 rounded-full bg-white animate-ping"></span>
                    @endif
                </a>

                {{-- Data BNBA Link --}}
                <a
                    href="{{ route('admin.bnba') }}"
                    class="group relative flex items-center justify-between px-3.5 py-2.5 rounded-xl font-medium transition-all duration-200 {{ request()->routeIs('admin.bnba*') ? 'bg-gradient-to-r from-emerald-600 to-teal-600 text-white shadow-md shadow-emerald-950/30' : 'text-slate-300 hover:bg-slate-800/80 hover:text-white' }}"
                >
                    <div class="flex items-center gap-3">
                        <svg class="w-4 h-4 shrink-0 transition-transform group-hover:scale-110 {{ request()->routeIs('admin.bnba*') ? 'text-white' : 'text-emerald-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                        </svg>
                        <span>Data BNBA Penerima</span>
                    </div>
                    <span class="text-[10px] px-1.5 py-0.5 rounded-full {{ request()->routeIs('admin.bnba*') ? 'bg-white/20 text-white' : 'bg-slate-800 text-slate-400 group-hover:text-slate-200' }} font-mono">11.2k</span>
                </a>

                {{-- Rekapitulasi Wilayah Link --}}
                <a
                    href="{{ route('admin.wilayah') }}"
                    class="group relative flex items-center justify-between px-3.5 py-2.5 rounded-xl font-medium transition-all duration-200 {{ request()->routeIs('admin.wilayah*') ? 'bg-gradient-to-r from-emerald-600 to-teal-600 text-white shadow-md shadow-emerald-950/30' : 'text-slate-300 hover:bg-slate-800/80 hover:text-white' }}"
                >
                    <div class="flex items-center gap-3">
                        <svg class="w-4 h-4 shrink-0 transition-transform group-hover:scale-110 {{ request()->routeIs('admin.wilayah*') ? 'text-white' : 'text-emerald-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                        </svg>
                        <span>Rekap Wilayah</span>
                    </div>
                    <span class="text-[10px] px-1.5 py-0.5 rounded-full {{ request()->routeIs('admin.wilayah*') ? 'bg-white/20 text-white' : 'bg-slate-800 text-slate-400 group-hover:text-slate-200' }} font-mono">40 Kec</span>
                </a>

                <div class="px-3 pt-5 pb-1 text-[10px] font-semibold text-slate-400 uppercase tracking-wider">
                    Akses Publik
                </div>

                {{-- Kembali ke Web / Peta Publik --}}
                <a
                    href="{{ route('home') }}"
                    target="_blank"
                    class="group flex items-center justify-between px-3.5 py-2.5 rounded-xl text-slate-400 hover:bg-slate-800/80 hover:text-slate-200 transition-all duration-200"
                >
                    <div class="flex items-center gap-3">
                        <svg class="w-4 h-4 shrink-0 text-slate-400 group-hover:text-amber-400 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/>
                        </svg>
                        <span>Lihat Peta Publik</span>
                    </div>
                    <span class="text-[10px] bg-slate-800/80 text-slate-400 group-hover:text-slate-200 px-2 py-0.5 rounded-md border border-slate-700/50">Tab baru &nearr;</span>
                </a>
            </nav>
        </div>

        {{-- Footer Sidebar: User Profile & Logout --}}
        <div class="p-3.5 border-t border-slate-800/80 bg-slate-950/60">
            <div class="p-2.5 rounded-xl bg-slate-900/90 border border-slate-800/80 flex items-center gap-3">
                <div class="relative shrink-0">
                    <div class="w-9 h-9 rounded-xl bg-gradient-to-br from-emerald-500 to-teal-700 text-white font-bold text-xs flex items-center justify-center shadow-md">
                        {{ substr(Auth::user()->name ?? 'A', 0, 1) }}
                    </div>
                    <span class="absolute -bottom-0.5 -right-0.5 w-2.5 h-2.5 bg-emerald-400 rounded-full border-2 border-slate-900"></span>
                </div>
                <div class="flex-1 min-w-0">
                    <p class="text-xs font-semibold text-white truncate">
                        {{ Auth::user()->name ?? 'Administrator' }}
                    </p>
                    <p class="text-[10px] text-slate-400 truncate">
                        {{ Auth::user()->email ?? 'admin@bogorkab.go.id' }}
                    </p>
                </div>
            </div>

            <form action="{{ route('logout') }}" method="POST" class="mt-2.5">
                @csrf
                <button
                    type="submit"
                    class="w-full flex items-center justify-center gap-2 px-3 py-2 text-xs font-semibold text-rose-400 hover:text-white hover:bg-rose-600/20 active:bg-rose-600/30 rounded-xl transition-all duration-200 border border-rose-900/40 hover:border-rose-700/60 group"
                >
                    <svg class="w-4 h-4 transition-transform group-hover:-translate-x-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                    </svg>
                    <span>Keluar Sistem</span>
                </button>
            </form>
        </div>
    </aside>

    {{-- Main Content Area (Offset by 64 Tailwind spacing units on desktop) --}}
    <div class="md:pl-64 flex flex-col min-h-screen min-w-0 bg-slate-50 transition-all duration-300">

        {{-- Topbar --}}
        <header class="bg-white/95 backdrop-blur-md border-b border-slate-200/80 px-4 sm:px-6 py-3.5 sticky top-0 z-30 flex items-center justify-between shadow-xs">
            <div>
                <h2 class="text-base sm:text-lg font-bold text-slate-900 tracking-tight flex items-center gap-2">
                    @yield('header_title', 'Dashboard')
                </h2>
                <p class="text-xs text-slate-500">
                    @yield('header_subtitle', 'Panel Kontrol Pelayanan Bedah Rumah Kabupaten Bogor')
                </p>
            </div>

            <div class="flex items-center gap-3">
                <div class="hidden md:flex items-center gap-1.5 text-xs text-slate-500 bg-slate-100/90 border border-slate-200 px-3 py-1.5 rounded-full font-medium">
                    <svg class="w-3.5 h-3.5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                    </svg>
                    <span>Kab. Bogor &bull; TA 2024–2026</span>
                </div>
            </div>
        </header>

        {{-- Alerts --}}
        @if (session('status'))
            <div class="mx-4 sm:mx-6 mt-4 p-3.5 rounded-xl bg-emerald-50 border border-emerald-200 text-xs text-emerald-800 font-medium flex items-center gap-2">
                <svg class="w-4 h-4 shrink-0 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                </svg>
                <span>{{ session('status') }}</span>
            </div>
        @endif

        @if (isset($errors) && $errors->any())
            <div class="mx-4 sm:mx-6 mt-4 p-3.5 rounded-xl bg-rose-50 border border-rose-200 text-xs text-rose-800 font-medium space-y-1">
                <div class="font-bold flex items-center gap-1.5">
                    <svg class="w-4 h-4 shrink-0 text-rose-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                    </svg>
                    <span>Perhatian</span>
                </div>
                @foreach ($errors->all() as $err)
                    <p class="pl-5 text-[11px]">{{ $err }}</p>
                @endforeach
            </div>
        @endif

        {{-- Page Body --}}
        <main class="flex-1 p-4 sm:p-6 max-w-7xl w-full">
            @yield('content')
        </main>

        {{-- Minimal Footer --}}
        <footer class="px-6 py-3 border-t border-slate-200/80 bg-white text-[11px] text-slate-500 flex flex-col sm:flex-row items-center justify-between gap-2">
            <span>&copy; {{ date('Y') }} Dinas Perumahan, Kawasan Permukiman dan Pertanahan Kabupaten Bogor.</span>
            <span class="text-slate-400">Sistem Informasi Bedah Rumah (v1.0)</span>
        </footer>
    </div>

    {{-- Script toggle sidebar mobile --}}
    <script>
        function toggleMobileSidebar() {
            const sidebar = document.getElementById('admin-sidebar');
            const backdrop = document.getElementById('sidebar-backdrop');
            sidebar.classList.toggle('-translate-x-full');
            backdrop.classList.toggle('hidden');
        }
    </script>
    @stack('scripts')
</body>
</html>
