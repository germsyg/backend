<?php
namespace app\backend\model;
use think\Config;
use think\Db;
use think\Session;
use think\Request;

class Menu extends Backend
{
	public $table = 'menu';

    public function ttt()
    {
        $u = Menu::get(1);
        return $u;
    }

}
