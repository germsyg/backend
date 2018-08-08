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

    	$path = input('param.path', '');    	
    	$filename = input('param.filename', 'file');    	    	
    	// 回调自定义文件保存路径
    	$rule = function($objFile) use($path){    		
    		return $path . DS . md5(microtime(true));    		
    	};

		$file = request()->file($filename);		
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

    /**
     * kindeditor 图片上传方法
     * @author XZJ 2018-08-04T13:47:15+0800
     * @return [type] [description]
     */
    public function kindUpload()
    {

    	$path = input('param.path', '');    	
    	$filename = input('param.filename', 'imgFile');    	    	
    	// 回调自定义文件保存路径
    	$rule = function($objFile) use($path){    		
    		return 'kind'. DS . 'image' . DS . $path . DS . md5(microtime(true));    		
    	};

		$file = request()->file($filename);
		// 自动生成文件名
		$info = $file->rule($rule)->move(ROOT_PATH . DS . 'public' .  DS . 'upload', true, false);
		if($file->getError()){
			$res['error'] = 1;
			$res['message'] = $file->getError();
		}else{
			$res['error'] = 0;
			$res['url'] = '/upload/'.$info->getSaveName();			
		}		
		return $res;
    }
}

