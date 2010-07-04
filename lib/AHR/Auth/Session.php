<?php  

/**
* mypassword12
*/
class AHR_Auth_Session
{
	
	function __construct()
	{

	}
	
	public function setFlash($msg='')
	{
		$_SESSION['flash']=$msg;
	}
	
	public function getFlash()
	{
		if(isset($_SESSION['flash']) and !empty($_SESSION['flash'])){
			$temp = $_SESSION['flash'];
			unset($_SESSION['flash']);
			return $temp;
		}
		else{
			return false;
		}
	}
	
	public function isAuthenticated()
	{
		if(!isset($_SESSION['login'])) 
			return false;
		else 
			return $_SESSION['login'];
	}
	
	public function login($bool)
	{
		if($bool){
			$_SESSION['login'] = true;		
		}
		else{
			$_SESSION['login']= false;
		}
	}
	
	
	public function logout()
	{
		$_SESSION['login'] = false;
		//session_destroy();
	}
	

}

?>