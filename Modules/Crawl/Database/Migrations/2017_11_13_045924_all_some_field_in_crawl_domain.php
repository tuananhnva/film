<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AllSomeFieldInCrawlDomain extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('crawl_domains', function(Blueprint $table)
        {
            $table->string('cd_law_tag')->nullable()->after('cd_add_domain_crawl_link');
            $table->string('cd_law_category')->nullable()->after('cd_add_domain_crawl_link');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('crawl_domains', function($table) {
            $table->dropColumn('cd_law_tag');
            $table->dropColumn('cd_law_category');
        });
    }
}
