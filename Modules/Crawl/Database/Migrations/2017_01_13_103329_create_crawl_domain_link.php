<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCrawlDomainLink extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('crawl_domain_links', function(Blueprint $table)
        {
            $table->increments('cdl_id');
            $table->string('cdl_link');
            $table->integer('cdl_check_page');
            $table->integer('cdl_domain_id')->index();
            $table->integer('cdl_cate_id')->index();
            $table->integer('cdl_page');
            $table->integer('cdl_status');
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
        Schema::drop('crawl_domain_links');
    }

}
