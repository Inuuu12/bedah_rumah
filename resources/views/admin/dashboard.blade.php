@extends('admin.layout')

@section('title', 'Dashboard')
@section('header_title', 'Ringkasan Dashboard')
@section('header_subtitle', 'Statistik dan sebaran program bantuan perumahan Kabupaten Bogor')

@section('content')
<div class="space-y-6">

    {{-- Clean Institutional Action Header --}}
    <div class="bg-white rounded-xl border border-slate-200 p-5 flex flex-col sm:flex-row sm:items-center justify-between gap-4 shadow-xs">
        <div>
            <h3 class="text-base font-bold text-slate-900">Sistem Monitoring Bedah Rumah Kab. Bogor</h3>
            <p class="text-xs text-slate-500 mt-0.5">
                Rekapitulasi data usulan dan realisasi bantuan Rumah Tidak Layak Huni (RTLH APBD &amp; BSPS Nasional).
            </p>
        </div>
    </div>

    {{-- KPI Metric Cards --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
        
        {{-- Card 1: Total Penerima --}}
        <div class="bg-white rounded-xl border border-slate-200 p-4 shadow-xs">
            <div class="flex items-center justify-between">
                <span class="text-[11px] font-semibold text-slate-500 uppercase tracking-wider">Total Penerima </span>
                <span class="p-1.5 rounded-lg bg-slate-100 text-slate-600">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                    </svg>
                </span>
            </div>
            <div class="mt-3">
                <div class="flex items-baseline gap-1.5">
                    <span class="text-2xl font-extrabold text-slate-900 tracking-tight">
                        {{ number_format($totalSemua, 0, ',', '.') }}
                    </span>
                    <span class="text-xs text-slate-500 font-medium">Rumah</span>
                </div>
            </div>
        </div>

        {{-- Card 2: RTLH APBD BOGOR --}}
        <div class="bg-white rounded-xl border border-slate-200 p-4 shadow-xs">
            <div class="flex items-center justify-between">
                <span class="text-[11px] font-semibold text-emerald-700 uppercase tracking-wider">RTLH APBD BOGOR</span>
                <span class="p-1.5 rounded-lg bg-emerald-50 text-emerald-700 border border-emerald-100">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                    </svg>
                </span>
            </div>
            <div class="mt-3">
                <div class="flex items-baseline gap-1.5">
                    <span class="text-2xl font-extrabold text-emerald-800 tracking-tight">
                        {{ number_format($totalRtlh, 0, ',', '.') }}
                    </span>
                    <span class="text-xs text-slate-500 font-medium">Rumah</span>
                </div>
                <div class="mt-1 flex items-center justify-between text-[11px]">
                </div>
            </div>
        </div>

        {{-- Card 3: BSPS NASIONAL --}}
        <div class="bg-white rounded-xl border border-slate-200 p-4 shadow-xs">
            <div class="flex items-center justify-between">
                <span class="text-[11px] font-semibold text-sky-700 uppercase tracking-wider">BSPS KEMENPERA</span>
                <span class="p-1.5 rounded-lg bg-sky-50 text-sky-700 border border-sky-100">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 14v3m4-3v3m4-3v3M3 21h18M3 10h18M3 7l9-4 9 4M4 10h16v11H4V10z"/>
                    </svg>
                </span>
            </div>
            <div class="mt-3">
                <div class="flex items-baseline gap-1.5">
                    <span class="text-2xl font-extrabold text-sky-800 tracking-tight">
                        {{ number_format($totalBsps, 0, ',', '.') }}
                    </span>
                    <span class="text-xs text-slate-500 font-medium">Rumah</span>
                </div>
                <div class="mt-1 flex items-center justify-between text-[11px]">
                </div>
            </div>
        </div>

        {{-- Card 4: Cakupan Wilayah --}}
        <div class="bg-white rounded-xl border border-slate-200 p-4 shadow-xs">
            <div class="flex items-center justify-between">
                <span class="text-[11px] font-semibold text-slate-600 uppercase tracking-wider">Cakupan Wilayah</span>
                <span class="p-1.5 rounded-lg bg-amber-50 text-amber-700 border border-amber-100">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                    </svg>
                </span>
            </div>
            <div class="mt-3">
                <div class="flex items-baseline gap-1.5">
                    <span class="text-2xl font-extrabold text-slate-900 tracking-tight">
                        {{ $totalKecamatan }}
                    </span>
                    <span class="text-xs text-slate-500 font-medium">Kecamatan</span>
                </div>
            </div>
        </div>

    </div>

    {{-- Distribusi Program & Status Pelaksanaan (Memanjang ke Samping / Full-Width) --}}
    <div class="bg-white rounded-xl border border-slate-200 p-5 sm:p-6 shadow-xs space-y-6">
        
        {{-- Section Header --}}
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 pb-4 border-b border-slate-200">
            <div>
                <h4 class="text-base font-bold text-slate-900 flex items-center gap-2">
                    <span>Distribusi Program &amp; Status Pelaksanaan</span>
                </h4>
                <p class="text-xs text-slate-500 mt-0.5">Alokasi kuota dan progres tahapan pelaksanaan bantuan RTLH APBD Kab. Bogor dan BSPS Nasional</p>
            </div>
        </div>

        {{-- 1. Komparasi Alokasi Program (Visual Proportion Bar & Info Cards) --}}
        <div>
            @php
                $pctRtlh = $totalSemua > 0 ? round(($totalRtlh / $totalSemua) * 100, 1) : 0;
                $pctBsps = $totalSemua > 0 ? round(($totalBsps / $totalSemua) * 100, 1) : 0;
            @endphp

            <div class="flex items-center justify-between text-xs font-semibold mb-2">
                <div class="flex items-center gap-2">
                    <span class="text-emerald-800">RTLH APBD Kab. Bogor</span>
                </div>
                <div class="flex items-center gap-2">
                    <span class="text-sky-800">BSPS Kemenpera</span>
                </div>
            </div>

            {{-- Visual Bar --}}
            <div class="w-full bg-slate-100 rounded-full h-3.5 flex overflow-hidden p-0.5 border border-slate-200">
                <div class="bg-emerald-600 h-full rounded-l-full transition-all duration-500" style="width: {{ $pctRtlh }}%" title="RTLH APBD: {{ $pctRtlh }}% ({{ number_format($totalRtlh, 0, ',', '.') }} unit)"></div>
                <div class="bg-sky-600 h-full rounded-r-full transition-all duration-500" style="width: {{ $pctBsps }}%" title="BSPS: {{ $pctBsps }}% ({{ number_format($totalBsps, 0, ',', '.') }} unit)"></div>
            </div>
        </div>

        {{-- 2. Status Pelaksanaan: RTLH dan BSPS Dibedain di Sebelahan (Side by Side) --}}
        <div>
            <div class="flex items-center gap-2 mb-3">
                <span class="text-xs font-bold text-slate-800 uppercase tracking-wider">Status Pelaksanaan Per Program:</span>
                <span class="text-[11px] text-slate-500">(Rincian tahapan Persiapan, Pembangunan, dan Selesai)</span>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-5">
                
                {{-- Kiri: Status Pelaksanaan RTLH APBD --}}
                <div class="rounded-xl border-2 border-emerald-200/80 bg-white p-4 sm:p-5 shadow-2xs space-y-4">
                    <div class="flex items-center justify-between pb-3 border-b border-emerald-100">
                        <div class="flex items-center gap-2.5">
                            <span class="w-8 h-8 rounded-lg bg-emerald-100 text-emerald-800 flex items-center justify-center font-bold">
                                <svg class="w-4 h-4 text-emerald-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                                </svg>
                            </span>
                            <div>
                                <h5 class="text-sm font-bold text-slate-900">Status Pelaksanaan RTLH</h5>
                            </div>
                        </div>
                    </div>

                    {{-- 3 Kartu Status RTLH --}}
                    @php
                        $rtlhPersiapan = $statusRtlh['PERSIAPAN'] ?? 0;
                        $rtlhProses = $statusRtlh['PROSES'] ?? 0;
                        $rtlhSelesai = $statusRtlh['SELESAI'] ?? 0;
                        $pctRtlhPersiapan = $totalRtlh > 0 ? round(($rtlhPersiapan / $totalRtlh) * 100, 1) : 0;
                        $pctRtlhProses = $totalRtlh > 0 ? round(($rtlhProses / $totalRtlh) * 100, 1) : 0;
                        $pctRtlhSelesai = $totalRtlh > 0 ? round(($rtlhSelesai / $totalRtlh) * 100, 1) : 0;
                    @endphp

                    <div class="grid grid-cols-3 gap-2.5 text-center">
                        {{-- Persiapan --}}
                        <div class="p-3 bg-amber-50/80 rounded-xl border border-amber-200">
                            <span class="text-[10px] font-bold text-amber-800 uppercase tracking-wider block">Persiapan</span>
                            <span class="text-lg font-extrabold text-amber-900 mt-1 block">
                                {{ number_format($rtlhPersiapan, 0, ',', '.') }}
                            </span>
                        </div>

                        {{-- Proses --}}
                        <div class="p-3 bg-blue-50/80 rounded-xl border border-blue-200">
                            <span class="text-[10px] font-bold text-blue-800 uppercase tracking-wider block">Pembangunan</span>
                            <span class="text-lg font-extrabold text-blue-900 mt-1 block">
                                {{ number_format($rtlhProses, 0, ',', '.') }}
                            </span>
                        </div>

                        {{-- Selesai --}}
                        <div class="p-3 bg-emerald-50/80 rounded-xl border border-emerald-200">
                            <span class="text-[10px] font-bold text-emerald-800 uppercase tracking-wider block">Selesai</span>
                            <span class="text-lg font-extrabold text-emerald-900 mt-1 block">
                                {{ number_format($rtlhSelesai, 0, ',', '.') }}
                            </span>
                        </div>
                    </div>                    
                </div>

                {{-- Kanan: Status Pelaksanaan BSPS --}}
                <div class="rounded-xl border-2 border-sky-200/80 bg-white p-4 sm:p-5 shadow-2xs space-y-4">
                    <div class="flex items-center justify-between pb-3 border-b border-sky-100">
                        <div class="flex items-center gap-2.5">
                            <span class="w-8 h-8 rounded-lg bg-sky-100 text-sky-800 flex items-center justify-center font-bold">
                                <svg class="w-4 h-4 text-sky-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 14v3m4-3v3m4-3v3M3 21h18M3 10h18M3 7l9-4 9 4M4 10h16v11H4V10z"/>
                                </svg>
                            </span>
                            <div>
                                <h5 class="text-sm font-bold text-slate-900">Status Pelaksanaan BSPS</h5>
                            </div>
                        </div>
                    </div>

                    {{-- 3 Kartu Status BSPS --}}
                    @php
                        $bspsPersiapan = $statusBsps['PERSIAPAN'] ?? 0;
                        $bspsProses = $statusBsps['PROSES'] ?? 0;
                        $bspsSelesai = $statusBsps['SELESAI'] ?? 0;
                        $pctBspsPersiapan = $totalBsps > 0 ? round(($bspsPersiapan / $totalBsps) * 100, 1) : 0;
                        $pctBspsProses = $totalBsps > 0 ? round(($bspsProses / $totalBsps) * 100, 1) : 0;
                        $pctBspsSelesai = $totalBsps > 0 ? round(($bspsSelesai / $totalBsps) * 100, 1) : 0;
                    @endphp

                    <div class="grid grid-cols-3 gap-2.5 text-center">
                        {{-- Persiapan --}}
                        <div class="p-3 bg-amber-50/80 rounded-xl border border-amber-200">
                            <span class="text-[10px] font-bold text-amber-800 uppercase tracking-wider block">Persiapan</span>
                            <span class="text-lg font-extrabold text-amber-900 mt-1 block">
                                {{ number_format($bspsPersiapan, 0, ',', '.') }}
                            </span>
                        </div>

                        {{-- Proses --}}
                        <div class="p-3 bg-blue-50/80 rounded-xl border border-blue-200">
                            <span class="text-[10px] font-bold text-blue-800 uppercase tracking-wider block">Pembangunan</span>
                            <span class="text-lg font-extrabold text-blue-900 mt-1 block">
                                {{ number_format($bspsProses, 0, ',', '.') }}
                            </span>
                        </div>

                        {{-- Selesai --}}
                        <div class="p-3 bg-emerald-50/80 rounded-xl border border-emerald-200">
                            <span class="text-[10px] font-bold text-emerald-800 uppercase tracking-wider block">Selesai</span>
                            <span class="text-lg font-extrabold text-emerald-900 mt-1 block">
                                {{ number_format($bspsSelesai, 0, ',', '.') }}
                            </span>
                        </div>
                    </div>

                    {{-- Mini Breakdown Bar BSPS --}}
                    
                </div>

            </div>
        </div>
    </div>

    {{-- 10 Kecamatan Alokasi Terbanyak: 2 Tabel Kiri-Kanan (RTLH APBD vs BSPS Nasional) --}}
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">

        {{-- 1. TABEL KIRI: PROGRAM RTLH (APBD KABUPATEN BOGOR) --}}
        <div class="bg-white rounded-xl border border-slate-200 p-5 shadow-xs flex flex-col justify-between">
            <div>
                <div class="flex items-center justify-between pb-3 border-b border-slate-200">
                    <div class="flex items-center gap-3">
                        <div class="w-9 h-9 rounded-lg bg-teal-50 border border-teal-200 flex items-center justify-center shrink-0">
                            <img src="{{ asset('images/lambang-kabupaten-bogor.svg') }}" alt="Logo Kab. Bogor" class="h-6 w-auto object-contain">
                        </div>
                        <div>
                            <h4 class="text-sm font-bold text-slate-900">Top 10 Alokasi RTLH (APBD)</h4>
                            <p class="text-[11px] text-slate-500">Kuota bantuan tertinggi RTLH APBD Kab. Bogor</p>
                        </div>
                    </div>
                    <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[10px] font-extrabold bg-teal-50 text-teal-800 border border-teal-200">
                        APBD BOGOR
                    </span>
                </div>

                <div class="overflow-x-auto mt-3">
                    <table class="w-full text-xs text-left">
                        <thead class="bg-slate-50 text-slate-600 font-bold border-b border-slate-200 text-[11px]">
                            <tr>
                                <th class="py-2.5 px-3 text-center w-10">No</th>
                                <th class="py-2.5 px-3">Kecamatan</th>
                                <th class="py-2.5 px-3 text-center">Persiapan</th>
                                <th class="py-2.5 px-3 text-center">Pembangunan</th>
                                <th class="py-2.5 px-3 text-center">Selesai</th>
                                <th class="py-2.5 px-3 text-right">Total</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100 text-slate-700">
                            @forelse ($topKecamatanRtlh as $index => $kec)
                                <tr class="hover:bg-teal-50/30 transition-colors">
                                    <td class="py-2.5 px-3 text-center text-slate-500 font-mono font-bold">
                                        {{ $index + 1 }}
                                    </td>
                                    <td class="py-2.5 px-3 font-semibold text-slate-900">
                                        KEC. {{ $kec->xkec }}
                                    </td>
                                    <td class="py-2.5 px-3 text-center">
                                        <span class="inline-block px-2 py-0.5 rounded-md text-[11px] font-bold bg-amber-50 text-amber-700 border border-amber-200/80">
                                            {{ number_format($kec->persiapan ?? 0, 0, ',', '.') }}
                                        </span>
                                    </td>
                                    <td class="py-2.5 px-3 text-center">
                                        <span class="inline-block px-2 py-0.5 rounded-md text-[11px] font-bold bg-blue-50 text-blue-700 border border-blue-200/80">
                                            {{ number_format($kec->proses, 0, ',', '.') }}
                                        </span>
                                    </td>
                                    <td class="py-2.5 px-3 text-center">
                                        <span class="inline-block px-2 py-0.5 rounded-md text-[11px] font-bold bg-emerald-50 text-emerald-700 border border-emerald-200/80">
                                            {{ number_format($kec->selesai, 0, ',', '.') }}
                                        </span>
                                    </td>
                                    <td class="py-2.5 px-3 text-right font-extrabold text-slate-900 font-mono">
                                        {{ number_format($kec->total, 0, ',', '.') }}
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="py-4 text-center text-slate-400">
                                        Tidak ada data alokasi RTLH
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="pt-3 border-t border-slate-100 mt-3 flex items-center justify-between text-[11px] text-slate-400">
                <span>Program Bantuan Pemkab Bogor</span>
                <a href="{{ route('admin.bnba', ['program' => 'RTLH']) }}" class="text-teal-700 hover:text-teal-900 font-bold hover:underline">
                    Lihat Rincian RTLH
                </a>
            </div>
        </div>

        {{-- 2. TABEL KANAN: PROGRAM BSPS (KEMENPERA NASIONAL) --}}
        <div class="bg-white rounded-xl border border-slate-200 p-5 shadow-xs flex flex-col justify-between">
            <div>
                <div class="flex items-center justify-between pb-3 border-b border-slate-200">
                    <div class="flex items-center gap-3">
                        <div class="w-9 h-9 rounded-lg bg-blue-50 border border-blue-200 flex items-center justify-center shrink-0">
                            <img src="{{ asset('images/logo-kemenpera.svg') }}" alt="Logo Kemenpera" class="h-6 w-auto object-contain">
                        </div>
                        <div>
                            <h4 class="text-sm font-bold text-slate-900">Top 10 Alokasi BSPS (Nasional)</h4>
                            <p class="text-[11px] text-slate-500">Kuota bantuan tertinggi BSPS Kemenpera</p>
                        </div>
                    </div>
                    <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[10px] font-extrabold bg-blue-50 text-blue-800 border border-blue-200">
                        BSPS PUSAT
                    </span>
                </div>

                <div class="overflow-x-auto mt-3">
                    <table class="w-full text-xs text-left">
                        <thead class="bg-slate-50 text-slate-600 font-bold border-b border-slate-200 text-[11px]">
                            <tr>
                                <th class="py-2.5 px-3 text-center w-10">No</th>
                                <th class="py-2.5 px-3">Kecamatan</th>
                                <th class="py-2.5 px-3 text-center">Persiapan</th>
                                <th class="py-2.5 px-3 text-center">Pembangunan</th>
                                <th class="py-2.5 px-3 text-center">Selesai</th>
                                <th class="py-2.5 px-3 text-right">Total</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100 text-slate-700">
                            @forelse ($topKecamatanBsps as $index => $kec)
                                <tr class="hover:bg-blue-50/30 transition-colors">
                                    <td class="py-2.5 px-3 text-center text-slate-500 font-mono font-bold">
                                        {{ $index + 1 }}
                                    </td>
                                    <td class="py-2.5 px-3 font-semibold text-slate-900">
                                        KEC. {{ $kec->xkec }}
                                    </td>
                                    <td class="py-2.5 px-3 text-center">
                                        <span class="inline-block px-2 py-0.5 rounded-md text-[11px] font-bold bg-amber-50 text-amber-700 border border-amber-200/80">
                                            {{ number_format($kec->persiapan ?? 0, 0, ',', '.') }}
                                        </span>
                                    </td>
                                    <td class="py-2.5 px-3 text-center">
                                        <span class="inline-block px-2 py-0.5 rounded-md text-[11px] font-bold bg-blue-50 text-blue-700 border border-blue-200/80">
                                            {{ number_format($kec->proses, 0, ',', '.') }}
                                        </span>
                                    </td>
                                    <td class="py-2.5 px-3 text-center">
                                        <span class="inline-block px-2 py-0.5 rounded-md text-[11px] font-bold bg-emerald-50 text-emerald-700 border border-emerald-200/80">
                                            {{ number_format($kec->selesai, 0, ',', '.') }}
                                        </span>
                                    </td>
                                    <td class="py-2.5 px-3 text-right font-extrabold text-slate-900 font-mono">
                                        {{ number_format($kec->total, 0, ',', '.') }}
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="py-4 text-center text-slate-400">
                                        Tidak ada data alokasi BSPS
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="pt-3 border-t border-slate-100 mt-3 flex items-center justify-between text-[11px] text-slate-400">
                <span>Program Kementerian RI</span>
                <a href="{{ route('admin.bnba', ['program' => 'BSPS']) }}" class="text-blue-700 hover:text-blue-900 font-bold hover:underline">
                    Lihat Rincian BSPS
                </a>
            </div>
        </div>

    </div>

    {{-- Penerima Bantuan Terbaru --}}
    <div class="bg-white rounded-xl border border-slate-200 p-5 shadow-xs">
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 pb-3 border-b border-slate-200">
            <div>
                <h4 class="text-sm font-bold text-slate-900">Data Penerima Terbaru</h4>
                <p class="text-xs text-slate-500">Daftar usulan penerima terakhir yang terdaftar.</p>
            </div>
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
                            <td class="py-2.5 px-3 font-mono text-slate-600 text-xs">
                                @php
                                    $dNik = trim((string) $penerima->bnba_nik);
                                    $dLen = strlen($dNik);
                                @endphp
                                {{ $dLen > 4 ? substr($dNik, 0, 2) . str_repeat('*', $dLen - 4) . substr($dNik, -2) : ($dNik ?: '-') }}
                            </td>
                            <td class="py-2.5 px-3 text-slate-700">
                                <span class="font-medium text-slate-800">Desa {{ $penerima->xkel }}</span>, <span class="text-slate-500">Kec. {{ $penerima->xkec }}</span>
                            </td>
                            <td class="py-2.5 px-3">
                                @if (str_contains($penerima->cat_bnba, 'APBD'))
                                    <span class="inline-block px-2 py-0.5 rounded text-[11px] font-semibold bg-emerald-50 text-emerald-800 border border-emerald-200">
                                        RTLH APBD
                                    </span>
                                @else
                                    <span class="inline-block px-2 py-0.5 rounded text-[11px] font-semibold bg-sky-50 text-sky-800 border border-sky-200">
                                        BSPS
                                    </span>
                                @endif
                            </td>
                            <td class="py-2.5 px-3">
                                @if ($penerima->st_akhir === 'SELESAI')
                                    <span class="inline-block px-2 py-0.5 rounded text-[11px] font-semibold bg-emerald-50 text-emerald-800 border border-emerald-200">
                                        SELESAI
                                    </span>
                                @elseif ($penerima->st_akhir === 'PROSES')
                                    <span class="inline-block px-2 py-0.5 rounded text-[11px] font-semibold bg-blue-50 text-blue-800 border border-blue-200">
                                        PROSES
                                    </span>
                                @else
                                    <span class="inline-block px-2 py-0.5 rounded text-[11px] font-semibold bg-amber-50 text-amber-800 border border-amber-200">
                                        PERSIAPAN
                                    </span>
                                @endif
                            </td>
                            <td class="py-2.5 px-3 text-center">
                                <a 
                                    href="{{ route('admin.bnba', ['q' => $penerima->name_bnba]) }}" 
                                    class="text-xs font-semibold text-emerald-700 hover:text-emerald-900 hover:underline"
                                >
                                    Detail
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

</div>

{{-- Modal Tambah Data Rumah --}}
@include('admin.bnba.create-modal')
@endsection
