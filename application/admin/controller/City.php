<?php
namespace app\admin\controller;
use app\common\model\City as CityModel;
use app\common\controller\AdminBase;
use think\Db;

/**
 * 栏目管理
 * Class Category
 * @package app\admin\controller
 */
class City extends AdminBase
{

    protected $city_model;

    protected function _initialize()
    {
        parent::_initialize();
        $this->city_model = new CityModel();
    }

    /**
     * 栏目管理
     * @return mixed
     */
    public function index($id='')
    {
	   if ($id){
			$where["pid"]=$id;
			$parent=$this->city_model->where(array('id'=>$id))->find();
			$this->assign("parent",$parent);
	   }else{
			$where["pid"]=0;
			$this->assign("parent",null);
	   }
	   $city_list=$this->city_model->where($where)->order("ID ASC")->select();
		$this->assign("city_list",$city_list);
		return $this->fetch();
    }

    /**
     * 添加栏目
     * @param string $pid
     * @return mixed
     */
    public function add($pid = '')
    {
        if ($pid){
			$where["id"]=$pid;
			$info=$this->city_model->where($where)->find();
			$city_list=$this->city_model->where(array('pid'=>$info["pid"]))->select();
			$this->assign("city_list",$city_list);
		}else{
			$city_list=$this->city_model->where(array('pid'=>0))->select();
			$this->assign("city_list",$city_list);
		}
		return $this->fetch('add', ['pid' => $pid]);
    }

    /**
     * 保存栏目
     */
    public function save()
    {
        if ($this->request->isPost()) {
            $data            = $this->request->param();
			if ($this->city_model->allowField(true)->save($data)) {
                  $this->success('保存成功');
            } else {
                  $this->error('保存失败');
            }
        }
    }

    /**
     * 编辑栏目
     * @param $id
     * @return mixed
     */
    public function edit($id)
    {
        $city = $this->city_model->find($id);
		$info=$this->city_model->find($city['pid']);
		if ($info){
			$city_list=$this->city_model->where(array('pid'=>$info["pid"]))->select();
		}else{
			$city_list=$this->city_model->where(array('pid'=>0))->select();
		}
		
		$this->assign("city_list",$city_list);

        return $this->fetch('edit', ['city' => $city]);
    }

    /**
     * 更新栏目
     * @param $id
     */
    public function update($id)
    {
        if ($this->request->isPost()) {
            $data            = $this->request->param();
            if ($this->city_model->allowField(true)->save($data, $id) !== false) {
                 $this->success('更新成功');
            } else {
                 $this->error('更新失败');
            }
        }
    }

    /**
     * 删除栏目
     * @param $id
     */
    public function delete($id)
    {
        $category = $this->city_model->where(['pid' => $id])->find();

        if (!empty($category)) {
            $this->error('此地区下存在子分类，不可删除');
        }
        if ($this->city_model->destroy($id)) {
            $this->success('删除成功');
        } else {
            $this->error('删除失败');
        }
    }
}