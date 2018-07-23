<?php
namespace app\backend\controller;
use think\Config;
use think\Db;
use think\Session;
use think\Request;

class Role extends Backend
{
	public $table = 'role';



    public function index()
    {                    
        $info = $this->selectBE($this->table, 'all');
        $this->assign('total', count($info));
        $this->assign('info', $info);
        return $this->fetch();
    }    
    

    public function add()
    {
        $info['auth'] = model('Role')->getFormatAuth();        
        $this->assign('info', $info);
    	return $this->fetch();
    }

    public function edit()
    {
        $id = input('param.id');          
        $info['auth'] = model('Role')->getFormatAuth($id);  
        $info['role'] = $this->findBE($this->table, ['id'=>$id]);          
        $this->assign('info', $info);
        return $this->fetch('add');   
    }


    public function save()
    {
    	$where = [];
        $input = input('post.');

        foreach($input as $k=>$v){
            if($k == 'id'){continue;}
            if($k == 'auth'){
                foreach($input['auth'] as $k=>$v){
                    $res[$k] = array_keys($v);
                }            
                $data['auth'] = json_encode($res); 
            }else{
                $data[$k] = $v;
            }
        }
        
    	if($input['id']){            
    		$data['modify_time'] = time();
    		$where = array('id' => $input['id']);
    	}else{
    		$data['add_time'] = $data['modify_time'] = time();
    	}
    	// $this->fetchSql = true;
    	$res = $this->saveBE($this->table, $data, $where);
    	if($res){
            return $this->suc;
        }else{
            return $this->fai;
        }
    }

}
