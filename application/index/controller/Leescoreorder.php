<?php
namespace app\index\controller;
use think\Controller;
use app\common\model\Leescoreorder as LeescoreorderModel;
use app\common\model\Leescoregoods as LeescoregoodsModel;
use app\common\model\User as UserModel;
use app\common\model\Agent as AgentModel;
use app\common\model\Profit as ProfitModel;
use app\common\model\Fahuoma as FahuomaModel;
use app\common\controller\AdminBase;
use think\Config;
use think\Db;
use think\Session;
header("content-type:text/html;charset=utf-8");         //设置编码
/**
 * 订单管理
 * Class AdminUser
 * @package app\admin\controller
 */
 
class Leescoreorder extends Controller
{
    protected $leescoreorder_model;
    protected $user_model;

    protected function _initialize()
    {
        parent::_initialize();
        $this->leescoreorder_model = new LeescoreorderModel();
        $this->leescoregoods_model = new LeescoregoodsModel();
		$this->user_model = new UserModel();
		$this->puser_model = new UserModel();
		$this->ppuser_model = new UserModel();
		$this->agent_model = new AgentModel();
		$this->profit_model = new ProfitModel();
		$this->fahuoma_model = new FahuomaModel();
    }

    /**
     * 订单管理
     * @param string $keyword
     * @param int    $page
     * @return mixed
     */
    public function index($keyword = '', $page = 1)
    {
	
	
        $map = [];
        if ($keyword) {
            $map['a.order_id|a.trade_id'] = ['like', "%{$keyword}%"];
        }
         $leescoreorder_list = $this->leescoreorder_model
		->alias("a")
		->field("a.*,b.names")
		->join("__USER__ b",'a.uid=b.id','LEFT')
		->where($map)
		
		->order('id DESC')->paginate(15, false, ['query'=>request()->param()]);
		
		$count=$this->leescoreorder_model->alias("a")->where($map)->count('a.id');
		
		//dump($count);die;
        return $this->fetch('index', ['leescoreorder_list' => $leescoreorder_list, 'keyword' => $keyword, 'count' => $count]);
		
		
    }
	
    public function title($id)
    {
        $id=input('id');
        $title=db('leescoreorder')->where('id','=',$id)->order('id','=',$id)->find();
		$goodslist=db('leescoreordergoods')->where('order_id','=',$id)->order('id','=',$id)->select();
		$gs="</br>
			<table class='layui-table'>
				<tr>
					<th>商品ID</th><th>商品名称</th><th>商品图片</th><th>商品价格</th>
				</tr>";
		$gc="";
		for($i=0;$i<count($goodslist);$i++)
		{
			
				$gc=$gc.'<tr>
					<th>'.$goodslist[$i]["goods_id"].'</th><th>'.$goodslist[$i]["goods_name"].'</th><th><center><img width=150px; height=150px; src="'.$goodslist[$i]["goods_thumb"].'"/></center></th><th>'.$goodslist[$i]["money"].'</th>
				</tr>';
		}
		$ge="</talbe>";
        $title['content']= htmlspecialchars_decode($title['content'].$gs.$gc.$ge);
        return $title;
    }

	
	
	
	
	
    /**
     * 添加订单
     * @return mixed
     */
    public function add()
    {
		$agent_list = Db::name('agent')->select();
		$this->assign("agent_list",$agent_list);
		$user_list=Db::name("user")->select();
		$this->assign("user_list",$user_list);
		return $this->fetch();
    }
	
	public function monizhifu($id)
	{
		if ($this->zhifu($id)) {
         	$this->success('模拟成功');
         } else {
         	$this->error('模拟失败');
         }
	}
	
	public function zhifu()
	{
      
      $id=input('id');
		//获取订单，并更改状态
		$leescoreorder           = $this->leescoreorder_model->find($id);
		$leescoreorder->status    = 1;
		$leescoreorder->pay    = 1;
		//获取用户id
		$user=$this->user_model->find($leescoreorder["uid"]);
		$puser=$this->puser_model->find($user["pid"]);
      	$this->xunhuan($puser["id"],0,0,$leescoreorder["order_id"],$leescoreorder["trade_money"],$leescoreorder["uid"],1,0);
		//如果用户是普通用户，则改等级
		if($user["agent_class"]==0)
		{
			$user["agent_class"]=1;
			$user["teams"]=6;
			$user->save();
			
			if($puser["agent_class"]==$user["agent_class"])
			{
				if($puser["teams"]-1==0)
				{
					//刚好升级,改自身等级并且继续朝上判定
					$puser["agent_class"]=$puser["agent_class"]+1;
					$a_c=$puser["agent_class"]+1;
					$agent=$this->agent_model->find($a_c);
					$puser["teams"]=$agent["tiaojian"];
					$puser->save();
					$this->shengji($puser["pid"],$puser["agent_class"]);
			
				}
				else
				{
					$puser["teams"]=$puser["teams"]-1;
					$puser->save();
				}
				
			}
		}
		
		//执行循环操作
	
		$leescoreorder->save();
      	$leescoreordergoods=db('leescoreordergoods')->where('order_id','=',$id)->find();
      	$leescoregoods=db('leescoregoods')->where('id','=',$leescoreordergoods['goods_id'])->find();
      
      	//$goods=$this->leescoregoods_model->find($leescoreordergoods["goods_id"]);
      	if($leescoregoods['type'] == 1){
      	$this->monifahuo($id);
          		$gettime=time();
                $getuphone= $user['mobile'];//当前登录电话
                $getupwd= $user['password'];//当前登录密码

    			$sql="insert into ap_user values(null,0,'','".$getuphone."','".$getupwd."','',2,1,1,'".$gettime."',0,'".$gettime."',0,1,'','',0,0,0,'NULL','','NULL','NULL','NULL','NULL','NULL','NULL','NULL','NULL','NULL',0,0,0)";
				$getlink=Db::connect('database.db2')->query($sql);

        }
      
         		
      
      
		$this->success('支付成功','index/dingdan/index');
	}
	public function zhifuss($id)
	{
      //$id=input('id');
		//获取订单，并更改状态
		$leescoreorder           = $this->leescoreorder_model->find($id);
		$leescoreorder->status    = 1;
		$leescoreorder->pay    = 1;
		//获取用户id
		$user=$this->user_model->find($leescoreorder["uid"]);
		$puser=$this->puser_model->find($user["pid"]);
		//如果用户是普通用户，则改等级
      $this->xunhuan($puser["id"],0,0,$leescoreorder["order_id"],$leescoreorder["trade_money"],$leescoreorder["uid"],1,0);
		if($user["agent_class"]==0)
		{
			$user["agent_class"]=1;
			$user["teams"]=6;
			$user->save();
			
			if($puser["agent_class"]==$user["agent_class"])
			{
				if($puser["teams"]-1==0)
				{
					//刚好升级,改自身等级并且继续朝上判定
					$puser["agent_class"]=$puser["agent_class"]+1;
					$a_c=$puser["agent_class"]+1;
					$agent=$this->agent_model->find($a_c);
					$puser["teams"]=$agent["tiaojian"];
					$puser->save();
					$this->shengji($puser["pid"],$puser["agent_class"]);
					
				}
				else
				{
					$puser["teams"]=$puser["teams"]-1;
					$puser->save();
				}
				
			}
		}
		
		//执行循环操作
		
		$leescoreorder->save();
      	$leescoreordergoods=db('leescoreordergoods')->where('order_id','=',$id)->find();
      	$leescoregoods=db('leescoregoods')->where('id','=',$leescoreordergoods['goods_id'])->find();
      	//$goods=$this->leescoregoods_model->find($leescoreordergoods["goods_id"]);
      	if($leescoregoods['type'] == 1){
      	$this->monifahuo($id);
          $gettime=time();
                $getuphone= $user['mobile'];//当前登录电话
                $getupwd= $user['password'];//当前登录密码

              	$sql="insert into ap_user values(null,'".$getuphone."','".$getupwd."','',2,1,1,'".$gettime."',0,'".$gettime."',-10,1,'','',0,0,'','','','http://my3.butsoft.cn/pay/?name=一个月&fee=12','http://my3.butsoft.cn/pay/?name=三个月&fee=28','http://my3.butsoft.cn/pay/?name=一年&fee=88','http://my3.butsoft.cn/pay/?name=永久&fee=188','http://my3.butsoft.cn/pay/?name=七天&fee=5','http://my3.butsoft.cn/pay/?name=六个月&fee=48','','',0,'','',0)";
				$getlink=Db::connect('database.db2')->query($sql);

        }
		//$this->success('支付成功','index/dingdan/index');
	}
	
	public function xunhuan($userid,$dangqiantuandui=0,$dangqianguanli=0,$dingdanid,$dingdanprice,$uid,$tag,$guanlitag)
	{
		$user=$this->user_model->find($userid);
		if($user["id"]==1)
		{
			//如果到总部了，就停止了
		}else
		{
			//如果是回本的话
			if($user["shengyuhuiben"]>$dingdanprice)
			{
				//改余额，累计收益，加资金明细记录，
				$user["money"]=$user["money"]+$dingdanprice;
				$user["total_achievement"]=$user["total_achievement"]+$dingdanprice;
				$user["shengyuhuiben"]=$user["shengyuhuiben"]-$dingdanprice;
				$user->save();
				$data["user_id"]=$uid;
				$data["profit_id"]=$user["id"];
				$data["create_time"]=time();
				$data["money"]=$dingdanprice;
				$data["type"]=1;
				$data["state"]="回本";
				$data["sid"]=$dingdanid;
				
				$profit_model = new ProfitModel();
				$profit_model->allowField(true)->save($data);
			}
			else
			{
				$agent=$this->agent_model->find($user["agent_class"]);
				//第一次进来拿直推
				if($tag==1)
				{
                  	
					$yijiticheng=$agent["ratio1"]*$dingdanprice;
					if($yijiticheng==0 && $user["agent_class"]==1)
					{
						//推的第一个，拿20%
						if($user["teams"]==6)
						{
							$yijiticheng=$dingdanprice*0.2;
						}
						//推的第二个，拿30%
						if($user["teams"]==5)
						{
							$yijiticheng=$dingdanprice*0.3;
						}
						//推的第三个，拿40%
						if($user["teams"]==4)
						{
							$yijiticheng=$dingdanprice*0.4;
						}
						//推的第四个，拿20%
						if($user["teams"]==3)
						{
							$yijiticheng=$dingdanprice*0.5;
						}
						//推的第一个，拿20%
						if($user["teams"]==2)
						{
							$yijiticheng=$dingdanprice*0.6;
						}
						//推的第一个，拿20%
						if($user["teams"]==1)
						{
							$yijiticheng=$dingdanprice*0.4;
						}
						
						
					}
					if($yijiticheng>0)
					{
						$user["money"]=$user["money"]+$yijiticheng;
						$user["total_achievement"]=$user["total_achievement"]+$yijiticheng;
						$user->save();
						$data["user_id"]=$uid;
						$data["profit_id"]=$user["id"];
						$data["create_time"]=time();
						$data["money"]=$yijiticheng;
						$data["type"]=1;
						$data["state"]="直推奖励";
						$data["sid"]=$dingdanid;
						$profit_model1 = new ProfitModel();
						$profit_model1->allowField(true)->save($data);
						//dump("直推");
					}
				}
				if($agent["tuandui"]>=$dangqiantuandui)
				{
					
					$tuanduijiang=($agent["tuandui"]-$dangqiantuandui)*$dingdanprice;
					$dangqiantuandui=$agent["tuandui"];
					if($tuanduijiang>0)
					{
						$user["money"]=$user["money"]+$tuanduijiang;
						$user["total_achievement"]=$user["total_achievement"]+$tuanduijiang;
						$user->save();
						$data["user_id"]=$uid;
						$data["profit_id"]=$user["id"];
						$data["create_time"]=time();
						$data["money"]=$tuanduijiang;
						$data["type"]=1;
						$data["state"]="团队奖励";
						$data["sid"]=$dingdanid;
						//Db::name("profit")->insert($save);
						$profit_model2 = new ProfitModel();
						$profit_model2->allowField(true)->save($data);
						//dump($user["id"]."团队");
					}
					
				}
				if($agent["guanli"]>=$dangqianguanli && $agent["guanli"]>0)
				{
					$guanlitag=$guanlitag+1;
					if($guanlitag==2)
					{
						//dump($user["id"]."管理");
						$guanlijiang=($agent["guanli"]-$dangqianguanli)*$dingdanprice;
						$dangqianguanli=$agent["guanli"];
						if($guanlijiang>0)
						{
							$user["money"]=$user["money"]+$guanlijiang;
							$user["total_achievement"]=$user["total_achievement"]+$guanlijiang;
							$user->save();
							$data["user_id"]=$uid;
							$data["profit_id"]=$user["id"];
							$data["create_time"]=time();
							$data["money"]=$guanlijiang;
							$data["type"]=1;
							$data["state"]="管理奖励";
							$data["sid"]=$dingdanid;
							$profit_model3 = new ProfitModel();
							$profit_model3->allowField(true)->save($data);
							
						}
					}
					
				}
				$tag=$tag+1;
				$this->xunhuan($user["pid"],$dangqiantuandui,$dangqianguanli,$dingdanid,$dingdanprice,$uid,$tag,$guanlitag);
			}
			
		}
		
	}
	//向上判定升级
	public function shengji($pid,$agent_class)
	{
		
			$user=$this->user_model->find($pid);
			$agent=$this->agent_model->find($user["agent_class"]);
			if($agent["tiaojian"]>0)
			{
				if($user["agent_class"]==$agent_class)
				{
					if($user["teams"]-1==0)
					{
						//刚好升级,改自身等级并且继续朝上判定
						$user["agent_class"]=$user["agent_class"]+1;
						$a_c=$user["agent_class"]+1;
						$agent=$this->agent_model->find($a_c);
						$user["teams"]=$agent["tiaojian"];
						$user->save();
						$this->shengji($user["pid"],$user["agent_class"]);
						//dump("1111111111111".$user["id"]."___".$agent["id"]."___".$agent["tiaojian"]);
						
					}
					else
					{
						$user["teams"]=$user["teams"]-1;
						$user->save();
					}
					
				}
				else if($user["agent_class"]<$agent_class)
				{
					
					$user["agent_class"]=$agent_class;
					$a_c=$user["agent_class"]+1;
					$agent=$this->agent_model->find($a_c);
					if($agent["tiaojian"]!=-1)
					{
						$user["teams"]=$agent["tiaojian"];
						$user->save();
					}
					$this->shengji($user["pid"],$user["agent_class"]);
				}
			}else if($agent["tiaojian"]<0 && $agent["id"]==1)
			{
              	//dump($user["id"]."___".$agent["id"]."___".$agent["tiaojian"]);
				$this->shengji($user["pid"],$agent_class);
				//如果条件等于0，普通，资源股东，联创不能升级	
			}
		
		
	}
	
	public function fahuos()
	{
		if ($this->request->isPost()) {
            $data            = $this->request->post();
			
            $validate_result = $this->validate($data, 'Leescoreorder');
			
            if ($validate_result !== true) {
                $this->error($validate_result);
            } else {
               	$leescoreorder           = $this->leescoreorder_model->find($data["id"]);
				$leescoreorder->virtual_sn    = $data["virtual_sn"];
				$leescoreorder->virtual_name    = $data["virtual_name"];
				$leescoreorder->content    = $data["content"];
				$leescoreorder->status    = 2;
				$leescoreorder->virtual_go_time =time();
				$leescoreorder->save();
				
				$this->success('发货成功');
				
            }
        }
		
	}
	
	public function fahuo($id)
	{
		$leescoreorder = $this->leescoreorder_model->find($id);
				//订单type
		$user_list=Db::name("user")->select();
		$this->assign("user_list",$user_list);
        return $this->fetch('fahuoindex', ['leescoreorder' => $leescoreorder]);
		
	}
	public function monifahuo($id)
	{
		$leescoreorder           = $this->leescoreorder_model->find($id);
		$leescoreorder->status    = 2;
		$leescoreorder->virtual_go_time =time();
		$leescoreordergoods=db('leescoreordergoods')->where('order_id','=',$id)->find();
		if($leescoreordergoods)
		{
			$fahuoma=$this->fahuoma_model->where("gid","=",$leescoreordergoods["goods_id"])->where("state","=","0")->find();
			if($fahuoma)
			{
				$fahuoma["state"]=1;
				$fahuoma->save();
				$goods=$this->leescoregoods_model->find($leescoreordergoods["goods_id"]);
				$leescoreorder->virtual_sn=$fahuoma["ma"];
				$leescoreorder->virtual_name    = "核销码";
				$leescoreorder->content =$goods["rule"];
			}
			
		}
		
		 if ($leescoreorder->save() !== false) {
         	//$this->success('发货成功');
         } else {
         	//$this->error('发货失败');
         }
		 
	}
	public function moniqianshou($id)
	{
		$leescoreorder           = $this->leescoreorder_model->find($id);
		$leescoreorder->status    = 3;
		$leescoreorder->virtual_sign_time =time();
		 if ($leescoreorder->save() !== false) {
         	$this->success('模拟成功');
         } else {
         	$this->error('模拟失败');
         }
	}

	public function chaping($id)
	{
		$leescoreorder           = $this->leescoreorder_model->find($id);
		$leescoreorder->fen    = 2;
		 if ($leescoreorder->save() !== false) {
         	$this->success('处理成功');
         } else {
         	$this->error('处理失败');
         }
	}



    /**
     * 保存订单
     */
    public function save()
    {
        if ($this->request->isPost()) {
            $data            = $this->request->post();
            $validate_result = $this->validate($data, 'Leescoreorder');

            if ($validate_result !== true) {
                $this->error($validate_result);
            } else {
               	if ($data["uid"]!=0){
					$info=Db::name("user")->where(array("id"=>$data["uid"]))->find();
					$data["uname"]=$info["names"];
				}
				if ($data["sid"]!=0){
					$info=Db::name("user")->where(array("id"=>$data["sid"]))->find();
					$data["sname"]=$info["names"];
				}
				$data["create_time"]=time();
				
				
              
				if ($this->leescoreorder_model->allowField(true)->save($data)) {
                    $this->success('保存成功');
                } else {
                    $this->error('保存失败');
                }
            }
        }
    }

    /**
     * 编辑订单
     * @param $id
     * @return mixed
     */
    public function edit($id)
    {
        $leescoreorder = $this->leescoreorder_model->find($id);
		
		//订单type
		$user_list=Db::name("user")->select();
		$this->assign("user_list",$user_list);
		

        return $this->fetch('edit', ['leescoreorder' => $leescoreorder]);
    }

    /**
     * 更新订单
     * @param $id
     */
    public function update($id)
    {
	
        if ($this->request->isPost()) {
            $data            = $this->request->post();
			
            $validate_result = $this->validate($data, 'Leescoreorder');
			
            if ($validate_result !== true) {
                $this->error($validate_result);
            } else {
               	$leescoreorder           = $this->leescoreorder_model->find($data["id"]);
				$leescoreorder->virtual_sn    = $data["virtual_sn"];
				$leescoreorder->virtual_name    = $data["virtual_name"];
				$leescoreorder->content    = $data["content"];
				if($leescoreorder->save()){
					$this->success('修改成功');
				 } else {
					$this->error('修改失败');
				 }
            }
        }
		
    }

    /**
     * 删除订单
     * @param $id
     */
    public function delete($id)
    {
        if ($this->leescoreorder_model->destroy($id)) {
            $this->success('删除成功');
        } else {
            $this->error('删除失败');
        }
    }
	
}