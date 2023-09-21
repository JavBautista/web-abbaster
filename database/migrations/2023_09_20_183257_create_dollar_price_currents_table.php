<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDollarPriceCurrentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dollar_price_currents', function (Blueprint $table) {
            $table->id();
            $table->decimal('price',8,2)->default(0);
        });

        DB::table('dollar_price_currents')->insert(array('id'=>'1','price'=>'20.5'));
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('dollar_price_currents');
    }
}
