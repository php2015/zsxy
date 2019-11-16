<?php
namespace app\index\controller;

use think\Controller;
use think\Db;
use think\Session;

class Allindex extends Controller
{
    
   public function _initialize(){
        if(!session('name')){
           // $this->error('请先登录系统！','index/login/login');
          $this->redirect('index/login/login');
        }
    }
    
     public function xianze()
    { 
       return $this->fetch();
    }
     public function index()
    { 
      $id=session('uid');
        $xiaji=db('user')->where('id','=',$id)->find();
        $upd=db('user')->where('pid','=',$xiaji['pid'])->find();
        $this->assign('upd',$upd);
       return $this->fetch();
    }
      public function xiaji()
    { 
       $kstime=input('kstime');
       $jstime=input('jstime');
        // dump($jstime);die;
        // $time=time();
        // $date=date('Y-m-d');
        // $times=time($date);
        // dump($time);die;
if(!empty($kstime)){
    $kstimes=strtotime($kstime);
    $date=date('Y-m-d',$kstimes);
    //dump($date);die;
    $jstimes=strtotime($jstime);
    $id=session('uid');
        $xiaji=db('user')->where('id','=',$id)->find();
        $user=db('user')
        ->alias('u')
        ->join('sun_agent a','u.agent_class=a.id')
        ->field('u.*,a.agent_name')->where('u.create_time','between',[$kstimes, $jstimes])
        ->where('u.pid','=',$id)->order('create_time asc')->select();
        //where('u.create_time','between',[$kstime, $jstime])->
        //dump($user);die;
        $this->assign('xiaji',$xiaji);
        $this->assign('user',$user);
}else{
  		$kaishi=date('Y-m-d 00:00');
         $kaishitime=strtotime($kaishi);
         $jieshu=date('Y-m-d 23:59');
         $jieshutime=strtotime($jieshu);
        $id=session('uid');
        $xiaji=db('user')->where('id','=',$id)->find();
        $user=db('user')
        ->alias('u')
        ->join('sun_agent a','u.agent_class=a.id')
        ->field('u.*,a.agent_name')
        ->where('u.pid','=',$id)->order('agent_class asc')->where('u.create_time','between',[$kaishitime, $jieshutime])
          ->select();
        //dump($user);die;
        $this->assign('xiaji',$xiaji);
        $this->assign('user',$user);
      }
      return $this->fetch();
      }   
    public function gerenxingxin()
    {
    
        $id=session('uid');
        $user=db('user')->where('id','=',$id)->find();
       $puser=db('user')->where('id','=',$user['pid'])->find();
        $user['pmid']=$puser['mid'];
      
        $this->assign('user',$user);
        return $this->fetch();
      }
         

      public function touxiang()
    { 
      $id=session('uid');
       if(request()->isPost()){

     $arr=request()->file('photo');
     //$id=session('uid');
     //dump($id);die;
     $data=db('user')->where('id','=',$id)->find();
     if($arr){
      $info = $arr->move(ROOT_PATH. DS . 'uploads');
            $dataimg='/'.'uploads'.'/'.$info->getSaveName();
            $data['image']=$dataimg;
          }else{
            return $this->error('请选择图片');
          }
     
     //dump($data);die;
     $user=db('user')->update($data);
     if($user){
             return $this->success('修改头像成功','index/index/index');
         }else{
             return $this->error('修改头像失败');
         }
     }
         
        //dump($data);die;
     $data=db('user')->where('id','=',$id)->find();
     $this->assign('user',$data);
      return $this->fetch();
      }



      public function bianji()
    { 
      
       $id=session('uid');
        $user=db('user')->where('id','=',$id)->find();
       if(request()->isPost()){
        $data=input('post.');
         $idcard=substr($data['idcard'],0,2);
        $city=db('city')->where('citynumber','=',$idcard)->find();
        if(empty($city['id'])){
            $city['id']=0;
            $citys['id']=0;
        }else{
        $idcards=substr($data['idcard'],0,4);
        $citys=db('city')->where('citynumber','=',$idcards)->find();
    }
        $max=db('user')->max("id");
        //dump($citys);die;
        $max++;
      $max+=10000;
    $new_mid="M00".$max;
        $userss=[
        'id'=>$user['id'],
          'names'=>$data['username'],
          'mid'=>$new_mid,
          'idcard'=>$data['idcard'],
          'mobile'=>$data['phone'],
          'status'=>1,
          'create_time'=>$user['create_time'],
          'province'=>$city['id'],
          'city'=>$citys['id'],
          'pid'=>$user['pid'],
          'pnames'=>$user['pnames'],
          'operator'=>$user['operator'],
          'type'=>$user['type'],
          'master_id'=>$user['master_id'],
          //'note'=>$data['note'],
          'password'=>$user['password'],
          'zhimafen'=>$data['zhimafen'],
          'fangchan'=>$data['fangchan'],
          'xinyongka'=>$data['xinyongka'],
          'hunyin'=>$data['hunyin'],
          'xueli'=>$data['xueli'],
          'yueshouru'=>$data['yueshouru'],
          'shebao'=>$data['shebao'],
          'gongjijin'=>$data['gongjijin'],
          'cheliang'=>$data['cheliang'],
          'baodan'=>$data['baodan'],
          'weilidai'=>$data['weilidai']
        ];
        //dump($user);die;
        $validate= \think\loader::validate('User');
        if(!$validate->scene('add')->check($userss)){
            $this->error($validate->getError());
            die;
        }
        //dump($user);die;
        $bjimg_id=db('user')->update($userss);
        //$us=db('user')->insert($user);
     if($bjimg_id){
             return $this->success('提交成功','index/index/index');
         }else{
             return $this->error('提交失败');
         }
     
     }

      $this->assign('user',$user);
      return $this->fetch();
      }


      public function ziliao()
    { 
      $id=session('uid');
      $user=db('user')->where('id','=',$id)->find();
       if(request()->isPost()){
        $data=input('post.');
        $userss=[
        'id'=>$user['id'],
          'names'=>$user['names'],
          'mid'=>$user['mid'],
          'idcard'=>$user['idcard'],
          'mobile'=>$user['mobile'],
          'status'=>1,
          'create_time'=>$user['create_time'],
          'province'=>$user['province'],
          'city'=>$user['city'],
          'pid'=>$user['pid'],
          'pnames'=>$user['pnames'],
          'agent_class'=>$user['agent_class'],
          'operator'=>$user['operator'],
          'type'=>$user['type'],
          'master_id'=>$user['master_id'],
          //'note'=>$data['note'],
          'password'=>$user['password'],
          'zhimafen'=>$data['zhimafen'],
          'xinyongka'=>$data['xinyongka'],
          'hunyin'=>$data['hunyin'],
          'xueli'=>$data['xueli'],
          'yueshouru'=>$data['yueshouru'],
          'shebao'=>$data['shebao'],
          'gongjijin'=>$data['gongjijin'],
          'cheliang'=>$data['cheliang'],
          'fangchan'=>$data['fangchan'],
          'baodan'=>$data['baodan'],
          'weilidai'=>$data['weilidai']
        ];
        //dump($user);die;
        $validate= \think\loader::validate('User');
        if(!$validate->scene('add')->check($userss)){
            $this->error($validate->getError());
            die;
        }
        //dump($user);die;
        $bjimg_id=db('user')->update($userss);
        //$us=db('user')->insert($user);
     if(!empty($bjimg_id)){
             return $this->redirect('index/allindex/index');
         
         }else{
             return $this->error('提交失败');
         }
     
     }
     $this->assign('user',$user);
       return $this->fetch();
  }
   public function onenote()
    {
        $id=input('id');
       $note = Db::name('note')->where('id','=',$id)->field('*')->find();
       $note['content']= htmlspecialchars_decode($note['content']);
      $this->assign('note',$note);
        return $this->fetch();
    }
}
