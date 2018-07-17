<?php
namespace app\backend\controller;
use think\Config;
use think\Db;
use think\Session;
use think\Request;

class Menu extends Backend
{
	public $table = 'menu';

    /**
     * 后台管理菜单页
     * @author XZJ @date 2018-07-17T19:52:53+0800
     * @return [type] [description]
     */
    public function index()
    {                    
        $menu = $this->selectBE($this->table, 'all');
        $menu = tree($menu);        
        $menu = sortTree($menu);        
        $this->assign('total', count($menu));
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
