<?php
namespace app\admin\validate;

use think\Validate;

class Slide extends Validate
{
    protected $rule = array(
        'id'     => 'require|integer',
        'name'   => 'require|chsAlphaNum|length:2,10',
        'img'    => 'require|url|length:2,200',
        'link'   => 'url|length:2,200',
        'orders' => 'number|unique:slide',
    );

    protected $message = array(
        'id.require'       => "ID参数错误",
        'id.integer'       => "ID只能为数字",

        'name.require'     => '请输入标题',
        'name.chsAlphaNum' => '标题只能为汉字、字母和数字',
        'name.length'      => '标题长度为2到10位',

        'img.require'      => '请上传幻灯片',
        'img.url'          => '幻灯片图片格式错误',
        'img.length'       => '幻灯片图片长度为2到200字符',

        'link.url'         => '链接格式错误',
        'link.length'      => '链接长度为2到200字符',

        'orders.number'    => '排序只能是数字',
        'orders.unique'    => '排序已存在',
    );

    public function sceneAdd()
    {
        return $this->only(['name', 'img', 'link', 'orders']);
    }

    public function sceneEdit()
    {
        return $this->only(['id', 'name', 'img', 'link', 'orders']);
    }
}
