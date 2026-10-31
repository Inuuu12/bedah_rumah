<?php

namespace Database\Factories;

use App\Models\Posting;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Posting>
 */
class PostingFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var class-string<Posting>
     */
    protected $model = Posting::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'tanggal_posting' => fake()->dateTimeBetween('-6 months', 'now'),
            'id_bnba' => null,
            'judul' => fake()->sentence(6),
            'keterangan' => fake()->paragraphs(3, true),
            'link_instagram' => 'https://www.instagram.com/kabupaten.bogor',
            'link_facebook' => 'https://www.facebook.com/pemkabbogor',
            'link_tiktok' => 'https://www.tiktok.com/@pemkabbogor',
            'link_youtube' => 'https://www.youtube.com/@pemkabbogor',
            'foto_persiapan_1' => 'uploads/postings/persiapan_1.jpg',
            'foto_persiapan_2' => 'uploads/postings/persiapan_2.jpg',
            'foto_persiapan_3' => null,
            'foto_pembangunan_1' => 'uploads/postings/pembangunan_1.jpg',
            'foto_pembangunan_2' => 'uploads/postings/pembangunan_2.jpg',
            'foto_pembangunan_3' => null,
            'foto_selesai_1' => 'uploads/postings/selesai_1.jpg',
            'foto_selesai_2' => null,
            'foto_selesai_3' => null,
            'file_rab' => 'uploads/rab/rab_contoh.pdf',
            'nama_file_rab' => 'RAB_Bedah_Rumah_2026.pdf',
            'tim_pelapor' => 'Tim Verifikasi Lapangan DPKPP Kec. '.fake()->randomElement(['Cibinong', 'Ciampea', 'Babakan Madang', 'Citeureup']),
            'user_id' => User::factory(),
            'status' => 'PUBLISHED',
        ];
    }
}
