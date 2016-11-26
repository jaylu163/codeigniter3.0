<link rel="stylesheet" type="text/css" href="/static/css/gong_xiao.css"/>
<div class="stp_cer clear">
    <div class="mbx_cs"><a href="">凯撒旅游</a> > <a href="">产品管理 </a> > <a href="">产品列表</a></div>
    <div class="qiehuan">
        <div class="xin_zeng">
            <ul class="clear" >
                <li>
                    <span class="xin_span"><font style=" color:#ff0101;" >*</font>  用户名</span>
                    <input class="xin_inp" type="text" value="" name="name" />
                    <span class="xin_tishi">注册后不可修改，支持4-14字符的数字、汉字、字母、下划线。</span>
                    <span class="qie_tishi"></span>
                </li>
                <li>
                    <span class="xin_span"><font style=" color:#ff0101;" >*</font>  姓名</span>
                    <input class="xin_inp" type="text" value="" name="true_name" />
                    <span class="xin_tishi" style="height: 30px; width: 400px;">支持小于50字符的中文、英文、空格、斜杠、点。需以中文或英文开头。</span>
                    <span class="qie_tishi" style="height: 30px; width: 400px; display: none;"></span>
                </li>
                <li>
                    <span class="xin_span"> 手机号</span>
                    <input class="xin_inp" type="text" value="" name="telephone" />
                    <span class="qie_tishi"></span>
                </li>
                <li>
                    <span class="xin_span"><font style=" color:#ff0101;" >*</font>  设置密码</span>
                    <input class="xin_inp" type="password" value="" name="password" />
                    <span class="qie_tishi"></span>
                </li>
                <li>
                    <span class="xin_span"><font style=" color:#ff0101;" >*</font>  确认密码</span>
                    <input class="xin_inp" type="password" value="" name="password2" />
                    <span class="qie_tishi"></span>
                </li>
            </ul>
            <div id="user_add" class="add_css xin_xl_add"><img src="/static/images/step1_155.jpg" /></div>
        </div>
    </div>
</div>

<script>
$(function(){
    $('#user_add').click(function(){
        $.ajax({
            type: "post",
            url: "/user/addSubmit",
            async: true,
            dataType: "json",
            data: {
                name: $('input[name=name]').val(),
                true_name: $('input[name=true_name]').val(),
                telephone: $('input[name=telephone]').val(),
                password: $('input[name=password]').val(),
                password2: $('input[name=password2]').val(),
            },
            success: function(data, success, t){
                cleanErr();
                if (data.data.success) {
                    showMsg(data.data.msg, false, function(){
                        location.href = '/user/';
                    });
                } else {
                    showErr(data.data);
                    //showMsg(data.data.msg, true);
                }
            }
        });
    });
    function showErr(data){
        if (data.errList) {
            $.each(data.errList, function(i, v){
                $current = $('input[name=' + i + ']');
                //$current.css('border-color', '#dddddd');
                if (!v.success) {
                    //$current.css('border-color', 'red');
                    $current.next('span.xin_tishi').hide();
                    $current.siblings('span.qie_tishi').html(v.msg).show();
                }
            });
        }
    }
    function cleanErr(){
        $('input').each(function(){
            $(this).next('span.xin_tishi').show();
            $(this).siblings('span.qie_tishi').hide();
        });
    }
});
</script>