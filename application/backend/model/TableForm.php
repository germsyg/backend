<?php
namespace app\backend\model;
use think\Model;
use think\View;


class TableForm extends Backend
{

	// 数据表
	protected $table = '';

	// 查询数据表字段文件
	protected $table_field_file = '';

	protected $table_config;

	// 列表数据回调方法
	protected $list_callback = array();

	// 搜索数据where回调
	protected $search_callback = array();

	// 查询筛选
	protected $filter = '';



	/**
	 * 设置查询的主表
	 * @author XZJ 2018-07-25T09:47:00+0800
	 * @param  [type] $table [description]
	 */
	protected function setTable($table)
	{
		$this->table = $table;
	}

	/**
	 * 设置查询表单字段
	 * @author XZJ 2018-07-25T09:47:30+0800
	 * @param  [type] $file [description]
	 */
	protected function setTableFieldFile($file)
	{
		$this->table_field_file = $file;
	}

	protected function setTableConfig($config)
	{
		$this->table_config = $config;
	}

	/**
	 * 回调，用于二次处理查询出来的数据
	 * @author XZJ 2018-07-25T09:47:56+0800
	 * @param  [type] $callback [description]
	 */
	protected function setListCallback($class, $func)
	{
		$this->list_callback['class'] = $class;
		$this->list_callback['func'] = $func;
	}

	protected function setSearchCallback($class, $func)
	{
		$this->search_callback['class'] = $class;
		$this->search_callback['func'] = $func;	
	}

	/**
	 * 公共列表页
	 * @author XZJ 2018-07-23T20:05:33+0800
	 * @return [type] [description]
	 */
	protected function table()
	{
		$page = input('post.page', 1);
		$limit = input('post.limit', 10);
		$this->loadFieldFile();

		$db = db($this->table);
		$field = $this->parseField();			
		$where = $this->parseWhere();	

		$list = $db->field($field)->where($where)->fetchSql(true)->page($page, $limit)->select();						
		var_dump($list);
		if($this->list_callback){				
			$list = call_user_func_array(array($this->list_callback['class'], $this->list_callback['func']), array($list));
		}		
		
		$info['config'] = $this->parseConfig();
		$info['search'] = $this->parseSearch();
		$info['count'] = $db->where($where)->count();				
		$info['limit'] = $limit;				
		$info['list'] = $list;	

		if(request()->isAjax()){					
			$view = view('table_form/tr');		
			$view->assign('info', $info);			
			$html = $view->getContent();			
			$res['status'] = 1;			
			$res['msg'] = 'success';			
			$res['data']['html'] = $html;
			$res['data']['count'] = $info['count'];
			$res['data']['limit'] = $info['limit'];
			echo json_encode($res);die;
		}else{
			$view = view('table_form/table');					
			$view->assign('info', $info);
			$view->send();
		}
			
	}

	protected function parseConfig()
	{
		$config = $this->table_config;
		foreach($config as $k=>$v){
			if(isset($v['is_show']) && !$v['is_show']){
				unset($config[$k]);
			}
		}
		return $config;
	}

	protected function parseSearch()
	{
		$config = $this->table_config;
		// var_dump($config);die;
		$search = array();

		$text = function($conf){
			return [];		
		};

		$date = function($conf){
			$js_id[] = $start['field'] = '__start_'.$conf['field'];
			$js_id[] = $end['field'] = '__end_'.$conf['field'];

			return array('start'=>$start, 'end'=>$end, 'js_id'=>$js_id);
		};

		foreach($config as $k=>$v){
			$data = array();
			if(isset($v['is_search'])){
				$data['field'] = $v['field'];
				if(isset($conf['is_search']['field'])){
					$data['field'] = $conf['is_search']['field'];
				}	
				$data['title'] = $v['title'];
				$data['type'] = $v['is_search']['type'];

				$data = array_merge($data, ${$v['is_search']['type']}($v));							
				$search[] = $data;
			}
		}
// var_dump($search);die;
		return $search;
	}

	protected function parseWhere()
	{
		$input = input('post.');
		$where = array();
		$config = $this->table_config;
		$where = array();
		foreach($config as $k=>$v){
			if(isset($v['is_search'])){
				if($v['is_search']['type'] == 'text'){
					if(!empty($input[$v['field']])){
						$r = array_flip($v['is_search']['expression']['args']);
						$r['name'] = '';
						$r['value'] = $input[$v['field']];
						$ext = vsprintf($v['is_search']['expression']['rule'], $r);						
						$where[$v['field']] = array('exp', $ext);						
					}
				}else if($v['is_search']['type'] == 'date'){
					if(!empty($input['__start_'.$v['field']]) && !empty($input['__end_'.$v['field']])){
						if(isset($v['is_unix_time']) && $v['is_unix_time']){
							$start = strtotime($input['__start_'.$v['field']]);
							$end = strtotime($input['__end_'.$v['field']]) + 86399;
						}
						$where[$v['field']] = array('>=', $start);
						$where[$v['field']] = array('=<', $end);
					}
				}
			}
		}
		// var_dump($where);die;
		return $where;
	}
	

	protected function loadFieldFile()
	{
		// 路径在与model同级的field文件夹下		
		if(empty($config)){
			$path = dirname(__DIR__);
			$file = $path . DS . 'field' . DS . $this->table_field_file;		
			$config = '';
			if(is_file($file)){
				$config = require_once $file;
				
			}
		}
		$this->setTableConfig($config);		
	}

	protected function parseField()
	{
		$config = $this->table_config;		
		$str = '';
		foreach($config as $k=>$v){
			if(isset($v['is_sql']) && !$v['is_sql']){
				$str .= '" " as `' . $v['field'] . '`' . ', ';
				continue;
			}

			if(isset($v['alias'])){
				$str .= $v['alias'] . '`' . $v['field'] .'`' . ', ';
			}else{
				$str .=  '`' . $v['field'] . '`' . ', ';
			}
		}
		return trim($str, ', ');		
	}

	protected function buildBtn($text, $url, $icon='')
	{			
		if(!$icon){
			$icon = '<button class="layui-btn layui-btn-xs">'.$text.'</button>';
		}else{
			$icon = '<i class="iconfont">'.$icon.'</i>';
		}

		$html = '<a title="%s" onclick="x_admin_show(\'%s\',\'%s\')" href="javascript:;">%s</a>';
        $html = sprintf($html, $text, $text, $url, $icon);
        return $html;
	}

	protected function buildSwitch($text, $value, $checked=true)
	{
		if($checked){
			$checked = 'checked="checked"';
		}else{
			$checked = ' ';
		}
		$html = '<input type="checkbox" name="status" lay-text="%s" lay-skin="switch" lay-filter="status" value="%s" %s>';
		$html = sprintf($html, $text, $value, $checked);
		return $html;
	}

	/**
	 * 公共表单页
	 * @author XZJ 2018-07-24T16:34:24+0800
	 * @return [type] [description]
	 */
	protected function form()
	{

	}
}
