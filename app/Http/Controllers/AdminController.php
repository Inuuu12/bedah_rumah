<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class AdminController extends Controller
{
    /**
     * Dashboard ringkasan admin.
     */
    public function dashboard(): View
    {
        $totalSemua = DB::table('app_md_bnba')->where('flag_del', 0)->count();

        $totalRtlh = DB::table('app_md_bnba')
            ->where('flag_del', 0)
            ->where('cat_bnba', 'like', '%APBD%')
            ->count();

        $totalBsps = DB::table('app_md_bnba')
            ->where('flag_del', 0)
            ->where('cat_bnba', 'BSPS')
            ->count();

        $statusCounts = DB::table('app_md_bnba')
            ->where('flag_del', 0)
            ->select('st_akhir', DB::raw('count(*) as total'))
            ->groupBy('st_akhir')
            ->pluck('total', 'st_akhir');

        // Top 5 kecamatan penerima terbanyak
        $topKecamatan = DB::table('app_md_bnba')
            ->where('flag_del', 0)
            ->select('xkec', 'id_kec', DB::raw('count(*) as total'))
            ->groupBy('xkec', 'id_kec')
            ->orderByDesc('total')
            ->limit(5)
            ->get();

        // Penerima bantuan terbaru
        $recentPenerima = DB::table('app_md_bnba')
            ->where('flag_del', 0)
            ->orderByDesc('id_bnba')
            ->limit(8)
            ->get();

        $totalKecamatan = DB::table('app_md_kec')->where('id_kab', 158)->where('flag_del', 0)->count();
        $totalDesa = DB::table('app_md_kel as kel')
            ->join('app_md_kec as kec', 'kel.id_kec', '=', 'kec.id_kec')
            ->where('kec.id_kab', 158)
            ->where('kel.flag_del', 0)
            ->count();

        return view('admin.dashboard', compact(
            'totalSemua',
            'totalRtlh',
            'totalBsps',
            'statusCounts',
            'topKecamatan',
            'recentPenerima',
            'totalKecamatan',
            'totalDesa'
        ));
    }

    /**
     * Halaman data BNBA (Penerima Bantuan) dengan filter dan pencarian.
     */
    public function bnba(Request $request): View
    {
        $query = DB::table('app_md_bnba')->where('flag_del', 0);

        // Filter Pencarian (Nama, NIK, Alamat)
        if ($request->filled('q')) {
            $keyword = trim($request->q);
            $query->where(function ($q) use ($keyword) {
                $q->where('name_bnba', 'like', "%{$keyword}%")
                    ->orWhere('bnba_nik', 'like', "%{$keyword}%")
                    ->orWhere('bnba_alamat', 'like', "%{$keyword}%");
            });
        }

        // Filter Kecamatan
        if ($request->filled('kecamatan')) {
            $query->where('id_kec', $request->kecamatan);
        }

        // Filter Program (RTLH APBD vs BSPS)
        if ($request->filled('program')) {
            if ($request->program === 'RTLH') {
                $query->where('cat_bnba', 'like', '%APBD%');
            } elseif ($request->program === 'BSPS') {
                $query->where('cat_bnba', 'BSPS');
            }
        }

        // Filter Status
        if ($request->filled('status')) {
            $query->where('st_akhir', $request->status);
        }

        $penerimaList = $query->orderBy('id_bnba', 'asc')
            ->paginate(25)
            ->withQueryString();

        $kecamatanList = DB::table('app_md_kec')
            ->where('id_kab', 158)
            ->where('flag_del', 0)
            ->orderBy('name_kec', 'asc')
            ->get();

        return view('admin.bnba.index', compact('penerimaList', 'kecamatanList'));
    }

    /**
     * Detail penerima untuk AJAX Modal.
     */
    public function bnbaDetail(int $id)
    {
        $penerima = DB::table('app_md_bnba')
            ->where('id_bnba', $id)
            ->where('flag_del', 0)
            ->first();

        if (! $penerima) {
            return response()->json(['error' => 'Data penerima tidak ditemukan.'], 404);
        }

        // Ambil info kelurahan dan koordinat desa jika ada
        $titikDesa = DB::table('app_md_mapgovpoint')
            ->where('id_kel', $penerima->id_kel)
            ->whereIn('id_mapgov', [3, 4])
            ->first();

        return response()->json([
            'data' => $penerima,
            'koordinat' => $titikDesa ? [
                'lat' => $titikDesa->gps_lat,
                'long' => $titikDesa->gps_long,
                'nama' => $titikDesa->name_mapgovpoint,
            ] : null,
        ]);
    }

    /**
     * Ubah status bantuan penerima (PERSIAPAN / PROSES / SELESAI).
     */
    public function bnbaUpdateStatus(Request $request, int $id): RedirectResponse
    {
        $request->validate([
            'st_akhir' => ['required', 'string', 'in:PERSIAPAN,PROSES,SELESAI'],
        ]);

        DB::table('app_md_bnba')
            ->where('id_bnba', $id)
            ->update([
                'st_akhir' => $request->st_akhir,
            ]);

        return back()->with('status', 'Status penerima bantuan berhasil diperbarui.');
    }

    /**
     * Halaman rekapitulasi data per wilayah / kecamatan.
     */
    public function wilayah(): View
    {
        $rekapKecamatan = DB::table('app_md_kec as k')
            ->where('k.id_kab', 158)
            ->where('k.flag_del', 0)
            ->leftJoin('app_md_bnba as b', function ($join) {
                $join->on('k.id_kec', '=', 'b.id_kec')
                    ->where('b.flag_del', '=', 0);
            })
            ->select(
                'k.id_kec',
                'k.name_kec',
                DB::raw("COUNT(CASE WHEN b.cat_bnba LIKE '%APBD%' THEN 1 END) as total_rtlh"),
                DB::raw("COUNT(CASE WHEN b.cat_bnba = 'BSPS' THEN 1 END) as total_bsps"),
                DB::raw('COUNT(b.id_bnba) as total_alokasi')
            )
            ->groupBy('k.id_kec', 'k.name_kec')
            ->orderBy('k.name_kec', 'asc')
            ->get();

        return view('admin.wilayah.index', compact('rekapKecamatan'));
    }
}
