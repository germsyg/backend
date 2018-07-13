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
}
