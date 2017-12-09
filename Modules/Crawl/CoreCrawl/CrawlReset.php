<?php
/**
 * Created by PhpStorm.
 * User: hung
 * Date: 16/01/17
 * Time: 15:09
 */

namespace Modules\Crawl\CoreCrawl;
use DB;
use Modules\Crawl\Models\CrawlDomain;
use Modules\Crawl\Models\CrawlDomainLink;

class CrawlReset
{

    public function resetDatabase()
    {
        DB::table('crawl_domains')->truncate();
        DB::table('crawl_domain_links')->truncate();
        DB::table('crawl_domain_link_details')->truncate();
        DB::table('crawl_news')->truncate();

        for ($i=1; $i<=1; $i++)
        {
            DB::table('news_content_'.$i)->truncate();
        }
    }

    public function insertDomain()
    {
        $domain  = get_domain();
        foreach ($domain as $value)
        {
            CrawlDomain::create($value);
        }
    }

    public function insertDomainLink()
    {
        $domainLink  = get_domain_link();
        foreach ($domainLink as $value)
        {
            CrawlDomainLink::create($value);
        }
    }
}