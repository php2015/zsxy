<?php
namespace app\admin\controller;

use app\common\model\Shenhe as ShenheModel;
use app\common\model\Agent as AgentModel;
use app\common\model\User as UserModel;
use app\common\controller\AdminBase;
use think\Config;
use think\Db;
use think\Session;
header("content-type:text/html;charset=utf-8");         //设置编码
/**
 * 商品管理
 * Class AdminUser
 * @package app\admin\controller
 */
class Shenhe extends AdminBase
{
    protected $shenhe_model;
    protected $user_model;
    protected $agent_model;

    protected function _initialize()
    {
        parent::_initialize();
        $this->shenhe_model = new ShenheModel();
        $this->shenhe1_model = new ShenheModel();
        $this->user_model = new UserModel();
        $this->agent_model = new AgentModel();
		
    }

    /**
     * 商品管理
     * @param string $keyword
     * @param int    $page
     * @return mixed
     */
    public function index($keyword = '', $page = 1)
    {
	
	
        $map = [];
        if ($keyword) {
            $map['a.uname|a.sname'] = ['like', "%{$keyword}%"];
        }
         $shenhe_list = $this->shenhe_model
		->alias("a")
		->field("a.*,d.agent_name agent1,e.agent_name agent2")
		->join("__AGENT__ d",'a.oldagent=d.id','LEFT')
		->join("__AGENT__ e",'a.newagent=e.id','LEFT')
		->where($map)
		
		->order('id DESC')->paginate(8, false, ['query'=>request()->param()]);
		
		$count=$this->shenhe_model->alias("a")->where($map)->count('a.id');
		
		//dump($count);die;
        return $this->fetch('index', ['shenhe_list' => $shenhe_list, 'keyword' => $keyword, 'count' => $count]);
		
		
    }
	
    public function title($id)
    {
        $id=input('id');
        $title=db('shenhe')->where('id','=',$id)->order('id','=',$id)->find();
        $title['content']= htmlspecialchars_decode($title['content']);
        return $title;
    }

	
	
	
	
	
    /**
     * 添加商品
     * @return mixed
     */
    public function add()
    {
		//地址
		$agent_list = Db::name('agent')->select();
		$this->assign("agent_list",$agent_list);
		$user_list=Db::name("user")->select();
		$this->assign("user_list",$user_list);
		return $this->fetch();
    }
	
	public function guoshen()
	{
		$id=input('id');
		//这里要改，改成 过审是找指定的人，并且等级是上一级
		$shenhe           = $this->shenhe_model->find($id);
		$shenhe->state    = 1;
		 if ($shenhe->save() !== false) 
		 {
		 	//检查是否还有审核没过，是需要审核2次，还是1次
		 	$jiancha=$this->shenhe_model->where(array("uid"=>$shenhe["uid"],"state"=>0))->find();
			if($jiancha)
			{
				
			}else
			{
				$up=array();
				$up["agent_class"]=$shenhe["newagent"];
				Db::name("user")->where(array("id"=>$shenhe["uid"]))->update($up);
				unset($up);
			}
		 	//如果是一星，则向上所有人团队人数加一
			if($shenhe["newagent"]==1)
			{
				$user=$this->user_model->where(array("id"=>$shenhe["uid"]))->find();
				$this->upup($user["pid"]);
			}
         	$this->success('审核成功');
         	//return 1;
         } else {
         	$this->error('审核失败');
         	//return 0;
         }
	}
	
	//向上所有人团队都加1
	public function upup($pid)
	{
		if($pid!=1)
		{
			$user=$this->user_model->where(array("id"=>$pid))->find();
			$user["teams"]=$user["teams"]+1;
			$user->save();
			$this->upup($user["pid"]);
		}
	}
	
	//申请升级，检查可申请的次数，检查团队，检查是否有正在审核的
	public function shenqing()
	{
		//获取该用户信息
		$uid=input('uid');
		//return $uid;
		//dump($uid);die;
		$user=$this->user_model->alias("a")
		->field("a.*,b.star")
		->join("__AGENT__ b",'a.agent_class=b.id','LEFT')
		->where(array("a.id"=>$uid))->find();
		//获取客户当前等级和要升的等级
		$pstar=$user["star"]+1;
		$newagent=$this->agent_model->where(array("star"=>$pstar))->find();
		if($user["numb"]<$newagent["marks"])
		{
			$this->error('可用申请次数不够');
			//return 0;
		}
		else
		{
			//检查是否有正在审的
			$jiancha=$this->shenhe_model->where(array("uid"=>$user["id"],"state"=>0))->find();
			if(!$jiancha)
			{
				
				
				//检查是否达到条件//找到对应的上级
				if($user["teams"]>=$newagent["tiaojian"])
				{
					if($newagent["marks"]==2)
					{
						$user["numb"]=$user["numb"]-1;
						$user->save();
						$data1["uid"]=$uid;
						$data1["uname"]=$user["names"];
						$upuser=$this->user_model->where(array("id"=>$user["pid"]))->find();
						$data1["sid"]=$upuser["id"];
						$data1["sname"]=$upuser["names"];
						$data1["state"]=0;
						$data1["fen"]=0;
						$data1["oldagent"]=$user["agent_class"];
						$data1["newagent"]=$newagent["id"];
						$data1["marks"]="";
						$data1["create_time"]=time();
						$this->shenhe1_model->allowField(true)->save($data1);
						
					}
					
					$user["numb"]=$user["numb"]-1;
					$user->save();
					$pandingstar=$user["star"]+$newagent["rank"];
					$newagenttiaojian=$newagent["tiaojian"];
					$this->selectrank($user["pid"],$uid,$user["names"],$user["agent_class"],$user["pid"],$pandingstar,$newagent);
					//return 1;
					$this->success('申请成功');
				}
				else
				{
					$this->error('团队人数不够');
					//return 2;
				}
			}
			else
			{
					$this->error('您还有待审核的');
					//return 3;
			}
		}
		
		//检查上级是否给他审过
		//过审改等级
	}
	//找符合条件的上级，返回该上级的信息
	public function selectrank($shangjiid,$uid,$uname,$oldagent,$pid,$pandingstar,$newagent)
	{
		$puser=$this->user_model
		->alias("a")
		->field("a.*,b.star")
		->join("__AGENT__ b",'a.agent_class=b.id','LEFT')
		->where(array("a.id"=>$pid))->find();
		
		if($puser["id"]==1)
		{
				return;
		}
		
		if($puser["star"]>=$pandingstar)//如果满足申请条件
		{
			if($this->shenhe_model->where(array("uid"=>$uid,"sid"=>$puser["id"],"state"=>1))->find())
			{
				$this->selectrank($shangjiid,$uid,$uname,$oldagent,$puser["pid"],$pandingstar,$newagent);
			}else
			{
				//提交到这里来，插入一条记录
				if($shangjiid==$puser["id"])
				{
					$this->selectrank($shangjiid,$uid,$uname,$oldagent,$puser["pid"],$pandingstar,$newagent);
				}
				else
				{
					$data["uid"]=$uid;
					$data["uname"]=$uname;
					$data["sid"]=$puser["id"];
					$data["sname"]=$puser["names"];
					$data["state"]=0;
					$data["fen"]=0;
					$data["oldagent"]=$oldagent;
					$data["newagent"]=$newagent["id"];
					$data["marks"]="2次";
					$data["create_time"]=time();
					$this->shenhe_model->allowField(true)->save($data);
				}
				
			}
				
		}else
		{
				$this->selectrank($shangjiid,$uid,$uname,$oldagent,$puser["pid"],$pandingstar,$newagent);
		}
		
	}
	
	
	
	public function chaping($id)
	{
		$shenhe           = $this->shenhe_model->find($id);
		$shenhe->fen    = 2;
		 if ($shenhe->save() !== false) {
         	$this->success('处理成功');
         } else {
         	$this->error('处理失败');
         }
	}

    /**
     * 保存商品
     */
    public function save()
    {
        if ($this->request->isPost()) {
            $data            = $this->request->post();
            $validate_result = $this->validate($data, 'Shenhe');

            if ($validate_result !== true) {
                $this->error($validate_result);
            } else {
               	if ($data["uid"]!=0){
					$info=Db::name("user")->where(array("id"=>$data["uid"]))->find();
					$data["uname"]=$info["names"];
					if($info["numb"]<1)
					{
						$this->error('该用户可申请次数不够');
					}
					else
					{
						$user=$this->user_model->where(array("id"=>$data["uid"]))->find();
						$user->numb    = $user["numb"]-1;
						$user->save();
					}				
				}
				if ($data["sid"]!=0){
					$info=Db::name("user")->where(array("id"=>$data["sid"]))->find();
					$data["sname"]=$info["names"];
				}
				$data["create_time"]=time();
				
				$data["state"]=0;
              
				if ($this->shenhe_model->allowField(true)->save($data)) {
                    $this->success('保存成功');
                } else {
                    $this->error('保存失败');
                }
            }
        }
    }

    /**
     * 编辑商品
     * @param $id
     * @return mixed
     */
    public function edit($id)
    {
        $shenhe = $this->shenhe_model->find($id);
		
		//商品type
		$user_list=Db::name("user")->select();
		$this->assign("user_list",$user_list);
		

        return $this->fetch('edit', ['shenhe' => $shenhe]);
    }

    /**
     * 更新商品
     * @param $id
     */
    public function update($id)
    {
	
        if ($this->request->isPost()) {
            $data            = $this->request->post();
            $validate_result = $this->validate($data, 'Shenhe');

            if ($validate_result !== true) {
                $this->error($validate_result);
            } else {
			
			 	
			    $shenhe           = $this->shenhe_model->find($id);
                $shenhe->id       = $id;
				if ($data["uid"]!=0){
					$info=Db::name("user")->where(array("id"=>$data["uid"]))->find();
					$shenhe->uname=$info["names"];
				}
				if ($data["sid"]!=0){
					$info=Db::name("user")->where(array("id"=>$data["sid"]))->find();
					$shenhe->sname=$info["names"];
				}
               	$shenhe->titles    = $data['titles'];
                $shenhe->type    = $data['type'];
                $shenhe->money    = $data['money'];
                $shenhe->category_id    = $data['category_id'];
                $shenhe->hott    = $data['hott'];
                $shenhe->news    = $data['news'];
                $shenhe->weigh    = $data['weigh'];
                $shenhe->status    = $data['status'];
                $shenhe->content    = $data['content'];
				
				
				if(strstr($data["thumb"],"http")==null && strstr($data["thumb"],"public")==null)
				{
					$data["thumb"]="/public".$data["thumb"];
				}
				 $shenhe->thumb   = $data['thumb'];
                if ($shenhe->save() !== false) {
                    $this->success('更新成功');
                } else {
                    $this->error('更新失败');
                }
				
            }
        }
		
    }

    /**
     * 删除商品
     * @param $id
     */
    public function delete($id)
    {
        if ($this->shenhe_model->destroy($id)) {
            $this->success('删除成功');
        } else {
            $this->error('删除失败');
        }
    }
	
}