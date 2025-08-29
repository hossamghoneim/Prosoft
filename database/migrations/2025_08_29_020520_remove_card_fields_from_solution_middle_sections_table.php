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
        Schema::table('solution_middle_sections', function (Blueprint $table) {
            // Remove card fields
            $table->dropColumn([
                'first_card_icon',
                'first_card_title',
                'first_card_description',
                'second_card_icon',
                'second_card_title',
                'second_card_description',
                'third_card_icon',
                'third_card_title',
                'third_card_description'
            ]);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('solution_middle_sections', function (Blueprint $table) {
            // Add back the card fields
            $table->string('first_card_icon')->nullable();
            $table->string('first_card_title')->nullable();
            $table->text('first_card_description')->nullable();
            $table->string('second_card_icon')->nullable();
            $table->string('second_card_title')->nullable();
            $table->text('second_card_description')->nullable();
            $table->string('third_card_icon')->nullable();
            $table->string('third_card_title')->nullable();
            $table->text('third_card_description')->nullable();
        });
    }
};
