var swiperV = new Swiper('.swiper-container-v', {
    pagination: '.swiper-pagination-v',
    noSwipingClass : 'stop-swiping',
    paginationClickable: true,
    slidesPerView: 'auto',
    onInit: function(swiper){ //Swiper2.x的初始化是onFirstInit
        swiperAnimateCache(swiper); //隐藏动画元素
        swiperAnimate(swiper); //初始化完成开始动画
    },
    onSlideChangeEnd: function(swiper){
        swiperAnimate(swiper); //每个slide切换结束时也运行当前slide动画
    }
});


var swiperV2 = new Swiper('.swiper-container-c', {
    pagination: '.swiper-pagination-c',
    paginationClickable: true,
    loop : true,
    slidesPerView: 'auto',
    observer:true,//修改swiper自己或子元素时，自动初始化swiper
    observeParents:true//修改swiper的父元素时，自动初始化swiper
});

//获取URL参数函数
function GetRequest() {
    var url = location.search; //获取url中"?"符后的字串
    var theRequest = new Object();
    if (url.indexOf("?") != -1) {
        var str = url.substr(1);
        strs = str.split("&");
        for(var i = 0; i < strs.length; i ++) {
            theRequest[strs[i].split("=")[0]]=unescape(strs[i].split("=")[1]);
        }
    }
    return theRequest;
}
var Request = new Object();
Request = GetRequest();


//可以获取中文参数
function getQueryString(name) {
    var reg = new RegExp("(^|&)" + name + "=([^&]*)(&|$)", "i");
    var r = window.location.search.substr(1).match(reg);
    if ( r != null ){
        return decodeURI(r[2]);
    }else{
        return null;
    }
}


//数据监测代码
if(Request['source'] == 2){
    _hmt.push(['_trackEvent', '微信', '总的统计', 'literature']);
    if(Request['channel'] == 1){
        _hmt.push(['_trackEvent', '微信', '活动进入', 'literature']);
    }
    if(Request['channel'] == 2){
        _hmt.push(['_trackEvent', '微信', '经销商进入', 'literature']);
    }
    if(Request['channel'] == 3){
        _hmt.push(['_trackEvent', '微信', '下拉菜单进入', 'literature']);
    }
    if(Request['channel'] == 4){
        _hmt.push(['_trackEvent', '微信', '官方二维码进入', 'literature']);
    }
    if(Request['channel'] == 5){
        _hmt.push(['_trackEvent', '微信', '店内海报', 'literature']);
    }
    if(Request['channel'] == 6){
        _hmt.push(['_trackEvent', '微信', '消息盒子', 'literature']);
    }
}
else {
    _hmt.push(['_trackEvent', '其他渠道', '其他渠道', 'literature']);
}


if(localStorage.getItem("moble")){
    swiperV.slideTo(3, 500, true);
    $.ajax({
        url:'demo.php',
        type:'POST',
        data:{mob:localStorage.getItem("moble")},
        success:function(data){
            if(data==""){
                score(50);
            }else {
                var s = parseInt(data);
                score(s);
            }

        }
    });
}

if(localStorage.getItem("nick")){
    swiperV.slideTo(3, 500, true);
    $.ajax({
        url:'demo.php',
        type:'POST',
        data:{name:localStorage.getItem("nick")},
        success:function(data){
            if(data==""){
                score(50);
            }else {
                var s = parseInt(data);
                score(s);
            }
        }
    });
}


//当前时间
function getNowFormatDate() {
    var date = new Date();
    var seperator1 = "-";
    var seperator2 = ":";
    var month = date.getMonth() + 1;
    var strDate = date.getDate();
    if (month >= 1 && month <= 9) {
        month = "0" + month;
    }
    if (strDate >= 0 && strDate <= 9) {
        strDate = "0" + strDate;
    }
    var currentdate = date.getFullYear() + seperator1 + month + seperator1 + strDate
        + " " + date.getHours() + seperator2 + date.getMinutes()
        + seperator2 + date.getSeconds();
    return currentdate;
}
//alert

var openid;
//获取openid
$.ajax({
    url:'demo.php',
    type:'POST',
    async: false,
    data:{key:Request['key']},
    dataType: "json",
    success:function(data){
        console.log(data['data']['openid']);
        openid = data['data']['openid'];
    }
})

var page = function (num) {
    swiperV.slideTo(num, 500, true);
};
//定时器,2s后显示介绍

window.setTimeout(function () {
    $(".introduce").fadeIn(1000);
},4000)

//点击详情显示遮罩
$("#see1").click(function () {
    $("#jiangpin").fadeIn(500)
});
//关闭奖品遮罩
$("#off_jp").click(function () {
    $("#jiangpin").fadeOut(500);
});
//上一页
$("#left").click(function () {
    swiperV2.slidePrev();
})
//下一页
$("#right").click(function () {
    swiperV2.slideNext();
})
$("#see2").click(function () {
    var oDiv =  $("<div class='xiangqing'>\
                    <img onclick='offMask(this);' id='off' src='img/page1/off.png' alt=''>\
                </div>");
    $(".page1").append(oDiv);
    oDiv.fadeIn(1000);
})
//点击关闭遮罩
var offMask = function (a) {
    $(a).parent().fadeOut(1000,function () {
        $(a).parent().remove();
    })
    $(".phb_box").fadeOut(1000);
}
/*获取验证码*/
var isPhone = 1;

function getCode(e,n) {
    var M = {};
    if(M.dialog1){
        return M.dialog1.show();
    }
    checkPhone(n); //验证手机号码
    if (isPhone) {
        resetCode(); //倒计时
        if(n==1){
            $.ajax({
                url:'demo.php',
                type:'POST',
                data:{phone:$("#phone").val()},
                success:function(data){
                    M.dialog1 = jqueryAlert({
                        'content' : '短信正在发送,请耐心等待!',
                        'closeTime' : 2000
                    })
                }
            })
        }else {
            $.ajax({
                url:'demo.php',
                type:'POST',
                data:{phone:$("#phone2").val()},
                success:function(data){
                    M.dialog1 = jqueryAlert({
                        'content' : '短信正在发送,请耐心等待!',
                        'closeTime' : 2000
                    })
                }
            })
        }

    } else {
        $('#phone').focus();
    }
}
//验证手机号码
function checkPhone(num) {
    var M = {};
    if(M.dialog1){
        return M.dialog1.show();
    }
    if(num==1){
        var phone = $('#phone').val();
    }else {
        var phone = $('#phone2').val();
    }
    var pattern = /^1[0-9]{10}$/;
    isPhone = 1;
    if (phone == '') {
        M.dialog1 = jqueryAlert({
            'content' : '请输入手机号码!',
            'closeTime' : 2000
        })
        isPhone = 0;
        return;
    }
    if (!pattern.test(phone)) {
        M.dialog1 = jqueryAlert({
            'content' : '请输入正确的手机号码!',
            'closeTime' : 2000
        })
        isPhone = 0;
        return;
    }
}
//倒计时
function resetCode() {
    $('.codeBtn1').hide();
    $('#J_second').html('60');
    $('.codeBtn2').show();
    var second = 60;
    var timer = null;
    timer = setInterval(function() {
        second -= 1;
        if (second > 0) {
            $('#J_second').html(second);
            $('#J_second2').html(second);
        } else {
            clearInterval(timer);
            $('.codeBtn1').show();
            $('.codeBtn2').hide();
        }
    }, 1000);
}
//还没账号,点击注册
$("#creg").click(function () {
    $("#text").fadeOut(500);
    $("#bg").fadeOut(500,function () {
        $("#bg2").fadeIn(500);
        $("#text2").fadeIn(500);
    })
});

//点击登录,开始游戏
$("#logReq").click(function () {
    var M = {};
    if(M.dialog1){
        return M.dialog1.show();
    }
    if($("#phone").val() == '' && $("#tm").val() == ''){
        M.dialog1 = jqueryAlert({
            'content' : '请输入手机号码或天猫账号登录!',
            'closeTime' : 2000
        })
    }else if($("#phone").val() != '' && $("#tm").val() != ''){
        M.dialog1 = jqueryAlert({
            'content' : '手机和天猫账号只能输入一个!',
            'closeTime' : 2000
        })
    }else if($("#phone").val() == '' && $("#tm").val() != ''){//天猫账户登录
        $.ajax({
            type: "POST",
            url: "http://customercare.levi.com.cn:10012/api/h5/Member/Query",
            contentType: "application/json", //必须有
            data: JSON.stringify({ 'Moblie':'', 'Nick':$("#tm").val(),'OpenId':''}),
            success: function (result) {
                var res = JSON.parse(result);
                if(res.StatusCode == 'S01'){
                    $("#bg").hide();
                    var oImg = $("<img id='fc' src='img/page2/logfc.png' alt=''>");
                    $(".page2").append(oImg);
                    oImg.fadeIn(1000);
                    localStorage.setItem("nick",$("#tm").val());
                    u_r_l = u_r_l +"&user="+$("#tm").val();//重置分享链接
                    share(u_r_l);
                }else {
                    M.dialog1 = jqueryAlert({
                        'content' : '登录失败，请输入正确的天猫会员账户!',
                        'closeTime' : 2000
                    })
                }

            }
        });
    }else if($("#phone").val() != '' && $("#tm").val() == ''){//手机号码登录
        if($("#pwd").val() == ''){
            M.dialog1 = jqueryAlert({
                'content' : '请输入验证码!',
                'closeTime' : 2000
            })
        }else{
            $.ajax({
                url:'demo.php',
                type:'POST',
                data:{phone2:$("#phone").val(),yzm:$("#pwd").val()},
                success:function(data){
                    if(data==1){//登录成功
                        $.ajax({
                            type: "POST",
                            url: "http://customercare.levi.com.cn:10012/api/h5/Member/Query",
                            contentType: "application/json", //必须有
                            data: JSON.stringify({ 'Moblie':$("#phone").val(), 'Nick':'','OpenId':''}),
                            success: function (result) {
                                var res = JSON.parse(result);
                                if(res.StatusCode == 'S01'){
                                    $("#bg").hide();
                                    var oImg = $("<img id='fc' src='img/page2/logfc.png' alt=''>");
                                    $(".page2").append(oImg);
                                    oImg.fadeIn(1000);
                                    localStorage.setItem("moble",$("#phone").val());
                                    u_r_l = u_r_l +"&phone="+$("#phone").val();//重置分享链接
                                    share(u_r_l);
                                }else {
                                    M.dialog1 = jqueryAlert({
                                        'content' : '您尚未注册会员，请先注册！',
                                        'closeTime' : 2000
                                    })
                                }

                            }
                        });
                    }else {
                        M.dialog1 = jqueryAlert({
                            'content' : '验证码有误,请查询后在输入!',
                            'closeTime' : 2000
                        })
                    }
                }
            })
        }
    }
});

var jifen = false;//注册后为ture，给是否增加积分判断！
var resTime;
//点击注册,开始游戏
$("#regReq").click(function () {
    var pattern = /^1[0-9]{10}$/;
    var M = {};
    if(M.dialog1){
        return M.dialog1.show();
    }

    if($("#phone2").val() == ''){
        M.dialog1 = jqueryAlert({
            'content' : '手机号码不能为空!',
            'closeTime' : 2000
        })
    }else if(!pattern.test($("#phone2").val())){
        M.dialog1 = jqueryAlert({
            'content' : '手机格式错误!',
            'closeTime' : 2000
        })
    }else if($("#pwd2").val() == ''){
        M.dialog1 = jqueryAlert({
            'content' : '请输入验证码!',
            'closeTime' : 2000
        })
    }else {
        $.ajax({
            url:'demo.php',
            type:'POST',
            data:{phone2:$("#phone2").val(),yzm:$("#pwd2").val()},
            success:function(data){
                var RecommendMoblie = '';
                var RecommendedNick = '';
              if(data==1){
                  if(Request['flag']){
                      if(Request['flag']==1){
                          RecommendMoblie=Request['phone'];
                      }
                      if(Request['flag']==2){
                          RecommendedNick=getQueryString('user')
                      }
                  }
                  resTime = getNowFormatDate();
                  $.ajax({
                      type: "POST",
                      url: "http://customercare.levi.com.cn:10012/api/h5/Member/Register",
                      contentType: "application/json", //必须有
                      data: JSON.stringify({ 'Moblie':$("#phone2").val(),'RecommendMoblie':RecommendMoblie,'OpenId':openid,'RecommendNick':RecommendedNick,'Source':Request['source'],'RegistTime':resTime}),
                      success: function (result) {
                          var res = JSON.parse(result);
                          if(res.StatusCode == 'S01'){
                              $("#bg2").hide();
                              var oImg = $("<img id='fc' src='img/page2/regfc.png' alt=''>");
                              $(".page2").append(oImg);
                              oImg.fadeIn(1000);
                              localStorage.setItem("moble",$("#phone2").val());
                              u_r_l = u_r_l +"&phone="+$("#phone2").val();//重置分享链接
                              share(u_r_l);
                              jifen = true;

                          }else {
                              M.dialog1 = jqueryAlert({
                                  'content' : '该手机号码已被注册!',
                                  'closeTime' : 2000
                              })
                          }
                      }
                  });
              }
            }
        })
    }
});

//点击浮层跳转下一页
$(".page2").on('click','#fc',function () {
    page(2);
});

//点击弹出分享遮罩
$("#share").click(function () {
    var oDiv = $("<img id='shareMask' src='img/page4/shareMask.png' alt=''>");
    $(".page4").append(oDiv);
    oDiv.fadeIn(1000);
})


//回顾详情
$("#hgxq").click(function () {
    var oDiv =  $("<div class='ck-box'>\
                    <img onclick='offMask(this);' id='off' src='img/page1/off.png' alt=''>\
                    <img class='ckjs' src='img/page5/ckjs.jpg' alt=''>\
                </div>");
    $(".page4").append(oDiv);
    oDiv.fadeIn(1000);
})
//点击排行榜
$("#phb").click(function () {
    var oDiv =  $("<div class='phb'>\
                    <img onclick='offMask(this);' id='off' src='img/page1/off.png' alt=''>\
                    <img class='jxk' src='img/page4/jxkj.png' alt=''>\
                </div>");
    $(".page4").append(oDiv);
    oDiv.fadeIn(1000);
    $(".phb_box").fadeIn(1000);

    $.ajax({
        url:'demo.php',
        type:'POST',
        data:{phb:'1'},
        dataType: "json",
        success:function(data){
            $(".phb_box").html("");
            for(var i=0;i<data.length;i++){
                if(data[i]['Nick']==null){
                    var moble = data[i]['Moble'];
                    var newMoble = moble[0]+moble[1]+moble[2]+'****'+moble[7]+moble[8]+moble[9]+moble[10];
                    var oDiv = $("<div><p class='sp1'>"+(i+1)+"."+newMoble+"</p><p class='sp2'>"+data[i]['Point']+"</p><p class='sp3'>分</p></div>");
                    $(".phb_box").append(oDiv);
                }else {
                    var Nick = data[i]['Nick'];
                    var newNick ="**"
                    for(var k=2;k<Nick.length;k++){
                        newNick = newNick+ Nick[k];
                    }
                    var oDiv = $("<div><p class='sp1'>"+(i+1)+"."+newNick+"</p><p class='sp2'>"+data[i]['Point']+"</p><p class='sp3'>分</p></div>");
                    $(".phb_box").append(oDiv);
                }
            }
        }
    });

})

//点击遮罩消失
$(".page4").on('click','#shareMask',function () {
    $(this).fadeOut(1000,function () {
        $(this).remove();
    })
});

//游戏部分
var flag = 1;
var num = 0;
var jifen2 = true;//设置只有第一次完成游戏才算积分加成！
var flag2 = true;//判断是不是第一次点
$('.game1>img,.game2>img,.game3>img,.game4>img,.game5>img').click(function () {
    // //重新播放音乐
    // var audio = document.getElementById("media2");
    // audio.currentTime = 0;
    // audio.play();


    num=num+80;
    if(num == 800){
        $(".ku").show(500);
        window.setTimeout(function () {
            $(".ku").hide(500);
        },1500)
    }
    if(num == 1600){
        $(".zan").show(500);
        window.setTimeout(function () {
            $(".zan").hide(500);
        },1500)
    }
    if(num == 3200){
        $(".cj").show(500);
        window.setTimeout(function () {
            $(".cj").hide(500);
        },1500)
    }
    if($(this).attr('class') == 'c2' && flag2){delSbd();flag2 = false;};
    var h = $(this).height();
    var w = $(this).width();
    var ha = $(this).offset().top;
    var wa = $(this).offset().left;
    var oSpan = $("<p class='add-score'>+ 80</p>");
    oSpan.css({'left':w+wa/2+'px','top':h+ha/2+'px'});
    $("#game").append(oSpan);
    oSpan.fadeIn(1000,function () {
        $(this).remove();
    });
    $(this).hide();
    var end = false;
    var n = 0;
    for(var i=0;i < $(this).parent().children('img').length; i++){
        // console.log($(this).parent().children('img').eq(i).css("display"));
        if( $(this).parent().children('img').eq(i).css("display") == 'none'){
            n++;
        }
        if(n==$(this).parent().children('img').length){
            end = true;
        }
    }
    n = 0;
        if(end){
            flag++;
            console.log(flag);
            if(flag==1){
                $(".game2").show();
                $(".game1").hide();
            }
            if(flag==2){
                $(".game3").show();
                $(".game2").hide();
            }
            if(flag==3){
                $(".game4").show();
                $(".game3").hide();
            }
            if(flag==4){
                $(".game5").show();
                $(".game4").hide();
            }
            if(flag==5){
                $('.game1>img,.game2>img,.game3>img,.game4>img,.game5>img').show();
                $(".game1").show();
                $(".game5").hide();
                flag=0;
            }
        }
});

//点击第一件
var timeN = 11;
function delSbd() {
    $(".ddd").hide(500);
    var time = setInterval(function () {
        timeN--;
        $("#num").html(timeN);
        if(timeN==3){
            $(".jiayou").show(500);
            window.setTimeout(function () {
                $(".jiayou").hide(500);
            },1500)
        }
        if(timeN==0){
            window.clearInterval(time);
            page(3);
            score(num);

            if(localStorage.getItem("moble")){
                $.ajax({
                    url:'demo.php',
                    type:'POST',
                    data:{score:num,'moble':localStorage.getItem("moble")},
                    // dataType: "json",
                    success:function(data){

                    }
                });
            }

            if(localStorage.getItem("nick")){
                $.ajax({
                    url:'demo.php',
                    type:'POST',
                    data:{score:num,'nick':localStorage.getItem("nick")},
                    // dataType: "json",
                    success:function(data){

                    }
                });
            }


            var M = {};
            if(M.dialog1){
                return M.dialog1.show();
            }
            //是否增加积分
            if(jifen && getQueryString('user')){
                $.ajax({
                    type: "POST",
                    url: "http://customercare.levi.com.cn:10012/api/h5/Member/Award_point",
                    contentType: "application/json", //必须有
                    data: JSON.stringify({ 'Moblie':'','Nick':getQueryString('user'),'RecommendedMoblie':$("#phone2").val(),'TriggerTime':resTime}),
                    success: function (result) {
                        console.log(result)
                        var res = JSON.parse(result);
                        if(res.StatusCode == 'S01'){
                            M.dialog1 = jqueryAlert({
                                'content' : "您的朋友"+getQueryString('user')+"增加积分200!",
                                'closeTime' : 2000
                            })
                        }
                    }
                });
            }

            if(jifen && Request['phone']){
                console.log($("#phone2").val());
                console.log(resTime);
                $.ajax({
                    type: "POST",
                    url: "http://customercare.levi.com.cn:10012/api/h5/Member/Award_point",
                    contentType: "application/json", //必须有
                    data: JSON.stringify({ 'Moblie':Request['phone'],'Nick':'','RecommendedMoblie':$("#phone2").val(),'TriggerTime':resTime}),
                    success: function (result) {
                        console.log(result)
                        var res = JSON.parse(result);
                        M.dialog1 = jqueryAlert({
                            'content' : "您的朋友"+Request['phone']+"增加积分200!",
                            'closeTime' : 2000
                        })
                    }
                });
            }

        }
    },1000);
}

//点击刚开始
$("#first").click(function () {
    $(this).fadeOut(500);
    $(".hand").fadeOut(200);
    $(".sbd").fadeOut(200);
    $(".ddd").show(500);
});

//再来一把
$("#zztb").click(function () {
    $(".hand").fadeIn(200);
    $(".sbd").fadeIn(200);
    $("#first").fadeIn(200);
    $('.game1>img,.game2>img,.game3>img,.game4>img,.game5>img').show();
    $(".game1").show();
    $(".game2").hide();
    $(".game3").hide();
    $(".game4").hide();
    $(".game5").hide();
    page(2);
    //初始化这些参数
    timeN=11;
    num = 0;
    flag2=true;
    flag=1;
    $("#num").html(10);
})


window.addEventListener("resize", function() {
    if(document.activeElement.tagName=="INPUT" || document.activeElement.tagName=="TEXTAREA") {
        window.setTimeout(function() {
            document.activeElement.scrollIntoViewIfNeeded();
        },0);
    }
})

function audioAutoPlay(id){
    var audio = document.getElementById(id),
        play = function(){
            audio.play();
            document.removeEventListener("touchstart",play, false);
        };
    audio.play();
    document.addEventListener("WeixinJSBridgeReady", function () {
        play();
    }, false);
    document.addEventListener('YixinJSBridgeReady', function() {
        play();
    }, false);
    document.addEventListener("touchstart",play, false);
}
audioAutoPlay('media');

//微信禁止下拉显示

var eventlistener_handler = function(e){
    e.preventDefault();     // 阻止浏览器默认动作(网页滚动)
};

var touchInit = function(){
    document.body.addEventListener("touchmove",eventlistener_handler, false);
};
touchInit();

//控制音乐播放
var xx = document.getElementById("media");
$("#audio_btn").click(function() {
    $(this).toggleClass("rotate");
    if ($(this).hasClass("rotate")) {
        xx.play()
    } else {
        xx.pause()
    }
});

//分数计算函数
function score(a) {
    var len = a.toString().length;
    if(len == 2){
        $(".num").eq(0).html(0);
        $(".num").eq(1).html(0);
        $(".num").eq(2).html(a.toString()[0]);
        $(".num").eq(3).html(a.toString()[1]);
    }else if(len == 3){
        $(".num").eq(0).html(0);
        $(".num").eq(1).html(a.toString()[0]);
        $(".num").eq(2).html(a.toString()[1]);
        $(".num").eq(3).html(a.toString()[2]);
    }else {
        $(".num").eq(0).html(a.toString()[0]);
        $(".num").eq(1).html(a.toString()[1]);
        $(".num").eq(2).html(a.toString()[2]);
        $(".num").eq(3).html(a.toString()[3]);
    }
    if(a>1599){
        $(".cd").attr('src','img/page4/cd2.png');
        $("#bfb").html("50");
    }
    if(a>2399){
        $(".cd").attr('src','img/page4/cd3.png');
        $("#bfb").html("70");
    }
    if(a>3599){
        $(".cd").attr('src','img/page4/cd4.png');
        $("#bfb").html("90");
    }
}

var u_r_l;
if(Request['channel']){
    u_r_l = "http://www.createcdigital.com/createc-new/levis/share.html?source="+Request['source']+"&channel="+Request['channel']+"";
}else{
    u_r_l = "http://www.createcdigital.com/createc-new/levis/share.html?source="+Request['source'];
}

if(localStorage.getItem("moble")){
    u_r_l = u_r_l + "&phone=" + localStorage.getItem("moble");
}
if(localStorage.getItem("nick")){
    u_r_l = u_r_l + "&user=" + localStorage.getItem("nick");
}
share(u_r_l);
function share(url) {
    var a = encodeURI(url);
    wx.ready(function () {
        wx.onMenuShareTimeline({
            title: "Levi's®要带我去旧金山玩了，你也想去？", // 分享标题
            link: a, // 分享链接，该链接域名或路径必须与当前页面对应的公众号JS安全域名一致
            imgUrl: 'http://www.createcdigital.com/createc-new/levis/img/logo.jpg', // 分享图标
            success: function () {
                swiperV.slideTo(4, 0, true);
                _hmt.push(['_trackEvent', '分享', '朋友圈', 'literature']);
            },
            cancel: function () {

            }
        });

        wx.onMenuShareAppMessage({
            title: "Levi's®要带我去旧金山玩了，你也想去？", // 分享标题
            desc: "要跟着Levi's®去旧金山玩的人，是你吗？", // 分享描述
            link: a, // 分享链接，该链接域名或路径必须与当前页面对应的公众号JS安全域名一致
            imgUrl: 'http://www.createcdigital.com/createc-new/levis/img/logo.jpg', // 分享图标
            type: '', // 分享类型,music、video或link，不填默认为link
            dataUrl: '', // 如果type是music或video，则要提供数据链接，默认为空
            success: function () {
                swiperV.slideTo(4, 0, true);
                _hmt.push(['_trackEvent', '分享', '朋友', 'literature']);
            },
            cancel: function () {

            }
        });
    })
}

//判断手机是否横屏
window.addEventListener('orientationchange', function(event){
    if ( window.orientation == 180 || window.orientation==0 ) {
        $(".jzhp").hide();
    }
    if( window.orientation == 90 || window.orientation == -90 ) {
        $(".jzhp").show();
    }
});

//安卓输入法BUG
var H = $(window).height();
var bgH = $("#bg").height();
$("input").focus(function(){
    $("#bg").css('height',bgH+'px');
    $(".page2").css('height',H+'px');
});