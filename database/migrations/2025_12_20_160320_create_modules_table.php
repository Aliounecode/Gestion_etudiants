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
        Schema::create('modules', function (Blueprint $table) {
            $table->id();

            // FK vers filiere
            $table->foreignId('filiere_id')
                  ->constrained()
                  ->cascadeOnDelete();

            // FK vers semestre (table semesters)
            $table->foreignId('semester_id')
                  ->nullable()
                  ->constrained('semesters')
                  ->nullOnDelete();

            // FK vers responsable (table responsables)
            $table->foreignId('responsable_id')
                  ->nullable()
                  ->constrained('responsables')
                  ->nullOnDelete();

            $table->string('code')->unique();   // INF-101, INF-204...
            $table->string('title');            // Algorithmique I...

            $table->enum('status', ['actif', 'en_attente', 'archive'])
                  ->default('actif');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('modules');
    }
};
