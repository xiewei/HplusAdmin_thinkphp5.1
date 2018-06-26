<?php
namespace app\admin\widget;

use think\Controller;
use think\Db;
use think\facade\Request;

class All extends Controller
{
    public function user_info()
    {
        $user = session('admin');

        $user = Db::view('auth_user', '*')
            ->view('auth_group_access', 'uid', 'auth_group_access.uid=auth_user.id', 'LEFT')
            ->view('auth_group', ['title' => 'group_name', 'id' => 'gid'], 'auth_group_access.group_id=auth_group.id')
            ->where('auth_user.id', $user['id'])->find();

        $this->assign('user', $user);
        return $this->fetch('all/user_info');
    }
    public function css()
    {
        $request    = Request::instance();
        $controller = $request->controller();
        $action     = $request->action();
        $this->assign('controller', $controller);
        $this->assign('action', $action);

        return $this->fetch('all/css');
    }

    public function js()
    {
        $request    = Request::instance();
        $controller = $request->controller();
        $action     = $request->action();
        $this->assign('controller', $controller);
        $this->assign('action', $action);

        return $this->fetch('all/js');
    }

    public function page_footer()
    {
        return $this->fetch('all/page_footer');
    }
}
