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
        Schema::create('object_lineup_software', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger("object_lineup_id")->comment("商品ID");
            $table->unsignedBigInteger("software_id")->comment("ソフトウェアID");
            $table->timestamps();

            $table->foreign('object_lineup_id')->references('id')->on('object_lineups')->onDelete('cascade');
            $table->foreign('software_id')->references('id')->on('softwares')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('object_lineup_software');
    }
};
