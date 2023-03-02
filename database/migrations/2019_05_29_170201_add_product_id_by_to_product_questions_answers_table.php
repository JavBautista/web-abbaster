<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddProductIdByToProductQuestionsAnswersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('product_questions_answers', function (Blueprint $table) {
            $table->unsignedInteger('product_questions_id');
            $table->foreign('product_questions_id')->references('id')->on('product_questions');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('product_questions_answers', function (Blueprint $table) {
            $table->dropForeign('product_questions_answers_product_questions_id_foreign');
            $table->dropColumn('product_questions_id');
        });
    }
}
