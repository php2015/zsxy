<?php
namespace app\api\controller;
use think\Controller;
use think\Db;
use think\Request;
use think\Session;
class Complaint extends Controller
{


    /**
     * 添加评论
     * @return int
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function comment(){
        $content = input('content');
        $type = input('type');
        $uid = session('uid');
        if(isset($uid) && !empty($uid)){
            $user = db('user')->where('id','=',$uid)->find();
            if($user){
                $data = [
                    'uid' => $uid,
                    'username' => $user['names'],
                    'mobile' => $user['mobile'],
                    'address' => $user['city'],
                    'score' => 5,
                  	'isdel' => 1,
                  	'type' => $type,
                    'content' => htmlspecialchars($content),
                    'createdAt'=>time()
                ];
                if(db('comment')->insert($data)){
                    return 1;
                }else{
                    return 0;
                }
            }
        }else{
            return 10;
        }
    }


   public function index(){
        $content = input('content');
        $type = input('type');
        $father = input('father');
        $img = input('img');
        $uid = session('uid');
        $connection = input('connection');
        if(isset($uid) && !empty($uid)){
            $user = db('user')->where('id','=',$uid)->find();
            if($user){
                $data = [
                    'uid' => $uid,
                    'username' => $user['names'],
                    'mobile' => $user['mobile'],
                    'type' => $type,
                    'father'=>$father,
                    'img' => $img,
                    'connection'=>$connection,
                    'score' => 5,
                    'content' => htmlspecialchars($content),
                  	'isdel' => 1,
                  	'status' => 1,
                    'createdAt'=>time()
                ];
                if(db('complaint')->insert($data)){
                    return 1;
                }else{
                    return 0;
                }
            }
        }else{
            return 10;
        }
    }

}