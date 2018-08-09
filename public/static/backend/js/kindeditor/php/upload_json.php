<?php
require_once 'JSON.php';

/*图片服务器URL*/
define('IMAGE_SERVER_URL', 'https://img.staticbg.com/');
define('IMAGE_SERVER_IP', '10.177.159.68');//图片服务器内网ip

$php_path = dirname(__FILE__) . '/';
$php_url = dirname($_SERVER['PHP_SELF']) . '/';

//文件保存目录路径
$save_path = $php_path . '../../forum_images/';
//文件保存目录URL
$save_url = 'forum_images/';
//定义允许上传的文件扩展名
$ext_arr = array(
	'image' => array('gif', 'jpg', 'jpeg', 'png', 'bmp'),
	//'flash' => array('swf', 'flv'),
	//'media' => array('swf', 'flv', 'mp3', 'wav', 'wma', 'wmv', 'mid', 'avi', 'mpg', 'asf', 'rm', 'rmvb'),
	//'file' => array('doc', 'docx', 'xls', 'xlsx', 'ppt', 'htm', 'html', 'txt', 'zip', 'rar', 'gz', 'bz2'),
);
//最大文件大小
$max_size = 500*1024;

$save_path = realpath($save_path) . '/';

//PHP上传失败
if (!empty($_FILES['imgFile']['error'])) {
	switch($_FILES['imgFile']['error']){
		case '1':
			$error = 'Upload file size limit exceeded.';
			break;
		case '2':
			$error = 'Upload file size limit exceeded.';
			break;
		case '3':
			$error = 'The picture only partially Uploaded';
			break;
		case '4':
			$error = 'Please select a picture';
			break;
		case '6':
			$error = 'temp directory not found!';
			break;
		case '7':
			$error = 'System error,please try again!';
			break;
		case '8':
			$error = 'File upload stopped by extension';
			break;
		case '999':
		default:
			$error = 'System error,please try again!';
	}
	alert($error);
}

//有上传文件时
if (empty($_FILES) === false) {
	//原文件名
	$file_name = $_FILES['imgFile']['name'];
	//服务器上临时文件名
	$tmp_name = $_FILES['imgFile']['tmp_name'];
	//文件大小
	$file_size = $_FILES['imgFile']['size'];
	//检查文件名
	if (!$file_name) {
		alert("Please select a picture.");
	}
	//检查目录
	if (@is_dir($save_path) === false) {
		alert("Upload directory does not exist.");
	}
	//检查目录写权限
	if (@is_writable($save_path) === false) {
		alert("Upload directory has no permission.");
	}
	//检查是否已上传
	if (@is_uploaded_file($tmp_name) === false) {
		alert("Upload file failed.");
	}
	//检查文件大小
	if ($file_size > $max_size) {
		alert("Upload file size limit exceeded. ( Maximum size:500k )");
	}
	//检查目录名
	$dir_name = empty($_GET['dir']) ? 'image' : trim($_GET['dir']);
	if (empty($ext_arr[$dir_name])) {
		alert("Directory name is not correct.");
	}
	//获得文件扩展名
	$temp_arr = explode(".", $file_name);
	$file_ext = array_pop($temp_arr);
	$file_ext = trim($file_ext);
	$file_ext = strtolower($file_ext);
	//检查扩展名
	if (in_array($file_ext, $ext_arr[$dir_name]) === false) {
		alert("Upload file extensions are not allowed.\n Only" . implode(",", $ext_arr[$dir_name]) . " type allowed.");
	}
	//创建文件夹
	if ($dir_name !== '') {
		$save_path .= $dir_name . "/";
		$save_url .= $dir_name . "/";
		if (!file_exists($save_path)) {
			mkdir($save_path);
		}
	}
	$ymd = date("Ymd");
	$save_path .= $ymd . "/";
	$save_url .= $ymd . "/";
	if (!file_exists($save_path)) {
		mkdir($save_path);
	}
	//新文件名
	$new_file_name = date("YmdHis") . '_' . rand(10000, 99999) . '.' . $file_ext;
	//移动文件
	$file_path = $save_path . $new_file_name;
	if (move_uploaded_file($tmp_name, $file_path) === false) {
		alert("Upload file failed.");
	}
	@chmod($file_path, 0755);

	$file_url = $save_url.$new_file_name;
	
	if(uploadToFtp($file_path,$file_url)){
		@unlink($file_path);
	}else{
		@unlink($file_path);
		alert("Upload file failed.");
	}
	
	//切换图片服务器路径
	$img_url = IMAGE_SERVER_URL . "forum_images/image/$ymd/".$new_file_name;
	
	header('Content-type: text/html; charset=UTF-8');
	$json = new Services_JSON();
	echo $json->encode(array('error' => 0, 'url' => $img_url));
	exit;
}

function alert($msg) {
	header('Content-type: text/html; charset=UTF-8');
	$json = new Services_JSON();
	echo $json->encode(array('error' => 1, 'message' => $msg));
	exit;
}

function uploadToFtp($file_path,$local_file)
{
	$handle = @fopen($file_path, 'r');
	if (!$handle){return false;}
	
	$contents = '';
	$contents = @fread($handle, filesize($file_path));
	@fclose($handle);
	//图片名
	$filename = basename($local_file);
	//图片目录
	$dirname = dirname($local_file);
	//$dirname = 'images/banner';
	
	$Ftp = &Z_createFtp();
	
	//因为无法判断是否存在目录，所以先创建目录
	//创建路径
	$dirs = explode('/', $dirname);
	$root_dir = '/img/IMG/';
	$upload_path = $root_dir.rtrim($dirname, '/').'/';
	foreach ($dirs as $dir){
		$root_dir = rtrim($root_dir, '/').'/'.$dir.'/';
		if ($dir != 'thumb'){
			$Ftp->mkdir($root_dir);
		}
	}
	
	//切换到上传目录
	$ret = $Ftp->chdir($upload_path);
	if ($ret){
		//上传到FTP
		$ret = $Ftp->put($filename, $contents);
	}
	
	return $ret;
}

	/**
     * 创建图片服务器FTP操作类
     *
     * @return object ZFTP
     */

function &Z_createFtp()
{
	static $instance;
	
	if (!isset($instance))
	{
		if (!class_exists('Net_SFTP'))
		{
			$root = dirname(dirname(dirname(__FILE__)));
			require_once $root.'/bg_os/includes/classes/e3_email/e3.class.php';
		}
		//图片服务器帐号
		$host = IMAGE_SERVER_IP;//图片服务器内网ip
		if($_SERVER['HTTP_HOST']=='localhost') $host = IMAGE_SERVER_HOST;
		$username = 'ftp_images';
		$password = 'fimgp_34@#$#%';
		$instance = new Net_SFTP ($host, 22);
		$ret = $instance->login($username, $password);
		if (!$ret){return false;}
		//切换到图片根目录
		$instance->chdir('/img/IMG/');
	}
	return $instance;
}
