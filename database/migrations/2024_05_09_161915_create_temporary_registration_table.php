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
        Schema::create('temporary_registration', function (Blueprint $table) {
            $table->id();
            $table->string("email", 128);
            $table->string("token", 250)->comment("確認トークン");
            $table->dateTime("expiration_date")->comment("有効期限");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('temporary_registration');
    }
};
