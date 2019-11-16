<?php
namespace app\admin\controller;

use app\common\model\Agentgoods as AgentgoodsModel;
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
class Agentgoods extends AdminBase
{
    protected $agentgoods_model;

    protected function _initialize()
    {
        parent::_initialize();
        $this->agentgoods_model = new AgentgoodsModel();
		
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
		$on="";
        if ($keyword) {
            $on=" and b.agent_name like '%".$keyword."%'";
        }
      	//$map['a.isdel'] = ['=', "1"];
         $agentgoods_list = $this->agentgoods_model
		->alias("a")
		->field("a.*,b.agent_name,c.tname")
		->where($map)
		->join("__AGENT__ b","a.aid=b.id".$on,'')
		->join("__GOODS__ c","a.gid=c.id ",'LEFT')
		->order('b.id desc')->paginate(15, false, ['query'=>request()->param()]);
		
		
		//dump($count);die;
        return $this->fetch('index', ['agentgoods_list' => $agentgoods_list, 'keyword' => $keyword]);
		
		
    }
	

	
	
	
	
	
    /**
     * 添加产品
     * @return mixed
     */
    public function add()
    {
		$agent_list=Db::name("agent")->where("id",">","1")->select();
		$this->assign("agent_list",$agent_list);
		
		$goods_list=Db::name("goods")->select();
		$this->assign("goods_list",$goods_list);
		return $this->fetch();
		
    }

    /**
     * 保存产品
     */
    public function save()
    {
        if ($this->request->isPost()) {
            $data            = $this->request->post();
            $validate_result = $this->validate($data, 'Agentgoods');

            if ($validate_result !== true) {
                $this->error($validate_result);
            } else {
               
			
				if ($this->agentgoods_model->allowField(true)->save($data)) {
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
        $agentgoods = $this->agentgoods_model->find($id);
		$agent_list=Db::name("agent")->where("id",">","1")->select();
		$this->assign("agent_list",$agent_list);
		
		$goods_list=Db::name("goods")->select();
		$this->assign("goods_list",$goods_list);
		return $this->fetch('edit', ['agentgoods' => $agentgoods]);
    }

    /**
     * 更新产品
     * @param $id
     */
    public function update($id)
    {
	
        if ($this->request->isPost()) {
            $data            = $this->request->post();
			    $agentgoods           = $this->agentgoods_model->find($id);
                $agentgoods->id       = $id;
                $agentgoods->aid = $data['aid'];
                $agentgoods->gid = $data['gid'];
                $agentgoods->price    = $data['price'];
                $agentgoods->erjiprice    = $data['erjiprice'];
				
				
				
				
                if ($agentgoods->save() !== false) {
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
        if ($this->agentgoods_model->destroy($id)) {
            $this->success('删除成功');
        } else {
            $this->error('删除失败');
        }
    }
	
}