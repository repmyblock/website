<?php
require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/db/db_repmyblock.php";  
global $DB;

class RMBAdmin extends RepMyBlock {
	
	function ListAllAdminCodes() {
		$sql = "SELECT * FROM AdminCode";							
		return $this->_return_multiple($sql);
	}

	
	function UpdateBulkSystemPriv($PrivModification, $SystemUserID = NULL) {
		
		$sql = "UPDATE SystemUser SET SystemUser_Priv = SystemUser_Priv";
		if ($PrivModification >= 0) { $sql .= " | ";
		} else { $sql .= " & ~"; }
			$sql .= ":AddPriv ";
			$sql_vars = array("AddPriv" => $PrivModification);
			$sql .= "WHERE SystemUser_Priv != 4294967295 ";
		
		if ( $SystemUserID > 0 ) {
			$sql .= "AND SystemUser_ID = :SystemID";
			$sql_vars["SystemID"] = $SystemUserID;
		}

		return $this->_return_nothing($sql, $sql_vars);
	}	
	
	function ReturnTeamMembership($SystemUserID) {
		$sql = "SELECT * FROM TeamMember WHERE SystemUser_ID = :SysID";	
		$sql_vars = array("SysID" => $SystemUserID);
		return $this->_return_multiple($sql, $sql_vars);
	}
	
	function ReturnTeamInformation($TeamID) {
		$sql = "SELECT * FROM TeamMember " . 
						"LEFT JOIN SystemUser ON (TeamMember.SystemUser_ID = SystemUser.SystemUser_ID) " . 
						"LEFT JOIN Team ON (Team.Team_ID = TeamMember.Team_ID) " . 
						"LEFT JOIN Voters ON (Voters.Voters_UniqStateVoterID = SystemUser.Voters_UniqStateVoterID) " .
						"LEFT JOIN DataHouse ON (Voters.DataHouse_ID = DataHouse.DataHouse_ID) " .
						"LEFT JOIN DataDistrictTown ON (DataHouse.DataDistrictTown_ID = DataDistrictTown.DataDistrictTown_ID) " .
						"LEFT JOIN DataDistrictTemporal ON (DataHouse.DataHouse_ID = DataDistrictTemporal.DataHouse_ID) " .
						"LEFT JOIN DataDistrict ON (DataDistrict.DataDistrict_ID = DataDistrictTemporal.DataDistrict_ID) " .
						"WHERE TeamMember.Team_ID = :TeamID";	
		$sql_vars = array("TeamID" => $TeamID);
		return $this->_return_multiple($sql, $sql_vars);
	}
		
	function ListsTeams($TeamID = NULL, $StartAt = NULL, $NumberOfLine = 20){
		$sql = "SELECT * ";
		
		if (! empty ($TeamID)) {
			$sql 	.= ", SystemUser.SystemUser_FirstName AS MasterFirst, SystemUser.SystemUser_LastName AS MasterLast, " .
								"UserNotif.SystemUser_FirstName as NotifFirst, UserNotif.SystemUser_LastName as NotifLast ";
		}
		
		$sql 	.= "FROM Team LEFT JOIN SystemUser ON (Team.SystemUser_ID = SystemUser.SystemUser_ID) ";
		
		if (! empty ($TeamID)) {
			$sql 	.= "LEFT JOIN AdminNotif ON (Team.Team_ID = AdminNotif.Team_ID) " .
								"LEFT JOIN SystemUser AS UserNotif ON (UserNotif.SystemUser_ID = AdminNotif.SystemUser_ID) ";
			$sql .= "WHERE Team.Team_ID = :TeamID";
				
			$sql_vars = array("TeamID" => $TeamID);
			return $this->_return_multiple($sql, $sql_vars);
		}	
		
		if ( ! empty ($StartAt)) {
			$sql .= " LIMIT " . $StartAt . ", " . ( $NumberOfLine + 1 );
		} else {
			$sql .= " LIMIT 0, " . ($NumberOfLine + 1);
		}
					
		return $this->_return_multiple($sql);
	}
	
	function SearchUsers($Query = NULL) {
		if (! is_array($Query) || empty ($Query)) {
			return parent::SearchUsers($Query);
		}
	
		// echo "<PRE>" . print_r($Query,1) . "</PRE>";
		$sql = "SELECT * FROM SystemUser ";
		if (! empty ($Query["username"])) {
			$sql .= "WHERE SystemUser_username LIKE :Username"; $sql_vars["Username"] = "%" . $Query["username"] . "%";
			return $this->_return_multiple($sql, $sql_vars);		
		}
		
		if (! empty ($Query["email"])) {
			$sql .= "WHERE SystemUser_email LIKE :Email"; $sql_vars["Email"] = "%" . $Query["emai"] . "%";
			return $this->_return_multiple($sql, $sql_vars);		
		}
		
		if (! empty ($Query["firstname"])) {
			$sql .= "WHERE SystemUser_FirstName LIKE :FirstName"; $sql_vars["FirstName"] = "%" . $Query["firstname"] . "%";
			return $this->_return_multiple($sql, $sql_vars);		
		}
		
		if (! empty ($Query["lastname"])) {
			$sql .= "WHERE SystemUser_LastName LIKE :LastName"; $sql_vars["LastName"] = "%" . $Query["lastname"] . "%";
			return $this->_return_multiple($sql, $sql_vars);		
		}
		
		if (! empty ($Query["zip"])) {
			$sql .= "LEFT JOIN Voters ON (Voters.Voters_UniqStateVoterID = SystemUser.Voters_UniqStateVoterID) " .
							"LEFT JOIN DataHouse ON (Voters.DataHouse_ID = DataHouse.DataHouse_ID) " .
							"LEFT JOIN DataAddress ON (DataAddress.DataAddress_ID = DataHouse.DataAddress_ID) ".
							"WHERE DataAddress_zipcode = :Zipcode";
			$sql_vars["Zipcode"] = $Query["zip"];
			return $this->_return_multiple($sql, $sql_vars);		
		}
	}
	
	function SearchTempUsers($Query = NULL) {
		if (! is_array($Query) || empty ($Query)) {
			return parent::SearchTempUsers($Query);
		}
		
		if ( ! empty ($Query["email"])) {
			$sql = "SELECT * FROM SystemUserTemporary WHERE SystemUserTemporary_email LIKE :Email";
			$sql_vars["Email"] = "%" . $Query["email"] . "%";
			echo "sql: $sql<BR>";
			return $this->_return_multiple($sql, $sql_vars);
		}		
	}
	
	function AdminSearchVoterDB($QueryFields) {		
		$CompressedFirstName = preg_replace("/[^a-zA-Z]+/", "", $QueryFields["FirstName"]);
		$CompressedLastName = preg_replace("/[^a-zA-Z]+/", "", $QueryFields["LastName"]);
		
		$sql_vars = array();
		
		$sql = "SELECT ";
		
 		$sql .= "* ";
		
//		$sql .= "VotersIndexes.VotersIndexes_ID, VotersIndexes_DOB, DataFirstName_Text, DataMiddleName_Text, DataLastName_Text, " .
//						"Voters_Gender, Voters_UniqStateVoterID, Voters_RegParty, Voters_ReasonCode, Voters_Status, " .
//						"Voters_CountyVoterNumber, Voters_RecFirstSeen, Voters_RecLastSeen, DataAddress_HouseNumber " . 
//						"";
		
		$sql .= "FROM VotersIndexes " .
						"LEFT JOIN DataFirstName ON (DataFirstName.DataFirstName_ID = VotersIndexes.DataFirstName_ID ) " . 
						"LEFT JOIN DataLastName ON (DataLastName.DataLastName_ID = VotersIndexes.DataLastName_ID ) " .
						"LEFT JOIN DataMiddleName ON (DataMiddleName.DataMiddleName_ID = VotersIndexes.DataMiddleName_ID ) " .
						"LEFT JOIN Voters ON (Voters.VotersIndexes_ID = VotersIndexes.VotersIndexes_ID) " . 
						"LEFT JOIN DataHouse ON (DataHouse.DataHouse_ID = Voters.DataHouse_ID) " .
						"LEFT JOIN DataAddress ON (DataAddress.DataAddress_ID = DataHouse.DataAddress_ID) " .
						"LEFT JOIN DataStreet ON (DataStreet.DataStreet_ID = DataAddress.DataStreet_ID) " . 
						"LEFT JOIN DataCity ON (DataAddress.DataCity_ID = DataCity.DataCity_ID) " . 
						"LEFT JOIN DataCounty ON (DataAddress.DataCounty_ID = DataCounty.DataCounty_ID) " . 
						"LEFT JOIN DataState ON (DataState.DataState_ID = DataCounty.DataState_ID) " . 
						"LEFT JOIN DataDistrictTown ON (DataHouse.DataDistrictTown_ID = DataDistrictTown.DataDistrictTown_ID) " . 
						"LEFT JOIN DataDistrictTemporal ON (DataDistrictTemporal.DataHouse_ID = DataHouse.DataHouse_ID) " . 
						"LEFT JOIN DataDistrict ON (DataDistrict.DataDistrict_ID = DataDistrictTemporal.DataDistrict_ID ) " . 
						"WHERE " ;
						
						
		$and = "";
		foreach ($QueryFields as $var => $index) {			
			if ( ! empty ($index)) {
				switch ($var)	{
					case 'LastName':
						$sql .= $and . " DataLastName_Compress = :LastName";
						$sql_vars["LastName"] = $CompressedLastName;
						break;
					
					case 'FirstName':
						$sql .= $and . " DataFirstName_Compress = :FirstName";
						$sql_vars["FirstName"] = $CompressedFirstName;
						break;
						
				 	case 'ResZip':
				 		$sql .= $and . " DataAddress_zipcode = :ResZip";
						$sql_vars["ResZip"] = $index;
						break;
						
					case 'UniqNYSVoterID':
						$sql .= $and . " VotersIndexes_UniqStateVoterID = :UniqNYS";
						$sql_vars["UniqNYS"] = $index;
						break;
					
					
					case 'AssemblyDistr':
						$sql .= $and . " DataDistrict_StateAssembly = :AD";
						$sql_vars["AD"] = $index;
						break;
						
					case 'ElectDistr':
						$sql .= $and . " DataDistrict_Electoral = :ED";
						$sql_vars["ED"] = $index;
						break;
								
					case 'CongressDistr':
						$sql .= $and . " DataDistrict_Congress = :CD";
						$sql_vars["CD"] = $index;
						break;
						
					case 'EnrollPolParty':
						$sql .= $and . " Voters_RegParty = :Party";
						$sql_vars["Party"] = $index;
						break;
						
					case 'HouseNumber':
						$sql .= $and . " DataAddress_HouseNumber = :House";
						$sql_vars["House"] = $index;
						break;
						
					case 'Address':
						$sql .= $and . " DataStreet_Name = :Add";
						$sql_vars["Add"] = $index;
						break;
						
						
//					case 'RetReturnCOUNTY':
//						$sql .= $and . " DataDistrict_Electoral = :ED";
//						$sql_vars["ED"] = $index;
//						break;
					
					

				}
						


//			VAR: UniqNYSVoterID INDEX:
//			VAR: FirstName INDEX: Theo
//			VAR: LastName INDEX: Chino
//			VAR: ResZip INDEX: 10031
//			VAR: CountyCode INDEX:
//			VAR: EnrollPolParty INDEX:
//			VAR: AssemblyDistr INDEX:
//			VAR: ElectDistr INDEX:
//			VAR: CongressDistr INDEX: 
			
				$and = " AND ";
			}
		}				
							
							
		WriteStderr($sql_vars, "SQL Vars");	
		if ( empty ($sql_vars)) {
		
			return;
		}
											
		WriteStderr($sql, "SQL request");			
		return $this->_return_multiple($sql, $sql_vars);		
		
	}
	
	
	function FindPositionsByED($ElectionID, $ADED ) {
		$sql = "SELECT * FROM ElectionsDistrictsConv " . 
						"LEFT JOIN ElectionsPosition ON (ElectionsPosition.ElectionsPosition_ID = ElectionsDistrictsConv.ElectionsPosition_ID) " .
						"LEFT JOIN Candidate ON (ElectionsPosition.ElectionsPosition_DBTable = Candidate.CandidateElection_DBTable " . 
						"AND ElectionsDistrictsConv.ElectionsDistricts_DBTableValue = Candidate.CandidateElection_DBTableValue) " . 
						"LEFT JOIN Team ON (Team.Team_ID = Candidate.Team_ID) " .
						"WHERE ElectionsDistrictsConv_DBTable = :TYPE AND " . 
						"ElectionsDistrictsConv_DBTableValue  = :ADED AND Elections_ID = :ElectID AND Candidate_ID IS NOT NULL";
		$sql_vars = array("TYPE" => "ADED", "ADED" => $ADED, "ElectID" => $ElectionID);
		#return $this->_return_multiple($sql, $sql_vars);
	}				

function FindPositionsInSame($ElectionsID, $TeamID, $CandidateID ) {
		$sql = "SELECT Can2.Candidate_ID as FindCandidate_ID, Can2.Candidate_DispName as FindCandidate_DispName, " .
						"Can2.Candidate_ID as FindCandidate_Candidate_ID, Can2.SystemUser_ID as FindCandidate_SystemUser_ID,  " .
						"Can2.Team_ID as FindCandidate_Team_ID, Can2.CandidateProfile_ID as FindCandidate_CandidateProfile_ID, " . 
						"Can2.Candidate_PetitionNameset as FindCandidate_PetitionNameset, Can2.Candidate_UniqStateVoterID as FindCandidate_UniqStateVoterID,  " .
						"Can2.DataCounty_ID as FindCandidate_DataCounty_ID, Can2.Voters_ID as FindCandidate_Voters_ID, " . 
						"Can2.CandidateElection_ID as FindCandidate_CandidateElection_ID,  " .
						"Can2.Candidate_Party as FindCandidate_Party, Can2.Candidate_FullPartyName as FindCandidate_FullPartyName, " . 
						"Can2.CandidatePartySymbol_ID as FindCandidate_PartySymbol_ID,  " .
						"Can2.Candidate_DisplayMap as FindCandidate_DisplayMap, Can2.Candidate_DispName as FindCandidate_DispName, " . 
						# "Can2.Candidate_DispResidence as FindCandidate_DispResidence, " .
						"Can2.CandidateElection_DBTable as FindCandidate_DBTable, Can2.CandidateElection_DBTableValue as FindCandidate_DBTableValue, " . 
						"Can2.Candidate_StatsVoters as FindCandidate_StatsVoters,  " .
						"Can2.Candidate_Status as FindCandidate_Status, Can2.Candidate_Watermark as FindCandidate_Watermark, " . 
						"Can2.Candidate_LocalHash as FindCandidate_LocalHash,  " .
						"Can2.Candidate_NominatedBy as FindCandidate_NominatedBy " .
						
						"FROM Candidate " .
						"LEFT JOIN Candidate AS Can2 ON (" .
						"Candidate.CandidateElection_DBTable = Can2.CandidateElection_DBTable " .
						"AND " .
						"Candidate.CandidateElection_DBTableValue = Can2.CandidateElection_DBTableValue" .
						")" .
						"LEFT JOIN CandidateElection ON (Can2.CandidateElection_ID = CandidateElection.CandidateElection_ID)" .
						"WHERE Candidate.Team_ID = :TeamID AND Elections_ID = :ElectionID AND Candidate.Candidate_ID = :CandidateID AND Can2.Candidate_ID != :CandidateID";
						
		$sql_vars = array("CandidateID" => $CandidateID, "TeamID" => $TeamID,  "ElectionID" => $ElectionsID);
		$ret = $this->_return_multiple($sql, $sql_vars);
		
		if ( empty ($ret)) {
			return array();
		} else {
			return $ret;
		}
						
  }
	
	function FindPositionsInToConv($ElectionsID, $Party, $CandidateID ) {
		$sql = "SELECT DISTINCT CandidateToFind.Candidate_ID as FindCandidate_ID, " .
					 	"CandidateToFind.Candidate_DispName as FindCandidate_DispName, " .
					 	
					 	"CandidateToFind.Candidate_ID as FindCandidate_Candidate_ID, CandidateToFind.SystemUser_ID as FindCandidate_SystemUser_ID,  " .
						"CandidateToFind.Team_ID as FindCandidate_Team_ID, CandidateToFind.CandidateProfile_ID as FindCandidate_CandidateProfile_ID, " . 
						"CandidateToFind.Candidate_PetitionNameset as FindCandidate_PetitionNameset, CandidateToFind.Candidate_UniqStateVoterID as FindCandidate_UniqStateVoterID,  " .
						"CandidateToFind.DataCounty_ID as FindCandidate_DataCounty_ID, CandidateToFind.Voters_ID as FindCandidate_Voters_ID, " . 
						"CandidateToFind.CandidateElection_ID as FindCandidate_CandidateElection_ID,  " .
						"CandidateToFind.Candidate_Party as FindCandidate_Party, CandidateToFind.Candidate_FullPartyName as FindCandidate_FullPartyName, " . 
						"CandidateToFind.CandidatePartySymbol_ID as FindCandidate_PartySymbol_ID,  " .
						"CandidateToFind.Candidate_DisplayMap as FindCandidate_DisplayMap, CandidateToFind.Candidate_DispName as FindCandidate_DispName, " . 
						# "CandidateToFind.Candidate_DispResidence as FindCandidate_DispResidence, " .
						"CandidateToFind.CandidateElection_DBTable as FindCandidate_DBTable, CandidateToFind.CandidateElection_DBTableValue as FindCandidate_DBTableValue, " . 
						"CandidateToFind.Candidate_StatsVoters as FindCandidate_StatsVoters,  " .
						"CandidateToFind.Candidate_Status as FindCandidate_Status, CandidateToFind.Candidate_Watermark as FindCandidate_Watermark, " . 
						"CandidateToFind.Candidate_LocalHash as FindCandidate_LocalHash,  " .
						"CandidateToFind.Candidate_NominatedBy as FindCandidate_NominatedBy " .
					 	
					 	
					 	
					 	"FROM Candidate " . 
						"LEFT JOIN CandidateElection ON (CandidateElection.CandidateElection_ID = Candidate.CandidateElection_ID) " . 
						"LEFT JOIN ElectionsDistrictsConv ON ( " . 
						"	 ElectionsDistrictsConv.ElectionsDistrictsConv_DBTable = Candidate.CandidateElection_DBTable AND " . 
						"	 ElectionsDistrictsConv.ElectionsDistrictsConv_DBTableValue = Candidate.CandidateElection_DBTableValue " . 
						") " . 
						"LEFT JOIN ElectionsPosition ON (ElectionsPosition.ElectionsPosition_ID = ElectionsDistrictsConv.ElectionsPosition_ID) " . 
						"LEFT JOIN Candidate AS CandidateToFind ON ( " . 
						"		ElectionsPosition.ElectionsPosition_DBTable = CandidateToFind.CandidateElection_DBTable AND " . 
						"		ElectionsDistrictsConv.ElectionsDistricts_DBTableValue = CandidateToFind.CandidateElection_DBTableValue " .      
						#"		Candidate.CandidateElection_DBTable = CandidateToFind.CandidateElection_DBTable AND " . 
						#"		Candidate.CandidateElection_DBTableValue = CandidateToFind.CandidateElection_DBTableValue " . 
						") " . 
						"LEFT JOIN CandidateElection AS CandidateElectionToFind ON (CandidateElectionToFind.CandidateElection_ID = CandidateToFind.CandidateElection_ID) " . 
						"WHERE Candidate.Candidate_ID = :CandidateID AND (ElectionsPosition_Party = :Party OR ElectionsPosition_Party IS NULL) " . 
						"AND CandidateElectionToFind.Elections_ID = :ElectionID "; 
						
		$sql_vars = array("CandidateID" => $CandidateID, "Party" => $Party,  "ElectionID" => $ElectionsID);
		$ret = $this->_return_multiple($sql, $sql_vars);
		
		if ( empty ($ret)) {
			return array();
		} else {
			return $ret;
		}
						
  }
  
  function FindPositionsInFromConv($ElectionsID, $Party, $CandidateID ) {
		$sql = "SELECT DISTINCT CandidateToFind.Candidate_ID as FindCandidate_ID, " .
					 	"CandidateToFind.Candidate_DispName as FindCandidate_DispName, " .
					 	
					 	"CandidateToFind.Candidate_ID as FindCandidate_Candidate_ID, CandidateToFind.SystemUser_ID as FindCandidate_SystemUser_ID,  " .
						"CandidateToFind.Team_ID as FindCandidate_Team_ID, CandidateToFind.CandidateProfile_ID as FindCandidate_CandidateProfile_ID, " . 
						"CandidateToFind.Candidate_PetitionNameset as FindCandidate_PetitionNameset, CandidateToFind.Candidate_UniqStateVoterID as FindCandidate_UniqStateVoterID,  " .
						"CandidateToFind.DataCounty_ID as FindCandidate_DataCounty_ID, CandidateToFind.Voters_ID as FindCandidate_Voters_ID, " . 
						"CandidateToFind.CandidateElection_ID as FindCandidate_CandidateElection_ID,  " .
						"CandidateToFind.Candidate_Party as FindCandidate_Party, CandidateToFind.Candidate_FullPartyName as FindCandidate_FullPartyName, " . 
						"CandidateToFind.CandidatePartySymbol_ID as FindCandidate_PartySymbol_ID,  " .
						"CandidateToFind.Candidate_DisplayMap as FindCandidate_DisplayMap, CandidateToFind.Candidate_DispName as FindCandidate_DispName, " . 
						# "CandidateToFind.Candidate_DispResidence as FindCandidate_DispResidence, " .
						"CandidateToFind.CandidateElection_DBTable as FindCandidate_DBTable, CandidateToFind.CandidateElection_DBTableValue as FindCandidate_DBTableValue, " . 
						"CandidateToFind.Candidate_StatsVoters as FindCandidate_StatsVoters,  " .
						"CandidateToFind.Candidate_Status as FindCandidate_Status, CandidateToFind.Candidate_Watermark as FindCandidate_Watermark, " . 
						"CandidateToFind.Candidate_LocalHash as FindCandidate_LocalHash,  " .
						"CandidateToFind.Candidate_NominatedBy as FindCandidate_NominatedBy " .
					 	
					 	"FROM Candidate " . 
					 	"LEFT JOIN CandidateElection ON (CandidateElection.CandidateElection_ID = Candidate.CandidateElection_ID)  " . 
					 	"LEFT JOIN ElectionsDistrictsConv ON ( ElectionsDistrictsConv.ElectionsPosition_ID = CandidateElection.ElectionsPosition_ID AND ElectionsDistrictsConv.ElectionsDistricts_DBTableValue = CandidateElection.CandidateElection_DBTableValue)  " . 
					 	"LEFT JOIN Candidate AS CandidateToFind ON (  " . 
					 	"ElectionsDistrictsConv.ElectionsDistrictsConv_DBTable = CandidateToFind.CandidateElection_DBTable  " . 
					 	"AND  " . 
					 	"ElectionsDistrictsConv.ElectionsDistrictsConv_DBTableValue = CandidateToFind.CandidateElection_DBTableValue  " . 
					 	")  " . 
					 	"LEFT JOIN CandidateElection AS CandidateElectionToFind ON (CandidateElectionToFind.CandidateElection_ID = CandidateToFind.CandidateElection_ID)  " . 
					 	"LEFT JOIN ElectionsPosition ON (ElectionsPosition.ElectionsPosition_ID = ElectionsDistrictsConv.ElectionsPosition_ID)  " . 
					 	
						"WHERE Candidate.Candidate_ID = :CandidateID AND (ElectionsPosition_Party = :Party OR ElectionsPosition_Party IS NULL) " . 
						"AND CandidateElectionToFind.Elections_ID = :ElectionID "; 
						
						
		$sql_vars = array("CandidateID" => $CandidateID, "Party" => $Party,  "ElectionID" => $ElectionsID);
		$ret = $this->_return_multiple($sql, $sql_vars);
		
		if ( empty ($ret)) {
			return array();
		} else {
			return $ret;
		}
						
  }


}
?>
