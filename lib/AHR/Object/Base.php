<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
class AHR_Object_Base{
	
    public function blank($property){

        if(isset($property) and !empty($property)){
            return false;
        }
        return true;
    }
        
        


}
?>
