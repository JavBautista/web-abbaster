<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnsTitleContactoWebCityToWebContentTestimoniosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('web_content_testimonios', function (Blueprint $table) {
            $table->string('title')->nullable();
            $table->string('contact')->nullable();
            $table->string('web')->nullable();
            $table->string('city')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('web_content_testimonios', function (Blueprint $table) {
            $table->dropColumn('title');
            $table->dropColumn('contact');
            $table->dropColumn('web');
            $table->dropColumn('city');
        });
    }
}
