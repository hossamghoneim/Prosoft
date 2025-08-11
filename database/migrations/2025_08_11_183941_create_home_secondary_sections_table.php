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
        Schema::create('home_secondary_sections', function (Blueprint $table) {
            $table->id();
            $table->string('main_title');
            $table->text('main_description');
            $table->string('background_image');
            $table->string('first_card_logo');
            $table->string('first_card_title');
            $table->text('first_card_description');
            $table->string('second_card_logo');
            $table->string('second_card_title');
            $table->text('second_card_description');
            $table->string('third_card_logo');
            $table->string('third_card_title');
            $table->text('third_card_description');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('home_secondary_sections');
    }
};
