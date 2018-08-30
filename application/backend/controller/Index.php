<?php
namespace app\backend\controller;
use think\Config;
use think\Db;

class Index extends Backend
{
	/**
	 * 后台首页
	 * @author XZJ @date 2018-07-17T19:55:06+0800
	 * @return [type] [description]
	 */
    public function index()
    {              

    	$menu = $this->selectBE('menu', ['status'=> 1], '*', ['page'=>0]);
    	$menu = tree($menu);        
        // var_dump($menu);die;
        foreach($menu as $k=>$v){
            if(!empty($v['child'])){
                $child_group = [];
                foreach($v['child'] as $kc=>$vc){
                    if($vc['group'] != ''){
                        $temp['name'] = $vc['group'];                        
                    }else{
                        $temp['name'] = $v['name'];
                    }                                  
                    $child_group[$temp['name']][] = $vc;
                }
                $menu[$k]['child'] = $child_group;
            }
        }
        // var_dump($menu);die;
        $this->assign('menu', $menu);
        return $this->fetch();
    }

    
}
