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
        Schema::create('partner_banner_section_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('partner_banner_section_id')->constrained('partner_banner_sections')->onDelete('cascade');
            $table->string('icon')->nullable(); // class or image path
            $table->string('title');
            $table->text('description')->nullable();
            $table->boolean('is_active')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('partner_banner_section_items');
    }
};
