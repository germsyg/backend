<?php
namespace app\backend\model;
use think\Config;
use think\Db;
use think\Session;
use think\Request;

class Xconfig extends TableForm
{
	protected $table = 'config';

	public function index()
	{
		$this->setTable('config');
		$this->setTableFieldFile('config.php');
		// $this->setListCallback($this, 'format');
		// $this->setSearchCallback($this, 'formatSearch');
		// $this->setWhereCallback($this, 'formatWhere');
		parent::table();
	}

	public function format($res)
	{				
		$role = model('Role')->getRole();		
		foreach($res as $k=>&$v){
			$r = explode(',', $v['role_ids']);
			$v['role_ids'] = '';
			foreach($r as $k){
				$v['role_ids'] .= $role[$k]['name'] . ', ';
			}
			$v['status'] = $this->buildSwitch('正常|禁用',  $v['status'], $v['status']?:0 );		
			$v['reg_time'] = date('Y-m-d H:i:s', $v['reg_time']);
			$v['operate'] = $this->buildBtn('编辑', url('Admin/edit', ['id'=>$v['id']]));
		}unset($v);		
		
		return $res;
	}

	public function formatWhere($where)
	{
		return $where;
	}

	public function formatSearch($search)
	{
		return $search;
	}

	public function add()
	{
		$this->setFormFieldFile('config_form.php');
		parent::form();
	}

}
