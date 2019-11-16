<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:37:"./themes/default/complaint/tousu.html";i:1571815559;}*/ ?>
<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
 	<meta name="viewport" content="width=device-width,initial-scale=1,minimum-scale=1,maximum-scale=1,user-scalable=no" />
    <title>投诉</title>
    <link href="/public/bootstrap/css/bootstrap.min.css" rel="stylesheet" />
    <link href="/public/bootstrap/css/base.css" rel="stylesheet" type="text/css" />
    <link href="/public/layui/layui/css/layui.css" rel="stylesheet" type="text/css" />
    <script src="/public/bootstrap/js/jquery-2.2.3.min.js"></script>
    <script src="/public/bootstrap/js/bootstrap.js"></script>
    <script type='text/javascript'src='https://webchat.7moor.com/javascripts/7moorInit.js?accessId=f50ea5f0-5c14-11e9-8670-5bf8fe2cdd9c&autoShow=false&language=ZHCN' async='async'></script>
</head>
<style>

    .container{
        padding-right: 0px;
        padding-left: 0px;
        margin-right: auto;
        margin-left: auto;
    }

    ul li{
        list-style:none;
    }
    .turn-pic a{
        color:#000000;
        text-decoration:none;
    }
    .turn-pic li {
        list-style:none;
        margin-left: 21px;
        border-bottom: 1px solid #e5e5e5;
        font-size: 17px;
        line-height: 43px;
    }

    .turn-pic li span{
        float: right;
        margin-right: 25px;
        color: #c9c9cb;
    }


    ::-webkit-input-placeholder {
        color: #999;
        font-size: 16px;
    }
    .btn-success{
        color: #fff;
        background-color: #51a938;
        border-color: #51a938;
    }
    p {
        margin: 0 0 10px;
    }

    .filid li{
        float:left;
        margin-right: 5px;
    }
</style>

<body style="">
<div class="container" style="background-color:#fff;">
   <!-- <div style="background-color:#f2f2f2;">
        <p style="margin-left: 20px;color: #999;font-size: 14px;letter-spacing: 1px;line-height: 38px;">投诉账号</p>
    </div>
    <div style="margin-left:20px;">
        <img src="/public/index/img/log01.png" width="50" height="50" style="float:left"/>
        <p style="margin-left: 65px;font-size: 15px;font-weight: bold;">钻石报告</p>
        <p style="margin-left: 65px;color: #999;">微信号：gh_d91582019834</p>
    </div> -->
    <div style="background-color:#f2f2f2;">
        <p style="margin-left: 20px;color: #999;font-size: 14px;letter-spacing: 1px;line-height: 38px;">投诉描述</p>
    </div>
    <div style="margin-left:20px;margin-right:30px;">
        <textarea name="content" style="resize:none;width: 100%;height: 100px;border: solid 0px;outline:none;" placeholder="请输入投诉内容"></textarea>
        <p  style="font-size: 16px;color: #999;margin-left: 87%;"><span id="name_word">0</span><span id="s">/200</span></p>
        <div style="border-bottom:1px solid #999;"></div>
    </div>
    <div style="margin-left:20px;margin-top:10px;">
        <p style="font-size: 15px;font-weight: bold;letter-spacing: 2px;margin-left:4px">
            证据截图
            <span style="float: right; margin-right: 10%;color: #999;font-size: 14px; font-weight: initial;">
                <span class="jishu">0</span><span>/4</span>
            </span>
        </p>
        <ul class="filid" id="fileImgs">
            <li class="fileImg" id="file_upload" style="margin-bottom: 20px;">
                <img src="/public/index/img/jia.png" width="80" height="80">
            </li>
            <input type="hidden" name="commodity_img" value="">
        </ul>
        <div style="clear:both"></div>

        <div style="border-bottom:1px solid #999;"></div>
    </div>
    <div style="margin-left:20px;margin-right:10px;margin-top:10px;">
         <span style="font-size: 15px;font-weight: bold;letter-spacing: 2px;margin-left:4px">证据连接</span>
        <input style="height: 30px;border: solid 0px;margin-left: 15px;" placeholder="选填" name="connection" type="text" value=""/>
    </div>
    <input type="hidden" name="type" value="<?php echo $type; ?>">
    <input type="hidden" name="father" value="<?php echo $father; ?>">
    <div style="background-color:#f2f2f2;width:100%;height:300px">
        <div style="text-align: center;"><button id="btn" type="button" style="margin-top: 45px;width: 90%;" class="btn btn-success">提交</button></div>
    </div>
</div>

</body>
</html>
<script src="/public/layer/layer.js"></script>
<script src="/public/layui/layui/layui.js"></script>
<script>
    $(document).ready(function(){
        $(document).keyup(function() {
            var text = $('textarea[name="content"]').val();
            var counter = text.length;
            $("#name_word").text(counter);
        });

        $('#btn').on('click',function(){
            var content = $('textarea[name="content"]').val();
            var commodity_img = $('input:hidden[name="commodity_img"]').val();
            var connection = $('input[name="connection"]').val();
            var type = $('input:hidden[name="type"]').val();
            var father = $('input:hidden[name="father"]').val();
            if(content == ''){
                layer.msg('内容不能为空');
                return;
            }

            if(content.length > 200){
                layer.msg('文字不能超过200');
                return;
            }
            var loading = layer.load(0);
            $(this).attr("disabled","true");
            $.ajax({
                url:'<?php echo url("/api/complaint/index"); ?>',
                type: 'post',
                dataType:'json',
                data:{'content':content,'img':commodity_img,'connection':connection,'type':type,'father':father},
                success:function(json){
                    layer.close(loading);
                    $(this).removeAttr('disabled');
                    if(json == 10){
                        layer.msg('非法操作');
                    }else if(json == 0){
                        layer.msg('提交失败');
                    }else{
                        layer.msg('提交成功',{'time':1000},function(){
                            window.location.href = '<?php echo url("/index/index/index"); ?>';
                        })
                    }
                }
            })



        });


        layui.use('upload', function () {
            var upload = layui.upload;
            var uploadInst = upload.render({
                elem: '#file_upload',
                url: '/index/upload/submit',
                data: {type: '1'},
                accept: 'images',
                exts: 'jpg|png|gif|bmp|jpeg',
                choose:function(obj){
                    obj.preview(function(index, file, result){
                        var f = $('.filid').children().length;
                        $('.jishu').html(f-2);
                        if(f == 6){
                            $('.fileImg').css('display','none');
                        }
                    })
                },
                multiple: true,
                number: 2,
                done: function (res, index, uploads) {
                    if (res){
                        var aa = $('input:hidden[name="commodity_img"]').val();
                        var html = '<li class="img"><img src="' + res.file.url + '" width="80" height="80"><a data-img="'+res.file.url+'" res="imgxx" style="margin-left:-19px;color: red;position: absolute;font-size:25px;font-weight: bold;z-index:999" >X</a></li>';
                        $('input:hidden[name="commodity_img"]').val((aa ? (aa + ",") : '')+res.file.url);
                        $('.fileImg').before(html);
                    } else {
                        layer.msg(res);
                    }
                }

            })
        })

        $('#fileImgs').on('click','li a[res="imgxx"]',function(){
            var temp='';
            var img = $(this).parent().siblings('input:hidden[name="commodity_img"]').val();
            var img = img.split(',');
            for(i in img){
                if(img[i] == $(this).attr('data-img')){
                    continue;
                }
                temp += temp ? "," + img[i] : img[i];
            }
            if($('#fileImgs').children().length <= 5){
                $('.fileImg').css('display','black');
            }
            $(this).parent().siblings('input:hidden[name="commodity_img"]').val(temp);
            $(this).parent().remove();
        })

        $('#fileImgs').on('click',function(){
            layer.photos({
                photos:".img",//相册标题
                anim: 1 ,//0-6的选择，指定弹出图片动画类型，默认随机（请注意，3.0之前的版本用shift参数）
            });
        })
    })
</script>

