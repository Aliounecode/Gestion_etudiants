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
        Schema::create('grades', function (Blueprint $table) {
    $table->id();
    $table->foreignId('student_id')->constrained()->onDelete('cascade');
    $table->foreignId('module_id')->constrained()->onDelete('cascade');
    $table->decimal('score_exam', 5, 2)->nullable();
    $table->decimal('score_cc', 5, 2)->nullable();
    $table->decimal('average', 5, 2)->nullable();
    $table->string('status')->default('pending'); // pending, validated, rejected
    $table->timestamps();
});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('grades');
    }
};
