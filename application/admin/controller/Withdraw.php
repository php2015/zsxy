<?php
namespace app\admin\controller;

use app\common\model\Withdraw as WithdrawModel;
use app\common\controller\AdminBase;
use think\Db;
use think\Session;

/**
 * 提现管理
 * Class Withdraw
 * @package app\admin\controller
 */
class Withdraw extends AdminBase
{

    protected $withdraw_model;
    protected function _initialize()
    {
        parent::_initialize();
        $this->withdraw_model = new WithdrawModel();
    }

    /**
     * 提现管理
     * @return mixed
     */
      public function index($keyword = '', $page = 1,$date1='',$date2='')
    {
	
		$where="1=1";

        if ($keyword) {
			$where = $where." and b.names LIKE '%".$keyword."%'";
        }
       
		
		if ($date2 == '') {
			$d2 = time();
        }else{
			$d2 = strtotime($date2);
		}
        if ($date1 != '') {
			$d1 = strtotime($date1);
            $where = $where." and a.create_time >= '".$d1."' and a.create_time <= '" . $d2 . "'";
        }
		
        $withdraw_list = $this->withdraw_model
		->alias("a")
		->field("a.*,b.names,b.bankname,b.phone,b.banknumber,b.wname,c.names as operator_name,b.id as uids")
		->join("__USER__ b",'a.user_id = b.id','LEFT')
		->join("__ADMIN_USER__ c",'a.operator = c.id','LEFT')
		->where($where)
		->order('a.id DESC')->paginate(15, false, ['query'=>request()->param()]);
		
		$map="status=1";
		$sum=$this->withdraw_model->alias("a")->where($map)->sum('a.money');
        return $this->fetch('index',  ['withdraw_list' => $withdraw_list, 'keyword' => $keyword, 'sum' => $sum, 'date1' => $date1,'date2' => $date2]);
    }
    /**
     * 添加提现
     * @param string $pid
     * @return mixed
     */
  
  public function add()
    {
		//用户
        $user_list = Db::name("user")->field("id,names")->order('id desc')->limit(15)->page(1)->select();
        $this->assign('user_list',$user_list);
		return $this->fetch();
    }


    public function findAll(){
        $page = input('page');
        $user_list = Db::name("user")->field("id,names")->order('id desc')->limit(15)->page($page)->select();
        return $user_list;
    }

    /**
     * 保存提现
     */
    public function save()
    {
        if ($this->request->isPost()) {
            $data            = $this->request->param();
			
            $validate_result = $this->validate($data, 'Withdraw');

            if ($validate_result !== true) {
                $this->error($validate_result);
            } else {
                $data["create_time"]=time();
				$data["operator"]=Session::get('admin_id');
				if ($this->withdraw_model->allowField(true)->save($data)) {
					//insert into sun_profit values (null,0,userid,0,nowtime,3998,体现,1111);
					
					//Db::name("user")->insert();
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
		$withdraw = $this->withdraw_model->find($id);
		$user_list=Db::name("user")->where('id','=',$withdraw['user_id'])->find();
	   	$this->assign("user_list",$user_list);
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
			   $data["update_time"]=time();	
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
			if ($user_info["money"] >= $info["money"]){
				$save=array();
				$save["money"]=$user_info["money"]-$info["money"];
				$yue=$save["money"];
				Db::name("user")->where(array("id"=>$user_info["id"]))->update($save);
				unset($save);
				$save=array();
				$save["status"]=1;
				$this->withdraw_model->where(array("id"=>$id))->update($save);
				
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