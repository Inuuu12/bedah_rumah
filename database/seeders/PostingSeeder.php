<?php

namespace Database\Seeders;

use App\Models\Posting;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PostingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $admin = User::first();
        $adminId = $admin ? $admin->id : null;

        // Ambil beberapa ID BNBA jika ada di database
        $bnbaList = DB::table('app_md_bnba')
            ->where('flag_del', 0)
            ->limit(5)
            ->pluck('id_bnba')
            ->toArray();

        $sampleBnba1 = $bnbaList[0] ?? null;
        $sampleBnba2 = $bnbaList[1] ?? null;

        Posting::create([
            'tanggal_posting' => now()->subDays(3),
            'id_bnba' => $sampleBnba1,
            'judul' => 'Realisasi Bantuan Bedah Rumah RTLH di Kecamatan Cibinong',
            'keterangan' => 'Pemerintah Kabupaten Bogor melalui Dinas Perumahan, Kawasan Permukiman dan Pertanahan (DPKPP) telah menyelesaikan pengerjaan renovasi rumah tidak layak huni untuk penerima manfaat di wilayah Cibinong. Kondisi atap dan sanitasi kini telah memenuhi standar kelayakan huni.',
            'link_instagram' => 'https://www.instagram.com/kabupaten.bogor',
            'link_facebook' => 'https://www.facebook.com/pemkabbogor',
            'link_tiktok' => 'https://www.tiktok.com/@pemkabbogor',
            'link_youtube' => 'https://www.youtube.com/@pemkabbogor',
            'foto_persiapan_1' => 'images/dokumentasi/persiapan_1.jpg',
            'foto_persiapan_2' => 'images/dokumentasi/persiapan_2.jpg',
            'foto_persiapan_3' => null,
            'foto_pembangunan_1' => 'images/dokumentasi/pembangunan_1.jpg',
            'foto_pembangunan_2' => 'images/dokumentasi/pembangunan_2.jpg',
            'foto_pembangunan_3' => null,
            'foto_selesai_1' => 'images/dokumentasi/selesai_1.jpg',
            'foto_selesai_2' => 'images/dokumentasi/selesai_2.jpg',
            'foto_selesai_3' => null,
            'file_rab' => 'uploads/rab/rab_cibinong.pdf',
            'nama_file_rab' => 'RAB_RTLH_Cibinong_2026.pdf',
            'tim_pelapor' => 'Fasilitator Lapangan RTLH Cibinong (Bpk. Hendra & Tim)',
            'user_id' => $adminId,
            'status' => 'PUBLISHED',
        ]);

        if ($sampleBnba2) {
            Posting::create([
                'tanggal_posting' => now()->subDays(1),
                'id_bnba' => $sampleBnba2,
                'judul' => 'Penyaluran dan Pengerjaan Fisik Bedah Rumah APBD di Kecamatan Ciampea',
                'keterangan' => 'Proses pengerjaan fisik bedah rumah telah mencapai tahap 60%. Dinding batako telah terpasang dan saat ini sedang dilakukan pemasangan rangka atap baja ringan.',
                'link_instagram' => 'https://www.instagram.com/kabupaten.bogor',
                'link_facebook' => 'https://www.facebook.com/pemkabbogor',
                'link_tiktok' => 'https://www.tiktok.com/@pemkabbogor',
                'link_youtube' => 'https://www.youtube.com/@pemkabbogor',
                'foto_persiapan_1' => 'images/dokumentasi/persiapan_ciamp.jpg',
                'foto_persiapan_2' => null,
                'foto_persiapan_3' => null,
                'foto_pembangunan_1' => 'images/dokumentasi/pembangunan_ciamp.jpg',
                'foto_pembangunan_2' => null,
                'foto_pembangunan_3' => null,
                'foto_selesai_1' => null,
                'foto_selesai_2' => null,
                'foto_selesai_3' => null,
                'file_rab' => 'uploads/rab/rab_ciampea.pdf',
                'nama_file_rab' => 'RAB_RTLH_Ciampea_2026.pdf',
                'tim_pelapor' => 'Tim Monev DPKPP Wilayah II',
                'user_id' => $adminId,
                'status' => 'PUBLISHED',
            ]);
        }
    }
}
