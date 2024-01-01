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
	$activeccs = NULL;
	
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
	
	preg_match('/^(T)?(\d{4})?(S)?([a-zA-Z]{2})?(D)?(\d{8})?$/', $_GET["k"], $matches, PREG_OFFSET_CAPTURE);	
	$ActiveTeam = (empty($matches[2][0])) ? NULL : $matches[2][0];
	$ActiveState = $matches[4][0];
	$ActiveDate = (empty($matches[6][0])) ? "NOW" : $matches[6][0];

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

	$result = $r->CandidatesForElection($ActiveDate, NULL, $ActiveState, $ActiveTeam);
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

.container_bla {

  display: grid;
  grid-template-columns: repeat(auto-fill, minmax(100px, 1fr));
  font-family: Helvetica;
  font-size: 1.4em;
  color: black;
  text-align: center;
  display: grid;
}

/*
.container_bla div:nth-child(n) {
  background-color: #B8336A;

}
*/

img.imgcandidate {
	height: 150px; 
	max-width: 100%;
}


.container_picture {
  position: relative;
  text-align: center;
  color: white;
}
/* Bottom left text */
.bottom-left {
  position: absolute;
  bottom: 8px;
  left: 16px;
}


img.imglogo {
	height: 50px; 
	max-width: 100%;
	
}

img.nonselected {
  opacity: 0.65;
  filter: alpha(opacity=65); /* msie */
  -webkit-filter: grayscale(1); /* Webkit */
  filter: gray; /* IE6-9 */
  filter: grayscale(1); /* W3C */
}

</style>



<DIV class="main">
	<DIV class="right f80bold">Voter Guide</DIV>
	
	<?php if ( !empty($result[0]["Team_Name"]) && ! empty($ActiveTeam)) { $activeccs = " nonselected"; ?>
		<DIV CLASS="f80">Candidates running as <FONT COLOR="BROWN"><?= $result[0]["Team_Name"] ?></FONT></DIV>
	<?php } ?>
	
  <P>
  			
	<!--Make sure the form has the autocomplete function switched off:-->
	<form autocomplete="off" method="post" action="">
	
	<DIV>
		<A HREF="/reset/voter/guide"><IMG ALT="Reset" id="pir" class="imglogo candidate" SRC="/shared/teams/reset.png"></A>
		<A HREF="/T0024/voter/guide"><IMG ALT="Pirate" id="pir" class="imglogo candidate<?= $ActiveTeam != 24 ? $activeccs : NULL ?>" SRC="/shared/teams/pirates/Pirate.png"></A>
		<A HREF="/T0069/voter/guide"><IMG ALT="International People's Party"  id="ipa" class="imglogo candidate<?= $ActiveTeam != 69 ? $activeccs : NULL ?>" SRC="/shared/teams/ipa/ipa.png"></A>
		<A HREF="/T0025/voter/guide"><IMG ALT="Socialist Alternative"  id="isa" class="imglogo candidate<?= $ActiveTeam != 25 ? $activeccs : NULL ?>" SRC="/shared/teams/socalternative/ISAlternative.png"></A>
		<A HREF="/T0026/voter/guide"><IMG ALT="Communists"  id="com" class="imglogo candidate<?= $ActiveTeam != 26 ? $activeccs : NULL ?>" SRC="/shared/teams/communists/solidnet.png"></A>
		<A HREF="/T0027/voter/guide"><IMG ALT="Progressive International"  id="pri" class="imglogo candidate<?= $ActiveTeam != 27 ? $activeccs : NULL ?>" SRC="/shared/teams/proginternational/ProgInternational.png"></A>
		<A HREF="/T0028/voter/guide"><IMG ALT="Greens"  id="gre" class="candidate imglogo<?= $ActiveTeam != 28 ? $activeccs : NULL ?>" SRC="/shared/teams/greens/Greens.png"></A>
		<A HREF="/T0029/voter/guide"><IMG ALT="Socialists"  id="soc" class="candidate imglogo<?= $ActiveTeam != 29 ? $activeccs : NULL ?>" SRC="/shared/teams/socialists/Socialists.png"></A>
		<A HREF="/T0030/voter/guide"><IMG ALT="Progressive Alliance"  id="pra" class="candidate imglogo<?= $ActiveTeam != 30 ? $activeccs : NULL ?>" SRC="/shared/teams/progalliance/ProgAlliance.png"></A>
		<A HREF="/T0031/voter/guide"><IMG ALT="Liberals"  id="lib" class="candidate imglogo<?= $ActiveTeam != 31 ? $activeccs : NULL ?>" SRC="/shared/teams/liberals/LiberalInternational.png"></A>
		<A HREF="/T0033/voter/guide"><IMG ALT="Christian Democrats"  id="cdu" class="candidate imglogo<?= $ActiveTeam != 33 ? $activeccs : NULL ?>" SRC="/shared/teams/christiansdemocrats/IDC.png"></A>
		<A HREF="/T0035/voter/guide"><IMG ALT="Libertarians"  id="lbt" class="candidate imglogo<?= $ActiveTeam != 35 ? $activeccs : NULL ?>" SRC="/shared/teams/libertarians/Libertarian.png"></A>
		<A HREF="/T0032/voter/guide"><IMG ALT="Democratic Union"  id="idu" class="candidate imglogo<?= $ActiveTeam != 32 ? $activeccs : NULL ?>" SRC="/shared/teams/democrats/IDU.png"></A>
		<A HREF="/T0034/voter/guide"><IMG ALT="Indentity and Democracy"  id="con" class="candidate imglogo<?= $ActiveTeam != 34 ? $activeccs : NULL ?>" SRC="/shared/teams/identity/Conservatives.png"></A>
	</DIV>

	<?php if ( ! empty ($ActiveState)) { ?>
	<P CLASS="f80"><?= $StateName[$ActiveState] ?> Election Dates</P>
	<UL>
		<?php foreach ($SortDates as $var) { 
			$PrintURL = (! empty ($ActiveTeam)) ? "T" . $ActiveTeam : NULL;
			$PrintURL .= (! empty ($ActiveState)) ? "S" . $ActiveState : NULL;
			$PrintURL .= (! empty ($var)) ? "D" . $var : NULL;
			?>		
			
			<LI><P CLASS="f80"><A HREF="/<?= $miduri . $PrintURL ?>/voter/guide"><?= PrintShortDate($var) ?></A></P>
		<?php } ?>
	</UL>
	<?php } ?>

	
	<P CLASS="f60">Enter State</P>
	  <div class="autocomplete" style="width:300px;">
	    <input id="myInput" type="text" name="myCountry" placeholder="State">
	  </div>
	  <input type="submit">
	</P>
	
	
	
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
						$PicturePath = (empty($var["CandidateProfile_PicFileName"]) ? "NoPicture.jpg" : $var["CandidateProfile_PicFileName"]);
						$DetailURL = "/" . $var["CandidateProfile_FirstName"] . $var["CandidateProfile_LastName"] . "_" . $var["CANDPROFID"] . "/voter/detail";		
						?>
						
					<?php	if ($PrevDateDesc != $DateDesc) { $PrintDiv = true; } ?>
					<?php	if ($PrevElectionID != $var["CandidateElection_ID"]) { $PrintDiv = true; } ?>
					<?php if ($PrintDiv == true) { if ($firsttime == false) { echo "</DIV>"; }} ?>
					<?php	if ($PrevDateDesc != $DateDesc) { ?><DIV class="f80bold"><B><?= $DateDesc ?></B></DIV><?php } ?>
					<?php	if ($PrevElectionID != $var["CandidateElection_ID"]) { $PrintDiv = true; ?><DIV class="f80"><B><?= $var["CandidateElection_Text"] ?></B></DIV><?php } ?>
					<?php if ($PrintDiv == true) { echo "<DIV class='container_bla'>"; } ?>

					<DIV CLASS="container_picture">
					<A HREF="<?= $DetailURL ?>"><IMG class="candidate imgcandidate" SRC="/shared/pics/<?= $PicturePath ?>"></A>
					
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