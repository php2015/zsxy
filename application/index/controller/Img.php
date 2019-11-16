<?php
namespace app\index\controller;

use think\Controller;
use think\Db;
use think\Session;

class Img extends Controller
{       
  public function imglist()
  { 
      $id=session('uid');
      $imglist=db('img_chaxun')->order('id desc')->select();
      $this->assign('imglist',$imglist);
      return $this->fetch('imglist01');
  }
  
   public function imglist01()
  { 
      $id=session('uid');
      $imglist=db('img_chaxun')->order('id desc')->select();
      $this->assign('imglist',$imglist);
      return $this->fetch();
  }
  
  
  
   //选择推广页面
    //分享
    public function share()
    {
        $pid=session('uid');
        $yuming=$_SERVER['HTTP_HOST'];
        $url = 'http://'.$yuming.'/index/login/daili/pid/'.$pid;
        $lianjie=$this->shortenSinaUrl($url);
        if($lianjie== 'none'){
            $lianjie = $url;
        }
        $this->assign('lianjie',$lianjie);
        return $this->fetch();
    }


    //生成网址的接口
    /**
     * [shortenSinaUrl 短网址接口]
     * @param  [integer] $long_url   需要转换的网址
     * @return [string]          [返回转结果]
     * @author king
     */
    public function shortenSinaUrl($long_url) {
        //apikey需要自己申请  方法见网址：   http://c7.gg/page/apidoc.html
        $apiUrl = 'http://api.c7.gg/api.php?format=json&url='. $long_url."&apikey=TdXuaecOhh8WhaYO8r@ddd";
        $curlObj = curl_init();
        curl_setopt($curlObj, CURLOPT_URL, $apiUrl);
        curl_setopt($curlObj, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curlObj, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($curlObj, CURLOPT_HEADER, 0);
        curl_setopt($curlObj, CURLOPT_HTTPHEADER, array(
            'Content-type:application/json'
        ));
        $response = curl_exec($curlObj);
        curl_close($curlObj);
        $json = json_decode($response);
        if(empty($json->error)){
            $url = $json->url;
        }else{
            $url = "none";
        }
        return $url;
    }
  
  
  
  
  public function add()
  { 
          $id=session('uid');
           if(request()->isPost()){

         $arr=request()->file('photo');
         //$img_id=input('id');
         $img_post=request();
         $img_tname=$img_post->post();
         //$dataduos=json_decode($img_tname,true);
         //$id=session('uid');
         //dump($img_post);die;
        // $data=db('img_url')->where('id','=',$id)->find();
         if($arr){
          $info = $arr->move(ROOT_PATH. DS . 'uploads');
                $dataimg='/'.'uploads'.'/'.$info->getSaveName();
                $data['thumb']=$dataimg;
                $data['uid']=$id;
                $data['tname']=$img_tname;
                $data['descc']=1;
              }else{
                return $this->error('请选择图片');
              }
         
         //dump($data);die;
         $user=db('img_url')->insert($data);
         if($user){
                 return $this->redirect('index/index/index');
             }else{
                 return $this->error('修改头像失败');
             }
         }
             
            //dump($data);die;
         //$data=db('user')->where('id','=',$id)->find();
         //dump($data);die;
         //$this->assign('user',$data);
          return $this->fetch();
      }
}