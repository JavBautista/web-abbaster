<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDiscountCodesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('discount_codes', function (Blueprint $table) {
            $table->increments('id');
            $table->string('code')->unique(); 
            $table->tinyInteger('status')->default(0);
            $table->integer('type_code')->default(0);
            $table->string('type_discount')->nullable(); 
            $table->decimal('discount',8,2)->default(0); 
            $table->integer('number_uses')->default(0);
            $table->integer('limit_uses')->default(0);
            $table->dateTime('start_date')->nullable();
            $table->dateTime('finish_date')->nullable();
            $table->integer('seller_id')->default(0);
            $table->integer('shop_id')->default(0);
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
        Schema::dropIfExists('discount_codes');
    }
}
