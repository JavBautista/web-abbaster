<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePurchasesDetailTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('purchases_detail', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('purchase_id')->default(0);
            
            $table->integer('product_id')->default(0);
            $table->string('key');
            $table->string('name')->nullable();
            $table->integer('qty')->default(0);
            $table->decimal('price',8,2)->default(0);

            $table->string('type_price')->nullable();
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
        Schema::dropIfExists('purchases_detail');
    }
}
