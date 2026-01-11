<?php	  	
require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/db/db_repmyblock.php";  

global $DB;
class NGOs extends RepMyBlock {
	
	function SaveNewNGO ($orgname = null, $orgstatus = null, $orgserialid = null, $orgwebsite = null) {
		$this->_return_nothing (
					"INSERT INTO TeamNGO SET TeamNGO_Name = :name, TeamNGO_TaxType = :status, " . 
					"TeamNGO_GovID = :id, TeamNGO_Website = :website",
					[ "name" => $orgname, "status" => $orgstatus, "id" => $orgserialid, "website" => $orgwebsite ]		
		);
		
		return $this->_return_simple("SELECT LAST_INSERT_ID() AS TeamNGO_ID")["TeamNGO_ID"];
	}

	function SaveNGOEndor ($ngoid, $endorsetype = null, $grade = null, $cantoorg = null, $orgtocan = null) {
		$this->_return_nothing (
					"INSERT INTO TeamNGOEnd SET TeamNGO_ID = :ngoid, TeamNGOEnd_Type = :endorsetype, " . 
					"TeamNGOEnd_Method = :method, TeamNGOEnd_ContactIn = :contactin, TeamNGOEnd_ContactOut = :contactout",
					[ 
						"ngoid" => $ngoid, "method" => $grade, "endorsetype" => $endorsetype, 
						"contactin" => $cantoorg, "contactout" => $orgtocan
					]		
		);
		
		return $this->_return_simple("SELECT LAST_INSERT_ID() AS TeamNGOEnd_ID")["TeamNGOEnd_ID"];
	}
	
}
?>

