<?php
namespace app\index\controller;

use think\Controller;
use think\Db;
use think\Session;

class Companyprofile extends Controller
{
    //操作说明
    public function index()
    {
        $note = db('note')->where('tid','=',7)->order('id desc')->select();
        $this->assign('note',$note);
        return $this->fetch();
    }
}
