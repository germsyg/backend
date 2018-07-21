<?php
namespace app\backend\controller;
use think\Controller;
use think\Db;
use think\Session;

header("Content-type: text/html; charset=utf-8");
class Backend extends Controller
{
	public function _initialize()
    {
        if(!session::get('user')){
			$this->redirect('Login/index');
        }
    }
	// succcess 返回
    protected $suc = array('status'=>1, 'msg'=>'success', 'data'=>'');
    // failed 返回
    protected $fai = array('status'=>0, 'msg'=>'failed', 'data'=>'');
    // true为返回sql
    protected $fetchSql = false;

    protected function lists($table, $where='', $field='*', $other=[])
    {        
        if(!$table){
            return false;
        }       
        $obj = db($table);
        
        
        $page = isset($other['page']) ? $other['page'] : 1;
        $limit = isset($other['limit']) ? $other['limit'] : 50;
        if($where != 'all' || $page != 0){
            // where为all时，放弃分页
            $obj->page("{$page}, {$limit}");
        }
        if(isset($other['order'])){             
            $obj->order($other['order']['key'], $other['order']['sort']);
        }
        $obj->field($field);
        
        if($where != 'all'){
            $obj->where($where);
        }
        $total = $obj->count();
        $this->assign('total', $total);
        $res = $obj->fetchSql($this->fetchSql)->select();        
        return $res;
    }

    /**
     * 后台数据编辑器，统一处理添加、编辑
     * @author XZJ 2018-07-14T15:09:13+0800
     * @param  [type] $table [description]
     * @param  [type] $where [description]
     * @param  [type] $data  [description]
     * @return [type]        [description]
     */
    protected function saveBE($table='', $data='', $where='')
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
    	return $res !== false;
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
     * @author XZJ @date 2018-07-17T19:50:44+0800
     * @param  [type] $table [description]
     * @param  string $where [description]
     * @param  string $field [description]
     * @param  array  $other ['page'=>1, 'limit'=>50, 'order'=>array('key'=>'id', 'sort'=>desc)]
     * other参数主要为，分页，与排序参数
     * @return [type]        [description]
     */
    protected function selectBE($table, $where='', $field='*', $other=[])    
    {
    	if(!$table){
    		return false;
    	}    	
    	$obj = db($table);
    	if(isset($other['isCount'])){
    		$type = 'count';
    	}else{
    		$type = 'select';
			$page = isset($other['page']) ? $other['page'] : 1;
			$limit = isset($other['limit']) ? $other['limit'] : 50;
    		if($where != 'all' || $page != 0){
    			// where为all时，放弃分页
    			$obj->page("{$page}, {$limit}");
    		}
    		if(isset($other['order'])){    			
    			$obj->order($other['order']['key'], $other['order']['sort']);
    		}
    		$obj->field($field);
    	}
    	if($where != 'all'){
    		$obj->where($where);
    	}

    	$res = $obj->fetchSql($this->fetchSql)->$type();
    	return $res;
    }

    /**
     * 一列数据
     * @author XZJ @date 2018-07-17T19:50:28+0800
     * @param  [type] $table [description]
     * @param  string $where [description]
     * @param  string $field [description]
     * @return [type]        [description]
     */
    protected function findBE($table, $where='', $field='*')
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
