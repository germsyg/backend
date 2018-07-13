<?php
namespace app\backend\controller;
use think\Controller;
use think\Db;

class Login extends Controller
{
    public function index()
    {    
        return $this->fetch();
    }    

    public function check()
    {
    	$res['status'] = 1;
    	$res['msg'] = 'success';
    	$res['data'] = input('post.');
    	return $res;
    }
}
