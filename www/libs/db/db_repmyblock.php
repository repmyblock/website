<?php	  	
require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/mysql/queries.php";
global $DB;

class RepMyBlock extends queries {

  function RepMyBlock ($debug = 0, $DBFile = "DB_OutragedDems") {
	  require $_SERVER["DOCUMENT_ROOT"] . "/../statlib/DBsLogins/" . $DBFile . ".php";
	  $DebugInfo["DBErrorsFilename"] = $DBErrorsFilename;
	  $DebugInfo["Flag"] = $debug;
	  
	  WriteStderr($DebugInfo, "RepMyBlock ->");	
	  
	  $this->queries($databasename, $databaseserver, $databaseport, $databaseuser, $databasepassword, $sslkeys, $DebugInfo);
  }
  
  function RecordWatch($SystemID, $FullName, $Email) {
		$sql = "INSERT INTO ZeMovieWtchd SET SystemUser_ID = :SystemUser, " .
						"ZeMovieWtchd_FullName = :FullName, " .
						"ZeMovieWtchd_Email = :Email, ZeMovieWtchd_Time = NOW()";
		$sql_vars = array("SystemUser" => $SystemID, 
											"FullName" => $FullName, "Email" => $Email);
		return $this->_return_nothing($sql, $sql_vars);
	}
	
	function GetMoviePassword() { 
		$sql = "SELECT * FROM ZeMoviePwd;";
		return $this->_return_simple($sql);
	}


 	function database_showtables() {
  	$sql = "SHOW TABLES";
  	return $this->_return_multiple($sql);	
 	}
 	
 	function database_showcolums($Tables) {
 		$sql = "SHOW COLUMNS FROM $Tables"; 		
 		// $sql_vars = array("Tables" => $Tables);
  	return $this->_return_multiple($sql); 
 	}
 	
 	function database_custquery($dbtable, $dbcol, $val) {
 		$sql = "SELECT * FROM $dbtable WHERE $dbcol = :VALUE LIMIT 10000";
 		$sql_vars = array("VALUE" => $val);
 		return $this->_return_multiple($sql, $sql_vars); 
 	}

  function FindVotersForEDAD($District, $ADED, $Party) {  	
		$sql = "SELECT * FROM Voters WHERE " .
						"ElectionsDistricts_DBTable = :DISTRICT AND ElectionsDistricts_DBTableValue = :ADED AND Voters_RegParty = :PARTY " .
						"AND (Voters_Status = 'Active' OR Voters_Status = 'Inactive')";
		$sql_vars = array("ADED" =>  $ADED, "DISTRICT" => $District, "PARTY" => $Party);	
		
		WriteStderr($sql_vars, "SQL Query: " . $sql);		
		return $this->_return_multiple($sql, $sql_vars);
	}  
   
 
   
  function FindPersonUser($SystemUserID) {
		$sql = "SELECT * FROM SystemUser WHERE SystemUser_ID = :ID";	
		$sql_vars = array(':ID' => $SystemUserID);											
		return $this->_return_simple($sql,  $sql_vars);
	}
	
	function FindPersonUserProfile($SystemUserID) {
		$sql = "SELECT * FROM SystemUser " . 
						"LEFT JOIN SystemUserProfile ON (SystemUser.SystemUserProfile_ID = SystemUserProfile.SystemUserProfile_ID) " . 
						"LEFT JOIN Voters ON (SystemUser.Voters_ID = Voters.Voters_ID) " . 
						"LEFT JOIN DataState ON (Voters.DataState_ID = DataState.DataState_ID) " . 
						"WHERE SystemUser_ID = :ID";	
		$sql_vars = array(':ID' => $SystemUserID);											
		return $this->_return_simple($sql,  $sql_vars);		
	}
	
	function InsertEmail($email) {
		$sql = "INSERT INTO SystemUser SET SystemUser_email = :Email";	
		$sql_vars = array(':Email' => $email);											
		return $this->_return_nothing($sql,  $sql_vars);
	}
	
	function CheckRegisterEmail ($email) {
		$sql = "SELECT * FROM SystemUser WHERE SystemUser_email = :Email";
		$sql_vars = array(':Email' => $email);											
		return $this->_return_simple($sql,  $sql_vars);
	}
		
	function FindGeoDiscID($GeoDescAbbrev) {
		$sql = "SELECT * FROM GeoDesc WHERE GeoGroup_ID = '3' AND GeoDesc_Abbrev = :Abbrev";
		$sql_vars = array('Abbrev' => $GeoDescAbbrev);							
		return $this->_return_simple($sql, $sql_vars);
	}
	
	function SearchVoterTableDB($FirstName, $LastName, $DOB, $DatedFiles = "", $Status = "") {

		$this->SaveVoterRequest($FirstName, $LastName, $DOB, NULL, NULL, $UniqNYSVoterID, $_SERVER['REMOTE_ADDR'] );		
		$TableVoter = "Raw_Voter_" . $DatedFiles;
		
		$CompressedFirstName = preg_replace("/[^a-zA-Z]+/", "", $FirstName);
		$CompressedLastName = preg_replace("/[^a-zA-Z]+/", "", $LastName);
		
		$sql = "SELECT * FROM VotersIndexes " .
						"LEFT JOIN DataFirstName ON (DataFirstName.DataFirstName_ID = VotersIndexes.DataFirstName_ID ) " . 
						"LEFT JOIN DataLastName ON (DataLastName.DataLastName_ID = VotersIndexes.DataLastName_ID ) " .
						"LEFT JOIN " . $TableVoter  . " ON (" . $TableVoter . ".Raw_Voter_UniqNYSVoterID = VotersIndexes.VotersIndexes_UniqNYSVoterID) " . 
						"WHERE DataFirstName_Compress = :FirstName AND " . 
						"DataLastName_Compress = :LastName " . #AND Raw_Voter_Dates_ID = :TableID " .
						"AND VotersIndexes_DOB = :DOB"; // AND Raw_Voter_Status = :Status"
						;
		$sql_vars = array('FirstName' => $CompressedFirstName,
											'LastName' => $CompressedLastName,
											'DOB' => $DOB);
											// 'Status' => $Status); 
											//,'TableID' => $TableID);
											
	
		return $this->_return_multiple($sql, $sql_vars);
	}
	
	function QueryVoterFile($UniqNYSVoterID, $FirstName, $LastName, $DOB = NULL, 
																$zip = NULL, $countyid = NULL, $Party = NULL, $AD = NULL, $ED = NULL, $Congress = NULL) {
		$this->SaveVoterRequest($FirstName, $LastName, $DOB, NULL, NULL, $UniqNYSVoterID, $_SERVER['REMOTE_ADDR'] );		
		
		$CompressedFirstName = preg_replace("/[^a-zA-Z]+/", "", $FirstName);
		$CompressedLastName = preg_replace("/[^a-zA-Z]+/", "", $LastName);
		
		$sql = "SELECT * FROM VotersIndexes " .
						"LEFT JOIN DataFirstName ON (DataFirstName.DataFirstName_ID = VotersIndexes.DataFirstName_ID ) " . 
						"LEFT JOIN DataLastName ON (DataLastName.DataLastName_ID = VotersIndexes.DataLastName_ID ) " .
						"LEFT JOIN DataMiddleName ON (DataMiddleName.DataMiddleName_ID = VotersIndexes.DataMiddleName_ID ) " .
						"LEFT JOIN Voters ON (Voters.VotersIndexes_ID = VotersIndexes.VotersIndexes_ID) " . 
						
						// This will need to be removed once I finish fixing the CD ROM.
						"LEFT JOIN VotersRaw_NY ON (VotersRaw_NY.UniqNYSVoterID = VotersIndexes_UniqStateVoterID) " . 
						
						"WHERE DataFirstName_Compress LIKE :FirstName AND " . 
						"DataLastName_Compress LIKE :LastName";
												
		$sql_vars = array('FirstName' => $CompressedFirstName . "%", 
											'LastName' => $CompressedLastName . "%");
	//										'DOB' => $DOB
											// 'Status' => $Status); 
											//,'TableID' => $TableID);
		
		return $this->_return_multiple($sql, $sql_vars);				
		
	
		if ( ! empty ($FirstName)) { $sql .= " AND Raw_Voter_FirstName = :FirstName"; $sql_vars["FirstName"] = $FirstName; }		
		if ( ! empty ($zip)) { $sql .= " AND Raw_Voter_ResZip = :ZIP"; $sql_vars["ZIP"] = $zip;	}
		if ( ! empty ($AD)) {	$sql .= " AND Raw_Voter_AssemblyDistr = :AD";	$sql_vars["AD"] = $AD; }
		if ( ! empty ($ED)) {	$sql .= " AND Raw_Voter_ElectDistr = :ED"; $sql_vars["ED"] = $ED; }
		if ( ! empty ($Congress)) {	$sql .= " AND Raw_Voter_CongressDistr = :Congress";	$sql_vars["Congress"] = $Congress;	}
		if ( ! empty ($Party)) { $sql .= " AND Raw_Voter_EnrollPolParty = :Party"; $sql_vars["Party"] = $Party;	}
		
		if ( ! empty ($countyid)) {
			switch ($countyid) {
				case 'BQK':
					$sql .= " AND (Raw_Voter_CountyCode = \"03\" || Raw_Voter_CountyCode = \"41\" || Raw_Voter_CountyCode = \"24\")";
					break;
					
				case 'NYC':
					$sql .= " AND (Raw_Voter_CountyCode = \"43\" || Raw_Voter_CountyCode = \"31\")";
					break;

				case 'OUTSIDE':
					$sql .= " AND Raw_Voter_CountyCode != \"03\" && Raw_Voter_CountyCode != \"41\" && Raw_Voter_CountyCode != \"24\"" .
									" AND Raw_Voter_CountyCode != \"43\" || Raw_Voter_CountyCode != \"31\"";
					break;
				
				default:
					$sql .= " AND Raw_Voter_CountyCode = :CountyCode";
					$sql_vars["CountyCode"] = $countyid;
					break;				
			}
		}
		
		return $this->_return_multiple($sql, $sql_vars);
	}
	
	// $this->SaveVoterRequest("NYS BOE ID", $NYSBOEID, $DOB, $DatedFilesID, NULL, $UniqNYSVoterID, $_SERVER['REMOTE_ADDR'] );		

	

	function SaveVoterRequest($FirstName, $LastName, $DateOfBirth, $DatedFilesID, $Email, $UniqNYSVoterID, $IP) {
		$sql = "INSERT INTO SystemUserQuery SET SystemUserQuery_FirstName = :FirstName, " .
		 				"SystemUserQuery_LastName = :LastName, SystemUserQuery_DateOfBirth = :DateOfBirth, " .
    				"SystemUserQuery_DatedFileID = :DatedFilesID, SystemUserQuery_Email = :Email, " .
    				"SystemUserQuery_UniqNYSVoterID = :UniqNYSVoterID, SystemUserQuery_IP = :IP, SystemUserQuery_Date = NOW()";

		$sql_vars = array("FirstName" => $FirstName, "LastName" => $LastName, 
											"DateOfBirth" => $DateOfBirth, "DatedFilesID" => $DatedFilesID,
    									"Email" => $Email, "UniqNYSVoterID" => $UniqNYSVoterID,
    									"IP" => $IP);
		return $this->_return_nothing($sql, $sql_vars);
	}

	function SearchVoterDB($FirstName, $LastName, $DOB, $Status = "") {

		$CompressedFirstName = preg_replace("/[^a-zA-Z]+/", "", $FirstName);
		$CompressedLastName = preg_replace("/[^a-zA-Z]+/", "", $LastName);
		
		$sql = "SELECT * FROM VotersIndexes " .
						"LEFT JOIN DataFirstName ON (DataFirstName.DataFirstName_ID = VotersIndexes.DataFirstName_ID ) " . 
						"LEFT JOIN DataLastName ON (DataLastName.DataLastName_ID = VotersIndexes.DataLastName_ID ) " .
						"LEFT JOIN Voters ON (Voters.VotersIndexes_ID = VotersIndexes.VotersIndexes_ID) " . 
						"WHERE DataFirstName_Compress = :FirstName AND " . 
						"DataLastName_Compress = :LastName " .
						"AND VotersIndexes_DOB = :DOB"; 
		$sql_vars = array('FirstName' => $CompressedFirstName, 
											'LastName' => $CompressedLastName, 
											'DOB' => $DOB);
						
		if (! empty ($Status)) {
			$sql .= " AND Voters_Status = :Status";
			$sql_vars["Status"] = $Status;
		}
						
		WriteStderr($sql, "SQL request");
					
		return $this->_return_multiple($sql, $sql_vars);		
	}
	
	
	function ListPetitionGroup($GroupID = NULL, $Status = NULL) {
		$sql = "SELECT * FROM CandidateGroup " .
						"LEFT JOIN Candidate ON (CandidateGroup.Candidate_ID = Candidate.Candidate_ID) " . 
						"LEFT JOIN DataCounty ON (DataCounty.DataCounty_ID = CandidateGroup.DataCounty_ID) " .
						"LEFT JOIN CandidateElection ON (CandidateElection.CandidateElection_ID = Candidate.CandidateElection_ID) " . 
						"LEFT JOIN Elections ON (Elections.Elections_ID = CandidateElection.Elections_ID) " .
						"LEFT JOIN CandidateComRplceSet ON (CandidateComRplceSet.Candidate_ID = Candidate.Candidate_ID) " .
						"LEFT JOIN CandidateComRplce ON (CandidateComRplceSet.CandidateComRplce_ID = CandidateComRplce.CandidateComRplce_ID) ";
		if ( ! empty ($GroupID)) {
			$sql .= "WHERE CandidateGroup.CandidateSet_ID = :CandidateGroup_ID ";
			$sql_vars = array("CandidateGroup_ID" => $GroupID);
		} else {
			$sql_vars = array();
		}
						
		$sql .= "ORDER BY CandidateElection_DisplayOrder ASC";							
		return $this->_return_multiple($sql, $sql_vars);	
	}

	function ListElectedPositions($state, $StateID = NULL, $PositionID = NULL) {
		$sql = "SELECT * FROM ElectionsPosition WHERE ";

		if ( $PositionID > 0) {
			$sql .= "ElectionsPosition_ID = :PosID";
			$sql_vars = array('PosID' => $PositionID);	
		} else {
			if ( $StateID == "id") {
				$sql .= "DataState_ID = :State ";
			}	else {	
				$sql .= "ElectionsPosition_State = :State ";				
			}
			$sql_vars = array('State' => $state);	
			$sql .= "ORDER BY ElectionsPosition_Order";
		} 
		
		return $this->_return_multiple($sql, $sql_vars);
	}
	
	function ListParties($StateID, $OfficialOnly = false, $PartyID = NULL) {
		$sql = "SELECT * FROM DataParty WHERE ";
		
		
		if ( $PartyID > 0) {
			$sql .= "DataParty_ID = :DataParty";
			$sql_vars = array("DataParty" => $PartyID);
		} else {
			$sql .= "DataState_ID = :StateID";
			$sql_vars = array("StateID" => $StateID);
		
			if ( $OfficialOnly == true) {
				$sql .= " AND DataParty_Recognized = :Recog";
				$sql_vars["Recog"] = "yes";
			}
		}
			
		return $this->_return_multiple($sql, $sql_vars);
	}

	function DisplayElectionPositions($ID) {
		$sql = "SELECT * FROM ElectionsPosition " . 
						"WHERE ElectionsPosition_ID = :ID ";
		$sql_vars = array('ID' => $ID);
		return $this->_return_simple($sql, $sql_vars);
	}
	
	function ListCandidatePetitions($CandidateID = NULL) {
		$sql = "SELECT * FROM CandidateProfile " . 
						"LEFT JOIN Candidate ON " . 
						"(Candidate.Candidate_ID = CandidateProfile.Candidate_ID) ";
		
		if (! empty ($CandidateID)) {
			$sql .= "WHERE CandidateProfile.Candidate_ID = :CandidateID";
			$sql_vars = array("CandidateID" => $CandidateID);
			return $this->_return_simple($sql, $sql_vars);
		}
		
		return $this->_return_multiple($sql);
	}
	
	function ListCandidateProfile($CandidateID = NULL) {
		$sql = "SELECT * FROM CandidateProfile ";
		
		if (! empty ($CandidateID)) {
			$sql .= "WHERE Candidate_ID = :CandidateID";
			$sql_vars = array("CandidateID" => $CandidateID);
			return $this->_return_simple($sql, $sql_vars);
		}
		
		return $this->_return_multiple($sql);
	}
	
	function InsertCandidateElection($CandidateElectionData) {
			
		if (! empty ($CandidateElectionData["ElectionID"])) {
			$sql = "INSERT INTO CandidateElection SET ";
			$MatchTableName = array(
					"ElectionID" => "Elections_ID", 
					"PosType" => "CandidateElection_PositionType", 
					"Party" => "CandidateElection_Party", 
					"PosText" => "CandidateElection_Text", 
					"PetText" => "CandidateElection_PetitionText", 
					"URLExplain" => "CandidateElection_URLExplain", 
					"Number" => "CandidateElection_Number", 
					"Order" => "CandidateElection_DisplayOrder", 
					"Display" => "CandidateElection_Display", 
					"Sex" => "CandidateElection_Sex", 
					"DBTable" => "CandidateElection_DBTable", 
					"DBValue" => "CandidateElection_DBTableValue", 
					"NbrVoters" => "CandidateElection_CountVoter"
			);
			
			$firsttime = 0;
			foreach ($MatchTableName as $index => $var) {			
				if (! empty ($CandidateElectionData[$index])) { 
					if ($firsttime == 0) { $firsttime = 1;} else { $sql .= ", "; }
					$sql .= $var . " = :" . $index;
				}
			}
		}
		
		$this->_return_nothing($sql, $CandidateElectionData);
		
		$sql = "SELECT LAST_INSERT_ID() as CandidateElection_ID";
		return $this->_return_simple($sql); 	
	}
	
	function updatecandidateprofile($Candidate_ID, $CandidateProfile) {
	
		if ($Candidate_ID > 0) {
			
			$MatchTableName = array(
				"PicFile" => "CandidateProfile_PicFileName", 
				"PDFFile" => "CandidateProfile_PDFFileName", 
				"Fist"	 =>  "CandidateProfile_FirstName", 
				"Last"	 => "CandidateProfile_LastName", 
				"Full"	 =>  "CandidateProfile_Alias", 
				"URL"	 =>  "CandidateProfile_Website", 
				"Email"	 => "CandidateProfile_Email", 
				"Twitter"	 => "CandidateProfile_Twitter", 
				"Facebook"	 => "CandidateProfile_Facebook", 
				"Instagram"	 => "CandidateProfile_Instagram", 
				"TikTok"	 => "CandidateProfile_TikTok", 
				"YouTube"	 => "CandidateProfile_YouTube", 
				"Ballotpedia"	 => "CandidateProfile_BallotPedia", 
				"Phone"	 => "CandidateProfile_PhoneNumber", 
				"Fax"	 => "CandidateProfile_FaxNumber", 
				"Platform"	 => "CandidateProfile_Statement"			
			);
			
			
			$return = $this->ListCandidateProfile($Candidate_ID);	
			# This is to set the collums that changed.
			foreach ($CandidateProfile as $index => $var) {			
				if ( $var == $return[$MatchTableName[$index]]) {
					unset ($CandidateProfile[$index]);
				}
			}
									
			if ( empty ($return)) {	$sql = "INSERT INTO"; } 
			else { $sql = "UPDATE"; }
			$sql .= " CandidateProfile SET ";
			$sql_vars = array("Candidate_ID" => $Candidate_ID);
			$FirstTime = 0;
			
			
			$firsttime = 0;
			foreach ( $CandidateProfile as $index => $var) {
				if ( ! empty ($var)) {
					if ( $firsttime ) { $sql .= ", "; }				
					$sql .= $MatchTableName[$index] . " = :" . $index; 
					$sql_vars[$index] =	$CandidateProfile[$index]; 
					$firsttime = 1;
				}
			}
			
			## Add the null tables at the end;
			foreach ( $CandidateProfile as $index => $var) {
				if ( empty ($CandidateProfile[$index])) {
					if ( $firsttime ) { $sql .= ", "; }	
					$sql .= $MatchTableName[$index] . " = NULL";
					$firsttime = 1;
				}
			}
			
			if ( empty ($return)) {	$sql .= " ,Candidate_ID = :Candidate_ID"; }
			else { $sql .= " WHERE Candidate_ID = :Candidate_ID"; }
			
			if (! $firsttime) return;
			$this->_return_nothing($sql, $sql_vars);
			
			$sql = "SELECT LAST_INSERT_ID() as CandidateProfile_ID";
			return $this->_return_simple($sql); 
		}
		
	}	
	
	function addcandidateprofileid($CandidateID, $CandidateProfileID) {
		
		if ( $CandidateID > 0) {
			$sql = "UPDATE Candidate SET CandidateProfile_ID = :ProfID WHERE Candidate_ID = :CandID";
			$sql_vars = array("ProfID" => $CandidateProfileID, "CandID" => $CandidateID);	
			return $this->_return_nothing($sql, $sql_vars);
		}
	}
    
 
	
	function ListCandidateInformation($SystemUserID) {
		$sql = "SELECT * FROM Candidate " . 
						"LEFT JOIN CandidateGroup ON (Candidate.Candidate_ID = CandidateGroup.Candidate_ID) " . 
						"WHERE SystemUser_ID = :SystemUserID";
		$sql_vars = array('SystemUserID' => $SystemUserID);
		return $this->_return_multiple($sql, $sql_vars);
	}
	
	function ListElections($SomeVariable) {
		$sql = "SELECT * FROM CandidateElection " . 
						"LEFT JOIN Candidate ON (CandidateElection.CandidateElection_ID = Candidate.CandidateElection_ID)";
					
		return $this->_return_multiple($sql);
	}
	
	function ListElectionsDates ($limit = 50, $start = 0, $futureonly = false, $StateID = NULL) {
		$sql = "SELECT * FROM Elections " . 
						"LEFT JOIN DataState ON (Elections.DataState_ID = DataState.DataState_ID) ";
		
		// Not very elegant but I am tired.
		if ( $futureonly == true ) {
			$sql .= "WHERE Elections_Date >= NOW() ";
			if ( $StateID > 0) { $sql .= "AND Elections.DataState_ID = :StateID "; }
		} else {
			if ( $StateID > 0 ) { $sql .= "WHERE Elections.DataState_ID = :StateID "; }
		}
		
		
		$sql .= "ORDER BY Elections_Date, Elections_Type LIMIT $start, $limit";	

		if ( $StateID > 0) {
			$sql_vars = array("StateID" => $StateID);
			return $this->_return_multiple($sql, $sql_vars);			
		}

		return $this->_return_multiple($sql);
	}
	
	function ListStates() {
		$sql = "SELECT * FROM DataState ORDER BY DataState.DataState_Abbrev";
		return $this->_return_multiple($sql);
	}
	
	function CandidateElection($DBTable, $DBTableValue, $FromDate = NULL,  $Party = NULL, $ElectionID = NULL) {
		$sql = 	"SELECT * FROM CandidateElection " .
						"LEFT JOIN Elections ON (Elections.Elections_ID = CandidateElection.Elections_ID) " .
						"WHERE CandidateElection_DBTable = :DBTable AND " . 
						"CandidateElection_DBTableValue = :DBValue";
		$sql_vars = array('DBTable' => $DBTable, 'DBValue' => $DBTableValue);						
		
		if ( ! empty ($FromDate)) {
			$sql .= " AND Elections_Date >= :FromDate";
			$sql_vars["FromDate"] = $FromDate;
		}
										
		if ( ! empty ($Party)) {
			$sql .= " AND CandidateElection_Party = :Party";
			$sql_vars["Party"] = $Party;
		}
		
		if ( ! empty ($ElectionID)) {
			$sql .= " AND CandidateElection.Elections_ID = :ElectionID";
			$sql_vars["ElectionID"] = $ElectionID;
		}
		
		return $this->_return_multiple($sql, $sql_vars);
	}

	function ListCandidateNomination($SystemUserID) {
		$sql = "SELECT * FROM CanNomination WHERE SystemUser_ID = :SystemUserID";
		$sql_vars = array('SystemUserID' => $SystemUserID);		
	}

	function NextPetitionSet($SystemUser_ID) {
		if ( $SystemUser_ID > 0) {
			$sql = "INSERT INTO CandidateSet SET SystemUser_ID = :SystemUserID, CandidateSet_TimeStamp = NOW()";
			$sql_vars = array("SystemUserID" => $SystemUser_ID);
			$this->_return_nothing($sql, $sql_vars);
		
			$sql = "SELECT LAST_INSERT_ID() as CandidateSet";
			return $this->_return_simple($sql);
		}		
	}
	
	function InsertCandidateSet($CandidateID, $CandidateSetID, $Party, $CountyID, $Order = NULL, $WaterMark = "yes") {
		$sql = "INSERT INTO CandidateGroup SET " .
						"CandidateSet_ID = :CanPetSetID, Candidate_ID = :CandidateID, " .
						"DataCounty_ID = :CountyID, CandidateGroup_Party = :Party, " .
						"CandidateGroup_Watermark = :Water, CandidateGroup_Order = :Order";
						
						
		$sql_vars = array("CanPetSetID" => $CandidateSetID, "CandidateID" => $CandidateID, 
											"CountyID" => $CountyID, "Party" => $Party, "Water" => $WaterMark, "Order" => $Order);			
		$this->_return_nothing($sql, $sql_vars);
		
		$sql = "SELECT LAST_INSERT_ID() as CandidateSet_ID";
		return $this->_return_simple($sql);
	}
	
	
	
	
	function InsertCandidate($SystemUserID, $UniqNYSVoterID, $RawVoterID, $DataCountyID, $CandidateElectionID, $Party, $DisplayName,
														$Address, $DBTable, $DBValue,	$StatsVoters, $Status, $NameSet = NULL) {
															
		$sql = "INSERT INTO Candidate SET SystemUser_ID = :SystemUserID, Candidate_UniqStateVoterID = :UniqNYSVoterID, " .
						"Voter_ID = :RawVoterID, DataCounty_ID = :DataCountyID," .
						"CandidateElection_ID = :CandidateElectionID, Candidate_Party = :Party, Candidate_DispName = :DisplayName, " .
						"Candidate_DispResidence = :Address, CandidateElection_DBTable = :DBTable, " .
						"CandidateElection_DBTableValue = :DBValue, Candidate_StatsVoters = :StatsVoters, " . 
						"Candidate_Status = :Status";
						
		$sql_vars = array("SystemUserID" => $SystemUserID, "UniqNYSVoterID" => $UniqNYSVoterID, 
											"RawVoterID" => $RawVoterID, "DataCountyID" => $DataCountyID, 
											"CandidateElectionID" => $CandidateElectionID, 
											"Party" => $Party, "DisplayName" =>  $DisplayName, 
											"Address" => $Address, "DBTable" => $DBTable, "DBValue" => $DBValue, 
											"StatsVoters" => $StatsVoters, "Status" => $Status);
											
		if ( $NameSet != NULL ) {
			$sql .= ", Candidate_PetitionNameset = :NameSet";
			$sql_vars["NameSet"] = $NameSet;
		}
		
		$this->_return_nothing($sql, $sql_vars);
		
		$sql = "SELECT LAST_INSERT_ID() as Candidate_ID";
		return $this->_return_simple($sql);
	}
	
	function CandidateNomination($SystemUserID, $ElectionID, $CandidateID) {
		$sql = "INSERT INTO CanNomination SET Candidate_ID = :CandidateID, SystemUser_ID = :SystemUserID, CandidateElection_ID = :CandidateElectionID";
		$sql_vars = array('CandidateID' => $CandidateID, 'SystemUserID' => $SystemUserID, 'CandidateElectionID' => $ElectionID);
		return $this->_return_nothing($sql, $sql_vars);
	}


	function ListCandidates() {
		$sql = "SELECT * FROM Candidate " . 
						"LEFT JOIN CandidateElection ON (Candidate.CandidateElection_ID = CandidateElection.CandidateElection_ID) " .
						"LEFT JOIN Elections ON (Elections.Elections_ID = CandidateElection.Elections_ID) " .
						"ORDER BY Elections_Date DESC, CandidateElection.CandidateElection_DBTable, CandidateElection.CandidateElection_DBTableValue";
		return $this->_return_multiple($sql);
	}

	function ListOnlyElections() {
		$sql = "SELECT * FROM CandidateElection";
		return $this->_return_multiple($sql);
	}
	
	function ListNominations($SystemUserID) {
		$sql = "SELECT * FROM CanNomination " .
						"LEFT JOIN CandidateElection ON (CandidateElection.CandidateElection_ID = CanNomination.CandidateElection_ID) " .
						"WHERE SystemUser_ID = :SystemUserID";
		$sql_vars = array("SystemUserID" => $SystemUserID);				
		return $this->_return_multiple($sql, $sql_vars);
	}
	
	function InsertNewNomination($CandidateElection, $SystemUser, $FirstName, $LastName, $Email, $Phone) {
		$sql = "INSERT INTO CanNomination SET CandidateElection_ID = :CandidateElection_ID, SystemUser_ID = :SystemUserID, " . 
						"CanNomination_FirstName = :FirstName, CanNomination_LastName = :LastName, CanNomination_Email = :Email, "  .
						"CanNomination_Phone = :Phone";
		$sql_vars = array('CandidateElection_ID' => $CandidateElection, 'SystemUserID' => $SystemUser, 'FirstName' =>  $FirstName, 
		 									'LastName'=> $LastName, 'Email'=> $Email, 'Phone'=> $Phone);
		return $this->_return_nothing($sql, $sql_vars);
	}
	
	function ListCandidatePetition($SystemUserID) {
		$sql = "SELECT * FROM CandidatePetitionSet " .
						"LEFT JOIN CandidateGroup ON (CandidateGroup.CandidatePetitionSet_ID = CandidatePetitionSet.CandidatePetitionSet_ID) " .
						"LEFT JOIN Candidate ON (CandidateGroup.Candidate_ID = Candidate.Candidate_ID) " .
						"LEFT JOIN CanWitnessSet ON (CanWitnessSet.Candidate_ID = Candidate.Candidate_ID) " .
						"LEFT JOIN CandidateWitness ON (CanWitnessSet.CandidateWitness_ID = CandidateWitness.CandidateWitness_ID) " .
						"LEFT JOIN CandidateElection ON (CandidateElection.CandidateElection_ID = Candidate.CandidateElection_ID) " .
						"WHERE CandidatePetitionSet.SystemUser_ID = :SystemUserID";
		$sql_vars = array("SystemUserID" => $SystemUserID);				
		return $this->_return_multiple($sql, $sql_vars);
	}

	function GetPetitionsSumary($SystemUser_ID) {
		$sql = "SELECT count(*) as CandidateTotal, count(CandidatePetition_SignedDate) as CandidateSigned " .
						"FROM Candidate LEFT JOIN CandidatePetition ON (Candidate.Candidate_ID = CandidatePetition.Candidate_ID) " .
						"WHERE SystemUser_ID = :SystemUserID";
		$sql_vars = array("SystemUserID" => $SystemUser_ID);
	 	return $ret = $this->_return_simple($sql, $sql_vars);	 
	}

	function ListCandidateNominatedForPetition($SystemUserID) {
		$sql = "SELECT * FROM CanNomination " .
						"LEFT JOIN CandidateElection ON (CandidateElection.CandidateElection_ID = CanNomination.CandidateElection_ID) " .
						"LEFT JOIN Candidate ON (CanNomination.Candidate_ID = Candidate.Candidate_ID) " .
						"LEFT JOIN CanWitnessSet ON (CanWitnessSet.Candidate_ID = Candidate.Candidate_ID) " .
						"LEFT JOIN CandidateWitness ON (CanWitnessSet.CandidateWitness_ID = CandidateWitness.CandidateWitness_ID) " .
						"WHERE CanNomination.SystemUser_ID = :SystemUserID";
		$sql_vars = array("SystemUserID" => $SystemUserID);				
		return $this->_return_multiple($sql, $sql_vars);
	}
	
	function AddIntoOldEmailTable($NewEmail, $OldEmail, $OldStatus, $SystemUserID) {		
		$sql = "INSERT INTO SystemUserOldEmail SET " .
						"SystemUser_ID = :SystemUserID, SystemUserOldEmail_OldEmail = :OldEmail, " .
						"SystemUserOldEmail_OldStatus = :OldStatus, SystemUserOldEmail_NewEmail = :NewEmail, " .
						"SystemUserOldEmail_Timestamp = NOW()";
		$sql_vars = array("SystemUserID" => $SystemUserID, "OldEmail" => $OldEmail,
											"OldStatus" => $OldStatus, "NewEmail" => $NewEmail);
		
	}
	
	function InsertCandidatePetitionSet($System_ID = NULL) {
		
		$sql = "INSERT INTO CandidatePetitionSet SET CandidatePetitionSet_TimeStamp = NOW()";
		$sql_vars = array('CanSetID' => $CandidatePetitionSet_ID);
		
		if ( ! empty ($System_ID)) {
			$sql .= ", SystemUser_ID = :SystemID";
			$sql_vars["SystemID"] =  $System_ID;
		}
		$this->_return_nothing($sql, $sql_vars);
		
		$sql = "SELECT LAST_INSERT_ID() as CandidatePetitionSet_ID";
		return $this->_return_simple($sql);
	}
	
	function ReturnVoterIndex($SingleIndex) {
				$sql = "SELECT * FROM VotersIndexes " .
						"LEFT JOIN DataFirstName ON (DataFirstName.DataFirstName_ID = VotersIndexes.DataFirstName_ID ) " . 
						"LEFT JOIN DataLastName ON (DataLastName.DataLastName_ID = VotersIndexes.DataLastName_ID ) " .
						"LEFT JOIN DataMiddleName ON (DataMiddleName.DataMiddleName_ID = VotersIndexes.DataMiddleName_ID ) " .
						"LEFT JOIN Voters ON (Voters.VotersIndexes_ID = VotersIndexes.VotersIndexes_ID) " . 
						"LEFT JOIN DataHouse ON (Voters.DataHouse_ID = DataHouse.DataHouse_ID) " . 
						"LEFT JOIN DataAddress ON (DataHouse.DataAddress_ID = DataAddress.DataAddress_ID) " .
						"LEFT JOIN DataStreet ON (DataAddress.DataStreet_ID = DataStreet.DataStreet_ID) " .
						"LEFT JOIN DataCity ON (DataAddress.DataCity_ID = DataCity.DataCity_ID) " .
						"LEFT JOIN DataState ON (DataAddress.DataState_ID = DataState.DataState_ID) " .
						"LEFT JOIN DataDistrictTemporal on (DataHouse.DataDistrictTemporal_GroupID = DataDistrictTemporal.DataDistrictTemporal_GroupID) " .
						"LEFT JOIN DataDistrict ON (DataDistrictTemporal.DataDistrict_ID = DataDistrict.DataDistrict_ID) " .		
						"LEFT JOIN DataCounty ON (DataDistrict.DataCounty_ID = DataCounty.DataCounty_ID) " .				
						"WHERE VotersIndexes.VotersIndexes_ID = :SingleIndex";
						
		$sql_vars = array("SingleIndex" => $SingleIndex);		
		return $this->_return_simple($sql, $sql_vars);		
	}
	
	function GetPetitionsForCandidate($CandidateID = 0, $SystemUserID = 0) {

		if ( $CandidateID == 0 && $SystemUserID == 0) return 0;
		
		$sql = "SELECT Candidate.Candidate_ID, Candidate.SystemUser_ID, Candidate.CandidateElection_ID, Candidate.Candidate_Party, " . 
						"Candidate.Candidate_DisplayMap, Candidate.Candidate_DispName, Candidate.Candidate_DispResidence, Candidate.CandidateAptment_ID, " . 
						"Candidate.Candidate_StatementPicFileName, Candidate.Candidate_StatementWebsite, Candidate.Candidate_StatementEmail, " . 
						"Candidate.Candidate_StatementTwitter, Candidate.Candidate_StatementPhoneNumber, Candidate.Candidate_StatementText, " . 
						"Candidate.CandidateElection_DBTable, Candidate.CandidateElection_DBTableValue, Candidate.Candidate_StatsVoters, " . 
						"Candidate.Candidate_Status, Candidate.Candidate_NominatedBy, CandidatePetition.CandidatePetition_ID, CandidatePetition.Candidate_ID, " . 
						"CandidatePetition.FollowUp_ID, CandidatePetition.CandidatePetition_Order, " . 
						"CandidatePetition.VotersIndexes_ID, CandidatePetition.CandidatePetition_VoterFullName, " . 
						"CandidatePetition.CandidatePetition_VoterResidenceLine1, CandidatePetition.CandidatePetition_VoterResidenceLine2, " . 
						"CandidatePetition.CandidatePetition_VoterResidenceLine3, CandidatePetition.CandidatePetition_VoterCounty, CandidatePetition.DataStreet_ID, " . 
						"CandidatePetition.Voters_ResHouseNumber, CandidatePetition.Voters_ResFracAddress, " . 
						"CandidatePetition.Voters_ResPreStreet, CandidatePetition.Voters_ResStreetName, CandidatePetition.Voters_ResPostStDir, " . 
						"CandidatePetition.Voters_ResApartment, CandidatePetition.Voters_Status, CandidatePetition.CandidatePetition_SignedDate " . 
						"FROM Candidate " .
						"LEFT JOIN CandidatePetition ON (CandidatePetition.Candidate_ID = Candidate.Candidate_ID) " .
						// "LEFT JOIN VotersIndexes ON (CandidatePetition.VotersIndexes_ID = VotersIndexes.VotersIndexes_ID) " .
						// "LEFT JOIN Raw_Voter_" . $DatedFiles . " ON (Raw_Voter_" . $DatedFiles . ".Raw_Voter_ID = CandidatePetition.Raw_Voter_DatedTable_ID) " .
						// "LEFT JOIN Raw_Voter_TrnsTable ON (Raw_Voter_TrnsTable.VotersIndexes_ID =  CandidatePetition.VotersIndexes_ID AND Raw_Voter_TrnsTable.Raw_Voter_Dates_ID =  CandidatePetition.Raw_Voter_Dates_ID) " .
						// "LEFT JOIN Raw_Voter ON (Raw_Voter.Raw_Voter_ID =  Raw_Voter_TrnsTable.Raw_Voter_ID) " .
						// "LEFT JOIN DataHouse ON (DataHouse.DataHouse_ID = Raw_Voter_TrnsTable.DataHouse_ID ) " . 
						// "LEFT JOIN DataAddress ON (DataHouse.DataAddress_ID = DataAddress.DataAddress_ID) " . 
						// "LEFT JOIN DataStreet ON (DataAddress.DataStreet_ID = DataStreet.DataStreet_ID) " . 
						// "LEFT JOIN Cordinate ON (DataAddress.Cordinate_ID = Cordinate.Cordinate_ID) " .
						"WHERE " ;
						
		if ( $CandidateID > 0 ) {
			$sql .= "Candidate_ID = :CandidateID";
			$sql_vars["CandidateID"] = $CandidateID;
			if ( $SystemUserID > 0 ) { $sql .= " AND "; }
		}
		
		if ( $SystemUserID > 0 ) {
			$sql .= "SystemUser_ID = :SystemUserID";
			$sql_vars["SystemUserID"] = $SystemUserID;
		}
											
		//	if ( ! empty ($Status)) {
		//		$sql .= " AND Raw_Voter_Status = :Status";
		//		$sql_vars["Status"] = $Status;
		//	} 
			
		//	if ( ! empty ($RegParty)) {
		//		$sql .= " AND Raw_Voter_RegParty = :Party";
		//		$sql_vars["Party"] = $RegParty;
		//	}
		
		$sql .= "	ORDER BY CandidatePetition_Order";
		
		// echo "SQL: $sql<BR>";
		// echo "<PRE>" . print_r($sql_vars, 1) . "</PRE>";
		
		return $this->_return_multiple($sql, $sql_vars);
	}
	
	function GetPetitionSignNames($SystemID, $DateID) {
		$sql = "SELECT * FROM Candidate LEFT JOIN CandidatePetition " .
						"ON (Candidate.Candidate_ID = CandidatePetition.Candidate_ID) " .
						"WHERE SystemUser_ID = :SystemUserID AND " . 
						"CandidatePetition.Raw_Voter_Dates_ID = :DateID";
		$sql_vars = array(":SystemUserID" => $SystemID, ":DateID" => $DateID);
		return $this->_return_multiple($sql, $sql_vars);
	}
	
	
	function SearchRawVoterInfo($UniqNYSVoterID) { 
		$sql = "SELECT * FROM VotersRaw_NY " . 
						"LEFT JOIN DataCounty ON (DataCounty.DataCounty_BOEID = VotersRaw_NY.CountyCode) " .										
						"WHERE UniqNYSVoterID = :Uniq AND Status = 'A'";
		$sql_vars = array("Uniq" => $UniqNYSVoterID);		
		return $this->_return_multiple($sql, $sql_vars);
	}
	
	
	function GetAdminStats() {
		$sql = "SELECT * FROM SystemStats";
		return $this->_return_multiple($sql);		
	}

	function UpdateSystemUserWithVoterCard($SystemUser_ID, $RawVoterID, $UniqNYSVoterID, $ADED, $Party, $VoterCount = 0) {
		$sql = "UPDATE SystemUser SET Voters_UniqStateVoterID = :NYSVoterID, SystemUser_EDAD = :EDAD, SystemUser_Party = :Party, " . 
						"Voters_ID = :Index";
		$sql_vars = array("NYSVoterID" => $UniqNYSVoterID,"EDAD" => $ADED, "ID" => $SystemUser_ID, "Party" => $Party, "Index" => $RawVoterID);


		if ($VoterCount > 0) {
			$sql .= ", SystemUser_NumVoters = :CountVoters ";
			$sql_vars["CountVoters"] = $VoterCount;
		}
		
		$sql .= "WHERE SystemUser_ID = :ID ";
		return $this->_return_nothing($sql, $sql_vars);				
	}
	
	function FindRawVoterbyADED($EDist, $ADist, $Party = "", $Active = 1, $order = 0) {
		
		$sql = "SELECT * FROM " . $TableVoter . 
						// " LEFT JOIN DataStreet ON (DataStreet.DataStreet_Name = Raw_Voter_ResStreetName) " .
						" WHERE " . 
						"Raw_Voter_AssemblyDistr = :AssDist AND Raw_Voter_ElectDistr = :ElectDist ";
					//	"LEFT JOIN Raw_Voter_" . $DatedFiles . " ON (Raw_Voter_ID = Raw_Voter_DatedTable_ID) " .
					//	"LEFT JOIN DataStreet ON (DataStreet.DataStreet_Name = Raw_Voter_ResStreetName)";
						
		$sql_vars = array('AssDist' => $ADist, 'ElectDist' => $EDist);				
		
		if ( $Active == 1) {
			$sql .= "AND (Raw_Voter_Status = 'ACTIVE' OR Raw_Voter_Status = 'INACTIVE') ";
		}
		
		if ( ! empty ($Party)) {
			$sql .= "AND Raw_Voter_EnrollPolParty = :Party ";
			$sql_vars[":Party"] = $Party;
		}
		
		if ( $order > 0) {
			$sql .= "ORDER BY Raw_Voter_ResStreetName, Raw_Voter_ResHouseNumber, Raw_Voter_ResApartment";
		}
		return $this->_return_multiple($sql, $sql_vars);
		
	}
	
	
	function OtherCandidateCoupled($Party) {
		$sql = "SELECT * FROM Candidate WHERE CandidateElection_DBTable != :DBTable AND CandidateElection_DBTable != :DBTable2 " . 
						"AND CandidateElection_DBTable IS NOT NULL AND Candidate_Party = :Party";
		$sql_vars = array("DBTable" => "EDAD", "DBTable2" => "BROKEN", "Party" => $Party);
		return $this->_return_multiple($sql, $sql_vars);
	}

	
	function PrepDisctictVoterRoll($CandidateID, $DatedFiles, $DatedFilesID, $InfoArray) {
	
		$var = $this->FindRawVoterbyADED($DatedFiles, $InfoArray["ElectDistr"],	$InfoArray["AssemblyDistr"],  $InfoArray["Party"], 1, 1);
		$TodayDay = date_create(date("Y-m-d"));
		
    // This is the 
    $Counter = 0;
		$SqlString = "INSERT INTO CandidatePetition " .
									"(Candidate_ID, CandidatePetition_Order, VotersIndexes_ID, Raw_Voter_DatedTable_ID, Raw_Voter_Dates_ID," .
									"CandidatePetition_VoterFullName, Raw_Voter_Gender, CandidatePetition_Age, CandidatePetition_Party, " . 
									"CandidatePetition_VoterResidenceLine1, CandidatePetition_VoterResidenceLine2, " .
									"CandidatePetition_VoterResidenceLine3, CandidatePetition_VoterCounty, DataStreet_ID, Raw_Voter_ResHouseNumber, " .
									"Raw_Voter_ResFracAddress, Raw_Voter_ResPreStreet, Raw_Voter_ResStreetName, Raw_Voter_ResPostStDir, " . 
									"Raw_Voter_ResApartment, Raw_Voter_Status) " .
									"VALUES ";
    
    if ( ! empty ($var)) {
	    foreach ($var as $vor) {
				if (! empty ($vor)) {
					if ( ! empty ($sql)) { $sql .= ","; }
					
					$FullName = $this->DB_ReturnFullName($vor);
     	   	$Address_Line1 = $this->DB_ReturnAddressLine1($vor);
     	  	$Address_Line2 = $this->DB_ReturnAddressLine2($vor);
        
    			// This is awfull but we need to go trought the list to find the VotersIndexes_ID
       		$VoterIndexesID = $this->GetVotersIndexesIDfromNYSCode($vor["Raw_Voter_UniqNYSVoterID"]);
     			$VoterAge = date_diff(date_create($vor["Raw_Voter_DOB"]), $TodayDay)->format("%Y");       		
       		if ( $VoterAge < 1 || $VoterAge > 150) { $VoterAge = 0; }
       		
					$sql .= "(" . $this->_QuoteString($CandidateID) . "," . $this->_QuoteString($Counter++) . "," . $this->_QuoteString($vor["Raw_Voter_ID"]) . "," . 
									$this->_QuoteString($VoterIndexesID["VotersIndexes_ID"]) . "," . $this->_QuoteString($DatedFilesID) . "," . 
									$this->_QuoteString($this->DB_ReturnFullName($vor)) . "," . 
									$this->_QuoteString($vor["Raw_Voter_Gender"]) . "," . $this->_QuoteString($VoterAge) . "," . $this->_QuoteString($vor["Raw_Voter_EnrollPolParty"]) . "," .								
									$this->_QuoteString($this->DB_ReturnAddressLine1($vor)) . "," . 
									$this->_QuoteString($this->DB_ReturnAddressLine2($vor)) . "," . "null," . 
									$this->_QuoteString($this->DB_WorkCounty($vor["Raw_Voter_CountyCode"])) . "," . $this->_QuoteString($vor["DataStreet_ID"]) . "," . 
					 				$this->_QuoteString($vor["Raw_Voter_ResHouseNumber"]) . "," . $this->_QuoteString($vor["Raw_Voter_ResFracAddress"]) . "," . 
					 				$this->_QuoteString($vor["Raw_Voter_ResPreStreet"]) . "," . $this->_QuoteString($vor["Raw_Voter_ResStreetName"]) . "," . 
									$this->_QuoteString($vor["Raw_Voter_ResPostStDir"]) . "," . $this->_QuoteString($vor["Raw_Voter_ResApartment"]) . "," . 
									$this->_QuoteString($vor["Raw_Voter_Status"]) . ")";
					
					if (($Counter % 10000) == 0) {
						if ( ! empty ($sql)) {
							$sql = $SqlString . $sql;
							$this->_return_nothing($sql); 	      
						  $sql = "";
						}
					} 					
				}
				
    	}
    }	
    
    if ( ! empty ($sql)) {
			$sql = $SqlString . $sql;
    	$this->_return_nothing($sql); 	    
		}
		
    return $Counter;
	}

	function UpdateCandidateCounterForVoter($Candidate_ID, $Counter) {
		$sql = "UPDATE Candidate SET Candidate_StatsVoters = :Counter WHERE Candidate_ID = :CandidateID";
		$sql_vars = array("Counter" => $Counter, "CandidateID" => $Candidate_ID);
		return $this->_return_nothing($sql, $sql_vars);
	}
	
	function UpdateElectionCounterForVoter($Election_ID, $Counter) {
		$sql = "UPDATE CandidateElection SET CandidateElection_CountVoter = :Counter WHERE CandidateElection_ID = :CandidateElection_ID";
		$sql_vars = array("Counter" => $Counter, "CandidateElection_ID" => $Election_ID);
		return $this->_return_nothing($sql, $sql_vars);
	}		
	
	
	// This will need to be changed later.
	function GetVotersIndexesIDfromNYSCode($NYSCode) {
		$sql = "SELECT * FROM VotersIndexes WHERE VotersIndexes_UniqNYSVoterID = :NYSCode ORDER BY VotersIndexes_ID LIMIT 1";
		$sql_vars = array("NYSCode" => $NYSCode);
		return $this->_return_simple($sql, $sql_vars);
	}
	
	function GetCountyFromNYSCodes($CountyCode) {
		$sql = "SELECT * FROM DataCounty WHERE DataCounty_ID = :CountyCode";
		$sql_vars = array("CountyCode" => $CountyCode);
		return $this->_return_simple($sql, $sql_vars);
	}
	
	function DB_WorkCounty($CountyID) {
		$County = $this->GetCountyFromNYSCodes($CountyID);
		return $County["DataCounty_Name"];	
	}

	function DB_ReturnAddressLine1($vor) {
		$Address_Line1 = "";
		if ( ! empty ($vor["Raw_Voter_ResHouseNumber"])) { $Address_Line1 .= $vor["Raw_Voter_ResHouseNumber"] . " "; }		
		if ( ! empty ($vor["Raw_Voter_ResFracAddress"])) { $Address_Line1 .= $vor["Raw_Voter_ResFracAddress"] . " "; }		
		if ( ! empty ($vor["Raw_Voter_ResPreStreet"])) { $Address_Line1 .= $vor["Raw_Voter_ResPreStreet"] . " "; }		
		$Address_Line1 .= $vor["Raw_Voter_ResStreetName"] . " ";
		if ( ! empty ($vor["Raw_Voter_ResPostStDir"])) { $Address_Line1 .= $vor["Raw_Voter_ResPostStDir"] . " "; }		
		if ( ! empty ($vor["Raw_Voter_ResApartment"])) { $Address_Line1 .= "- Apt. " . $vor["Raw_Voter_ResApartment"]; }
		$Address_Line1 = preg_replace('!\s+!', ' ', $Address_Line1 );
		return $Address_Line1;
  }
  
  function DB_ReturnAddressLine2($vor) {
  	$Address_Line2 = $vor["Raw_Voter_ResCity"] . ", NY " . $vor["Raw_Voter_ResZip"];
    return $Address_Line2;
  }
	
	function DB_ReturnFullName($vor) {
		$FullName = $vor["Raw_Voter_FirstName"] . " ";
		if ( ! empty ($vor["Raw_Voter_MiddleName"])) { $FullName .= substr($vor["Raw_Voter_MiddleName"], 0, 1) . ". "; }
		$FullName .= $vor["Raw_Voter_LastName"] ." ";
		if ( ! empty ($vor["Raw_Voter_Suffix"])) { $FullName .= $vor["Raw_Voter_Suffix"]; }				
		$FullName = ucwords(strtolower($FullName));
		return $FullName;
	}	

	/* This is for the search of the $VI in the other file */
	function SearchVotersIndexesDB($ArrIndexes) {

		if ( empty ($ArrIndexes)) return 0;
		$sql_index = "";

		foreach ($ArrIndexes as $var) {
			if ( ! empty ($var)) {
				if ( ! empty ($sql_index)) { $sql_index .= " OR "; }
				$sql_index .= "VotersIndexes.VotersIndexes_ID = '" . $var . "'";
			}
		}
	
		$sql = "SELECT * FROM VotersIndexes " .
						"LEFT JOIN DataFirstName ON (DataFirstName.DataFirstName_ID = VotersIndexes.DataFirstName_ID ) " . 
						"LEFT JOIN DataLastName ON (DataLastName.DataLastName_ID = VotersIndexes.DataLastName_ID ) " .
						#"LEFT JOIN Raw_Voter ON (Raw_Voter.Raw_Voter_UniqNYSVoterID = VotersIndexes.VotersIndexes_UniqNYSVoterID) " . 
						#"LEFT JOIN " . $TableVoter . " ON (" . ".Raw_Voter_UniqNYSVoterID = VotersIndexes.VotersIndexes_UniqNYSVoterID) " .		
						"WHERE " . $sql_index;
		
		return $this->_return_multiple($sql);		
	}
	
	Function GetWalkSheetInfo ($DataDistrictID) {
		if ( $DataDistrictID > 0 ) {
			$sql = "SELECT * FROM DataDistrict " .
						"LEFT JOIN DataDistrictTemporal ON " . 
						"(DataDistrictTemporal.DataDistrict_ID = DataDistrict.DataDistrict_ID) " .
						"LEFT JOIN DataDistrictCycle ON " .
						"(DataDistrictCycle.DataDistrictCycle_ID = DataDistrictTemporal.DataDistrictCycle_ID) " . 
						"WHERE DataDistrict.DataDistrict_ID = :District";
			$sql_vars = array("District" => $DataDistrictID);
			return $this->_return_multiple($sql, $sql_vars);					
		}		
	}
	
	
	function ListEDByDistricts($DistrictCycle, $DistrictType, $DistrictValue)	{
		$sql = "SELECT DISTINCT DataDistrict.DataDistrict_ID, DataDistrict_Electoral AS ED, DataDistrict_StateAssembly AS AD ";
	
		switch ($DistrictType) {
			case "AD":
				$sql .= ", DataDistrict_StateAssembly AS District ";
				$sql_vars = array("CycleID" => $DistrictCycle, "AD" => $DistrictValue);
				$sql_query = "AND DataDistrict_StateAssembly = :AD ";
				break;
			
			case "CG":
				$sql .= ", DataDistrict_Congress AS District ";
				$sql_vars = array("CycleID" => $DistrictCycle, "CG" => $DistrictValue);
				$sql_query = "AND DataDistrict_Congress = :CG ";
				break;
				
			case "SN":
				$sql .= ", DataDistrict_SenateSenate AS District ";
				$sql_vars = array("CycleID" => $DistrictCycle, "SN" => $DistrictValue);
				$sql_query = "AND DataDistrict_SenateSenate = :SN ";
				break;
		}
		
		$sql .= "FROM RepMyBlock.DataDistrict " . 
						"LEFT JOIN DataDistrictTemporal ON " . 
						"(DataDistrictTemporal.DataDistrict_ID = DataDistrict.DataDistrict_ID) " .
						"LEFT JOIN DataDistrictCycle ON " .
						"(DataDistrictCycle.DataDistrictCycle_ID = DataDistrictTemporal.DataDistrictCycle_ID) ";
		
		$sql .= "WHERE DataDistrictCycle.DataDistrictCycle_ID = :CycleID ";
		$sql .= $sql_query;		
		$sql .= "ORDER BY DataDistrict_StateAssembly, DataDistrict_Electoral";
	
		return $this->_return_multiple($sql, $sql_vars);
	}
	
	

	function ListRawNYEDByDistricts( $DistrictType, $DistrictValue)	{
	
		$sql = "SELECT AssemblyDistr AS AD, ElectDistr AS ED";

		switch ($DistrictType) {
			case "AD":
				$sql .= ", AssemblyDistr AS District ";
				$sql_vars = array( "AD" => $DistrictValue);
				$sql_query = "AND AssemblyDistr = :AD ";
				$sql_group = "GROUP BY ElectDistr";
				break;
			
			case "CG":
				$sql .= ", CongressDistr AS District ";
				$sql_vars = array( "CG" => $DistrictValue);
				$sql_query = "AND CongressDistr = :CG ";
				$sql_group = "GROUP BY ElectDistr, AssemblyDistr";
				break;
				
			case "SN":
				$sql .= ", SenateDistr AS District ";
				$sql_vars = array( "SN" => $DistrictValue);
				$sql_query = "AND SenateDistr = :SN ";
				$sql_group = "GROUP BY ElectDistr, AssemblyDistr";
				break;
		}
		
		$sql .= "FROM VotersRaw_NY WHERE Status = 'A' ";
		$sql .= $sql_query;		
		$sql .= $sql_group . " ORDER BY AssemblyDistr, CAST(ElectDistr as unsigned)";
	
		return $this->_return_multiple($sql, $sql_vars);
	}
	
	
	function SearchUserVoterCard($SystemUserID) {
		$sql = "SELECT * FROM SystemUser " .
						"LEFT JOIN Voters ON (Voters.Voters_ID = SystemUser.Voters_ID) " . 
						"LEFT JOIN VotersIndexes ON (VotersIndexes.VotersIndexes_ID = Voters.VotersIndexes_ID) " .
						"LEFT JOIN DataState ON (DataState.DataState_ID = VotersIndexes.DataState_ID) " .
						"LEFT JOIN DataLastName ON (DataLastName.DataLastName_ID = VotersIndexes.DataLastName_ID) " .  
						"LEFT JOIN DataFirstName ON (DataFirstName.DataFirstName_ID = VotersIndexes.DataFirstName_ID) " .  
						"LEFT JOIN DataMiddleName ON (DataMiddleName.DataMiddleName_ID = VotersIndexes.DataMiddleName_ID) " .
						"LEFT JOIN DataHouse ON (Voters.DataHouse_ID = DataHouse.DataHouse_ID) " .
						"LEFT JOIN DataAddress ON (DataAddress.DataAddress_ID = DataHouse.DataAddress_ID) " .
						"LEFT JOIN DataStreet ON (DataAddress.DataStreet_ID = DataStreet.DataStreet_ID) " .
						"LEFT JOIN DataCity ON (DataCity.DataCity_ID = DataAddress.DataCity_ID) " .
						"LEFT JOIN DataDistrictTemporal on (DataHouse.DataDistrictTemporal_GroupID = DataDistrictTemporal.DataDistrictTemporal_GroupID) " .
						"LEFT JOIN DataDistrict ON (DataDistrictTemporal.DataDistrict_ID = DataDistrict.DataDistrict_ID) " .		
						"LEFT JOIN DataCounty ON (DataDistrict.DataCounty_ID = DataCounty.DataCounty_ID) " .
						"LEFT JOIN SystemUserSelfDistrict ON (SystemUser.SystemUser_ID = SystemUserSelfDistrict.SystemUser_ID) " . 
						"WHERE SystemUser.SystemUser_ID = :SystemID";
		$sql_vars = array("SystemID" => $SystemUserID);		
		return $this->_return_simple($sql, $sql_vars);
	}
	
	function UpdateSystemSetPriv($SystemUserID, $PrivModification) {
		if ( $SystemUserID > 0 ) {
			$sql = "UPDATE SystemUser SET SystemUser_Priv = :AddPriv WHERE SystemUser_ID = :SystemID";
			$sql_vars = array("SystemID" => $SystemUserID, "AddPriv" => $PrivModification);
			return $this->_return_nothing($sql, $sql_vars);
		}
	}
	
	function UpdateSystemPriv($SystemUserID, $PrivModification) {
		if ( $SystemUserID > 0 ) {
			$sql = "UPDATE SystemUser SET SystemUser_Priv = SystemUser_Priv";
			
			if ($PrivModification >= 0) {
				$sql .= " | ";
			} else {
				$sql .= " & ~";
			}
						 
			$sql .= ":AddPriv WHERE SystemUser_ID = :SystemID";
			$sql_vars = array("SystemID" => $SystemUserID, "AddPriv" => $PrivModification);
			return $this->_return_nothing($sql, $sql_vars);
		}
	}
	
	function CreateSystemUserAndUpdateProfile($TempEmail, $ProfileArray = "", $Person = "") {
		
		$sql = "INSERT INTO SystemUser (SystemUser_email, SystemUser_emailverified, SystemUser_username, SystemUser_password, " . 
																		"SystemUser_emaillinkid, SystemUser_createtime, SystemUser_lastlogintime, SystemUser_Priv"; 
		$sql_vars = array("TempEmail" => $TempEmail);
																		
		if ( ! empty ($ProfileArray["Change"]["SystemUser_FirstName"])) { $sql .= ", SystemUser_FirstName"; $sql_vars["FirstName"] = $ProfileArray["Change"]["SystemUser_FirstName"]; }
		if ( ! empty ($ProfileArray["Change"]["SystemUser_LastName"])) { $sql .= ", SystemUser_LastName"; $sql_vars["LastName"] = $ProfileArray["Change"]["SystemUser_LastName"]; }
																		
		$sql .= ") " .
					 "SELECT SystemUserTemporary_email, SystemUserTemporary_emailverified, SystemUserTemporary_username, " . 
									"SystemUserTemporary_password, SystemUserTemporary_emaillinkid, NOW(), NOW(), " . (PERM_MENU_PROFILE + PERM_MENU_SUMMARY + PERM_MENU_DOCU);
									
		if ( ! empty ($ProfileArray["Change"]["SystemUser_FirstName"])) { $sql .= ", :FirstName"; }
		if ( ! empty ($ProfileArray["Change"]["SystemUser_LastName"])) { $sql .= ", :LastName"; }
									
		$sql .= " FROM SystemUserTemporary WHERE SystemUserTemporary_email = :TempEmail"; 
		$this->_return_nothing($sql, $sql_vars);		
	
		$sql = "SELECT LAST_INSERT_ID() as SystemUser_ID";
		$ret = $this->_return_simple($sql);

		$sql = "UPDATE SystemUserTemporary SET SystemUser_ID = :SystemUserID,  SystemUserTemporary_password = null, SystemUserTemporary_emaillinkid = null WHERE SystemUserTemporary_email = :TempEmail"; 
		$sql_vars = array("TempEmail" => $TempEmail, "SystemUserID" => $ret["SystemUser_ID"]);
		$this->_return_nothing($sql, $sql_vars);	
		
		$this->SaveInscriptionRecord ($TempEmail, $Username, "convert", $ret["SystemUser_ID"]);	
		return $this->FindPersonUserProfile($ret["SystemUser_ID"]);
		
	}
	
	function SaveInscriptionRecord ($Email, $Username, $Type = "Other", $SystemUserID = NULL) {
		$sql = "INSERT INTO SystemUserVoter SET SystemUserVoter_Username = :Username, " .
						"SystemUserVoter_Email = :Email, SystemUserVoter_action = :Type, " . 
						"SystemUserVoter_Date = NOW(), SystemUserVoter_IP = :IP, SystemUser_ID = :SystemUserID";
		$sql_vars = array('Email' => $Email, 'Username' => $Username, 'Type' => $Type, 'IP' => $_SERVER['REMOTE_ADDR'], 'SystemUserID' => $SystemUserID);
		return $this->_return_nothing($sql,  $sql_vars);
	}
	
	
	function SearchUsers($UserID = NULL) {	
		$sql = "SELECT * FROM SystemUser";
		
		if ( ! empty ($UserID)) {
			$sql .= " WHERE SystemUser_ID = :UserID";
			$sql_vars = array ("UserID" => $UserID);
			return $this->_return_simple($sql, $sql_vars);
		}
		
		return $this->_return_multiple($sql);
	}	
	
	function SearchTempUsers($UserID = NULL) {	
		$sql = "SELECT * FROM SystemUserTemporary";
		
		if ( ! empty ($UserID)) {
			$sql .= " WHERE SystemUserTemporary_ID = :UserID";
			$sql_vars = array ("UserID" => $UserID);
			return $this->_return_simple($sql, $sql_vars);
		}
		
		return $this->_return_multiple($sql);
	}	
	
	function UpdateTempDistrict($Type, $SystemUser_ID, $AD, $ED, $CG, $SN, $SystemID = NULL) {
		
		switch($Type) {
			case "insert":
				$sql = "INSERT INTO SystemUserSelfDistrict SET ";
				break;
				
			case "update":
				$sql = "UPDATE SystemUserSelfDistrict SET ";
				$sql_end = " WHERE SystemUserSelfDistrict_ID = :SysDisID";
				$sql_vars = array("SysDisID" => $SystemID);
				break;
		}
	
		// There will be a bug to fix which is how to delete an entry. - Need to think about it.
		if (empty ($sql)) return $this->FindTemporaryDistrict($SystemUserID);			
		if (! empty ($AD)) { $sql .= "SystemUserSelfDistrict_AD = :AD"; $sql_vars["AD"] = intval($AD); $comma = 1;}
		if ($comma == 1) { $sql .= ", "; $comma = 0; }
		if (! empty ($ED)) { $sql .= "SystemUserSelfDistrict_ED = :ED"; $sql_vars["ED"] = intval($ED); $comma = 1;}
		if ($comma == 1) { $sql .= ", "; $comma = 0; }
		if (! empty ($CG)) { $sql .= "SystemUserSelfDistrict_CG = :CG"; $sql_vars["CG"] = intval($CG); $comma = 1;}
		if ($comma == 1) { $sql .= ", "; $comma = 0; }
		if (! empty ($SN)) { $sql .= "SystemUserSelfDistrict_SN = :SN"; $sql_vars["SN"] = intval($SN); $comma = 1;}
		if ($comma == 1) { $sql .= ", "; $comma = 0; }		
		if (! empty ($SystemUser_ID)) { $sql .= "SystemUser_ID = :SystemUser_ID"; $sql_vars["SystemUser_ID"] = $SystemUser_ID;}

		$sql .= $sql_end;
		return $this->_return_nothing($sql, $sql_vars);
	}
	
	function FindTemporaryDistrict($SystemUserID) {
		$sql = "SELECT * FROM SystemUserSelfDistrict WHERE SystemUser_ID = :SystemUserID";
		$sql_vars = array("SystemUserID" => $SystemUserID);
		return $this->_return_simple($sql, $sql_vars);
	}
	
	
	function ReturnPrivCodes () {
		$sql = "SELECT * FROM AdminCode";
		return $this->_return_multiple($sql);
	}	
	
	
	/* Custom SQL Statement to minimize the number of question based on logic. */
		
	// The input is an array with array of stuff that changed + Person is the stuff coming
	// from FindPersonUserProfile. If populate I won't have to call it again. 
	// If there is a field called Change, then we change those field in SystemUser
	
	function UpdatePersonUserProfile($SystemUserID, $ProfArray = "", $Person = "") {
		
		// This is for the normal information.
		if ( ! empty ($ProfArray["Change"])) {
			$add_coma = 0;
			$sql_vars = array("SystemUser" => $SystemUserID);

			$sql = "UPDATE SystemUser SET ";
			if ( ! empty ($ProfArray["Change"]["SystemUser_FirstName"] )) {
				$sql .= "SystemUser_FirstName = :FirstName";
				$sql_vars["FirstName"] = $ProfArray["Change"]["SystemUser_FirstName"];
				$add_coma = 1;
				$Person["SystemUser_FirstName"] = $ProfArray["Change"]["SystemUser_FirstName"];
			}

			if ( ! empty ($ProfArray["Change"]["SystemUser_LastName"] )) {
				if ( $add_coma == 1 ) { $sql .= ", "; }
				$sql .= "SystemUser_LastName = :LastName";
				$sql_vars["LastName"] = $ProfArray["Change"]["SystemUser_LastName"];
				$add_coma = 1;
				$Person["SystemUser_LastName"] = $ProfArray["Change"]["SystemUser_LastName"];
			}
			
			$sql .= " WHERE SystemUser_ID = :SystemUser";
			
			$this->_return_nothing($sql, $sql_vars);
		}
		
		// This is the rest of the BIO, we'll need to create a for loop.
		// This also make the assumption that 
		
		if ( empty ($Person["SystemUserProfile_ID"])) {
			$sql = "INSERT INTO SystemUserProfile SET ";
		} else {
			$sql = "UPDATE SystemUserProfile SET ";
		}
		
		$add_coma = 0;
		$sql_vars = array();
		if ( ! empty ($ProfArray["bio"])) {
			$sql .= "SystemUserProfile_bio = :bio ";
			$sql_vars["bio"] = $ProfArray["bio"];
			$add_coma = 1;
			$Person["SystemUserProfile_bio"] = $ProfArray["bio"];
		}
		
		if ( ! empty ($ProfArray["URL"])) {
			if ( $add_coma == 1 ) { $sql .= ", "; }
			$sql .= "SystemUserProfile_URL = :URL ";
			$sql_vars["URL"] = $ProfArray["URL"];
			$add_coma = 1;
			$Person["SystemUserProfile_URL"] = $ProfArray["URL"];
		}
		
		if ( ! empty ($ProfArray["Location"])) {
			if ( $add_coma == 1 ) { $sql .= ", "; }
			$sql .= "SystemUserProfile_Location = :Location ";
			$sql_vars["Location"] = $ProfArray["Location"];
			$add_coma = 1;
			$Person["SystemUserProfile_Location"] = $ProfArray["Location"];
		}
	
		if ( $add_coma == 1) {
	
			if ( ! empty ($Person["SystemUserProfile_ID"])) {	
				$sql .= "WHERE SystemUserProfile_ID = :SystemProfileID";
				
				$sql_vars["SystemProfileID"] = $Person["SystemUserProfile_ID"];
				$this->_return_nothing($sql, $sql_vars);
				
			} else {
				
				$this->_return_nothing($sql, $sql_vars);
				$sql = "SELECT LAST_INSERT_ID() as SystemUserProfile_ID";
				$ret = $this->_return_simple($sql);
			}
		}	

		// Check that email is not double.
		if ( ! empty ($ProfArray["Special"]["SystemUser_email"])) {
			$ret_email = $this->CheckRegisterEmail ($ProfArray["Special"]["SystemUser_email"]);
			if ( empty ($ret_email)) {
				$Person["ChangeEmail"] = 1;
				$ChangeEmailOK = 1;
			} else {
				$Person["ChangeEmail"] = -1;
				$Person["EmailToChangeTo"] = $ProfArray["Special"]["SystemUser_email"];
				$ChangeEmailOK = 0;
			}
		}			

		if ( $ChangeEmailOK == 1 || empty ($Person["SystemUserProfile_ID"])) {						
			$add_coma = 0;		
			// This is to deal with the complicate stuff.
			$sql = "UPDATE SystemUser SET ";
			$sql_vars = array("SystemID" => $SystemUserID);
		
			if ( empty ($Person["SystemUserProfile_ID"])) {
				// Update the profile
				$sql .= "SystemUserProfile_ID = :SystemUserProfileID ";
				$sql_vars["SystemUserProfileID"] = $ret["SystemUserProfile_ID"];	
				$add_coma = 1;
			}
			
			if ( $ChangeEmailOK == 1 ) {
				if ( $add_coma == 1 ) { $sql .= ", "; }
				$sql .= "SystemUser_email = :SystemEmail, SystemUser_emailverified = 'no', " .
								"SystemUser_emaillinkid = :EmailLinkID ";
				
				$sql_vars["EmailLinkID"] = $ProfArray["Special"]["SystemUser_emaillinkid"];
				$sql_vars["SystemEmail"] = $ProfArray["Special"]["SystemUser_email"];	
				$add_coma = 1;
			}			

			$sql .= "WHERE SystemUser_ID = :SystemID";	
			$this->_return_nothing($sql, $sql_vars);
					
			if ($ChangeEmailOK == 1) {
				$this->AddIntoOldEmailTable($ProfArray["Special"]["SystemUser_email"], $Person["SystemUser_email"], 
																		$Person["SystemUser_emailverified"], $SystemUserID);				
				$Person["SystemUser_email"] = $ProfArray["Special"]["SystemUser_email"];
				$Person["SystemUser_emailverified"] = 'no';
				$Person["SystemUser_emaillinkid"] = $ProfArray["Special"]["SystemUser_emaillinkid"];
			}
		}
		
		if ( empty ($Person["SystemUserProfile_ID"])) {
			$Person["SystemUserProfile_ID"] = $ret["SystemUserProfile_ID"];
		}
		 
		return $Person;
	}
	
	
}

?>

