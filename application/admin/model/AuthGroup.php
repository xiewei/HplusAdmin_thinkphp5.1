<?php
namespace app\admin\model;

use think\Model;

class AuthGroup extends Model
{

    protected $table = 'gtb_auth_group';

    protected $insert = ['title', 'description', 'rules', 'status'];
    protected $update = ['id', 'title', 'description', 'rules', 'status'];

    public function group_edit()
    {
        $id            = (int) input('post.id/d');
        $data          = input('post.');
        $data['rules'] = implode(',', $data['rules']);

        $authgroup = new AuthGroup;
        if ($id) {
            // 显式指定更新数据操作 isUpdate(true)
            $return = $authgroup->isUpdate(true)->save($data);
        } else {
            // 显式指定当前操作为新增操作 isUpdate(true)
            $return = $authgroup->isUpdate(false)->save($data);
        }
        return $return;
    }

}
