<?php
namespace app\admin\validate;

use think\Validate;

class AuthUser extends Validate
{

    protected $rule = array(
        'id'       => 'require|integer',
        'gid'      => 'require|integer',
        'username' => 'require|alphaNum|length:4,20|unique:auth_user',
        'password' => 'alphaNum|length:6,20',
        'realname' => 'require|chsAlphaNum|length:2,10',
        'mobile'   => 'require|mobile|length:11',
        'avatar'   => 'require|url|length:2,200',
        'ps'       => 'length:2,100',
    );

    protected $message = array(
        'id.require'           => "ID参数错误",
        'id.integer'           => "ID只能为数字",

        'gid.require'          => "所属组参数错误",
        'gid.integer'          => "所属组只能为数字",

        'username.require'     => "请输入用户名",
        'username.alphaNum'    => "用户名只能为字母和数字",
        'username.length'      => "用户名为4到20位",
        'username.unique'      => '用户名不是唯一',

        'password.require'     => '请输入密码',
        'password.alphaNum'    => '密码只能为字母和数字',
        'password.length'      => '密码长度为6到20位',

        'realname.require'     => '请输入姓名',
        'realname.chsAlphaNum' => '姓名只能为汉字、字母和数字',
        'realname.length'      => '姓名长度为2到10位',

        'mobile.require'       => '请输入手机号码',
        'mobile.mobile'        => '手机号码格式错误',
        'mobile.length'        => '电话号码长度只能为11位',

        'avatar.require'       => '请上传头像',
        'avatar.url'           => '头像格式错误',
        'avatar.length'        => '头像长度为2到200字符',

        'ps'                   => '备注长度为2到100个字符',
    );

    public function sceneAdd()
    {
        return $this->only(['gid', 'username', 'password', 'realname', 'mobile', 'avatar', 'ps'])->append('password', 'require');
    }

    public function sceneEdit()
    {
        return $this->only(['id', 'gid', 'username', 'password', 'realname', 'mobile', 'avatar', 'ps'])->remove('password', 'require')->remove('username', 'require');
    }
}
