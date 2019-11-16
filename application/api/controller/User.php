<?php

namespace app\api\controller;

use think\Controller;
use think\Db;
use think\Request;

class User extends Controller
{
    //编辑信息
    public function bianji()
    {
        $id = session('uid');
        $user = db('user')->where('id', '=', $id)->find();
        $datas['username'] = input('username');
        $datas['idcard'] = input('idcard');
        $datas['phone'] = input('phone');
        $userss = [
            'id' => $user['id'],
            'idcard' => $datas['idcard'],
            'create_time' => time(),
        ];
        if (db('user')->update($userss)) {
            return 1;
        } else {

            return 0;
        }
    }

    //查询记录
    public function cxjilu()
    {
        $id = session('uid');
        $times = time();
        $shijian = $times - 604800;
        $chaxun = db('chaxun')
            ->alias('c')
            ->join('sun_bairo b', 'c.id=b.chaxunid')
            ->field('c.*,b.json')
            ->where('c.uid', '=', $id)
            ->where('c.dates', '>', $shijian)
            ->order("c.id desc")->select();
        $num = count($chaxun);
        for ($i = 0; $i < $num; $i++) {
            $times = $chaxun[$i]['dates'];

            $time_js = isset($times) && !empty($times) ? date('s', $times) : 1;
            $ctime = ceil($time_js / 2);
            if ($ctime > 25) {
                $ctime = 25;
            } else {
                $ctime;
            }


            $chaxun[$i]['dates'] = date("Y-m-d H:i", $chaxun[$i]['dates']);
            $chaxun[$i]['tel'] = substr_replace($chaxun[$i]['tel'], '****', 3, 4);
            $chaxun[$i]['names'] = substr_replace($chaxun[$i]['names'], '*', 3, 3);
            $chaxun[$i]['idcard'] = substr_replace($chaxun[$i]['idcard'], '********', 6, 8);
            $chaxun[$i]['json'] = json_decode($chaxun[$i]['json'], true);
            $product = db('product')->where('id', '=', $chaxun[$i]['pid'])->find();
            $chaxun[$i]['a_g_id'] = $product['a_g_id'];
            if ($chaxun[$i]['json']['code'] == '00' or $chaxun[$i]['json']['code'] == '100002') {
                $chaxun[$i]['json']['scorecashon'] = $this->pingfen($ctime);
            } else {
                $chaxun[$i]['json']['scorecashon'] = $this->pingfen($ctime);
            }
        }
        return $chaxun;
    }


    //查询记录

    public function chaxunjil()
    {
        $params = $this->request->param();
        $id = session('uid');
        $map = [];
        $times = time();
        if (isset($params['name']) && !empty($params['name'])) {
            $map['c.names|c.tel'] = ['like', "%{$params['name']}%"];
        }
        $shijian = $times - 100*604800;
        if($id != 759){
        	$ma_id['c.ma_id|c.uid'] = $id;
        }else{
        	//$ma_id['c.ma_id|c.uid'] = $id;
        	$ma_id = [];
        }
        
        $chaxun = Db::table('sun_chaxun')
            ->alias('c')
            ->join('sun_bairo b','c.id = b.chaxunid')
            ->field('c.*,b.json,b.top_image')
            ->where($map)
            ->where($ma_id)
            ->where('c.dates', '>', $shijian)
            ->order("c.id desc")->page($params['page'], $params['limit'])->select();
        $num = count($chaxun);
        $bname = ['2' => '专业版', '3' => '资信报告', '4' => '消费评估', '5' => '用户画像'];
        for ($i = 0; $i < $num; $i++) {
            $times = $chaxun[$i]['dates'];
            $chaxun[$i]['dates'] = date("Y-m-d H:i", $chaxun[$i]['dates']);
            $chaxun[$i]['tel'] = substr_replace($chaxun[$i]['tel'], '****', 3, 4);
            $chaxun[$i]['names'] = substr_replace($chaxun[$i]['names'], '*', 3, 3);
            $chaxun[$i]['idcard'] = substr_replace($chaxun[$i]['idcard'], '********', 6, 8);
            $product = db('product')->where('id', '=', $chaxun[$i]['pid'])->find();
            $begin = mktime(0, 0, 0, date('m'), date('d') - 5, date('Y'));
            $chaxun[$i]['bname'] = isset($bname[$product['a_g_id']]) ? $bname[$product['a_g_id']] : '';
            if (in_array($product['a_g_id'], [2, 3]) and $times < $begin) {
                $timess = 2;
            }
            $chaxun[$i]['timess'] = isset($timess) ? $timess : 0;
            $chaxun[$i]['a_g_id'] = $product['a_g_id'];
            $chaxun[$i]['overdue'] = 0;
            if ($product['a_g_id'] == 3) {
                $top_image = isset($item['top_image']) && !empty($item['top_image']) ? json_decode($item['top_image'], true) : [];
                if (isset($top_image['data']['loanInfos']) && !is_null($top_image['data']['loanInfos'])) {
                    foreach ($top_image['data']['loanInfos'] as $value) {
                        if (isset($value['arrearsAmount']) && !empty($value['arrearsAmount'])) {
                            $chaxun[$i]['overdue'] += floatval($value['arrearsAmount']);
                        }
                    }
                }
            }
            $chaxun[$i]['json'] = isset($chaxun[$i]['json']) && !empty($chaxun[$i]['json']) ? json_decode($chaxun[$i]['json'], true) : [];
            if (isset($chaxun[$i]['json']) && !empty($chaxun[$i]['json'])) {
            	$time_day = mktime(0,0,0,date('m'),date('d')-5,date('Y'));
            	if($times < $time_day){
        			 $chaxun[$i]['json']['scorecashon'] = $this->pingfenss($chaxun[$i]['json']);
        		}else{
        			$chaxun[$i]['json']['scorecashon']  = $this->agent_view($chaxun[$i]['json']);
        		}
               
            } else {
                $chaxun[$i]['json']['scorecashon'] = 95;
            }
        }
        return $chaxun;
    }
    
    
    
     public function agent_view($params){
    	 if(isset($params) && !empty($params)){
    	 	$result = $params['data'];
    	 }
    	 if(isset($result['CPL0081']) && $result['CPL0081'] == 0){
    	 		$result['CPL0081'] = 5;
    	 }else if(isset($result['CPL0081']) && !empty($result['CPL0081'])){
    	 		$result['CPL0081'] = $result['CPL0081'] * 100;
    	 }else{
    	 		$result['CPL0081'] = 5;
    	 } 
    	  if(!empty($result['CPL0081']) && $result['CPL0081'] == 5){
    	 	$result['fen'] = 95;
    	 }else if(!empty($result['CPL0081']) && $result['CPL0081'] > 5){
    	 	$fen = 100 - $result['CPL0081'];
    	 	if($fen < 28){
    	 		$result['fen'] = 28;
    	 	}else{
    	 		$result['fen'] = $fen;
    	 	}
    	 }else{
    	 	$result['fen'] = 95;
    	 }

    	 return  $result['fen'];
    }
    
    


    public function pingfenss($temp_res, $dishonesty = '')
    {
        if (isset($temp_res['query_sum_count']) && !empty($temp_res['query_sum_count'])) {
            $num = !empty($temp_res['query_sum_count']) ? $temp_res['query_sum_count'] : '';
        } else {
            if (isset($temp_res['data']) && !empty($temp_res['data'])) {
                $apply_loan = ['7天内申请人在多个平台申请借款', '1个月内申请人在多个平台申请借款', '3个月内申请人在多个平台申请借款', '3个月内申请人在多个平台被放款_不包含本合作方'];
                $resk = isset($temp_res) && !empty($temp_res) ? $temp_res['data']['tongDunRep']['result_desc']['ANTIFRAUD']['risk_items'] : '';
                if (isset($resk) && !empty($resk)) {
                    foreach ($resk as $key => $value) {
                        if (!empty($value['rule_id'])) {
                            if (!empty($value['risk_detail'])) {
                                foreach ($value['risk_detail'] as $item) {
                                    if (in_array($value['risk_name'], $apply_loan)) {
                                        foreach ($item['platform_detail_dimension'] as $k => $val) {
                                            if ($value['risk_name'] == '3个月内申请人在多个平台申请借款') {
                                                $result['apply_loan']['Apply12_month'][$k] = $this->val($val, 12);
                                                $result['apply_loan']['fractions'] = $result['apply_loan']['Apply12_month'][$k]['count'];
                                            }

                                        }
                                    }
                                    if ($value['risk_name'] == '身份证命中法院失信名单') {
                                        $result['dishonesty'] = $item['court_details'];
                                    }
                                }
                            }
                        }
                    }
                }
                $num = !empty($result['apply_loan']['fractions']) ? $result['apply_loan']['fractions'] : '';
                $dishonesty = isset($result['dishonesty']) && !empty($result['dishonesty']) ? $result['dishonesty'] : '';
            }else{
                $num = 0;
            }
        }

        if (!empty($num)) {
            $fen = 100 - $num - 8;
            if ($fen < 28) {
                $fen = 28;
            }
        } else {
            $fen = 95;
        }


        //法院执行人
        if (isset($dishonesty) && !empty($dishonesty)) {
            $fen = ceil($fen / 2);
        }
        return $fen;
    }


    public function val($params, $num)
    {

        if ($num == 6) {
            $i = 1.5;
            $params['count'] = ceil($params['count'] * $i);
        }
        if ($num == 12) {
            $i = 2;
            $params['count'] = ceil($params['count'] * $i);
        }
        $a = 0;
        foreach ($params['detail'] as $key => $item) {
            $params['detail'][$key]['count'] = ceil($item['count'] * $i);
            $a = $a + $params['detail'][$key]['count'];
        }
        return $params;
    }


    public function chaxunjils()
    {
        $id = session('uid');
        $namess = input('name');

        $times = time();
        $shijian = $times - 4 * 604800;
        $map1 = [
            ['c.uid', '=', $id],
            ['c.names', '=', $namess],
        ];

        $map2 = [
            ['c.uid', '=', $id],
            ['c.tel', '=', $namess],
        ];
        $map['c.names|c.tel'] = ['like', "%{$namess}%"];
        $ma_id['c.ma_id|c.uid'] = $id;
        $chaxun = Db::table('sun_chaxun')
            ->alias('c')
            ->join('sun_bairo b', 'c.id=b.chaxunid')
            ->field('c.*,b.json,b.top_image')
            ->where($map)
            ->where($ma_id)
            ->where('c.dates', '>', $shijian)
            ->order("c.id desc")->select();

        $num = count($chaxun);
        for ($i = 0; $i < $num; $i++) {
            $times = $chaxun[$i]['dates'];

            $time_js = isset($times) && !empty($times) ? date('s', $times) : 1;
            $ctime = ceil($time_js / 2);
            if ($ctime > 25) {
                $ctime = 25;
            }
            $chaxun[$i]['dates'] = date("Y-m-d H:i", $chaxun[$i]['dates']);
            $chaxun[$i]['tel'] = substr_replace($chaxun[$i]['tel'], '****', 3, 4);
            $chaxun[$i]['names'] = substr_replace($chaxun[$i]['names'], '*', 3, 3);
            $chaxun[$i]['idcard'] = substr_replace($chaxun[$i]['idcard'], '********', 6, 8);
            $product = db('product')->where('id', '=', $chaxun[$i]['pid'])->find();
            $chaxun[$i]['a_g_id'] = $product['a_g_id'];
            $chaxun[$i]['overdue'] = 0;
            if ($product['a_g_id'] == 3) {
                $top_image = isset($item['top_image']) && !empty($item['top_image']) ? json_decode($item['top_image'], true) : [];
                if (isset($top_image['data']['loanInfos']) && !is_null($top_image['data']['loanInfos'])) {
                    foreach ($top_image['data']['loanInfos'] as $value) {
                        if (isset($value['arrearsAmount']) && !empty($value['arrearsAmount'])) {
                            $chaxun[$i]['overdue'] += floatval($value['arrearsAmount']);
                        }
                    }
                }
            }
            $chaxun[$i]['json'] = json_decode($chaxun[$i]['json'], true);
            if ($chaxun[$i]['json']['code'] == '00' or $chaxun[$i]['json']['code'] == '100002') {
                $chaxun[$i]['json']['scorecashon'] = $this->pingfen($ctime);
            } else {
                $chaxun[$i]['json']['scorecashon'] = $this->pingfen($ctime);
            }
        }
        return $chaxun;
    }

    //查询记录
    public function chaxunjilss()
    {
        $id = session('uid');
        $namess = input('name');

        $times = time();
        $shijian = $times - 30 * 604800;
        $map1 = [
            ['c.uid', '=', $id],
            ['c.names', '=', $namess],
        ];

        $map2 = [
            ['c.uid', '=', $id],
            ['c.tel', '=', $namess],
        ];
        $map['c.names|c.tel'] = ['like', "%{$namess}%"];
        $chaxun = Db::table('sun_chaxun')
            ->alias('c')
            ->join('sun_bairo b', 'c.id=b.chaxunid')
            ->field('c.*,b.json')
            ->where($map)
            ->where('c.uid', '=', $id)
            ->where('c.dates', '>', $shijian)
            ->order("c.id desc")->select();

        $num = count($chaxun);
        for ($i = 0; $i < $num; $i++) {
            $chaxun[$i]['dates'] = date("Y-m-d H:i", $chaxun[$i]['dates']);
            $chaxun[$i]['tel'] = substr_replace($chaxun[$i]['tel'], '****', 3, 4);
            $chaxun[$i]['names'] = substr_replace($chaxun[$i]['names'], '*', 3, 3);
            $chaxun[$i]['idcard'] = substr_replace($chaxun[$i]['idcard'], '********', 6, 8);
            $chaxun[$i]['json'] = json_decode($chaxun[$i]['json'], true);
            if ($chaxun[$i]['json']['code'] == '00' or $chaxun[$i]['json']['code'] == '100002') {
                $chaxun[$i]['json']['scorecashon'] = $this->pingfen($chaxun[$i]['json']);
            } else {
                $chaxun[$i]['json']['scorecashon'] = 0;
            }
        }
        return $chaxun;
    }

    public function pingfen($temp_res)
    {


        if (!empty($temp_res)) {
            $fen = 100 - $temp_res - 8;
            if ($fen < 28) {
                $fen = 28;
            }
        } else {
            $fen = 95;
        }

        return $fen;
    }

    /**
     * 收款方式
     * @return int
     * @throws \think\Exception
     * @throws \think\exception\PDOException
     */
    public function userskfs()
    {
        $id = session('uid');
        //判断提现表是否有未支付的提现有修改信息
        $withdraw = db('withdraw')->where('user_id', '=', $id)->where('status', '=', 0)->find();
        if ($withdraw) {
        		$data['type'] = input('banktype');
        	if (isset($user['banktype']) && $user['banktype'] == '支付宝') {
            		$data['bankcard'] = input('banknames');
        	}else{
            		$data['bankcard'] = input('banknumber');
        	}
            if (db('withdraw')->where('id', '=', $withdraw['id'])->update($data)) {

            } else {
                return 0;
            }
        }
        $user['banktype'] = input('banktype');
        if (isset($user['banktype']) && $user['banktype'] == '支付宝') {
            $user['bankname'] = input('banknames');
            $user['phone'] = input('phone');
        } else {
            $user['banknumber'] = input('banknumber');
            $user['phone'] = input('phone');
        }
        $user['wname'] = input('wname');
        $user['update_time'] = time();
        if (db('user')->where('id', '=', $id)->update($user)) {
            return 1;
        } else {
            return 0;
        }


    }

    /**
     * 代理提现
     * @return int
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function usertx()
    {
        $id = session('uid');
        $type = input('type');

        //查询提现人信息
        $user = db('user')->where('id', '=', $id)->where('status', '=', '1')->find();
        if(isset($type) && $type == 1){
            //判断是否绑定收款账号
            if (!isset($user['bankname']) && empty($user['bankname'])) {
                return 5;
            }
            $bankname = $user['bankname'];
            $banktype = '支付宝';
        }else{
            //判断是否绑定收款账号
            if (!isset($user['banknumber']) && empty($user['banknumber'])) {
                return 5;
            }
            //判断是否绑定收款账号
            if (!isset($user['phone']) && empty($user['phone'])) {
                return 22;
            }
            $bankname = $user['banknumber'];
            $banktype = '银行卡';
        }

        //查询是否有正在审核的订单
        $sta = db('withdraw')->where('user_id', '=', $id)->where('status', '=', '0')->find();

        $count = db('withdraw')->where('create_time', 'between', [mktime(0, 0, 0, date("m"), date("d"), date("Y")), time()])->where('user_id', '=', $id)->count();

        if ($count == 3) {
            return 88;
        }

        //订单状态修改
        if (empty($sta)) {
            $account = input('account');
            if ($account < 50) {
                return 6;
            }
            $data = [
                'user_id' => $id,
                'money' => $account,
                'type' => $banktype,
                'bankcard' => $bankname,
                'create_time' => time(),
                'operator' => '1',
            ];
            //提现的钱必须小于余额
            if ($user['money'] >= $data['money']) {
                //提现表插入
                if (db('withdraw')->insert($data)) {
                    return 1;
                } else {
                    return 0;
                }
                //余额为0提示
            } elseif ($user['money'] == 0) {
                return 2;
            } else {
                return 3;
            }
        } else {
            return 4;
        }
    }
}
