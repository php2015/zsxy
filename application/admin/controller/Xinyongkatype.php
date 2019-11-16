<?php
namespace app\admin\controller;

use app\common\model\Xinyongkatype as XinyongkatypeModel;
use app\common\controller\AdminBase;
use think\Config;
use think\Db;
use think\Session;
header("content-type:text/html;charset=utf-8");         //设置编码
/**
 * 信用卡管理
 * Class AdminUser
 * @package app\admin\controller
 */
class Xinyongkatype extends AdminBase
{
    protected $xinyongkatype_model;

    protected function _initialize()
    {
        parent::_initialize();
        $this->xinyongkatype_model = new XinyongkatypeModel();
		
    }

    /**
     * 信用卡管理
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
         $xinyongkatype_list = $this->xinyongkatype_model
		->alias("a")
		->field("a.*")
		->where($map)
		
		->order('id DESC')->paginate(15, false, ['query'=>request()->param()]);
		//dump($xinyongka_list);die;
        return $this->fetch('index', ['xinyongkatype_list' => $xinyongkatype_list, 'keyword' => $keyword]);
		
		
    }
	

	
    /**
     * 添加信用卡
     * @return mixed
     */
    public function add()
    {
		/*
		$type_list = Db::name('xinyongkatype')->select();
		$this->assign("type_list",$type_list);
		*/
		return $this->fetch();
    }

    /**
     * 保存信用卡
     */
    public function save()
    {
        if ($this->request->isPost()) {
            $data            = $this->request->post();
           // $validate_result = $this->validate($data, 'Xinyongkatype');

          
               
				if(strstr($data["thumb"],"http")==null && strstr($data["thumb"],"public")==null)
				{
					$data["thumb"]="/public".$data["thumb"];
				}
				
				if ($this->xinyongkatype_model->allowField(true)->save($data)) {
                    $this->success('保存成功');
                } else {
                    $this->error('保存失败');
                }
            
        }
    }

    /**
     * 编辑信用卡
     * @param $id
     * @return mixed
     */
    public function edit($id)
    {
        $xinyongkatype = $this->xinyongkatype_model->find($id);
		
		/*
		$type_list=Db::name("xinyongkatype")->select();
		$this->assign("type_list",$type_list);
		*/

        return $this->fetch('edit', ['xinyongkatype' => $xinyongkatype]);
    }

    /**
     * 更新信用卡
     * @param $id
     */
    public function update($id)
    {
	
        if ($this->request->isPost()) {
            $data            = $this->request->post();
           
			
			 
			    $xinyongkatype           = $this->xinyongkatype_model->find($id);
                $xinyongkatype->id       = $id;
                $xinyongkatype->tname = $data['tname'];
                
                $xinyongkatype->descc    = $data['descc'];
				
				if(strstr($data["thumb"],"http")==null && strstr($data["thumb"],"public")==null)
					{
						$data["thumb"]="/public".$data["thumb"];
					}
				$xinyongkatype->thumb   = $data['thumb'];
                if ($xinyongkatype->save() !== false) {
                    $this->success('更新成功');
                } else {
                    $this->error('更新失败');
                }
				
            }
        
		
    }

    /**
     * 删除信用卡
     * @param $id
     */
    public function delete($id)
    {
        if ($this->xinyongkatype_model->destroy($id)) {
            $this->success('删除成功');
        } else {
            $this->error('删除失败');
        }
    }
	
}