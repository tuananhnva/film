<?php
/**
 * Created by PhpStorm.
 * User: hung
 * Date: 13/01/17
 * Time: 15:34
 * Tong hop cac ham ho tro ve mang trng ung dung
 *
 */

if (!function_exists('echo_array'))
{
    /**
     * Created by : BillJanny
     * Date: 19:31 - 13/01/17
     * Show thong tin mang
     * @param array $array : mang truyen vao
     * @return
     */
    function echo_array($array)
    {
        if(!empty($array)){
            echo "<pre>";
            print_r($array);
            echo "</pre>";
        }else{
            echo "ko co hang";
        }
    }
}

if (!function_exists('remove_keyword_domain'))
{
    function remove_keyword_domain($str)
    {
        $array_keyword = array(
            'http://itsolutionstuff.com', 'itsolutionstuff.com'
        );

        $str	= str_replace($array_keyword, '', $str);
        $str	= trim($str, ' |-');

        return $str;
    }
}