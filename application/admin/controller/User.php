<?php
namespace app\admin\controller;

use app\common\model\User as UserModel;
use app\common\controller\AdminBase;
use think\Config;
use think\Db;
use think\Session;

use PHPExcel_IOFactory;
use PHPExcel;
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
    public function index($keyword = '', $page = 1,$date1='',$date2='',$tag=0,$pingfeng=0)
    {
       	$map = [];
		if($keyword){
			$map['a.names|a.mobile|a.idcard|a.id'] = ['like',"%{$keyword}%"];
		}
		$map1 = [];
		
		if(empty($keyword)){
				if(!empty($date1)){
			$d1=strtotime($date1);
            $map['a.create_time'] = [['>=',$d1],['<=',time()]];
        	}
        
        	if(!empty($date2)){
				$d2=strtotime($date2);
				$map['a.create_time'] = [['>=',!empty($d1)?$d1:0],['<=',$d2]];
        	}
        
        	if(empty($date1) && empty($date2)){
        		$map['a.create_time'] = [['>=',strtotime('-15 day',time())],['<=',time()]];
        	}
		}
	
        if(isset($pingfeng) && $pingfeng == 1){
        	$order = 'a.pingfeng desc';
        }else{
        	$order = 'a.id desc';
        }
        
        
        
		$map['a.agent_class']=array('=',1);
	
        $user_list = $this->user_model
		->alias("a")
		->field("a.*,b.agent_name,c.names pnames")
		->where($map)
		->join("__AGENT__ b","a.agent_class = b.id ",'LEFT')
		->join("__USER__ c",'a.pid = c.id','LEFT')
		->order($order)->paginate(15, false, ['query'=>request()->param()]);


		$count=$this->user_model->alias("a")->where($map)->count('a.id');
      	$zao=strtotime(date('Y-m-d',time()));
      	$wan=time();
      	$mapjin['a.create_time'] = array(array('>=',$zao),array('<=',$wan));
		$mapyouxiao['a.pingfeng']=array('>','0');
		$countyouxiaojin=$this->user_model->alias("a")->where($map)->where($mapjin)->where($mapyouxiao)->count('a.id');
		$countjin=$this->user_model->alias("a")->where($map)->where($mapjin)->count('a.id');
		$countyouxiao=$this->user_model->alias("a")->where($map)->where($mapyouxiao)->count('a.id');
		
		
        return $this->fetch('index', ['user_list' => $user_list,'keyword' => $keyword, 'count' => $count, 'countyouxiao' => $countyouxiao, 'countjin' => $countjin, 'countyouxiaojin' => $countyouxiaojin,'date1' => $date1,'date2' => $date2]);
    }
	
	
	
	
	public function excel($keyword = '',$date1='',$date2=''){
		
		 $map = [];
        if ($keyword) {
            $map['a.names|a.mobile|a.idcard'] = ['like', "%{$keyword}%"];
        }
		$map1 = [];
		
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
		$map['a.agent_class']=array('=',1);
        $user_list = $this->user_model
		->alias("a")
		->field("a.*,b.agent_name,c.names pnames")
		->where($map)
		->join("__AGENT__ b","a.agent_class=b.id ",'LEFT')
		->join("__USER__ c",'a.pid=c.id','LEFT')
		->order('id DESC')->select();
		//dump(count($user_list));die;
		vendor("PHPExcel.PHPExcel");
		vendor("PHPExcel.PHPExcel.Writer.Excel5");
		vendor("PHPExcel.PHPExcel.Writer.Excel2007");
		vendor("PHPExcel.PHPExcel.IOFactory");
		$objPHPExcel=new PHPExcel();
		$objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('A1', 'ID')
            ->setCellValue('B1', '姓名')
            ->setCellValue('C1', '手机')
            ->setCellValue('D1', '身份证')
            ->setCellValue('E1', '城市')
            ->setCellValue('F1', '创建时间')
            ->setCellValue('G1', '推荐人')
            ->setCellValue('H1', '有效');
		
		
		if ($user_list){
			$i=2;  //定义一个i变量，目的是在循环输出数据是控制行数
			$count = count($user_list);  //计算有多少条数据
			for ($i = 2; $i <= $count+1; $i++) {
				$objPHPExcel->getActiveSheet()->setCellValue('A' . $i, $user_list[$i-2]["id"]);
				$objPHPExcel->getActiveSheet()->setCellValue('B' . $i, $user_list[$i-2]["names"]);
				$objPHPExcel->getActiveSheet()->setCellValue('C' . $i, $user_list[$i-2]["mobile"]);
				$objPHPExcel->getActiveSheet()->setCellValue('D' . $i, "'".$user_list[$i-2]["idcard"]."'");
				$objPHPExcel->getActiveSheet()->setCellValue('E' . $i, $user_list[$i-2]["city"]);
				$objPHPExcel->getActiveSheet()->setCellValue('F' . $i, date('Y-m-d H:i:s',$user_list[$i-2]["create_time"]));
				$objPHPExcel->getActiveSheet()->setCellValue('G' . $i, $user_list[$i-2]["pnames"]);
				$objPHPExcel->getActiveSheet()->setCellValue('H' . $i, $user_list[$i-2]["pingfeng"]);

			}
		}	
		$objPHPExcel->getActiveSheet()->setTitle('用户');      //设置sheet的名称
        $objPHPExcel->setActiveSheetIndex(0);                   //设置sheet的起始位置
        $objWriter = \PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');   //Excel2003通过PHPExcel_IOFactory的写函数将上面数据写出来
        $PHPWriter = \PHPExcel_IOFactory::createWriter( $objPHPExcel,"Excel2007"); //Excel2007
        header('Content-Disposition: attachment;filename="用户.xlsx"');
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        $PHPWriter->save("php://output"); //表示在$path路径下面生成demo.xlsx文件
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
			//$user_list["create_time"]=strtotime($user["create_time"]);
			//userList.add(userinfo);
			$user_list[]=$user;
		 }
		//dump($user_list);
        return $this->fetch('sel', ['user_list' => $user_list]);
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
		->field("a.*,b.agent_name,c.names pnames")
		->where($map)
		->join("__AGENT__ b",'a.agent_class=b.id','LEFT')
		->join("__USER__ c",'a.pid=c.id','LEFT')
		->order('id DESC')->paginate(15, false, ['query'=>request()->param()]);
		//dump($user_list);die;
        return $this->fetch('selxia', ['user_list' => $user_list]);
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
				$data["password"]= md5($data['password']. Config::get('salt'));
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
                    $this->success($data["password"]);
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
		$agent_list=$this->user_model->where("agent_class",">","1")->limit(0,1000)->select();
	
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
               // $user->idcard    = $data['idcard'];
                $user->pid    = $data['pid'];
				
				if (!empty($data['password'])) {
                    $user->password = md5($data['password']. Config::get('salt'));
                }
				
				/* if(isset($data['idcard'])){
                  $provincenumber=substr($data['idcard'],0,2);
                }else{
                	$provincenumber = '';
                }
				$province=db('city')->where('citynumber','=',$provincenumber)->find();
				if(!$province){
				  $province['city_name']='湖北';
				}
              if(isset($data['idcard'])){
                 $citynumber=substr($data['idcard'],0,4);
                }else{
                	$citynumber = '';
                }
				$city=db('city')->where('citynumber','=',$citynumber)->find();
				if(!$city){
				  $city['city_name']='武汉';
				}
				$user->province=$province['city_name'];
				$user->city=$city['city_name'];
                */
				$user->note=$data['note'];
                $user->status   = $data['status'];
              	$user->create_time = time();
                if ($user->save() !== false) {
                    $this->success('更新成功');
                } else {
                    $this->error('更新失败');
                }
            }
        }
    }
  
  /**
  *  更新
  */
   public function iswx($id){
        if ($this->request->isPost()) {
                $iswx = input('iswx');
                $user           = $this->user_model->find($id);
                $user->id       = $id;
                $user->iswx = $iswx;
                if ($user->save() !== false) {
                    $this->success('更新成功');
                } else {
                    $this->error('更新失败');
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