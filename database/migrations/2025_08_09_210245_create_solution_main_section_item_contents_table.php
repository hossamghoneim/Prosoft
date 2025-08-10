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
        Schema::create('solution_main_section_item_contents', function (Blueprint $table) {
            $table->id();
            $table->foreignId('solution_main_section_item_id')->constrained('solution_main_section_items')->cascadeOnDelete()->name('smsec_item_id_fk');
            $table->string('main_title');
            $table->text('description');
            $table->string('background_image');
            $table->string('first_card_title');
            $table->text('first_card_description');
            $table->string('second_card_title')->nullable();
            $table->text('second_card_description')->nullable();
            $table->string('third_card_title')->nullable();
            $table->text('third_card_description')->nullable();
            $table->string('logo')->nullable();
            $table->string('button_text')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('solution_main_section_item_contents');
    }
};
