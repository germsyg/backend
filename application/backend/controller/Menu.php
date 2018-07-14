<?php
namespace app\backend\controller;
use think\Config;
use think\Db;
use think\Session;

class Menu extends Backend
{
	public $table = 'menu';

    public function index()
    {            
        return $this->fetch();
    }    

    public function add()
    {    	
    	$menu = $this->select($this->table, ['parent_id'=>0], '*', 0);
    	
    	$this->assign('menu', $menu);
    	return $this->fetch();
    }

    public function handle()
    {
    	$id = input('post.id');
    	$data['name'] = input('post.name');
    	$data['url'] = input('post.url');
    	$parent_id = input('post.parent_id');
    	$where = [];
    	if($id){
    		$data['modify_time'] = time();
    		$where = array('id'=>$id);
    	}else{
    		$data['add_time'] = $data['modify_time'] = time();
    		$data['add_admin'] = session::get('user.name');
    	}
    	
    	// $this->fetchSql = true;
    	$res = $this->edit($this->table, $data, $where);
    	var_dump($res);
    }
}
