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
        // 'alias' => 'a',        
    ),
    array(
        'title' => '用户名',
        'field' => 'name',        
    ),
    array(
        'title' => '角色',
        'field' => 'role_ids',        
    ),
    array(
        'title' => '邮箱',
        'field' => 'email',        
    ),
    array(
        'title' => '加入时间',
        'field' => 'reg_time',        
    ),
    array(
        'title' => '状态',
        'field' => 'status',        
    ),
    array(
        'title' => '操作',
        'field' => 'operate',        
        'is_sql' => false,
    ),

];
