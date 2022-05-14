<?php
require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/db/db_repmyblock.php";  
global $DB;

class RMB_Admin extends RepMyBlock {
  
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
		
		if ( $SystemUserID > 0 ) {
			$sql .= "WHERE SystemUser_ID = :SystemID";
			$sql_vars["SystemID"] = $SystemUserID;
		}

		return $this->_return_nothing($sql, $sql_vars);
	}	

}
?>
