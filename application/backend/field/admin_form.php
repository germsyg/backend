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
        'title' => '邮箱',
        'field' => 'email',
        'type' => 'text',
        'validate' =>  array(
            'require' => true,                        
            ),        
    ),
    array(
        'title' => '名字',
        'field' => 'name',
        'type' => 'text',
        'validate' =>  array(
            'require' => true,                        
            ),
        'tip' => '站内显示的名字',
    ),
    array(
        'title' => '密码',
        'field' => 'pwd',
        'type' => 'password',        
    ),
    array(
        'title' => '用户组',
        'field' => 'role_ids',
        'type' => 'checkbox',
        'validate' =>  array(
            'require' => true,                        
            ),
        'option' => array(
            // '数字' => array('value' => 1, 'checked' => true),
            // '字符' => array('value' => 2, ),
            // '数组' => array('value' => 3, ),
            // '布尔' => array('value' => 4, ),
            ),
    ),

    array(
        'title' => '状态',
        'field' => 'status',
        'type' => 'radio',
        'validate' =>  array(
            'require' => true,
            'err' => '请添加配置值',
            ),
        'option' => array(
            '启用' => array('value' => 1, 'checked' => true),
            '关闭' => array('value' => 0, ),
            ),
    ),

];
