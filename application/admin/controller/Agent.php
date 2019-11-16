<?php
namespace app\admin\controller;

use app\common\model\Agent as AgentModel;
use app\common\controller\AdminBase;
use think\Config;
use think\Db;
use think\Session;
header("content-type:text/html;charset=utf-8");         //设置编码

class Agent extends AdminBase
{
    protected $agent_model;

    protected function _initialize()
    {
        parent::_initialize();
        $this->agent_model = new AgentModel();
		
    }


    public function index($keyword = '', $page = 1)
    {
	
	
        $map = [];
        if ($keyword) {
            $map['a.agent_name'] = ['like', "%{$keyword}%"];
        }
         $agent_list = $this->agent_model
		->alias("a")
		->field("a.*")
		->where($map)
		
		->order('id DESC')->paginate(15, false, ['query'=>request()->param()]);
		//dump($kouzi_list);die;
        return $this->fetch('index', ['agent_list' => $agent_list, 'keyword' => $keyword]);
		
		
    }
	

	
    public function add()
    {
		
		return $this->fetch();
    }

    public function save()
    {
        if ($this->request->isPost()) {
            $data            = $this->request->post();
        		if ($this->agent_model->allowField(true)->save($data)) {
                    $this->success('保存成功');
                } else {
                    $this->error('保存失败');
                }
            
        }
    }

    public function edit($id)
    {
        $agent = $this->agent_model->find($id);
		
        return $this->fetch('edit', ['agent' => $agent]);
    }

    public function update($id)
    {
	
        if ($this->request->isPost()) {
            $data            = $this->request->post();
           
			 
			    $agent           = $this->agent_model->find($id);
                $agent->id       = $id;
                $agent->agent_name = $data['agent_name'];
                $agent->isoem_name = $data['isoem_name'];
                $agent->rename = $data['rename'];
                $agent->isoem_ewm = $data['isoem_ewm'];
                $agent->isopen_ewm = $data['isopen_ewm'];
                $agent->thumb = $data['thumb'];
                $agent->isoem_price = $data['isoem_price'];
                $agent->isoem_title = $data['isoem_title'];
                $agent->isoem_marks = $data['isoem_marks'];
                $agent->nums = $data['nums'];
                
                $agent->descc    = $data['descc'];
				
				
                if ($agent->save() !== false) {
                    $this->success('更新成功');
                } else {
                    $this->error('更新失败');
                }
				
            }
        
		
    }


    public function delete($id)
    {
        if ($this->agent_model->destroy($id)) {
            $this->success('删除成功');
        } else {
            $this->error('删除失败');
        }
    }
	
}