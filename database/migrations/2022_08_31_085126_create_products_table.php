<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();

            // translated columns
            $table->string('name_ar')->nullable();
            $table->string('name_en')->nullable();
            $table->text('short_description_ar')->nullable();
            $table->text('short_description_en')->nullable();
            $table->text('long_description_ar')->nullable();
            $table->text('long_description_en')->nullable();

            $table->string('main_image');
            $table->text('images')->nullable();
            $table->decimal('price',10,2);
            $table->decimal('price_after_discount',10,2)->nullable();
            $table->date('discount_from')->nullable();
            $table->date('discount_to')->nullable();
            $table->string('sku')->nullable();
            $table->integer('stock_quantity')->default(0);
            $table->boolean('status')->default(false);
            $table->decimal('rate')->default(0.0);
            $table->foreignId('category_id')->constrained('categories')->onDelete('cascade')->onUpdate('cascade');
            $table->foreignId('vendor_id')->constrained('vendors')->onDelete('cascade')->onUpdate('cascade');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('products');
    }
};
