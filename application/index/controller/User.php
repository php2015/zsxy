<?php

namespace app\index\controller;

use app\common\model\Feedback;
use think\Controller;
use think\Db;
use think\Session;

class User extends Controller
{
    public function _initialize()
    {
        parent::_initialize();
        $uid = session('uid');
        if (!isset($uid) || empty($uid)) {
            $uid = "";
        }
        if ($uid == null || $uid == "" || $uid == "null" || $uid == 0 || $uid == false) {
            return $this->redirect('index/login/logins');
        }
    }


    public function bianji()
    {
        $id = session('uid');
        $user = db('user')->where('id', '=', $id)->find();
        $this->assign('user', $user);
        return $this->fetch();
    }

    //查询记录
    public function chaxunjilu()
    {
        header("content-type:text/html;charset=utf8");
        $price = input('price');
        $name = input('name');
        if (empty($name)) {
            $name = '';
        }
        //dump($name);die;
        $pid = input('pid');
        $this->assign('pid', $pid);
        $this->assign('price', $price);
        $this->assign('name', $name);
        $id = session('uid');
        return $this->fetch();
    }

    public function chaxunjiluss()
    {
        header("content-type:text/html;charset=utf8");
        $price = input('price');
        $name = input('name');
        if (empty($name)) {
            $name = '';
        }
        //dump($name);die;
        $pid = input('pid');
        $p_id = input('p_id');
        $this->assign('p_id', $p_id);
        $this->assign('pid', $pid);
        $this->assign('price', $price);
        $this->assign('name', $name);
        $id = session('uid');
        return $this->fetch();
    }

    /**
     * 我的团队
     * @return mixed
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function tuandui($name='')
    {
        $id = session('uid');

        $user = db('user')->field('id,names,mobile,pid')->where('id','=',$id)->find();

        if(isset($user['pid']) && !empty($user['pid'])){
            $pid = $user['pid'];
        }else{
            $pid = 759;
        }
        $agent = db('user')->field('id,names,mobile,create_time')->where('id','=',$pid)->find();

        if(!empty($agent)){
            $agent['mobiles'] = substr_replace($agent["mobile"], '****', 3, 4);
        }

        $aget_sum = db('user')->field('id,pid')->where('pid','=',$id)->count('id');

        $agent_price = db('profit')->where('profit_id','=',$id)->where('type','=','二级奖励')->sum('money');

        $beginToday=mktime(0,0,0,date('m'),date('d'),date('Y'));

        $agent_price_day = db('profit')->where('profit_id','=',$id)->where('type','=','二级奖励')->where('create_time','between',[$beginToday,time()])->sum('money');

        $this->assign('name', $name);
        $this->assign('aget_sum', $aget_sum);
        $this->assign('agent_price', $agent_price);
        $this->assign('agent_price_day', $agent_price_day);
        $this->assign('agent', $agent);
        return $this->fetch();
    }


    /**
     * 团队列表
     * @return mixed
     */
    public function lists(){
        $params = $this->request->param();
        $id = session('uid');
        $agent = db('user')
            ->field('id,names,mobile,total_achievement,create_time,agent_class,pid')
            ->where('names|id|mobile','like','%'.$params['name'].'%')
            ->where('agent_class','>',1)
            ->where('pid','=',$id)
            ->order('total_achievement desc')
            ->page($params['page'],$params['limit'])->select();

        if(!empty($agent)){
            foreach($agent as $key => $value){
                $agent[$key]['create_time'] = date('Y-m-d H:i:s',$value['create_time']);
                $agent[$key]['mobile'] = substr_replace($value["mobile"], '****', 3, 4);
                $agent[$key]['type'] = $value["total_achievement"] > 0 ? '有效' : '无效';
            }
        }
        return $agent;
    }

    /**
     *  反馈
     */
    public function feedback(){
        return $this->fetch();
    }


    /**
     * 添加反馈
     * @return mixed
     */
    public function feeadd(){
        $params = $this->request->param();
        $data = [];
        $data['mobile'] = isset($params['mobile']) && !empty($params['mobile']) ? $params['mobile'] : '';
        $data['content'] = isset($params['content']) && !empty($params['content']) ? htmlspecialchars($params['content']): '';
        $data['create_time'] = time();
        $data['status'] = 0;
        $mobile = new Feedback();
        $status = $mobile->allowField(true)->save($data);
        return $status;
    }


    /**
     * 代理提现
     * @return mixed
     */
    public function usertx()
    {
        $id = session('uid');
        $user = db('user')->where('id', '=', $id)->where('status', '=', '1')->find();
        $this->assign('user', $user);
        return $this->fetch();
    }

    /**
     * 设置银行卡提现
     * @return mixed
     */
    public function userskfs()
    {
        $id = session('uid');
        $user = db('user')->where('id', '=', $id)->where('status', '=', '1')->find();
        $this->assign('user', $user);
        return $this->fetch();

    }

    /**
     * 设置支付提现
     * @return mixed
     */
    public function userskfs1()
    {
        $id = session('uid');
        $user = db('user')->where('id', '=', $id)->where('status', '=', '1')->find();
        $this->assign('user', $user);
        return $this->fetch('userskfs1');

    }


    /**
     * 基本信息
     * @return mixed
     */
    public function userinfo(){
        $id = session('uid');
        $user = db('user')->where('id', '=', $id)->where('status', '=', '1')->find();
        $this->assign('user', $user);
        return $this->fetch('userInfo');
    }


    public function touxiang()
    {
        $id = session('uid');
        if (request()->isPost()) {

            $arr = request()->file('photo');
            //$img_id=input('id');
            //$img_tname=input('tname');
            //$id=session('uid');
            //dump($id);die;
            $data = db('img_url')->where('id', '=', $id)->find();
            if ($arr) {
                $info = $arr->move(ROOT_PATH . DS . 'uploads');
                $dataimg = '/' . 'uploads' . '/' . $info->getSaveName();
                $data['thumb'] = $dataimg;
            } else {
                return $this->error('请选择图片');
            }

            //dump($data);die;
            $user = db('user')->where('id', '=', $id)->update($data);
            if ($user) {
                return $this->redirect('index/index/index');
            } else {
                return $this->error('修改头像失败');
            }
        }

        //dump($data);die;
        $data = db('user')->where('id', '=', $id)->find();
        //dump($data);die;
        $this->assign('user', $data);
        return $this->fetch();
    }
}