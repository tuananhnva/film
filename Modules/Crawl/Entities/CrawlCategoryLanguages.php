<?php

namespace Modules\Crawl\Entities;

use Illuminate\Database\Eloquent\Model;

class CrawlCategoryLanguages extends Model
{
    public $table = 'crawl_category_languages';
    protected $primaryKey = 'ccl_id';
    protected $fillable = ['ccl_name', 'ccl_md5'];
}
