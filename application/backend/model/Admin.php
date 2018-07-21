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
			$id = session('user.id');
		}
		$id = 2;
		$role = Admin::get($id)->role_ids;
		$auth = model('Role')->where('id', 'in', $role)->column('auth');
		foreach($auth as $k){
			$temp = json_decode($k, true);
			var_dump($temp);
		}
		// var_dump($r);
		
	}


}
