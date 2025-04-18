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
        Schema::create('history_pengajuan', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_distribution_detail');
            $table->foreign('id_distribution_detail')->references('id')->on('distribution_detail')->onDelete('cascade');
            $table->integer('status')->default(0);
            $table->enum('status_pengajuan',['0', '1', '2', '3'])->default(1);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('history_pengajuan');
    }
};
