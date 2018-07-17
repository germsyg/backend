<?php
namespace app\backend\controller;
use think\Config;
use think\Db;
use think\Session;
use think\Request;

class Admin extends Backend
{
	public $table = 'admin';

    public function index()
    {                	
    	$info = $this->lists($this->table);    	
    	$this->assign('info', $info);
        return $this->fetch();
    }

    public function add()
    {
    	$id = input('param.id');
    	if($id){
    		$info = $this->fetchBE($this->table, ['id'=>$id]);
    		$this->assign('info', $info);    		
    	}
    	return $this->fetch();	
    }

    public function handle()
    {
    	$id = input('post.id');
    	$data['name'] = input('post.name');
        $data['email'] = input('post.email');

    	$pwd = input('post.password');
    	$salt = randomString(6);
    	$where = [];
        $pwd = action('Common/generalPwd',[$pwd, $salt]);
    	
    	if($id){    		
    		$where = array('id'=>$id);
    	}else{
    		$data['pwd'] = $pwd;
    		$data['salt'] = $salt;
    		$data['reg_time'] = time();
    		$data['reg_ip'] = $_SERVER['REMOTE_ADDR'];
    	}
    	
    	// $this->fetchSql = true;
    	$res = $this->editBE($this->table, $data, $where);
    	if($res){
            return $this->suc;
        }else{
            return $this->fai;
        }
    }


    public function modify()
    {        
        $id = input('param.id');
        $data = Request::instance()->only(['status']);

        $where['id'] = $id;        
        $res = $this->editBE($this->table, $data, $where);
        
        if($res){
            return $this->suc;
        }else{
            $this->fai['msg'] = '更新失败，稍后再试';
            return $this->fai;
        }
    }

    
}
