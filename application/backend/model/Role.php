<?php
namespace app\backend\model;
use think\Config;
use think\Db;
use think\Session;
use think\Request;

class Role extends Backend
{
	public function getRoleAuth($id)
	{
		
		return json_decode(Role::get($id)->auth, true);
	}

}
