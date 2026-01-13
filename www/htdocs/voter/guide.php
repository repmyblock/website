<?php
	$HeaderTwitter = "yes";
	$HeaderTwitterTitle = "Rep My Block - Universal Voter Guide";
	$HeaderTwitterPicLink = "https://static.repmyblock.org/pics/paste/UniversalVoterGuide.jpg";
	$HeaderTwitterDesc = "Rep My Block Voter Guide, the only voter guide that don't restrict the candidate.";
	$HeaderOGTitle = "Rep My Block Voter Guide.";
	$HeaderOGDescription = "Rep My Block Voter Guide, the only voter guide that don't restrict the candidate.";
	$HeaderOGImage = "https://static.repmyblock.org/pics/paste/UniversalVoterGuide.jpg"; 
	$HeaderOGImageWidth = "921";
	$HeaderOGImageHeight = "477";
	
	$Statescountries = array (
			"Alabama" => "AL", "Alaska" => "AK", "American Samoa" => "AS", "Arizona" => "AZ", "Arkansas" => "AR", "Austria" => "AT",
			"Belgium" => "BE", "Bulgaria" => "BG", "California" => "CA", "Colorado" => "CO", "Connecticut" => "CT", "Croatia" => "HR",
			"Cyprus" => "CY", "Czech Republic" => "CZ", "Delaware" => "DE", "Denmark" => "DK", "District of Columbia" => "DC", 
			"Dominican Republic" => "DO", "Estonia" => "EE",
			"Finland" => "FI", "Florida" => "FL", "France" => "FR", "Georgia" => "GA", "Germany" => "GE", "Greece" => "GR", "Guam" => "GU",
			"Haiti" => "HT", "Hawaii" => "HI", "Hungary" => "HU", "Idaho" => "ID", "Illinois" => "IL", "Indiana" => "IN", "Iowa" => "IA", "Ireland" => "IE", 
			"Italy" => "IT", "Kansas" => "KS", "Kentucky" => "KY", "Latvia" => "LV", "Lithuania" => "LT", "Louisiana" => "LA", 
			"Luxembourg" => "LU",
			"Maine" => "ME", "Malta" => "ML", "Maryland" => "MD", "Massachusetts" => "MA", "Mexico" => "MX", "Michigan" => "MI", "Minnesota" => "MN", 
			"Mississippi" => "MS",
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
		header("Location: /Z" . $_POST["zipcode"] . "/voter/guide");
		exit();
	}
	
	require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/common/verif_nolog.php";
	
	if ( $MobileDisplay == true ) { $TypeEmail = "email"; $TypeUsername = "username";
	} else { $TypeEmail = "text"; $TypeUsername = "text"; }
	
	require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/db/db_welcome.php";
	$r = new welcome(0);	
		
	$ListState = $r->ListElections();	
	WriteStderr($ListState, "List Election");
	
	preg_match('/^(T)?(\d{4}|[a-zA-Z]{3})?(S)?([a-zA-Z]{2})?(D)?(\d{8})?(Z)?(\d{5})?$/', $_GET["k"], $matches, PREG_OFFSET_CAPTURE);	
	$ActiveTeam = (empty($matches[2][0])) ? NULL : $matches[2][0];
	$ActiveState = $matches[4][0];
	$ActiveDate = (empty($matches[6][0])) ? NULL : $matches[6][0];
	$ActiveZIP = (empty($matches[8][0])) ? NULL : $matches[8][0];

	if (strlen($matches[2][0]) == 3) {
		$MyTCode = strtolower($matches[2][0]);
		switch ($MyTCode) {
			case 'pir': $newid = "T0024"; break;
			case 'ipa': $newid = "T0069"; break;	
			case 'isa': $newid = "T0025"; break;
			case 'com': $newid = "T0026"; break;
			case 'pri': $newid = "T0027"; break;
			case 'gre': $newid = "T0028"; break;
			case 'soc': $newid = "T0029"; break;
			case 'pra': $newid = "T0030"; break;
			case 'lib': $newid = "T0031"; break;
			case 'cdu': $newid = "T0033"; break;
			case 'lbt': $newid = "T0035"; break;
			case 'idu': $newid = "T0032"; break;
			case 'con': $newid = "T0034"; break;
		}
		if (! empty ($newid)) {
			header("Location: /" . $newid . "/voter/guide");
			exit();		
		}
	}
	
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
		$resultzip = $r->ListDistrictsAndTablesForZip($ActiveZIP);
		
		foreach ($resultzip as $var) {
			$StateID["state"] = $var["DataState_ID"];
			$StateID["statename"] = $var["DataState_Abbrev"];
		}
		
		$resultpositions = $r->ListElectionPositions( $StateID["state"]);	
		$result = $r->CandidatesForElection((empty ($ActiveDate) ? "NOW" : $ActiveDate), NULL, $StateID["statename"], $ActiveTeam, NULL);
		
		foreach ($resultpositions as $var) {		
			switch ($var["ElectionsPosition_Location"]) {
				case "table":
					
					// echo "<PRE>" . print_r($resultzip,1) . "</PRE>";
					WriteStderr($resultzip, "Result Zip");
					
					foreach ($resultzip as $vor) { // This is to check the type of geographical location								
						$ADEDValue = $vor["DataDistrict_StateAssembly"]  . str_pad($vor["DataDistrict_Electoral"], 3, "0", STR_PAD_LEFT);
						foreach($result as $vir) {  // Does the candidate fall into the geographical area?
							if ( $vir[$vor["ElectionsPosition_DBTableName"]] == "ADED" && $vir["CANDVALUE"] == $ADEDValue) {
								$ListCandidate[$vir["Elections_Date"]][$vir["CANDPROFID"]] = $vir;
							}
						}
					}
					
				break;
				
				case "partycall":
					foreach ($resultzip as $vor) { // This is to check the type of geographical location				
						foreach($result as $vir) {  // Does the candidate fall into the geographical area?
							if ( $vir["CANDDTABLE"] == $vor["ElectionsPosition_DBTable"] && $vir["CANDVALUE"] == $vor["ElectionsPartyCall_ConversionValue"]) {
								$ListCandidate[$vir["Elections_Date"]][$vir["CANDPROFID"]] = $vir;
							}
						}
					}
					
				break;
				
				case "state":
				
					foreach($result as $vor) {
						if ( $var["ElectionsPosition_DBTable"] == $vor["CANDDTABLE"]) {
							$ListCandidate[$vor["Elections_Date"]][$vor["CANDPROFID"]] = $vor;	
						}
					}
				break;
			}
		}
		
		ksort($ListCandidate);
		$result = array();
		if (! empty ($ListCandidate)) {
			foreach ($ListCandidate as $var => $index) {
				foreach ($index as $vor => $newindex) {
					$result[] = $newindex;
				}
			}
		}
		
		#print "<PRE>" . print_r($result,1) . "</PRE>";
		
	} else {
		foreach($result as $var) {
			$ActiveStateWithCandidate[$var["DataState_Abbrev"]] = true;
		}
		
		$result = $r->CandidatesForElection((empty ($ActiveDate) ? "NOW" : $ActiveDate), NULL, $ActiveState, $ActiveTeam, $ActiveZIP);
		WriteStderr($result, "Candidate List");
	}
	
	foreach($result as $var) {
		$ActiveStateWithCandidate[$var["DataState_Abbrev"]] = true;
	}
	
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

img.imgcandidate {
  width: 200px;
  height: 300px;
  object-fit: cover;
  flex-shrink: 0;
}



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




.flag {
  height: 24px;
  width: auto;
  display: inline-block;
  vertical-align: middle;
}

.flag-link:hover .flag {
  transform: scale(1.15);
}



</style>

<form autocomplete="off" method="post" action="">
	
<DIV class="main">

<STYLE>

.election-batch {
  margin-bottom: 40px;
}

/* Frame */
.candidate-card.frame {
  position: relative;
  display: inline-block;

  padding: 6px;
  background: #fff;
  border-radius: 6px;

  overflow: hidden; /* 🔑 THIS CLIPS THE RIBBON */

  box-shadow:
    0 4px 10px rgba(0,0,0,.18),
    0 1px 3px rgba(0,0,0,.12);
}

/* Image */
.imgcandidate {
  display: block;
  width: 100%;
  height: auto;
  border-radius: 4px;
}

/* Ribbon */
.ribbon {
  position: absolute;
  top: 5px;
 	left: -80px;    /* mostly inside */
   width: 200px;
  padding: 6px 0;

  font-size: 11px;
  font-weight: 700;
  line-height: 1.05;
  text-align: center;
  color: #fff;

  transform: rotate(-45deg);
  z-index: 2;
}

/* Party color */
.ribbon.dem {background: linear-gradient(135deg, #f7a8b8, #e35d6a);}
.ribbon.rep {background: linear-gradient(135deg, #00AEEF, #6fd3ff);}
.ribbon.gre {background: linear-gradient(135deg, #6fdc9c, #00A651);}
.ribbon.con {background: linear-gradient(135deg, #3a2416, #1f120a);}
.ribbon.lib {background: linear-gradient(135deg, #f9a03f, #d97706);}
.ribbon.wfp {background: linear-gradient(135deg, #6b2f85, #3f1a52);}
.ribbon.com {background: linear-gradient(135deg, #a32020, #5a0f0f);}
.ribbon small {
  display: block;
  font-size: 9px;
}

.candidate-card.frame {
  position: relative;
  display: inline-flex;
  flex-direction: column;
  align-items: center;

  padding: 6px;
  background: #fff;
  border-radius: 6px;
  overflow: hidden;

  box-shadow:
    0 4px 10px rgba(0,0,0,.18),
    0 1px 3px rgba(0,0,0,.12);
}

/* 🔒 Image is sacred: never resize */
.imgcandidate {
  display: block;
  width: 200 !important;
  height: 300 !important;
  max-width: none !important;   /* ⬅ critical */
  flex-shrink: 0;               /* ⬅ critical */
}

/* 🔒 Name is constrained to image width */
.candidate-name {
  max-width: 100%;              /* relative to image */
  margin-top: 6px;
  padding: 2px 4px;

  text-align: center;
  font-size: 14px;
  font-weight: 600;

  white-space: normal;
  word-break: break-word;
  overflow-wrap: anywhere;
}

.candidate-card.frame {
  transition: transform 0.15s ease, box-shadow 0.15s ease;
}

.candidate-card.frame:hover {
  transform: translateY(-3px);
  box-shadow:
    0 8px 18px rgba(0,0,0,0.25),
    0 3px 6px rgba(0,0,0,0.15);
}

.state-flag-bar {
  position: sticky;
  top: 0;
  z-index: 300;
}

.election-header {
  position: sticky;
  top: var(--flags-h);
  z-index: 200;
}

.district-header {
  position: sticky;
  top: calc(var(--flags-h) + var(--date-h));
  z-index: 100;
}

.state-flag-bar,
.election-header,
.district-header {
  background-color: #ffffff !important;
  background-clip: padding-box;
}

.flag-link {
  position: relative;
  display: inline-block;
}

.flag-link::after {
  content: attr(data-state);
  position: absolute;

  bottom: 100%;          /* appear above flag */
  left: 50%;
  transform: translateX(-50%) translateY(-6px);

  background: #000;
  color: #fff;
  font-size: 12px;
  font-weight: 600;
  white-space: nowrap;

  padding: 4px 8px;
  border-radius: 4px;

  opacity: 0;
  pointer-events: none;
  transition: opacity 0.15s ease;
  z-index: 9999;
}

.flag-link:hover::after {
  opacity: 1;
}
</STYLE>

	<div class="sticky-stack">

  <div class="state-flag-bar">
  		<DIV class="right f80bold">Voter Guide<?= (empty (!$StateName[$ActiveState]) ? " for " . $StateName[$ActiveState] : NULL) ?></DIV>
			<?php
	
			$activeccs = NULL; 
			foreach ($Statescountries as $CountryName => $CountryFlag) { 
				if ( ! empty($ActiveState)) { $activeccs = " flagnonselected"; }
				$activeccs = $ActiveStateWithCandidate[$CountryFlag] ? NULL : " flagnonselected";
			
			?><A class="flag-link" data-state="<?= $CountryName ?>" HREF="/<?= $BuildURLBeg . (($ActiveState != $CountryFlag) ? "S" . $CountryFlag : "rset") . $BuildURLEnd ?>/voter/guide" ALT="<?= $CountryName ?>"><IMG SRC="/images/flags/<?= $CountryFlag ?>.png" class="flag <?= $ActiveState != $CountryFlag ? $activeccs : NULL ?>"></A> <?php 
		} ?>
	 </div>
	

<?php 
	$firsttime = true;
$PrevDateDesc = null;
$PrevElectionID = null;

if (!empty($result)) {
  foreach ($result as $var) {

    if (
      !empty($var["CandidateProfile_ID"]) &&
      $var["CandidateProfile_NotOnBallot"] != 'yes' &&
      $var["CandidateProfile_PublishProfile"] != 'no'
    ) {

      $DateDesc = PrintShortDate($var["Elections_Date"]) . " - " . $var["Elections_Text"];

      $PicturePath = "/shared/pics/" . (!empty($var["CandidateProfile_PicFileName"]) ?
									         $var["CandidateProfile_PicFileName"] : "0000/NoPicture.jpg");

      $FullAlias = preg_replace('/[^a-zA-Z0-9]+/', '', $var["CandidateProfile_Alias"]);
      $DetailURL = "/" . $FullAlias . "_" . $var["CANDPROFID"] . "/voter/detail";

      /* 🔑 Detect new batch */
      $NewBatch =
        ($PrevDateDesc !== $DateDesc) ||
        ($PrevElectionID !== $var["CandidateElection_ID"]);

      /* 🔒 Close previous batch */
      if ($NewBatch && !$firsttime) {
        echo "</div>"; // .election-batch
      }

      /* 🔒 Open new batch + print headers */
      if ($NewBatch) {
        ?>
        <div class="election-batch">
          <div class="election-header f60bold">
            <?= $DateDesc ?>
          </div>
          <div class="district-header" class="f60">
            <?= $var["CandidateElection_Text"] ?>
          </div>
        <?php
      }
      ?>

      <!-- Candidate card -->
      <div class="candidate-card frame">
        <span class="ribbon <?= strtolower($var["Candidate_Party"]) ?>">
          <?= $var["Candidate_Party"] ?>
        </span>
        <a href="<?= $DetailURL ?>">
          <img src="<?= $PicturePath ?>" class="imgcandidate">
        </a>
        <div class="candidate-name">
          <?= ucwords(strtolower($var["CandidateProfile_Alias"])) ?>
        </div>
      </div>

      <?php
      $PrevDateDesc = $DateDesc;
      $PrevElectionID = $var["CandidateElection_ID"];
      $firsttime = false;
    }
  }

  /* 🔒 Close last batch */
  if (!$firsttime) {
    echo "</div>";
  }

} else {
  ?>
  <h2>The guide is empty at this time.</h2>
  <?php
}
?>
		<div id="scroll-sentinel"></div>
		</DIV>

<br style="clear:both">


<P>
	<DIV class="right f80">Notice to voters and candidates</DIV>
	
	<P>
		If you are a voter and would like to receive an update on the election in your 
		district, you can <A HREF="/<?= $middleuri ?>/register/user">register</A>, 
		and we'll email you with the latest voter guide before the election.
	</P>
	
	<P>
		We do not sell your information to any candidate, and we don't track you as per 
		our <A HREF="/<?= $middleuri ?>/policies/privacy">Privacy Policy</A>.
	</P>
	
	<P>
		Any candidate can update the voter guide by updating their information by
		<A HREF="/<?= $middleuri ?>/register/user">registering</A>. 
	</P>

	<DIV class="right f60">	
		<A HREF="<?= PrintReferer() ?>">Return to previous menu</A></B>
	</DIV>
		
</P>

</DIV>
</DIV>
</FORM>

		
<?php include $_SERVER["DOCUMENT_ROOT"] . "/common/footer.php"; ?>
<script>
function updateStickyHeights() {
  const flags = document.querySelector('.state-flag-bar');
  const date  = document.querySelector('.election-header');

  if (!flags || !date) return;

  document.documentElement.style.setProperty(
    '--flags-h',
    flags.offsetHeight + 'px'
  );

  document.documentElement.style.setProperty(
    '--date-h',
    date.offsetHeight + 'px'
  );
}

window.addEventListener('load', updateStickyHeights);
window.addEventListener('resize', updateStickyHeights);
</script>
<script>
let offset = 600;
let loading = false;
let done = false;

const sentinel = document.getElementById('scroll-sentinel');

const observer = new IntersectionObserver(entries => {
  if (entries[0].isIntersecting && !loading && !done) {
    loadNextBatch();
  }
}, {
  rootMargin: '800px'   // 🔑 preload before bottom
});

observer.observe(sentinel);

function loadNextBatch() {
  loading = true;

  const params = new URLSearchParams({
    offset: offset,
    state: '<?= $ActiveState ?>',
    date:  '<?= $ActiveDate ?? "NOW" ?>',
    team:  '<?= $ActiveTeam ?>'
  });

  fetch('/' + params.toString() '/voter/load_candidates')
    .then(res => res.text())
    .then(html => {
      if (html.trim() === '') {
        done = true;
        observer.disconnect();
        return;
      }

      sentinel.insertAdjacentHTML('beforebegin', html);
      offset += 600;
      loading = false;

      // 🔑 recalc sticky heights after DOM changes
      updateStickyHeights();
    })
    .catch(() => loading = false);
}
</script>
</BODY>
</HTML>