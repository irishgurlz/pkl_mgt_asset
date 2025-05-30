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
        Schema::create('pendanaan', function (Blueprint $table) {
            $table->id();
            $table->string('no_pmn')->unique();
            $table->string('deskripsi')->nullable();
            $table->date('tanggal');
            $table->string('file_attach');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('strategy');
    }
};
