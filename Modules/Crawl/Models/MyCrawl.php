<?php
/**
 * Created by PhpStorm.
 * User: hung
 * Date: 15/01/17
 * Time: 02:17
 */

namespace Modules\Crawl\Models;

use DB;
use Mockery\CountValidator\Exception;

class MyCrawl
{
    public static function storeDataWithTable($table, $data)
    {
       $query = DB::table($table)->insertGetId($data);
       if (!$query)
           throw new Exception("Co loi xay ra.");

       return $query;
    }
}