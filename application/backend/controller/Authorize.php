<?php
namespace app\backend\controller;
use think\Controller;
use think\Config;
use think\Session;
use think\Request;

class Authorize extends Controller
{
    // 免验证控制器
    private $exempt_controller = array('Login', 'Index');


	public function _initialize()
    {                
        
        $res = $this->verifyAuth();
        if(!$res){
            if(request()->isAjax()){
                $fail = array('status'=>0, 'msg'=>'no permission');
                // header("Content-Type: application/json; charset=utf-8");
                // return $fail;die;
                // echo json_encode($fail);die;
            }else{
                echo 'no permission';die;
            }
        }

    }

    private function verifyAuth()
    {        
        $admin = session::get('admin');        
        
        $con = request()->controller();
        $act = request()->action();  
        // 未登陆跳转
        if(!$admin && $con != 'Login'){
            $this->redirect('Login/index');die;
        }      
        // 超管权限
        if($admin['id'] == 1){
            return true;
        }
        // var_dump($con);
        // 免验证控制器
        if(in_array($con, $this->exempt_controller)){
            return true;
        }        
        // 验证具体权限        
        // $admin_auth = $admin['auth'];        
        $admin_auth = model('Admin')->getAdminAuth();
        if(isset($admin_auth[$con])){
            if(!in_array($act, $admin_auth[$con])){
                return false;
            }
        }else{
            return false;
        }

        return true;
    }

}
