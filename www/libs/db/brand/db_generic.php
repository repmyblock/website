<?php
require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/db/db_repmyblock.php";
global $DB;

class generic extends RepMyBlock {

  function SaveContacts($Brand, $FirstName, $LastName, $Email, $Telephone, $VoterID) {
  	$ret = $this->SaveVoterRequest($FirstName, $LastName, NULL, NULL, $Email, $Telephone, $VoterID, $_SERVER['SERVER_ADDR'], $Brand);
  	return $ret["SystemUserQuery_ID"];
  }
  
  function QueryVoter($Brand, $FirstName, $LastName) {  	
  	
  	$this->SaveVoterRequest($FirstName, $LastName, NULL, NULL, NULL, NULL, NULL, $_SERVER['SERVER_ADDR'], $Brand);
  	
  	$CompressedFirstName = preg_replace("/[^a-zA-Z]+/", "", $FirstName);
		$CompressedLastName = preg_replace("/[^a-zA-Z]+/", "", $LastName);
		
		$sql = "SELECT * FROM VotersIndexes " . 
						"LEFT JOIN DataFirstName ON (VotersIndexes.DataFirstName_ID = DataFirstName.DataFirstName_ID) " .
						"LEFT JOIN DataLastName ON (VotersIndexes.DataLastName_ID = DataLastName.DataLastName_ID) " .
						"LEFT JOIN Voters ON (Voters.VotersIndexes_ID = VotersIndexes.VotersIndexes_ID) " .
						"LEFT JOIN DataHouse ON (Voters.DataHouse_ID = DataHouse.DataHouse_ID) " .
						"LEFT JOIN DataAddress ON (DataHouse.DataAddress_ID = DataAddress.DataAddress_ID) " .
						"LEFT JOIN DataStreet ON (DataAddress.DataStreet_ID = DataStreet.DataStreet_ID) " .
						"WHERE DataFirstName_Compress = :FirstNameCompressed AND DataLastName_Compress = :LastNameCompressed";
												
		$sql_vars = array("FirstNameCompressed" => $CompressedFirstName, "LastNameCompressed" => $CompressedLastName);
		return $this->_return_multiple($sql, $sql_vars);	
	}
}
?>
