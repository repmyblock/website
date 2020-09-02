<?php
require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/mysql/queries.php";
global $DB;

class runwithme extends queries {

  function runwithme ($debug = 0, $DBFile = "DB_OutragedDems") {
	  require $_SERVER["DOCUMENT_ROOT"] . "/../statlib/DBsLogins/" . $DBFile . ".php";
	  $DebugInfo["DBErrorsFilename"] = $DBErrorsFilename;
	  $DebugInfo["Flag"] = $debug;
	  
	 	$this->queries($databasename, $databaseserver, $databaseport, $databaseuser, $databasepassword, $sslkeys, $DebugInfo);
  }
  
  function FindVoter($FirstName, $LastName, $DatedFile) {  	
  	$CompressedFirstName = preg_replace("/[^a-zA-Z]+/", "", $FirstName);
		$CompressedLastName = preg_replace("/[^a-zA-Z]+/", "", $LastName);

		$sql = "SELECT * FROM VotersIndexes " . 
						"LEFT JOIN VotersFirstName ON (VotersIndexes.VotersFirstName_ID = VotersFirstName.VotersFirstName_ID) " .
						"LEFT JOIN VotersLastName ON (VotersIndexes.VotersLastName_ID = VotersLastName.VotersLastName_ID) " .
						"LEFT JOIN " . $DatedFile . " AS DF ON (DF.Raw_Voter_UniqNYSVoterID = VotersIndexes.VotersIndexes_UniqNYSVoterID) " . 
						"WHERE VotersFirstName_Compress = :FirstNameCompressed AND VotersLastName_Compress = :LastNameCompressed";
		$sql_vars = array("FirstNameCompressed" => $CompressedFirstName, "LastNameCompressed" => $CompressedLastName);
		return $this->_return_multiple($sql, $sql_vars);	
	} 
	
	
	function FindNeibors($NYSID, $HseNbr, $FracAddress, $Apt, $PreStreet, $StreetName, $PostStreet, $City, $Zip, $DatedFile) {
		$sql = "SELECT * FROM $DatedFile " . 
						"WHERE (Raw_Voter_Status = 'ACTIVE' OR Raw_Voter_Status = 'INACTIVE') " . 
						"AND Raw_Voter_ResStreetName = :StreetName AND Raw_Voter_ResZip = :Zip";
		$sql_vars = array("StreetName" => $StreetName, "Zip" => $Zip);
		
		if (! empty ($HseNbr)) {
			$sql .= " AND Raw_Voter_ResHouseNumber = :HseNbr";
			$sql_vars["HseNbr"] = $HseNbr;
		}				
		
		$sql .= " ORDER BY CAST(Raw_Voter_ResHouseNumber AS UNSIGNED), Raw_Voter_ResApartment";
		return $this->_return_multiple($sql, $sql_vars);	
	} 
	
	function ShowPetitionsForUser($UniqID) {
		$sql = "SELECT * FROM PetitionGroup " . 
						"LEFT JOIN PetitionSigners ON (PetitionSigners.PetitionGroup_ID = PetitionGroup.PetitionGroup_ID) " . 
						"WHERE PetitionGroup_OwnerUniqID = :Uniq";
		$sql_vars = array("Uniq" => $UniqID);
		return $this->_return_multiple($sql, $sql_vars);
	}
	
	// This will have plenty of logic.
	function SavePetitionGroup($Signatures, $TheWitness, $OwnerID, $CandidateID, $DatedFile) {
		$sql = "SELECT * FROM " . $DatedFile . " " . 
						"LEFT JOIN DataCounty ON (" . $DatedFile . ".Raw_Voter_CountyCode = DataCounty.DataCounty_ID) " .
						"WHERE ";	
		$Counter = 0;
	
		if ( ! empty ($TheWitness)) {
			$Name = "NYSVoterID" . $Counter++;
			$sql .= "Raw_Voter_UniqNYSVoterID = :" . $Name;
			$sqlvars[$Name] = $TheWitness;
		}
		
		if ( ! empty ($Signatures)) {
			foreach ($Signatures as $Sig) {
				if ( ! empty ($Sig)) {
					$Name = "NYSVoterID" . $Counter++;
					$sql .= " OR Raw_Voter_UniqNYSVoterID = :" . $Name;
					$sqlvars[$Name] = $Sig;
				}
			}
		}
		
		$results = $this->_return_multiple($sql, $sqlvars);		
		$sql = "INSERT INTO PetitionGroup SET Candidate_ID = :CandidateID, PetitionGroup_WitnessName = :WitnessName, PetitionGroup_WitnessResidence = :Residence, " .
						"PetitionGroup_UniqNYSVoterID = :UniqID, PetitionGroup_WitnessCity = :City, PetitionGroup_WitnessCounty = :County, " . 
						"PetitionGroup_OwnerUniqID = :Owner, PetitionGroup_Timestamp = NOW()";
		
		// This is to create the witness
		if ( ! empty ($results)) {
			foreach ($results as $var) {
				if ( ! empty ($var)) {
					if ( $var["Raw_Voter_UniqNYSVoterID"] == $TheWitness ) {
						$Residence = "";
						if ( ! empty ($var["Raw_Voter_ResHouseNumber"])) { $Residence .= $var["Raw_Voter_ResHouseNumber"] . " "; }
						if ( ! empty ($var["Raw_Voter_ResFracAddress"])) { $Residence .= $var["Raw_Voter_ResFracAddress"] . " "; }
						if ( ! empty ($var["Raw_Voter_ResPreStreet"])) { $Residence .= $var["Raw_Voter_ResPreStreet"] . " "; }
						if ( ! empty ($var["Raw_Voter_ResStreetName"])) { $Residence .= ucwords(strtolower($var["Raw_Voter_ResStreetName"])) . " "; }
						if ( ! empty ($var["Raw_Voter_ResPostStDir"])) { $Residence .= $var["Raw_Voter_ResPostStDir"] . " "; }
						if ( ! empty ($var["Raw_Voter_ResCity"])) { $Residence = trim($Residence) . ", " . ucwords(strtolower($var["Raw_Voter_ResCity"])); }
	      		
						$sqlvars = array("WitnessName" => ucwords(strtolower($var["Raw_Voter_FirstName"])) . " " . 
																							ucwords(strtolower($var["Raw_Voter_LastName"])),
														 "Residence" => trim($Residence), "UniqID" => $TheWitness,
														 "City" => trim(ucwords(strtolower($var["Raw_Voter_ResCity"]))),
														 "County" => trim(ucwords(strtolower($var["DataCounty_Name"]))),
														 "Owner" => $OwnerID, "CandidateID" => $CandidateID);
	          
						$this->_return_nothing($sql, $sqlvars);
						$groupid = $this->_return_simple("SELECT LAST_INSERT_ID() as GroupID");
					}					
				}
			}
		}
		
		$sql = "INSERT INTO PetitionSigners SET " .
						"PetitionGroup_ID = :GroupID, PetitionSigners_Date = NOW(), " . 
						"PetitionSigners_Name = :WitnessName, PetitionSigners_Residence = :Residence, " .
						"PetitionSigners_ResidenceCounty = :County, " . 
						"Raw_Voter_UniqNYSVoterID = :UniqID, PetitionSigners_Timestamp = NOW()";
		
		// This is to create petitioneed
		if ( ! empty ($results)) {
			foreach ($results as $var) {
				if ( ! empty ($var)) {
					if ( $var["Raw_Voter_UniqNYSVoterID"] != $TheWitness ) {
						$Residence = "";
						if ( ! empty ($var["Raw_Voter_ResHouseNumber"])) { $Residence .= $var["Raw_Voter_ResHouseNumber"] . " "; }
						if ( ! empty ($var["Raw_Voter_ResFracAddress"])) { $Residence .= $var["Raw_Voter_ResFracAddress"] . " "; }
						if ( ! empty ($var["Raw_Voter_ResPreStreet"])) { $Residence .= $var["Raw_Voter_ResPreStreet"] . " "; }
						if ( ! empty ($var["Raw_Voter_ResStreetName"])) { $Residence .= ucwords(strtolower($var["Raw_Voter_ResStreetName"])) . " "; }
						if ( ! empty ($var["Raw_Voter_ResPostStDir"])) { $Residence .= $var["Raw_Voter_ResPostStDir"] . " "; }
						if ( ! empty ($var["Raw_Voter_ResApartment"])) { $Residence = trim($Residence) . " - Apt " . $var["Raw_Voter_ResApartment"] . " "; }
						if ( ! empty ($var["Raw_Voter_ResCity"])) { 
							$Residence = trim($Residence) . ", " . ucwords(strtolower($var["Raw_Voter_ResCity"])) . ", NY " . $var["Raw_Voter_ResZip"] ; 
						}
	      		
						$sqlvars = array("WitnessName" => ucwords(strtolower($var["Raw_Voter_FirstName"])) . " " . 
																							ucwords(strtolower($var["Raw_Voter_LastName"])),
														 "Residence" => trim($Residence), "UniqID" => $var["Raw_Voter_UniqNYSVoterID"],
														 "GroupID" => $groupid["GroupID"], "County" => $var["DataCounty_Name"]);
	          
						$this->_return_nothing($sql, $sqlvars);
					}					
				}
			}
		}
		return $groupid["GroupID"];
	}
		
}


?>
