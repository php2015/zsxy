<?php

namespace app\admin\controller;

use app\common\model\Complaint as ComplaintModel;
use app\common\model\Comment as CommentModel;

use app\common\controller\AdminBase;

class Complaint extends AdminBase{


    protected function _initialize()
    {
        parent::_initialize();
        $this->complaint_model  = new ComplaintModel();
        $this->comment_model  = new CommentModel();
    }


    /**
     * 投诉列表页
     * @param string $keyword
     * @param int $page
     * @return mixed
     */
    public function index($keyword = '', $page = 1){
        $map = [];
        if ($keyword) {
            $map['a.username|a.mobile'] = ['like', "%{$keyword}%"];
        }
        $data = $this->complaint_model->alias("a")
            ->field("a.*")
            ->where($map)
            ->where('isdel','=',1)
           ->order('status ASC') ->order('createdAt DESC')->paginate(15, false, ['query'=>request()->param()]);
        $this->assign('data',$data);
        $this->assign('keyword',$keyword);
        return $this->fetch();
    }


    /**
     * 投诉编辑
     * @return mixed
     */
    public function edit(){
        $id = input('id');
        $data = $this->complaint_model->where('id','=',$id)->find();
        $this->assign('data',$data);
        return $this->fetch();
    }


    /**
     * 更新数据
     * @param $id
     */
    public function update($id)
    {
        if ($this->request->isPost()) {
            $complaint           = $this->complaint_model->find($id);
            $complaint->id       = $id;
            $complaint->status    = 2;
            if ($complaint->save() !== false) {
                $this->success('更新成功');
            } else {
                $this->error('更新失败');
            }
        }
    }


    /**
     * 删除数据
     * @param $id
     */
    public function delete($id){
            $complaint           = $this->complaint_model->find($id);
            $complaint->id       = $id;
            $complaint->isdel    = 0;
            if ($complaint->save() !== false) {
                $this->success('删除成功');
            } else {
                $this->error('删除失败');
            }
    }

}