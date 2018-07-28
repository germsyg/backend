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
        'title' => '配置名',
        'field' => 'name',
        'is_search' => array(
            'type' => 'text',
            'sort' => 10,
            'field' => '',
            'expression' => array(
                'rule' => '%s LIKE "%s%%"',
                'args' => array('name', 'value'),
                ),
            ),
    ),
    array(
        'title' => '标识',
        'field' => 'tag',       
    ),
    array(
        'title' => '修改时间',
        'field' => 'modify_time',        
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
