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
		$this->setListCallback($this, 'formatList');
		$this->setSearchCallback($this, 'formatSearch');
		$this->setWhereCallback($this, 'formatWhere');
		parent::table();
	}

	public function formatList($res)
	{				
		foreach($res as $k=>&$v){
			$v['operate'] = $this->buildBtn('edit', url('edit', array('id'=>$v['id'])));
			$v['status'] = $this->buildSwitch('启用|关闭', $v['status'], $v['status']== 1 ? true: false);
			$v['add_time'] = date('Y-m-d H:i:s', $v['add_time']);
		}
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

	public function add($id = 0)
	{
		$this->setFormFieldFile('example_form.php');
		
		if($id){
			$data = $info['data'] = Example::get($id)->toArray();

			// 格式化显示日期
			$info['data']['add_time'] = date('Y-m-d', $data['add_time']);

			// 格式化checkbox，数据为数组
			$info['data']['type'] = explode(',', $data['type']);

			// 格式化图片， 形成url与value
			$img = explode(',', $data['img']);
			$info['data']['img'] = array_map(function($d){
				return array('url' => '/upload/'.$d, 'value' => $d);
			}, $img);
			
			// var_dump($info);die;
			$this->assignData($info);
		}
		parent::form();
	}



}
