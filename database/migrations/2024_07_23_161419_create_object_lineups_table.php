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
        Schema::create('object_lineups', function (Blueprint $table) {
            $table->id();
            $table->string("name")->comment("商品名");
            $table->string("description")->comment("商品説明");
            $table->integer("amount")->comment("商品金額");
            $table->string("preview_file")->comment("商品紹介画像");
            $table->string("download_file")->comment("商品ダウンロード");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('object_lineups');
    }
};
