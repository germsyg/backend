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
 * 后台列表展示器
 * title，显示的th名
 * field，查询数据库字段
 * is_key，标记为主键，用于隐藏作用域
 * is_search，搜索， type 类型有 text|
 */
return [
    array(
        'title' => '序号',
        'field' => 'id',
        'is_key' => true,
    ),
    array(
        'title' => '名称',
        'field' => 'name',
        'is_search' => array(
            'type' => 'text',   //搜索类型
            'sort' => 10,   // 搜索的字段显示排序，小到大排，没有的最后
            'field' => '',
            'expression' => array(
                'rule' => '%s LIKE "%%%s%%"',     // 规则，使用sprintf 替换
                'args' => array('name', 'value'),   // 替换的参数
                ),
            ),
    ),
    array(
        'title' => '密码',
        'field' => 'pwd',                      
    ),
    array(
        'title' => '内容',
        'field' => 'content',              
    ),    
    array(
        'title' =>'时间',
        'field' => 'add_time',
        'is_search' => array(
            'type' => 'date',   //搜索类型                                
            'is_unix_time' => false, // 将时间转为时间戳
        ),
    ),
    array(
        'title' => '地区',
        'field' => 'area',

    ),

    array(
        'title' => '类型',
        'field' => 'type',
        'is_search' => array(            
            'type' => 'checkbox',
            'option' => array(
                '开发' => array('value'=> 1), // 显示名=》value值，
                '测试' => array('value'=> 2),    //checked为选中
                '用户' => array('value'=> 3),
                '客服' => array('value'=> 4),
                ),
            ), 
    ),

    array(
        'title' => '状态',
        'field' => 'status',
        'is_search' => array(            
            'type' => 'select',
            'option' => array(
                '正常' => 1,
                '禁用' => 2,
                ),
            ),   
    ),

    array(
        'title' => '操作',
        'field' => 'operate', 
        'is_sql' => false,  // 是否sql中的字段        
    ),


];
