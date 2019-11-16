<?php
namespace app\index\controller;

use think\Controller;
use think\Db;
use think\Session;
header("content-type:text/html;charset=utf-8");         //设置编码
class Dingdan extends Controller
{
    //发货
     public function fahou()
    {
	$did=input('did');
	$this->assign("did",$did);
	 return $this->fetch();
	}
	 //发货
     public function fahous()
    {
		$data['virtual_name']=input('virtual_name');
		$data['id']=input('id');
		$data['virtual_sn']=input('virtual_sn');
		$data['status']=2;
		$data['virtual_go_time']=time();
		if(db('Leescoreorder')->where('id','=',$data['id'])->update($data)){
			$this->success('发货成功','index/dingdan/index');
		}else{
		
		}
	}
   public function Index(){
     Session::delete('order_no');
          $uid=session('uid');
        $page=input('page');
        $leescoreorder=db('leescoreordergoods')
        ->alias("g")
        ->field("l.*,g.buy_num,g.money,g.goods_name,g.goods_thumb,g.id g_id")
        ->join("sun_leescoreorder l","g.order_id=l.id","LEFT")
        ->where('l.uid','=',$uid)
           ->order('l.id desc')
           ->order('g.order_id desc')
        ->paginate(4);
         //dump($leescoreorder);die;
        $num=count($leescoreorder);
        // for($i=0;$i<$num;$i++){
        //   if($leescoreorder[$i]['status'] == 0){
        //     $leescoreorder[$i]['zhuangtai'] = '未付款';
        //   }else if($leescoreorder[$i]['status'] == 1){
        //     $leescoreorder[$i]['zhuangtai'] = '已付款';
        //   }else if($leescoreorder[$i]['status'] == 2){
        //     $leescoreorder[$i]['zhuangtai'] = '已发货';
        //   }else if($leescoreorder[$i]['status'] == 3){
        //     $leescoreorder[$i]['zhuangtai'] = '已签收';
        //   }else if($leescoreorder[$i]['status'] == 4){
        //     $leescoreorder[$i]['zhuangtai'] = '退货中';
        //   }
        // }
        $this->assign("leescoreorder",$leescoreorder);
        return $this->fetch('index');
    }
	 public function Xiangqing(){
    	 $uid=session('uid');
        $id=input('did');
        $leescoreorder=db('leescoreordergoods')
        ->alias("g")
        ->field("l.*,g.buy_num,g.money,g.goods_name,g.goods_thumb,g.id g_id,r.region,r.city,r.xian,r.address,s.type")
        ->join("sun_leescoreorder l","g.order_id=l.id","LEFT")
		->join("sun_leescoreaddress r","l.address_id=r.id","LEFT")
        ->join("sun_leescoregoods s","s.id=g.goods_id","LEFT")
        ->where('l.uid','=',$uid)
		 ->where('l.id','=',$id)
        ->find();
        $leescoreorder['content']= htmlspecialchars_decode($leescoreorder['content']);
        $this->assign("leescoreorder",$leescoreorder);
        return $this->fetch('xiangqing');
    }
    public function Weifukuan(){
      	$uid=session('uid');
      	$page=input('page');
      	$leescoreorder=db('leescoreorder')
        ->alias("l")
        ->field("l.*,g.buy_num,g.money,g.goods_name,g.goods_thumb,g.id g_id")
        ->join("sun_leescoreordergoods g","g.order_id=l.id","LEFT")
        ->where('l.uid','=',$uid)
        ->paginate(1);

        $num=count($leescoreorder);
        for($i=0;$i<$num;$i++){
        	if($leescoreorder[$i]['status'] == 0){
        		$leescoreorder[$i]['zhuangtai'] = '未付款';
        	}else if($leescoreorder[$i]['status'] == 1){
        		$leescoreorder[$i]['zhuangtai'] = '已付款';
        	}else if($leescoreorder[$i]['status'] == 2){
        		$leescoreorder[$i]['zhuangtai'] = '已发货';
        	}else if($leescoreorder[$i]['status'] == 3){
        		$leescoreorder[$i]['zhuangtai'] = '已签收';
        	}else if($leescoreorder[$i]['status'] == 4){
        		$leescoreorder[$i]['zhuangtai'] = '退货中';
        	}
        }
        
        return $leescoreorder;
    }
    public function Quxiao(){
      	$data['id']=input('did');
        $data['status']=-1;
        $leescoreorder=db('leescoreorder')->where('id','=',$data['id'])->find();
        if($leescoreorder['status'] == 0){
            if(db('leescoreorder')->where('id','=',$data['id'])->update($data)){
              //库存+
                  $leescoregoods  =db('leescoregoods')
                ->alias("l")
               ->field("l.*,d.buy_num")
                ->join("sun_leescoreordergoods d","l.id=d.goods_id","LEFT")
               ->where('d.order_id','=',$leescoreorder['id'])
               ->find();
                if($leescoregoods){
                    $data_godds['id']=$leescoregoods['id'];
                 $data_godds['stock']=$leescoregoods['stock'] + $leescoregoods['buy_num'];
                 $leescoregood_up = Db::name('leescoregoods')->where('id','=',$leescoregoods['id'])->update($data_godds);
                }
                return $this->redirect('index/dingdan/index');
            }else{
                return $this->error('取消订单失败');
            }
        }else{
            return $this->error('无法取消订单');
        }
    }
   
}
