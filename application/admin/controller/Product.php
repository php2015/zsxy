<?php
namespace app\admin\controller;

use app\common\model\Product as ProductModel;
use app\common\controller\AdminBase;
use think\Config;
use think\Db;
use think\Session;
header("content-type:text/html;charset=utf-8");         //设置编码
/**
 * 版本管理
 * Class AdminUser
 * @package app\admin\controller
 */
class Product extends AdminBase
{
    protected $product_model;

    protected function _initialize()
    {
        parent::_initialize();
        $this->product_model = new ProductModel();
		
    }

    /**
     * 版本管理
     * @param string $keyword
     * @param int    $page
     * @return mixed
     */
    public function index($keyword = '', $page = 1)
    {
	
	
        $map = [];
        if ($keyword) {
            $map['a.rename|a.product_name|a.uid|a.id'] = ['like', "%{$keyword}%"];
        }
      	$map['isdel']=['=', "1"];
         $product_list = $this->product_model
		->alias("a")
		->field("a.*,b.erjiprice,c.agent_name,d.names")
		->join("__AGENTGOODS__ b","a.a_g_id=b.id ",'LEFT')
		->join("__USER__ d","a.uid=d.id ",'LEFT')
		->join("__AGENT__ c","d.agent_class=c.id ",'LEFT')
		->where($map)
		
		->order('a.createtime desc,names desc')->paginate(200, false, ['query'=>request()->param()]);
		
		$count=$this->product_model->alias("a")->where($map)->count('a.id');
		
		//dump($count);die;
        return $this->fetch('index', ['product_list' => $product_list, 'keyword' => $keyword, 'count' => $count]);
		
		
    }
	

	
	
	
	
	
    /**
     * 添加版本
     * @return mixed
     */
    public function add()
    {
		return $this->fetch();
    }

    /**
     * 保存版本
     */
    public function save()
    {
        if ($this->request->isPost()) {
            $data            = $this->request->post();
            $validate_result = $this->validate($data, 'Product');

            if ($validate_result !== true) {
                $this->error($validate_result);
            } else {
				if ($this->product_model->allowField(true)->save($data)) {
                    $this->success('保存成功');
                } else {
                    $this->error('保存失败');
                }
            }
        }
    }

    /**
     * 编辑版本
     * @param $id
     * @return mixed
     */
    public function edit($id)
    {
        $product = $this->product_model->find($id);
		
		
        return $this->fetch('edit', ['product' => $product]);
    }

    /**
     * 更新版本
     * @param $id
     */
    public function update($id)
    {
	
        if ($this->request->isPost()) {
            $data            = $this->request->post();
            $validate_result = $this->validate($data, 'Product');

            if ($validate_result !== true) {
                $this->error($validate_result);
            } else {
			
			 
			    $product           = $this->product_model->find($id);
                $product->id       = $id;
              
                $product->price    = $data['price'];
				
				
				
				
                if ($product->save() !== false) {
                    $this->success('更新成功');
                } else {
                    $this->error('更新失败');
                }
				
            }
        }
		
    }

    /**
     * 删除版本
     * @param $id
     */
    public function delete($id)
    {
        if ($this->product_model->destroy($id)) {
            $this->success('删除成功');
        } else {
            $this->error('删除失败');
        }
    }
	
}