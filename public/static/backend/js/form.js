$(function () {

    $(document).on('click','.js-del-img',function(){
        if(confirm('确认删除？')){
            var id = $(this).closest('.layui-form-item').find('.js-upload-btn').attr('id');
            $(this).closest('li').remove();           
            checkBtn(id);
        }
    })

});

// 检测上传按钮可用性
function checkBtn(id){
    var limit_num = $('#'+id).attr('num');
    var num = $('#'+id).closest('.layui-form-item').find('.upload_box > ul').find('li').length;
    if(num >= limit_num){
        forbidBtn(id);
    }else{
        activeBtn(id);
    }
}

// 禁用上图按钮
function forbidBtn(id){
    $('#'+id).attr('disabled', true).addClass('layui-btn-disabled');
}
// 激活按钮
function activeBtn(id){
    $('#'+id).attr('disabled', false).removeClass('layui-btn-disabled');
}






