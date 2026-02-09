<?php
require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/mysql/queries.php";
global $DB;

class display extends queries {

	function __construct($debug = 0, $DBFile = "DB_OutragedDems") {
    require $_SERVER["DOCUMENT_ROOT"] . "/../statlib/DBsLogins/" . $DBFile . ".php";
    $DebugInfo["DBFile"] = $DBFile;
    $DebugInfo["DBErrorsFilename"] = $DBErrorsFilename;
    $DebugInfo["Flag"] = $debug;
    parent::__construct($databasename, $databaseserver, $databaseport, $databaseuser, $databasepassword, $sslkeys, $DebugInfo);
  }

  function listvendors() {
		return $this->_return_multiple("SELECT * FROM Vendor WHERE Vendor_Stage = 'visible' AND Vendor_Visible = 'yes' ORDER BY Vendor_Order");
	}
	
	function findbadgeinfo($Code) {
		return $this->_return_simple(
			"SELECT BadgeVerif_ID, BadgeVerif_Reason, BadgeVerif_Active, BadgeVerif_ActiveFrom, BadgeVerif_ActiveTo " . 
			"FROM BadgeVerif WHERE BadgeVerif_Code = :Code", 
			array("Code" => $Code)
		);
	}
	
	function findbadgepicture($Code) {
		return $this->_return_simple(
			"SELECT BadgeVerif_Picture FROM BadgeVerif WHERE BadgeVerif_Code = :Code", 
			array("Code" => $Code)
		);
	}
	
	
	
}
?>
