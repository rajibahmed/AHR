<?php


require_once 'Connection.php';

/**
 * Description of ActiveRecord
 *
 * @author R Ahmed
 */
class AHR_Database_ActiveRecord{



    /*
     *  This holds the last query
     *
     */
    //TODO need to log of this query for log reader;

    private $_query;

    private $_db;

    private $_tableName;

    private $_columns=array();

    //private $_columnNames;

    private $_lastInsertId = null;

    public function  __construct() {
        // assings the singleton database link to the db attribute
        $this->_db = AHR_Database_Connection::getInstance()->getLink();

        // sets the table name for CRUD
        $this->_tableName = $this->_getTableNameFromChildClass();

        // sets the objcet properties
        $this->_columns = $this->_setTableAttributes();
        
    }


    /**
     *
     * @return string Displays the query string of current class
     */
    public function getQuery() {

        return $this->_query;


    }



    protected function _prepareQuery() {


    }



    protected function _executeQuery() {


    }




    /**
     *
     * This is the find imetation of RoR
     * 
     * @param array 
     *
     */
    public function find($name='all', Array $options=null){

        $this->_query = 'SELECT * FROM '.$this->_tableName;
    	
    	$columns=null;
    	$where= null;
    	$limit= null;
    	$order= null;
    	
    	
    	if (!empty($options)) {
	    	extract($options);
    	}
    	
	
    	if($columns){
    		$str = implode(',',$columns);
        	$this->_query .= ' '.$str;
        }
	
        if($where){
    		$str = implode(' ', $where);
        	$this->_query .= ' where '.$str;
        	
        }
        
    	
        if($limit){
			$this->_query .= ' limit '.$limit;   		
    	}
    	
    	if($order){
    		$str = implode(' ', $order);
				$this->_query.=' order by '.$str;
    	}        

    	//echo $this->_query;
        $objects=array();

        $result = $this->_db->query($this->_query);

        while($record= $result->fetch_assoc()){
            
            $class_name = $this->_tableName;

            $object =new $class_name;

            foreach ($record as $key=>$value){

                if($object->hasAttributes($key)){
                    $object->$key = $value;
                }//if
                
            }//foreach

            $objects[] = $object;
        }//while
       return $objects;
    }


    /**
     *
     * This is the find imetation of RoR
     * 
     * @param array 
     *
     */
    public function findById($id,$column='id'){
        $this->_query = 'SELECT * FROM '.$this->_tableName.' WHERE '.$column.'='.$id;
        $objects=false;
        $result = $this->_db->query($this->_query);
      //  while($record= $result->fetch_assoc()){
            $record = $result->fetch_assoc();
            $class_name = $this->_tableName;
            $object =new $class_name;
            foreach ($record as $key=>$value){
                if($object->hasAttributes($key)){
                    $object->$key = $value;
                }//if
            }//foreach
            //$objects[] = $object;
        //}//while
       return $object;
    }



    /**
     * This also find through the database
     * 
     * @param string $sql raw sql code is feed here
     */
    public function findBySql($sql='') {

        $this->_query = $sql;



    }


    /**
     *
     * @return string  returns the class name of the requested class
     */
    protected function _getTableNameFromChildClass(){

        return strtolower(get_class($this));

    }



    protected function _buildSelectQuery() {



    }




    /**
     * This will do both inster and Update SQL
     *
     */
    public function save( $data = array()) {
        
        $query = 'INSERT INTO '.$this->_tableName.' ( ';

        $query.= implode(',',$this->_columns); 

        $query.=') values(\'';

        $values=array();

        foreach($this->_columns as $column){
            $values[] = $this->$column;                
        }

        $query.= implode('\',\'',$values);
        
        $query.='\')';
        return $this->_db->query($query);
    }
    /**
     * This will run the update command
     */

    public function update() {

        //if($this->id){
            $query = 'UPDATE '.$this->_tableName.' SET ';

            $columns = $this->_columns;
            array_shift($columns); 
            $set =array();
            foreach($columns as $column){
                $set[] = ' '.$column .'=\''.$this->{$column}.'\'';
            
            }
            $query.=implode(',',$set);
            $query.= " WHERE id = '{$this->id}'";
        //}
        
    }

    /**
     *
     *
     */
    public function updateAttributes() {

    }



    /**
     * this can delete a record and it can also dependent destroy
     *
     */
    public function destroy() {


    }




    /**
     *  This will generate all the attr for child class
     *  and have to make it right
     * 
     */
    public function _setTableAttributes() {
		
        $this->_query ='SHOW COLUMNS FROM '.$this->_tableName;
        $result = $this->_db->query($this->_query);
        $column_names =array();
        while($row = $result->fetch_assoc()){
            $this->{$row['Field']} =null;
            $column_names[] = $row['Field'];
        }
        return $column_names;
    }



    public function hasAttributes($attribute) {
        
        $attributes= get_object_vars($this);

        return array_key_exists($attribute, $attributes);
    }


    public function lastId(){
    
        $this->_query = 'SELECT LAST_INSERT_ID() as id';
        $lastInsertId = $this->_db->query($this->_query)->fetch_assoc();
        
        return $this->_lastInsertId =(int) $lastInsertId['id'];

    }


    
    public function saveAll() {

    }
    
    function query($string){
    
       return $this->_db->query($string);
    }
    
    function multi_update($data,$table){
	//debug($data);	
		$q=array();
		$test=array();
		$ids=array();
		$data = array_filter($data);
		// debug($data);
		if (!empty($data)) {
			foreach ($data as $value) {
				foreach ($value as $key => $value) {
					if($key!='id'){
						$q[]="$key = '$value'";
					}else{
						$ids[]=(int)$value;
					}
				}
					$test[]= implode(', ', $q);
					unset($q);						
			}

			for ($i=0; $i < count($ids); $i++) { 
				if(!empty($test[$i]))
			    	$query = 'update '.$table.' set '.$test[$i].' where id='.$ids[$i];
				$this->query($query);
			}	
		}

	}

}// 
