<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full bg-slate-50">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Admin Panel') • Bedah Rumah Kab. Bogor</title>

    <!-- Favicon -->
    <link rel="icon" type="image/svg+xml" href="{{ asset('images/lambang-kabupaten-bogor.svg') }}">

    <!-- Fonts: Poppins via Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,300;0,400;0,500;0,600;0,700;0,800&display=swap" rel="stylesheet">

    <!-- Styles / Scripts via Vite or Tailwind CDN fallback -->
    @php
        $isLocalDev = in_array(request()->getHost(), ['localhost', '127.0.0.1']);
        $hasManifest = file_exists(public_path('build/manifest.json'));
        $hasHot = $isLocalDev && file_exists(public_path('hot'));
    @endphp
    @if ($hasManifest || $hasHot)
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
        /* Sleek custom scrollbar for white sidebar */
        aside::-webkit-scrollbar {
            width: 4px;
        }
        aside::-webkit-scrollbar-track {
            background: #f8fafc;
        }
        aside::-webkit-scrollbar-thumb {
            background: #cbd5e1;
            border-radius: 4px;
        }
        aside::-webkit-scrollbar-thumb:hover {
            background: #059669;
        }
    </style>
</head>
<body class="min-h-screen bg-slate-50 text-slate-800 antialiased font-sans selection:bg-emerald-600 selection:text-white">

    {{-- Mobile Header --}}
    <div class="md:hidden bg-white text-slate-900 px-4 py-3 flex items-center justify-between border-b border-slate-200 sticky top-0 z-40 shadow-xs">
        <div class="flex items-center gap-3">
            <img src="{{ asset('images/lambang-kabupaten-bogor.svg') }}" alt="Kabupaten Bogor" class="sidebar-logo-img" style="width: 28px; height: 35px; max-width: 28px; max-height: 35px;">
            <div>
                <span class="block text-xs font-bold tracking-tight text-slate-900 leading-tight">Admin Bedah Rumah</span>
                <span class="block text-[10px] text-emerald-600 font-semibold">Kabupaten Bogor</span>
            </div>
        </div>
        <button
            type="button"
            onclick="toggleMobileSidebar()"
            class="p-2 rounded-lg bg-slate-100 text-slate-600 hover:text-slate-900 hover:bg-slate-200 border border-slate-200 focus:outline-none transition-colors"
            aria-label="Toggle Menu"
        >
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
            </svg>
        </button>
    </div>

    {{-- Backdrop for Mobile Sidebar --}}
    <div id="sidebar-backdrop" onclick="toggleMobileSidebar()" class="fixed inset-0 bg-slate-900/40 backdrop-blur-xs z-45 hidden md:hidden transition-opacity"></div>

    {{-- Sidebar Navigation (White Theme) --}}
    <aside id="admin-sidebar" class="fixed inset-y-0 left-0 w-64 bg-white text-slate-700 flex flex-col justify-between border-r border-slate-200 z-50 transform -translate-x-full md:translate-x-0 transition-transform duration-300 ease-in-out shrink-0 overflow-y-auto shadow-xl md:shadow-none">

        <div>
            {{-- Brand / Identity --}}
            <div class="p-4 border-b border-slate-200 flex items-center gap-3 bg-white">
                <img src="{{ asset('images/lambang-kabupaten-bogor.svg') }}" alt="Lambang Kabupaten Bogor" class="sidebar-logo-img" style="width: 32px; height: 40px; max-width: 32px; max-height: 40px;">
                <div class="min-w-0">
                    <h1 class="text-xs font-bold text-slate-900 tracking-wider uppercase leading-tight truncate">BEDAH RUMAH</h1>
                    <p class="text-[11px] text-emerald-600 font-semibold truncate">Kab. Bogor</p>
                </div>
            </div>

            {{-- Navigation Menu --}}
            <nav class="p-3 space-y-1 text-xs">
                <div class="px-3 pt-2 pb-1 text-[10px] font-bold text-slate-400 uppercase tracking-wider">
                    Menu Utama
                </div>

                {{-- Dashboard Link --}}
                <a
                    href="{{ route('admin.dashboard') }}"
                    class="flex items-center justify-between px-3 py-2.5 rounded-lg font-medium transition-colors {{ request()->routeIs('admin.dashboard') ? 'bg-emerald-600 text-white font-semibold shadow-xs' : 'text-slate-600 hover:bg-slate-100 hover:text-slate-900' }}"
                >
                    <div class="flex items-center gap-2.5">
                        <svg class="w-4 h-4 shrink-0 {{ request()->routeIs('admin.dashboard') ? 'text-white' : 'text-slate-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                        </svg>
                        <span>Dashboard</span>
                    </div>
                </a>

                {{-- Rekapitulasi Wilayah Link --}}
                <a
                    href="{{ route('admin.wilayah') }}"
                    class="flex items-center justify-between px-3 py-2.5 rounded-lg font-medium transition-colors {{ request()->routeIs('admin.wilayah*') ? 'bg-emerald-600 text-white font-semibold shadow-xs' : 'text-slate-600 hover:bg-slate-100 hover:text-slate-900' }}"
                >
                    <div class="flex items-center gap-2.5">
                        <svg class="w-4 h-4 shrink-0 {{ request()->routeIs('admin.wilayah*') ? 'text-white' : 'text-slate-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                        </svg>
                        <span>Rekap Wilayah</span>
                    </div>
                </a>

                {{-- Data BNBA Link --}}
                <a
                    href="{{ route('admin.bnba') }}"
                    class="flex items-center justify-between px-3 py-2.5 rounded-lg font-medium transition-colors {{ request()->routeIs('admin.bnba*') ? 'bg-emerald-600 text-white font-semibold shadow-xs' : 'text-slate-600 hover:bg-slate-100 hover:text-slate-900' }}"
                >
                    <div class="flex items-center gap-2.5">
                        <svg class="w-4 h-4 shrink-0 {{ request()->routeIs('admin.bnba*') ? 'text-white' : 'text-slate-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                        </svg>
                        <span>Data Penerima</span>
                    </div>
                </a>

                {{-- Dokumentasi Publik / Posting Link --}}
                <a
                    href="{{ route('admin.posting.index') }}"
                    class="flex items-center justify-between px-3 py-2.5 rounded-lg font-medium transition-colors {{ request()->routeIs('admin.posting*') ? 'bg-emerald-600 text-white font-semibold shadow-xs' : 'text-slate-600 hover:bg-slate-100 hover:text-slate-900' }}"
                >
                    <div class="flex items-center gap-2.5">
                        <svg class="w-4 h-4 shrink-0 {{ request()->routeIs('admin.posting*') ? 'text-white' : 'text-slate-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                        </svg>
                        <span>Dokumentasi Publik</span>
                    </div>
                </a>
            </nav>
        </div>

        {{-- Footer Sidebar: User Profile & Logout --}}
        <div class="p-3 border-t border-slate-200 bg-slate-50/70">
            <div class="p-2.5 rounded-lg bg-white border border-slate-200 shadow-2xs flex items-center gap-2.5">
                <div class="w-8 h-8 rounded-lg bg-emerald-600 text-white font-bold text-xs flex items-center justify-center shrink-0 shadow-xs">
                    {{ substr(Auth::user()->name ?? 'A', 0, 1) }}
                </div>
                <div class="flex-1 min-w-0">
                    <p class="text-xs font-bold text-slate-800 truncate">
                        {{ Auth::user()->name ?? 'Administrator' }}
                    </p>
                    <div class="flex items-center gap-1.5 mt-0.5">
                        @if (Auth::user()?->isKecamatan())
                            <span class="inline-block px-1.5 py-0.5 rounded text-[9px] font-bold bg-blue-100 text-blue-700">Admin Kec</span>
                        @elseif (Auth::user()?->isDesa())
                            <span class="inline-block px-1.5 py-0.5 rounded text-[9px] font-bold bg-teal-100 text-teal-700">Admin Desa</span>
                        @else
                            <span class="inline-block px-1.5 py-0.5 rounded text-[9px] font-bold bg-emerald-100 text-emerald-700">Admin Inti</span>
                        @endif
                        <span class="text-[10px] text-slate-400 truncate">
                            {{ Auth::user()->email ?? 'admin@bogorkab.go.id' }}
                        </span>
                    </div>
                </div>
            </div>

            <form action="{{ route('logout') }}" method="POST" class="mt-2">
                @csrf
                <button
                    type="submit"
                    class="w-full flex items-center justify-center gap-2 px-3 py-2 text-xs font-semibold text-rose-600 hover:text-white hover:bg-rose-600 bg-white hover:border-rose-600 rounded-lg transition-colors border border-rose-200 shadow-2xs"
                >
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                    </svg>
                    <span>Keluar</span>
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
        </header>

        {{-- Alerts --}}
        @if (session('status'))
            <div class="mx-4 sm:mx-6 mt-4 p-3 rounded-lg bg-emerald-50 border border-emerald-200 text-xs text-emerald-800 font-medium flex items-center gap-2">
                <svg class="w-4 h-4 shrink-0 text-emerald-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
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
