<?php
namespace app\admin\controller;

use app\common\model\Gonggao as GonggaoModel;
use app\common\controller\AdminBase;
use think\Config;
use think\Db;
use think\Session;
header("content-type:text/html;charset=utf-8");         //设置编码
/**
 * 轮播图
 * Class AdminUser
 * @package app\admin\controller
 */
class Gonggao extends AdminBase
{
    protected $gonggao_model;

    protected function _initialize()
    {
        parent::_initialize();
        $this->gonggao_model = new GonggaoModel();
		
    }

    /**
     * 轮播图管理
     * @param string $keyword
     * @param int    $page
     * @return mixed
     */
    public function index($keyword = '', $page = 1)
    {
	
	
        $map = [];
        if ($keyword) {
            $map['a.title|a.marks'] = ['like', "%{$keyword}%"];
        }
         $gonggao_list = $this->gonggao_model
		->alias("a")
		->field("a.*")
		->where($map)
		
		->order('id DESC')->paginate(15, false, ['query'=>request()->param()]);
		//dump($kouzi_list);die;
        return $this->fetch('index', ['gonggao_list' => $gonggao_list, 'keyword' => $keyword]);
		
		
    }
	

	
    /**
     * 添加
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
     * 保存
     */
    public function save()
    {
        if ($this->request->isPost()) {
            $data            = $this->request->post();
            $validate_result = $this->validate($data, 'Gonggao');

            if ($validate_result !== true) {
                $this->error($validate_result);
            } else {
               
				
				//$data["dates"]=time();
				
				if ($this->gonggao_model->allowField(true)->save($data)) {
                    $this->success('保存成功');
                } else {
                    $this->error('保存失败');
                }
            }
        }
    }

    /**
     * 编辑
     * @param $id
     * @return mixed
     */
    public function edit($id)
    {
        $gonggao = $this->gonggao_model->find($id);
		
		/*
		$type_list=Db::name("kouzitype")->select();
		$this->assign("type_list",$type_list);
		*/

        return $this->fetch('edit', ['gonggao' => $gonggao]);
    }

    /**
     * 更新口子
     * @param $id
     */
    public function update($id)
    {
	
        if ($this->request->isPost()) {
            $data            = $this->request->post();
            $validate_result = $this->validate($data, 'Gonggao');

            if ($validate_result !== true) {
                $this->error($validate_result);
            } else {
			
			 
			    $gonggao           = $this->gonggao_model->find($id);
                $gonggao->id       = $id;
                $gonggao->title = $data['title'];
                $gonggao->marks   = $data['marks'];
                $gonggao->descc    = $data['descc'];
              
                if ($gonggao->save() !== false) {
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
        if ($this->gonggao_model->destroy($id)) {
            $this->success('删除成功');
        } else {
            $this->error('删除失败');
        }
    }
	
}