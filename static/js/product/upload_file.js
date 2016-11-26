//行程概要设置
$(function(){
    var $gaiyaoFileList = $('#gaiyaoFileList');
    var up_visa_file = WebUploader.create({
        // 选完文件后，是否自动上传。
        auto: true,
        // swf文件路径
        swf: '/static/webuploader/Uploader.swf',
        // 文件接收服务端。
        server: '/product/fileUpload',
        // 选择文件的按钮。可选。
        // 内部根据当前运行是创建，可能是input元素，也可能是flash.
        pick: '#gaiyao_file',
        fileVal: 'xingcheng_gaiyao_file',
        formData: {'input_name': 'xingcheng_gaiyao_file'},
        duplicate: false,
    });
    // 当有文件添加进来的时候
    up_visa_file.on( 'fileQueued', function( file ) {
        if ($gaiyaoFileList.html() != '') {
            var $li = $gaiyaoFileList.find('p');
            $li.find('.remove-this').click();
        }
        var $li = $(
            '<p id="' + file.id + '" class="img_p file-item thumbnail" style="width: 360px;">' +
                '<span class="img_span info">' + file.name + '</span>' +
                '<span class="shachu_cs remove-this" style="top: 8px;"><img src="/static/images/step1_47.jpg" /></span>' +
            '</p>'
        );
        // $list为容器jQuery实例
        $gaiyaoFileList.append( $li );
        
    });
    //文件上传结果，返回false时调用uploadError事件
    up_visa_file.on('uploadAccept', function(t, data) {
        $('.qie_tishi.xingcheng_gaiyao').html('');
        var data = data.data;
        var $li = $('#' + t.file.id);
        if (data.success) {
            $li.data('file_url', data.data.full_path);
            return true;
        } else {
            $li.remove();
            $('.qie_tishi.xingcheng_gaiyao').html(data.msg);
        }
        return false;
    });
});
//签证及面签说明附件设置
$(function(){
    var $visaFileList = $('#visaFileList');
    var up_visa_file = WebUploader.create({
        // 选完文件后，是否自动上传。
        auto: true,
        // swf文件路径
        swf: '/static/webuploader/Uploader.swf',
        // 文件接收服务端。
        server: '/product/fileUpload',
        // 选择文件的按钮。可选。
        // 内部根据当前运行是创建，可能是input元素，也可能是flash.
        pick: '#visa_file',
        fileVal: 'visa_file',
        formData: {'input_name': 'visa_file'},
        duplicate: false,
    });
    // 当有文件添加进来的时候
    up_visa_file.on( 'fileQueued', function( file ) {
        var $li = $(
            '<p id="' + file.id + '" class="img_p file-item thumbnail" style="float: none; width: 360px;">' +
                '<span class="img_span info" style="text-align: left;">' + file.name + '</span>' +
                '<span class="shachu_cs remove-this" style="top: 8px;"><img src="/static/images/step1_47.jpg" /></span>' +
            '</p>'
        );
        // $list为容器jQuery实例
        $visaFileList.append( $li );
    
    });
    //文件上传结果，返回false时调用uploadError事件
    up_visa_file.on('uploadAccept', function(t, data) {
        $('.qie_tishi.visa_file').html('');
        var data = data.data;
        var $li = $('#' + t.file.id);
        if (data.success) {
            $li.data('file_url', data.data.full_path);
            return true;
        } else {
            $li.remove();
            $('.qie_tishi.visa_file').html(data.msg);
        }
        return false;
    });
});