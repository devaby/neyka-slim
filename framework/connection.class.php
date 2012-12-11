<?php

namespace framework;

class connection {

public $type            = DATABASE;
public $schema          = "CORNC";
public $userName        = "postgres";
public $host        	= "127.0.0.1";
public $port        	= "5432";
public $password        = "123";
public $database        = "postgres";
public $encoding        = "AL32UTF8";

	public function __construct() {
		
		$database = $this->type; $this->$database();
	
	}
	
	public function mysql() {
	
		mysql_connect ($this -> host, $this -> userName, $this -> password) or die (mysql_error());
		mysql_select_db ($this -> dbName) or die (mysql_error()); 
	
	}
	
    public function oracle() {
		return oci_connect($this->userName, $this->password, $this->host.'/'.$this->database, $this->encoding);
	}
			
	public function postgres() {
		return pg_connect("host=$this->host port=$this->port dbname=$this->database user=$this->userName password=$this->password");
	}

        
}

?>