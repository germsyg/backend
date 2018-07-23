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
    	$where = [];
        $data = input('post.');
        foreach($data['auth'] as $k=>$v){
            $res[$k] = array_keys($v);
        }
        
        $data['auth'] = json_encode($res);
        
    	if($data['id']){
    		$data['modify_time'] = time();
    		$where = array('id' => $data['id']);
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

    public function modify()
    {        
        $id = input('param.id');
        $data = Request::instance()->only(['status', 'sort']);

        $where['id'] = $id;        
        $res = $this->saveBE($this->table, $data, $where);
        
        if($res){
            return $this->suc;
        }else{
            $this->fai['msg'] = '更新失败，稍后再试';
            return $this->fai;
        }
    }


}
