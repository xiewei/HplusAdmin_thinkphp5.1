<?php
namespace app\admin\model;

use think\Db;
use think\Model;

class AuthUser extends Model
{
    protected $table = 'gtb_auth_user';

    protected $autoWriteTimestamp = true;
    protected $createTime         = 'create_datetime';

    protected $insert = ['realname', 'username', 'password', 'mobile', 'avatar', 'avatar', 'code', 'ps', 'login_ip' => '127.0.0.1', 'login_last_ip' => '127.0.0.1', 'create_datetime'];
    protected $update = ['id', 'realname', 'password', 'mobile', 'avatar', 'avatar', 'ps'];

    public function authuser_edit()
    {
        //获取ID
        $id = (int) input('post.id/d');
        //获取全部参数
        $data      = input('post.');
        $authgroup = new AuthUser;
        if ($id) {
            // 显式指定更新数据操作 isUpdate(true)
            if ($data['password']) {
                $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT, config('pwd_option'));
            } else {
                $userinfo         = AuthUser::get($data['id']);
                $data['password'] = $userinfo->password;
            }
            $return = $authgroup->isUpdate(true)->allowField(true)->isAutoWriteTimestamp(false)->save($data);
            if ($return) {
                Db::name('auth_group_access')->where('uid', $data['id'])->setField('group_id', $data['gid']);
            }
        } else {
            // 显式指定当前操作为新增操作 isUpdate(false)
            if ($data['password']) {
                $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT, config('pwd_option'));
            } else {
                return false;
            }
            $data['code'] = uniqid();
            $return       = $authgroup->isUpdate(false)->allowField(true)->save($data);
            if ($return) {
                //此处的 $return 不是返回的自增ID 一般返回1  如果要获取自增ID的话 $authgroup->id （2018年6月24日00:40:41 勿删）
                Db::name('auth_group_access')->insert(['uid' => $authgroup->id, 'group_id' => $data['gid']]);
            }
        }
        return $return;
    }

}
