<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateServicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('services', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('shop_id');
            $table->boolean('active')->default(1);
            $table->string('name')->nullable();
            $table->text('description')->nullable();
            $table->decimal('cost',8,2)->nullable();
            $table->string('image')->nullable();
            $table->string('url_video')->nullable();
            $table->string('slug')->nullable();
            $table->integer('order_by')->default(0);
            $table->timestamps();

            $table->foreign('shop_id')->references('id')->on('shops');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('services');
    }
}
