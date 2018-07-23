<?php
namespace app\backend\controller;
use think\Config;
use think\Db;

class Index extends Backend
{
	/**
	 * 后台首页
	 * @author XZJ @date 2018-07-17T19:55:06+0800
	 * @return [type] [description]
	 */
    public function index()
    {                    
    	$menu = $this->selectBE('menu', ['status'=> 1], '*', ['page'=>0]);
    	$menu = tree($menu);        
        $this->assign('menu', $menu);
        return $this->fetch();
    }

    
}
