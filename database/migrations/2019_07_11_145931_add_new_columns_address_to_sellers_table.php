<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddNewColumnsAddressToSellersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('sellers', function (Blueprint $table) {
            $table->string('rfc')->nullable()->after('name');
            $table->string('number_out')->nullable()->after('address');
            $table->string('number_int')->nullable()->after('number_out');            
            $table->string('reference')->nullable()->after('state');
            $table->string('detail')->nullable()->after('reference');
            $table->string('observations')->nullable()->after('detail');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('sellers', function (Blueprint $table) {
            $table->dropColumn('rfc');
            $table->dropColumn('number_out');
            $table->dropColumn('number_int');
            $table->dropColumn('reference');
            $table->dropColumn('detail');
            $table->dropColumn('observations');
        });
    }
}
