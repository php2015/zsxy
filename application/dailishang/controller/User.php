<?php
namespace app\dailishang\controller;

use app\common\model\User as UserModel;
use app\common\model\Agentzhuce as AgentzhuceModel;
use app\common\model\Chaxun as ChaxunModel;
use app\common\controller\AdminBaseDailishang;
use think\Config;
use think\Db;
use think\Session;
header("content-type:text/html;charset=utf-8");         //设置编码
/**
 * 用户管理
 * Class AdminUser
 * @package app\admin\controller
 */
class User extends AdminBaseDailishang
{
    protected $user_model;

    protected function _initialize()
    {
        parent::_initialize();
        $this->user_model = new UserModel();
        $this->chaxun_model = new ChaxunModel();
        $this->agentzhuce_model = new AgentzhuceModel();
    }
	public function tuiguang()
	{
		$dailishang_id = Session::get('dailishang_id');
		$yuming=$_SERVER['HTTP_HOST']; 
        $tuiguanglianjie = 'http://'.$yuming.'/index.php/index/login/daili/pid/'.$dailishang_id;
		 return $this->fetch('tuiguang', ['tuiguanglianjie' => $tuiguanglianjie]);
	}
    /**
     * 用户管理
     * @param string $keyword
     * @param int    $page
     * @return mixed
     */
    public function index($keyword = '', $page = 1,$date1='',$date2='',$tag=0)
    {
		$dailishang_id = Session::get('dailishang_id');
	
        $map = [];
        if ($keyword) {
            $map['a.names|a.mobile|a.idcard'] = ['like', "%{$keyword}%"];
        }
		$map['a.pid']=['=',$dailishang_id];
		$map['a.agent_class']=array('>',1);
		if ($date2=='') {
			$d2=time();
        }else
		{
			$d2=strtotime($date2);
		}
        if ($date1!='') {
			$d1=strtotime($date1);
            $map['a.create_time'] = array(array('>=',$d1),array('<=',$d2));
        }
		//SELECT a.*,b.agent_name FROM sun_user a,sun_agent b WHERE a.`agent_class`=b.`id`
        $user_list = $this->user_model
		->alias("a")
		->field("a.id,a.total_achievement,a.names,a.mid,CONCAT(LEFT(a.idcard,6),'********',RIGHT(a.idcard,4))as idcard,CONCAT(LEFT(a.mobile,3),'****',RIGHT(a.mobile,4)) AS mobile,a.status,a.create_time,a.province,a.city,a.pid,a.money,a.agent_class,a.note,a.password,a.thumb,b.agent_name,c.names pnames")
		->where($map)
		->join("__AGENT__ b","a.agent_class=b.id ",'LEFT')
		->join("__USER__ c",'a.pid=c.id','LEFT')
		->order('agent_class DESC')->order('create_time DESC')->paginate(15, false, ['query'=>request()->param()]);
		
		$count=$this->user_model->alias("a")->where($map)->count('a.id');
      	$zao=strtotime(date('Y-m-d',time()));
      	$wan=time();
      	$mapjin['a.create_time'] = array(array('>=',$zao),array('<=',$wan));
		$countjin=$this->user_model->alias("a")->where($map)->where($mapjin)->count('a.id');
		
		$mapyouxiao['a.total_achievement']=array('>','0');
		$countyouxiaojin=$this->user_model->alias("a")->where($map)->where($mapjin)->where($mapyouxiao)->count('a.id');
		$countyouxiao=$this->user_model->alias("a")->where($map)->where($mapyouxiao)->count('a.id');
		
		// 判定权限，是否有资格看到总业绩
		
		$dailishang=$this->user_model->where('id',$dailishang_id)->find();
		$agentzhuce=$this->agentzhuce_model->where('paid',$dailishang["agent_class"] )->where('tag','1' )->find();
		$isok=0;
		$agentyeji=0;
		if($agentzhuce)
		{
			$isok=1;
			$agentyeji=$agentzhuce["maid"];
		}
		//dump($isok);
        return $this->fetch('index', ['user_list' => $user_list,'keyword' => $keyword, 'count' => $count, 'countjin' => $countjin,'countyouxiao' => $countyouxiao,'countyouxiaojin' => $countyouxiaojin,'date1' => $date1,'date2' => $date2, 'isok' => $isok,'agentyeji'=>$agentyeji]);
    }
	
	
	 public function userindex($keyword = '', $page = 1,$date1='',$date2='',$tag=0)
    {
		$dailishang_id = Session::get('dailishang_id');
	
        $map = [];
        if ($keyword) {
            $map['a.names|a.mobile|a.idcard'] = ['like', "%{$keyword}%"];
        }
		$map['a.pid']=['=',$dailishang_id];
		$map['a.agent_class']=array('=',1);
		if ($date2=='') {
			$d2=time();
        }else
		{
			$d2=strtotime($date2);
		}
        if ($date1!='') {
			$d1=strtotime($date1);
            $map['a.create_time'] = array(array('>=',$d1),array('<=',$d2));
        }
		//SELECT a.*,b.agent_name FROM sun_user a,sun_agent b WHERE a.`agent_class`=b.`id`
        $user_list = $this->user_model
		->alias("a")
		->field("a.id,a.pingfeng,a.names,a.mid,CONCAT(LEFT(a.idcard,6),'********',RIGHT(a.idcard,4))as idcard,CONCAT(LEFT(a.mobile,3),'****',RIGHT(a.mobile,4)) AS mobile,a.status,a.create_time,a.province,a.city,a.pid,a.money,a.agent_class,a.note,a.password,a.thumb,b.agent_name,c.names pnames")
		->where($map)
		->join("__AGENT__ b","a.agent_class=b.id ",'LEFT')
		->join("__USER__ c",'a.pid=c.id','LEFT')
		->order('agent_class DESC')->order('create_time DESC')->paginate(15, false, ['query'=>request()->param()]);
		
		$count=$this->user_model->alias("a")->where($map)->count('a.id');
      	$zao=strtotime(date('Y-m-d',time()));
      	$wan=time();
      	$mapjin['a.create_time'] = array(array('>=',$zao),array('<=',$wan));
		$countjin=$this->user_model->alias("a")->where($map)->where($mapjin)->count('a.id');
		$mapyouxiao['a.pingfeng']=array('>','0');
		$countyouxiaojin=$this->user_model->alias("a")->where($map)->where($mapjin)->where($mapyouxiao)->count('a.id');
		$countyouxiao=$this->user_model->alias("a")->where($map)->where($mapyouxiao)->count('a.id');
		

        return $this->fetch('userindex', ['user_list' => $user_list,'keyword' => $keyword, 'count' => $count, 'countjin' => $countjin,'countyouxiao' => $countyouxiao,'countyouxiaojin' => $countyouxiaojin,'date1' => $date1,'date2' => $date2]);
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
				$html .= "<li>{$t['names']}</br> （{$t['agent_name']}）</li>";
				
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
     * 查看下级列表
     * @return userlist
     */
	public function selxia($id,$page = 1)
	{
	
	/*
		$user_list = $this->user_model
		->alias("a")
		->field("a.*,b.agent_name,c.names pnames")
		->where($map)
		->join("__AGENT__ b",'a.agent_class=b.id','LEFT')
		->join("__USER__ c",'a.pid=c.id','LEFT')
		->order('id DESC')->paginate(15, false, ['query'=>request()->param()]);
		
		*/
		$map = [];
       
            $map['a.pid'] = $id;
        
        $user_list = $this->user_model
		->alias("a")
		->field("a.id,a.names,a.mid,CONCAT(LEFT(a.idcard,6),'********',RIGHT(a.idcard,4))as idcard,CONCAT(LEFT(a.mobile,3),'****',RIGHT(a.mobile,4)) AS mobile,a.status,a.create_time,a.province,a.city,a.pid,a.money,a.agent_class,a.note,a.password,a.thumb,b.agent_name,c.names pnames")
		->where($map)
		->join("__AGENT__ b",'a.agent_class=b.id','LEFT')
		->join("__USER__ c",'a.pid=c.id','LEFT')
		->order('agent_class DESC')->paginate(15, false, ['query'=>request()->param()]);
		//dump($user_list);die;
        return $this->fetch('selxia', ['user_list' => $user_list]);
	}
	
	//业绩总
	public function getyeji($agentyeji)
	{
		//dump($agentyeji);
		$zao=date('Y-m-d',time());
      	$wan=date('Y-m-d H:i:s',time());
		//$zao='2019-03-03';
		
		$this->indexyeji($zao,$wan,$agentyeji);
	}
	
	public function indexyeji($date1='',$date2='',$agentyeji=0)
	{
		if($date1=='')
		{
			$date1=date('Y-m-d',time());
		}
		if($date2=='')
		{
			$date2=date('Y-m-d H:i:s',time());
		}
		
		$d1=strtotime ($date1);
		$d2=strtotime ($date2);
		
		$map="1=1 and dates>='".$d1."' and dates<='".$d2."' and b.agent_class='".$agentyeji."'";

		$chaxun_list  = $this->chaxun_model
		->alias("a")
		->field("a.`id`,a.`ordernumber`,a.`uid`,b.`names`,d.`agent_name`,a.`dates`,a.`pid`,c.`product_name`,a.`price`,a.`names` as namess,CONCAT(LEFT(a.idcard,6),'********',RIGHT(a.idcard,4))as idcard,CONCAT(LEFT(a.tel,3),'****',RIGHT(a.tel,4)) AS tel,e.names pnames,f.names manames,a.sheng,a.shi")
		->join("__USER__ b","a.ma_id=b.id","LEFT")
		->join("__PRODUCT__ c","a.pid=c.id","LEFT")
		->join("__AGENT__ d","b.agent_class=d.id","LEFT")
		->join("__USER__ e","b.pid=e.id","LEFT")
		->join("__USER__ f","c.uid=f.id","LEFT")
		->where($map)->order(['a.id' => 'DESC'])->paginate(15, false, ['query'=>request()->param()]);
		
		$chaxun_count  = $this->chaxun_model
		->alias("a")
		->field("a.`id`")
		->join("__USER__ b","a.ma_id=b.id","LEFT")
		->where($map)->count('a.id');
		
		return $this->fetch('indexyeji', ['chaxun_list' => $chaxun_list,  'date1' => $date1,'date2' => $date2,'agentyeji' => $agentyeji,'chaxun_count'=>$chaxun_count]);
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

		//代理商列表
		$agent_list=$this->user_model->where("agent_class",">","1")->select();
		$this->assign("agent_list",$agent_list);
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
				$data['create_time']=time();
				$provincenumber=substr($data['idcard'],0,2);
				$province=db('city')->where('citynumber','=',$provincenumber)->find();
				if(!$province){
				  $province['city_name']='湖北';
				}
				$citynumber=substr($data['idcard'],0,4);
				$city=db('city')->where('citynumber','=',$citynumber)->find();
				if(!$city){
				  $city['city_name']='武汉';
				}
				$data['province']=$province['city_name'];
				$data['city']=$city['city_name'];
				
				
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
		
		//用户
		$agent_list=$this->user_model->where("agent_class",">","1")->select();
		$this->assign("agent_list",$agent_list);

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
				
				if (!empty($data['password'])) {
                    $user->password = md5($data['password']);
                }
				
				
				$provincenumber=substr($data['idcard'],0,2);
				$province=db('city')->where('citynumber','=',$provincenumber)->find();
				if(!$province){
				  $province['city_name']='湖北';
				}
				$citynumber=substr($data['idcard'],0,4);
				$city=db('city')->where('citynumber','=',$citynumber)->find();
				if(!$city){
				  $city['city_name']='武汉';
				}
				$user->province=$province['city_name'];
				$user->city=$city['city_name'];
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
		//SELECT a.* FROM sun_city a,sun_city b WHERE a.pid=b.id AND b.city_name='湖北省'
		 $map['b.city_name'] = $cid;
		$city_list = Db::name('city')->alias("a")
			->field("a.*")
			->where($map)
			->join("__CITY__ b",'a.pid=b.id','LEFT')
			->select();
			
		if ($city_list){
			$str="";
			foreach ($city_list as $item){
				$str.="<option value=\"".$item["city_name"]."\">".$item["city_name"]."</option>\r\n";
			}
		}else{
			$str="<option value=\"\">该区域下暂无下级</option>";
		}
		echo $str;
	}
}