<?php
    	session_start();
    
    if(!defined ('DS')){
        define ('DS','/');
    }
    
    
    $dir = dirname(__FILE__);    
    if(!defined('APP_PATH')){
        define('APP_PATH',$dir);
	}
	
	    
    function __autoload($class_name) {

        $dirs = preg_split('/_/',$class_name);

        $loc='';

        $file=array_pop($dirs);

        foreach ($dirs as $variable) {
            $loc .= $variable.DS;
        }   

        /*
         *  example AHR_Database_Connection = AHR/Database/Connection.php
         */
        require_once APP_PATH.DS.$loc.$file.'.php';

    }

    function redirect_to($page='index.php'){
        header('location:'.$page);
        exit; 
    }

    function sanitize($data) {
        
    }

	function mysql_insertion_check($value)
	{
		$magic_qutes_active= get_magic_quotes_gpc();
		$new_php=function_exists('mysql_escape_string()');
		
		if($new_php){
			if($magic_qutes_active==true){
				$value=stripslashes($value);
			}
			$value=mysql_escape_string($value);
		}else{
			if($magic_qutes_active==false)
				$value = addslashes($value);
		}
		return $value;
	}

    function debug($t) {
		echo '<pre>';
			var_dump($t);
		echo '</pre>';
    }
    
	$user = new AHR_Auth_User();
    $session = new AHR_Auth_Session(); 
	require_once APP_PATH.DS.'AHR'.DS.'Database'.DS.'ActiveRecord.php';   