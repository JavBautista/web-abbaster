<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDollarPrice extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dollar_price', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->decimal('price',8,2)->default(0);
            $table->timestamps();
        });

         DB::table('dollar_price')->insert(array('id'=>'1','price'=>'20.5'));
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('dollar_price');
    }
}
