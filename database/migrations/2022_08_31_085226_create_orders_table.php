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
        Schema::create('orders', function (Blueprint $table) {

            $table->id();
            $table->string('notes')->nullable();
            $table->string('coupon_code')->nullable();
            $table->decimal('sub_total');
            $table->decimal('total_price');
            $table->enum('status',['placed' , 'processing', 'on_delivery',  'delivered'])->default('placed');
            $table->dateTime('opened_at')->nullable();

            $table->foreignId('opened_by')->nullable()->constrained('admins')->onDelete('cascade')->onUpdate('cascade');
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade')->onUpdate('cascade');
            $table->foreignId('address_id')->constrained('user_addresses')->onDelete('cascade')->onUpdate('cascade');

            $table->string('date'); // needs it for making reports queries faster

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
        Schema::dropIfExists('orders');
    }
};
