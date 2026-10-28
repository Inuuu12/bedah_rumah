@extends('admin.layout')

@section('title', 'Dashboard Ringkasan')
@section('header_title', 'Ringkasan Dashboard')
@section('header_subtitle', 'Data statistik dan sebaran program bantuan perumahan Kabupaten Bogor')

@section('content')
<style>
    /* Keyframe Animations for Staggered Entrance */
    @keyframes dashFadeSlideUp {
        0% {
            opacity: 0;
            transform: translateY(22px) scale(0.985);
        }
        100% {
            opacity: 1;
            transform: translateY(0) scale(1);
        }
    }

    .dash-reveal {
        opacity: 0;
        animation: dashFadeSlideUp 0.65s cubic-bezier(0.16, 1, 0.3, 1) forwards;
        will-change: opacity, transform;
    }

    .delay-1 { animation-delay: 0.04s; }
    .delay-2 { animation-delay: 0.10s; }
    .delay-3 { animation-delay: 0.16s; }
    .delay-4 { animation-delay: 0.22s; }
    .delay-5 { animation-delay: 0.28s; }
    .delay-6 { animation-delay: 0.34s; }

    /* Animated progress bars */
    .progress-bar-fill {
        width: 0%;
        transition: width 1.2s cubic-bezier(0.16, 1, 0.3, 1);
    }

    /* Glass card hover lift */
    .dash-card-hover {
        transition: transform 0.25s cubic-bezier(0.16, 1, 0.3, 1), box-shadow 0.25s cubic-bezier(0.16, 1, 0.3, 1), border-color 0.25s ease;
    }
    .dash-card-hover:hover {
        transform: translateY(-3px);
        box-shadow: 0 14px 28px -6px rgba(15, 23, 42, 0.08), 0 6px 12px -4px rgba(15, 23, 42, 0.04);
    }
</style>

<div class="space-y-6">

    {{-- Banner / Header Stat Ringkasan --}}
    <div class="dash-reveal delay-1 bg-gradient-to-r from-slate-900 via-slate-800 to-emerald-950 rounded-2xl p-5 sm:p-6 text-white shadow-lg relative overflow-hidden">
        {{-- Decorative background glow --}}
        <div class="absolute -right-10 -top-10 w-64 h-64 bg-emerald-500/10 rounded-full blur-3xl pointer-events-none"></div>
        <div class="absolute right-1/3 -bottom-12 w-48 h-48 bg-sky-500/10 rounded-full blur-2xl pointer-events-none"></div>

        <div class="relative z-10 flex flex-col md:flex-row md:items-center justify-between gap-4">
            <div class="space-y-1">
                <div class="inline-flex items-center gap-2 px-2.5 py-1 rounded-full bg-emerald-500/20 border border-emerald-400/30 text-emerald-300 text-xs font-medium">
                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-400"></span>
                    <span>Monitoring Realtime BNBA</span>
                </div>
                <h1 class="text-xl sm:text-2xl font-extrabold tracking-tight text-white">
                    Sistem Monitoring Bedah Rumah Kab. Bogor
                </h1>
                <p class="text-xs sm:text-sm text-slate-300 max-w-2xl leading-relaxed">
                    Ringkasan data usulan dan realisasi bantuan perumahan rakyat tidak layak huni (RTLH APBD &amp; BSPS Nasional).
                </p>
            </div>

            <div class="flex items-center gap-2.5 shrink-0">
                <a 
                    href="{{ route('admin.bnba') }}" 
                    class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl bg-emerald-500 hover:bg-emerald-400 text-slate-950 font-bold text-xs shadow-md shadow-emerald-950/40 hover:shadow-lg transition-all duration-200 transform hover:-translate-y-0.5 active:translate-y-0"
                >
                    <svg class="w-4 h-4 text-slate-950" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                    </svg>
                    <span>Kelola Data BNBA</span>
                </a>
                <a 
                    href="{{ route('home') }}" 
                    target="_blank" 
                    class="inline-flex items-center gap-2 px-3.5 py-2.5 rounded-xl bg-white/10 hover:bg-white/20 text-white font-medium text-xs border border-white/15 transition-all duration-200"
                >
                    <span>Peta Publik</span>
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/>
                    </svg>
                </a>
            </div>
        </div>
    </div>

    {{-- KPI Metric Cards (4 Kolom dengan Stagger & Counter Animasi) --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
        
        {{-- Card 1: Total Penerima --}}
        <div class="dash-reveal delay-1 dash-card-hover bg-white rounded-2xl border border-slate-200/90 p-5 shadow-xs relative overflow-hidden">
            <div class="absolute top-0 left-0 right-0 h-1 bg-gradient-to-r from-slate-600 via-slate-700 to-slate-900"></div>
            <div class="flex items-center justify-between">
                <span class="text-[11px] font-bold text-slate-500 uppercase tracking-wider">Total Penerima BNBA</span>
                <div class="w-9 h-9 rounded-xl bg-slate-100 text-slate-700 flex items-center justify-center shadow-xs">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                    </svg>
                </div>
            </div>
            <div class="mt-4">
                <div class="flex items-baseline gap-1.5">
                    <h3 class="text-3xl font-extrabold text-slate-900 tracking-tight counter-number" data-target="{{ $totalSemua }}">
                        0
                    </h3>
                    <span class="text-xs font-semibold text-slate-500">Rumah</span>
                </div>
                <div class="mt-2.5 flex items-center justify-between text-[11px]">
                    <span class="text-slate-500 truncate">Total data terverifikasi</span>
                    <span class="inline-flex items-center px-1.5 py-0.5 rounded-md bg-slate-100 text-slate-700 font-bold">100%</span>
                </div>
            </div>
        </div>

        {{-- Card 2: RTLH APBD BOGOR --}}
        <div class="dash-reveal delay-2 dash-card-hover bg-white rounded-2xl border border-slate-200/90 p-5 shadow-xs relative overflow-hidden">
            <div class="absolute top-0 left-0 right-0 h-1 bg-gradient-to-r from-emerald-500 to-teal-600"></div>
            <div class="flex items-center justify-between">
                <span class="text-[11px] font-bold text-emerald-700 uppercase tracking-wider">RTLH APBD BOGOR</span>
                <div class="w-9 h-9 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center shadow-xs border border-emerald-100">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                    </svg>
                </div>
            </div>
            <div class="mt-4">
                <div class="flex items-baseline gap-1.5">
                    <h3 class="text-3xl font-extrabold text-emerald-700 tracking-tight counter-number" data-target="{{ $totalRtlh }}">
                        0
                    </h3>
                    <span class="text-xs font-semibold text-slate-500">Rumah</span>
                </div>
                <div class="mt-2.5 flex items-center justify-between text-[11px]">
                    <span class="text-slate-500 truncate">APBD Pemerintah Kab. Bogor</span>
                    <span class="inline-flex items-center px-1.5 py-0.5 rounded-md bg-emerald-50 text-emerald-700 font-bold border border-emerald-200">
                        {{ $totalSemua > 0 ? round(($totalRtlh / $totalSemua) * 100, 1) : 0 }}%
                    </span>
                </div>
            </div>
        </div>

        {{-- Card 3: BSPS NASIONAL --}}
        <div class="dash-reveal delay-3 dash-card-hover bg-white rounded-2xl border border-slate-200/90 p-5 shadow-xs relative overflow-hidden">
            <div class="absolute top-0 left-0 right-0 h-1 bg-gradient-to-r from-sky-500 to-blue-600"></div>
            <div class="flex items-center justify-between">
                <span class="text-[11px] font-bold text-sky-700 uppercase tracking-wider">BSPS KEMENPERA</span>
                <div class="w-9 h-9 rounded-xl bg-sky-50 text-sky-600 flex items-center justify-center shadow-xs border border-sky-100">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 14v3m4-3v3m4-3v3M3 21h18M3 10h18M3 7l9-4 9 4M4 10h16v11H4V10z"/>
                    </svg>
                </div>
            </div>
            <div class="mt-4">
                <div class="flex items-baseline gap-1.5">
                    <h3 class="text-3xl font-extrabold text-sky-700 tracking-tight counter-number" data-target="{{ $totalBsps }}">
                        0
                    </h3>
                    <span class="text-xs font-semibold text-slate-500">Rumah</span>
                </div>
                <div class="mt-2.5 flex items-center justify-between text-[11px]">
                    <span class="text-slate-500 truncate">Stimulan Swadaya Pusat</span>
                    <span class="inline-flex items-center px-1.5 py-0.5 rounded-md bg-sky-50 text-sky-700 font-bold border border-sky-200">
                        {{ $totalSemua > 0 ? round(($totalBsps / $totalSemua) * 100, 1) : 0 }}%
                    </span>
                </div>
            </div>
        </div>

        {{-- Card 4: Cakupan Wilayah --}}
        <div class="dash-reveal delay-4 dash-card-hover bg-white rounded-2xl border border-slate-200/90 p-5 shadow-xs relative overflow-hidden">
            <div class="absolute top-0 left-0 right-0 h-1 bg-gradient-to-r from-amber-500 to-orange-500"></div>
            <div class="flex items-center justify-between">
                <span class="text-[11px] font-bold text-slate-500 uppercase tracking-wider">Cakupan Wilayah</span>
                <div class="w-9 h-9 rounded-xl bg-amber-50 text-amber-600 flex items-center justify-center shadow-xs border border-amber-100">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                    </svg>
                </div>
            </div>
            <div class="mt-4">
                <div class="flex items-baseline gap-1.5">
                    <h3 class="text-3xl font-extrabold text-slate-900 tracking-tight counter-number" data-target="{{ $totalKecamatan }}">
                        0
                    </h3>
                    <span class="text-xs font-semibold text-slate-500">Kecamatan</span>
                </div>
                <div class="mt-2.5 flex items-center justify-between text-[11px]">
                    <span class="text-slate-500 truncate">Di <span class="font-semibold text-slate-700 counter-number" data-target="{{ $totalDesa }}">{{ $totalDesa }}</span> Desa/Kelurahan</span>
                    <span class="inline-flex items-center px-1.5 py-0.5 rounded-md bg-amber-50 text-amber-700 font-bold border border-amber-200">100%</span>
                </div>
            </div>
        </div>
    </div>

    {{-- Grid 2 Kolom: Rekapitulasi Program & Top Kecamatan --}}
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        
        {{-- Kolom Kiri (1 Col): Distribusi Program & Status Progres --}}
        <div class="dash-reveal delay-3 bg-white rounded-2xl border border-slate-200/90 p-5 shadow-xs flex flex-col justify-between dash-card-hover">
            <div>
                <div class="flex items-center justify-between pb-3 border-b border-slate-100">
                    <div>
                        <h4 class="text-sm font-bold text-slate-900">Distribusi Program &amp; Status</h4>
                        <p class="text-[11px] text-slate-500">Proporsi alokasi dan progres pelaksanaan</p>
                    </div>
                    <span class="p-1.5 bg-slate-100 rounded-lg text-slate-500">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 3.055A9.001 9.001 0 1020.945 13H11V3.055z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.488 9H15V3.512A9.025 9.025 0 0120.488 9z"/>
                        </svg>
                    </span>
                </div>

                {{-- Visual Stacked Proportion Bar --}}
                <div class="mt-5">
                    @php
                        $pctRtlh = $totalSemua > 0 ? round(($totalRtlh / $totalSemua) * 100, 1) : 0;
                        $pctBsps = $totalSemua > 0 ? round(($totalBsps / $totalSemua) * 100, 1) : 0;
                    @endphp
                    <div class="flex items-center justify-between text-xs font-semibold mb-2">
                        <span class="text-emerald-700 flex items-center gap-1.5">
                            <span class="w-2.5 h-2.5 rounded-full bg-emerald-500"></span>
                            RTLH APBD ({{ $pctRtlh }}%)
                        </span>
                        <span class="text-sky-700 flex items-center gap-1.5">
                            BSPS ({{ $pctBsps }}%)
                            <span class="w-2.5 h-2.5 rounded-full bg-sky-500"></span>
                        </span>
                    </div>

                    {{-- Combined segmented bar --}}
                    <div class="w-full bg-slate-100 rounded-xl h-3.5 flex overflow-hidden p-0.5 border border-slate-200/80">
                        <div 
                            class="bg-gradient-to-r from-emerald-500 to-teal-500 h-full rounded-l-lg progress-bar-fill" 
                            data-width="{{ $pctRtlh }}%" 
                            title="RTLH APBD: {{ $pctRtlh }}%"
                        ></div>
                        <div 
                            class="bg-gradient-to-r from-sky-500 to-blue-600 h-full rounded-r-lg progress-bar-fill" 
                            data-width="{{ $pctBsps }}%" 
                            title="BSPS Nasional: {{ $pctBsps }}%"
                        ></div>
                    </div>
                </div>

                {{-- Program Breakdowns --}}
                <div class="mt-5 space-y-3.5">
                    <div class="p-3 rounded-xl bg-emerald-50/50 border border-emerald-100/80">
                        <div class="flex justify-between items-center text-xs">
                            <span class="font-medium text-emerald-900 flex items-center gap-2">
                                <span class="w-2 h-2 rounded-full bg-emerald-500"></span>
                                RTLH APBD Kab. Bogor
                            </span>
                            <span class="font-extrabold text-emerald-800 counter-number" data-target="{{ $totalRtlh }}">
                                {{ number_format($totalRtlh, 0, ',', '.') }}
                            </span>
                        </div>
                    </div>

                    <div class="p-3 rounded-xl bg-sky-50/50 border border-sky-100/80">
                        <div class="flex justify-between items-center text-xs">
                            <span class="font-medium text-sky-900 flex items-center gap-2">
                                <span class="w-2 h-2 rounded-full bg-sky-500"></span>
                                BSPS Kemenpera (Nasional)
                            </span>
                            <span class="font-extrabold text-sky-800 counter-number" data-target="{{ $totalBsps }}">
                                {{ number_format($totalBsps, 0, ',', '.') }}
                            </span>
                        </div>
                    </div>
                </div>

                {{-- Status Box Tahapan --}}
                <div class="mt-6 pt-5 border-t border-slate-100">
                    <span class="text-[11px] font-bold text-slate-500 uppercase tracking-wider block mb-2.5">Status Progres Pelaksanaan:</span>
                    <div class="grid grid-cols-3 gap-2 text-center">
                        <div class="p-2.5 bg-amber-50/80 rounded-xl border border-amber-200/70 hover:shadow-xs transition-shadow">
                            <div class="flex items-center justify-center gap-1">
                                <span class="w-1.5 h-1.5 rounded-full bg-amber-500"></span>
                                <span class="text-[10px] font-bold text-amber-800 uppercase">Persiapan</span>
                            </div>
                            <span class="block text-base font-extrabold text-amber-900 mt-1 counter-number" data-target="{{ $statusCounts['PERSIAPAN'] ?? 0 }}">
                                {{ number_format($statusCounts['PERSIAPAN'] ?? 0, 0, ',', '.') }}
                            </span>
                        </div>

                        <div class="p-2.5 bg-blue-50/80 rounded-xl border border-blue-200/70 hover:shadow-xs transition-shadow">
                            <div class="flex items-center justify-center gap-1">
                                <span class="w-1.5 h-1.5 rounded-full bg-blue-500"></span>
                                <span class="text-[10px] font-bold text-blue-800 uppercase">Proses</span>
                            </div>
                            <span class="block text-base font-extrabold text-blue-900 mt-1 counter-number" data-target="{{ $statusCounts['PROSES'] ?? 0 }}">
                                {{ number_format($statusCounts['PROSES'] ?? 0, 0, ',', '.') }}
                            </span>
                        </div>

                        <div class="p-2.5 bg-emerald-50/80 rounded-xl border border-emerald-200/70 hover:shadow-xs transition-shadow">
                            <div class="flex items-center justify-center gap-1">
                                <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                                <span class="text-[10px] font-bold text-emerald-800 uppercase">Selesai</span>
                            </div>
                            <span class="block text-base font-extrabold text-emerald-900 mt-1 counter-number" data-target="{{ $statusCounts['SELESAI'] ?? 0 }}">
                                {{ number_format($statusCounts['SELESAI'] ?? 0, 0, ',', '.') }}
                            </span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="mt-6 pt-4 border-t border-slate-100">
                <a 
                    href="{{ route('admin.bnba') }}" 
                    class="group w-full flex items-center justify-center gap-2 py-2.5 px-3 text-xs font-bold text-emerald-700 bg-emerald-50 hover:bg-emerald-100 hover:text-emerald-800 rounded-xl transition-all duration-200 border border-emerald-200/80 shadow-xs"
                >
                    <span>Buka Manajemen Data BNBA</span>
                    <span class="transition-transform group-hover:translate-x-1 font-bold">&rarr;</span>
                </a>
            </div>
        </div>

        {{-- Kolom Kanan (2 Col): Top 5 Kecamatan Penerima Terbanyak --}}
        <div class="dash-reveal delay-4 bg-white rounded-2xl border border-slate-200/90 p-5 shadow-xs lg:col-span-2 flex flex-col justify-between dash-card-hover">
            <div>
                <div class="flex items-center justify-between pb-3 border-b border-slate-100">
                    <div>
                        <h4 class="text-sm font-bold text-slate-900 flex items-center gap-2">
                            <span>5 Kecamatan dengan Penerima Terbanyak</span>
                            <span class="px-2 py-0.5 text-[10px] font-semibold bg-emerald-100 text-emerald-800 rounded-full">Prioritas</span>
                        </h4>
                        <p class="text-[11px] text-slate-500">Peringkat wilayah dengan kuota alokasi program tertinggi</p>
                    </div>
                    <a 
                        href="{{ route('admin.wilayah') }}" 
                        class="text-xs font-semibold text-emerald-600 hover:text-emerald-700 hover:underline flex items-center gap-1 group"
                    >
                        <span>Lihat Semua 40 Kec</span>
                        <span class="transition-transform group-hover:translate-x-0.5">&rarr;</span>
                    </a>
                </div>

                <div class="overflow-x-auto mt-3">
                    <table class="w-full text-xs text-left">
                        <thead class="bg-slate-50/80 text-slate-500 font-semibold border-b border-slate-200/80">
                            <tr>
                                <th class="py-3 px-3 text-center w-12">Rank</th>
                                <th class="py-3 px-3">Kecamatan</th>
                                <th class="py-3 px-3 text-right">Jumlah Penerima</th>
                                <th class="py-3 px-3">Persentase</th>
                                <th class="py-3 px-3 text-right">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">
                            @foreach ($topKecamatan as $index => $kec)
                                @php
                                    $pct = $totalSemua > 0 ? round(($kec->total / $totalSemua) * 100, 1) : 0;
                                @endphp
                                <tr class="hover:bg-slate-50/80 transition-colors group">
                                    <td class="py-3 px-3 text-center">
                                        @if ($index == 0)
                                            <span class="inline-flex items-center justify-center w-6 h-6 rounded-full bg-amber-100 text-amber-800 font-extrabold text-[11px] shadow-xs">1</span>
                                        @elseif ($index == 1)
                                            <span class="inline-flex items-center justify-center w-6 h-6 rounded-full bg-slate-200 text-slate-700 font-extrabold text-[11px] shadow-xs">2</span>
                                        @elseif ($index == 2)
                                            <span class="inline-flex items-center justify-center w-6 h-6 rounded-full bg-amber-700/15 text-amber-900 font-extrabold text-[11px] shadow-xs">3</span>
                                        @else
                                            <span class="inline-flex items-center justify-center w-6 h-6 rounded-full bg-slate-100 text-slate-500 font-semibold text-[11px]">{{ $index + 1 }}</span>
                                        @endif
                                    </td>
                                    <td class="py-3 px-3">
                                        <div class="font-bold text-slate-900 flex items-center gap-1.5">
                                            <svg class="w-3.5 h-3.5 text-slate-400 group-hover:text-emerald-600 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                                            </svg>
                                            <span>KEC. {{ $kec->xkec }}</span>
                                        </div>
                                    </td>
                                    <td class="py-3 px-3 text-right">
                                        <span class="font-extrabold text-slate-900 counter-number" data-target="{{ $kec->total }}">
                                            {{ number_format($kec->total, 0, ',', '.') }}
                                        </span>
                                        <span class="text-slate-400 font-normal ml-0.5">rumah</span>
                                    </td>
                                    <td class="py-3 px-3">
                                        <div class="flex items-center gap-2.5">
                                            <div class="w-28 bg-slate-100 rounded-full h-2 overflow-hidden border border-slate-200/50">
                                                <div 
                                                    class="bg-gradient-to-r from-emerald-500 to-teal-500 h-2 rounded-full progress-bar-fill" 
                                                    data-width="{{ min(100, $pct * 6) }}%"
                                                ></div>
                                            </div>
                                            <span class="text-slate-600 font-medium text-[11px] w-10">{{ $pct }}%</span>
                                        </div>
                                    </td>
                                    <td class="py-3 px-3 text-right">
                                        <a 
                                            href="{{ route('admin.bnba', ['kecamatan' => $kec->id_kec]) }}" 
                                            class="inline-flex items-center gap-1 px-2.5 py-1 rounded-lg text-xs font-semibold text-emerald-600 hover:text-emerald-800 hover:bg-emerald-50 transition-colors"
                                        >
                                            <span>Filter</span>
                                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                                            </svg>
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="mt-4 pt-3 border-t border-slate-100 flex items-center justify-between text-[11px] text-slate-500">
                <span>Total 40 Kecamatan di Kab. Bogor</span>
                <a href="{{ route('admin.wilayah') }}" class="font-semibold text-emerald-600 hover:text-emerald-700 hover:underline">
                    Buka Rekapitulasi Lengkap Seluruh Kecamatan &rarr;
                </a>
            </div>
        </div>
    </div>

    {{-- Penerima Bantuan Terbaru (8 Data Terakhir) --}}
    <div class="dash-reveal delay-5 bg-white rounded-2xl border border-slate-200/90 p-5 shadow-xs dash-card-hover">
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 mb-4 pb-3 border-b border-slate-100">
            <div>
                <div class="flex items-center gap-2">
                    <h4 class="text-sm font-bold text-slate-900">Data Penerima Terbaru</h4>
                    <span class="px-2 py-0.5 text-[10px] font-semibold bg-slate-100 text-slate-700 rounded-full">8 Terakhir</span>
                </div>
                <p class="text-xs text-slate-500 mt-0.5">Daftar usulan penerima terakhir yang terdaftar dalam basis data</p>
            </div>
            <a 
                href="{{ route('admin.bnba') }}" 
                class="inline-flex items-center gap-2 px-3.5 py-2 text-xs font-bold text-white bg-gradient-to-r from-emerald-600 to-teal-600 hover:from-emerald-500 hover:to-teal-500 rounded-xl shadow-xs hover:shadow-md transition-all duration-200 transform hover:-translate-y-0.5 active:translate-y-0 shrink-0"
            >
                <span>Buka Tabel Lengkap ({{ number_format($totalSemua, 0, ',', '.') }} Data)</span>
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/>
                </svg>
            </a>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-xs text-left">
                <thead class="bg-slate-50/80 text-slate-500 font-semibold border-b border-slate-200/80">
                    <tr>
                        <th class="py-3 px-3">ID</th>
                        <th class="py-3 px-3">Nama Penerima</th>
                        <th class="py-3 px-3">NIK</th>
                        <th class="py-3 px-3">Wilayah Domisili</th>
                        <th class="py-3 px-3">Program Bantuan</th>
                        <th class="py-3 px-3">Status Verifikasi</th>
                        <th class="py-3 px-3 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @foreach ($recentPenerima as $penerima)
                        <tr class="hover:bg-emerald-50/30 transition-colors group">
                            <td class="py-3 px-3 font-mono font-medium text-slate-500">
                                <span class="px-1.5 py-0.5 rounded bg-slate-100 text-slate-700 text-[11px]">#{{ $penerima->id_bnba }}</span>
                            </td>
                            <td class="py-3 px-3">
                                <div class="flex items-center gap-2.5">
                                    <div class="w-7 h-7 rounded-lg bg-emerald-100 text-emerald-800 font-bold text-[11px] flex items-center justify-center shrink-0">
                                        {{ substr($penerima->name_bnba, 0, 1) }}
                                    </div>
                                    <span class="font-bold text-slate-900 group-hover:text-emerald-700 transition-colors">{{ $penerima->name_bnba }}</span>
                                </div>
                            </td>
                            <td class="py-3 px-3 font-mono text-slate-600">
                                {{ strlen($penerima->bnba_nik) >= 16 ? substr($penerima->bnba_nik, 0, 6) . '******' . substr($penerima->bnba_nik, -4) : $penerima->bnba_nik }}
                            </td>
                            <td class="py-3 px-3 text-slate-700">
                                <span class="font-semibold text-slate-800">DESA {{ $penerima->xkel }}</span>, <span class="text-slate-500">KEC. {{ $penerima->xkec }}</span>
                            </td>
                            <td class="py-3 px-3">
                                @if (str_contains($penerima->cat_bnba, 'APBD'))
                                    <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-[11px] font-bold bg-emerald-50 text-emerald-700 border border-emerald-200">
                                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                                        RTLH APBD
                                    </span>
                                @else
                                    <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-[11px] font-bold bg-sky-50 text-sky-700 border border-sky-200">
                                        <span class="w-1.5 h-1.5 rounded-full bg-sky-500"></span>
                                        BSPS
                                    </span>
                                @endif
                            </td>
                            <td class="py-3 px-3">
                                <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full text-[11px] font-bold bg-amber-50 text-amber-800 border border-amber-200">
                                    <span class="w-1.5 h-1.5 rounded-full bg-amber-500"></span>
                                    {{ $penerima->st_akhir }}
                                </span>
                            </td>
                            <td class="py-3 px-3 text-right">
                                <a 
                                    href="{{ route('admin.bnba', ['q' => $penerima->name_bnba]) }}" 
                                    class="inline-flex items-center gap-1 text-xs font-bold text-emerald-600 hover:text-emerald-800 hover:underline"
                                >
                                    <span>Detail</span>
                                    <span>&rarr;</span>
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

</div>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', () => {
        // 1. Animasi Counter Angka Berjalan (Rolling Numbers)
        const counters = document.querySelectorAll('.counter-number');
        counters.forEach(counter => {
            const target = parseInt(counter.getAttribute('data-target'), 10);
            if (isNaN(target) || target === 0) {
                counter.innerText = '0';
                return;
            }

            const duration = 1200; // ms
            const startTime = performance.now();

            function updateCounter(currentTime) {
                const elapsed = currentTime - startTime;
                const progress = Math.min(elapsed / duration, 1);
                
                // Ease out expo formula for premium dashboard feel
                const easeOut = progress === 1 ? 1 : 1 - Math.pow(2, -10 * progress);
                const currentVal = Math.floor(easeOut * target);

                counter.innerText = currentVal.toLocaleString('id-ID');

                if (progress < 1) {
                    requestAnimationFrame(updateCounter);
                } else {
                    counter.innerText = target.toLocaleString('id-ID');
                }
            }

            requestAnimationFrame(updateCounter);
        });

        // 2. Animasi Lebar Bar Progres (Progress Bar Animation)
        setTimeout(() => {
            const progressBars = document.querySelectorAll('.progress-bar-fill');
            progressBars.forEach(bar => {
                const width = bar.getAttribute('data-width');
                if (width) {
                    bar.style.width = width;
                }
            });
        }, 150);
    });
</script>
@endpush
@endsection
