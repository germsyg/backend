<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006-2016 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: 流年 <liu21st@gmail.com>
// +----------------------------------------------------------------------

// 应用公共文件

/**
 * 树级分类
 * @author XZJ @date 2018-07-14T23:57:22+0800
 * @param  [type]  $data [description]
 * @param  integer $pid  [description]
 * @return [type]        [description]
 */
function tree($data, $pid=0, $level=1) {
    $tree = [];
    foreach($data as $k => $v) {
        if ($v['parent_id'] == $pid) {
        	$v['level'] = $level;
            $v['child'] = tree($data, $v['id'], $level+1);
            $tree[] = $v;
            //unset($data[$k]);
        }
    }
    return $tree;
}

/**
 * 格式化树，适合表格输出
 * @author XZJ @date 2018-07-17T20:36:26+0800
 * @param  [type] $data [description]
 * @return [type]       [description]
 */
function sortTree($data)
{
	$tmp = [];
	foreach($data as $k=>$v){
		$d = $v;		
		$d['hasChild'] = empty($d['child']) ? false : true;
		unset($d['child']);
		$tmp[] = $d;
		if(!empty($v['child'])){
			$tmp = array_merge($tmp, sortTree($v['child']));
		}
	}
	return $tmp;
}

/**
 * 随机字符串
 * @author XZJ @date 2018-07-17T20:39:12+0800
 * @param  integer $length [description]
 * @return [type]          [description]
 */
function randomString($length = 6) { 
	$characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ'; 
	$randomString = ''; 
	for ($i = 0; $i < $length; $i++) { 
		$randomString .= $characters[rand(0, strlen($characters) - 1)]; 
	} 
	return $randomString; 
}

/**
 * 二维数组按某字段排序， 无该字段的排到最后
 * @author XZJ 2018-07-27T14:45:21+0800
 * @param  [type] &$array [description]
 * @param  [type] $key    [description]
 * @param  string $sort   [description]
 * @return [type]         [description]
 */
function arraySort(&$array, $key, $sort='desc'){
	$a1 = $a2 = $s = array();
	foreach($array as $k=>$v){
		if(isset($v[$key])){
			$a1[] = $v;
			$s[] = $v[$key];
		}else{
			$a2[] = $v;
		}
	}
	if($sort == 'desc'){
		$sort = SORT_DESC;
	}else{
		$sort = SORT_ASC;
	}
	array_multisort($s, $sort, $a1);
	$array = array_merge($a1, $a2);			
}