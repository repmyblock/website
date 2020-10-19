<?php	  	
require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/mysql/queries.php";
global $DB;

class RepMyBlock extends queries {

  function RepMyBlock ($debug = 0, $DBFile = "DB_OutragedDems") {
	  require $_SERVER["DOCUMENT_ROOT"] . "/../statlib/DBsLogins/" . $DBFile . ".php";
	  $DebugInfo["DBErrorsFilename"] = $DBErrorsFilename;
	  $DebugInfo["Flag"] = $debug;
	  $this->queries($databasename, $databaseserver, $databaseport, $databaseuser, $databasepassword, $sslkeys, $DebugInfo);
  }
  
  function SearchUsers($DateFile) {
  	$sql = "SELECT * FROM SystemUser " .
  					"LEFT JOIN Raw_Voter_" . $DateFile . " ON (Raw_Voter_" . $DateFile . ".Raw_Voter_UniqNYSVoterID = SystemUser.Raw_Voter_UniqNYSVoterID)";
  	$sql_vars = array();
  	return $this->_return_multiple($sql, $sql_vars);
  }
  
  function FindVotersInRawForEDAD($ADED, $Party, $DateFile) {  	
  	preg_match('/(\d\d)(\d\d\d)/', $ADED, $Keywords);		
		$sql = "SELECT * FROM Raw_Voter_" . $DateFile . " WHERE " .
						"Raw_Voter_ElectDistr = :ED AND Raw_Voter_AssemblyDistr = :AD AND Raw_Voter_EnrollPolParty = :PARTY " .
						"AND (Raw_Voter_Status = 'ACTIVE' OR Raw_Voter_Status = 'INACTIVE')";
		$sql_vars = array("ED" =>  intval($Keywords[2]), "AD" => intval($Keywords[1]), "PARTY" => $Party);	
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
	
	function SearchVoterDBbyID($DatedFiles, $RawVoterID) {
		$TableVoter = "Raw_Voter_" . $DatedFiles;
		$sql = "SELECT * FROM " . $TableVoter . " WHERE " . 
		"Raw_Voter_ID = :RawVoterID";
		$sql_vars = array('RawVoterID' => $RawVoterID);							
		return $this->_return_multiple($sql, $sql_vars);
	}
	
	function FindSystemUserVoter($RawVoterID) {
		$sql = "SELECT * FROM SystemUserVoter WHERE Raw_Voter_ID = :RawVoterID";
		$sql_vars = array('RawVoterID' => $RawVoterID);							
		return $this->_return_multiple($sql, $sql_vars);
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
						"LEFT JOIN VotersFirstName ON (VotersFirstName.VotersFirstName_ID = VotersIndexes.VotersFirstName_ID ) " . 
						"LEFT JOIN VotersLastName ON (VotersLastName.VotersLastName_ID = VotersIndexes.VotersLastName_ID ) " .
						"LEFT JOIN " . $TableVoter  . " ON (" . $TableVoter . ".Raw_Voter_UniqNYSVoterID = VotersIndexes.VotersIndexes_UniqNYSVoterID) " . 
						"WHERE VotersFirstName_Compress = :FirstName AND " . 
						"VotersLastName_Compress = :LastName " . #AND Raw_Voter_Dates_ID = :TableID " .
						"AND VotersIndexes_DOB = :DOB"; // AND Raw_Voter_Status = :Status"
						;
		$sql_vars = array('FirstName' => $CompressedFirstName,
											'LastName' => $CompressedLastName,
											'DOB' => $DOB);
											// 'Status' => $Status); 
											//,'TableID' => $TableID);
											
	
		return $this->_return_multiple($sql, $sql_vars);
	}
	
	function VoterRanCandidate($RawVoterID, $DatedFiles) {
		$TableVoter = "Raw_Voter_" . $DatedFiles;
		$sql = "SELECT * FROM " . $TableVoter . " " .
						"LEFT JOIN DataCounty ON ( Raw_Voter_CountyCode = DataCounty.DataCounty_ID) " . 
						"LEFT JOIN Candidate ON (Candidate.Raw_Voter_ID = " . $TableVoter . ".Raw_Voter_ID AND Raw_Voter_DatedTable_ID = :DatedFiles) " .
						"LEFT JOIN CanPetitionSet ON (CanPetitionSet.Candidate_ID = Candidate.Candidate_ID) " .
						"WHERE " . 
						$TableVoter . ".Raw_Voter_ID = :RawVoterID";
		$sql_vars = array('DatedFiles' => $DatedFiles, 'RawVoterID' => $RawVoterID);			
		return $this->_return_multiple($sql, $sql_vars);		
	}
	
	function SearchCandidateInArea($DatedFiles, $RawVoterID) {
		$TableVoter = "Raw_Voter_" . $DatedFiles;
		$sql = "SELECT * FROM " . $TableVoter . " " .
						"LEFT JOIN Raw_Voter ON (Raw_Voter.Raw_Voter_TableDate_ID = " . $TableVoter . ".Raw_Voter_ID) " .
						"LEFT JOIN CandidatePetition ON (CandidatePetition.Raw_Voter_ID = Raw_Voter.Raw_Voter_ID) " . 
						"LEFT JOIN Candidate ON (Candidate.Candidate_ID = CandidatePetition.Candidate_ID) " .		
						"WHERE " . 
						"Raw_Voter.Raw_Voter_ID = :RawVoterID";
		$sql_vars = array('RawVoterID' => $RawVoterID);									
		return $this->_return_multiple($sql, $sql_vars);
	}
	
	
	function SearchVoter_Dated_DB($UniqNYSVoterID, $DatedFiles, $DatedFilesID, $FirstName, $LastName, $DOB = NULL, 
																$zip = NULL, $countyid = NULL, $Party = NULL, $AD = NULL, $ED = NULL, $Congress = NULL) {
		$this->SaveVoterRequest($FirstName, $LastName, $DOB, $DatedFilesID, NULL, $UniqNYSVoterID, $_SERVER['REMOTE_ADDR'] );		
		$TableVoter = "Raw_Voter_" . $DatedFiles;
		$sql = "SELECT * FROM " . $TableVoter . " " . 
						"LEFT JOIN DataCounty ON ( Raw_Voter_CountyCode = DataCounty.DataCounty_ID) " . 
						"WHERE Raw_Voter_LastName = :LastName ";						
		$sql_vars = array('LastName' => $LastName);

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
	
	function SearchVoter_Dated_NYSBOEID($UniqNYSVoterID, $DatedFiles, $DatedFilesID, $NYSBOEID) {
		$this->SaveVoterRequest("NYS BOE ID", $NYSBOEID, $DOB, $DatedFilesID, NULL, $UniqNYSVoterID, $_SERVER['REMOTE_ADDR'] );		
		$TableVoter = "Raw_Voter_" . $DatedFiles;
		$sql = "SELECT * FROM " . $TableVoter . " " .
						"LEFT JOIN DataCounty ON ( Raw_Voter_CountyCode = DataCounty.DataCounty_ID) " . 
						"WHERE Raw_Voter_UniqNYSVoterID = :NYSBOEID";
		$sql_vars = array('NYSBOEID' => $NYSBOEID);
		
		return $this->_return_multiple($sql, $sql_vars);
	}

	function ReturnGroupAD_Dated_DB($UniqNYSVoterID, $DatedFiles, $DatedFilesID, $PARTY, $AD, $ED = NULL) { 
		$this->SaveVoterRequest("AD: " . $AD, "GROUP", $DOB, $DatedFilesID, NULL, $UniqNYSVoterID, $_SERVER['REMOTE_ADDR'] );		
		$TableVoter = "Raw_Voter_" . $DatedFiles;

		$sql_vars = array('AD' => $AD, 'Party' => $PARTY);
		$sql = "SELECT COUNT(*) AS Count, Raw_Voter_EnrollPolParty, Raw_Voter_AssemblyDistr, Raw_Voter_ElectDistr " . 
						"FROM " . $TableVoter . " " . 
					 	"WHERE Raw_Voter_AssemblyDistr = :AD AND Raw_Voter_EnrollPolParty = :Party" ;
		if ( ! empty ($ED)) {
			$sql .= " AND Raw_Voter_ElectDistr = :ED";
			$sql_vars["ED"] = $ED;
		}			 
					 
		$sql .= " AND (Raw_Voter_Status = 'ACTIVE' OR Raw_Voter_Status = 'INACTIVE')" .
					 " GROUP BY Raw_Voter_AssemblyDistr, Raw_Voter_ElectDistr ";
	 	$sql .= " ORDER BY CAST(Raw_Voter_ElectDistr AS unsigned) ASC";
	 	
		return $this->_return_multiple($sql, $sql_vars);
	}

	function SearchByAD_Dated_DB($UniqNYSVoterID, $DatedFiles, $DatedFilesID, $PARTY, $AD, $ED = NULL) { 
		$this->SaveVoterRequest("AD: " . $AD, "ED: " . $ED, NULL, $DatedFilesID, NULL, $UniqNYSVoterID, $_SERVER['REMOTE_ADDR'] );		
		$TableVoter = "Raw_Voter_" . $DatedFiles;
		
		// Need to move party so I can have an empty request for the general.
		$sql = "SELECT * FROM " . $TableVoter . " WHERE Raw_Voter_EnrollPolParty = :Party AND " . 
					"Raw_Voter_AssemblyDistr = :AD";
		$sql_vars = array('AD' => $AD, 'Party' => $PARTY);
		if ( ! empty ($ED)) {
			$sql .= " AND Raw_Voter_ElectDistr = :ED";
			$sql_vars["ED"] = $ED;
		} else {
			$sql .= " GROUP BY Raw_Voter_ElectDistr";
		}
		
		return $this->_return_multiple($sql, $sql_vars);
	}


	function SaveVoterRequest($FirstName, $LastName, $DateOfBirth, $DatedFilesID, $Email, $UniqNYSVoterID, $IP) {
		$sql = "INSERT INTO SaveVoterRequest SET SaveVoterRequest_FirstName = :FirstName, " .
		 				"SaveVoterRequest_LastName = :LastName, SaveVoterRequest_DateOfBirth = :DateOfBirth, " .
    				"SaveVoterRequest_DatedFileID = :DatedFilesID, SaveVoterRequest_Email = :Email, " .
    				"SaveVoterRequest_UniqNYSVoterID = :UniqNYSVoterID, SaveVoterRequest_IP = :IP, SaveVoterRequest_Date = NOW()";

		$sql_vars = array("FirstName" => $FirstName, "LastName" => $LastName, 
											"DateOfBirth" => $DateOfBirth, "DatedFilesID" => $DatedFilesID,
    									"Email" => $Email, "UniqNYSVoterID" => $UniqNYSVoterID,
    									"IP" => $IP);
		return $this->_return_nothing($sql, $sql_vars);
	}

	function SearchVoterDB($FirstName, $LastName, $DOB, $TableID = "", $Status = "") {

		$CompressedFirstName = preg_replace("/[^a-zA-Z]+/", "", $FirstName);
		$CompressedLastName = preg_replace("/[^a-zA-Z]+/", "", $LastName);
		
		$sql = "SELECT * FROM VotersIndexes " .
						"LEFT JOIN VotersFirstName ON (VotersFirstName.VotersFirstName_ID = VotersIndexes.VotersFirstName_ID ) " . 
						"LEFT JOIN VotersLastName ON (VotersLastName.VotersLastName_ID = VotersIndexes.VotersLastName_ID ) " .
						"LEFT JOIN Raw_Voter ON (Raw_Voter.Raw_Voter_UniqNYSVoterID = VotersIndexes.VotersIndexes_UniqNYSVoterID) " . 
						"WHERE VotersFirstName_Compress = :FirstName AND " . 
						"VotersLastName_Compress = :LastName " . #AND Raw_Voter_Dates_ID = :TableID " .
						"AND VotersIndexes_DOB = :DOB"; // AND Raw_Voter_Status = :Status"
						;
		$sql_vars = array('FirstName' => $CompressedFirstName, 
											'LastName' => $CompressedLastName, 
											'DOB' => $DOB);
											// 'Status' => $Status); 
											//,'TableID' => $TableID);
		
		return $this->_return_multiple($sql, $sql_vars);		
	}

	function ListElectedPositions($state) {
		$sql = "SELECT * FROM CandidatePositions " . 
						"WHERE CandidatePositions_State = :State " . 
						"ORDER BY CandidatePositions_Order";
		$sql_vars = array('State' => $state);
		return $this->_return_multiple($sql, $sql_vars);
	}
	
	function DisplayElectionPositions($ID) {
		$sql = "SELECT * FROM CandidatePositions " . 
						"WHERE CandidatePositions_ID = :ID ";
		$sql_vars = array('ID' => $ID);
		return $this->_return_simple($sql, $sql_vars);
	}
	
	function ListCandidatePetitions($Date) {
		$sql = "SELECT * FROM CandidatePetitionSet " . 
						"LEFT JOIN CanPetitionSet ON (CanPetitionSet.CandidatePetitionSet_ID = CandidatePetitionSet.CandidatePetitionSet_ID) " .
						"LEFT JOIN Candidate ON (Candidate.Candidate_ID = CanPetitionSet.Candidate_ID) " .
						"LEFT JOIN DataCounty ON (CanPetitionSet.DataCounty_ID = DataCounty.DataCounty_ID) " .
						"LEFT JOIN CandidatePositions ON (CandidatePositions.CandidateElection_DBTable = Candidate.CandidateElection_DBTable) " .
						"WHERE CandidatePetitionSet_TimeStamp > :Date " . 
						"ORDER BY CandidatePetitionSet.CandidatePetitionSet_ID DESC";
		$sql_vars = array('Date' => $Date);
		return $this->_return_multiple($sql, $sql_vars);
	}

	function SearchVoterDBbyNYSID($ID, $DatedFiles) {
		$TableVoter = "Raw_Voter_" . $DatedFiles;
		$sql = "SELECT * FROM " . $TableVoter . " " .
						"LEFT JOIN DataCounty ON (Raw_Voter_" . $DatedFiles . ".Raw_Voter_CountyCode = DataCounty.DataCounty_ID) " .
						"WHERE Raw_Voter_UniqNYSVoterID = :ID";
		$sql_vars = array('ID' => $ID);							
		
		// $result = $this->_return_multiple($sql, $sql_vars);
		// return $result;
		return $this->_return_multiple($sql, $sql_vars);
	}
	
	function SearchLocalRawDBbyNYSID($UniqNYSID) {
		$sql = "SELECT * FROM Raw_Voter WHERE Raw_Voter_UniqNYSVoterID = :ID ";  #AND Raw_Voter_Dates_ID = :Dates " .
						#"AND Raw_Voter_Status = :Status";
		
		$sql_vars = array('ID' => $UniqNYSID); #,  'Status' => $Status);		# ,'Dates' => $DatedFilesID);
		return $this->_return_multiple($sql, $sql_vars);
	}
	
	function ListCandidateInformation($SystemUserID) {
		$sql = "SELECT * FROM Candidate " . 
						"LEFT JOIN CanPetitionSet ON (Candidate.Candidate_ID = CanPetitionSet.Candidate_ID) " . 
						"WHERE SystemUser_ID = :SystemUserID";
		$sql_vars = array('SystemUserID' => $SystemUserID);
		return $this->_return_multiple($sql, $sql_vars);
	}
	
	function ListElections($SomeVariable) {
		$sql = "SELECT * FROM CandidateElection " . 
						"LEFT JOIN Candidate ON (CandidateElection.CandidateElection_ID = Candidate.CandidateElection_ID)";
					
		return $this->_return_multiple($sql);
	}
	
	function ListElectionsDates ($limit = 50, $start = 0) {
		$sql = "SELECT * FROM Elections ORDER BY Elections_Date DESC, Elections_Type LIMIT $start, $limit";
		return $this->_return_multiple($sql);
	}
	
	function CandidateElection($DBTable, $DBTableValue , $FromDate) {
		$sql = 	"SELECT * FROM NYSVoters.CandidateElection " .
						"LEFT JOIN Elections ON (Elections.Elections_ID = CandidateElection.Elections_ID) " .
						"WHERE Elections_Date > :FromDate AND CandidateElection_DBTable = :DBTable AND " . 
						"CandidateElection_DBTableValue = :DBValue";
				
		$sql_vars = array('FromDate' => $FromDate, 'DBTable' => $DBTable, 'DBValue' => $DBTableValue);						
		return $this->_return_multiple($sql, $sql_vars);
	}

	function ListCandidateNomination($SystemUserID) {
		$sql = "SELECT * FROM CanNomination WHERE SystemUser_ID = :SystemUserID";
		$sql_vars = array('SystemUserID' => $SystemUserID);
		
	}
	
	function InsertCandidateSet($Candidate_ID, $CandidatePetitionSet_ID, $CanPetitionSet_Party, $DataCounty_ID) {
		$sql = "INSERT INTO CanPetitionSet SET " .
						"CandidatePetitionSet_ID = :CanPetSetID, Candidate_ID = :CandidateID, " .
						"DataCounty_ID = :CountyID, CanPetitionSet_Party = :Party";
		$sql_vars = array("CanPetSetID" => $CandidatePetitionSet_ID, "CandidateID" => $Candidate_ID, 
											"CountyID" => $DataCounty_ID, "Party" => $CanPetitionSet_Party);			
		$this->_return_nothing($sql, $sql_vars);
		
		$sql = "SELECT LAST_INSERT_ID() as CanPetitionSet_ID";
		return $this->_return_simple($sql);
	}
	
	function InsertCandidate($SystemUserID, $UniqNYSVoterID, $RawVoterID, $RawDatedTable, 
														$RawDatedID, $CandidateElectionID, $Party, $DisplayName,
														$Address, $DBTable, $DBValue,	$StatsVoters, $Status) {
															
		$sql = "INSERT INTO Candidate SET SystemUser_ID = :SystemUserID, Candidate_UniqNYSVoterID = :UniqNYSVoterID, " .
						"Raw_Voter_ID = :RawVoterID, Raw_Voter_DatedTable_ID = :RawDatedTable, Raw_Voter_Dates_ID = :RawDatedID, " .
						"CandidateElection_ID = :CandidateElectionID, Candidate_Party = :Party, Candidate_DispName = :DisplayName, " .
						"Candidate_DispResidence = :Address, CandidateElection_DBTable = :DBTable, " .
						"CandidateElection_DBTableValue = :DBValue, Candidate_StatsVoters = :StatsVoters,  Candidate_Status = :Status";
						
		$sql_vars = array("SystemUserID" => $SystemUserID, "UniqNYSVoterID" => $UniqNYSVoterID, 
											"RawVoterID" => $RawVoterID, "RawDatedTable" => $RawDatedTable, 
											"RawDatedID" => $RawDatedID, "CandidateElectionID" => $CandidateElectionID, 
											"Party" => $Party, "DisplayName" =>  $DisplayName, 
											"Address" => $Address, "DBTable" => $DBTable, "DBValue" => $DBValue, 
											"StatsVoters" => $StatsVoters, "Status" => $Status);
		
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
						"LEFT JOIN CanPetitionSet ON (CanPetitionSet.CandidatePetitionSet_ID = CandidatePetitionSet.CandidatePetitionSet_ID) " .
						"LEFT JOIN Candidate ON (CanPetitionSet.Candidate_ID = Candidate.Candidate_ID) " .
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
	
	function SearchVotersBySingleIndex($SingleIndex, $DatedFiles) {
		$TableVoter = "Raw_Voter_" . $DatedFiles;
		$sql = "SELECT * FROM VotersIndexes " .
						"LEFT JOIN VotersFirstName ON (VotersFirstName.VotersFirstName_ID = VotersIndexes.VotersFirstName_ID ) " . 
						"LEFT JOIN VotersLastName ON (VotersLastName.VotersLastName_ID = VotersIndexes.VotersLastName_ID ) " .
		#				"LEFT JOIN Raw_Voter ON (Raw_Voter.Raw_Voter_UniqNYSVoterID = VotersIndexes.VotersIndexes_UniqNYSVoterID) " . 
						"LEFT JOIN " . $TableVoter . " ON (" . $TableVoter . ".Raw_Voter_UniqNYSVoterID = VotersIndexes.VotersIndexes_UniqNYSVoterID) " .		
						"LEFT JOIN DataCounty ON (" . $TableVoter . ".Raw_Voter_CountyCode = DataCounty.DataCounty_ID) " .
						"WHERE VotersIndexes.VotersIndexes_ID = :SingleIndex";
		$sql_vars = array("SingleIndex" => $SingleIndex);		
		return $this->_return_simple($sql, $sql_vars);		
	}
	
	function GetPetitionsForCandidate($DatedFiles, $CandidateID = 0, $SystemUserID = 0) {

		if ( $CandidateID == 0 && $SystemUserID == 0) return 0;
		
		$sql = "SELECT Candidate.Candidate_ID, Candidate.SystemUser_ID, Candidate.CandidateElection_ID, Candidate.Candidate_Party, " . 
						"Candidate.Candidate_DisplayMap, Candidate.Candidate_DispName, Candidate.Candidate_DispResidence, Candidate.CandidateAptment_ID, " . 
						"Candidate.Candidate_StatementPicFileName, Candidate.Candidate_StatementWebsite, Candidate.Candidate_StatementEmail, " . 
						"Candidate.Candidate_StatementTwitter, Candidate.Candidate_StatementPhoneNumber, Candidate.Candidate_StatementText, " . 
						"Candidate.CandidateElection_DBTable, Candidate.CandidateElection_DBTableValue, Candidate.Candidate_StatsVoters, " . 
						"Candidate.Candidate_Status, Candidate.Candidate_NominatedBy, CandidatePetition.CandidatePetition_ID, CandidatePetition.Candidate_ID, " . 
						"CandidatePetition.FollowUp_ID, CandidatePetition.CandidatePetition_Order, " . 
						"CandidatePetition.Raw_Voter_DatedTable_ID, CandidatePetition.Raw_Voter_Dates_ID, " . 
						"CandidatePetition.VotersIndexes_ID, CandidatePetition.CandidatePetition_VoterFullName, " . 
						"CandidatePetition.CandidatePetition_VoterResidenceLine1, CandidatePetition.CandidatePetition_VoterResidenceLine2, " . 
						"CandidatePetition.CandidatePetition_VoterResidenceLine3, CandidatePetition.CandidatePetition_VoterCounty, CandidatePetition.DataStreet_ID, " . 
						"CandidatePetition.Raw_Voter_ResHouseNumber, CandidatePetition.Raw_Voter_ResFracAddress, " . 
						"CandidatePetition.Raw_Voter_ResPreStreet, CandidatePetition.Raw_Voter_ResStreetName, CandidatePetition.Raw_Voter_ResPostStDir, " . 
						"CandidatePetition.Raw_Voter_ResApartment, CandidatePetition.Raw_Voter_Status, CandidatePetition.CandidatePetition_SignedDate " . 
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
	
	function UpdateSystemUserWithVoterCard($SystemUser_ID, $RawVoterID, $UniqNYSVoterID, $ADED) {
		$sql = "UPDATE SystemUser SET " .
						" Raw_Voter_UniqNYSVoterID = :NYSVoterID, " .
						"SystemUser_EDAD = :EDAD " .
						"WHERE SystemUser_ID = :ID ";
		$sql_vars = array("NYSVoterID" => $UniqNYSVoterID,
											"EDAD" => $ADED, "ID" => $SystemUser_ID);
		return $this->_return_nothing($sql, $sql_vars);				
	}
	
	function FindRawVoterbyADED($DatedFiles, $EDist, $ADist, $Party = "", $Active = 1, $order = 0) {
		
		$TableVoter = "Raw_Voter_" . $DatedFiles;
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
	function SearchVotersIndexesDB($ArrIndexes, $DatedFiles) {

		if ( empty ($ArrIndexes)) return 0;
		$sql_index = "";
		$TableVoter = "Raw_Voter_" . $DatedFiles;
				
		foreach ($ArrIndexes as $var) {
			if ( ! empty ($var)) {
				if ( ! empty ($sql_index)) { $sql_index .= " OR "; }
				$sql_index .= "VotersIndexes.VotersIndexes_ID = '" . $var . "'";
			}
		}
	
		$sql = "SELECT * FROM VotersIndexes " .
						"LEFT JOIN VotersFirstName ON (VotersFirstName.VotersFirstName_ID = VotersIndexes.VotersFirstName_ID ) " . 
						"LEFT JOIN VotersLastName ON (VotersLastName.VotersLastName_ID = VotersIndexes.VotersLastName_ID ) " .
						#"LEFT JOIN Raw_Voter ON (Raw_Voter.Raw_Voter_UniqNYSVoterID = VotersIndexes.VotersIndexes_UniqNYSVoterID) " . 
						"LEFT JOIN " . $TableVoter . " ON (" . $TableVoter . ".Raw_Voter_UniqNYSVoterID = VotersIndexes.VotersIndexes_UniqNYSVoterID) " .		
						"WHERE " . $sql_index;
		
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

