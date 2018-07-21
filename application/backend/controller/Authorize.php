<?php
namespace app\backend\controller;
use think\Controller;
use think\Config;
use think\Session;
use think\Request;

class Authorize extends Controller
{
	public function _initialize()
    {                
        $this->verifyAuth();
        if(!session::get('user') && request()->controller() != 'Login'){
            $this->redirect('Login/index');
        }
    }

    private function verifyAuth()
    {
        // var_dump(get_class_methods(request()));die;
        $con = request()->controller();
        $act = request()->action();        
    }

}
