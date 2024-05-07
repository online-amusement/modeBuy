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
            $table->string('name')->comment('氏名')->change();
            $table->string('email')->comment('メールアドレス')->change();
            $table->string('password')->comment('パスワード')->change();
            $table->string('address')->comment('住所')->change();
            $table->string('city')->comment('住所2')->change();
            $table->string('country')->comment('国')->change();
            $table->integer('point')->comment('ポイント')->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('members', function (Blueprint $table) {
            //
        });
    }
};
