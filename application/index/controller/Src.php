<?php
namespace app\index\controller;
use think\Controller;
use think\Image;
use think\Request;//首先引入 Request 文件；
class Src extends Controller
{
   public function _initialize(){
        if(!session('name')){
           // $this->error('请先登录系统！','index/login/login');
          $this->redirect('index/login/login');
        }
    }
         public function index()
     {
        $url=input('url');
        $this->assign("url",$url);
       // dump($url);die;
        return $this->fetch('index');
    }
        public function fanhui()
     {
        return $this->fetch('fanhui');
    }
}