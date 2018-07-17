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