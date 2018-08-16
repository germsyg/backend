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
        model($this->table)->index();
    }

    public function add()
    {
        model($this->table)->add();
    }

    public function edit()
    {
        $id = input('param.id', 0);
        model($this->table)->add($id);
    }

    /**
     * 保存信息
     * @author XZJ 2018-08-14T19:26:41+0800
     * @return [type] [description]
     */
    public function save()
    {
    	$input = input('post.');            		      
    	$where = [];
        // var_dump($input);die;
        foreach($input as $k=>$v){
            if($k == 'id'){continue;}
            if($k == 'pwd' && !empty($v)){
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
