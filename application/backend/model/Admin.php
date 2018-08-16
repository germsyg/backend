<?php
namespace app\backend\model;
use think\Config;
use think\Db;
use think\Session;
use think\Request;

class Admin extends TableForm
{

	/**
	 * 管理员列表页
	 * @author XZJ 2018-08-14T19:25:12+0800
	 * @return [type] [description]
	 */
	public function index()
	{
		$this->setTable('admin');
		$this->setTableFieldFile('admin_table.php');
		$this->setListCallback($this, 'formatList');
		
		parent::table();
	}

	/**
	 * 编辑页
	 * @author XZJ 2018-08-14T19:25:23+0800
	 * @param  integer $id [description]
	 */
	public function add($id=0)
	{
		$this->setFormFieldFile('admin_form.php');
		$role = model('Role')->getRole();
		foreach($role as $k=>$v){            
            $options[$v['name']]['value'] = $v['id'];
            $options[$v['name']]['checked'] = 0;
        }
        
		if($id){
			$info['data'] = $this->getAdmin($id);        	        
			// var_dump($info['user']);
	        $user_role = explode(',', $info['data']['role_ids']);
	        $info['data']['role_ids'] = $user_role;
	        $info['data']['pwd'] = '';
	        if(!empty($user_role)){
	            foreach($options as $k=>$v){
	                if(in_array($v['value'], $user_role)){
	                    $role[$k]['checked'] = 1;
	                }
	            }
	        }
	        $info['role'] = $role;
        	$this->assignData($info);                   
		}
		// var_dump($options);
		$info['field']['role_ids']['option'] = $options;
		// var_dump($info);die;
		$this->assignData($info);                   
		
        parent::form(); 
	}

	/**
	 * 格式化列表
	 * @author XZJ 2018-08-14T19:25:39+0800
	 * @param  [type] $res [description]
	 * @return [type]      [description]
	 */
	public function formatList($res)
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
			$v['operate'] = $this->buildBtn('编辑', url('edit', ['id'=>$v['id']]));
		}unset($v);		
		
		return $res;
	}

	/**
	 * 获取管理员信息
	 * @author XZJ 2018-08-14T19:25:56+0800
	 * @param  [type] $id [description]
	 * @return [type]     [description]
	 */
	public function getAdmin($id)
	{
		return Admin::get($id)->toArray();
	}	

	/**
	 * 获取管理员权限信息
	 * @author XZJ 2018-08-14T19:26:18+0800
	 * @param  string $id [description]
	 * @return [type]     [description]
	 */
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
