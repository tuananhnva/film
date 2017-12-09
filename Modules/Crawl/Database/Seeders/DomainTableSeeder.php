<?php namespace Modules\Crawl\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Modules\Crawl\Models\CrawlDomain;

class DomainTableSeeder extends Seeder {

	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		Model::unguard();
		
        $defaul = [
            [
                'cd_domain'                => 'http://blogtamsu.vn/',
                'cd_law_crawl_link'        => 'h3.title a',
                'cd_add_domain_crawl_link' => '0',
                'cd_law_title'             => 'h1',
                'cd_law_description'       => '',
                'cd_law_content'           => '#remain_detail',
                'cd_law_img'               => '',
                'cd_law_remove'            => 'center|#vmcbackground|#advMidContent|#advBotton|div',
                'cd_law_add_page'          => '/page/{PAGE}',
                'cd_status'                => '1',
                'cd_type'                  => '1',
            ],
            [
                'cd_domain'                => 'http://www.daikynguyenvn.com/',
                'cd_law_crawl_link'        => 'h2.post-box-title a',
                'cd_add_domain_crawl_link' => '0',
                'cd_law_title'             => 'h1',
                'cd_law_description'       => '',
                'cd_law_content'           => '#the-post',
                'cd_law_img'               => '',
                'cd_law_remove'            => 'div',
                'cd_law_add_page'          => '/page/{PAGE}',
                'cd_status'                => '1',
                'cd_type'                  => '1',
            ]
        ];

        foreach ($defaul as $value)
        {
            CrawlDomain::create($value);
        }
	}

}