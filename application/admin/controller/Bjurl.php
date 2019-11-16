<?php
namespace app\admin\controller;

use app\common\model\Bjurl as BjurlModel;
use app\common\controller\AdminBase;
use think\Config;
use think\Db;
use think\Session;
header("content-type:text/html;charset=utf-8");         //设置编码

class Bjurl extends AdminBase
{
    protected $bjurl_model;

    protected function _initialize()
    {
        parent::_initialize();
        $this->bjurl_model = new BjurlModel();
		
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
         $bjurl_list = $this->bjurl_model
		->alias("a")
		->field("a.*")
		->where($map)
		
		->order('id DESC')->paginate(15, false, ['query'=>request()->param()]);
		//dump($kouzi_list);die;
        return $this->fetch('index', ['bjurl_list' => $bjurl_list, 'keyword' => $keyword]);
		
		
    }
	

	
    /**
     * 添加口子
     * @return mixed
     */
    public function add()
    {
		/*
		$type_list = Db::name('bjurl')->select();
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
           
				
				if ($this->bjurl_model->allowField(true)->save($data)) {
                    $this->success('保存成功');
                } else {
                    $this->error('保存失败');
                }
            
        }
    }


    public function edit($id)
    {
        $bjurl = $this->bjurl_model->find($id);
		
	

        return $this->fetch('edit', ['bjurl' => $bjurl]);
    }


    public function update($id)
    {
	
        if ($this->request->isPost()) {
            $data            = $this->request->post();
          
			 
			    $bjurl           = $this->bjurl_model->find($id);
                $bjurl->id       = $id;
                $bjurl->tname = $data['tname'];
                
                $bjurl->descc    = $data['descc'];
				
				
				$bjurl->thumb   = $data['thumb'];
                if ($bjurl->save() !== false) {
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
        if ($this->bjurl_model->destroy($id)) {
            $this->success('删除成功');
        } else {
            $this->error('删除失败');
        }
    }
	
}