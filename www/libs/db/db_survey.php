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
	
	function SaveSurvey($data) {
		
		
		
		foreach ($data as $var => $index) {
			
			print "VAR: $var => $index<BR>\n";
			
			
			
			
		}
		
		/*
		"State" => $matches[1][0], "FirstName" => $_POST["FirstName"], "LastName" => $_POST["LastName"],
									"County" => $_POST["County"], "ZipCode" => $_POST["ZipCode"],"Partisan_DemCounty" => $_POST["Partisan_DemCounty"],
									"Partisan_ClubMember" => $_POST["Partisan_ClubMember"],"Partisan_RanForOffice" => $_POST["Partisan_RanForOffice"],
									"Partisan_ElectedToOffice" => $_POST["Partisan_ElectedToOffice"], "Partisan_Never" => $_POST["Partisan_Never"],
									"DelegateStatus_AOCDelegate" => $_POST["DelegateStatus_AOCDelegate"], "DelegateStatus_WouldloveToBe" => $_POST["DelegateStatus_WouldloveToBe"],
									"DelegateStatus_VolunteerFor" => $_POST["DelegateStatus_VolunteerFor"], "DelegateStatus_TimeToRead" => $_POST["DelegateStatus_TimeToRead"],
									"DelegateStatus_WasDelegate" => $_POST["DelegateStatus_WasDelegate"],"Affirmative_AfricanAmerican" => $_POST["Affirmative_AfricanAmerican"],
									"Affirmative_Hispanic" => $_POST["Affirmative_Hispanic"],"Affirmative_AsianPacific" => $_POST["Affirmative_AsianPacific"],
									"Affirmative_Disability" => $_POST["Affirmative_Disability"],"Affirmative_LGBT" => $_POST["Affirmative_LGBT"] ,
									"Affirmative_Youth" => $_POST["Affirmative_Youth"],"Age" => $_POST["Age"]);
									
									Affirmative_NativeAmerica
		
		return $this->nothing();
		*/
	}
	
}
?>
