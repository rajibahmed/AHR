<?php

require_once 'ActiveRecord.php';

class Users extends AHR_Database_ActiveRecord{

    public function  __construct() {
       parent::__construct();
    }
    
}

$user= new Users;
//$user->find();


var_dump($user->find());
//echo $user->getQuery();




