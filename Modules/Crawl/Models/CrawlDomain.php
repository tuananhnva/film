<?php namespace Modules\Crawl\Models;
   
use Illuminate\Database\Eloquent\Model;
use DB;

class CrawlDomain extends Model {

    protected $table = 'crawl_domains';
    protected $primaryKey = 'cd_id';
    protected $fillable = [
        'cd_id', 'cd_domain', 'cd_law_crawl_link', 'cd_add_domain_crawl_link',
        'cd_law_title','cd_law_description', 'cd_law_content', 'cd_law_img', 'cd_law_remove',
        'cd_law_add_page', 'cd_status', 'cd_type','cd_law_tag','cd_law_category'
    ];

    /**
     * Lấy tất cả các link cần crawl thỏa mãn điều kiện  mang ra lấy thông tin
     * @param void
     * @return mixed
     */
    public static function getLinkCrawl($cdl_domain_id=0)
    {
        $dbQuery = DB::table('crawl_domains')
                    ->join('crawl_domain_links', 'cd_id', '=' ,'cdl_domain_id')
                    ->where('cd_type',1)
                    ->where('cd_status', 1)
                    ->where('cdl_status', 1);

        if ($cdl_domain_id > 0)
        {
            $dbQuery = $dbQuery->where('cdl_domain_id','=', $cdl_domain_id);
        }

        $dbQuery = $dbQuery->orderBy('cdl_id')->get();
        return $dbQuery;
    }
}