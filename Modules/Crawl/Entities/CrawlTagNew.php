<?php

namespace Modules\Crawl\Entities;

use Illuminate\Database\Eloquent\Model;

class CrawlTagNew extends Model
{
	public $table = 'crawl_tag_news';
	protected $primaryKey = 'ctn_id';
    protected $fillable = ['ctn_name','ctn_md5'];
}
