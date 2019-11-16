<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:37:"./themes/default/chaxun/yangshi1.html";i:1572949734;}*/ ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,initial-scale=1,minimum-scale=1,maximum-scale=1,user-scalable=no">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>消费评估</title>
	<link rel="stylesheet" href="__PUBLIC__/css/style.css">
    <link rel="stylesheet" href="__PUBLIC__/css/estimate.css?v=7897987">
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
        <p class="estimate_time">检测时间：2019-10-20 15:51</p>
        <img class="estimate_shout" src="__PUBLIC__/img/bank/shout.png" alt="">
        <div class="info_box">
            <p>基本资料</p>
            <p>姓名：张珊</p>
            <p>年龄：24</p>
            <p>性别：女</p>
            <p>身份证：452727******71866</p>
            <p>手机号：18344555658</p>
            <p>银行卡号：645464316548321354</p>
        </div>
        <div class="blue_line"></div>
        <div class="card_box">
            <p>卡名称：IC绿卡通</p>
            <p>发卡行：中国邮政储蓄银行</p>
            <p>卡品牌：银联标准卡</p>
            <p>卡性质：准贷记卡</p>
            <p>借贷标记：借记卡</p>
            <p>是否银联高端用户：否</p>
            <img src="__PUBLIC__/img/bank/card.png" alt="">
        </div>
        <div style="width: 6.7rem;height: 2.3rem;border-radius: 0.18rem;margin: 0.3rem auto;position: relative;">
         	<p class="p_index_yonh">是否</p>
         	<p class="p_index_yonhs">银联高端用户</p>
         		<p class="p_index_yonhss">是</p>
         	<img src="__PUBLIC__/bg/imgs/hhxi1.png" alt="" style="width:100%">
         </div>
        <div class="blue_line"></div>
        <div class="score_box">
            <div class="score_top">风险分数测评</div>
            <div class="score_wrap clearfix">
                <div class="score_item">
                    <div class="score_bot">280</div>
                    <p>逾期风险得分</p>
                </div>
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
                    <td>4565</td>
                    <td>11564</td>
                    <td>28973</td>
                </tr>
            </table>
            <p class="trade_time">历史最早交易日期：2017-12-10</p>
            <p class="trade_time">最近一笔交易时间：2018-12-10</p>
            <p class="chart_tips">温馨提醒：尽量避免大额整额交易，长期刷整额大额会对你的卡有影响！</p>
        </div>
        <div class="blue_line"></div>
        <div class="score_box">
            <div class="score_top">消费地域</div>
            <div class="area_box">
                <img src="__PUBLIC__/img/bank/diyu.png" alt="">
                <p>北京</p>
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
                    data:[2100, 3192, 4578]
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
                    data:[8, 12, 17]
                }
            ]
        };
        if (option && typeof option === "object") {
            myChart.setOption(option, true);
        }
    }
    tradePos()
    function tradeOnline(){
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
                    data:[20896, 31892, 45798]
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
                    data:[11, 21, 32]
                }
            ]
        };
        if (option && typeof option === "object") {
            myChart.setOption(option, true);
        }
    }
    tradeOnline()
    function monetary(){
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
                    data:[21064, 31469, 45096]
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
                    data:[12, 23, 32]
                }
            ]
        };
        if (option && typeof option === "object") {
            myChart.setOption(option, true);
        }
    }
    monetary()
    function category(){
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
                    data: [0, 12058, 4903, 4890, 4899],
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
                    data: [0, 31, 17, 18, 17],
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