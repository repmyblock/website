<?php
require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/mysql/queries.php";
global $DB;

class survey extends queries {

  function survey ($debug = 0, $DBFile = "DB_OutragedDems") {
	  require $_SERVER["DOCUMENT_ROOT"] . "/../statlib/DBsLogins/" . $DBFile . ".php";
	  $DebugInfo["DBErrorsFilename"] = $DBErrorsFilename;
	  $DebugInfo["Flag"] = $debug;
	  
	 	$this->queries($databasename, $databaseserver, $databaseport, $databaseuser, $databasepassword, $sslkeys, $DebugInfo);
  }
  
  function FindState($CandidateID, $StateInfo) {  	
		return $this->_return_simple("SELECT * FROM SurveyPresDelInfo " . 
						" LEFT JOIN SurveyPresDocuments ON " . 
						"(SurveyPresDocuments_Party = SurveyPresDelInfo_Party AND  SurveyPresDocuments_StateCode = SurveyPresDelInfo_StateCode) " . 
						" WHERE Candidate_ID = :Candidate AND SurveyPresDelInfo_StateCode = :StateCode", 
						array("Candidate" => $CandidateID, "StateCode" => $StateInfo));	
	}
	
	function CheckSurveyRandomKey($RandomKey) {
		return $this->_return_simple("SELECT SurveyPresUser_RandomKey FROM SurveyPresUser WHERE SurveyPresUser_RandomKey = :Random", 
																	array("Random" => $RandomKey));
	}
	
	function SaveSurvey($data) {
		if ( ! empty ($data)) {
			foreach ($data as $var => $index) {
				if ( ! empty ($index)) {		
					$sql_tables .= $comma . $var;
					$sql_values .= $comma . ":" . $var;
					$sql_vals[$var] = $index;
					$comma = ", ";	
				}
			}
			$sql = "INSERT INTO SurveyPresUser (" . $sql_tables . ") VALUES (" . $sql_values . ")";
			print "SQL: $sql<BR>";
			return $this->_return_nothing($sql, $sql_vals);
		}
	}
	
}
?>
