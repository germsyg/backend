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

	// 回调方法
	protected $callback = '';

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

	/**
	 * 回调，用于二次处理查询出来的数据
	 * @author XZJ 2018-07-25T09:47:56+0800
	 * @param  [type] $callback [description]
	 */
	protected function setCallback($class, $func)
	{
		$this->callback['class'] = $class;
		$this->callback['func'] = $func;
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

		$db = db($this->table);
		$field = $this->parseField();			
		$where = $this->parseWhere();	

		$list = $db->field($field)->where($where)->fetchSql(false)->page($page, $limit)->select();						
		
		if($this->callback){			
			$list = call_user_func_array(array($this->callback['class'], $this->callback['func']), array($list));			
		}		
		
		$info['config'] = $this->loadFieldFile();			
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

	protected function parseWhere()
	{
		$input = input('post.');
		$where = array();
		if(isset($input['name'])){
			// $where['name'] = array('like', $input['name'].'%');
			$where['name'] = array('like', 'ran%');
		}
		return $where;
	}

	protected function loadFieldFile()
	{
		// 路径在与model同级的field文件夹下
		static $config;
		if(empty($config)){
			$path = dirname(__DIR__);
			$file = $path . DS . 'field' . DS . $this->table_field_file;		
			$config = '';
			if(is_file($file)){
				$config = require_once $file;
			}
		}
		
		return $config;
	}

	protected function parseField()
	{
		$config = $this->loadFieldFile();
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
