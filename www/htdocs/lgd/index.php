<?php
	if ( ! empty ($k)) { $MenuLogin = "logged";  }  
	$Menu = "summary";
	$BigMenu = "represent";	
	
	require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/common/verif_sec.php";	
  require $_SERVER["DOCUMENT_ROOT"] . "/../statlib/Config/Vars.php";
	require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/funcs/general.php";
	require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/db/db_repmyblock.php";  
  
  if (empty ($SystemUser_ID)) { goto_signoff(); }
	$rmb = new repmyblock();
	$rmbperson = $rmb->FindPersonUser($SystemUser_ID);

	if ( $VerifVoter == 1 && $rmbperson["Raw_Voter_ID"] > 0 ) { $VerifVoter = 0; }
	if ( $VerifEmail == 1 && $rmbperson["SystemUser_emailverified"] == 'yes') { $VerifEmail = 0; }

	if ( empty ($MenuDescription)) { $MenuDescription = "District Not Defined";}	
	$Party = NewYork_PrintParty($UserParty);
	
	$PersonFirstName = $rmbperson["SystemUser_FirstName"];
	$PersonLastName  = $rmbperson["SystemUser_LastName"];
	$PersonEmail     = $rmbperson["SystemUser_Email"];

	$DayToGo = intval(($LastDayPetiton - time()) / 86400);

	//date_diff(, date_create('today'))->d;
	
	$NumberOfElectors = "";
	$Progress = "%";
	$DateToWait = "April 1<sup>st</sup>";
	$NumberOfSignatures = intval($NumberOfElectors * $SignaturesRequired) + 1;
	$NumberOfAddressesOnDistrict = 0;				

	include $_SERVER["DOCUMENT_ROOT"] . "/headers/headers.php";
?>

<div class="row">
  <div class="main">

		<?php include $_SERVER["DOCUMENT_ROOT"] . "/headers/menu.php"; ?>


			<div class="col-9 float-left">
			
				<div class="Subhead">
			  	<h2 class="Subhead-heading">Summary</h2>
				</div>
	
<?php 
				if ($VerifEmail == true) { 
					include $_SERVER["DOCUMENT_ROOT"] . "/warnings/emailverif.php";
				} else if ($VerifVoter == true) {
					include $_SERVER["DOCUMENT_ROOT"] . "/warnings/voterinfo.php";
				} 
?>         
          
		    <div class="d-flex flex-column flex-md-row mb-3">
		    	<div class="col-12 py-3 px-4 col-md-4 mb-md-0 mb-3 mr-md-3 bg-gray rounded-1">
		        <h4 class="f5 text-normal text-gray"><?= $Party ?>s in the district</h4>
		        <span class="f2 text-bold d-block mt-1 mb-2 pb-1"><?= $NumberOfElectors ?></span>
		    	</div>

		    	<div class="col-md-4 mr-md-3 col-12 py-3 px-4 mb-md-0 mb-3 bg-gray rounded-1">
		      	<h4 class="f5 text-normal text-gray">Required Signatures (Progress)</h4>
		  			<span class="f2 text-bold d-block mt-1 mb-2 pb-1"><?= $NumberOfSignatures ?> (<?= $Progress ?>)</span>
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
 	  
			</DIV>
		</DIV>
	</DIV>
</DIV>

<?php include $_SERVER["DOCUMENT_ROOT"] . "/headers/footer.php";	?>