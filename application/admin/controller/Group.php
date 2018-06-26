<?php
namespace app\admin\controller;

use think\Controller;
use think\Db;

class Group extends Base
{
    /**
     * [index description] 组管理页面
     * @return [type] [description]
     */
    public function index()
    {
        return $this->fetch();
    }
    /**
     * [list_get description] 获取组数据
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
            $map['username'] = array('like', '%' . $p['search'] . '%');
            $map['realname'] = array('like', '%' . $p['search'] . '%');
            $map['_logic']   = 'or';
        } else {
            $map = [];
        }
        $count      = Db::name('auth_group')->where($map)->count();
        $auth_group = Db::name('auth_group')->where($map)->order($p['sort'] . " " . $p['order'])->limit($p['pageNumber'] . ',' . $p['pageSize'])->select();

        $result["rows"]  = $auth_group;
        $result["total"] = $count;
        echo json_encode($result);
    }
    /**
     * [set_yesorno description] 设置每个组的状态是否有效
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
                $this->error('默认管理组不可编辑');
            }
            $res = Db::name('auth_group')->where('id', $oper['id'])->update(array('status' => $oper['value']));
            if ($res !== false) {
                $this->success('设置成功');
            } else { $this->error('设置失败');}
        } else {
            $this->error('非法请求');
        }
    }
    /**
     * [group_edit_page description] 添加或编辑组页面
     * @param  string $value [description]
     * @return [type]        [description]
     */
    public function group_edit_page()
    {
        $arr_controller = getController("./application/admin/controller");

        $L_ar = Db::name("auth_rule")->where('status=1')->select();
        foreach ($L_ar as $k => $v) {
            $temp_arr               = explode('/', $v['name']);
            $L_ar[$k]['controller'] = $temp_arr[1];
        }
        $this->assign('L_ar', $L_ar);
        $this->assign('arr_controller', $arr_controller);
        return $this->fetch();
    }
    /**
     * [group_edit_action description] 编辑组/添加组操作请求
     * @param  string $value [description]
     * @return [type]        [description]
     */
    public function group_edit_action()
    {
        if ($this->request->isPost()) {

            $param    = $this->param;
            $validate = new \app\admin\validate\AuthGroup;
            if ($param['id']) {
                if (!$validate->scene('edit')->check($param)) {
                    $this->error($validate->getError());
                }
            } else {
                if (!$validate->scene('add')->check($param)) {
                    $this->error($validate->getError());
                }
            }
            $return = model('AuthGroup')->group_edit();
            if ($return) {
                $this->success('操作成功');
            } else {
                $this->error('操作失败');
            }
        } else { $this->error('非法请求');}
    }
    /**
     * [rule_add description] 添加规则页面
     * @param  string $value [description]
     * @return [type]        [description]
     */
    public function rule_add()
    {
        $arr_controller = getController("./application/admin/controller");
        foreach ($arr_controller as $v) {
            $all_action = getAction($v);
            foreach ($all_action as $v2) {
                $action_arr[$v][] = 'admin' . '/' . $v . '/' . $v2;
            }
        }
        $L_ar = Db::name("auth_rule")->select();
        foreach ($L_ar as $k => $v) {
            $temp_arr               = explode('/', $v['name']);
            $L_ar[$k]['controller'] = $temp_arr[1];
            $L_ar[$k]['fc']         = $temp_arr[2];
        }
        $this->assign('L_ar', $L_ar);
        $this->assign('arr_controller', $arr_controller);
        $this->assign('action_arr', $action_arr);
        return $this->fetch();
    }
    /**
     * [rule_edit description] 添加rule操作
     * @param  string $value [description]
     * @return [type]        [description]
     */
    public function rule_edit()
    {
        if ($this->request->isAjax()) {
            $param    = $this->param;
            $validate = new \app\admin\validate\AuthRule;

            if (!$validate->scene('add')->check($param)) {
                $this->error($validate->getError());
            }
            $return = Db::name('auth_rule')->insert($param);
            if ($return) {
                $this->success('添加成功');
            } else {
                $this->error('添加失败');
            }
        } else {
            $this->error('非法请求');
        }
    }
    /**
     * [rule_set_yesorno description] 设置规则的有效性
     * @param  string $value [description]
     * @return [type]        [description]
     */
    public function rule_set_yesorno()
    {
        if ($this->request->isAjax()) {
            $id = $this->request->post('id/d');
            if ($id) {
                $rule = Db::name('auth_rule')->where('id', $id)->find();
                if ($rule['status'] == 1) {
                    $res = Db::name('auth_rule')->where('id', $rule['id'])->setField('status', 0);
                } else {
                    $res = Db::name('auth_rule')->where('id', $rule['id'])->setField('status', 1);
                }
                if ($res !== false) {
                    $this->success($rule['status']);
                } else { $this->error('设置错误');}
            } else {
                $this->error('参数错误');
            }
        } else {
            $this->error('非法请求');
        }
    }
    /**
     * [rule_del description] 删除规则
     * @param  string $value [description]
     * @return [type]        [description]
     */
    public function rule_del()
    {
        if ($this->request->isAjax()) {
            $id = $this->request->post('id/d');
            if ($id) {
                $res = Db::name('auth_rule')->delete($id);
                if ($res !== false) {
                    $this->success('删除成功');
                } else { $this->error('删除错误');}
            } else {
                $this->error('参数错误');
            }
        } else {
            $this->error('非法请求');
        }
    }
}
