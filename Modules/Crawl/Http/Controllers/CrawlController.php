<?php

namespace Modules\Crawl\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\Crawl\CoreCrawl\Crawl;

class CrawlController extends Controller
{

    public function getDomainLinkDetail()
    {
        Crawl::getDomainLinkDetail();
        return redirect('crawl/get-content');
    }


    public function getContentLinkDetail($limit=5)
    {
        Crawl::getContentLinkDetail($limit);
    }

}
