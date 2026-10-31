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
        if (Schema::hasTable('postings') && ! Schema::hasColumn('postings', 'link_youtube')) {
            Schema::table('postings', function (Blueprint $table) {
                $table->string('link_youtube')->nullable()->after('link_tiktok');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasTable('postings') && Schema::hasColumn('postings', 'link_youtube')) {
            Schema::table('postings', function (Blueprint $table) {
                $table->dropColumn('link_youtube');
            });
        }
    }
};
