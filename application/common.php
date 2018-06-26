<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006-2016 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: 流年 <liu21st@gmail.com>
// +----------------------------------------------------------------------
/**
 * [p 调试方法]
 * @param  array   $data  [description]
 * @return [type]        [description]
 */
function xw($data, $die = 0)
{
    echo "<pre>";
    print_r($data);
    echo "</pre>";
    if ($die) {
        die;
    }
}
/**
 * [resultArray description] 返回对象
 * @param  [type] $array [description] 响应数据
 * @return [type]        [description]
 */
function resultArray($array)
{
    if (isset($array['data'])) {
        $array['error'] = '';
        $code           = 200;
    } elseif (isset($array['error'])) {
        $code          = 400;
        $array['data'] = '';
    }
    return [
        'code'  => $code,
        'data'  => $array['data'],
        'error' => $array['error'],
    ];
}
/**
 * [HttpServerName description] 获取地址
 * @param  [type] $pageurl [description] 返回地址
 */
function HttpServerName()
{
    $pageurl = 'http';
    if (array_key_exists('HTTPS', $_SERVER) && $_SERVER["HTTPS"] == "on") {
        $pageurl .= "s";
    }
    $pageurl .= "://";
    $pageurl .= $_SERVER["SERVER_NAME"];
    return $pageurl;
}

//随机字符串
function randstr($lenght)
{
    $randstr = array('0', '1', '2', '3', '4', '5', '6', '7', '8', '9', 'A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z', 'a', 'b', 'c', 'd', 'e', 'f', 'g', 'h', 'i', 'j', 'k', 'l', 'm', 'n', 'o', 'p', 'q', 'r', 's', 't', 'u', 'v', 'w', 'x', 'y', 'z');
    $res     = "";
    for ($i = 0; $i < $lenght; $i++) {
        $res .= $randstr[mt_rand(0, 61)];
    }
    return $res;
}
