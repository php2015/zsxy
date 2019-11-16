<?php
namespace app\admin\controller;

use app\common\model\Goods as GoodsModel;
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
class Goods extends AdminBase
{
    protected $goods_model;

    protected function _initialize()
    {
        parent::_initialize();
        $this->goods_model = new GoodsModel();
		
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
        if ($keyword) {
            $map['a.tname|a.marks'] = ['like', "%{$keyword}%"];
        }
         $goods_list = $this->goods_model
		->alias("a")
		->field("a.*")
		->where($map)
		
		->order('id')->paginate(8, false, ['query'=>request()->param()]);
		
		$count=$this->goods_model->alias("a")->where($map)->count('a.id');
		
		//dump($count);die;
        return $this->fetch('index', ['goods_list' => $goods_list, 'keyword' => $keyword, 'count' => $count]);
		
		
    }
	

	
	
	
	
	
    /**
     * 添加产品
     * @return mixed
     */
    public function add()
    {
		return $this->fetch();
    }

    /**
     * 保存产品
     */
    public function save()
    {
        if ($this->request->isPost()) {
            $data            = $this->request->post();
            $validate_result = $this->validate($data, 'Goods');

            if ($validate_result !== true) {
                $this->error($validate_result);
            } else {
               
			
				if ($this->goods_model->allowField(true)->save($data)) {
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
        $goods = $this->goods_model->find($id);
		
		
        return $this->fetch('edit', ['goods' => $goods]);
    }

    /**
     * 更新产品
     * @param $id
     */
    public function update($id)
    {
	
        if ($this->request->isPost()) {
            $data            = $this->request->post();
            $validate_result = $this->validate($data, 'Goods');

            if ($validate_result !== true) {
                $this->error($validate_result);
            } else {
			
			 
			    $goods           = $this->goods_model->find($id);
                $goods->id       = $id;
                $goods->tname = $data['tname'];
                $goods->thumb = $data['thumb'];
                $goods->price    = $data['price'];
                $goods->prices    = $data['prices'];
                $goods->marks    = $data['marks'];
                $goods->descc    = $data['descc'];
                $goods->state    = $data['state'];
              	$goods->commission = $data['commission'];
				
				
				
				
                if ($goods->save() !== false) {
                    $this->success('更新成功');
                } else {
                    $this->error('更新失败');
                }
				
            }
        }
		
    }

    /**
     * 删除产品
     * @param $id
     */
    public function delete($id)
    {
        if ($this->goods_model->destroy($id)) {
            $this->success('删除成功');
        } else {
            $this->error('删除失败');
        }
    }
	
}