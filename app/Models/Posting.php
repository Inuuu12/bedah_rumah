<?php

namespace App\Models;

use Database\Factories\PostingFactory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Carbon;

/**
 * Model Posting / Berita Progres Bedah Rumah
 *
 * @property int $id
 * @property Carbon $tanggal_posting
 * @property int|null $id_bnba
 * @property string|null $judul
 * @property string $keterangan
 * @property string|null $link_instagram
 * @property string|null $link_facebook
 * @property string|null $link_tiktok
 * @property string|null $link_youtube
 * @property string|null $foto_persiapan_1
 * @property string|null $foto_persiapan_2
 * @property string|null $foto_persiapan_3
 * @property string|null $foto_pembangunan_1
 * @property string|null $foto_pembangunan_2
 * @property string|null $foto_pembangunan_3
 * @property string|null $foto_selesai_1
 * @property string|null $foto_selesai_2
 * @property string|null $foto_selesai_3
 * @property string|null $file_rab
 * @property string|null $nama_file_rab
 * @property string|null $tim_pelapor
 * @property int|null $user_id
 * @property string $status
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 */
class Posting extends Model
{
    /** @use HasFactory<PostingFactory> */
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'postings';

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'tanggal_posting',
        'id_bnba',
        'judul',
        'keterangan',
        'link_instagram',
        'link_facebook',
        'link_tiktok',
        'link_youtube',
        'foto_persiapan_1',
        'foto_persiapan_2',
        'foto_persiapan_3',
        'foto_pembangunan_1',
        'foto_pembangunan_2',
        'foto_pembangunan_3',
        'foto_selesai_1',
        'foto_selesai_2',
        'foto_selesai_3',
        'file_rab',
        'nama_file_rab',
        'tim_pelapor',
        'user_id',
        'status',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'tanggal_posting' => 'datetime',
            'id_bnba' => 'integer',
            'user_id' => 'integer',
        ];
    }

    /**
     * Relasi ke user / admin pembuat postingan.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Relasi ke penerima BNBA terkait (dari tabel app_md_bnba).
     */
    public function bnba(): BelongsTo
    {
        return $this->belongsTo(Bnba::class, 'id_bnba', 'id_bnba');
    }

    /**
     * Koleksi foto tahap persiapan dalam bentuk array URL / path.
     *
     * @return list<string>
     */
    public function getFotosPersiapanAttribute(): array
    {
        return array_values(array_filter([
            $this->foto_persiapan_1,
            $this->foto_persiapan_2,
            $this->foto_persiapan_3,
        ]));
    }

    /**
     * Koleksi foto tahap pembangunan / pengerjaan dalam bentuk array URL / path.
     *
     * @return list<string>
     */
    public function getFotosPembangunanAttribute(): array
    {
        return array_values(array_filter([
            $this->foto_pembangunan_1,
            $this->foto_pembangunan_2,
            $this->foto_pembangunan_3,
        ]));
    }

    /**
     * Koleksi foto tahap selesai dalam bentuk array URL / path.
     *
     * @return list<string>
     */
    public function getFotosSelesaiAttribute(): array
    {
        return array_values(array_filter([
            $this->foto_selesai_1,
            $this->foto_selesai_2,
            $this->foto_selesai_3,
        ]));
    }

    /**
     * Scope untuk mengambil posting yang sudah dipublikasikan.
     */
    public function scopePublished(Builder $query): Builder
    {
        return $query->where('status', 'PUBLISHED');
    }

    /**
     * Scope urutan tanggal posting terbaru.
     */
    public function scopeRecent(Builder $query): Builder
    {
        return $query->orderBy('tanggal_posting', 'desc');
    }
}
