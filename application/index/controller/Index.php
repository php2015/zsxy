<?php

namespace app\index\controller;

use think\Controller;
use think\Db;
use think\Session;
use orderpay\lib\IpsPaySubmit;

class Index extends Controller
{

    public function _initialize()
    {
        parent::_initialize();
        $uid = session('uid');
        if (!isset($uid) || empty($uid)) {
            $uid = "";
        }
        if ($uid == null || $uid == "" || $uid == "null" || $uid == 0 || $uid == false) {
            return $this->redirect('index/login/login');
        }
    }


    public function gzh()
    {
    	
    	$gzh = Db::name('banner')->where(['names'=>'公众号'])->order('id desc')->find();
        $this->assign('gzh',$gzh);
        return $this->fetch();
    }

    //生成网址的接口

    /**
     * [shortenSinaUrl 短网址接口]
     * @param  [integer] $long_url   需要转换的网址
     * @return [string]          [返回转结果]
     * @author king
     */
    public function shortenSinaUrl($long_url)
    {
//apikey需要自己申请  方法见网址：   http://c7.gg/page/apidoc.html
        //$apiUrl = 'https://www.98api.cn/api/wxDwz.php?url='. $long_url."?ie=UTF-8&wd=98api";
        $apiUrl = 'http://api.c7.gg/api.php?format=json&url=' . $long_url . "&apikey=oJmWtN079SVfXf9iFk@ddd";
        $curlObj = curl_init();
        curl_setopt($curlObj, CURLOPT_URL, $apiUrl);
        curl_setopt($curlObj, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curlObj, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($curlObj, CURLOPT_HEADER, 0);
        curl_setopt($curlObj, CURLOPT_HTTPHEADER, array(
            'Content-type:application/json'
        ));
        $response = curl_exec($curlObj);
        curl_close($curlObj);
        $json = json_decode($response);
        if (empty($json->error)) {
            //$url = $json->short_url;
            $url = $json->url;
        } else {
            $url = "none";
        }
        //dump($url);
        return $url;
    }


    //操作说明
    public function onenote()
    {
        $id = input('id');
        $note = Db::name('note')->where('id', '=', $id)->field('*')->find();
        $note['content'] = htmlspecialchars_decode($note['content']);
        $this->assign('note', $note);
        return $this->fetch();
    }

    public function weixin()
    {
        $hf = Db::name('banner')->where(['names'=>'客服二维码'])->order('id desc')->find();
        $this->assign('hf',$hf);
        $gzh = Db::name('banner')->where(['names'=>'公众号'])->order('id desc')->find();
        $this->assign('gzh',$gzh);
        return $this->fetch();
    }


    /**
     * 排行榜
     * @return mixed
     */
    public function bang()
    {
        $allAchieve = db('user')->field('names,mobile,total_achievement')->order('total_achievement desc')->limit(16)->select();
       
        $count = db('user')->where('agent_class','>',1)->count();
        $sum = db('user')->where('agent_class','>',1)->sum('total_achievement');
        foreach ($allAchieve as $k => $v) {
            if ($v['mobile'] == '15392157862') {
                continue;
            }
            $allAchieves[] = $v;
        }
        foreach ($allAchieves as $k => $v) {
            $allAchieves[$k]['names'] = mb_substr($v['names'], 0, 1, 'utf-8') . '***';
            $allAchieves[$k]['mobile'] = '尾号' . substr($v['mobile'], 7, 4);
        }
        $this->assign('allAchieve', $allAchieves);
        
         $ph = Db::name('banner')->where(['names'=>'排行榜'])->order('id desc')->find();
         $this->assign('ph',$ph);
         $this->assign('count',$count);
          $this->assign('sum',$sum);
        return $this->fetch();
    }


    /**
     * 个人中心
     * @return mixed
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function index()
    {
        $uid = session('uid');
        $user = db('user')->where('id', '=', $uid)->find();
        //$puser = db('user')->where('id', '=', $user['pid'])->find();
        //$agent = db('agent')->where('id', '=', $user['agent_class'])->find();
        $gonggao = db('gonggao')->select();
        $str_msg = '';
        if (!empty($gonggao)) {
            foreach ($gonggao as $item) {
                $str_msg .= '<span style="color: #fff159;">' . $item['title'] . ":" . '</span>' . $item['marks'] . '。';
            }
        }
        $user['mobile'] = substr_replace($user['mobile'], '****', 3, 4);
        $user['names'] = substr_replace($user['names'], '*', 3, 3);
        $this->assign("str_msg", $str_msg);//公告
        //幻灯片
        $profit_id = db('profit')->where(['profit_id' => $user['id'], 'type' => '提现'])->sum('money');
        $this->assign("user", $user);
        $this->assign("profit_id", $profit_id);
        
        $gr = Db::name('banner')->where(['names'=>'个人'])->order('id desc')->find();
        $this->assign('gr',$gr);
        
        return $this->fetch();
    }


    /**
     * 员工列表
     * @return mixed
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function yindex()
    {
        $isStaff = session('isStaff');
        $uid = session('uid');
        $username = Db::name('User')->where('id', '=', $uid)->find();
        if (isset($isStaff) && $isStaff == 1) {
            $user = Db::name('sales')->field('id')->where('sessionfpid', 'in', $uid)->where('status', '=', 1)->count('id');
            $startTime = mktime(0, 0, 0, date('m'), date('d'), date('y'));
            $endTime = mktime(23, 59, 59, date('m'), date('d'), date('y'));
            $maps['createAt'] = array(array('>=', $startTime), array('<=', $endTime));
            $map['create_time'] = array(array('>=', $startTime), array('<=', $endTime));
            $userDtyx = Db::name('sales')->where('sessionfpid', 'in', $uid)->where('status', '=', 1)->where($maps)->count('id');
            $userDt = Db::name('User')->where('pid', '=', $uid)->where($map)->count('id');
            $this->assign('user', $user);
            $this->assign('userDt', $userDt);
            $this->assign('userDtyx', $userDtyx);
        }
        $names = session('name');
        $this->assign('names', $names);
        $this->assign('username', $username);
        return $this->fetch();
    }

    /**
     * 注册用户明细
     * @return array|mixed
     */
    public function registeredmx()
    {
        return $this->fetch();
    }

    /**
     * 查询注册用户明细
     * @return array
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function relist()
    {
        $uid = session('uid');
        $isStaff = session('isStaff');
        $params = $this->request->param();
        $user = Db::name('User')->field('id,names,mobile,create_time')->where('pid', '=', $uid)->where('total_achievement', '=', 0)->order('create_time desc')->page($params['page'], $params['limit'])->select();
        $this->assign('user', $user);
        return ['data' => $user];
    }


    public function indexss()
    {
        $uid = session('uid');
        $user = db('user')->where('id', '=', $uid)->find();
        $puser = db('user')->where('id', '=', $user['pid'])->find();
        $agent = db('agent')->where('id', '=', $user['agent_class'])->find();
        $yeji = array();//db('profit')->where('profit_id','=',$uid)->where('type','like','%奖励')->select();

        // $userp = db('user')->where('pid','=',$uid)->select();


        $num = count($yeji);
        $sum = 0;

        for ($i = 0; $i < $num; $i++) {
            $sum += $yeji[$i]['money'];
        }
        $user['agent'] = $agent['agent_name'];
        $user['sum'] = $sum;
        $user['pname'] = $puser['names'];
        $user['pname'] = substr_replace($puser['names'], '*', 3, 3);
        if (empty($user['thumb'])) {
            $user['thumb'] = '';
        }

        $tuikuangsun = 0;//db('profit')->where('profit_id','=',$uid)->where('type','eq','退款')->sum('money');
        if (empty($tuikuangsun)) {
            $tuikuangsun = 0;
        }
        $this->assign("tuikuangsun", $tuikuangsun);
        $gonggao = db('gonggao')->select();
        $this->assign("news_list", $gonggao);//公告
        //幻灯片
        $banner = Db::name('banner')->field('*')->select();
        $bannerone = Db::name('banner')->field('*')->find();

        $ljsy = round($sum - $tuikuangsun, 2);
        $this->assign("banner", $banner);
        $this->assign("bannerone", $bannerone);
        $this->assign("user", $user);
        $this->assign("ljsy", $ljsy);
        return $this->fetch();
    }


    public function pingfen($temp_res)
    {
        if (isset($temp_res['als_m12_id_bank_allnum'])) {
            if (isset($temp_res['als_m12_id_nbank_allnum'])) {
                $max = $temp_res['als_m12_id_bank_allnum'] + $temp_res['als_m12_id_nbank_allnum'];
            } else {
                $max = $temp_res['als_m12_id_bank_allnum'];
            }
        } else {
            if (isset($temp_res['als_m12_id_nbank_allnum'])) {
                $max = $temp_res['als_m12_id_nbank_allnum'];
            } else {
                $max = 0;
            }
        }

        if (!empty($max)) {
            $fen = 100 - $max - 5;
            if ($fen < 28) {
                $fen = 28;
            }
        } else {
            $fen = 95;
        }
        return $fen;
    }


    public function mingxis($start = '', $end = '')
    {
        header("content-type:text/html;charset=utf-8");         //设置编码
        $kstime = input('kstime');
        $jstime = input('jstime');


    }


    //资金明细
    public function mingxi($start = '', $end = '')
    {
        header("content-type:text/html;charset=utf-8");         //设置编码

        $isStaff = session('isStaff');

        if (!empty($start) && !empty($end)) {
            $kstimes = strtotime($start);
            $jstimes = strtotime($end);
        } else {
            $kstimes = mktime(0, 0, 0, date('m'), date('d'), date('Y'));
            $jstimes = time();
        }
        $start1 = mktime(0, 0, 0, date('m'), date('d'), date('Y'));
        $end1 = time();


        $this->assign('start', date('Y-m-d 00:00:00', $kstimes));
        $this->assign('end', date('Y-m-d 23:59:59', $jstimes));
        $id = session('uid');
        $xiaji = db('user')->where('id', '=', $id)->find();
        //订单
        $dingdan = db('chaxun')->where('ma_id', '=', $id)->where('dates', 'between', [$kstimes, $jstimes])->count('id');
        $this->assign('dingdan', $dingdan);

        $profitsun = db('profit')->where('profit_id', '=', $id)->where('create_time', 'between', [$kstimes, $jstimes])->where('type', 'neq', '提现')->where('type', 'neq', '退款')->sum('money');

        //总收益
        if (empty($profitsun)) {
            $profitsun = 0;
        }
        $this->assign('profitsun', $profitsun);

        $profityiji = db('profit')->where('profit_id', '=', $id)->where('create_time', 'between', [$kstimes, $jstimes])->where('type', 'eq', '直推奖励')->sum('money');
        if (empty($profityiji)) {
            $profityiji = 0;
        }

        $dayprofi = db('profit')->where('profit_id', '=', $id)->where('create_time', 'between', [$start1, $end1])->where('type', 'eq', '直推奖励')->sum('money');
        if (empty($dayprofi)) {
            $dayprofi = 0;
        }

        $this->assign('dayprofi', $dayprofi);
        //一级
        $this->assign('profityiji', $profityiji);
        $profiterji = db('profit')->where('profit_id', '=', $id)->where('create_time', 'between', [$kstimes, $jstimes])->where('type', 'eq', '二级奖励')->sum('money');
        if (empty($profiterji)) {
            $profiterji = 0;
        }

        $dayprice = db('profit')->where('profit_id', '=', $id)->where('create_time', 'between', [$start1, $end1])->where('type', 'eq', '二级奖励')->sum('money');
        if (empty($dayprice)) {
            $dayprice = 0;
        }
        $this->assign('dayprice', $dayprice);
        $tuikuangsun = db('profit')->where('profit_id', '=', $id)->where('create_time', 'between', [$kstimes, $jstimes])->where('type', 'eq', '退款')->sum('money');
        if (empty($tuikuangsun)) {
            $tuikuangsun = 0;
        }
        $this->assign('tuikuangsun', $tuikuangsun);
        //二级
        $this->assign('profiterji', $profiterji);

        //er级
        $profitcont = db('profit')->where('profit_id', '=', $id)->where('create_time', 'between', [$kstimes, $jstimes])->where('type', 'eq', '二级奖励')->select();
        $profitnum = count($profitcont);
        $this->assign('profitnum', $profitnum);

        $this->assign('xiaji', $xiaji);
        $this->assign('isStaff', $isStaff);
        return $this->fetch();
    }


    /**
     * 列表数据
     * @return mixed
     */
    public function lists()
    {
        $params = $this->request->param();
        $id = session('uid');
        if (!empty($params['start']) && !empty($params['end'])) {
            $kstimes = strtotime($params['start']);
            $jstimes = strtotime($params['end']);
        } else {
            $kstimes = mktime(0, 0, 0, date('m'), date('d'), date('Y'));
            $jstimes = time();
        }
        $user = db('profit')
            ->alias("a")
            ->field("a.*,b.names,b.mobile mobilesss,b.mid,CONCAT(LEFT(c.names,1),'**') namess ,c.tel mobile")
            ->join("sun_user b", "a.profit_id=b.id", "LEFT")
            ->join("sun_chaxun c", "a.order_id=c.ordernumber", "LEFT")
            ->join("sun_user d", "c.uid=d.id", "LEFT")
            ->where('a.create_time', 'between', [$kstimes, $jstimes])
            ->where('a.profit_id', '=', $id)
            ->order(['a.id' => 'DESC'])->page($params['page'], $params['limit'])->select();
        $num = count($user);
        for ($i = 0; $i < $num; $i++) {
            $user[$i]["order_id"] = str_replace('T', 'D', $user[$i]["order_id"]);
            $userhh = db('user')
                ->alias("a")
                ->field("a.*")
                ->join("sun_chaxun c", "a.id=c.uid", "LEFT")
                ->where('c.ordernumber', '=', $user[$i]["order_id"])
                ->find();
            $user[$i]['nameshh'] = substr_replace($userhh['names'], '**', 3, 6);
            $user[$i]['tname'] = isset($user[$i]['type']) && $user[$i]['type'] == '二级奖励' ? '代理' : '用户';
            $user[$i]['mobileshh'] = substr_replace($userhh['mobile'], '***', 4, 3);
            $user[$i]['mobile'] = substr_replace($user[$i]['mobile'], '***', 4, 3);
            $user[$i]['mobilesss'] = substr_replace($user[$i]['mobilesss'], '***', 4, 3);
            $user[$i]['create'] = date('Y-m-d H:i:s', $user[$i]['create_time']);
        }
        return $user;
    }


    //资金明细
    public function mingxiss()
    {
    	$id = session('uid');
    	$alltxNum = db('withdraw')->where(['user_id' => $id,'status'=>1])->sum('money');
    	$this->assign('alltxNum',$alltxNum);
        return $this->fetch();
    }
    
    
    
    public function mixglist(){
    	$params = $this->request->param();
    
        header("content-type:text/html;charset=utf-8");
        $id = session('uid');
        $user = db('withdraw')->where(['user_id' => $id])->order('id desc')->page($params['page'], $params['limit'])->select();
        foreach ($user as $key => $val){
            $user[$key]['zhanghao'] = substr_replace($val['bankcard'], '****', 4,-3);
            $user[$key]['types'] = !empty($val['status']) && $val['status'] == 1 ? '提现成功':'待审核';
            $user[$key]['create_times'] = date('Y-m-d H:i:s',$val['create_time']);
        }
        return $user;
    }
    
    

    public function mingxissOLD()
    {
        header("content-type:text/html;charset=utf-8");         //设置编码
        $kstime = input('kstime');
        $jstime = input('jstime');
        if (!empty($kstime)) {
            $this->assign('kaishi', $kstime);
            $this->assign('jieshu', $jstime);
            $kstimes = strtotime($kstime);
            $date = date('Y-m-d', $kstimes);
            $jstimes = strtotime($jstime);
            $id = session('uid');
            $this->assign('uid', $id);
            $xiaji = db('user')->where('id', '=', $id)->find();
            $user = db('profit')
                ->alias("a")
                ->field("a.*,b.names,b.mid,CONCAT(LEFT(c.names,1),'**') namess ,c.tel mobile")
                ->join("sun_user b", "a.profit_id=b.id", "LEFT")
                ->join("sun_chaxun c", "a.order_id=c.ordernumber", "LEFT")
                ->join("sun_user d", "c.uid=d.id", "LEFT")->where('a.create_time', 'between', [$kstimes, $jstimes])
                ->where('a.profit_id', '=', $id)
                ->where('a.type', '=', '提现')
                ->order(['a.id' => 'DESC'])->select();
            $num = count($user);
            for ($i = 0; $i < $num; $i++) {
                $user[$i]['mobile'] = substr_replace($user[$i]['mobile'], '***', 7, 3);
            }
            $this->assign('xiaji', $xiaji);
            $this->assign('user', $user);
        } else {
            $kaishi = date('Y-m-d 00:00');
            $this->assign('kaishi', $kaishi);
            $kaishitime = strtotime($kaishi);
            $jieshu = date('Y-m-d 23:59');
            $jieshutime = strtotime($jieshu);
            $this->assign('jieshu', $jieshu);
            $id = session('uid');
            $this->assign('uid', $id);
            $user = db('profit')
                ->alias("a")
                ->field("a.*,b.names,b.mid,CONCAT(LEFT(c.names,1),'**') namess ,c.tel mobile")
                ->join("sun_user b", "a.profit_id=b.id", "LEFT")
                ->join("sun_chaxun c", "a.order_id=c.ordernumber", "LEFT")
                ->join("sun_user d", "c.uid=d.id", "LEFT")->where('a.create_time', 'between', [$kaishitime, $jieshutime])
                ->where('a.profit_id', '=', $id)
                ->where('a.type', '=', '提现')
                ->order(['a.id' => 'DESC'])->select();
            $num = count($user);
            for ($i = 0; $i < $num; $i++) {
                $user[$i]['mobile'] = substr_replace($user[$i]['mobile'], '***', 7, 3);
            }
            $this->assign('user', $user);
        }
        return $this->fetch();
    }

    //分享
    public function durl()
    {
        $url = $this->shortenSinaUrl("http://www.zsxycx.com/index/login/login");
        dump($url);
        die;
    }

    //选择推广页面
    //分享
    public function tuiguang()
    {
        $typeId = input('type_status');
        $yuming = $_SERVER['HTTP_HOST'];
        $a_g_id = input('a_g_id');
        if (isset($typeId) && !empty($typeId) && $typeId == 8) {
            $imgid = input('imgid');
            $url = 'http://' . $yuming . '/index/chaxun/analysis/cid/' . $imgid;
        } else {
            $imgid = input('imgid');
            switch ($a_g_id) {
                case 7:
                    $product = db('product')->where('id', '=', $imgid)->find();
                    $url = 'http://' . $yuming . '/index/chaxun/query5/price/' . $product['price'] . '/pid/' . $product['id'];
                    break;
                case 5:
                    $product = db('product')->where('id', '=', $imgid)->find();
                    $url = 'http://' . $yuming . '/index/chaxun/query2/price/' . $product['price'] . '/pid/' . $product['id'];
                    break;
                case 4:
                    $product = db('product')->where('id', '=', $imgid)->find();
                    $url = 'http://' . $yuming . '/index/chaxun/query1/price/' . $product['price'] . '/pid/' . $product['id'];
                    break;
                case 3:
                   	$product = db('product')->where('id', '=', $imgid)->find();
                    $url = 'http://' . $yuming . '/index/chaxun/query/price/' . $product['price'] . '/pid/' . $product['id'];
                    break;
                default:
                	$product = db('product')->where('id', '=', $imgid)->find();
                    $url = 'http://' . $yuming . '/index/chaxun/query/price/' . $product['price'] . '/pid/' . $product['id'];
            }
        }
        
        if (isset($lianjie) && $lianjie == 'none') {
            $lianjie = $url;
        }
        $this->assign('a_g_id', $a_g_id);
        $this->assign('imgid', $imgid);
        $this->assign('lianjie', $url);
        $this->assign('typeId', $typeId);
        return $this->fetch();
    }


    public function home()
    {
        $isStaff = session('isStaff');
        $id = session('uid');
        $product = db('product')->where('uid', '=', $id)->where('isdel', '=', 1)->where('type_status', 0)->order('id desc')->select();
        $user = db('user')->where('id', '=', $id)->find();
        $this->assign("user", $user);
        $num = count($product);
        for ($i = 0; $i < $num; $i++) {
            $agent = db('agent')->where('id', '=', $user['agent_class'])->find();
            $agentgoods = db('agentgoods')->where('aid', '=', $user['agent_class'])->where('gid', '=', $product[$i]['a_g_id'])->find();
            if ($agentgoods) {
                $product[$i]['yongjin'] = $product[$i]['price'] - $agentgoods['price'];
                $product[$i]['chengben'] = $agentgoods['price'];
            } else {
                $goods = db('goods')->where('id', '=', $product[$i]['a_g_id'])->find();
                $product[$i]['yongjin'] = $product[$i]['price'] - $goods['price'];
                $product[$i]['chengben'] = $goods['price'];
            }

        }
        $sy = Db::name('banner')->where(['names'=>'首页'])->order('id desc')->find();
        $this->assign('sy',$sy);

        $goods = db('goods')->where('state', '=', 1)->select();
        $this->assign('goods', $goods);
        $this->assign('isStaff', $isStaff);
        $this->assign('id', $id);
        $this->assign("product", $product);
        return $this->fetch();
    }


    public function fenxiang()
    {
        $isStaff = session('isStaff');
        $id = session('uid');
        $tuikuangsun = db('profit')->where('profit_id', '=', $id)->where('type', 'eq', '退款')->sum('money');
        if (empty($tuikuangsun)) {
            $tuikuangsun = 0;
        }
        $this->assign("tuikuangsun", $tuikuangsun);
        //累计收益
        $yeji = db('profit')->where('profit_id', '=', $id)->where('type', 'like', '%奖励')->select();
        $num = count($yeji);
        $sum = 0;
        for ($i = 0; $i < $num; $i++) {
            $sum += $yeji[$i]['money'];
        }
        $this->assign("sum", $sum);
        $user = db('user')->where('id', '=', $id)->find();
        $this->assign("user", $user);
        $product = db('product')->where('uid', '=', $id)->where('isdel', '=', 1)->where('type_status', 0)->order('id desc')->select();

        $comp = db('comp')->where('uid', '=', $id)->where('isdel', '=', 1)->select();

        $num = count($product);
        for ($i = 0; $i < $num; $i++) {
            $agent = db('agent')->where('id', '=', $user['agent_class'])->find();
            $agentgoods = db('agentgoods')->where('aid', '=', $user['agent_class'])->where('gid', '=', $product[$i]['a_g_id'])->find();
            if ($agentgoods) {
                $product[$i]['yongjin'] = $product[$i]['price'] - $agentgoods['price'];
                $product[$i]['chengben'] = $agentgoods['price'];
            } else {
                $goods = db('goods')->where('id', '=', $product[$i]['a_g_id'])->find();
                $product[$i]['yongjin'] = $product[$i]['price'] - $goods['price'];
                $product[$i]['chengben'] = $goods['price'];
            }

        }

        $this->assign('isStaff', $isStaff);
        $this->assign('id', $id);
        $this->assign('comp', $comp);
        $this->assign("product", $product);
        return $this->fetch();
    }


    /**
     * 版本删除
     * @return int
     * @throws \think\Exception
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     * @throws \think\exception\PDOException
     */
    public function shanchu()
    {
        $tid = input('tid');
        $data['id'] = input('pid');
        if (isset($tid) && $tid == 8) {
            $isdel['isdel'] = 0;
            $comp = db('comp')->where('id', '=', $data['id'])->find();
            $pid = explode(',', $comp['pid']);
            db('product')->where('id', 'in', $pid)->update($isdel);
            if (db('comp')->where('id', '=', $data['id'])->update($isdel)) {
                return 1;
            } else {
                return 0;
            }
        } else {
            $data['isdel'] = 0;
            if (db('product')->where('id', '=', $data['id'])->update($data)) {
                return 1;
            } else {
                return 0;
            }
        }
    }

    public function qrclist()
    {
        $p_id = input('imgid');
        $this->assign('p_id', $p_id);
        //dump($p_id);die;
        $id = session('uid');
        $imglist = db('img_qrc')->where('uid', '=', $id)->order('id desc')->select();
        $this->assign('imglist', $imglist);
        //dump($imglist);die;
        return $this->fetch();
    }

    public function del()
    {
        $id = input('id');
        if (db('img_qrc')->delete($id)) {
            $this->redirect('index/img/imglist');
        } else {
            $this->error('删除图片失败');
        }

    }

    public function add()
    {
        $id = session('uid');
        if (request()->isPost()) {

            $arr = request()->file('photo');
            //$img_id=input('id');
            $img_post = request();
            $img_tname = $img_post->post();
            //$dataduos=json_decode($img_tname,true);
            //$id=session('uid');
            //dump($img_post);die;
            // $data=db('img_url')->where('id','=',$id)->find();
            if ($arr) {
                $info = $arr->move(ROOT_PATH . DS . 'uploads');
                $dataimg = '/' . 'uploads' . '/' . $info->getSaveName();
                $data['thumb'] = $dataimg;
                $data['uid'] = $id;
                $data['tname'] = $img_tname;
                $data['descc'] = 1;
            } else {
                return $this->error('请选择图片');
            }

            //dump($data);die;
            $user = db('img_qrc')->insert($data);
            if ($user) {
                return $this->redirect('index/index/index');
            } else {
                return $this->error('修改头像失败');
            }
        }

        //dump($data);die;
        //$data=db('user')->where('id','=',$id)->find();
        //dump($data);die;
        //$this->assign('user',$data);
        return $this->fetch();
    }

    //查询结果
    public function view()
    {
        $dingdanids = input('dingdanids');
        //$dingdanids=base64_decode(base64_decode($dingdanid));
        //$dingdanids=8697;
        $session_uid = session('uid');
        $this->assign("session_uid", $session_uid);
        $chaxun = db('chaxun')->where('id', '=', $dingdanids)->find();
        $this->assign("dingdanids", $dingdanids);
        $this->assign("chaxun", $chaxun);
        //个人信息
        $op = substr_replace($chaxun['tel'], '****', 3, 4);
        $opnames = substr_replace($chaxun['names'], '*', 3, 3);
        $opcard = substr_replace($chaxun['idcard'], '********', 6, 8);
        $user = db('user')->where("id", "=", $chaxun['uid'])->find();
        $dizhi = db('user')->where("mobile", "=", $chaxun['tel'])->find();
        $agent = db('agent')->where("id", "=", $user['agent_class'])->find();
        $this->assign("agent", $agent);
        $this->assign("dizhi", $dizhi);
        $this->assign("op", $op);
        $this->assign("opnames", $opnames);
        $this->assign("opcard", $opcard);
        $product = db('product')->where("id", "=", $chaxun['pid'])->find();
        $priceid = $product['a_g_id'];
        $priceid = 3;
        $this->assign("priceid", $priceid);
        //百融
        $bairo = db('bairo')->where('chaxunid', '=', $chaxun['id'])->find();
        $temp_res_arr = $bairo['json'];
        //$matches=preg_match_all('/'.$find.'/', $temp_res_arr);
        $temp_res = json_decode($temp_res_arr, true);
        $temp_res['scorecashon'] = $this->pingfen($temp_res);
        $this->assign("temp_res", $temp_res);
        //在网时长
        $tianyan_phone = $bairo['tianyan_phone'];
        $phone = json_decode($tianyan_phone, true);
        if (isset($phone['result'])) {
            $all_user_phone = $phone['result'];
        } else {
            $all_user_phone = array();
        }
        //$all_user_phone = $phone['result'];
        $this->assign("all_user_phone", $all_user_phone);
        //实名制
        $tianyan_mobile = $bairo['tianyan_mobile'];
        $mobile = json_decode($tianyan_mobile, true);
        //$all_user_mobile = $mobile['result'];
        if (isset($mobile['result'])) {
            $all_user_mobile = $mobile['result'];
        } else {
            $all_user_mobile = array();
        }
        $this->assign("all_user_mobile", $all_user_mobile);
        //个人不良信息
        $tianyan_geren = $bairo['tianyan_geren'];
        $all_user_geren = json_decode($tianyan_geren, true);
        $this->assign("all_user_geren", $all_user_geren);
        //dump($all_user_geren);die;
        if (isset($all_user_geren['result']['lawSuitInfo'])) {
            $all_user_geren_alllist = $all_user_geren['result']['lawSuitInfo'];
        } else {
            $all_user_geren_alllist = array();
        }
        $this->assign("all_user_geren_alllist", $all_user_geren_alllist);
        //金融黑名单
        $tianyan_jinro = $bairo['tianyan_jinro'];
        $jinro = json_decode($tianyan_jinro, true);
        if (isset($jinro['result'])) {
            $all_user_jinro = $jinro['result'];
        } else {
            $all_user_jinro = array();
        }
        // $all_user_jinro = $jinro['result'];
        $this->assign("all_user_jinro", $all_user_jinro);
        //多头注册
        $tianyan_duotou = $bairo['tianyan_duotou'];
        $duotou = json_decode($tianyan_duotou, true);
        $this->assign("duotou", $duotou);
        $doutuo_s = $duotou['result']['detail'];
        if (isset($duotou['result']['detail'])) {
            $doutuo_s = $duotou['result']['detail'];
        } else {
            $doutuo_s = array();
        }
        $num = count($doutuo_s);
        if ($num == 0) {
            $all_user_duotou_zhuce = array();
            $this->assign("all_user_duotou_zhuce", $all_user_duotou_zhuce);
            $all_user_duotou_shengqin = array();
            $this->assign("all_user_duotou_shengqin", $all_user_duotou_shengqin);
            $all_user_duotou_fangkuan = array();
            $this->assign("all_user_duotou_fangkuan", $all_user_duotou_fangkuan);
            $all_user_duotou_bohui = array();
            $this->assign("all_user_duotou_bohui", $all_user_duotou_bohui);
            $all_user_duotou_yuqi = array();
            $this->assign("all_user_duotou_yuqi", $all_user_duotou_yuqi);
            $all_user_duotou_qiankaun = array();
            $this->assign("all_user_duotou_qiankaun", $all_user_duotou_qiankaun);
        }
        $all_user_duotou_zhuce = array();
        $all_user_duotou_shengqin = array();
        $all_user_duotou_fangkuan = array();
        $all_user_duotou_bohui = array();
        $all_user_duotou_yuqi = array();
        $all_user_duotou_qiankaun = array();
        for ($i = 0; $i < $num; $i++) {
            if ($doutuo_s[$i]['type'] == 'TYD002') {
                $all_user_duotou_zhuce = $doutuo_s[$i]['data'];
            }
            if ($doutuo_s[$i]['type'] == 'TYD004') {
                $all_user_duotou_shengqin = $doutuo_s[$i]['data'];
            }
            if ($doutuo_s[$i]['type'] == 'TYD007') {
                $all_user_duotou_fangkuan = $doutuo_s[$i]['data'];
            }
            if ($doutuo_s[$i]['type'] == 'TYD009') {
                $all_user_duotou_bohui = $doutuo_s[$i]['data'];
            }
            if ($doutuo_s[$i]['type'] == 'TYD012') {
                $all_user_duotou_yuqi = $doutuo_s[$i]['data'];
            }
            if ($doutuo_s[$i]['type'] == 'TYD013') {
                $all_user_duotou_qiankaun = $doutuo_s[$i]['data'];
            }
        }
        $this->assign("all_user_duotou_zhuce", $all_user_duotou_zhuce);
        $this->assign("all_user_duotou_shengqin", $all_user_duotou_shengqin);
        $this->assign("all_user_duotou_fangkuan", $all_user_duotou_fangkuan);
        $this->assign("all_user_duotou_bohui", $all_user_duotou_bohui);
        $this->assign("all_user_duotou_yuqi", $all_user_duotou_yuqi);
        $this->assign("all_user_duotou_qiankaun", $all_user_duotou_qiankaun);
        //通话记录
        $tianyan_tonghua = $bairo['tianyan_tonghua'];
        $ress = str_replace("\\", "", $tianyan_tonghua);
        //$resss_1=substr($ress, 1, -1);
        $tianyan_tonghuas = json_decode($ress);
        if (isset($tianyan_tonghuas->success)) {
            $su = $tianyan_tonghuas->success;
        } else {
            $su = false;
        }
        //dump($tianyan_tonghuas);die;
        if ($su == true) {
            $tonghuas = $tianyan_tonghuas->data;
            $tonghua_pd = 1;
        } else {
            $tonghuas = array();
            $tonghua_pd = 0;
        }
        //dump($tonghuas->active_degree_detail->no_call_day_1m);die;
        //$this->assign("tianyan_tonghuas", $tianyan_tonghuas);
        $this->assign("tonghuas", $tonghuas);
        $this->assign("tonghua_pd", $tonghua_pd);
        if (isset($tianyan_tonghuas->data->friend_circle->call_num_top3_3m)) {
            $call_num_top3_3m = $tianyan_tonghuas->data->friend_circle->call_num_top3_3m;
        } else {
            $call_num_top3_3m = array();
        }
        //dump($call_num_top3_3m[0]->peer_number);die;
        $this->assign("call_num_top3_3m", $call_num_top3_3m);
        //dump($tonghuas->friend_circle->active_degree_detail->no_call_day_1m);die;
        if (isset($tianyan_tonghuas->data->friend_circle->call_num_top3_6m)) {
            $call_num_top3_6m = $tianyan_tonghuas->data->friend_circle->call_num_top3_6m;
        } else {
            $call_num_top3_6m = array();
        }
        $this->assign("call_num_top3_6m", $call_num_top3_6m);
        //dump($call_num_top3_6m);die;
        if (isset($tianyan_tonghuas->data->friend_circle->call_contact_detail)) {
            $call_contact_detail = $tianyan_tonghuas->data->friend_circle->call_contact_detail;
        } else {
            $call_contact_detail = array();
            $call_contact_detail_s = array();
        }
        $nums = count($call_contact_detail);
        $shuliang = $agent['nums'];
        for ($a = 0; $a < $nums; $a++) {
            if ($a < $shuliang) {
                $call_contact_detail_s[$a] = $call_contact_detail[$a];
            }
        }
        $this->assign("call_contact_detail_s", $call_contact_detail_s);
        //dump($call_contact_detail_s);die;
        //dump($tonghuas);die;
        ///dump($tianyan_tonghuas->success);dump($tianyan_tonghuas);die;
        // $ress=str_replace("\\","",$res); 
        //  $resss_1=substr($ress, 1, -1);
        //  $gr1=json_decode($resss_1);
        //dump($doutuo_s);die;
        return $this->fetch('view');
    }

}