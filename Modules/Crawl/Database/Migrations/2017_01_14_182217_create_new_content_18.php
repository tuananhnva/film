<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateNewContent18 extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('news_content_18', function(Blueprint $table)
        {
            $table->increments('nec_id');
            $table->text('nec_content');
            $table->text('nec_release_id');
            $table->text('nec_tag');
            $table->text('nec_description');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('news_content_18');
    }

}
