<?php
namespace app\backend\model;
use think\Config;
use think\Db;
use think\Session;
use think\Request;

class Admin extends TableForm
{

	public function index()
	{
		$this->setTable('admin');
		$this->setTableFieldFile('admin.php');
		$this->setListCallback($this, 'format');
		$this->setSearchCallback($this, 'formatSearch');
		$this->setWhereCallback($this, 'formatWhere');
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
