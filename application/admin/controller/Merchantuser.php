<?php
namespace app\admin\controller;

use think\Controller;
use think\Db;

class Merchantuser extends Base
{
    /**
     * [index description] Merchantuser 养殖户端用户管理
     * @param  string $value [description]
     * @return [type]        [description]
     */
    public function index()
    {
        return $this->fetch();
    }
    /**
     * [list_get description] 获取养殖户端用户数据
     * @param  string $value [description]
     * @return [type]        [description]
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
                ['login_id', 'like', '%' . $p['search'] . '%'],
                ['phone', 'like', '%' . $p['search'] . '%'],
            ];
        } else {
            $map = [];
        }
        $count  = Db::name('merchant_user')->whereOr($map)->count();
        $L_user = Db::name('merchant_user')->whereOr($map)->order($p['sort'] . " " . $p['order'])->limit($p['pageNumber'] . ',' . $p['pageSize'])->select();

        $result["rows"]  = $L_user;
        $result["total"] = count($L_user);
        echo json_encode($result);
    }
    /**
     * [set_yesorno description] 设置用户状态
     */
    public function set_yesorno()
    {
        if ($this->request->isAjax()) {
            $oper = $this->param;
            if (!ctype_digit($oper['id']) || !ctype_digit($oper['value'])) {
                $this->error('参数错误');
            }
            $res = Db::name('merchant_user')->where('id', $oper['id'])->update(array($oper['field'] => $oper['value']));

            if ($res !== false) {
                $this->success('设置成功');
            } else { $this->error('设置失败');}

        } else {
            $this->error('非法请求');
        }
    }
    /**
     * [merchant_details description] 查看详情
     * @param  string $value [description]
     * @return [type]        [description]
     */
    public function merchant_details()
    {
        $data = Db::name('merchant_user')->where('id', request()->param('id'))->find();
        $this->assign('data', $data);
        return $this->fetch();
    }
    /**
     * [merchant description] 养殖户端用户认证
     * @param  string $value [description]
     * @return [type]        [description]
     */
    public function auth_merchant()
    {

        return $this->fetch();
    }
    /**
     * [merchant_list_get description] 获取养殖户端用户认证数据
     * @param  string $value [description]
     * @return [type]        [description]
     */
    public function merchant_list_get()
    {
        $p = $this->param;
        if (!intval($p['pageSize'])) {
            $p['pageSize'] = 10;
        }
        if (!intval($p['pageNumber'])) {
            $p['pageNumber'] = 0;
        }
        if (empty($p['sort']) || $p['sort'] == "") {
            $p['sort'] = 'm.id';
        }
        if (empty($p['order']) || $p['order'] == "") {
            $p['order'] = 'desc';
        }
        if (!empty($p['search']) && $p['search'] != "") {
            $map['m.username'] = array('like', '%' . $p['search'] . '%');
            $map['m.realname'] = array('like', '%' . $p['search'] . '%');
            $map['_logic']     = 'or';
        } else {
            $map = [];
        }
        // $L_user = Db::view('merchant_merchant', '*')
        //     ->view('merchant_user', ['login_id', 'phone'], 'merchant_merchant.u_id=merchant_user.id', 'LEFT')
        //     ->whereOr($map)
        //     ->order($p['sort'] . " " . $p['order'])
        //     ->limit($p['pageNumber'] . ',' . $p['pageSize'])
        //     ->select();

        $L_user = Db::table('gtb_merchant_merchant')
            ->alias('m')
            ->leftJoin('merchant_user u', 'u.id = m.u_id')
            ->order($p['sort'], $p['order'])
            ->limit($p['pageNumber'] . ',' . $p['pageSize'])
            ->field('m.*,u.id as userid,u.login_id,u.phone')->select();

        $result["rows"]  = $L_user;
        $result["total"] = count($L_user);
        echo json_encode($result);
    }
}
