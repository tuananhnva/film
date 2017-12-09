<?php namespace Modules\Crawl\Models;
   
use Illuminate\Database\Eloquent\Model;
use DB;

class CrawlDomainLinkDetail extends Model
{

    protected $table = 'crawl_domain_link_details';
    protected $primaryKey = 'cdld_id';
    protected $fillable = [
        'cdld_id', 'cdld_link', 'cdld_title', 'cdld_title_md5',
        'cdld_cate_id', 'cdld_domain_id', 'cdld_time', 'cdld_status',
    ];

    const ACTIVE = 1;
    const INACTIVE = 0;
    const NEW_CRAWL_STATUS = 0;
    const SUCCESS_CRAWL_STATUS = 1;
    const FAIL_CRAWL_STATUS = 2;

    /**
     * Created by : Hungokata
     * Time : 09:14 / 16/01/17
     * Cập nhật các link đã crawl dữ liệu thành cong
     * @param void
     * @return mixed
     */
    public static function updateDomainLinkDetail($cdld_id='')
    {
        return DB::table('crawl_domain_link_details')
                ->where('cdld_id',$cdld_id)
                ->update(['cdld_status'=>self::SUCCESS_CRAWL_STATUS]);
    }

    /**
     * Created by : BillJanny
     * Date: 09:11 - 16/01/17
     * Lấy các thông tin đường dẫn san sang để crawl dữ liệu
     * @param void
     * @return mixed
     */
    public static function getListDomainLinkDetail($limit=1000)
    {
        $query = DB::table('crawl_domain_link_details')
                     ->join('crawl_domains', 'cdld_domain_id', '=', 'cd_id')
                     ->where('cdld_status', '=', self::NEW_CRAWL_STATUS)
                     ->where('cd_status','=', self::ACTIVE)
                     ->orderBy('cdld_id', 'DESC')
                     ->take($limit)
                     ->get();

        return $query;
    }


    /**
     * Created by : BillJanny
     * Date: 10:22 - 16/01/17
     * Luu nhieu du lieu cung mot luc
     * @param string $string : chuoi du lieu
     * @return boolean
     */
    public static function saveMultipleData($string)
    {
        $query = DB::statement($string);
        return $query;
    }
}