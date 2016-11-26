<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="stylesheet" type="text/css" href="/static/css/base.css"/>
<link rel="stylesheet" type="text/css" href="/static/css/gong_xiao.css"/>
<script type="text/javascript" src="http://img.caissa.com.cn/share/j/jquery1.7.1.min.js"></script>
<title>登录</title>
<script>
    function showMsg(msg, err, closeCallback){
        if (!msg) msg = '';
        if (!err) err = false;
        if (!closeCallback) closeCallback = function(){};
        
        if (err) {
            $('.popup .modify_cg p').removeClass('modify_cg_p').addClass('modify_cg_p_err');
        } else {
            $('.popup .modify_cg p').removeClass('modify_cg_p_err').addClass('modify_cg_p');
        }
        $('.popup .modify_cg p').html(msg);
        $('.popup').show();
        
        //添加关闭事件和关闭回调
        $('.popup .modify_span').click(function(){
            hideMsg(closeCallback);
        });
        return false;
    };
    function hideMsg(callback){
        if (!callback) callback = function(){};
        $('.popup').hide();
        callback();
        return false;
    };
</script>
</head>

<body>
<div id="fade" class="modify popup" style="display: none;">
    <div class="modify_center">
        <h3 class="modify_h3"><span class="modify_span" onclick="hideMsg()"></span></h3>
        <div class="modify_cg">
            <p class="modify_cg_p">恭喜，审核已提交，工作人员将尽快处理！</p>
        </div>
    </div>
</div>
<div class="rcxd_wrap">
    <div class="rcxd_banner_form">
       <div class="rcxd_banner" height="100%">
            <!--<img class="img_100" src="/static/images/dl3_01.jpg" />-->
            <img class="img_100" src="/static/images/dl3_02.jpg" />
            <img class="img_100" src="/static/images/dl3_03.jpg" />
            <img class="img_100" src="/static/images/dl3_04.jpg" />
        </div>
        
    </div>
    <div class="zhuanti_top" style="top: 104px;">
        <h3 class="zhuanti_h2">凯撒旅游供应商平台</h3>
        <div class="zhuanti">
        <div class="gx_css clear"><img src="/static/images/ddl3_07.jpg" /></div>
        <div class="from_css">
            <ul class="clear">
                <li><input type="text" name="name" class="yh_inp" placeholder="用户名" /></li>
                <li><input type="password" name="password" class="mima_inp yh_input" placeholder="密码" /></li>
                <li class="captcha" style="display: none;"><input type="text" name="captcha" class="yh_inp yanzheng" placeholder="验证码" /><span class="yzm"></span></li>
            </ul>
            <div class="denglu">登&nbsp;&nbsp;录</div>
            <div class="shai_xuan">
                <label><input style="vertical-align: middle;" id="" name="remember" value="" type="checkbox"><span>&nbsp;7天内自动登录</span></label>
                <span class="shai_span"></span>
            </div>
        </div>
    </div>
    </div>
</div>
<script>
    $(function(){
        $('.denglu').click(function(){
            var name = $('.from_css input[name=name]').val();
            var password = $('.from_css input[name=password]').val();
            var captcha = $('.from_css input[name=captcha]').val();
            var remember = $('input[name=remember]').attr('checked') ? 1 : 0;
            if (name === '') {
                $('.shai_span').html('用户名不能为空');
                return false;
            }
            if (password === '') {
                $('.shai_span').html('密码不能为空');
                return false;
            }
            $.ajax({
                type: "post",
                url: 'login/login/',
                async: true,
                dataType: "json",
                data: {
                    name: name,
                    password: password,
                    captcha: captcha,
                    remember: remember
                },
                success: function(data, success, t){
                    $('.shai_span').html(data.data.msg);
                    if (!data.data.success) {
                        checkNeedCaptcha();
                    } else {
                        //showMsg(data.data.msg, false, function(){
                            location.href = '/home';
                        //});
                    }
                }
            });
        });
        loadCaptcha();
        $('span.yzm').click(function(){
            loadCaptcha();
        });
        //响应回车
        $('input[name=name], input[name=password], input[name=captcha]').keydown(function(e){
            if (e.keyCode == '13') {
                $('.denglu').click();
            }
        });
        //用户名获取焦点
        $('input[name=name]').focus();
        checkNeedCaptcha();
    });
    function loadCaptcha(){
        $.ajax({
            type: 'post',
            url: '/login/captcha/',
            async: true,
            dataType: "json",
            data: {},
            success: function(data, success, t){
                $('span.yzm').html(data.image);
            }
        });
    }
    function checkNeedCaptcha(){
        $.ajax({
            type: 'post',
            url: '/login/checkNeedCaptcha/',
            async: true,
            dataType: "json",
            success: function(data, success, t){console.log(data);
                if (data.data.result) {
                    $('.from_css li.captcha').show();
                    loadCaptcha();
                } else {
                    $('.from_css li.captcha').hide();
                }
                
            }
        });
    }
</script>
</body>
</html>
