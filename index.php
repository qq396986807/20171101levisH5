<?php
require_once 'jssdk.php';
$jssdk = new Jssdk("wxd4f26aea63a05347", "ee83c1915b59d37aa47c14d9e590b052");
$signPackage = $jssdk->GetSignPackage();
$appId = $signPackage["appId"];
$timestamp = $signPackage["timestamp"];
$nonceStr = $signPackage["nonceStr"];
$signature = $signPackage["signature"];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Levi's · 礼遇最牛之人</title>
    <meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1">
    <!-- Link Swiper's CSS -->
    <link rel="stylesheet" href="css/swiper.min.css">
    <link rel="stylesheet" href="css/animate.min.css">
    <link rel="stylesheet" href="css/css.css?v=1.2">
    <link rel="stylesheet" href="css/alert.css">
    <script>
        var _hmt = _hmt || [];
        (function() {
            var hm = document.createElement("script");
            hm.src = "https://hm.baidu.com/hm.js?bf65ad1add48d3030493d53774991cc5";
            var s = document.getElementsByTagName("script")[0];
            s.parentNode.insertBefore(hm, s);
        })();
    </script>
    <script src="js/jquery-3.2.1.min.js"></script>
    <script src="https://res.wx.qq.com/open/js/jweixin-1.2.0.js"></script>
</head>
<body>
<!-- Swiper -->
<div class="jzhp">
    <img class="xuanzhuan" src="img/page1/landscape.png" alt="">
    <span class="tishi">为了更好的体验，请将手机/平板竖过来</span>
</div>
<div id="audio_btn" class="rotate">
    <audio loop src="music/music.mp3" id="media" autoplay="" preload=""></audio>
</div>
<audio src="music/yinxiao1.mp3" id="media2" preload=""></audio>
<div class="swiper-container swiper-container-v">
    <div class="swiper-wrapper">
        <div class="swiper-slide page1 stop-swiping">
            <div id="jiangpin" class="swiper-container swiper-container-c">
                <img id="off_jp" src="img/page1/off.png" alt="">
                <img id="left" src="img/page1/left.png" alt="">
                <img id="right" src="img/page1/right.png" alt="">
                <div class="swiper-wrapper">
                    <div class="swiper-slide p1"></div>
                    <div class="swiper-slide p2"></div>
                    <div class="swiper-slide p3"></div>
                    <div class="swiper-slide p4"></div>
                </div>
            </div>
            <div class="introduce">
                <div id="see1"></div>
                <div style="top: 83%;" id="see2"></div>
                <img onclick="page(1)" src="img/page1/btn.png" alt="">
            </div>
        </div>
        <div class="swiper-slide page2 stop-swiping">
            <img id="text" src="img/page2/logText.png" alt="">
            <img id="text2" src="img/page2/regText.png" alt="">
            <div id="bg">
                <div class="box1 box1-1">
                    <img src="img/page2/phone.png" alt="">
                    <div class="inputLog">
                        <input id="phone" type="text" placeholder="请输入联系电话(必填)">
                    </div>
                </div>
                <div class="box2 box2-2">
                    <img src="img/page2/pwd.png" alt="">
                    <div class="inputLog">
                        <input id="pwd" type="text" placeholder="请输入验证码">
                        <div onclick="getCode(this,1)" class="codeBtn1">获取验证码</div>
                        <div style="display: none;" class="codeBtn2"><span id="J_second">60</span>秒后重发</div>
                    </div>
                </div>
                <div class="box3">
                    <img class="or" src="img/page2/or.png" alt="">
                    <div class="float-k"></div>
                    <img class="tm-icon" src="img/page2/tm.png" alt="">
                    <div class="input-tm">
                        <input id="tm" type="text" placeholder="天猫店铺会员请输入天猫账号">
                    </div>
                </div>
                <img id="logReq" src="img/page2/log.png" alt="">
                <img id="creg" src="img/page2/creg.png" alt="">
            </div>
            <div style="display: none;" id="bg2">
                <div class="box1">
                    <img src="img/page2/phone.png" alt="">
                    <div class="inputLog">
                        <input id="phone2" type="text" placeholder="请输入联系电话(必填)">
                    </div>
                </div>
                <div class="box2">
                    <img src="img/page2/pwd.png" alt="">
                    <div class="inputLog">
                        <input id="pwd2" type="text" placeholder="请输入验证码">
                        <div onclick="getCode(this,2)" class="codeBtn1">获取验证码</div>
                        <div style="display: none;" class="codeBtn2"><span id="J_second2">60</span>秒后重发</div>
                    </div>
                </div>
                <img id="regReq" src="img/page2/reg.png" alt="">
            </div>
        </div>
        <div id="game" class="swiper-slide stop-swiping">
            <img class="sbd" src="img/page3/sbd.png" alt="">
            <img class="hand" src="img/page3/hand.png" alt="">
            <img class="ddd" src="img/page3/ddd.gif" alt="">
            <img class="jiayou" src="img/page3/jiayou.gif" alt="">
            <img class="ku" src="img/page3/ku.gif" alt="">
            <img class="zan" src="img/page3/zan.gif" alt="">
            <img class="cj" src="img/page3/cj.gif" alt="">
            <img id="first" style="z-index: 977;position: absolute;" class="c2" src="img/page3/c3.png" alt="">
            <div class="yuan">
                <span id="num">10</span><span>S</span>
            </div>
            <div class="game">
                <div class="game1">
                    <img class="c1" src="img/page3/c1.png" alt="">
                    <img class="c3" src="img/page3/c2.png" alt="">
                    <img class="c2" src="img/page3/c3.png" alt="">
                    <div class="space">
                        <img class="nc1" src="img/page3/nc1.png" alt="">
                    </div>
                </div>
                <div class='game2'>
                    <img class='c4' src='img/page3/c5.png' alt=''>
                    <img class='c5' src='img/page3/c6.png' alt=''>
                    <img class='c7' src='img/page3/c5.png' alt=''>
                    <img class='c6' src='img/page3/c4.png' alt=''>
                </div>
                <div class='game3'>
                    <img class='c8' src='img/page3/c5.png' alt=''>
                    <img class='c9' src='img/page3/c5.png' alt=''>
                    <img class='c10' src='img/page3/c7.png' alt=''>
                    <img class='c11' src='img/page3/c5.png' alt=''>
                    <img class='c13' src='img/page3/c5.png' alt=''>
                    <img class='c12' src='img/page3/c6.png' alt=''>
                </div>
                <div class='game4'>
                    <img class='c14' src='img/page3/c5.png' alt=''>
                    <img class='c20' src='img/page3/c2.png' alt=''>
                    <img class='c15' src='img/page3/c2.png' alt=''>
                    <img class='c16' src='img/page3/c5.png' alt=''>
                    <img class='c17' src='img/page3/c2.png' alt=''>
                    <img class='c18' src='img/page3/c5.png' alt=''>
                    <img class='c22' src='img/page3/c5.png' alt=''>
                    <img class='c19' src='img/page3/c2.png' alt=''>
                    <img class='c21' src='img/page3/c2.png' alt=''>
                    <img class='c23' src='img/page3/c5.png' alt=''>
                    <div class='space'>
                        <img class='sjx' src='img/page3/sjx.png' alt=''>
                    </div>
                    <div class='space'>
                        <img class='huahand' src='img/page3/huahand.png' alt=''>
                    </div>
                </div>
                <div class='game5'>
                    <img class='c24' src='img/page3/c8.png' alt=''>
                    <img class='c25' src='img/page3/c4.png' alt=''>
                    <img class='c26' src='img/page3/c4.png' alt=''>
                    <img class='c27' src='img/page3/c5.png' alt=''>
                    <img class='c28' src='img/page3/c4.png' alt=''>
                    <img class='c29' src='img/page3/c5.png' alt=''>
                    <div class='space'>
                        <img class='nc2' src='img/page3/nc1.png' alt=''>
                    </div>
                    <img class='c30' src='img/page3/c4.png' alt=''>
                    <img class='c31' src='img/page3/c8.png' alt=''>
                    <img class='c32' src='img/page3/c4.png' alt=''>
                    <img class='c33' src='img/page3/c8.png' alt=''>
                    <div class='space'>
                        <img class='sjx' src='img/page3/sjx.png' alt=''>
                    </div>
                    <div class='space'>
                        <img class='huahand' src='img/page3/huahand.png' alt=''>
                    </div>
                </div>
            </div>
        </div>
        <div class="swiper-slide page4 stop-swiping">
            <img class="score" src="img/page4/score.png" alt="">
            <img class="cd" src="img/page4/cd1.png" alt="">
            <img style="top: 77%" id="share" src="img/page4/yrlz.png" alt="">
            <img style="top: 84%;width: 28%;" id="phb" src="img/page4/phb.png" alt="">
            <img style="top: 84%;width: 28%;left: 50%" id="hgxq" src="img/page4/hgxq.png" alt="">
            <div class="phb_box"></div>
            <img id="zztb" src="img/page4/zzyb.png" alt="">
            <span style="left: 22.5%" class="num">0</span>
            <span style="left: 38%" class="num">0</span>
            <span style="left: 54%" class="num">0</span>
            <span style="left: 70%" class="num">0</span>
            <p class="record"><span id="bfb">20</span>%的玩家<br />都是你的手下败将</p>
            <img class="bottom" src="img/page4/buttom.png" alt="">
        </div>
        <div class="swiper-slide page5 stop-swiping">
            <img class="share_over" src="img/page5/page5.jpg" alt="">
        </div>
    </div>
</div>
<script>
    //微信的操作
    wx.config({
        debug: false,
        appId: '<?php echo $appId?>',
        timestamp: '<?php echo $timestamp?>',
        nonceStr: '<?php echo $nonceStr?>',
        signature: '<?php echo $signature?>',
        jsApiList: [
            // 所有要调用的 API 都要加到这个列表中,,,,,
            "onMenuShareTimeline",
            "onMenuShareAppMessage",
            "checkJsApi",
            "chooseImage",
            "uploadImage",
        ]
    });


</script>
<!-- Swiper JS -->
<script src="js/swiper.jquery.min.js"></script>
<script src="js/swiper.animate1.0.2.min.js"></script>
<script src="js/alert.js"></script>
<script src="js/index.js?v=1.2"></script>
</body>
</html>