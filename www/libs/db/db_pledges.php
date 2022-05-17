<?php
require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/db/db_repmyblock.php";  

global $DB;
class RMBpledges extends RepMyBlock {
	function ListBuildingsByADED($AD, $ED) {		
		$sql = "SELECT DISTINCT DataAddress.DataAddress_ID, DataAddress_HouseNumber, DataAddress_FracAddress, DataAddress_PreStreet, " . 
						"DataStreet_Name, DataAddress_PostStreet, DataAddress_zipcode ";
		//$sql = "SELECT * ";

		$sql .= "FROM DataDistrict " .
						"LEFT JOIN DataDistrictTemporal ON (DataDistrictTemporal.DataDistrict_ID = DataDistrict.DataDistrict_ID) " . 
						"LEFT JOIN DataDistrictCycle ON (DataDistrictCycle.DataDistrictCycle_ID = DataDistrictTemporal.DataDistrictCycle_ID) " . 
						"LEFT JOIN DataHouse ON (DataHouse.DataDistrictTemporal_GroupID = DataDistrictTemporal.DataDistrictTemporal_GroupID) " . 
						"LEFT JOIN DataAddress ON (DataHouse.DataAddress_ID = DataAddress.DataAddress_ID) " . 
						"LEFT JOIN DataStreet ON (DataStreet.DataStreet_ID = DataAddress.DataStreet_ID) "; 
		$sql .= "WHERE DataDistrict.DataDistrict_StateAssembly = :AD AND " . 
						"DataDistrict.DataDistrict_Electoral = :ED";			
											
		$sql_vars = array("AD" => $AD, "ED" => $ED);								
		return $this->_return_multiple($sql, $sql_vars);
	}		
}
?>

