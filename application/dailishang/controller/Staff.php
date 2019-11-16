<?php
namespace app\dailishang\controller;

use app\common\controller\AdminBaseDailishang;
use \app\common\model\User as UserModel;
use think\Db;
use think\Session;
use think\Config;
/**
 * 订单管理
 * Class Chaxun
 * @package app\admin\controller
 */

class Staff extends AdminBaseDailishang
{

    protected $user_model;

    protected function _initialize()
    {
        parent::_initialize();
        $this->user_model = new UserModel();
    }


    public function sindex($keyword = '', $page = 1,$date1='',$date2='',$tag=0){

        if(input('type') == 1){
            $date1 = str_replace('+',' ',$date1);
            $date2 = str_replace('+',' ',$date2);
        }
        $map = [];
        $status = input('status');

        if(isset($status)){
            $map['s.status'] = ['=', $status];
        }
        $agentUser = Db::name('User')->field('id')->where('agent_class','>',1)->select();
        $apid = array_column($agentUser,'id');
        $map['s.sessionfpid'] = array('in',$apid);

        if ($keyword) {
            $map['a.names'] = ['like', "%{$keyword}%"];
        }

        if ($date2=='') {
            $d2=time();
        }else{
            $d2=strtotime($date2);
        }
        if ($date1!='') {
            $d1=strtotime($date1);
            $map['s.create_time'] = array(array('>=',$d1),array('<=',$d2));
        }

        $user_list = Db::name('sales')
            ->alias("s")
            ->field("s.*,c.id cid ,c.names anames,c.mobile,c.idcard,a.id aid ,a.names")
            ->where($map)
            ->join("__USER__ c",'s.uid = c.id','LEFT')
            ->join("__USER__ a",'s.sessionfpid = a.id','LEFT')
            ->order('s.create_time DESC')->paginate(15, false, ['query'=>request()->param()]);

        if(!empty($date1)){
            $startTimes = mktime(0,0,0,date('m',strtotime($date1)),date('d',strtotime($date1)),date('y',strtotime($date1)));
            $ma['create_time'] = [['>=',$startTimes],['<=',time()]];
        }else{
            $ma = [];
        }

        if(!empty($date2)){
            $endTimes = mktime(23,59,59,date('m',strtotime($date2)),date('d',strtotime($date2)),date('y',strtotime($date2)));
            $ma['create_time'] = [['>=',!empty($startTimes)?$startTimes:0],['<=',$endTimes]];
        }else{
            $ma = [];
        }


        if (!empty($keyword)) {
            $user = Db::name('User')->field('id,names')->where('names','=',$keyword)->find();
            //echo "<pre>";
            //var_dump($user['id']);die;
            //总成交数量
            $zfsum = Db::name('sales')->field('id')->where('sessionfpid','in',$user['id'])->where('status','=',1)->where($ma)->count('id');
            //var_dump($zfsum);die;
            $wzfsum = Db::name('sales')->field('id')->where('sessionfpid','in',$user['id'])->where('status','=',0)->where($ma)->count('id');

            //当天成交数量
            $startTime = mktime(0,0,0,date('m'),date('d'),date('y'));
            $endTime = mktime(23,59,59,date('m'),date('d'),date('y'));
            $maps['create_time'] = array(array('>=',$startTime),array('<=',$endTime));
            $dayzfsum = Db::name('sales')->where('sessionfpid','in',$user['id'])->where('status','=',1)->where($maps)->count('id');
            //当天失败数量
            $daywzfsum = Db::name('sales')->where('sessionfpid','in',$user['id'])->where('status','=',0)->where($maps)->count('id');
        }else{
            //总成交数量
            $zfsum = Db::name('sales')->field('id')->where('status','=',1)->where($ma)->count('id');
            $wzfsum = Db::name('sales')->field('id')->where('status','=',0)->where($ma)->count('id');
            //当天成交数量
            $startTime = mktime(0,0,0,date('m'),date('d'),date('y'));
            $endTime = mktime(23,59,59,date('m'),date('d'),date('y'));
            $maps['create_time'] = array(array('>=',$startTime),array('<=',$endTime));
            $dayzfsum = Db::name('sales')->where('status','=',1)->where($maps)->count('id');
            //当天失败数量
            $daywzfsum = Db::name('sales')->where('status','=',0)->where($maps)->count('id');
        }



        return $this->fetch('sindex', ['user_list' => $user_list,'zfsum'=>$zfsum,'wzfsum'=>$wzfsum,'dayzfsum'=>$dayzfsum,'daywzfsum'=>$daywzfsum,'date1' => $date1,'date2' => $date2,'keyword' => $keyword]);
    }







    /**
     * 用户管理
     * @param string $keyword
     * @param int    $page
     * @return mixed
     */
    public function index($keyword = '', $page = 1,$date1='',$date2='',$tag=0)
    {
        $dailishang_id = session('dailishang_id');

        $map = [];
        if (isset($keyword)&&!empty($keyword)) {
            $map['a.names|a.mobile|a.idcard'] = ['like', "%{$keyword}%"];
        }
        if(isset($dailishang_id)){
            $map['a.isStaff'] = ['=',1];
        }
        $map['a.pid'] = ['=',$dailishang_id];
        $user_list = $this->user_model
            ->alias("a")
            ->field("a.*,b.agent_name")
            ->where($map)
            ->join("__AGENT__ b","a.agent_class = b.id ",'LEFT')
            ->join("__USER__ c",'a.pid = c.id','LEFT')
            ->order('id DESC')->paginate(15, false, ['query'=>request()->param()]);

        if(!empty($user_list)){
            $this->userList($user_list,['date1'=>$date1,'date2'=>$date2]);
        }
        return $this->fetch('index', ['user_list' => $user_list,'keyword' => $keyword,'date1' => $date1,'date2' => $date2]);
    }





    public function userList(&$data,$params){
        if(!empty($params['date1'])){
            $startTimes = mktime(0,0,0,date('m',strtotime($params['date1'])),date('d',strtotime($params['date1'])),date('y',strtotime($params['date1'])));
            $ma['createAt'] = [['>=',$startTimes],['<=',time()]];
        }else{
            $startTime = mktime(0,0,0,date('m'),date('d'),date('y'));
            $ma['createAt'] = [['>=',$startTime],['<=',time()]];
        }

        if(!empty($params['date2'])){
            $endTimes = mktime(23,59,59,date('m',strtotime($params['date2'])),date('d',strtotime($params['date2'])),date('y',strtotime($params['date2'])));
            $ma['createAt'] = [['>=',!empty($startTimes)?$startTimes:0],['<=',$endTimes]];
        }else{
            $endTime = mktime(23,59,59,date('m'),date('d'),date('y'));
            $ma['createAt'] = [['>=',$startTime],['<=',$endTime]];
        }
        foreach($data as &$item){
            //总成交数量
            $item['sess'] = Db::name('sales')->field('id')->where('sessionfpid','in',$item['id'])->where('status','=',1)->count('id');
            $item['sesssb'] = Db::name('sales')->field('id')->where('sessionfpid','in',$item['id'])->where('status','=',0)->count('id');

            //当天成交数量
            $item['sessdt']  = Db::name('sales')->where('sessionfpid','in',$item['id'])->where('status','=',1)->where($ma)->count('id');
            //当天失败数量
            $item['sessdtsb']  = Db::name('sales')->where('sessionfpid','in',$item['id'])->where('status','=',0)->where($ma)->count('id');

        }
    }


    /**
     * 编辑用户
     * @param $id
     * @return mixed
     */
    public function edit($id)
    {
        $aid = Session('admin_id');
        $user = $this->user_model->find($id);
        $agent_list=Db::name("agent")->where("id",">","1")->select();
        $this->assign("agent_list",$agent_list);
        $user_list=Db::name("user")->where("agent_class",">","1")->select();
        $this->assign("user_list",$user_list);
        return $this->fetch('edit', ['user' => $user,'aid'=>$aid]);
    }

    /**
     * 更新用户
     * @param $id
     */
    public function update($id)
    {
        if ($this->request->isPost())
        {
            $aid = Session('admin_id');
            $data          = $this->request->post();
            $user          = $this->user_model->find($id);
            $user->id      = $id;
            $user->names = $data['names'];
            $user->mobile   = $data['mobile'];
            $user->pid    = $data['pid'];

            if (!empty($data['password'])) {
                $user->password = md5($data['password']. Config::get('salt'));
            }

            $user->status   = 1;
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


    /**
     * 添加用户
     * @return mixed
     */
    public function add()
    {
        $dailishang_id = session('dailishang_id');
        $dailishang_name = session('dailishang_names');
        //代理商列表
        $this->assign("dailishang_id",$dailishang_id);
        $this->assign("dailishang_names",$dailishang_name);
        return $this->fetch();
    }

    /**
     * 保存用户
     */
    public function save()
    {
        if ($this->request->isPost()) {
            $data            = $this->request->post();
            $data['status'] = 1;
            $validate_result = $this->validate($data, 'User');
            if ($validate_result !== true) {
                $this->error($validate_result);
            } else {
                $userfind = Db::name('User')->field('id,names,agent_class')->where('id','=',$data['pid'])->find();
                $data["password"] = md5($data['password']. \think\Config::get('salt'));
                $data["mid"] = $this->new_mid();
                $data['agent_class'] = $userfind['agent_class'];
                $data['create_time'] = time();
                $data['isStaff'] = 1;
                if ($this->user_model->allowField(true)->save($data)) {
                    $this->success('保存成功');
                } else {
                    $this->error('保存失败');
                }
            }
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


}