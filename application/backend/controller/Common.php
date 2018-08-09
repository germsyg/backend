<?php
namespace app\backend\controller;
use think\Config;
use think\Db;

class Common extends Backend
{
    private $code = 'mvy#@$DFG^sdf0';
    public function index()
    {
    	$this->assign('name','ThinkPHP');        
        return $this->fetch();
    }


    public function icon()
    {
    	return $this->fetch();	
    }

    public function generalPwd($pwd, $salt)
    {        
        return md5($pwd.$this->code.$salt);
    }

    public function vertifyPwd($input_pwd, $user_pwd, $salt)
    {
        return md5($input_pwd.$this->code.$salt) === $user_pwd;
    }

    public function uploadImg()
    {   
        $event = controller('common/Upload');
        return $event->uploadImg();        
    }

    public function kindUpload()
    {
        header("Content-Type: application/json; charset=utf-8");                
        $event = controller('common/Upload');
        $res = $event->kindUpload();           
        echo json_encode($res);die;
    }
}
