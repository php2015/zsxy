<?php

namespace app\admin\controller;

use app\common\model\Comment as CommentModel;

use app\common\controller\AdminBase;

class Comment extends AdminBase{

    protected function _initialize()
    {
        parent::_initialize();
        $this->comment_model  = new CommentModel();
    }


    /**
     * 评论列表
     * @param string $keyword
     * @param int $page
     * @return mixed
     */
    public function index($keyword = '', $page = 1){
        $map = [];
        if ($keyword) {
            $map['a.username|a.mobile'] = ['like', "%{$keyword}%"];
        }
        $data = $this->comment_model->alias("a")
            ->field("a.*")
            ->where($map)
            ->where('isdel','=',1)
            ->order('id DESC')->paginate(15, false, ['query'=>request()->param()]);
        $this->assign('data',$data);
        $this->assign('keyword',$keyword);
        return $this->fetch();
    }


    /**
     * 删除数据
     * @param $id
     */
    public function delete($id){
        $comment          = $this->comment_model->find($id);
        $comment->id       = $id;
        $comment->isdel    = 0;
        if ($comment->save() !== false) {
            $this->success('删除成功');
        } else {
            $this->error('删除失败');
        }
    }
}