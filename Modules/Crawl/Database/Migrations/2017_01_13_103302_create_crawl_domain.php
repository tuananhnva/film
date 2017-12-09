<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCrawlDomain extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('crawl_domains', function(Blueprint $table)
        {
            $table->increments('cd_id');
            $table->string('cd_domain');
            $table->string('cd_law_crawl_link');
            $table->tinyInteger('cd_add_domain_crawl_link');
            $table->string('cd_law_title');
            $table->string('cd_law_description');
            $table->string('cd_law_content');
            $table->string('cd_law_img');
            $table->string('cd_law_remove');
            $table->string('cd_law_add_page');
            $table->tinyInteger('cd_status');
            $table->tinyInteger('cd_type');
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
        Schema::drop('crawl_domains');
    }

}
