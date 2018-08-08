<?php
namespace app\backend\controller;
use think\Config;
use think\Db;
use think\Session;
use think\Request;

class Xconfig extends Backend
{
	public $table = 'config';


    public function index()
    {                    
        model('xconfig')->index();
    }    

    public function add()
    {
        model('xconfig')->add();
    }

    public function edit()
    {
        $id = input('post.id', 0);
        model('xconfig')->add($id);
    }

    public function save()
    {
        $input = input('post.'); 
        
        $where = [];
        foreach($input as $k=>$v){
            if($k == 'id'){continue;}
            $data[$k] = $v;
        }        
        if($input['id']){           
            $where = array('id'=>$input['id']);                                
        }

        $res = $this->saveBE($this->table, $data, $where);        
        if($res){
            return $this->suc;
        }else{
            return $this->fai;
        }
    }

}
