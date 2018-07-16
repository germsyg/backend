<?php
namespace app\backend\controller;
use think\Controller;
use think\Db;
use think\Session;

header("Content-type: text/html; charset=utf-8");
class Backend extends Controller
{
	// succcess 返回
    protected $suc = array('status'=>1, 'msg'=>'success', 'data'=>'');
    // failed 返回
    protected $fai = array('status'=>0, 'msg'=>'failed', 'data'=>'');
    // true为返回sql
    protected $fetchSql = false;



    /**
     * 后台数据编辑器，统一处理添加、编辑
     * @author XZJ 2018-07-14T15:09:13+0800
     * @param  [type] $table [description]
     * @param  [type] $where [description]
     * @param  [type] $data  [description]
     * @return [type]        [description]
     */
    protected function editBE($table='', $data='', $where='')
    {
    	if(!$table){
    		return false;
    	}
    	$obj = db($table);
    	if($where){
    		$obj->where($where);
    		$type = 'update';
    	}else{
    		$type = 'insert';
    	}    	
    	$res = $obj->fetchSql($this->fetchSql)->$type($data);
        if(!$this->fetchSql){
            $this->log($table, $data, $where);
        }
    	return $res;
    }

    /**
     * 后台数据操作日志
     * @author XZJ 2018-07-16T12:43:03+0800
     * @param  [type] $table [description]
     * @param  [type] $data  [description]
     * @param  [type] $where [description]
     * @return [type]        [description]
     */
    private function log($table, $data, $where)
    {
        $data_id = 0;
        if($where){
            if(is_array($where)){
                $key = db($table)->getPk();
                isset($where[$key]) && $data_id = $where[$key];
            }
        }else{
            $data_id = db($table)->getLastInsID();
        }
        $insert['table'] = $table;
        $insert['data_id'] = (int)$data_id;
        $insert['content'] = json_encode($data);
        $insert['admin_id'] = session::get('user.id');
        $insert['add_time'] = time();
        db('backend_log')->insert($insert);
    }

    /**
     * 后台数据查询
     * @author XZJ 2018-07-14T17:15:43+0800
     * @param  [type]  $table   [description]
     * @param  string  $field   [description]
     * @param  string  $where   [description]
     * @param  integer $page    [description]
     * @param  integer $limit   [description]
     * @param  boolean $isCount [description]
     * @return [type]           [description]
     */
    protected function selectBE($table, $where='', $field='*', $page=1, $limit=50, $isCount=false)
    {
    	if(!$table){
    		return false;
    	}
    	$obj = db($table);
    	if($isCount){
    		$type = 'count';
    	}else{
    		$type = 'select';
    		if($where != 'all' || $page == 0){  
    			// where为all时，放弃分页
    			$obj->page("{$page}, {$limit}");
    		}
    		$obj->field($field);
    	}
    	if($where != 'all'){
    		$obj->where($where);
    	}

    	$res = $obj->fetchSql($this->fetchSql)->$type();
    	return $res;
    }

    public function findBE($table, $where='', $field='*')
    {
    	if(!$table){
    		return false;
    	}
    	$obj = db($table);    	

    	$res = $obj->where($where)->fetchSql($this->fetchSql)->find();
    	return $res;
    }

    /**
     * 后台数据count查询
     * @author XZJ 2018-07-14T17:16:01+0800
     * @param  [type] $table [description]
     * @param  string $where [description]
     * @return [type]        [description]
     */
    protected function countBE($table, $where='')
    {
		return db($table)->where($where)->fetchSql($this->fetchSql)->count();
    }
}
