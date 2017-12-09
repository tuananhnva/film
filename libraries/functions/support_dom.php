<?php
/**
 * Created by PhpStorm.
 * User: HUNG
 * Date: 3/18/2017
 * Time: 10:33 PM
 */
function sdv_strip_tag2($html)
{
    //Cac the cho phep
    //$valid_tag	= array( "br", "font", "i", "img", "b","p");
    $valid_tag	= array( "br","i" ,"img", "b","p");
    $tag_allow = "";
    reset($valid_tag);
    foreach ($valid_tag as $m_key => $m_value){
        $tag_allow .= "<" . $m_value . ">";
    }
    $html   =  strip_tags($html, $tag_allow);
    return $html;
}


/*
* Loại bỏ các kí tự không cần thiết , các thẻ bị thừa
*/
function clean_char_chapter($html)
{
//    $html    = sdv_strip_tag2($html);
    $doc = new DOMDocument("1.0", "UTF-8");
    $doc->formatOutput = true;
    $html = 	'<html>' .
        '<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">' .
        '<body>' .
        $html .
        '</body>' .
        '</html>';
    @$doc->loadHTML($html);
    $xpath   = new DOMXPath($doc);
    $body    = $xpath->query('/html/body');
    $html    = $doc->saveXml($body->item(0));

    $arr_rep_to_space1 	= array(chr(10), chr(13),"&nbsp;","&quot;");
    $arr_rep_to_null  	= array("<body>","</body>", "<p><br></p>", "<p></p>", "<p> </p>","<p/>","<span></span>","<span> </span>","<p>&nbsp;</p","<p/>",
        "<ul><li> </li><li> </li><li> </li></ul>");
    $html = str_replace($arr_rep_to_space1," ",$html);
    $html = str_replace($arr_rep_to_null,"",$html);

    $arr_br  = array("<br><br><br><br><br>","<br><br><br><br>","<br><br><br>","<br><br>");
    $html = str_replace($arr_br,"<br>",$html);
    $html = str_replace($arr_br,"<br>",$html);

    $arr_space  = array("      ","     ","    ","   ","  ");
    $html  = str_replace($arr_space," ",$html);
    $html  = str_replace($arr_space," ",$html);

    $html = preg_replace("/(<font>)(.*?)(<\/font>)/iU",'$2', $html);
    $html = preg_replace("/(<font>)(.*?)(<\/font>)/iU",'$2', $html);
    $html = preg_replace("/(<font>)(.*?)(<\/font>)/iU",'$2', $html);
    $html = preg_replace("/(<font>)(.*?)(<\/font>)/iU",'$2', $html);
    $html = preg_replace("/(<font>)(.*?)(<\/font>)/iU",'$2', $html);

    return $html;
}


function everything_in_tags($string, $tagname)
{
    $pattern = "#<\s*?$tagname\b[^>]*>(.*?)</$tagname\b[^>]*>#s";
    preg_match($pattern, $string, $matches);
    return $matches[1];
}

function crawl_all_image_from_url($url, $saveTo='')
{
    $html       = use_curl_get_html($url, true);
    $html       = str_get_html($html);
    if($html)
    {
        foreach ($html->find('img') as $value) {
            $src = $value->getAttribute('src');
            use_curl_download_file(base64_encode($src), $saveTo);
        }
    } 
}

/*
Loai bo cac thuoc tinh ko cho phep trong cac the
*/
function clean_attr_chapter($html,$folder_img = "", $attributes=array())
{
    $alt = array_get($attributes, 'alt');
    $doc  = new DOMDocument("1.0", "UTF-8");
    $doc->formatOutput = true;
    //Cho thẻ HTML, meta UTF8, <body> vào DOM để tránh lỗi khi loadHTML
    $html = '<html>' .
        '<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">' .
        '<body>' .
        $html .
        '</body>' .
        '</html>';
    @$doc->loadHTML($html);
    foreach($doc->getElementsByTagName('p') as $element)
    {
        $element->removeAttribute('style');
        $element->removeAttribute('align');
        $element->removeAttribute('name');
        $element->removeAttribute('id');
        $element->removeAttribute('lang');
        $p_class = $element->getAttribute("class");
        if($p_class != "title" && $p_class != "image")
        {
            $element->removeAttribute('class');
        }
    }

    foreach($doc->getElementsByTagName('div') as $element)
    {
        $element->removeAttribute('id');
        $element->removeAttribute('style');
        $element->removeAttribute('align');
        $element->removeAttribute('data-width');
        $element->removeAttribute('videoid');
        $element->removeAttribute('videoid');
        $element->removeAttribute('videoexternalid');
        $element->removeAttribute('contenteditable');
        $element->removeAttribute('data-height');
        $element->removeAttribute('data-src');
        $element->removeAttribute('type');
        $element->removeAttribute('class');
    }

    foreach($doc->getElementsByTagName('img') as $element)
    {
        $element->removeAttribute('class');
        $element->removeAttribute('style');
        $element->removeAttribute('border');
        $element->removeAttribute('align');
        $element->removeAttribute('type');
        $element->removeAttribute('name');
        $element->removeAttribute('class');
        $element->removeAttribute('photoid');
        $element->removeAttribute('w');
        $element->removeAttribute('h');
        $element->removeAttribute('rel');
        $element->removeAttribute('data-original');
        $element->removeAttribute('data-src');
        $element->removeAttribute('srcset');
        $element->removeAttribute('sizes');
        $element->removeAttribute('id');
        $element->removeAttribute('lang');
        $element->removeAttribute('title');
        $element->removeAttribute('width');
        $element->removeAttribute('height');
        getParentByTagName_1($element,"p");
        getParentByTagName_1($element,"div");
        $src = $element->getAttribute('data-lazy-src');
        if (!$src)
        {
            $src = $element->getAttribute('src');
        }
        put_log('image_content', $src);
        $imgNews    = use_curl_download_file(base64_encode($src), $folder_img);
        $pathImage  = $folder_img.basename($imgNews);
        $element->setAttribute("src",$pathImage);
        if ($alt) $element->setAttribute("alt",$alt);
        $element->removeAttribute('data-lazy-src');
    }

    foreach($doc->getElementsByTagName('font') as $element)
    {
        $element->removeAttribute('class');
        $element->removeAttribute('id');
        $element->removeAttribute('face');
        $element->removeAttribute('lang');
        $element->removeAttribute('style');
        $element_size  = intval($element->getAttribute('size'));
        if($element_size == 4)
        {
            getParentByTagName($element,"p");
        }
        elseif($element_size >= 5)
        {
            getParentByTagName_2($element,"p");
        }
        $element->removeAttribute('size');
        if($element->getAttribute('color') == "#000000")
        {
            $element->removeAttribute('color');
        }
    }

    foreach($doc->getElementsByTagName('i') as $element)
    {
        $element->removeAttribute('style');
        $element->removeAttribute('class');
        $element->removeAttribute('id');
        $element->removeAttribute('lang');
    }

    foreach($doc->getElementsByTagName('a') as $element)
    {
        $element->removeAttribute('href');
        $element->removeAttribute('title');
        $element->removeAttribute('id');
        $element->removeAttribute('class');
    }

    foreach($doc->getElementsByTagName('b') as $element)
    {
        $element->removeAttribute('style');
        $element->removeAttribute('class');
        $element->removeAttribute('id');
        $element->removeAttribute('lang');
    }

    $html = $doc->saveHTML();
    $html = everything_in_tags($html, 'body');
    return $html;
}

/*
Them class title vao cho cai thang title
tim thay thang con $obj thi them cho thang cha no co the la $tag
*/
function getParentByTagName($obj, $tag)
{
    $obj_parent = $obj->parentNode;
    if (!$obj_parent) return false;
    if (strtolower($obj_parent->tagName) == $tag)
    {
        $obj_parent->setAttribute("class","title");

    }else{
        getParentByTagName($obj_parent, $tag);
    }
}

/*
    Them class chuong vao cho cai thang ten chuong
    tim thay thang con $obj thi them cho thang cha no co the la $tag
    Cai nay dung khi ma xu ly ca quyen(nhieu chuong)
*/
function getParentByTagName_2($obj, $tag)
{
    $obj_parent = $obj->parentNode;
    if (!$obj_parent) return false;
    if (strtolower($obj_parent->tagName) == $tag){
        $obj_parent->setAttribute("class","chuong");

    }else{
        getParentByTagName_2($obj_parent, $tag);
    }
}
/*
Them class img vao cho cai thang chua img
tim thay thang con $obj thi them cho thang cha no co the la $tag
*/
function getParentByTagName_1($obj, $tag)
{
    $obj_parent = $obj->parentNode;
    if (!$obj_parent) return false;
    if (isset($obj_parent->tagName) && strtolower($obj_parent->tagName) == $tag)
    {
        $obj_parent->setAttribute("class","image");
    }else{
        getParentByTagName_1($obj_parent, $tag);
    }
}