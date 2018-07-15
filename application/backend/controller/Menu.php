<?php
namespace app\backend\controller;
use think\Config;
use think\Db;
use think\Session;
use think\Request;

class Menu extends Backend
{
	public $table = 'menu';

    public function index()
    {            
        $menu = $this->selectBE($this->table, 'all');
        $menu = tree($menu);
        // var_dump($menu);
        $menu = sortTree($menu);
        // var_dump($menu);die;
        $this->assign('menu', $menu);
        return $this->fetch();
    }    

    public function add()
    {
        $id = input('param.id');    	
    	$menu = $this->selectBE($this->table, 'all');
    	$menu = tree($menu);        
        $menu = sortTree($menu);
        $this->assign('menu', $menu);
    	$this->assign('pid_selected', $id);
    	return $this->fetch();
    }

    public function edit()
    {
        $id = input('param.id');
        $menu = $this->selectBE($this->table, 'all');        
        $menu = tree($menu);        
        $menu = sortTree($menu);
        $this->assign('menu', $menu);

        // $this->fetchSql = true;
        
        $info = $this->findBE($this->table, ['id'=>$id]);  
        // var_dump($info);      
        $this->assign('info', $info);
        return $this->fetch('add');   
    }

    public function getMenu()
    {
        $id = input('param.id');
        $menu = $this->selectBE($this->table, ['parent_id'=>$id], 'id, name');        
        return $menu;
    }

    public function handle()
    {
    	$id = input('post.id');
    	$data['name'] = input('post.name');
    	$data['url'] = input('post.url');
        $data['parent_id'] = input('post.parent_id');
    	$data['icon'] = input('post.icon');
    	$where = [];
        // var_dump($data);die;
    	if($id){
    		$data['modify_time'] = time();
    		$where = array('id'=>$id);
    	}else{
    		$data['add_time'] = $data['modify_time'] = time();
    		$data['add_admin'] = session::get('user.name');
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
        sleep(2);
        $id = input('param.id');
        $data = Request::instance()->only(['status', 'sort']);
        // var_dump($data);
        // var_dump($id);
        $where['id'] = $id;
        // $res = $this->editBE($this->table, $data, $where);
        // if($res){
        //     return $this->suc;
        // }else{
            return $this->fai;
        // }
    }
}
