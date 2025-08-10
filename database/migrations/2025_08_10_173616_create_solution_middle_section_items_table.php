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
        Schema::create('solution_middle_section_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('solution_middle_section_id')->constrained('solution_middle_sections')->cascadeOnDelete();
            $table->string('title');
            $table->text('description');
            $table->string('icon');
            $table->integer('order')->default(0);
            $table->boolean('is_active')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('solution_middle_section_items');
    }
};
