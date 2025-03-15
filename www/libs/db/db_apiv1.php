<?php
require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/mysql/queries.php";
global $DB;

class api_v1 extends queries {

  function api_v1 ($debug = 0, $DBFile = "DB_OutragedDems") {
	  require $_SERVER["DOCUMENT_ROOT"] . "/../statlib/DBsLogins/" . $DBFile . ".php";
	  $DebugInfo["DBErrorsFilename"] = $DBErrorsFilename;
	  $DebugInfo["Flag"] = $debug;
	  
	 	$this->queries($databasename, $databaseserver, $databaseport, $databaseuser, $databasepassword, $sslkeys, $DebugInfo);
  }
 
 function SearchVotersFile($DataSearch) {
   	$sqlquery = ""; $sql_vars = array();
				
		$sql = "SELECT ";
		
		
		$sql .= "DataHouse.DataHouse_ID, DataHouse_Type, DataHouse_Apt, DataDistrictTown.DataDistrictTown_ID, DataStreetNonStdFormat_ID, " . 
						"DataAddress_HouseNumber, DataAddress_FracAddress, DataAddress_PreStreet, DataAddress_PostStreet, " . 
						"DataAddress_zipcode, DataAddress_zip4, DataCounty.DataState_ID, DataState_Abbrev, DataState_Name," . 
						"DataStreet_Name, DataCity_Name, Voters_Gender, Voters_UniqStateVoterID, Voters_RegParty, " . 
						"Voters_Status, Voters_DateInactive, Voters_DatePurged , Voters_RMBActive, Voters_RecFirstSeen, " . 
						"Voters_RecLastSeen, VotersIndexes_Suffix, VotersIndexes_DOB, VotersIndexes_UniqStateVoterID, " . 
						"DataLastName_Text, DataFirstName_Text, DataMiddleName_Text, DataCounty_Name, " .
						"DataDistrict_Electoral, DataDistrict_StateAssembly, DataDistrict_StateSenate, DataDistrict_Legislative, " . 
						"DataDistrict_Ward, DataDistrict_Congress, " .
						"DataHouse_Type, DataHouse_Apt, DataDistrictTown_Name "; 
		
		
		$sql .=	"FROM DataDistrict " .
						"LEFT JOIN DataDistrictTemporal on (DataDistrict.DataDistrict_ID = DataDistrictTemporal.DataDistrict_ID) " .
						"LEFT JOIN DataDistrictCycle on (DataDistrictTemporal.DataDistrictCycle_ID = DataDistrictCycle.DataDistrictCycle_ID) " .
						"LEFT JOIN DataHouse ON (DataHouse.DataHouse_ID = DataDistrictTemporal.DataHouse_ID) " .
						"LEFT JOIN DataAddress ON (DataAddress.DataAddress_ID = DataHouse.DataAddress_ID) " .
						"LEFT JOIN DataCounty ON (DataAddress.DataCounty_ID = DataCounty.DataCounty_ID) " . 
						"LEFT JOIN DataState ON (DataState.DataState_ID = DataCounty.DataState_ID) " .
						"LEFT JOIN DataStreet ON (DataStreet.DataStreet_ID = DataAddress.DataStreet_ID) " .
						"LEFT JOIN DataCity ON (DataCity.DataCity_ID = DataAddress.DataCity_ID) " .
						"LEFT JOIN Voters ON (Voters.DataHouse_ID = DataHouse.DataHouse_ID) " .
						"LEFT JOIN VotersIndexes ON (VotersIndexes.VotersIndexes_ID = Voters.VotersIndexes_ID) " .
						"LEFT JOIN DataLastName ON (DataLastName.DataLastName_ID = VotersIndexes.DataLastName_ID) " .  
						"LEFT JOIN DataFirstName ON (DataFirstName.DataFirstName_ID = VotersIndexes.DataFirstName_ID) " .  
						"LEFT JOIN DataMiddleName ON (DataMiddleName.DataMiddleName_ID = VotersIndexes.DataMiddleName_ID) " .
						"LEFT JOIN DataDistrictTown ON (DataDistrictTown.DataDistrictTown_ID = DataDistrict.DataDistrictTown_ID) " .
						"WHERE (Voters_Status = 'Active' OR Voters_Status = 'Inactive') AND " . 
						"(CURDATE() >= DataDistrictCycle_CycleStartDate AND CURDATE() <= DataDistrictCycle_CycleEndDate) IS NULL";
				 	
		
  	foreach ($DataSearch as $Param => $Search) {
			$sqlquery .= " AND ";
  		switch ($Param) {
  			case "AD": $sqlquery .= "DataDistrict_StateAssembly = :AD"; $sql_vars["AD"] = $Search; break;
  			case "ED": $sqlquery .= "DataDistrict_Electoral = :ED"; $sql_vars["ED"] = $Search; break;
  			case "CD": $sqlquery .= "CountyCode = :CD"; $sql_vars["CD"] = $Search; break;
  			case "LG": $sqlquery .= "LegisDistr = :LG"; $sql_vars["LG"] = $Search; break;
  			case "TW": $sqlquery .= "TownCity = :TW"; $sql_vars["TW"] = $Search; break;
  			case "WD": $sqlquery .= "Ward = :WD"; $sql_vars["WD"] = $Search; break;
  			case "CG": $sqlquery .= "CongressDistr = :CG"; $sql_vars["CG"] = $Search; break;
  			case "SD": $sqlquery .= "SenateDistr = :SD"; $sql_vars["SD"] = $Search; break;
  			case "PT": $sqlquery .= "Voters_RegParty = :PT"; $sql_vars["PT"] = $Search; break;
  			case "VI": $sqlquery .= "Voters_ID = :VI"; $sql_vars["VI"] = $Search; break;
  		}
  	}
  
  	$sql .= $sqlquery; 	
  	WriteStderr($sql, "SearchInRawNYSFile SQL");
  	WriteStderr($sql_vars, "SearchInRawNYSFile SQL VARS");
  	return $this->_return_multiple($sql, $sql_vars);  	
  }
 
}

?>
