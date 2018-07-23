<?php
namespace app\backend\model;
use think\Config;
use think\Db;
use think\Session;
use think\Request;

class Role extends Backend
{

	public function getRole()
	{
		return collection(Role::column('*', 'id'))->toArray();
	}	

	public function getRoleAuth($id='')
	{		
		if(!$id){return [];}
		return json_decode(Role::get($id)->auth, true);
	}

	/**
	 * 格式化后的权限数据，用于编辑角色
	 * @author XZJ 2018-07-23T11:54:23+0800
	 * @param  string $id [description]
	 * @return [type]     [description]
	 */
	public function getFormatAuth($id='')
	{
		$modAuth = model('Auth');
		$auth = $modAuth->getAuth();
        $db_auth = $modAuth->getDbAuth();
        $role_auth = $this->getRoleAuth($id);
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
        return $res;
	}

}
