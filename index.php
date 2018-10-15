 <?php
define('DS','/');
define('ROOT_PATH', dirname(__FILE__));
define('_PUBLIC_', ROOT_PATH.'/public');
define('_UPLOADS_', ROOT_PATH.'/public/uploads');
$GLOBALS['uploads'] = _UPLOADS_;
function autoload($class) {
	if(file_exists(ROOT_PATH.'/' . $class . '.class.php')){
    	require_once( ROOT_PATH.'/' . $class . '.class.php');
	}elseif(file_exists(_PUBLIC_.'/' . $class . '.class.php')){
   		require_once( _PUBLIC_.'/' . $class . '.class.php');
	}else{
		die('模块或控制器不存！');
	}
	
}
spl_autoload_register('autoload');
	if($_REQUEST['mod'] && $_REQUEST['act']){
	    $mod = $_REQUEST['mod'];
	    $control = $_REQUEST['act'];
	}else{
   	  	exit('请输入控制器名称如：mod=&act=');
   	}
$Object = new $mod;
$Object->$control();
// if(function_exists()){
// 	$Object->$control();
// }else{
// 	exit('方法不存在!');
// }




?>
