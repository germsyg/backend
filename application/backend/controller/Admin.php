<?php
namespace app\backend\controller;
use think\Config;
use think\Db;

class Admin extends Backend
{
    public function index()
    {            
        return $this->fetch();
    }

    
}
