<?php

namespace App\Http\Controllers;

use App\Models\Posting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\View\View;

class HomeController extends Controller
{
    public function index()
    {
        // 1. Total Program dari Database app_md_bnba (RTLH APBD & BSPS Pusat)
        $totalRtlh = DB::table('app_md_bnba')->where('cat_bnba', 'like', '%APBD%')->count();
        $totalRtlhProses = DB::table('app_md_bnba')->where('cat_bnba', 'like', '%APBD%')->where('st_akhir', 'PROSES')->count();
        $totalRtlhSelesai = DB::table('app_md_bnba')->where('cat_bnba', 'like', '%APBD%')->where('st_akhir', 'SELESAI')->count();
        $totalRtlhPersiapan = max(0, $totalRtlh - $totalRtlhProses - $totalRtlhSelesai);

        $totalBsps = DB::table('app_md_bnba')->where('cat_bnba', 'BSPS')->count();
        $totalBspsProses = DB::table('app_md_bnba')->where('cat_bnba', 'BSPS')->where('st_akhir', 'PROSES')->count();
        $totalBspsSelesai = DB::table('app_md_bnba')->where('cat_bnba', 'BSPS')->where('st_akhir', 'SELESAI')->count();
        $totalBspsPersiapan = max(0, $totalBsps - $totalBspsProses - $totalBspsSelesai);

        $totalAllBnba = $totalRtlh + $totalBsps;

        $totalDesaKel = DB::table('app_md_kel')
            ->whereIn('id_kec', function ($query) {
                $query->select('id_kec')->from('app_md_kec')->where('id_kab', 158);
            })
            ->count();

        // 2. Data 40 Kecamatan di Kab. Bogor beserta titik koordinat dan rincian RTLH & BSPS
        $kecamatans = DB::table('app_md_kec')
            ->where('id_kab', 158)
            ->where('flag_del', 0)
            ->orderBy('name_kec')
            ->get();

        // Ambil titik koordinat kantor camat dari app_md_mapgovpoint (id_mapgov = 2)
        $mapPoints = DB::table('app_md_mapgovpoint')
            ->where('id_mapgov', 2)
            ->where('flag_del', 0)
            ->select('id_kec', 'gps_lat', 'gps_long')
            ->get()
            ->keyBy('id_kec');

        // Hitung rincian RTLH & BSPS per kecamatan dari app_md_bnba
        $bnbaStats = DB::table('app_md_bnba')
            ->select(
                'id_kec',
                DB::raw("COUNT(CASE WHEN cat_bnba LIKE '%APBD%' THEN 1 END) as rtlh"),
                DB::raw("COUNT(CASE WHEN cat_bnba = 'BSPS' THEN 1 END) as bsps"),
                DB::raw('COUNT(*) as total')
            )
            ->groupBy('id_kec')
            ->get()
            ->keyBy('id_kec');

        // Hitung jumlah desa & kelurahan per kecamatan
        $desaKelCounts = DB::table('app_md_kel')
            ->select('id_kec', DB::raw('count(*) as total'))
            ->groupBy('id_kec')
            ->pluck('total', 'id_kec');

        $daftar40Kecamatan = [];
        $no = 1;
        foreach ($kecamatans as $kec) {
            $point = $mapPoints->get($kec->id_kec);
            $stat = $bnbaStats->get($kec->id_kec);

            $rtlhCount = (int) ($stat ? $stat->rtlh : 0);
            $bspsCount = (int) ($stat ? $stat->bsps : 0);
            $totalCount = (int) ($stat ? $stat->total : ($rtlhCount + $bspsCount));
            $totalDesa = (int) ($desaKelCounts->get($kec->id_kec) ?? 0);

            // Koordinat default Bogor jika koordinat 0 / null
            $lat = ($point && (float) $point->gps_lat != 0) ? (float) $point->gps_lat : -6.5000;
            $lng = ($point && (float) $point->gps_long != 0) ? (float) $point->gps_long : 106.8500;

            $daftar40Kecamatan[] = [
                'no' => $no++,
                'id_kec' => $kec->id_kec,
                'nama' => strtoupper($kec->name_kec),
                'desa' => $totalDesa,
                'kel' => 0,
                'jumlah' => $totalCount,
                'rtlh' => $rtlhCount,
                'bsps' => $bspsCount,
                'lat' => $lat,
                'lng' => $lng,
            ];
        }

        // Ambil data dokumentasi / postingan publik dari database (Maksimal 10 kartu di homepage)
        $postings = collect();
        $totalPostings = 0;
        if (Schema::hasTable('postings')) {
            $totalPostings = Posting::published()->count();
            $postings = Posting::published()->recent()->with('bnba')->take(10)->get();
        }

        return view('welcome', compact(
            'totalRtlh',
            'totalRtlhPersiapan',
            'totalRtlhProses',
            'totalRtlhSelesai',
            'totalBsps',
            'totalBspsPersiapan',
            'totalBspsProses',
            'totalBspsSelesai',
            'totalAllBnba',
            'totalDesaKel',
            'daftar40Kecamatan',
            'postings',
            'totalPostings'
        ));
    }

    /**
     * Halaman penuh katalog & arsip seluruh dokumentasi publik (Pindah Page)
     */
    public function dokumentasi(Request $request): View
    {
        $query = Posting::published()->recent()->with('bnba');

        if ($request->filled('q')) {
            $q = trim($request->input('q'));
            $query->where(function ($w) use ($q) {
                $w->where('judul', 'like', "%{$q}%")
                    ->orWhere('keterangan', 'like', "%{$q}%")
                    ->orWhere('tim_pelapor', 'like', "%{$q}%")
                    ->orWhereHas('bnba', function ($b) use ($q) {
                        $b->where('name_bnba', 'like', "%{$q}%");
                    });
            });
        }

        if ($request->filled('program')) {
            $program = $request->input('program');
            $query->whereHas('bnba', function ($b) use ($program) {
                if ($program === 'RTLH') {
                    $b->where('cat_bnba', 'like', '%APBD%');
                } elseif ($program === 'BSPS') {
                    $b->where('cat_bnba', 'BSPS');
                }
            });
        }

        if ($request->filled('kecamatan')) {
            $kecId = $request->input('kecamatan');
            $query->whereHas('bnba', function ($b) use ($kecId) {
                $b->where('id_kec', $kecId);
            });
        }

        $postings = $query->paginate(12)->withQueryString();

        $kecamatanList = DB::table('app_md_kec')
            ->where('flag_del', 0)
            ->orderBy('name_kec')
            ->get();

        return view('dokumentasi.index', compact('postings', 'kecamatanList'));
    }

    /**
     * Endpoint API untuk mengambil daftar penerima BNBA spesifik per kecamatan saat titik/batas diklik
     */
    public function getPenerimaByKecamatan($id_kec)
    {
        $warga = DB::table('app_md_bnba')
            ->leftJoin('app_md_mapgovpoint', function ($join) {
                $join->on('app_md_bnba.id_kel', '=', 'app_md_mapgovpoint.id_kel')
                    ->whereIn('app_md_mapgovpoint.id_mapgov', [3, 4])
                    ->where('app_md_mapgovpoint.flag_del', 0);
            })
            ->where(function ($q) use ($id_kec) {
                if (is_numeric($id_kec)) {
                    $q->where('app_md_bnba.id_kec', $id_kec);
                } else {
                    $q->where('app_md_bnba.xkec', strtoupper($id_kec));
                }
            })
            ->select(
                'app_md_bnba.id_bnba',
                'app_md_bnba.name_bnba as nama',
                'app_md_bnba.bnba_nik as nik',
                'app_md_bnba.xkel as desa',
                'app_md_bnba.bnba_rt as rt',
                'app_md_bnba.bnba_rw as rw',
                'app_md_bnba.bnba_alamat as alamat',
                'app_md_bnba.cat_bnba',
                'app_md_bnba.st_akhir as status',
                'app_md_bnba.thn_bnba as tahun',
                'app_md_bnba.gps_lat as house_lat',
                'app_md_bnba.gps_long as house_long',
                'app_md_mapgovpoint.gps_lat as desa_lat',
                'app_md_mapgovpoint.gps_long as desa_long',
                'app_md_mapgovpoint.name_mapgovpoint as nama_desa_titik'
            )
            ->orderBy('app_md_bnba.id_bnba')
            ->limit(350)
            ->get();

        // Samarkan NIK dan nama untuk privasi publik serta set program RTLH/BSPS & koordinat
        $warga->transform(function ($item) {
            $item->program = str_contains(strtoupper($item->cat_bnba ?? ''), 'APBD') ? 'RTLH' : 'BSPS';

            if (strlen($item->nik ?? '') >= 16) {
                $item->nik = Auth::check()
                    ? $item->nik
                    : substr($item->nik, 0, 6).'******'.substr($item->nik, -4);
            }

            // Sensor nama warga untuk privasi publik: menyisakan 1 huruf awal per kata jika belum login admin
            $item->nama = self::maskName($item->nama);

            $item->desa_full = ($item->desa ? 'Desa/Kel. '.$item->desa : '').
                               ($item->rt ? ', RT '.$item->rt : '').
                               ($item->rw ? '/RW '.$item->rw : '');

            // Prioritas koordinat:
            // 1. Koordinat GPS asli rumah (jika ada dan != 0)
            // 2. Koordinat GPS asli kantor desa/kelurahan dari app_md_mapgovpoint
            $hasHouseGps = $item->house_lat && (float) $item->house_lat != 0 && $item->house_long && (float) $item->house_long != 0;
            $hasDesaGps = $item->desa_lat && (float) $item->desa_lat != 0 && $item->desa_long && (float) $item->desa_long != 0;

            if ($hasHouseGps) {
                $item->lat = (float) $item->house_lat;
                $item->lng = (float) $item->house_long;
                $item->tipe_titik = 'gps_rumah';
            } elseif ($hasDesaGps) {
                $item->lat = (float) $item->desa_lat;
                $item->lng = (float) $item->desa_long;
                $item->tipe_titik = 'gps_desa';
            } else {
                $item->lat = null;
                $item->lng = null;
                $item->tipe_titik = 'kecamatan_fallback';
            }

            return $item;
        });

        return response()->json($warga);
    }

    /**
     * Sensor nama penerima untuk privasi publik dengan menyisakan 1 huruf awal per kata.
     * Contoh: "Didi Suryadi" -> "D*** S******", "SAPINAH" -> "S******"
     * Jika admin sudah login, nama TIDAK disensor (tampilkan nama lengkap asli).
     */
    public static function maskName(?string $name): string
    {
        if (empty($name)) {
            return '-';
        }

        // Jika admin sudah login, tampilkan nama asli lengkap tanpa masking
        if (Auth::check()) {
            return $name;
        }

        $words = preg_split('/\s+/', trim($name));
        $masked = [];

        foreach ($words as $word) {
            $len = mb_strlen($word);
            if ($len <= 1) {
                $masked[] = $word;
            } else {
                $masked[] = mb_substr($word, 0, 1).str_repeat('*', $len - 1);
            }
        }

        return implode(' ', $masked);
    }

    /**
     * Sensor judul dokumentasi publik jika memuat nama penerima.
     * Contoh: "Realisasi Bedah Rumah - Didi Suryadi (Desa A)" -> "Realisasi Bedah Rumah - D*** S****** (Desa A)"
     * Jika admin sudah login, judul TIDAK disensor (tampilkan judul asli lengkap).
     */
    public static function maskTitle(?string $title, ?string $knownName = null): string
    {
        if (empty($title)) {
            return '';
        }

        // Jika admin sudah login, tampilkan judul asli lengkap tanpa masking
        if (Auth::check()) {
            return $title;
        }

        // 1. Jika nama asli diketahui, ganti langsung
        if (! empty($knownName) && stripos($title, $knownName) !== false) {
            return str_ireplace($knownName, self::maskName($knownName), $title);
        }

        // 2. Format standar: "Kegiatan ... - Nama Orang (Lokasi...)" atau "Kegiatan ... - Nama Orang"
        if (str_contains($title, ' - ')) {
            $parts = explode(' - ', $title, 2);
            $prefix = $parts[0];
            $rest = $parts[1];

            // Jika ada kurung lokasi di akhir, misal "Didi Suryadi (CIAPUS, Kec. CIOMAS)"
            if (preg_match('/^(.*?)\s*(\(.*?\))\s*$/', $rest, $matches)) {
                $namePart = trim($matches[1]);
                $locPart = ' '.trim($matches[2]);
                if (! empty($namePart)) {
                    return $prefix.' - '.self::maskName($namePart).$locPart;
                }
            } else {
                return $prefix.' - '.self::maskName(trim($rest));
            }
        }

        return $title;
    }
}
