<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        DB::transaction(function (): void {
            $ids = DB::table('sertifikasis')
                ->orderByDesc('created_at')
                ->orderByDesc('id')
                ->pluck('id');

            foreach ($ids as $position => $id) {
                DB::table('sertifikasis')->where('id', $id)->update([
                    'urutan' => $position + 1,
                ]);
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::table('sertifikasis')->update(['urutan' => 0]);
    }
};
