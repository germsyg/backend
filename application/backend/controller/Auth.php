<?php
namespace app\backend\controller;
use think\Config;
use think\Db;
use think\Session;
use think\Request;

class Auth extends Backend
{
	public $table = 'auth';


    public function index()
    {                    
        
        return $this->fetch();
    }    
    
    public function roleAuth()
    {
        $id = input('param.id');
        $auth = model('Auth')->getAuth();
        $role_auth = model('Role')->getRoleAuth($id);
        // var_dump($role_auth);die;
        foreach($auth as $ka=>&$va){
            foreach($va['func'] as $k=>$v){
                if(isset($role_auth[$va['class']]) && in_array($k, $role_auth[$va['class']])){
                    $va['func'][$k] = 1;
                }
            }
        }unset($va);
        $info['auth'] = $auth;
        $info['id'] = $id;
// var_dump($auth);die;
        $this->assign('info', $info);
        return $this->fetch('add');
    }

    public function add()
    {
    	return $this->fetch();
    }

    public function edit()
    {
        $id = input('param.id');            
        $info = $this->findBE($this->table, ['id'=>$id]);          
        $this->assign('info', $info);
        return $this->fetch('add');   
    }

    public function getMenu()
    {
        $id = input('param.id');
        $menu = $this->selectBE($this->table, ['parent_id'=>$id], 'id, name');        
        return $menu;
    }

    public function save()
    {
    	// $id = input('post.id');
    	// $data['name'] = input('post.name');
    	$where = [];
        $data = input('post.');

    	if($data['id']){
    		$data['modify_time'] = time();
    		$where = array('id'=>$id);
    	}else{
    		$data['add_time'] = $data['modify_time'] = time();
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
        $data = Request::instance()->only(['status', 'sort']);

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
