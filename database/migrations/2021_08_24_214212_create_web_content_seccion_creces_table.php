<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateWebContentSeccionCrecesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('web_content_seccion_creces', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->unsignedInteger('shop_id')->default(0);
            $table->string('title')->nullable();
            $table->text('description')->nullable();
            $table->boolean('show')->default(1);

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
        Schema::dropIfExists('web_content_seccion_creces');
    }
}
