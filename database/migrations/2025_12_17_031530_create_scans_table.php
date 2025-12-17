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
        Schema::create('scans', function (Blueprint $table) {
    $table->id();
    $table->string('filename');
    $table->string('file_path');
    $table->foreignId('user_id')->constrained(); // Qui a uploadé
    $table->string('status')->default('pending'); // pending, processed, error
    $table->json('metadata')->nullable(); // Stocker semestre, module, etc.
    $table->timestamps();
});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('scans');
    }
};
