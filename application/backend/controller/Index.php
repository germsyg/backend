<?php
namespace app\backend\controller;
use think\Config;
use think\Db;

class Index extends Backend
{
    public function index()
    {            
        return $this->fetch();
    }

    
}
