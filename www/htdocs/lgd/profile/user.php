<?php
  $Menu = "profile";  
  $BigMenu = "profile";  
  
  require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/common/verif_sec.php";  
  require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/db/db_repmyblock.php";  
  
  if (empty ($URIEncryptedString["SystemUser_ID"])) { goto_signoff(); }
  $rmb = new repmyblock();  
  
  // Put the POST HERE because we need to reread the data 
  if ( ! empty ($_POST)) {
    WriteStderr($_POST, "Post");
    
    if ( ! empty ($_POST["LastName"]) || ! empty ($_POST["FirstName"])) {
    
      // This is where the data in the profile gets updated.
      $ProfileArray = [ 
      									"bio" => $_POST["profile_bio"] ?? null, 
                        "URL"=> $_POST["URL"] ?? null,
                        "Location" => $_POST["Location"] ?? null
                      ];

      if ( $rmbperson["SystemUser_FirstName"] ?? null != $_POST["FirstName"] ) {
        $ProfileArray["Change"]["SystemUser_FirstName"] = $_POST["FirstName"];
        $FirstName = trim($_POST["FirstName"]);
      } 
        
      if ( $rmbperson["SystemUser_LastName"] ?? null != $_POST["LastName"] ) {
        $ProfileArray["Change"]["SystemUser_LastName"] = $_POST["LastName"];
        $LastName = trim($_POST["LastName"]);
      }
      if ( $rmbperson["SystemUser_email"]  ?? null != $_POST["Email"] ) {
        $ProfileArray["Special"]["SystemUser_email"] = $_POST["Email"];
        $ProfileArray["Special"]["SystemUser_emaillinkid"] = hash("md5", PrintRandomText(40));
      }

      if ( $URIEncryptedString["SystemUser_ID"] == "TMP") {
        
        $mytmp = $rmb->SearchTempUsers($URIEncryptedString["SystemTemporaryID"]);      
        WriteStderr($mytmp, "SystemUserID ==> TMP with " . $URIEncryptedString["SystemTemporaryID"]);

        if ( empty ($mytmp["SystemUser_ID"])) {
          $rmbperson = $rmb->CreateSystemUserAndUpdateProfile($URIEncryptedString["SystemTemporaryEmail"], $ProfileArray, $rmbperson);        
          $URIEncryptedString["SystemUser_ID"] = $rmbperson["SystemUser_ID"];
        
          // If the person is part of the team, 
          if ( ! empty ($mytmp["SystemUserTemporary_reference"])) { 
            // If ONLY Digits, it's a claim for a profile.
          	if ( ctype_digit($mytmp["SystemUserTemporary_reference"])) {
							// Add   
							$CandidateInfo = $rmb->FindPublicProfile(null, $mytmp["SystemUserTemporary_reference"]);
							
							if ( ! empty ($CandidateInfo)) {
								WriteStderr($CandidateInfo, "CandidateInfo"); 	
								$rmb->UpdateCandidateCounterSystemID( $CandidateInfo["Candidate_ID"],$rmbperson["SystemUser_ID"]);     
  						}    
  						 		
          	} else {
	            // Check that a team exist with that code.
  	          $TeamWebCode = $rmb->FindCampaignFromWebCode($mytmp["SystemUserTemporary_reference"]);
    	        WriteStderr($TeamWebCode, "WebCode");    
      	      $rmb->SaveTeamInfo($rmbperson["SystemUser_ID"] , $TeamWebCode["Team_ID"], NULL, 'pending');
            }
          }
          
        } else {
          $rmbperson = $rmb->UpdatePersonUserProfile($mytmp[0]["SystemUser_ID"], $ProfileArray, $rmbperson);       
          $URIEncryptedString["SystemUser_ID"] = $mytmp[0]["SystemUser_ID"];
        }
        
        $URIEncryptedString["FirstName"] = $rmbperson["SystemUser_FirstName"];
        $URIEncryptedString["LastName"] = $rmbperson["SystemUser_LastName"];
        $URIEncryptedString["SystemUser_Priv"] = $rmbperson["SystemUser_Priv"];
        
      } else {
        $rmbperson = $rmb->UpdatePersonUserProfile($URIEncryptedString["SystemUser_ID"], $ProfileArray, $rmbperson);        
      }
    
        
      if ( $rmbperson["ChangeEmail"] == 1) {      
        $infoarray["FirstName"] = $rmbperson["SystemUser_FirstName"];
        require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/funcs/email.php";      
        SendChangeEmail($rmbperson["SystemUser_email"], $rmbperson["SystemUser_emaillinkid"], 
                        $rmbperson["SystemUser_username"], $infoarray); 
      }  
    } else {
      $ErrorMsg = "You need to enter a First or Last Name to enable your account.";
      header("Location: user");
      exit();  
    }
  } 
  
  $rmbperson = $rmb->FindPersonUserProfile($URIEncryptedString["SystemUser_ID"]);
  
  if ( $URIEncryptedString["SystemUser_ID"] == "TMP" ) {
    WriteStderr($rmbperson, "In the SystemUserID == TEMP Section");
    $PersonEmail = $URIEncryptedString["SystemTemporaryEmail"];  
    
    if ( ! empty ($rmbperson)) {
      WriteStderr($mytmp, "MY Temp ID from the If Above");
      
      $k = CreateEncoded ([
          "SystemUser_ID" => $rmbperson["SystemUser_ID"],  
          "FirstName" => $PersonFirstName, 
          "LastName" => $PersonLastName,
          "SystemUser_email" =>  $rmbperson["SystemUser_email"], 
          "SystemUser_Priv" => $rmbperson["SystemUser_Priv"],
      ]);

      if ( ! empty ($_POST)) {
        WriteStderr($_POST, "In the SystemUserID == TEMP Section and in the Header.");
        header("Location: /" . $k . "/lgd/profile/user");
        exit();  
      }
    }  
   
  } else {
    WriteStderr($rmbperson, "rmbperson array of the Else of the TMP Section");
    
    $PersonFirstName = $rmbperson["SystemUser_FirstName"];
    $PersonLastName  = $rmbperson["SystemUser_LastName"];
    $PersonEmail     = $rmbperson["SystemUser_email"];
    $PersonBio       = $rmbperson["SystemUserProfile_bio"];
    $PersonURL       = $rmbperson["SystemUserProfile_URL"];
    $PersonLocation  = $rmbperson["SystemUserProfile_Location"];
    
    if (! empty ($_POST)) { $ReloadTheScreen = true; }       
    
    // This is to catch the user coming back and updating the name.
    $KBuildSystemID = $rmbperson["SystemUser_ID"];
    if ( empty ($KBuildSystemID)) {
      if ( empty ($mytmp["SystemUser_ID"])) {  goto_signoff(); }
      $KBuildSystemID = $mytmp["SystemUser_ID"];      
    }
    
    $k = CreateEncoded ([ 
        "SystemUser_ID" => $KBuildSystemID,  
        "FirstName" => $PersonFirstName, 
        "LastName" => $PersonLastName,
        "VotersIndexes_ID" =>  $rmbperson["VotersIndexes_ID"], 
        "UserParty" => $rmbperson["SystemUser_Party"], 
        "MenuDescription" => $URIEncryptedString["MenuDescription"],
        "SystemUser_Priv" => $URIEncryptedString["SystemUser_Priv"],
        "EDAD" => $URIEncryptedString["EDAD"]
    ]);
    
    if ( $ReloadTheScreen == true) {
      WriteStderr($_POST, "In the Else of the TMP Section and reloading in the header");
      header("Location: /" . $k . "/lgd/profile/user");
      exit();  
    }
    
    if ( empty ($MenuDescription)) { $MenuDescription = "District Not Defined";}  
    $Party = PrintParty($UserParty);
    
    if ($rmbperson["SystemUser_emailverified"] == "both") {
      $TopMenus = [ 
	      ["k" => $k, "url" => "profile/user", "text" => "Public Profile"],
	      ["k" => $k, "url" => "profile/voter/card", "text" => "Voter Profile"], 
	      ["k" => $k, "url" => "profile/candidate/public", "text" => "Candidate Profile"],
	      ["k" => $k, "url" => "profile/team/section", "text" => "Team Profile"]
	    ];
    }              
  }
  
  $middleuri = $k;
  include $_SERVER["DOCUMENT_ROOT"] . "/common/headers.php";
  if ( $MobileDisplay == true) { $Cols = "col-12"; } else { $Cols = "col-full"; }
?>

    <div class="row layout">
      <?php include $_SERVER["DOCUMENT_ROOT"] . "/common/menu.php"; ?>
      <div class="main">
        <div class="col-full">
          <div class="Subhead">
            <h2 class="Subhead-heading">Personal Profile</h2>
          </div>
          <?php  PlurialMenu($k, $TopMenus ?? null); ?>
          <div class="col-full f60">
<?php if (empty ($TopMenus)) { ?>
            <P class="f60">
              <B>
                <BR>
                You <FONT COLOR=BROWN>must</FONT> fill in at least your <FONT COLOR=BROWN>first</FONT> or <FONT COLOR=BROWN>last</FONT>
                name to enable the other screens.
              </B>
            </P>
<?php } ?>
            <form id="" action="" accept-charset="UTF-8" method="post">
<?php if ( ! empty ($TopMenus)) { ?>
              <input type="hidden" value="<?= $URIEncryptedString["SystemUser_ID"] ?>" name="UserID">
<?php } ?>
						 	<div class="clearfix gutter d-flex flex-shrink-0">
						 		<div class="list-group-item filtered">
						 			
						 			<div class="voter-form">
		              <div class="field">
		                <label class="f40" for="user_profile_name">Email Address</label>
		                <div class="form-value" style="padding: 45px 20px"><?= $PersonEmail ?></div>
		              </div>     
		            </DIV>
		     
			            <div class="voter-form">
			              <div class="field" style="grid-column: span 6;">
			                <input id="firstname" class="input" type="text" name="FirstName" value="<?= $PersonFirstName  ?? null ?>" required placeholder=" ">
			                <label for="firstname">First Name</label>
			              </div>
			            
			              <DIV class="field" style="grid-column: span 6;">
			                <input id="lastname" class="input" type="text" name="LastName" value="<?= $PersonLastName ?? null ?>" required placeholder=" ">
			                <label for="lastname">Last Name</label>
			              </div>
			              
			            </DIV>
			              
		              <DIV class="">
		                <INPUT class="f60bold" TYPE="Submit" NAME="SaveInfo" VALUE="Update profile">
		              </DIV>
		              
		            </DIV>
		          </DIV>
            </FORM>    
          </DIV>
        </DIV>
      </DIV>
    </DIV>
<?php include $_SERVER["DOCUMENT_ROOT"] . "/common/footer.php";  ?>