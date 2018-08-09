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
		$this->setTableFieldFile('config_table.php');
		$this->setListCallback($this, 'formatList');
		// $this->setSearchCallback($this, 'formatSearch');
		// $this->setWhereCallback($this, 'formatWhere');
		parent::table();
	}

	public function formatList($data)
	{
		foreach($data as $k=>&$v){
			$v['operate'] = $this->buildBtn('编辑', url('edit', array('id'=>$v['id'])));
		}
		return $data;
	}



	public function add($id=0)
	{
		$this->setFormFieldFile('config_form.php');
		if($id){
			$info['data'] = Xconfig::get($id)->toArray();
			// var_dump($info);
			$this->assignData($info);
		}
		parent::form();
	}

}
