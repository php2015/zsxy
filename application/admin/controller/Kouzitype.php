<?php
namespace app\admin\controller;

use app\common\model\Kouzitype as KouzitypeModel;
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
class Kouzitype extends AdminBase
{
    protected $kouzitype_model;

    protected function _initialize()
    {
        parent::_initialize();
        $this->kouzitype_model = new KouzitypeModel();
		
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
         $kouzitype_list = $this->kouzitype_model
		->alias("a")
		->field("a.*")
		->where($map)
		
		->order('id DESC')->paginate(15, false, ['query'=>request()->param()]);
		//dump($kouzi_list);die;
        return $this->fetch('index', ['kouzitype_list' => $kouzitype_list, 'keyword' => $keyword]);
		
		
    }
	

	
    /**
     * 添加口子
     * @return mixed
     */
    public function add()
    {
		/*
		$type_list = Db::name('kouzitype')->select();
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
            $validate_result = $this->validate($data, 'Kouzitype');

            if ($validate_result !== true) {
                $this->error($validate_result);
            } else {
               
				
			
				
				if(!strstr($data["thumb"],"http"))
				{
					$data["thumb"]="/public".$data["thumb"];
				}
				
				if ($this->kouzitype_model->allowField(true)->save($data)) {
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
        $kouzitype = $this->kouzitype_model->find($id);
		
		/*
		$type_list=Db::name("kouzitype")->select();
		$this->assign("type_list",$type_list);
		*/

        return $this->fetch('edit', ['kouzitype' => $kouzitype]);
    }

    /**
     * 更新口子
     * @param $id
     */
    public function update($id)
    {
	
        if ($this->request->isPost()) {
            $data            = $this->request->post();
            $validate_result = $this->validate($data, 'Kouzitype');

            if ($validate_result !== true) {
                $this->error($validate_result);
            } else {
			
			 
			    $kouzitype           = $this->kouzitype_model->find($id);
                $kouzitype->id       = $id;
                $kouzitype->tname = $data['tname'];
                
                $kouzitype->descc    = $data['descc'];
				
				if(!strstr($data["thumb"],"http"))
					{
						$data["thumb"]="/public".$data["thumb"];
					}
				$kouzitype->thumb   = $data['thumb'];
                if ($kouzitype->save() !== false) {
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
        if ($this->kouzitype_model->destroy($id)) {
            $this->success('删除成功');
        } else {
            $this->error('删除失败');
        }
    }
	
}