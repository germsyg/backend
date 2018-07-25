<?php
namespace app\backend\controller;
use think\Config;
use think\Db;
use think\Session;
use think\Request;

class Admin extends Backend
{
	public $table = 'admin';

    public function index2()
    {
        // view('index2',['a'=>1]);die;
        // var_dump($this->fetch());die;
        model($this->table)->index();
    }

    public function index()
    {                	
    	$info = $this->lists($this->table);
        $role = model('Role')->getRole();        
        foreach($info as $k=>$v){
            $info[$k]['role'] = '';
            if($v['role_ids']){
                $user_role = explode(',', $v['role_ids']);
                foreach($user_role as $kr=>$vr){
                    $info[$k]['role'] .= $role[$vr]['name'].', ';
                }
            }
        }
        // var_dump($info);die;
    	$this->assign('info', $info);
        return $this->fetch();
    }

    public function add()
    {
    	$info['role'] = model('Role')->getRole();
		$this->assign('info', $info);    		
    	
    	return $this->fetch();	
    }

    public function edit()
    {
        $id = input('param.id');

        $info['user'] = model('Admin')->getAdmin($id);        
        $role = model('Role')->getRole();
        $user_role = explode(',', $info['user']['role_ids']);
        if(!empty($user_role)){
            foreach($role as $k=>$v){
                $role[$k]['checked'] = 0;
                if(in_array($v['id'], $user_role)){
                    $role[$k]['checked'] = 1;
                }
            }
        }
        $info['role'] = $role;
        $this->assign('info', $info);                   
        return $this->fetch('add');  
    }

    public function save()
    {
    	$input = input('post.');            		      
    	$where = [];
        foreach($input as $k=>$v){
            if($k == 'id'){continue;}
            if($k == 'pwd'){
                $data['salt'] = $salt = randomString(6);        
                $data['pwd'] = action('Common/generalPwd',[$v, $salt]);        
            }else if($k == 'role'){
                $data['role_ids'] = implode(',', array_keys($input['role']));
            }else{
                $data[$k] = $v;            
            }
        }
        // var_dump($input['role']);
    	if($input['id']){    		
    		$where = array('id'=>$input['id']);                                
    	}else{
    		$data['reg_time'] = time();
    		$data['reg_ip'] = $_SERVER['REMOTE_ADDR'];
    	}

    	$res = $this->saveBE($this->table, $data, $where);        
    	if($res){
            return $this->suc;
        }else{
            return $this->fai;
        }
    }    
}
