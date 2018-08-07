<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006~2018 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: liu21st <liu21st@gmail.com>
// +----------------------------------------------------------------------

/**
 * 表单格式器，适用于一般的表单填写，
 * title，显示的标题，用于提示输入内容， 必须有
 * field，保存数量时传到后台的字段名， 必须有
 * is_key，表单中的标识，一般对应数据库的主键， 必须且只有一个
 * tip，输入框旁边的提示
 * type，字段类型，用于展示不同的内容，必须有，值为 text|password|textarea|editor|select|upload|checkbox|radio|date
 * validate，字段js验证
 *
 * 具体使用方法如下
 */

return [
    array(
        'title' => '序号', // 显示名称
        'field' => 'id',    //字段名
        'type' => 'text',   //字段类型 
        'is_key' => true, //唯一is_key，数据库字段标识
    ),    
    array(
        'title' => '名称',
        'field' => 'name',
        'type' => 'text',
        'validate' =>  array(   // js验证
            'require' => true,      //不能为空
            'reg' => '/\S+/',  //按需自定义验证正则，默认 '/\S+/'
            'err' => '配置名不能空',  //验证不通过的提示， 默认 'title值+不能为空'
            ),
        'tip' => '配置',  //输入旁边的提示
    ),
    array(
        'title' => '密码',
        'field' => 'pwd',
        'type' => 'password',                
    ),
    array(
        'title' => '内容',
        'field' => 'content',
        'type' => 'textarea',        
    ),
    array(
        'title' => '长内容',
        'field' => 'longcontent',
        'type' => 'editor',        // js在线编辑器
    ),
    array(
        'title' => '时间',
        'field' => 'add_time',
        'type' => 'date',        // 日期拾取器, 具体设置 http://www.layui.com/doc/modules/laydate.html
        'option' => array(
            'type' => 'date',    // 选择器类型，默认date，date|year|month|time|datetime 5种 
            'format' => 'yyyy-MM-dd',  // 格式，默认yyyy-MM-dd, 参考layui日期选择器，
            'value' => '',  //初始值，默认空
            'min' => '',    // 日期范围，默认空， 最小1900-01-01
            'max' => '',  // 日期范围，默认空， 最大3000-01-01
            ),
    ),
    array(
        'title' => '地区',
        'field' => 'area',
        'type' => 'select',
        'option' => array(  // 类型为select时的选项值
            '广州' => array('value'=> 1), // 显示名=》value值， 
            '上海' => array('value'=> 2),
            '北京' => array('value'=> 3, 'checked'=>true),    //checked为选中
            '深圳' => array('value'=> 4),
            ),
    ),
    array(
        'title' => '图片',
        'field' => 'img',
        'type' => 'upload',
        'option' => array(  // 类型为upload的配置值
            'ext' => array('jpg', 'jpeg'), //默认允许格式 'gif', 'jpg', 'jpeg', 'bmp', 'png', 'swf'
            'size' => 1024, //单位 k，默认3072
            'path' => 'example', // 根目录 public/upload/ + 'path'
            'num' => 2, // 数量限制，默认1
            ),
        // 'validate' =>  array(   // js验证
        //     'require' => true,      //不能为空
        //     'reg' => '/\S+/',  //按需自定义验证正则，默认 '!/\S+/'
        // ),  
    ),
    array(
        'title' => '类型',
        'field' => 'type',
        'type' => 'checkbox',   
        'option' => array(  // 类型为checkbox时的选项值
            '开发' => array('value'=> 1), // 显示名=》value值，
            '测试' => array('value'=> 2, 'checked'=>true),    //checked为选中
            '用户' => array('value'=> 3, 'checked'=>true),
            '客服' => array('value'=> 4),
            ),  
        'validate' =>  array(   // js验证
            'require' => true,      //不能为空
        ),      
    ),
 
    array(
        'title' => '状态',
        'field' => 'status',
        'type' => 'radio',  
        'option' => array(  // 类型为radio时的选项值
            '开启' => array('value'=> 1),
            '关闭' => array('value'=> 0, 'checked'=>true),    //checked为选中
            ),   
        'validate' =>  array(   // js验证
            'require' => true,      //不能为空
            'reg' => '/\d+/',  //按需自定义验证正则，默认 '!/\S+/'
            'err' => '配置名不能空',  //验证不通过的提示， 默认 'title值+不能为空'
        ),     
    ),


];
