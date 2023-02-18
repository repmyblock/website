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
		
	function ListsTeams($TeamID = NULL) {
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

}
?>
