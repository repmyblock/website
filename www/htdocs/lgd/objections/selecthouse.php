<?php
	if ( ! empty ($k)) { $MenuLogin = "logged";  }  
	$Menu = "objections";
	// $BigMenu = "represent";	
	
	require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/common/verif_sec.php";
	require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/db/db_objections.php";	
	if (empty ($URIEncryptedString["SystemUser_ID"])) { goto_signoff(); }
	
	$rmb = new Objections();
	$rmbperson = $rmb->SearchUserVoterCard($URIEncryptedString["SystemUser_ID"]);
	
	if ( ! empty ($_POST)) {
		foreach ($_POST["Sheet"] as $index => $var) {
			if ( $var > 0) {
				
				if ($_POST["PrevSheet"][$index] != $_POST["Sheet"][$index] || 
						$_POST["PrevLine"][$index] != $_POST["Line"][$index]) {

					if (empty ($_POST["PrevSheet"][$index]) && ! empty($_POST["Sheet"][$index]) &&
							empty ($_POST["PrevLine"][$index]) && ! empty($_POST["Line"][$index])) {
						$Details[] = array("VoterID" => $index, "Sheet" => $var, "Line" => $_POST["Line"][$index], "Type" => "new");		
					}	else {
						$Details[] = array("VoterID" => $index, "Sheet" => $var, "Line" => $_POST["Line"][$index], 
																"ObjID" => $_POST["ObjID"][$index],  "Type" => "update");				
					}
					
				}
			}
		}

		$rmb->AddObjectionDetail($URIEncryptedString["Objections_ID"], $Details);
		header("Location: selecthouse");
		exit();	
	}	
	
	if ($URIEncryptedString["Objections_ID"] > 0) {
		$ListObjections = $rmb->ListObjectionsDetails($URIEncryptedString["Objections_ID"]);		
		WriteStderr($ListObjections, "Buildings in District");
		
		if (! empty ($ListObjections)) {
			foreach ($ListObjections as $var) {
				if ( !empty ($var)) {
					$VoterStatus[$var["Voter_ID"]] = array(
											"sheet" => $var["ObjectionsDetails_Sheet"], 
											"line" => $var["ObjectionsDetails_Line"],
											"ojbid" => $var["ObjectionsDetails_ID"]
										);
				}
			}
		}		
	}
	
	
	$ListVoterAtAddress = $rmb->SearchVoterAtAddress(
			array("HouseNumber" => $URIEncryptedString["DataAddress_HouseNumber"], "Name" => $URIEncryptedString["DataStreet_Name"], 
						"FracAddress" => $URIEncryptedString["DataAddress_FracAddress"], "PreStreet" => $URIEncryptedString["DataAddress_PreStreet"], 
						"PostStreet" => $URIEncryptedString["DataAddress_PostStreet"], "Zipcode" => $URIEncryptedString["DataAddress_zipcode"],
						"County" => $URIEncryptedString["DataCounty_ID"], "FirstName" => $URIEncryptedString["FirstName"],
						"LastName" => $URIEncryptedString["LastName"],
						"BOECountyID" => $URIEncryptedString["BOECountyID"],
						"BOEStateID" => $URIEncryptedString["BOEStateID"],
						)
	);
	
	
	
	//$result = $r->GetSignedElectors($Candidate_ID);
	$EncryptURL = EncryptURL("CandidateID=" . $Candidate_ID . "&PetitionSetID=" . $CandidatePetitionSet_ID);
	
	/*
	$TopMenus = array ( 
		array("k" => $k, "url" => "team/index", "text" => "Team Members"),
		array("k" => $k, "url" => "team/teampetitions", "text" => "Manage Petitions"),
		array("k" => $k, "url" => "team/teamcandidate", "text" => "Setup Teams")
	);			
	WriteStderr($TopMenus, "Top Menu");		
	*/
	
	include $_SERVER["DOCUMENT_ROOT"] . "/common/headers.php";		
	if ( $MobileDisplay == true) {	 $Cols = "col-12"; $SizeField = " SIZE=10"; } else { $Cols = "col-9"; }
?>


<script>
function myFunction() {
  // Declare variables
  var input, filter, table, tr, td, i, txtValue;
  var col=4;
  input = document.getElementById("myInput");
  filter = input.value.toUpperCase();
 
  table = document.getElementById("myTable");
  tr = table.getElementsByTagName("tr");
  
 	console.log("Console tr.Lenght: " + tr.length);

  // Loop through all table rows, and hide those who don't match the search query
 for (i = 0; i < tr.length; i++) {
    td1 = tr[i].getElementsByTagName("td")[2];
    td2 = tr[i].getElementsByTagName("td")[4];
    
    if (td1 || td2) {
      txtValue = (td1.textContent || td1.innerText) + (td2.textContent || td2.innerText);
      if (txtValue.toUpperCase().indexOf(filter) > -1) {
        tr[i].style.display = "";
      } else {
        tr[i].style.display = "none";
      }
    }

  }
}
</script>

<div class="row">
  <div class="main">
		<?php include $_SERVER["DOCUMENT_ROOT"] . "/common/menu.php"; ?>
  		<div class="<?= $Cols ?> float-left col-full">
    
			  <!-- Public Profile -->
			  <div class="Subhead mt-0 mb-0">
			    <h2 class="Subhead-heading">Objections management</h2>
				</DIV>
				<?php	PlurialMenu($k, $TopMenus); ?>   
			  <div class="clearfix gutter">
			  	<div class="row">
				  <div class="main">
			  	
			  		<DIV>
				<P class="f40">
		   		 
		   	<?php WriteStderr($ListTeamNames, "List of name inside the code that are not appearing."); ?>

     	</P>
			</DIV>

						<div class="Box">
					  	<div class="Box-header pl-0">
					    	<div class="table-list-filters d-flex">
					  			<div class="table-list-header-toggle states flex-justify-start pl-3 f60">Petitions objections</div>
					  		</div>
					    </div>
	
					
								
							<div class="Box-body js-collaborated-repos-empty">
								<div class="flex-items-left">	
									<span class="ml-0 flex-items-baseline ">
										
									<FORM METHOD="POST" ACTION="">
											
									<h2>Search on sheet</H2>
									<P CLASS="f60">
							
							
						
	 						<input type="text" id="myInput" onkeyup="myFunction()" placeholder="Lookup">
	 					</P>
	 					<P>
							<A HREF="addvoter">Return to previous menu</A>
   </P>
									
										<DIV class="p40">
										<TABLE BORDER=1 id="myTable">
											<TR>
													<TH>Sheet</TH>
													<TH>Line</TH>
													<TH style="padding:0px 4px;">First Name</TH>
													<TH style="padding:0px 4px;">Middle</TH>
													<TH style="padding:0px 4px;">Last Name</TH>
													<TH style="padding:0px 4px;">Suffix</TH>
													<TH>DOB</TH>													
													<TH>Party</TH>
													<TH>Address</TH>
													<TH>County ID</TH>
													<TH>Status</TH>
											</TR>
									<?php 
											if ( ! empty ($ListVoterAtAddress) ) {
												foreach ($ListVoterAtAddress as $var) {
													if ( !empty ($var)) {
											?>		
												<TR>
													<TD style="padding:0px 10px;"><INPUT TYPE="TEXT" NAME="Sheet[<?= $var["Voters_ID"] ?>]" SIZE=1 value="<?= $VoterStatus[$var["Voters_ID"]]["sheet"] ?>"></TD>
													<TD style="padding:0px 10px;"><INPUT TYPE="TEXT" NAME="Line[<?= $var["Voters_ID"] ?>]" SIZE=1 value="<?= $VoterStatus[$var["Voters_ID"]]["line"] ?>">
													<?php if ( ! empty ($VoterStatus[$var["Voters_ID"]]["ojbid"])) { ?>
														<INPUT TYPE="HIDDEN" NAME="PrevSheet[<?= $var["Voters_ID"] ?>]" SIZE=1 value="<?= $VoterStatus[$var["Voters_ID"]]["sheet"] ?>">
														<INPUT TYPE="HIDDEN" NAME="PrevLine[<?= $var["Voters_ID"] ?>]" SIZE=1 value="<?= $VoterStatus[$var["Voters_ID"]]["line"] ?>">
														<INPUT TYPE="HIDDEN" NAME="ObjID[<?= $var["Voters_ID"] ?>]" SIZE=1 value="<?= $VoterStatus[$var["Voters_ID"]]["ojbid"] ?>"><?php 													
													} ?></TD>
														
													<TD style="padding:0px 10px;"><?= $var["DataFirstName_Text"] ?></TD>
													<TD style="padding:0px 10px;"><?= $var["DataMiddleName_Text"] ?></TD>
													<TD style="padding:0px 10px;"><?= $var["DataLastName_Text"] ?></TD>
													<TD style="padding:0px 10px;"><?= $var["VotersIndexes_Suffix"] ?></TD>
													<TD style="padding:0px 10px;"><?= $var["VotersIndexes_DOB"] ?></TD>													
													<TD style="padding:0px 10px;"><?= $var["Voters_RegParty"] ?></TD>
													<TD style="padding:0px 10px;"><?= $var["DataAddress_HouseNumber"] ?>
													<?= $var["DataAddress_FracAddress"] ?>
													<?= $var["DataAddress_PreStreet"] ?>
													<?= $var["DataStreet_Name"] ?>
													<?= $var["DataAddress_PostStreet"] ?>
													<?= $var["DataHouse_Type"] . " " . $var["DataHouse_Apt"] ?></TD>
													<TD style="padding:0px 10px;"><?= $var["Voters_CountyVoterNumber"] ?></TD>
													<TD style="padding:0px 10px;"><?= $var["Voters_Status"] ?></TD>
											</TR>
								<?php }
									}
							
										
										} else {
							?>
								<TR><TD COLSPAN=15 ALIGN=CENTER>No petitions have been defined for this election<BR><BR><BR></TD></TR>
							<?php } ?>


<TR><TD COLSPAN=15 ALIGN=LEFT><BR><p><button type="submit" class="submitred">Update Petition Sheet</button></p></TD></TR>

							</TABLE>
						
		
</FORM>
</DIV>
</DIV>
</DIV>
</DIV>
</DIV>
</DIV>
</DIV>
</DIV>
</DIV>
</DIV>



<?php include $_SERVER["DOCUMENT_ROOT"] . "/common/footer.php";	?>