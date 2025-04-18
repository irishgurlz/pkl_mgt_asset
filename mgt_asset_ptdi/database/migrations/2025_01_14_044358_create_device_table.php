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
        Schema::create('device', function (Blueprint $table) {
            $table->id();
            $table->string('nomor_it')->unique();
            $table->string('no_pmn');
            $table->foreign('no_pmn')->references('no_pmn')->on('pendanaan')->onDelete('cascade');
            $table->foreignId('id_kategori')->constrained('kategori')->onDelete('cascade');
            $table->foreignId('id_tipe')->constrained('sub_kategori')->onDelete('cascade');
            $table->foreignId('processor')->constrained('sub_kategori')->onDelete('cascade');
            $table->foreignId('storage_type')->constrained('sub_kategori')->onDelete('cascade');
            $table->integer('storage_capacity');
            $table->foreignId('memory_type')->constrained('sub_kategori')->onDelete('cascade');
            $table->integer('memory_capacity');
            $table->string('serial_number');
            $table->foreignId('vga_type')->constrained('sub_kategori')->onDelete('cascade');
            $table->integer('vga_capacity');
            $table->foreignId('operation_system')->constrained('sub_kategori')->onDelete('cascade');
            $table->foreignId('os_license')->constrained('sub_kategori')->onDelete('cascade');
            $table->foreignId('office')->constrained('sub_kategori')->onDelete('cascade');
            $table->foreignId('office_license')->constrained('sub_kategori')->onDelete('cascade');
            $table->date('umur')->nullable();
            $table->string('aplikasi_lainnya');
            $table->string('keterangan_tambahan');
            $table->enum('kondisi',['1', '0'])->default(0);

            $table->string('foto_kondisi')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('device');
    }
};
