<?php
/**
 * Created by PhpStorm.
 * User: hung
 * Date: 21/01/17
 * Time: 12:12
 */
if (!function_exists('get_domain')) {
    function get_domain()
    {
        return [
            [
                'cd_domain' => 'http://itsolutionstuff.com',
                'cd_law_crawl_link' => '.main-content .blogShort > h2 a',
                'cd_add_domain_crawl_link' => '0',
                'cd_law_title' => 'h1.post-title',
                'cd_law_description' => '',
                'cd_law_content' => '.main-content .discription',
                'cd_law_tag'     => '.main-content .detail-tag .label-info-tag a',
                'cd_law_img' => '',
                'cd_law_remove' => 'center|#loadContentRight|.adsbygoogle|#advMidContent|iframe|script|.sharebotdetail',
                'cd_law_add_page' => '/?page={PAGE}',
                'cd_law_category' => '.main-content .label-info',
                'cd_status' => '1',
                'cd_type' => '1',
            ]
        ];
    }
}


if (!function_exists('get_domain_link')) {
    function get_domain_link()
    {
        return [
            [
                'cdl_link' => 'http://itsolutionstuff.com/latestpost',
                'cdl_domain_id' => '1',
                'cdl_check_page' => 1, 
                'cdl_cate_id' => '0',
                'cdl_page' => '107',
                'cdl_status' => '1',
            ],
            [
                'cdl_link' => 'http://itsolutionstuff.com/featured-post',
                'cdl_domain_id' => '1',
                'cdl_check_page' => 1, 
                'cdl_cate_id' => '0',
                'cdl_page' => '22',
                'cdl_status' => '1',
            ]
        ];
    }
}