<?php
namespace app\admin\controller;

use think\Controller;
use think\Db;

class Admin extends Base
{
    /**
     * [index description] 管理员页面
     * @return [type] [description]
     */
    public function index()
    {
        // echo Env::get('ROOT_PATH') . Env::get('DS') . 'uploads';
        return $this->fetch();
    }
    /**
     * [list_get description] 获取管理数据
     * @return [type] [description]
     */
    public function list_get()
    {
        $p = $this->param;
        if (!intval($p['pageSize'])) {
            $p['pageSize'] = 10;
        }
        if (!intval($p['pageNumber'])) {
            $p['pageNumber'] = 0;
        }
        if (empty($p['sort']) || $p['sort'] == "") {
            $p['sort'] = 'id';
        }
        if (empty($p['order']) || $p['order'] == "") {
            $p['order'] = 'desc';
        }
        if (!empty($p['search']) && $p['search'] != "") {
            $map = [
                ['auth_user.realname', 'like', '%' . $p['search'] . '%'],
                ['auth_user.username', 'like', '%' . $p['search'] . '%'],
            ];
        } else {
            $map = [];
        }

        $user = Db::view('auth_user', '*')
            ->view('auth_group_access', 'uid', 'auth_group_access.uid=auth_user.id', 'LEFT')
            ->view('auth_group', ['title' => 'group_name', 'id' => 'gid'], 'auth_group_access.group_id=auth_group.id')
            ->whereOr($map)
            ->order($p['sort'] . " " . $p['order'])
            ->limit($p['pageNumber'] . ',' . $p['pageSize'])
            ->select();

        $result["rows"]  = $user;
        $result["total"] = count($user);
        echo json_encode($result);
    }
    /**
     * [set_yesorno description] 设置管理员状态
     * @param string $value [description]
     */
    public function set_yesorno()
    {
        if ($this->request->isAjax()) {
            $oper = $this->param;
            if (!ctype_digit($oper['id']) || !ctype_digit($oper['value'])) {
                $this->error('参数错误');
            }
            if ($oper['id'] == 1) {
                $this->error('默认超级管理员不可归档，不可锁定，不可多点登陆');
            }

            $res = Db::name('auth_user')->where('id', $oper['id'])->update(array($oper['field'] => $oper['value']));

            if ($res !== false) {
                $this->success('设置成功');
            } else { $this->error('设置失败');}

        } else {
            $this->error('非法请求');
        }
    }
    /**
     * [user_edit_page description] 编辑/添加管理员页面
     * @param  string $value [description]
     * @return [type]        [description]
     */
    public function user_edit_page()
    {
        $group = Db::name('auth_group')->where('status', 1)->select();
        $this->assign('group', $group);
        return $this->fetch();
    }

    public function user_edit()
    {
        if ($this->request->isAjax()) {
            $param = $this->param;

            $validate = new \app\admin\validate\AuthUser;
            if ($param['id']) {
                if (!$validate->scene('edit')->check($param)) {
                    $this->error($validate->getError());
                } else {
                    if ($param['id'] == 1) {
                        if ($param['gid'] != 1) {
                            $this->error('默认超级管理员不可改变所属组');
                        }
                    } else {
                        if ($param['gid'] == 1) {
                            $count = Db::table('gtb_auth_user')->alias('u')
                                ->join('auth_group_access g', 'g.uid=u.id')
                                ->where("g.group_id", $param['gid'])->count();
                            if ($count) {
                                $this->error('超级管理组只能添加一位管理员');
                            }
                        }
                    }
                }
            } else {
                if (!$validate->scene('add')->check($param)) {
                    $this->error($validate->getError());
                } else {
                    if ($param['gid'] == 1) {
                        $count = Db::table('gtb_auth_user')->alias('u')
                            ->join('auth_group_access g', 'g.uid=u.id')
                            ->where("g.group_id", $param['gid'])->count();
                        if ($count) {
                            $this->error('超级管理组只能添加一位管理员');
                        }
                    }
                }
            }
            $return = model('AuthUser')->authuser_edit();
            if ($return) {
                $this->success('操作成功');
            } else {
                $this->error('操作失败');
            }
        } else {
            $this->error('非法请求');
        }
    }
}
