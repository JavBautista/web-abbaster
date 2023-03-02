<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePurchasesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('purchases', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('shop_id')->default(0);
            $table->integer('customer_id')->default(0);
            $table->tinyInteger('status')->default(0);            
            
            $table->string('tracking_number')->nullable();

            $table->decimal('subtotal',8,2)->default(0);            
            $table->decimal('shipping',8,2)->default(0);            
            $table->decimal('tax',8,2)->default(0);            
            $table->decimal('total',8,2)->default(0);            
            
            $table->text('observations')->nullable();
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
        Schema::dropIfExists('purchases');
    }
}
