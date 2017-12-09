<?php
/**
 * Created by PhpStorm.
 * User: hung
 * Date: 13/01/17
 * Time: 15:33
 */

if (! function_exists('use_curl_get_html'))
{
    /**
     * Nhận toàn bộ thông tin html bằng một $url truyền vào
     * @param string $url : Đường dẫn url cần lấy
     * @param string $cookie :Có lưu cookie hay không
     * @return html
     */
    function use_curl_get_html($url ='', $cookie='')
    {
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_AUTOREFERER, TRUE);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_REFERER, 'http://www.phunutoday.vn/nau-an');
        curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/46.0.2490.80 Safari/537.36');
        if($cookie)
        {
            curl_setopt($ch, CURLOPT_COOKIE, $cookie);
        }
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_ENCODING , "gzip");
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, TRUE);
        $data = curl_exec($ch);
        if(curl_error($ch))
        {
            echo 'error:' . curl_error($ch);
        }
        curl_close($ch);
        return $data;
    }
}

if (!function_exists('use_curl_get_data'))
{
    /**
     * Created by : BillJanny
     * Date: 19:28 - 13/01/17
     * Nhận thông tin dữ liệu từ một url truyền vào
     * @param string $url : any path $url
     * @param boolaen $showHeader : có header không
     * @return array
     */
    function use_curl_get_data($url, $showHeader= false)
    {
        $ch = curl_init();
        $timeout = 5;
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HEADER, true);
        curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/46.0.2490.80 Safari/537.36');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_ENCODING , "gzip");
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, TRUE);
        $data 	= curl_exec($ch);
        if($showHeader)
        {
            $header = curl_getinfo($ch);
            echo_array($header);
        }
        curl_close($ch);

        return $data;
    }
}

if (!function_exists('use_curl_get_content'))
{
    // Function lấy html của 1 url truyền vào
    function use_curl_get_content($url, $post = "", $refer = "", $usecookie = false) {
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);

        if($post) {
            curl_setopt($curl, CURLOPT_POST, 1);
            curl_setopt ($curl, CURLOPT_POSTFIELDS, $post);
        }

        if($refer) {
            curl_setopt($curl, CURLOPT_REFERER,$refer);
        }

        curl_setopt($curl, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($curl, CURLOPT_USERAGENT, "Mozilla/6.0 (Windows; U; Windows NT 5.1; en-US; rv:1.7.7) Gecko/20050414 Firefox/1.0.3");
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
        //curl_setopt($curl, CURLOPT_TIMEOUT_MS, 5000);

        if ($usecookie) {
            curl_setopt($curl, CURLOPT_COOKIEJAR, $usecookie);
            curl_setopt($curl, CURLOPT_COOKIEFILE, $usecookie);
        }

        curl_setopt($curl, CURLOPT_RETURNTRANSFER,1);

        $html = curl_exec($curl);
        curl_close($curl);
        return $html;
    }
}

//================================================= function vua moi them

if (!function_exists('use_curl_post_data'))
{
    function use_curl_post_data($url, $data)
    {
        $str		= base64_encode(json_encode($data));
        $array 	= array('data' => $str);
        $ch 		= curl_init();                    // initiate curl
        curl_setopt($ch, CURLOPT_URL,$url);
        curl_setopt($ch, CURLOPT_POST, true);  // tell curl you want to post something
        curl_setopt($ch, CURLOPT_POSTFIELDS, $array); // define what you want to post
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); // return the output in string format
        $output = curl_exec ($ch); // execute

        curl_close ($ch); // close curl handle

        return $output;
    }
}

/**
 * Dùng để download hình ảnh thông qua curl
 * @param string $url : Đường dẫn url của hình ảnh
 * @param string $path : đường dẫn chứa thứ mục ảnh
 * @param string $name_img="" : Tên ảnh
 * @return string
 */
if (! function_exists('use_curl_download_file'))
{
    function use_curl_download_file($url, $path='', $name_img="")
    {
        $url = base64_decode($url);
        $dir = $path;
        //tạo folder images
        $path = $path ? MEDIA . DIRECTORY_SEPARATOR . $path : MEDIA;

        if (!file_exists(ROOTSTATIC . $path)) {
            mkdir(ROOTSTATIC . $path);
            chmod(ROOTSTATIC . $path, 0777);
        }

        $path = $path . DIRECTORY_SEPARATOR;
        $filename = $name_img ? $name_img : generate_name($url);
        $filePath = $path . $filename;
        
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/6.0 (Windows; U; Windows NT 5.1; en-US; rv:1.7.7) Gecko/20050414 Firefox/1.0.3");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        $result = curl_exec($ch);
        curl_close($ch);

        // check truong hop duong dan co ca query nen ta phai su dung truong hop try catch de lay thong tin cua no
        try
        {
            $fp	   =	fopen(ROOTSTATIC.$filePath,'w+');
            fwrite($fp, $result);
            fclose($fp);
            if (!check_path_file(ROOTSTATIC.$filePath))
            {
                put_log('imges_error', $url);
                return 'myrecipe.jpg';
            }
            unset($dir);
            unset($filename);
            return $filePath;
        }
        catch (\Exception $e)
        {
            $list = (explode('?', basename($url)));
            if (isset($list['0']) && $l = $list['0'])
            {
                $listExtenstion = explode('.', $l);
                if (isset($listExtenstion[1]) && $ext = $listExtenstion[1])
                {
                    $filename =  generate_name_v1() . "." . $ext;
                    $filePath = $path . $filename;
                    $fp	      =	fopen(ROOTSTATIC.$filePath,'w+');
                    fwrite($fp, $result);
                    fclose($fp);
                    if (!check_path_file(ROOTSTATIC.$filePath))
                    {
                        put_log('imges_error', $url);
                        return 'myrecipe.jpg';
                    }
                    unset($dir);
                    unset($filename);
                    return $filePath;
                }
            }
        }
    }
}