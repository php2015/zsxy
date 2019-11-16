<?php

namespace app\dailishang\controller;


use app\common\controller\AdminBaseDailishang;
use \app\common\model\User as UserModel;
use think\Db;
use think\Session;

class Staffs extends AdminBaseDailishang{


    public function index($keyword = '', $page = 1,$date1='',$date2='',$tag=0){
        $dailishang_id = session('dailishang_id');
        if(input('type') == 1){
            $date1 = str_replace('+',' ',$date1);
            $date2 = str_replace('+',' ',$date2);
        }
        $map = [];
        $status = input('status');

        if(isset($status)){
            $map['s.status'] = ['=', $status];
        }
        $agentUser = Db::name('User')->field('id')->where('pid','=',$dailishang_id)->where('isStaff','=',1)->select();

        $apid = $this->_array_column($agentUser,'id');

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
            $map['s.createAt'] = array(array('>=',$d1),array('<=',$d2));
        }

        $user_list = Db::name('sales')
            ->alias("s")
            ->field("s.*,c.id cid ,c.names anames,c.mobile,c.idcard,a.id aid ,a.names")
            ->where($map)
            ->join("__USER__ c",'s.uid = c.id','LEFT')
            ->join("__USER__ a",'s.sessionfpid = a.id','LEFT')
            ->order('s.createAt DESC')->paginate(15, false, ['query'=>request()->param()]);

        if(!empty($date1)){
            $startTimes = mktime(0,0,0,date('m',strtotime($date1)),date('d',strtotime($date1)),date('y',strtotime($date1)));
            $ma['createAt'] = [['>=',$startTimes],['<=',time()]];
        }else{
            $ma = [];
        }

        if(!empty($date2)){
            $endTimes = mktime(23,59,59,date('m',strtotime($date2)),date('d',strtotime($date2)),date('y',strtotime($date2)));
            $ma['createAt'] = [['>=',!empty($startTimes)?$startTimes:0],['<=',$endTimes]];
        }else{
            $ma = [];
        }

        if (!empty($keyword)) {
            $user = Db::name('User')->field('id,names')->where('names','=',$keyword)->where('isStaff','=',1)->find();
            //echo "<pre>";
            //var_dump($user['id']);die;
            //总成交数量
            $zfsum = Db::name('sales')->field('id')->where('sessionfpid','in',$user['id'])->where('status','=',1)->where($ma)->count('id');
            //var_dump($zfsum);die;
            $wzfsum = Db::name('sales')->field('id')->where('sessionfpid','in',$user['id'])->where('status','=',0)->where($ma)->count('id');

            //当天成交数量
            $startTime = mktime(0,0,0,date('m'),date('d'),date('y'));
            $endTime = mktime(23,59,59,date('m'),date('d'),date('y'));
            $maps['createAt'] = array(array('>=',$startTime),array('<=',$endTime));
            $dayzfsum = Db::name('sales')->where('sessionfpid','in',$user['id'])->where('status','=',1)->where($maps)->count('id');
            //当天失败数量
            $daywzfsum = Db::name('sales')->where('sessionfpid','in',$user['id'])->where('status','=',0)->where($maps)->count('id');
        }else{
  
            //总成交数量
            $zfsum = Db::name('sales')->field('id')->where('status','=',1)->where('sessionfpid','in',$apid)->where($ma)->count('id');
            $wzfsum = Db::name('sales')->field('id')->where('status','=',0)->where('sessionfpid','in',$apid)->where($ma)->count('id');
            //当天成交数量

          	$startTime = mktime(0,0,0,date('m'),date('d'),date('y'));
            $endTime = mktime(23,59,59,date('m'),date('d'),date('y'));
            $maps['createAt'] = array(array('>=',$startTime),array('<=',$endTime));
            $dayzfsum = Db::name('sales')->where('status','=',1)->where('sessionfpid','in',$apid)->where($maps)->count('id');
            //当天失败数量
            $daywzfsum = Db::name('sales')->where('status','=',0)->where('sessionfpid','in',$apid)->where($maps)->count('id');
        }
        return $this->fetch('index', ['user_list' => $user_list,'zfsum'=>$zfsum,'wzfsum'=>$wzfsum,'dayzfsum'=>$dayzfsum,'daywzfsum'=>$daywzfsum,'date1' => $date1,'date2' => $date2,'keyword' => $keyword]);
    }
  
  
  
 public function _array_column(array $array, $column_key, $index_key=null){
    $result = [];
    foreach($array as $arr) {
        if(!is_array($arr)) continue;

        if(is_null($column_key)){
            $value = $arr;
        }else{
            $value = $arr[$column_key];
        }

        if(!is_null($index_key)){
            $key = $arr[$index_key];
            $result[$key] = $value;
        }else{
            $result[] = $value;
        }
    }
    return $result; 
}

}
