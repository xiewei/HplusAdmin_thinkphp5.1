<?php
namespace app\admin\controller;

use think\Controller;
use think\Db;

class Customeruser extends Base
{
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
        $count  = Db::name('customer_user')->whereOr($map)->count();
        $L_user = Db::name('customer_user')->whereOr($map)->order($p['sort'], $p['order'])->limit($p['pageNumber'], $p['pageSize'])->select();

        $result["rows"]  = $L_user;
        $result["total"] = count($L_user);
        echo json_encode($result);
    }
    /**
     * [set_yesorno description] 设置宠物店短用户状态
     * @param  string $value [description]
     * @return [type]        [description]
     */
    public function set_yesorno()
    {
        if ($this->request->isAjax()) {
            $oper = $this->param;
            if (!ctype_digit($oper['id']) || !ctype_digit($oper['value'])) {
                $this->error('参数错误');
            }
            $res = Db::name('customer_user')->where('id', $oper['id'])->update(array($oper['field'] => $oper['value']));

            if ($res !== false) {
                $this->success('设置成功');
            } else { $this->error('设置失败');}

        } else {
            $this->error('非法请求');
        }
    }
    /**
     * [customer_details description] 查看详情
     * @param  string $value [description]
     * @return [type]        [description]
     */
    public function customer_details()
    {

        $data = Db::name('customer_user')->where('id', request()->param('id'))->find();
        $this->assign('data', $data);
        return $this->fetch();
    }
    /**
     * [auth_customer description] 宠物店端用户认证页面
     * @return [type] [description]
     */
    public function auth_customer()
    {

        return $this->fetch();
    }
    /**
     * [customer_list_get description] 获取宠物店端用户认证数据
     * @return [type] [description]
     */
    public function customer_list_get()
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

        $json = ['product_type'];

        $L_user = Db::table('gtb_customer_customer')
            ->alias('m')
            ->leftJoin('gtb_customer_user u', 'u.id = m.u_id')
            ->order($p['sort'], $p['order'])->json($json)
            ->limit($p['pageNumber'] . ',' . $p['pageSize'])
            ->field('m.*,u.id as userid,u.login_id,u.phone')->select();

        $result["rows"]  = $L_user;
        $result["total"] = count($L_user);
        echo json_encode($result);
    }
    /**
     * [auth_customer_edit_page description] 查看认证数据详情
     * @return [type] [description]
     */
    public function auth_customer_edit_page()
    {
        if (request()->param('id')) {
            //查询的json字段
            $json     = ['product_type', 'license_image', 'logo_image', 'customer_image'];
            $customer = Db::name('customer_customer')->json($json)->where('id', request()->param('id'))->find();
            //license_image 营业执照
            foreach ($customer['license_image'] as $key => $value) {
                $customer['license_image'][$key] = Db::name('file')->where('id', $value)->value('uri');
            }
            //logo_image 店铺logo
            foreach ($customer['logo_image'] as $key => $value) {
                $customer['logo_image'][$key] = Db::name('file')->where('id', $value)->value('uri');
            }
            //customer_image  店铺内图集
            foreach ($customer['customer_image'] as $key => $value) {
                $customer['customer_image'][$key] = Db::name('file')->where('id', $value)->value('uri');
            }
            //宠物类型 店铺主营产品 product_type
            foreach ($customer['product_type'] as $key => $value) {
                $customer['product_type'][$key] = Db::name('product')->where('id', $value)->value('name');
            }

            $this->assign('list', json_encode($customer));
            $this->assign('data', $customer);
            return $this->fetch();
        } else {
            $this->error('参数错误');
        }
    }
    /**
     * [auth_customer_edit description] 认证审批操作
     * @param  string $value [description]
     * @return [type]        [description]
     */
    public function auth_customer_edit()
    {
        if ($this->request->isAjax()) {
            $oper = $this->param;
            if (!ctype_digit($oper['id']) || !ctype_digit($oper['state'])) {
                $this->error('参数错误');
            }
            $res = Db::name('customer_customer')->where('id', $oper['id'])->update(array('state' => $oper['state']));

            if ($res !== false) {
                $this->success('设置成功');
            } else { $this->error('设置失败');}

        } else {
            $this->error('非法请求');
        }
    }
}
