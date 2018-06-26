<?php
namespace app\admin\controller;

use think\Controller;
use think\Db;

class Slide extends Base
{
    /**
     * [index description] 幻灯片管理
     * @param  string $value [description]
     * @return [type]        [description]
     */
    public function index($value = '')
    {
        return $this->fetch();
    }
    /**
     * [list_get description] 获取幻灯片数据
     * @param  string $value [description]
     * @return [type]        [description]
     */
    public function list_get($value = '')
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
            $map['name']   = array('like', '%' . $p['search'] . '%');
            $map['_logic'] = 'or';
        } else {
            $map = [];
        }
        $count      = Db::name('slide')->where($map)->count();
        $auth_group = Db::name('slide')->where($map)->order($p['sort'], $p['order'])->limit($p['pageNumber'] . ',' . $p['pageSize'])->select();

        $result["rows"]  = $auth_group;
        $result["total"] = $count;
        echo json_encode($result);
    }

    /**
     * [set_status description] 设置幻灯片的状态
     * @param string $value [description]
     */
    public function set_status()
    {
        if ($this->request->isAjax()) {
            $oper = $this->param;
            if (!ctype_digit($oper['id']) || !ctype_digit($oper['value'])) {
                $this->error('参数错误');
            }
            $res = Db::name('slide')->where('id', $oper['id'])->update(array($oper['field'] => $oper['value']));
            if ($res !== false) {
                $this->success('设置成功');
            } else { $this->error('设置失败');}
        } else {
            $this->error('非法请求');
        }
    }

    /**
     * [slide_edit_page description] 编辑或添加幻灯片页面
     * @return [type] [description]
     */
    public function slide_edit_page()
    {

        return $this->fetch();
    }
    /**
     * [slide_edit description] 编辑或添加幻灯片请求
     * @param  string $value [description]
     * @return [type]        [description]
     */
    public function slide_edit($value = '')
    {
        if ($this->request->isAjax()) {
            $param    = $this->param;
            $validate = new \app\admin\validate\Slide;
            if ($param['id']) {
                if (!$validate->scene('edit')->check($param)) {
                    $this->error($validate->getError());
                }
            } else {
                if (!$validate->scene('add')->check($param)) {
                    $this->error($validate->getError());
                }
            }
            $return = model('slide')->slide_edit();
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
