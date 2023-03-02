<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColLocationToAbbasterInformationTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('abbaster_information', function (Blueprint $table) {
            $table->text('location')->nullable();
            $table->string('style_color_txt')->nullable();
            $table->string('style_color_bg')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('abbaster_information', function (Blueprint $table) {
            $table->dropColumn('location');
            $table->dropColumn('style_color_txt');
            $table->dropColumn('style_color_bg');
        });
    }
}
