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



}
