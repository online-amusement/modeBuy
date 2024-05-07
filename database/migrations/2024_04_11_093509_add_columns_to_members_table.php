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
            $table->string('api_token', 80)->nullable()->default(null)->comment('トークン')->after('password');
            $table->tinyInteger('status')->comment('0:仮登録 1:通常 2:退会')->after('api_token');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('members', function (Blueprint $table) {
            Schema::dropIfExists('members');
        });
    }
};
