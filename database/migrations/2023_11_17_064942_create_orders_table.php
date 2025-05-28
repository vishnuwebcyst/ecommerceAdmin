<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdersTable extends Migration
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
            $table->integer('user_id');
            $table->integer('address_id');
            $table->bigInteger('order_id')->nullable();
            $table->double("total_price",20,4);
            $table->string('total_quantity');
            $table->string('remarks')->nullable();
            $table->enum('status', ['Pending', 'Processing', 'Confirmed', 'Dispatched', 'Out For Delivery', 'Delivered', 'Cancelled', 'Rejected'])->default('Pending');
            $table->string("payment_type")->default("COD");
            $table->enum('payment_status', ['Pending', 'Completed'])->default('Pending');
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
}
