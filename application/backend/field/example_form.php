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

return [
    array(
        'title' => '序号',
        'field' => 'id',
        'type' => 'text',            
        'is_key' => true,
    ),    
    array(
        'title' => '名称',
        'field' => 'name',
        'type' => 'text',
        'validate' =>  array(
            'require' => true,  
            'reg' => '!/\S+/',
            'err' => '配置名不能空',
            ),
        'tip' => '配置',
    ),
    array(
        'title' => '密码',
        'field' => 'pwd',
        'type' => 'password',                
    ),
    array(
        'title' => '内容',
        'field' => 'type',
        'type' => 'textarea',        
    ),
    array(
        'title' => '长内容',
        'field' => 'longcontent',
        'type' => 'editor',        
    ),
    array(
        'title' => '地区',
        'field' => 'area',
        'type' => 'select',
        'option' => array(
            '广州' => array('value'=> 1),
            '上海' => array('value'=> 2),
            '北京' => array('value'=> 3, 'checked'=>true),
            '深圳' => array('value'=> 4),
            ),
    ),
    array(
        'title' => '长内容2',
        'field' => 'longcontent2',
        'type' => 'editor',        
    ),
    array(
        'title' => '图片',
        'field' => 'img',
        'type' => 'upload',        
    ),
    array(
        'title' => '图片2',
        'field' => 'img2',
        'type' => 'upload',        
    ),
    array(
        'title' => '类型',
        'field' => 'type',
        'type' => 'checkbox',   
        'option' => array(
            '开发' => array('value'=> 1),
            '测试' => array('value'=> 2, 'checked'=>true),
            '用户' => array('value'=> 3),
            '客服' => array('value'=> 4),
            ),     
    ),
    array(
        'title' => '状态',
        'field' => 'status',
        'type' => 'radio', 
        'option' => array(
            '开启' => array('value'=> 1),
            '关闭' => array('value'=> 2, 'checked'=>true),
            ),        
    ),


];
