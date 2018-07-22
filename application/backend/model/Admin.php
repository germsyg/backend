<?php
namespace app\backend\model;
use think\Config;
use think\Db;
use think\Session;
use think\Request;

class Admin extends Backend
{

	public function getAdmin($id)
	{
		return Admin::get($id)->toArray();
	}	

	public function getAdminAuth($id='')
	{
		if(!$id){
			$id = session('admin.id');
		}		
		// 用户属于多个角色
		$role = Admin::get($id)->role_ids;
		$auth = model('Role')->where('id', 'in', $role)->column('auth');
		$sum = array();
		foreach($auth as $k){
			if(!empty($k)){
				$temp = json_decode($k, true);
				foreach($temp as $kt=>$vt){
					if(isset($sum[$kt])){
						$sum[$kt] = array_merge($sum[$kt], $vt);
					}else{
						$sum[$kt] = $vt;
					}
				}
			}		
		}
		return $sum;		
	}


}
