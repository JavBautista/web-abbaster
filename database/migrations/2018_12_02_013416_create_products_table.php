<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->increments('id');
            $table->tinyInteger('status');
            $table->string('key');
            $table->string('barcode')->nullable();
            $table->string('name')->nullable();
            $table->text('description')->nullable();
            $table->decimal('cost',8,2)->nullable();
            $table->decimal('retail',8,2)->nullable();
            $table->decimal('wholesale',8,2)->nullable();            
            $table->decimal('shipping',8,2)->nullable();            
            $table->string('image')->nullable();
            $table->string('url_video')->nullable();
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
}
