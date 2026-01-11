<?php	  	
require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/db/db_repmyblock.php";  

global $DB;
class searchvoters extends RepMyBlock {
	
	function VoterSearch ($QueryArray) {
				
		define('SET_BOEStateID',  1 << 1); // 1
		define('SET_BOEVSNID',  	1 << 2);
	  define('SET_FirstName',  	1 << 3);
		define('SET_LastName',    1 << 4);
		define('SET_Zipcode',     1 << 5);
		define('SET_County',      1 << 6);
		define('SET_StreetName',  1 << 7);
	  define('SET_HouseNumber', 1 << 8);
		define('SET_PostStreet',  1 << 9);
		define('SET_PreStreet',   1 << 10);
		define('SET_FracAddress', 1 << 11);
		   	
		// Create the query
		print "<h3>Checking the query rules</H3>";
		
		
	
		echo "<button onclick=\"window.history.back()\">Go Back</button><BR>";
		
			echo "<PRE>";
		print_r($QueryArray);
		echo "</PRE>";
		
		
		// We are going to do an array
		$BitQueryArray = 0;
		
		foreach ($QueryArray as $key => $value) {
	  	switch ($key) {
	  		
		    case 'BOEStateID': $BOEStateID = trim($value);
			  	if (! empty($BOEStateID)) $BitQueryArray += 1;
		     	break;
		     	
		    case 'BOEVSNID': $BOEVSNID = trim($value);
			  	if (! empty($BOEVSNID)) $BitQueryArray += 2;
		     	break;
		    
		    case 'FirstName': $FirstName = trim($value);
			  	if (! empty($FirstName)) $BitQueryArray += 4;
		     	break;
		    
		    case 'LastName': $LastName = trim($value);
			  	if (! empty($LastName)) $BitQueryArray += 8;
		     	break;
	  
		   	case 'Zipcode': $Zipcode = trim($value);
			  	if (! empty($Zipcode)) $BitQueryArray += 16;
		     	break;
		     	
		    case 'County': $County = trim($value);
			  	if (! empty($County)) $BitQueryArray += 32;
		     	break; 
		     
		    case 'StreetName': 
		    	$StreetName = trim($value);
					if (! empty($StreetName)) $BitQueryArray += 64;
		     	break;
	  
			  case 'HouseNumber': 
			  	$HouseNumber = trim($value); 
					if (! empty($HouseNumber)) $BitQueryArray += 128;
			  	break;
		   
		    case 'PostStreet': $PostStreet = trim($value);
			  	if (! empty($PostStreet)) $BitQueryArray += 256;
		     	break;
		     	
		    case 'PreStreet': $PreStreet = trim($value);
			  	if (! empty($PreStreet)) $BitQueryArray += 512;
		     	break;
		   
		    case 'FracAddress': $FracAddress = trim($value);
		   		if (! empty($FracAddress)) $BitQueryArray += 1024;
		     	break;
		     	
	  	}
		}
		
		printf(
    "<pre>Bitmask: %d (0b%s)</pre>",
    $BitQueryArray,
    decbin($BitQueryArray)
);

		// if Query had piece of address, query on address.
		
		if (($BitQueryArray & SET_BOEStateID) && ($BitQueryArray & SET_BOEVSNID)) {
	    die("Error: BOEStateID and BOEVSNID cannot be used together.");
		}
		
	
		$ExclusiveMask = SET_BOEStateID | SET_BOEVSNID;

		if ($BitQueryArray & $ExclusiveMask) {

    // Strip everything except BOEStateID / BOEVSNID
    $BitQueryArray &= $ExclusiveMask;

    // Optional: explicitly unset other variables
    unset(
        $FirstName, $LastName, $Zipcode, $County,
        $StreetName, $HouseNumber, $PostStreet,
        $PreStreet, $FracAddress
    );
}
		
		exit();
	
	
		if (! empty ($QueryArray["BOECountyID"]) || ! empty ($QueryArray["BOEStateID"])) {	
	 		$sql = "SELECT * FROM Voters " . 
						"LEFT JOIN VotersIndexes ON (VotersIndexes.VotersIndexes_ID = Voters.VotersIndexes_ID) " . 
						"LEFT JOIN DataHouse ON (Voters.DataHouse_ID = DataHouse.DataHouse_ID) " . 
						"LEFT JOIN DataAddress ON (DataAddress.DataAddress_ID = DataHouse.DataAddress_ID) " . 
						"LEFT JOIN DataStreet ON (DataStreet.DataStreet_ID = DataAddress.DataStreet_ID) " . 
						"LEFT JOIN DataLastName ON (DataLastName.DataLastName_ID = VotersIndexes.DataLastName_ID) " . 
						"LEFT JOIN DataFirstName ON (DataFirstName.DataFirstName_ID = VotersIndexes.DataFirstName_ID) " . 
						"LEFT JOIN DataMiddleName ON (DataMiddleName.DataMiddleName_ID = VotersIndexes.DataMiddleName_ID) ";
		} else {					
			$sql = "SELECT * FROM DataAddress " . 
						"LEFT JOIN DataStreet ON (DataStreet.DataStreet_ID = DataAddress.DataStreet_ID) " . 
						"LEFT JOIN DataHouse ON (DataAddress.DataAddress_ID = DataHouse.DataAddress_ID) " . 
						"LEFT JOIN Voters ON (DataHouse.DataHouse_ID = Voters.DataHouse_ID) " . 
						"LEFT JOIN VotersIndexes ON (VotersIndexes.VotersIndexes_ID = Voters.VotersIndexes_ID) " . 
						"LEFT JOIN DataLastName ON (DataLastName.DataLastName_ID = VotersIndexes.DataLastName_ID) " . 
						"LEFT JOIN DataFirstName ON (DataFirstName.DataFirstName_ID = VotersIndexes.DataFirstName_ID) " . 
						"LEFT JOIN DataMiddleName ON (DataMiddleName.DataMiddleName_ID = VotersIndexes.DataMiddleName_ID) "; 
		}					

		$sql .= "WHERE ";
			
		if (! empty ($QueryArray["BOECountyID"]) || ! empty ($QueryArray["BOEStateID"])) {						
			if (! empty ($QueryArray["BOECountyID"])) {
				$sql .= "Voters_CountyVoterNumber = :BOECountyID";
				$sql_vars["BOECountyID"] = $QueryArray["BOECountyID"];
			}
		
			if (! empty ($QueryArray["BOEStateID"])) {
				$sql .= "VotersIndexes_UniqStateVoterID LIKE :BOEStateID";
				$sql_vars["BOEStateID"] = $QueryArray["BOEStateID"];
			}
			
		} else {
			$sql .= "DataCounty_ID = :County";
			$sql_vars = array("County" => $QueryArray["County"]);
		}
		
		if (! empty ($QueryArray["Zipcode"])) {
			$sql .= " AND DataAddress_zipcode  = :DataZip";
			$sql_vars["DataZip "] = $QueryArray["Zipcode"];
		}
						
		if (! empty ($QueryArray["FracAddress"])) {
			$sql .= " AND DataAddress_FracAddress = :FracAddress";
			$sql_vars["FracAddress"] = $QueryArray["FracAddress"];
		}
		
		if (! empty ($QueryArray["PreStreet"])) {
			$sql .= " AND DataAddress_PreStreet = :PreStreet";
			$sql_vars["PreStreet"] = $QueryArray["PreStreet"];
		}
		
		if (! empty ($QueryArray["PostStreet"])) {
			$sql .= " AND DataAddress_PostStreet = :PostStreet";
			$sql_vars["PostStreet"] = $QueryArray["PostStreet"];
		}
		
		if (! empty ($QueryArray["HouseNumber"])) {
			$sql .= " AND DataAddress_HouseNumber LIKE :HouseNumber";
			$sql_vars["HouseNumber"] = $QueryArray["HouseNumber"] . "%";
		}
		
		if (! empty ($QueryArray["Name"])) {
			$sql .= " AND DataStreet_Name LIKE :DataStreet";
			$sql_vars["DataStreet"] = $QueryArray["Name"] . "%";
		}
		
		if (! empty ($QueryArray["FirstName"])) {
			$CompressedFirstName = preg_replace("/[^a-zA-Z]+/", "%", $QueryArray["FirstName"]);
			$sql .= " AND DataFirstName_Compress LIKE :FirstName";
			$sql_vars["FirstName"] = "%" . $CompressedFirstName . "%";
		}
		
		if (! empty ($QueryArray["LastName"])) {
			$CompressedLastName = preg_replace("/[^a-zA-Z]+/", "%", $QueryArray["LastName"]);
			$sql .= " AND DataLastName_Compress LIKE :LastName";
			$sql_vars["LastName"] = "%" . $CompressedLastName . "%";
		}
		
		return $this->_return_multiple($sql, $sql_vars);
	}
	
}
?>

