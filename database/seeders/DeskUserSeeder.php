<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;

class DeskUserSeeder extends Seeder
{
    /**
     * Run the database seeds from USER_DESK_RTLH_SHARE.
     */
    public function run(): void
    {
        $jsonPath = database_path('data/desk_users.json');
        if (! file_exists($jsonPath)) {
            return;
        }

        $users = json_decode(file_get_contents($jsonPath), true);
        if (! is_array($users)) {
            return;
        }

        $hasAppMdUser = Schema::hasTable('app_md_user');
        $hasUsers = Schema::hasTable('users');

        foreach ($users as $u) {
            $login = strtolower(trim($u['login_user']));
            $email = $login.'@bogorkab.go.id';
            $plainPassword = $u['pswd'];

            // 1. Simpan ke tabel users standar Laravel
            if ($hasUsers) {
                User::updateOrCreate(
                    ['email' => $email],
                    [
                        'name' => $u['name_user'],
                        'password' => Hash::make($plainPassword),
                    ]
                );
            }

            // 2. Simpan ke tabel legacy app_md_user jika ada
            if ($hasAppMdUser) {
                $existing = DB::table('app_md_user')->where('login_user', $login)->first();
                if ($existing) {
                    DB::table('app_md_user')
                        ->where('login_user', $login)
                        ->update([
                            'name_user' => $u['name_user'],
                            'level_user' => $u['level_user'],
                            'pswd' => $plainPassword,
                            'flag_del' => 0,
                        ]);
                } else {
                    DB::table('app_md_user')->insert([
                        'id_user' => $u['id_user'],
                        'name_user' => $u['name_user'],
                        'level_user' => $u['level_user'],
                        'login_user' => $login,
                        'pswd' => $plainPassword,
                        'flag_del' => 0,
                    ]);
                }
            }
        }
    }
}
