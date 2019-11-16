<?php
namespace app\admin\controller;

use app\common\model\Types as TypesModel;
use app\common\controller\AdminBase;
use think\Config;
use think\Db;
use think\Session;
header("content-type:text/html;charset=utf-8");         //设置编码

/**
 * 口子管理
 * Class AdminUser
 * @package app\admin\controller
 */
class Types extends AdminBase
{
    protected $types_model;

    protected function _initialize()
    {
        parent::_initialize();
        $this->types_model = new TypesModel();
		
    }

    /**
     * 口子管理
     * @param string $keyword
     * @param int    $page
     * @return mixed
     */
    public function index($keyword = '', $page = 1)
    {
	
	
        $map = [];
        if ($keyword) {
            $map['a.tname'] = ['like', "%{$keyword}%"];
        }
         $types_list = $this->types_model
		->alias("a")
		->field("a.*")
		->where($map)
		
		->order('id DESC')->paginate(15, false, ['query'=>request()->param()]);
		//dump($kouzi_list);die;
        return $this->fetch('index', ['types_list' => $types_list, 'keyword' => $keyword]);
		
		
    }
	

	
    /**
     * 添加口子
     * @return mixed
     */
    public function add()
    {
		/*
		$type_list = Db::name('Types')->select();
		$this->assign("type_list",$type_list);
		*/
		return $this->fetch();
    }

    /**
     * 保存口子
     */
    public function save()
    {
        if ($this->request->isPost()) {
            $data            = $this->request->post();
            $validate_result = $this->validate($data, 'Types');

            if ($validate_result !== true) {
                $this->error($validate_result);
            } else {
               
				
			
			
				
				if ($this->types_model->allowField(true)->save($data)) {
                    $this->success('保存成功');
                } else {
                    $this->error('保存失败');
                }
            }
        }
    }

    /**
     * 编辑口子
     * @param $id
     * @return mixed
     */
    public function edit($id)
    {
        $types = $this->types_model->find($id);
		
		/*
		$type_list=Db::name("Types")->select();
		$this->assign("type_list",$type_list);
		*/

        return $this->fetch('edit', ['types' => $types]);
    }

    /**
     * 更新口子
     * @param $id
     */
    public function update($id)
    {
	
        if ($this->request->isPost()) {
            $data            = $this->request->post();
            $validate_result = $this->validate($data, 'Types');

            if ($validate_result !== true) {
                $this->error($validate_result);
            } else {
			
			 
			    $types           = $this->types_model->find($id);
                $types->id       = $id;
                $types->tname = $data['tname'];
                $types->isshangjia = $data['isshangjia'];
              
                if ($types->save() !== false) {
                    $this->success('更新成功');
                } else {
                    $this->error('更新失败');
                }
				
            }
        }
		
    }

    /**
     * 删除口子
     * @param $id
     */
    public function delete($id)
    {
        if ($this->types_model->destroy($id)) {
            $this->success('删除成功');
        } else {
            $this->error('删除失败');
        }
    }
	
}