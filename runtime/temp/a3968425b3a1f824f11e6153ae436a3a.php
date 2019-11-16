<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:37:"./themes/default/chaxun/yangshi3.html";i:1573121053;}*/ ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,initial-scale=1,minimum-scale=1,maximum-scale=1,user-scalable=no">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>风险报告</title>
    <link rel="stylesheet" href="__PUBLIC__/css/fxcss/mui.min.css">
    <link rel="stylesheet" href="__PUBLIC__/css/fxcss/style.css">
    <link rel="stylesheet" href="__PUBLIC__/css/fxcss/index.css?v=78945">
    <script src="__PUBLIC__/js/mui.min.js"></script>
    <script src="__PUBLIC__/js/jquery.min.js"></script>
    <script src="__PUBLIC__/js/index.js"></script>
</head>

<style>
    .lan_list_left_1 {
        font-family: PingFang-SC-Bold;
        font-size: 0.2rem;
        letter-spacing: 0px;
        color: #333333;
    }

    .lan_list_left_2 {
        font-family: PingFang-SC-Medium;
        font-size: 0.2rem;
        font-weight: normal;
        font-stretch: normal;
        letter-spacing: 0px;
        color: #5961cd;
    }

    .quota_left_2 {
        font-family: PingFang-SC-Bold;
        font-size: 71px;
        font-weight: normal;
        font-stretch: normal;
        letter-spacing: 0px;
        color: #fff36d;
    }
</style>
<body>
<div class="container">
    <div class="score_box">
        <div class="zsxy_ti">
            <img src="img/xlogo.png" alt="">
        </div>
        <div class="score_grade"><span>B级</span></div>
        <div class="star_box">
            <img src="__PUBLIC__/imgfxs/star_y.png" alt="">
            <img src="__PUBLIC__/imgfxs/star_y.png" alt="">
            <img src="__PUBLIC__/imgfxs/star_y.png" alt="">
            <img src="__PUBLIC__/imgfxs/star_y.png" alt="">
            <img src="__PUBLIC__/imgfxs/star_w.png" alt="">
        </div>
        <div class="score_num">
            <span>85</span>
        </div>
        <p class="score_user">您的评分指数</p>
        <div class="score_press">
            <div class="press_blue" id="bar" style="width: 0%;">
                <img src="__PUBLIC__/imgfxs/huojian.png" alt="">
            </div>
        </div>
        <p class="score_per">满分100分，分数越高信用越好<span id="total" style="display: none;"></span></p>
    </div>
    <p class="basic_info" style="display:none;">
        <span>基本信息</span>
    </p>
    <div class="user_card">
        <p class="username">张三&nbsp;&nbsp;35岁&nbsp;&nbsp;男</p>
        <div class="user_info">
            <p>
                <img src="__PUBLIC__/imgfxs/shoujihao.png" alt="">185****4715
            </p>
        </div>
        <div class="user_info">
            <p>
                <img src="__PUBLIC__/imgfxs/shenfenzheng.png" alt="">47154********5478
            </p>
        </div>
        <div class="user_info">
            <p>
                <img src="__PUBLIC__/imgfxs/dizhi.png" alt="">湖北武汉
            </p>
        </div>
        <p class="init_time">报告生成时间：2019-10-18 14:33:44</p>
        <p class="init_time">报告失效时间：2019-10-23 14:33:44</p>
        <div class="user_tag">
            <p><span>个人信息</span></p>
        </div>
    </div>
    <div class="quota_box">
        <div class="quota_item clearfix">
            <div class="quota_left">
                <p>信用卡预测额度</p>
                <p>5000-15000</p>
            </div>
            <div class="quota_left">
                <p>贷款预测额度</p>
                <p>8000-20000</p>
            </div>
        </div>
    </div>
    <p class="basic_info basic_info1">
        <span>信用风险评分</span>
    </p>
    <p class="subtitle"><span></span>CREDIT RISK RATING</p>
    <div class="intention_box">
        <div class="intention_wrap">
            <div class="inten_score">
                <span>100</span>
                <p>履约金额综合指数</p>
            </div>
            <div class="inten_score1">
                <span>63</span>
                <div class="clearfix"></div>
                <p>信用风险评分</p>
            </div>
            <div class="inten_score2">
                <span>86</span>
                <p>履约笔数综合指数</p>
            </div>
        </div>
        <img src="__PUBLIC__/imgfxs/xian.png">
        <p class="inten_explain">分数说明</p>
        <p class="inten_explain1">0-100之间，分数越高用户信用越低</p>
        <p class="inten_explain1">0-100之间，指数越大用户逾期可能性越高</p>
    </div>
    <p class="basic_info basic_info1">
        <span>信用逾期说明</span>
    </p>
    <p class="subtitle"><span></span>STATEMENT OF OVERDUE CREDIT</p>
    <div class="search_id loan_box">
        <div class="loan_list loan_list1">
            <p class="loan_list_left">当前是否逾期</p>
            <p class="loan_list_right">
                <span class="loan_tell">未逾期</span>
            </p>
        </div>
        <img class="xian_bor" src="__PUBLIC__/imgfxs/xian.png">
        <div class="loan_list loan_list1">
            <p class="loan_list_left">是否存在逾期未结清</p>
        </div>
        <img class="xian_bor" src="__PUBLIC__/imgfxs/xian.png">
        <div class="loan_list">
            <p class="loan_list_left">最近7天</p>
            <p class="loan_list_right">
                <span class="loan_tell">未逾期</span>
            </p>
        </div>
        <div class="loan_list">
            <p class="loan_list_left">最近14天</p>
            <p class="loan_list_right">
                <span class="loan_tell">未逾期</span>
            </p>
        </div>
        <div class="loan_list">
            <p class="loan_list_left">最近21天</p>
            <p class="loan_list_right">
                <span class="loan_tell">未逾期</span>
            </p>
        </div>
        <div class="loan_list">
            <p class="loan_list_left">最近30天</p>
            <p class="loan_list_right">
                <span class="loan_tell">未逾期</span>
            </p>
        </div>
        <img class="xian_bor loan_list2" src="__PUBLIC__/imgfxs/xian.png">
        <div class="loan_list loan_list1">
            <p class="loan_list_left">是否发生过逾期</p>
        </div>
        <div class="loan_list">
            <p class="loan_list_left">最近7天</p>
            <p class="loan_list_right">
                <span class="loan_tell">未逾期</span>
            </p>
        </div>
        <div class="loan_list">
            <p class="loan_list_left">最近14天</p>
            <p class="loan_list_right">
                <span class="loan_tell">未逾期</span>
            </p>
        </div>
        <div class="loan_list">
            <p class="loan_list_left">最近21天</p>
            <p class="loan_list_right">
                <span class="loan_tell">未逾期</span>
            </p>
        </div>
        <div class="loan_list">
            <p class="loan_list_left">最近30天</p>
            <p class="loan_list_right">
                <span class="loan_tell">未逾期</span>
            </p>
        </div>
    </div>
    <div class="dk_fate">
        <p class="fate_ti1">天数</p>
        <p class="fate_ti2">信用贷款</p>
        <div class="fate_box">783天</div>
    </div>
    <p class="basic_info basic_info1">
        <span>贷款机构数</span>
    </p>
    <p class="subtitle"><span></span>NUMBER OF LEADING INSTITUTIONS</p>
    <div class="search_id loan_box">
        <div class="loan_list loan_list1">
            <p class="loan_list_left">总机构数</p>
            <p class="loan_list_right">
                <span class="loan_tell">6</span>
            </p>
        </div>
        <div class="loan_list loan_list1">
            <p class="loan_list_left">已结清机构数</p>
            <p class="loan_list_right">
                <span class="loan_tell">6</span>
            </p>
        </div>
        <img class="xian_bor" src="__PUBLIC__/imgfxs/xian.png">
        <div class="loan_list loan_list1">
            <p class="loan_list_left">贷款机构数</p>
        </div>
        <div class="loan_list">
            <p class="loan_list_left">最近7天</p>
            <p class="loan_list_right">
                <span class="loan_tell">0</span>
            </p>
        </div>
        <div class="loan_list">
            <p class="loan_list_left">最近14天</p>
            <p class="loan_list_right">
                <span class="loan_tell">0</span>
            </p>
        </div>
        <div class="loan_list">
            <p class="loan_list_left">最近21天</p>
            <p class="loan_list_right">
                <span class="loan_tell">0</span>
            </p>
        </div>
        <div class="loan_list">
            <p class="loan_list_left">最近30天</p>
            <p class="loan_list_right">
                <span class="loan_tell">0</span>
            </p>
        </div>
        <div class="loan_list">
            <p class="loan_list_left">最近90天</p>
            <p class="loan_list_right">
                <span class="loan_tell">0</span>
            </p>
        </div>
        <div class="loan_list">
            <p class="loan_list_left">最近180天</p>
            <p class="loan_list_right">
                <span class="loan_tell">0</span>
            </p>
        </div>
    </div>
    <div class="quota_box">
        <div class="quota_item quota_item2 clearfix">
            <div class="quota_left">
                <p>0</p>
                <p>信用卡预测额度</p>
                <p>5000-15000</p>
            </div>
            <div class="quota_left">
                <p>0</p>
                <p>贷款预测额度</p>
                <p>8000-20000</p>
            </div>
        </div>
    </div>
    <p class="basic_info basic_info1">
        <span>交易失败笔数/金额</span>
    </p>
    <p class="subtitle"><span></span>NUMBER OF FAILED TRADES</p>
    <div class="search_id loan_box">
        <div class="loan_list loan_list1">
            <p class="loan_list_left">历史贷款机构交易失败笔数</p>
            <p class="loan_list_right">
                <span class="loan_tell">8笔</span>
            </p>
        </div>
        <img class="xian_bor" src="__PUBLIC__/imgfxs/xian.png">
        <div class="trade_tabbox">
            <table class="trade_tab">
                <tr>
                    <td></td>
                    <td>交易失败笔数</td>
                    <td>交易失败金额</td>
                </tr>
                <tr>
                    <td>最近7天</td>
                    <td>0</td>
                    <td>0</td>
                </tr>
                <tr>
                    <td>最近14天</td>
                    <td>0</td>
                    <td>0</td>
                </tr>
                <tr>
                    <td>最近21天</td>
                    <td>0</td>
                    <td>0</td>
                </tr>
                <tr>
                    <td>最近30天</td>
                    <td>0</td>
                    <td>0</td>
                </tr>
                <tr>
                    <td>最近90天</td>
                    <td>0</td>
                    <td>0</td>
                </tr>
                <tr>
                    <td>最近180天</td>
                    <td>0</td>
                    <td>0</td>
                </tr>
            </table>
        </div>
    </div>
    <p class="basic_info basic_info1">
        <span>还款成功笔数/金额</span>
    </p>
    <p class="subtitle"><span></span>NUMBER OF SUCCESS TRADES</p>
    <div class="search_id loan_box">
        <div class="loan_list loan_list1">
            <p class="loan_list_left">历史贷款机构成功还款笔数</p>
            <p class="loan_list_right">
                <span class="loan_tell">12笔</span>
            </p>
        </div>
        <img class="xian_bor" src="__PUBLIC__/imgfxs/xian.png">
        <div class="trade_tabbox">
            <table class="trade_tab">
                <tr>
                    <td></td>
                    <td>还款成功笔数</td>
                    <td>还款成功金额(元)</td>
                </tr>
                <tr>
                    <td>最近7天</td>
                    <td>0</td>
                    <td>0</td>
                </tr>
                <tr>
                    <td>最近14天</td>
                    <td>0</td>
                    <td>0</td>
                </tr>
                <tr>
                    <td>最近21天</td>
                    <td>0</td>
                    <td>0</td>
                </tr>
                <tr>
                    <td>最近30天</td>
                    <td>0</td>
                    <td>0</td>
                </tr>
                <tr>
                    <td>最近90天</td>
                    <td>0</td>
                    <td>0</td>
                </tr>
                <tr>
                    <td>最近180天</td>
                    <td>0</td>
                    <td>0</td>
                </tr>
            </table>
        </div>
    </div>


    <p class="basic_info basic_info1">
        <span>消费金融类</span>
    </p>
    <p class="subtitle"><span></span>CONSUMER FINANCE</p>
    <div class="search_id loan_box">
        <div class="loan_list loan_list1">
            <p class="loan_list_left lan_list_left_1" style="font-size: 0.2rem;">最后一次交易失败后还款次数</p>
            <p class="loan_list_right">
                <span class="loan_tell lan_list_left_2" style="font-size: 0.2rem;">12次</span>
            </p>
        </div>
        <img class="xian_bor" src="__PUBLIC__/imgfxs/xian.png">
        <div class="loan_list loan_list1">
            <p class="loan_list_left lan_list_left_1" style="font-size: 0.2rem;">交易失败到下一次还款成功最短天数</p>
            <p class="loan_list_right">
                <span class="loan_tell lan_list_left_2" style="font-size: 0.2rem;">15天</span>
            </p>
        </div>
        <img class="xian_bor" src="__PUBLIC__/imgfxs/xian.png">
        <div class="loan_list loan_list1">
            <p class="loan_list_left lan_list_left_1" style="font-size: 0.2rem;">交易失败到下一次还款成功最长天数</p>
            <p class="loan_list_right">
                <span class="loan_tell lan_list_left_2" style="font-size: 0.2rem;">12天</span>
            </p>
        </div>
        <img class="xian_bor" src="__PUBLIC__/imgfxs/xian.png">
        <div class="loan_list loan_list1">
            <p class="loan_list_left lan_list_left_1" style="font-size: 0.2rem;">交易失败到下一次还款成功的平均天数</p>
            <p class="loan_list_right">
                <span class="loan_tell lan_list_left_2" style="font-size: 0.2rem;">1天</span>
            </p>
        </div>
        <img class="xian_bor" src="__PUBLIC__/imgfxs/xian.png">
    </div>


    <p class="basic_info basic_info1">
        <span>小贷担保类</span>
    </p>
    <p class="subtitle"><span></span>SMALL LOAN GUARANTEE CLASS</p>
    <div class="search_id loan_box">
        <div class="loan_list loan_list1">
            <p class="loan_list_left lan_list_left_1" style="font-size: 0.2rem;">最后一次交易失败后还款次数</p>
            <p class="loan_list_right">
                <span class="loan_tell lan_list_left_2" style="font-size: 0.2rem;">12次</span>
            </p>
        </div>
        <img class="xian_bor" src="__PUBLIC__/imgfxs/xian.png">
        <div class="loan_list loan_list1">
            <p class="loan_list_left lan_list_left_1" style="font-size: 0.2rem;">交易失败到下一次还款成功最短天数</p>
            <p class="loan_list_right">
                <span class="loan_tell lan_list_left_2" style="font-size: 0.2rem;">15天</span>
            </p>
        </div>
        <img class="xian_bor" src="__PUBLIC__/imgfxs/xian.png">
        <div class="loan_list loan_list1">
            <p class="loan_list_left lan_list_left_1" style="font-size: 0.2rem;">交易失败到下一次还款成功最长天数</p>
            <p class="loan_list_right">
                <span class="loan_tell lan_list_left_2" style="font-size: 0.2rem;">12天</span>
            </p>
        </div>
        <img class="xian_bor" src="__PUBLIC__/imgfxs/xian.png">
        <div class="loan_list loan_list1">
            <p class="loan_list_left lan_list_left_1" style="font-size: 0.2rem;">交易失败到下一次还款成功的平均天数</p>
            <p class="loan_list_right">
                <span class="loan_tell lan_list_left_2" style="font-size: 0.2rem;">1天</span>
            </p>
        </div>
        <img class="xian_bor" src="__PUBLIC__/imgfxs/xian.png">
    </div>


    <p class="basic_info basic_info1">
        <span>交易信息</span>
    </p>
    <p class="subtitle"><span></span>SMALL LOAN GUARANTEE CLASS</p>
    <div class="search_id loan_box">
        <div class="loan_list loan_list1">
            <p class="loan_list_left lan_list_left_1" style="font-size: 0.2rem;">最近一次交易距离当前天数</p>
            <p class="loan_list_right">
                <span class="loan_tell lan_list_left_2" style="font-size: 0.2rem;">465天</span>
            </p>
        </div>
        <img class="xian_bor" src="__PUBLIC__/imgfxs/xian.png">
        <div class="loan_list loan_list1">
            <p class="loan_list_left lan_list_left_1" style="font-size: 0.2rem;">最后一次交易失败后还款次数</p>
            <p class="loan_list_right">
                <span class="loan_tell lan_list_left_2" style="font-size: 0.2rem;">1次</span>
            </p>
        </div>
        <img class="xian_bor" src="__PUBLIC__/imgfxs/xian.png">
        <div class="loan_list loan_list1">
            <p class="loan_list_left lan_list_left_1" style="font-size: 0.2rem;">交易失败到下一次还款成功最短天数</p>
            <p class="loan_list_right">
                <span class="loan_tell lan_list_left_2" style="font-size: 0.2rem;">12天</span>
            </p>
        </div>
        <img class="xian_bor" src="__PUBLIC__/imgfxs/xian.png">
        <div class="loan_list loan_list1">
            <p class="loan_list_left lan_list_left_1" style="font-size: 0.2rem;">交易失败到下一次还款成功最长天数</p>
            <p class="loan_list_right">
                <span class="loan_tell lan_list_left_2" style="font-size: 0.2rem;">1天</span>
            </p>
        </div>
        <img class="xian_bor" src="__PUBLIC__/imgfxs/xian.png">
        <div class="loan_list loan_list1">
            <p class="loan_list_left lan_list_left_1" style="font-size: 0.2rem;">交易失败到下一次还款成功的平均天数</p>
            <p class="loan_list_right">
                <span class="loan_tell lan_list_left_2" style="font-size: 0.2rem;">1天</span>
            </p>
        </div>
        <img class="xian_bor" src="__PUBLIC__/imgfxs/xian.png">
    </div>


    <p class="basic_info basic_info1">
        <span>还款信息</span>
    </p>
    <p class="subtitle"><span></span>REPAYMENT INFORMATION</p>
    <div class="quota_box" style="margin-top: 0.2rem;">
        <div class="quota_item quota_item4 clearfix">
            <div class="quota_left">
                <p style="font-family: PingFang-SC-Bold;font-size: 0.5rem;font-weight: normal;font-stretch: normal;letter-spacing: 0px;color: #fff36d;">
                    465天</p>
                <p style="	font-family: PingFang-SC-Bold;font-size: 0.3rem;font-weight: normal;font-stretch: normal;color: #ffffff;">
                    最近一次还款成功距离<br/>
                    当前天数</p>
            </div>
            <div class="quota_left">
                <p style="font-family: PingFang-SC-Bold;font-size: 0.5rem;font-weight: normal;font-stretch: normal;letter-spacing: 0px;color: #fff36d;">
                    12笔</p>
                <p style="	font-family: PingFang-SC-Bold;font-size: 0.3rem;font-weight: normal;font-stretch: normal;color: #ffffff;">
                    近20次还款成功笔数
                </p>
            </div>
        </div>
    </div>

    <div class="quota_box" style="margin-top: 0.2rem;">
        <div class="quota_item quota_item5 clearfix">
            <div class="quota_left">
                <p style="font-family: PingFang-SC-Bold;font-size: 0.5rem;font-weight: normal;font-stretch: normal;letter-spacing: 0px;color: #fff36d;">
                    400元</p>
                <p style="	font-family: PingFang-SC-Bold;font-size: 0.3rem;font-weight: normal;font-stretch: normal;color: #ffffff;">
                    近5次还款成功总金额</p>
            </div>
            <div class="quota_left">
                <p style="font-family: PingFang-SC-Bold;font-size: 0.5rem;font-weight: normal;font-stretch: normal;letter-spacing: 0px;color: #fff36d;">
                    15400元</p>
                <p style="	font-family: PingFang-SC-Bold;font-size: 0.3rem;font-weight: normal;font-stretch: normal;color: #ffffff;">
                    近20次还款成功总金额
                </p>
            </div>
        </div>
    </div>

    <div class="search_id loan_box" style="padding-bottom: 0rem;">
        <div class="loan_list loan_list1">
            <p class="loan_list_left lan_list_left_1" style="font-size: 0.2rem;">近5次(成功还款总金额除以还款总金额)</p>
            <p class="loan_list_right">
                <span class="loan_tell lan_list_left_2" style="font-size: 0.2rem;">0.45</span>
            </p>
        </div>
    </div>

    <div class="search_id loan_box" style="padding-bottom: 0rem;">
        <div class="loan_list loan_list1">
            <p class="loan_list_left lan_list_left_1" style="font-size: 0.2rem;">近5次(还款成功笔数除以还款总笔数）</p>
            <p class="loan_list_right">
                <span class="loan_tell lan_list_left_2" style="font-size: 0.2rem;">0.2</span>
            </p>
        </div>
    </div>

    <div class="search_id loan_box" style="padding-bottom: 0rem;">
        <div class="loan_list loan_list1">
            <p class="loan_list_left lan_list_left_1" style="font-size: 0.2rem;">近20次小贷担保类(还款成功笔数除以还款笔数)</p>
            <p class="loan_list_right">
                <span class="loan_tell lan_list_left_2" style="font-size: 0.2rem;">0.6</span>
            </p>
        </div>
    </div>

    <div class="search_id loan_box" style="padding-bottom: 0rem;">
        <div class="loan_list loan_list1">
            <p class="loan_list_left lan_list_left_1" style="font-size: 0.2rem;">近90天内(还款成功总金额除以还款总金额)</p>
            <p class="loan_list_right">
                <span class="loan_tell lan_list_left_2" style="font-size: 0.2rem;">200</span>
            </p>
        </div>
    </div>

    <div class="search_id loan_box" style="padding-bottom: 0rem;">
        <div class="loan_list loan_list1">
            <p class="loan_list_left lan_list_left_1" style="font-size: 0.2rem;">近90天内(还款成功总笔数除以还款总笔数)</p>
            <p class="loan_list_right">
                <span class="loan_tell lan_list_left_2" style="font-size: 0.2rem;">200</span>
            </p>
        </div>
    </div>



    <p class="basic_info basic_info1">
        <span>失信情况总览</span>
    </p>
    <p class="subtitle"><span></span>GENERAL INFORMATION ON BREACH OF TRUST</p>
    <div class="implement_box">
        <p class="implement_ti">
            <span>失信被执行人</span>
        </p>
        <p class="implement_info">
            <span>2016年08月19日</span>
            <span>绵阳市</span>
            <span>游仙区人民法院</span>
        </p>
        <p class="implement_item">
            <span class="info_left">执行案号：</span>
            <span class="info_right">（2016）安执字第00175号</span>
        </p>
        <p class="implement_item">
            <span class="info_left">执行标的：</span>
            <span class="info_right">20000</span>
        </p>
        <p class="implement_item">
            <span class="info_left">立案时间：</span>
            <span class="info_right">2016年04月05日</span>
        </p>
        <p class="implement_item">
            <span class="info_left">做出执行依据单位：</span>
            <span class="info_right">游仙区人民法院</span>
        </p>
        <p class="implement_item">
            <span class="info_left">被执行人的履行情况：</span>
            <span class="info_right">全部未履行</span>
        </p>
        <p class="implement_item">
            <span class="info_left">生效法律文书确定的义务：</span>
            <span class="info_right">其他有履行能力而拒不履</br>行生效法律文书确定义务</span>
        </p>
        <p class="implement_item">
            <span class="info_left">失信被执行人行为具体情形：</span>
            <span class="info_right">其他有履行能力而拒不履<br/>行生效法律文书确定义务</span>
        </p>
    </div>
    <div class="implement_box">
        <p class="implement_ti">
            <span>法院被执行人</span>
        </p>
        <p class="implement_info">
            <span>2016年04月05日</span>
            <span>绵阳市</span>
            <span>游仙区人民法院</span>
        </p>
        <p class="implement_item">
            <span class="info_left">执行案号：</span>
            <span class="info_right">（2016）安执字第00175号</span>
        </p>
        <p class="implement_item">
            <span class="info_left">执行标的：</span>
            <span class="info_right">20000</span>
        </p>
        <p class="implement_item">
            <span class="info_left">立案时间：</span>
            <span class="info_right">2016年04月05日</span>
        </p>
        <p class="implement_item">
            <span class="info_left">执行法院：</span>
            <span class="info_right">游仙区人民法院</span>
        </p>
        <p class="implement_item">
            <span class="info_left">案件状态：</span>
            <span class="info_right">执行中</span>
        </p>
        <div class="horizontal_line"></div>
        <p class="implement_info">
            <span>2016年04月05日</span>
            <span>绵阳市</span>
            <span>游仙区人民法院</span>
        </p>
        <p class="implement_item">
            <span class="info_left">执行案号：</span>
            <span class="info_right">（2016）安执字第00175号</span>
        </p>
        <p class="implement_item">
            <span class="info_left">执行标的：</span>
            <span class="info_right">20000</span>
        </p>
        <p class="implement_item">
            <span class="info_left">立案时间：</span>
            <span class="info_right">2016年04月05日</span>
        </p>
        <p class="implement_item">
            <span class="info_left">执行法院：</span>
            <span class="info_right">游仙区人民法院</span>
        </p>
        <p class="implement_item">
            <span class="info_left">案件状态：</span>
            <span class="info_right">终结本次程序</span>
        </p>
    </div>


    <p class="basic_info basic_info1">
        <span>网贷风险信息</span>
    </p>
    <p class="subtitle"><span></span>NETWORK LOAN RISK INFORMATION</p>
    <div class="search_id wagndai_risk">
        <p class="implement_item">
            <span class="info_left">手机号是否命中网贷重点关注名单</span>
            <span class="info_right">否</span>
        </p>
        <p class="implement_item">
            <span class="info_left">身份证是否命中网贷重点关注名单</span>
            <span class="info_right">否</span>
        </p>
        <p class="implement_item">
            <span class="info_left">身份证是否命中外部黑名单</span>
            <span class="info_right">否</span>
        </p>
        <p class="implement_item">
            <span class="info_left">身份证是否存在信贷逾期历史记录</span>
            <span class="info_right">否</span>
        </p>
        <p class="implement_item">
            <span class="info_left">身份证是否命中高风险关注名单</span>
            <span class="info_right">否</span>
        </p>
        <p class="implement_item">
            <span class="info_left">手机号是否命中高风险关注名单</span>
            <span class="info_right">否</span>
        </p>
        <p class="implement_item">
            <span class="info_left">手机号是否命中通讯小库号</span>
            <span class="info_right">否</span>
        </p>
        <p class="implement_item">
            <span class="info_left">手机号是否命中虚假号码库</span>
            <span class="info_right">否</span>
        </p>
        <p class="implement_item">
            <span class="info_left">手机号是否命中诈骗骚扰库</span>
            <span class="info_right">否</span>
        </p>
        <p class="implement_item">
            <span class="info_left">身份证是否命中风险群体网络</span>
            <span class="info_right">否</span>
        </p>
        <p class="implement_item">
            <span class="info_left">身份证是否命中信贷逾期后还款名单</span>
            <span class="info_right">否</span>
        </p>
        <p class="implement_item">
            <span class="info_left">身份证是否命中车辆租赁违约名单</span>
            <span class="info_right">否</span>
        </p>
        <p class="implement_item">
            <span class="info_left">身份证对应人是否存在助学贷款欠费历史</span>
            <span class="info_right">否</span>
        </p>
    </div>
    <p class="basic_info basic_info1">
        <span>手机号对应风险信息</span>
    </p>
    <p class="subtitle"><span></span>CELLPHONE NUMBER CORRESPONDS</p>
    <div class="search_id wagndai_risk">
        <p class="implement_item">
            <span class="info_left">手机号命中虚假号码库</span>
            <span class="info_right">未发现</span>
        </p>
        <p class="implement_item">
            <span class="info_left">手机号命中通信小号库</span>
            <span class="info_right">未发现</span>
        </p>
        <p class="implement_item">
            <span class="info_left">手机号命中诈骗骚扰库</span>
            <span class="info_right">未发现</span>
        </p>
        <p class="implement_item">
            <span class="info_left">手机号命中高风险关注名单</span>
            <span class="info_right">未发现</span>
        </p>
        <p class="implement_item">
            <span class="info_left">手机号命中信贷逾期名单</span>
            <span class="info_right">未发现</span>
        </p>
        <p class="implement_item">
            <span class="info_left">手机号命中车辆租赁违约名单</span>
            <span class="info_right">未发现</span>
        </p>
        <p class="implement_item">
            <span class="info_left">手机号疑似乱填</span>
            <span class="info_right">未发现</span>
        </p>
        <p class="implement_item">
            <span class="info_left">手机号命中欠款公司法人代表名单</span>
            <span class="info_right">未发现</span>
        </p>
        <p class="implement_item">
            <span class="info_left">手机号命中信贷逾期后还款名单</span>
            <span class="info_right">未发现</span>
        </p>
    </div>
    <p class="basic_info basic_info1">
        <span>身份证风险对应信息</span>
    </p>
    <p class="subtitle"><span></span>IDCARD RISK INFORMATION</p>
    <div class="search_id wagndai_risk">
        <p class="implement_item">
            <span class="info_left">身份证格式校验错误</span>
            <span class="info_right">未发现</span>
        </p>
        <p class="implement_item">
            <span class="info_left">身份证归属地位于高风险较为集中地区</span>
            <span class="info_right">未发现</span>
        </p>
        <p class="implement_item">
            <span class="info_left">身份证命中法院失信名单</span>
            <span class="info_right">未发现</span>
        </p>
        <p class="implement_item">
            <span class="info_left">身份证命中犯罪通缉名单</span>
            <span class="info_right">未发现</span>
        </p>
        <p class="implement_item">
            <span class="info_left">身份证命中法院执行名单</span>
            <span class="info_right">未发现</span>
        </p>
        <p class="implement_item">
            <span class="info_left">身份证命中法院结案名单</span>
            <span class="info_right">未发现</span>
        </p>
        <p class="implement_item">
            <span class="info_left">身份证命中信贷逾期名单</span>
            <span class="info_right">未发现</span>
        </p>
        <p class="implement_item">
            <span class="info_left">身份证命中信贷逾期后还款名单</span>
            <span class="info_right">未发现</span>
        </p>
        <p class="implement_item">
            <span class="info_left">身份证对应人存在助学贷款欠费历史</span>
            <span class="info_right">未发现</span>
        </p>
        <p class="implement_item">
            <span class="info_left">身份证命中高风险关注名单</span>
            <span class="info_right">未发现</span>
        </p>
        <p class="implement_item">
            <span class="info_left">身份证命中车辆租赁违约名单</span>
            <span class="info_right">未发现</span>
        </p>
        <p class="implement_item">
            <span class="info_left">身份证姓名命中信贷逾期模糊名单</span>
            <span class="info_right">未发现</span>
        </p>
        <p class="implement_item">
            <span class="info_left">身份证命中欠款公司法人代表名单</span>
            <span class="info_right">未发现</span>
        </p>
        <p class="implement_item">
            <span class="info_left">身份证命中欠税公司法人代表名单</span>
            <span class="info_right">未发现</span>
        </p>
        <p class="implement_item">
            <span class="info_left">身份证命中故意违章乘车名单</span>
            <span class="info_right">未发现</span>
        </p>
        <p class="implement_item">
            <span class="info_left">身份证命中欠税名单</span>
            <span class="info_right">未发现</span>
        </p>
    </div>

</div>
<script>
    var bu = 1;
    var nums = $(".score_num span").text();

    function zhuan() {
        $(".score_num span").text(bu);
        bu++;
        if (bu > nums) {
            clearInterval(setin);
        }
    }

    var setin = setInterval(zhuan, 15)

    function run() {
        var bar = document.getElementById("bar");
        var total = document.getElementById("total");
        bar.style.width = parseInt(bar.style.width) + 1 + "%";
        total.innerHTML = bar.style.width;
        if (bar.style.width == "75%") {
            window.clearTimeout(timeout);
            return;
        }
        var timeout = window.setTimeout("run()", 10);
    }

    run();
</script>
</body>
</html>