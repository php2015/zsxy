<?php
namespace app\admin\controller;

use app\common\model\User as UserModel;
use app\common\controller\AdminBase;
use think\Config;
use think\Db;
use think\Session;
header("content-type:text/html;charset=utf-8");         //设置编码
/**
 * 用户管理
 * Class AdminUser
 * @package app\admin\controller
 */
class User extends AdminBase
{
    protected $user_model;

    protected function _initialize()
    {
        parent::_initialize();
        $this->user_model = new UserModel();
    }

    /**
     * 用户管理
     * @param string $keyword
     * @param int    $page
     * @return mixed
     */
    public function index($keyword = '', $page = 1)
    {
        $map = [];
        if ($keyword) {
            $map['a.names|a.mobile|a.idcard'] = ['like', "%{$keyword}%"];
        }
        $user_list = $this->user_model
		->alias("a")
		->field("a.*,b.agent_name,c.names as operator_name,d.names as master_name,e.city_name as province_name,f.city_name")
		->where($map)
		->join("__AGENT__ b",'a.agent_class=b.id','LEFT')
		->join("__ADMIN_USER__ c",'a.operator=c.id','LEFT')
		->join("__ADMIN_USER__ d",'a.master_id=d.id','LEFT')
		->join("__CITY__ e",'a.province=e.id','LEFT')
		->join("__CITY__ f",'a.city=f.id','LEFT')
		->order('id DESC')->paginate(15, false, ['query'=>request()->param()]);
        return $this->fetch('index', ['user_list' => $user_list, 'keyword' => $keyword]);
    }
	
	public function getTree($data, $pId=0)
{
    $tree = '';
    foreach($data as $k => $v)
    {
        if($v['pid'] == $pId)
        { 
			
            $v['pid'] = $this->getTree($data, $v['id']);
            $tree[] = $v;
			
        }
    }
    return $tree;
}

    
   
public function procHtml($tree)
{
    $html = '';
	if($tree)
	{
		foreach($tree as $t)
		{
			if($t['pid'] == '')
			{
				$html .= "<li>{$t['id']}{$t['names']}</br> （{$t['agent_name']}）</li>";
				
			}
		
			else
			{
				//dump($t['pid']);
				$html .= "<li>{$t['id']}".$t['names']."</br>（".$t['agent_name']."）";
				$html .= $this->procHtml($t['pid']);
				$html = $html."</li>";
			}
		}
	}
    return $html ? '<ul id="organisation" style="display:none;">'.$html.'</ul>' : $html ;
}

    /**
     * 网络图显示
     */
    public function getAll($id)
    {
        //就写在这里
		 $user=db('user')
        ->alias("a")
        ->field('a.id,a.names ,b.agent_name,a.pid,a.pnames parent')
        ->join("__AGENT__ b",'a.agent_class=b.id','LEFT')
		//->where("a.id","=",$id)
        ->select();
		
		//$data=$user;
		$tree = $this->getTree($user);
		
        return $this->fetch('getall',['user' => $this->procHtml($tree)]);	
    }
	
    private function tim($id,$list)
    {
        
         $user=db('user')
        ->alias("a")
        ->field('a.id,a.names,b.agent_name,a.pid')
        ->join("__AGENT__ b",'a.agent_class=b.id','LEFT')
        ->where('a.pid','=',$id)
        ->select();
        $list=array();
            if($user)
            {
                dump($user);
                foreach ($user as $u => $data) 
                {
                    
                    $this->tim($data['id']);
                }
            }
       
       
    }
	/**
     * 查看上级列表
     * @return userlist
     */
	public function sel($id)
	{
		$user_list=array();
		
		 while($id!=0)
		 {
		 if(request()->isPost()){
		 $uid=input(keyword);
		 }
		 	//Userinfo user=select userid,username,user..... from userinfo where pid=$id;
			//$user=db('user')->where(array("id"=>$id))->select();
			 $map = [];
        
            $map['a.id'] = $id;
			 $user = $this->user_model
			
        
		->alias("a")
		->field("a.*,b.agent_name,c.names as operator_name,d.names as master_name,e.city_name as province_name,f.city_name")
		->where($map)
		->join("__AGENT__ b",'a.agent_class=b.id','LEFT')
		->join("__ADMIN_USER__ c",'a.operator=c.id','LEFT')
		->join("__ADMIN_USER__ d",'a.master_id=d.id','LEFT')
		->join("__CITY__ e",'a.province=e.id','LEFT')
		->join("__CITY__ f",'a.city=f.id','LEFT')->select();
		
			$id=$user[0]["pid"];
			
			//userList.add(userinfo);
			$user_list[]=$user;
		 }
		//dump($user_list);
        return $this->fetch('sel', ['user_list' => $user_list]);
	}
	/**
     * 批量减少业绩
     * @return userlist
    */
	
	public function jian($id)
	{
		$user_list=array();
		$i=1;
		 while($id!=0)
		 {
		 if(request()->isPost()){
		 $uid=input(keyword);
		 }
		 	//Userinfo user=select userid,username,user..... from userinfo where pid=$id;
			//$user=db('user')->where(array("id"=>$id))->select();
			 $map = [];
        
            $map['a.id'] = $id;
			 $user = $this->user_model
			->alias("a")
			->field("a.*,b.agent_name,c.names as operator_name,d.names as master_name,e.city_name as province_name,f.city_name")
			->where($map)
			->join("__AGENT__ b",'a.agent_class=b.id','LEFT')
			->join("__ADMIN_USER__ c",'a.operator=c.id','LEFT')
			->join("__ADMIN_USER__ d",'a.master_id=d.id','LEFT')
			->join("__CITY__ e",'a.province=e.id','LEFT')
			->join("__CITY__ f",'a.city=f.id','LEFT')->select();
		
		
			$id=$user[0]["pid"];
			//$userment=$user[0]["total_achievement"];
			//dump($userment.$id);
			
			//$data=['total_achievement'=>'total_achievement-1'];
			
			Db::name('user')->where('id='.$id)->setDec('total_achievement',3998);
			/////////////////////////////////////////////////////////////////
			/////////////////////////////////////////////////////////////////
			/////////////////////////////////////////////////////////////////
			/////////////////////////////////////////////////////////////////
			/////////////////////////////////////////////////////////////////
		
			
			//userList.add(userinfo);
			$user_list[]=$user;
			
		 }
		//dump($user_list);
		$this->success('保存成功');
       // return $this->fetch('sel', ['user_list' => $user_list]);
	}
	 
	
    /**
     * 添加用户
     * @return mixed
     */
    public function add()
    {
		//地址
		$city_list = Db::name('city')->where(array("pid"=>0))->select();
		$this->assign("city_list",$city_list);
		//管理员
		$admin_list=Db::name("admin_user")->select();
		$this->assign("admin_list",$admin_list);
		//级别
		$agent_list=Db::name("agent")->select();
		$this->assign("agent_list",$agent_list);
		//用户
		$user_list=$this->user_model->select();
		$this->assign("user_list",$user_list);
		return $this->fetch();
    }

    /**
     * 保存用户
     */
    public function save()
    {
        if ($this->request->isPost()) {
            $data            = $this->request->post();
            $validate_result = $this->validate($data, 'User');

            if ($validate_result !== true) {
                $this->error($validate_result);
            } else {
                $data["mid"]=$this->new_mid();
				if ($data["pid"]!=0){
					$info=Db::name("user")->where(array("id"=>$data["pid"]))->find();
					$data["pnames"]=$info["names"];
				}
				$data["operator"] = Session::get('admin_id');
				if (isset($data['password'])){
					$data['password'] = md5($data['password']);
				}else{
					$data['password'] = md5('123456');
				}
				if ($this->user_model->allowField(true)->save($data)) {
                    $this->success('保存成功');
                } else {
                    $this->error('保存失败');
                }
            }
        }
    }

    /**
     * 编辑用户
     * @param $id
     * @return mixed
     */
    public function edit($id)
    {
        $user = $this->user_model->find($id);
		//地址
		$province_list = Db::name('city')->where(array("pid"=>0))->select();
		$this->assign("province_list",$province_list);
		$city_list = Db::name('city')->where(array("pid"=>$user["province"]))->select();
		$this->assign("city_list",$city_list);
		//管理员
		$admin_list=Db::name("admin_user")->select();
		$this->assign("admin_list",$admin_list);
		//级别
		$agent_list=Db::name("agent")->select();
		$this->assign("agent_list",$agent_list);
		//用户
		$user_list=$this->user_model->select();
		$this->assign("user_list",$user_list);

        return $this->fetch('edit', ['user' => $user]);
    }

    /**
     * 更新用户
     * @param $id
     */
    public function update($id)
    {
        if ($this->request->isPost()) {
            $data            = $this->request->post();
            $validate_result = $this->validate($data, 'User');

            if ($validate_result !== true) {
                $this->error($validate_result);
            } else {
                $user           = $this->user_model->find($id);
                $user->id       = $id;
                $user->names = $data['names'];
                $user->mobile   = $data['mobile'];
                $user->idcard    = $data['idcard'];
                $user->pid    = $data['pid'];
				if ($data["pid"]!=0){
					$info=Db::name("user")->where(array("id"=>$data["pid"]))->find();
					$user->pnames=$info["names"];
				}else{
					$user->pnames = array('exp','null');
				}
				if (!empty($data['password'])) {
                    $user->password = md5($data['password']);
                }
				$user->agent_class=$data['agent_class'];
				$user->money=$data['money'];
				$user->province=$data['province'];
				$user->city=$data['city'];
				$user->type=$data['type'];
				$user->master_id=$data['master_id'];
				$user->note=$data['note'];
                $user->status   = $data['status'];
                if ($user->save() !== false) {
                    $this->success('更新成功');
                } else {
                    $this->error('更新失败');
                }
            }
        }
    }

    /**
     * 删除用户
     * @param $id
     */
    public function delete($id)
    {
        if ($this->user_model->destroy($id)) {
            $this->success('删除成功');
        } else {
            $this->error('删除失败');
        }
    }
	private function new_mid(){
		$max=$this->user_model->max("id");
		if (!$max){
			$max=0;
		}
		$max++;
		$max+=10000;
		$new_mid="M00".$max;
		return $new_mid;
	}
	/*
	*AJAX城市
	*/
	public function ajax_city(){
		$cid=$_POST["cid"];
		$city_list = Db::name('city')->where(array("pid"=>$cid))->select();
		if ($city_list){
			$str="";
			foreach ($city_list as $item){
				$str.="<option value=\"".$item["id"]."\">".$item["city_name"]."</option>\r\n";
			}
		}else{
			$str="<option value=\"\">该区域下暂无下级</option>";
		}
		echo $str;
	}
}