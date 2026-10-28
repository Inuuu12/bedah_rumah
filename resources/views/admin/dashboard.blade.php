@extends('admin.layout')

@section('title', 'Dashboard Ringkasan')
@section('header_title', 'Ringkasan Dashboard')
@section('header_subtitle', 'Data statistik dan sebaran program bantuan perumahan Kabupaten Bogor')

@section('content')
<div class="space-y-6">

    {{-- KPI Metric Cards --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
        
        {{-- Card 1: Total Penerima --}}
        <div class="bg-white rounded-xl border border-slate-200 p-5 shadow-xs">
            <div class="flex items-center justify-between">
                <span class="text-xs font-semibold text-slate-500 uppercase tracking-wider">Total Penerima</span>
                <span class="p-2 bg-slate-100 rounded-lg text-slate-600">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                    </svg>
                </span>
            </div>
            <div class="mt-3">
                <h3 class="text-2xl font-bold text-slate-900 tracking-tight">
                    {{ number_format($totalSemua, 0, ',', '.') }}
                </h3>
                <p class="text-xs text-slate-500 mt-1">
                    Seluruh usulan data BNBA terverifikasi
                </p>
            </div>
        </div>

        {{-- Card 2: RTLH APBD --}}
        <div class="bg-white rounded-xl border border-slate-200 p-5 shadow-xs border-l-4 border-l-emerald-600">
            <div class="flex items-center justify-between">
                <span class="text-xs font-semibold text-slate-500 uppercase tracking-wider">RTLH APBD BOGOR</span>
                <span class="p-2 bg-emerald-50 rounded-lg text-emerald-600">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                    </svg>
                </span>
            </div>
            <div class="mt-3">
                <h3 class="text-2xl font-bold text-emerald-700 tracking-tight">
                    {{ number_format($totalRtlh, 0, ',', '.') }}
                </h3>
                <p class="text-xs text-slate-500 mt-1">
                    Sumber pendanaan APBD Kab. Bogor
                </p>
            </div>
        </div>

        {{-- Card 3: BSPS Nasional --}}
        <div class="bg-white rounded-xl border border-slate-200 p-5 shadow-xs border-l-4 border-l-sky-600">
            <div class="flex items-center justify-between">
                <span class="text-xs font-semibold text-slate-500 uppercase tracking-wider">BSPS KEMENPERA</span>
                <span class="p-2 bg-sky-50 rounded-lg text-sky-600">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 14v3m4-3v3m4-3v3M3 21h18M3 10h18M3 7l9-4 9 4M4 10h16v11H4V10z"/>
                    </svg>
                </span>
            </div>
            <div class="mt-3">
                <h3 class="text-2xl font-bold text-sky-700 tracking-tight">
                    {{ number_format($totalBsps, 0, ',', '.') }}
                </h3>
                <p class="text-xs text-slate-500 mt-1">
                    Bantuan Stimulan Perumahan Swadaya
                </p>
            </div>
        </div>

        {{-- Card 4: Cakupan Wilayah --}}
        <div class="bg-white rounded-xl border border-slate-200 p-5 shadow-xs">
            <div class="flex items-center justify-between">
                <span class="text-xs font-semibold text-slate-500 uppercase tracking-wider">Cakupan Wilayah</span>
                <span class="p-2 bg-slate-100 rounded-lg text-slate-600">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                    </svg>
                </span>
            </div>
            <div class="mt-3">
                <h3 class="text-2xl font-bold text-slate-900 tracking-tight">
                    {{ $totalKecamatan }} <span class="text-sm font-normal text-slate-500">Kecamatan</span>
                </h3>
                <p class="text-xs text-slate-500 mt-1">
                    Tersebar di {{ $totalDesa }} Desa / Kelurahan
                </p>
            </div>
        </div>
    </div>

    {{-- Grid 2 Kolom: Rekapitulasi Program & Top Kecamatan --}}
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        
        {{-- Kolom Kiri: Status & Distribusi Program --}}
        <div class="bg-white rounded-xl border border-slate-200 p-5 shadow-xs flex flex-col justify-between">
            <div>
                <h4 class="text-sm font-bold text-slate-900">Distribusi Program & Status</h4>
                <p class="text-xs text-slate-500 mt-0.5">Proporsi alokasi dan progres pelaksanaan bantuan</p>

                {{-- Bar Alokasi --}}
                <div class="mt-5 space-y-4">
                    <div>
                        <div class="flex justify-between text-xs font-medium text-slate-700 mb-1.5">
                            <span>RTLH APBD BOGOR</span>
                            <span class="font-bold text-emerald-700">{{ number_format($totalRtlh, 0, ',', '.') }} ({{ $totalSemua > 0 ? round(($totalRtlh / $totalSemua) * 100, 1) : 0 }}%)</span>
                        </div>
                        <div class="w-full bg-slate-100 rounded-full h-2.5 overflow-hidden">
                            <div class="bg-emerald-600 h-2.5 rounded-full" style="width: {{ $totalSemua > 0 ? ($totalRtlh / $totalSemua) * 100 : 0 }}%"></div>
                        </div>
                    </div>

                    <div>
                        <div class="flex justify-between text-xs font-medium text-slate-700 mb-1.5">
                            <span>BSPS NASIONAL</span>
                            <span class="font-bold text-sky-700">{{ number_format($totalBsps, 0, ',', '.') }} ({{ $totalSemua > 0 ? round(($totalBsps / $totalSemua) * 100, 1) : 0 }}%)</span>
                        </div>
                        <div class="w-full bg-slate-100 rounded-full h-2.5 overflow-hidden">
                            <div class="bg-sky-600 h-2.5 rounded-full" style="width: {{ $totalSemua > 0 ? ($totalBsps / $totalSemua) * 100 : 0 }}%"></div>
                        </div>
                    </div>
                </div>

                {{-- Status Box --}}
                <div class="mt-6 pt-5 border-t border-slate-100 space-y-2.5">
                    <span class="text-xs font-semibold text-slate-600 uppercase tracking-wider block">Status Tahapan:</span>
                    <div class="grid grid-cols-3 gap-2 text-center">
                        <div class="p-2.5 bg-amber-50 rounded-lg border border-amber-200/80">
                            <span class="block text-[11px] font-semibold text-amber-800">PERSIAPAN</span>
                            <span class="block text-base font-bold text-amber-900 mt-0.5">{{ number_format($statusCounts['PERSIAPAN'] ?? 0, 0, ',', '.') }}</span>
                        </div>
                        <div class="p-2.5 bg-blue-50 rounded-lg border border-blue-200/80">
                            <span class="block text-[11px] font-semibold text-blue-800">PROSES</span>
                            <span class="block text-base font-bold text-blue-900 mt-0.5">{{ number_format($statusCounts['PROSES'] ?? 0, 0, ',', '.') }}</span>
                        </div>
                        <div class="p-2.5 bg-emerald-50 rounded-lg border border-emerald-200/80">
                            <span class="block text-[11px] font-semibold text-emerald-800">SELESAI</span>
                            <span class="block text-base font-bold text-emerald-900 mt-0.5">{{ number_format($statusCounts['SELESAI'] ?? 0, 0, ',', '.') }}</span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="mt-6 pt-4 border-t border-slate-100">
                <a href="{{ route('admin.bnba') }}" class="w-full block text-center py-2 px-3 text-xs font-semibold text-emerald-700 bg-emerald-50 hover:bg-emerald-100 rounded-lg transition-colors border border-emerald-200">
                    Buka Manajemen Data BNBA &rarr;
                </a>
            </div>
        </div>

        {{-- Kolom Kanan: Top 5 Kecamatan Penerima Terbanyak --}}
        <div class="bg-white rounded-xl border border-slate-200 p-5 shadow-xs lg:col-span-2">
            <div class="flex items-center justify-between mb-4">
                <div>
                    <h4 class="text-sm font-bold text-slate-900">5 Kecamatan dengan Penerima Terbanyak</h4>
                    <p class="text-xs text-slate-500 mt-0.5">Wilayah prioritas penyaluran program bantuan</p>
                </div>
                <a href="{{ route('admin.wilayah') }}" class="text-xs font-semibold text-emerald-600 hover:text-emerald-700">
                    Lihat Semua 40 Kec &rarr;
                </a>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-xs text-left">
                    <thead class="bg-slate-50 text-slate-600 font-semibold border-y border-slate-200">
                        <tr>
                            <th class="py-2.5 px-3">No</th>
                            <th class="py-2.5 px-3">Kecamatan</th>
                            <th class="py-2.5 px-3 text-right">Jumlah Penerima</th>
                            <th class="py-2.5 px-3">Persentase</th>
                            <th class="py-2.5 px-3 text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @foreach ($topKecamatan as $index => $kec)
                            @php
                                $pct = $totalSemua > 0 ? round(($kec->total / $totalSemua) * 100, 1) : 0;
                            @endphp
                            <tr class="hover:bg-slate-50/70 transition-colors">
                                <td class="py-2.5 px-3 font-medium text-slate-500">{{ $index + 1 }}</td>
                                <td class="py-2.5 px-3 font-bold text-slate-900">KEC. {{ $kec->xkec }}</td>
                                <td class="py-2.5 px-3 text-right font-semibold text-slate-800">
                                    {{ number_format($kec->total, 0, ',', '.') }} <span class="text-slate-400 font-normal">rumah</span>
                                </td>
                                <td class="py-2.5 px-3">
                                    <div class="flex items-center gap-2">
                                        <div class="w-24 bg-slate-100 rounded-full h-1.5 overflow-hidden">
                                            <div class="bg-emerald-600 h-1.5 rounded-full" style="width: {{ min(100, $pct * 6) }}%"></div>
                                        </div>
                                        <span class="text-slate-500 text-[11px]">{{ $pct }}%</span>
                                    </div>
                                </td>
                                <td class="py-2.5 px-3 text-right">
                                    <a href="{{ route('admin.bnba', ['kecamatan' => $kec->id_kec]) }}" class="inline-flex items-center text-xs font-semibold text-emerald-600 hover:text-emerald-800">
                                        Filter Data
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    {{-- Penerima Bantuan Terbaru --}}
    <div class="bg-white rounded-xl border border-slate-200 p-5 shadow-xs">
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-2 mb-4">
            <div>
                <h4 class="text-sm font-bold text-slate-900">Data Penerima Terbaru</h4>
                <p class="text-xs text-slate-500 mt-0.5">8 data penerima terakhir yang terdaftar dalam basis data</p>
            </div>
            <a href="{{ route('admin.bnba') }}" class="inline-flex items-center gap-1.5 px-3 py-1.5 text-xs font-semibold text-white bg-emerald-600 hover:bg-emerald-700 rounded-lg transition-colors">
                <span>Buka Tabel Lengkap (11.297 Data)</span>
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                </svg>
            </a>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-xs text-left">
                <thead class="bg-slate-50 text-slate-600 font-semibold border-y border-slate-200">
                    <tr>
                        <th class="py-2.5 px-3">ID</th>
                        <th class="py-2.5 px-3">Nama Penerima</th>
                        <th class="py-2.5 px-3">NIK</th>
                        <th class="py-2.5 px-3">Wilayah</th>
                        <th class="py-2.5 px-3">Program</th>
                        <th class="py-2.5 px-3">Status</th>
                        <th class="py-2.5 px-3 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @foreach ($recentPenerima as $penerima)
                        <tr class="hover:bg-slate-50/70 transition-colors">
                            <td class="py-2.5 px-3 font-medium text-slate-500">#{{ $penerima->id_bnba }}</td>
                            <td class="py-2.5 px-3 font-bold text-slate-900">{{ $penerima->name_bnba }}</td>
                            <td class="py-2.5 px-3 font-mono text-slate-600">
                                {{ strlen($penerima->bnba_nik) >= 16 ? substr($penerima->bnba_nik, 0, 6) . '******' . substr($penerima->bnba_nik, -4) : $penerima->bnba_nik }}
                            </td>
                            <td class="py-2.5 px-3 text-slate-700">
                                <span class="font-medium">DESA {{ $penerima->xkel }}</span>, KEC. {{ $penerima->xkec }}
                            </td>
                            <td class="py-2.5 px-3">
                                @if (str_contains($penerima->cat_bnba, 'APBD'))
                                    <span class="inline-flex items-center px-2 py-0.5 rounded text-[11px] font-semibold bg-emerald-50 text-emerald-700 border border-emerald-200">
                                        RTLH APBD
                                    </span>
                                @else
                                    <span class="inline-flex items-center px-2 py-0.5 rounded text-[11px] font-semibold bg-sky-50 text-sky-700 border border-sky-200">
                                        BSPS
                                    </span>
                                @endif
                            </td>
                            <td class="py-2.5 px-3">
                                <span class="inline-flex items-center px-2 py-0.5 rounded text-[11px] font-semibold bg-amber-50 text-amber-700 border border-amber-200">
                                    {{ $penerima->st_akhir }}
                                </span>
                            </td>
                            <td class="py-2.5 px-3 text-right">
                                <a href="{{ route('admin.bnba', ['q' => $penerima->name_bnba]) }}" class="text-xs font-semibold text-emerald-600 hover:text-emerald-800">
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
