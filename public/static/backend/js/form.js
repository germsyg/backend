$(function () {

    $(document).on('click','.js-del-img',function(){
        if(confirm('确认删除？')){
            $(this).closest('li').remove();           
        }
    })

});

// 禁用上图按钮
function forbidBtn(id){
    $('#'+id).attr('disabled', true).addClass('layui-btn-disabled');
}
// 激活按钮
function activeBtn(id){
    $('#'+id).attr('disabled', false).removeClass('layui-btn-disabled');
}






