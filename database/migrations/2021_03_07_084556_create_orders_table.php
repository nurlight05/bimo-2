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
            $table->string('code');
            $table->decimal('total_price')->default(0);
            $table->string('payment_mode')->nullable();
            $table->date('planned_delivery_date')->nullable();
            $table->date('creation_date')->nullable();
            $table->string('delivery_mode')->nullable();
            $table->string('state')->nullable();
            $table->string('status')->nullable();
            $table->decimal('delivery_cost')->default(0);
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
