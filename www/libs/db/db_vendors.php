<?php
require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/db/db_repmyblock.php"; 
global $DB;

class vendors extends RepMyBlock {

  function vendors ($debug = 0, $DBFile = "DB_OutragedDems") {
	  require $_SERVER["DOCUMENT_ROOT"] . "/../statlib/DBsLogins/" . $DBFile . ".php";
	  $DebugInfo["DBErrorsFilename"] = $DBErrorsFilename;
	  $DebugInfo["Flag"] = $debug;
	 	$this->queries($databasename, $databaseserver, $databaseport, $databaseuser, $databasepassword, $sslkeys, $DebugInfo);
  }
  
  function listvendors($SystemUserID) {
		return $this->_return_multiple(
							"SELECT * FROM Vendor WHERE SystemUser_ID = :SystemUser",
							array("SystemUser" => $SystemUserID)
						);
	}
	
	
	function SaveVendorPitch($SystemUserID, $VendorID, $VendorName, $VendorPitch, $VendorURL) {

		if (empty ($VendorID)) {
			$LastOrder = $this->_return_simple("SELECT max(Vendor_Order) AS VendOrder FROM Vendor")["VendOrder"];
			$LastOrder++;
		}
			
		$sql_vars = array("SystemUser" => $SystemUserID, "VendorName" => $VendorName,
											"VendorPitch" => $VendorPitch,	"VendorUrl" => $VendorURL);
											
		if (empty ($VendorID)) {
			$sql = "INSERT INTO Vendor SET SystemUser_ID = :SystemUser, Vendor_Order = :VendorOrder, ";
			$sql_vars["VendorOrder"] = $LastOrder;
		} else {
			$sql = "UPDATE Vendor SET ";
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
