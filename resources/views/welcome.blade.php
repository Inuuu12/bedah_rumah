<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" id="app-html">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Bedah Rumah • Portal Pelayanan & Peta Sebaran RTLH Kabupaten Bogor</title>
    <meta name="description" content="Sistem Informasi Pelayanan Bedah Rumah dan Pemetaan Sebaran Rumah Tidak Layak Huni (RTLH) Pemerintah Kabupaten Bogor.">

    <!-- Favicon - Lambang Tegar Beriman -->
    <link rel="icon" type="image/svg+xml" href="/images/lambang-kabupaten-bogor.svg">

    <!-- Fonts: Poppins via Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,400;1,600&display=swap" rel="stylesheet">

    <!-- Leaflet CSS & JS for Map -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin=""/>
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>

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
            background-color: #f8fafc;
        }

        /* Leaflet popup customization */
        .leaflet-popup-content-wrapper {
            border-radius: 14px;
            box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.15);
            padding: 2px;
            font-family: 'Poppins', sans-serif;
        }
        .leaflet-popup-content {
            margin: 12px 14px;
            line-height: 1.4;
        }
        /* Leaflet tooltip customization */
        .leaflet-tooltip {
            background: rgba(255, 255, 255, 0.96);
            backdrop-filter: blur(4px);
            border: 1px solid rgba(148, 163, 184, 0.4);
            border-radius: 8px;
            box-shadow: 0 6px 16px -2px rgba(0, 0, 0, 0.12);
            padding: 5px 9px;
            font-family: 'Poppins', sans-serif;
        }
    </style>
</head>
<body class="bg-slate-50 text-slate-900 min-h-screen flex flex-col antialiased">

    {{-- 1. Navbar Kabupaten Bogor --}}
    @include('components.navbar')
    {{-- 2. Hero Section + Watermark + 2 Floating Cards --}}
    @include('components.hero-top')

    {{-- 3. Peta Wilayah & Tabel Sebaran RTLH Kab. Bogor (Berdampingan) --}}
    @include('components.peta-wilayah')

    {{-- 4. Dokumentasi Realisasi Bedah Rumah --}}
    @include('components.dokumentasi')

    {{-- Footer Hijau Solid --}}
    <footer class="mt-auto py-8 bg-teal-800 text-teal-100 text-xs border-t border-teal-700">
        <div class="w-full max-w-7xl mx-auto px-6 sm:px-10 lg:px-16 xl:px-20 flex flex-col sm:flex-row items-center justify-between gap-4">
            <div class="flex items-center gap-2.5">
                <img src="/images/lambang-kabupaten-bogor.svg" alt="Kabupaten Bogor" class="h-6 w-auto drop-shadow-sm">
                <span class="font-bold text-white tracking-wide">BEDAH RUMAH</span>
                <span class="text-teal-200"> Pemerintah Kabupaten Bogor &copy; {{ date('Y') }}</span>
            </div>
            <div class="flex items-center gap-4 text-[11px] font-semibold text-teal-100">
                <a href="#peta-wilayah" class="hover:text-white transition-colors">Peta Wilayah</a>
                <a href="#dokumentasi" class="hover:text-white transition-colors">Dokumentasi</a>
                <a href="#app-html" class="hover:text-white transition-colors">Kembali ke Atas </a>
            </div>
        </div>
    </footer>
</body>
</html>
