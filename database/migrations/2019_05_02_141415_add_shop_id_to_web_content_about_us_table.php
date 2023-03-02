<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddShopIdToWebContentAboutUsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('web_content_about_us', function (Blueprint $table) {
            $table->unsignedInteger('shop_id')->after('id');
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
        Schema::table('web_content_about_us', function (Blueprint $table) {
            $table->dropForeign('web_content_about_us_shop_id_foreign');
            $table->dropColumn('shop_id');
        });
    }
}
