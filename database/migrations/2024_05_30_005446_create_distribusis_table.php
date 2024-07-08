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
        Schema::create('distribusis', function (Blueprint $table) {
            $table->id();
            $table->date('tanggal')->nullable(false);
            $table->string('tempat')->nullable(false);
            $table->string('penerima_manfaat')->nullable(false);
            $table->string('anggaran')->nullable(false);
            $table->string('pengeluaran')->nullable(false);
            $table->string('sisa')->nullable();
            $table->string('file')->nullable();
            $table->unsignedBigInteger('programs_id');
            $table->foreign('programs_id')->references('id')->on('programs')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('distribusis');
    }
};
