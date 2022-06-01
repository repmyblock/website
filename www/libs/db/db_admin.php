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
