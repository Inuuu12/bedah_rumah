@extends('admin.layout')

@section('title', 'Rekapitulasi Wilayah')
@section('header_title', 'Rekapitulasi 40 Kecamatan')
@section('header_subtitle', 'Alokasi dan sebaran kuota program per kecamatan di Kabupaten Bogor')

@section('content')
<div class="space-y-5">

    {{-- Info Card --}}
    <div class="bg-white rounded-lg border border-slate-200 p-5 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h3 class="text-sm font-bold text-slate-900">Sebaran Alokasi Bantuan Bedah Rumah</h3>
            <p class="text-xs text-slate-500 mt-1">
                Data rekapitulasi alokasi Rumah Tidak Layak Huni (RTLH APBD) dan BSPS di 40 Kecamatan Kabupaten Bogor.
            </p>
        </div>
        <div class="flex items-center gap-3">
            <span class="text-xs font-semibold px-3 py-1.5 bg-teal-50 text-teal-800 border border-teal-200 rounded-lg">
                Total: 40 Kecamatan Terdata
            </span>
        </div>
    </div>

    {{-- Main Table --}}
    <div class="bg-white rounded-lg border border-slate-200 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-xs text-left">
                <thead class="bg-slate-50 text-slate-600 font-semibold border-b border-slate-200 uppercase tracking-wider text-[11px]">
                    <tr>
                        <th class="py-3 px-3.5 w-12 text-center">No</th>
                        <th class="py-3 px-3.5">Nama Kecamatan</th>
                        <th class="py-3 px-3.5 text-right">RTLH APBD</th>
                        <th class="py-3 px-3.5 text-right">BSPS Kemenpera</th>
                        <th class="py-3 px-3.5 text-right">Total Alokasi</th>
                        <th class="py-3 px-3.5">Proporsi Wilayah</th>
                        <th class="py-3 px-3.5 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @php
                        $grandRtlh = 0;
                        $grandBsps = 0;
                        $grandTotal = 0;
                        foreach($rekapKecamatan as $k) {
                            $grandRtlh += $k->total_rtlh;
                            $grandBsps += $k->total_bsps;
                            $grandTotal += $k->total_alokasi;
                        }
                    @endphp

                    @foreach ($rekapKecamatan as $index => $row)
                        @php
                            $pct = $grandTotal > 0 ? round(($row->total_alokasi / $grandTotal) * 100, 1) : 0;
                        @endphp
                        <tr class="hover:bg-slate-50 transition-colors">
                            <td class="py-3 px-3.5 text-center text-slate-400 font-mono">
                                {{ $index + 1 }}
                            </td>
                            <td class="py-3 px-3.5 font-bold text-slate-900">
                                KEC. {{ $row->name_kec }}
                            </td>
                            <td class="py-3 px-3.5 text-right font-medium text-teal-800">
                                {{ number_format($row->total_rtlh, 0, ',', '.') }}
                            </td>
                            <td class="py-3 px-3.5 text-right font-medium text-sky-700">
                                {{ number_format($row->total_bsps, 0, ',', '.') }}
                            </td>
                            <td class="py-3 px-3.5 text-right font-bold text-slate-900">
                                {{ number_format($row->total_alokasi, 0, ',', '.') }}
                            </td>
                            <td class="py-3 px-3.5">
                                <div class="flex items-center gap-2">
                                    <div class="w-20 bg-slate-100 rounded-full h-1.5 overflow-hidden">
                                        <div class="bg-teal-700 h-1.5 rounded-full" style="width: {{ min(100, $pct * 6) }}%"></div>
                                    </div>
                                    <span class="text-slate-500 text-[11px] font-mono">{{ $pct }}%</span>
                                </div>
                            </td>
                            <td class="py-3 px-3.5 text-center whitespace-nowrap">
                                <a 
                                    href="{{ route('admin.bnba', ['kecamatan' => $row->id_kec]) }}" 
                                    class="inline-flex items-center gap-1 px-2.5 py-1 text-[11px] font-semibold text-teal-700 bg-teal-50 hover:bg-teal-100 rounded border border-teal-200 transition-colors"
                                >
                                    <span>Lihat BNBA</span>
                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                                    </svg>
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
                <tfoot class="bg-slate-100 text-slate-900 font-bold border-t-2 border-slate-300 text-xs">
                    <tr>
                        <td colspan="2" class="py-3 px-3.5 text-right uppercase tracking-wider">
                            Total Kabupaten Bogor (40 Kec):
                        </td>
                        <td class="py-3 px-3.5 text-right text-teal-800">
                            {{ number_format($grandRtlh, 0, ',', '.') }}
                        </td>
                        <td class="py-3 px-3.5 text-right text-sky-800">
                            {{ number_format($grandBsps, 0, ',', '.') }}
                        </td>
                        <td class="py-3 px-3.5 text-right text-slate-900">
                            {{ number_format($grandTotal, 0, ',', '.') }}
                        </td>
                        <td class="py-3 px-3.5 text-slate-500 font-mono">100%</td>
                        <td></td>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>

</div>
@endsection
