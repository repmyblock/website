<?php      
require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/mysql/queries.php";
global $DB;

// This are functions used by various pages. 
// If the Function is not used by multiple pages, then it's proper location is in the DB_<NAME_OF_PAGE>.php

class RepMyBlock extends queries {

  function __construct($debug = 0, $DBFile = "DB_OutragedDems") {
    require $_SERVER["DOCUMENT_ROOT"] . "/../statlib/DBsLogins/" . $DBFile . ".php";
    $DebugInfo["DBFile"] = $DBFile;
    $DebugInfo["DBErrorsFilename"] = $DBErrorsFilename;
    $DebugInfo["Flag"] = $debug;
    parent::__construct($databasename, $databaseserver, $databaseport, $databaseuser, $databasepassword, $sslkeys, $DebugInfo);
  }

  // These function are from DB_TEAMS but it's being used by user.php so back in main.
  function FindCampaignFromWebCode ($TeamWebCode, $SQLTables = null) {
    return $this->_return_simple(
      "SELECT " . sqltablestoshow($SQLTables) . " FROM Team WHERE Team_WebCode = :TeamWebCode",
      ["TeamWebCode" => $TeamWebCode]
    );
  }
  
  function ListElectionDate($StateID, $DateElection, $SQLTables = null) {
 
    return $this->_return_simple(
      "SELECT " . sqltablestoshow($SQLTables) . " FROM Elections WHERE DataState_ID = :StateID AND Elections_Date = :ElectDate",
      ["StateID" => $StateID, "ElectDate" => $DateElection]
    );
  }
  
  function AddElectionDate($StateID, $DateElection, $Election_Text = null, $ElectType = "toverify") {
    $this->_return_nothing(
      "INSERT INTO Elections SET DataState_ID = :StateID, Elections_Date = :ElectDate, " .
      "Elections_Text = :Text, Elections_Type = :ElectType", 
      ["StateID" => $StateID, "ElectDate" => $DateElection, "Text" => $Election_Text, "ElectType" => $ElectType]
    );
        
      return $this->_return_simple("SELECT LAST_INSERT_ID() as Elections_ID");   
  }
  
  
  function SaveTeamInfo($SystemUser_ID, $Team_ID, $Priv = NULL, $Active = 'pending') {
     $ret = $this->ReturnTeamInfo($SystemUser_ID, $Team_ID);
     WriteStderr($ret, "ReturnTeamInfo");
     
     if (empty ($ret)) {      
      $sql = "INSERT INTO TeamMember SET SystemUser_ID = :SystemUser, Team_ID = :TeamID, " . 
             "TeamMember_Active = :Active, TeamMember_DateRequest = NOW()";
      $sql_vars = array("SystemUser" => $SystemUser_ID, "TeamID" => $Team_ID, "Active" => $Active);
      //        "TeamMember_Active = :Active, TeamMember_Privs = :Privs, " .
      //        "TeamMember_ApprovedBy = :App_SystemID, TeamMember_ApprovedNote = :App_Note, ";  
      WriteStderr($sql, "ReturnTeamInfo");  
      return $this->_return_nothing($sql, $sql_vars);            
    }
  }
 
   function ListAllPositions($ElectPost = null, $SQLTables = null) {
    if ( $ElectPost > 0) {    
       return $this->_return_simple(
         "SELECT " . sqltablestoshow($SQLTables) . " FROM ElectionsPosition WHERE ElectionsPosition_ID = :ElectPost",
         ["ElectPost" => $ElectPost]
       );
    }

     return $this->_return_multiple("SELECT * FROM ElectionsPosition");
   }
  
  function ListCCPartyCall($Party, $ADED, $ElectionsID, $SQLTables = null) {
    // Need to add piece for NULL ELECTION ID.
    return $this->_return_multiple(
        "SELECT " . sqltablestoshow($SQLTables) . " FROM ElectionsPartyCall " .
        "LEFT JOIN ElectionsPosition ON (ElectionsPosition.ElectionsPosition_ID = ElectionsPartyCall.ElectionsPosition_ID) " .
        "WHERE ElectionsPosition_Party = :Party AND ElectionsPartyCall_DBTableValue = :Value AND " . 
        "ElectionsPosition_DBTable = :Type AND " .
        "Elections_ID = :ElectionID",
        ["Party" => $Party, "Value" =>  $ADED, "Type" => "ADED", "ElectionID" => $ElectionsID]
    );
  }
  
  
  
  function FindRacesInPartyCallInfo($Election, $DTable, $DValue, $SQLTables = null) {
    $sql = "SELECT " . sqltablestoshow($SQLTables) . " FROM ElectionsDistrictsConv " .
            "LEFT JOIN ElectionsPartyCall ON (" .
            "ElectionsPartyCall.ElectionsPartyCall_DBTable = ElectionsDistrictsConv.ElectionsDistrictsConv_DBTable AND " .
            "ElectionsPartyCall.ElectionsPartyCall_DBTableValue = ElectionsDistrictsConv.ElectionsDistrictsConv_DBTableValue AND " .
            "ElectionsPartyCall.Elections_ID = ElectionsDistrictsConv.Elections_ID) " .
            "LEFT JOIN ElectionsPosition ON (" . 
            "ElectionsPosition.ElectionsPosition_ID = ElectionsDistrictsConv.ElectionsPosition_ID";
    $sql .= ") " .
            "LEFT JOIN DataCounty ON (DataCounty.DataCounty_ID = ElectionsDistrictsConv.DataCounty_ID) " . 
            "WHERE ElectionsDistrictsConv.Elections_ID = :ElectionID AND ElectionsPartyCall_DBTableValue = :Position AND " . 
            "ElectionsPartyCall_DBTable = :DTable " .
            "ORDER BY ElectionsPosition_Order";
            
    $sql_vars = array("ElectionID" => $Election, "DTable" =>  $DTable, "Position" => $DValue);
    #return $this->_return_multiple($sql, $sql_vars);            
  }
  
  function PartyCallInfo($Party, $Election, $DTable, $DValue, $SQLTables = null) {
    
    $sql = "SELECT " . sqltablestoshow($SQLTables) . " FROM ElectionsDistrictsConv " .
            "LEFT JOIN ElectionsPartyCall ON (" .
            "ElectionsPartyCall.ElectionsPartyCall_DBTable = ElectionsDistrictsConv.ElectionsDistrictsConv_DBTable AND " .
            "ElectionsPartyCall.ElectionsPartyCall_DBTableValue = ElectionsDistrictsConv.ElectionsDistrictsConv_DBTableValue AND " .
            "ElectionsPartyCall.Elections_ID = ElectionsDistrictsConv.Elections_ID) " .
            "LEFT JOIN ElectionsPosition ON (" . 
            "ElectionsPosition.ElectionsPosition_ID = ElectionsDistrictsConv.ElectionsPosition_ID";
    if ( ! empty ($Party)) {
      $sql .=   " AND ElectionsPartyCall.ElectionsPartyCall_Party = ElectionsPosition.ElectionsPosition_Party";
    } 
    $sql .= ") " .
            "LEFT JOIN DataCounty ON (DataCounty.DataCounty_ID = ElectionsDistrictsConv.DataCounty_ID) " . 
            "WHERE ElectionsDistrictsConv.Elections_ID = :ElectionID AND ElectionsDistricts_DBTableValue = :Position AND " . 
            "ElectionsPosition_DBTable = :DTable ";
            
    $sql_vars = array("ElectionID" => $Election, "DTable" =>  $DTable, "Position" => $DValue);
    
    if ( ! empty ($Party)) {
      $sql .= " AND ElectionsPosition_Party = :Party";
      $sql_vars["Party"] = $Party;
    } else {
      $sql .= " AND ElectionsPosition_Party IS NULL";
    }

    #return $this->_return_multiple($sql, $sql_vars);            
  }
  
  function ListPartyCall($Election_ID, $SQLTables = null) {
    return $this->_return_multiple(
      "SELECT " . sqltablestoshow($SQLTables) . " FROM ElectionsPartyCall WHERE Elections_ID = :ElectionID",
       ["ElectionID" => $Election_ID]
    );
  }
  
  function ListDBTablesFromPositions($ElectionsPosition_ID, $SQLTables = null) {
    return $this->_return_multiple(
      #"SELECT DISTINCT ElectionsPosition_ID, CandidateElection_DBTable, CandidateElection_DBTableValue, CandidateElection_Text " . 
      #"FROM RepMyBlock.CandidateElection WHERE ElectionsPosition_ID = :ElectionsPositionsID " . 
      #"ORDER BY CandidateElection_DBTableValue ASC",
      
      "SELECT DISTINCT ElectionsPosition_ID, CandidateElection_DBTable, " .
      "NormalizedValue AS CandidateElection_DBTableValue, CandidateElection_Text, " .
      "SortGroup, NumericSort FROM ( " .
      "SELECT ElectionsPosition_ID, CandidateElection_DBTable, CandidateElection_Text, " .
      "CandidateElection_DBTableValue, " .
      "CASE WHEN CandidateElection_DBTableValue REGEXP '^[0-9]+$' " .
      "THEN CAST(CandidateElection_DBTableValue AS UNSIGNED) ELSE CandidateElection_DBTableValue " .
      "END AS NormalizedValue, CASE WHEN CandidateElection_DBTableValue REGEXP '^[0-9]+$' THEN 0 " .
      "ELSE 1 END AS SortGroup, CASE WHEN CandidateElection_DBTableValue REGEXP '^[0-9]+$' " .
      "THEN CAST(CandidateElection_DBTableValue AS UNSIGNED) " .
      "ELSE NULL END AS NumericSort FROM RepMyBlock.CandidateElection " .
      "WHERE ElectionsPosition_ID = :ElectionsPositionsID ) t ORDER BY SortGroup, NumericSort, " .
      "NormalizedValue",
      
      ["ElectionsPositionsID" => $ElectionsPosition_ID]
    );
  }
  
  function ListPartyCallForPositions($Election_ID, $ElectionPosition = NULL, $SQLTables = null) {
    $sql = "SELECT DISTINCT " . 
            "Elections_ID, ElectionsPartyCall_Party, ElectionsPartyCall_SignDeadline, " .
            "ElectionsPartyCall_NumberFemale, ElectionsPartyCall_NumberMale,  ElectionsPartyCall_NumberUnixSex, " .
            "ElectionsPosition_DBTable, ElectionsPosition_Type, ElectionsPosition_Name, ElectionsPosition_Party,  " .
            "ElectionsPosition_Order, ElectionsPosition_Explanation " .
            " FROM ElectionsPartyCall " . 
            "LEFT JOIN ElectionsPosition ON (ElectionsPosition.ElectionsPosition_ID = ElectionsPartyCall.ElectionsPosition_ID) " .
            "WHERE Elections_ID = :ElectionID";
    $sql_vars = array("ElectionID" => $Election_ID);
    
    if ( ! empty ($ElectionPosition)) {
      $sql .= " AND ElectionsPartyCall.ElectionsPosition_ID = :PositionID";
      $sql_vars["PositionID"] = $ElectionPosition;
    }
    
    return $this->_return_multiple($sql, $sql_vars);
  }
  
  function ReturnTeamInfo($SystemUser_ID, $Team_ID, $Active = 'yes', $SQLTables = null) {
    return $this->_return_simple(
        "SELECT " . sqltablestoshow($SQLTables) . " FROM TeamMember WHERE SystemUser_ID = :SystemUser AND " . 
        "Team_ID = :TeamID AND TeamMember_Active = :Active",
        ["SystemUser" => $SystemUser_ID, "TeamID" => $Team_ID, "Active" => $Active]
    );
  }
  
  // Unorganized functions.
  function RecordWatch($SystemID, $FullName, $Email) {
    $sql = "INSERT INTO ZeMovieWtchd SET SystemUser_ID = :SystemUser, " .
            "ZeMovieWtchd_FullName = :FullName, " .
            "ZeMovieWtchd_Email = :Email, ZeMovieWtchd_Time = NOW()";
    $sql_vars = array("SystemUser" => $SystemID, 
                      "FullName" => $FullName, "Email" => $Email);
    return $this->_return_nothing($sql, $sql_vars);
  }
  
  function GetMoviePassword($SQLTables = null) {
    $sql = "SELECT " . sqltablestoshow($SQLTables) . " FROM ZeMoviePwd;";
    return $this->_return_simple($sql);
  }

   function database_showtables() {
     return $this->_return_multiple("SHOW TABLES");
   }
   
   function database_showcolums($Tables) {
     return $this->_return_multiple("SHOW COLUMNS FROM $Tables");     
     // $sql_vars = array("Tables" => $Tables);
   }
   
   function database_custquery($dbtable, $dbcol, $val) {
     $sql = "SELECT " . sqltablestoshow($SQLTables) . " FROM $dbtable WHERE $dbcol = :VALUE LIMIT 10000";
     $sql_vars = array("VALUE" => $val);
     return $this->_return_multiple($sql, $sql_vars); 
   }

  function FindVotersForEDAD($AD, $ED, $Party, $SQLTables = null) {
    $sql = "SELECT " . sqltablestoshow($SQLTables) . " FROM DataDistrict " . 
            "LEFT JOIN DataDistrictTemporal ON (DataDistrictTemporal.DataDistrict_ID = DataDistrict.DataDistrict_ID) " .
            "LEFT JOIN Voters ON (DataDistrictTemporal.DataHouse_ID = Voters.DataHouse_ID) " . 
            "LEFT JOIN DataDistrictCycle ON (DataDistrictTemporal.DataDistrictCycle_ID = DataDistrictCycle.DataDistrictCycle_ID) " . 
            "WHERE DataDistrict_StateAssembly = :AD and DataDistrict_Electoral = :ED AND " . 
            "Voters_ID Is not null AND (Voters_Status = \"active\" OR Voters_Status = \"Inactive\") AND " .
            "Voters_RegParty = :Party AND " . 
            "(CURDATE() >=DataDistrictCycle_CycleStartDate AND CURDATE() <=DataDistrictCycle_CycleEndDate) IS NULL";        
    $sql_vars = array("AD" =>  $AD, "ED" => $ED, "Party" => $Party);  
    
    WriteStderr($sql_vars, "SQL Query: " . $sql);    
    return $this->_return_multiple($sql, $sql_vars);
  }  
   
  function FindPersonUser($SystemUserID, $SQLTables = null) {
    $sql = "SELECT " . sqltablestoshow($SQLTables) . " FROM SystemUser WHERE SystemUser_ID = :ID";  
    $sql_vars = array(':ID' => $SystemUserID);                      
    return $this->_return_simple($sql,  $sql_vars);
  }
  
  function FindPersonUserProfile($SystemUserID, $SQLTables = PERSON_DATABASE) {
    return $this->_return_simple(
        "SELECT " . sqltablestoshow($SQLTables) . " FROM SystemUser " .
        "LEFT JOIN SystemUserProfile ON (SystemUser.SystemUserProfile_ID = SystemUserProfile.SystemUserProfile_ID) " . 
        "LEFT JOIN Voters ON (SystemUser.Voters_ID = Voters.Voters_ID) " . 
        "WHERE SystemUser_ID = :ID",  
        [':ID' => $SystemUserID]
     );    
  }
  
  function InsertEmail($email) {
    $sql = "INSERT INTO SystemUser SET SystemUser_email = :Email";  
    $sql_vars = array(':Email' => $email);                      
    return $this->_return_nothing($sql,  $sql_vars);
  }
  
  function CheckRegisterEmail ($email, $SQLTables = null) {     
    return $this->_return_simple(
      "SELECT " . sqltablestoshow($SQLTables) . " FROM SystemUser WHERE SystemUser_email = :Email",
      ['Email' => $email]
    );
  }
 
  function CheckForDelegationPrivs($email, $SQLTables = null) {
    return $this->_return_multiple(
      "SELECT " . sqltablestoshow($SQLTables) . " FROM SystemUserTeamPending WHERE SystemUserTeamPending_email = :Email",
      ["Email" => $email]
    );
  }

  function CheckRegisterEmailForTeamAdmin($email, $SysIDGiv, $Team_ID, $SQLTables = null) {
    return $this->_return_simple(
      "SELECT " . sqltablestoshow($SQLTables) . " FROM SystemUserTeamPending LEFT JOIN SystemUser ON " .
        "(SystemUser.SystemUser_email = SystemUserTeamPending.SystemUserTeamPending_email) " . 
        "WHERE SystemUserTeamPending_GivenSysUsr " . (($SysIDGiv === null) ? "is" : "=") . " :SysID AND SystemUserTeamPending_Valid = 'yes' " .
        "AND SystemUserTeamPending_email = :Email AND Team_ID = :TeamID",
      ["Email" => $email, "SysID" => $SysIDGiv, "TeamID" => $Team_ID]
    );
  }

  function InsertTempTeam($Email, $TeamID,  $SysIDGiv, $FullAdmin = 'no', $AdminCode = null) {
    return $this->_return_nothing(
      "INSERT INTO SystemUserTeamPending SET Team_ID = :TeamID, " . 
       "SystemUserTeamPending_email = :Email, SystemUserTeamPending_FullAdmin = :FullAdmin, " .
       "SystemUserTeamPending_GivenSysUsr = :SysID, SystemUserTeamPending_Valid = 'yes', " . 
       "SystemUserTeamPending_AdminCode = :AdminCode, SystemUserTeamPending_Given = NOW()",
      [  
       "Email" => $Email, 'SysID' => $SysIDGiv, "FullAdmin" => $FullAdmin, 
       "TeamID" => $TeamID, "AdminCode" => $AdminCode
      ]
    );
  }
    
  function FindGeoDiscID($GeoDescAbbrev, $SQLTables = null) {
    return $this->_return_simple(
      "SELECT " . sqltablestoshow($SQLTables) . " FROM GeoDesc WHERE GeoGroup_ID = '3' AND GeoDesc_Abbrev = :Abbrev", 
      ["Abbrev" => $GeoDescAbbrev]
    );
  }

  function SaveVoterRequest($FirstName, $LastName, $DateOfBirth, $DatedFilesID, $Email, $Contact, 
                            $UniqNYSVoterID, $IP, $Branding = null) {
    $this->_return_nothing(
            "INSERT INTO SystemUserQuery SET SystemUserQuery_FirstName = :FirstName, " .
            "SystemUserQuery_LastName = :LastName, SystemUserQuery_DateOfBirth = :DateOfBirth, " .
            "SystemUserQuery_DatedFileID = :DatedFilesID, SystemUserQuery_Email = :Email, " .
            "SystemUserQuery_UniqNYSVoterID = :UniqNYSVoterID, SystemUserQuery_BrandingGroup = :Branding, " .
            "SystemUserQuery_IP = :IP, SystemUserQuery_Contact = :Contact, SystemUserQuery_Date = NOW()", 
            [
              "FirstName" => $FirstName, "LastName" => $LastName, 
              "DateOfBirth" => $DateOfBirth, "DatedFilesID" => $DatedFilesID,
              "Email" => $Email, "UniqNYSVoterID" => $UniqNYSVoterID,
              "Branding" => $Branding, "Contact" => $Contact,
              "IP" => $IP
            ]
     );
    
    return $this->_return_simple("SELECT LAST_INSERT_ID() as SystemUserQuery_ID");   
  }

  function SearchVoterDB($FirstName, $LastName, $DOB, $Status = "", $SQLTables = null) {
    $CompressedFirstName = preg_replace("/[^a-zA-Z]+/", "", $FirstName);
    $CompressedLastName = preg_replace("/[^a-zA-Z]+/", "", $LastName);
    
    $sql = "SELECT " . sqltablestoshow($SQLTables) . " FROM VotersIndexes " .
            "LEFT JOIN DataFirstName ON (DataFirstName.DataFirstName_ID = VotersIndexes.DataFirstName_ID ) " . 
            "LEFT JOIN DataLastName ON (DataLastName.DataLastName_ID = VotersIndexes.DataLastName_ID ) " .
            "LEFT JOIN Voters ON (Voters.VotersIndexes_ID = VotersIndexes.VotersIndexes_ID) " . 
            "WHERE DataFirstName_Compress = :FirstName AND " . 
            "DataLastName_Compress = :LastName " .
            "AND VotersIndexes_DOB = :DOB"; 
    $sql_vars = array('FirstName' => $CompressedFirstName, 
                      'LastName' => $CompressedLastName, 
                      'DOB' => $DOB);
            
    if (! empty ($Status)) {
      $sql .= " AND Voters_Status = :Status";
      $sql_vars["Status"] = $Status;
    }
            
    WriteStderr($sql, "SQL request");
          
    return $this->_return_multiple($sql, $sql_vars);    
  }
  
  function CreatePositionEntry($DataArray) {
    $sql = "INSERT INTO CandidateElection SET ";
    $FirstTime = false;
    $sql_vars = [];
    
    if ( ! empty ($DataArray)) {
      foreach ($DataArray as $var => $data) {
        if ( ! empty ($data)) { 
          if ( $FirstTime == false ) { $FirstTime = true; } else { $sql .= ", "; }
          $sql .=  $var . " = :" . $var; 
          $sql_vars[$var] = $data;
        }
      }
    }
    
    if ( $FirstTime == true) {
      $this->_return_nothing($sql, $sql_vars);
      $ret = $this->_return_simple("SELECT LAST_INSERT_ID() as CandidateElection_ID");   
      return $ret["CandidateElection_ID"];
    }
  }
  
  function InsertCandidateElection($CandidateElectionData, $SQLTables = null) {
    
    $sql = "SELECT " . sqltablestoshow($SQLTables) . " FROM CandidateElection WHERE ";
    $MatchTableName = array(
      "ElectionID" => "Elections_ID", 
      "ElectPosID" => "ElectionsPosition_ID",
      "PosType" => "CandidateElection_PositionType", 
      "Party" => "CandidateElection_Party", 
      "PosText" => "CandidateElection_Text", 
      "PetText" => "CandidateElection_PetitionText", 
      "URLExplain" => "CandidateElection_URLExplain", 
      "Number" => "CandidateElection_Number", 
      "Order" => "CandidateElection_DisplayOrder", 
      "Display" => "CandidateElection_Display", 
      "Sex" => "CandidateElection_Sex", 
      "DBTable" => "CandidateElection_DBTable", 
      "DBValue" => "CandidateElection_DBTableValue", 
      "NbrVoters" => "CandidateElection_CountVoter",
      "SignDeadline" => "CandidateElection_SignDeadline",
    );
      
    $firsttime = 0;
    foreach ($MatchTableName as $index => $var) {      
      if (! empty ($CandidateElectionData[$index])) { 
        if ($firsttime == 0) { $firsttime = 1;} else { $sql .= " AND "; }
        $sql .= $var . " = :" . $index;
      } else {
        unset($CandidateElectionData[$index]);
      }
    }
  
    $ret = $this->_return_multiple($sql, $CandidateElectionData);
    
    if ( $ret[0]["CandidateElection_ID"] > 0 ) {
      return $ret[0]["CandidateElection_ID"];
    }
    
    if (! empty ($CandidateElectionData["ElectionID"])) {
      
      $sql = "INSERT INTO CandidateElection SET ";
      $MatchTableName = array(
          "ElectionID" => "Elections_ID", 
          "ElectPosID" => "ElectionsPosition_ID",
          "PosType" => "CandidateElection_PositionType", 
          "Party" => "CandidateElection_Party", 
          "PosText" => "CandidateElection_Text", 
          "PetText" => "CandidateElection_PetitionText", 
          "URLExplain" => "CandidateElection_URLExplain", 
          "Number" => "CandidateElection_Number", 
          "Order" => "CandidateElection_DisplayOrder", 
          "Display" => "CandidateElection_Display", 
          "Sex" => "CandidateElection_Sex", 
          "DBTable" => "CandidateElection_DBTable", 
          "DBValue" => "CandidateElection_DBTableValue", 
          "NbrVoters" => "CandidateElection_CountVoter",
          "SignDeadline" => "CandidateElection_SignDeadline",
      );
      
      $firsttime = 0;
      foreach ($MatchTableName as $index => $var) {      
        if (! empty ($CandidateElectionData[$index])) { 
          if ($firsttime == 0) { $firsttime = 1;} else { $sql .= ", "; }
          $sql .= $var . " = :" . $index;
        } else {
          unset($CandidateElectionData[$index]);
        }
      }
  
      $this->_return_nothing($sql, $CandidateElectionData);
      return ($this->_return_simple("SELECT LAST_INSERT_ID() as CandidateElection_ID"))[CandidateElection_ID];   
    }
  }
  
  function FindElectionType($ElectionID, $RegParty, $TypeElection, $TypeValue, $SQLTables = null) {
    return $this->_return_multiple(
        "SELECT " . sqltablestoshow($SQLTables) . " FROM CandidateElection WHERE Elections_ID = :ElectionID AND " .
        "CandidateElection_Party = :Party AND CandidateElection_DBTable = :DBTable AND " .
        "CandidateElection_DBTableValue = :DBValue",
        [
          "ElectionID" => $ElectionID, "Party" => $RegParty, 
          "DBTable" => $TypeElection, "DBValue" => $TypeValue
         ]    
    );
  }
  
  function FindElectionFromPositionID($ElectionID, $PositionID, $TypeElection, $TypeValue, $SQLTables = null) {
    return $this->_return_multiple(
      "SELECT " . sqltablestoshow($SQLTables) . " FROM CandidateElection " .  
      "LEFT JOIN ElectionsPosition ON " . 
      "(ElectionsPosition.ElectionsPosition_ID = CandidateElection.ElectionsPosition_ID) " . 
      "WHERE " .
       "Elections_ID " . (($ElectionID === null) ? "is" : "=") . " :ElectionID AND " .
      "CandidateElection.ElectionsPosition_ID " . (($PositionID === null) ? "is" : "=") . " :PositionID AND " .
      "CandidateElection_DBTable " . (($TypeElection === null) ? "is" : "=") . " :DBTable AND " .
      "CandidateElection_DBTableValue " . (($TypeValue === null) ? "is" : "=") . " :DBValue",
      [
        "ElectionID" => $ElectionID, "PositionID" => $PositionID, 
        "DBTable" => $TypeElection, "DBValue" => $TypeValue
      ]
    );
  }
  
  function FindInPartyCall($ElectionID, $County, $Party, $DBTable, $DBValue, $SQLTables = null) {
    return $this->_return_simple(
        "SELECT " . sqltablestoshow($SQLTables) . " FROM ElectionsPartyCall WHERE " .
        "Elections_ID = :ElectionID AND DataCounty_ID = :County AND " .
        "ElectionsPartyCall_Party = :Party AND ElectionsPartyCall_DBTable = :DBTable AND " . 
        "ElectionsPartyCall_DBTableValue = :DBValue",
        [
          "ElectionID" => $ElectionID, "County" => $County,  "Party" => $Party, 
          "DBTable" => $DBTable, "DBValue" => $DBValue
        ]           
    );
  }
    
  function FindElectionsAvailable ($DataState_ID = NULL, $Party = NULL, $CandidateElectionID = NULL, $SQLTables = null) {
    $sql = "SELECT " . sqltablestoshow($SQLTables) . " FROM ElectionsPosition " .
            "LEFT JOIN DataState ON (DataState.DataState_ID = ElectionsPosition.DataState_ID) ";
    $sql_vars = [];
    
    if ( ! empty($DataState_ID) || ! empty($Party) || ! empty($CandidateElectionID) ) {
      $sql .= "WHERE ";
    }  
    
    if (! empty($CandidateElectionID)) {
      $sql .= "ElectionsPosition_ID = :ElectionPositionID ";
      $sql_vars["ElectionPositionID"] = $CandidateElectionID;
    }
    
    if (! empty($DataState_ID)) {
      if ( ! empty($CandidateElectionID)) { $sql .= "AND "; }
      $sql .= "ElectionsPosition.DataState_ID = :DataState_ID ";
      $sql_vars["DataState_ID"] = $DataState_ID;
    }
    
    if ( ! empty ($Party)) {
      if ( ! empty($CandidateElectionID) || ! empty($DataState_ID)) { $sql .= " AND "; }
      $sql .= " (" . 
              "(ElectionsPosition_Type = 'party' AND ElectionsPosition_Party = :Party) ".
              "OR " .
              "(ElectionsPosition_Type = 'office' AND ElectionsPosition_Party IS NULL) " .
              ") ";
      $sql_vars["Party"] = $Party;
    } 
    /* else {
      $sql .= "AND ElectionsPosition_Party IS NULL ";
    } */
  
    $sql .= "ORDER BY ElectionsPosition_Order";
    
    return $this->_return_multiple($sql, $sql_vars);
  }
  
  function FindElectionInfoForPetition ($DistrictID, $DBTable = NULL, $Party = NULL, $DateToMatch = true, $SQLTables = null) {
    $sql = "SELECT " . sqltablestoshow($SQLTables) . ", UNIX_TIMESTAMP(Elections_Date) AS UnixElection_Date ";
    
    $sql .= ", CONCAT(DataDistrict_StateAssembly, LPAD(DataDistrict_Electoral, 3, 0)) AS ADED ";
    
    $sql .=  "FROM DataDistrict LEFT JOIN DataCounty ON (DataCounty.DataCounty_ID = DataDistrict.DataCounty_ID) " . 
            "LEFT JOIN DataState ON (DataState.DataState_ID = DataCounty.DataState_ID) " .
            "LEFT JOIN ElectionsPosition ON (DataState.DataState_ID = ElectionsPosition.DataState_ID) " . 
            "LEFT JOIN CandidateElection ON (CandidateElection.ElectionsPosition_ID = ElectionsPosition.ElectionsPosition_ID ";
            
    $sql .= "AND ";
    $sql .= "CandidateElection_DBTableValue = CONCAT(DataDistrict_StateAssembly, LPAD(DataDistrict_Electoral, 3, 0)) ";
              
    $sql .=  ") " .
            "LEFT JOIN Elections ON (Elections.Elections_ID = CandidateElection.Elections_ID) ";
            
    $sql .= "WHERE ElectionsPosition_DBTable = :DBTable AND DataDistrict_ID = :DistrictID ";
    
    if ( $DateToMatch == true) {
      $sql .= "AND Elections_Date > CURDATE()";
    }
    
    $sql_vars = array("DBTable" => $DBTable, "DistrictID" => $DistrictID);
    
    if ( ! empty ($Party)) {
      $sql .= " AND ElectionsPosition_Party = :Party";
      $sql_vars["Party"] = $Party;
    }
    
    $sql .= " LIMIT 100";
    return $this->_return_multiple($sql, $sql_vars);
  }
  
  function ListPetitionGroup($GroupID = NULL, $Status = NULL, $SQLTables = null) {
    $sql = "SELECT " . sqltablestoshow($SQLTables) . " FROM CandidateGroup " .
            "LEFT JOIN CandidateSet ON (CandidateGroup.CandidateSet_ID = CandidateSet.CandidateSet_ID) " . 
            "LEFT JOIN Candidate ON (CandidateGroup.Candidate_ID = Candidate.Candidate_ID) " . 
            "LEFT JOIN DataCounty ON (DataCounty.DataCounty_ID = CandidateGroup.DataCounty_ID) " .
            "LEFT JOIN CandidateElection ON (CandidateElection.CandidateElection_ID = Candidate.CandidateElection_ID) " . 
            "LEFT JOIN Elections ON (Elections.Elections_ID = CandidateElection.Elections_ID) " .
            "LEFT JOIN CandidateComRplceSet ON (CandidateComRplceSet.Candidate_ID = Candidate.Candidate_ID) " .
            "LEFT JOIN CandidateComRplce ON (CandidateComRplceSet.CandidateComRplce_ID = CandidateComRplce.CandidateComRplce_ID) ";
    if ( ! empty ($GroupID)) {
      $sql .= "WHERE CandidateGroup.CandidateSet_ID = :CandidateSet_ID ";
      $sql_vars = array("CandidateSet_ID" => $GroupID);
    } else {
      $sql_vars = array();
    }
            
    $sql .= "ORDER BY CandidateGroup.CandidateSet_ID DESC, CandidateElection_DisplayOrder ASC";              
    return $this->_return_multiple($sql, $sql_vars);  
  }

  function ListElectedPositions($StateAbbrev, $StateID = NULL, $PositionID = NULL, $Party = NULL, $PositionCode = NULL, $SQLTables = null) {
    $sql = "SELECT " . sqltablestoshow($SQLTables) . " FROM DataState " .
            "LEFT JOIN ElectionsPosition ON (DataState.DataState_ID = ElectionsPosition.DataState_ID) ";
            
    $sql_vars = array();
    $and = "";
    
    if ( ! empty ($PositionCode) || ! empty ($Party) || ! empty ($PositionID) || ! empty ($StateID)) {
      $sql .= "WHERE ";

      if ( ! empty ($PositionCode )) {
        $sql .= " ElectionsPosition_DBTable = :PositionCode ";
        $sql_vars["PositionCode"] = $PositionCode;
        $and = " AND";
      }
      
      if ( ! empty ($Party)) { 
        $sql .= $and . " ElectionsPosition_Party = :Party";
        $sql_vars["Party"] = $Party;
        $and = " AND ";
      }

      if ( $PositionID > 0) {
        $sql .= $and . "ElectionsPosition_ID = :PosID";
        $sql_vars['PosID'] = $PositionID;  
      } else {
        if ( $StateID == "id") {
          $sql .= $and . "DataState.DataState_ID = :State ";
        }  else {  
          $sql .= $and . "DataState.DataState_Abbrev = :State ";        
        }
        $sql_vars['State'] = $StateAbbrev;  
        $sql .= "ORDER BY ElectionsPosition_Order";
      } 
    }
    
    WriteStderr($sql, "SQL:");  
    WriteStderr($sql_vars, "SQL VAR:");  
    return $this->_return_multiple($sql, $sql_vars);
  }
  
  function ListParties($StateID, $OfficialOnly = false, $PartyID = NULL, $SQLTables = null) {
    $sql = "SELECT " . sqltablestoshow($SQLTables) . " FROM DataParty WHERE ";
  
    if ( $PartyID > 0) {
      $sql .= "DataParty_ID = :DataParty";
      $sql_vars = array("DataParty" => $PartyID);
    } else {
      $sql .= "DataState_ID = :StateID";
      $sql_vars = array("StateID" => $StateID);
    
      if ( $OfficialOnly == true) {
        $sql .= " AND DataParty_Recognized = :Recog";
        $sql_vars["Recog"] = "yes";
      }
    }
      
    return $this->_return_multiple($sql, $sql_vars);
  }

  function DisplayElectionPositions($ID, $SQLTables = null) {
    return $this->_return_simple(
      "SELECT " . sqltablestoshow($SQLTables) . " FROM ElectionsPosition " . 
      "WHERE ElectionsPosition_ID = :ID ",
      ['ID' => $ID]
    );
  }
  
   function DisplayElectionDate($ID, $SQLTables = null) {
    return $this->_return_simple(
        "SELECT " . sqltablestoshow($SQLTables) . " FROM ElectionsPosition WHERE Elections_Date >= NOW()"
    );
  }
  
  function ListElectionPositionsForEDAD($DBTableValue, $State, $SQLTables = null) {
    return $this->_return_multiple(
       "SELECT " . sqltablestoshow($SQLTables) . " FROM DataState " . 
      "LEFT JOIN Elections ON (Elections.DataState_ID = DataState.DataState_ID) " . 
      "LEFT JOIN ElectionsPartyCall ON (ElectionsPartyCall.Elections_ID = Elections.Elections_ID) " . 
      "LEFT JOIN ElectionsPosition ON (" . 
      "ElectionsPosition.ElectionsPosition_ID = ElectionsPartyCall.ElectionsPosition_ID) " . 
      "LEFT JOIN CandidateElection ON " . 
      "(CandidateElection.Elections_ID = Elections.Elections_ID AND " . 
      "CandidateElection.CandidateElection_DBTableValue = ElectionsPartyCall_ConversionValue ) " . 
      "LEFT JOIN Candidate ON (Candidate.CandidateElection_ID = CandidateElection.CandidateElection_ID) " . 
      "LEFT JOIN PublicProfile ON (PublicProfile.Candidate_ID = Candidate.Candidate_ID) " . 
      "LEFT JOIN CandidateProfile ON (CandidateProfile.CandidateProfile_ID = PublicProfile.CandidateProfile_ID) " . 
      "WHERE DataState_Abbrev = :State AND Elections_Date >= NOW() " . 
       "AND ElectionsPartyCall_DBTableValue = :DBTableValue " .
       "AND PublicProfile_PublishProfile = 'yes' " .
       "ORDER BY Elections_Date, ElectionsPartyCall.ElectionsPosition_ID", 
       ["DBTableValue" => $DBTableValue, "State" => $State]
     );
  }
    
  function ListElectionPositionsForStateID($StateID, $SQLTables = null) {
    $sql = "SELECT " . sqltablestoshow($SQLTables) . " FROM CandidateProfile " . 
            "LEFT JOIN Candidate ON (Candidate.Candidate_ID = CandidateProfile.Candidate_ID) " . 
            "LEFT JOIN CandidateElection ON (CandidateElection.CandidateElection_ID = Candidate.CandidateElection_ID) " . 
            "LEFT JOIN Elections on (CandidateElection.Elections_ID = Elections.Elections_ID) " . 
            "LEFT JOIN DataState ON (DataState.DataState_ID = Elections.DataState_ID) " . 
            "WHERE CandidateProfile_PublishProfile = 'yes' AND DataState.DataState_ID = :StateID";
    $sql_vars = array("StateID" => $StateID);
    return $this->_return_multiple($sql, $sql_vars);  
  }
  
  function ListCandidatePetitions($CandidateID = NULL, $SQLTables = null) {
    $sql = "SELECT " . sqltablestoshow($SQLTables) . " FROM CandidateProfile " . 
            "LEFT JOIN Candidate ON " . 
            "(Candidate.Candidate_ID = CandidateProfile.Candidate_ID) ";
    
    if (! empty ($CandidateID)) {
      $sql .= "WHERE CandidateProfile.Candidate_ID = :CandidateID";
      $sql_vars = array("CandidateID" => $CandidateID);
      return $this->_return_simple($sql, $sql_vars);
    }
    
    return $this->_return_multiple($sql);
  }
  
  // Function use 8.1 format - Don't change var names
  function ListProfilesForCandidates($SystemID = null, $TeamID = null, $CandidateID = null, $SQLTables = null) {
  	
  	if ($SystemID > 0) { $SQLVar = "Candidate.SystemUser_ID"; $VarValue = $SystemID; }
  	else if ($CandidateID > 0) { $SQLVar = "Candidate.Candidate_ID"; $VarValue = $CandidateID; }
  	
    return $this->_return_multiple(
        "SELECT " . sqltablestoshow($SQLTables) . " FROM Candidate " .
        "LEFT JOIN PublicProfile ON (PublicProfile.Candidate_ID = Candidate.Candidate_ID) " .
        "LEFT JOIN CandidateProfile ON (PublicProfile.CandidateProfile_ID = CandidateProfile.CandidateProfile_ID) " .
        "LEFT JOIN CandidateElection ON (Candidate.CandidateElection_ID = CandidateElection.CandidateElection_ID) " .
        "LEFT JOIN Elections on (Elections.Elections_ID = CandidateElection.Elections_ID) " .
        "WHERE " . $SQLVar . " = :VarID " .
        
      	"AND Elections.Elections_Date >= NOW() " .
    	
        "ORDER BY Elections.Elections_Date DESC, Elections.DataState_ID",
        ["VarID" => $VarValue]
    );
  }
  
  function ListCandidateProfile($CandidateID = NULL, $CandidateProfileID = NULL, $SQLTables = null) {
    $sql = "SELECT " . sqltablestoshow($SQLTables) . " FROM CandidateProfile ";
        
    if (! empty ($CandidateID)) {
      $sql .= "WHERE Candidate_ID = :CandidateID";
      $sql_vars = array("CandidateID" => $CandidateID);
      
      if ( ! empty ($CandidateProfileID)) {
        $sql .= " AND CandidateProfile_ID = :ProfileID";
        $sql_vars["ProfileID"] = $CandidateProfileID;
      }
      
      return $this->_return_simple($sql, $sql_vars);

    } else {
      $sql .= "WHERE CandidateProfile_ID = :ProfileID";
      $sql_vars = array("ProfileID" => $CandidateProfileID);
      return $this->_return_simple($sql, $sql_vars);
    }
    
    return $this->_return_multiple($sql);
  }
  
  function ListAllElectionsDates($DateList = NULL, $StateID = NULL, $SQLTables = null) {
    $sql = "SELECT " . sqltablestoshow($SQLTables) . " FROM Elections " .
            "LEFT JOIN DataState ON (DataState.DataState_ID = Elections.DataState_ID)";
    
    if (empty($StateID) && empty ($DateList)) {
      $sql .= " ORDER BY Elections_Date";
      return $this->_return_multiple($sql);
    }
    
    $sql .= " WHERE ";
    
    if ( ! empty ($DateList)) {
      $sql .= "Elections.Elections_Date >= NOW()";
    }
    
    if ( ! empty ($StateID)) {
      if ( ! empty ($DateList)) { $sql .= " AND "; }
      $sql .= "Elections.DataState_ID = :State";
      $sql_vars = array("State" => $StateID);  
      $sql .= " ORDER BY Elections_Date DESC";
      return $this->_return_multiple($sql, $sql_vars);
    } 
    
    $sql .= " ORDER BY Elections_Date";
    return $this->_return_multiple($sql);
  }
  
  function findelectionbystatedate($StateID, $Date, $SQLTables = null) {
    return $this->_return_simple(
      "SELECT " . sqltablestoshow($SQLTables) . " FROM Elections WHERE Elections_Date = :Date AND DataState_ID = StateID",
      ["Date" => $Date, "StateID" => $StateID]
    );
  }
  
  function FindCandidateElection($StateID, $PositionID, $SQLTables = null) {
    return $this->_return_multiple(
      "SELECT " . sqltablestoshow($SQLTables) . " FROM CandidateElection " .
      "LEFT JOIN Elections ON (Elections.Elections_ID = CandidateElection.Elections_ID) " .
      "WHERE ElectionsPosition_ID = :PositionID AND DataState_ID = :StateID ORDER BY Elections_Date ASC",
      ["PositionID" => $PositionID, "StateID" => $StateID]
    );
  }
  
  // Function use 8.1 format - Don't change var names
  function PublicProfileToggle($PublicProfileID = null, $CandidateID = null,  $flag = null) {
  	if ($PublicProfileID > 0 || $CandidateID > 0) {
  		
  		if ( $CandidateID > 0) { $Table = "Candidate_ID"; $var = $CandidateID; }
  		if ( $PublicProfileID > 0) { $Table = "PublicProfile_ID"; $var = $PublicProfileID; }

	    return $this->_return_nothing(
  	    "UPDATE PublicProfile SET PublicProfile_PublishProfile = :flag " . 
  	    "WHERE $Table = :Var",
    	  ["flag" => $flag, "Var" => $var]
    	);
    }
  }
  
  // Function use 8.1 format - Don't change var names
  function UpdateCandidateProfileByFields($CandidateProfile_ID,	$Quarantine = null, $PicFileName = null, 
  	$TmpPicFileName = null, $PicVerif = null, $PDFFileName = null, $TmpPDFFileName = null, 
  	$PDFVerif = null, $PDFPetition = null, $PDFPetitionState = null, $Team_ID = null, 
  	$PolSelfParty = null, $PolSelfCaucus = null, $PolSelfAss = null, $FirstName = null, $LastName = null, 
  	$Alias = null, $CandidateRegAuthority_ID = null, $RegID = null, $DataConference_ID = null, $Website = null, 
  	$Email = null, $SocialImgPath = null, $Twitter = null, $BlueSky = null, $Truth = null, $Facebook = null, 
  	$LinkedIn = null, $Instagram = null, $TikTok = null, 	$YouTube = null, $BallotPedia = null, $PhoneNumber = null, 
  	$FaxNumber = null, $Statement = null, $Donation = null, $PublishPetition = null, $Complain = null, 
  	$LastModified = null) {
  	 												
  	WriteStderr($CandidateProfile_ID, "Inside RepMyBlock DB Function UpdateCandidateProfileByFields: $CandidateProfile_ID");
									
  	if ( $CandidateProfile_ID > 0) {
			
			$fields = [];

			$params = [ "CandidateProfileID" => $CandidateProfile_ID  ];
  	
	  	$updates = [
				"CandidateProfile_Quarantine" => $Quarantine,
				"CandidateProfile_PicFileName" => $PicFileName, 
				"CandidateProfile_TmpPicFileName" => $TmpPicFileName,
				"CandidateProfile_PicVerif" => $PicVerif,
				"CandidateProfile_PDFFileName" => $PDFFileName,
				"CandidateProfile_TmpPDFFileName" => $TmpPDFFileName,
				"CandidateProfile_PDFVerif" => $PDFVerif, 
				"CandidateProfile_PDFPetition" => $PDFPetition,
				"CandidateProfile_PDFPetitionState" => $PDFPetitionState,
				"Team_ID" => $Team_ID, 
				"CandidateProfile_PolSelfParty" => $PolSelfParty,
				"CandidateProfile_PolSelfCaucus" => $PolSelfCaucus,
				"CandidateProfile_PolSelfAss" => $PolSelfAss, 
				"CandidateProfile_FirstName" => $FirstName, 
				"CandidateProfile_LastName" => $LastName,
				"CandidateProfile_Alias" => $Alias,
				"CandidateRegAuthority_ID" => $CandidateRegAuthority_ID,
				"CandidateProfile_RegID" => $RegID,
				"DataConference_ID" => $DataConference_ID,
				"CandidateProfile_Website" => $Website,
				"CandidateProfile_Email" => $Email,
				"CandidateProfile_SocialImgPath" => $SocialImgPath,
				"CandidateProfile_Twitter" => $Twitter,
				"CandidateProfile_BlueSky" => $BlueSky,
				"CandidateProfile_Truth" => $Truth, 
				"CandidateProfile_Facebook" => $Facebook,
				"CandidateProfile_LinkedIn" => $LinkedIn, 
				"CandidateProfile_Instagram" => $Instagram,
				"CandidateProfile_TikTok" => $TikTok,
				"CandidateProfile_YouTube" => $YouTube, 
				"CandidateProfile_BallotPedia" => $BallotPedia, 
				"CandidateProfile_PhoneNumber" => $PhoneNumber,
				"CandidateProfile_FaxNumber" => $FaxNumber, 
				"CandidateProfile_Statement" => $Statement,
				"CandidateProfile_Donation" => $Donation,
				"CandidateProfile_PublishPetition" => $PublishPetition,
				"CandidateProfile_Complain" => $Complain
			];

			foreach ($updates as $column => $value) {
				if ($value !== null) {
				  $param = str_replace(["CandidateProfile_"], "", $column);
				  $fields[] = "$column = :$param";
				  $params[$param] = $value;
				}
			}
			
			WriteStderr($fields, "Inside RepMyBlock DB Function UpdateCandidateProfileByFields: $CandidateProfile_ID");
			

			$fields[] = "CandidateProfile_LastModified = NOW()";
			return $this->_return_nothing(
				"UPDATE CandidateProfile SET " . implode(", ", $fields) . " WHERE CandidateProfile_ID = :CandidateProfileID", 
				$params
			);
  	}											
	}
	
  // Function use 8.1 format - Don't change var names
  function UpdateCandidateProfileAutoCycle($CandidateProfile_ID, $Candidate_ID, $ProfileArray) {
    
    // This is where we'll put the logic to normalize all the LINKS to various place depending
    // how the candidates input their links.
    $ProfilePublic = $ProfileArray["MakePublic"];
    WriteStderr($ProfileArray, "Inside updatecandidateprofile DB: CandidateProfile_ID: $CandidateProfile_ID");
    
    if ( ! empty ($ProfileArray["Phone"])) { $ProfileArray["Phone"] = FormatPhoneNumber($ProfileArray["Phone"]); }
    if ( ! empty ($ProfileArray["Fax"])) { $ProfileArray["Fax"] = FormatPhoneNumber($ProfileArray["Fax"]); }

    $MatchTableName = [
      "PicFile" => "CandidateProfile_PicFileName",     "PDFFile" => "CandidateProfile_PDFFileName",
      "First"   =>  "CandidateProfile_FirstName",      "Last"   => "CandidateProfile_LastName",
      "Full"   =>  "CandidateProfile_Alias",           "URL"   =>  "CandidateProfile_Website",
      "Email"   => "CandidateProfile_Email",           "Twitter"   => "CandidateProfile_Twitter",
      "BlueSky" => "CandidateProfile_BlueSky",         "Facebook"   => "CandidateProfile_Facebook",
      "LinkedIn" => "CandidateProfile_LinkedIn",       "Instagram"   => "CandidateProfile_Instagram",
      "TikTok"   => "CandidateProfile_TikTok",         "YouTube"   => "CandidateProfile_YouTube", 
      "Ballotpedia"   => "CandidateProfile_BallotPedia", "Phone"   => "CandidateProfile_PhoneNumber",
      "Fax"   => "CandidateProfile_FaxNumber",      "Platform"   => "CandidateProfile_Statement",
      "Quarantine" => "CandidateProfile_Quarantine", "MakePublic"  => "CandidateProfile_PublishPetition", 
      "PicVerified" => "CandidateProfile_PicVerif", "PDFVerified" => "CandidateProfile_PDFVerif",
      "ProfileComplain" => "CandidateProfile_Complain", "Donation" => "CandidateProfile_Donation", 
      "PublishPetition" => "CandidateProfile_PublishPetition", "SelfAss" => "CandidateProfile_PolSelfAss",
      "SelfParty" => "CandidateProfile_PolSelfParty", "SelfCaucus" => "CandidateProfile_PolSelfCaucus",
      "Truth" => "CandidateProfile_Truth", "TmpPicFile" => "CandidateProfile_TmpPicFileName",
      "PicFile" => "CandidateProfile_PicFileName"
    ];
    
    WriteStderr($MatchTableName, "The Match Table");
   
    
    if ( $CandidateProfile_ID > 0) {
      $return = $this->ListCandidateProfile(NULL, $CandidateProfile_ID);
      # This is to set the colums that changed.
      foreach ($ProfileArray as $index => $var) {
        if ( $var == $return[$MatchTableName[$index]]) {
          unset ($ProfileArray[$index]);
        }
      }
    }
    
    if ( empty ($return)) {  $sql = "INSERT INTO"; } else { $sql = "UPDATE"; }
    $sql .= " CandidateProfile SET ";

    $firsttime = false;
    foreach ($ProfileArray as $index => $var) {
      if ($firsttime) { $sql .= ", "; }
      if ($var !== null && $var !== '') {
        $sql .= $MatchTableName[$index] . " = :" . $index;
        $sql_vars[$index] = $var;
      } else {
        $sql .= $MatchTableName[$index] . " = NULL";
      }
      $firsttime = true;    
    }

    $sql .= $firsttime ? "," : NULL;
    $sql .= " CandidateProfile_LastModified = NOW()";

    if ( ! empty ($return)) {
      $sql .= " WHERE CandidateProfile_ID = :CandidateProfile_ID";
      $sql_vars["CandidateProfile_ID"] = $CandidateProfile_ID;
    }

    $this->_return_nothing($sql, $sql_vars);   
    
    $MySpecialCandidate = (!empty($return)) ? 
        $CandidateProfile_ID : 
        $this->_return_simple("SELECT LAST_INSERT_ID() as CandidateProfileID")["CandidateProfileID"];    
        
    return $this->UpdatePublicProfile($MySpecialCandidate, $Candidate_ID, $ProfilePublic);
  }

  function UpdatePublicProfile($CandidateProfile_ID, $Candidate_ID, $MakePublic = 'no') {
    
    WriteStderr( $PublicProfileID, "DB UpdatePublicProfile($CandidateProfile_ID, $Candidate_ID, $MakePublic)");
    $PublicProfileID = $this->FindPublicProfile($Candidate_ID);
    
    if (empty ($PublicProfileID)) {
      // When Insering, Publish Profile is always 'no' - Only on update it can be 'yes'
      $this->_return_nothing(
        "INSERT INTO PublicProfile SET CandidateProfile_ID = :CandidateProfileID, " .
        "Candidate_ID = :CandidateID, PublicProfile_PublishProfile = 'no', " . 
        "PublicProfile_LastModified = NOW()",
        ["CandidateID" => $Candidate_ID, "CandidateProfileID" => $CandidateProfile_ID]
      );
      return $this->_return_simple("SELECT LAST_INSERT_ID() as PublicProfileID")["PublicProfileID"];
    }

    $this->_return_nothing(
      "UPDATE PublicProfile SET CandidateProfile_ID = :CandidateProfileID, " .
      "Candidate_ID = :CandidateID, PublicProfile_PublishProfile = :MakePublic, " .
      "PublicProfile_LastModified = NOW() WHERE " .
      "PublicProfile_ID = :PublicProfile",
      [
        "PublicProfile" => $PublicProfileID["PublicProfile_ID"], "CandidateID" => $Candidate_ID, 
        "CandidateProfileID" => $CandidateProfile_ID, "MakePublic" => $MakePublic
      ]
    );
      
    return $PublicProfileID["PublicProfile_ID"];
  }

	// Function use 8.1 format - Don't change var names
  function FindPublicProfile($Candidate_ID = null, $PublicProfileID = null, $SQLTables = null) {

    if ( empty ($PublicProfileID)) {
      return $this->_return_simple(
        "SELECT " . sqltablestoshow($SQLTables) . " FROM PublicProfile WHERE Candidate_ID = :CandidateID",
        ["CandidateID" => $Candidate_ID]
      );
    }

    return $this->_return_simple(
      "SELECT " . sqltablestoshow($SQLTables) . " FROM PublicProfile WHERE PublicProfile_ID = :PublicProfileID",
      ["PublicProfileID" => $PublicProfileID]
    );
  }
  
  function PublicProfileInfo($PublicProfileID, $SQLTables = null) {
    return $this->_return_simple(
      "SELECT " . sqltablestoshow($SQLTables) . " FROM PublicProfile " . 
      "LEFT JOIN Candidate ON (PublicProfile.Candidate_ID = Candidate.Candidate_ID) " . 
      "LEFT JOIN CandidateProfile ON (PublicProfile.CandidateProfile_ID = CandidateProfile.CandidateProfile_ID) " .
      "WHERE PublicProfile_ID = :PublicProfileID",
      ["PublicProfileID" => $PublicProfileID]
    );
  }
  
  function CheckCandidateGroups ($CandidatesIDs, $SQLTables = null) {
    $sql = "SELECT " . sqltablestoshow($SQLTables) . " FROM CandidateGroup WHERE "; 
    
     if ( ! empty ($CandidatesIDs)) {
      foreach ($CandidatesIDs as $index => $var) {
        $sql .= $and ."Candidate_ID = '" . intval($var) . "'";
        $and = " OR ";
      }
    }
    
    return $this->_return_multiple($sql);
  }
  
  
  function updatecandidatesetorder($CandidateGroupID, $Order) {
    if ( $CandidateGroupID > 0 && $Order > 0) {
      $sql = "UPDATE CandidateGroup SET CandidateGroup_Order = :Order WHERE CandidateGroup_ID = :GroupID";
      return $this->_return_nothing($sql, array("Order" => $Order, "GroupID" => $CandidateGroupID));
    }
  }
  
  function addcandidateprofileid($CandidateID, $CandidateProfileID) {
    if ( $CandidateID > 0) {
      $sql = "UPDATE Candidate SET CandidateProfile_ID = :ProfID WHERE Candidate_ID = :CandID";
      $sql_vars = array("ProfID" => $CandidateProfileID, "CandID" => $CandidateID);  
      return $this->_return_nothing($sql, $sql_vars);
    }
  }
  
  function ListPetitionCandidateSet($PetitionSetID, $SQLTables = null) {
    $sql = "SELECT " . sqltablestoshow($SQLTables) . " FROM CandidateSet " .
            "LEFT JOIN CandidateGroup ON (CandidateGroup.CandidateSet_ID = CandidateSet.CandidateSet_ID) " .
            "LEFT JOIN Candidate ON (Candidate.Candidate_ID = CandidateGroup.Candidate_ID) " . 
            "LEFT JOIN CandidateElection ON (Candidate.CandidateElection_ID = CandidateElection.CandidateElection_ID) " . 
            "WHERE CandidateSet.CandidateSet_ID = :CandidateSet " . 
            "ORDER BY CandidateGroup_Order";
    return $this->_return_multiple($sql, array('CandidateSet'=> $PetitionSetID));
  }
  
  function ListCandidateInformationByUNIQ($UniqID, $ElectionID = NULL, $CandidateElection_ID = NULL, $SQLTables = null) {
    $sql = "SELECT " . sqltablestoshow($SQLTables) . " FROM PublicProfile " . 
            "LEFT JOIN CandidateProfile ON (PublicProfile.CandidateProfile_ID = CandidateProfile.CandidateProfile_ID) " . 
            "LEFT JOIN Candidate ON (Candidate.Candidate_ID = PublicProfile.Candidate_ID) " .     
            "LEFT JOIN CandidateGroup ON (Candidate.Candidate_ID = CandidateGroup.Candidate_ID) " . 
            "LEFT JOIN CandidateSet ON (CandidateGroup.CandidateSet_ID = CandidateSet.CandidateSet_ID) " .
            "LEFT JOIN CandidateElection ON (Candidate.CandidateElection_ID = CandidateElection.CandidateElection_ID) " . 
            "WHERE Candidate.Candidate_UniqStateVoterID = :UniqID";
    $sql_vars  = array('UniqID' => $UniqID);
            
    if ( ! empty ($ElectionID)) {
      $sql .= " AND Elections_ID = :ElectionID";
      $sql_vars["ElectionID"] = $ElectionID;
    }
    
    if ( ! empty ($CandidateElection_ID)) {
      $sql .= " AND Candidate.CandidateElection_ID = :CandidateElectionID";
      $sql_vars["CandidateElectionID"] = $CandidateElection_ID;
    }
    
    $sql .= " ORDER BY CandidateGroup.CandidateSet_ID, CandidateGroup_Order";        
    
    // Fix the issue as the Candidate PROFILE is tied to the username and not the VOTER ID.
    
    
    return $this->_return_multiple($sql, $sql_vars);
  }
  
  function ListCandidateInformation($SystemUserID, $SQLTables = null) {
    $sql = "SELECT " . sqltablestoshow($SQLTables) . " FROM Candidate " . 
            "LEFT JOIN CandidateGroup ON (Candidate.Candidate_ID = CandidateGroup.Candidate_ID) " . 
            "LEFT JOIN CandidateSet ON (CandidateGroup.CandidateSet_ID = CandidateSet.CandidateSet_ID) " .
            "WHERE Candidate.SystemUser_ID = :SystemUserID";
    return $this->_return_multiple($sql, array('SystemUserID' => $SystemUserID));
  }
  
  function ListCandidateTeamInformation($TeamID, $SQLTables = null) {
    $sql = "SELECT " . sqltablestoshow($SQLTables) . " FROM Candidate " . 
            "LEFT JOIN CandidateGroup ON (Candidate.Candidate_ID = CandidateGroup.Candidate_ID) " . 
            "LEFT JOIN CandidateSet ON (CandidateSet.CandidateSet_ID = CandidateGroup.CandidateSet_ID) " .
            "LEFT JOIN CandidateElection ON (CandidateElection.CandidateElection_ID = Candidate.CandidateElection_ID) " .
            "LEFT JOIN Elections ON (Elections.Elections_ID = CandidateElection.Elections_ID) " .
            "LEFT JOIN DataDistrictTown ON (Candidate.DataDistrictTown_ID = DataDistrictTown.DataDistrictTown_ID) " . 
            "WHERE Candidate.Team_ID = :Team_ID";
            
    return $this->_return_multiple($sql, array('Team_ID' => $TeamID));
  }
  
  function ListElections($Type = NULL) {
    $sql = "SELECT DISTINCT ElectionsPosition.ElectionsPosition_ID, ElectionsPosition_DBTable, ElectionsPosition.DataState_ID, " . 
            "ElectionsPosition_Type, ElectionsPosition_Name, ElectionsPosition_Party, ElectionsPosition_Order, " . 
            "ElectionsPosition_Explanation, DataState_Name, DataState_Abbrev, ElectionsPartyCall_Party, " . 
            "ElectionsPartyCall.Elections_ID, " . 
            "Elections_Text, Elections_Date, Elections_Type, DataCounty_ID, ElectionsPartyCall_DBTable, ElectionsPartyCall_SignDeadline " .
            "FROM ElectionsPosition LEFT JOIN DataState ON (DataState.DataState_ID = ElectionsPosition.DataState_ID) "  . 
            "LEFT JOIN ElectionsPartyCall ON (ElectionsPartyCall.ElectionsPosition_ID = ElectionsPosition.ElectionsPosition_ID) "  . 
            "LEFT JOIN Elections ON (ElectionsPartyCall.Elections_ID = Elections.Elections_ID) ";
          
    $sql .= "WHERE Elections_Date >= NOW() ";
            
    switch ($Type) {  
      case "ADED":
        $sql .= "AND ElectionsPosition_DBTable = \"ADED\" ";
        break;
              
      default:
        $sql .= "AND Elections_Date IS NOT NULL ";
        break;
    }
      
    $sql .= "ORDER BY ElectionsPosition.DataState_ID, ElectionsPosition_Order DESC";
    return $this->_return_multiple($sql);
  }
  
  function ListElectionsDates ($limit = 50, $start = 0, $futureonly = false, $StateID = NULL, $ElectionID = NULL) {
    $sql = "SELECT DISTINCT DataState.DataState_ID, DataState.DataState_Name, DataState_Abbrev, Elections_Text, Elections_Date, Elections_Type, " . 
            "Elections.Elections_ID " .
            "FROM DataState " . 
            "LEFT JOIN ElectionsPosition ON (ElectionsPosition.DataState_ID = DataState.DataState_ID) " .
            "LEFT JOIN CandidateElection ON (ElectionsPosition.ElectionsPosition_ID = CandidateElection.ElectionsPosition_ID) " . 
            "LEFT JOIN Elections ON (Elections.Elections_ID = CandidateElection.Elections_ID) ";
    
    // Not very elegant but I am tired.
    if ( $futureonly == true ) {
      $sql .= "WHERE (Elections_Date >= NOW()) ";
      if ( $StateID > 0) { $sql .= "AND DataState.DataState_ID = :StateID "; }
    } else {
      if ( $StateID > 0 ) { $sql .= "WHERE DataState.DataState_ID = :StateID "; }
    }
    
    if ( ! empty($ElectionID)) { 
      $sql .= "WHERE Elections.Elections_ID = :ElectionID ";
      return $this->_return_multiple($sql, array("ElectionID" => $ElectionID));
    }
  
    if ( empty ($StateID)) { $sql .= "WHERE Elections_Date is NOT NULL ";  }  
    $sql .= "ORDER BY Elections_Date, Elections_Type ";    
    
    if ( $limit > 0) {
      $sql .= "LIMIT $start, $limit";  
    }

    if ( $StateID > 0) {
      $sql_vars = array("StateID" => $StateID);
      return $this->_return_multiple($sql, $sql_vars);      
    }
    
    return $this->_return_multiple($sql);
  }
  
  function ListStates($DataStateID = null, $SQLTables = null) {
    if ( $DataStateID > 0) {
      return $this->_return_simple(
        "SELECT " . sqltablestoshow($SQLTables) . " FROM DataState WHERE DataState_ID = :ID",
        ["ID" => $DataStateID]
      );
    }
    
    return $this->_return_multiple(
      "SELECT " . sqltablestoshow($SQLTables) . " FROM DataState ORDER BY DataState_Abbrev"
    );
  }
  
  function CandidateElection($DBTable, $DBTableValue, $FromDate = NULL,  $Party = NULL, $ElectionID = NULL, $SQLTables = null) {
    $sql =   "SELECT " . sqltablestoshow($SQLTables) . " FROM CandidateElection " .
            "LEFT JOIN Elections ON (Elections.Elections_ID = CandidateElection.Elections_ID) " .
            "WHERE CandidateElection_DBTable = :DBTable AND " . 
            "CandidateElection_DBTableValue = :DBValue";
    $sql_vars = array('DBTable' => $DBTable, 'DBValue' => $DBTableValue);            
    
    if ( ! empty ($FromDate)) {
      $sql .= " AND Elections_Date >= :FromDate";
      $sql_vars["FromDate"] = $FromDate;
    }
                    
    if ( ! empty ($Party)) {
      $sql .= " AND CandidateElection_Party = :Party";
      $sql_vars["Party"] = $Party;
    }
    
    if ( ! empty ($ElectionID)) {
      $sql .= " AND CandidateElection.Elections_ID = :ElectionID";
      $sql_vars["ElectionID"] = $ElectionID;
    }
    
    return $this->_return_multiple($sql, $sql_vars);
  }

  function ListCandidateNomination($SystemUserID, $SQLTables = null) {
    $sql = "SELECT " . sqltablestoshow($SQLTables) . " FROM CanNomination WHERE SystemUser_ID = :SystemUserID";
    $sql_vars = array('SystemUserID' => $SystemUserID);    
  }
  
  function GetRandomCandidateSetID($RandomText, $SQLTables = null) {
    $sql = "SELECT " . sqltablestoshow($SQLTables) . " FROM CandidateSet WHERE CandidateSet_Random = :GroupRandomText";    
    return $this->_return_simple($sql, array("GroupRandomText" => $RandomText));
  }
  
  function NextPetitionSet($SystemUser_ID) {
    if ( $SystemUser_ID > 0) {

      do {
        $RandomString = PrintRandomText(12);
        $ret = $this->GetRandomCandidateSetID($RandomString);
      } while ( ! empty ($ret["CandidateSet_ID"]));
      
      $sql = "INSERT INTO CandidateSet SET SystemUser_ID = :SystemUserID, CandidateSet_Random = :Random, CandidateSet_TimeStamp = NOW()";
      $sql_vars = array("SystemUserID" => $SystemUser_ID, "Random" => $RandomString);
      $this->_return_nothing($sql, $sql_vars);
    
      $sql = "SELECT LAST_INSERT_ID() as CandidateSet";
      $ret =  $this->_return_simple($sql);
      $ret["Random"] = $RandomString;
      return $ret;
    }    
  }
  
  function InsertCandidateSet($CandidateID, $CandidateSetID, $Party, $CountyID, $Order = "1", $WaterMark = "yes") {
    $sql = "INSERT INTO CandidateGroup SET " .
            "CandidateSet_ID = :CanPetSetID, Candidate_ID = :CandidateID, " .
            "DataCounty_ID = :CountyID, CandidateGroup_Party = :Party, " .
            "CandidateGroup_Watermark = :Water, CandidateGroup_Order = :Order";
            
            
    $sql_vars = array("CanPetSetID" => $CandidateSetID, "CandidateID" => $CandidateID, 
                      "CountyID" => $CountyID, "Party" => $Party, "Water" => $WaterMark, "Order" => $Order);      
    $this->_return_nothing($sql, $sql_vars);
    
    $sql = "SELECT LAST_INSERT_ID() as CandidateSet_ID";
    return $this->_return_simple($sql)["CandidateSet_ID"];
  }
  
  // Function use 8.1 format - Don't change var names
  function InsertCandidate($SystemUserID = NULL, $UniqNYSVoterID = NULL, $RawVoterID = NULL, $DataCountyID = NULL, 
  													$CandidateElectionID = NULL, $Party = NULL, $DisplayName = NULL, $Address = NULL, 
  													$DBTable = NULL, $DBValue = NULL, $StatsVoters = NULL, $Status = NULL, 
  													$TeamID = NULL, $NameSet = NULL) {
                                                            
    $WaterMark = 'yes';
                                                            
    $sql = "INSERT INTO Candidate SET SystemUser_ID = :SystemUserID, Candidate_UniqStateVoterID = :UniqNYSVoterID, " .
            "Voters_ID = :RawVoterID, DataCounty_ID = :DataCountyID," .
            "CandidateElection_ID = :CandidateElectionID, Candidate_Party = :Party, Candidate_DispName = :DisplayName, " .
            "Candidate_DispResidence = :Address, CandidateElection_DBTable = :DBTable, " .
            "CandidateElection_DBTableValue = :DBValue, Candidate_StatsVoters = :StatsVoters, " . 
            "Candidate_Status = :Status, Candidate_Watermark = :WaterMark, Candidate_LastModified = NOW()";
            
    $sql_vars = array("SystemUserID" => $SystemUserID, "UniqNYSVoterID" => $UniqNYSVoterID, 
                      "RawVoterID" => $RawVoterID, "DataCountyID" => $DataCountyID, 
                      "CandidateElectionID" => $CandidateElectionID, 
                      "Party" => $Party, "DisplayName" =>  $DisplayName, 
                      "Address" => $Address, "DBTable" => $DBTable, "DBValue" => $DBValue, 
                      "StatsVoters" => $StatsVoters, "Status" => $Status, "WaterMark" => $WaterMark);
                      
    if ( $NameSet != NULL ) {
      $sql .= ", Candidate_PetitionNameset = :NameSet";
      $sql_vars["NameSet"] = $NameSet;
    }
    
    if ( $TeamID != NULL) {
      $sql .= ", Team_ID = :TeamID";
      $sql_vars["TeamID"] = $TeamID;
    }
    
    $this->_return_nothing($sql, $sql_vars);
    
    $sql = "SELECT LAST_INSERT_ID() as Candidate_ID";
    return $this->_return_simple($sql)["Candidate_ID"];
  }
	
  // Function use 8.1 format - Don't change var names
  function SearchPetitionCandidate($SystemUserID = null, $UniqNYSVoterID = null, $RawVoterID = null, 
  																	$DataCountyID = null, $CandidateElectionID = null, $Party = null, 
  																	$DisplayName = null,  $Address = null, $DBTable = null, $DBValue = null, 
  																	$Status = null, $TeamID = NULL, $SQLTables = null) {
                                                            
    $sql = "SELECT " . sqltablestoshow($SQLTables) . " FROM Candidate WHERE ";
    $and = "";
    $sql_vars = [];
    
    if ( ! empty ($SystemUserID)) {
      $sql .= $and . "SystemUser_ID = :SystemUserID"; $and = " AND ";  $sql_vars["SystemUserID"] = $SystemUserID;
    }
    
    if ( ! empty ($UniqNYSVoterID)) {
      $sql .= $and . "Candidate_UniqStateVoterID = :UniqNYSVoterID"; $and = " AND ";  $sql_vars["UniqNYSVoterID"] = $UniqNYSVoterID;
    }
    
    if ( ! empty ($RawVoterID)) {
      $sql .= $and . "Voters_ID = :RawVoterID"; $and = " AND ";  $sql_vars["RawVoterID"] = $RawVoterID;
    }
  
    if ( ! empty ($DataCountyID)) {
      $sql .= $and . "DataCounty_ID = :DataCountyID"; $and = " AND ";  $sql_vars["DataCountyID"] = $DataCountyID;
    }
    
    if ( ! empty ($CandidateElectionID)) {
      $sql .= $and . "CandidateElection_ID = :CandidateElectionID"; $and = " AND ";  $sql_vars["CandidateElectionID"] = $CandidateElectionID;
    }
    
    if ( ! empty ($Party)) {
      $sql .= $and . "Candidate_Party = :Party"; $and = " AND ";  $sql_vars["Party"] = $SysPartytemUserID;
    }
    
    if ( ! empty ($DisplayName)) {
      $sql .= $and . "Candidate_DispName = :DisplayName"; $and = " AND ";  $sql_vars["DisplayName"] = $DisplayName;
    }
    
    if ( ! empty ($Address)) {
      $sql .= $and . "Candidate_DispResidence = :Address"; $and = " AND ";  $sql_vars["Address"] = $Address;
    }
    
    if ( ! empty ($DBTable)) {
      $sql .= $and . "CandidateElection_DBTable = :DBTable"; $and = " AND ";  $sql_vars["DBTable"] = $DBTable;
    }
    
    if ( ! empty ($DBValue)) {
      $sql .= $and . "CandidateElection_DBTableValue = :DBValue"; $and = " AND ";  $sql_vars["DBValue"] = $DBValue;
    }
    
    if ( ! empty ($Status)) {
      $sql .= $and . "Candidate_Status = :Status"; $and = " AND ";  $sql_vars["Status"] = $Status;
    }
    
    if ( ! empty ($TeamID)) {
      $sql .= $and . "Team_ID = :TeamID"; $and = " AND ";  $sql_vars["TeamID"] = $TeamID;
    }
        
    return $this->_return_multiple($sql, $sql_vars);
  }

  function CandidateNomination($SystemUserID, $ElectionID, $CandidateID) {
    return $this->_return_nothing(
        "INSERT INTO CanNomination SET Candidate_ID = :CandidateID, SystemUser_ID = :SystemUserID, CandidateElection_ID = :CandidateElectionID", 
        ['CandidateID' => $CandidateID, 'SystemUserID' => $SystemUserID, 'CandidateElectionID' => $ElectionID]);
  }
  
  
  function FindPublicProfileFromCandidate($Candidate_ID, $SQLTables = null) {
    return $this->_return_multiple(
      "SELECT " . sqltablestoshow($SQLTables) . " FROM PublicProfile WHERE Candidate_ID = :Candidate",
      ["Candidate" => $Candidate_ID]
    );
  }
    
  function PublicProfileKey($Candidate_ID, $CandidateProfile_ID, $TypeAdd = null) {
    $sql_vars = ["CandidateProfile" => $CandidateProfile_ID, "Candidate" => $Candidate_ID];
    $sql = "PublicProfile SET CandidateProfile_ID = :CandidateProfile, Candidate_ID = :Candidate, CandidateProfile_LastModified = NOW()";

    if ( $TypeAdd == "ADD") {
      $sql = "INSERT INTO " . $sql;    
    } else {
      $sql = "UPDATE " . $sql .  " WHERE Candidate_ID = :Candidate";
      #$sql_vars = array_merge($sql_vars, ["CandidateOrig" => $Candidate_ID]);
    }
  
    return $this->_return_nothing($sql, $sql_vars);
  }
  
  function ListCandidates($CandidateID = null, $Limit = 500, $SQLTables = null) {
    $sql = "SELECT " . sqltablestoshow($SQLTables) . " FROM Candidate " . 
    				"LEFT JOIN PublicProfile ON (Candidate.Candidate_ID = PublicProfile.Candidate_ID) " .
            "LEFT JOIN CandidateProfile ON (PublicProfile.CandidateProfile_ID = CandidateProfile.CandidateProfile_ID) " . 
            "LEFT JOIN CandidateElection ON (Candidate.CandidateElection_ID = CandidateElection.CandidateElection_ID) " .
            "LEFT JOIN Elections ON (Elections.Elections_ID = CandidateElection.Elections_ID) " .
            "LEFT JOIN FillingDoc ON (FillingDoc.Candidate_ID = Candidate.Candidate_ID) ";
            
    if ( ! empty ($CandidateID)) {
      $sql .= "WHERE Candidate.Candidate_ID = :CandidateID";
      return $this->_return_simple($sql, array("CandidateID" => $CandidateID));
    }
            
    $sql .=  "ORDER BY Elections_Date DESC, CandidateElection.CandidateElection_DBTable, CandidateElection.CandidateElection_DBTableValue";    
    $sql .= " LIMIT  $Limit";

    return $this->_return_multiple($sql);
  }

  function ListOnlyElections($CandidateElection = NULL, $SQLTables = null) {
    $sql = "SELECT " . sqltablestoshow($SQLTables) . " FROM CandidateElection";
    
    if ( ! empty($CandidateElection)) {
      $sql .= " WHERE CandidateElection_ID = :CandidateElection";
      return $this->_return_simple($sql, array("CandidateElection" => $CandidateElection));
    }
    
    return $this->_return_multiple($sql);
  }
  
  function ListNominations($SystemUserID, $SQLTables = null) {
    $sql = "SELECT " . sqltablestoshow($SQLTables) . " FROM CanNomination " .
            "LEFT JOIN CandidateElection ON (CandidateElection.CandidateElection_ID = CanNomination.CandidateElection_ID) " .
            "WHERE SystemUser_ID = :SystemUserID";
    $sql_vars = array("SystemUserID" => $SystemUserID);        
    return $this->_return_multiple($sql, $sql_vars);
  }
  
  function InsertNewNomination($CandidateElection, $SystemUser, $FirstName, $LastName, $Email, $Phone) {
    $sql = "INSERT INTO CanNomination SET CandidateElection_ID = :CandidateElection_ID, SystemUser_ID = :SystemUserID, " . 
            "CanNomination_FirstName = :FirstName, CanNomination_LastName = :LastName, CanNomination_Email = :Email, "  .
            "CanNomination_Phone = :Phone";
    $sql_vars = array('CandidateElection_ID' => $CandidateElection, 'SystemUserID' => $SystemUser, 'FirstName' =>  $FirstName, 
                       'LastName'=> $LastName, 'Email'=> $Email, 'Phone'=> $Phone);
    return $this->_return_nothing($sql, $sql_vars);
  }
  
  function ListCandidatePetition($SystemUserID, $SQLTables = null) {
    $sql = "SELECT " . sqltablestoshow($SQLTables) . " FROM CandidatePetitionSet " .
            "LEFT JOIN CandidateGroup ON (CandidateGroup.CandidatePetitionSet_ID = CandidatePetitionSet.CandidatePetitionSet_ID) " .
            "LEFT JOIN Candidate ON (CandidateGroup.Candidate_ID = Candidate.Candidate_ID) " .
            "LEFT JOIN CanWitnessSet ON (CanWitnessSet.Candidate_ID = Candidate.Candidate_ID) " .
            "LEFT JOIN CandidateWitness ON (CanWitnessSet.CandidateWitness_ID = CandidateWitness.CandidateWitness_ID) " .
            "LEFT JOIN CandidateElection ON (CandidateElection.CandidateElection_ID = Candidate.CandidateElection_ID) " .
            "WHERE CandidatePetitionSet.SystemUser_ID = :SystemUserID";
    $sql_vars = array("SystemUserID" => $SystemUserID);        
    return $this->_return_multiple($sql, $sql_vars);
  }

  function GetPetitionsSumary($SystemUser_ID, $SQLTables = null) {
    $sql = "SELECT count(*) as CandidateTotal, count(CandidatePetition_SignedDate) as CandidateSigned " .
            "FROM Candidate LEFT JOIN CandidatePetition ON (Candidate.Candidate_ID = CandidatePetition.Candidate_ID) " .
            "WHERE SystemUser_ID = :SystemUserID";
    $sql_vars = array("SystemUserID" => $SystemUser_ID);
     return $ret = $this->_return_simple($sql, $sql_vars);   
  }

  function ListCandidateNominatedForPetition($SystemUserID, $SQLTables = null) {
    $sql = "SELECT " . sqltablestoshow($SQLTables) . " FROM CanNomination " .
            "LEFT JOIN CandidateElection ON (CandidateElection.CandidateElection_ID = CanNomination.CandidateElection_ID) " .
            "LEFT JOIN Candidate ON (CanNomination.Candidate_ID = Candidate.Candidate_ID) " .
            "LEFT JOIN CanWitnessSet ON (CanWitnessSet.Candidate_ID = Candidate.Candidate_ID) " .
            "LEFT JOIN CandidateWitness ON (CanWitnessSet.CandidateWitness_ID = CandidateWitness.CandidateWitness_ID) " .
            "WHERE CanNomination.SystemUser_ID = :SystemUserID";
    $sql_vars = array("SystemUserID" => $SystemUserID);        
    return $this->_return_multiple($sql, $sql_vars);
  }
  
  function AddIntoOldEmailTable($NewEmail, $OldEmail, $OldStatus, $SystemUserID) {    
    $sql = "INSERT INTO SystemUserOldEmail SET " .
            "SystemUser_ID = :SystemUserID, SystemUserOldEmail_OldEmail = :OldEmail, " .
            "SystemUserOldEmail_OldStatus = :OldStatus, SystemUserOldEmail_NewEmail = :NewEmail, " .
            "SystemUserOldEmail_Timestamp = NOW()";
    $sql_vars = array("SystemUserID" => $SystemUserID, "OldEmail" => $OldEmail,
                      "OldStatus" => $OldStatus, "NewEmail" => $NewEmail);
    $this->_return_nothing($sql, $sql_vars);
  }
  
  function InsertCandidatePetitionSet($System_ID = NULL) {
    
    $sql = "INSERT INTO CandidatePetitionSet SET CandidatePetitionSet_TimeStamp = NOW()";
    $sql_vars = array('CanSetID' => $CandidatePetitionSet_ID);
    
    if ( ! empty ($System_ID)) {
      $sql .= ", SystemUser_ID = :SystemID";
      $sql_vars["SystemID"] =  $System_ID;
    }
    $this->_return_nothing($sql, $sql_vars);
    
    $sql = "SELECT LAST_INSERT_ID() as CandidatePetitionSet_ID";
    return $this->_return_simple($sql);
  }
  
  function ReturnVoterIndex($SingleIndex, $SQLTables = null) {
        $sql = "SELECT " . sqltablestoshow($SQLTables) . " FROM VotersIndexes " .
            "LEFT JOIN DataFirstName ON (DataFirstName.DataFirstName_ID = VotersIndexes.DataFirstName_ID ) " . 
            "LEFT JOIN DataLastName ON (DataLastName.DataLastName_ID = VotersIndexes.DataLastName_ID ) " .
            "LEFT JOIN DataMiddleName ON (DataMiddleName.DataMiddleName_ID = VotersIndexes.DataMiddleName_ID ) " .
            "LEFT JOIN Voters ON (Voters.VotersIndexes_ID = VotersIndexes.VotersIndexes_ID) " . 
            "LEFT JOIN DataHouse ON (Voters.DataHouse_ID = DataHouse.DataHouse_ID) " . 
            "LEFT JOIN DataAddress ON (DataHouse.DataAddress_ID = DataAddress.DataAddress_ID) " .
            "LEFT JOIN DataCity ON (DataAddress.DataCity_ID = DataCity.DataCity_ID) " .
            "LEFT JOIN DataStreet ON (DataAddress.DataStreet_ID = DataStreet.DataStreet_ID) " .              
            "LEFT JOIN DataDistrictTemporal on (DataHouse.DataHouse_ID = DataDistrictTemporal.DataHouse_ID) " .
            "LEFT JOIN DataDistrict ON (DataDistrictTemporal.DataDistrict_ID = DataDistrict.DataDistrict_ID) " .    
            "LEFT JOIN DataCounty ON (DataDistrict.DataCounty_ID = DataCounty.DataCounty_ID) " .  
            "LEFT JOIN DataState ON (DataCounty.DataState_ID = DataState.DataState_ID) " .
            "WHERE VotersIndexes.VotersIndexes_ID = :SingleIndex AND Voters_Status = 'Active'";
            
    $sql_vars = array("SingleIndex" => $SingleIndex);    
    return $this->_return_simple($sql, $sql_vars);    
  }
  
  function GetPetitionsForCandidate($CandidateID = 0, $SystemUserID = 0, $SQLTables = [
  					"Candidate.Candidate_ID", "Candidate.SystemUser_ID", "Candidate.CandidateElection_ID", 
  					"Candidate.Candidate_Party", "Candidate.Candidate_DisplayMap", "Candidate.Candidate_DispName", 
  					"Candidate.Candidate_DispResidence", "Candidate.CandidateAptment_ID", 
  					"Candidate.Candidate_StatementPicFileName", "Candidate.Candidate_StatementWebsite", 
  					"Candidate.Candidate_StatementEmail", "Candidate.Candidate_StatementTwitter", 
  					"Candidate.Candidate_StatementPhoneNumber", "Candidate.Candidate_StatementText", 
            "Candidate.CandidateElection_DBTable", "Candidate.CandidateElection_DBTableValue", 
            "Candidate.Candidate_StatsVoters", "Candidate.Candidate_Status", "Candidate.Candidate_NominatedBy", 
            "CandidatePetition.CandidatePetition_ID", "CandidatePetition.Candidate_ID", 
            "CandidatePetition.FollowUp_ID", "CandidatePetition.CandidatePetition_Order", 
            "CandidatePetition.VotersIndexes_ID", "CandidatePetition.CandidatePetition_VoterFullName",
            "CandidatePetition.CandidatePetition_VoterResidenceLine1", 
            "CandidatePetition.CandidatePetition_VoterResidenceLine2", 
            "CandidatePetition.CandidatePetition_VoterResidenceLine3", 
            "CandidatePetition.CandidatePetition_VoterCounty", "CandidatePetition.DataStreet_ID",
            "CandidatePetition.Voters_ResHouseNumber", "CandidatePetition.Voters_ResFracAddress",
            "CandidatePetition.Voters_ResPreStreet", "CandidatePetition.Voters_ResStreetName", 
            "CandidatePetition.Voters_ResPostStDir", "CandidatePetition.Voters_ResApartment", 
            "CandidatePetition.Voters_Status", "CandidatePetition.CandidatePetition_SignedDate" 
  				]) {

    if ( $CandidateID == 0 && $SystemUserID == 0) return 0;
    
    $sql = "SELECT " . sqltablestoshow($SQLTables) . "FROM Candidate " .
            "LEFT JOIN CandidatePetition ON (CandidatePetition.Candidate_ID = Candidate.Candidate_ID) " .
            "WHERE " ;
            
    if ( $CandidateID > 0 ) {
      $sql .= "Candidate_ID = :CandidateID";
      $sql_vars["CandidateID"] = $CandidateID;
      if ( $SystemUserID > 0 ) { $sql .= " AND "; }
    }
    
    if ( $SystemUserID > 0 ) {
      $sql .= "SystemUser_ID = :SystemUserID";
      $sql_vars["SystemUserID"] = $SystemUserID;
    }
      
    $sql .= "  ORDER BY CandidatePetition_Order";
    
    return $this->_return_multiple($sql, $sql_vars);
  }
  
  function GetPetitionSignNames($SystemID, $DateID, $SQLTables = null) {
    $sql = "SELECT " . sqltablestoshow($SQLTables) . " FROM Candidate LEFT JOIN CandidatePetition " .
            "ON (Candidate.Candidate_ID = CandidatePetition.Candidate_ID) " .
            "WHERE SystemUser_ID = :SystemUserID AND " . 
            "CandidatePetition.Raw_Voter_Dates_ID = :DateID";
    $sql_vars = array(":SystemUserID" => $SystemID, ":DateID" => $DateID);
    return $this->_return_multiple($sql, $sql_vars);
  }

  function SearchRawVoterInfo($UniqNYSVoterID, $SQLTables = null) {
    return $this->_return_multiple(
      "SELECT " . sqltablestoshow($SQLTables) . " FROM Voters " .  
      "LEFT JOIN DataHouse ON (Voters.DataHouse_ID = DataHouse.DataHouse_ID) " . 
      "LEFT JOIN DataAddress ON (DataHouse.DataAddress_ID = DataAddress.DataAddress_ID) " . 
      "LEFT JOIN DataCounty ON (DataCounty.DataCounty_BOEID = DataAddress.DataCounty_ID) " .                    
      "WHERE Voters_UniqStateVoterID = :Uniq AND Voters_Status = 'active'", 
      ["Uniq" => $UniqNYSVoterID]
    );
  }
  
  function GetAdminStats($SQLTables = null) {
    $sql = "SELECT " . sqltablestoshow($SQLTables) . " FROM SystemStats";
    return $this->_return_multiple($sql);    
  }

  function UpdateSystemUserWithVoterCard($SystemUser_ID, $RawVoterID, $UniqNYSVoterID, $ADED, $StateAbbrev,  $Party, $VoterCount = 0) {
    $sql = "UPDATE SystemUser SET Voters_UniqStateVoterID = :NYSVoterID, SystemUser_EDAD = :EDAD, SystemUser_Party = :Party, " . 
            "Voters_ID = :Index, SystemUser_StateAbbrev = :Abbrev ";
    $sql_vars = array("NYSVoterID" => $UniqNYSVoterID,"EDAD" => $ADED, "ID" => $SystemUser_ID, "Party" => $Party, 
                      "Index" => $RawVoterID, "Abbrev" => $StateAbbrev);

    if ($VoterCount > 0) {
      $sql .= ", SystemUser_NumVoters = :CountVoters ";
      $sql_vars["CountVoters"] = $VoterCount;
    }
    
    $sql .= "WHERE SystemUser_ID = :ID ";
    return $this->_return_nothing($sql, $sql_vars);        
  }

  function OtherCandidateCoupled($Party, $SQLTables = null) {
    $sql = "SELECT " . sqltablestoshow($SQLTables) . " FROM Candidate WHERE CandidateElection_DBTable != :DBTable AND CandidateElection_DBTable != :DBTable2 " . 
            "AND CandidateElection_DBTable IS NOT NULL AND Candidate_Party = :Party";
    $sql_vars = array("DBTable" => "EDAD", "DBTable2" => "BROKEN", "Party" => $Party);
    return $this->_return_multiple($sql, $sql_vars);
  }
  
  // Function use 8.1 format - Don't change var names
  function UpdateCandidate($Candidate_ID, $SystemUser_ID = null, $Team_ID = null, $PetitionNameset = null, 
  													$UniqStateVoterID = null, $DataCounty_ID = null, $Voters_ID = null, 
  													$CandidateElection_ID = null, $Party = null, $FullPartyName = null, 
  													$CandidatePartySymbol_ID = null, $DisplayMap = null, $DispName = null, 
  													$DispResidence = null, $DBTable = null, $DBTableValue = null, $DataDistrictTown_ID = null, 
  													$StatsVoters = null, $Status = null, $Watermark = null, $LocalHash = null, 
  													$NominatedBy = null) {
  														
  	if ( $Candidate_ID > 0) {
			
			$fields = [];

			$params = [ "CandidateID" => $Candidate_ID  ];

			$updates = [
				"SystemUser_ID" => $SystemUser_ID,
				"Team_ID" => $Team_ID,
				"Candidate_PetitionNameset" => $PetitionNameset,
				"Candidate_UniqStateVoterID" => $UniqStateVoterID,
				"DataCounty_ID" => $DataCounty_ID,
				"Voters_ID" => $Voters_ID,
				"CandidateElection_ID" => $CandidateElection_ID,
				"Candidate_Party" => $Party,
				"Candidate_FullPartyName" => $FullPartyName,
				"CandidatePartySymbol_ID" => $CandidatePartySymbol_ID,
				"Candidate_DisplayMap" => $DisplayMap,
				"Candidate_DispName" => $DispName,
				"Candidate_DispResidence" => $DispResidence,
				"CandidateElection_DBTable" => $DBTable,
				"CandidateElection_DBTableValue" => $DBTableValue,
				"DataDistrictTown_ID" => $DataDistrictTown_ID,
				"Candidate_StatsVoters" => $StatsVoters,
				"Candidate_Status" => $Status,
				"Candidate_Watermark" => $Watermark,
				"Candidate_LocalHash" => $LocalHash,
				"Candidate_NominatedBy" => $NominatedBy
			];

			foreach ($updates as $column => $value) {
				if ($value !== null) {
				  $param = str_replace(["Candidate_", "CandidateElection_"], "", $column);
				  $fields[] = "$column = :$param";
				  $params[$param] = $value;
				}
			}

			$fields[] = "Candidate_LastModified = NOW()";
			return $this->_return_nothing(
				"UPDATE Candidate SET " . implode(", ", $fields) . " WHERE Candidate_ID = :CandidateID", 
				$params
			);
  	}											
	}
  
  function UpdateCandidateCounterSystemID($Candidate_ID, $SysID) {
    return $this->_return_nothing(
      "UPDATE Candidate SET SystemUser_ID = :SysID WHERE Candidate_ID = :CandidateID", 
      ["SysID" => $SysID, "CandidateID" => $Candidate_ID]
     );
  }
    
  function UpdateCandidateCounterForVoter($Candidate_ID, $Counter) {
    return $this->_return_nothing(
      "UPDATE Candidate SET Candidate_StatsVoters = :Counter WHERE Candidate_ID = :CandidateID", 
      ["Counter" => $Counter, "CandidateID" => $Candidate_ID]
     );
  }
  
  function UpdateElectionCounterForVoter($Election_ID, $Counter) {
    return $this->_return_nothing(
      "UPDATE CandidateElection SET CandidateElection_CountVoter = :Counter WHERE CandidateElection_ID = :CandidateElection_ID", 
      ["Counter" => $Counter, "CandidateElection_ID" => $Election_ID]
    );
  }    
  
  // This will need to be changed later.
  function GetVotersIndexesIDfromNYSCode($NYSCode, $SQLTables = null) {
    return $this->_return_simple(
      "SELECT " . sqltablestoshow($SQLTables) . " FROM VotersIndexes WHERE VotersIndexes_UniqNYSVoterID = :NYSCode ORDER BY VotersIndexes_ID LIMIT 1", 
      ["NYSCode" => $NYSCode]
    );
  }
  
  function GetCountyFromState($StateID, $SQLTables = null) {
    return $this->_return_multiple(
      "SELECT " . sqltablestoshow($SQLTables) . " FROM DataCounty WHERE DataState_ID = :DataState_ID ORDER BY DataCounty_Name", 
      ["DataState_ID" => $StateID]
    );
  }
  
  function GetCountyFromNYSCodes($CountyCode, $SQLTables = null) {
    return $this->_return_simple(
      "SELECT " . sqltablestoshow($SQLTables) . " FROM DataCounty WHERE DataCounty_ID = :CountyCode", 
      ["CountyCode" => $CountyCode]);
  }
  
  function DB_WorkCounty($CountyID) {
    $County = $this->GetCountyFromNYSCodes($CountyID);
    return $County["DataCounty_Name"];  
  }

  /* This is for the search of the $VI in the other file */
  function SearchVotersIndexesDB($ArrIndexes, $SQLTables = null) {

    if ( empty ($ArrIndexes)) return 0;
    $sql_index = "";

    foreach ($ArrIndexes as $var) {
      if ( ! empty ($var)) {
        if ( ! empty ($sql_index)) { $sql_index .= " OR "; }
        $sql_index .= "VotersIndexes.VotersIndexes_ID = '" . $var . "'";
      }
    }
  
    $sql = "SELECT " . sqltablestoshow($SQLTables) . " FROM VotersIndexes " .
            "LEFT JOIN DataFirstName ON (DataFirstName.DataFirstName_ID = VotersIndexes.DataFirstName_ID ) " . 
            "LEFT JOIN DataLastName ON (DataLastName.DataLastName_ID = VotersIndexes.DataLastName_ID ) " .
            #"LEFT JOIN Raw_Voter ON (Raw_Voter.Raw_Voter_UniqNYSVoterID = VotersIndexes.VotersIndexes_UniqNYSVoterID) " . 
            #"LEFT JOIN " . $TableVoter . " ON (" . ".Raw_Voter_UniqNYSVoterID = VotersIndexes.VotersIndexes_UniqNYSVoterID) " .    
            "WHERE " . $sql_index;
    
    return $this->_return_multiple($sql);    
  }
  
  Function GetWalkSheetInfo ($DataDistrictID, $SQLTables = null) {
    if ( $DataDistrictID > 0 ) {
      $sql = "SELECT " . sqltablestoshow($SQLTables) . " FROM DataDistrict " .
            "LEFT JOIN DataDistrictTemporal ON " . 
            "(DataDistrictTemporal.DataDistrict_ID = DataDistrict.DataDistrict_ID) " .
            "LEFT JOIN DataDistrictCycle ON " .
            "(DataDistrictCycle.DataDistrictCycle_ID = DataDistrictTemporal.DataDistrictCycle_ID) " . 
            "WHERE DataDistrict.DataDistrict_ID = :District";
      $sql_vars = array("District" => $DataDistrictID);
      return $this->_return_multiple($sql, $sql_vars);          
    }    
  }
  
  
  function ListEDByDistricts($DistrictType, $DistrictValue, $DistrictCycle = '8', $SQLTables = null) {
    $sql = "SELECT DISTINCT DataDistrict_Electoral AS ED, DataDistrict_StateAssembly AS AD ";
  
    switch ($DistrictType) {
      case "AD":
        $sql .= ", DataDistrict_StateAssembly AS District ";
        $sql_vars = array("CycleID" => $DistrictCycle, "AD" => $DistrictValue);
        $sql_query = "AND DataDistrict_StateAssembly = :AD ";
        break;
      
      case "CG":
        $sql .= ", DataDistrict_Congress AS District ";
        $sql_vars = array("CycleID" => $DistrictCycle, "CG" => $DistrictValue);
        $sql_query = "AND DataDistrict_Congress = :CG ";
        break;
        
      case "SN":
        $sql .= ", DataDistrict_SenateSenate AS District ";
        $sql_vars = array("CycleID" => $DistrictCycle, "SN" => $DistrictValue);
        $sql_query = "AND DataDistrict_SenateSenate = :SN ";
        break;
    }
    
    $sql .= "FROM DataDistrict " . 
            "LEFT JOIN DataDistrictTemporal ON " . 
            "(DataDistrictTemporal.DataDistrict_ID = DataDistrict.DataDistrict_ID) " .
            "LEFT JOIN DataDistrictCycle ON " .
            "(DataDistrictCycle.DataDistrictCycle_ID = DataDistrictTemporal.DataDistrictCycle_ID) ";
    
    $sql .= "WHERE DataDistrictCycle.DataDistrictCycle_ID = :CycleID ";
    $sql .= $sql_query;    
    $sql .= "ORDER BY DataDistrict_StateAssembly, DataDistrict_Electoral";
  
    return $this->_return_multiple($sql, $sql_vars);
  }
    
  function SearchUserVoterCard($SystemUserID, $SQLTables = null) {
    $sql = "SELECT " . sqltablestoshow($SQLTables) . " FROM SystemUser " .
            "LEFT JOIN Voters ON (Voters.Voters_ID = SystemUser.Voters_ID) " . 
            "LEFT JOIN VotersIndexes ON (VotersIndexes.VotersIndexes_ID = Voters.VotersIndexes_ID) " .
            "LEFT JOIN DataLastName ON (DataLastName.DataLastName_ID = VotersIndexes.DataLastName_ID) " .  
            "LEFT JOIN DataFirstName ON (DataFirstName.DataFirstName_ID = VotersIndexes.DataFirstName_ID) " .  
            "LEFT JOIN DataMiddleName ON (DataMiddleName.DataMiddleName_ID = VotersIndexes.DataMiddleName_ID) " .
            "LEFT JOIN DataHouse ON (Voters.DataHouse_ID = DataHouse.DataHouse_ID) " .
            "LEFT JOIN DataAddress ON (DataAddress.DataAddress_ID = DataHouse.DataAddress_ID) " .
            "LEFT JOIN DataStreet ON (DataAddress.DataStreet_ID = DataStreet.DataStreet_ID) " .
            "LEFT JOIN DataCity ON (DataCity.DataCity_ID = DataAddress.DataCity_ID) " .
            "LEFT JOIN DataDistrictTemporal on (DataHouse.DataHouse_ID = DataDistrictTemporal.DataHouse_ID) " .
            "LEFT JOIN DataDistrictCycle on (DataDistrictTemporal.DataDistrictCycle_ID = DataDistrictCycle.DataDistrictCycle_ID) " .
            "LEFT JOIN DataDistrict ON (DataDistrictTemporal.DataDistrict_ID = DataDistrict.DataDistrict_ID) " .    
            "LEFT JOIN DataCounty ON (DataDistrict.DataCounty_ID = DataCounty.DataCounty_ID) " .
            "LEFT JOIN DataState ON (DataState.DataState_ID = DataCounty.DataState_ID) " .
            "LEFT JOIN DataDistrictTown ON (DataDistrictTown.DataDistrictTown_ID = DataDistrict.DataDistrictTown_ID) " . 
            "LEFT JOIN SystemUserSelfDistrict ON (SystemUser.SystemUser_ID = SystemUserSelfDistrict.SystemUser_ID) " . 
            "WHERE SystemUser.SystemUser_ID = :SystemID AND " .
            "(CURDATE() >= DataDistrictCycle_CycleStartDate AND CURDATE() <= DataDistrictCycle_CycleEndDate) IS NULL";
    $sql_vars = array("SystemID" => $SystemUserID);    
    return $this->_return_simple($sql, $sql_vars);
  }
  
  function UpdateSystemSetPriv($SystemUserID, $PrivModification) {
    if ( $SystemUserID > 0 ) {
      $sql = "UPDATE SystemUser SET SystemUser_Priv = :AddPriv WHERE SystemUser_ID = :SystemID";
      $sql_vars = array("SystemID" => $SystemUserID, "AddPriv" => $PrivModification);
      return $this->_return_nothing($sql, $sql_vars);
    }
  }
  
  function UpdateSystemPriv($SystemUserID, $PrivModification) {
    if ( $SystemUserID > 0 ) {
      $sql = "UPDATE SystemUser SET SystemUser_Priv = SystemUser_Priv";
      
      if ($PrivModification >= 0) {
        $sql .= " | ";
      } else {
        $sql .= " & ~";
      }
             
      $sql .= ":AddPriv WHERE SystemUser_ID = :SystemID";
      $sql_vars = array("SystemID" => $SystemUserID, "AddPriv" => $PrivModification);
      return $this->_return_nothing($sql, $sql_vars);
    }
  }
  
  function CreateSystemUserAndUpdateProfile($TempEmail, $ProfileArray = "", $Person = "") {
    
    $sql = "INSERT INTO SystemUser (SystemUser_email, SystemUser_emailverified, SystemUser_username, SystemUser_password, " . 
                                    "SystemUser_emaillinkid, SystemUser_createtime, SystemUser_lastlogintime, SystemUser_Priv"; 
    $sql_vars = array("TempEmail" => $TempEmail);
                                    
    if ( ! empty ($ProfileArray["Change"]["SystemUser_FirstName"])) { $sql .= ", SystemUser_FirstName"; $sql_vars["FirstName"] = $ProfileArray["Change"]["SystemUser_FirstName"]; }
    if ( ! empty ($ProfileArray["Change"]["SystemUser_LastName"])) { $sql .= ", SystemUser_LastName"; $sql_vars["LastName"] = $ProfileArray["Change"]["SystemUser_LastName"]; }
                                    
    $sql .= ") " .
           "SELECT SystemUserTemporary_email, SystemUserTemporary_emailverified, SystemUserTemporary_username, " . 
                  "SystemUserTemporary_password, SystemUserTemporary_emaillinkid, NOW(), NOW(), " . (PERM_MENU_PROFILE + PERM_MENU_SUMMARY /*+ PERM_MENU_DOCU */);
                  
    if ( ! empty ($ProfileArray["Change"]["SystemUser_FirstName"])) { $sql .= ", :FirstName"; }
    if ( ! empty ($ProfileArray["Change"]["SystemUser_LastName"])) { $sql .= ", :LastName"; }
                  
    $sql .= " FROM SystemUserTemporary WHERE SystemUserTemporary_email = :TempEmail"; 
    $this->_return_nothing($sql, $sql_vars);    
  
    $sql = "SELECT LAST_INSERT_ID() as SystemUser_ID";
    $ret = $this->_return_simple($sql);

    $sql = "UPDATE SystemUserTemporary SET SystemUser_ID = :SystemUserID,  SystemUserTemporary_password = null, SystemUserTemporary_emaillinkid = null WHERE SystemUserTemporary_email = :TempEmail"; 
    $sql_vars = array("TempEmail" => $TempEmail, "SystemUserID" => $ret["SystemUser_ID"]);
    $this->_return_nothing($sql, $sql_vars);  
    
    $this->SaveInscriptionRecord ($TempEmail, $Username, "convert", $ret["SystemUser_ID"]);  
    return $this->FindPersonUserProfile($ret["SystemUser_ID"]);
    
  }
  
  function SaveInscriptionRecord ($Email, $Username, $Type = "Other", $SystemUserID = NULL) {
    $sql = "INSERT INTO SystemUserVoter SET SystemUserVoter_Username = :Username, " .
            "SystemUserVoter_Email = :Email, SystemUserVoter_action = :Type, " . 
            "SystemUserVoter_Date = NOW(), SystemUserVoter_IP = :IP, SystemUser_ID = :SystemUserID";
    $sql_vars = array('Email' => $Email, 'Username' => $Username, 'Type' => $Type, 'IP' => $_SERVER['REMOTE_ADDR'], 'SystemUserID' => $SystemUserID);
    return $this->_return_nothing($sql,  $sql_vars);
  }
  
  
  function SearchUsers($UserID = NULL, $SQLTables = null) {
    $sql = "SELECT " . sqltablestoshow($SQLTables) . " FROM SystemUser";
    
    if ( ! empty ($UserID)) {
      $sql .= " WHERE SystemUser_ID = :UserID";
      $sql_vars = array ("UserID" => $UserID);
      return $this->_return_simple($sql, $sql_vars);
    }
    
    return $this->_return_multiple($sql);
  }  
  
  function SearchTempUsers($UserID = NULL, $SQLTables = null) {
    $sql = "SELECT " . sqltablestoshow($SQLTables) . " FROM SystemUserTemporary";
    
    if ( ! empty ($UserID)) {
      $sql .= " WHERE SystemUserTemporary_ID = :UserID";
      $sql_vars = array ("UserID" => $UserID);
      return $this->_return_simple($sql, $sql_vars);
    }
    
    return $this->_return_multiple($sql);
  }  
  
  function UpdateTempDistrict($Type, $SystemUser_ID, $AD, $ED, $CG, $SN, $SystemID = NULL, $SQLTables = null) {
    
    switch($Type) {
      case "insert":
        $sql = "INSERT INTO SystemUserSelfDistrict SET ";
        break;
        
      case "update":
        $sql = "UPDATE SystemUserSelfDistrict SET ";
        $sql_end = " WHERE SystemUserSelfDistrict_ID = :SysDisID";
        $sql_vars = array("SysDisID" => $SystemID);
        break;
    }
  
    // There will be a bug to fix which is how to delete an entry. - Need to think about it.
    if (empty ($sql)) return $this->FindTemporaryDistrict($SystemUserID);      
    if (! empty ($AD)) { $sql .= "SystemUserSelfDistrict_AD = :AD"; $sql_vars["AD"] = intval($AD); $comma = 1;}
    if ($comma == 1) { $sql .= ", "; $comma = 0; }
    if (! empty ($ED)) { $sql .= "SystemUserSelfDistrict_ED = :ED"; $sql_vars["ED"] = intval($ED); $comma = 1;}
    if ($comma == 1) { $sql .= ", "; $comma = 0; }
    if (! empty ($CG)) { $sql .= "SystemUserSelfDistrict_CG = :CG"; $sql_vars["CG"] = intval($CG); $comma = 1;}
    if ($comma == 1) { $sql .= ", "; $comma = 0; }
    if (! empty ($SN)) { $sql .= "SystemUserSelfDistrict_SN = :SN"; $sql_vars["SN"] = intval($SN); $comma = 1;}
    if ($comma == 1) { $sql .= ", "; $comma = 0; }    
    if (! empty ($SystemUser_ID)) { $sql .= "SystemUser_ID = :SystemUser_ID"; $sql_vars["SystemUser_ID"] = $SystemUser_ID;}

    $sql .= $sql_end;
    return $this->_return_nothing($sql, $sql_vars);
  }
  
  function FindTemporaryDistrict($SystemUserID, $SQLTables = null) {
    $sql = "SELECT " . sqltablestoshow($SQLTables) . " FROM SystemUserSelfDistrict WHERE SystemUser_ID = :SystemUserID";
    $sql_vars = array("SystemUserID" => $SystemUserID);
    return $this->_return_simple($sql, $sql_vars);
  }
  
  function ReturnPrivCodes ($SQLTables = null) {
    $sql = "SELECT " . sqltablestoshow($SQLTables) . " FROM AdminCode";
    return $this->_return_multiple($sql);
  }  
  
  /* Custom SQL Statement to minimize the number of question based on logic. */
  // The input is an array with array of stuff that changed + Person is the stuff coming
  // from FindPersonUserProfile. If populate I won't have to call it again. 
  // If there is a field called Change, then we change those field in SystemUser
  
  function UpdatePersonUserProfile($SystemUserID, $ProfArray = "", $Person = "", $SQLTables = null) {
    
    // This is for the normal information.
    if ( ! empty ($ProfArray["Change"])) {
      $add_coma = 0;
      $sql_vars = array("SystemUser" => $SystemUserID);

      $sql = "UPDATE SystemUser SET ";
      if ( ! empty ($ProfArray["Change"]["SystemUser_FirstName"] )) {
        $sql .= "SystemUser_FirstName = :FirstName";
        $sql_vars["FirstName"] = $ProfArray["Change"]["SystemUser_FirstName"];
        $add_coma = 1;
        $Person["SystemUser_FirstName"] = $ProfArray["Change"]["SystemUser_FirstName"];
      }

      if ( ! empty ($ProfArray["Change"]["SystemUser_LastName"] )) {
        if ( $add_coma == 1 ) { $sql .= ", "; }
        $sql .= "SystemUser_LastName = :LastName";
        $sql_vars["LastName"] = $ProfArray["Change"]["SystemUser_LastName"];
        $add_coma = 1;
        $Person["SystemUser_LastName"] = $ProfArray["Change"]["SystemUser_LastName"];
      }
      
      $sql .= " WHERE SystemUser_ID = :SystemUser";
      
      $this->_return_nothing($sql, $sql_vars);
    }
    
    // This is the rest of the BIO, we'll need to create a for loop.
    // This also make the assumption that 
    
    if ( empty ($Person["SystemUserProfile_ID"])) {
      $sql = "INSERT INTO SystemUserProfile SET ";
    } else {
      $sql = "UPDATE SystemUserProfile SET ";
    }
    
    $add_coma = 0;
    $sql_vars = array();
    if ( ! empty ($ProfArray["bio"])) {
      $sql .= "SystemUserProfile_bio = :bio ";
      $sql_vars["bio"] = $ProfArray["bio"];
      $add_coma = 1;
      $Person["SystemUserProfile_bio"] = $ProfArray["bio"];
    }
    
    if ( ! empty ($ProfArray["URL"])) {
      if ( $add_coma == 1 ) { $sql .= ", "; }
      $sql .= "SystemUserProfile_URL = :URL ";
      $sql_vars["URL"] = $ProfArray["URL"];
      $add_coma = 1;
      $Person["SystemUserProfile_URL"] = $ProfArray["URL"];
    }
    
    if ( ! empty ($ProfArray["Location"])) {
      if ( $add_coma == 1 ) { $sql .= ", "; }
      $sql .= "SystemUserProfile_Location = :Location ";
      $sql_vars["Location"] = $ProfArray["Location"];
      $add_coma = 1;
      $Person["SystemUserProfile_Location"] = $ProfArray["Location"];
    }
  
    if ( $add_coma == 1) {
  
      if ( ! empty ($Person["SystemUserProfile_ID"])) {  
        $sql .= "WHERE SystemUserProfile_ID = :SystemProfileID";
        
        $sql_vars["SystemProfileID"] = $Person["SystemUserProfile_ID"];
        $this->_return_nothing($sql, $sql_vars);
        
      } else {
        
        $this->_return_nothing($sql, $sql_vars);
        $sql = "SELECT LAST_INSERT_ID() as SystemUserProfile_ID";
        $ret = $this->_return_simple($sql);
      }
    }  

    // Check that email is not double.
    if ( ! empty ($ProfArray["Special"]["SystemUser_email"])) {
      $ret_email = $this->CheckRegisterEmail ($ProfArray["Special"]["SystemUser_email"]);
      if ( empty ($ret_email)) {
        $Person["ChangeEmail"] = 1;
        $ChangeEmailOK = 1;
      } else {
        $Person["ChangeEmail"] = -1;
        $Person["EmailToChangeTo"] = $ProfArray["Special"]["SystemUser_email"];
        $ChangeEmailOK = 0;
      }
    }      

    if ( $ChangeEmailOK == 1 || empty ($Person["SystemUserProfile_ID"])) {            
      $add_coma = 0;    
      // This is to deal with the complicate stuff.
      $sql = "UPDATE SystemUser SET ";
      $sql_vars = array("SystemID" => $SystemUserID);
    
      if ( empty ($Person["SystemUserProfile_ID"])) {
        // Update the profile
        $sql .= "SystemUserProfile_ID = :SystemUserProfileID ";
        $sql_vars["SystemUserProfileID"] = $ret["SystemUserProfile_ID"];  
        $add_coma = 1;
      }
      
      if ( $ChangeEmailOK == 1 ) {
        if ( $add_coma == 1 ) { $sql .= ", "; }
        $sql .= "SystemUser_email = :SystemEmail, SystemUser_emailverified = 'no', " .
                "SystemUser_emaillinkid = :EmailLinkID ";
        
        $sql_vars["EmailLinkID"] = $ProfArray["Special"]["SystemUser_emaillinkid"];
        $sql_vars["SystemEmail"] = $ProfArray["Special"]["SystemUser_email"];  
        $add_coma = 1;
      }      

      $sql .= "WHERE SystemUser_ID = :SystemID";  
      $this->_return_nothing($sql, $sql_vars);
          
      if ($ChangeEmailOK == 1) {
        $this->AddIntoOldEmailTable($ProfArray["Special"]["SystemUser_email"], $Person["SystemUser_email"], 
                                    $Person["SystemUser_emailverified"], $SystemUserID);        
        $Person["SystemUser_email"] = $ProfArray["Special"]["SystemUser_email"];
        $Person["SystemUser_emailverified"] = 'no';
        $Person["SystemUser_emaillinkid"] = $ProfArray["Special"]["SystemUser_emaillinkid"];
      }
    }
    
    if ( empty ($Person["SystemUserProfile_ID"])) {
      $Person["SystemUserProfile_ID"] = $ret["SystemUserProfile_ID"];
    }
    
    return $Person;
  }
  
  function ListBuildingsByADED($AD, $ED, $SQLTables = null) {
    $sql = "SELECT DISTINCT DataAddress_HouseNumber, DataAddress_FracAddress, DataAddress_PreStreet, " . 
            "DataStreet_Name, DataAddress_PostStreet, DataAddress_zipcode ";
    // $sql = "SELECT * ";

    $sql .= "FROM DataDistrict " .
            "LEFT JOIN DataDistrictTemporal ON (DataDistrictTemporal.DataDistrict_ID = DataDistrict.DataDistrict_ID) " . 
            "LEFT JOIN DataDistrictCycle ON (DataDistrictCycle.DataDistrictCycle_ID = DataDistrictTemporal.DataDistrictCycle_ID) " . 
            "LEFT JOIN DataHouse ON (DataDistrictTemporal.DataHouse_ID = DataHouse.DataHouse_ID) " . 
            "LEFT JOIN DataAddress ON (DataHouse.DataAddress_ID = DataAddress.DataAddress_ID) " . 
            "LEFT JOIN DataStreet ON (DataStreet.DataStreet_ID = DataAddress.DataStreet_ID) "; 
    $sql .= "WHERE DataDistrict.DataDistrict_StateAssembly = :AD AND " . 
            "DataDistrict.DataDistrict_Electoral = :ED ORDER BY DataAddress_zipcode, DataStreet_Name, DataAddress_HouseNumber";      
                          
    $sql_vars = array("AD" => $AD, "ED" => $ED);  
    return $this->_return_multiple($sql, $sql_vars);
  }
    
    
    
    
  function SearchVoterAtAddress($DataHouseArray, $SQLTables = null) {
    
    // echo "I must remove this function";
    // create a silent debug function that notify if the funtion is used for later
    // removal
  
    if (! empty ($DataHouseArray["BOECountyID"]) || ! empty ($DataHouseArray["BOEStateID"])) {  
       $sql = "SELECT " . sqltablestoshow($SQLTables) . " FROM Voters " . 
            "LEFT JOIN VotersIndexes ON (VotersIndexes.VotersIndexes_ID = Voters.VotersIndexes_ID) " . 
            "LEFT JOIN DataHouse ON (Voters.DataHouse_ID = DataHouse.DataHouse_ID) " . 
            "LEFT JOIN DataAddress ON (DataAddress.DataAddress_ID = DataHouse.DataAddress_ID) " . 
            "LEFT JOIN DataStreet ON (DataStreet.DataStreet_ID = DataAddress.DataStreet_ID) " . 
            "LEFT JOIN DataLastName ON (DataLastName.DataLastName_ID = VotersIndexes.DataLastName_ID) " . 
            "LEFT JOIN DataFirstName ON (DataFirstName.DataFirstName_ID = VotersIndexes.DataFirstName_ID) " . 
            "LEFT JOIN DataMiddleName ON (DataMiddleName.DataMiddleName_ID = VotersIndexes.DataMiddleName_ID) ";
    } else {          
      $sql = "SELECT " . sqltablestoshow($SQLTables) . " FROM DataAddress " . 
            "LEFT JOIN DataStreet ON (DataStreet.DataStreet_ID = DataAddress.DataStreet_ID) " . 
            "LEFT JOIN DataHouse ON (DataAddress.DataAddress_ID = DataHouse.DataAddress_ID) " . 
            "LEFT JOIN Voters ON (DataHouse.DataHouse_ID = Voters.DataHouse_ID) " . 
            "LEFT JOIN VotersIndexes ON (VotersIndexes.VotersIndexes_ID = Voters.VotersIndexes_ID) " . 
            "LEFT JOIN DataLastName ON (DataLastName.DataLastName_ID = VotersIndexes.DataLastName_ID) " . 
            "LEFT JOIN DataFirstName ON (DataFirstName.DataFirstName_ID = VotersIndexes.DataFirstName_ID) " . 
            "LEFT JOIN DataMiddleName ON (DataMiddleName.DataMiddleName_ID = VotersIndexes.DataMiddleName_ID) "; 
    }          

    $sql .= "WHERE ";
      
    if (! empty ($DataHouseArray["BOECountyID"]) || ! empty ($DataHouseArray["BOEStateID"])) {            
      if (! empty ($DataHouseArray["BOECountyID"])) {
        $sql .= "Voters_CountyVoterNumber = :BOECountyID";
        $sql_vars["BOECountyID"] = $DataHouseArray["BOECountyID"];
      }
    
      if (! empty ($DataHouseArray["BOEStateID"])) {
        $sql .= "VotersIndexes_UniqStateVoterID LIKE :BOEStateID";
        $sql_vars["BOEStateID"] = $DataHouseArray["BOEStateID"];
      }
      
    } else {
      $sql .= "DataCounty_ID = :County";
      $sql_vars = array("County" => $DataHouseArray["County"]);
    }
    
    if (! empty ($DataHouseArray["Zipcode"])) {
      $sql .= " AND DataAddress_zipcode  = :DataZip";
      $sql_vars["DataZip "] = $DataHouseArray["Zipcode"];
    }
            
    if (! empty ($DataHouseArray["FracAddress"])) {
      $sql .= " AND DataAddress_FracAddress = :FracAddress";
      $sql_vars["FracAddress"] = $DataHouseArray["FracAddress"];
    }
    
    if (! empty ($DataHouseArray["PreStreet"])) {
      $sql .= " AND DataAddress_PreStreet = :PreStreet";
      $sql_vars["PreStreet"] = $DataHouseArray["PreStreet"];
    }
    
    if (! empty ($DataHouseArray["PostStreet"])) {
      $sql .= " AND DataAddress_PostStreet = :PostStreet";
      $sql_vars["PostStreet"] = $DataHouseArray["PostStreet"];
    }
    
    if (! empty ($DataHouseArray["HouseNumber"])) {
      $sql .= " AND DataAddress_HouseNumber LIKE :HouseNumber";
      $sql_vars["HouseNumber"] = $DataHouseArray["HouseNumber"] . "%";
    }
    
    if (! empty ($DataHouseArray["Name"])) {
      $sql .= " AND DataStreet_Name LIKE :DataStreet";
      $sql_vars["DataStreet"] = $DataHouseArray["Name"] . "%";
    }
    
    if (! empty ($DataHouseArray["FirstName"])) {
      $CompressedFirstName = preg_replace("/[^a-zA-Z]+/", "%", $DataHouseArray["FirstName"]);
      $sql .= " AND DataFirstName_Compress LIKE :FirstName";
      $sql_vars["FirstName"] = "%" . $CompressedFirstName . "%";
    }
    
    if (! empty ($DataHouseArray["LastName"])) {
      $CompressedLastName = preg_replace("/[^a-zA-Z]+/", "%", $DataHouseArray["LastName"]);
      $sql .= " AND DataLastName_Compress LIKE :LastName";
      $sql_vars["LastName"] = "%" . $CompressedLastName . "%";
    }
    
    return $this->_return_multiple($sql, $sql_vars);
  }
}

?>