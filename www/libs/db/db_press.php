<?php
require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/db/db_repmyblock.php"; 
global $DB;

class press extends RepMyBlock {
 
  function listnotifications($SystemUserID) {
		return $this->_return_multiple(
							"SELECT * FROM AdminNotif WHERE SystemUser_ID = :SystemUser",
							array("SystemUser" => $SystemUserID)
						);
	}
	
	function listtypenotif($PermsRequired) {
		return $this->_return_multiple(
							"SELECT * FROM AdminNotifList WHERE SystemUser_Priv = :Perms AND Team_ID = :TeamID".
							array("Perms" => $PermsRequired, "TeamID" => $GlobalVarTeams["press"])
						);
	}
		
	function SavePressPreferences($SystemUserID, $TeamID, $Privs) {

		if (empty ($VendorID)) {
			$LastOrder = $this->_return_simple("SELECT max(Vendor_Order) AS VendOrder FROM Vendor")["VendOrder"];
			$LastOrder++;
		}
			
		$sql_vars = array("SystemUser" => $SystemUserID, "VendorName" => $VendorName,
											"VendorPitch" => $VendorPitch,	"VendorUrl" => $VendorURL);
											
		if (empty ($VendorID)) {
			$sql = "INSERT INTO AdminNotif SET SystemUser_ID = :SystemUser, AdminNotif_PrivA = :Admin, ";
			$sql_vars["VendorOrder"] = $LastOrder;
		} else {
			$sql = "UPDATE AdminNotif SET ";
		}
		
		$sql .= "Vendor_Name = :VendorName, Vendor_Pitch = :VendorPitch, Vendor_URL = :VendorUrl, " .
						"Vendor_Stage = 'visible', Vendor_Visible = 'yes', Vendor_UpdateTime = NOW()";

		if ( ! empty ($VendorID)) {
			$sql .= " WHERE SystemUser_ID = :SystemUser AND Vendor_ID = :VendorID";
			$sql_vars["VendorID"] = $VendorID;
		}
				
		return $this->_return_nothing($sql, $sql_vars);
  }
}
?>
