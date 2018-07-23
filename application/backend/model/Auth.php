<?php
namespace app\backend\model;
use think\Config;
use think\Db;
use think\Session;
use think\Request;

class Auth extends Backend
{
	public function getAuth()
	{
		// 父类方法
		$parent_class = 'Backend';
		// 排除类
		$remove_class = array('Login','Common', 'Authorize');
		$dir = dirname(__DIR__).DS.'controller';
		$files = scandir($dir); 
		foreach ($files as $file) {					
            if ('.' . pathinfo($file, PATHINFO_EXTENSION) === CONF_EXT) {            	
            	$filename = $dir.DS.$file;             	
				$class = str_replace(CONF_EXT, '', $file);				
				if($class == $parent_class){
					require_once($filename);				
					$parent_auth = get_class_methods('\\app\\backend\\controller\\'.$class);				
				}else if (in_array($class, $remove_class)){
					continue;
				}else{
					require_once($filename);				
					$auth[$class] = get_class_methods('\\app\\backend\\controller\\'.$class);	
				}            	
            }
        }         
        // 对权限进行格式化
        foreach($auth as $ka=>$va){
        	$func = array_diff($va, $parent_auth);
        	$d['class'] = $ka;        	
        	$d['func'] = array();
        	foreach($func as $k=>$v){
        		$d['func'][$v] = 0;
        	}
        	$res[] = $d;
        }
        // return $auth;
        return $res;
	}

	public function getDbAuth()
	{
		$res = Auth::all();
		if($res){
			$res = collection($res)->toArray();
			foreach($res as $k=>$v){
				$r[$v['class']][$v['func']]['id'] = $v['id'];
				$r[$v['class']][$v['func']]['name'] = $v['name'];
			}
			return $r;
		}else{
			return [];		
		}
	}

}
