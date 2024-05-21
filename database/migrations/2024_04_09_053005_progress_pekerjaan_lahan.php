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
        Schema::create('progress_pekerjaan_lahan', function (Blueprint $table) {
            $table->id();
            $table->integer('lahan_id');
            $table->string('deskripsi');
            $table->datetime('tanggal_selesai')->nullable();;
            $table->boolean('status');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('progress_pekerjaan_lahan');
    }
};
