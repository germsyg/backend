<?php
namespace app\backend\controller;
use think\Config;
use think\Db;
use think\Session;
use think\Request;

class Xconfig extends Backend
{
	public $table = 'config';


    public function index()
    {                    
        model('xconfig')->index();
    }    

    public function add()
    {
        model('xconfig')->add();
    }

    public function save()
    {
        $input = input('post.');
    }

}
