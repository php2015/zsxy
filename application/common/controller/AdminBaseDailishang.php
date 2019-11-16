<?php
namespace app\common\controller;

use org\Auth;
use think\Loader;
use think\Cache;
use think\Controller;
use think\Db;
use think\Session;

/**
 * 后台公用基础控制器
 * Class AdminBase
 * @package app\common\controller
 */
class AdminBaseDailishang extends Controller
{
    protected function _initialize()
    {
        parent::_initialize();

        $this->checkAuth();
        $this->getMenu();

        // 输出当前请求控制器（配合后台侧边菜单选中状态）
        $this->assign('controller', Loader::parseName($this->request->controller()));
    }

    /**
     * 权限检查
     * @return bool
     */
    protected function checkAuth()
    {

        if (!Session::has('dailishang_id')) {
            $this->redirect('dailishang/login/index');
        }

        $module     = $this->request->module();
        $controller = $this->request->controller();
        $action     = $this->request->action();

        // 排除权限
        $not_check = ['dailishang/Index/index', 'dailishang/AuthGroup/getjson', 'dailishang/System/clear'];

        if (!in_array($module . '/' . $controller . '/' . $action, $not_check)) {
            $auth     = new Auth();
            $dailishang_id = Session::get('dailishang_id');
            /*
			if (!$auth->check($module . '/' . $controller . '/' . $action, $dailishang_id) && $dailishang_id != 1) {
                $this->error('没有权限');
            }
			*/
        }
    }

    /**
     * 获取侧边栏菜单
     */
    protected function getMenu()
    {
        $menu     = [];
        $admin_id = Session::get('dailishang_id');
        $auth     = new Auth();

        $auth_rule_list = Db::name('auth_rule_dailishang')->where('status', 1)->order(['sort' => 'DESC', 'id' => 'ASC'])->select();

        foreach ($auth_rule_list as $value) {
            if (1 == 1) {
                $menu[] = $value;
            }
        }
        $menu = !empty($menu) ? array2tree($menu) : [];
		//dump($menu);
        $this->assign('menu', $menu);
    }
}