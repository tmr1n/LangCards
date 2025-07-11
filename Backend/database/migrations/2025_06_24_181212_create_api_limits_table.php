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
        Schema::create('api_limits', function (Blueprint $table) {
            $table->id();
            $table->date('day')->unique(); // Дата (без времени)
            $table->unsignedInteger('request_count')->default(0); // Количество запросов
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('api_limits');
    }
};
