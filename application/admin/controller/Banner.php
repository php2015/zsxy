<?php
namespace app\admin\controller;

use app\common\model\Banner as BannerModel;
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
class Banner extends AdminBase
{
    protected $banner_model;

    protected function _initialize()
    {
        parent::_initialize();
        $this->banner_model = new BannerModel();
		
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
            $map['a.names'] = ['like', "%{$keyword}%"];
        }
         $banner_list = $this->banner_model
		->alias("a")
		->field("a.*")
		->where($map)
		
		->order('id DESC')->paginate(3, false, ['query'=>request()->param()]);
		//dump($kouzi_list);die;
        return $this->fetch('index', ['banner_list' => $banner_list, 'keyword' => $keyword]);
		
		
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
         
				if ($this->banner_model->allowField(true)->save($data)) {
                    $this->success('保存成功');
                } else {
                    $this->error('保存失败');
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
        $banner = $this->banner_model->find($id);
		
		
        return $this->fetch('edit', ['banner' => $banner]);
    }

    /**
     * 更新口子
     * @param $id
     */
    public function update($id)
    {
	
        if ($this->request->isPost()) {
            $data            = $this->request->post();
           	$banner           = $this->banner_model->find($id);
                $banner->id       = $id;
                $banner->names = $data['names'];
                
                $banner->hrefs   = $data['hrefs'];
                $banner->descc    = $data['descc'];
            
				 $banner->thumb   = $data['thumb'];
                if ($banner->save() !== false) {
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
        if ($this->banner_model->destroy($id)) {
            $this->success('删除成功');
        } else {
            $this->error('删除失败');
        }
    }
	
}