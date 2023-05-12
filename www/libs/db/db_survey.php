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
	
	function PullSurveyFromRandomKey($RandomKey) {
		$sql = "SELECT * FROM SurveyPresUser " . 
						"LEFT JOIN SurveyPresDelInfo ON (SurveyPresDelInfo.SurveyPresDelInfo_StateCode = SurveyPresUser.SurveyPresUser_State " . 
						"AND SurveyPresDelInfo.Candidate_ID = SurveyPresUser.Candidate_ID) " . 
						"LEFT JOIN SurveyPresDocuments ON (SurveyPresDocuments.SurveyPresDocuments_Party = SurveyPresDelInfo.SurveyPresDelInfo_Party " .
						"AND SurveyPresDelInfo.SurveyPresDelInfo_StateCode = SurveyPresDocuments.SurveyPresDocuments_StateCode) " . 
						"WHERE SurveyPresUser_RandomKey = :Random";
		return $this->_return_simple($sql, array("Random" => $RandomKey));
	}
	
	function SaveSurvey($data) {
		if ( ! empty ($data)) {
			foreach ($data as $var => $index) {
				if ( ! empty ($index)) {		
					$sql_tables .= $var . ",";
					$sql_values .= ":" . $var . ", ";
					$sql_vals[$var] = $index;
				}
			}
			
			$sql_tables .= "SurveyPresUser_DateTime, SurveyPresUser_IP";
			$sql_values .= "NOW(), :IP";
			$sql_vals["IP"] = $_SERVER['REMOTE_ADDR'];
							
			$sql = "INSERT INTO SurveyPresUser (" . $sql_tables . ") VALUES (" . $sql_values . ")";
			return $this->_return_nothing($sql, $sql_vals);
		}
	}
	
}
?>
