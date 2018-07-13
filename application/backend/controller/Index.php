<?php
namespace app\backend\controller;
use think\Config;
use think\Db;

class Index extends Backend
{
    public function index()
    {
        // $r = Db::query('select * from admin');
        // var_dump($r);
    	$this->assign('name','ThinkPHP');        
        return $this->fetch();
    }

    
}
