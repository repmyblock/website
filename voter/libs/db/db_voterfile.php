<?php
require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/mysql/queries.php";
global $DB;




class VoterFile extends queries {
	
	function __construct($debug = 0, $DBFile = "DB_VoterFile") {
    require $_SERVER["DOCUMENT_ROOT"] . "/../statlib/DBsLogins/" . $DBFile . ".php";
    $DebugInfo["DBFile"] = $DBFile;
    $DebugInfo["DBErrorsFilename"] = $DBErrorsFilename;
    $DebugInfo["Flag"] = $debug;
    parent::__construct($databasename, $databaseserver, $databaseport, $databaseuser, $databasepassword, $sslkeys, $DebugInfo);
  }

	function ListStates() {
		$sql = "SELECT * FROM States ORDER BY States_Name";
		$sql_vars = array();
		return $this->_return_multiple($sql, $sql_vars);
	}


	function SaveSurvey($First, $Last, $Email, $stateid, $CountyName, $zipcode, $BOEexperience, $BOEraw) {
		$sql = "INSERT INTO Survey SET States_ID = :StateID, Survey_FirstName = :FirstName, Survey_LastName = :LastName, " .
						"Survey_CountyName = :CountyName, Survey_Zipcode = :ZIP, Survey_BOEExperience = :BOEExp, " .
						"Survey_BOERequestRaw = :BOERaw, Survey_Email = :Email, Survey_TimeStamp = NOW()";
		$sql_vars = array("StateID" => $stateid, "FirstName" => $First, "LastName" => $Last, 
											"CountyName" => $CountyName, "ZIP" => $zipcode, "BOEExp" => $BOEexperience,
											 "BOERaw" => $BOEraw, "Email" => $Email);
		$this->_return_nothing($sql, $sql_vars);
		
		$sql = "SELECT LAST_INSERT_ID() as Survey_ID";
		return $this->_return_simple($sql);
	}
	
	function SaveLocalBOE($SurveyID, $Name, $URL) {
		$sql = "INSERT INTO LocalBOE SET LocalBOE_URL = :URL, LocalBOE_Name = :Name, Survey_ID = :SurveyID";
		$sql_vars = array("URL" => $URL, "Name" => $Name, "SurveyID" => $SurveyID);
		$this->_return_nothing($sql, $sql_vars);

		$sql = "SELECT LAST_INSERT_ID() as LocalBOE_ID";
		return $this->_return_simple($sql);
	}
	
	function SavePersonal($id, $tendencyid, $partyname, $partywebsite, $partycity) {
		
		if ( empty ($tendencyid)) {
			$tendencyid = 0;
		}
		
		$sql = "INSERT INTO TendencySurvey SET Survey_ID = :id, Political_ID = :tendencyid, " . 
						"TendencySurvey_PartyName = :name, TendencySurvey_PartyWeb = :web, TendencySurvey_PartyCity = :city, " .
						"TendencySurvey_TimeStamp  = NOW()";
		$sql_vars = array("id" => $id, "tendencyid" => $tendencyid, "name" => $partyname, 
											"web" => $partywebsite, "city" => $partycity);
		$this->_return_nothing($sql, $sql_vars);
	}
}

?>