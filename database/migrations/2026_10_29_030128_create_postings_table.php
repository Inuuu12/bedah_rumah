<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('postings', function (Blueprint $table) {
            // 1. ID Posting
            $table->id();

            // 2. Tanggal Posting
            $table->dateTime('tanggal_posting')->useCurrent();

            // 3. ID BNBA (Relasi ke Penerima Bantuan RTLH/BSPS di app_md_bnba)
            $table->unsignedBigInteger('id_bnba')->nullable()->index();

            // 4. Judul & Keterangan / Berita
            $table->string('judul')->nullable();
            $table->longText('keterangan');

            // 5. Link Media Sosial
            $table->string('link_instagram')->nullable();
            $table->string('link_facebook')->nullable();
            $table->string('link_tiktok')->nullable();
            $table->string('link_youtube')->nullable();

            // 6. Dokumentasi Foto (@3 foto per tahap)
            // Tahap Persiapan
            $table->string('foto_persiapan_1')->nullable();
            $table->string('foto_persiapan_2')->nullable();
            $table->string('foto_persiapan_3')->nullable();

            // Tahap Pembangunan / Proses
            $table->string('foto_pembangunan_1')->nullable();
            $table->string('foto_pembangunan_2')->nullable();
            $table->string('foto_pembangunan_3')->nullable();

            // Tahap Selesai
            $table->string('foto_selesai_1')->nullable();
            $table->string('foto_selesai_2')->nullable();
            $table->string('foto_selesai_3')->nullable();

            // 7. File RAB (Dokumen PDF / Excel)
            $table->string('file_rab')->nullable();
            $table->string('nama_file_rab')->nullable();

            // 8. Tim Pelapor (Freetext)
            $table->string('tim_pelapor')->nullable();

            // Metadata Tambahan
            $table->foreignId('user_id')->nullable()->nullOnDelete(); // Admin / User pembuat
            $table->enum('status', ['DRAFT', 'PUBLISHED'])->default('PUBLISHED');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('postings');
    }
};
