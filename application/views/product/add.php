<link rel="stylesheet" type="text/css" href="/static/css/gong_xiao.css"/>
<script type="text/javascript" charset="utf-8" src="/static/plugin/ueditor/ueditor.config.js"></script>
<script type="text/javascript" charset="utf-8" src="/static/plugin/ueditor/ueditor.all.min.js"></script>
<link rel="stylesheet" type="text/css" href="/static/plugin/webuploader/webuploader.css" />
<script type="text/javascript" src="/static/plugin/webuploader/webuploader.min.js"></script>
<script type="text/javascript" src="/static/js/product/upload_img.js"></script>
<script type="text/javascript" src="/static/js/product/upload_file.js"></script>
<div class="stp_cer clear">
    <div class="mbx_cs"><a href="/">凯撒旅游</a> > <a href="/product">产品管理 </a> > <a href="/product/add">产品添加</a></div>
    <div class="qiehuan">
        <div class="qie_sep">
            <span class="qie_sep_span sep_new">step1产品信息</span>
            <span class="qie_sep_span">step2设置库存报价</span>
        </div>
        <div class="qie_sep_ul" style="display:block">
            <h3 class="qie_h3">说明：1、产品名称不得录入出发地及行程天数。     2、标有“<font style=" color:#ff0101;" >*</font> ”，为必填项</h3>
            <ul class="clear">
                <li class="product_code">
                    <span class="qie_span">供应商产品编号</span>
                    <input class="qie_inp" type="text" value="" name="product_code" />
                    <span class="qie_tishi"></span>
                </li>
                <li class="tour_type from_radio">   
                    <span class="qie_span"><font style=" color:#ff0101;" >*</font>  出入境类型</span>
                    <?php foreach ($tourType as $val) :?>
                    <span class="cj_cs" value="<?php echo $val['id'];?>"><?php echo $val['name'];?></span>
                    <?php endforeach;?>
                    <span class="qie_tishi tour_type"></span>
                </li>
                <li>
                    <span class="qie_span"><font style=" color:#ff0101;" >*</font>  行程天数</span>
                    <input class="qie_inp tianshu" type="text" value="" name="delay_date_day" onkeyup="this.value=this.value.replace(/\D/g,'')" onafterpaste="this.value=this.value.replace(/\D/g,'')"/>
                    <span class="ts_sp">天</span>
                    <input class="qie_inp tianshu" type="text" value="" name="delay_date_night" onkeyup="this.value=this.value.replace(/\D/g,'')" onafterpaste="this.value=this.value.replace(/\D/g,'')"/>
                    <span class="ts_sp">晚</span>
                    <span class="qie_tishi delay_date"></span>
                </li>
                <li class="start_city_id from_select">
                    <span class="qie_span"><font style=" color:#ff0101;" >*</font>  出发城市</span>
                    <input class="qie_inp crt_cs" type="text" value="" name="start_city_id" placeholder="输入关键字后自动搜索" />
                    <span class="qie_tishi start_city_id"></span>
                    <span class="xiala_cs"><img src="/static/images/step1_14.jpg" /></span>
                    <div class="xl_kuang" style="height: 200px; overflow: auto; display:none;">
                    </div>
                </li>
                <li>
                    <span class="qie_span"><font style=" color:#ff0101;" >*</font>  产品名称</span>
                    <input class="qie_inp" type="text" value="" name="product_name" />
                    <span class="qie_tishi product_name"></span>
                    
                </li>
                <li class="liulan">
                    <span class="qie_span">产品名称预览</span>
                    <span class="ts_sp">北京出发：十全十美—摩洛哥浪漫风情之旅  东航直飞9天8晚</span>
                    
                </li>
                <li>
                    <span class="qie_span"><font style=" color:#ff0101;" >*</font>  产品特色</span>
                    <input class="qie_inp" type="text" value="" placeholder="如：比萨 卢浮宫 塞纳河 THE MALL" name="product_feature" />
                    <span class="qie_tishi product_feature"></span>
                    
                </li>
                <li>
                    <span class="qie_span"><font style=" color:#ff0101;" >*</font>  副标题</span>
                    <input class="qie_inp" type="text" value="" placeholder="如：一价全含 特色餐 高迪建筑主题" name="sub_name" />
                    <span class="qie_tishi sub_name"></span>
                    
                </li>
                <li class="des_area_id from_select">
                    <span class="qie_span"><font style=" color:#ff0101;" >*</font>  目的地分区</span>
                    <input class="qie_inp crt_cs" type="text" value="请输入" name="des_area_name" />
                    <span class="qie_tishi des_area_id"></span>
                    <span class="xiala_cs"><img src="/static/images/step1_14.jpg" /></span>
                    <div class="xl_kuang" style="height: 251px; overflow: auto; display:none;">
                        <p class="xl_p" style="cursor: pointer;"><span class="xl_span" value="0">请输入</span></p>
                        <?php foreach ($desArea as $val) :?>
                        <p class="xl_p" style="cursor: pointer;"><span class="xl_span" value="<?php echo $val['id'];?>"><?php echo $val['name'];?></span></p>
                        <?php endforeach;?>
                    </div>
                </li>
                <li class="traffic_id from_radio">
                    <span class="qie_span"><font style=" color:#ff0101;" >*</font>  交通方式</span>
                    <?php foreach ($traffic as $val) :?>
                    <span class="cj_cs" value="<?php echo $val['id'];?>"><?php echo $val['name'];?></span>
                    <?php endforeach;?>
                    <span class="qie_tishi traffic_id"></span>
                </li>
                <li class="des_country from_select">
                    <span class="qie_span"><font style=" color:#ff0101;" >*</font>  目的地国家</span>
                    <input class="qie_inp crt_cs" type="text" value="" name="des_country" placeholder="输入关键字后自动搜索" />
                    <span class="qie_tishi des_country"></span>
                    <span class="xiala_cs"><img src="/static/images/step1_14.jpg" /></span>
                    <div class="xl_kuang" style="height: 200px; overflow: auto; display:none;">
                    </div>
                    <div class="xuanze">
                    </div>
                </li>
                <li class="product_level_id from_radio">
                    <span class="qie_span"><font style=" color:#ff0101;" >*</font>  产品等级</span>
                    <?php foreach ($productLevel as $val) :?>
                    <span class="cj_cs" value="<?php echo $val['id'];?>"><?php echo $val['name'];?></span>
                    <?php endforeach;?>
                    <span class="qie_tishi product_level_id"></span>
                </li>
                <li class="product_series_id from_radio">
                    <span class="qie_span"><font style=" color:#ff0101;" >*</font>  产品系列</span>
                    <?php foreach ($productSeries as $val) :?>
                    <span class="cj_cs" value="<?php echo $val['id'];?>"><?php echo $val['name'];?></span>
                    <?php endforeach;?>
                    <span class="qie_tishi product_series_id"></span>
                </li>
                <li class="product_theme from_checkbox">
                    <span class="qie_span"><font style=" color:#ff0101;" >*</font>  产品主题</span>
                    <div class="ch_div">
                        <?php foreach ($productTheme as $val) :?>
                        <span class="zhuti_cs" value="<?php echo $val['id'];?>"><?php echo $val['name'];?></span>
                        <?php endforeach;?>
                        <span class="qie_tishi product_theme"></span>
                    </div>
                </li>
                <li class="kids_standard_id from_select">
                    <span class="qie_span"><font style=" color:#ff0101;" >*</font>  儿童标准价</span>
                    <input class="qie_inp crt_cs" type="text" value="请输入" name="" />
                    <span class="qie_tishi kids_standard_id"></span>
                    <span class="xiala_cs"><img src="/static/images/step1_14.jpg" /></span>
                    <div class="xl_kuang" style="height: 251px; overflow: auto; display:none;">
                        <p class="xl_p" style="cursor: pointer;"><span class="xl_span" value="0">请输入</span></p>
                        <?php foreach ($kidsStandard as $val) :?>
                        <p class="xl_p" style="cursor: pointer;"><span class="xl_span" value="<?php echo $val['id'];?>"><?php echo $val['name'];?></span></p>
                        <?php endforeach;?>
                    </div>
                </li>
                <li class="hotel_level from_checkbox">
                    <span class="qie_span"><font style=" color:#ff0101;" >*</font>  酒店等级</span>
                    <div class="ch_div">
                        <?php foreach ($hotelLevel as $val) :?>
                        <span class="zhuti_cs" value="<?php echo $val['id'];?>"><?php echo $val['name'];?></span>
                        <?php endforeach;?>
                        <span class="qie_tishi hotel_level"></span>
                    </div>
                    
                </li>
                <li class="product_images">
                    <span class="qie_span"><font style=" color:#ff0101;" >*</font>  产品图片</span>
                    <span id="img_select">选择图片</span>
                    <span class="ts_sp tup_cs">图片说明</span>
                    <span class="qie_tishi product_images"></span>
                    <div class="xuanze" id="imgList"></div>
                </li>
                <li class="xingcheng_gaiyao">
                    <span class="qie_span"><font style=" color:#ff0101;" >*</font>  行程概要</span>
                    <span class="zhaiyao zhaiyao_new gaiyao_btn" style="cursor: pointer;">文本编辑</span>
                    <span class="zhaiyao gaiyao_btn" style="cursor: pointer;">上传附件</span>
                    <span class="qie_tishi xingcheng_gaiyao"></span>
                    <div class="xuanze gaiyao_detail" style="display:block;">
                        <span>此处方编辑文档此处方编辑文档此处方编辑文档此处方编辑文档此处方编辑文档此处方编辑文档此处方编辑文档</span>
                        <script id="editor" type="text/plain" style="width: 906px; height: 400px;"></script>
                        
                    </div>
                    <div class="xuanze gaiyao_detail" style="display:none;">
                        <span class="tupian xingcheng_gaiyao_file" id="gaiyao_file" style="margin-right: 45px;">选择附件</span>
                        <div style="width: 990px; margin-top: 15px; float:left; display: block;" id="gaiyaoFileList"></div>
                    </div>
                </li>
                <li>
                    <span class="qie_span"><font style=" color:#ff0101;" >*</font>  签证及面签说明</span>
                    <textarea id="" name="visa_description" class="tabThree_textarea"></textarea>
                    <span class="xuanze qie_tishi visa_description"></span>
                </li>
                <li>
                    <span class="qie_span">  签证及面签说明附件</span>
                    <span class="tupian" id="visa_file" style="margin-right: 45px;">选择附件</span>
                    <span class="qie_tishi visa_file"></span>
                    <div class="xuanze" id="visaFileList"></div>
                </li>
                <li>
                    <span class="qie_span">其他说明</span>
                    <textarea id="" name="other_description" class="tabThree_textarea"></textarea>
                    <span class="xuanze qie_tishi other_description"></span>
                </li>
            </ul>
            <div class="add_css" id="addSubmit"><img src="/static/images/step1_154.jpg" /></div>
        </div>
        
    </div>
</div>
<script>
    //添加时为0，编辑是为1
    var is_edit = '<?php echo $isEdit;?>';
    if (is_edit != '0') {
        var info = $.parseJSON('<?php echo json_encode($info);?>');
    }
    
    $(function(){
        //初始化UEditor
        UE.getEditor('editor');
        //行程概要事件
        $('li.xingcheng_gaiyao span.gaiyao_btn').click(function(){
            $(this).addClass('zhaiyao_new').siblings('span.gaiyao_btn').removeClass('zhaiyao_new');
            $(this).closest('li').find('div.gaiyao_detail').eq($(this).index('span.gaiyao_btn')).show().siblings('div.gaiyao_detail').hide();
        });
        //单选按钮事件
        $(document).on('click', 'li.from_radio span', function() {
            radioValue($(this).closest('li'), false, $(this).attr('value'));
        });
        //多选框事件
        $(document).on('click', 'li.from_checkbox .ch_div span', function() {
            if (!$(this).hasClass('zhti_css')) {
                checkboxValue($(this).closest('li'), false, $(this).attr('value'));
            } else {
                $(this).removeClass('zhti_css')
            }
        });
        //下拉-按钮事件
        $('li.from_select span.xiala_cs').click(function(){
            $(this).closest('li').find('div.xl_kuang').toggle();
        });
        //下拉-选项点击事件
        $(document).on('click', 'li.from_select div.xl_kuang p', function(){
            selectValue($(this).closest('li'), false, $(this).find('span').attr('value'));
            $(this).closest('li').find('div.xl_kuang').hide();
        });
        //下拉-输入框事件
        $('li.from_select input').focus(function(){
            $(this).closest('li').find('div.xl_kuang').show();
        });
        //下拉-点击空白隐藏
        $(document).mouseup(function(e){
            var _input = $('li.from_select input');//输入框
            var _xiala = $('li.from_select span.xiala_cs');//下拉
            var _select = $('li.from_select div.xl_kuang');//选项
            if(!_input.is(e.target) && _input.has(e.target).length === 0 &&
            !_xiala.is(e.target) && _xiala.has(e.target).length === 0 &&
            !_select.is(e.target) && _select.has(e.target).length === 0){
                _input.closest('li').find('div.xl_kuang').hide();
            }
        });
        //出发城市事件
        $('li.start_city_id input').bind('input propertychange', function(){
            loadStartCity($('li.start_city_id'), $(this).val());
        });
        //目的地国家事件
        $('li.des_country input').bind('input propertychange', function(){
            loadDesCountry($('li.des_country'), $(this).val());
        });
        
        $('#addSubmit').click(function(){
            if ($(this).data('submited')) return false;
            $(this).data('submited', true);
            $.ajax({
                type: "post",
                url: "/product/addSubmit",
                async: true,
                data: {
                    'product_code': $('input[name=product_code]').val(),
                    'tour_type': radioValue($('li.tour_type'), true).value,
                    'tour_type_name': radioValue($('li.tour_type'), true).name,
                    'delay_date_day': $('input[name=delay_date_day]').val(),
                    'delay_date_night': $('input[name=delay_date_night]').val(),
                    'start_city_id': selectValue($('li.start_city_id'), true).value,
                    'start_city_name' : selectValue($('li.start_city_id'), true).name,
                    'product_name': $('input[name=product_name]').val(),
                    'product_feature': $('input[name=product_feature]').val(),
                    'sub_name': $('input[name=sub_name]').val(),
                    'des_area_id': selectValue($('li.des_area_id'), true).value,
                    'des_area_name': selectValue($('li.des_area_id'), true).name,
                    'traffic_id': radioValue($('li.traffic_id'), true).value,
                    'traffic_name': radioValue($('li.traffic_id'), true).name,
                    'hotel_level': JSON.stringify(checkboxValue($('li.hotel_level'), true)),
                    'des_country': JSON.stringify(selectMultiValue($('li.des_country'), true)),
                    'product_level_id': radioValue($('li.product_level_id'), true).value,
                    'product_level_name': radioValue($('li.product_level_id'), true).name,
                    'product_series_id': radioValue($('li.product_series_id'), true).value,
                    'product_series_name': radioValue($('li.product_series_id'), true).name,
                    'product_theme': JSON.stringify(checkboxValue($('li.product_theme'), true)),
                    'kids_standard_id': selectValue($('li.kids_standard_id'), true).value,
                    'kids_standard_name': selectValue($('li.kids_standard_id'), true).name,
                    'product_images': JSON.stringify(fileListValue($('#imgList'), true)),
                    'xingcheng_gaiyao_text': UE.getEditor('editor').getContent(),
                    'xingcheng_gaiyao_file': JSON.stringify(fileListValue($('#gaiyaoFileList'), true)),
                    'other_description': $('textarea[name=other_description]').val(),
                    'visa_description': $('textarea[name=visa_description]').val(),
                    'visa_file': JSON.stringify(fileListValue($('#visaFileList'), true)),
                },
                success: function(data){
                    $('#addSubmit').data('submited', false);
                    $('.qie_tishi').html('');
                    if (!data.data.success) {
                        showMsg(data.data.msg, true);
                        $.each(data.data.errList, function(i, v){
                            $('.qie_tishi.' + i).html(v.msg);
                        });
                    } else {
                        showMsg(data.data.msg);
                    }
                }
            });
        });
        showEdit();
    });
    
    function loadStartCity(t, word, callback){
        !callback ? callback = function(){} : '';
        $.ajax({
            type: "post",
            url: "/product/getStartCity",
            async: true,
            data: {'word': word},
            success: function(data){
                t.find('div.xl_kuang').html('');
                if (data.data) {
                    $.each(data.data, function(i, v){
                        var p = '<p class="xl_p" style="cursor: pointer;"><span class="xl_span" value="' + v.id + '">' + v.name + '</span></p>';
                        t.find('div.xl_kuang').append(p);
                    });
                }
                callback();
            }
        });
    }
    function loadDesCountry(t, word, callback){
        !callback ? callback = function(){} : '';
        $.ajax({
            type: "post",
            url: "/product/getDesCountry",
            async: true,
            data: {'word': word},
            success: function(data){
                t.find('div.xl_kuang').html('');
                if (data.data) {
                    $.each(data.data, function(i, v){
                        var $p = $(
                            '<p class="xl_p" style="cursor: pointer;"><span class="xl_span" value="' + v.id + '">' + v.name + '</span></p>'
                        );
                        t.find('div.xl_kuang').append($p);
                        //绑定对选下拉事件
                        $p.unbind('click').bind('click', function(){
                            selectMultiValue($(this).closest('li'), false, $(this).find('span').attr('value'));
                            $(this).closest('li').find('div.xl_kuang').hide();
                        });
                    });
                }
                callback();
            }
        });
    }
    function showEdit(){
        if (is_edit == '1') {
            showProductInfo();
        } else if (is_edit == '2') {
            showProductInfo();
            disableEdit();
        }
    }
    function showProductInfo(){
        if (info) {console.log(info);
            $('input[name=product_code]').val(info.product_code);
            radioValue($('li.tour_type'), false, info.tour_type);
            $('input[name=delay_date_day]').val(info.delay_date_day);
            $('input[name=delay_date_night]').val(info.delay_date_night);
            loadStartCity($('li.start_city_id'), info.start_city_name, function(){
                selectValue($('li.start_city_id'), false, info.start_city_id);
            });
            $('input[name=product_name]').val(info.product_name);
            
            
        }
    }
    function disableEdit(){
        
    }
    /**
     * 单选按钮set/get
     * @param t eg. $('li.tour_type')
     * @param value 值
     * @param get boolean
     */
    function radioValue(t, get, value){
        get = get ? get : false;
        var radios = t.find('span.cj_cs');
        if (!get && !value) {
            radios.removeClass('xuan_zhong');
        }
        var result = {'value': '', 'name': ''};
        $.each(radios, function(){
            if (get) {
                if ($(this).hasClass('xuan_zhong')) {
                    result = {'value': $(this).attr('value'), 'name': $(this).html()};
                    return false;
                }
            } else {
                if ($(this).attr('value') == value) {
                    $(this).addClass('xuan_zhong').siblings().removeClass('xuan_zhong');
                    return false;
                }
            }
        });
        return result;
    }
    /**
     * 下拉列表set/get
     * @param t eg. $('li.des_area_id')
     * @param value 值
     * @param get boolean
     */
    function selectValue(t, get, value){
        get = get ? get : false;
        value = value ? value : '0';
        var sel = t.find('div.xl_kuang span');//下拉列表项
        var input = t.find('input[type=text]');
        if (get) {
            if (input.attr('selected') && input.data('id')) {
                return {'value': input.data('id'), 'name': input.val()};
            }
            return {'value': 0, 'name': ''};
        } else {
            $.each(sel, function(){
                if ($(this).attr('value') == value) {
                    input.val($(this).html());
                    input.data('id', value);
                    input.attr('selected', 'selected');
                    return false;
                }
            });
        }
    }
    /**
     * 下拉列表set/get
     * @param t eg. $('li.des_country')
     * @param get boolean
     * @param value 值 多个在用逗号隔开
     */
    function selectMultiValue(t, get, value, keepBefore){
        value = String(value).split(',');
        get = get ? get : false;
        typeof keepBefore == 'undefined' ? keepBefore = true : '';
        var sel = t.find('div.xl_kuang span');//下拉列表项
        var box = t.find('.xuanze');//存储选中结果的box
        var box_item = box.find('p span.xz_span');//选中结果项
        if (!get && (!keepBefore || !value)) {
            box.html('');
        }
        if (get) {
            var re_val = '';
            var re_name = '';
            $.each(box_item, function(){
                re_val += (re_val ? ',' : '') + $(this).attr('value');
                re_name += (re_name ? ',' : '') + $(this).html();
            });
            return {'value': re_val, 'name': re_name};
        } else {
            var exists = [];//已存在的选项，不允许添加
            $.each(box_item, function(){
                exists.push($(this).attr('value'));
            });
            $.each(sel, function(){
                if ($.inArray($(this).attr('value'), value) >= 0 && $.inArray($(this).attr('value'), exists) < 0) {
                    var $p = $(
                        '<p class="xz_p">' +
                            '<span class="xz_span xz_span01" value="' + $(this).attr('value') + '">' + $(this).html() + '</span><span class="guanbi"><img src="/static/images/step1_28.jpg" height="24" /></span>' +
                        '</p>'
                    );
                    box.append($p);
                    $del = $p.find('span.guanbi').click(function(){
                        $(this).closest('p').remove();
                    });
                }
            });
        }
    }
    /**
     * 下拉列表set/get
     * @param t eg. $('li.product_theme')
     * @param value 值
     * @param get boolean
     */
    function checkboxValue(t, get, value, keepBefore){
        value = String(value).split(',');
        get = get ? get : false;
        typeof keepBefore == 'undefined' ? keepBefore = true : '';
        var box = t.find('div.ch_div span');
        var re_val = '';
        var re_name = '';
        if (!get && (!keepBefore || !value)) {
            box.removeClass('zhti_css');
        }
        $.each(box, function(){
            if (get) {
                if ($(this).hasClass('zhti_css')) {
                    re_val += (re_val ? ',' : '') + $(this).attr('value');
                    re_name += (re_name ? ',' : '') + $(this).html();
                }
            } else {
                if ($.inArray($(this).attr('value'), value) >= 0) {
                    $(this).addClass('zhti_css');
                }
            }
        });
        return {'value': re_val, 'name': re_name};
    }
    /**
     * 文件列表set/get
     * @param t eg. $('div#imgList')
     * @param value 值
     * @param get boolean
     */
    function fileListValue(t, get, value, canDel){
        value = String(value).split(',');
        get = get ? get : false;
        canDel = canDel ? canDel : false;
        var list = t;
        
        if (get) {
            var files = [];
            $.each(list.find('p'), function(){
                files.push($(this).data('file_url'));
            });
            return files;
        } else {
            $.each(value, function(i, v){
                var filename = pop(v.split('.'));
                if (list.is('#imgList')) {
                    var $li = $(
                        '<p id="" class="img_p file-item thumbnail">' +
                            '<img>' +
                            '<span class="img_span info">' + filename + '</span>' +
                            '<span class="shachu_cs remove-this"><img src="/static/images/step1_47.jpg" /></span>' +
                        '</p>'
                    ),
                    $img = $li.find('img:first');
                    $img.attr( 'src', '/static/images/step1_136.jpg' );//TODO
                } else {
                    var $li = $(
                        '<p id="" class="img_p file-item thumbnail" style="width: 360px;">' +
                            '<span class="img_span info">' + filename + '</span>' +
                            '<span class="shachu_cs remove-this" style="top: 8px;"><img src="/static/images/step1_47.jpg" /></span>' +
                        '</p>'
                    );
                }
                $li.data('file_url', v);
                list.append( $li );
            });
        }
        
        
    }
</script>