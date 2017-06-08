<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * Class CreateHrefsTable
 */
class CreateHrefsTable extends BaseMigration
{
    /**
     * Run the migrations.
     * @return void
     */
    public function up()
    {
        Schema::create('hrefs', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('parent_id');

            $table->unsignedInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users');

            $table->timestamp('date_added')->nullable();
            $table->unsignedInteger('index')->default(0);
            $table->boolean('visible')->default(true);

            $table->string('title');
            $table->string('url', 500)->nullable();

            $this->audit($table);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('hrefs');
    }
}
