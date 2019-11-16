<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:36:"./themes/calculator/index/lists.html";i:1572356236;}*/ ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,initial-scale=1,minimum-scale=1,maximum-scale=1,user-scalable=no">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>法律问答</title>
    <link rel="stylesheet" href="__PUBLICS__/calculator/css/style.css">
    <link rel="stylesheet" href="__PUBLICS__/calculator/css/index.css">
</head>
<body>
<div class="container">
    <div class="content question_box">
        <p class="lawyer_ques">
            <img src="__PUBLICS__/calculator/img/2.1.png" alt="">法律问答
            <img src="__PUBLICS__/calculator/img/2.2.png" alt="">
        </p>
        <?php $i = 0; if(is_array($data) || $data instanceof \think\Collection || $data instanceof \think\Paginator): if( count($data)==0 ) : echo "" ;else: foreach($data as $key=>$vo): $i++ ;?>
        <div class="question_list clearfix">
            <p class="ques_left" style="font-size:0.26rem;"><?php echo $i; ?>.<?php echo $vo['title']; ?></p>
            <p class="ques_right">
                <a href="<?php echo url('/calculator/index/unlock',['id'=>$vo['id']]); ?>">
                    <button style="font-size:0.24rem;">查看答案</button>
                </a>
            </p>
        </div>
        <?php endforeach; endif; else: echo "" ;endif; ?>
    </div>
    
</div>
</body>
<script src="__PUBLIC__/js/jquery.min.js"></script>
<script src="/public/bootstrap/js/jquery.bootstrap.newsbox.min.js"></script>
<script src="/public/layer/layer.js"></script>
<script>
    $(".demo1").bootstrapNews({
        newsPerPage: 5,
        autoplay: true,
        pauseOnHover: true,
        navigation: false,
        direction: 'up',
        newsTickerInterval: 4000,
        onToDo: function () {

        }
    });

    $(document).ready(function(){
        $('.sub_comment').on('click',function(){
            var uid = '<?php echo $uid; ?>';
            if(uid == ''){
                layer.msg('请先去登录');
                return ;
            }
           var content = $('textarea[name="content"]').val();
           var loading = layer.load(0);
           $(this).attr("disabled","true");
            $.ajax({
                url:'<?php echo url("/api/complaint/comment"); ?>',
                type:'post',
                dataType:'json',
                data:{'content':content,type:2},
                success:function(json){
                    layer.close(loading);
                    $(this).removeAttr('disabled');
                    if(json == 10){
                        layer.msg('非法操作');
                    }else if(json == 0){
                        layer.msg('提交失败');
                    }else{
                        layer.msg('提交成功',{'time':1000},function(){
                            history.go();
                        })
                    }
                }
            })
        })
    });
</script>
</html>
