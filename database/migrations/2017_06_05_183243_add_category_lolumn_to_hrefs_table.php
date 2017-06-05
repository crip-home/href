<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddCategoryLolumnToHrefsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('hrefs', function (Blueprint $table) {
            $table->unsignedInteger('category_id')->index()->nullable();
            $table->foreign('category_id')->references('id')->on('categories');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('hrefs', function (Blueprint $table) {
            $table->dropForeign('hrefs_category_id_foreign');
            $table->dropColumn('category_id');
        });
    }
}
