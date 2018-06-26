<?php
namespace app\admin\controller;

use think\captcha\Captcha;
use think\Controller;
use think\Db;
use think\facade\Request;
use think\Validate;

class Login extends controller
{
    /**
     * [index description] 登陆页面
     * @return [type] [description]
     */
    public function index()
    {
        return $this->fetch();
    }
    /**
     * [verify description] 验证码
     * @return [type] [description]
     */
    public function verify()
    {
        $captcha = new Captcha(config('verify_config'));
        return $captcha->entry();
    }
    /**
     * [login description] 登陆请求
     * @return [type] [description]
     */
    public function login()
    {
        if (Request::isAjax()) {
            $s = Request::post();
            //当前账户密码输入错5次后限制登陆
            if (cache(md5($s['u'])) == 5) {
                $this->error('你已在' . (config('app.cache_time.cache_user') / 60 / 60) . '小时之内禁止登陆');
            }

            $validate = Validate::make([
                'u|用户名'      => 'alpha|max:6',
                'p|密码'       => 'require',
                'verify|验证码' => 'require',
            ]);

            if (!$validate->check($s)) {
                $this->error($validate->getError());
            }

            $captcha = new Captcha();
            if (!$captcha->check($s['verify'])) {
                $this->error('验证码错误');
            }

            $map['username'] = $s['u'];
            $map['isstatus'] = 1;

            $user = Db::name('auth_user')->where(['username' => $s['u'], 'isstatus' => 1])->find();
            if ($user) {
                if ($user['islock'] == 1) {
                    $this->error('你已被锁定');
                }
                if (password_verify($s['p'], $user['password'])) {
                    if (password_needs_rehash($user['password'], PASSWORD_DEFAULT, config('pwd_option'))) {
                        $data['password'] = password_hash($s['p'], PASSWORD_DEFAULT, config('pwd_option'));
                    }
                    $data['login_ip']            = Request::ip();
                    $data['login_last_ip']       = $user['login_ip'];
                    $data['login_datetime']      = time();
                    $data['login_last_datetime'] = $user['login_datetime'];
                    //将错误的缓存信息清除
                    cache(md5($s['u']), null);
                    Db::name('auth_user')->where('id', $user['id'])->update($data);
                    $user = Db::name('auth_user')->where('id', $user['id'])->field('password', true)->find();

                    session('admin', $user);
                    cache('ismore_' . md5($s['u']), array('ismore' => $user['ismore'], 'phpsid' => cookie('PHPSESSID')));

                    $this->success('登录成功', url('/admin'));

                } else {
                    if (cache(md5($s['u']))) {
                        cache(md5($s['u']), cache(md5($s['u'])) + 1);
                    } else {
                        cache(md5($s['u']), 1);
                    }
                    if (cache(md5($s['u'])) != 5) {
                        $this->error('用户名或密码出错' . cache(md5($s['u'])) . '次');
                    } else {
                        cache(md5($s['u']), 5, config('app.cache_time.cache_user'));
                        $this->error('你已在' . (config('app.cache_time.cache_user') / 60 / 60) . '小时之内禁止登陆');
                    }
                }
            } else {
                $this->error('数据错误');
            }
        }
    }

    /**
     * [nopermissions description] 没权限页面
     * @return [type] [description]
     */
    public function nopermissions()
    {
        return $this->fetch();
    }

    public function logout()
    {
        if (isAdminLogin()) {
            session('admin', null);
            session('[destroy]');
            $this->redirect('/Admin/login');
        } else {
            $this->redirect('/Admin');
        }
    }

}
