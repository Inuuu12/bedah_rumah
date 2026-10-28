@extends('admin.layout')

@section('title', 'Dashboard')
@section('header_title', 'Ringkasan Dashboard')
@section('header_subtitle', 'Statistik dan sebaran program bantuan perumahan Kabupaten Bogor')

@section('content')
<div class="space-y-6">

    {{-- Clean Institutional Action Header --}}
    <div class="bg-white rounded-lg border border-slate-200 p-5 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h3 class="text-base font-bold text-slate-900">Sistem Monitoring Bedah Rumah Kab. Bogor</h3>
            <p class="text-xs text-slate-500 mt-0.5">
                Rekapitulasi data usulan dan realisasi bantuan Rumah Tidak Layak Huni (RTLH APBD &amp; BSPS Nasional).
            </p>
        </div>
        <div class="flex items-center gap-2 shrink-0">
            <a 
                href="{{ route('admin.bnba') }}" 
                class="inline-flex items-center gap-1.5 px-3.5 py-2 bg-teal-700 hover:bg-teal-800 text-white font-medium text-xs rounded-lg transition-colors"
            >
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                </svg>
                <span>Kelola Data BNBA</span>
            </a>
            <a 
                href="{{ route('home') }}" 
                target="_blank" 
                class="inline-flex items-center gap-1.5 px-3 py-2 bg-slate-100 hover:bg-slate-200 text-slate-700 font-medium text-xs rounded-lg border border-slate-300 transition-colors"
            >
                <span>Peta Publik</span>
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/>
                </svg>
            </a>
        </div>
    </div>

    {{-- KPI Metric Cards (Clean Flat Institutional Style) --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
        
        {{-- Card 1: Total Penerima --}}
        <div class="bg-white rounded-lg border border-slate-200 p-4">
            <div class="flex items-center justify-between">
                <span class="text-[11px] font-semibold text-slate-500 uppercase tracking-wider">Total Penerima BNBA</span>
                <span class="p-1.5 rounded bg-slate-100 text-slate-600">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                    </svg>
                </span>
            </div>
            <div class="mt-3">
                <div class="flex items-baseline gap-1.5">
                    <span class="text-2xl font-bold text-slate-900 tracking-tight">
                        {{ number_format($totalSemua, 0, ',', '.') }}
                    </span>
                    <span class="text-xs text-slate-500 font-medium">Rumah</span>
                </div>
                <p class="text-[11px] text-slate-500 mt-1">Total data sasaran terdaftar</p>
            </div>
        </div>

        {{-- Card 2: RTLH APBD BOGOR --}}
        <div class="bg-white rounded-lg border border-slate-200 p-4">
            <div class="flex items-center justify-between">
                <span class="text-[11px] font-semibold text-teal-700 uppercase tracking-wider">RTLH APBD BOGOR</span>
                <span class="p-1.5 rounded bg-teal-50 text-teal-700">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                    </svg>
                </span>
            </div>
            <div class="mt-3">
                <div class="flex items-baseline gap-1.5">
                    <span class="text-2xl font-bold text-teal-800 tracking-tight">
                        {{ number_format($totalRtlh, 0, ',', '.') }}
                    </span>
                    <span class="text-xs text-slate-500 font-medium">Rumah</span>
                </div>
                <div class="mt-1 flex items-center justify-between text-[11px]">
                    <span class="text-slate-500">APBD Kab. Bogor</span>
                    <span class="font-semibold text-teal-700">
                        {{ $totalSemua > 0 ? round(($totalRtlh / $totalSemua) * 100, 1) : 0 }}%
                    </span>
                </div>
            </div>
        </div>

        {{-- Card 3: BSPS NASIONAL --}}
        <div class="bg-white rounded-lg border border-slate-200 p-4">
            <div class="flex items-center justify-between">
                <span class="text-[11px] font-semibold text-sky-700 uppercase tracking-wider">BSPS KEMENPERA</span>
                <span class="p-1.5 rounded bg-sky-50 text-sky-700">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 14v3m4-3v3m4-3v3M3 21h18M3 10h18M3 7l9-4 9 4M4 10h16v11H4V10z"/>
                    </svg>
                </span>
            </div>
            <div class="mt-3">
                <div class="flex items-baseline gap-1.5">
                    <span class="text-2xl font-bold text-sky-800 tracking-tight">
                        {{ number_format($totalBsps, 0, ',', '.') }}
                    </span>
                    <span class="text-xs text-slate-500 font-medium">Rumah</span>
                </div>
                <div class="mt-1 flex items-center justify-between text-[11px]">
                    <span class="text-slate-500">Stimulan APBN</span>
                    <span class="font-semibold text-sky-700">
                        {{ $totalSemua > 0 ? round(($totalBsps / $totalSemua) * 100, 1) : 0 }}%
                    </span>
                </div>
            </div>
        </div>

        {{-- Card 4: Cakupan Wilayah --}}
        <div class="bg-white rounded-lg border border-slate-200 p-4">
            <div class="flex items-center justify-between">
                <span class="text-[11px] font-semibold text-slate-600 uppercase tracking-wider">Cakupan Wilayah</span>
                <span class="p-1.5 rounded bg-amber-50 text-amber-700">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                    </svg>
                </span>
            </div>
            <div class="mt-3">
                <div class="flex items-baseline gap-1.5">
                    <span class="text-2xl font-bold text-slate-900 tracking-tight">
                        {{ $totalKecamatan }}
                    </span>
                    <span class="text-xs text-slate-500 font-medium">Kecamatan</span>
                </div>
                <p class="text-[11px] text-slate-500 mt-1">
                    Tersebar di <span class="font-semibold text-slate-700">{{ $totalDesa }}</span> Desa/Kelurahan
                </p>
            </div>
        </div>

    </div>

    {{-- Grid 2 Kolom: Rekapitulasi Program & Top Kecamatan --}}
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        
        {{-- Kolom Kiri: Distribusi Program & Status Progres --}}
        <div class="bg-white rounded-lg border border-slate-200 p-5 flex flex-col justify-between">
            <div>
                <div class="pb-3 border-b border-slate-200">
                    <h4 class="text-sm font-bold text-slate-900">Distribusi Program &amp; Status</h4>
                    <p class="text-xs text-slate-500">Komparasi alokasi dan progres pelaksanaan bantuan</p>
                </div>

                {{-- Stacked Proportion Bar --}}
                <div class="mt-4">
                    @php
                        $pctRtlh = $totalSemua > 0 ? round(($totalRtlh / $totalSemua) * 100, 1) : 0;
                        $pctBsps = $totalSemua > 0 ? round(($totalBsps / $totalSemua) * 100, 1) : 0;
                    @endphp
                    <div class="flex items-center justify-between text-xs font-medium mb-1.5">
                        <span class="text-teal-800">RTLH APBD ({{ $pctRtlh }}%)</span>
                        <span class="text-sky-800">BSPS ({{ $pctBsps }}%)</span>
                    </div>

                    <div class="w-full bg-slate-100 rounded h-2.5 flex overflow-hidden">
                        <div class="bg-teal-700 h-full" style="width: {{ $pctRtlh }}%" title="RTLH APBD: {{ $pctRtlh }}%"></div>
                        <div class="bg-sky-600 h-full" style="width: {{ $pctBsps }}%" title="BSPS Nasional: {{ $pctBsps }}%"></div>
                    </div>
                </div>

                {{-- Breakdown Rinci --}}
                <div class="mt-4 space-y-2 text-xs">
                    <div class="flex justify-between items-center p-2.5 rounded bg-slate-50 border border-slate-200">
                        <span class="text-slate-700 font-medium">RTLH APBD Kab. Bogor</span>
                        <span class="font-bold text-teal-800">{{ number_format($totalRtlh, 0, ',', '.') }} unit</span>
                    </div>
                    <div class="flex justify-between items-center p-2.5 rounded bg-slate-50 border border-slate-200">
                        <span class="text-slate-700 font-medium">BSPS Kemenpera (Pusat)</span>
                        <span class="font-bold text-sky-800">{{ number_format($totalBsps, 0, ',', '.') }} unit</span>
                    </div>
                </div>

                {{-- Status Box Tahapan --}}
                <div class="mt-5 pt-4 border-t border-slate-200">
                    <span class="text-[11px] font-semibold text-slate-500 uppercase tracking-wider block mb-2">Status Pelaksanaan:</span>
                    <div class="grid grid-cols-3 gap-2 text-center text-xs">
                        <div class="p-2 bg-amber-50 rounded border border-amber-200">
                            <span class="text-[10px] font-bold text-amber-800 uppercase block">Persiapan</span>
                            <span class="text-sm font-bold text-amber-900 mt-0.5 block">
                                {{ number_format($statusCounts['PERSIAPAN'] ?? 0, 0, ',', '.') }}
                            </span>
                        </div>
                        <div class="p-2 bg-blue-50 rounded border border-blue-200">
                            <span class="text-[10px] font-bold text-blue-800 uppercase block">Proses</span>
                            <span class="text-sm font-bold text-blue-900 mt-0.5 block">
                                {{ number_format($statusCounts['PROSES'] ?? 0, 0, ',', '.') }}
                            </span>
                        </div>
                        <div class="p-2 bg-teal-50 rounded border border-teal-200">
                            <span class="text-[10px] font-bold text-teal-800 uppercase block">Selesai</span>
                            <span class="text-sm font-bold text-teal-900 mt-0.5 block">
                                {{ number_format($statusCounts['SELESAI'] ?? 0, 0, ',', '.') }}
                            </span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="mt-5 pt-3 border-t border-slate-200">
                <a 
                    href="{{ route('admin.bnba') }}" 
                    class="w-full flex items-center justify-center gap-1.5 py-2 px-3 text-xs font-semibold text-teal-700 bg-teal-50 hover:bg-teal-100 rounded border border-teal-200 transition-colors"
                >
                    <span>Buka Data BNBA</span>
                    <span>&rarr;</span>
                </a>
            </div>
        </div>

        {{-- Kolom Kanan: Top 5 Kecamatan --}}
        <div class="bg-white rounded-lg border border-slate-200 p-5 lg:col-span-2 flex flex-col justify-between">
            <div>
                <div class="flex items-center justify-between pb-3 border-b border-slate-200">
                    <div>
                        <h4 class="text-sm font-bold text-slate-900">5 Kecamatan dengan Alokasi Terbanyak</h4>
                        <p class="text-xs text-slate-500">Daftar wilayah dengan jumlah kuota bantuan tertinggi</p>
                    </div>
                    <a 
                        href="{{ route('admin.wilayah') }}" 
                        class="text-xs font-medium text-teal-700 hover:text-teal-900 hover:underline"
                    >
                        Lihat 40 Kecamatan &rarr;
                    </a>
                </div>

                <div class="overflow-x-auto mt-3">
                    <table class="w-full text-xs text-left">
                        <thead class="bg-slate-50 text-slate-600 font-semibold border-b border-slate-200">
                            <tr>
                                <th class="py-2.5 px-3 text-center w-12">No</th>
                                <th class="py-2.5 px-3">Kecamatan</th>
                                <th class="py-2.5 px-3 text-right">Jumlah Penerima</th>
                                <th class="py-2.5 px-3">Persentase</th>
                                <th class="py-2.5 px-3 text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">
                            @foreach ($topKecamatan as $index => $kec)
                                @php
                                    $pct = $totalSemua > 0 ? round(($kec->total / $totalSemua) * 100, 1) : 0;
                                @endphp
                                <tr class="hover:bg-slate-50 transition-colors">
                                    <td class="py-2.5 px-3 text-center text-slate-500 font-mono">
                                        {{ $index + 1 }}
                                    </td>
                                    <td class="py-2.5 px-3 font-semibold text-slate-900">
                                        KEC. {{ $kec->xkec }}
                                    </td>
                                    <td class="py-2.5 px-3 text-right font-bold text-slate-900">
                                        {{ number_format($kec->total, 0, ',', '.') }}
                                        <span class="text-slate-500 font-normal ml-0.5">unit</span>
                                    </td>
                                    <td class="py-2.5 px-3">
                                        <div class="flex items-center gap-2">
                                            <div class="w-24 bg-slate-100 rounded h-1.5 overflow-hidden">
                                                <div class="bg-teal-700 h-1.5 rounded" style="width: {{ min(100, $pct * 6) }}%"></div>
                                            </div>
                                            <span class="text-slate-600 text-[11px] font-mono">{{ $pct }}%</span>
                                        </div>
                                    </td>
                                    <td class="py-2.5 px-3 text-center">
                                        <a 
                                            href="{{ route('admin.bnba', ['kecamatan' => $kec->id_kec]) }}" 
                                            class="inline-block px-2 py-1 text-[11px] font-medium text-teal-700 bg-teal-50 hover:bg-teal-100 rounded border border-teal-200 transition-colors"
                                        >
                                            Filter Data
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="mt-4 pt-3 border-t border-slate-200 flex items-center justify-between text-xs text-slate-500">
                <span>Total 40 Kecamatan di Kab. Bogor</span>
                <a href="{{ route('admin.wilayah') }}" class="font-medium text-teal-700 hover:underline">
                    Buka Rekapitulasi Lengkap Seluruh Kecamatan &rarr;
                </a>
            </div>
        </div>
    </div>

    {{-- Penerima Bantuan Terbaru --}}
    <div class="bg-white rounded-lg border border-slate-200 p-5">
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 pb-3 border-b border-slate-200">
            <div>
                <h4 class="text-sm font-bold text-slate-900">Data Penerima Terbaru</h4>
                <p class="text-xs text-slate-500">Daftar usulan penerima terakhir yang terdaftar dalam basis data</p>
            </div>
            <a 
                href="{{ route('admin.bnba') }}" 
                class="inline-flex items-center gap-1.5 px-3 py-1.5 text-xs font-medium text-teal-700 bg-teal-50 hover:bg-teal-100 rounded border border-teal-200 transition-colors shrink-0"
            >
                <span>Buka Seluruh BNBA ({{ number_format($totalSemua, 0, ',', '.') }})</span>
                <span>&rarr;</span>
            </a>
        </div>

        <div class="overflow-x-auto mt-3">
            <table class="w-full text-xs text-left">
                <thead class="bg-slate-50 text-slate-600 font-semibold border-b border-slate-200">
                    <tr>
                        <th class="py-2.5 px-3">ID</th>
                        <th class="py-2.5 px-3">Nama Penerima</th>
                        <th class="py-2.5 px-3">NIK</th>
                        <th class="py-2.5 px-3">Wilayah Domisili</th>
                        <th class="py-2.5 px-3">Program Bantuan</th>
                        <th class="py-2.5 px-3">Status</th>
                        <th class="py-2.5 px-3 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @foreach ($recentPenerima as $penerima)
                        <tr class="hover:bg-slate-50 transition-colors">
                            <td class="py-2.5 px-3 font-mono text-slate-500 text-[11px]">
                                #{{ $penerima->id_bnba }}
                            </td>
                            <td class="py-2.5 px-3 font-semibold text-slate-900">
                                {{ $penerima->name_bnba }}
                            </td>
                            <td class="py-2.5 px-3 font-mono text-slate-600">
                                {{ strlen($penerima->bnba_nik) >= 16 ? substr($penerima->bnba_nik, 0, 6) . '******' . substr($penerima->bnba_nik, -4) : $penerima->bnba_nik }}
                            </td>
                            <td class="py-2.5 px-3 text-slate-700">
                                <span class="font-medium text-slate-800">Desa {{ $penerima->xkel }}</span>, <span class="text-slate-500">Kec. {{ $penerima->xkec }}</span>
                            </td>
                            <td class="py-2.5 px-3">
                                @if (str_contains($penerima->cat_bnba, 'APBD'))
                                    <span class="inline-block px-2 py-0.5 rounded text-[11px] font-medium bg-teal-50 text-teal-800 border border-teal-200">
                                        RTLH APBD
                                    </span>
                                @else
                                    <span class="inline-block px-2 py-0.5 rounded text-[11px] font-medium bg-sky-50 text-sky-800 border border-sky-200">
                                        BSPS
                                    </span>
                                @endif
                            </td>
                            <td class="py-2.5 px-3">
                                <span class="inline-block px-2 py-0.5 rounded text-[11px] font-medium bg-amber-50 text-amber-800 border border-amber-200">
                                    {{ $penerima->st_akhir }}
                                </span>
                            </td>
                            <td class="py-2.5 px-3 text-center">
                                <a 
                                    href="{{ route('admin.bnba', ['q' => $penerima->name_bnba]) }}" 
                                    class="text-xs font-medium text-teal-700 hover:text-teal-900 hover:underline"
                                >
                                    Detail &rarr;
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

</div>
@endsection
