<?php
namespace app\backend\controller;
use think\Config;
use think\Db;
use think\Session;
use think\Request;

class Example extends Backend
{
	public $table = 'example';


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
        model($this->table)->add((int)$id);
    }

    public function save()
    {        
        $input = input('post.'); 
        
        $where = [];
        foreach($input as $k=>$v){
            if($k == 'id'){continue;}
            if($k == 'img' || $k == 'type'){                       
                $data[$k] = implode(',', $v);
            }else if($k == 'add_time'){
                $data[$k] = strtotime($v);
            }else{
                $data[$k] = $v;            
            }
        }        
        if($input['id']){           
            $where = array('id'=>$input['id']);                                
        }
// var_dump($data);die;
        $res = $this->saveBE($this->table, $data, $where);        
        if($res){
            return $this->suc;
        }else{
            return $this->fai;
        }
    }

}
