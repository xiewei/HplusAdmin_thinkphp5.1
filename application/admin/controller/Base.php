<?php
namespace app\admin\controller;

use think\auth\Auth;
use think\Controller;
use think\facade\Request;

class Base extends controller
{
    public $request;
    public $param;

    protected function initialize()
    {
        $request       = Request::instance();
        $this->request = $request;
        $this->param   = $request->param();

        $rule = $this->request->module() . '/' . $this->request->controller() . '/' . $this->request->action();
        $user = session('admin');

        // $ismore = S('ismore_' . md5($uid['username']));
        // if ($ismore['ismore'] == 0 && $ismore['phpsid'] != cookie('PHPSESSID')) {
        //     session('admin', null);
        //     if (IS_AJAX) {
        //         $this->error('你的账号已在其他地方登陆！');
        //     }
        //     $this->redirect('/Admin/Login');
        // }
        if (isAdminLogin()) {
            if ($user['id'] == 1) {
                return true;
            } else {
                $auth = new \com\Auth();
                if (!$auth->check($rule, $user['id'])) {
                    if ($request->isAjax()) {
                        $this->error('未授权访问');
                    } else {
                        $this->redirect('/Admin/Login/nopermissions');
                    }
                }
            }
        } else { $this->redirect('/Admin/Login');}
    }
}
