<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('parameters', function (Blueprint $table) {
            $table->unsignedInteger('harga')->nullable()->default(null)->change();
        });
    }

    public function down(): void
    {
        DB::table('parameters')
            ->whereNull('harga')
            ->update(['harga' => 0]);

        Schema::table('parameters', function (Blueprint $table) {
            $table->unsignedInteger('harga')->nullable(false)->default(0)->change();
        });
    }
};
