//产品图片设置
$(function(){
    var $imgList = $('#imgList'),
    // 优化retina, 在retina下这个值是2
    ratio = window.devicePixelRatio || 1,
    // 缩略图大小
    thumbnailWidth = 160 * ratio,
    thumbnailHeight = 100 * ratio;
    var up_product_images = WebUploader.create({
        // 选完文件后，是否自动上传。
        auto: true,
        // swf文件路径
        swf: '/static/webuploader/Uploader.swf',
        // 文件接收服务端。
        server: '/product/fileUpload',
        // 选择文件的按钮。可选。
        // 内部根据当前运行是创建，可能是input元素，也可能是flash.
        pick: '#img_select',
        // 不压缩image, 默认如果是jpeg，文件上传前会压缩一把再上传！
        compress: false,
        accept: {
            title: 'Images',
            extensions: 'gif,jpg,jpeg,bmp,png',
            mimeTypes: 'image/*'
        },
        fileVal: 'product_images',
        formData: {'input_name': 'product_images'}
    });
    // 当有文件添加进来的时候
    up_product_images.on( 'fileQueued', function( file ) {
        var $li = $(
            '<p id="' + file.id + '" class="img_p file-item thumbnail">' +
                '<img>' +
                '<span class="img_span info">' + file.name + '</span>' +
                '<span class="shachu_cs remove-this"><img src="/static/images/step1_47.jpg" /></span>' +
            '</p>'
        ),
        $img = $li.find('img:first');
    
        // $list为容器jQuery实例
        $imgList.append( $li );
    
        // 创建缩略图
        // 如果为非图片文件，可以不用调用此方法。
        // thumbnailWidth x thumbnailHeight 为 100 x 100
        up_product_images.makeThumb( file, function( error, src ) {
            if ( error ) {
                $img.replaceWith('<span>不能预览</span>');
                return;
            }
    
            $img.attr( 'src', src );
        }, thumbnailWidth, thumbnailHeight );
        
    });
    //文件上传结果，返回false时调用uploadError事件
    up_product_images.on('uploadAccept', function(t, data) {
        $('.qie_tishi.product_images').html('');
        var data = data.data;
        var $li = $('#' + t.file.id);
        if (data.success) {
            $li.data('file_url', data.data.full_path);
            return true;
        } else {
            $li.remove();
            $('.qie_tishi.product_images').html(data.msg);
        }
        return false;
    });
    //删除事件
    $(document).on('click', '.remove-this', function() {
        var $li = $(this).closest('p');
        $.ajax({
            type: "post",
            url: "/product/fileRemove",
            async: true,
            data: {'file_url': $li.data('file_url')},
            success: function(data){
                if (data.data.success) {
                    $li.remove();
                } else {
                    showMsg(data.data.msg);
                }
            }
        });
    });
});