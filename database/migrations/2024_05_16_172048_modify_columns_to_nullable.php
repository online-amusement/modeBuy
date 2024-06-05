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
        Schema::table('members', function (Blueprint $table) {
            $table->string('name')->comment('氏名')->nullable(true)->change();
            $table->string('password', 64)->comment('パスワード')->nullable(true)->change();
            $table->string('country')->comment('国')->nullable(true)->change();
            $table->string('address')->comment('住所')->nullable(true)->change();
            $table->string('city')->comment('住所2')->nullable(true)->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('members', function (Blueprint $table) {
            $table->string('name')->comment('氏名')->nullable(false)->change();
            $table->string('password', 64)->comment('パスワード')->nullable(false)->change();
            $table->string('country')->comment('国')->nullable(false)->change();
            $table->string('address')->comment('住所')->nullable(false)->change();
            $table->string('city')->comment('住所2')->nullable(false)->change();
        });
    }
};
