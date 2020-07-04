<?php
require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/mysql/queries.php";
global $DB;

class runwithme extends queries {

  function runwithme ($debug = 0, $DBFile = "DB_OutragedDems") {
	  require $_SERVER["DOCUMENT_ROOT"] . "/../statlib/DBsLogins/" . $DBFile . ".php";
	  $DebugInfo["DBErrorsFilename"] = $DBErrorsFilename;
	  $DebugInfo["Flag"] = $debug;
	 	$this->queries($databasename, $databaseserver, $databaseport, $databaseuser, $databasepassword, $sslkeys, $DebugInfo);
  }
  
  function FindVoter($FirstName, $LastName, $DatedFile) {  	
  	$CompressedFirstName = preg_replace("/[^a-zA-Z]+/", "", $FirstName);
		$CompressedLastName = preg_replace("/[^a-zA-Z]+/", "", $LastName);

		$sql = "SELECT * FROM VotersIndexes " . 
						"LEFT JOIN VotersFirstName ON (VotersIndexes.VotersFirstName_ID = VotersFirstName.VotersFirstName_ID) " .
						"LEFT JOIN VotersLastName ON (VotersIndexes.VotersLastName_ID = VotersLastName.VotersLastName_ID) " .
						"LEFT JOIN " . $DatedFile . " AS DF ON (DF.Raw_Voter_UniqNYSVoterID = VotersIndexes.VotersIndexes_UniqNYSVoterID) " . 
						"WHERE VotersFirstName_Compress = :FirstNameCompressed AND VotersLastName_Compress = :LastNameCompressed";
		$sql_vars = array("FirstNameCompressed" => $CompressedFirstName, "LastNameCompressed" => $CompressedLastName);
		return $this->_return_multiple($sql, $sql_vars);	
	} 
	
}


?>
