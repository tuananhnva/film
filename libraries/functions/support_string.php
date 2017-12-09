<?php
/**
 * Created by PhpStorm.
 * User: hung
 * Date: 13/01/17
 * Time: 15:34
 */

if (!function_exists('put_log'))
{
    function put_log($filename, $content)
    {
        $imageLog = storage_path().'/logs/'.$filename.'.log';
        $handle   = @fopen($imageLog, "a");
        if(!$handle)
        {
            $handle = @fopen($imageLog, "a");
        }
//        @fwrite($handle, date("d/m/Y h:i:s A") . " " .$content. "\n");
        @fwrite($handle, $content. "\n");
        @fclose($handle);
    }
}

if (!function_exists('title_replace'))
{
    /**
     * Created by : BillJanny
     * Date: 23:24 - 13/01/17
     * thay the chuoi chuoi vao
     * @param string $title
     * @return string
     */
    function title_replace($title)
    {
        $arrayReplace = array(
            '&#8211;', '&nbsp;', '&#226;', '&#224;', '&#244;', '&#225;', '&#234;', '&#243;', '&#237;', '&#236;', '&#249;', '&#250;',
            '&#253;', '&#227;', '&#242;'
        );

        $arrayText		= array(
            '', '', 'â', 'à', 'ô', 'á', 'ê', 'ó', 'í', 'ì', 'ù', 'ú',
            'ý', 'ã', 'ò'
        );

        $title	= strip_tags($title);
        $title	= str_replace($arrayReplace, $arrayText, $title);
        $title	= replace_mq($title);
        $title	= trim($title);
        return $title;
    }
}

if (! function_exists('replace_mq'))
{
    /**
     * Created by : BillJanny
     * Date: 23:23 - 13/01/17
     * Thay the cac ki tu khong can thiet
     * @param string $text
     * @return string
     */
    function replace_mq($text)
    {
        $text	= str_replace("\'", "'", $text);
        $text	= str_replace("'", "''", $text);
        return $text;
    }
}
//================================================= function vua moi them

if (! function_exists('generate_name_v1'))
{

    function generate_name_v1()
    {
        $name = "";
        for($i=0; $i<5; $i++){
            $name .= chr(rand(97,122));
        }
        $today   = getdate();
        $name   .= $today[0];
        return $name;
    }
}

/**
    Generate file name
 */
if (! function_exists('generate_name'))
{
    function generate_name($filename)
    {
        $ext	 = substr($filename, (strrpos($filename, ".") + 1));
        return generate_name_v1() . "." . $ext;
    }
}

if (! function_exists('get_extension_file'))
{
    function get_extension_file($filePath)
    {
        return @substr(@strrchr($filePath, "."), 1);
    }
}

if (!function_exists('random'))
{

    /**
     * Random so
     * @param
     * @return
     */
    function random()
    {
        $rand_value = "";
        $rand_value.= rand(1000,9999);
        $rand_value.= chr(rand(65,90));
        $rand_value.= rand(1000,9999);
        $rand_value.= chr(rand(97,122));
        $rand_value.= rand(1000,9999);
        $rand_value.= chr(rand(97,122));
        $rand_value.= rand(1000,9999);
        return $rand_value;
    }
}

if (!function_exists('replace_keyword_search'))
{
    /**
     * Replace cac ki tu khong can thiet
     * @param
     * @return
     */
    function replace_keyword_search($keyword, $lower=1)
    {
        if($lower == 1) $keyword	= mb_strtolower($keyword, "UTF-8");
        $keyword	= replace_mq($keyword);
        $arrRep	    = array("'", '"', "-", "+", "=", "*", "?", "/", "!", "~", "#", "@", "%", "$", "^", "&", "(", ")", ";", ":", "\\", ".", ",", "[", "]", "{", "}", "‘", "’", '“', '”');
        $keyword	= str_replace($arrRep, " ", $keyword);
        $keyword	= str_replace("  ", " ", $keyword);
        $keyword	= str_replace("  ", " ", $keyword);
        return $keyword;
    }
}

if (!function_exists('rand_string'))
{
    //tao chuoi ran dom
    function rand_string( $length )
    {
        $chars  = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
        $str    = "";
        $size   = strlen( $chars );
        for( $i = 0; $i < $length; $i++ )
        {
            $str .= $chars[ rand( 0, $size - 1 ) ];
        }
        return $str;
    }
}

if (!function_exists('remove_script'))
{
    //Loại bỏ javascript
    function remove_script($string)
    {
        $string = preg_replace ('/<script.*?\>.*?<\/script>/si', '<br />', $string);
        $string = preg_replace ('/on([a-zA-Z]*)=".*?"/si', ' ', $string);
        $string = preg_replace ('/On([a-zA-Z]*)=".*?"/si', ' ', $string);
        $string = preg_replace ("/on([a-zA-Z]*)='.*?'/si", " ", $string);
        $string = preg_replace ("/On([a-zA-Z]*)='.*?'/si", " ", $string);
        return $string;
    }
}

if (!function_exists('_format_bytes'))
{
    function _format_bytes($a_bytes)
    {
        if ($a_bytes < 1024) {
            return $a_bytes . ' B';
        } elseif ($a_bytes < 1048576) {
            return round($a_bytes / 1024, 2) . ' KB';
        } elseif ($a_bytes < 1073741824) {
            return round($a_bytes / 1048576, 2) . ' MB';
        } elseif ($a_bytes < 1099511627776) {
            return round($a_bytes / 1073741824, 2) . ' GB';
        } elseif ($a_bytes < 1125899906842624) {
            return round($a_bytes / 1099511627776, 2) . ' TB';
        } elseif ($a_bytes < 1152921504606846976) {
            return round($a_bytes / 1125899906842624, 2) . ' PB';
        } elseif ($a_bytes < 1180591620717411303424) {
            return round($a_bytes / 1152921504606846976, 2) . ' EB';
        } elseif ($a_bytes < 1208925819614629174706176) {
            return round($a_bytes / 1180591620717411303424, 2) . ' ZB';
        } else {
            return round($a_bytes / 1208925819614629174706176, 2) . ' YB';
        }
    }
}

if (!function_exists('keyword_to_array'))
{
    /**
     * Key word search.
     */
    function keyword_to_array($keyword)
    {
        $min_character = 1;
        $max_keyword = 90;
        $array_keyword = array();
        //Lấy keyword còn lại sau, bẻ dấu cách
        $array_temp = explode(" ", $keyword);
        $j = -1;
        for ($i = 0; $i < count($array_temp); $i++) {
            //Lay từng từ khóa một, từ khóa có độ dài phải lớn hơn min_character hoặc là 1 ký tự số dạng iphone 4, ipad 2
            if (trim($array_temp[$i]) != "" && (mb_strlen(trim($array_temp[$i]), "UTF-8") > $min_character || is_numeric($array_temp[$i]))) {
                $j++;
                //gán từ khóa
                $array_keyword[$j][0] = trim($array_temp[$i]);

                //Vượt ngưỡng max thì out khỏi vòng lặp luôn
                if ($j >= $max_keyword) break;
            }
        }
        return $array_keyword;
    }
}