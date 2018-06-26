<?php
namespace app\admin\validate;

use think\Validate;

class AuthRule extends Validate
{

    protected $rule = array(
        'module'    => 'alphaDash|length:2,50',
        'type'      => 'integer|length:1',
        'name'      => ['require', 'regex' => '/^[0-9a-zA-Z\/_]+$/u', 'length:2,50', 'unique:auth_rule'],
        'title'     => ['require', 'regex' => '/^[0-9a-zA-Z\x{4e00}-\x{9fa5}\-]+$/u', 'length:2,50', 'unique:auth_rule'],
        'status'    => 'integer|length:1',
        'condition' => ['regex' => '/^[0-9a-zA-Z_\!\=\(\)\>\<\' ]+$/u', 'length:1,1000'],
    );
    protected $message = array(
        'module.alphaDash' => "模型仅能为字母和数字，下划线_及破折号-",
        'module.length'    => "模型长度为2到50位",

        'type.integer'     => "验证类型仅能为数字",
        'type.length'      => "验证类型长度错误",

        'name.require'     => '节点仅能为数字，大小写字母，斜杠，下划线',
        'name.regex'       => '节点仅能为数字，大小写字母，斜杠，下划线',
        'name.length'      => '节点长度为2到50位',
        'name.unique'      => '节点规则已存在',

        'title.require'    => '规则名称仅能为数字，字母，汉字及横杠',
        'title.regex'      => '规则名称仅能为数字，字母，汉字及横杠',
        'title.length'     => '规则名称长度为2到50个字符',
        'title.unique'     => '规则名称已存在',

        'status.integer'   => '状态仅能为数字',
        'status.length'    => '状态长度错误',

        'condition.regex'  => '额外规则仅能为数字，字母，判断表达式',
        'condition.length' => '额外规则长度为1到1000位',
    );

    protected $scene = [
        'add' => ['module', 'type', 'name', 'title', 'status', 'condition'],
    ];

}
