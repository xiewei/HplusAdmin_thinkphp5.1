<?php
/**
 * [isAdminLogin description] 验证后台是否登录
 * @param  string  $value [description]
 * @return boolean        [description]
 */
function isAdminLogin()
{
    $admin = session('admin');
    if (!$admin) {
        return false;
    }
    return true;
}

//获取所有控制器名称
function getController($dir)
{
    $pathList = glob($dir . '/*.php');
    $res      = [];
    foreach ($pathList as $key => $value) {
        $res[] = basename($value, '.php');
    }
    //排除部分控制器
    $inherents_controller = array('Login', 'Admin', 'Group', 'Base');
    $customer_controller  = array();
    foreach ($res as $func) {
        $func = trim($func);
        if (!in_array($func, $inherents_controller)) {
            $customer_controller[] = $func;
        }
    }
    return $customer_controller;
}
/**
 * [getActions description] 获取某个控制器的方法名的函数 此方法过滤父级Base控制器的方法，只保留自己的
 * @param  [type] $className [description]
 * @param  string $base      [description]
 * @return [type]            [description]
 */
function getAction($controller)
{
    if (empty($controller)) {
        return null;
    }
    $content = file_get_contents('./application/admin/controller/' . $controller . '.php');
    preg_match_all("/.*?public.*?function(.*?)\(.*?\)/i", $content, $matches);
    $functions = $matches[1];
    //排除部分方法
    $inherents_functions = array('_initialize', '__construct', 'getActionName', 'isAjax', 'display', 'show', 'fetch', 'buildHtml', 'assign', '__set', 'get', '__get', '__isset', '__call', 'error', 'success', 'ajaxReturn', 'redirect', '__destruct', '_empty');

    $customer_functions = array();
    foreach ($functions as $func) {
        $func = trim($func);
        if (!in_array($func, $inherents_functions)) {
            $customer_functions[] = $func;
        }
    }
    return $customer_functions;
}

//规则类型
function rule_type($s)
{
    switch ($s) {
        case 1:return '<span class="label label-info">实时</span>';
        case 2:return '<span class="label label-success">登陆</span>';
        default:return '异常';
    }
}
//规则状态
function rule_status($s)
{
    switch ($s) {
        case 0:return '<span onclick="set_yesorno(this)" style="cursor:pointer;" class="label label-danger">无效</span>';
        case 1:return '<span onclick="set_yesorno(this)" style="cursor:pointer;" class="label label-info">有效</span>';
        default:return '异常';
    }
}
