<?php
namespace app\admin\controller;

use app\common\model\Leescoregoods as LeescoregoodsModel;
use app\common\controller\AdminBase;
use think\Config;
use think\Db;
use think\Session;
header("content-type:text/html;charset=utf-8");         //设置编码
/**
 * 商品管理
 * Class AdminUser
 * @package app\admin\controller
 */
class Leescoregoods extends AdminBase
{
    protected $leescoregoods_model;

    protected function _initialize()
    {
        parent::_initialize();
        $this->leescoregoods_model = new LeescoregoodsModel();
		
    }

    /**
     * 商品管理
     * @param string $keyword
     * @param int    $page
     * @return mixed
     */
    public function index($keyword = '', $page = 1)
    {
	
	
        $map = [];
        if ($keyword) {
            $map['a.name|a.titles'] = ['like', "%{$keyword}%"];
        }
         $leescoregoods_list = $this->leescoregoods_model
		->alias("a")
		->field("a.*,b.tname")
		->join("__LEESCORECATEGORY__ b",'a.category_id=b.id','LEFT')
		->where($map)
		
		->order('id DESC')->paginate(8, false, ['query'=>request()->param()]);
		
		$count=$this->leescoregoods_model->alias("a")->where($map)->count('a.id');
		
		//dump($count);die;
        return $this->fetch('index', ['leescoregoods_list' => $leescoregoods_list, 'keyword' => $keyword, 'count' => $count]);
		
		
    }
	
    public function title($id)
    {
        $id=input('id');
        $title=db('leescoregoods')->where('id','=',$id)->order('id','=',$id)->find();

        $title['content']= htmlspecialchars_decode($title['content']."<center><h3>发货配置</h3></center></br>".$title['rule']);
        return $title;
    }

	
	
	
	
	
    /**
     * 添加商品
     * @return mixed
     */
    public function add()
    {
		//地址
		$type_list = Db::name('leescorecategory')->select();
		$this->assign("type_list",$type_list);
		
		return $this->fetch();
    }

    /**
     * 保存商品
     */
    public function save()
    {
        if ($this->request->isPost()) {
            $data            = $this->request->post();
            $validate_result = $this->validate($data, 'Leescoregoods');

            if ($validate_result !== true) {
                $this->error($validate_result);
            } else {
               
				$data["createtime"]=time();
				
				if(strstr($data["thumb"],"http")==null && strstr($data["thumb"],"public")==null)
				{
					$data["thumb"]="/public".$data["thumb"];
				}
              
				if ($this->leescoregoods_model->allowField(true)->save($data)) {
                    $this->success('保存成功');
                } else {
                    $this->error('保存失败');
                }
            }
        }
    }

    /**
     * 编辑商品
     * @param $id
     * @return mixed
     */
    public function edit($id)
    {
        $leescoregoods = $this->leescoregoods_model->find($id);
		
		//商品type
		$type_list=Db::name("leescorecategory")->select();
		$this->assign("type_list",$type_list);
		

        return $this->fetch('edit', ['leescoregoods' => $leescoregoods]);
    }
	
	public function peizhi($id)
    {
        $leescoregoods = $this->leescoregoods_model->find($id);
		

        return $this->fetch('peizhi', ['leescoregoods' => $leescoregoods]);
    }
	public function pei($id)
	{
		  if ($this->request->isPost()) {
            $data            = $this->request->post();
				$leescoregoods           = $this->leescoregoods_model->find($id);
                $leescoregoods->id       = $id;
               
                $leescoregoods->rule    = $data['rule'];
				
				
                if ($leescoregoods->save() !== false) {
                    $this->success('更新成功');
                } else {
                    $this->error('更新失败');
                }
				
            
        	}
	}
    /**
     * 更新商品
     * @param $id
     */
    public function update($id)
    {
	
        if ($this->request->isPost()) {
            $data            = $this->request->post();
            $validate_result = $this->validate($data, 'Leescoregoods');

            if ($validate_result !== true) {
                $this->error($validate_result);
            } else {
			
			 
			    $leescoregoods           = $this->leescoregoods_model->find($id);
                $leescoregoods->id       = $id;
                $leescoregoods->name = $data['name'];
               
                $leescoregoods->titles    = $data['titles'];
                $leescoregoods->type    = $data['type'];
                $leescoregoods->money    = $data['money'];
                $leescoregoods->category_id    = $data['category_id'];
                $leescoregoods->hott    = $data['hott'];
                $leescoregoods->news    = $data['news'];
                $leescoregoods->weigh    = $data['weigh'];
                $leescoregoods->stock    = $data['stock'];
                $leescoregoods->yuanjia    = $data['yuanjia'];
                $leescoregoods->status    = $data['status'];
                $leescoregoods->content    = $data['content'];
				
				
				if(strstr($data["thumb"],"http")==null && strstr($data["thumb"],"public")==null)
				{
					$data["thumb"]="/public".$data["thumb"];
				}
				 $leescoregoods->thumb   = $data['thumb'];
                if ($leescoregoods->save() !== false) {
                    $this->success('更新成功');
                } else {
                    $this->error('更新失败');
                }
				
            }
        }
		
    }

    /**
     * 删除商品
     * @param $id
     */
    public function delete($id)
    {
        if ($this->leescoregoods_model->destroy($id)) {
            $this->success('删除成功');
        } else {
            $this->error('删除失败');
        }
    }
	
}