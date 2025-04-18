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
        Schema::create('actor', function (Blueprint $table) {
            $table->id();
            $table->string('nik')->nullable();
            $table->foreign('nik')->references('nik')->on('employee')->onDelete('cascade')->onUpdate('cascade');
            $table->unsignedBigInteger('user_id');
            $table->string('user_type');
            $table->string('password');
            $table->enum('role',['admin', 'karyawan', 'super admin']);
            $table->rememberToken();
            $table->timestamps();

            $table->unique(['nik', 'role']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('actor');
    }
};
