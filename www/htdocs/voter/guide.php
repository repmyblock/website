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
	
	$Statescountries = array (
			"Alabama" => "AL", "Alaska" => "AK", "American Samoa" => "AS", "Arizona" => "AZ", "Arkansas" => "AR", "Austria" => "AT",
			"Belgium" => "BE", "Bulgaria" => "BG", "California" => "CA", "Colorado" => "CO", "Connecticut" => "CT", "Croatia" => "HR",
			"Cyprus" => "CY", "Czech Republic" => "CZ", "Delaware" => "DE", "Denmark" => "DK", "District of Columbia" => "DC", "Estonia" => "EE",
			"Finland" => "FI", "Florida" => "FL", "France" => "FR", "Georgia" => "GA", "Germany" => "GE", "Greece" => "GR", "Guam" => "GU",
			"Hawaii" => "HI", "Hungary" => "HU", "Idaho" => "ID", "Illinois" => "IL", "Indiana" => "IN", "Iowa" => "IA", "Ireland" => "IE", 
			"Italy" => "IT", "Kansas" => "KS", "Kentucky" => "KY", "Latvia" => "LV", "Lithuania" => "LT", "Louisiana" => "LA", "Luxembourg" => "LU",
			"Maine" => "ME", "Malta" => "ML", "Maryland" => "MD", "Massachusetts" => "MA", "Michigan" => "MI", "Minnesota" => "MN", "Mississippi" => "MS",
			"Missouri" => "MO", "Montana" => "MT", "Nebraska" => "NE", "Netherlands" => "NL", "Nevada" => "NV", "New Hampshire" => "NH", "New Jersey" => "NJ",
			"New Mexico" => "NM", "New York" => "NY", "North Carolina" => "NC", "North Dakota" => "ND", "Northern Mariana Islands" => "MP", "Ohio" => "OH",
			"Oklahoma" => "OK", "Oregon" => "OR", "Pennsylvania" => "PA", "Poland" => "PL", "Portugal" => "PT", "Puerto Rico" => "PR", "Rhode Island" => "RI",
			"Romania" => "RO", "Slovakia" => "SK", "Slovenia" => "SI", "South Carolina" => "SC", "South Dakota" => "SD", "Spain" => "ES", "Sweden" => "SE",
			"Tennessee" => "TN", "Texas" => "TX", "U.S. Virgin Islands" => "VI", "Utah" => "UT", "Vermont" => "VT", "Virginia" => "VA", "Washington" => "WA",
			"West Virginia" => "WV", "Wisconsin" => "WI", "Wyoming" => "WY"
	);	
	$activeccs = NULL;
	$addtopics = date("ymd",time());
	
	if (! empty ($_POST)) {
		header("Location: /S" . $Statescountries[$_POST["myCountry"]] . "/voter/guide");
		exit();
	}
	
	require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/common/verif_nolog.php";
	
	if ( $MobileDisplay == true ) { $TypeEmail = "email"; $TypeUsername = "username";
	} else { $TypeEmail = "text"; $TypeUsername = "text"; }
	
	require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/db/db_welcome.php";
	$r = new welcome();	
		
	$ListState = $r->ListElections();	
	WriteStderr($ListState, "List Election");
	
	preg_match('/^(T)?(\d{4})?(S)?([a-zA-Z]{2})?(D)?(\d{8})?(Z)?(\d{5})?$/', $_GET["k"], $matches, PREG_OFFSET_CAPTURE);	
	$ActiveTeam = (empty($matches[2][0])) ? NULL : $matches[2][0];
	$ActiveState = $matches[4][0];
	$ActiveDate = (empty($matches[6][0])) ? NULL : $matches[6][0];
	$ActiveZIP = (empty($matches[8][0])) ? NULL : $matches[8][0];
	
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

	if ( ! empty ($ActiveZIP)) {
		// Get the Table for that zip
		$resultzip = $r->ListDistrictsForZip($ActiveZIP);
		
		foreach ($resultzip as $var) {
			$StateID["state"] = $var["DataState_ID"];
		}
		
		$resultpositions = $r->ListElectionPositions( $StateID["state"]);
		
		foreach ($resultpositions as $var) {
			
			if ( $var["ElectionsPosition_Location"] == "table") {
				if ($var["ElectionsPosition_Location"] == "NYCG") {
				}
			}	
		}
		
		echo "Result Positions:";
		print "<PRE>" . print_r($resultpositions, 1) . "</PRE>";


		echo "Result Zip:";
		print "<PRE>" . print_r($resultzip, 1) . "</PRE>";
		exit(1);
	}
	
	//$result = $r->ListOnElectionsStates();

	$result = $r->CandidatesForElection((empty ($ActiveDate) ? "NOW" : $ActiveDate), NULL, $ActiveState, $ActiveTeam, $ActiveZIP);
	
	// Process the candidates to check the users.
	foreach($result as $var) {
		$ActiveStateWithCandidate[$var["DataState_Abbrev"]] = true;
	}
	
	WriteStderr($result, "Candidate List");
	
	if (empty($result) && ! empty ($ActiveTeam)) {
		$result = $r->GetTeamInfo($ActiveTeam);
	}

	include $_SERVER["DOCUMENT_ROOT"] . "/common/headers.php"; 
?>

<style>
* {
  /* box-sizing: border-box; */
}

/* the container must be positioned relative: */
.autocomplete {position: relative;display: inline-block;}
input {border: 1px solid transparent;background-color: #f1f1f1;padding: 10px;font-size: 16px;}
input[type=text] {background-color: #f1f1f1;width: 100%;}
.autocomplete-items {position: absolute;border: 1px solid #d4d4d4;border-bottom: none;border-top: none;z-index: 99;
  /*position the autocomplete items to be the same width as the container:*/
  top: 100%;left: 0;right: 0;}
.autocomplete-items div {padding: 10px;cursor: pointer;background-color: #fff;border-bottom: 1px solid #d4d4d4;}
/*when hovering an item:*/
.autocomplete-items div:hover {background-color: #e9e9e9;}

/*when navigating through the items using the arrow keys:*/
.autocomplete-active {background-color: DodgerBlue !important;color: #ffffff;}
.container_bla {display: grid;grid-template-columns: repeat(auto-fill, minmax(100px, 1fr));font-family: Helvetica;font-size: 1.4em;color: black;text-align: center;display: grid;}
/*
.container_bla div:nth-child(n) {
  background-color: #B8336A;
}
*/

img.imgcandidate {height: 150px;max-width: 100%;}
.container_picture {position: relative;text-align: center;color: white;}
/* Bottom left text */
.bottom-left {position: absolute;bottom: 8px;left: 16px;}
img.imglogo {height: 50px;max-width: 100%;}
img.nonselected {opacity: 0.65;filter: alpha(opacity=65); /* msie */
  -webkit-filter: grayscale(1); /* Webkit */
  filter: gray; /* IE6-9 */
  filter: grayscale(1); /* W3C */
}

img.flagnonselected {
  opacity: 0.25;
  filter: alpha(opacity=25); /* msie */
  /* -webkit-filter: grayscale(1); /* Webkit */
  /* filter: gray; /* IE6-9 */
  /* filter: grayscale(1); /* W3C */
}

</style>



<DIV class="main">
	<DIV class="right f80bold">Voter Guide<?= (empty (!$StateName[$ActiveState]) ? " for " . $StateName[$ActiveState] : NULL) ?></DIV>
	
	<DIV class="f60"><B>Political Orientation</B></DIV>
	
	<?php if ( !empty($result[0]["Team_Name"]) && ! empty($ActiveTeam)) { $activeccs = " nonselected"; ?>
		<DIV CLASS="f80">Candidates running as <FONT COLOR="BROWN"><?= $result[0]["Team_Name"] ?></FONT></DIV>
	
		<?php 
			switch ($ActiveTeam) {
				case "0024": echo "<P CLASS=\"f50\"><B><A HREF=\"https://pp-international.net/\">Pirate Parties International:</A></B> USA: United States Pirate Party <I><A HREF=\"https://uspirates.org\" TARGET=\"VotGuide\">https://uspirates.org</A></I></P></P>"; break;
				case "0069": echo "<P CLASS=\"f50\"><B><A HREF=\"https://ipa-aip.org\">International People's Party:</A></B> USA: Party for Socialism and Liberation <I><A HREF=\"https://pslweb.org\" TARGET=\"VotGuide\">https://pslweb.org</A></I></P>"; break;
				case "0025": echo "<P CLASS=\"f50\"><B><A HREF=\"https://internationalsocialist.net\">Socialist Alternative:</A></B> USA: Socialist Alternative <I><A HREF=\"https://socialistalternative.org\" TARGET=\"VotGuide\">https://socialistalternative.org</A></I></P>"; break;
				case "0026": echo "<P CLASS=\"f50\"><B><A HREF=\"http://www.solidnet.org\">Communists:</A></B> USA: Communist Party USA <I><A HREF=\"https://www.cpusa.org\" TARGET=\"VotGuide\">https://www.cpusa.org</A></I></P>"; break;
				case "0027": echo "<P CLASS=\"f50\"><B><A HREF=\"https://progressive.international\">Progressive International:</A></B> USA: Democrat Socialists of America <I><A HREF=\"https://www.dsausa.org\" TARGET=\"VotGuide\">https://www.dsausa.org</A></I></P>"; break;
				case "0028": echo "<P CLASS=\"f50\"><B><A HREF=\"https://globalgreens.org\">Global Greens:</A></B> USA: Green Party US <I><A HREF=\"https://www.gp.org\" TARGET=\"VotGuide\">https://www.gp.org</A></I></P>"; break;
				case "0029": echo "<P CLASS=\"f50\"><B><A HREF=\"https://www.socialistinternational.org\">Social democrats and Socialists:</A></B> USA: Social Democrats of America <I><A HREF=\"https://socialists.us\" TARGET=\"VotGuide\">https://socialists.us</A></I></P>"; break;
				case "0030": echo "<P CLASS=\"f50\"><B><A HREF=\"https://progressive-alliance.info\">Progressive Alliance:</A></B> USA: Progressive Democrats of America <I><A HREF=\"https://pdamerica.org\" TARGET=\"VotGuide\">https://pdamerica.org</A></I></P>"; break;
				case "0031": echo "<P CLASS=\"f50\"><B><A HREF=\"https://liberal-international.org\">Liberals:</A></B> USA: Center for New Liberalism <I><A HREF=\"https://cnliberalism.org\" TARGET=\"VotGuide\">https://cnliberalism.org</A></I></P>"; break;
				case "0033": echo "<P CLASS=\"f50\"><B><A HREF=\"https://idc-cdi.com\">Christian Democrats:</A></B> USA: Frederick Douglass Foundation <I><A HREF=\"https://fdfnational.org\" TARGET=\"VotGuide\">https://fdfnational.org</A></I></P>"; break;
				case "0035": echo "<P CLASS=\"f50\"><B><A HREF=\"https://ialp.com\">Libertarians:</A></B> USA: Libertarian <I><A HREF=\"https://www.lp.org\" TARGET=\"VotGuide\">https://www.lp.org</A></I></P>"; break;
				case "0032": echo "<P CLASS=\"f50\"><B><A HREF=\"https://www.idu.org\">Democrat Union:</A></B> USA: Republican National Committee <I><A HREF=\"https://gop.com\" TARGET=\"VotGuide\">https://gop.com</A></I></P>"; break;
				case "0034": echo "<P CLASS=\"f50\"><B><A HREF=\"https://www.idgroup.eu\" TARGET=\"VotGuide\">Democrat Union:</A></B> USA: Conservative Party USA <I><A HREF=\"https://conservativepartyusa.org\" TARGET=\"VotGuide\">https://conservativepartyusa.org</A></I></P>"; break;
		} ?>
		
		
	<?php } 
		// Special build for the team
		$BuildURLEnd = (! empty ($ActiveState)) ? "S" . $ActiveState : NULL;
		// $BuildURLEnd .= (! empty ($ActiveDate)) ? "D" . $ActiveDate : NULL;		
		$BuildURLEnd .= (! empty ($ActiveZIP)) ? "Z" . $ActiveZIP : NULL;		
		$BuildURLEnd = (empty($BuildURLEnd) && empty ($ActiveTeam)) ? "rset" : $BuildURLEnd;
		
	?>
	
  <P>
  			
	<!--Make sure the form has the autocomplete function switched off:-->
	<form autocomplete="off" method="post" action="">
	
	<DIV>
		<A HREF="/<?= ($ActiveTeam != 24 ? "T0024" : NULL) . $BuildURLEnd ?>/voter/guide"><IMG ALT="Pirate" id="pir" class="imglogo candidate<?= $ActiveTeam != 24 ? $activeccs : NULL ?>" SRC="/shared/teams/pirates/Pirate.png"></A>
		<A HREF="/<?= ($ActiveTeam != 69 ? "T0069" : NULL) . $BuildURLEnd ?>/voter/guide"><IMG ALT="International People's Party"  id="ipa" class="imglogo candidate<?= $ActiveTeam != 69 ? $activeccs : NULL ?>" SRC="/shared/teams/ipa/ipa.png"></A>
		<A HREF="/<?= ($ActiveTeam != 25 ? "T0025" : NULL) . $BuildURLEnd ?>/voter/guide"><IMG ALT="Socialist Alternative"  id="isa" class="imglogo candidate<?= $ActiveTeam != 25 ? $activeccs : NULL ?>" SRC="/shared/teams/socalternative/ISAlternative.png"></A>
		<A HREF="/<?= ($ActiveTeam != 26 ? "T0026" : NULL) . $BuildURLEnd ?>/voter/guide"><IMG ALT="Communists"  id="com" class="imglogo candidate<?= $ActiveTeam != 26 ? $activeccs : NULL ?>" SRC="/shared/teams/communists/solidnet.png"></A>
		<A HREF="/<?= ($ActiveTeam != 27 ? "T0027" : NULL) . $BuildURLEnd ?>/voter/guide"><IMG ALT="Progressive International"  id="pri" class="imglogo candidate<?= $ActiveTeam != 27 ? $activeccs : NULL ?>" SRC="/shared/teams/proginternational/ProgInternational.png"></A>
		<A HREF="/<?= ($ActiveTeam != 28 ? "T0028" : NULL) . $BuildURLEnd ?>/voter/guide"><IMG ALT="Greens"  id="gre" class="candidate imglogo<?= $ActiveTeam != 28 ? $activeccs : NULL ?>" SRC="/shared/teams/greens/Greens.png"></A>
		<A HREF="/<?= ($ActiveTeam != 29 ? "T0029" : NULL) . $BuildURLEnd ?>/voter/guide"><IMG ALT="Socialists"  id="soc" class="candidate imglogo<?= $ActiveTeam != 29 ? $activeccs : NULL ?>" SRC="/shared/teams/socialists/Socialists.png"></A>
		<A HREF="/<?= ($ActiveTeam != 30 ? "T0030" : NULL) . $BuildURLEnd ?>/voter/guide"><IMG ALT="Progressive Alliance"  id="pra" class="candidate imglogo<?= $ActiveTeam != 30 ? $activeccs : NULL ?>" SRC="/shared/teams/progalliance/ProgAlliance.png"></A>
		<A HREF="/<?= ($ActiveTeam != 31 ? "T0031" : NULL) . $BuildURLEnd ?>/voter/guide"><IMG ALT="Liberals"  id="lib" class="candidate imglogo<?= $ActiveTeam != 31 ? $activeccs : NULL ?>" SRC="/shared/teams/liberals/LiberalInternational.png"></A>
		<A HREF="/<?= ($ActiveTeam != 33 ? "T0033" : NULL) . $BuildURLEnd ?>/voter/guide"><IMG ALT="Christian Democrats"  id="cdu" class="candidate imglogo<?= $ActiveTeam != 33 ? $activeccs : NULL ?>" SRC="/shared/teams/christiansdemocrats/IDC.png"></A>
		<A HREF="/<?= ($ActiveTeam != 35 ? "T0035" : NULL) . $BuildURLEnd ?>/voter/guide"><IMG ALT="Libertarians"  id="lbt" class="candidate imglogo<?= $ActiveTeam != 35 ? $activeccs : NULL ?>" SRC="/shared/teams/libertarians/Libertarian.png"></A>
		<A HREF="/<?= ($ActiveTeam != 32 ? "T0032" : NULL) . $BuildURLEnd ?>/voter/guide"><IMG ALT="Democratic Union"  id="idu" class="candidate imglogo<?= $ActiveTeam != 32 ? $activeccs : NULL ?>" SRC="/shared/teams/democrats/IDU.png"></A>
		<A HREF="/<?= ($ActiveTeam != 34 ? "T0034" : NULL) . $BuildURLEnd ?>/voter/guide"><IMG ALT="Indentity and Democracy"  id="con" class="candidate imglogo<?= $ActiveTeam != 34 ? $activeccs : NULL ?>" SRC="/shared/teams/identity/Conservatives.png"></A>
	</DIV>
	
	<DIV class="f60"><B>State</B></DIV>
	<P>
	<DIV>
		<?php
			// Special build for the Team
			$BuildURLBeg = (! empty ($ActiveTeam)) ? "T" . $ActiveTeam : NULL;		
			$BuildURLEnd = (! empty ($ActiveDate)) ? "D" . $ActiveDate : NULL;		
			$BuildURLEnd .= (! empty ($ActiveZIP)) ? "Z" . $ActiveZIP : NULL;		

			$activeccs = NULL; 
			foreach ($Statescountries as $CountryName => $CountryFlag) { 
				if ( ! empty($ActiveState)) { $activeccs = " flagnonselected"; }
				$activeccs = $ActiveStateWithCandidate[$CountryFlag] ? NULL : " flagnonselected";
			
			?><A HREF="/<?= $BuildURLBeg . (($ActiveState != $CountryFlag) ? "S" . $CountryFlag : "rset") . $BuildURLEnd ?>/voter/guide" ALT="<?= $CountryName ?>"><IMG SRC="/images/flags/<?= $CountryFlag ?>.png" class="candidate<?= $ActiveState != $CountryFlag ? $activeccs : NULL ?>"></A> <?php 
		} ?>
	</DIV>
</P>

	<?php if ( ! empty ($ActiveState)) { ?>
	
	<P CLASS="f60"><B>Election Dates</B></P>
		<P CLASS="f50">
		<?php foreach ($SortDates as $var) { 
			$PrintURL = (! empty ($ActiveTeam)) ? "T" . $ActiveTeam : NULL;
			$PrintURL .= (! empty ($ActiveState)) ? "S" . $ActiveState : NULL;
			$PrintURL .= (! empty ($var)) ? "D" . $var : NULL;
			?><A HREF="/<?= $miduri . $PrintURL ?>/voter/guide"><?= PrintShortDate($var) ?></A> - 
		<?php } ?>
	</UL>
	
	<?php } ?>

	<?php /*
	<p>
	  <div class="autocomplete" style="width:300px;">
	    <input id="myInput" type="text" name="myCountry" placeholder="Candidate's Name">
	  </div>
	  <input type="submit">
	</P>
	
	*/ ?>
	
  <?php /* <P CLASS="f60">Zipcode<BR><input id="myInput" type="text" name="ZipCode" placeholder="Zipcode" SIZE=5></P> */ ?>
  
  <script>
		var countries = [<?= $ListOfStates ?>];
	</script>
	<script src="/js/autocomplete.js"></script>
	


 	<DIV class="panels">
		
		<?php
			
			$firsttime = true;
			
			if (! empty ($result)) {
				foreach($result as $var) {
					WriteStderr($var, "Voter Guide");
										
					if ( ! empty ($var["CandidateProfile_ID"]) && $var["CandidateProfile_NotOnBallot"] != 'yes' &&  $var["CandidateProfile_PublishProfile"] != 'no' ) {
						$DateDesc = PrintShortDate($var["Elections_Date"]) . " - " . $var["Elections_Text"];
						$PicturePath = "/shared/pics/" . 
															((empty($var["CandidateProfile_PicFileName"])) ? 
															((empty($var["Candidate_Party"]) || $var["Candidate_Party"] == "BLK") ? 
																"0000/NoPicture.jpg" : 														
																"0000/" . $var["DataState_Abbrev"] . "/" . $var["Candidate_Party"] . "_NoPic.jpg") : 
																($var["CandidateProfile_PicFileName"] . "?" . $addtopics));
						$DetailURL = "/" . $var["CandidateProfile_FirstName"] . $var["CandidateProfile_LastName"] . "_" . $var["CANDPROFID"] . "/voter/detail";		
						
						?>
						
					<?php	if ($PrevDateDesc != $DateDesc) { $PrintDiv = true; } ?>
					<?php	if ($PrevElectionID != $var["CandidateElection_ID"]) { $PrintDiv = true; } ?>
					<?php if ($PrintDiv == true) { if ($firsttime == false) { echo "</DIV>"; }} ?>
					<?php	if ($PrevDateDesc != $DateDesc) { ?><DIV class="f80bold"><B><?= $DateDesc ?></B></DIV><?php } ?>
					<?php	if ($PrevElectionID != $var["CandidateElection_ID"]) { $PrintDiv = true; ?><DIV class="f80"><B><?= $var["CandidateElection_Text"] ?></B></DIV><?php } ?>
					<?php if ($PrintDiv == true) { echo "<DIV class='container_bla'>"; } ?>

					<DIV CLASS="container_picture">
					<A HREF="<?= $DetailURL ?>"><IMG class="candidate imgcandidate" SRC="<?= $PicturePath ?>"></A>
					
				  <div class="centered p40"><?=  $var["CandidateProfile_Alias"] ?></div>
						
					</DIV>
				
					<?php
				
						$PrevDateDesc = $DateDesc;
						$PrevElectionID = $var["CandidateElection_ID"];
						$firsttime = false;
						$PrintDiv = false;
				}
			}
		}
		
		if ($firsttime == true) { ?>
			<H2>The guide is empty at this time.</H2>
		<?php } ?>
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