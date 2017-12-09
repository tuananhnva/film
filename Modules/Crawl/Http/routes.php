<?php

Route::group(['middleware' => 'web', 'prefix' => 'crawl', 'namespace' => 'Modules\Crawl\Http\Controllers'], function()
{	

    // Trang chủ test crawl
    Route::get('/', function() 
    {
        $curl = curl_init('http://testing-ground.scraping.pro/blocks'); 
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, TRUE); $page = curl_exec($curl); 
        if(curl_errno($curl)) 
        {     
            echo 'Scraper error: ' . curl_error($curl);     
            exit; 
        } 

        curl_close($curl);  
        $DOM = new DOMDocument;  
        libxml_use_internal_errors(true);  
        if (!$DOM->loadHTML($page))     
        {       
            $errors="";         
            foreach (libxml_get_errors() as $error)  
            {          
                $errors.=$error->message."<br/>";       
            }       
            libxml_clear_errors();      
            print "libxml errors:<br>$errors";      
            return;     
        } 
        
        $xpath = new DOMXPath($DOM);  
        $case1 = $xpath->query('//*[@id="case1"]')->item(0); 
        $query = 'div[not (@class="ads")]/span[1]';  
        $entries = $xpath->query($query, $case1); 

        foreach ($entries as $entry) 
        {    
            echo " {$entry->firstChild->nodeValue} <br /> "; 
        }

    });

    Route::get('/test', function() {
        set_time_limit(90000);
        $getTag = [];
        $getLinks = [];
        for ($i = 0 ; $i < 10 ; $i++)
        { 
            $html = use_curl_get_html('http://phim.keeng.vn/ajax/moreCateFilm.aspx?cid=1&id=0&order=0&isInternational=1&p='.$i);
            $html = str_get_html($html);
            $tags = $html->find('.av-top-small .ats-lnk-img');
            if ($tags) 
            {
                foreach ($tags as $tag)
                {
                    $getTag[]   = $tag->href;  
                }  
            }
        }
        foreach ($getTag as $value) {
            $getLink = [];
            $htmllink = use_curl_get_html($value);
            $htmllink = str_get_html($htmllink);
            $links = $htmllink->find('#video_container');
           if ($links) 
            {
                foreach ($links as $lk)
                {
                    $linkCDN    = str_replace('http://kfilmvod.1d2173fe.viettel-cdn.vn','http://cdn2.keeng.net',$lk->children[0]->children[0]->src);
                    $linkCDN    = str_replace('/playlist.m3u8?','?',$linkCDN);
                    $getLink[]   = $linkCDN; 
                }  
            }
            
        }
        dd($getLink);

    });

    Route::get('/getlink', function() {
        
        $getTag = [];
        $html = use_curl_get_html('http://phim.keeng.vn/long-quyen-tieu-tu-kung-fu-boys-f909081.html');
        $html = str_get_html($html);
        $tags = $html->find('#video_container');

        if ($tags) 
        {
            foreach ($tags as $tag)
            {
                $linkCDN    = str_replace('http://kfilmvod.1d2173fe.viettel-cdn.vn','http://cdn2.keeng.net',$tag->children[0]->children[0]->src);
                $linkCDN    = str_replace('/playlist.m3u8?','?',$linkCDN);
                $getTag[]   = $linkCDN; 
            }  
        }
        dd($getTag);

    });

    // Lay skill by job
    Route::get('getSkill', function() {
        return view('crawl::get_skill');
    });

    Route::get('/ajax', function() {
        $slug = $_GET['slug'];
        $html = file_get_contents('https://www.vietnamworks.com/'.$slug);
        sleep(3);
        $html = file_get_contents('https://www.vietnamworks.com/'.$slug);
        dd($html);
    });

    
    /**
     * Các bước crawl cho một website mới
     * Hiện tại đang gồm 3 bước như sau
     */
    
    // Bước 1 : Reset thông tin
    Route::get('/reset', ['uses'=> 'ResetController@getReset']);

    // Bước 2 : Chạy luật thông tin được thiết lập sẵn
	Route::get('/run', 'CrawlController@getDomainLinkDetail');

    // Bước 3 : Bắt đầu lấy content bên trong
	Route::get('/get-content', 'CrawlController@getContentLinkDetail');

    // Màn hình hiển thị view đang crawl ra sao
    
    Route::get('status', function() 
    {
        return view('crawl::pusher');
    });

});