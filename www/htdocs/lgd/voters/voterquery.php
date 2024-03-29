<?php
	if ( ! empty ($k)) { $MenuLogin = "logged";  }  
	$Menu = "voters";
	$BigMenu = "represent";	
	
	require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/common/verif_sec.php";	
	require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/funcs/general.php";
	require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/db/db_repmyblock.php";  

  if (empty ($URIEncryptedString["SystemUser_ID"])) { goto_signoff(); }
	if ( empty ($URIEncryptedString["MenuDescription"])) { $MenuDescription = "District Not Defined";}	
	$Party = PrintParty($URIEncryptedString["UserParty"]);

	if (! empty($_POST)) {	
	
		// This will be different answer depending
		$finalurl = "voters/voterresult";
		
		header("Location: /" .  CreateEncoded ( array( 
								"Query_FirstName" => $_POST["FirstName"],
								"Query_LastName" => $_POST["LastName"], 
								"Query_AD" => $_POST["AD"],
								"Query_ED" => $_POST["ED"],
								"Query_ZIP" => $_POST["ZIP"],
								"Query_COUNTY" => $_POST["COUNTY"],
								"Query_PARTY" => $_POST["Party"],
								"Query_NYSBOEID" => $_POST["UniqNYS"],
								"Query_Congress" => $_POST["Congress"],
								"SystemUser_ID" => $URIEncryptedString["SystemUser_ID"],
						    "FirstName" => $URIEncryptedString["FirstName"],
						    "LastName" => $URIEncryptedString["LastName"],
						    "UniqNYSVoterID" => $URIEncryptedString["UniqNYSVoterID"],
						   	"SystemUser_Priv" => $URIEncryptedString["SystemUser_Priv"],
						   	"EDAD" => $URIEncryptedString["EDAD"]
					)) . "/lgd/" . $finalurl);
		exit();
	}

	$rmb = new RepMyBlock();	
	$rmbperson = $rmb->SearchUserVoterCard($URIEncryptedString["SystemUser_ID"]);
	
	// Why I am getting petition for candidates ?
	//	$result = $rmb->GetPetitionsForCandidate($DatedFiles, 0, $URIEncryptedString["SystemUser_ID"]);
	/*
	if ( ! empty ($result)) {
		foreach ($result as $var) {
			if ( ! empty ($var)) {

				$MyAddressToUse = $var["Raw_Voter_ResHouseNumber"] . " " . 
													$var["Raw_Voter_ResStreetName"];

				if ( empty ($Counter[$MyAddressToUse] )) {
					$Counter[$MyAddressToUse] = 0;
				}
				
				$Electors[$MyAddressToUse][$Counter[$MyAddressToUse]]["Petition_ID"] = $var["Candidate_ID"];
				$Electors[$MyAddressToUse][$Counter[$MyAddressToUse]]["Elector_ID"] = $var["VotersIndexes_UniqNYSVoterID"];
				$Electors[$MyAddressToUse][$Counter[$MyAddressToUse]]["Elector_FullName"] = $var["CandidatePetition_VoterFullName"];
				$Electors[$MyAddressToUse][$Counter[$MyAddressToUse]]["Elector_Address"] = "Apt " . $var["Raw_Voter_ResApartment"];
				$Electors[$MyAddressToUse][$Counter[$MyAddressToUse]]["Full_Elector_Address"] = $var["Raw_Voter_ResHouseNumber"] . " " . $var["Raw_Voter_ResStreetName"];
			}			
			
			$Counter[$MyAddressToUse]++;
		}	
	}
	*/
	
	$TopMenus = array ( 
						array("k" => $k, "url" => "voters/voterlist", "text" => "District Voters"),
						array("k" => $k, "url" => "voters/voterquery", "text" => "Search Voter")
					);			
	WriteStderr($TopMenus, "Top Menu");		


			
	include $_SERVER["DOCUMENT_ROOT"] . "/common/headers.php";
	if ($MobileDisplay == true) { $Cols = "col-12"; } else { $Cols = "col-9"; }
?>

<div class="row">
  <div class="main">



<?php include $_SERVER["DOCUMENT_ROOT"] . "/common/menu.php"; ?>


<div class="<?= $Cols ?> float-left">
	
	<div class="Subhead">
  	<h2 class="Subhead-heading">Voters</h2>
	</div>

	
			<?php
			 	PlurialMenu($k, $TopMenus);
			?>
				    
				<div class="clearfix gutter d-flex flex-shrink-0">
									
				<FORM ACTION="" METHOD="POST">
					<TABLE WIDTH=100%>
						
						<TR ALIGN=CENTER>
							<TH style="padding:0px 10px;">House Number</TH><TD><INPUT TYPE="INPUT" NAME="HouseNumber" VALUE="<?= $HouseNumber ?>" SIZE=2></TD>				
							<TH style="padding:0px 10px;" COLSPAN=4>Street Name</TH><TD><INPUT TYPE="INPUT" NAME="StreetName" VALUE="<?= $StreetName ?>" SIZE=30></TD>
						</TR>
						
						<TR ALIGN=CENTER>
							<TH style="padding:0px 10px;">ZipCode</TD><TD><INPUT TYPE="INPUT" NAME="ZipCode" VALUE="<?= $ZipCode ?>" SIZE=5></TD>
							<TH style="padding:0px 10px;">AD</TH><TD><INPUT TYPE="INPUT" NAME="AD" VALUE="<?= $RepostAD ?>" SIZE=2></TD>								
							<TH style="padding:0px 10px;">ED</TD><TD><INPUT TYPE="INPUT" NAME="ED" VALUE="<?= $RepostED ?>" SIZE=2></TD>
							<TH style="padding:0px 10px;">County</TD>
							<TD>
								<SELECT NAME="County_ID">
									<?php if ( ! empty ($ListCounties)) {
										foreach ($ListCounties as $var) {
											if ( ! empty ($var)) { ?>
												<OPTION VALUE="<?= $var["DataCounty_ID"] ?>"<?= ($rmbperson["DataCounty_ID"] == $var["DataCounty_ID"]) ? " SELECTED" : NULL ?>><?= $var["DataCounty_Name"] ?></OPTION>
												<?php
												}
											}
										}
									?>
								</SELECT>
							</TD>
						</TR>
						<TR ALIGN=CENTER>
							<TH style="padding:0px 10px;" COLSPAN=3>First Name</TH><TD><INPUT TYPE="INPUT" NAME="FirstName" VALUE="<?= $FirstName ?>" SIZE=20></TD>								
							<TH style="padding:0px 10px;">Last Name</TH></TD><TD COLSPAN=3><INPUT TYPE="INPUT" NAME="LastName" VALUE="<?= $LastName ?>" SIZE=20></TD>
						</TR>
						
						<TR ALIGN=CENTER>
							<TH style="padding:0px 10px;" COLSPAN=3>County ID</TH><TD><INPUT TYPE="INPUT" NAME="BOECountyID" VALUE="<?= $BOECountyID ?>" SIZE=20></TD>								
							<TH style="padding:0px 10px;">State ID</TH></TD><TD COLSPAN=3><INPUT TYPE="INPUT" NAME="BOEStateID" VALUE="<?= $BOEStateID ?>" SIZE=20></TD>
						</TR>
						
						<TR>
							<TH COLSPAN=8 style="padding:0px 10px;"><INPUT TYPE="SUBMIT" NAME="SearchBuilding" VALUE="Search buildings" SIZE=2></TH>
						</TR>		
					</TABLE>
				</DIV>
				
				<div class="list-group-item filtered">
					<TABLE BORDER=1>
					<TR>
						<TH style="padding:0px 10px;">House</TH>
						<TH style="padding:0px 10px;">Frac</TH></TH>
						<TH style="padding:0px 10px;">Pre</TH>
						<TH style="padding:0px 10px;">Street Name</TH>
						<TH style="padding:0px 10px;">PostStreet</TH>
						<TH style="padding:0px 10px;">Zipcode</TH>
						<TH style="padding:0px 10px;">&nbsp;</TH>
					</TR>
										
					<?php 
						if (! empty ($result)) {
							foreach ($result as $var) {
								if (! empty ($var["DataAddress_HouseNumber"] && ! empty($var["DataStreet_Name"]) && ! empty ($var["DataAddress_zipcode"]))) {
					?>		
	
					<TR ALIGN=CENTER>
						<TD style="padding:0px 10px;"><?= $var["DataAddress_HouseNumber"] ?></TD>
						<TD style="padding:0px 10px;"><?= $var["DataAddress_FracAddress"] ?></TD>
						<TD style="padding:0px 10px;"><?= $var["DataAddress_PreStreet"] ?></TD>
						<TD style="padding:0px 10px;"><?= $var["DataStreet_Name"] ?></TD>
						<TD style="padding:0px 10px;"><?= $var["DataAddress_PostStreet"] ?></TD>
						<TD style="padding:0px 10px;"><?= $var["DataAddress_zipcode"] ?></TD>
						<TD style="padding:0px 10px;"><A HREF="/<?= MergeEncode(array(
																	"DataAddress_HouseNumber" => $var["DataAddress_HouseNumber"], 
																	"DataAddress_FracAddress" => $var["DataAddress_FracAddress"],
																	"DataAddress_PreStreet" => $var["DataAddress_PreStreet"],
																	"DataStreet_Name" => $var["DataStreet_Name"],
																	"DataAddress_PostStreet" => $var["DataAddress_PostStreet"],
																	"DataAddress_zipcode" => $var["DataAddress_zipcode"],
																
																)); 
															?>/lgd/objections/selecthouse"><B>See voters</B></A></TD>
					</TR>
					<?php 
								}
							}
						}
					?>
					</TABLE>
	</DIV>
</DIV>


</DIV>
</DIV>
</DIV>
<?php include $_SERVER["DOCUMENT_ROOT"] . "/common/footer.php";	?>
