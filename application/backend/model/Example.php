<?php
namespace app\backend\model;
use think\Config;
use think\Db;
use think\Session;
use think\Request;

class Example extends TableForm
{
	protected $table = 'example';

	public function index()
	{
		$this->setTable('example');
		$this->setTableFieldFile('example_table.php');
		// $this->setListCallback($this, 'format');
		// $this->setSearchCallback($this, 'formatSearch');
		// $this->setWhereCallback($this, 'formatWhere');
		parent::table();
	}

	public function format($res)
	{				
		
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
		$this->setFormFieldFile('example_form.php');
		parent::form();
	}

}
