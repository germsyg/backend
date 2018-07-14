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
    protected function edit($table='', $data='', $where='')
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
    	return $res;
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
    protected function select($table, $where='', $field='*', $page=1, $limit=50, $isCount=false)
    {
    	if(!$table){
    		return false;
    	}
    	$obj = db($table);
    	if($isCount){
    		$type = 'count';
    	}else{
    		$type = 'select';
    		if($page != 0){
    			// 0则查询所有数据
    			$obj->page("{$page}, {$limit}");
    		}
    		$obj->field($field);
    	}

    	$res = $obj->where($where)->fetchSql($this->fetchSql)->$type();
    	return $res;
    }


    /**
     * 后台数据count查询
     * @author XZJ 2018-07-14T17:16:01+0800
     * @param  [type] $table [description]
     * @param  string $where [description]
     * @return [type]        [description]
     */
    protected function count($table, $where='')
    {
		return db($table)->where($where)->fetchSql($this->fetchSql)->count();
    }
}
