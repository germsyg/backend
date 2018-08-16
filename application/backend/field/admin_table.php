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
        'is_key' => true,                    
    ),
    array(
        'title' => '用户名',
        'field' => 'name',
        'is_search' => array(
            'type' => 'text',
            'sort' => 10,
            'expression' => array(
                'rule' => '%s LIKE "%s%%"',
                'args' => array('name', 'value'),
                ),
            ),
    ),
    array(
        'title' => '角色',
        'field' => 'role_ids',       
    ),
    array(
        'title' => '邮箱',
        'field' => 'email',
        'is_search' => array(
            'type' => 'text',
            'sort' => 1,
            'expression' => array(
                'rule' => '%s = "%s"',
                'args' => array('name', 'value'),
                ),
            ),        
    ),
    array(
        'title' => '加入时间',
        'field' => 'reg_time', 
        'is_search' => array(
            'type' => 'date',
            'is_unix_time' => true,                                
            ),       
    ),
    array(
        'title' => '状态',
        'field' => 'status',
        'is_search' => array(            
            'type' => 'select',
            'option' => array(
                '正常' => 1,
                '禁用' => 0,
                ),
            ),             
    ),
    array(
        'title' => '操作',
        'field' => 'operate',        
        'is_sql' => false,
    ),

];
