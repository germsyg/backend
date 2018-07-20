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
		// 排除公共类
		$remove_class = array('Login','Common');
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
        	$fun = array_diff($va, $parent_auth);
        	foreach($fun as $kf=>$vf){
        		$res[$ka][$vf] = 1;
        	}
        }
        return $res;
	}

}
