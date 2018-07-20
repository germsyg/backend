<?php
namespace app\backend\controller;
use think\Config;
use think\Db;
use think\Session;
use think\Request;

class Auth extends Backend
{
	public $table = 'auth';


    /**
     * 后台管理菜单页
     * @author XZJ @date 2018-07-17T19:52:53+0800
     * @return [type] [description]
     */
    public function index()
    {                    
        $info = $this->selectBE($this->table, 'all');

        $this->assign('total', count($info));
        $this->assign('info', $info);
        return $this->fetch();
    }    
    
    public function roleAuth()
    {
        $auth = model('Auth')->getAuth();
        foreach($auth as $k=>$v){
            var_dump($k);
        }
        var_dump($auth);die;
        $this->assign('info', $auth);
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

    public function handle()
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
