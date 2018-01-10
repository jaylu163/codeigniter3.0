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

    </div>
<!--公用头部-->



<div class="pop_box" id="pop_edit_pass" style="display:none;">

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