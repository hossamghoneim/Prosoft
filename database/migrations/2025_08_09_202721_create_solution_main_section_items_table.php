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
        Schema::create('solution_main_section_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('solution_main_section_id')->constrained('solution_main_sections')->cascadeOnDelete();
            $table->string('title');
            $table->string('image');
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
        Schema::dropIfExists('solution_main_section_items');
    }
};
