<?php
namespace app\dailishang\controller;

use app\common\controller\AdminBaseDailishang;
use think\Config;
use think\Db;
use think\Session;

/**
 * 修改密码
 * Class ChangePassword
 * @package app\admin\controller
 */
class ChangePassword extends AdminBaseDailishang
{
    /**
     * 修改密码
     * @return mixed
     */
    public function index()
    {
        return $this->fetch('system/change_password');
    }

    /**
     * 更新密码
     */
    public function updatePassword()
    {
        if ($this->request->isPost()) {
            $dailishang_id    = Session::get('dailishang_id');
            $data   = $this->request->param();
            $result = Db::name('user')->find($dailishang_id);

            if ($result['password'] == md5($data['old_password'] . Config::get('salt'))) {
                if ($data['password'] == $data['confirm_password']) {
                    $new_password = md5($data['password'] . Config::get('salt'));
                    $res          = Db::name('user')->where(['id' => $dailishang_id])->setField('password', $new_password);

                    if ($res !== false) {
                        $this->success('修改成功');
                    } else {
                        $this->error('修改失败');
                    }
                } else {
                    $this->error('两次密码输入不一致');
                }
            } else {
                $this->error('原密码不正确');
            }
        }
    }
}