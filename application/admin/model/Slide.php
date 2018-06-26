<?php
namespace app\admin\model;

use think\Model;

class Slide extends Model
{
    protected $table = 'gtb_slide';

    protected $autoWriteTimestamp = true;
    protected $createTime         = 'create_time';

    protected $insert = ['name', 'img', 'link', 'orders', 'create_time'];
    protected $update = ['id', 'name', 'img', 'link', 'orders'];

    public function slide_edit()
    {
        //获取ID
        $id = (int) input('post.id/d');
        //获取全部参数
        $data      = input('post.');
        $authgroup = new Slide;
        if ($id) {
            // 显式指定更新数据操作 isUpdate(true)
            $return = $authgroup->isUpdate(true)->allowField(true)->isAutoWriteTimestamp(false)->save($data);
        } else {
            $return = $authgroup->isUpdate(false)->allowField(true)->save($data);
        }
        return $return;
    }
}
