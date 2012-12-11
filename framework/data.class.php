<?php 

namespace framework;

use \framework\connection;

class dataMysqlSelect {

public $column;
public $tableName;
public $whereClause;
public $orderClause;
public $arrayResult;
public $singleResult;
public $whereID;

	public function __construct($column,$tableName,$whereClause,$whereID,$orderClause) {
	
		$this -> column 	= $column;
		$this -> tableName	= $tableName;
		$this -> whereClause	= $whereClause;
		$this -> whereID	= $whereID;
		$this -> orderClause	= $orderClause;
	
	}

	public function selectSingleTable () {
	
		$query	= "SELECT " . $this -> column . " FROM " . $this -> tableName;
		$result	= mysql_query($query) or die (mysql_error());
		
			while ($row = mysql_fetch_assoc($result)) { 
			$array [] = $row;
			}
		
		$this -> arrayResult = $array; 
	
	}
	
	public function selectSingleTableWhereClause () {
	
		$query	= "SELECT " . 
                          $this -> column . " FROM " . 
                          $this -> tableName . " WHERE " . 
                          $this -> whereClause . " = '" . 
                          $this -> whereID . "'";

		$result	= mysql_query($query) or die (mysql_error());
		
			while ($row = mysql_fetch_assoc($result)) { 
			$array [] = $row;
			}
		
		$this -> arrayResult = $array; 
	
	}
	
	
	public function selectSingleTableWhereClauseIsNull () {
		
		$query	= "SELECT " . 
                          $this -> column . " FROM " . 
                          $this -> tableName . " WHERE " . 
                          $this -> whereClause . " " . 
                          $this -> whereID . "";

		$result	= mysql_query($query) or die (mysql_error());
			
			while ($row = mysql_fetch_assoc($result)) { 
			$array [] = $row;
			}
			
		$this   -> arrayResult = $array; 
		
	}
	
	

}

class dataInsert {

}

class dataDelete {

}

class dataUpdate {

}




class dataOracle extends connection {

public $oraConn;
public $column;
public $tableName;
public $whereClause;
public $orderClause;
public $arrayResult;
public $singleResult;
public $content;
public $whereID;
public $language;
public $dateColumn = array("CAP_CON_CREATED");

	public function __construct($column,$tableName,$whereClause,$whereID,$orderClause) {
                
        $this -> oraConn        = oci_connect($this->userName, $this->password, $this->host.'/'.$this->database);
		$this -> column 		= $column;
		$this -> tableName		= $tableName;
		$this -> whereClause	= $whereClause;
		$this -> whereID		= $whereID;
		$this -> orderClause	= $orderClause;
		$this -> language		= self::setDefaultLanguage();
	
	}
	
	public function setDefaultLanguage() {
	
		$query  = "SELECT * FROM CAP_MAIN WHERE CAP_MAI_ID = 1";
		$result = oci_parse($this->oraConn, $query); oci_execute($result);
        $row    = oci_fetch_array($result);
		
		return $row[CAP_MAI_LANGUAGE];

	}
	
	public function oracleCommit() {
		oci_commit($this->oraConn);
	}
	
	public function returnMaxIDFromTable() {
	
		$query  = "SELECT MAX(" . $this->columnMaxID . ") as lastID FROM " . $this->tableName;
		$result = oci_parse($this->oraConn, $query); oci_execute($result);
        $row    = oci_fetch_array($result,OCI_NUM);
		$lastID = $row[0];
		
		return $lastID;
		
	}

}


class dataOracleSelect extends dataOracle {

	public function __construct($column,$tableName,$whereClause,$whereID,$orderClause) {
                
        parent::__construct($column,$tableName,$whereClause,$whereID,$orderClause);
	
	}

	public function selectSingleTable () {
	
		$query	= "SELECT " . $this -> column . " FROM " . $this->schema . "." . $this -> tableName . "";
		$result	= oci_parse($this -> oraConn,$query); oci_execute($result);
		
			while ($row = oci_fetch_array($result, OCI_ASSOC | OCI_RETURN_LOBS)) { 
			$array [] = $row;
			}
		
		$this -> arrayResult = $array; 
		
		$this -> query = $query;

	}
	
	public function selectSingleTableWhereClause () {
    
		$query	= "SELECT " . 
                   $this->column . " FROM " . 
                   $this->schema . "." .
                   $this->tableName . " WHERE " . 
                   $this->whereClause . " = '" . 
                   $this->whereID . "'";
                
                $result	= oci_parse($this -> oraConn, $query); oci_execute($result);
                                
            while ($row = oci_fetch_array($result, OCI_ASSOC | OCI_RETURN_LOBS)) { 
			$array [] = $row;
			}
		                
		$this -> arrayResult = $array; 
		
		$this	-> query;
				
	}
	
	
	public function selectSingleTableWhereClauseIsNull() {
		
		$query	= "SELECT " . 
                   $this->column . " FROM " . 
                   $this->schema . "." .
                   $this->tableName . " WHERE " . 
                   $this->whereClause . " " . 
                   $this->whereID . "";

		$result	= oci_parse($this -> oraConn, $query); oci_execute($result);
			
			while ($row = oci_fetch_array($result, OCI_ASSOC | OCI_RETURN_LOBS)) { 
			$array [] = $row;
			}
			
		$this   -> arrayResult = $array; 
		
		$this	-> query = $query;
	}
	
	public function selectSingleTableWhereOrderByClauseIsNull () {
                            
		$query	= "SELECT " . 
                          $this -> column . " FROM " . 
                          $this->schema . "." . 
                          $this -> tableName . " WHERE " . 
                          $this -> whereClause . " " . 
                          $this -> whereID . " ORDER BY " .
                          $this -> orderClause;

            $result	= oci_parse($this -> oraConn, $query); oci_execute($result);
                                
            while ($row = oci_fetch_array($result, OCI_ASSOC | OCI_RETURN_LOBS)) { 
			$array [] = $row;
			}
		               
		$this -> arrayResult = $array; 
		
		$this -> query = $query;
		
	}

}

class menudata extends dataOracleSelect {
    
    
   public function __construct($column,$tableName,$whereClause,$whereID) {
            
        parent::__construct($column,$tableName,$whereClause,$whereID,"");
            
   }
        
   public static function autoload($className) {
        
         include ROOT_PATH.$className;
            
    }
    

	public function dropDownData ($id,&$menuTree) {
		
            $conn     = $this->oraConn;
            
            $menuTree = array();
            $query    = "SELECT * FROM $this->schema.CAP_MENU
                         LEFT JOIN CAP_MENU_PAGES ON CAP_MENU.CAP_MEN_ID = CAP_MENU_PAGES.CAP_MENU_CAP_MEN_ID
                         LEFT JOIN CAP_PAGES ON CAP_MENU_PAGES.CAP_PAGES_CAP_PAG_ID = CAP_PAGES.CAP_PAG_ID
                         LEFT JOIN CAP_LANGUAGE_COMBINE ON CAP_MENU.CAP_MEN_ID = CAP_LANGUAGE_COMBINE.CAP_LAN_COM_FKID
                         WHERE CAP_MEN_PARENT = $id AND CAP_MEN_ACCESS = 'Public' AND CAP_MEN_STATUS = 'Active' AND
                         CAP_LAN_COM_TYPE = 'menu' AND CAP_LAN_COM_LAN_ID = '$_SESSION[language]'
                         ORDER BY CAP_MEN_POSITION ASC";
		
		if (!empty($id)) {
		
        $result   = oci_parse($conn, $query); oci_execute($result);
		
		while ($row  = oci_fetch_array($result, OCI_ASSOC | OCI_RETURN_LOBS)) {
						
		$array  []	 = array(
		"ID" 		=> $row["CAP_MEN_ID"], 
		"Name" 		=> $row["CAP_LAN_COM_VALUE"], 
		"Path" 		=> $row["CAP_PAG_PATH"], 
		'IMG' 		=> $row["CAP_MEN_IMG"], 
		'Preview' 	=> $row["CAP_MEN_PREVIEW"]);
		$parent 	 = $row["CAP_MEN_ID"];
		$queryChild	 = "SELECT COUNT(*) AS COUNT FROM $this->schema.CAP_MENU WHERE CAP_MEN_PARENT = '$parent'";
		$resultChild     = oci_parse($conn, $queryChild) ; oci_execute($resultChild);
        $rowChild        = oci_fetch_array($resultChild);
        $check		 = $rowChild["COUNT"];

                    if ($check != 0) {
                    $menuTree  [] = array("parent" => $array, "child" => menuData::dropDownData($parent,$array[]));
                    unset($array);
                    }
                    else {
                    $menuTree []  = array("parent" => $array);
                    }
							
                }
               
        }
			
		return $menuTree;
						
	}
        
        
        public function selectFindMenuPath ($page,$lang) {
		
		if ($page == 'admin') {
		
		$queryAdmin  =  "SELECT * FROM $this->schema.CAP_PAGES WHERE CAP_PAG_NAME = 'admin'";

		$resultAdmin = oci_parse($this -> oraConn, $queryAdmin); oci_execute($resultAdmin);
		
		while ($rowAdmin    = oci_fetch_array($resultAdmin, OCI_ASSOC | OCI_RETURN_LOBS)) {
		$this -> pageID		  	= $rowAdmin[CAP_PAG_ID];
		$this -> singleResult 	= $rowAdmin[CAP_PAG_PATH];
		$this -> pagesContainer = $rowAdmin[CAP_PAG_CONTAINER];
		}
		
		return $this;
		}
		
		$query	= "SELECT CAP_MEN_ID FROM $this->schema.CAP_MENU";
		
		$result	= oci_parse($this -> oraConn, $query); oci_execute($result);

			while ($row = oci_fetch_array($result, OCI_ASSOC | OCI_RETURN_LOBS)) {
			$idMenu [] = $row["CAP_MEN_ID"];
			}
        
		$findme   = 'c';
		$pos = strpos($page, $findme);
		        
        	if ($pos === false) {
                   
        	$query  =  "SELECT * FROM $this->schema.CAP_MENU 
                  		LEFT JOIN CAP_MENU_PAGES ON CAP_MENU.CAP_MEN_ID = CAP_MENU_PAGES.CAP_MENU_CAP_MEN_ID 
                  		LEFT JOIN CAP_PAGES ON CAP_MENU_PAGES.CAP_PAGES_CAP_PAG_ID = CAP_PAGES.CAP_PAG_ID 
                  		LEFT JOIN CAP_CONTENT ON CAP_MENU.CAP_CONTENT_CAP_CON_ID = CAP_CONTENT.CAP_CON_ID WHERE CAP_MEN_ID = '$this->whereID'";
            
        	}
        	
        	else {
        	
        	$this->whereID = strstr($page,'c', true);
        	
        	$query  =  "SELECT * FROM $this->schema.CAP_CONTENT
                  		LEFT JOIN CAP_PAGES ON CAP_CONTENT.CAP_CON_PAGES = CAP_PAGES.CAP_PAG_ID
                  		WHERE CAP_CON_ID = '$this->whereID'";
            
        	}
                                          
        $result = oci_parse($this -> oraConn, $query); oci_execute($result);
        
		while ($row	= oci_fetch_array($result, OCI_ASSOC | OCI_RETURN_LOBS)) {
		
		$pathID	= $row[CAP_PAG_ID];
		$path	= $row[CAP_PAG_PATH];
		$pagesc	= $row[CAP_PAG_CONTAINER];
		$id     = $row[CAP_CON_ID];
				
		}
		
		
		$queryContent  = "SELECT * FROM $this->schema.CAP_LANGUAGE_COMBINE WHERE CAP_LAN_COM_FKID = '$id' 
				   		  AND CAP_LAN_COM_LAN_ID = '" . $_SESSION['language'] . "' AND CAP_LAN_COM_TYPE = 'content'
				   		  ORDER BY CAP_LAN_COM_COLUMN DESC";

		$resultContent = oci_parse($this -> oraConn, $queryContent); oci_execute($resultContent);
			
			while ($rowContent = oci_fetch_array($resultContent, OCI_ASSOC | OCI_RETURN_LOBS)) {
			
			$i++;

				if ($i != 1) {$con = $rowContent[CAP_LAN_COM_VALUE];} else {$hea = $rowContent[CAP_LAN_COM_VALUE];}
			
			}
				
		$check = oci_num_rows($result); $checkContent = oci_num_rows($resultContent);
				
			if ($page == '') {
			$this -> singleResult = ROOT_PATH."view/pages/default/index.php";
			}
			else if ($page != '' && $check == 0) {
			$this -> singleResult = ROOT_PATH."view/pages/404-Error/index.php";
			}
			else {
			$this -> contentID	  	= $id;
			$this -> pageID		  	= $pathID;
			$this -> pagesContainer = $pagesc;
			$this -> singleResult 	= $path; 
            $this -> header      	= $hea;
            $this -> content      	= $con;
            $this -> check 			= $checkContent;
			}
			
        return $this;
                        
		}
   
	
}


class dataOracleUpdate extends dataOracle {

	public function __construct($column,$tableName,$whereClause,$whereID,$orderClause) {
                
        parent::__construct($column,$tableName,$whereClause,$whereID,$orderClause);
	
	}
	
	public function updateContent() {
		
		$query = "UPDATE " . $this->schema . "." . $this->tableName . " SET ";
		
		foreach ($this->column as $key => $value) {
			$query .= $key. "= :" . str_replace("\"","",$key) . ",";
			$bind[$key] = $value;
		}
		
		$query  = substr($query, 0, -1);
		
		$query .= " WHERE " . $this->whereClause . "=" . $this->whereID;
				
		$result	= oci_parse($this->oraConn, $query); 
		
		$clob   = oci_new_descriptor($this->oraConn, OCI_D_LOB);
		
		foreach ($bind as $key => $value) {
			if ($key != "CAP_CON_CONTENT") {
			$header   = ":$key"; $headerVal  = $value;
			}
			else {
			$content  = ":$key"; $contentVal = $value;
			}
		}
				
		oci_bind_by_name($result, $header, $headerVal);
		
		oci_bind_by_name($result, $content, $clob, -1, OCI_B_CLOB);
		
		$clob->writeTemporary($contentVal,OCI_TEMP_CLOB);
		
		$status = oci_execute($result,OCI_DEFAULT);
		
			if ($clob->writeTemporary($contentVal,OCI_TEMP_CLOB)) {
			OCICommit($this->oraConn); echo 1;
			}
				
	}
	
	public function updateSingleColumnWhereID() {
		
		$query = "UPDATE " . $this->schema . "." . $this->tableName . " SET ";
		
			foreach ($this->column as $key => $value) {
			$query .= $key . ",";
			}
		
		$query  = substr($query, 0, -1);
		
		$query .= " = ";
		
			foreach ($this->column as $key => $value) {
			$query .= ":$key,"; $content = ":$key"; $contentVal = $value;
			}
			
		$query  = substr($query, 0, -1);
		
		$query .= " WHERE " . $this->whereClause . " = " . $this->whereID;
				
		$result	= oci_parse($this->oraConn, $query); 
		
		$clob   = oci_new_descriptor($this->oraConn, OCI_D_LOB);
		
		oci_bind_by_name($result, $content, $clob, -1, OCI_B_CLOB);
		
		$clob->writeTemporary($contentVal,OCI_TEMP_CLOB);
		
		$status = oci_execute($result,OCI_DEFAULT);
				
			if ($clob->writeTemporary($contentVal,OCI_TEMP_CLOB)) {
			OCICommit($this->oraConn);
			}
		
		echo $query;
	}
	
	public function updateMultipleRowMultipleWhere() {
		
		$query = "UPDATE " . $this->schema . "." . $this->tableName . " SET ";
		
			foreach ($this->column as $key => $value) {
			$query .= $key . " = :$key,";
			}
		
		$query  = substr($query, 0, -1);
		
		$query .= " WHERE " . $this->whereClause;
				
		$result	= oci_parse($this->oraConn, $query); 
		
			foreach ($this->column as $key => $value) {
			oci_bind_by_name($result, ":" . $key, $this->column[$key]);
			}
			
		$status = oci_execute($result);
						

	}
	
	public function updateMultipleRowWhereID() {
		
		$query = "UPDATE " . $this->schema . "." . $this->tableName . " SET ";
		
			foreach ($this->column as $key => $value) {
			$query .= $key . " = :$key,";
			}
		
		$query  = substr($query, 0, -1);
		
		$query .= " WHERE " . $this->whereClause . " = " . $this->whereID;
				
		$result	= oci_parse($this->oraConn, $query); 
		
			foreach ($this->column as $key => $value) {
			oci_bind_by_name($result, ":" . $key, $this->column[$key]);
			}
			
		$status = oci_execute($result);
		
		$this->query = $query;						

	}


}


class dataOracleInsert extends dataOracle {

	public function __construct($column,$tableName,$whereClause,$whereID,$orderClause) {
                
        parent::__construct($column,$tableName,$whereClause,$whereID,$orderClause);
	
	}
	
	public function insertMultipleRowWhereID() {
		
		$query = "INSERT INTO " . $this->schema . "." . $this->tableName . " (";
		
			foreach ($this->column as $key => $value) {
			$query .= $key . ",";
			}
		
		$query  = substr($query, 0, -1); $query .= ")"; $query .= "VALUES (";
		
			foreach ($this->column as $key => $value) {
			
				if (in_array($key,$this->dateColumn)) {
				$query .= "to_date(:" . $key . ",'yyyy-mm-dd HH24:MI:SS'),";
				}
				else {
				$query .= ":$key" . ",";
				}
			
			}
		
		$query  = substr($query, 0, -1); $query .= ")";
				
		$result	= oci_parse($this->oraConn, $query); 
		
			foreach ($this->column as $key => $value) {
			oci_bind_by_name($result, ":" . $key, $this->column[$key]);
			}
			
		$status = oci_execute($result); 

	}
	
	public function insertRowToTable() {
		
		$query = "INSERT INTO " . $this->schema . "." . $this->tableName . " (";
		
			foreach ($this->column as $key => $value) {
			$query .= $key . ",";
			}
		
		$query  = substr($query, 0, -1); $query .= ")"; $query .= "VALUES (";
		
			foreach ($this->column as $key => $value) {
				if (in_array($key,$this->dateColumn)) {
				$query .= "to_date(:" . $key . ",'yyyy-mm-dd HH24:MI:SS'),";
				}
				else {
				$query .= ":$key" . ",";
				}
			}
		
		$query  = substr($query, 0, -1); $query .= ")";
				
		$result	= oci_parse($this->oraConn, $query); 
		
			foreach ($this->column as $key => $value) {
			oci_bind_by_name($result, ":" . $key, $this->column[$key]);
			}
			
		$status = oci_execute($result);	

	}
	
	public function insertContentReturnLastID() {
		
		$query = "INSERT INTO " . $this->schema . "." . $this->tableName . "(";
		
		foreach ($this->column as $key => $value) {
			$query .= $key . ",";
		}
		
		$query  = substr($query, 0, -1);
		
		$query .= ") VALUES (";
		
		foreach ($this->column as $key => $value) {
		
			if ($key != "CAP_CON_CONTENT" && $key != "CAP_CON_HEADER") {
				if ($key == "CAP_USER_CAP_USE_ID") { 
				$query .= 1 . ",";
				}
				else if ($key == "FK_CAP_CONTENT_CATEGORY") { 
				$query .= 1 . ",";
				}
				else if ($key == "CAP_CON_CREATED") { 
				$query .= "to_date('" . date("Y-m-d",time()) . "','yyyy-mm-dd'),";
				}
				else if ($key == "CAP_CON_PUBLISHED") { 
				$query .= "'N'" . ",";
				}

			}
			else {
			$query .= ":" . $key . ",";
			$bind[$key] = $value;
			}
			
		}
		
		$query  = substr($query, 0, -1);
		
		$query .= ")";
						
		$result	= oci_parse($this->oraConn, $query); 
		
		$clob   = oci_new_descriptor($this->oraConn, OCI_D_LOB);
		
		foreach ($bind as $key => $value) {
			if ($key != "CAP_CON_CONTENT") {
			$header   = ":$key"; $headerVal  = $value;
			oci_bind_by_name($result, $header, $headerVal);
			}
			else {
			$content  = ":$key"; $contentVal = $value;
			}
		}
						
		oci_bind_by_name($result, $content, $clob, -1, OCI_B_CLOB);
		
		$clob->writeTemporary($contentVal,OCI_TEMP_CLOB);
		
		$status = oci_execute($result,OCI_DEFAULT);

			if ($clob->writeTemporary($contentVal,OCI_TEMP_CLOB)) {
			$queryLastID = "SELECT MAX(CAP_CON_ID) as lastID FROM " . $this->schema . ".CAP_CONTENT";
			$resultLastID	= oci_parse($this -> oraConn, $queryLastID); oci_execute($resultLastID);
            $rowLastID = oci_fetch_array($resultLastID);
			$lastID = $rowLastID[0];
			OCICommit($this->oraConn); echo 1;
			}
		
		return $lastID;
		
	}
	
	public function updateMenuLinkToLastInsertedContent($lastID,$menuID) {
		if (empty($lastID)) {return;}
		$query = "UPDATE " . $this->schema . ".CAP_MENU SET CAP_CONTENT_CAP_CON_ID = $lastID WHERE CAP_MEN_ID = $menuID";
		$result	= oci_parse($this -> oraConn, $query); $execute = oci_execute($result);
	}

}


class dataOracleDelete extends dataOracle {

	public function __construct($column,$tableName,$whereClause,$whereID,$orderClause) {
                
        parent::__construct($column,$tableName,$whereClause,$whereID,$orderClause);
	
	}
	
	public function deleteRow() {
	
		$query  = "DELETE FROM " . $this->schema . "." . $this->tableName . " WHERE " . $this->whereClause . " = " . $this->whereID;
		
		$result	= oci_parse($this->oraConn, $query); oci_execute($result);
	
	}
	
	public function deleteRowMultipleWhere() {
	
		$query  = "DELETE FROM " . $this->schema . "." . $this->tableName . " WHERE " . $this->whereClause;
		
		$result	= oci_parse($this->oraConn, $query); oci_execute($result);
	
	}

}



?>