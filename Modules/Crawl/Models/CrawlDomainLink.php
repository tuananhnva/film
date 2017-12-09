<?php namespace Modules\Crawl\Models;
   
use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\Paginator;

class CrawlDomainLink extends Model {

    protected $table = 'crawl_domain_links';
    protected $primaryKey = 'cdl_id';
    protected $fillable = [
        'cdl_id', 'cdl_link','cdl_check_page', 'cdl_domain_id', 'cdl_cate_id', 'cdl_page','cdl_status'
    ];


    public static function updateDomainLink($cdl_id=0, $status_new=1, $status_old=0)
    {
        $cdl_id = (int)$cdl_id;
        $query  = self::where('cdl_status','=', $status_old);
        if ($cdl_id>0)
        {
            $query->where('cdl_id', $cdl_id);
        }

        $query->update(['cdl_status'=> $status_new]);
    }
}