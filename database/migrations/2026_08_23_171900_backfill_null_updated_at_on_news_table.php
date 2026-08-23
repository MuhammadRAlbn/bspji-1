<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        DB::table('news')
            ->whereNull('created_at')
            ->update(['created_at' => DB::raw('published_at')]);

        DB::table('news')
            ->whereNull('updated_at')
            ->update(['updated_at' => DB::raw('COALESCE(created_at, published_at)')]);
    }

    public function down(): void
    {
        // Tidak bisa di-revert karena kita tidak tahu row mana yang aslinya null
    }
};
