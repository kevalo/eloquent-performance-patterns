<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('bill_user', static function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users');
            $table->foreignId('bill_id')->constrained('bills');
            $table->unique(['user_id', 'bill_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('bill_users');
    }
};
