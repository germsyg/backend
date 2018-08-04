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
        model('example')->index();
    }    

    public function add()
    {
        model('example')->add();
    }

    public function save()
    {
        
        $input = input('post.'); 
        
        $where = [];
        foreach($input as $k=>$v){
            if($k == 'id'){continue;}
            if($k == 'img' || $k == 'type'){                       
                $data[$k] = implode(',', $v);
            }else{
                $data[$k] = $v;            
            }
        }
        unset($data['desc'], $data['longcontent2'], $data['file']);
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

    public function uploadImg()
    {
        $event = controller('common/Upload');
        $res = $event->uploadImg();
        return $res;
    }

}
