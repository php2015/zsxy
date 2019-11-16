<?php
namespace app\dailishang\controller;

use think\Config;
use think\Controller;
use think\Db;
use think\Session;

/**
 * 后台登录
 * Class Login
 * @package app\admin\controller
 */
class Login extends Controller
{
    /**
     * 后台登录
     * @return mixed
     */
    public function index()
    {
        return $this->fetch();
    }

    /**
     * 登录验证
     * @return string
     */
    public function login()
    {
        if ($this->request->isPost()) {
            $data            = $this->request->only(['tel', 'password']);
           
                $where['mobile'] = $data['tel'];
                $where['password'] = md5($data['password'] . Config::get('salt'));

                $dailishang = Db::name('user')->field('id,names,status')->where($where)->find();

                if (!empty($dailishang)) {
                    if ($dailishang['status'] != 1) {
                        $this->error('当前用户已禁用');
                    } else {
                        Session::set('dailishang_id', $dailishang['id']);
                        Session::set('dailishang_names', $dailishang['names']);
                      
                        $this->success('登录成功', 'dailishang/index/index');
                    }
                } else {
                    $this->error('用户名或密码错误');
                }
          
        }
    }

    /**
     * 退出登录
     */
    public function logout()
    {
        Session::delete('dailishang_id');
        Session::delete('dailishang_names');
        $this->success('退出成功', 'dailishang/login/index');
    }
}
