<?php namespace Modules\Crawl\Http\Controllers;

use Modules\Crawl\CoreCrawl\CrawlReset;

use Illuminate\Routing\Controller;
class ResetController extends Controller
{
    /**
     * Reset cơ sử dữ liệu và insert luật mới
     * @return void
     */
	public function makeResetDatabaseAndUpdateNewLaw()
	{
        $reset = new CrawlReset();
        $reset->resetDatabase();
        $reset->insertDomain();
        $reset->insertDomainLink();
    }
}