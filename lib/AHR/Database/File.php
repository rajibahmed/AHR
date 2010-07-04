<?php  



/**
* This is custom library for reading wrting to file
* @author Rajib Ahmed
*/
class AHR_Database_File 
{
	
	public $name;
	
	public $size;
	
	public $data;
	
	public $path;
	
	function __construct($filename='',$path='')
	{
		$this->setName($filename);
		$this->setPath($path);
		
		if(!empty($filename) && !empty($path) && isset($path) && isset($filename)){
		 	$this->data = $this->readFile();
		 }
		 
	}
	
	public function readFile()	
	{
	 	return file_get_contents($this->path.$this->name);
	 	//return fopen($this->path.$this->name,'a+');
	}
	
	public function appendToFile($data)
	{
		
	}
	
	public function getSize()
	{
		return	$this->size = 5;
	}
	
	public function setPath($path='')
	{
		$this->path=$path;
	}
	
	
	
	public function readLine()
	{
		
		$lines = explode('|*|',$this->data);
		
		return $lines;
	}

	
	public function setName($name)
	{
		$this->name = $name;
	}
	
	public function formattedOutput(){
		
		if (!isset($this->data) && empty($this->data))
		{
			$this->data = $this->readFile();
		}
		
		$data=array();
		foreach ($this->readLine() as $line) {
			$data[] = explode('||', $line);
		}
		return $data;
	}
	
	public function totalFiles($path)
	{	
		return scandir($path);
	}

}
?>