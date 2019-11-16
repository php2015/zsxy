<?php
namespace app\dailishang\controller;

use app\common\model\Withdraw as WithdrawModel;
use app\common\model\User as UserModel;
use app\common\controller\AdminBaseDailishang;
use think\Db;
use think\Session;

/**
 * 提现管理
 * Class Withdraw
 * @package app\admin\controller
 */
class Withdraw extends AdminBaseDailishang
{

    protected $withdraw_model;
    protected function _initialize()
    {
        parent::_initialize();
        $this->withdraw_model = new WithdrawModel();
        $this->user_model = new UserModel();
    }

    /**
     * 提现管理
     * @return mixed
     */
      public function index( $page = 1,$date1='',$date2='')
    {
		$dailishang_id = Session::get('dailishang_id');
		$where="1=1";
		$where=$where." and user_id='".$dailishang_id."'";
		if ($date2=='') {
			$d2=time();
        }else
		{
			$d2=strtotime($date2);
		}
        if ($date1!='') {
			$d1=strtotime($date1);
            $where=$where." and a.create_time>='".$d1."' and a.create_time<='".$d2."'";
        }
		
        $withdraw_list = $this->withdraw_model
		->alias("a")
		->field("a.*,b.names,b.bankname,b.phone,b.banknumber,c.names as operator_name")
		->join("__USER__ b",'a.user_id=b.id','LEFT')
		->join("__ADMIN_USER__ c",'a.operator=c.id','LEFT')
		->where($where)
		->order('a.id DESC')->paginate(15, false, ['query'=>request()->param()]);
		
		$map="status=1";
		$sum=$this->withdraw_model->alias("a")->where($map)->where($where)->sum('a.money');
        return $this->fetch('index',  ['withdraw_list' => $withdraw_list,  'sum' => $sum, 'date1' => $date1,'date2' => $date2]);
    }

    public function add()
    {
		//用户
		$dailishang_id = Session::get('dailishang_id');
		$user = $this->user_model->find($dailishang_id);
		$this->assign("user",$user);
		return $this->fetch();
    }

    /**
     * 保存提现
     */
    public function save()
    {
		$dailishang_id = Session::get('dailishang_id');
        if ($this->request->isPost()) {
            $data            = $this->request->param();
            
            
             //查询是否有正在审核的订单
        		$sta=db('withdraw')->where('user_id','=',$dailishang_id)->where('status','=','0')->find();
        		if(!empty($sta)){
        				 $this->success('您有待审核的订单');
        		}
        		
        	    $count = db('withdraw')->where('create_time','between',[mktime(0,0,0,date("m"),date("d"),date("Y")),time()])->where('user_id','=',$dailishang_id)->count();
        	    
        	    if($count == 3){
        	    	 $this->success('当天提现不可超过3笔');
        	    }
        		
        		$count = db('withdraw')->where('create_time','between',[mktime(0,0,0,date("m"),date("d"),date("Y")),mktime(23,59,59,date("m"),date("d"),date("Y"))])->count();
        		
        		if(empty($data["type"])){
        			$this->success('类型不能为空，银行卡或支付宝');
        		}
        		
        		if(empty($data["namesss"])){
        				 $this->success('姓名不能为空');
        		}
        		
        		if(empty($data["bankcard"])){
        				$this->success('提现到账卡号不能为空');
        		}
        		
        		if(empty($data['telsss'])){
        				$this->success('手机号码不能为空');
        		}
        		
         		if($data["money"]>$data["ketixian"])
				{
					 $this->success('超出可提现余额');
				}else if($data["money"]<50){
					$this->success('最低提现50元');
				}else{
					$data["create_time"] = time();
					$data["user_id"] = $dailishang_id;
					$save = array();
					$save['wname'] = $data["namesss"];
					
					if(!empty($data['type']) && $data['type'] == '支付宝'){
        				$save["bankname"] = $data["bankcard"];
        			}else{
        				$save["banknumber"] = $data["bankcard"];
        			}
					$save["phone"] = $data["telsss"];
					$save["update_time"] = time();
					Db::name("user")->where(array("id"=>$dailishang_id))->update($save);
					if ($this->withdraw_model->allowField(true)->save($data)) {
						$this->success('保存成功');
					} else {
						$this->error('保存失败');
					}
				}
            
        }
    }

    /**
     * 编辑提现
     * @param $id
     * @return mixed
     */
    public function edit($id)
    {
        //用户
		$user_list=Db::name("user")->field("id,names")->select();
		$this->assign("user_list",$user_list);
		
		$withdraw = $this->withdraw_model->find($id);

        return $this->fetch('edit', ['withdraw' => $withdraw]);
    }

    /**
     * 更新提现
     * @param $id
     */
    public function update($id)
    {
        if ($this->request->isPost()) {
            $data            = $this->request->param();
            $validate_result = $this->validate($data, 'Withdraw');

            if ($validate_result !== true) {
                $this->error($validate_result);
            } else {
				
               if ($this->withdraw_model->allowField(true)->save($data, $id) !== false) {
                     $this->success('更新成功');
               } else {
                     $this->error('更新失败');
               }
            }
        }
    }

    /**
     * 删除提现
     * @param $id
     */
    public function delete($id)
    {
        if ($this->withdraw_model->destroy($id)) {
            $this->success('删除成功');
        } else {
            $this->error('删除失败');
        }
    }
	//支付处理
	public function pay($id){
		$info=$this->withdraw_model->where(array("id"=>$id))->find();
		$user_info=Db::name("user")->where(array("id"=>$info["user_id"]))->find();
		if ($user_info){
			if ($user_info["money"]>=$info["money"]){
				$save=array();
				$save["money"]=$user_info["money"]-$info["money"];
				$yue=$save["money"];
				Db::name("user")->where(array("id"=>$user_info["id"]))->update($save);
				unset($save);
				$save=array();
				$save["status"]=1;
				$this->withdraw_model->where(array("id"=>$id))->update($save);
				
				/*
				id=null,
				orderid=$id=提现的id
				profit_id=$info["user_id"]
				ratio=0,
				create_time=当前时间
				money=$info["money"];
				type=提现
				cid=0
				balance=$yue
				*/
				$data=[
				'order_id'=>$id+100000,
				'profit_id'=>$info["user_id"],
				'ratio'=>0,
				'create_time'=>time(),
				'money'=>$info["money"],
				'type'=>'提现',
				'balance'=>$yue
				];
				Db::name("profit")->insert($data);
				$this->success('支付成功');
			}else{
				$this->error("用户余额不足，支付失败！");
			}
		}
	}
}