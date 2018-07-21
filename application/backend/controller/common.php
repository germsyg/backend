<?php
namespace app\backend\controller;
use think\Config;
use think\Db;

class Common extends Backend
{
    public function index()
    {
        // $r = Db::query('select * from admin');
        // var_dump($r); kj 
    	$this->assign('name','ThinkPHP');        
        return $this->fetch();
    }


    public function icon()
    {
    	return $this->fetch();	
    }

    
}
