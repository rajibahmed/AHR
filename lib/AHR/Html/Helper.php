<?php
/**
 * 
 */

class AHR_Html_Helper {


    public function optionsForSelect($options)
    {
        extract($options);
        
        $output='';
        
		if($selects)
		{

			$output= $default?'<option selected >Primary </option>':'';


			foreach( $selects as $option )
			{
				if($selected_id && ($selected_id==$option[$value]))
				{
					$output .="<option selected value=\"$option[$value]\">".$option[$display]."</option>";
				}
				else
				{
					$output .="<option value=\"$option[$value]\">".$option[$display]."</option>";
				}
			}
			return $output;
		}
		else
		{
			return	$output='<option selected > Nothing To select </option>';
		}
        
	}


    public function linkTo($options) {

        extract($options);
        
        try{
            if(!isset($text)){
                throw new Exception('Hyper Link can not  be created');
            }
            else{
                $output = '<a href=\''.$href.'\'>'.$text.'</a>';
            }

        }
        catch( Exception $e){
            echo "You Have an error :".$e->getMessage();
        }

        return $output;
    }

    
}
//no need to end php_end Zend article For header Already Sent ;