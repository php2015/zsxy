<?php
namespace app\admin\controller;

use app\common\model\Notetype as NotetypeModel;
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
class Notetype extends AdminBase
{
    protected $notetype_model;

    protected function _initialize()
    {
        parent::_initialize();
        $this->notetype_model = new NotetypeModel();
		
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
         $notetype_list = $this->notetype_model
		->alias("a")
		->field("a.*")
		->where($map)
		
		->order('id DESC')->paginate(15, false, ['query'=>request()->param()]);
		//dump($kouzi_list);die;
        return $this->fetch('index', ['notetype_list' => $notetype_list, 'keyword' => $keyword]);
		
		
    }
	

	
    /**
     * 添加口子
     * @return mixed
     */
    public function add()
    {
		/*
		$type_list = Db::name('notetype')->select();
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
           
               
			
				if ($this->notetype_model->allowField(true)->save($data)) {
                    $this->success('保存成功');
                } else {
                    $this->error('保存失败');
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
        $notetype = $this->notetype_model->find($id);
		
		

        return $this->fetch('edit', ['notetype' => $notetype]);
    }

    /**
     * 更新口子
     * @param $id
     */
    public function update($id)
    {
	
        if ($this->request->isPost()) {
            $data            = $this->request->post();
           

			 
			    $notetype           = $this->notetype_model->find($id);
                $notetype->id       = $id;
                $notetype->tname = $data['tname'];
                
                $notetype->descc    = $data['descc'];
				
				
				$notetype->thumb   = $data['thumb'];
                if ($notetype->save() !== false) {
                    $this->success('更新成功');
                } else {
                    $this->error('更新失败');
                }
				
            
        }
		
    }

    /**
     * 删除口子
     * @param $id
     */
    public function delete($id)
    {
        if ($this->notetype_model->destroy($id)) {
            $this->success('删除成功');
        } else {
            $this->error('删除失败');
        }
    }
	
}