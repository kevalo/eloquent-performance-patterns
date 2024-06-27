<?php

use App\Enums\BillStatus;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('bills', static function (Blueprint $table) {
            $table->id();
            $table->text('description')->fulltext();
            $table->double('payment');
            $table->enum('status', BillStatus::toArray())->default('pending');
            $table->foreignId('company_id')->constrained('companies');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('bills');
    }
};
