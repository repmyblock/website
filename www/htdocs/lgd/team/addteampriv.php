<?php
	if ( ! empty ($k)) { $MenuLogin = "logged";  }  
	$Menu = "team";
	
	require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/common/verif_sec.php";	
	require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/db/db_teams.php";
	
  if (empty ($URIEncryptedString["SystemUser_ID"])) { goto_signoff(); }
  
  // Passtru function to add the Team Priviledge to the user.  
  $rmb = new Teams();
	$rmb->UpdateAutoTeam(PERM_MENU_TEAM, $URIEncryptedString["SystemUser_ID"]); 
	
	WriteStderr($k, "K In Team Priv:");
		
	header("Location: /" .  MergeEncode(array( 
								"SystemUser_ID" => $URIEncryptedString["SystemUser_ID"],
						    "UniqNYSVoterID" => $URIEncryptedString["UniqNYSVoterID"],
						   	"SystemUser_Priv" => $URIEncryptedString["SystemUser_Priv"]
					)) . "/lgd/team/createteams");
	exit();
?>
