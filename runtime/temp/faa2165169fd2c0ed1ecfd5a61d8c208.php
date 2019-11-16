<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:37:"./themes/default/chaxun/estimate.html";i:1572949898;}*/ ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,initial-scale=1,minimum-scale=1,maximum-scale=1,user-scalable=no">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>消费评估</title>
    <link rel="stylesheet" href="__PUBLIC__/css/style.css">
    <link rel="stylesheet" href="__PUBLIC__/css/estimate.css?v=123456">
    <script src="__PUBLIC__/js/jquery.min.js"></script>
    <script src="__PUBLIC__/js/echarts.min.js"></script>
    <!-- <script type="text/javascript" src="http://echarts.baidu.com/gallery/vendors/echarts/echarts.min.js"></script> -->
</head>
<style>
	.p_index_yonh{
	    position: absolute;
    	z-index: 99999;
    	color: #373a5a;
    	font-size: 0.7rem;
    	font-weight: bold;
    	margin: 0.4rem 0px 0 0.5rem;
	}
	
	.p_index_yonhs{
		position: absolute;
    	z-index: 99999;
    	color: #373a5a;
    	font-size: 0.43rem;
    	font-weight: bold;
    	margin: 1.3rem 0px 0 0.5rem;
	}
	
	.p_index_yonhss{
		position: absolute;
    	z-index: 99999;
    	color: #fff;
        font-size: 0.5rem;
    	font-weight: bold;
    	margin: 0.78rem 0px 0 5.06rem;
	}
	.score_item {
		width: 100%;
    	float: left;
	}
</style>
<body>
    <div class="container">
        <img class="logo" src="__PUBLIC__/img/bank/logo.png" alt="">
        <p class="estimate_ti">消费评估报告</p>
        <p class="estimate_ti1">Consumption Assessment Report</p>
        <p class="estimate_time">检测时间：<?php if(isset($result['dates']) && !empty($result['dates'])): ?><?php echo $result['dates']; endif; ?></p>
        <p class="estimate_time">商户单号：<?php if(isset($result['out_trade_no']) && !empty($result['out_trade_no'])): ?><?php echo $result['out_trade_no']; endif; ?></p>
        <p class="estimate_time">交易单号：<?php if(isset($result['transaction_id']) && !empty($result['transaction_id'])): ?><?php echo $result['transaction_id']; endif; ?></p>
        <img class="estimate_shout" src="__PUBLIC__/img/bank/shout.png" alt="">
        <div class="info_box">
            <p>基本资料</p>
            <p>姓名：<?php if(isset($result['opnames']) && !empty($result['opnames'])): ?><?php echo $result['opnames']; endif; ?></p>
            <p>年龄：<?php if(isset($result['age']) && !empty($result['age'])): ?><?php echo $result['age']; endif; ?></p>
            <p>性别：<?php if(isset($result['sex']) && !empty($result['sex'])): ?><?php echo $result['sex']; endif; ?></p>
            <p>身份证：<?php if(isset($result['opcard']) && !empty($result['opcard'])): ?><?php echo $result['opcard']; endif; ?></p>
            <p>手机号：<?php if(isset($result['mobile']) && !empty($result['mobile'])): ?><?php echo $result['mobile']; endif; ?></p>
            <p>银行卡号：<?php if(isset($result['account_no']) && !empty($result['account_no'])): ?><?php echo $result['account_no']; endif; ?></p>
        </div>
        <div class="blue_line"></div>
        <div class="card_box">
            <p>卡名称：<?php if(isset($result['YLZC005']) && !empty($result['YLZC005'])): ?><?php echo $result['YLZC005']; else: ?>未知<?php endif; ?></p>
            <p>发卡行：<?php if(isset($result['YLZC008']) && !empty($result['YLZC008'])): ?><?php echo $result['YLZC008']; else: ?>未知<?php endif; ?></p>
            <p>卡品牌：<?php if(isset($result['YLZC003']) && !empty($result['YLZC003'])): ?><?php echo $result['YLZC003']; else: ?>未知<?php endif; ?></p>
            <p>卡性质：<?php if(isset($result['YLZC002']) && !empty($result['YLZC002'])): ?><?php echo $result['YLZC002']; else: ?>未知<?php endif; ?></p>
            <p>借贷标记：<?php if(isset($result['YLZC001']) && !empty($result['YLZC001'])): ?><?php echo $result['YLZC001']; else: ?>未知<?php endif; ?></p>
            <img src="__PUBLIC__/img/bank/card.png" alt="">
        </div>
        
        <div style="width: 6.7rem;height: 2.3rem;border-radius: 0.18rem;margin: 0.3rem auto;position: relative;">
         	<p class="p_index_yonh">是否</p>
         	<p class="p_index_yonhs">银联高端用户</p>
         		<p class="p_index_yonhss"><?php if(isset($result['YLZC007']) && !empty($result['YLZC007'])): ?><?php echo $result['YLZC007']; else: ?>否<?php endif; ?></p>
         	<img src="__PUBLIC__/bg/imgs/hhxi1.png" alt="" style="width:100%">
         </div>
        
        <div class="blue_line"></div>
        <div class="score_box">
            <div class="score_top">风险分数测评</div>
            <div class="score_wrap clearfix">
            	<?php if(isset($result['RMS002']) && !empty($result['RMS002'])): ?>
            	<div class="score_item">
                    <div class="score_bot"><?php if(isset($result['RMS002']) && !empty($result['RMS002'])): ?><?php echo $result['RMS002']; else: ?>0<?php endif; ?></div>
                    <p>逾期风险得分</p>
                </div>
                <?php endif; if(isset($result['RMS003']) && !empty($result['RMS003'])): ?>
            	<div class="score_item">
                    <div class="score_bot"><?php if(isset($result['RMS003']) && !empty($result['RMS003'])): ?><?php echo $result['RMS003']; else: ?>0<?php endif; ?></div>
                    <p>信用得分</p>
                </div>
                <?php endif; ?>
            </div>
            <p class="score_tips">注释：0-1000分，分值越大风险越高</p>
        </div>
        <div class="blue_line"></div>
        <div class="score_box">
            <div class="score_top">POS交易概括</div>
            <div id="trade_pos"></div>
        </div>
        <div class="blue_line"></div>
        <div class="score_box">
            <div class="score_top">线上交易概括</div>
            <div id="trade_online"></div>
        </div>
        <div class="blue_line"></div>
        <div class="score_box">
            <div class="score_top">消费金额概括</div>
            <div id="monetary"></div>
            <table class="table_box">
                <tr>
                    <td>月均消费金额</td>
                    <td>近3个月</td>
                    <td>近6个月</td>
                    <td>近12个月</td>
                </tr>
                <tr>
                    <td>单位: 元</td>
                    <td><?php if(isset($result['YLZC253']) && !empty($result['YLZC253'])): ?><?php echo $result['YLZC253']; else: ?>0<?php endif; ?></td>
                    <td><?php if(isset($result['YLZC254']) && !empty($result['YLZC254'])): ?><?php echo $result['YLZC254']; else: ?>0<?php endif; ?></td>
                    <td><?php if(isset($result['YLZC255']) && !empty($result['YLZC255'])): ?><?php echo $result['YLZC255']; else: ?>0<?php endif; ?></td>
                </tr>
            </table>
            <p class="trade_time">历史最早交易日期：<?php if(isset($result['YLZC282']) && !empty($result['YLZC282'])): ?><?php echo $result['YLZC282']; else: ?>0<?php endif; ?></p>
            <p class="trade_time">最近一笔交易时间：<?php if(isset($result['YLZC284']) && !empty($result['YLZC284'])): ?><?php echo $result['YLZC284']; else: ?>0<?php endif; ?></p>
            
            <p class="chart_tips">温馨提醒：尽量避免大额整额交易，长期刷整额大额会对你的卡有影响！</p>
        </div>
        <div class="blue_line"></div>
        <div class="score_box">
            <div class="score_top">消费地域</div>
            <div class="area_box">
                <img src="__PUBLIC__/img/bank/diyu.png" alt="">
                <p><?php if(isset($result['YLZC285']) && !empty($result['YLZC285'])): ?><?php echo $result['YLZC285']; else: ?>0<?php endif; ?></p>
            </div>
        </div>
        <div class="blue_line"></div>
        <div class="score_box">
            <div class="score_top">消费类别分析</div>
            <div id="category"></div>
            <p class="cate_time">时间：近六个月</p>
            <p class="chart_tips">温馨提醒：住宿服务、就餐场所、餐馆、快餐、酒吧、茶馆、咖啡馆、歌舞厅、KTV、百货商店、珠宝首饰</p>
        </div>
        <div class="blue_line"></div>
        
         <p class="chart_tips">测评使用说明：</p>
         <p class="chart_tips">1、本测试均经您授权下进行，未经书面许可，不可复制，转载和发表</p>
         <p class="chart_tips">2、本测试结果仅供参考，据此作出的决策均基于您独立的判断，如产生不利后果，我方不承担任何责任</p>
    </div>
</body>
<script>
    function tradePos(){
    	
    	
    	var YLZC183 = '<?php if(isset($result['YLZC183']) && !empty($result['YLZC183'])): ?><?php echo $result['YLZC183']; else: ?>0<?php endif; ?>';
    	var YLZC184 = '<?php if(isset($result['YLZC184']) && !empty($result['YLZC184'])): ?><?php echo $result['YLZC184']; else: ?>0<?php endif; ?>';
    	var YLZC185 = '<?php if(isset($result['YLZC185']) && !empty($result['YLZC185'])): ?><?php echo $result['YLZC185']; else: ?>0<?php endif; ?>';
    	var YLZC187 = '<?php if(isset($result['YLZC187']) && !empty($result['YLZC187'])): ?><?php echo $result['YLZC187']; else: ?>0<?php endif; ?>';
    	var YLZC188 = '<?php if(isset($result['YLZC188']) && !empty($result['YLZC188'])): ?><?php echo $result['YLZC188']; else: ?>0<?php endif; ?>';
    	var YLZC189 = '<?php if(isset($result['YLZC189']) && !empty($result['YLZC189'])): ?><?php echo $result['YLZC189']; else: ?>0<?php endif; ?>';
    	
    	
        var dom = document.getElementById("trade_pos");
        var myChart = echarts.init(dom);
        var app = {};
        option = {
            color: ['#ff5656','#569eff'],
            tooltip : {
                trigger: 'axis'
            },
            legend: {
                x:'left',
                data:['交易金额','交易比数'],
                textStyle:{
                    color:'#fff'
                }
            },
            toolbox: {
                show : true,
                feature : {
                    dataView : {show: true, readOnly: false},
                    magicType : {show: true, type: ['line', 'bar']},
                    restore : {show: true},
                    saveAsImage : {show: true}
                }
            },
            calculable : true,
            textStyle:{
                color:'#fff'
            },
            grid: {
                left: '1%',
                right: '5%',
                bottom: '5%',
                containLabel: true
            },
            xAxis : [
                {
                    type : 'category',
                    data : ['近3个月','近6个月','近12个月'],
                    offset: 10,
                }
            ],
            yAxis : [
                {
                    type: 'value',
                    name: '单位：元',
                    min: 0,
                    max: 5000,
                    interval: 1000,
                    splitLine: {    // gird 区域中的分割线
                        show: true,   // 是否显示
                        lineStyle: {
                            color: '#332b4a',
                            width: 1,
                            type: 'solid'
                        }
                    },
                },
                {
                    type: 'value',
                    name: '单位：笔',
                    min: 0,
                    max: 50,
                    interval: 10,
                    splitLine: {    // gird 区域中的分割线
                        show: true,   // 是否显示
                        lineStyle: {
                            color: '#332b4a',
                            width: 1,
                            type: 'solid'
                        }
                    },
                }
            ],
            series : [
                {
                    name:'交易金额',
                    type:'bar',
                    itemStyle: {    // 图形的形状
                        normal: {
                            barBorderRadius: [16, 16, 0 ,0],
                            label: {
                                show: true, //开启显示
                                position: 'top', //在上方显示
                                textStyle: { //数值样式
                                    color: 'white',
                                    fontSize: 12
                                }
                            }
                        }
                    },
                    barWidth: 10,  // 柱形的宽度
                    data:[YLZC183, YLZC184, YLZC185]
                },
                {
                    name:'交易比数',
                    type:'bar',
                    yAxisIndex: 1,
                    itemStyle: {    // 图形的形状
                        normal: {
                            barBorderRadius: [16, 16, 0 ,0],
                            label: {
                                show: true, //开启显示
                                position: 'top', //在上方显示
                                textStyle: { //数值样式
                                    color: 'white',
                                    fontSize: 12
                                }
                            }
                        },
                    },
                    barWidth: 10,  // 柱形的宽度
                    data:[YLZC187, YLZC188, YLZC189]
                }
            ]
        };
        if (option && typeof option === "object") {
            myChart.setOption(option, true);
        }
    }
    tradePos()
    function tradeOnline(){
    	
    	var YLZC191 = '<?php if(isset($result['YLZC191']) && !empty($result['YLZC191'])): ?><?php echo $result['YLZC191']; else: ?>0<?php endif; ?>';
    	var YLZC192 = '<?php if(isset($result['YLZC192']) && !empty($result['YLZC192'])): ?><?php echo $result['YLZC192']; else: ?>0<?php endif; ?>';
    	var YLZC193 = '<?php if(isset($result['YLZC193']) && !empty($result['YLZC193'])): ?><?php echo $result['YLZC193']; else: ?>0<?php endif; ?>';
    	var YLZC195 = '<?php if(isset($result['YLZC195']) && !empty($result['YLZC195'])): ?><?php echo $result['YLZC195']; else: ?>0<?php endif; ?>';
    	var YLZC196 = '<?php if(isset($result['YLZC196']) && !empty($result['YLZC196'])): ?><?php echo $result['YLZC196']; else: ?>0<?php endif; ?>';
    	var YLZC197 = '<?php if(isset($result['YLZC197']) && !empty($result['YLZC197'])): ?><?php echo $result['YLZC197']; else: ?>0<?php endif; ?>';
    	
        var dom = document.getElementById("trade_online");
        var myChart = echarts.init(dom);
        var app = {};
        option = {
            color: ['#ff5656','#569eff'],
            tooltip : {
                trigger: 'axis'
            },
            legend: {
                x:'left',
                data:['交易金额','交易比数'],
                textStyle:{
                    color:'#fff'
                }
            },
            toolbox: {
                show : true,
                feature : {
                    dataView : {show: true, readOnly: false},
                    magicType : {show: true, type: ['line', 'bar']},
                    restore : {show: true},
                    saveAsImage : {show: true}
                }
            },
            calculable : true,
            textStyle:{
                color:'#fff'
            },
            grid: {
                left: '1%',
                right: '5%',
                bottom: '5%',
                containLabel: true
            },
            xAxis : [
                {
                    type : 'category',
                    data : ['近3个月','近6个月','近12个月'],
                    offset: 10,
                }
            ],
            yAxis : [
                {
                    type: 'value',
                    name: '单位：元',
                    min: 0,
                    max: 50000,
                    interval: 10000,
                    splitLine: {    // gird 区域中的分割线
                        show: true,   // 是否显示
                        lineStyle: {
                            color: '#332b4a',
                            width: 1,
                            type: 'solid'
                        }
                    },
                },
                {
                    type: 'value',
                    name: '单位：笔',
                    min: 0,
                    max: 50,
                    interval: 10,
                    splitLine: {    // gird 区域中的分割线
                        show: true,   // 是否显示
                        lineStyle: {
                            color: '#332b4a',
                            width: 1,
                            type: 'solid'
                        }
                    },
                }
            ],
            series : [
                {
                    name:'交易金额',
                    type:'bar',
                    itemStyle: {    // 图形的形状
                        normal: {
                            barBorderRadius: [16, 16, 0 ,0],
                            label: {
                                show: true, //开启显示
                                position: 'top', //在上方显示
                                textStyle: { //数值样式
                                    color: 'white',
                                    fontSize: 12
                                }
                            }
                        }
                    },
                    barWidth: 10,  // 柱形的宽度
                    data:[YLZC191,YLZC192,YLZC193]
                },
                {
                    name:'交易比数',
                    type:'bar',
                    yAxisIndex: 1,
                    itemStyle: {    // 图形的形状
                        normal: {
                            barBorderRadius: [16, 16, 0 ,0],
                            label: {
                                show: true, //开启显示
                                position: 'top', //在上方显示
                                textStyle: { //数值样式
                                    color: 'white',
                                    fontSize: 12
                                }
                            }
                        },
                    },
                    barWidth: 10,  // 柱形的宽度
                    data:[YLZC195, YLZC196, YLZC197]
                }
            ]
        };
        if (option && typeof option === "object") {
            myChart.setOption(option, true);
        }
    }
    tradeOnline()
    function monetary(){
    	
    	var YLZC243 = '<?php if(isset($result['YLZC243']) && !empty($result['YLZC243'])): ?><?php echo $result['YLZC243']; else: ?>0<?php endif; ?>';
    	var YLZC244 = '<?php if(isset($result['YLZC244']) && !empty($result['YLZC244'])): ?><?php echo $result['YLZC244']; else: ?>0<?php endif; ?>';
    	var YLZC245 = '<?php if(isset($result['YLZC245']) && !empty($result['YLZC245'])): ?><?php echo $result['YLZC245']; else: ?>0<?php endif; ?>';
    	var YLZC247 = '<?php if(isset($result['YLZC247']) && !empty($result['YLZC247'])): ?><?php echo $result['YLZC247']; else: ?>0<?php endif; ?>';
    	var YLZC248 = '<?php if(isset($result['YLZC248']) && !empty($result['YLZC248'])): ?><?php echo $result['YLZC248']; else: ?>0<?php endif; ?>';
    	var YLZC249 = '<?php if(isset($result['YLZC249']) && !empty($result['YLZC249'])): ?><?php echo $result['YLZC249']; else: ?>0<?php endif; ?>';
    	
        var dom = document.getElementById("monetary");
        var myChart = echarts.init(dom);
        var app = {};
        option = {
            color: ['#ff5656','#569eff'],
            tooltip : {
                trigger: 'axis'
            },
            legend: {
                x:'left',
                data:['交易金额','交易比数'],
                textStyle:{
                    color:'#fff'
                }
            },
            toolbox: {
                show : true,
                feature : {
                    dataView : {show: true, readOnly: false},
                    magicType : {show: true, type: ['line', 'bar']},
                    restore : {show: true},
                    saveAsImage : {show: true}
                }
            },
            calculable : true,
            textStyle:{
                color:'#fff'
            },
            grid: {
                left: '1%',
                right: '5%',
                bottom: '5%',
                containLabel: true
            },
            xAxis : [
                {
                    type : 'category',
                    data : ['近3个月','近6个月','近12个月'],
                    offset: 10,
                }
            ],
            yAxis : [
                {
                    type: 'value',
                    name: '单位：元',
                    min: 0,
                    max: 50000,
                    interval: 10000,
                    splitLine: {    // gird 区域中的分割线
                        show: true,   // 是否显示
                        lineStyle: {
                            color: '#332b4a',
                            width: 1,
                            type: 'solid'
                        }
                    },
                },
                {
                    type: 'value',
                    name: '单位：笔',
                    min: 0,
                    max: 50,
                    interval: 10,
                    splitLine: {    // gird 区域中的分割线
                        show: true,   // 是否显示
                        lineStyle: {
                            color: '#332b4a',
                            width: 1,
                            type: 'solid'
                        }
                    },
                }
            ],
            series : [
                {
                    name:'交易金额',
                    type:'bar',
                    itemStyle: {    // 图形的形状
                        normal: {
                            barBorderRadius: [16, 16, 0 ,0],
                            label: {
                                show: true, //开启显示
                                position: 'top', //在上方显示
                                textStyle: { //数值样式
                                    color: 'white',
                                    fontSize: 12
                                }
                            }
                        }
                    },
                    barWidth: 10,  // 柱形的宽度
                    data:[YLZC243, YLZC244, YLZC245]
                },
                {
                    name:'交易比数',
                    type:'bar',
                    yAxisIndex: 1,
                    itemStyle: {    // 图形的形状
                        normal: {
                            barBorderRadius: [16, 16, 0 ,0],
                            label: {
                                show: true, //开启显示
                                position: 'top', //在上方显示
                                textStyle: { //数值样式
                                    color: 'white',
                                    fontSize: 12
                                }
                            }
                        },
                    },
                    barWidth: 10,  // 柱形的宽度
                    data:[YLZC247, YLZC248, YLZC249]
                }
            ]
        };
        if (option && typeof option === "object") {
            myChart.setOption(option, true);
        }
    }
    monetary()
    function category(){
    	
    	var YLZC449 = '<?php if(isset($result['YLZC449']) && !empty($result['YLZC449'])): ?><?php echo $result['YLZC449']; else: ?>0<?php endif; ?>';
    	var YLZC452 = '<?php if(isset($result['YLZC452']) && !empty($result['YLZC452'])): ?><?php echo $result['YLZC452']; else: ?>0<?php endif; ?>';
    	var YLZC455 = '<?php if(isset($result['YLZC455']) && !empty($result['YLZC455'])): ?><?php echo $result['YLZC455']; else: ?>0<?php endif; ?>';
    	var YLZC458 = '<?php if(isset($result['YLZC458']) && !empty($result['YLZC458'])): ?><?php echo $result['YLZC458']; else: ?>0<?php endif; ?>';
    	var YLZC467 = '<?php if(isset($result['YLZC467']) && !empty($result['YLZC467'])): ?><?php echo $result['YLZC467']; else: ?>0<?php endif; ?>';
    	var YLZC470 = '<?php if(isset($result['YLZC470']) && !empty($result['YLZC470'])): ?><?php echo $result['YLZC470']; else: ?>0<?php endif; ?>';
    	var YLZC479 = '<?php if(isset($result['YLZC479']) && !empty($result['YLZC479'])): ?><?php echo $result['YLZC479']; else: ?>0<?php endif; ?>';
    	var YLZC482 = '<?php if(isset($result['YLZC482']) && !empty($result['YLZC482'])): ?><?php echo $result['YLZC482']; else: ?>0<?php endif; ?>';
    	var YLZC485 = '<?php if(isset($result['YLZC485']) && !empty($result['YLZC485'])): ?><?php echo $result['YLZC485']; else: ?>0<?php endif; ?>';
    	var YLZC488 = '<?php if(isset($result['YLZC488']) && !empty($result['YLZC488'])): ?><?php echo $result['YLZC488']; else: ?>0<?php endif; ?>';
    	
        var dom = document.getElementById("category");
        var myChart = echarts.init(dom);
        var app = {};
        option = {
            color: ['#ff5656','#569eff'],
            tooltip: {
                trigger: 'axis',
                axisPointer: {
                    type: 'shadow'
                }
            },
            legend: {
                x:'left',
                data: ['交易金额', '交易比数'],
                textStyle:{
                    color:'#fff'
                }
            },
            textStyle:{
                color:'#fff'
            },
            grid: {
                left: '2%',
                right: '14%',
                bottom: '3%',
                containLabel: true
            },
            xAxis: [
                {
                    type: 'value',
                    name: '单位：元',
                    nameLocation: 'start',
                    min: 0,
                    max: 12000,
                    interval: 2000,
                    boundaryGap: [0, 0.01],
                    splitLine: {    // gird 区域中的分割线
                        show: true,   // 是否显示
                        lineStyle: {
                            color: '#332b4a',
                            width: 1,
                            type: 'solid'
                        }
                    },
                    axisLine: {       // 坐标轴 轴线
                        show: false,  // 是否显示
                    },
                },
                {
                    type: 'value',
                    name: '单位：笔',
                    nameLocation: 'start',
                    min: 0,
                    max: 60,
                    interval: 10,
                    boundaryGap: [0, 0.01],
                    splitLine: {    // gird 区域中的分割线
                        show: true,   // 是否显示
                        lineStyle: {
                            color: '#332b4a',
                            width: 1,
                            type: 'solid'
                        }
                    },
                    axisLine: {       // 坐标轴 轴线
                        show: false,  // 是否显示
                    },
                }
            ],
            yAxis: {
                type: 'category',
                data: ['非批发类','餐娱类','民生类','一般类','日用百货'],
            },
            series: [
                {
                    name: '交易金额',
                    type: 'bar',
                    barWidth:8,
                    data: [YLZC449, YLZC455, YLZC467, YLZC479, YLZC485],
                    itemStyle: {    // 图形的形状
                        normal: {
                            barBorderRadius: [0, 16, 16 ,0],
                            label: {
                                show: true, //开启显示
                                position: 'right', //在上方显示
                                textStyle: { //数值样式
                                    color: 'white',
                                    fontSize: 12
                                }
                            }
                        },
                    },
                },
                {
                    name: '交易比数',
                    xAxisIndex: 1,
                    type: 'bar',
                    barWidth:8,
                    data: [YLZC452, YLZC458, YLZC470, YLZC482, YLZC488],
                    itemStyle: {    // 图形的形状
                        normal: {
                            barBorderRadius: [0, 16, 16 ,0],
                            label: {
                                show: true, //开启显示
                                position: 'right', //在上方显示
                                textStyle: { //数值样式
                                    color: 'white',
                                    fontSize: 12
                                }
                            }
                        },
                    },
                }
            ]
        };
        if (option && typeof option === "object") {
            myChart.setOption(option, true);
        }
    }
    category()
</script>
</html>