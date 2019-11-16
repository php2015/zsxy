<?php
namespace app\admin\controller;

use app\common\model\Order as OrderModel;
use app\common\controller\AdminBase;
use think\Db;
use think\Session;

/**
 * 订单管理
 * Class Order
 * @package app\admin\controller
 */
 
class Order extends AdminBase
{
    protected $order_model;
    protected function _initialize()
    {
        parent::_initialize();
        $this->order_model  = new OrderModel();
    }

    /**
     * 订单管理
     * @param int    $cid     分类ID
     * @param string $keyword 关键词
     * @param int    $page
     * @return mixed
     */
    public function index($page = 1)
    {
		
        $map   = [];
        $order_list  = $this->order_model
		->alias("a")
		->field("a.*,b.names,c.product_name,d.names as operator_name,e.names as master_name")
		->join("__USER__ b","a.user_id=b.id","LEFT")
		->join("__PRODUCT__ c","a.product_id=c.id","LEFT")
		->join("__ADMIN_USER__ d","a.operator=d.id","LEFT")
		->join("__ADMIN_USER__ e","a.master_id=e.id","LEFT")
		->where($map)->order(['a.id' => 'DESC'])->paginate(15, false, ['page' => $page]);
        return $this->fetch('index', ['order_list' => $order_list]);
    }

	
    /**
     * 添加订单
     * @return mixed
     */
    public function add()
    {
        //管理员
		$admin_list=Db::name("admin_user")->select();
		$this->assign("admin_list",$admin_list);
		//商品
		$product_list=Db::name("product")->select();
		$this->assign("product_list",$product_list);
		//用户
		$user_list=Db::name("user")->field("id,names")->select();
		$this->assign("user_list",$user_list);
		return $this->fetch();
    }

    /**
     * 保存订单
     */
    public function save()
    {
        if ($this->request->isPost()) {
            $data            = $this->request->param();
            $validate_result = $this->validate($data, 'Order');

            if ($validate_result !== true) {
                $this->error($validate_result);
            } else {
                
				$data["create_time"]=strtotime($data["create_time"]);
				$data["operator"]=Session::get('admin_id');
				$result=$this->order_model->allowField(true)->save($data);
				if ($result) {
                    //分成
					$order_id=$this->order_model->getLastInsID();
					$this->buy($data,$order_id);
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
        $order = $this->order_model->find($id);
		//管理员
		$admin_list=Db::name("admin_user")->select();
		$this->assign("admin_list",$admin_list);
		//商品
		$product_list=Db::name("product")->select();
		$this->assign("product_list",$product_list);
		//用户
		$user_list=Db::name("user")->field("id,names")->select();
		$this->assign("user_list",$user_list);

        return $this->fetch('edit', ['order' => $order]);
    }

    /**
     * 更新订单
     * @param $id
     */
    public function update($id)
    {
        if ($this->request->isPost()) {
            $data            = $this->request->param();
            $validate_result = $this->validate($data, 'Order');

            if ($validate_result !== true) {
                $this->error($validate_result);
            } else {
				$order_info=$this->order_model->where(array("id"=>$id))->find();
				$data["create_time"]=strtotime($data["create_time"]);
				if ($this->order_model->allowField(true)->save($data, $id) !== false) {
                    //先退分成
					$this->back($order_info,$id);
					//再更新本次分成
					$this->buy($data,$id);
					$this->success('更新成功');
                } else {
                    $this->error('更新失败');
                }
            }
        }
    }

    /**
     * 删除订单
     * @param int   $id
     * @param array $ids
     */
    public function delete($id = 0)
    {
        if ($id) {
            $order_info=$this->order_model->where(array("id"=>$id))->find();
			if ($this->order_model->destroy($id)) {
                //退掉本次分成
				$this->back($order_info,$id);
				$this->success('删除成功，该单上级 及 二级上级分成同步扣减');
            } else {
                $this->error('删除失败');
            }
        } else {
            $this->error('请选择需要删除的订单');
        }
    }
	//处理分成流程
	private function buy($data,$order_id){
		$user_info=Db::name("user")->where(array("id"=>$data["user_id"]))->find();
		if ($user_info["pid"]){
			$up_user_info=Db::name("user")->where(array("id"=>$user_info["pid"]))->find();
			$up_user_agent=Db::name("agent")->where(array("id"=>$up_user_info["agent_class"]))->find();
			if ($up_user_agent){
				//更新上级提成
				$up_user_money=$data["reality_price"]*$up_user_agent["ratio1"];
				$save=array();
				$save["order_id"]=$order_id;
				$save["profit_id"]=$up_user_info["id"];
				$save["ratio"]=$up_user_agent["ratio1"];
				$save["create_time"]=$data["create_time"];
				$save["money"]=$up_user_money;
				$save["balance"]=$up_user_info["money"]+$up_user_money;
				$save["type"]="一级奖励";
				$save["cid"]="1";
				if($up_user_money>0)
				{
				Db::name("profit")->insert($save);
				}
				$save=array();
				$save["money"]=$up_user_info["money"]+$up_user_money;
				Db::name("user")->where(array("id"=>$up_user_info["id"]))->update($save);
				unset($save);
			}
			if ($up_user_info["pid"]){
				$second_user_info=Db::name("user")->where(array("id"=>$up_user_info["pid"]))->find();
				$second_user_agent=Db::name("agent")->where(array("id"=>$second_user_info["agent_class"]))->find();
				if ($second_user_agent){
					//更新二级上级提成
					$second_user_money=$data["reality_price"]*$second_user_agent["ratio2"];
					$save=array();
					$save["order_id"]=$order_id;
					$save["profit_id"]=$second_user_info["id"];
					$save["ratio"]=$second_user_agent["ratio2"];
					$save["create_time"]=$data["create_time"];
					$save["money"]=$second_user_money;
					$save["balance"]=$second_user_info["money"]+$second_user_money;
					$save["type"]="二级奖励";
					$save["cid"]="1";
					if($up_user_money>0)
					{
					Db::name("profit")->insert($save);
					}
					$save=array();
					$save["money"]=$second_user_info["money"]+$second_user_money;
					Db::name("user")->where(array("id"=>$second_user_info["id"]))->update($save);
					unset($save);
				}
			}
			//团队奖励开始
			$this->team($data["create_time"],$order_id,$data["price"],$data["reality_price"],$up_user_info["id"],0,0,0,0);
			$this->success('成功');
		}
	}
	/*
	//退回分成流程
	private function back($data,$order_id){
		$user_info=Db::name("user")->where(array("id"=>$data["user_id"]))->find();
		if ($user_info["pid"]){
			$up_user_info=Db::name("user")->where(array("id"=>$user_info["pid"]))->find();
			$up_user_agent=Db::name("agent")->where(array("id"=>$up_user_info["agent_class"]))->find();
			if ($up_user_agent){
				//更新上级提成
				$up_user_money=$data["reality_price"]*$up_user_agent["ratio1"];
				$save=array();
				$save["order_id"]=$order_id;
				$save["profit_id"]=$up_user_info["id"];
				$save["ratio"]=$up_user_agent["ratio1"];
				$save["create_time"]=time();
				$save["money"]=-$up_user_money;
				$save["balance"]=$up_user_info["money"];
				$save["type"]="退回一级奖励";
				$save["cid"]="0";
				Db::name("profit")->insert($save);
				$save=array();
				$save["money"]=$up_user_info["money"]-$up_user_money;
				Db::name("user")->where(array("id"=>$up_user_info["id"]))->update($save);
				unset($save);
			}
			if ($up_user_info["pid"]){
				$second_user_info=Db::name("user")->where(array("id"=>$up_user_info["pid"]))->find();
				$second_user_agent=Db::name("agent")->where(array("id"=>$second_user_info["agent_class"]))->find();
				if ($second_user_agent){
					//更新二级上级提成
					$second_user_money=$data["reality_price"]*$second_user_agent["ratio2"];
					$save=array();
					$save["order_id"]=$order_id;
					$save["profit_id"]=$second_user_info["id"];
					$save["ratio"]=$second_user_info["ratio2"];
					$save["create_time"]=time();
					$save["money"]=-$second_user_money;
					$save["balance"]=$second_user_info["money"];
					$save["type"]="退回二级奖励";
					$save["cid"]="0";
					Db::name("profit")->insert($save);
					$save=array();
					$save["money"]=$second_user_info["money"]-$second_user_money;
					Db::name("user")->where(array("id"=>$second_user_info["id"]))->update($save);
					unset($save);
				}
			}
		}
	}
	*/
	//新退回流程
	private function back($data,$order_id){
		$award_list=Db::name("profit")->where(array("order_id"=>$order_id))->select();
		
		foreach($award_list as $item){
			//更新退回
			unset($item["id"]);
			$user_info=Db::name("user")->where(array("id"=>$item["profit_id"]))->find();
			$save=array();
			$save["money"]=$user_info["money"]-$item["money"];
			$save["total_achievement"]=$user_info["total_achievement"];
			Db::name("user")->where(array("id"=>$user_info["id"]))->update($save);
			unset($save);
			
			
			//管锐修改，上面的余额已经改过来了，我只需要删除该订单对应的就可以了
			$item["money"]=-$item["money"];
			$item["type"]="退回".$item["type"];
			$item["cid"]=0;
			$item["balance"]=$user_info["money"]+$item["money"];
			Db::name("profit")->insert($item);
			
			
		}
		//Db::name("profit")->where(array("order_id"=>$order_id))->delete();
	}
	
	
	/*
	private function back($data,$order_id){
		$award_list=Db::name("profit")->where(array("order_id"=>$order_id))->select();
		
		foreach($award_list as $item){
			//更新退回
			unset($item["id"]);
			$user_info=Db::name("user")->where(array("id"=>$item["profit_id"]))->find();
			$save=array();
			$save["money"]=$user_info["money"]-$item["money"];
			$save["total_achievement"]=$user_info["total_achievement"]-$data["price"];
			Db::name("user")->where(array("id"=>$user_info["id"]))->update($save);
			unset($save);
			$profit=$this->profit_model->where(array("id"=>$item["id"]))->find();
			if ($this->order_model->destroy($id)) {
		
			
		}
		      
	}
	*/
	//团队奖励
	/*
	*order_id 						订单ID
	*price 							业绩金额
	*real_price 					实收金额
	*parent_id 						上级ID
	*is_level 						平级奖励是否占用
	*is_up 							封顶奖励是否占用
	*front_ratio					前一级比率
	*front_total_achievement		前一级总业绩
	*/
	private function team($times,$order_id,$price,$real_price,$parent_id,$is_level,$is_up,$front_ratio,$front_total_achievement){
		//提取用户信息
		$user_info=Db::name("user")->where(array("id"=>$parent_id))->find();
		//取小于DESC 10的用户参与分成
		$user_agent=Db::name("agent")->where(array("id"=>$user_info["agent_class"],"rank"=>array("lt",10)))->find();
		if ($user_agent){
			//判断当前用户层级
			if ($user_info["total_achievement"]>50000000){
				$team_ratio="team_ratio6";
			}elseif($user_info["total_achievement"]>24000000){
				$team_ratio="team_ratio5";
			}elseif($user_info["total_achievement"]>12000000){
				$team_ratio="team_ratio4";
			}elseif($user_info["total_achievement"]>6000000){
				$team_ratio="team_ratio3";
			}elseif($user_info["total_achievement"]>2000000){
				$team_ratio="team_ratio2";
			}else{
				$team_ratio="team_ratio1";
			}
			//获取当前分成比率
			$user_ratio=$user_agent[$team_ratio];
			if ($user_ratio>$front_ratio){
				//进行分成
				$current_ratio=$user_ratio-$front_ratio;
				$addition_money=$real_price*$current_ratio;
				$data=array();
				$data["order_id"]=$order_id;
				$data["profit_id"]=$parent_id;
				$data["ratio"]=$current_ratio;
				$data["create_time"]=$times;
				$data["money"]=$addition_money;
				$data["type"]="团队奖励";
				$data["cid"]=1;
				$data["balance"]=$user_info["money"]+$addition_money;
				if($addition_money>0)
				{
					Db::name("profit")->insert($data);
				}
				$save=array();
				$save["money"]=$user_info["money"]+$addition_money;
				Db::name("user")->where(array("id"=>$user_info["id"]))->update($save);
				//更新参数
				$front_ratio=$user_ratio;
			}else{
				//是否平级奖
				if (!$is_level){
					//得3%平级奖
					$current_ratio=0.03;
					$addition_money=$real_price*$current_ratio;
					$data=array();
					$data["order_id"]=$order_id;
					$data["profit_id"]=$parent_id;
					$data["ratio"]=$current_ratio;
					$data["create_time"]=$times;
					$data["money"]=$addition_money;
					$data["type"]="团队奖励-首次平级";
					$data["cid"]=1;
					$data["balance"]=$user_info["money"]+$addition_money;
					if($addition_money>0)
					{
						Db::name("profit")->insert($data);
					}
					$save=array();
					$save["money"]=$user_info["money"]+$addition_money;
					Db::name("user")->where(array("id"=>$user_info["id"]))->update($save);
					//更新参数
					$is_level=1;
				}else{
					//平级奖与顶级奖不可兼得
					//是否顶级奖
					if ($team_ratio=="team_ratio6"){
						if (!$is_up){
							if (($user["total_achievement"]-$front_total_achievement)>20000000){
								//得4%顶级奖
								$current_ratio=0.04;
								$addition_money=$real_price*$current_ratio;
								$data=array();
								$data["order_id"]=$order_id;
								$data["profit_id"]=$parent_id;
								$data["ratio"]=$current_ratio;
								$data["create_time"]=$times;
								$data["money"]=$addition_money;
								$data["type"]="团队奖励-首次顶级";
								$data["cid"]=1;
								$data["balance"]=$user_info["money"]+$addition_money;
								if($addition_money>0)
								{
								Db::name("profit")->insert($data);
								}
								$save=array();
								$save["money"]=$user_info["money"]+$addition_money;
								Db::name("user")->where(array("id"=>$user_info["id"]))->update($save);
								//更新参数
								$is_up=1;
							}
						}
					}
				}
			}
		}
		//进行业绩统计
		$front_total_achievement=$user_info["total_achievement"];
		$save=array();
		$save["total_achievement"]=$user_info["total_achievement"]+$price;
		Db::name("user")->where(array("id"=>$user_info["id"]))->update($save);
		if ($user_info["pid"]){
			//下一次循环
			$this->team($times,$order_id,$price,$real_price,$user_info["pid"],$is_level,$is_up,$front_ratio,$front_total_achievement);
		}
		
	}
}