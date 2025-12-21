<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('juries', function (Blueprint $table) {
            $table->id();
            $table->string('name');                 // ex : "Jury L3 Info - S5 2024"
            $table->string('promotion')->nullable(); // ex : "L3 Informatique"
            $table->string('semester')->nullable();  // ex : "S5"
            $table->string('session')->nullable();   // Normale, Rattrapage...
            $table->dateTime('meeting_at')->nullable();
            $table->string('status')->default('draft'); // draft, validated, archived
            $table->timestamps();
        });

        Schema::create('juries_student', function (Blueprint $table) {
            $table->id();
            $table->foreignId('jury_id')->constrained()->onDelete('cascade');
            $table->foreignId('student_id')->constrained()->onDelete('cascade');
            // Optionnel : infos spécifiques au jury
            $table->string('decision')->nullable(); // Admis, Ajourné...
            $table->text('comment')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('juries_student');
        Schema::dropIfExists('juries');
    }
};
