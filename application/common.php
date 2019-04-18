<?php
 //+----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006-2016 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: 流年 <liu21st@gmail.com>
// +----------------------------------------------------------------------


//把span字符串换成a标签
function replace($data){
    return str_replace('span','a',$data);
}

function strToArray($data){
    return explode('|',$data);
}

//$text  文本的内容
//$logo  logo图片
function code($text){
    //二维码图片保存路径
    $pathname = APP_PATH . '/../Public';
    if(!is_dir($pathname)) { //若目录不存在则创建之
        mkdir($pathname);
    }
    vendor("phpqrcode.phpqrcode");
    $name =  "/upload/qrcode_" . time() . ".png";
    //二维码图片保存路径(若不生成文件则设置为false)
    $filename = $pathname .$name;


//二维码容错率，默认L
    $level = "L";
//二维码图片每个黑点的像素，默认4
    $size = '4';
//二维码边框的间距，默认2
    $padding = 2;
//保存二维码图片并显示出来，$filename必须传递文件路径
    $saveandprint = true;

//生成二维码图片
\PHPQRCode\QRcode::png($text,$filename,$level,$size,$padding,$saveandprint);
    return $name;
}