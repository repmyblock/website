<?php
	if ( ! empty ($k)) { $MenuLogin = "logged"; }  
	$Menu = "summary";
	$BigMenu = "represent";	
	
	require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/common/verif_sec.php";	
	require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/db/db_repmyblock.php";  
	
  if (empty ($URIEncryptedString["SystemUser_ID"])) { goto_signoff(); exit(); }
  
	$rmb = new RepMyBlock();
	$rmbperson = $rmb->FindPersonUser($URIEncryptedString["SystemUser_ID"]);
	$NumberPetitions = $rmb->GetPetitionsSumary($URIEncryptedString["SystemUser_ID"]);

	if ( $VerifVoter == 1 && $rmbperson["Raw_Voter_ID"] > 0 ) { $VerifVoter = 0; }
	if ( $VerifEmail == 1 && $rmbperson["SystemUser_emailverified"] == 'yes') { $VerifEmail = 0; }

	/* Define numbers */
	$NumberOfElectors = $NumberPetitions["CandidateTotal"];
	$NumberOfSignatures = intval($NumberOfElectors * $SignaturesRequired) + 1;
	$Progress = round ((($NumberPetitions["CandidateSigned"] / $NumberPetitions["CandidateTotal"]) * 100), 2);
	$DateToWait = "April 1<sup>st</sup>";
	
	$NumberOfAddressesOnDistrict = 0;				

	/* Define the boxes here before we set the menu */
	if (empty ($MenuDescription)) { 
		$BoxSignatures = "Not defined"; 
		$BoxInDistrict = "Number of voters";
		$NumberOfElectors = "Not defined";
		
	} else {
		$Party = NewYork_PrintParty($UserParty);
		$BoxInDistrict = $Party . "s in the district";
		if ($VerifVoter == 1) { $BoxInDistrict = "Verify your voter info."; }
		$BoxSignatures = $NumberOfSignatures . " (" . $Progress . " %)";
	}	
	
	
	$PersonFirstName = $rmbperson["SystemUser_FirstName"];
	$PersonLastName  = $rmbperson["SystemUser_LastName"];
	$PersonEmail     = $rmbperson["SystemUser_Email"];

	$DayToGo = intval(($LastDayPetiton - time()) / 86400);
	
	/* Define the elements of the menu */
	if ( empty ($MenuDescription)) { $MenuDescription = "District Not Defined";}	
	
	include $_SERVER["DOCUMENT_ROOT"] . "/common/headers.php";
?>

<div class="row">
	<div class="main">

		<?php include $_SERVER["DOCUMENT_ROOT"] . "/common/menu.php"; ?>


			<div class="col-9 float-left">
			
				<div class="Subhead">
			  	<h2 class="Subhead-heading">Summary</h2>
				</div>
						
				<?php	PrintVerifMenu($VerifEmail, $VerifVoter);	?>     
				
				<?php if ($MenuDescription == "District Not Defined") { ?>
				
				<P>
					<A HREF="/lgd/<?= $k ?>/profile">Please update your Personal Profile so we can complete the summary information.</A>
				</P>		
					
				<?php } ?>
				   
	        
		    <div class="d-flex flex-column flex-md-row mb-3">
		    	<div class="col-12 py-3 px-4 col-md-4 mb-md-0 mb-3 mr-md-3 bg-gray rounded-1">
		        <h4 class="f5 text-normal text-gray"><?= $BoxInDistrict ?></h4>
		        <span class="f2 text-bold d-block mt-1 mb-2 pb-1"><?= $NumberOfElectors ?></span>
		    	</div>

		    	<div class="col-md-4 mr-md-3 col-12 py-3 px-4 mb-md-0 mb-3 bg-gray rounded-1">
		      	<h4 class="f5 text-normal text-gray">Required Signatures (Progress)</h4>
		  			<span class="f2 text-bold d-block mt-1 mb-2 pb-1"><?= $BoxSignatures ?></span>
			    </div>

			    <div class="col-md-4 col-12 py-3 px-4 mb-md-0 mb-3 bg-gray rounded-1">
			      <h4 class="f5 text-normal text-gray">Days to Go</h4>
			  		<span class="f2 text-bold d-block mt-1 mb-2 pb-1"><?= $DayToGo ?></span>						
			    </div>
			  </div>
			
				<P>
					Once you collect the  <?= $NumberOfSignatures ?> signatutes plus a few more, 
					you need to wait until <? $DateToWait ?> to take them
					to the board of elections. <B>Just follow the 
					<A HREF="<?= $FrontEndWeb ?>/where-to-file/prepare-to-file-your-petition-to-the-board-of-elections.html">instruction posted on the FAQ</A>.</B>
				</P>
				
						
				<P>
					The <A TARGET="CCSUN" HREF="https://CCSunlight.org">CC Sunlight Project</A> has put together a very
					good Run Kit. You can download 
					<A TARGET="CCSUN"HREF="https://drive.google.com/drive/folders/1CLpq48zFPQbHCeMN_3IKHVM65xejA354">from here.</A>
				</P>
	  
			</DIV>
		</DIV>
	</DIV>
</DIV>
<?php include $_SERVER["DOCUMENT_ROOT"] . "/common/footer.php";	?>