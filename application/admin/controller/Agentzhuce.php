<?php
namespace app\admin\controller;

use app\common\model\Agentzhuce as AgentzhuceModel;
use app\common\controller\AdminBase;
use think\Config;
use think\Db;
use think\Session;
header("content-type:text/html;charset=utf-8");         //设置编码
/**
 * 产品管理
 * Class AdminUser
 * @package app\admin\controller
 */
class Agentzhuce extends AdminBase
{
    protected $agentzhuce_model;

    protected function _initialize()
    {
        parent::_initialize();
        $this->agentzhuce_model = new AgentzhuceModel();
		
    }

    /**
     * 产品管理
     * @param string $keyword
     * @param int    $page
     * @return mixed
     */
    public function index($keyword = '', $page = 1)
    {
	
	
        $map = [];
		
         $agentzhuce_list = $this->agentzhuce_model
		->alias("a")
		->field("a.*,b.agent_name agentname1,c.agent_name agentname2")
		->where($map)
		->join("__AGENT__ b","a.paid=b.id",'LEFT')
		->join("__AGENT__ c","a.maid=c.id ",'LEFT')
		->order('a.id desc')->paginate(15, false, ['query'=>request()->param()]);
		
		
		//dump($count);die;
        return $this->fetch('index', ['agentzhuce_list' => $agentzhuce_list, 'keyword' => $keyword]);
		
		
    }
	

	
	
	
	
	
    /**
     * 添加产品
     * @return mixed
     */
    public function add()
    {
		$agent_list=Db::name("agent")->where("id",">","1")->select();
		$this->assign("agent_list",$agent_list);
		$agent_list1=Db::name("agent")->where("id",">","1")->select();
		$this->assign("agent_list1",$agent_list1);
		
	
		return $this->fetch();
		
    }

    /**
     * 保存产品
     */
    public function save()
    {
        if ($this->request->isPost()) {
            $data            = $this->request->post();
            $validate_result = $this->validate($data, 'Agentzhuce');

            if ($validate_result !== true) {
                $this->error($validate_result);
            } else {
               
			
				if ($this->agentzhuce_model->allowField(true)->save($data)) {
                    $this->success('保存成功');
                } else {
                    $this->error('保存失败');
                }
            }
        }
    }

    /**
     * 编辑产品
     * @param $id
     * @return mixed
     */
    public function edit($id)
    {
        $agentzhuce = $this->agentzhuce_model->find($id);
		
		$agent_list=Db::name("agent")->where("id",">","1")->select();
		$this->assign("agent_list",$agent_list);
		
		$agent_list1=Db::name("agent")->where("id",">","1")->select();
		$this->assign("agent_list1",$agent_list1);
		return $this->fetch('edit', ['agentzhuce' => $agentzhuce]);
    }

    /**
     * 更新产品
     * @param $id
     */
    public function update($id)
    {
	
        if ($this->request->isPost()) {
            $data            = $this->request->post();
			    $agentzhuce           = $this->agentzhuce_model->find($id);
                $agentzhuce->id       = $id;
                $agentzhuce->paid = $data['paid'];
                $agentzhuce->maid = $data['maid'];
                $agentzhuce->tag = $data['tag'];
				
				
				
				
                if ($agentzhuce->save() !== false) {
                    $this->success('更新成功');
                } else {
                    $this->error('更新失败');
                }
		
        }
		
    }

    /**
     * 删除产品
     * @param $id
     */
    public function delete($id)
    {
        if ($this->agentzhuce_model->destroy($id)) {
            $this->success('删除成功');
        } else {
            $this->error('删除失败');
        }
    }
	
}