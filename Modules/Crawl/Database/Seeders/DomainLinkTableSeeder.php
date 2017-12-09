<?php namespace Modules\Crawl\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class DomainLinkTableSeeder extends Seeder {

	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		Model::unguard();
		
		$default = [
            [
              'cdl_link' => 'http://blogtamsu.vn/sao-2',
              'cdl_domain_id' => '1',
              'cdl_cate' => '0',
              'cdl_page' => '10',
              'cdl_status' => '1',
            ],[
              'cdl_link' => 'http://www.daikynguyenvn.com/cat/gioi-sao',
              'cdl_domain_id' => '2',
              'cdl_cate' => '0',
              'cdl_page' => '10',
              'cdl_status' => '1',
            ]
        ];
	}

}