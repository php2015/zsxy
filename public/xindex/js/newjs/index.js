$(function(){
    $(".see_all_btn").click(function(){
        $(".other_details").slideToggle(function(){
            if($(".other_details").is(":hidden")){
                $(".see_all_btn").html("查看完整详情")
            }else{
                $(".see_all_btn").html("收起详情列表")
            }
        });
    })
    $(".see_more_btn").click(function(){
        $(".conceal_propose").slideToggle(function(){
            if($(".conceal_propose").is(":hidden")){
                $(".see_more_btn").html("点击查看更多信息")
            }else{
                $(".see_more_btn").html("收起信息详情列表")
            }
        });
    })
    $(".go_top").click(function(){
        $('body,html').animate({scrollTop:0},500);
    })

    //最近7天
    var n = 0;
    var width = parseInt($(".loan_box").css("width"));
    $(".loan_box .previous").click(function(){
        if(n<=0){
            return false
        }else{
            n--;
            console.log(n)
            var left = -width * n
            $(".loan_tab").animate({"margin-left":left + "px"},300)
        }
    })
    $(".loan_box .next").click(function(){
        if(n>3){
            return false
        }else{
            n++;
            console.log(n)
            var left = -width * n
            $(".loan_tab").animate({"margin-left":left + "px"},300)
        }
    })

    $(".loan_tob span").click(function(){
        $(this).addClass("active").siblings().removeClass("active")
        var index = $(this).index()
        $(this).parent().siblings(".loan_tab").find(".loan_item").eq(index).addClass("active").siblings().removeClass("active")
    })

    $(".useful_box span").click(function(){
        $(this).addClass("active").parent().siblings().find("span").removeClass("active")
    })
})