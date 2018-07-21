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
        $auth = model('Auth')->getAuth();
        $db_auth = model('Auth')->getDbAuth();
        // var_dump($db_auth);
        // var_dump($auth);die;
        foreach($auth as $ka=>$va){

            $d['class'] = $va['class'];
            $d['name'] = isset($db_auth[$va['class']]['-']['name']) ? $db_auth[$va['class']]['-']['name'] : '';                
            foreach($va['func'] as $k=>$v){
                $d['func'][$k] = isset($db_auth[$va['class']][$k]['name']) ? $db_auth[$va['class']][$k]['name'] : '';
            }
            $info[] = $d;
        }
        // var_dump($info);die;
        $this->assign('info', $info);
        return $this->fetch();
    }    
    
    public function roleAuth()
    {
        $id = input('param.id');
        $auth = model('Auth')->getAuth();
        $db_auth = model('Auth')->getDbAuth();
        $role_auth = model('Role')->getRoleAuth($id);
        // var_dump($db_auth);die;
        foreach($auth as $ka=>&$va){
            $d['class'] = $va['class'];
            $d['name'] = $va['class'];
            if(isset($db_auth[$va['class']]['-'])){
                $d['name'] = $db_auth[$va['class']]['-']['name'] ?: $va['class'];
            }
            foreach($va['func'] as $k=>$v){
                $d['func'][$k]['checked'] = 0;
                if(isset($role_auth[$va['class']]) && in_array($k, $role_auth[$va['class']])){
                    $d['func'][$k]['checked'] = 1;
                }
                $d['func'][$k]['name'] = $k;
                if(isset($db_auth[$va['class']][$k])){
                    $d['func'][$k]['name'] = $db_auth[$va['class']][$k]['name'] ?: $k;
                }
            }
            $res[] = $d;
        }unset($va);
        $info['auth'] = $res;
        $info['id'] = $id;
// var_dump($info);die;
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
    	$where = [];
        $data = input('post.');
        $modAuth = model('Auth');
        $db_auth = $modAuth->getDbAuth();
        
        foreach($data as $kd=>$vd){
            foreach($vd as $k=>$v){
                if(isset($db_auth[$kd][$k])){
                    if($db_auth[$kd][$k]['name'] != $v){
                        $modAuth->data(['id'=>$db_auth[$kd][$k]['id'], 'name'=>$v]);
                        $res = $modAuth->save();
                    }
                }else{
                    $d['class'] = $kd;
                    $d['func'] = $k;
                    $d['name'] = $v;
                    $insert[] = $d;
                }
            }            
        }
        if($insert){
            $res = $modAuth->saveAll($insert);
        }

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
