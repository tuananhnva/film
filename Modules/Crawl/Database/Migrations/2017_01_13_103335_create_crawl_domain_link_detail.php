<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCrawlDomainLinkDetail extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('crawl_domain_link_details', function(Blueprint $table)
        {
            $table->increments('cdld_id');
            $table->string('cdld_link');
            $table->string('cdld_title');
            $table->string('cdld_title_md5')->unique()->index();
            $table->integer('cdld_cate_id');
            $table->integer('cdld_domain_id');
            $table->integer('cdld_time');
            $table->integer('cdld_status');

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
        Schema::drop('crawl_domain_link_details');
    }

}
