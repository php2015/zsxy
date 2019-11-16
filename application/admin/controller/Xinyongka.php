<?php
namespace app\admin\controller;

use app\common\model\Xinyongka as XinyongkaModel;
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
class Xinyongka extends AdminBase
{
    protected $xinyongka_model;

    protected function _initialize()
    {
        parent::_initialize();
        $this->xinyongka_model = new XinyongkaModel();
		
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
            $map['a.kname|a.ktitle|a.kmarks'] = ['like', "%{$keyword}%"];
        }
         $xinyongka_list = $this->xinyongka_model
		->alias("a")
		->field("a.*")
		->where($map)
		
		->order('id DESC')->paginate(8, false, ['query'=>request()->param()]);
		
		$count=$this->xinyongka_model->alias("a")->where($map)->count('a.id');
		
		//dump($count);die;
        return $this->fetch('index', ['xinyongka_list' => $xinyongka_list, 'keyword' => $keyword, 'count' => $count]);
		
		
    }
	

	
	
	
	
	
    /**
     * 添加口子
     * @return mixed
     */
    public function add()
    {
		//地址
		$type_list = Db::name('xinyongkatype')->select();
		$this->assign("type_list",$type_list);
		
		return $this->fetch();
    }

    /**
     * 保存口子
     */
    public function save()
    {
        if ($this->request->isPost()) {
            $data            = $this->request->post();
           
               
				if ($data["ktype"]!=0){
					$info=Db::name("xinyongkatype")->where(array("id"=>$data["ktype"]))->find();
					$data["typename"]=$info["tname"];
				}
				$data["dates"]=time();
				$data["hrefs"]=str_replace("&amp;","&",$data["hrefs"]);
				if(strstr($data["thumb"],"http")==null && strstr($data["thumb"],"public")==null)
				{
					$data["thumb"]="/public".$data["thumb"];
				}
              
				if ($this->xinyongka_model->allowField(true)->save($data)) {
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
        $xinyongka = $this->xinyongka_model->find($id);
		
		//口子type
		$type_list=Db::name("xinyongkatype")->select();
		$this->assign("type_list",$type_list);
		

        return $this->fetch('edit', ['xinyongka' => $xinyongka]);
    }

    /**
     * 更新口子
     * @param $id
     */
    public function update($id)
    {

        if ($this->request->isPost()) {
            $data            = $this->request->post();
			
			
			    $xinyongka           = $this->xinyongka_model->find($id);
                $xinyongka->id       = $id;
                $xinyongka->xname = $data['xname'];
              	$xinyongka->ktitle    = $data['ktitle'];
                $xinyongka->xchahrefs    = $data['xchahrefs'];
                $xinyongka->bizhong    = $data['bizhong'];
                $xinyongka->nianfei    = $data['nianfei'];
                $xinyongka->descc    = $data['descc'];
                $xinyongka->hrefs    = str_replace("&amp;","&",$data["hrefs"]);
                $xinyongka->state    = $data['state'];
                $xinyongka->remarks    = $data['remarks'];
                $xinyongka->ktype    = $data['ktype'];
				
				if ($data["ktype"]!=0){
					$info=Db::name("xinyongkatype")->where(array("id"=>$data["ktype"]))->find();
					$xinyongka->typename=$info["tname"];
					
				}else{
					$xinyongka->typename = array('exp','null');
				}
				if(strstr($data["thumb"],"http")==null && strstr($data["thumb"],"public")==null)
				{
					$data["thumb"]="/public".$data["thumb"];
				}
				 $xinyongka->thumb   = $data['thumb'];
                if ($xinyongka->save() !== false) {
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
        if ($this->xinyongka_model->destroy($id)) {
            $this->success('删除成功');
        } else {
            $this->error('删除失败');
        }
    }
	
}