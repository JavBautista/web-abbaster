<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddShopIdColumnToDownloadDocumentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('download_documents', function (Blueprint $table) {
            $table->unsignedInteger('shop_id')->after('status');
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
        Schema::table('download_documents', function (Blueprint $table) {
            $table->dropForeign('download_documents_shop_id_foreign');
            $table->dropColumn('shop_id');
        });
    }
}
