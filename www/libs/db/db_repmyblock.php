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
  
  function FindPersonUser($SystemUserID) {
		$sql = "SELECT * FROM SystemUser WHERE SystemUser_ID = :ID";	
		$sql_vars = array(':ID' => $SystemUserID);											
		return $this->_return_simple($sql,  $sql_vars);
	}
	
	// This is a particular to get the BIO
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

	function SearchVoter_Dated_DB($DatedFiles, $FirstName, $LastName, $DOB) {
		$TableVoter = "Raw_Voter_" . $DatedFiles;
		$sql = "SELECT * FROM " . $TableVoter . " WHERE Raw_Voter_LastName = :LastName AND Raw_Voter_FirstName = :FirstName AND Raw_Voter_DOB = :DOB";
		$sql_vars = array('FirstName' => $FirstName, 'LastName' => $LastName, 'DOB' => $DOB);							
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
						"ORDER BY CandidatePositions_State";
		$sql_vars = array('State' => $state);
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
		$sql = "SELECT * FROM Candidate WHERE SystemUser_ID = :SystemUserID";
		$sql_vars = array('SystemUserID' => $SystemUserID);
		return $this->_return_multiple($sql, $sql_vars);
	}
	
	function ListElections($SomeVariable) {
		$sql = "SELECT * FROM CandidateElection " . 
						"LEFT JOIN Candidate ON (CandidateElection.CandidateElection_ID = Candidate.CandidateElection_ID)";
					
		return $this->_return_multiple($sql);
	}

	function ListCandidateNomination($SystemUserID) {
		$sql = "SELECT * FROM CanNomination WHERE SystemUser_ID = :SystemUserID";
		$sql_vars = array('SystemUserID' => $SystemUserID);
		return $this->_return_multiple($sql, $sql_vars);
	}
	
	function CandidateNomination($SystemUserID, $ElectionID, $CandidateID) {
		$sql = "INSERT INTO CanNomination SET Candidate_ID = :CandidateID, SystemUser_ID = :SystemUserID, CandidateElection_ID = :CandidateElectionID";
		$sql_vars = array('CandidateID' => $CandidateID, 'SystemUserID' => $SystemUserID, 'CandidateElectionID' => $ElectionID);
		return $this->_return_nothing($sql, $sql_vars);
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
		return $this->_return_nothing($sql, $sql_vars);
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
	
	function UpdateSystemUserWithVoterCard($SystemUser_ID, $RawVoterID, $UniqNYSVoterID, $ADED) {
		$sql = "UPDATE SystemUser SET " .
						"Raw_Voter_ID = :RawVoterID, Raw_Voter_UniqNYSVoterID = :NYSVoterID, " .
						"SystemUser_EDAD = :EDAD " .
						"WHERE SystemUser_ID = :ID ";
		$sql_vars = array("RawVoterID" => $RawVoterID, "NYSVoterID" => $UniqNYSVoterID,
											"EDAD" => $ADED, "ID" => $SystemUser_ID);
		
		return $this->_return_nothing($sql, $sql_vars);				
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

