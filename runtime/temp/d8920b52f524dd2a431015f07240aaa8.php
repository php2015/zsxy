<?php if (!defined('THINK_PATH')) exit(); /*a:2:{s:35:"./themes/calculator/apay/index.html";i:1571815575;s:29:"./themes/calculator/base.html";i:1571815574;}*/ ?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <title>计算器后台</title>
    
<link rel="stylesheet" href="__PUBLICS__/calculator/admin/css/layui.css">
<link rel="stylesheet" href="__PUBLICS__/calculator/admin/css/comment.css">
<link rel="stylesheet" href="__PUBLICS__/calculator/admin/css/modules/laydate/default/laydate.css">

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
        <div data-warp="comment">
            <div class="comment_num">
                <table>
                    <tr>
                        <td>今日已支付人数</td>
                        <td>今日待支付人数</td>
                        <td>总已支付人数</td>
                        <td>总待支付人数</td>
                    </tr>
                    <tr>
                        <td><?php echo $count['pay']; ?></td>
                        <td><?php echo $count['wpay']; ?></td>
                        <td><?php echo $count['zzpay']; ?></td>
                        <td><?php echo $count['zwpay']; ?></td>
                    </tr>
                </table>
                <div class="line"></div>
            </div>

            <div class="demoTable">
                <button class="layui-btn quandel" style="width: 134px;height: 34px;background-color: #817ee8; border-radius: 8px;border: none;font-size: 16px;font-weight: bold;color: #ffffff;margin: 20px 20px 10px 0;float: left;" data-type="getCheckData">删除</button>
            </div>
            <form class="layui-form layui-form-pane" action="<?php echo url('/calculator/apay/index'); ?>" method="get">
                <div class="search_box">
                    <input type="text" name="keyword">
                    <span>关键字</span>
                </div>
                <div class="search_box layui-input-inline">
                    <input type="text" class="layui-input times" name="ctime" id="time">
                    <span>时间</span>
                </div>
                <div class="layui-inline">
                    <button class="btn_del">搜索</button>
                </div>
            </form>


            <div class="clearfix"></div>
            <div class="tab_box">
                <table class="layui-table" lay-data="{width: 1660, page:true, id:'idTest'}" lay-filter="demo">
                    <thead>
                    <tr>
                        <th lay-data="{type:'checkbox'}"></th>
                        <th lay-data="{field:'id', sort: true, align:'center'}">ID</th>
                        <th lay-data="{field:'username', align:'center'}">手机号</th>
                        <th lay-data="{field:'sex', sort: true, align:'center'}">订单号</th>
                        <th lay-data="{field:'city', align:'center'}">支付金额</th>
                        <th lay-data="{field:'sign', sort: true, align:'center'}">支付时间</th>
                        <th lay-data="{field:'classify', align:'center'}">代理人</th>
                        <th lay-data="{field:'experience', sort: true, align:'center'}">付款状态</th>
                        <!-- <th lay-data="{fixed: 'right', align:'center', toolbar: '#barDemo'}"></th> -->
                    </tr>
                    </thead>
                    <tbody>
                    <?php if(is_array($data) || $data instanceof \think\Collection || $data instanceof \think\Paginator): if( count($data)==0 ) : echo "" ;else: foreach($data as $key=>$vo): ?>
                    <tr>
                        <td lay-data="{type:'checkbox', fixed: 'left'}"></td>
                        <td><?php echo $vo['id']; ?></td>
                        <td><?php echo $vo['mobile']; ?></td>
                        <td><?php echo $vo['out_trade_no']; ?></td>
                        <td><?php echo $vo['total_fee']/100; ?></td>
                        <td><?php echo date("Y-m-d H:i:s",$vo['createAt']); ?></td>
                        <td><?php echo $vo['names']; ?></td>
                        <td><a href="<?php echo url('/calculator/apay/index',['status'=>$vo['status']]); ?>"><?php if(!empty($vo['status']) && $vo['status'] == 1): ?>已支付<?php else: ?>未支付<?php endif; ?></a><a class="delete" lay-event="del" href="javascript:;"><i class="layui-icon layui-icon-delete"></i></a></td>
                    </tr>
                    <?php endforeach; endif; else: echo "" ;endif; ?>
                    </tbody>
                </table>
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
<script src="__PUBLICS__/calculator/admin/lay/modules/laydate.js"></script>
<script src="__PUBLICS__/calculator/layui/layui.js"></script>

<!--页面JS脚本-->

<script>
    $(function(){
        laydate.render({
            elem: '#time',
            range: true,
            value: ''
        });
        layui.use('table', function () {
            var table = layui.table;
            //监听表格复选框选择
            //监听工具条
            table.on('tool(demo)', function (obj) {
                var data = obj.data;
                if (obj.event === 'detail') {
                    layer.msg('ID：' + data.id + ' 的查看操作');
                } else if (obj.event === 'del') {
                    layer.confirm('真的删除行么', function (index) {
                        $.ajax({
                            url: '<?php echo url("/calculator/apay/delete"); ?>',
                            type: 'post',
                            data: {'id': data.id},
                            dataType: 'json',
                            success: function (json) {
                                obj.del(index);
                            }
                        });
                        layer.close(index);
                    });
                } else if (obj.event === 'edit') {
                    layer.alert('编辑行：<br>' + JSON.stringify(data))
                }
            });

            var $ = layui.$, active = {
                getCheckData: function () { //获取选中数据
                    var checkStatus = table.checkStatus('idTest')
                        , data = checkStatus.data;
                    var id = [];
                    $(data).each(function(i,n) {
                        id[i] = n.id;
                    });
                    layer.confirm('真的删除行么', function (index) {
                        $.ajax({
                            url: '<?php echo url("/calculator/apay/deletes"); ?>',
                            type: 'post',
                            data: {'id':id.join(',')},
                            dataType: 'json',
                            success: function (json) {
                                window.location.href = '/calculator/apay/index';
                            }
                        });
                        layer.close(index);
                    });
                }
                , getCheckLength: function () { //获取选中数目
                    var checkStatus = table.checkStatus('idTest')
                        , data = checkStatus.data;
                    layer.msg('选中了：' + data.length + ' 个');
                }
                , isAll: function () { //验证是否全选
                    var checkStatus = table.checkStatus('idTest');
                    layer.msg(checkStatus.isAll ? '全选' : '未全选')
                }
            };

            $('.demoTable .layui-btn').on('click', function () {
                var type = $(this).data('type');
                active[type] ? active[type].call(this) : '';
            });
        });
    })
</script>

</body>
</html>
