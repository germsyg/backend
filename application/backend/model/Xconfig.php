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



	public function add($id=0)
	{
		$this->setFormFieldFile('config_form.php');
		parent::form();
	}

}
