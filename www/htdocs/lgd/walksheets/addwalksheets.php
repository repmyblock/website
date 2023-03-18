<?php
	if ( ! empty ($k)) { $MenuLogin = "logged";  }  
	$Menu = "team";

	require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/common/verif_sec.php";	
	require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/db/db_teams.php";
	
  if (empty ($URIEncryptedString["SystemUser_ID"])) { goto_signoff(); }
  
  // Passtru function to add the Team Priviledge to the user.  
  $rmb = new Teams();
	$rmb->UpdateAutoTeam(PERM_MENU_WALKSHEET, $URIEncryptedString["SystemUser_ID"]); 
			

	header("Location: /" .  CreateEncoded ( array( 
								"SystemUser_ID" => $URIEncryptedString["SystemUser_ID"],
						    "FirstName" => $URIEncryptedString["FirstName"],
						    "LastName" => $URIEncryptedString["LastName"],
						    "UniqNYSVoterID" => $URIEncryptedString["UniqNYSVoterID"],
						   	"SystemUser_Priv" => $URIEncryptedString["SystemUser_Priv"]
					)) . "/lgd/walksheets/petitions");
	exit();
?>
