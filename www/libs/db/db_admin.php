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
		return $this->_return_nothing($sql, $sql_vars);
	}
	
	function ListsTeams() {
		$sql = "SELECT * FROM Team";	
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

	function SearchVoter_Dated_DB($QueryFields) {
		print "Search Voter Dated DB: <PRE>" . print_r($QueryFields, 1) . "</PRE>";
		$sql = "SELECT * FROM NY_Raw_20220516 WHERE ";
		$sql .= "LastName = :LastName ";
		$sql .= "AND FirstName =: FirstName ";
		
		$sql_vars = array(
			"FirstName" => $QueryFields["FirstName"], 
			"LastName" => $QueryFields["LastName"],
						
			//	"UniqNYSVoterID" => $URIEncryptedString["UniqNYSVoterID"],
			//	"FirstName" => $URIEncryptedString["Query_FirstName"], 
			//	"LastName" => $URIEncryptedString["Query_LastName"],
			//	"ResZip" => $URIEncryptedString["Query_ZIP"], 
			//	"CountyCode" => $CountyCode,
			//	"EnrollPolParty" => $URIEncryptedString["Query_PARTY"], 
			//	"AssemblyDistr" => $URIEncryptedString["Query_AD"],
			//	"ElectDistr" => $URIEncryptedString["Query_ED"], 
			//  "CongressDistr" => $URIEncryptedString["Query_Congress"]
				
		);

		return $this->_return_multiple($sql, $sql_vars);
		exit();
	}
}
?>
