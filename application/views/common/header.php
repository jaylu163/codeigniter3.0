<link rel="stylesheet" type="text/css" href="/static/css/base.css"/>
<script type="text/javascript" src="http://img.caissa.com.cn/share/j/jquery1.7.1.min.js"></script>
<script>
    function getMaxZindex(){
        return Math.max.apply(null, $.map($('body > *'), function (e, n) {
                if ($(e).css('position') == 'absolute' || $(e).css('position') == 'fixed') {
                    return parseInt($(e).css('z-index')) || 1;
                }
            })
        );
    }
    /**
     * 提示框
     * @param msg 提示内容
     * @param err 是否提示错误（默认提示正确）
     * @param closeCallback 关闭时回调
     */
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
        $('.popup .modify_center').css('z-index', getMaxZindex() + 1);
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

<body class="body_bg">
<div id="fade" class="modify popup" style="display: none;">
    <div class="modify_center">
        <h3 class="modify_h3"><span class="modify_span" onclick="hideMsg()"></span></h3>
        <div class="modify_cg">
            <p class="modify_cg_p">恭喜，审核已提交，工作人员将尽快处理！</p>
        </div>
    </div>
</div>
<!--公用头部-->
    <div class="gtop_css">
        <div class="gtop clear">
            <h1 class="gtop_css_h1"><img src="/static/images/step1_02.jpg" title="凯撒旅游" /></h1>
            <div class="gtop_css_p">
                <span class="gtop_span gtop_sp" onclick="location.href='/login/logout';">退出</span>
                <span class="gtop_span edit_pass public_table">修改密码</span>
                <span class="gtop_span">你好，<font style="color:#fcac00;"><?php  echo isset($this->userInfo['name'])?$this->userInfo['name']:'';?></font> </span>
            </div>
        </div>
        <div class="gtop_ban">
            <ul>
                <li class="li_first li_new"><a href="/home">首页</a></li>
                <li class="li_new">
                    <a href="">产品管理</a>
                    <div class="cai_dan">
                        <span class="cai_dan"><a href="/product/index">参团游产品</a></span>
                    </div>
                </li>
                <li>
                    <a href="">订单管理</a>
                    <div class="cai_dan">
                        <span class="cai_dan"><a href="/order/orderlist">参团游产品</a></span>
                    </div>
                </li>
                <li><a href="/user/index">用户管理</a></li>
                <li><a href="">我的待办</a></li>
            </ul>
        </div>
    </div>
<!--公用头部-->



<div class="pop_box" id="pop_edit_pass" style="display:none;">
    <div class="pop_wd">
        <div class="model_w_con" style="width: 450px; height: 260px; top: 30%; margin: 0px; margin-left: -200px;">
            <div class="pop_top"><strong class="close"><i></i></strong></div>
            <div class="add_kc">
                <ul>
                    <li><label><i>*</i>新密码：</label><input type="password" name="password" value=""></li>
                    <li><label><i>*</i>确认密码：</label><input type="password" name="password2" value=""></li>
                </ul>
            </div>
            <div class="pop_btn">
                <p>
                    <input type="button" name="submit_edit_pass" value="确认" />
                    <span class="" style="font: 12px Microsoft YaHei,Arial;"></span>
                </p>

            </div>
        </div>
    </div>
    <div class="modal_bg" id="mask"></div>
</div>

<script type="text/javascript">
    function popup(id){
        var model = $('#'+id);
        var mask = $('#mask');
        mask.css("height", $(document).height()).css("width", $(document).width()).show();
        var top = ($(window).height() - model.height()) / 2;
        var left = ($(window).width() - model.width()) / 2;
        var scrollTop = $(document).scrollTop();
        var scrollLeft = $(document).scrollLeft();
        model.find('.tishi').html('');
        model.css({position: 'absolute', 'top': top + scrollTop, left: left + scrollLeft}).show();
        model.find('.close').click(function(){
            mask.hide();
            model.hide();
        });
    }

    $(function () {
        //弹出重设密码框
        $(document).on('click', ' .edit_pass', function(){

            row = $(this).closest('tr').data('row');
            popup('pop_edit_pass');
            //console.log(getMaxZindex());
        });


    });


</script>