<?php

namespace app\index\controller;

use think\Controller;
use think\Db;
use think\Session;
use app\index\model\Admin;
use app\common\controller\SignatureHelper;

header("content-type:text/html;charset=utf-8");         //设置编码
class Login extends Controller
{


    /**
     * 用户登录
     * @return mixed|void
     */
    public function login()
    {
    	
        if (session('uid')) {
            return $this->redirect('index/index/index');
        }
        
        $login = Db::name('banner')->where(['names'=>'log'])->order('id desc')->find();
        $this->assign('login',$login);
        return $this->fetch();
    }


    public function ylogin()
    {
        if (session('uid')) {
            $this->redirect('index/yindex/yindex');
        }
        $jl = input('jl');
        $p_id = input('p_id');

        $this->assign('jl', $jl);
        $this->assign('p_id', $p_id);
        return $this->fetch();
    }

    public function logins()
    {
    	$login = Db::name('banner')->where(['names'=>'log'])->order('id desc')->find();
        $this->assign('login',$login);
        $p_id = input('p_id');
        $this->assign('p_id', $p_id);
        return $this->fetch();
    }

    public function daili()
    {
        $qpid = input('pid');
        if (!empty($qpid)) {
            session('pid', $qpid);
        }
        $login = Db::name('banner')->where(['names'=>'log'])->order('id desc')->find();
        $this->assign('login',$login);
        $this->assign('pid', $qpid);
        return $this->fetch();
    }

    public function zcdl()
    {


        return $this->fetch();
    }

    public function duanxin()
    {
        return $this->fetch();
    }

    /**
     * 忘记密码
     * @return mixed
     */
    public function weixin()
    {
    	$login = Db::name('banner')->where(['names'=>'log'])->order('id desc')->find();
        $this->assign('login',$login);
        return $this->fetch();
    }

    public function editpd()
    {
        return $this->fetch();
    }


    public function tuichu()
    {
        $clientIp = $this->request->ip();

        Session::delete('name');
        Session::delete('uid');
        Session::delete('isStaff');
        if (!session('name')) {
            $this->redirect('index/index/index');
        }
    }

    public function ytuichu()
    {
        $clientIp = $this->request->ip();

        Session::delete('name');
        Session::delete('uid');
        if (!session('name')) {
            $this->redirect('index/login/ylogin');
        }
    }


    public function zhuce()
    {
        $qpid = input('pid');
        if (!empty($qpid)) {
            session('pid', $qpid);
        }
        $this->assign('pid', $qpid);
        return $this->fetch();
    }

    public function protocol()
    {

        return $this->fetch();
    }

    public function protocol1()
    {

        return $this->fetch();
    }

    public function protocol2()
    {

        return $this->fetch();
    }






    public function pingfenss($temp_res, $dishonesty = '')
    {
        if (!empty($temp_res)) {
            $fen = 100 - $temp_res - 8;
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

        $grade = '无';

        switch ($fen) {
            case $fen < 52 :
                $grade = 'D';
                break;
            case $fen > 51 && $fen < 71 :
                $grade = 'C';
                break;
            case $fen > 70 && $fen < 83 :
                $grade = 'B';
                break;
            case $fen > 82 :
                $grade = 'A';
                break;
        }


        return ['fraction' => $fen, 'grade' => $grade];
    }

    public function view()
    {
        $dingdanids = input('dingdanids');
        $session_uid = session('uid');
        $this->assign("session_uid", $session_uid);
        $this->assign("dingdanid", $dingdanids);
        $chaxun = db('chaxun')->where('id', '=', $dingdanids)->find();
        $data = [];
        if (!empty($chaxun)) {
            $sales = Db::name('Sales')->where('id', '=', $chaxun['sid'])->find();
            $bairo = db('bairo')->where('chaxunid', '=', $chaxun['id'])->find();
            $dizhi = db('user')->where("mobile", "=", $chaxun['tel'])->find();
            $data['chaxun'] = $chaxun;
            $data['sales'] = $sales;
            $data['bairo'] = $bairo;
            $data['dizhi'] = $dizhi;
        }
        $user = db('user')->where("id", "=", $chaxun['ma_id'])->find();
        $agent = db('agent')->where("id", "=", $user['agent_class'])->find();
        $product = db('product')->where("id", "=", $chaxun['pid'])->find();

        $time_day = mktime(0, 0, 0, date('m'), date('d') - 8, date('Y'));
        if (in_array($product['a_g_id'], [2, 3, 5, 6, 7]) && $chaxun['dates'] < $time_day) {
            echo '<meta http-equiv="Content-Type" content="text/html; charset=utf-8" /><p style="font-size:100px;text-align: center;margin-top:500px;">报告超过7天，数据已清理，该连接已失效</p>';
            die;
        }

         $time_day = mktime(0,0,0,date('m'),date('d')-5,date('Y'));
        if($product['a_g_id'] == 3){
        	if($chaxun['dates'] < $time_day){
        		$result = $this->filter($data);
        	}else{
        		$result = $this->agent_view($data);
        	}
        }
       
        if(in_array($product['a_g_id'],[4,5])){
        	$result = $this->estimate($data);
        }

        $this->assign("agent", $agent);
        $this->assign("result", $result);
        switch ($product['a_g_id']) {
            case 5 :
                 return $this->fetch('portrait');
                break;
            case 6 :
                return $this->fetch('sview');
                break;
            case 7 :
                return $this->fetch('viewd');
                break;
            case 4:
                return $this->fetch('estimate');//estimate
                break;
            case 3:
               if($chaxun['dates'] < $time_day){
        			return $this->fetch('view');
        		}else{
        			return $this->fetch('viewagent');
        		}
                break;
            default:
                return $this->fetch();
        }

    }
    
    
    
      public function agent_view($params=''){
    	
    	 $data = isset($params['bairo']['json']) && !empty($params['bairo']['json']) ? json_decode($params['bairo']['json'], true) : '' ;
    	 if(isset($data) && !empty($data)){
    	 	$result = $data['data'];
    	 }
    	 $price = 200;
    	 
    	 if(isset($result['CPL0081']) && $result['CPL0081'] == 0){
    	 		$result['CPL0081'] = 5;
    	 }else if(isset($result['CPL0081']) && !empty($result['CPL0081'])){
    	 		$result['CPL0081'] = $result['CPL0081'] * 100;
    	 }else{
    	 		$result['CPL0081'] = 5;
    	 } 

    	 $result['CPL0082'] = isset($result['CPL0082']) && !empty($result['CPL0082']) ? $result['CPL0082'] * 100 : 10;
    	 $result['CPL0083'] = isset($result['CPL0083']) && !empty($result['CPL0083']) ? $result['CPL0083'] * 100 : 6;
    	 $result['CPL0045'] = isset($result['CPL0045']) && !empty($result['CPL0045']) ? $result['CPL0045'] : 365;
    	 $result['CPL0035'] = isset($result['CPL0035']) && !empty($result['CPL0035']) ? $result['CPL0035'] * $price : 0;
    	 $result['CPL0037'] = isset($result['CPL0037']) && !empty($result['CPL0037']) ? $result['CPL0037'] * $price : 0;
    	 $result['CPL0067'] = isset($result['CPL0067']) && !empty($result['CPL0067']) ? $result['CPL0067'] * $price : 0;
    	 $result['CPL0039'] = isset($result['CPL0039']) && !empty($result['CPL0039']) ? $result['CPL0039'] * $price : 0;
    	 $result['CPL0041'] = isset($result['CPL0041']) && !empty($result['CPL0041']) ? $result['CPL0041'] * $price : 0;
    	 $result['CPL0043'] = isset($result['CPL0043']) && !empty($result['CPL0043']) ? $result['CPL0043'] * $price : 0;
    	 $result['CPL0034'] = isset($result['CPL0034']) && !empty($result['CPL0034']) ? $result['CPL0034'] * $price : 0;
    	 $result['CPL0036'] = isset($result['CPL0036']) && !empty($result['CPL0036']) ? $result['CPL0036'] * $price : 0;
    	 $result['CPL0066'] = isset($result['CPL0066']) && !empty($result['CPL0066']) ? $result['CPL0066'] * $price : 0;
    	 $result['CPL0038'] = isset($result['CPL0038']) && !empty($result['CPL0038']) ? $result['CPL0038'] * $price : 0;
    	 $result['CPL0040'] = isset($result['CPL0040']) && !empty($result['CPL0040']) ? $result['CPL0040'] * $price : 0;
    	 $result['CPL0042'] = isset($result['CPL0042']) && !empty($result['CPL0042']) ? $result['CPL0042'] * $price : 0;
    	 
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
    	 
    	  switch ($result['fen']) {
            case $result['fen'] < 52 :
                $result['dj'] = 'D';
                break;
            case $result['fen'] > 51 && $result['fen'] < 71 :
                $result['dj'] = 'C';
                break;
            case $result['fen'] > 70 && $result['fen'] < 83 :
                $result['dj'] = 'B';
                break;
            case $result['fen'] > 82 :
                $result['dj'] = 'A';
                break;
        }
    	 $result['mobile'] = isset($params['chaxun']['tel']) && !empty($params['chaxun']['tel']) ? substr_replace($params['chaxun']['tel'], '****', 3, 4) : '' ;
         $result['opnames'] = isset($params['chaxun']['names']) && !empty($params['chaxun']['names']) ? substr_replace($params['chaxun']['names'], '*', 3, 3) : '';
         $result['opcard'] = isset($params['chaxun']['idcard']) && !empty($params['chaxun']['idcard']) ? substr_replace($params['chaxun']['idcard'], '********', 6, 8) : '';
         $result['age'] = date('Y') - substr($params['chaxun']['idcard'], 6, 4) + (date('md') >= substr($params['chaxun']['idcard'], 10, 4) ? 1 : 0);
         $result['province'] = !empty($params['dizhi']['city'])? $params['dizhi']['city'] :  $params['dizhi']['province'] . $params['dizhi']['city'] ;
         $result['transaction_id'] = !empty($params['sales']['transaction_id']) ? $params['sales']['transaction_id'] : '';
         $result['out_trade_no'] = !empty($params['sales']['out_trade_no']) ? $params['sales']['out_trade_no'] : '';
         $result['createAt'] = !empty($params['sales']['createAt']) ? date('Y-m-d H:i', $params['sales']['createAt']) : date('Y-m-d H:i', $params['chaxun']['dates']);
         $result['createAts'] = !empty($params['sales']['createAt']) ? date('Y-m-d H:i', strtotime('+ 7 day',$params['sales']['createAt'])) : date('Y-m-d H:i', strtotime('+ 7 day',$params['chaxun']['dates']));
         $result['ren'] = $this->idcards($params['chaxun']['idcard']);
    	 return $result;
    }
    
    
    
    
    
     /**
     * 消费评估 
     * 
     */
    public function estimate($params){
    	
    	 $data = isset($params['bairo']['tianyan_duotou']) && !empty($params['bairo']['tianyan_duotou']) ? json_decode($params['bairo']['tianyan_duotou'], true) : '' ;
    	 
    	 $result = $this->estimatess($data);
    	 
    	 $result['mobile'] = isset($params['chaxun']['tel']) && !empty($params['chaxun']['tel']) ? substr_replace($params['chaxun']['tel'], '****', 3, 4) : '' ;
         $result['opnames'] = isset($params['chaxun']['names']) && !empty($params['chaxun']['names']) ? substr_replace($params['chaxun']['names'], '*', 3, 3) : '';
         $result['opcard'] = isset($params['chaxun']['idcard']) && !empty($params['chaxun']['idcard']) ? substr_replace($params['chaxun']['idcard'], '********', 6, 8) : '';
         $result['age'] = date('Y') - substr($params['chaxun']['idcard'], 6, 4) + (date('md') >= substr($params['chaxun']['idcard'], 10, 4) ? 1 : 0);
         $result['province'] = !empty($params['dizhi']['city'])? $params['dizhi']['city'] :  $params['dizhi']['province'] . $params['dizhi']['city'] ;
         $result['transaction_id'] = !empty($params['sales']['transaction_id']) ? $params['sales']['transaction_id'] : '';
         $result['out_trade_no'] = !empty($params['sales']['out_trade_no']) ? $params['sales']['out_trade_no'] : '';
         $result['dates'] = !empty($params['chaxun']['dates']) ? date('Y-m-d H:i',$params['chaxun']['dates']) : '';
         $result['sex'] = $this->idcards($params['chaxun']['idcard']);
         if(isset($result) && !empty($result['account_no'])){
         	$result['account_no'] = substr_replace($result['account_no'], '***********', 4, -4);
         }else{
         	$result['account_no'] = substr_replace($params['dizhi']['banknumber'], '***********', 4, -4);
         }
    	 return $result;
    }
    
    
    /**
     * 判断身份证性别 
     * 
     */
    public function idcards($idcard){
    	if(empty($idcard)) return ''; 
    	$sexint = (int) substr($idcard, 16, 1);
    	return $sexint % 2 === 0 ? '女' : '男';
    }
    
     /**
     * 银行卡信息查询转换数据
     */ 
    public function estimatess($data){
    	$YLZC001 = ['debit'=>'借记卡','credit'=>'信用卡'];
    	$YLZC002 = ['00'=>'未知','01'=>'借记卡','02'=>'贷记卡','03'=>'准贷记卡','04'=>'借贷合一卡','05'=>'预付费卡'];
    	$YLZC003 = ['CUP'=>'62银联标准卡','VSA'=>'VISA卡','MST'=>'MASTERCARD','AME'=>'美运卡','JCB'=>'信用卡','DNC'=>'Discover卡','CUP_OLD'=>'9字头银联卡','OTH'=>'其他品牌'];
    	$YLZC007 = ['1'=>'是','0'=>'否'];
		//$YLZC009 = ['1'=>'低','2'=>'低','3'=>'中','4'=>'高','5'=>'高','6'=>'高','"null"'=>'低'];
		
		$YLZC009 = ['1'=>'（与目标生活所在地区相比）显著低','2'=>'（与目标生活所在地区相比）低','3'=>'（与目标生活所在地区相比）相当','4'=>'（与目标生活所在地区相比）高','5'=>'（与目标生活所在地区相比）显著高','6'=>'高额消费','"null"'=>'近3个月无交易'];
		
		$YLZC010 = ['1'=>'取现转账，偏向于现金交易，取款转账次数较多','2'=>'购物消费，交易偏向于线上生活购物','3'=>'高端商务差旅、出差旅行较多','4'=>'生意达人、大额对公交易偏多','5'=>'卫生医疗交易偏多','6'=>'殷实家居，家庭消费水平较高','7'=>'爱车一族的有车人士，交易场景多跟车有关','8'=>'成长家庭，家庭消费水平整体偏低','"null"'=>'近6个月无交易'];

		$YLZC011 = ['1'=>'不活跃客户、整体用卡交易行为较少','2'=>'长期忠诚客户、热衷于银行账户交易，使用三方支付较少','3'=>'近期活跃度呈上升趋势','4'=>'近期活跃活跃呈下降趋势','5'=>'自激活或新客户','6'=>'睡眠客户、近期未产生交易','"null"'=>'近12个月无交易'];
		$YLZC013 = ['1'=>'（与目标生活所在地区）消费水平增长趋势显著慢','2'=>'（与目标生活所在地区）消费水平增长趋势慢','3'=>'（与目标生活所在地区）消费水平增长趋势相当','4'=>'（与目标生活所在地区）消费水平增长趋势提升快','5'=>'（与目标生活所在地区）消费水平增长趋势显著快','6'=>'（与目标生活所在地区）趋势不稳定','"null"'=>'近6个月无交易'];
		
    	$YLZC014 = ['1'=>'高端人群:最优质客群，交易金额高，消费场所高端，客户价值很高','2'=>'文艺小资:消费场所高端，交易金额较高，但显著低于高端人群，客户价值高','3'=>'白领人士:交易金额高，消费场所档次较高，但显著低于高端人群，客户价值高','4'=>'潜力客户:消费场所高端，但交易次数少、消费金额不高，客户现有价值一般，但潜力很高','5'=>'打拼生活:消费场所档次一般，消费金额中等，客户价值中等','6'=>'大宗交易:交易金额很高，主要为批发类大宗交易，客户个人价值中低，但有较大的贷款需求和潜力','7'=>'日常超市:交易金额中等，消费场所主要为日常消费地点，客户价值中低','8'=>'小微批发:主要为批发类交易，交易金额较高，但显著低于大宗交易类客户，客户个人价值较低，但有一定的贷款需求和潜力','9'=>'低频消费：交易金额、频次低，消费集中于日常消费，客户价值低','"null"'=>'近6个月无交易'];
    	$CSSS001 = ['9991'=>'（特殊赋值）商业性消费、一次性大额消费','9992'=>'（特殊赋值）近三个月无交易行为','9993'=>'（特殊赋值）交易次数过少','"null"'=>'近6个月无交易'];
    	$YLZC017 = ['1'=>'靠后 ： 持卡人很少使用，交易特征为划卡次数很少，用卡商户类型少，总交易金额低，刷卡消费不稳定','2'=>'居中（特殊）：主要用于某一两次大额支付服务，用卡次数少、商户类型少，总划卡金额及单笔高，刷卡消费比较不稳定','3'=>'居中（专门）：主要用于某类特定商户的交易，划卡次数多，用卡商户类型少，刷卡消费比较稳定，但用卡范围比较固定','4'=>'居中（辅助）：多为首选卡金额不足情况下的辅助用卡，各项指标都较高，但明显低于靠前','5'=>'靠前：持卡人首选卡，消费频率高、类别范围广，与发卡银行业务粘合度高，刷卡消费稳定','"null"'=>'近6个月无交易'];
    	
    	$item = isset($data) && !empty($data[0]) ? $data[0] : [];
    	
    	if(isset($item)&&!empty($item)){
    	$item['YLZC005'] = isset($item) && !empty($item['YLZC005']) && $item['YLZC005'] != '"null"' ? $item['YLZC005']  : '未知';
    	
    	$item['YLZC008'] = isset($item) && !empty($item['YLZC008']) && $item['YLZC008'] != '"null"' ? $item['YLZC008']  : '未知';
    	$item['YLZC001'] = isset($item) && !empty($item['YLZC001']) ? $YLZC001[$item['YLZC001']] : '未知';
    	$item['YLZC002'] = isset($item) && !empty($item['YLZC002']) ? $YLZC002[$item['YLZC002']] : '未知';
    	$item['YLZC003'] = isset($item) && !empty($item['YLZC003']) ? $YLZC003[$item['YLZC003']] : '未知';
    	$item['YLZC007'] = isset($item) && !empty($item['YLZC007']) ? $YLZC007[$item['YLZC007']] : '否';
    	$item['YLZC009'] = isset($item) && !empty($item['YLZC009']) ? $YLZC009[$item['YLZC009']] : '未知';
    	$item['YLZC010'] = isset($item) && !empty($item['YLZC010']) ? $YLZC010[$item['YLZC010']] : '未知';
    	$item['YLZC011'] = isset($item) && !empty($item['YLZC011']) ? $YLZC011[$item['YLZC011']] : '未知';
    	$item['YLZC013'] = isset($item) && !empty($item['YLZC013']) ? $YLZC013[$item['YLZC013']] : '未知';
    	$item['YLZC014'] = isset($item) && !empty($item['YLZC014']) ? $YLZC014[$item['YLZC014']] : '未知';

    	$CSSS0012 = '';
    	switch($item['CSSS001']){
    		case $item['CSSS001'] >= 701 :
    			$CSSS0012 = '高自由度';
    			break;
    		case $item['CSSS001'] >= 301 :
    			$CSSS0012 = '高自由度';
    			break;
    		case $item['CSSS001'] <= 300 :
    			$CSSS0012 = '高自由度';
    			break;
    		default :
    			$CSSS0012 = isset($CSSS001[$item['CSSS001']]) && !empty($CSSS001[$item['CSSS001']]) ? $CSSS001[$item['CSSS001']] : '';
    			
    	}
    	
    	//echo "<pre>";
    	//var_dump($item);die;
    	$item['CSSS001'] = isset($CSSS0012) && !empty($CSSS0012) ? $CSSS0012 : '未知';
    	$item['YLZC017'] = isset($item) && !empty($item['YLZC017']) ? $YLZC017[$item['YLZC017']] : '未知';
    	
    	$item['RMS002'] = isset($item) && !empty($item['RMS002']) && $item['RMS002'] != '"null"'  ? $item['RMS002'] : '0';
    	$item['RMS003'] = isset($item) && !empty($item['RMS003']) && $item['RMS003'] != '"null"' ? $item['RMS003'] : '0';
    	
    	$item['YLZC282'] = isset($item) && !empty($item['YLZC282']) ? date('Y-m-d',strtotime($item['YLZC282'])) : '未知';
    	$item['YLZC284'] = isset($item) && !empty($item['YLZC284']) ? date('Y-m-d',strtotime(substr($item['YLZC284'],0,-6))) : '未知';
    	$item['account_no'] = isset($item) && !empty($item['account_no']) ? substr_replace($item['account_no'], '***********', 4, -4) : '未知';
    	$item['YLZC285'] = isset($item) && !empty($item['YLZC285']) && $item['YLZC285'] != '"null"'? $item['YLZC285'] : '全国';
    	}
    	return $item;
    }
    


    public function filter($params)
    {
        $data = isset($params['bairo']['json']) && !empty($params['bairo']['json']) ? json_decode($params['bairo']['json'], true) : '';
        $resk = isset($data) && !empty($data) ? $data['data']['tongDunRep']['result_desc']['ANTIFRAUD']['risk_items'] : '';
        $apply_loan = ['7天内申请人在多个平台申请借款', '1个月内申请人在多个平台申请借款', '3个月内申请人在多个平台申请借款', '3个月内申请人在多个平台被放款_不包含本合作方'];
        $attention = ['手机号命中高风险关注名单', '申请人信息命中低风险关注名单', '申请人信息命中高风险关注名单', '申请人信息命中中风险关注名单'];
        $association = ['3个月内身份证关联多个申请信息', '3个月内申请信息关联多个身份证'];
        $result = [];
        if (isset($resk) && !empty($resk)) {
            foreach ($resk as $key => $value) {
                if (!empty($value['rule_id'])) {
                    if (!empty($value['risk_detail'])) {
                        foreach ($value['risk_detail'] as $item) {
                            if (in_array($value['risk_name'], $apply_loan)) {
                                foreach ($item['platform_detail_dimension'] as $k => $val) {
                                    if ($value['risk_name'] == '7天内申请人在多个平台申请借款') {
                                        $result['one_week'] = $val['count'];
                                        $result['apply_loan']['Apply7_day'][$k] = $val;
                                    }

                                    if ($value['risk_name'] == '1个月内申请人在多个平台申请借款') {
                                        $result['January'] = $val['count'];
                                        $result['apply_loan']['Apply1_month'][$k] = $val;
                                    }

                                    if ($value['risk_name'] == '3个月内申请人在多个平台申请借款') {
                                        $result['March'] = $val['count'];
                                        $result['apply_loan']['Apply3_month'][$k] = $val;
                                        $result['apply_loan']['Apply6_month'][$k] = $this->val($val, 6);
                                        $result['apply_loan']['Apply12_month'][$k] = $this->val($val, 12);
                                        $result['June'] = $result['apply_loan']['Apply6_month'][$k]['count'];
                                        $result['apply_loan']['fractions'] = $result['apply_loan']['Apply12_month'][$k]['count'];
                                    }

                                    if ($value['risk_name'] == '3个月内申请人在多个平台被放款_不包含本合作方') {
                                        $result['apply_loan']['loan'][$k] = $val;
                                    }
                                }
                            }

                            if ($value['risk_name'] == '身份证命中法院失信名单') {
                                $result['dishonesty'] = $item['court_details'];
                            }

                            //!empty($value['rule_id']) &&  $value['risk_name'] == '身份证命中法院执行名单'
                            if (!empty($value['rule_id']) && $value['risk_name'] == '身份证命中法院结案名单') {
                                $result['carried'] = $item['court_details'];
                            }

                            if (in_array($value['risk_name'], $attention)) {
                                foreach ($item['grey_list_details'] as $i => $k) {
                                    $item['grey_list_details'][$i]['hit_type_display_name'] = $item['hit_type_display_name'];
                                }
                                $result['attention'][] = $item['grey_list_details'];
                            }


                            if (in_array($value['risk_name'], $association)) {
                                foreach ($item['frequency_detail_list'] as $i => $k) {
                                    $item['frequency_detail_list'][$i]['risk_name'] = $value['risk_name'];
                                }
                                $result['association'][$key] = $item['frequency_detail_list'];
                                $result['association'][$key] = $item['frequency_detail_list'];
                            }

                        }
                    }
                }
            }
        }

        $pingfen = $this->pingfenss(!empty($result['apply_loan']['fractions']) ? $result['apply_loan']['fractions'] : '', isset($result['dishonesty']) ? $result['dishonesty'] : '');
        $result['fraction'] = $pingfen['fraction'];
        $result['grade'] = $pingfen['grade'];
        $result['mobile'] = isset($data['data']['phone']) && !empty($data['data']['phone']) ? substr_replace($data['data']['phone'], '****', 3, 4) : '';
        $result['opnames'] = isset($data['data']['name']) && !empty($data['data']['name']) ? substr_replace($data['data']['name'], '*', 3, 3) : '';
        $result['opcard'] = isset($data['data']['identityNo']) && !empty($data['data']['identityNo']) ? substr_replace($data['data']['identityNo'], '********', 6, 8) : '';
        $result['province'] = !empty($data['data']['identityLocation'])? $data['data']['identityLocation'] :  $params['dizhi']['province'] . $params['dizhi']['city'] ;
        $result['phoneLocation'] = !empty($data['data']['phoneLocation']) ? $data['data']['phoneLocation']:'';
        $result['createAt'] = !empty($params['sales']['createAt']) ? date('Y-m-d H:i', $params['sales']['createAt']) : date('Y-m-d H:i', $params['chaxun']['dates']);

        $result['createAts'] = !empty($params['sales']['createAt']) ? date('Y-m-d H:i', strtotime('+ 7 day',$params['sales']['createAt'])) : date('Y-m-d H:i', strtotime('+ 7 day',$params['chaxun']['dates']));

        $result['ningling'] = !empty($data['data']['age']) ? $data['data']['age'] : '';
        $result['ren'] = !empty($data['data']['sex']) ? $data['data']['sex'] : '';
        $result['riskLevel'] = !empty($data['data']['riskLevel']) ? $data['data']['riskLevel'] : '';
        $result['score'] = !empty($data['data']['score']) ? $data['data']['score'] : '';

        $result['initiative'] = !empty($result['apply_loan']['fractions']) ? $result['apply_loan']['fractions'] * 5 : '未获得';

        $result['passive'] = !empty($result['apply_loan']['fractions']) ? $result['apply_loan']['fractions'] * 7 : '未获得';

        $result['blacklist'] = !empty($result['apply_loan']['fractions']) ? ceil($result['apply_loan']['fractions'] / 10) : 0;

        $result['zjblacklist'] = !empty($result['apply_loan']['fractions']) ? ceil($result['apply_loan']['fractions'] * 2.5) : 0;

        $result['December'] = !empty($result['apply_loan']['fractions']) ? $result['apply_loan']['fractions'] : 0;


        $result['transaction_id'] = !empty($params['sales']['transaction_id']) ? $params['sales']['transaction_id'] : '';

        $result['out_trade_no'] = !empty($params['sales']['out_trade_no']) ? $params['sales']['out_trade_no'] : '';

        return $result;
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


}
