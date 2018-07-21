<?php
namespace app\backend\controller;
use think\Controller;
use think\Db;
use think\Session;

class Login extends Backend
{
    public function index()
    {                    
        if(session::get('user')){            
            $this->redirect('Index/index');
        }else{
        	return $this->fetch();
    	}    	
    }    


    /**
     * ajax 登陆
     * @author XZJ 2018-07-14T10:34:24+0800
     * @return [type] [description]
     */
    public function check()
    {    	
    	$res['status'] = 0;
    	$res['msg'] = '账号或密码错误';

    	$email = input('post.email');
    	$pwd = input('post.password');

    	$info = $this->getAdmin($email);
    	if(!$info){
    		return $res;
    	}else{
    		$match = action('Common/vertifyPwd', [$pwd, $info['pwd'], $info['salt']]);
    		if($match){
    			$this->login($info);
    			$res['status'] = 1;
    			$res['msg'] = 'success';
    		}
    	}    	    
    	return $res;
    }

    /**
     * 根据邮箱获取用户用户
     * @author XZJ 2018-07-14T10:34:01+0800
     * @param  string $email [description]
     * @return [type]        [description]
     */
    private function getAdmin($email = '')
    {
    	if(!$email){
    		return false;
    	}
    	$res = Db::table('admin')->where('email', $email)->find();
    	return $res;
    }

    /**
     * 对比密码
     * @author XZJ 2018-07-14T10:33:49+0800
     * @param  [type] $data  [description]
     * @param  [type] $input [description]
     * @return [type]        [description]
     */
    private function comparePwd($data, $input)
    {    	
    	$res = false;
    	if(md5($input) == $data){
    		$res = true;
    	}
    	return $res;
    }

    /**
     * 登陆后session等信息操作
     * @author XZJ 2018-07-14T10:33:26+0800
     * @param  [type] $info [description]
     * @return [type]       [description]
     */
    private function login($info)
    {
    	// session 录入
        Session::set('user.id', $info['id']);
		Session::set('user.email', $info['email']);
		Session::set('user.name', $info['name']);
		Session::set('user.last_login_ip', $info['last_login_ip']);
		Session::set('user.last_login_time', $info['last_login_time']);

		// 更新登陆信息
		$update['last_login_ip'] = $_SERVER["REMOTE_ADDR"];;
		$update['last_login_time'] = time();
		Db::table('admin')->where('id', $info['id'])->update($update);
    }

    /**
     * 退出登陆
     * @author XZJ 2018-07-14T10:38:41+0800
     * @return [type] [description]
     */
    public function logout()
    {
    	Session::delete('user');
    	$this->redirect('Login/index');
    }


}
