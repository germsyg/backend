<?php
namespace app\backend\controller;
use think\Config;
use think\Db;

class Common extends Backend
{
    public function index()
    {
        // $r = Db::query('select * from admin');
        // var_dump($r);
    	$this->assign('name','ThinkPHP');        
        return $this->fetch();
    }


    public function icon()
    {
    	return $this->fetch();	
    }

    public function generalPwd($pwd, $salt)
    {
        $code = 'mvy#@$DFG^sdf0';
        return md5($pwd.$code.$salt);
    }

    public function vertifyPwd($pwd, $data_pwd, $salt)
    {

    }
}
