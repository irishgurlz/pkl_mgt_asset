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
        Schema::create('history', function (Blueprint $table) {
            $table->id();

            $table->integer('status_pengalihan')->default(0);

            $table->string('nik');
            $table->foreign('nik')->references('nik')->on('employee')->onDelete('cascade')->onUpdate('cascade');

            $table->string('nomor_penyerahan');
            $table->foreign('nomor_penyerahan')->references('nomor_penyerahan')->on('distribution')->onDelete('cascade');

            $table->string('nomor_asset')->nullable();
            $table->foreign('nomor_asset')->references('nomor_asset')->on('asset')->onDelete('cascade');

            $table->string('nomor_it')->nullable();
            $table->foreign('nomor_it')->references('nomor_it')->on('device')->onDelete('cascade');

            $table->date('tanggal_pengalihan')->nullable();

            $table->string('dokumen_pengalihan')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('history');
    }
};
