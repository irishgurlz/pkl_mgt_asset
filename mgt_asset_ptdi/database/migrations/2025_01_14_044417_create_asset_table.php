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
        Schema::create('asset', function (Blueprint $table) {
            $table->id();
            $table->string('nomor_asset')->unique();
            $table->string('no_pmn');
            $table->foreign('no_pmn')->references('no_pmn')->on('pendanaan')->onDelete('cascade');
            $table->foreignId('id_kategori')->constrained('kategori')->onDelete('cascade');
            $table->foreignId('id_tipe')->constrained('sub_kategori')->onDelete('cascade');
            // $table->string('nama');
            $table->date('umur');
            $table->string('foto')->nullable();
            $table->enum('kondisi',['1', '0'])->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('asset');
    }
};
