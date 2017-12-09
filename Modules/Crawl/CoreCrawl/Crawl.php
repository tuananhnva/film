<?php
/**
 * Created by PhpStorm.
 * User: hung
 * Date: 16/01/17
 * Time: 14:42
 */

    namespace Modules\Crawl\CoreCrawl;
use Illuminate\Support\Facades\Log;
use Mockery\CountValidator\Exception;
use Modules\Crawl\Models\CrawlDomain;
use Modules\Crawl\Models\CrawlDomainLink;
use Modules\Crawl\Models\CrawlDomainLinkDetail;
use Modules\Crawl\Models\MyCrawl;

class Crawl
{
    /**
     * Method dành cho việc lấy tất cả các thông tin url, tiêu đề của một website để phục vụ cho lấy nội dung
     * @param void
     * @return void
     */
    public static function getDomainLinkDetail()
    {
        header('Content-Type: text/html; charset=utf-8');
        set_time_limit(10000);

        // Lấy các domain cần crawl ứng với luật ====================================================
        $listLinksCrawlAvailable = CrawlDomain::getLinkCrawl();

        // Check cac link mang ra crawl khong co. Minh phai update lai thong tin de crawl ===========
        if (!$listLinksCrawlAvailable)
        {
            CrawlDomainLink::updateDomainLink(0, 1, 2);
            self::getDomainLinkDetail();
        }


        /**** Bat dau tim kiem du lieu ****/
        // Mang chua cac link da crawl xong =========================================================
        foreach ($listLinksCrawlAvailable as $value)
        {
            // Lay so luong page gan nhat
            for ($page = $value->cdl_page; $page >= 1; $page --)
            {
                $url        = $value->cdl_link;
                $urlPage    = $page;

                // check page nao can thiet moi trang ================================================
                $_page      = ($value->cdl_check_page) 
                              ? str_replace('{PAGE}', (int)$urlPage, $value->cd_law_add_page)
                              : '';
                              
                $url        = $url . $_page;
                $html       = use_curl_get_html($url, true);
                $html       = str_get_html($html);

                
                /**
                 * Các hạng mục cần lấy từ domain thiết lập
                 * 1. Link
                 * 2. Category
                 * 
                 */
                 $arrayLink	= array();
                 $arrayCategory = array();

                if ($html)
                {
                    // 1. Link : Kiểm tra để bắt đầu lấy link theo luật được thiết lập
                    $arrLawLink = explode('|', $value->cd_law_crawl_link);
                    foreach ($arrLawLink as $law)
                    {
                        $content = $html->find($law);
                        // Ton tai content khong =====================================================
                        if ($content)
                        {
                            foreach ($content as $htm)
                            {
                                // Lay title bai viet ================================================
                                $_title = $htm->getAttribute('title');
                                $_title = $_title ? $_title : $htm->text();
                                $_title = title_replace($_title);

                                // Lay duong dan cua bai viet ========================================
                                $link   = $htm->getAttribute('href');
                                $link   = str_replace('./', '', $link);

                                echo "$link<br/>\n";

                                // cac link crawl duoc ===============================================
                                $arrayLink [md5($link)] =
                                [
                                    ($value->cd_add_domain_crawl_link) ? $value->cd_domain.$link : $link,
                                    $_title,
                                    md5($_title),
                                    $value->cdl_cate_id,
                                    $value->cd_id,
                                    time()
                                ];
                            }
                        }
                    }
                }

                /**** Hien thi bao nhieu ban ghi duoc lay ****/
                echo "Ket qua `$url` = " . count($arrayLink) . " record \n\n\n\n";


                /**** Them vao csdl ****/
                $arrayField	= array(
                    'cdld_link', 'cdld_title', 'cdld_title_md5', 'cdld_cate_id', 'cdld_domain_id', 'cdld_time'
                );

                $arrayLink = array_values($arrayLink);

                // Nhat duoc link roi thi chung ta insert vao csdl de lay thoy =======================================
                if ($arrayLink)
                {
                    $dbInsert = generate_sql_batch_insert('crawl_domain_link_details', $arrayField, $arrayLink, 'IGNORE');
                    CrawlDomainLinkDetail::saveMultipleData($dbInsert);
                }

                unset($arrayLink);
                sleep(3);
            }

            // Update thong tin cac duong dan chinh bat link da duoc tim thay
            CrawlDomainLink::updateDomainLink($value->cdl_id, 2, 1);
            sleep(5);
        }


        echo "***************************************************\n";
        echo "Finish. Now u can get content of detail link \n";
        echo "\n\n\n\n";
    }



    /**
     * Method dành cho việc lấy thông tin content
     * @param $limit : số lượt bài sẽ lấy ra để crawl
     * @return mixed
     */
    public static function getContentLinkDetail($limit=1000)
    {
        $crawled = 0;
        $domainLinksDetail = CrawlDomainLinkDetail::getListDomainLinkDetail($limit);
        if (!$domainLinksDetail)
        {
            echo('Not exist data to crawl'); die();
        }
    
        foreach ($domainLinksDetail as $row)
        {
            $url  = $row->cdld_link;
            $html = use_curl_get_html($url);
            $html = str_get_html($html);
            echo $url ." ---- \t";

            /**
             * Các đầu việc cần lấy khi có thông tin như sau
             * Step 1: Get tmage,
             * Step 2: Get description
             * Step 3: Get title
             * Step 4: Get category
             * Step 5: Get tag
             * Step 6: Get content
             * Step 7: Insert to database
             */
            if ($html)
            {
            
                /**
                 * Step 1: Get image article
                 */
                if ($getImage = $html->find('meta[property=og:image]', 0))
                {
                    $getImage = $getImage->getAttribute('content');
                }else
                {
                    if ($getImage1 = $html->find($row->cd_law_img, 0))
                    {
                        $getImage  = $getImage1->getAttribute('href');
                    }
                }

                $imgNews = use_curl_download_file(base64_encode($getImage));


                /**
                 * Step 2: Get description
                 */
                $getDescription= ($row->cd_law_description)
                                ? $html->find($row->cd_law_description, 0)
                                : $html->find('meta[property=og:description]', 0);
                if ($getDescription)
                {
                    $descNews = $getDescription->getAttribute('content');
                }

                /**
                 * Step 3: Get title 
                 * 
                 */
                $getTitle = $html->find($row->cd_law_title, 0);
                $titleNews = $getTitle 
                                ? $getTitle->plaintext 
                                : $html->find('meta[property=og:title]', 0)->getAttribute('content');
                if(!$titleNews) continue;


                /**
                 * Step 4: Get tag
                 * 
                 */
                $arrTags = array();
                $arrLawTag = explode('|', $row->cd_law_tag);

                foreach ($arrLawTag as $lawTag) 
                {

                    
                    $tagNodes = $html->find($lawTag);
                    // Ton tai content khong =====================================================
                    if (count($tagNodes) > 0)
                    {
                        foreach ($tagNodes as $htm)
                        {
                        
                            $textTag = $htm->plaintext;
                            // cac link crawl duoc ===============================================
                            $arrTags[md5($textTag)] =
                            [
                                $textTag,
                                md5($textTag),
                                time()
                            ];
                        }
                    }
                }   

            

                /**
                 * Step 5: Get category
                 */
                $arrCategories = array();
                $arrLawCategory = explode('|', $row->cd_law_category);

                foreach ($arrLawCategory as $lawCategory) 
                {
                    $content = $html->find($lawCategory);
                    if ($content)
                    {
                        foreach ($content as $htm)
                        {
                        
                            $textCategory = $htm->plaintext;
                            $arrCategories[md5($textCategory)] =
                            [
                                $textCategory,
                                md5($textCategory),
                                time()
                            ];
                        }
                    }
                }

                /**
                 * Step 6: Get content article : 2 step
                 * Step 1: get content
                 * Step 2: Remove a object in law 
                 */
                $contentNews = $html->find($row->cd_law_content, 0);
                $arrayRemove = ($row->cd_law_remove != '' ? explode('|', $row->cd_law_remove) : array());
                if ($contentNews && $arrayRemove)
                {
                    foreach ($arrayRemove as $remove)
                    {
                        $removeElements = $contentNews->find($remove);
                        foreach ($removeElements as $reElement)
                        {
                            $reElement->outertext = '';
                        }
                    }
                }

                if ($contentNews)
                {
                    // Title article
                    $titleNews   = remove_keyword_domain($titleNews);
                    // Content article  HTML : Loại bỏ các thuộc tính không cho phép
                    $contentNews = $contentNews->innertext();
                    $contentNews = trim($contentNews);
                    $contentNews = clean_attr_chapter($contentNews, MEDIA_RECIPE_CRAWL, ['alt'=> MYWEBSITE.$titleNews]);

                    // Desc article
                    $descNews    = stripslashes($descNews);
                    $descNews    = remove_keyword_domain($descNews);
                

                    // Array insert to database
                    $array_insert = [
                        'new_title'            => replace_mq($titleNews),
                        'new_title_old'        => replace_mq($titleNews),
                        'new_title_md5'        => md5($titleNews),
                        'new_domain_id'        => $row->cdld_domain_id,
                        'new_link_from_domain' => replace_mq($url),
                        'new_img'              => replace_mq($imgNews),
                        'new_cate_id'          => $row->cdld_cate_id,
                        'new_description'      => replace_mq($descNews), 
                        'new_content'          => $contentNews,
                        'new_date'             => time(),
                        'new_description'      => replace_mq(strip_tags($descNews)),
                    ];

                    try
                    {
                        // Bat dau insert vao bang news voi cac keyword chinh
                        $newLastId = MyCrawl::storeDataWithTable('crawl_news', $array_insert);
                        dd($newLastId);
                        // Chen noi dung cac phan con lai vao cac bang con cua no
                        if ($newLastId)
                        {
                            $crawled++;
                            event(new \App\Events\SomeEvent($array_insert));
                            echo "ID : $newLastId\n\n\n";
                        }
                    }
                    catch (\Exception $e)
                    {
                        put_log('link_error', $row->cdld_link);
                    }
                }

            }


            // Update thông tin đường dẫn lại đã lấy được
            CrawlDomainLinkDetail::updateDomainLinkDetail($row->cdld_id);
            sleep(2);
        }

        echo "**************************************\n";
        echo "Qua trinh crawl tin hoan thannh voi " . $crawled;
    }
}