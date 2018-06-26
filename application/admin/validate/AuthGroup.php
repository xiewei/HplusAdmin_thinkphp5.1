<?php
namespace app\admin\validate;

use think\Validate;

class AuthGroup extends Validate
{

    protected $rule = array(
        'id'          => 'number',
        'title'       => 'require|max:4',
        'description' => 'require',
        'status'      => 'number',
        'rules'       => 'require|array|checkrules',
    );
    protected $message = array(
        'id.number'           => "ID参数错误",
        'title.require'       => '标题必须填写',
        'title.max'           => '标题最多不能超过25个字符',
        'description.require' => '描述不能为空',
        'rules.require'       => '请选择规则',
        'rules.checkrules'    => '规则参数错误',
    );

    protected $scene = [
        'add'  => ['title', 'description', 'status', 'rules'],
        'edit' => ['id', 'title', 'description', 'status'],
    ];
    // 自定义验证规则
    protected function checkrules($value, $rule, $data = [])
    {
        if ($value && is_array($value)) {
            foreach ($value as $k => $v) {
                if (!preg_match('/^[0-9]+$/u', $v) || strlen($v) > 11) {
                    return false;
                }
            }
            return true;
        } else {
            return false;
        }
    }
}
