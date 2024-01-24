<?php	  	
require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/db/db_repmyblock.php";  

global $DB;
class Objections extends RepMyBlock {
  
  function CreateNewObjectionFolder($VolumeID, $NumberSheets = 0) {
  	$sql = "INSERT INTO Objections SET Objections_VolumeID = :VolID";
  	$sql_vars = array("VolID" => $VolumeID);
  	
  	if ( $NumberSheets > 0) {
  		$sql .= ", Objections_SheetsNumber = :Sheets";
  		$sql_vars["Sheets"] = $NumberSheets;
  	}
  	
  	$sql .= ", Objections_Created = NOW()";
  	$this->_return_nothing($sql, $sql_vars);
  	
  	$sql = "SELECT LAST_INSERT_ID() as ObjectionsID";
  	return $this->_return_simple($sql)["ObjectionsID"];
  }
  
  function ListOjbections($Objections_ID = NULL) {
  	$sql = "SELECT * FROM Objections";
  	$sql_vars = array();
  	
  	if ( $Objections_ID > 0) {
  		$sql .= " WHERE Objections_ID = :OjbID";
  		$sql_vars["OjbID"] = $Objections_ID;
  	}
  	return $this->_return_multiple($sql, $sql_vars);
  }
  
  function AddObjectionDetail($Objections_ID, $Details) {
  	
  	$sql_query = "ObjectionsDetails SET ".
  					"Objections_ID = :ObjectID, ".
  					"Voter_ID = :VoterID, ObjectionsDetails_Sheet = :Sheet, ObjectionsDetails_Line = :Line";

  
  	if ( ! empty ($Details) && $Objections_ID > 0) {
	  	foreach ($Details as $var) {
  			if ( ! empty($var)) {
  				$sql_vars = array("ObjectID" => $Objections_ID, "VoterID" => $var["VoterID"], 
  													"Sheet" => $var["Sheet"], "Line" => $var["Line"]);
  													
  				if ($var["Type"] == "update") {
  					$sql = "UPDATE " . $sql_query . " WHERE ObjectionsDetails_ID = :DetailID";
  					$sql_vars["DetailID"] = $var["ObjID"];
  				} else {
  					$sql = "INSERT INTO " . $sql_query;
  				}
   																			
  				$this->_return_nothing($sql, $sql_vars);		
  				
  			}
  		}
  	}
  	  	
	}

  function ListObjectionsDetails($Objections_ID = NULL) {
  	$sql = "SELECT * FROM ObjectionsDetails";
  	$sql_vars = array();
  	
  	if ( $Objections_ID > 0) {
  		$sql .= " WHERE Objections_ID = :OjbID";
  		$sql_vars["OjbID"] = $Objections_ID;
  	}
  	return $this->_return_multiple($sql, $sql_vars);
  }
  
}
?>
