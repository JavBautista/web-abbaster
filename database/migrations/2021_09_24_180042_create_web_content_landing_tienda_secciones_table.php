<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateWebContentLandingTiendaSeccionesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('web_content_landing_tienda_secciones', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->unsignedInteger('shop_id')->default(0);
            $table->string('title')->nullable();
            $table->text('description')->nullable();
            $table->boolean('show')->default(1);
            $table->string('image')->nullable();
            $table->longText('content')->nullable();
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
        Schema::dropIfExists('web_content_landing_tienda_secciones');
    }
}
