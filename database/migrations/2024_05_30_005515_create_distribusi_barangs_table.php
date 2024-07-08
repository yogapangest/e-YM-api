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
        Schema::create('distribusi_barangs', function (Blueprint $table) {
            $table->id();
            $table->string('nama_barang')->nullable(false);
            $table->string('volume')->nullable(false);
            $table->string('satuan')->nullable(false);
            $table->string('harga_satuan')->nullable(false);
            $table->string('jumlah')->nullable(false);
            $table->unsignedBigInteger('distribusis_id');
            $table->foreign('distribusis_id')->references('id')->on('distribusis')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('distribusi_barangs');
    }
};
