<?php
namespace app\index\controller;

use think\Controller;
use think\Db;
use think\Session;
use Utils\Utils;
use EncryptUtil\EncryptUtil;
use Helper\Helper;
use HttpCurl\HttpCurl;
use Log\Log;
class Complaint extends Controller
{

     public function index(){
        return $this->fetch();
    }

    public function qz(){
        $type = input('type');
        $this->assign('type',$type);
        return $this->fetch();
    }

    public function yd(){
        $type = input('type');
        $this->assign('type',$type);
        return $this->fetch();
    }

    public function bs(){
        $type = input('type');
        $this->assign('type',$type);
        return $this->fetch();
    }


    public function tousu(){
        $type = input('type');
        $father = input('father');
        $this->assign('type',$type);
        $this->assign('father',$father);
        return $this->fetch();
    }

    public function comment(){
        return $this->fetch();
    }
  
   public function wenti(){
        return $this->fetch();
    }

}