<?php
function check_image($path, $filename)
{
    $sExtension = getExtension($filename);
    //Check image file type extensiton
    $checkImg = true;
    switch($sExtension){
        case "gif":
            $checkImg = @imagecreatefromgif($path . $filename);
            break;
        case $sExtension == "jpg" || $sExtension == "jpe" || $sExtension == "jpeg":
            $checkImg = @imagecreatefromjpeg($path . $filename);
            break;
        case "png":
            $checkImg = @imagecreatefrompng($path . $filename);
            break;
    }
    if(!$checkImg)
    {
        delete_file($path, $filename);
        return 0;
    }
    return 1;
}

function delete_file($path, $filename)
{
    if($filename == "") return;
    $array_file	= array("small_", "normal_", "larger_", "");

    for($i=0; $i<count($array_file); $i++)
    {
        if(file_exists($path . $array_file[$i] . $filename))
            @unlink($path . $array_file[$i] . $filename);
    }
}

/**
 *  echo resize_image(MEDIA . 'downloads/images/', $imageDownloaded,100, 100, 75, 'medium_', MEDIA . 'downloads/crawls/');
 * @param
 * @return
 */
function resize_image($path, $filename, $maxwidth, $maxheight, $quality=75, $type = "small_", $new_path = "")
{
    $filename   = DIRECTORY_SEPARATOR.basename($filename);
    $sExtension = substr($filename, (strrpos($filename, ".") + 1));
    $sExtension = strtolower($sExtension);

    // check ton tai thu muc khong
    if (!file_exists($path.$type))
    {
        @mkdir($path.$type, 0777, true);
        chmod($path.$type, 0777);
    }
    // Get new dimensions
    $size = getimagesize($path . $filename);
    $width = $size[0];
    $height = $size[1];
    if($width != 0 && $height !=0)
    {
        if($maxwidth / $width > $maxheight / $height) $percent = $maxheight / $height;
        else $percent = $maxwidth / $width;
    }

    $new_width	= $width * $percent;
    $new_height	= $height * $percent;

    // Resample
    $image_p = imagecreatetruecolor($new_width, $new_height);
    //check extension file for create
    switch($size['mime'])
    {
        case 'image/gif':
            $image = imagecreatefromgif($path . $filename);
            break;
        case 'image/jpeg' :
        case 'image/pjpeg' :
            $image = imagecreatefromjpeg($path . $filename);
            break;
        case 'image/png':
            $image = imagecreatefrompng($path . $filename);
            break;
    }
    //Copy and resize part of an image with resampling
    imagecopyresampled($image_p, $image, 0, 0, 0, 0, $new_width, $new_height, $width, $height);

    // Output
    // check new_path, nếu new_path tồn tại sẽ save ra đó, thay path = new_path
    if($new_path != "")
    {
        $path = $new_path;
        if (!file_exists($path.$type))
        {
            @mkdir($path.$type, 0777, true);
            chmod($path.$type, 0777);
        }
    }

    switch($sExtension)
    {
        case "gif":
            imagegif($image_p, $path . $type . $filename);
            break;
        case $sExtension == "jpg" || $sExtension == "jpe" || $sExtension == "jpeg":
            imagejpeg($image_p, $path . $type . $filename, $quality);
            break;
        case "png":
            imagepng($image_p, $path . $type . $filename);
            break;
    }
    imagedestroy($image_p);
}

/*
	Check upload file path
	*/
function check_path_file($path)
{
    if(@filesize($path) == 0)
    {
        @unlink($path);
        return 0;
    }
    else return 1;
}


function resize_image_crop($path, $filename, $maxwidth, $maxheight, $quality, $type = "small_", $new_path = "",$dst_x = 0,$dst_y = 0,$src_x = 0,$src_y = 0){
    $sExtension = substr($filename, (strrpos($filename, ".") + 1));
    $sExtension = strtolower($sExtension);

    // Get new dimensions
    $size    = getimagesize($path . $filename);
    $width   = $size[0];
    $height  = $size[1];
    $width   = $src_x;
    $height  = $src_y;
    if($width != 0 && $height !=0){
        if($maxwidth / $width > $maxheight / $height) $percent = $maxheight / $height;
        else $percent = $maxwidth / $width;
    }

    $new_width	= $width * $percent;
    $new_height	= $height * $percent;
    $dst_w      = $new_width;
    $dst_h      = $new_height;

    // Resample
    $image_p = imagecreatetruecolor($dst_w, $dst_h);
    //check extension file for create
    switch($size['mime']){
        case 'image/gif':
            $image = imagecreatefromgif($path . $filename);
            break;
        case 'image/jpeg' :
        case 'image/pjpeg' :
            $image = imagecreatefromjpeg($path . $filename);
            break;
        case 'image/png':
            $image = imagecreatefrompng($path . $filename);
            break;
        default :
            $image = imagecreatefromjpeg($path . $filename);
            break;
    }
    //Copy and resize part of an image with resampling
    imagecopyresampled($image_p,$image,0,0,$dst_x,$dst_y,$dst_w,$dst_h,$src_x,$src_y);
    // Output

    // check new_path, nếu new_path tồn tại sẽ save ra đó, thay path = new_path
    if($new_path != "") $path = $new_path;

    switch($sExtension){
        case "gif":
            imagegif($image_p, $path . $type . $filename);
            break;
        case $sExtension == "jpg" || $sExtension == "jpe" || $sExtension == "jpeg":
            imagejpeg($image_p, $path . $type . $filename, $quality);
            break;
        case "png":
            imagepng($image_p, $path . $type . $filename);
            break;
    }
    imagedestroy($image_p);
}