<?php
//
//Tạo php artisan make:command MakePDF
// Chạy php artisan dompdf:make_pdf
// 
namespace App\Console\Commands;

use Illuminate\Console\Command;

class cloneLink extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:getMovie';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $getTag     = [];
        $getLink    = [];

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
                    $htmllink   = use_curl_get_html($tag->href);
                    $htmllink   = str_get_html($htmllink);
                    $links      = $htmllink->find('#video_container');
                    if ($links) 
                    {
                        foreach ($links as $lk)
                        {

                            $arr    = str_replace('http://kfilmvod.1d2173fe.viettel-cdn.vn','http://cdn2.keeng.net',$lk->children[0]->children[0]->src);
                            $arr    = str_replace('/playlist.m3u8?','?',$arr);

                            echo $arr;
                            echo "\n";
                            echo "===============================================";
                            echo "\n";
                            $getLink[]   = $arr;
                        }  
                    }
                }  
            }
        }
        $text = '';
        $i = 1;
        foreach ($getLink as $value) {
            $text.= 'RewriteRule ^phimhayso'.$i.'  '.$value." [L]"."\n";
            $i++;
        }
        $htac = '<IfModule mod_rewrite.c>
                    <IfModule mod_negotiation.c>
                        Options -MultiViews
                    </IfModule>

                    RewriteEngine On

                    '.$text.'

                    # Redirect Trailing Slashes If Not A Folder...
                    RewriteCond %{REQUEST_FILENAME} !-d
                    RewriteCond %{REQUEST_URI} (.+)/$
                    RewriteRule ^ %1 [L,R=301]

                    # Handle Front Controller...
                    RewriteCond %{REQUEST_FILENAME} !-d
                    RewriteCond %{REQUEST_FILENAME} !-f
                    RewriteRule ^ index.php [L]

                    # Handle Authorization Header
                    RewriteCond %{HTTP:Authorization} .
                    RewriteRule .* - [E=HTTP_AUTHORIZATION:%{HTTP:Authorization}]
                </IfModule>';
        
        // $getTag = json_encode($getTag);
        // $getLinks = json_encode($getLink);
        // file_put_contents(public_path('lists.json'), $getTag);
        // file_put_contents(public_path('links.json'), $getLinks);
        file_put_contents(public_path('.htaccess'), $htac);
    }
}
