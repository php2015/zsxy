<?php
namespace app\index\controller;


use think\Controller;

class Borrowing extends Controller{

    public static $config = [
        'public_key' => 'MIGfMA0GCSqGSIb3DQEBAQUAA4GNADCBiQKBgQC0YkOA2dioLxPbfBn924O7Q7P9xKLAReDkZ2aNljKCwz2XwDRlU0bwQnh26HjVnwF03mw1GWlgWbKNNjIgQQw4/ywiYGG24eBS/XS8uRUDHO+rPH5vXnJPU5mv0hCo6TqPBoXdKaP93r5ZhozRxzp+UeKze6RiGEvTKiX2KD1PBQIDAQAB',
        'private_key' => 'MIICdgIBADANBgkqhkiG9w0BAQEFAASCAmAwggJcAgEAAoGBAOCAQOmvkxhtws8KcMPzvuk3Q3frCUY9CHbDWDlX2FSu/gOEMViz7sG9wYKpinfOePEwjpPoqlrLAyIDGUBeh3LK1j8RQOJcytsOggqv+kpM3nARP1teMyer6sRovYLwQyvYbhtAaF5wQ+6bWHBt0cNCziYljG79ayo0erlBm9djAgMBAAECgYEArpHsaAqX9in7juVOdIEIFe9cLlZ8erqg50DVTJnLZWZBrVhQyun3oX29iK3vN2Q9VUdtxwPn2/v67qq8KvqWlS7f1t80jT+QyXhZ1u5XMSGkB55wJcqgh/oU61tx/O0982bqbg+aE1UyGt2YTAJnwYK/QTekW0HQhyhy0gDMaikCQQDw54dA10D9Bl7As0hYowb+1lBDcPa/X9Aw8IgmPFewT5/h+r863n0cL29HUbz1tEtolJSR3RoMTvyRslJIbPXvAkEA7pGW7i3wgLx6XoTklxPpQVtU0vdrHKGWITgRG0UKmewEs7R0FCqLpano1lVpEssWy//o4UOf4XuzBMPrRyKJzQJALOWZiXYUgJONWTCQjSRlC115u/fzpJsAu/44AZhBZ3SPgZgvx5LrkjMs9AfBxbECVM1MGxsv3Zdi7uxi9WiJNQJAfLL9AWJh4+igzecI1S9DLTZgECXjhwOvRY3Y4zgjYnFLw+L/CctzUxSM7/uVAI3HTLpnL9f5KhNOb584y+XxwQJAc+EnB11CxDIXlnbx706cF6Y+X2FW1MYhcK5RW3k2SL3uZFJT9xo4Xhu/Cxtfa+3+78kss03V897JnFVGEqwixg==',
        'des_key' => 'tHcs5Zautfy3LYdAzL4dRoazSAXC83Nu',
    ];
    
    
     public function indexs(){
    	$data = self::index(['names'=>'师庆需','idcard'=>'372922198812236078','mobile'=>'18369161107']);
    	
    	echo "<pre>";var_dump($data);
    }
    

   

    public function index($params){
        $data = [
            'out_trade_no' => 'Test'.time(),
            'tran_time' => time(),
            'customer_code' => '1015491531563452',
            'verify_type' => '0535',
            'name' => $params['names'],
            'cert_no' => $params['idcard'],
            'phone' => $params['mobile'],
            'sign' => '',
        ];

        $data['sign'] = $this->privateEncrypt($this->getSignContent($data), self::$config['private_key']);
        $stream = $this->DesEncrypt(json_encode($data, 256), self::$config['des_key']);
        $str = $this->post($stream,'http://api.jizhengyun.com/v1.0/realname/1015491531563452');
        $result = json_decode($str, true);
        if(isset($result['code']) && $result['code'] == 0000){
        	$result = $result['message'];
        }else{
        	$result = [];
        }
		return $result;
    }



    public function results($params)
    {
        $result = isset($params['data']['financialMsg']) && !empty($params['data']['financialMsg']) ? $params['data']['financialMsg'] :[];

        if(!empty($result)) {
            $data = [
                "收款金额" => [
                    '最近7天收款金额' => $result['amt7DayRecv'],
                    '最近7天最大单笔收款金额' => $result['amt7DayRecvMax'],
                    '最近7天单日累计最大收款金额' => $result['amt7DayRecvMaxDay'],
                    '最近14天收款金额' => $result['amt14DayRecv'],
                    '最近14天最大单笔收款金额' => $result['amt14DayRecvMax'],
                    '最近14天单日累计最大收款金额' => $result['amt14DayRecvMaxDay'],
                    '最近1个月收款金额' => $result['amt1MonRecv'],
                    '最近1个月最大单笔收款金额' => $result['amt1MonRecvMax'],
                    '最近1个月单日累计最大收款金额' => $result['amt1MonRecvMaxDay'],
                    '最近2个月收款金额' => $result['amt2MonRecv'],
                    '最近2个月最大单笔收款金额' => $result['amt2MonRecvMax'],
                    '最近2个月单日累计最大收款金额' => $result['amt2MonRecvMaxDay'],
                    '最近3个月收款金额' => $result['amt3MonRecv'],
                    '最近3个月最大单笔收款金额' => $result['amt3MonRecvMax'],
                    '最近3个月单日累计最大收款金额' => $result['amt3MonRecvMaxDay'],
                    '最近6个月收款金额' => $result['amt6MonRecv'],
                    '最近6个月最大单笔收款金额' => $result['amt6MonRecvMax'],
                    '最近6个月单日累计最大收款金额' => ['amt6MonRecvMaxDay'],
                    '最近12个月收款金额' => $result['amt12MonRecv'],
                    '最近12个月最大单笔收款金额' => $result['amt12MonRecvMax'],
                    '最近12个月单日累计最大收款金额' => $result['amt12MonRecvMaxDay'],
                ],

                "收款笔数" => [
                    '最近7天收款笔数' => $result['cnt7DayRecv'],
                    '最近7天单日累计最多收款笔数' => $result['cnt7DayRecvMaxDay'],

                    '最近14天收款笔数' => $result['cnt14DayRecv'],
                    '最近14天单日累计最多收款笔数' => $result['cnt14DayRecvMaxDay'],

                    '最近1个月收款笔数' => $result['cnt1MonRecv'],
                    '最近1个月单日累计最多收款笔数' => $result['cnt1MonRecvMaxDay'],

                    '最近2个月收款笔数' => $result['cnt2MonRecv'],
                    '最近2个月单日累计最多收款笔数' => $result['cnt2MonRecvMaxDay'],

                    '最近3个月收款笔数' => $result['cnt3MonRecv'],
                    '最近3个月单日累计最多收款笔数' => $result['cnt3MonRecvMaxDay'],

                    '最近6个月收款笔数' => $result['cnt6MonRecv'],
                    '最近6个月单日累计最多收款笔数' => $result['cnt6MonRecvMaxDay'],

                    '最近12个月收款笔数' => $result['cnt12MonRecv'],
                    '最近12个月单日累计最多收款笔数' => $result['cnt12MonRecvMaxDay'],
                ],
                "付款金额" => [
                    '最近7天付款金额' => $result['amt7DayPay'],
                    '最近7天最大单笔付款金额' => $result['amt7DayPayMax'],
                    '最近7天单日累计最大付款金额' => $result['amt7DayPayMaxDay'],

                    '最近14天付款金额' => $result['amt14DayPay'],
                    '最近14天最大单笔付款金额' => $result['amt14DayPayMax'],
                    '最近14天单日累计最大付款金额' => $result['amt14DayPayMaxDay'],

                    '最近1个月付款金额' => $result['amt1MonPay'],
                    '最近1个月最大单笔付款金额' => $result['amt1MonPayMax'],
                    '最近1个月单日累计最大付款金额' => $result['amt1MonPayMaxDay'],

                    '最近2个月付款金额' => $result['amt2MonPay'],
                    '最近2个月最大单笔付款金额' => $result['amt2MonPayMax'],
                    '最近2个月单日累计最大付款金额' => $result['amt2MonPayMaxDay'],

                    '最近3个月付款金额' => $result['amt3MonPay'],
                    '最近3个月最大单笔付款金额' => $result['amt3MonPayMax'],
                    '最近3个月单日累计最大付款金额' => $result['amt3MonPayMaxDay'],


                    '最近6个月付款金额' => $result['amt6MonPay'],
                    '最近6个月最大单笔付款金额' => $result['amt6MonPayMax'],
                    '最近6个月单日累计最大付款金额' => $result['amt6MonPayMaxDay'],

                    '最近12个月付款金额' => $result['amt12MonPay'],
                    '最近12个月最大单笔付款金额' => $result['amt12MonPayMax'],
                    '最近12个月单日累计最大付款金额' => $result['amt12MonPayMaxDay'],
                ],

                '付款笔数' => [
                    '最近7天付款笔数' => $result['cnt7DayPay'],
                    '最近7天单日累计最多付款笔数' => $result['cnt7DayPayMaxDay'],

                    '最近14天付款笔数' => $result['cnt14DayPay'],
                    '最近14天单日累计最多付款笔数' => $result['cnt14DayPayMaxDay'],

                    '最近1个月付款笔数' => $result['cnt1MonPay'],
                    '最近1个月单日累计最多付款笔数' => $result['cnt1MonPayMaxDay'],

                    '最近2个月付款笔数' => $result['cnt2MonPay'],
                    '最近2个月单日累计最多付款笔数' => $result['cnt2MonPayMaxDay'],

                    '最近3个月付款笔数' => $result['cnt3MonPay'],
                    '最近3个月单日累计最多付款笔数' => $result['cnt3MonPayMaxDay'],

                    '最近6个月付款笔数' => $result['cnt6MonPay'],
                    '最近6个月单日累计最多付款笔数' => $result['cnt6MonPayMaxDay'],

                    '最近12个月付款笔数' => $result['cnt12MonPay'],
                    '最近12个月单日累计最多付款笔数' => $result['cnt12MonPayMaxDay'],
                ],

                '收款交易平台' => [
                    '最近7天收款平台总数' => $result['num7DayRecvMch'],
                    '最近7天收款P2P平台数' => $result['num7DayRecvP2PMch'],
                    '最近7天收款互联网信贷平台数' => $result['num7DayRecvInterCrMch'],
                    '最近7天收款消费金融平台数' => $result['num7DayRecvConsmFinMch'],

                    '最近14天收款平台总数' => $result['num14DayRecvMch'],
                    '最近14天收款P2P平台数' => $result['num14DayRecvP2PMch'],
                    '最近14天收款互联网信贷平台数' => $result['num14DayRecvInterCrMch'],
                    '最近14天收款消费金融平台数' => $result['num14DayRecvConsmFinMch'],

                    '最近1个月收款平台总数' => $result['num1MonRecvMch'],
                    '最近1个月收款P2P平台数' => $result['num1MonRecvP2PMch'],
                    '最近1个月收款互联网信贷平台数' => $result['num1MonRecvInterCrMch'],
                    '最近1个月收款消费金融平台数' => $result['num1MonRecvConsmFinMch'],

                    '最近2个月收款平台总数' => $result['num2MonRecvMch'],
                    '最近2个月收款P2P平台数' => $result['num2MonRecvP2PMch'],
                    '最近2个月收款互联网信贷平台数' => $result['num2MonRecvInterCrMch'],
                    '最近2个月收款消费金融平台数' => $result['num2MonRecvConsmFinMch'],

                    '最近3个月收款平台总数' => $result['num3MonRecvMch'],
                    '最近3个月收款P2P平台数' => $result['num3MonRecvP2PMch'],
                    '最近3个月收款互联网信贷平台数' => $result['num3MonRecvInterCrMch'],
                    '最近3个月收款消费金融平台数' => $result['num3MonRecvConsmFinMch'],


                    '最近6个月收款平台总数' => $result['num6MonRecvMch'],
                    '最近6个月收款P2P平台数' => $result['num6MonRecvP2PMch'],
                    '最近6个月收款互联网信贷平台数' => $result['num6MonRecvInterCrMch'],
                    '最近6个月收款消费金融平台数' => $result['num6MonRecvConsmFinMch'],


                    '最近12个月收款平台总数' => $result['num12MonRecvMch'],
                    '最近12个月收款P2P平台数' => $result['num12MonRecvP2PMch'],
                    '最近12个月收款互联网信贷平台数' => $result['num12MonRecvInterCrMch'],
                    '最近12个月收款消费金融平台数' => $result['num12MonRecvConsmFinMch'],

                    '近7天收款金额最大商户的行业类型' => $result['type7DayRecvMaxAmtMch'],
                    '近7天最大商户收款金额' => $result['amt7DayRecvMaxAmtMch'],
                    '近7天收款笔数最多商户的行业类型' => $result['type7DayRecvMaxCntMch'],
                    '近7天最大商户收款笔数' => $result['cnt7DayRecvMaxCntMch'],

                    '近14天收款金额最大商户的行业类型' => $result['type14DayRecvMaxAmtMch'],
                    '近14天最大商户收款金额' => $result['amt14DayRecvMaxAmtMch'],
                    '近14天收款笔数最多商户的行业类型' => $result['type14DayRecvMaxCntMch'],
                    '近14天最大商户收款笔数' => $result['cnt14DayRecvMaxCntMch'],

                    '近1个月收款金额最大商户的行业类型' => $result['type1MonRecvMaxAmtMch'],
                    '近1个月最大商户收款金额' => $result['amt1MonRecvMaxAmtMch'],
                    '近1个月收款笔数最多商户的行业类型' => $result['type1MonRecvMaxCntMch'],
                    '近1个月最大商户收款笔数' => $result['cnt1MonRecvMaxCntMch'],

                    '近6个月收款金额最大商户的行业类型' => $result['type6MonRecvMaxAmtMch'],
                    '近6个月最大商户收款金额' => $result['amt6MonRecvMaxAmtMch'],
                    '近6个月收款笔数最多商户的行业类型' => $result['type6MonRecvMaxCntMch'],
                    '近6个月最大商户收款笔数' => $result['cnt6MonRecvMaxCntMch'],

                    '近12个月收款金额最大商户的行业类型' => $result['type12MonRecvMaxAmtMch'],
                    '近12个月最大商户收款金额' => $result['amt12MonRecvMaxAmtMch'],
                    '近12个月收款笔数最多商户的行业类型' => $result['type12MonRecvMaxCntMch'],
                    '近12个月最大商户收款笔数' => $result['cnt12MonRecvMaxCntMch'],
                ],

                '付款交易平台' => [
                    '最近7天付款平台总数' => $result['num7DayPayMch'],
                    '最近7天付款P2P平台数' => $result['num7DayPayP2PMch'],
                    '最近7天付款互联网信贷平台数' => $result['num7DayPayInterCrMch'],
                    '最近7天付款消费金融平台数' => $result['num7DayPayConsmFinMch'],

                    '最近14天付款平台总数' => $result['num14DayPayMch'],
                    '最近14天付款P2P平台数' => $result['num14DayPayP2PMch'],
                    '最近14天付款互联网信贷平台数' => $result['num14DayPayInterCrMch'],
                    '最近14天付款消费金融平台数' => $result['num14DayPayConsmFinMch'],

                    '最近1个月付款平台总数' => $result['num1MonPayMch'],
                    '最近1个月付款P2P平台数' => $result['num1MonPayP2PMch'],
                    '最近1个月付款互联网信贷平台数' => $result['num1MonPayInterCrMch'],
                    '最近1个月付款消费金融平台数' => $result['num1MonPayConsmFinMch'],

                    '最近2个月付款平台总数' => $result['num2MonPayMch'],
                    '最近2个月付款P2P平台数' => $result['num2MonPayP2PMch'],
                    '最近2个月付款互联网信贷平台数' => $result['num2MonPayInterCrMch'],
                    '最近2个月付款消费金融平台数' => $result['num2MonPayConsmFinMch'],

                    '最近3个月付款平台总数' => $result['num3MonPayMch'],
                    '最近3个月付款P2P平台数' => $result['num3MonPayP2PMch'],
                    '最近3个月付款互联网信贷平台数' => $result['num3MonPayInterCrMch'],
                    '最近3个月付款消费金融平台数' => $result['num3MonPayConsmFinMch'],


                    '最近6个月付款平台总数' => $result['num6MonPayMch'],
                    '最近6个月付款P2P平台数' => $result['num6MonPayP2PMch'],
                    '最近6个月付款互联网信贷平台数' => $result['num6MonPayInterCrMch'],
                    '最近6个月付款消费金融平台数' => $result['num6MonPayConsmFinMch'],

                    '最近12个月付款平台总数' => $result['num12MonPayMch'],
                    '最近12个月付款P2P平台数' => $result['num12MonPayP2PMch'],
                    '最近12个月付款互联网信贷平台数' => $result['num12MonPayInterCrMch'],
                    '最近12个月付款消费金融平台数' => $result['num12MonPayConsmFinMch'],

                    '近7天付款金额最大商户的行业类型' => $result['type7DayPayMaxAmtMch'],
                    '近7天最大商户付款金额' => $result['amt7DayPayMaxAmtMch'],
                    '近7天付款笔数最多商户的行业类型' => $result['type7DayPayMaxCntMch'],
                    '近7天最大商户付款笔数' => $result['cnt7DayPayMaxCntMch'],
                    '近14天付款金额最大商户的行业类型' => $result['type14DayPayMaxAmtMch'],
                    '近14天最大商户付款金额' => $result['amt14DayPayMaxAmtMch'],
                    '近14天付款笔数最多商户的行业类型' => $result['type14DayPayMaxCntMch'],
                    '近14天最大商户付款笔数' => $result['cnt14DayPayMaxCntMch'],
                    '近1个月付款金额最大商户的行业类型' => $result['type1MonPayMaxAmtMch'],
                    '近1个月最大商户付款金额' => $result['amt1MonPayMaxAmtMch'],
                    '近1个月付款笔数最多商户的行业类型' => $result['type1MonPayMaxCntMch'],
                    '近1个月最大商户付款笔数' => $result['cnt1MonPayMaxCntMch'],
                    '近6个月付款金额最大商户的行业类型' => $result['type6MonPayMaxAmtMch'],
                    '近6个月最大商户付款金额' => $result['amt6MonPayMaxAmtMch'],
                    '近6个月付款笔数最多商户的行业类型' => $result['type6MonPayMaxCntMch'],
                    '近6个月最大商户付款笔数' => $result['cnt6MonPayMaxCntMch'],
                    '近12个月付款金额最大商户的行业类型' => $result['type12MonPayMaxAmtMch'],
                    '近12个月最大商户付款金额' => $result['amt12MonPayMaxAmtMch'],
                    '近12个月付款笔数最多商户的行业类型' => $result['type12MonPayMaxCntMch'],
                    '近12个月最大商户付款笔数' => $result['cnt12MonPayMaxCntMch'],
                ],

                '收款交易金额分布' => [
                    '最近7天0 - 1000的收款次数' => $result['cnt7DayRecv0to1000'],
                    '最近7天1000 - 3000的收款次数' => $result['cnt7DayRecv1000to3000'],
                    '最近7天3000 - 10000的收款次数' => $result['cnt7DayRecv3000to10000'],
                    '最近7天10000 - 50000的收款次数' => $result['cnt7DayRecv10000to50000'],
                    '最近7天50000以上收款次数' => $result['cnt7DayRecvAbove50000'],
                    '最近14天0 - 1000的收款次数' => $result['cnt14DayRecv0to1000'],
                    '最近14天1000 - 3000的收款次数' => $result['cnt14DayRecv1000to3000'],
                    '最近14天3000 - 10000的收款次数' => $result['cnt14DayRecv3000to10000'],
                    '最近14天10000 - 50000的收款次数' => $result['cnt14DayRecv10000to50000'],
                    '最近14天50000以上收款次数' => $result['cnt14DayRecvAbove50000'],
                    '最近1个月0 - 1000的收款次数' => $result['cnt1MonRecv0to1000'],
                    '最近1个月1000 - 3000的收款次数' => $result['cnt1MonRecv1000to3000'],
                    '最近1个月3000 - 10000的收款次数' => $result['cnt1MonRecv3000to10000'],
                    '最近1个月10000 - 50000的收款次数' => $result['cnt1MonRecv10000to50000'],
                    '最近1个月50000以上收款次数' => $result['cnt1MonRecvAbove50000'],
                    '最近2个月0 - 1000的收款次数' => $result['cnt2MonRecv0to1000'],
                    '最近2个月1000 - 3000的收款次数' => $result['cnt2MonRecv1000to3000'],
                    '最近2个月3000 - 10000的收款次数' => $result['cnt2MonRecv3000to10000'],
                    '最近2个月10000 - 50000的收款次数' => $result['cnt2MonRecv10000to50000'],
                    '最近2个月50000以上收款次数' => $result['cnt2MonRecvAbove50000'],
                    '最近3个月0 - 1000的收款次数' => $result['cnt3MonRecv0to1000'],
                    '最近3个月1000 - 3000的收款次数' => $result['cnt3MonRecv1000to3000'],
                    '最近3个月3000 - 10000的收款次数' => $result['cnt3MonRecv3000to10000'],
                    '最近3个月10000 - 50000的收款次数' => $result['cnt3MonRecv10000to50000'],
                    '最近3个月50000以上收款次数' => $result['cnt3MonRecvAbove50000'],
                    '最近6个月0 - 1000的收款次数' => $result['cnt6MonRecv0to1000'],
                    '最近6个月1000 - 3000的收款次数' => $result['cnt6MonRecv1000to3000'],
                    '最近6个月3000 - 10000的收款次数' => $result['cnt6MonRecv3000to10000'],
                    '最近6个月10000 - 50000的收款次数' => $result['cnt6MonRecv10000to50000'],
                    '最近6个月50000以上收款次数' => $result['cnt6MonRecvAbove50000'],
                    '最近12个月0 - 1000的收款次数' => $result['cnt12MonRecv0to1000'],
                    '最近12个月1000 - 3000的收款次数' => $result['cnt12MonRecv1000to3000'],
                    '最近12个月3000 - 10000的收款次数' => $result['cnt12MonRecv3000to10000'],
                    '最近12个月10000 - 50000的收款次数' => $result['cnt12MonRecv10000to50000'],
                    '最近12个月50000以上收款次数' => $result['cnt12MonRecvAbove50000'],
                ],

                '付款交易金额分布' => [
                    '最近7天0 - 1000的付款次数' => $result['cnt7DayPay0to1000'],
                    '最近7天1000 - 3000的付款次数' => $result['cnt7DayPay1000to3000'],
                    '最近7天3000 - 10000的付款次数' => $result['cnt7DayPay3000to10000'],
                    '最近7天10000 - 50000的付款次数' => $result['cnt7DayPay10000to50000'],
                    '最近7天50000以上付款次数' => $result['cnt7DayPayAbove50000'],
                    '最近14天0 - 1000的付款次数' => $result['cnt14DayPay0to1000'],
                    '最近14天1000 - 3000的付款次数' => $result['cnt14DayPay1000to3000'],
                    '最近14天3000 - 10000的付款次数' => $result['cnt14DayPay3000to10000'],
                    '最近14天10000 - 50000的付款次数' => $result['cnt14DayPay10000to50000'],
                    '最近14天50000以上付款次数' => $result['cnt14DayPayAbove50000'],
                    '最近1个月0 - 1000的付款次数' => $result['cnt1MonPay0to1000'],
                    '最近1个月1000 - 3000的付款次数' => $result['cnt1MonPay1000to3000'],
                    '最近1个月3000 - 10000的付款次数' => $result['cnt1MonPay3000to10000'],
                    '最近1个月10000 - 50000的付款次数' => $result['cnt1MonPay10000to50000'],
                    '最近1个月50000以上付款次数' => $result['cnt1MonPayAbove50000'],
                    '最近2个月0 - 1000的付款次数' => $result['cnt2MonPay0to1000'],
                    '最近2个月1000 - 3000的付款次数' => $result['cnt2MonPay1000to3000'],
                    '最近2个月3000 - 10000的付款次数' => $result['cnt2MonPay3000to10000'],
                    '最近2个月10000 - 50000的付款次数' => $result['cnt2MonPay10000to50000'],
                    '最近2个月50000以上付款次数' => $result['cnt2MonPayAbove50000'],
                    '最近3个月0 - 1000的付款次数' => $result['cnt3MonPay0to1000'],
                    '最近3个月1000 - 3000的付款次数' => $result['cnt3MonPay1000to3000'],
                    '最近3个月3000 - 10000的付款次数' => $result['cnt3MonPay3000to10000'],
                    '最近3个月10000 - 50000的付款次数' => $result['cnt3MonPay10000to50000'],
                    '最近3个月50000以上付款次数' => $result['cnt3MonPayAbove50000'],
                    '最近6个月0 - 1000的付款次数' => $result['cnt6MonPay0to1000'],
                    '最近6个月1000 - 3000的付款次数' => $result['cnt6MonPay1000to3000'],
                    '最近6个月3000 - 10000的付款次数' => $result['cnt6MonPay3000to10000'],
                    '最近6个月10000 - 50000的付款次数' => $result['cnt6MonPay10000to50000'],
                    '最近6个月50000以上付款次数' => $result['cnt6MonPayAbove50000'],
                    '最近12个月0 - 1000的付款次数' => $result['cnt12MonPay0to1000'],
                    '最近12个月1000 - 3000的付款次数' => $result['cnt12MonPay1000to3000'],
                    '最近12个月3000 - 10000的付款次数' => $result['cnt12MonPay3000to10000'],
                    '最近12个月10000 - 50000的付款次数' => $result['cnt12MonPay10000to50000'],
                    '最近12个月50000以上付款次数' => $result['cnt12MonPayAbove50000'],
                ],

                '收款交易时间' => [
                    '最近7天23点 - 7点收款金额' => $result['amt7DayRecvHour23to7'],
                    '最近7天23点 - 7点收款次数' => $result['cnt7DayRecvHour23to7'],

                    '最近14天23点 - 7点收款金额' => $result['amt14DayRecvHour23to7'],
                    '最近14天23点 - 7点收款次数' => $result['cnt14DayRecvHour23to7'],

                    '最近1个月23点 - 7点收款金额' => $result['amt1MonRecvHour23to7'],
                    '最近1个月23点 - 7点收款次数' => $result['cnt1MonRecvHour23to7'],

                    '最近2个月23点 - 7点收款金额' => $result['amt2MonRecvHour23to7'],
                    '最近2个月23点 - 7点收款次数' => $result['cnt2MonRecvHour23to7'],

                    '最近3个月23点 - 7点收款金额' => $result['amt3MonRecvHour23to7'],
                    '最近3个月23点 - 7点收款次数' => $result['cnt3MonRecvHour23to7'],

                    '最近6个月23点 - 7点收款金额' => $result['amt6MonRecvHour23to7'],
                    '最近6个月23点 - 7点收款次数' => $result['cnt6MonRecvHour23to7'],

                    '最近12个月23点 - 7点收款金额' => $result['amt12MonRecvHour23to7'],
                    '最近12个月23点 - 7点收款次数' => $result['cnt12MonRecvHour23to7'],
                    '近12个月最早一次收款交易日期' => $result['date12MonRecvEarliest'],
                    '近12个月最近一次收款交易日期' => $result['date12MonRecvLatest'],
                ],

                '付款交易时间' => [
                    '最近7天23点 - 7点付款金额' => $result['amt7DayPayHour23to7'],
                    '最近7天23点 - 7点付款次数' => $result['cnt7DayPayHour23to7'],

                    '最近14天23点 - 7点付款金额' => $result['amt14DayPayHour23to7'],
                    '最近14天23点 - 7点付款次数' => $result['cnt14DayPayHour23to7'],

                    '最近1个月23点 - 7点付款金额' => $result['amt1MonPayHour23to7'],
                    '最近1个月23点 - 7点付款次数' => $result['cnt1MonPayHour23to7'],

                    '最近2个月23点 - 7点付款金额' => $result['amt2MonPayHour23to7'],
                    '最近2个月23点 - 7点付款次数' => $result['cnt2MonPayHour23to7'],

                    '最近3个月23点 - 7点付款金额' => $result['amt3MonPayHour23to7'],
                    '最近3个月23点 - 7点付款次数' => $result['cnt3MonPayHour23to7'],

                    '最近6个月23点 - 7点付款金额' => $result['amt6MonPayHour23to7'],
                    '最近6个月23点 - 7点付款次数' => $result['cnt6MonPayHour23to7'],

                    '最近12个月23点 - 7点付款金额' => $result['amt12MonPayHour23to7'],
                    '最近12个月23点 - 7点付款次数' => $result['cnt12MonPayHour23to7'],
                    '近12个月最早一次付款交易日期' => $result['date12MonPayEarliest'],
                    '近12个月最近一次付款交易日期' => $result['date12MonPayLatest'],
                ],

                '扣款失败笔数' => [
                    '过去第1个月扣款失败次数' => $result['cnt1MonDeductFail'],
                    '过去第2个月扣款失败次数' => $result['cnt2MonDeductFail'],
                    '过去第3个月扣款失败次数' => $result['cnt3MonDeductFail'],
                    '过去第4个月扣款失败次数' => $result['cnt4MonDeductFail'],
                    '过去第5个月扣款失败次数' => $result['cnt5MonDeductFail'],
                    '过去第6个月扣款失败次数' => $result['cnt6MonDeductFail'],

                    '过去第1个月P2P平台扣款失败次数' => $result['cnt1MonP2pDeductFail'],
                    '过去第2个月P2P平台扣款失败次数' => $result['cnt2MonP2pDeductFail'],
                    '过去第3个月P2P平台扣款失败次数' => $result['cnt3MonP2pDeductFail'],
                    '过去第4个月P2P平台扣款失败次数' => $result['cnt5MonP2pDeductFail'],
                    '过去第6个月P2P平台扣款失败次数' => $result['cnt6MonP2pDeductFail'],

                    '过去第1个月消费金融平台扣款失败次数' => $result['cnt1MonConsmFinDeductFail'],
                    '过去第2个月消费金融平台扣款失败次数' => $result['cnt2MonConsmFinDeductFail'],
                    '过去第3个月消费金融平台扣款失败次数' => $result['cnt3MonConsmFinDeductFail'],
                    '过去第4个月消费金融平台扣款失败次数' => $result['cnt4MonConsmFinDeductFail'],
                    '过去第5个月消费金融平台扣款失败次数' => $result['cnt5MonConsmFinDeductFail'],
                    '过去第6个月消费金融平台扣款失败次数' => $result['cnt6MonConsmFinDeductFail'],

                    '过去第1个月互联网信贷平台扣款失败次数' => $result['cnt1MonInterCrDeductFail'],
                    '过去第2个月互联网信贷平台扣款失败次数' => $result['cnt2MonInterCrDeductFail'],
                    '过去第3个月互联网信贷平台扣款失败次数' => $result['cnt3MonInterCrDeductFail'],
                    '过去第4个月互联网信贷平台扣款失败次数' => $result['cnt4MonInterCrDeductFail'],
                    '过去第5个月互联网信贷平台扣款失败次数' => $result['cnt5MonInterCrDeductFail'],
                    '过去第6个月互联网信贷平台扣款失败次数' => $result['cnt6MonInterCrDeductFail'],
                ],
                '扣款失败平台数' => [
                    '过去第1个月扣款失败平台数' => $result['num1MonDeductFailMch'],
                    '过去第2个月扣款失败平台数' => $result['num2MonDeductFailMch'],
                    '过去第3个月扣款失败平台数' => $result['num3MonDeductFailMch'],
                    '过去第4个月扣款失败平台数' => $result['num4MonDeductFailMch'],
                    '过去第5个月扣款失败平台数' => $result['num5MonDeductFailMch'],
                    '过去第6个月扣款失败平台数' => $result['num6MonDeductFailMch'],
                    '过去第1个月扣款失败P2P平台数' => $result['num1MonP2pDeductFailMch'],
                    '过去第2个月扣款失败P2P平台数' => $result['num2MonP2pDeductFailMch'],
                    '过去第3个月扣款失败P2P平台数' => $result['num3MonP2pDeductFailMch'],
                    '过去第4个月扣款失败P2P平台数' => $result['num4MonP2pDeductFailMch'],
                    '过去第5个月扣款失败P2P平台数' => $result['num5MonP2pDeductFailMch'],
                    '过去第6个月扣款失败P2P平台数' => $result['num6MonP2pDeductFailMch'],
                    '过去第1个月扣款失败消费金融平台数' => $result['num1MonConsmFinDeductFailMch'],
                    '过去第2个月扣款失败消费金融平台数' => $result['num2MonConsmFinDeductFailMch'],
                    '过去第3个月扣款失败消费金融平台数' => $result['num3MonConsmFinDeductFailMch'],
                    '过去第4个月扣款失败消费金融平台数' => $result['num4MonConsmFinDeductFailMch'],
                    '过去第5个月扣款失败消费金融平台数' => $result['num5MonConsmFinDeductFailMch'],
                    '过去第6个月扣款失败消费金融平台数' => $result['num6MonConsmFinDeductFailMch'],
                    '过去第1个月扣款失败互联网信贷平台数' => $result['num1MonInterCrDeductFailMch'],
                    '过去第2个月扣款失败互联网信贷平台数' => $result['num2MonInterCrDeductFailMch'],
                    '过去第3个月扣款失败互联网信贷平台数' => $result['num3MonInterCrDeductFailMch'],
                    '过去第4个月扣款失败互联网信贷平台数' => $result['num4MonInterCrDeductFailMch'],
                    '过去第5个月扣款失败互联网信贷平台数' => $result['num5MonInterCrDeductFailMch'],
                    '过去第6个月扣款失败互联网信贷平台数' => $result['num6MonInterCrDeductFailMch'],
                ],

            ];
        }else{
            $data = [];
        }
        return $data;
    }




    /**
     * 转换数组
     * @param $data
     * @return string
     */

    function getSignContent($data)
    {
        $buff = '';

        foreach ($data as $k => $v) {
            $buff .= (!in_array($k, ['sign', 'customer_code']) && $v !== '' && !is_array($v)) ? strtoupper($k) . '=' . $v . '&' : '';
        }
        return trim($buff, '&');
    }



    /**
     * rsa 加密
     * @param $data
     * @param $key
     * @return string
     */

    public function privateEncrypt($data, $key)
    {
        $key = '-----BEGIN PRIVATE KEY-----' . PHP_EOL . wordwrap($key, 64, "\n", true) . PHP_EOL . '-----END PRIVATE KEY-----';
        $output = '';
        openssl_sign($data, $output, $key, OPENSSL_ALGO_SHA1);

        return base64_encode($output);
    }


    /**
     * 加密
     * @param $data
     * @param $key
     * @return string
     */

    public function DesEncrypt($data, $key)
    {
        $data = openssl_encrypt($data, 'DES-EDE3', $key, OPENSSL_RAW_DATA); // php7

        return strtoupper(bin2hex($data));
    }



    function Post($PostArry,$request_url)
    {
        //$postData = $PostArry;
        //$postDataString = http_build_query($postData);//格式化参数
        $curl = curl_init(); // 启动一个CURL会话
        curl_setopt($curl, CURLOPT_URL, $request_url); // 要访问的地址
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE); // 对认证证书来源的检查
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, FALSE); // 从证书中检查SSL加密算法是否存在
        curl_setopt($curl, CURLOPT_POST, true); // 发送一个常规的Post请求
        curl_setopt($curl, CURLOPT_POSTFIELDS, $PostArry); // Post提交的数据包
        curl_setopt($curl, CURLOPT_TIMEOUT, 60); // 设置超时限制防止死循环返回
        curl_setopt($curl,CURLOPT_RETURNTRANSFER,true);

        $tmpInfo = curl_exec($curl); // 执行操作
        if (curl_errno($curl)) {

            $tmpInfo = curl_error($curl);//捕抓异常
        }
        curl_close($curl); // 关闭CURL会话
        return $tmpInfo; // 返回数据
    }


}