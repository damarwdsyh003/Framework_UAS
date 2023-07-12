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
        Schema::create('tenant', function (Blueprint $table) {
            $table->BigIncrements('id_tenant');
            $table->unsignedBigInteger('id_makanan');
            $table->unsignedBigInteger('id_minuman');
            $table->string('nama_tenant');
            $table->timestamps();

            $table->foreign('id_makanan')->references('id_makanan')->on('makanan');
            $table->foreign('id_minuman')->references('id_minuman')->on('minuman');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tenant');
    }
};
