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
        if (! Schema::hasTable('tbl_kabupaten')) {
            return;
        }

        Schema::table('tbl_kabupaten', function (Blueprint $table) {
            if (! Schema::hasColumn('tbl_kabupaten', 'latitude')) {
                $table->decimal('latitude', 10, 7)->nullable()->after('nama_kabupaten');
            }

            if (! Schema::hasColumn('tbl_kabupaten', 'longitude')) {
                $table->decimal('longitude', 10, 7)->nullable()->after('latitude');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (! Schema::hasTable('tbl_kabupaten')) {
            return;
        }

        Schema::table('tbl_kabupaten', function (Blueprint $table) {
            if (Schema::hasColumn('tbl_kabupaten', 'latitude')) {
                $table->dropColumn('latitude');
            }

            if (Schema::hasColumn('tbl_kabupaten', 'longitude')) {
                $table->dropColumn('longitude');
            }
        });
    }
};
