<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateNew extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('crawl_news', function(Blueprint $table)
        {
            $table->increments('new_id');
            $table->string('new_title');
            $table->string('new_title_old');
            $table->string('new_title_md5')->unique()->index();
            $table->integer('new_domain_id')->index();
            $table->string('new_link_from_domain');
            $table->string('new_img');
            $table->integer('new_cate_id')->index();
            $table->text('new_description');
            $table->text('new_content');
            $table->tinyInteger('new_top');
            $table->tinyInteger('new_hot');
            $table->tinyInteger('new_status');
            $table->integer('new_date');
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
        Schema::drop('crawl_news');
    }

}
