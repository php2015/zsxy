<?php

namespace app\admin\controller;

use app\common\model\Insurance as InsuranceModel;

use app\common\controller\AdminBase;

class Insurance extends AdminBase{
	

    protected function _initialize()
    {
        parent::_initialize();
        $this->insurance_model  = new InsuranceModel();
    }


    /**
     * 评论列表
     * @param string $keyword
     * @param int $page
     * @return mixed
     */
    public function index($keyword = '', $page = 1,$status='',$startTime='',$endTime=''){
        $map = [];
        if ($keyword) {
            $map['a.name|a.mobile|a.IdCard'] = ['like', "%{$keyword}%"];
        }
        
        if(!empty($status) && $status == 1){
        	$map =  ['a.status' => 1];
        }
        
        if(!empty($status) && $status == 2){
        	$map = ['a.status' => 0];
        }
        
        $times = [];
        
        
        if(!empty($startTime)){
			$d1=strtotime($startTime);
            $times['a.createAt'] = [['>=',$d1],['<=',time()]];
        }
        
        if(!empty($endTime)){
			$d2=strtotime($endTime);
			$times['a.createAt'] = [['>=',!empty($d1)?$d1:0],['<=',$d2]];
        }
        if(empty($startTime) && empty($endTime)){
        	$times['a.createAt'] = [['>=',strtotime('-15 day',time())],['<=',time()]];
        }
        
        $data = $this->insurance_model->alias("a")
            ->field("a.*")
            ->where($map)
            ->where($times)
            ->order('id DESC')->paginate(15, false, ['query'=>request()->param()]);
            
        $ccount =  $this->insurance_model->where('status','=',1)->count();   
        $scount =  $this->insurance_model->where('status','=',0)->count();
        
        $beginToday=mktime(0,0,0,date('m'),date('d'),date('Y'));
        $dccount =  $this->insurance_model->where('status','=',1)->where('createAt','between',[$beginToday,time()])->count();   
        $dscount =  $this->insurance_model->where('status','=',0)->where('createAt','between',[$beginToday,time()])->count();
       
        $this->assign('data',$data);
        
        $this->assign('ccount',$ccount);
        $this->assign('scount',$scount);
        $this->assign('dccount',$dccount);
        $this->assign('dscount',$dscount);
        
        $this->assign('startTime',$startTime);
        $this->assign('endTime',$endTime);
        $this->assign('keyword',$keyword);
        
        
        return $this->fetch();
    }


    /**
     * 删除数据
     * @param $id
     */
    public function delete($id){
    	
    	if ($this->insurance_model->destroy($id)) {
            $this->success('删除成功');
        } else {
            $this->error('删除失败');
        }
       
    }
}