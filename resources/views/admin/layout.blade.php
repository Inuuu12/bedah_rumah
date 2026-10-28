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
    </style>
</head>
<body class="h-full text-slate-800 flex flex-col md:flex-row antialiased overflow-x-hidden">

    {{-- Mobile Header --}}
    <div class="md:hidden bg-slate-900 text-white px-4 py-3 flex items-center justify-between border-b border-slate-800 sticky top-0 z-40">
        <div class="flex items-center gap-2.5">
            <img src="/images/lambang-kabupaten-bogor.svg" alt="Kabupaten Bogor" class="h-8 w-auto">
            <div>
                <span class="block text-xs font-bold tracking-tight text-white leading-tight">Admin Bedah Rumah</span>
                <span class="block text-[10px] text-slate-400">Kabupaten Bogor</span>
            </div>
        </div>
        <button 
            type="button" 
            onclick="toggleMobileSidebar()" 
            class="p-2 rounded-lg bg-slate-800 text-slate-300 hover:text-white focus:outline-none"
            aria-label="Toggle Menu"
        >
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
            </svg>
        </button>
    </div>

    {{-- Backdrop for Mobile Sidebar --}}
    <div id="sidebar-backdrop" onclick="toggleMobileSidebar()" class="fixed inset-0 bg-slate-900/50 backdrop-blur-xs z-40 hidden md:hidden"></div>

    {{-- Sidebar Navigation --}}
    <aside id="admin-sidebar" class="fixed md:sticky top-0 left-0 h-screen w-64 bg-slate-900 text-slate-300 flex flex-col justify-between border-r border-slate-800 z-50 transform -translate-x-full md:translate-x-0 transition-transform duration-200 ease-in-out shrink-0">
        
        <div>
            {{-- Brand / Identity --}}
            <div class="p-5 border-b border-slate-800 flex items-center gap-3">
                <img src="/images/lambang-kabupaten-bogor.svg" alt="Lambang Kabupaten Bogor" class="h-10 w-auto shrink-0 drop-shadow-sm">
                <div>
                    <h1 class="text-sm font-bold text-white tracking-tight leading-tight">BEDAH RUMAH</h1>
                    <p class="text-[11px] text-emerald-400 font-medium">Kabupaten Bogor</p>
                </div>
            </div>

            {{-- Navigation Menu --}}
            <nav class="p-3 space-y-1 text-xs">
                <div class="px-3 pt-3 pb-1 text-[10px] font-semibold text-slate-400 uppercase tracking-wider">
                    Menu Utama
                </div>

                {{-- Dashboard Link --}}
                <a 
                    href="{{ route('admin.dashboard') }}" 
                    class="flex items-center gap-3 px-3 py-2.5 rounded-lg font-medium transition-colors {{ request()->routeIs('admin.dashboard') ? 'bg-emerald-600 text-white shadow-xs' : 'text-slate-300 hover:bg-slate-800 hover:text-white' }}"
                >
                    <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                    </svg>
                    <span>Ringkasan Dashboard</span>
                </a>

                {{-- Data BNBA Link --}}
                <a 
                    href="{{ route('admin.bnba') }}" 
                    class="flex items-center gap-3 px-3 py-2.5 rounded-lg font-medium transition-colors {{ request()->routeIs('admin.bnba*') ? 'bg-emerald-600 text-white shadow-xs' : 'text-slate-300 hover:bg-slate-800 hover:text-white' }}"
                >
                    <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                    </svg>
                    <span>Data BNBA Penerima</span>
                </a>

                {{-- Rekapitulasi Wilayah Link --}}
                <a 
                    href="{{ route('admin.wilayah') }}" 
                    class="flex items-center gap-3 px-3 py-2.5 rounded-lg font-medium transition-colors {{ request()->routeIs('admin.wilayah*') ? 'bg-emerald-600 text-white shadow-xs' : 'text-slate-300 hover:bg-slate-800 hover:text-white' }}"
                >
                    <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                    </svg>
                    <span>Rekap Wilayah (40 Kec)</span>
                </a>

                <div class="px-3 pt-5 pb-1 text-[10px] font-semibold text-slate-400 uppercase tracking-wider">
                    Akses Publik
                </div>

                {{-- Kembali ke Web / Peta Publik --}}
                <a 
                    href="{{ route('home') }}" 
                    target="_blank" 
                    class="flex items-center justify-between px-3 py-2.5 rounded-lg text-slate-400 hover:bg-slate-800 hover:text-slate-200 transition-colors"
                >
                    <div class="flex items-center gap-3">
                        <svg class="w-4 h-4 shrink-0 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/>
                        </svg>
                        <span>Lihat Peta Publik</span>
                    </div>
                    <span class="text-[10px] bg-slate-800 text-slate-300 px-1.5 py-0.5 rounded">Tab baru</span>
                </a>
            </nav>
        </div>

        {{-- Footer Sidebar: User Profile & Logout --}}
        <div class="p-3 border-t border-slate-800 bg-slate-950/40">
            <div class="flex items-center gap-3 px-2 py-2">
                <div class="w-8 h-8 rounded-full bg-emerald-700 text-white flex items-center justify-center font-bold text-xs uppercase shadow-xs">
                    {{ substr(Auth::user()->name ?? 'A', 0, 1) }}
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

            <form action="{{ route('logout') }}" method="POST" class="mt-2">
                @csrf
                <button 
                    type="submit" 
                    class="w-full flex items-center justify-center gap-2 px-3 py-2 text-xs font-medium text-rose-400 hover:text-white hover:bg-rose-600/20 rounded-lg transition-colors border border-rose-900/30"
                >
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                    </svg>
                    <span>Keluar Sistem</span>
                </button>
            </form>
        </div>
    </aside>

    {{-- Main Content Area --}}
    <div class="flex-1 flex flex-col min-h-screen min-w-0 bg-slate-50">
        
        {{-- Topbar --}}
        <header class="bg-white border-b border-slate-200/90 px-4 sm:px-6 py-3.5 sticky top-0 z-30 flex items-center justify-between">
            <div>
                <h2 class="text-base sm:text-lg font-bold text-slate-900 tracking-tight">
                    @yield('header_title', 'Dashboard')
                </h2>
                <p class="text-xs text-slate-500">
                    @yield('header_subtitle', 'Panel Kontrol Pelayanan Bedah Rumah Kabupaten Bogor')
                </p>
            </div>

            <div class="flex items-center gap-3">
                <div class="hidden sm:flex items-center gap-1.5 px-3 py-1 bg-slate-100 rounded-full border border-slate-200 text-xs font-medium text-slate-600">
                    <span class="w-2 h-2 rounded-full bg-emerald-500"></span>
                    <span>Database Aktif (MySQL)</span>
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
