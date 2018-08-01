<?php
namespace app\common\controller;
use think\Config;
use think\Db;

class Upload extends Common
{
	/**
	 * 上传图片
	 * @author XZJ 2018-08-01T18:18:53+0800
	 * @return [type] [description]
	 */
    public function uploadImg()
    {

    	$path = input('post.path', '');    	
    	// var_dump($path);die;
    	// 回调自定义文件保存路径
    	$rule = function($objFile) use($path){    		
    		return $path . DS . md5(microtime(true));    		
    	};
		$file = request()->file('file');

		// 同名
		// $info = $file->move(ROOT_PATH . DS . 'public' .  DS . 'upload', '', false);
		// 自动生成文件名
		$info = $file->rule($rule)->move(ROOT_PATH . DS . 'public' .  DS . 'upload', true, false);
		if($file->getError()){
			$res['status'] = 0;
			$res['msg'] = $file->getError();
		}else{
			$res['status'] = 1;
			$res['data']['saveName'] = $info->getSaveName();
			$res['msg'] = 'success';
		}
		return $res;
    }
}

