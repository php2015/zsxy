<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:37:"./themes/default/chaxun/yangshi6.html";i:1571815569;}*/ ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,initial-scale=1,minimum-scale=1,maximum-scale=1,user-scalable=no">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>报告内容</title>
	<link rel="stylesheet" href="__PUBLIC__/css/xcss/mui.min.css">
    <link rel="stylesheet" href="__PUBLIC__/css/xcss/dstyle.css">
    <link rel="stylesheet" href="__PUBLIC__/css/xcss/dindex1.css">
    <script src="__PUBLIC__/js/xjs/mui.min.js"></script>
    <script src="__PUBLIC__/js/xjs/jquery.min.js"></script>
    <script src="__PUBLIC__/js/xjs/index.js"></script>
    <script type="text/javascript" src="https://echarts.baidu.com/gallery/vendors/echarts/echarts.min.js"></script>
</head>
  
  <style>

    #bar{
        background-size: auto 0.3rem;
    }
</style>
  
<body>
    <div class="container">
        <header>
            <span class="mui-icon mui-icon-left-nav"></span>
            <p class="head_right">
                <img src="img/logo.png" alt="">钻石报告
            </p>
        </header>
      
      
    <a href="/index/complaint/wenti.html">
        <div style="width: 40px;height: 40px;border: 1px solid #ee823a;background: #ee823a;border-radius:100%;position: fixed;right: 5px; top: 300px;z-index: 999;opacity:0.5;">
            <p style="text-align: center;line-height: 39px;margin-left: 3px;color: #fff;font-weight: bold;">帮助</p>
        </div>
    </a>
    <a href="<?php echo url('/index/complaint/comment'); ?>">
        <div style="width: 40px;height: 40px;border: 1px solid #ee823a;background: #ee823a;border-radius:100%;position: fixed;right: 5px; top: 350px;z-index: 999;opacity:0.5;">
            <p style="text-align: center;line-height: 39px;margin-left: 3px;color: #fff;font-weight: bold;">评论</p>
        </div>
    </a>
    <a href="<?php echo url('/index/complaint/index'); ?>">
        <div style="width: 40px;height: 40px;border: 1px solid #ff9600;background: #ff9600;border-radius:100%;position: fixed;right: 5px; top: 400px;z-index: 999;opacity:0.5;">
            <p style="text-align: center;line-height: 39px;margin-left: 3px;color: #fff;font-weight: bold;">投诉</p>
        </div>
    </a>
      
        <div class="dashboard">
            <div id="yibiao">
                <div class="yuan1"></div>
                <div class="clip"></div>
                <div class="yuan2"></div>
                <div class="pinfengzhishu">预测通过率</div>
                <div class="num"><span>85</span>%</div>
                <div class="pingjie">你的资质评级：B</div> 
                <div class="waiquan">
                    <img src="__PUBLIC__/ximg/waiquan.png">
                       <div class="neiquan"><img src="__PUBLIC__/ximg/neiquan.png"></div>
                </div>
            </div>
            <p class="username">张三&nbsp;&nbsp;&nbsp;136****5486</p>
            <div class="percent_box">
                <div id="bar" style="width:0%;">
                    <img src="__PUBLIC__/ximg/huojian.png">
                </div>
            </div>
            <p class="xinyong_per">您的通过率打败了全国<span id="total"></span>的用户！</p>
            <p class="init_time">报告生成时间：2019-05-18 14:33:45</p>
        </div>
        <div class="main_content">
            <div class="content_box">
                <p class="cont_ti conti_risk"><span>风险解读</span></p>
                <div class="risk_list clearfix">
                    <p>网络小贷高风险</p>
                    <p>风险群体名单</p>
                    <p>多头借贷严重名单</p>
                    <p>网贷黑名单</p>
                    <p>羊毛党名单</p>
                    <p>法院失信名单</p>
                    <p>法院执行名单</p>
                </div>
            </div>
            <div class="gray_bg"></div>
            <div class="content_box">
                <p class="cont_ti"><span>预测额度</span></p>
                <div class="forecast">
                    <p>信用卡预测额度：</p>
                    <p>5k~1.5w</p>
                </div>
                <div class="forecast forecast1">
                    <p>贷款预测额度：</p>
                    <p>8k~2w</p>
                </div>
                <p class="forecast_tips">授信额度由钻石报告评测，额度仅供参考，钻石报告仅做获取及展示，不对此额度做任何担保及保证。</p>
            </div>
            <div class="gray_bg"></div>
            <div class="content_box">
                <p class="cont_ti"><span>个人信息</span></p>
                <div class="userinfo">
                    <div class="info_list clearfix">
                        <p class="info_left">
                            <img src="__PUBLIC__/ximg/xpf-x.png" alt="">姓名：
                        </p>
                        <p class="info_right">张三</p>
                    </div>
                    <div class="info_list clearfix">
                        <p class="info_left">
                            <img src="__PUBLIC__/ximg/xpf-xb.png" alt="">性别：
                        </p>
                        <p class="info_right">男性</p>
                    </div>
                    <div class="info_list clearfix">
                        <p class="info_left">
                            <img src="__PUBLIC__/ximg/xpf-n.png" alt="">年龄：
                        </p>
                        <p class="info_right">35岁</p>
                    </div>
                    <div class="info_list clearfix">
                        <p class="info_left">
                            <img src="__PUBLIC__/ximg/xpf-sj.png" alt="">手机：
                        </p>
                        <p class="info_right">185****4715</p>
                    </div>
                    <div class="info_list clearfix">
                        <p class="info_left">
                            <img src="__PUBLIC__/ximg/xpf-gui.png" alt="">手机归属地：
                        </p>
                        <p class="info_right">湖北武汉</p>
                    </div>
                    <div class="info_list clearfix">
                        <p class="info_left">
                            <img src="__PUBLIC__/ximg/xpf-shif.png" alt="">身份证：
                        </p>
                        <p class="info_right">47154********5478</p>
                    </div>
                    <div class="info_list clearfix">
                        <p class="info_left">
                            <img src="__PUBLIC__/ximg/xpf-sfg.png" alt="">身份证归属地：
                        </p>
                        <p class="info_right">湖北武汉</p>
                    </div>
                </div>
            </div>
            <div class="gray_bg"></div>
            <div class="content_box">
				<p class="cont_ti"><span>风险评估等级</span></p>
                <div class="intention_wrap" style="display:flex">
					<div class="intention_score" style="width:50%">
						<div class="score_bot" style="margin:0 auto;">96</div>
						<p class="intention_ti" style="font-size:0.26rem;color:#333;text-align:center;">分数</p>
						<p class="intention_txt" style="color:#666;">20分及以下：等级较好</p>
						<p class="intention_txt" style="color:#666;">20分 - 80分：等级一般</p>
						<p class="intention_txt" style="color:#666;">80分及以上：等级较差</p>
					</div>
					<div class="intention_score" style="width:50%">
						<div class="score_bot" style="margin:0 auto;">中</div>
						<p class="intention_ti" style="font-size:0.26rem;color:#333;text-align:center;">风险</p>
						<p class="intention_txt" style="color:#666;">低：较小的欺诈和失信风险</p>
						<p class="intention_txt" style="color:#666;">中：有一定欺诈和失信风险</p>
						<p class="intention_txt" style="color:#666;">高：较高的欺诈和失信风险</p>
					</div>
				</div>
            </div>
          	<div class="gray_bg"></div>
            <div class="content_box">
                <p class="cont_ti"><span>联系人风险</span></p>
                <div class="contact_box">
                    <div class="info_list clearfix">
                        <p class="info_left">直接联系人黑名单人数：</p>
                        <p class="info_right">126</p>
                    </div>
                    <div class="info_list clearfix">
                        <p class="info_left">间接联系人黑名单人数：</p>
                        <p class="info_right">248</p>
                    </div>
					<div class="info_list clearfix">
                        <p class="info_left">主动联系人人数：</p>
                        <p class="info_right">286</p>
                    </div>
                    <div class="info_list clearfix">
                        <p class="info_left">被动联系人人数：</p>
                        <p class="info_right">125</p>
                    </div>
                </div>
                <p class="contact_tips">身边的黑名单朋友过多，也会对钻石报告造成影响，物以类聚，人以群分。</p>
            </div>
            <div class="gray_bg"></div>
            <div class="content_box">
                <p class="cont_ti"><span>高风险命中查询</span></p>
                <div class="contact_box">
                    <div class="search_list">
                        <div class="info_list clearfix">
                            <p class="info_left">银行机构高风险</p>
                            <p class="info_right">
                                <span class="yes">命中</span>
                            </p>
                        </div>
                        <p class="risk_type">风险类型：负债率高，频繁申贷，职业异常</p>
                    </div>
                    <div class="search_list">
                        <div class="info_list clearfix">
                            <p class="info_left">非银行机构高风险</p>
                            <p class="info_right">
                                <span>未命中</span>
                            </p>
                        </div>
                        <p class="risk_type">风险类型：机构代办，异常审核</p>
                    </div>
                    <div class="search_list">
                        <div class="info_list clearfix">
                            <p class="info_left">网络小贷高风险</p>
                            <p class="info_right">
                                <span>未命中</span>
                            </p>
                        </div>
                        <p class="risk_type">风险类型：异常支付，仿冒风险</p>
                    </div>
                    <div class="search_list">
                        <div class="info_list clearfix">
                            <p class="info_left">线下小贷高风险</p>
                            <p class="info_right">
                                <span class="yes">命中</span>
                            </p>
                        </div>
                        <p class="risk_type">风险类型：机构代办，资料异常</p>
                    </div>
                    <div class="search_list">
                        <div class="info_list clearfix">
                            <p class="info_left">消费金融高风险</p>
                            <p class="info_right">
                                <span>未命中</span>
                            </p>
                        </div>
                        <p class="risk_type">风险类型：负债偏高</p>
                    </div>
                    <div class="search_list">
                        <div class="info_list clearfix">
                            <p class="info_left">融资租赁高风险</p>
                            <p class="info_right">
                                <span class="yes">命中</span>
                            </p>
                        </div>
                        <p class="risk_type">风险类型：汽车租赁违约</p>
                    </div>
                    <div class="search_list">
                        <div class="info_list clearfix">
                            <p class="info_left">汽车金融风险</p>
                            <p class="info_right">
                                <span class="yes">命中</span>
                            </p>
                        </div>
                        <p class="risk_type">风险类型：车贷风险名单</p>
                    </div>
                    <div class="search_list">
                        <div class="info_list clearfix">
                            <p class="info_left">法院执行名单</p>
                            <p class="info_right">
                                <span class="yes">命中</span>
                            </p>
                        </div>
                        <p class="risk_type">风险类型：法院执行人</p>
                    </div>
                    <div class="search_list">
                        <div class="info_list clearfix">
                            <p class="info_left">法院失信名单</p>
                            <p class="info_right">
                                <span>未命中</span>
                            </p>
                        </div>
                        <p class="risk_type">风险类型：法院失信人</p>
                    </div>
                    <div class="search_list">
                        <div class="info_list clearfix">
                            <p class="info_left">信贷逾期名单</p>
                            <p class="info_right">
                                <span>未命中</span>
                            </p>
                        </div>
                        <p class="risk_type">风险类型：逾期欠款</p>
                    </div>
                    <div class="search_list">
                        <div class="info_list clearfix">
                            <p class="info_left">信贷逾期后还款名单</p>
                            <p class="info_right">
                                <span class="yes">命中</span>
                            </p>
                        </div>
                        <p class="risk_type">风险类型：逾期后还款</p>
                    </div>
                    <div class="search_list">
                        <div class="info_list clearfix">
                            <p class="info_left">风险群体名单</p>
                            <p class="info_right">
                                <span class="yes">命中</span>
                            </p>
                        </div>
                        <p class="risk_type">风险类型：垃圾注册，异常提现、机构代办</p>
                    </div>
                    <div class="search_list">
                        <div class="info_list clearfix">
                            <p class="info_left">多头借贷严重名单</p>
                            <p class="info_right">
                                <span class="yes">命中</span>
                            </p>
                        </div>
                        <p class="risk_type">风险类型：频繁注册申请贷款</p>
                    </div>
                    <div class="search_list">
                        <div class="info_list clearfix">
                            <p class="info_left">欺诈风险名单</p>
                            <p class="info_right">
                                <span>未命中</span>
                            </p>
                        </div>
                        <p class="risk_type">风险类型：仿冒风险，资料异常</p>
                    </div>
                    <div class="search_list">
                        <div class="info_list clearfix">
                            <p class="info_left">高负债名单</p>
                            <p class="info_right">
                                <span>未命中</span>
                            </p>
                        </div>
                        <p class="risk_type">风险类型：负债过高</p>
                    </div>
                    <div class="search_list">
                        <div class="info_list clearfix">
                            <p class="info_left">网贷黑名单</p>
                            <p class="info_right">
                                <span class="yes">命中</span>
                            </p>
                        </div>
                        <p class="risk_type">风险类型：信用异常</p>
                    </div>
                    <div class="search_list">
                        <div class="info_list clearfix">
                            <p class="info_left">行业黑名单</p>
                            <p class="info_right">
                                <span class="yes">命中</span>
                            </p>
                        </div>
                        <p class="risk_type">风险类型：从事行业风险过高</p>
                    </div>
                    <div class="search_list">
                        <div class="info_list clearfix">
                            <p class="info_left">羊毛党黑名单</p>
                            <p class="info_right">
                                <span class="yes">命中</span>
                            </p>
                        </div>
                        <p class="risk_type">风险类型：恶意注册，刷单</p>
                    </div>
                    <div class="search_list">
                        <div class="info_list clearfix">
                            <p class="info_left">网贷灰名单</p>
                            <p class="info_right">
                                <span>未命中</span>
                            </p>
                        </div>
                        <p class="risk_type">风险类型：多头借款，有逾期倾向</p>
                    </div>
                    <div class="search_list">
                        <div class="info_list clearfix">
                            <p class="info_left">恶意注册名单</p>
                            <p class="info_right">
                                <span>未命中</span>
                            </p>
                        </div>
                        <p class="risk_type">风险类型：异常支付，异常注册</p>
                    </div>
                    <div class="search_list">
                        <div class="info_list clearfix">
                            <p class="info_left">车辆租赁违约名单</p>
                            <p class="info_right">
                                <span class="yes">命中</span>
                            </p>
                        </div>
                        <p class="risk_type">风险类型：汽车租赁违约</p>
                    </div>
                    <div class="search_list">
                        <div class="info_list clearfix">
                            <p class="info_left">犯罪通缉名单</p>
                            <p class="info_right">
                                <span class="yes">命中</span>
                            </p>
                        </div>
                        <p class="risk_type">风险类型：刑事犯罪</p>
                    </div>
                    <div class="search_list">
                        <div class="info_list clearfix">
                            <p class="info_left">机构关注名单</p>
                            <p class="info_right">
                                <span class="yes">命中</span>
                            </p>
                        </div>
                        <p class="risk_type">风险类型：当事人风险指数有增高倾向</p>
                    </div>
                    <div class="search_list">
                        <div class="info_list clearfix">
                            <p class="info_left">身份证命中高风险区域</p>
                            <p class="info_right">
                                <span>未命中</span>
                            </p>
                        </div>
                        <p class="risk_type">风险类型：身份证所属地区逾期风险较集中</p>
                    </div>
                    <div class="search_list">
                        <div class="info_list clearfix">
                            <p class="info_left">存在信用逾期历史记录</p>
                            <p class="info_right">
                                <span>未命中</span>
                            </p>
                        </div>
                        <p class="risk_type">风险类型：逾期，逾期后还款</p>
                    </div>
                </div>
                <p class="contact_tips">借款前，放款机构会在金融平台共享信息中查询用户是否存在逾期或者违约行为、是否被其他机构拉入高风险名单。</p>
            </div>
            <div class="gray_bg"></div>
            <div class="content_box">
                <p class="cont_ti"><span>多平台注册申请</span></p>
                <div class="contact_box">
                    <div id="histogram"></div>
                </div>
                <ul class="register_tab">
                    <li>
                        <p class="tab_list">
                            <span>近7天内</span>
                            <span>33<i class="mui-icon mui-icon-arrowdown"></i></span>
                        </p>
                        <div class="apply_list">
                            <p class="apply_item">
                                <span>小额现金贷申请次数</span>
                                <span>241</span>
                            </p>
                            <p class="apply_item">
                                <span>现金分期申请次数</span>
                                <span>241</span>
                            </p>
                            <p class="apply_item">
                                <span>信用卡申请次数</span>
                                <span>9</span>
                            </p>
                            <p class="apply_item">
                                <span>线下消费分期申请次数</span>
                                <span>4</span>
                            </p>
                            <p class="apply_item">
                                <span>线上消费分期申请次数</span>
                                <span>4</span>
                            </p>
                            <p class="apply_item">
                                <span>汽车金融申请次数</span>
                                <span>9</span>
                            </p>
                            <p class="apply_item">
                                <span>P2P机构申请次数</span>
                                <span>4</span>
                            </p>
                            <p class="apply_item">
                                <span>小贷机构申请次数</span>
                                <span>4</span>
                            </p>
                        </div>
                    </li>
                    <li>
                        <p class="tab_list">
                            <span>近1个月内</span>
                            <span>50<i class="mui-icon mui-icon-arrowdown"></i></span>
                        </p>
                        <div class="apply_list">
                            <p class="apply_item">
                                <span>小额现金贷申请次数</span>
                                <span>17</span>
                            </p>
                            <p class="apply_item">
                                <span>现金分期申请次数</span>
                                <span>3</span>
                            </p>
                            <p class="apply_item">
                                <span>信用卡申请次数</span>
                                <span>9</span>
                            </p>
                            <p class="apply_item">
                                <span>线下消费分期申请次数</span>
                                <span>4</span>
                            </p>
                            <p class="apply_item">
                                <span>线上消费分期申请次数</span>
                                <span>4</span>
                            </p>
                            <p class="apply_item">
                                <span>汽车金融申请次数</span>
                                <span>9</span>
                            </p>
                            <p class="apply_item">
                                <span>P2P机构申请次数</span>
                                <span>4</span>
                            </p>
                            <p class="apply_item">
                                <span>小贷机构申请次数</span>
                                <span>4</span>
                            </p>
                        </div>
                    </li>
                    <li>
                        <p class="tab_list">
                            <span>近3个月内</span>
                            <span>54<i class="mui-icon mui-icon-arrowdown"></i></span>
                        </p>
                        <div class="apply_list">
                           <p class="apply_item">
                                <span>小额现金贷申请次数</span>
                                <span>17</span>
                            </p>
                            <p class="apply_item">
                                <span>现金分期申请次数</span>
                                <span>3</span>
                            </p>
                            <p class="apply_item">
                                <span>信用卡申请次数</span>
                                <span>9</span>
                            </p>
                            <p class="apply_item">
                                <span>线下消费分期申请次数</span>
                                <span>4</span>
                            </p>
                            <p class="apply_item">
                                <span>线上消费分期申请次数</span>
                                <span>4</span>
                            </p>
                            <p class="apply_item">
                                <span>汽车金融申请次数</span>
                                <span>9</span>
                            </p>
                            <p class="apply_item">
                                <span>P2P机构申请次数</span>
                                <span>4</span>
                            </p>
                            <p class="apply_item">
                                <span>小贷机构申请次数</span>
                                <span>4</span>
                            </p>
                        </div>
                    </li>
                </ul>
            </div>
            <div class="gray_bg"></div>
            <div class="content_box">
                <p class="cont_ti"><span>提高评分消除风险建议</span></p>
                <div class="proposal_box">
                    <p>1、三个月不要注册申请超过20次贷款，控制申请频率。</p>
                    <p>2、如果有逾期或者被执行等不良记录，保持良好的信用1-2年，记录可以滚动覆盖过去。</p>
                    <p>3、？？？？？？？？？？？？？？？？</p>
                    <p>4、？？？？？？？？？？？？？？？？</p>
                    <p>5、？？？？？？？？？？？？？？？？</p>
                </div>
            </div>
            <div class="gray_bg"></div>
            <div class="content_box">
                <p class="cont_ti"><span>申贷最重要的小技巧</span></p>
                <div class="proposal_box">
                    <p>1、下载借款APP及申请的时候，平台需要获取定位，通讯录等权限，务必选择允许或者好和同意。</p>
                    <p>2、如果有逾期或者被执行等不良记录，保持良好的信用1-2年，记录可以滚动覆盖过去。</p>
                    <p>3、？？？？？？？？？？？？？？？？</p>
                    <p>4、？？？？？？？？？？？？？？？？</p>
                    <p>5、？？？？？？？？？？？？？？？？</p>
                    <p>6、？？？？？？？？？？？？？？？？</p>
                    <p>7、？？？？？？？？？？？？？？？？</p>
                    <p>8、？？？？？？？？？？？？？？？？</p>
                    <p>9、？？？？？？？？？？？？？？？？</p>
                    <p>10、？？？？？？？？？？？？？？？？</p>
                    <p>11、？？？？？？？？？？？？？？？？</p>
                    <p>12、？？？？？？？？？？？？？？？？</p>
                    <p>13、？？？？？？？？？？？？？？？？</p>
                    <p>14、？？？？？？？？？？？？？？？？</p>
                </div>
            </div>
            <div class="gray_bg"></div>
            <div class="content_box">
                <div class="bot_box">
                	<div class="bot_top">
                    <img src="__PUBLIC__/ximg/sanjiao.png" alt="">
                </div>
                    <p class="data_des">钻石报告说明</p>
                    <p class="data_txt">本报告不是银行征信，和个人信用无关，由本人授权查询，本平台只做获取和整理，报告仅供参考，如您对报告内容有异议，可联系我司沟通协商，最终解释权归本公司所有</p>
                    <!-- <img class="go_top" src="__PUBLIC__/ximg/fanhuidingbu.png" alt=""> -->
                </div>
            </div>
        </div>
    </div>
</body>
<script>
    function yibiaopan(){
         //默认数字0--100，默认数字自增步长1
        var buchang = 1;
        var deg = 181.8 * buchang / 100; //每个步长代表的度数
        var degs = parseInt($(".num span").text()) / buchang * deg; //先计算有几个步长,算出半圆要转的度数
        var du = 0; //起始度数
        var bu = 1; //数字自增步长
        function zhuan() {

            $(".clip").css("transform", "rotate(" + du + "deg)");
            $(".num span").text(bu);
            du += deg;  
            bu += buchang;
            if(du >= degs) {
                    clearInterval(setin);
            }

        }
        var setin = setInterval(zhuan, 15)
    }
    yibiaopan()
    function run(){ 
        var bar = document.getElementById("bar");
        var total = document.getElementById("total");
        bar.style.width=parseInt(bar.style.width) + 1 + "%"; 
        total.innerHTML = bar.style.width; 
        if(bar.style.width == "75%"){ 
        window.clearTimeout(timeout);
        return;
        }
        var timeout=window.setTimeout("run()",15);
    }
    run();
    //柱状图
    function histogram(){
        var dom = document.getElementById("histogram");
        var myChart = echarts.init(dom);
        var app = {};
        option = null;
        // app.title = '坐标轴刻度与标签对齐';

        option = {
            color: ['#ED7D31'],
            tooltip : {
                trigger: 'axis',
                axisPointer : {            // 坐标轴指示器，坐标轴触发有效
                    type : 'shadow'        // 默认为直线，可选为：'line' | 'shadow'
                }
            },
            grid: {
                left: '0%',
                right: '4%',
                bottom: '3%',
                containLabel: true,
            },
            xAxis : [
                {
                    type : 'category',
                    data : ['7天内', '1个月内', '3个月内'],
                    axisTick: {
                        alignWithLabel: true
                    }
                }
            ],
            yAxis : [
                {
                    type : 'value',
                    scale: true,
                    min:0
                }
            ],
            series : [
                {
                    name:'直接访问',
                    type:'bar',
                    barWidth: '40%',
                    data:[20, 32, 44],
                    itemStyle: {
                        normal: {
                            label: {
                                show: true, //开启显示
                                position: 'insideTop', //在上方显示
                                textStyle: { //数值样式
                                    color: '#fff',
                                    fontSize: '0.26rem'
                                }
                            }
                        }
                    }
                }
            ]
        };
        if (option && typeof option === "object") {
            myChart.setOption(option, true);
        }
    }
    histogram()
    //折线图
    function polygonal(){
        var dom = document.getElementById("polygonal");
        var myChart = echarts.init(dom);
        var app = {};
        option = null;
        option = {
            tooltip: {
                trigger: 'axis'
            },
            legend: {
                data:['申请次数','申请机构数']
            },
            color:["#5B9BD5","#EC7E32"],
            grid: {
                left: '0%',
                right: '4%',
                bottom: '3%',
                containLabel: true
            },
            toolbox: {
                feature: {
                    saveAsImage: {}
                }
            },
            xAxis: {
                type: 'category',
                boundaryGap: false,
                data: ['1','2','3','4','5','6','7','8','9','10','11','12','13']
            },
            yAxis: {
                type: 'value'
            },
            series: [
                {
                    name:'申请次数',
                    type:'line',
                    stack: '总量',
                    label: {
                        normal: {
                            show: true,
                            position: 'center',
                            textStyle: {
                                color: '#404040',
                                fontSize: '0.2rem'
                            }
                        }
                    },
                    data:[2, 4, 7, 14, 16, 24, 27, 29, 38, 38, 39, 39, 41],
                },
                {
                    name:'申请机构数',
                    type:'line',
                    stack: '总量',
                    label: {
                        normal: {
                            show: true,
                            position: 'center',
                            textStyle: {
                                color: '#404040',
                                fontSize: '0.2rem'
                            }
                        }
                    },
                    data:[8, 10, 16, 19, 22, 24, 35, 36, 42, 47, 49, 52, 58],
                }
            ]
        };
        if (option && typeof option === "object") {
            myChart.setOption(option, true);
        }
    }
    polygonal()
</script>
</html>