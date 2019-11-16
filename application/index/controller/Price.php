<?php

namespace app\index\controller;

use think\Controller;
use think\Db;
use think\Session;
use think\Request;

class Price extends Controller
{
    public function pricelist()
    {
    	$uid = session('uid');
    	if($uid == 759){
    		//$goods = db('goods')->select();
    		$goods = db('goods')->where('state', '=', 1)->select();
    	}else{
    		$goods = db('goods')->where('state', '=', 1)->select();
    	}
        $this->assign('goods', $goods);
        $sy = Db::name('banner')->where(['names'=>'首页'])->order('id desc')->find();
        $this->assign('sy',$sy);
        return $this->fetch();
    }


    public function comprehensive()
    {
        $uid = session('uid');
        $goods = db('goods')->where('id', 'in', ['2', '3', '5', '6', '7'])->select();

        $user = db('user')->where('id', '=', $uid)->find();
        $bjurlone = db('bjurl')->where('id', '=', '2556')->find();
        $this->assign('bjurlone', $bjurlone);
        $this->assign('goods', $goods);
        return $this->fetch();
    }

    public function priceadd()
    {
        $goodid = input('priceid');
        $uid = session('uid');
        $user = db('user')->where('id', '=', $uid)->find();
        $goods = db('goods')->where('id', '=', $goodid)->find();
        
        $agent = db('agent')->where('id', '=', $user['agent_class'])->find();
        
        $agentgoods = db('agentgoods')->where('aid', '=', $user['agent_class'])->where('gid', '=', $goodid)->find();
        //dump($agent);die;
        $bjurl = db('bjurl')->where('id', 'not in', ['2553', '2554', '2555'])->order('id desc')->select();

        switch ($goods['id']) {
            case 5:
                $bjurlone = db('bjurl')->where('id', '=', '2553')->find();
                break;
            case 6:
                $bjurlone = db('bjurl')->where('id', '=', '2554')->find();
                break;
            case 7:
                $bjurlone = db('bjurl')->where('id', '=', '2555')->find();
                break;
            case 2:
                $bjurlone = db('bjurl')->where('tname', '=', '专业版')->find();
                break;
            case 3:
                $bjurlone = db('bjurl')->where('tname', '=', '高级版')->find();
                break;
            default:
                $bjurlone = db('bjurl')->where('id', '=', '2556')->find();

        }

        $this->assign('bjurl', $bjurl);
        $this->assign('bjurlone', $bjurlone);
        $this->assign('agentgoods', $agentgoods);
        $this->assign('agent', $agent);
        $this->assign('goods', $goods);
        $this->assign('goodid', $goodid);
        return $this->fetch();
    }


    public function add()
    {
        $uid = session('uid');
        $productname = input('productname');
        $price = input('price');
        $marks = input('marks');
        $goodid = input('goodid');
        if ($goodid == 2) {
            if ($price > 50) {
                return 50;
            }
        }

        if ($goodid == 3) {
            if ($price > 70) {
                return 99;
            }
        }

        if ($goodid == 4) {
            if ($price > 80) {
                return 25;
            }
        }

        if ($goodid == 5) {
            if ($price > 80) {
                return 25;
            }
        }

        if ($goodid == 7) {
            if ($price > 25) {
                return 25;
            }
        }

        $bid = input('bid');
        $user = db('user')->where('id', '=', $uid)->find();
        $agentgoods = db('agentgoods')->where('aid', '=', $user['agent_class'])->where('gid', '=', $goodid)->find();
        $agent = db('agent')->where('id', '=', $user['agent_class'])->find();
        if ($agent['isoem_ewm'] == 0) {
            return 5;
        }
        $goods = db('goods')->where('id', '=', $goodid)->find();

        if (!isset($goods) && empty($goods)) {
            return 0;
        }

        if (!empty($agentgoods)) {
            if ($agentgoods['price'] > $price && !in_array($uid,[759])) {
                return 2;
            }
        } else {
            if ($goods['price'] > $price && !in_array($uid,[759])) {
                return 2;
            }
        }
        $data = [
            'a_g_id' => $goodid,
            'product_name' => $goods['tname'],
            'rename' => $productname,
            'price' => $price,
            'createtime' => time(),
            'marks' => $marks,
            'uid' => $uid,
            'bgid' => $bid
        ];

        if (db('product')->insert($data)) {
            return 1;
        } else {
            return 0;
        }
    }


    public function adds()
    {
        $uid = session('uid');

        $post = Request::instance()->post();

        $data = [];
        foreach ($post as $key => $value) {
            if (is_array($value)) {
                foreach ($value as $k => $v) {
                    $data[$k][$key] = $v;
                    $data[$k]['type_status'] = $post['type_status'];
                }
            }
        }

        $pid = [];
        $user = db('user')->where('id', '=', $uid)->find();
        foreach ($data as $value) {
            switch ($value['goodid']) {
                case 2 :
                    if ($value['price'] > 50) {
                        return 50;
                    }
                    break;
                case 3 :
                    if ($value['price'] > 70) {
                        return 99;
                    }
                    break;
                case 5 :
                    if ($value['price'] > 25) {
                        return 25;
                    }
                    break;
                case 6 :
                    if ($value['price'] > 25) {
                        return 26;
                    }
                    break;
                case 7 :
                    if ($value['price'] > 25) {
                        return 27;
                    }
                    break;
            }
            $goods = db('goods')->where('id', '=', $value['goodid'])->find();

            if (!isset($goods) && empty($goods)) {
                return 0;
            }

            if (!empty($goods)) {
                if ($goods['price'] > $value['price']) {
                    return 2;
                }
            }

            $data = [
                'a_g_id' => $value['goodid'],
                'product_name' => $goods['tname'],
                'rename' => $value['productname'],
                'price' => $value['price'],
                'createtime' => time(),
                'marks' => '',
                'uid' => $uid,
                'bgid' => 2556,
                'type_status' => $value['type_status'],
            ];
            db::name('product')->insert($data);
            $statusid = db::name('product')->getLastInsID();
            $pid[] = $statusid;
        }
        $comp = [
            'pid' => implode(',', $pid),
            'uid' => $uid,
            'isdel' => 1,
            'createdAt' => time(),
        ];
        $status = db::name('comp')->insert($comp);
        if ($status) {
            return 1;
        } else {
            return 0;
        }
    }

}