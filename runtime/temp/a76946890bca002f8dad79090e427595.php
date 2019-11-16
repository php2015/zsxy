<?php if (!defined('THINK_PATH')) exit(); /*a:2:{s:37:"./themes/calculator/aindex/index.html";i:1571815575;s:29:"./themes/calculator/base.html";i:1571815574;}*/ ?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <title>计算器后台</title>
    
<link rel="stylesheet" href="__PUBLICS__/calculator/admin/css/layui.css">
<link rel="stylesheet" href="__PUBLICS__/calculator/admin/css/index.css">

    <link rel="stylesheet" href="__PUBLICS__/calculator/admin/css/layui.css">
</head>

<style>
    .layui-layout-admin .layui-logo {
        background: #282751;
    }

    .layui-layout-admin .layui-side {
        top: 0px;
    }
</style>

<body class="layui-layout-body">
<div class="layadmin-side-spread-sm">
<div class="layui-layout layui-layout-admin">
    <div class="layui-header" style="height: 73px;">
        <ul class="layui-nav layui-layout-right">
            <li class="layui-nav-item">
                <a href="javascript:;">
                    <img src="https://t.cn/RCzsdCq" class="layui-nav-img">
                    贤心
                </a>
            </li>
            <li class="layui-nav-item">
                <a href="<?php echo url('/calculator/login/logout'); ?>">
                    <img src="__PUBLICS__/calculator/admin/images/img/tuichu.png" alt="退出" title="退出">
                </a>
            </li>

        </ul>
    </div>

    <div class="layui-side layui-side-menu" style="z-index: 9999999;">
        <div class="layui-side-scroll">
            <div class="layui-logo" lay-href="">
                <span>计算工具后台</span>
            </div>
            <ul class="layui-nav layui-nav-tree" lay-filter="test layadmin-system-side-menu" lay-shrink="all"
                id="LAY-system-side-menu" style="top: 73px;">
                <li class="layui-nav-item">
                    <a class="" href="<?php echo url('/calculator/aindex/index'); ?>">
                        <img src="__PUBLICS__/calculator/admin/images/img/shouye.png"/>首&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;页
                    </a>
                </li>
                <li class="layui-nav-item">
                    <a href="<?php echo url('/calculator/acomment/index'); ?>">
                        <img src="__PUBLICS__/calculator/admin/images/img/pinglun.png"/>评论审核
                    </a>
                </li>
                <li class="layui-nav-item">
                    <a href="<?php echo url('/calculator/apay/index'); ?>">
                        <img src="__PUBLICS__/calculator/admin/images/img/zhifu.png"/>支付记录
                    </a>
                </li>
                <li class="layui-nav-item">
                    <a href="<?php echo url('/calculator/acontent/index'); ?>">
                        <img src="__PUBLICS__/calculator/admin/images/img/neirong.png"/>内容管理
                    </a>
                </li>
            </ul>
        </div>
    </div>
    <!--主体-->
    <div class="layui-body">
        <!-- 内容主体区域 -->
        <div style="padding: 20px;">
            


<div class="layui-body">
    <div class="layui-fluid">
        <div class="layui-row">
            <div class="index_top clearfix">
                <?php if(is_array($data['statistics']) || $data['statistics'] instanceof \think\Collection || $data['statistics'] instanceof \think\Paginator): $i = 0; $__LIST__ = $data['statistics'];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$v): $mod = ($i % 2 );++$i;?>
                <div class="layui-col-xs6 layui-col-sm6 layui-col-md3">

                    <div class="statistics">
                        <p class="statistics_ti">
                            <?php if(isset($v['type']) and $v['type'] == 1): ?>
                            当天数据统计
                            <?php elseif(isset($v['type']) and $v['type'] == 2): ?>
                            本周数据统计
                            <?php elseif(isset($v['type']) and $v['type'] == 3): ?>
                            当月数据统计
                            <?php elseif(isset($v['type']) and $v['type'] == 4): ?>
                            总数据统计
                            <?php endif; ?>
                        </p>
                        <div class="statistics_bot layui-row">
                            <div class="layui-col-md6">
                                <div class="statistics_item">
                                    <p>已完成订单</p>
                                    <p><?php if(isset($v['awesome']) && !empty($v['awesome'])): ?><?php echo $v['awesome']; else: ?>0<?php endif; ?></p>
                                </div>
                            </div>
                            <div class="layui-col-md6">
                                <div class="statistics_item">
                                    <p>注册人数</p>
                                    <p><?php if(!empty($v['awesome']) || !empty($v['registered'])): ?><?php echo $v['awesome'] + $v['registered']; else: ?>0<?php endif; ?></p>
                                </div>
                            </div>
                            <div class="layui-col-md6">
                                <div class="statistics_item">
                                    <p>评论人数</p>
                                    <p><?php if(isset($v['responses']) && !empty($v['responses'])): ?><?php echo $v['responses']; else: ?>0<?php endif; ?></p>
                                </div>
                            </div>
                            <div class="layui-col-md6">
                                <div class="statistics_item">
                                    <p>访问人数</p>
                                    <p><?php if(isset($v['browse']) && !empty($v['browse'])): ?><?php echo $v['browse']; else: ?>0<?php endif; ?></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <?php endforeach; endif; else: echo "" ;endif; ?>

            </div>
            <div class="order_box">
                <div class="layui-col-xs12 layui-col-sm8 layui-col-md8 order_left">
                    <div id="completed"></div>
                    <div id="unfulfilled"></div>
                </div>
                <div class="layui-col-xs12 layui-col-sm4 layui-col-md4">
                    <div class="order_ri1">
                        <div id="orderPay"></div>
                    </div>
                    <div class="order_ri1 order_ri2">
                        <div id="orderFinish"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

        </div>
    </div>
    <div class="layui-footer">
        <!-- 底部固定区域 -->
        <!-- © layui.com - 底部固定区域 -->
    </div>
</div>
</div>
<script src="__PUBLICS__/calculator/admin/js/jquery-1.8.3.min.js"></script>
<script>
    // 定义全局JS变量
    var GV = {
        current_controller: "calculator/<?php echo (isset($controller) && ($controller !== '')?$controller:''); ?>/",
        base_url: "__PUBLICS__"
    };
</script>
<script src="__PUBLICS__/calculator/layui/layui.all.js"></script>
<script src="__PUBLICS__/calculator/admin/js/cadmin.js?v=1597"></script>
<script>
    layui.use('element', function () {
        var element = layui.element;
    });
</script>


<script type="text/javascript" src="https://echarts.baidu.com/gallery/vendors/echarts/echarts.min.js"></script>

<!--页面JS脚本-->

<script>
    $(function () {
        function completed() {
            var dom = document.getElementById("completed");
            var myChart = echarts.init(dom);
            var app = {};
            option = {
                title: {
                    text: '已完成订单',
                    textStyle: {
                        color: '#3b3b3b'
                    },
                    padding: [0, 0, 0, 0]  // 位置
                },
                color: ['#ffc851', '#51b3ff', '#516eff'],
                tooltip: {
                    trigger: 'axis',
                    axisPointer: {            // 坐标轴指示器，坐标轴触发有效
                        type: 'shadow'        // 默认为直线，可选为：'line' | 'shadow'
                    }
                },
                legend: {
                    data: ['0单-150单', '151单-300单', '301单-更多']
                },
                grid: {
                    left: '3%',
                    right: '4%',
                    bottom: '3%',
                    containLabel: true
                },
                xAxis: {
                    type: 'category',
                    data:<?php echo json_encode($data['data']['time']); ?>,
                    axisTick: {
                        alignWithLabel: true
                    }
                },
                yAxis: [
                    {
                        type: 'value',
                        scale: true,
                        min: 0,
                        name: '2019',    // 轴名称
                        nameLocation: 'start',  // 轴名称相对位置
                    }
                ],
                series: [
                    {
                        name: '0单-150单',
                        type: 'bar',
                        stack: '总量',
                        barWidth: 30,
                        data: <?php echo json_encode($data['data']['single1']); ?>
                    },
                    {
                        name: '151单-300单',
                        type: 'bar',
                        stack: '总量',
                        barWidth: 30,
                        data: <?php echo json_encode($data['data']['single2']); ?>
                    },
                    {
                        name: '301单-更多',
                        type: 'bar',
                        stack: '总量',
                        barWidth: 30,
                        data: <?php echo json_encode($data['data']['single3']); ?>
                    }
                ]
            };
            if (option && typeof option === "object") {
                myChart.setOption(option, true);
            }
        }

        completed();

        function unfulfilled() {
            var dom = document.getElementById("unfulfilled");
            var myChart = echarts.init(dom);
            var app = {};
            option = {
                title: {
                    text: '未完成订单',
                    textStyle: {
                        color: '#3b3b3b'
                    },
                    padding: [0, 0, 0, 0]  // 位置
                },
                color: ['#ffc851', '#51b3ff', '#516eff'],
                tooltip: {
                    trigger: 'axis',
                    axisPointer: {            // 坐标轴指示器，坐标轴触发有效
                        type: 'shadow'        // 默认为直线，可选为：'line' | 'shadow'
                    }
                },
                legend: {
                    data: ['0单-150单', '151单-300单', '301单-更多']
                },
                grid: {
                    left: '3%',
                    right: '4%',
                    bottom: '3%',
                    containLabel: true
                },
                xAxis: {
                    type: 'category',
                    data: <?php echo json_encode($data['data']['time']); ?>,
                    axisTick: {
                        alignWithLabel: true
                    }
                },
                yAxis: [
                    {
                        type: 'value',
                        scale: true,
                        min: 0,
                        name: '2019',    // 轴名称
                        nameLocation: 'start',  // 轴名称相对位置
                    }
                ],
                series: [
                    {
                        name: '0单-150单',
                        type: 'bar',
                        stack: '总量',
                        barWidth: 30,
                        data: <?php echo json_encode($data['data']['countjin1']); ?>
                    },
                    {
                        name: '151单-300单',
                        type: 'bar',
                        stack: '总量',
                        barWidth: 30,
                        data: <?php echo json_encode($data['data']['countjin2']); ?>
                    },
                    {
                        name: '301单-更多',
                        type: 'bar',
                        stack: '总量',
                        barWidth: 30,
                        data: <?php echo json_encode($data['data']['countjin3']); ?>
                    }
                ]
            };
            if (option && typeof option === "object") {
                myChart.setOption(option, true);
            }
        }

        unfulfilled()

        function orderPay() {
            var dom = document.getElementById("orderPay");
            var myChart = echarts.init(dom);
            var app = {};
            option = {
                title: {
                    text: '已支付与待支付对比图',
                    x: 'left'
                },
                color: ['#ffc851', '#817ee8'],
                tooltip: {
                    trigger: 'item',
                    formatter: "{a} <br/>{b} : {c} ({d}%)"
                },
                legend: {
                    orient: 'vertical',
                    left: 'left',
                    top: 40,
                    data: ['未完成订单', '已完成订单']
                },
                series: [
                    {
                        type: 'pie',
                        radius: '55%',
                        center: ['62%', '60%'],
                        data: [
                            {value: '<?php echo $data['sums_tim']; ?>', name: '未完成订单'},
                            {value: '<?php echo $data['sums']; ?>', name: '已完成订单'}
                        ],
                        itemStyle: {
                            emphasis: {
                                shadowBlur: 10,
                                shadowOffsetX: 0,
                                shadowColor: 'rgba(0, 0, 0, 0.5)'
                            }
                        }
                    }
                ]
            };
            if (option && typeof option === "object") {
                myChart.setOption(option, true);
            }
        }

        orderPay()

        function orderFinish() {
            var dom = document.getElementById("orderFinish");
            var myChart = echarts.init(dom);
            var app = {};
            option = {
                title: {
                    text: '已完成订单对比图',
                    x: 'left'
                },
                color: ['#ffc851', '#817ee8'],
                tooltip: {
                    trigger: 'item',
                    formatter: "{a} <br/>{b} : {c} ({d}%)"
                },
                legend: {
                    orient: 'vertical',
                    left: 'left',
                    top: 40,
                    data: ['今日完成订单', '昨日完成订单']
                },

                series: [
                    {
                        type: 'pie',
                        radius: '55%',
                        center: ['62%', '60%'],
                        data: [
                            {value: <?php echo $data['data']['single1']['0']; ?>, name: '今日完成订单'},
                            {value:  <?php echo $data['data']['single1']['1']; ?>, name: '昨日完成订单'}
                        ],
                        itemStyle: {
                            emphasis: {
                                shadowBlur: 10,
                                shadowOffsetX: 0,
                                shadowColor: 'rgba(0, 0, 0, 0.5)'
                            }
                        }
                    }
                ]
            };
            if (option && typeof option === "object") {
                myChart.setOption(option, true);
            }
        }

        orderFinish()
        $("canvas").css({"width": "100%"});
        $("canvas").parent().css({"width": "100%"});
    })
</script>

</body>
</html>
