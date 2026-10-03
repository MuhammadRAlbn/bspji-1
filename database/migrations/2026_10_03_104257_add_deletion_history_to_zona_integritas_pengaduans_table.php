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
        Schema::table('zona_integritas_pengaduans', function (Blueprint $table) {
            $table->softDeletes()->index();
            $table->text('deletion_reason')->nullable();
            $table->unsignedBigInteger('deleted_by_id')->nullable()->index();
            $table->string('deleted_by_name')->nullable();
            $table->string('deleted_by_email')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('zona_integritas_pengaduans', function (Blueprint $table) {
            $table->dropIndex(['deleted_by_id']);
            $table->dropIndex(['deleted_at']);
            $table->dropSoftDeletes();
            $table->dropColumn(['deletion_reason', 'deleted_by_id', 'deleted_by_name', 'deleted_by_email']);
        });
    }
};
