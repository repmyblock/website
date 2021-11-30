<?php	  	
require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/mysql/queries.php";
global $DB;

class bugs extends queries {

  function bugs ($debug = 0, $DBFile = "DB_OutragedDems") {
	  require $_SERVER["DOCUMENT_ROOT"] . "/../statlib/DBsLogins/" . $DBFile . ".php";
	  $DebugInfo["DBErrorsFilename"] = $DBErrorsFilename;
	  $DebugInfo["Flag"] = $debug;
	  $this->queries($databasename, $databaseserver, $databaseport, $databaseuser, $databasepassword, $sslkeys, $DebugInfo);
  }
  
  function ListSurveyCategories($SystemUserID) {
  	$sql = "SELECT * FROM TeamMemberOrg " .
  					"LEFT JOIN SurveyCategory ON (TeamMemberOrg.TeamMember_ID = SurveyCategory.TeamMember_ID) " .
  					"LEFT JOIN SurveyValues ON (TeamMemberOrg.TeamMember_ID = SurveyValues.TeamMember_ID " . 
  					"AND SurveyCategory.SurveyCategory_ID = SurveyValues.SurveyCategory_ID) " .
  					"WHERE TeamMemberOrg.SystemUser_ID = :SystemUserID";
  	$sql_vars = array("SystemUserID" => $SystemUserID);
  	return $this->_return_multiple($sql, $sql_vars);	
  }
  
  
  
}

?>

