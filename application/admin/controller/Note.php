<?php
namespace app\admin\controller;

use app\common\model\Note as NoteModel;
use app\common\controller\AdminBase;
use think\Config;
use think\Db;
use think\Session;

/**
 * 用户管理
 * Class AdminNote
 * @package app\admin\controller
 */
class Note extends AdminBase
{
    protected $note_model;

    protected function _initialize()
    {
        parent::_initialize();
        $this->note_model = new NoteModel();
    }

    /**
     * 用户管理
     * @param string $keyword
     * @param int    $page
     * @return mixed
     */
    public function index($keyword = '', $page = 1)
    {
        $map = [];
        if ($keyword) {
            $map['a.title'] = ['like', "%{$keyword}%"];
        }
		//注册时间
        //die;
        $note_list = $this->note_model
		->alias("a")
		->field("a.id,a.title,a.lasttime,a.descc,a.jianjie,b.tname")
		->join("__NOTETYPE__ b","a.tid=b.id","LEFT")
		->where($map)
		->order('descc desc')->paginate(15, false, ['query'=>request()->param()]);
		
        $num=count($note_list);
       
        //dump($note_list);die;
        return $this->fetch('index', ['note_list' => $note_list, 'keyword' => $keyword]);
    }
    /**
     * 笔记笔记
     */
    public function province()
    {
        $id=input('id');
       
             $note_list = $this->note_model
        ->alias("a")
        ->field("a.id,a.title,a.lasttime,a.descc,a.content")
        ->where('a.id','=',$id)
        ->find();
            $wenjianlist=db('wenjian')->where('note_id','=',$id)->order('id desc')->select();
        //dump($note_list);die;
        return $this->fetch('province', ['note_list' => $note_list,'wenjianlist' => $wenjianlist]);
       
    }
    /**
     * 添加用户
     * @return mixed
     */
    public function add()
    {
		//地址
      	$note_list=Db::name("notetype")->select();
        $this->assign("note_list",$note_list);
		
		return $this->fetch();
    }



     /**
     * 查看文章
     */
    public function title($id)
    {
        $id=input('id');
        $title=db('note')->where('id','=',$id)->order('id','=',$id)->find();
        $title['content']= htmlspecialchars_decode($title['content']);
        return $title;
    }



    /**
     * 保存用户
     */
    public function save()
    {
        if ($this->request->isPost()) {
            $data            = $this->request->post();
           

                $data["lasttime"]=time();

             
                    if ($this->note_model->allowField(true)->save($data)) {
                    $this->success('保存成功');
                    } else {
                        $this->error('保存失败');
                    }
                
            
        }
    }


    public function wenjianlist($keyword = '', $page = 1)
    {
        $map = [];
        if ($keyword) {
            $map['a.title'] = ['like', "%{$keyword}%"];
        }
        //注册时间
      
        $note_list = db('wenjian')
        ->alias("a")
        ->field("a.id,a.dizhi,a.time,a.note")
        ->where($map)
        ->order('descc desc')->paginate(15, false, ['query'=>request()->param()]);
        return $this->fetch('wenjianlist', ['note_list' => $note_list, 'keyword' => $keyword]);
    }

 /**
     * 保存用户
     */
   
    /**
     * 编辑用户
     * @param $id
     * @return mixed
     */
    public function edit($id)
    {
        $note = $this->note_model->find($id);
		$note['content']= htmlspecialchars_decode($note['content']);
		//口子type
		$note_list=Db::name("notetype")->select();
		$this->assign("note_list",$note_list);
		
		return $this->fetch('edit', ['note' => $note]);
            
    }

    /**
     * 更新用户
     * @param $id
     */
    public function update($id)
    {
        if ($this->request->isPost()) {
            $data            = $this->request->post();
           
                $note           = $this->note_model->find($id);
                $note->id       = $id;
                $note->title = $data['title'];
                $note->content   = $data['content'];
                $note->lasttime =time();
				$note->types    = $data['types'];
                $note->jianjie    = $data['jianjie'];
                $note->tid    = $data['tid'];
                
				
				$note->thumb    = $data['thumb'];
				
                if ($note->save() !== false) {
                    $this->success('更新成功');
                } else {
                    $this->error('更新失败');
                }
            }
        
    }
       /**
     * 排序加一
     * @param $id
     */
    public function up($id)
    {
       
                $note           = $this->note_model->find($id);
                $note->descc = $note['descc']+1;
               
              
                if ($note->save() !== false) {
                    $this->success('更新成功');
                } else {
                    $this->error('更新失败');
                }
      
    }
	
	 public function down($id)
    {
       
                $note           = $this->note_model->find($id);
                $note->descc = $note['descc']-1;
               
              
                if ($note->save() !== false) {
                    $this->success('更新成功');
                } else {
                    $this->error('更新失败');
                }
      
    }

    /**
     * 删除用户
     * @param $id
     */
    public function delete($id)
    {

      
        if ($this->note_model->destroy($id)) {
            $this->success('删除成功');
        } else {
            $this->error('删除失败');
        }
    }
	
    public function wenjiandel($id)
    {
	  	$note = db('wenjian')->where('id','=',$id)->find($id);
        $QIMG=ROOT_PATH. DS .'public/upload'. DS .$note['urls'];
		//dump($QIMG);die;
        $wenjiandel=db('wenjian')->where('id','=',$id)->delete();
		
        if ($wenjiandel) {
            unlink($QIMG);
            $this->success('删除成功');
        } else {
            $this->error('删除失败');
        }
    }
	private function new_mid(){
		$max=$this->note_model->max("id");
		if (!$max){
			$max=0;
		}
		$max++;
		$max+=10000;
		$new_mid="M00".$max;
		return $new_mid;
	}
	/*
	*AJAX城市
	*/
	public function ajax_city(){
		$cid=$_POST["cid"];
		$city_list = Db::name('city')->where(array("pid"=>$cid))->select();
		if ($city_list){
			$str="";
			foreach ($city_list as $item){
				$str.="<option value=\"".$item["id"]."\">".$item["city_name"]."</option>\r\n";
			}
		}else{
			$str="<option value=\"\">该区域下暂无下级</option>";
		}
		echo $str;
	}
}