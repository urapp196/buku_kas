<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->enum('type', ['masuk', 'keluar']);
            $table->date('date');
            $table->string('category', 60);
            $table->string('description', 60)->nullable();
            $table->unsignedBigInteger('amount');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};
