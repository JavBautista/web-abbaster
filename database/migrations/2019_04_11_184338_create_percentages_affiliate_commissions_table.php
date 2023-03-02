<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePercentagesAffiliateCommissionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('percentages_affiliate_commissions', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('description')->nullable();
            $table->integer('minimum_range')->default(0);
            $table->integer('middle_range')->default(0);
            $table->integer('maximum_range')->default(0);
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
        Schema::dropIfExists('percentages_affiliate_commissions');
    }
}
