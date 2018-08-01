<?php
namespace app\backend\controller;
use think\Config;
use think\Db;
use think\Session;
use think\Request;

class Example extends Backend
{
	public $table = 'config';


    public function index()
    {                    
        model('example')->index();
    }    

    public function add()
    {
        model('example')->add();
    }

    public function save()
    {
        $input = input('post.');
    }

    public function uploadImg()
    {
        $event = controller('common/Upload');
        $res = $event->uploadImg();
        return $res;
    }

}
