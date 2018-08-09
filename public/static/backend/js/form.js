$(function () {

    $(document).on('click','.js-del-img',function(){
        if(confirm('确认删除？')){
            var id = $(this).closest('.layui-form-item').find('.js-upload-btn').attr('id');
            $(this).closest('li').remove();           
            checkBtn(id);
        }
    })

});

// 验证表单
function validateForm(data){          
    var res = true;

    $('.js-reg').each(function(i, e){
        var type = $(this).attr('type');
        var reg = $(this).attr('reg');
        var err = $(this).attr('err');
        var regObj = new RegExp(reg);
        var field = $(this).attr('field');     

        if(type == 'upload'){     
            // 图片上传，field[0] field[1] field[2]
            var key = field+'[0]';       
            if(data[key] == undefined){
                res = false;
                layer.msg(err);return false;
            }
        }else if(type == 'checkbox'){
            // field[value1] field[value5] field[value10]，value为实际对应值，
            var r = new RegExp(field + '[\\S+]');
            var check = false;
            $.each(data, function(k, v){
                if(r.test(k)){
                    check = true;                    
                    return false;
                }
            });
            if(!check){
                res = false;
                layer.msg(err);
                return false;
            }
        }else{
            if(data[field] == undefined || !regObj.test(data[field])){
                res = false;
                layer.msg(err);return false;
            }
        }
    })

    return res;
}

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






