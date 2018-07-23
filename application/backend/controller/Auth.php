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
        foreach($auth as $ka=>$va){
            $d['class'] = $va['class'];
            $d['name'] = isset($db_auth[$va['class']]['-']['name']) ? $db_auth[$va['class']]['-']['name'] : '';                
            foreach($va['func'] as $k=>$v){
                $d['func'][$k] = isset($db_auth[$va['class']][$k]['name']) ? $db_auth[$va['class']][$k]['name'] : '';
            }
            $info[] = $d;
        }        
        $this->assign('info', $info);
        return $this->fetch();
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
                    if($v == ''){
                        continue;
                    }
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

}
