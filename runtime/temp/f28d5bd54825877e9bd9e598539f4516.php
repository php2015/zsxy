<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:35:"./themes/default/user/feedback.html";i:1571815550;}*/ ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,initial-scale=1,minimum-scale=1,maximum-scale=1,user-scalable=no">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>意见反馈</title>
    <link rel="stylesheet" href="__PUBLIC__/css/style.css">
    <link rel="stylesheet" href="__PUBLIC__/css/feedback.css">
    <script src="__PUBLIC__/js/jquery.min.js"></script>
    <script src="__PUBLICS__/layer/layer.js"></script>
</head>
<body>
<div class="container">
    <div class="feedback_box">
        <textarea name="content" id="" cols="30" rows="10" placeholder="请描述您遇到的问题或者反馈"></textarea>
    </div>
    <input class="call_way" type="text" name="mobile" id="" placeholder="联系方式">
    <button class="submit_btn">提交意见</button>
</div>

<script>

    $(document).ready(function(){
        $('.submit_btn').on('click',function(){
            var content = $('textarea[name="content"]').val();
            var mobile = $('input[name="mobile"]').val();
            var pattern = /^1[34578]\d{9}$/;
            if(content == ''){
                layer.msg('反馈内容不能为空');
                return;
            }
            if(mobile == '' || !pattern.test(mobile)){
                layer.msg('手机号码有误');
                return;
            }
           // var fee = layer.load();
            $.ajax({
                'url':"<?php echo url('index/user/feeadd'); ?>",
                'type':'post',
                'dataType':'json',
                'data':{'content':content,'mobile':mobile},
                success:function(json){
                    if(json == 1){
                        layer.msg('提交成功',{time:300},function(){
                            window.location.href = '/index/index/index';
                        })
                    }else{
                        layer.msg('提交失败');
                    }
                   // layer.close(fee);
                }
            })
        })

    })

</script>
</body>
</html>