<?php
	$HeaderTwitter = "yes";
	$HeaderTwitterTitle = "Rep My Block - Rep My Block";
	$HeaderTwitterPicLink = "https://static.repmyblock.org/pics/paste/RepMyBlockVoterGuide.jpg";
	$HeaderTwitterDesc = "Rep My Block Voter Guide, the only voter guide that don't restrict the candidate.";
	$HeaderOGTitle = "Rep My Block Voter Guide.";
	$HeaderOGDescription = "Rep My Block Voter Guide, the only voter guide that don't restrict the candidate.";
	$HeaderOGImage = "https://static.repmyblock.org/pics/paste/RepMyBlockVoterGuide.jpg"; 
	$HeaderOGImageWidth = "941";
	$HeaderOGImageHeight = "477";
	
	$Statescountries = array ("Alaska" => "AK", "Alaska" => "AK", "Alabama" => "AL", "Alabama" => "AL", "Arkansas" => "AR", "Arkansas" => "AR", "American Samoa" => "AS", "American Samoa" => "AS", "American Samoa" => "AS", "Arizona" => "AZ", "Arizona" => "AZ", "Arizona" => "AZ", "California" => "CA", "California" => "CA", "Colorado" => "CO", "Colorado" => "CO", "Colorado" => "CO", "Connecticut" => "CT", "Connecticut" => "CT", "District of Columbia" => "DC", "Delaware" => "DE", "Delaware" => "DE", "Florida" => "FL", "Florida" => "FL", "Georgia" => "GA", "Georgia" => "GA", "Guam" => "GU", "Guam" => "GU", "Hawaii" => "HI", "Hawaii" => "HI", "Iowa" => "IA", "Iowa" => "IA", "Idaho" => "ID", "Idaho" => "ID", "Idaho" => "ID", "Idaho" => "ID", "Illinois" => "IL", "Illinois" => "IL", "Indiana" => "IN", "Indiana" => "IN", "Kansas" => "KS", "Kansas" => "KS", "Kentucky" => "KY", "Kentucky" => "KY", "Louisiana" => "LA", "Louisiana" => "LA", "Massachusetts" => "MA", "Massachusetts" => "MA", "Maryland" => "MD", "Maryland" => "MD", "Maine" => "ME", "Maine" => "ME", "Michigan" => "MI", "Michigan" => "MI", "Minnesota" => "MN", "Minnesota" => "MN", "Missouri" => "MO", "Missouri" => "MO", "Northern Mariana Islands" => "MP", "Northern Mariana Islands" => "MP", "Mississippi" => "MS", "Mississippi" => "MS", "Mississippi" => "MS", "Montana" => "MT", "Montana" => "MT", "North Carolina" => "NC", "North Carolina" => "NC", "North Dakota" => "ND", "North Dakota" => "ND", "North Dakota" => "ND", "Nebraska" => "NE", "Nebraska" => "NE", "New Hampshire" => "NH", "New Hampshire" => "NH", "New Jersey" => "NJ", "New Jersey" => "NJ", "New Mexico" => "NM", "New Mexico" => "NM", "New Mexico" => "NM", "New Mexico" => "NM", "Nevada" => "NV", "Nevada" => "NV", "New York" => "NY", "New York" => "NY", "New York" => "NY", "New York" => "NY", "Ohio" => "OH", "Ohio" => "OH", "Oklahoma" => "OK", "Oklahoma" => "OK", "Oregon" => "OR", "Oregon" => "OR", "Pennsylvania" => "PA", "Pennsylvania" => "PA", "Puerto Rico" => "PR", "Puerto Rico" => "PR", "Puerto Rico" => "PR", "Rhode Island" => "RI", "Rhode Island" => "RI", "Rhode Island" => "RI", "South Carolina" => "SC", "South Carolina" => "SC", "South Carolina" => "SC", "South Dakota" => "SD", "South Dakota" => "SD", "Tennessee" => "TN", "Tennessee" => "TN", "Tennessee" => "TN", "Texas" => "TX", "Texas" => "TX", "Utah" => "UT", "Utah" => "UT", "Virginia" => "VA", "Virginia" => "VA", "Vermont" => "VT", "Vermont" => "VT", "Washington" => "WA", "Washington" => "WA", "Wisconsin" => "WI", "Wisconsin" => "WI", "West Virginia" => "WV", "West Virginia" => "WV", "Wyoming" => "WY", "Wyoming" => "WY");	

	if (! empty ($_POST)) {
		header("Location: /S" . $Statescountries[$_POST["myCountry"]] . "/voter/guide");
		exit();
	}
	
	require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/common/verif_nolog.php";
	
	if ( $MobileDisplay == true ) { $TypeEmail = "email"; $TypeUsername = "username";
	} else { $TypeEmail = "text"; $TypeUsername = "text"; }
	
	require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/db/db_welcome.php";
	$r = new welcome(0);	
		
	$ListState = $r->ListElections();	
	WriteStderr($ListState, "List Election");
	
	preg_match('/^S([a-zA-Z]{2})D?(\d{8})?$/', $_GET["k"], $matches, PREG_OFFSET_CAPTURE);	
	$ActiveState = $matches[1][0];
	$ActiveDate = $matches[2][0];
		
	foreach ($ListState as $var) { 
		$StateName[$var["DataState_Abbrev"]] = $var["DataState_Name"];
		$StatesDates[$var["DataState_Name"]][$var["Elections_Date"]] = true;
 	}
	foreach ($StatesDates[$StateName[$ActiveState]] as $key => $val) { $SortDates[] = preg_replace('/-/', '', $key); }
	sort($SortDates);
	
	$ListOfStates = "\"";
	foreach ($StatesDates as $var => $index) { 
		$ListOfStates .= $commas . $var; $commas = "\", \"";			
	}
	$ListOfStates .= "\"";
	
	WriteStderr($ListOfStates, "List Election");
	WriteStderr($Dates, "Dates");
	WriteStderr($StatesDates, "States Dates");

	$result = $r->CandidatesForElection($ActiveDate, NULL, $ActiveState);
	WriteStderr($result, "Candidate List");
	
	include $_SERVER["DOCUMENT_ROOT"] . "/common/headers.php"; 
?>

<DIV class="main">
	<DIV class="right f80bold">Voter Guide</DIV>
	

<P>

<!--Make sure the form has the autocomplete function switched off:-->
<form autocomplete="off" method="post" action="">
	
	<P CLASS="f60">Enter State</P>
	  <div class="autocomplete" style="width:300px;">
	    <input id="myInput" type="text" name="myCountry" placeholder="State">
	  </div>
	  <input type="submit">
	</P>

	<P CLASS="f80"><?= $StateName[$ActiveState] ?> Election Dates</P>
		
	<UL>
		<?php foreach ($SortDates as $var) { ?>		
			<LI><P CLASS="f80"><A HREF="/<?= $miduri ?>S<?= $ActiveState ?>D<?= $var ?>/voter/guide"><?= PrintShortDate($var) ?></A></P>
		<?php } ?>
	</UL>
	
	 <div style="width:300px;">
    <P CLASS="f60">Zipcode<BR><input id="myInput" type="text" name="ZipCode" placeholder="Zipcode" SIZE=5></P>
  </div>
  <script>
		var countries = [<?= $ListOfStates ?>];
	</script>
	<script src="/js/autocomplete.js"></script>
	
<style>
* {
  box-sizing: border-box;
}

body {
  font: 16px Arial;  
}

/*the container must be positioned relative:*/
.autocomplete {
  position: relative;
  display: inline-block;
}

input {
  border: 1px solid transparent;
  background-color: #f1f1f1;
  padding: 10px;
  font-size: 16px;
}

input[type=text] {
  background-color: #f1f1f1;
  width: 100%;
}

.autocomplete-items {
  position: absolute;
  border: 1px solid #d4d4d4;
  border-bottom: none;
  border-top: none;
  z-index: 99;
  /*position the autocomplete items to be the same width as the container:*/
  top: 100%;
  left: 0;
  right: 0;
}

.autocomplete-items div {
  padding: 10px;
  cursor: pointer;
  background-color: #fff; 
  border-bottom: 1px solid #d4d4d4; 
}

/*when hovering an item:*/
.autocomplete-items div:hover {
  background-color: #e9e9e9; 
}

/*when navigating through the items using the arrow keys:*/
.autocomplete-active {
  background-color: DodgerBlue !important; 
  color: #ffffff; 
}
</style>

 	<DIV class="panels">
	<P>
		<?php
			if (! empty ($result)) {
				foreach($result as $var) {
					
					WriteStderr($var, "Voter Guide");
					if ( ! empty ($var)) {
						print "<br style=\"clear:both\" />";
						$DateDesc = PrintShortDate($var["Elections_Date"]) . " - " . $var["Elections_Text"];
						if ($DateDesc != $PrevDateDesc) { 
							print "<DIV class=\"f60\"><B>" . $DateDesc . "</B></DIV>";
						}
						$PrevDateDesc = $DateDesc;
						$PicturePath = (empty($var["CandidateProfile_PicFileName"]) ? "NoPicture.jpg" : $var["CandidateProfile_PicFileName"]);
						// if ( $var["CandidateProfile_PublishProfile"] != 'no' || $var["CandidateProfile_PublishPetition"] != 'no') {
		?>

		<DIV>
			<P>
				<DIV class="f60"><B><?= $var["CandidateProfile_Alias"] ?></B></DIV>
			</P>

			<DIV class='container2'>
				<DIV>
					<?php $DetailURL = "/" . $var["CandidateProfile_FirstName"] . $var["CandidateProfile_LastName"] . "_" . $var["CANDPROFID"] . "/voter/detail"; ?>
					<A HREF="<?= $DetailURL ?>"><IMG style="float: left; margin: 0px 15px 0px 15px;"  class="candidate" SRC="<?= $FrontEndStatic ?>/shared/pics/<?= $PicturePath ?>" class='iconDetails'></A>
						<P class="f40" style="text-margin: 0px 0px 0px 0px;">
							<I>Running for <?= $var["CandidateElection_PetitionText"] ?></I>
							<?php if (! empty ($var["CandidateProfile_Statement"])) { print $var["CandidateProfile_Statement"]; }  ?>
						</P>
				</DIV>

				<BR style="clear:both">

				<DIV class='container3'>
					<P class="f40">
						<?php if (! empty ($var["CandidateProfile_Website"])) { ?><B>Website:</B> <A TARGET="NEW" HREF="<?= $var["CandidateProfile_Website"] ?>"><?= $var["CandidateProfile_Website"] ?></A> -<?php } ?> 
					  <?php if (! empty ($var["CandidateProfile_BallotPedia"])) { ?><A TARGET="NEW" HREF="<?= $var["CandidateProfile_BallotPedia"] ?>">Ballotpedia</A><?php } ?><BR>
			      <?php if (! empty ($var["CandidateProfile_Email"])) { ?><B>Email:</B> <A TARGET="NEW" HREF="mailto:<?= $var["CandidateProfile_Email"] ?>"><?= $var["CandidateProfile_Email"] ?></A><?php } ?>
			      <?php if (! empty ($var["CandidateProfile_PhoneNumber"])) { print "- <B>Telephone:</B> " . $var["CandidateProfile_PhoneNumber"]; } ?><BR>
			      
			      <?php if (! empty ($var["CandidateProfile_Twitter"])) { ?>Twitter: <A TARGET="NEW" HREF="https://twitter.com/<?= $var["CandidateProfile_Twitter"] ?>">@<?= $var["CandidateProfile_Twitter"] ?></A> -<?php } ?> 
			     	<?php if (! empty ($var["CandidateProfile_Facebook"])) { ?>Facebook: <A TARGET="NEW" HREF="https://facebook.com/<?= $var["CandidateProfile_Facebook"] ?>"><?= $var["CandidateProfile_Facebook"] ?></A> -<?php } ?> 
			      <?php if (! empty ($var["CandidateProfile_Instagram"])) { ?>Instagram: <A TARGET="NEW" HREF="https://instagram.com/<?= $var["CandidateProfile_Instagram"] ?>">@<?= $var["CandidateProfile_Instagram"] ?></A> -<?php } ?> 
			      <?php if (! empty ($var["CandidateProfile_TikTok"])) { print $var["CandidateProfile_TikTok"] . " - "; } ?> 
			      <?php if (! empty ($var["CandidateProfile_YouTube"])) { print $var["CandidateProfile_YouTube"] . " - "; }  ?>
			      <?php if (! empty ($var["CandidateProfile_FaxNumber"])) { print $var["CandidateProfile_FaxNumber"]; }  ?><BR>
		      </P>

					<?php if ( ! empty ($var["CandidateProfile_PDFFileName"])) { ?>						
						<P class="f40"><A TARGET="PDFCandidate" HREF="<?= $FrontEndStatic ?>/shared/platforms/<?= $var["CandidateProfile_PDFFileName"] ?>">Download <?= $var["CandidateProfile_Alias"] ?>'s Platform</A></P>
					<?php } ?>
					
					
					<?php if ( empty ($var["SystemUser_ID"])) { ?>
						<A HREF="/<?= $var["CANDPROFID"] ?>/voter/claim">Claim this profile</A>
					<?php } ?>
					
				</DIV>
			</DIV>
		</DIV>
	</P>

	<?php
				}
			}
		} else { ?>
		<H2>The guide is empty at this time.</H2>
	<?php } ?>
	</P>
</DIV>

<br style="clear:both">

<P>
	<DIV class="right f60">	
		<A HREF="<?= PrintReferer() ?>">Return to previous menu</A></B>
	</DIV>
</P>

<P>
	<DIV class="right f80">Notice to voters and candidates</DIV>
	
	<P>
		If you are a voter and would like to receive an update on the election in your 
		district, you can <A HREF="/<?= $middleuri ?>/exp/register/register">register</A>, 
		and we'll email you with the latest voter guide before the election.
	</P>
	
	<P>
		We do not sell your information to any candidate, and we don't track you as per 
		our <A HREF="/<?= $middleuri ?>/policies/privacy">Privacy Policy</A>.
	</P>
	
	<P>
		Any candidate can update the voter guide by updating their information by
		<A HREF="/<?= $middleuri ?>/exp/register/register">registering</A>. 
	</P>

	<DIV class="right f60">	
		<A HREF="<?= PrintReferer() ?>">Return to previous menu</A></B>
	</DIV>
		
</P>

</DIV>
</DIV>
</FORM>

		
<?php include $_SERVER["DOCUMENT_ROOT"] . "/common/footer.php"; ?>