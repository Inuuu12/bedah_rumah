<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" id="app-html">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Katalog Dokumentasi & Publikasi Bedah Rumah • Kabupaten Bogor</title>
    <meta name="description" content="Arsip lengkap dokumentasi fisik renovasi Rumah Tidak Layak Huni (RTLH) dan BSPS di seluruh Kabupaten Bogor.">

    <!-- Favicon - Lambang Tegar Beriman -->
    <link rel="icon" type="image/svg+xml" href="{{ asset('images/lambang-kabupaten-bogor.svg') }}">

    <!-- Fonts: Poppins via Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,400;1,600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- Styles / Scripts via Vite -->
    @php
        $isLocalDev = in_array(request()->getHost(), ['localhost', '127.0.0.1']);
        $hasManifest = file_exists(public_path('build/manifest.json'));
        $hasHot = $isLocalDev && file_exists(public_path('hot'));
    @endphp
    @if ($hasManifest || $hasHot)
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
        html {
            scroll-behavior: smooth;
        }

        body {
            font-family: 'Poppins', ui-sans-serif, system-ui, sans-serif;
            background-color: #f8fafc;
            color: #0f172a;
        }

        /* --- NEWS GRID & CARDS (4 Kolom / Kartu di Desktop) --- */
        .news-grid {
            display: grid;
            grid-template-columns: repeat(1, minmax(0, 1fr));
            gap: 20px;
        }

        @media (min-width: 640px) {
            .news-grid {
                grid-template-columns: repeat(2, minmax(0, 1fr));
                gap: 22px;
            }
        }

        @media (min-width: 1024px) {
            .news-grid {
                grid-template-columns: repeat(4, minmax(0, 1fr));
                gap: 22px;
            }
        }

        .news-card {
            background: #ffffff;
            border-radius: 14px;
            overflow: hidden;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.05);
            transition: all 0.25s cubic-bezier(0.16, 1, 0.3, 1);
            cursor: pointer;
            border: 1px solid #e2e8f0;
            display: flex;
            flex-direction: column;
        }

        .news-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 14px 28px rgba(13, 148, 136, 0.14);
            border-color: #99f6e4;
        }

        .card-img-wrapper {
            position: relative;
            height: 185px;
            overflow: hidden;
            background-color: #f1f5f9;
        }

        .card-img-wrapper img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.45s ease;
        }

        .news-card:hover .card-img-wrapper img {
            transform: scale(1.07);
        }

        .card-img-top-badges {
            position: absolute;
            top: 10px;
            left: 10px;
            right: 10px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 6px;
            z-index: 5;
            pointer-events: none;
        }

        .badge-date {
            background: rgba(15, 23, 42, 0.78);
            color: #ffffff;
            padding: 3.5px 8px;
            border-radius: 20px;
            font-size: 0.68rem;
            font-weight: 600;
            backdrop-filter: blur(4px);
            display: inline-flex;
            align-items: center;
            gap: 4px;
            white-space: nowrap;
            flex-shrink: 0;
        }

        .badge-status-tahap {
            padding: 3.5px 9px;
            border-radius: 20px;
            font-size: 0.68rem;
            font-weight: 700;
            backdrop-filter: blur(4px);
            display: inline-flex;
            align-items: center;
            gap: 4px;
            white-space: nowrap;
            flex-shrink: 0;
        }

        .badge-tahap-selesai {
            background: rgba(16, 185, 129, 0.92);
            color: #ffffff;
        }

        .badge-tahap-proses {
            background: rgba(14, 165, 233, 0.92);
            color: #ffffff;
        }

        .badge-tahap-persiapan {
            background: rgba(245, 158, 11, 0.92);
            color: #ffffff;
        }

        .card-body {
            padding: 16px 18px 18px;
            flex: 1;
            display: flex;
            flex-direction: column;
        }

        .badge-instansi {
            display: inline-block;
            padding: 3px 8px;
            border-radius: 6px;
            font-size: 0.7rem;
            font-weight: 700;
            letter-spacing: 0.3px;
            text-transform: uppercase;
            margin-bottom: 8px;
            align-self: flex-start;
        }

        .badge-program-rtlh {
            background-color: #f0fdf4;
            color: #047857;
            border: 1px solid #bbf7d0;
        }

        .badge-program-bsps {
            background-color: #eff6ff;
            color: #1d4ed8;
            border: 1px solid #bfdbfe;
        }

        .card-title {
            font-size: 0.92rem;
            font-weight: 700;
            color: #0f172a;
            line-height: 1.4;
            margin-bottom: 6px;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }

        .card-location {
            font-size: 0.8rem;
            color: #64748b;
            margin-bottom: 10px;
            font-weight: 500;
            display: flex;
            align-items: center;
            gap: 5px;
        }

        .card-location i {
            color: #0d9488;
        }

        .card-evidences {
            display: flex;
            flex-wrap: wrap;
            gap: 5px;
            margin-bottom: 10px;
        }

        .badge-evidence {
            font-size: 0.7rem;
            font-weight: 600;
            padding: 2.5px 7px;
            border-radius: 6px;
            display: inline-flex;
            align-items: center;
            gap: 3.5px;
        }

        .badge-pdf {
            background-color: #fef2f2;
            color: #dc2626;
            border: 1px solid #fecaca;
        }

        .badge-ig {
            background-color: #fdf2f8;
            color: #db2777;
            border: 1px solid #fbcfe8;
        }

        .badge-fb {
            background-color: #eff6ff;
            color: #1d4ed8;
            border: 1px solid #bfdbfe;
        }

        .badge-tt {
            background-color: #f8fafc;
            color: #0f172a;
            border: 1px solid #cbd5e1;
        }

        .badge-yt {
            background-color: #fef2f2;
            color: #ef4444;
            border: 1px solid #fca5a5;
        }

        .badge-foto {
            background-color: #f0fdf4;
            color: #16a34a;
            border: 1px solid #bbf7d0;
        }

        .card-text {
            font-size: 0.82rem;
            color: #64748b;
            line-height: 1.55;
            margin-bottom: 14px;
            flex: 1;
            display: -webkit-box;
            -webkit-line-clamp: 4;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }

        .card-footer-row {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-top: auto;
            padding-top: 12px;
            border-top: 1px solid #f1f5f9;
            font-size: 0.78rem;
        }

        .card-reporter {
            font-size: 0.76rem;
            color: #94a3b8;
            display: inline-flex;
            align-items: center;
            gap: 4px;
        }

        .card-reporter i {
            color: #0d9488;
        }

        .card-link {
            color: #0f766e;
            font-size: 0.84rem;
            font-weight: 700;
            display: inline-flex;
            align-items: center;
            gap: 6px;
            transition: color 0.2s ease;
        }

        .news-card:hover .card-link {
            color: #042f2e;
        }

        /* --- MODAL POPUP DETAIL (GAYA KAMI MENDENGAR) --- */
        .modal-overlay {
            position: fixed;
            top: 0; left: 0; width: 100%; height: 100%;
            background: rgba(15, 23, 42, 0.75);
            backdrop-filter: blur(6px);
            display: none;
            align-items: center;
            justify-content: center;
            z-index: 1000;
            padding: 20px;
        }

        .modal-overlay.active {
            display: flex;
        }

        .modal-content {
            background: #ffffff;
            width: 100%;
            max-width: 820px;
            max-height: 92vh;
            border-radius: 20px;
            overflow-y: auto;
            position: relative;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.35);
            animation: modalFadeIn 0.25s ease-out;
            border: 1px solid rgba(255, 255, 255, 0.2);
        }

        @keyframes modalFadeIn {
            from { opacity: 0; transform: translateY(16px) scale(0.98); }
            to { opacity: 1; transform: translateY(0) scale(1); }
        }

        .close-btn {
            position: absolute;
            top: 16px;
            right: 16px;
            width: 38px;
            height: 38px;
            border-radius: 50%;
            background: rgba(15, 23, 42, 0.7);
            color: #ffffff;
            border: none;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.1rem;
            z-index: 20;
            transition: all 0.2s ease;
        }

        .close-btn:hover {
            background: #0f172a;
            transform: scale(1.08);
        }

        .modal-img-container {
            position: relative;
            width: 100%;
            height: 360px;
            background-color: #0f172a;
            overflow: hidden;
        }

        .modal-active-stage-badge {
            position: absolute;
            top: 14px;
            left: 14px;
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 0.72rem;
            font-weight: 700;
            backdrop-filter: blur(6px);
            z-index: 10;
            display: inline-flex;
            align-items: center;
            gap: 6px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.25);
        }

        .modal-img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            display: block;
            transition: opacity 0.2s ease;
        }

        .modal-gallery-wrapper {
            padding: 14px 28px 16px;
            background: #f8fafc;
            border-bottom: 1px solid #e2e8f0;
        }

        .modal-gallery-title {
            font-size: 0.76rem;
            font-weight: 700;
            color: #475569;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-bottom: 10px;
            display: flex;
            align-items: center;
            gap: 6px;
        }

        .modal-gallery-stages-container {
            display: flex;
            flex-direction: column;
            gap: 8px;
        }

        .stage-gallery-block {
            background: #ffffff;
            border: 1px solid #e2e8f0;
            border-radius: 10px;
            padding: 8px 12px;
            display: flex;
            flex-direction: column;
            gap: 8px;
        }

        @media (min-width: 640px) {
            .stage-gallery-block {
                flex-direction: row;
                align-items: center;
                gap: 14px;
            }
        }

        .stage-gallery-header {
            display: flex;
            align-items: center;
            gap: 8px;
            min-width: 175px;
            flex-shrink: 0;
        }

        .stage-gallery-badge {
            font-size: 0.72rem;
            font-weight: 700;
            padding: 3px 10px;
            border-radius: 20px;
            display: inline-flex;
            align-items: center;
            gap: 6px;
            white-space: nowrap;
        }

        .stage-badge-sebelum {
            background-color: #fef3c7;
            color: #92400e;
            border: 1px solid #fde68a;
        }

        .stage-badge-pembangunan {
            background-color: #e0f2fe;
            color: #0369a1;
            border: 1px solid #bae6fd;
        }

        .stage-badge-selesai {
            background-color: #dcfce7;
            color: #15803d;
            border: 1px solid #bbf7d0;
        }

        .stage-gallery-thumbs {
            display: flex;
            gap: 8px;
            overflow-x: auto;
            padding-bottom: 2px;
            align-items: center;
            flex: 1;
        }

        .modal-gallery-thumb {
            width: 58px;
            height: 58px;
            border-radius: 8px;
            object-fit: cover;
            cursor: pointer;
            border: 2px solid #e2e8f0;
            transition: all 0.2s ease;
            flex-shrink: 0;
        }

        .modal-gallery-thumb:hover {
            transform: scale(1.06);
            border-color: #0d9488;
        }

        .modal-gallery-thumb.active {
            border-color: #0d9488;
            box-shadow: 0 0 0 2px rgba(13, 148, 136, 0.4);
            transform: scale(1.06);
        }

        .modal-body {
            padding: 26px 28px 30px;
        }

        .modal-meta-row {
            display: flex;
            flex-wrap: wrap;
            gap: 14px;
            margin-bottom: 14px;
            font-size: 0.82rem;
            color: #64748b;
        }

        .modal-meta-item {
            display: inline-flex;
            align-items: center;
            gap: 6px;
        }

        .modal-meta-item i {
            color: #0d9488;
        }

        .modal-title {
            font-size: 1.35rem;
            font-weight: 800;
            color: #0f172a;
            margin-bottom: 14px;
            line-height: 1.35;
        }

        .modal-desc {
            font-size: 0.92rem;
            color: #334155;
            line-height: 1.7;
            margin-bottom: 24px;
            white-space: pre-line;
        }

        .modal-section-title {
            font-size: 0.8rem;
            font-weight: 700;
            color: #334155;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-bottom: 10px;
            display: flex;
            align-items: center;
            gap: 6px;
        }

        .modal-actions {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
        }

        .btn-action {
            padding: 9px 18px;
            border-radius: 10px;
            font-size: 0.82rem;
            font-weight: 600;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            border: none;
            cursor: pointer;
            transition: all 0.2s ease;
        }

        .btn-action:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.12);
        }

        .btn-doc-pdf {
            background-color: #dc2626;
            color: #ffffff;
        }

        .btn-doc-pdf:hover {
            background-color: #b91c1c;
        }

        .btn-social-ig {
            background: linear-gradient(45deg, #f09433, #e6683c, #dc2743, #cc2366, #bc1888);
            color: #ffffff;
        }

        .btn-social-fb {
            background-color: #1877f2;
            color: #ffffff;
        }

        .btn-social-tt {
            background-color: #000000;
            color: #ffffff;
        }

        .btn-social-yt {
            background-color: #ff0000;
            color: #ffffff;
        }
    </style>
</head>
<body class="min-h-screen flex flex-col antialiased">

    {{-- Topbar Kontak & Informasi Resmi --}}
    @include('components.topbar')

    {{-- Navbar Utama Beranda / Navigasi --}}
    @include('components.navbar')

    {{-- Main Content Container --}}
    <main class="flex-1 w-full max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 sm:py-10">

        {{-- Breadcrumb Navigasi --}}
        <nav class="flex items-center gap-2 text-xs text-slate-500 mb-6 font-medium" aria-label="Breadcrumb">
            <a href="{{ url('/') }}" class="hover:text-teal-700 flex items-center gap-1.5 transition-colors">
                <i class="fa-solid fa-house text-teal-600"></i>
                <span>Beranda</span>
            </a>
        </nav>

        {{-- Header Judul & Tombol Tambah --}}
            @auth
                <div class="shrink-0">
                    <a href="{{ route('admin.posting.create') }}" class="inline-flex items-center gap-2 bg-teal-700 hover:bg-teal-800 text-white font-bold px-5 py-2.5 rounded-xl text-xs sm:text-sm shadow-xs hover:shadow-md transition-all active:scale-95">
                        <i class="fa-solid fa-plus"></i>
                        <span>Posting Dokumentasi Baru</span>
                    </a>
                </div>
            @endauth
        </div>

        {{-- Form Pencarian & Filter Multi-Kategori --}}
        <div class="bg-white rounded-2xl border border-slate-200 p-5 sm:p-6 shadow-xs mb-8">
            <form method="GET" action="{{ route('dokumentasi.index') }}" class="space-y-4">
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-3.5">
                    
                    {{-- Input Pencarian Teks --}}
                    <div class="sm:col-span-2 relative">
                        <label for="q" class="block text-[11px] font-bold text-slate-600 mb-1 uppercase tracking-wider">Pencarian Kata Kunci</label>
                        <div class="relative">
                            <input 
                                type="text" 
                                name="q" 
                                id="q" 
                                value="{{ request('q') }}" 
                                placeholder="Cari judul berita, nama penerima, keterangan, atau pelapor..." 
                                class="w-full text-xs sm:text-sm bg-slate-50 border border-slate-300 rounded-xl pl-9 pr-3 py-2.5 text-slate-800 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-teal-500 font-medium"
                            >
                            <i class="fa-solid fa-magnifying-glass text-slate-400 absolute left-3 top-3.5 text-xs pointer-events-none"></i>
                        </div>
                    </div>

                    {{-- Filter Program --}}
                    <div>
                        <label for="program" class="block text-[11px] font-bold text-slate-600 mb-1 uppercase tracking-wider">Program Bantuan</label>
                        <select 
                            name="program" 
                            id="program"
                            class="w-full text-xs sm:text-sm bg-slate-50 border border-slate-300 rounded-xl px-3 py-2.5 text-slate-800 focus:outline-none focus:ring-2 focus:ring-teal-500 font-medium"
                        >
                            <option value="">Semua Program</option>
                            <option value="RTLH" {{ request('program') === 'RTLH' ? 'selected' : '' }}>RTLH APBD BOGOR</option>
                            <option value="BSPS" {{ request('program') === 'BSPS' ? 'selected' : '' }}>BSPS KEMENPERA</option>
                        </select>
                    </div>

                    {{-- Filter Kecamatan --}}
                    <div>
                        <label for="kecamatan" class="block text-[11px] font-bold text-slate-600 mb-1 uppercase tracking-wider">Kecamatan (40)</label>
                        <select 
                            name="kecamatan" 
                            id="kecamatan"
                            class="w-full text-xs sm:text-sm bg-slate-50 border border-slate-300 rounded-xl px-3 py-2.5 text-slate-800 focus:outline-none focus:ring-2 focus:ring-teal-500 font-medium"
                        >
                            <option value="">Semua Kecamatan</option>
                            @foreach ($kecamatanList as $kec)
                                <option value="{{ $kec->id_kec }}" {{ request('kecamatan') == $kec->id_kec ? 'selected' : '' }}>
                                    Kec. {{ $kec->name_kec }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>

                {{-- Action Tombol Terapkan & Reset Filter --}}
                <div class="flex flex-wrap items-center justify-between gap-3 pt-3 border-t border-slate-100">
                    <div class="text-xs text-slate-500">
                        @if ($postings->total() > 0)
                            Ditemukan <strong class="text-slate-800">{{ $postings->total() }}</strong> dokumentasi kegiatan
                        @else
                            Tidak ada dokumentasi ditemukan
                        @endif
                    </div>

                    <div class="flex items-center gap-2">
                        @if (request()->hasAny(['q', 'program', 'kecamatan']))
                            <a href="{{ route('dokumentasi.index') }}" class="px-4 py-2 rounded-xl text-xs font-bold text-slate-600 hover:text-slate-900 bg-slate-100 hover:bg-slate-200 transition-colors">
                                <i class="fa-solid fa-rotate-left mr-1"></i> Reset Filter
                            </a>
                        @endif
                        <button type="submit" class="inline-flex items-center gap-1.5 px-5 py-2 rounded-xl text-xs font-bold text-white bg-teal-700 hover:bg-teal-800 transition-colors shadow-xs">
                            <i class="fa-solid fa-filter"></i>
                            <span>Terapkan Filter</span>
                        </button>
                    </div>
                </div>
            </form>
        </div>

        @php
            $modalList = [];
            $postingsData = [];

            if (isset($postings) && $postings->isNotEmpty()) {
                foreach ($postings as $item) {
                    $bnba = $item->bnba;
                    
                    // Kumpulkan foto dari 3 tahap terpisah
                    $photosSebelum = [];
                    for ($i = 1; $i <= 3; $i++) {
                        $f = $item->{"foto_persiapan_{$i}"};
                        if ($f) $photosSebelum[] = [
                            'title' => "Sebelum Renovasi #{$i}",
                            'url' => asset($f),
                            'stage' => 'sebelum',
                            'stage_label' => 'Sebelum Renovasi'
                        ];
                    }

                    $photosPembangunan = [];
                    for ($i = 1; $i <= 3; $i++) {
                        $f = $item->{"foto_pembangunan_{$i}"};
                        if ($f) $photosPembangunan[] = [
                            'title' => "Proses Pembangunan #{$i}",
                            'url' => asset($f),
                            'stage' => 'pembangunan',
                            'stage_label' => 'Proses Pembangunan'
                        ];
                    }

                    $photosSelesai = [];
                    for ($i = 1; $i <= 3; $i++) {
                        $f = $item->{"foto_selesai_{$i}"};
                        if ($f) $photosSelesai[] = [
                            'title' => "Selesai 100% #{$i}",
                            'url' => asset($f),
                            'stage' => 'selesai',
                            'stage_label' => 'Selesai 100%'
                        ];
                    }

                    // Urutan foto total: Selesai -> Pembangunan -> Sebelum
                    $photos = array_merge($photosSelesai, $photosPembangunan, $photosSebelum);
                    $imgUrl = !empty($photosSelesai) 
                        ? $photosSelesai[0]['url'] 
                        : (!empty($photosPembangunan) ? $photosPembangunan[0]['url'] : (!empty($photosSebelum) ? $photosSebelum[0]['url'] : asset('images/hero-bg.png')));

                    $tahapLabel = 'Tahap Persiapan';
                    $tahapCls = 'badge-tahap-persiapan';
                    if (!empty($item->foto_selesai_1)) {
                        $tahapLabel = '100% Selesai Huni';
                        $tahapCls = 'badge-tahap-selesai';
                    } elseif (!empty($item->foto_pembangunan_1)) {
                        $tahapLabel = 'Proses Pembangunan';
                        $tahapCls = 'badge-tahap-proses';
                    }

                    $lokasi = 'Kabupaten Bogor';
                    $rawNama = $item->judul;
                    $programLabel = 'RTLH APBD BOGOR';
                    $programBadgeCls = 'badge-program-rtlh';

                    if ($bnba) {
                        $rawNama = $bnba->name_bnba;
                        $lokasi = 'Desa ' . ($bnba->xkel ?? '-') . ', Kec. ' . ($bnba->xkec ?? '-');
                        if (str_contains(strtoupper($bnba->cat_bnba ?? ''), 'BSPS')) {
                            $programLabel = 'BSPS KEMENPERA';
                            $programBadgeCls = 'badge-program-bsps';
                        }
                    }

                    // Sensor nama penerima & judul di public (1 huruf awal per kata)
                    $namaPenerima = \App\Http\Controllers\HomeController::maskName($rawNama);
                    $judul = \App\Http\Controllers\HomeController::maskTitle($item->judul, $bnba?->name_bnba);

                    $postingsData[] = [
                        'judul' => $judul,
                        'tgl_formatted' => $item->tanggal_posting ? $item->tanggal_posting->translatedFormat('d F Y') : date('d F Y'),
                        'tgl_badge' => $item->tanggal_posting ? $item->tanggal_posting->format('d/m/Y') : date('d/m/Y'),
                        'keterangan' => $item->keterangan,
                        'tim_pelapor' => $item->tim_pelapor ?: 'Petugas Lapangan',
                        'lokasi' => $lokasi,
                        'nama_penerima' => $namaPenerima,
                        'program' => $programLabel,
                        'program_cls' => $programBadgeCls,
                        'tahap_label' => $tahapLabel,
                        'tahap_cls' => $tahapCls,
                        'img_cover' => $imgUrl,
                        'photos' => $photos,
                        'photos_sebelum' => $photosSebelum,
                        'photos_pembangunan' => $photosPembangunan,
                        'photos_selesai' => $photosSelesai,
                        'file_rab' => $item->file_rab ? asset($item->file_rab) : null,
                        'nama_file_rab' => $item->nama_file_rab ?: 'Dokumen RAB',
                        'link_ig' => $item->link_instagram,
                        'link_fb' => $item->link_facebook,
                        'link_tt' => $item->link_tiktok,
                        'link_yt' => $item->link_youtube,
                    ];
                }
            }
        @endphp

        {{-- NEWS GRID (4 Kolom / Kartu di Desktop) --}}
        @if (count($postingsData) > 0)
            <div class="news-grid">
                @foreach ($postingsData as $idx => $card)
                    @php
                        $modalList[$idx] = $card;
                    @endphp
                    <div class="news-card" onclick="openNewsModal({{ $idx }})">
                        
                        {{-- Wrapper Gambar dengan Badge Tanggal & Status --}}
                        <div class="card-img-wrapper">
                            <div class="card-img-top-badges">
                                <span class="badge-date">
                                    <i class="fa-regular fa-calendar"></i>
                                    <span>{{ $card['tgl_badge'] ?? $card['tgl_formatted'] }}</span>
                                </span>

                                <span class="badge-status-tahap {{ $card['tahap_cls'] }}">
                                    {{ $card['tahap_label'] }}
                                </span>
                            </div>

                            <img 
                                src="{{ $card['img_cover'] }}" 
                                alt="{{ $card['judul'] }}" 
                                loading="lazy"
                                onerror="this.onerror=null;this.src='{{ asset('images/hero-bg.png') }}';"
                            >
                        </div>

                        {{-- Card Body --}}
                        <div class="card-body">
                            {{-- Badge Program --}}
                            <span class="badge-instansi {{ $card['program_cls'] }}">
                                {{ $card['program'] }}
                            </span>

                            {{-- Judul Kegiatan --}}
                            <h4 class="card-title">{{ $card['judul'] }}</h4>

                            {{-- Lokasi / Wilayah --}}
                            <p class="card-location">
                                <i class="fa-solid fa-location-dot"></i>
                                <span>{{ $card['lokasi'] }}</span>
                            </p>

                            {{-- Badges Kelengkapan Eviden & Dokumen --}}
                            <div class="card-evidences">
                                @if (!empty($card['file_rab']))
                                    <span class="badge-evidence badge-pdf">
                                        <i class="fa-solid fa-file-pdf"></i> Dokumen RAB
                                    </span>
                                @endif

                                @if (!empty($card['link_ig']))
                                    <span class="badge-evidence badge-ig">
                                        <i class="fa-brands fa-instagram"></i> IG
                                    </span>
                                @endif

                                @if (!empty($card['link_fb']))
                                    <span class="badge-evidence badge-fb">
                                        <i class="fa-brands fa-facebook"></i> FB
                                    </span>
                                @endif

                                @if (!empty($card['link_tt']))
                                    <span class="badge-evidence badge-tt">
                                        <i class="fa-brands fa-tiktok"></i> TikTok
                                    </span>
                                @endif

                                @if (!empty($card['link_yt']))
                                    <span class="badge-evidence badge-yt">
                                        <i class="fa-brands fa-youtube"></i> YouTube
                                    </span>
                                @endif

                                @if (count($card['photos']) > 0)
                                    <span class="badge-evidence badge-foto">
                                        <i class="fa-solid fa-images"></i> {{ count($card['photos']) }} Foto
                                    </span>
                                @endif
                            </div>

                            {{-- Cuplikan Deskripsi (Hingga 4 Baris) --}}
                            <p class="card-text">
                                {{ Str::limit($card['keterangan'], 160) }}
                            </p>

                            {{-- Footer Kartu --}}
                            <div class="card-footer-row">
                                <span class="card-reporter">
                                    <i class="fa-regular fa-user"></i>
                                    <span>{{ $card['tim_pelapor'] }}</span>
                                </span>
                                <span class="card-link">
                                    <span>Lihat Kegiatan</span>
                                </span>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            {{-- Paginasi Halaman --}}
            <div class="mt-10 flex items-center justify-center">
                {{ $postings->links() }}
            </div>
        @else
            {{-- Empty State Box --}}
            <div class="bg-white rounded-2xl border border-slate-200 p-12 text-center shadow-xs">
                <div class="w-16 h-16 rounded-full bg-slate-100 text-slate-400 flex items-center justify-center mx-auto mb-4 text-2xl">
                    <i class="fa-regular fa-folder-open"></i>
                </div>
                <h3 class="text-base font-bold text-slate-800 mb-1">Dokumentasi Tidak Ditemukan</h3>
                <p class="text-xs sm:text-sm text-slate-500 max-w-md mx-auto mb-5 leading-relaxed">
                    Tidak ada dokumentasi kegiatan bedah rumah yang cocok dengan kriteria pencarian atau filter yang Anda pilih.
                </p>
                <a href="{{ route('dokumentasi.index') }}" class="inline-flex items-center gap-2 px-5 py-2.5 rounded-xl bg-teal-700 hover:bg-teal-800 text-white font-bold text-xs shadow-xs transition-colors">
                    <i class="fa-solid fa-rotate-left"></i>
                    <span>Tampilkan Semua Dokumentasi</span>
                </a>
            </div>
        @endif

    </main>

    {{-- MODAL DETAIL DOKUMENTASI (GAYA KAMI MENDENGAR DENGAN PREVIEW GALERI THUMBNAIL) --}}
    <div class="modal-overlay" id="newsModal">
        <div class="modal-content">
            <button class="close-btn" onclick="closeNewsModal()" aria-label="Tutup Detail">
                <i class="fa-solid fa-xmark"></i>
            </button>

            {{-- Foto Utama / Active Photo --}}
            <div class="modal-img-container">
                <span id="modalActiveStageBadge" class="modal-active-stage-badge" style="display: none;"></span>
                <img src="" alt="Foto Kegiatan Bedah Rumah" class="modal-img" id="modalImg" onerror="this.onerror=null;this.src='{{ asset('images/hero-bg.png') }}';">
            </div>

            {{-- Thumbnail Galeri Foto Dokumentasi (Tahap Persiapan, Pembangunan, Selesai) --}}
            <div class="modal-gallery-wrapper" id="modalGalleryWrapper" style="display: none;">
                <div class="modal-gallery-title">
                    <i class="fa-solid fa-images text-teal-600"></i>
                    <span>Galeri Dokumentasi Foto Pelaksanaan (Klik foto untuk pratinjau):</span>
                </div>
                <div id="modalGalleryStages" class="modal-gallery-stages-container">
                    {{-- Dinamis melalui JavaScript --}}
                </div>
            </div>

            {{-- Isi Detail Pop-up --}}
            <div class="modal-body">
                <div class="modal-meta-row">
                    <span class="modal-meta-item">
                        <i class="fa-regular fa-calendar"></i>
                        <span id="modalDate">-</span>
                    </span>
                    <span class="modal-meta-item">
                        <i class="fa-solid fa-tag"></i>
                        <span id="modalProgram">-</span>
                    </span>
                    <span class="modal-meta-item">
                        <i class="fa-solid fa-location-dot"></i>
                        <span id="modalLocation">-</span>
                    </span>
                    <span class="modal-meta-item">
                        <i class="fa-solid fa-user-check"></i>
                        <strong id="modalPenerima">-</strong>
                    </span>
                    <span class="modal-meta-item">
                        <i class="fa-regular fa-user"></i>
                        <span id="modalActor">-</span>
                    </span>
                </div>

                <h3 class="modal-title" id="modalTitle">-</h3>
                <div class="modal-desc" id="modalDesc">-</div>

                {{-- Berkas Dokumen Laporan / RAB --}}
                <div class="mb-6" id="modalDocSection" style="display: none;">
                    <div class="modal-section-title">
                        <i class="fa-solid fa-file-contract text-red-600"></i>
                        <span>Berkas Dokumen Laporan / RAB:</span>
                    </div>
                    <div id="modalDocContainer">
                        {{-- Dinamis via JavaScript --}}
                    </div>
                </div>

                {{-- Media Sosial & Publikasi Resmi --}}
                <div>
                    <div class="modal-section-title">
                        <i class="fa-solid fa-share-nodes text-teal-600"></i>
                        <span>Tautan Publikasi Kegiatan:</span>
                    </div>
                    <div class="modal-actions" id="modalActions">
                        {{-- Tombol media sosial dinamis via JavaScript --}}
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Footer Resmi Pemerintah Kabupaten Bogor --}}
    <footer class="mt-auto w-full bg-teal-700 text-teal-50 text-xs border-t border-teal-600 shadow-md">
        <div class="w-full max-w-7xl mx-auto px-6 sm:px-10 lg:px-16 xl:px-20 py-10 sm:py-12">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8 mb-8 pb-8 border-b border-teal-600/70">
                <div class="space-y-3">
                    <div class="flex items-center gap-3">
                        <img src="{{ asset('images/lambang-kabupaten-bogor.svg') }}" alt="Logo Kabupaten Bogor" class="h-10 w-auto">
                        <div class="flex flex-col text-left">
                            <span class="text-sm font-extrabold tracking-tight text-white uppercase leading-none">Bedah Rumah</span>
                            <span class="text-[11px] font-bold text-teal-200 tracking-wider uppercase mt-1">Kabupaten Bogor</span>
                        </div>
                    </div>
                    <p class="text-teal-100/90 text-xs leading-relaxed max-w-sm">
                        Sistem Informasi Dokumentasi dan Pemantauan Program Bantuan Bedah Rumah Tidak Layak Huni (RTLH & BSPS) Pemerintah Kabupaten Bogor.
                    </p>
                </div>

                <div class="space-y-2">
                    <h4 class="text-xs font-bold uppercase tracking-wider text-white">Navigasi Utama</h4>
                    <ul class="space-y-1.5 text-teal-100 text-xs">
                        <li><a href="{{ url('/') }}" class="hover:text-white hover:underline">&rsaquo; Beranda Portal</a></li>
                        <li><a href="{{ url('/#peta-wilayah') }}" class="hover:text-white hover:underline">&rsaquo; Peta Sebaran Wilayah</a></li>
                        <li><a href="{{ route('dokumentasi.index') }}" class="hover:text-white hover:underline font-bold text-white">&rsaquo; Katalog Dokumentasi</a></li>
                    </ul>
                </div>

                <div class="space-y-2">
                    <h4 class="text-xs font-bold uppercase tracking-wider text-white">Kontak Layanan</h4>
                    <p class="text-teal-100 text-xs leading-relaxed">
                        Dinas Perumahan, Kawasan Permukiman dan Pertanahan (DPKPP)<br>
                        Kabupaten Bogor, Jawa Barat.
                    </p>
                </div>
            </div>

            <div class="flex flex-col sm:flex-row items-center justify-between gap-3 text-teal-200 text-[11px]">
                <p>&copy; {{ date('Y') }} Pemerintah Kabupaten Bogor. Hak Cipta Dilindungi.</p>
                <p>Dokumentasi Bedah Rumah RTLH & BSPS</p>
            </div>
        </div>
    </footer>

    {{-- Script Modal Pop-up Interaktif --}}
    <script>
        window.newsDataList = @json($modalList);

        function openNewsModal(idx) {
            const data = window.newsDataList[idx];
            if (!data) return;

            const modal = document.getElementById('newsModal');
            const modalImg = document.getElementById('modalImg');
            const modalDate = document.getElementById('modalDate');
            const modalProgram = document.getElementById('modalProgram');
            const modalLocation = document.getElementById('modalLocation');
            const modalPenerima = document.getElementById('modalPenerima');
            const modalActor = document.getElementById('modalActor');
            const modalTitle = document.getElementById('modalTitle');
            const modalDesc = document.getElementById('modalDesc');
            const modalGalleryWrapper = document.getElementById('modalGalleryWrapper');
            const modalGalleryStages = document.getElementById('modalGalleryStages');
            const modalActiveStageBadge = document.getElementById('modalActiveStageBadge');
            const modalDocSection = document.getElementById('modalDocSection');
            const modalDocContainer = document.getElementById('modalDocContainer');
            const modalActions = document.getElementById('modalActions');

            modalImg.src = data.img_cover;
            modalDate.innerText = data.tgl_formatted || '';
            modalProgram.innerText = data.program || '';
            modalLocation.innerText = data.lokasi || '';
            modalPenerima.innerText = 'Penerima: ' + (data.nama_penerima || '-');
            modalActor.innerText = 'Pelapor: ' + (data.tim_pelapor || '-');
            modalTitle.innerText = data.judul || '';
            modalDesc.innerText = data.keterangan || '';

            // 1. Galeri Thumbnail Foto Terpisah Kategori (Sebelum, Pembangunan, Selesai)
            modalGalleryStages.innerHTML = '';

            const stagesConfig = [
                {
                    key: 'sebelum',
                    label: 'Sebelum Renovasi',
                    sublabel: 'Persiapan',
                    icon: 'fa-solid fa-clock-rotate-left',
                    badgeCls: 'stage-badge-sebelum',
                    items: data.photos_sebelum || []
                },
                {
                    key: 'pembangunan',
                    label: 'Proses Pembangunan',
                    sublabel: 'Konstruksi',
                    icon: 'fa-solid fa-trowel-bricks',
                    badgeCls: 'stage-badge-pembangunan',
                    items: data.photos_pembangunan || []
                },
                {
                    key: 'selesai',
                    label: 'Selesai Renovasi',
                    sublabel: '100% Siap Huni',
                    icon: 'fa-solid fa-circle-check',
                    badgeCls: 'stage-badge-selesai',
                    items: data.photos_selesai || []
                }
            ];

            let totalPhotos = 0;
            let initialStage = null;

            stagesConfig.forEach(st => {
                if (st.items && st.items.length > 0) {
                    totalPhotos += st.items.length;

                    // Tentukan info badge untuk cover aktif
                    if (!initialStage) {
                        const matchCover = st.items.find(p => p.url === data.img_cover);
                        if (matchCover) {
                            initialStage = { label: matchCover.title || st.label, badgeCls: st.badgeCls, icon: st.icon };
                        }
                    }

                    const stageBlock = document.createElement('div');
                    stageBlock.className = 'stage-gallery-block';

                    const headerDiv = document.createElement('div');
                    headerDiv.className = 'stage-gallery-header';
                    headerDiv.innerHTML = `
                        <span class="stage-gallery-badge ${st.badgeCls}">
                            <i class="${st.icon}"></i>
                            <span>${st.label}</span>
                        </span>
                        <span class="text-[11px] font-bold text-slate-400">${st.items.length} Foto</span>
                    `;
                    stageBlock.appendChild(headerDiv);

                    const thumbsDiv = document.createElement('div');
                    thumbsDiv.className = 'stage-gallery-thumbs';

                    st.items.forEach((ph, i) => {
                        const thumb = document.createElement('img');
                        thumb.src = ph.url;
                        thumb.alt = ph.title || st.label;
                        thumb.title = ph.title || st.label;
                        thumb.className = `modal-gallery-thumb ${ph.url === data.img_cover ? 'active' : ''}`;
                        thumb.onclick = function() {
                            modalImg.src = ph.url;
                            if (modalActiveStageBadge) {
                                modalActiveStageBadge.style.display = 'inline-flex';
                                modalActiveStageBadge.className = `modal-active-stage-badge ${st.badgeCls}`;
                                modalActiveStageBadge.innerHTML = `<i class="${st.icon}"></i> <span>${ph.title || st.label}</span>`;
                            }
                            document.querySelectorAll('.modal-gallery-thumb').forEach(t => t.classList.remove('active'));
                            thumb.classList.add('active');
                        };
                        thumbsDiv.appendChild(thumb);
                    });

                    stageBlock.appendChild(thumbsDiv);
                    modalGalleryStages.appendChild(stageBlock);
                }
            });

            if (totalPhotos > 0) {
                modalGalleryWrapper.style.display = 'block';
                if (modalActiveStageBadge) {
                    if (!initialStage) {
                        const firstAvail = stagesConfig.find(s => s.items.length > 0);
                        if (firstAvail) {
                            initialStage = { label: firstAvail.items[0].title || firstAvail.label, badgeCls: firstAvail.badgeCls, icon: firstAvail.icon };
                        }
                    }
                    if (initialStage) {
                        modalActiveStageBadge.style.display = 'inline-flex';
                        modalActiveStageBadge.className = `modal-active-stage-badge ${initialStage.badgeCls}`;
                        modalActiveStageBadge.innerHTML = `<i class="${initialStage.icon}"></i> <span>${initialStage.label}</span>`;
                    }
                }
            } else {
                modalGalleryWrapper.style.display = 'none';
                if (modalActiveStageBadge) {
                    modalActiveStageBadge.style.display = 'none';
                }
            }

            // 2. Berkas Dokumen Laporan / RAB
            modalDocContainer.innerHTML = '';
            if (data.file_rab && data.file_rab.trim() !== '') {
                modalDocSection.style.display = 'block';
                const docBtn = document.createElement('a');
                docBtn.href = data.file_rab;
                docBtn.target = '_blank';
                docBtn.className = 'btn-action btn-doc-pdf';
                docBtn.innerHTML = `<i class="fa-solid fa-file-pdf"></i> Unduh / Buka File RAB (${data.nama_file_rab || 'PDF'})`;
                modalDocContainer.appendChild(docBtn);
            } else {
                modalDocSection.style.display = 'none';
            }

            // 3. Media Sosial (Instagram, Facebook, TikTok, YouTube)
            modalActions.innerHTML = '';
            const sosmed = [
                { label: 'Instagram', url: data.link_ig, icon: 'fa-brands fa-instagram', cls: 'btn-social-ig' },
                { label: 'Facebook', url: data.link_fb, icon: 'fa-brands fa-facebook', cls: 'btn-social-fb' },
                { label: 'TikTok', url: data.link_tt, icon: 'fa-brands fa-tiktok', cls: 'btn-social-tt' },
                { label: 'YouTube', url: data.link_yt, icon: 'fa-brands fa-youtube', cls: 'btn-social-yt' }
            ];

            let countSosmed = 0;
            sosmed.forEach(s => {
                if (s.url && s.url.trim() !== '') {
                    countSosmed++;
                    const btn = document.createElement('a');
                    btn.href = s.url;
                    btn.target = '_blank';
                    btn.className = `btn-action ${s.cls}`;
                    btn.innerHTML = `<i class="${s.icon}"></i> ${s.label}`;
                    modalActions.appendChild(btn);
                }
            });

            if (countSosmed === 0) {
                const emptyNotice = document.createElement('span');
                emptyNotice.style.fontSize = '0.82rem';
                emptyNotice.style.color = '#94a3b8';
                emptyNotice.innerText = 'Belum ada tautan media sosial yang dilampirkan.';
                modalActions.appendChild(emptyNotice);
            }

            modal.classList.add('active');
            document.body.style.overflow = 'hidden';
        }

        function closeNewsModal() {
            const modal = document.getElementById('newsModal');
            if (modal) {
                modal.classList.remove('active');
                document.body.style.overflow = 'auto';
            }
        }

        window.addEventListener('click', function(e) {
            const modal = document.getElementById('newsModal');
            if (e.target === modal) {
                closeNewsModal();
            }
        });

        window.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                closeNewsModal();
            }
        });
    </script>
</body>
</html>

