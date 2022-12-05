<?php
	if ( ! empty ($k)) { $MenuLogin = "logged";  }  
	$Menu = "team";

	require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/common/verif_sec.php";	
	require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/db/db_teams.php";
  if (empty ($URIEncryptedString["SystemUser_ID"])) { goto_signoff(); }
  
  $rmb = new Teams();
	
  if (! empty ($_POST)) {
  	WriteStderr($URIEncryptedString, "URIEncryptedString");
  	WriteStderr($_POST, "POST to ... ");
  	exit();

  } else {
 		$rmbperson = $rmb->SearchUserVoterCard($URIEncryptedString["SystemUser_ID"]);
		$rmbteamuser = $rmb->ReturnMemberFromTeam($URIEncryptedString["TeamMember_ID"]);
		WriteStderr($rmbteamuser, "RMB Team");
		$ActiveTeam = $rmbteamuser["Team_Name"];
		$FullName = $rmbteamuser["SystemUser_FirstName"] . " " . $rmbteamuser["SystemUser_LastName"];
		$rmbteammember = $rmb->SearchUserVoterCard($rmbteamuser["TeamSystemUser_ID"]);

	}

	
	include $_SERVER["DOCUMENT_ROOT"] . "/common/headers.php";
?>

<div class="row">
  <div class="main">
		<?php include $_SERVER["DOCUMENT_ROOT"] . "/common/menu.php"; ?>
  		<div class="<?= $Cols ?> float-left col-full">
    
			  <!-- Public Profile -->
			  <div class="Subhead mt-0 mb-0">
			    <h2 class="Subhead-heading">Voter Information</h2>
				</DIV>

				 <div class="clearfix gutter">
			  	<div class="row">
				  <div class="main">
			  	
			  		<DIV>
				<P class="f40">
		   		 <B>Current Team:</B> <?= $ActiveTeam ?>
     	</P>
				
			

			  <div class="clearfix gutter">

		<div class="row">
		  <div class="main">
				<FORM ACTION="" METHOD="POST">
				<div class="Box">
			  	<div class="Box-header pl-0">
			    	<div class="table-list-filters d-flex">
			  			<div class="table-list-header-toggle states flex-justify-start pl-3">Voter Information for <B><?= $FullName  ?></B></div>
			  		</div>
			    </div>
			    
			     <div class="Box-body  js-collaborated-repos-empty">
					      <a href="index">Return to previous screen</a>
					    </div>
					    
				    
			    <div class="Box-body text-center py-6 js-collaborated-repos-empty" hidden="">
			      We don't know your district <a href="/voter">create one</a>?
			    </div>
			    
					<?php 			
						$Counter = 0;
						//if ( ! empty ($rmbteaminfo)) {								
					?>
					
					<div id="voters">
					<div class="list-group-item filtered">							
						<?php 
							// This need to be updated for the right state						
							preg_match('/^NY0+(.*)/', $rmbteammember["VotersIndexes_UniqStateVoterID"], $UniqMatches, PREG_OFFSET_CAPTURE);
							$UniqVoterID = $rmbteammember["DataState_Abbrev"] . $UniqMatches[1][0]; 
						?>
						
						<P>
							Click here to include this user in your team <INPUT TYPE="CHECKBOX" MemberActive=""> 									
							<BR>
							<A HREF="">Prepare a petition</A>
							<A HREF="">Prepare a walksheet</A>
						</P>

						<P>
							<svg class="octicon octicon-organization" viewBox="0 0 16 16" version="1.1" width="16" height="16" aria-hidden="true"><path fill-rule="evenodd" d="M16 12.999c0 .439-.45 1-1 1H7.995c-.539 0-.994-.447-.995-.999H1c-.54 0-1-.561-1-1 0-2.634 3-4 3-4s.229-.409 0-1c-.841-.621-1.058-.59-1-3 .058-2.419 1.367-3 2.5-3s2.442.58 2.5 3c.058 2.41-.159 2.379-1 3-.229.59 0 1 0 1s1.549.711 2.42 2.088C9.196 9.369 10 8.999 10 8.999s.229-.409 0-1c-.841-.62-1.058-.59-1-3 .058-2.419 1.367-3 2.5-3s2.437.581 2.495 3c.059 2.41-.158 2.38-1 3-.229.59 0 1 0 1s3.005 1.366 3.005 4z"></path></svg>
							<?= $UniqVoterID ?> Status: <FONT COLOR=BROWN><?= $rmbperson["Voters_Status"] ?></FONT>
						</P>
						
						<TABLE BORDER=1>
							<TR>
								<TH style="padding:0px 10px;">First</TH>
								<TH style="padding:0px 10px;">Middle</TH>
								<TH style="padding:0px 10px;">Last</TH>
								<TH style="padding:0px 10px;">Suffix</TH>
							</TR>
							<TR ALIGN=CENTER>
								<TD style="padding:0px 10px;"><?= $rmbteammember["DataFirstName_Text"] ?></TD>
								<TD style="padding:0px 10px;"><?= $rmbteammember["DataMiddleName_Text"] ?></TD>
								<TD style="padding:0px 10px;"><?= $rmbteammember["DataLastName_Text"] ?></TD>
								<TD style="padding:0px 10px;"><?= $rmbteammember["VotersIndexes_Suffix"] ?></TD>
							</TR>
						</TABLE>

						<BR>

						<TABLE BORDER=1>
							<TR>
								<TH style="padding:0px 10px;">Email Address</TH>
							</TR>
							<TR ALIGN=CENTER>
								<TD style="padding:0px 10px;"><?= $rmbteammember["SystemUser_email"] ?></TD>
							</TR>
						</TABLE>

						<BR>

						<TABLE BORDER=1>
							<TR>
								<TH style="padding:0px 10px;">Date of Birth</TH>
								<TH style="padding:0px 10px;">Age</TH>
								<TH style="padding:0px 10px;">Gender</TH>
								<TH style="padding:0px 10px;">Party</TH>
							</TR>
							<?php
								$dob = new DateTime($rmbteammember["VotersIndexes_DOB"]);
								$now = new DateTime();
								$difference = $now->diff($dob);
							?>

							<TR ALIGN=CENTER>
								<TD style="padding:0px 10px;"><?= PrintShortDate($rmbteammember["VotersIndexes_DOB"]); ?></TD>
								<TD style="padding:0px 10px;"><?= $difference->y; ?></TD>
								<TD style="padding:0px 10px;"><?= $rmbteammember["Voters_Gender"] ?></TD>
								<TD style="padding:0px 10px;"><?= PrintParty($rmbteammember["Voters_RegParty"]) ?></TD>
							</TR>
						</TABLE>					

						<BR>

						<TABLE BORDER=1>
							<TR>
								<TH style="padding:0px 10px;">Address</TH>
							</TR>
							
							<TR>
								<TD style="padding:0px 10px;">		
									<?php if (! empty ($rmbteammember["DataAddress_HouseNumber"])) echo $rmbteammember["DataAddress_HouseNumber"]; ?>
									<?php if (! empty ($rmbteammember["DataAddress_FracAddress"]))  echo $rmbteammember["DataAddress_FracAddress"]; ?>
									<?php if (! empty ($rmbteammember["DataAddress_PreStreet"])) echo $rmbteammember["DataAddress_PreStreet"]; ?>
									<?php if (! empty ($rmbteammember["DataStreet_Name"])) echo $rmbteammember["DataStreet_Name"]; ?>
									<?php if (! empty ($rmbteammember["DataAddress_PostStreet"])) echo $rmbteammember["DataAddress_PostStreet"]; ?>
									<?php if (! empty ($rmbteammember["DataHouse_Apt"])) echo " - Apt " . $rmbteammember["DataHouse_Apt"]; ?>
									<BR>
									<?= $rmbteammember["DataCity_Name"] . ", " . $rmbteammember["DataState_Abbrev"] ?>
										<?= $rmbteammember["DataAddress_zipcode"] ?>
									<?php if (! empty ($rmbteammember["Raw_Voter_ResZip4"])) echo " - " . $rmbteammember["Raw_Voter_ResZip4"]; ?>
									<BR>
								</TD>
							</TR>
						</TABLE>
					
						<BR>

						<TABLE BORDER=1>
							<TR>
								<TH style="padding:0px 10px;">Board of Election ID #</TH>
							</TR>
								<TR ALIGN=CENTER>
								<TD style="padding:0px 10px;"><?= $rmbteammember["Voters_CountyVoterNumber"] ?></TD>
							</TR>
						</TABLE>
						
						<BR>

						<TABLE BORDER=1>
							<TR>
								<TH style="padding:0px 10px;">Assembly</TH>
								<TH style="padding:0px 10px;">Electoral</TH>
								<TH style="padding:0px 10px;">Congress</TH>
								<TH style="padding:0px 10px;">County</TH>
							</TR>
																
							<TR ALIGN=CENTER>
								<TD style="padding:0px 10px;"><?= $RawVoterNY["AssemblyDistr"] ?></TD>
								<TD style="padding:0px 10px;"><?= $RawVoterNY["ElectDistr"] ?></TD>
								<TD style="padding:0px 10px;"><?= $RawVoterNY["CongressDistr"] ?></TD>
								<TD style="padding:0px 10px;"><?= $RawVoterNY["DataCounty_Name"] ?></TD>
							</TR>
						</TABLE>
							
						<BR>
							<TABLE BORDER=1>
							<TR>
								<TH style="padding:0px 10px;">Legis #</TH>
								<TH style="padding:0px 10px;">Town</TH>
								<TH style="padding:0px 10px;">Ward</TH>
								<TH style="padding:0px 10px;">Senate</TH>
							</TR>
							<TR ALIGN=CENTER>
								<TD style="padding:0px 10px;"><?= $RawVoterNY["LegisDistr"] ?></TD>
								<TD style="padding:0px 10px;"><?= $RawVoterNY["TownCity"] ?></TD>
								<TD style="padding:0px 10px;"><?= $RawVoterNY["Ward"] ?></TD>
								<TD style="padding:0px 10px;"><?= $RawVoterNY["SenateDistr"] ?></TD>
			
							</TR>
						</TABLE>
			
						<BR>
						</div>
			
					</span>
				</div>

				<?php						
				///			} 
				?>

							</div>
							<BR>

					</div>
					</FORM>
			</div>
		</DIV>
	</DIV>
	</DIV>
</DIV>

</DIV>
</div>
</div>
</div>


<?php include $_SERVER["DOCUMENT_ROOT"] . "/common/footer.php";	?>
