<?php
namespace app\dailishang\controller;

use think\Controller;
use think\Db;
use think\Session;
class Shangping extends Controller
{   
    
    //操作说明
     public function index()
    {
      
        $this->redirect('dailishang/login/index');
    }
   
}