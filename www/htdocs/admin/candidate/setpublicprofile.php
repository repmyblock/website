<?php
	/*
		Always send the return data here.
		"ReturnURL" => "/admin/candidate/detail?Candidate_ID=<SOME VALUE
	*/

	if ( ! empty ($k)) { $MenuLogin = "logged";  }  

	require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/common/verif_sec.php";	
  require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/common/verif_admin.php";
	require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/db/db_admin.php";
	
  if (empty ($URIEncryptedString["SystemUser_ID"])) { goto_signoff(); }
  
  $parts = parse_url($URIEncryptedString["ReturnURL"]);
	parse_str($parts['query'], $query);

  // Passtru function to add the Team Priviledge to the user.  
  $rmb = new RMBAdmin(); 
 	$ret = $rmb->FindPublicProfileFromCandidate($URIEncryptedString["Candidate_ID"]);
 	
  if (empty ($ret)) { $TypeAdd = "ADD"; }
	$rmb->PublicProfileKey($URIEncryptedString["Candidate_ID"], $URIEncryptedString["CandidateProfile_ID"], $TypeAdd);	
	
	header("Location: /" .  MergeEncode($query, "ReturnURL") . $parts["path"]);  
  exit();
  
?>

