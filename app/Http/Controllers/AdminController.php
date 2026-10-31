<?php

namespace App\Http\Controllers;

use App\Models\Posting;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;
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

        // Status rincian khusus RTLH APBD
        $statusCountsRtlh = DB::table('app_md_bnba')
            ->where('flag_del', 0)
            ->where('cat_bnba', 'like', '%APBD%')
            ->select(DB::raw('UPPER(TRIM(st_akhir)) as st'), DB::raw('count(*) as total'))
            ->groupBy('st')
            ->pluck('total', 'st');

        $statusRtlh = [
            'PERSIAPAN' => (int) ($statusCountsRtlh['PERSIAPAN'] ?? 0),
            'PROSES' => (int) ($statusCountsRtlh['PROSES'] ?? 0),
            'SELESAI' => (int) ($statusCountsRtlh['SELESAI'] ?? 0),
        ];

        // Status rincian khusus BSPS Nasional
        $statusCountsBsps = DB::table('app_md_bnba')
            ->where('flag_del', 0)
            ->where('cat_bnba', 'BSPS')
            ->select(DB::raw('UPPER(TRIM(st_akhir)) as st'), DB::raw('count(*) as total'))
            ->groupBy('st')
            ->pluck('total', 'st');

        $statusBsps = [
            'PERSIAPAN' => (int) ($statusCountsBsps['PERSIAPAN'] ?? 0),
            'PROSES' => (int) ($statusCountsBsps['PROSES'] ?? 0),
            'SELESAI' => (int) ($statusCountsBsps['SELESAI'] ?? 0),
        ];

        // Top 10 kecamatan penerima terbanyak (Semua Program)
        $topKecamatan = DB::table('app_md_bnba')
            ->where('flag_del', 0)
            ->select('xkec', 'id_kec', DB::raw('count(*) as total'))
            ->groupBy('xkec', 'id_kec')
            ->orderByDesc('total')
            ->limit(10)
            ->get();

        // Top 10 kecamatan untuk RTLH (APBD Kab. Bogor)
        $topKecamatanRtlh = DB::table('app_md_bnba')
            ->where('flag_del', 0)
            ->where('cat_bnba', 'like', '%APBD%')
            ->select(
                'xkec',
                'id_kec',
                DB::raw('count(*) as total'),
                DB::raw("SUM(CASE WHEN UPPER(TRIM(st_akhir)) = 'PROSES' THEN 1 ELSE 0 END) as proses"),
                DB::raw("SUM(CASE WHEN UPPER(TRIM(st_akhir)) = 'SELESAI' THEN 1 ELSE 0 END) as selesai"),
                DB::raw("SUM(CASE WHEN UPPER(TRIM(st_akhir)) = 'PERSIAPAN' THEN 1 ELSE 0 END) as persiapan")
            )
            ->groupBy('xkec', 'id_kec')
            ->orderByDesc('total')
            ->limit(10)
            ->get();

        // Top 10 kecamatan untuk BSPS (Pusat / Kemenpera)
        $topKecamatanBsps = DB::table('app_md_bnba')
            ->where('flag_del', 0)
            ->where('cat_bnba', 'BSPS')
            ->select(
                'xkec',
                'id_kec',
                DB::raw('count(*) as total'),
                DB::raw("SUM(CASE WHEN UPPER(TRIM(st_akhir)) = 'PROSES' THEN 1 ELSE 0 END) as proses"),
                DB::raw("SUM(CASE WHEN UPPER(TRIM(st_akhir)) = 'SELESAI' THEN 1 ELSE 0 END) as selesai"),
                DB::raw("SUM(CASE WHEN UPPER(TRIM(st_akhir)) = 'PERSIAPAN' THEN 1 ELSE 0 END) as persiapan")
            )
            ->groupBy('xkec', 'id_kec')
            ->orderByDesc('total')
            ->limit(10)
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

        $kecamatanList = DB::table('app_md_kec')
            ->where('id_kab', 158)
            ->where('flag_del', 0)
            ->orderBy('name_kec', 'asc')
            ->get();

        return view('admin.dashboard', compact(
            'totalSemua',
            'totalRtlh',
            'totalBsps',
            'statusCounts',
            'statusRtlh',
            'statusBsps',
            'topKecamatan',
            'topKecamatanRtlh',
            'topKecamatanBsps',
            'recentPenerima',
            'totalKecamatan',
            'totalDesa',
            'kecamatanList'
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
     * Ubah status bantuan penerima (PERSIAPAN / PROSES / SELESAI)
     * dan unggah foto progresan agar langsung tayang di portal depan publik.
     */
    public function bnbaUpdateStatus(Request $request, int $id): RedirectResponse
    {
        $targetId = (int) ($request->input('id_bnba') ?: $id);

        $request->validate([
            'st_akhir' => ['required', 'string', 'in:PERSIAPAN,PROSES,SELESAI'],
            'keterangan_progres' => ['nullable', 'string', 'max:1000'],
            'foto_progres_1' => ['nullable', 'image', 'mimes:jpeg,jpg,png,webp', 'max:5120'],
            'foto_progres_2' => ['nullable', 'image', 'mimes:jpeg,jpg,png,webp', 'max:5120'],
            'foto_progres_3' => ['nullable', 'image', 'mimes:jpeg,jpg,png,webp', 'max:5120'],
        ]);

        $bnba = DB::table('app_md_bnba')->where('id_bnba', $targetId)->first();
        if (! $bnba) {
            return back()->with('error', 'Data penerima tidak ditemukan.');
        }

        // 1. Update status akhir di app_md_bnba
        DB::table('app_md_bnba')
            ->where('id_bnba', $targetId)
            ->update([
                'st_akhir' => $request->st_akhir,
            ]);

        // 2. Unggah foto progresan jika ada
        $hasPhotos = $request->hasFile('foto_progres_1')
            || $request->hasFile('foto_progres_2')
            || $request->hasFile('foto_progres_3');

        if ($hasPhotos && Schema::hasTable('postings')) {
            $destinationPath = public_path('uploads/postings');
            if (! File::exists($destinationPath)) {
                File::makeDirectory($destinationPath, 0755, true, true);
            }

            $uploadedPhotos = [];
            for ($i = 1; $i <= 3; $i++) {
                if ($request->hasFile("foto_progres_{$i}")) {
                    $file = $request->file("foto_progres_{$i}");
                    $filename = 'prog_'.time().'_'.$i.'_'.Str::random(8).'.'.$file->getClientOriginalExtension();
                    $file->move($destinationPath, $filename);
                    $uploadedPhotos[$i] = 'uploads/postings/'.$filename;
                }
            }

            // Tentukan field foto di tabel postings sesuai status pengerjaan
            $fieldPrefix = match ($request->st_akhir) {
                'SELESAI' => 'foto_selesai_',
                'PROSES' => 'foto_pembangunan_',
                default => 'foto_persiapan_',
            };

            // Cari apakah postingan untuk penerima ini sudah ada
            $posting = Posting::where('id_bnba', $targetId)->first();

            $programName = str_contains(strtoupper($bnba->cat_bnba ?? ''), 'APBD') ? 'RTLH APBD BOGOR' : 'BSPS KEMENPERA';
            $defaultTitle = "Realisasi Bedah Rumah {$programName} - {$bnba->name_bnba} ({$bnba->xkel}, Kec. {$bnba->xkec})";
            $defaultDesc = $request->filled('keterangan_progres')
                ? $request->keterangan_progres
                : "Pembaruan progres fisik tahap {$request->st_akhir} pelaksanaan bedah rumah untuk penerima manfaat {$bnba->name_bnba} di Desa {$bnba->xkel}, Kecamatan {$bnba->xkec}.";

            $updateData = [
                'tanggal_posting' => now(),
                'status' => 'PUBLISHED',
                'tim_pelapor' => Auth::user()?->name ?: 'Petugas Lapangan',
            ];

            if ($request->filled('keterangan_progres')) {
                $updateData['keterangan'] = $request->keterangan_progres;
            }

            foreach ($uploadedPhotos as $idx => $photoPath) {
                $updateData[$fieldPrefix.$idx] = $photoPath;
            }

            if ($posting) {
                $posting->update($updateData);
            } else {
                $updateData['id_bnba'] = $targetId;
                $updateData['judul'] = $defaultTitle;
                $updateData['keterangan'] = $defaultDesc;
                $updateData['user_id'] = Auth::id();
                Posting::create($updateData);
            }
        }

        $msg = 'Status penerima bantuan berhasil diperbarui.';
        if ($hasPhotos) {
            $msg .= ' Foto progres berhasil diunggah dan langsung tayang di portal depan publik!';
        }

        return back()->with('status', $msg);
    }

    /**
     * Simpan data baru usulan rumah yang akan direnovasi (BNBA).
     * Aturan: Hanya Admin Inti dan Admin Desa yang diizinkan menginput data warga.
     */
    public function bnbaStore(Request $request): RedirectResponse
    {
        if (! Auth::user()?->canInputWarga()) {
            abort(403, 'Akses dibatasi: Penginputan data usulan warga hanya dapat dilakukan oleh Admin Inti dan Admin Desa.');
        }

        $validated = $request->validate([
            'name_bnba' => ['required', 'string', 'max:255'],
            'bnba_nik' => ['required', 'string', 'digits:16'],
            'bnba_kk' => ['nullable', 'string', 'max:30'],
            'bnba_jkel' => ['required', 'string', 'in:L,P'],
            'cat_bnba' => ['required', 'string'],
            'id_kec' => ['required', 'integer'],
            'id_kel' => ['required', 'integer'],
            'bnba_alamat' => ['required', 'string', 'max:255'],
            'bnba_rt' => ['nullable', 'string', 'max:10'],
            'bnba_rw' => ['nullable', 'string', 'max:10'],
            'thn_bnba' => ['nullable', 'integer'],
            'st_akhir' => ['required', 'string', 'in:PERSIAPAN,PROSES,SELESAI'],
            'gps_lat' => ['nullable', 'numeric'],
            'gps_long' => ['nullable', 'numeric'],
        ], [
            'name_bnba.required' => 'Nama penerima renovasi wajib diisi.',
            'bnba_nik.required' => 'Nomor NIK 16 digit wajib diisi.',
            'bnba_nik.digits' => 'Nomor NIK harus berupa 16 digit angka.',
            'bnba_jkel.required' => 'Jenis kelamin wajib dipilih.',
            'cat_bnba.required' => 'Program bantuan renovasi wajib dipilih.',
            'id_kec.required' => 'Kecamatan wajib dipilih.',
            'id_kel.required' => 'Desa/Kelurahan wajib dipilih.',
            'bnba_alamat.required' => 'Alamat lengkap rumah wajib diisi.',
            'st_akhir.required' => 'Status pelaksanaan wajib dipilih.',
        ]);

        $kec = DB::table('app_md_kec')->where('id_kec', $validated['id_kec'])->first();
        $kel = DB::table('app_md_kel')->where('id_kel', $validated['id_kel'])->first();

        $catBnba = $validated['cat_bnba'];
        if (str_contains(strtoupper($catBnba), 'APBD')) {
            $catBnba = 'APBD BOGOR';
        } else {
            $catBnba = 'BSPS';
        }

        $idBnba = DB::table('app_md_bnba')->insertGetId([
            'cat_bnba' => $catBnba,
            'thn_bnba' => $validated['thn_bnba'] ?: date('Y'),
            'name_bnba' => strtoupper(trim($validated['name_bnba'])),
            'bnba_jkel' => $validated['bnba_jkel'],
            'bnba_nik' => trim($validated['bnba_nik']),
            'bnba_kk' => ! empty($validated['bnba_kk']) ? trim($validated['bnba_kk']) : '0',
            'bnba_alamat' => strtoupper(trim($validated['bnba_alamat'])),
            'bnba_rt' => ! empty($validated['bnba_rt']) ? str_pad(trim($validated['bnba_rt']), 3, '0', STR_PAD_LEFT) : null,
            'bnba_rw' => ! empty($validated['bnba_rw']) ? str_pad(trim($validated['bnba_rw']), 3, '0', STR_PAD_LEFT) : null,
            'id_kel' => $validated['id_kel'],
            'id_kec' => $validated['id_kec'],
            'st_akhir' => $validated['st_akhir'],
            'gps_lat' => ! empty($validated['gps_lat']) ? (float) $validated['gps_lat'] : 0,
            'gps_long' => ! empty($validated['gps_long']) ? (float) $validated['gps_long'] : 0,
            'id_user' => Auth::id() ?? 1,
            'tgl_data' => now(),
            'flag_del' => 0,
            'xkel' => $kel ? strtoupper($kel->name_kel) : '',
            'xkec' => $kec ? strtoupper($kec->name_kec) : '',
        ]);

        return back()->with('status', "Data rumah baru untuk penerima '".strtoupper(trim($validated['name_bnba']))."' berhasil ditambahkan (ID #{$idBnba}).");
    }

    /**
     * API ambil daftar kelurahan / desa berdasarkan kecamatan.
     */
    public function getKelurahanByKecamatan(int $id_kec)
    {
        $kelurahans = DB::table('app_md_kel')
            ->where('id_kec', $id_kec)
            ->where('flag_del', 0)
            ->select('id_kel', 'name_kel')
            ->orderBy('name_kel', 'asc')
            ->get();

        return response()->json($kelurahans);
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
