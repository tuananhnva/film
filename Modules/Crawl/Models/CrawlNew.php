<?php namespace Modules\Crawl\Models;
   
use Illuminate\Database\Eloquent\Model;
use DB;

class CrawlNew extends Model {

    protected $table = 'crawl_news';
    protected $primaryKey = 'new_id';
    protected $fillable = [
        'new_id', 'new_title', 'new_title_old', 'new_title_md5', 'new_domain_id', 'new_link_from_domain',
        'new_img', 'new_cate_id', 'new_description', 'new_content', 'new_top', 'new_hot',
        'new_status', 'new_date'
    ];
}