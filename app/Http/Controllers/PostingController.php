<?php

namespace App\Http\Controllers;

use App\Models\Posting;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;
use Illuminate\View\View;

class PostingController extends Controller
{
    /**
     * Tampilkan daftar dokumentasi / posting di panel admin.
     */
    public function index(Request $request): View
    {
        $this->ensureTableExists();

        if (! Schema::hasTable('postings')) {
            return view('admin.posting.index', [
                'postings' => collect(),
                'tableNotReady' => true,
            ]);
        }

        $query = Posting::query();

        // Pencarian (Judul, Keterangan, Tim Pelapor)
        if ($request->filled('q')) {
            $keyword = trim($request->q);
            $query->where(function ($q) use ($keyword) {
                $q->where('judul', 'like', "%{$keyword}%")
                    ->orWhere('keterangan', 'like', "%{$keyword}%")
                    ->orWhere('tim_pelapor', 'like', "%{$keyword}%");
            });
        }

        $postings = $query->orderBy('tanggal_posting', 'desc')
            ->paginate(10)
            ->withQueryString();

        return view('admin.posting.index', [
            'postings' => $postings,
            'tableNotReady' => false,
        ]);
    }

    /**
     * Tampilkan form pembuatan dokumentasi / posting baru.
     */
    public function create(): View
    {
        $this->ensureTableExists();

        $kecamatanList = collect();
        if (Schema::hasTable('app_md_kec')) {
            $kecamatanList = DB::table('app_md_kec')
                ->where('id_kab', 158)
                ->where('flag_del', 0)
                ->orderBy('name_kec', 'asc')
                ->get();
        }

        $bnbaList = collect();

        return view('admin.posting.create', compact('kecamatanList', 'bnbaList'));
    }

    /**
     * Simpan dokumentasi baru beserta unggahan foto & file RAB.
     */
    public function store(Request $request): RedirectResponse
    {
        $this->ensureTableExists();

        $validated = $request->validate([
            'tanggal_posting' => ['required', 'date'],
            'judul' => ['required', 'string', 'max:255'],
            'id_bnba' => ['nullable', 'integer'],
            'keterangan' => ['required', 'string'],
            'link_instagram' => ['nullable', 'url', 'max:255'],
            'link_facebook' => ['nullable', 'url', 'max:255'],
            'link_tiktok' => ['nullable', 'url', 'max:255'],
            'link_youtube' => ['nullable', 'url', 'max:255'],
            'tim_pelapor' => ['nullable', 'string', 'max:255'],

            // Foto Persiapan (@3 foto)
            'foto_persiapan_1' => ['nullable', 'image', 'mimes:jpeg,jpg,png,webp', 'max:5120'],
            'foto_persiapan_2' => ['nullable', 'image', 'mimes:jpeg,jpg,png,webp', 'max:5120'],
            'foto_persiapan_3' => ['nullable', 'image', 'mimes:jpeg,jpg,png,webp', 'max:5120'],

            // Foto Pembangunan (@3 foto)
            'foto_pembangunan_1' => ['nullable', 'image', 'mimes:jpeg,jpg,png,webp', 'max:5120'],
            'foto_pembangunan_2' => ['nullable', 'image', 'mimes:jpeg,jpg,png,webp', 'max:5120'],
            'foto_pembangunan_3' => ['nullable', 'image', 'mimes:jpeg,jpg,png,webp', 'max:5120'],

            // Foto Selesai (@3 foto)
            'foto_selesai_1' => ['nullable', 'image', 'mimes:jpeg,jpg,png,webp', 'max:5120'],
            'foto_selesai_2' => ['nullable', 'image', 'mimes:jpeg,jpg,png,webp', 'max:5120'],
            'foto_selesai_3' => ['nullable', 'image', 'mimes:jpeg,jpg,png,webp', 'max:5120'],

            // Dokumen RAB: Hanya format PDF (.pdf)
            'file_rab' => ['nullable', 'file', 'mimes:pdf', 'max:20480'],
        ], [
            'judul.required' => 'Judul dokumentasi wajib diisi.',
            'keterangan.required' => 'Keterangan atau berita progres wajib diisi.',
            'tanggal_posting.required' => 'Tanggal posting wajib dipilih.',
            'image' => 'File harus berupa gambar (JPEG, PNG, WEBP).',
            'file_rab.mimes' => 'File RAB wajib berformat PDF (.pdf).',
            'mimes' => 'Format file tidak didukung.',
            'max' => 'Ukuran file melebihi batas maksimum.',
        ]);

        $data = $validated;
        $data['user_id'] = Auth::id();
        $data['status'] = 'PUBLISHED'; // Otomatis langsung tayang tanpa opsi status publikasi

        // Upload Foto-Foto (@3 foto per tahap)
        $photoFields = [
            'foto_persiapan_1', 'foto_persiapan_2', 'foto_persiapan_3',
            'foto_pembangunan_1', 'foto_pembangunan_2', 'foto_pembangunan_3',
            'foto_selesai_1', 'foto_selesai_2', 'foto_selesai_3',
        ];

        foreach ($photoFields as $field) {
            if ($request->hasFile($field)) {
                $data[$field] = $this->uploadFile($request->file($field), 'uploads/postings');
            } else {
                $data[$field] = null;
            }
        }

        // Upload File RAB
        if ($request->hasFile('file_rab')) {
            $rabFile = $request->file('file_rab');
            $data['nama_file_rab'] = $rabFile->getClientOriginalName();
            $data['file_rab'] = $this->uploadFile($rabFile, 'uploads/rab');
        } else {
            $data['file_rab'] = null;
            $data['nama_file_rab'] = null;
        }

        Posting::create($data);

        return redirect()->route('admin.posting.index')
            ->with('status', 'Dokumentasi berhasil dipublikasikan dan langsung tayang di portal publik!');
    }

    /**
     * Tampilkan form edit dokumentasi.
     */
    public function edit(int $id): View
    {
        $this->ensureTableExists();

        $posting = Posting::findOrFail($id);

        $kecamatanList = collect();
        if (Schema::hasTable('app_md_kec')) {
            $kecamatanList = DB::table('app_md_kec')
                ->where('id_kab', 158)
                ->where('flag_del', 0)
                ->orderBy('name_kec', 'asc')
                ->get();
        }

        $selectedBnba = null;
        $selectedKecId = null;
        $selectedKelId = null;
        $desaList = collect();
        $bnbaList = collect();

        if ($posting->id_bnba && Schema::hasTable('app_md_bnba')) {
            $selectedBnba = DB::table('app_md_bnba')
                ->where('id_bnba', $posting->id_bnba)
                ->where('flag_del', 0)
                ->first();

            if ($selectedBnba) {
                $selectedKecId = $selectedBnba->id_kec;
                $selectedKelId = $selectedBnba->id_kel;

                if ($selectedKecId) {
                    $desaList = DB::table('app_md_kel')
                        ->where('id_kec', $selectedKecId)
                        ->where('flag_del', 0)
                        ->orderBy('name_kel', 'asc')
                        ->get();
                }

                if ($selectedKelId) {
                    $bnbaList = DB::table('app_md_bnba')
                        ->where('id_kel', $selectedKelId)
                        ->where('flag_del', 0)
                        ->orderBy('name_bnba', 'asc')
                        ->get()
                        ->map(function ($item) {
                            $nik = trim((string) $item->bnba_nik);
                            $len = strlen($nik);
                            $item->masked_nik = $len > 4
                                ? substr($nik, 0, 2).str_repeat('*', $len - 4).substr($nik, -2)
                                : ($nik ?: '-');

                            return $item;
                        });
                }
            }
        }

        return view('admin.posting.edit', compact(
            'posting',
            'kecamatanList',
            'selectedBnba',
            'selectedKecId',
            'selectedKelId',
            'desaList',
            'bnbaList'
        ));
    }

    /**
     * Perbarui data dokumentasi yang telah tersimpan.
     */
    public function update(Request $request, int $id): RedirectResponse
    {
        $this->ensureTableExists();

        $posting = Posting::findOrFail($id);

        $validated = $request->validate([
            'tanggal_posting' => ['required', 'date'],
            'judul' => ['required', 'string', 'max:255'],
            'id_bnba' => ['nullable', 'integer'],
            'keterangan' => ['required', 'string'],
            'link_instagram' => ['nullable', 'url', 'max:255'],
            'link_facebook' => ['nullable', 'url', 'max:255'],
            'link_tiktok' => ['nullable', 'url', 'max:255'],
            'link_youtube' => ['nullable', 'url', 'max:255'],
            'tim_pelapor' => ['nullable', 'string', 'max:255'],

            'foto_persiapan_1' => ['nullable', 'image', 'mimes:jpeg,jpg,png,webp', 'max:5120'],
            'foto_persiapan_2' => ['nullable', 'image', 'mimes:jpeg,jpg,png,webp', 'max:5120'],
            'foto_persiapan_3' => ['nullable', 'image', 'mimes:jpeg,jpg,png,webp', 'max:5120'],
            'foto_pembangunan_1' => ['nullable', 'image', 'mimes:jpeg,jpg,png,webp', 'max:5120'],
            'foto_pembangunan_2' => ['nullable', 'image', 'mimes:jpeg,jpg,png,webp', 'max:5120'],
            'foto_pembangunan_3' => ['nullable', 'image', 'mimes:jpeg,jpg,png,webp', 'max:5120'],
            'foto_selesai_1' => ['nullable', 'image', 'mimes:jpeg,jpg,png,webp', 'max:5120'],
            'foto_selesai_2' => ['nullable', 'image', 'mimes:jpeg,jpg,png,webp', 'max:5120'],
            'foto_selesai_3' => ['nullable', 'image', 'mimes:jpeg,jpg,png,webp', 'max:5120'],

            // Dokumen RAB: Hanya format PDF (.pdf)
            'file_rab' => ['nullable', 'file', 'mimes:pdf', 'max:20480'],
        ], [
            'file_rab.mimes' => 'File RAB wajib berformat PDF (.pdf).',
        ]);

        $data = $validated;
        $data['status'] = 'PUBLISHED'; // Selalu published

        $photoFields = [
            'foto_persiapan_1', 'foto_persiapan_2', 'foto_persiapan_3',
            'foto_pembangunan_1', 'foto_pembangunan_2', 'foto_pembangunan_3',
            'foto_selesai_1', 'foto_selesai_2', 'foto_selesai_3',
        ];

        foreach ($photoFields as $field) {
            if ($request->hasFile($field)) {
                $this->deleteFile($posting->{$field});
                $data[$field] = $this->uploadFile($request->file($field), 'uploads/postings');
            } else {
                unset($data[$field]);
            }
        }

        if ($request->hasFile('file_rab')) {
            $this->deleteFile($posting->file_rab);
            $rabFile = $request->file('file_rab');
            $data['nama_file_rab'] = $rabFile->getClientOriginalName();
            $data['file_rab'] = $this->uploadFile($rabFile, 'uploads/rab');
        } else {
            unset($data['file_rab'], $data['nama_file_rab']);
        }

        $posting->update($data);

        return redirect()->route('admin.posting.index')
            ->with('status', 'Dokumentasi berhasil diperbarui.');
    }

    /**
     * Hapus dokumentasi beserta file fisik foto dan RAB.
     */
    public function destroy(int $id): RedirectResponse
    {
        $posting = Posting::findOrFail($id);

        $photoFields = [
            'foto_persiapan_1', 'foto_persiapan_2', 'foto_persiapan_3',
            'foto_pembangunan_1', 'foto_pembangunan_2', 'foto_pembangunan_3',
            'foto_selesai_1', 'foto_selesai_2', 'foto_selesai_3',
        ];

        foreach ($photoFields as $field) {
            $this->deleteFile($posting->{$field});
        }

        $this->deleteFile($posting->file_rab);

        $posting->delete();

        return redirect()->route('admin.posting.index')
            ->with('status', 'Dokumentasi berhasil dihapus.');
    }

    /**
     * API untuk mengambil daftar penerima BNBA di suatu desa/kelurahan.
     */
    public function getBnbaByDesa(int $id_kel): JsonResponse
    {
        $list = DB::table('app_md_bnba')
            ->where('id_kel', $id_kel)
            ->where('flag_del', 0)
            ->select('id_bnba', 'name_bnba', 'bnba_nik', 'cat_bnba', 'bnba_alamat', 'st_akhir', 'xkec', 'xkel')
            ->orderBy('name_bnba', 'asc')
            ->get()
            ->map(function ($item) {
                $nik = trim((string) $item->bnba_nik);
                $len = strlen($nik);
                $item->masked_nik = $len > 4
                    ? substr($nik, 0, 2).str_repeat('*', $len - 4).substr($nik, -2)
                    : ($nik ?: '-');

                return $item;
            });

        return response()->json($list);
    }

    /**
     * Helper untuk upload file ke folder public (kompatibel penuh dengan cPanel shared hosting).
     */
    private function uploadFile(UploadedFile $file, string $folder): string
    {
        $destinationPath = public_path($folder);
        if (! File::exists($destinationPath)) {
            File::makeDirectory($destinationPath, 0755, true, true);
        }

        $filename = Str::random(20).'.'.$file->getClientOriginalExtension();
        $file->move($destinationPath, $filename);

        return $folder.'/'.$filename;
    }

    /**
     * Helper untuk menghapus file fisik di folder public.
     */
    private function deleteFile(?string $path): void
    {
        if (! $path) {
            return;
        }

        $fullPath = public_path($path);
        if (File::exists($fullPath) && ! is_dir($fullPath)) {
            File::delete($fullPath);
        }
    }

    /**
     * Pastikan tabel postings dan kolom terkait sudah siap di database.
     * Mencegah error 1146 Table doesn't exist pada shared hosting / server cPanel.
     */
    protected function ensureTableExists(): void
    {
        if (! Schema::hasTable('postings')) {
            try {
                \Illuminate\Support\Facades\Artisan::call('migrate', ['--force' => true]);
            } catch (\Throwable $e) {
                // Abaikan jika migrasi via Artisan gagal
            }

            if (! Schema::hasTable('postings')) {
                Schema::create('postings', function (\Illuminate\Database\Schema\Blueprint $table) {
                    $table->id();
                    $table->dateTime('tanggal_posting')->useCurrent();
                    $table->unsignedBigInteger('id_bnba')->nullable()->index();
                    $table->string('judul')->nullable();
                    $table->longText('keterangan');
                    $table->string('link_instagram')->nullable();
                    $table->string('link_facebook')->nullable();
                    $table->string('link_tiktok')->nullable();
                    $table->string('link_youtube')->nullable();
                    $table->string('foto_persiapan_1')->nullable();
                    $table->string('foto_persiapan_2')->nullable();
                    $table->string('foto_persiapan_3')->nullable();
                    $table->string('foto_pembangunan_1')->nullable();
                    $table->string('foto_pembangunan_2')->nullable();
                    $table->string('foto_pembangunan_3')->nullable();
                    $table->string('foto_selesai_1')->nullable();
                    $table->string('foto_selesai_2')->nullable();
                    $table->string('foto_selesai_3')->nullable();
                    $table->string('file_rab')->nullable();
                    $table->string('nama_file_rab')->nullable();
                    $table->string('tim_pelapor')->nullable();
                    $table->unsignedBigInteger('user_id')->nullable();
                    $table->enum('status', ['DRAFT', 'PUBLISHED'])->default('PUBLISHED');
                    $table->timestamps();
                });
            }
        }

        // Pastikan kolom link_youtube tersedia
        if (Schema::hasTable('postings') && ! Schema::hasColumn('postings', 'link_youtube')) {
            Schema::table('postings', function (\Illuminate\Database\Schema\Blueprint $table) {
                $table->string('link_youtube')->nullable()->after('link_tiktok');
            });
        }

        // Pastikan direktori folder upload tersedia
        if (! File::exists(public_path('uploads/postings'))) {
            File::makeDirectory(public_path('uploads/postings'), 0755, true, true);
        }
        if (! File::exists(public_path('uploads/rab'))) {
            File::makeDirectory(public_path('uploads/rab'), 0755, true, true);
        }
    }
}
