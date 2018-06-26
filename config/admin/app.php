<?php
//配置文件
return [
    'app_name'      => array(
        'app_title' => "狗淘网后台管理系统",
        'app_login' => "狗淘网后台登录",
    ),
    'verify_config' => array(
        'codeSet'  => "0123456789",
        'fontSize' => 25, // 验证码字体大小
        'length'   => 4, // 验证码位数
        'useNoise' => true, // 关闭验证码杂点
        'imageW'   => 300, // 验证码宽，0则自动计算
        'imageH'   => 0, // 验证码高，0则自动计算
        'expire'   => 30, // 有效期
        'reset'    => true,
    ),

    // +----------------------------------------------------------------------
    // | Auth权限设置
    // +----------------------------------------------------------------------
    'auth'          => [
        'auth_on'           => 1, // 权限开关
        'auth_type'         => 1, // 认证方式，1为实时认证；2为登录认证。
        'auth_group'        => 'auth_group', // 用户组数据不带前缀表名
        'auth_group_access' => 'auth_group_access', // 用户-用户组关系不带前缀表名
        'auth_rule'         => 'auth_rule', // 权限规则不带前缀表名
        'auth_user'         => 'auth_user', // 用户信息不带前缀表名
    ],

    'pwd_option'    => array(
        'cost' => 10,
    ),
    'cache_time'    => array( //缓存生存周期，单位秒
        'cache_user'       => '86400', //禁止登陆24小时
        'cache_index_page' => '7200', //后台首页缓存每2小时更新
        'cache_count_page' => '86400', //运营统计缓存每24小时更新
    ),
];
