<link rel="stylesheet" type="text/css" href="/static/css/gong_xiao.css"/>
<link rel="stylesheet" type="text/css" href="/static/css/index.css">
<div class="gx_mian">
    <div class="mbx_cs"><a href="">凯撒旅游</a> > <a href="">产品管理 </a> > <a href="">产品列表</a></div>
    <div class="sea_con">
        <ul>
            <li><label>用户名：</label><input type="text" name="name" value=""></li>
            <li><label>姓名：</label><input type="text" name="true_name" value=""></li>
        </ul>
        <p class="btn"><input id="search" type="button" name="" value="查询"></p>
    </div>
    <div class="index_bot">  
        <div class="top_des">
            <div class="ope_btn">
                <span style="display: none;">删除</span>
                <span class="add" id="user_add">+新增</span>
            </div>
        </div>     
        <div class="public_table" style="height: 400px;">
            <table>
                <tr>
                    <th><span class="wd45"><i></i></span></th>
                    <th><span class="wd200">用户名</span></th>
                    <th><span class="wd200">姓名</span></th>
                    <th><span class="wd200">联系方式</span></th>
                    <th><span class="wd150">状态</span></th>
                    <th style="display: none;"><span class="wd250">权限</span></th>
                    <th><span class="wd300">操作</span></th>
                </tr>
                <?php ?>
            </table>
        </div>
        <div id="pageLink" class="page_box"></div>
    </div>
</div>
<div class="pop_box" id="pop_edit" style="display:none;">
    <div class="pop_wd">
        <div class="model_w_con" style="width: 450px; height: 310px; top: 30%; margin: 0px; margin-left: -200px;">
            <div class="pop_top"><strong class="close"><i></i></strong></div>
            <div class="add_kc">
                <ul>
                    <li><label><i>*</i>用户名：</label><input type="text" name="name" value="" disabled="disabled"></li>
                    <li><label><i>*</i>姓名：</label><input type="text" name="true_name" value=""></li>
                    <li><label>手机号码：</label><input type="text" name="telephone" value=""></li>
                </ul>
            </div>
            <div class="pop_btn">
                <p>
                    <input type="button" name="submit_edit" value="保存" />
                    <span class="tishi" style="font: 12px Microsoft YaHei,Arial;"></span>
                </p>
                
            </div>
        </div>
    </div>
    <div class="modal_bg" id="mask"></div>
</div>


<script>

</script>
<script>
    var page = 1;
    function loadList(callback){
        !callback ? callback = function(){} : '';
        $('.public_table table tr.list').remove();
        $.ajax({
            type: "post",
            url: '/user/search',// + location.search,
            async: true,
            dataType: "json",
            data: {
                name: $('.sea_con input[name=name]').val(),
                true_name: $('.sea_con input[name=true_name]').val(),
                page: page
            },
            success: function(data, success, t){
                if (data.data.list) {
                    
                    $.each(data.data.list, function(i, v) {
                        var status = v.status == 1 ? '<em class="status disable">禁用</em>' : '<em class="status">启用</em>';
                        var html = '';
                        html += '<td><span class="wd45"><i></i></span></td>';
                        html += '<td><span class="wd200">' + v.name + '</span></td>';
                        html += '<td><span class="wd200" style="white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">' + v.true_name + '</span></td>';
                        html += '<td><span class="wd200">' + v.telephone + '</td>';
                        html += '<td><span class="wd150">' + v.status_name + '</span></td>';
                        html += '<td><span class="wd300"><em class="edit">编辑</em>' + status + '<em class="del" style="display: none;">删除</em><em class="edit_pass">重设密码</em></span></td>';
                        $('<tr class="list"></tr>').data('row', v).append(html).appendTo('.public_table table');
                    });
                }
                $('#pageLink').html(data.data.pageLink);
                $('#pageLink span a').each(function(){
                    $(this).attr('href', 'javascript:void(0);');
                });
                callback();
            }
        });
    }
    $(function(){
        loadList();
        $('#user_add').click(function(){
            location.href = '/user/add';
        });
        $('#search').click(function(){
            loadList();
        });
        
        $(document).on('click', '#pageLink span a', function(){
            page = $(this).data('ci-pagination-page');
            loadList();
        });
        //弹出编辑框
        $(document).on('click', '.public_table .edit', function(){
            row = $(this).closest('tr').data('row');
            $('#pop_edit input[name=name]').val(row.name);
            $('#pop_edit input[name=true_name]').val(row.true_name);
            $('#pop_edit input[name=telephone]').val(row.telephone);
            popup('pop_edit');
            console.log(getMaxZindex());
        });

        //禁用启用
        $(document).on('click', '.public_table .status', function(){
            row = $(this).closest('tr').data('row');console.log(row);
            $.ajax({
                type: "post",
                url: "/user/" + (row.status == 1 ? 'statusTo2' : 'statusTo1'),
                async: true,
                data: {
                    id: row.id,
                    updatetime: row.updatetime,
                },
                success: function(data){
                    showMsg(data.data.msg);
                    if (data.data.success) {
                        loadList();
                    }
                }
            });
        });
        //提交编辑
        $('input[name=submit_edit]').click(function(){
            var true_name = $('#pop_edit input[name=true_name]').val();
            if (true_name === '') {
                $(this).next('span').html('姓名不能为空');
                return false;
            }
            $.ajax({
                type: "post",
                url: "/user/edit",
                async: true,
                data: {
                    id: row.id,
                    //name: row.name,
                    true_name: true_name,
                    telephone: $('#pop_edit input[name=telephone]').val(),
                    updatetime: row.updatetime,
                },
                success: function(data){
                    if (data.data.success) {
                        showMsg(data.data.msg);
                        loadList();
                    } else {
                        $('#pop_edit .pop_btn span').html(data.data.msg);
                    }
                }
            });
        });
        //提交重设密码
        $('input[name=submit_edit_pass]').click(function(){
            var password = $('#pop_edit_pass input[name=password]').val();
            var password2 = $('#pop_edit_pass input[name=password2]').val();
            if (password === '') {
                $(this).next('span').html('密码不能为空');
                return false;
            }
            if (password2 === '') {
                $(this).next('span').html('确认密码不能为空');
                return false;
            }
            $.ajax({
                type: "post",
                url: "/user/editPassword",
                async: true,
                data: {
                    id: row.id,
                    password: password,
                    password2: password2,
                    updatetime: row.updatetime,
                },
                success: function(data){
                    if (data.data.success) {
                        showMsg(data.data.msg);
                        loadList();
                    } else {
                        $('#pop_edit_pass .pop_btn span').html(data.data.msg);
                    }
                }
            });
        });
    });
    
</script>