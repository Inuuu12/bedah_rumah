<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

#[Fillable(['name', 'email', 'password'])]
#[Hidden(['password', 'remember_token'])]
class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    /**
     * Cache map akun dari desk_users.json
     *
     * @var array<string, array>|null
     */
    protected static ?array $deskUsersMap = null;

    /**
     * Dapatkan detail akun desk berdasarkan username/email
     */
    public function getDeskUser(): ?array
    {
        if (static::$deskUsersMap === null) {
            static::$deskUsersMap = [];
            $jsonPath = database_path('data/desk_users.json');
            if (file_exists($jsonPath)) {
                $data = json_decode(file_get_contents($jsonPath), true);
                if (is_array($data)) {
                    foreach ($data as $item) {
                        $key = strtolower(trim($item['login_user']));
                        static::$deskUsersMap[$key] = $item;
                    }
                }
            }
        }

        $cleanLogin = strtolower(str_replace('@bogorkab.go.id', '', $this->email ?? ''));

        return static::$deskUsersMap[$cleanLogin] ?? null;
    }

    /**
     * Tipe peran akun: 'admin_inti', 'admin_kecamatan', atau 'admin_desa'
     */
    public function getRoleAttribute(): string
    {
        $cleanLogin = strtolower(str_replace('@bogorkab.go.id', '', $this->email ?? ''));

        // Akun utama pengelola Pemkab Bogor
        if (in_array($cleanLogin, ['admin', 'bestie', 'adminbedahrumah', 'deskbedahrumah'])) {
            return 'admin_inti';
        }

        $desk = $this->getDeskUser();
        if ($desk) {
            if ($desk['sheet'] === 'user_kab') {
                return 'admin_inti';
            }
            if ($desk['sheet'] === 'user_kec') {
                return 'admin_kecamatan';
            }
            if ($desk['sheet'] === 'usr_desa') {
                return 'admin_desa';
            }
        }

        // Fallback pola penamaan login_user
        if (preg_match('/^rtlh\.[a-z]{4}\d{4}$/', $cleanLogin)) {
            return 'admin_desa';
        }
        if (str_starts_with($cleanLogin, 'rtlh.')) {
            return 'admin_kecamatan';
        }

        return 'admin_inti';
    }

    /**
     * Apakah pengguna diizinkan menginput data usulan warga baru (BNBA)?
     * Sesuai aturan: Hanya Admin Inti dan Admin Desa yang bisa. Admin Kecamatan TIDAK BISA.
     */
    public function canInputWarga(): bool
    {
        return $this->role !== 'admin_kecamatan';
    }

    public function isInti(): bool
    {
        return $this->role === 'admin_inti';
    }

    public function isKecamatan(): bool
    {
        return $this->role === 'admin_kecamatan';
    }

    public function isDesa(): bool
    {
        return $this->role === 'admin_desa';
    }

    public function getRoleLabelAttribute(): string
    {
        return match ($this->role) {
            'admin_inti' => 'Admin Inti',
            'admin_kecamatan' => 'Admin Kecamatan',
            'admin_desa' => 'Admin Desa',
            default => 'Administrator',
        };
    }

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }
}
