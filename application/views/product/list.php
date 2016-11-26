<link rel="stylesheet" type="text/css" href="/static/css/gong_xiao.css"/>
<link rel="stylesheet" type="text/css" href="/static/css/index.css">
<div class="gx_mian">
    <div class="mbx_cs"><a href="">凯撒旅游</a> > <a href="">产品管理 </a> > <a href="">产品列表</a></div>
    <div class="sea_con">
        <ul>
            <li><label>产品名称：</label><input type="text" name="product_name" value=""></li>
            <li><label>供应商产品编号：</label><input type="text" name="product_code" value=""></li>
            <li><label>凯撒产品编号：</label><input type="text" name="caissa_product_code" value=""></li>
            <li><label>目的地：</label><input type="text" name="des_area_name" value=""></li>
            <li><label>提交日期：</label><input type="text" name="createtime" value=""></li>
        </ul>
        <p class="btn"><input type="button" name="" value="查询"></p>
    </div>
    <div class="index_bot">  
        <div class="top_des">
            <div class="ope_btn">
                <span>更改供应商op</span>
                <span class="add" id="product_add">+新增</span>
            </div>
        </div>     
        <div class="public_table" style="height: 400px;">
            <table>
                <tr>
                    <th><span class="wd45"><i></i></span></th>
                    <th><span class="wd120">凯撒产品编号</span></th>
                    <th><span class="wd120">供应商产品编号</span></th>
                    <th><span class="wd250">产品名称</span></th>
                    <th><span class="wd80">供应商op</span></th>
                    <th><span class="wd200">库存报价数据明细</span></th>
                    <th><span class="wd120">数据最后更新时间</span></th>
                    <th><span class="wd200">操作</span></th>
                </tr>
            </table>
        </div>
        <div id="pageLink" class="page_box"></div>
    </div>
</div>
<script>
    var page = 1;
    function loadList(callback){
        !callback ? callback = function(){} : '';
        $('.public_table table tr.list').remove();
        $.ajax({
            type: "post",
            url: '/product/search',
            async: true,
            dataType: "json",
            data: {
                product_name: $('.sea_con input[name=product_name]').val(),
                product_code: $('.sea_con input[name=product_code]').val(),
                caissa_product_code: $('.sea_con input[name=caissa_product_code]').val(),
                des_area_name: $('.sea_con input[name=true_name]').val(),
                createtime: $('.sea_con input[name=true_name]').val(),
                page: page,
            },
            success: function(data, success, t){
                if (data.data.list) {
                    
                    $.each(data.data.list, function(i, v) {
                        var status = v.status == 1 ? '<em class="status disable">禁用</em>' : '<em class="status">启用</em>';
                        var html = '';
                        html += '<td><span class="wd45"><i></i></span></td>';
                        html += '<td><span class="wd120">' + v.caissa_product_code + '</span></td>';
                        html += '<td><span class="wd120">' + v.product_code + '</span></td>';
                        html += '<td><span class="wd250" style="white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">' + v.start_city_name + '出发：' +  v.product_name + '</td>';
                        html += '<td><span class="wd80">' + v.op_name + '</span></td>';
                        html += '<td><span class="wd200"><b>未提交：21</b><b>审核中：20</b><b>未提交：21</b><b>审核中：20</b></span></td>';
                        html += '<td><span class="wd120">' + v.updatetime + '</span></td>';
                        html += '<td><span class="wd200"><a class="see pad_ri10">查看</a><em class="copy">复制</em><em class="kc_bj">库存报价</em></span></td>';
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
        //跳转到添加
        $('#product_add').click(function(){
            location.href = '/product/add';
        });
        //查询
        $('#search').click(function(){
            loadList();
        });
        //ajax分页
        $(document).on('click', '#pageLink span a', function(){
            page = $(this).data('ci-pagination-page');
            loadList();
        });
    });
</script>