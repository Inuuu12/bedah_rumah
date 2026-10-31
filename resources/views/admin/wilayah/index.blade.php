@extends('admin.layout')

@section('title', 'Rekapitulasi Wilayah')
@section('header_title', 'Rekapitulasi 40 Kecamatan')
@section('header_subtitle', 'Alokasi dan sebaran kuota program per kecamatan di Kabupaten Bogor')

@section('content')
<div class="space-y-5">

    {{-- Info Card --}}
    <div class="bg-white rounded-xl border border-slate-200 p-5 flex flex-col sm:flex-row sm:items-center justify-between gap-4 shadow-xs">
        <div>
            <h3 class="text-sm font-bold text-slate-900">Sebaran Alokasi Bantuan Bedah Rumah</h3>
            <p class="text-xs text-slate-500 mt-1">
                Data rekapitulasi alokasi Rumah Tidak Layak Huni (RTLH APBD) dan BSPS di 40 Kecamatan Kabupaten Bogor.
            </p>
        </div>
        <div class="flex items-center gap-3">
            <span class="text-xs font-semibold px-3 py-1.5 bg-emerald-50 text-emerald-800 border border-emerald-200 rounded-lg">
                Total: 40 Kecamatan Terdata
            </span>
        </div>
    </div>

    {{-- Main Table --}}
    <div class="bg-white rounded-xl border border-slate-200 shadow-xs overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-xs text-left">
                <thead class="bg-slate-50 text-slate-600 font-semibold border-b border-slate-200 uppercase tracking-wider text-[11px]">
                    <tr>
                        <th class="py-3 px-3.5 w-12 text-center">No</th>
                        <th class="py-3 px-3.5">Nama Kecamatan</th>
                        <th class="py-3 px-3.5 text-right">RTLH APBD</th>
                        <th class="py-3 px-3.5 text-right">BSPS Kemenpera</th>
                        <th class="py-3 px-3.5 text-right">Total Alokasi</th>
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
                        <tr class="hover:bg-slate-50 transition-colors">
                            <td class="py-3 px-3.5 text-center text-slate-400 font-mono">
                                {{ $index + 1 }}
                            </td>
                            <td class="py-3 px-3.5 font-bold text-slate-900">
                                KEC. {{ $row->name_kec }}
                            </td>
                            <td class="py-3 px-3.5 text-right font-semibold text-emerald-800">
                                {{ number_format($row->total_rtlh, 0, ',', '.') }}
                            </td>
                            <td class="py-3 px-3.5 text-right font-semibold text-sky-700">
                                {{ number_format($row->total_bsps, 0, ',', '.') }}
                            </td>
                            <td class="py-3 px-3.5 text-right font-extrabold text-slate-900">
                                {{ number_format($row->total_alokasi, 0, ',', '.') }}
                            </td>
                        </tr>
                    @endforeach
                </tbody>
                <tfoot class="bg-slate-100 text-slate-900 font-bold border-t-2 border-slate-300 text-xs">
                    <tr>
                        <td colspan="2" class="py-3 px-3.5 text-right uppercase tracking-wider">
                            Total Kabupaten Bogor (40 Kec):
                        </td>
                        <td class="py-3 px-3.5 text-right text-emerald-800">
                            {{ number_format($grandRtlh, 0, ',', '.') }}
                        </td>
                        <td class="py-3 px-3.5 text-right text-sky-800">
                            {{ number_format($grandBsps, 0, ',', '.') }}
                        </td>
                        <td class="py-3 px-3.5 text-right text-slate-900">
                            {{ number_format($grandTotal, 0, ',', '.') }}
                        </td>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>

</div>
@endsection
