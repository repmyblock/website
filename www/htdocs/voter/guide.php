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
		
	preg_match(
	    '/^T?(?:(\d{4})|([picpgsp][ipsordb][ramiecbutn]))?S?([A-Za-z]{2})?D?(\d{8})?Z?(\d{5})?$/',
	    $_GET['k'],
	    $matches,
	    PREG_OFFSET_CAPTURE
	);

	$ActiveTeam  = !empty($matches[1][0]) ? $matches[1][0] : (!empty($matches[2][0]) ? $matches[2][0] : null);
	$ActiveState = !empty($matches[3][0]) ? $matches[3][0] : null;
	$ActiveDate  = !empty($matches[4][0]) ? $matches[4][0] : null;
	$ActiveZIP   = !empty($matches[5][0]) ? $matches[5][0] : null;
	
	if (strlen($ActiveTeam) == 3) {
		
		$MyTCode = strtolower($ActiveTeam);
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
	// sort($SortDates);
	
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
		$result = $r->CandidatesForElection((empty ($ActiveDate) ? "NOW" : $ActiveDate), null, 
																					$StateID["statename"], $ActiveTeam, null, null, 	
																					null);
		
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
		
		$result = $r->CandidatesForElection(
			ElectionDateFrom: (empty ($ActiveDate) ? "NOW" : $ActiveDate), 
			ElectionState: $ActiveState,
			ActiveTeam: $ActiveTeam, 
			SQLTables: [
				"Candidate_DispName", "CandidateProfile.CandidateProfile_ID", "CandidateProfile_NotOnBallot", 
				"CandidateProfile_PublishProfile", "Elections_Date", "Elections_Text", 
				"CandidateProfile_PicFileName", "CandidateProfile_Alias", 
				"CandidateElection_Text", "Candidate_Party", "CandidateProfile_Alias",
	     	"CandidateElection.CandidateElection_ID"
     	]
		);
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
<link rel="stylesheet" type="text/css" href="/css/guide.css">


<form autocomplete="off" method="post" action="">
	
<DIV class="main">



	<div class="sticky-stack">

  <div class="state-flag-bar">
  		<DIV class="right f80bold">Voter Guide<?= (empty (!$StateName[$ActiveState]) ? " for " . $StateName[$ActiveState] : NULL) ?></DIV>
  		
  		<DIV style="padding: 10px 0px 10px 0px;">
				<input id="placeSearch" list="places" placeholder="Search location..." />
  			<datalist id="places"></datalist>
		
				<input id="candidateSearch" list="candidates" placeholder="Candidate name..." />
  			<datalist id="candidates"></datalist>				
				
			</DIV>
				
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
      $DetailURL = "/" . numbertoalpha($var["CANDPROFID"]) . "_" . strtolower($FullAlias) . "/voter/detail";

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
          <div class="district-header f60">
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
	  date: '<?= $ActiveDate ?? "NOW" ?>',
	  team: '<?= $ActiveTeam ?>'
	});

	const encoded = btoa(params.toString());

  fetch('/' + encodeURIComponent(encoded) + '/voter/load_candidates')
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

		<script>
let selectedAddresses = [];

const input = document.getElementById("placeSearch");
const datalist = document.getElementById("places");

input.addEventListener("input", async function () {
  const q = this.value.trim();

  if (q.length < 3) {
    datalist.innerHTML = "";
    return;
  }

  const response = await fetch("/" + encodeURIComponent(q) + "/voter/autocomplete_address");
  selectedAddresses = await response.json();

  datalist.innerHTML = "";

  selectedAddresses.forEach(address => {
    const option = document.createElement("option");
    option.value = address.label;
    datalist.appendChild(option);
  });
});

input.addEventListener("change", function () {
  const selected = selectedAddresses.find(
    address => address.label.toLowerCase() === this.value.toLowerCase()
  );

  if (!selected) return;

  console.log("Selected address:", selected);

  if (typeof map !== "undefined") {
    map.setView([selected.lat, selected.lon], 16);

    L.popup()
      .setLatLng([selected.lat, selected.lon])
      .setContent(selected.label)
      .openOn(map);
  }
});

document.addEventListener("DOMContentLoaded", () => {
  const input = document.getElementById("candidateSearch");
  const datalist = document.getElementById("candidates");
  const container = document.querySelector(".sticky-stack");

  let timer = null;
  let controller = null;

  input.addEventListener("input", () => {
    const q = input.value.trim();

    clearTimeout(timer);

    if (q.length < 3) {
      datalist.innerHTML = "";
      return;
    }

    timer = setTimeout(async () => {
      try {
        if (controller) controller.abort();
        controller = new AbortController();

        const response = await fetch(
          "/" + encodeURIComponent(q) + "/voter/autocomplete_candidates",
          { signal: controller.signal }
        );

        const data = await response.json();
        datalist.innerHTML = "";

        data.forEach(row => {
          const option = document.createElement("option");
          option.value = row.CandidateProfile_Alias || row.name || row;
          datalist.appendChild(option);
        });

      } catch (err) {
        if (err.name !== "AbortError") console.error(err);
      }
    }, 250);
  });

  input.addEventListener("change", async () => {
    const q = input.value.trim();

    if (q.length < 3) return;

    const response = await fetch(
      "/" + encodeURIComponent(q) + "/voter/candidate_cards"
    );

    const html = await response.text();

    document.querySelectorAll(".election-batch").forEach(el => el.remove());

    const sentinel = document.getElementById("scroll-sentinel");
    sentinel.insertAdjacentHTML("beforebegin", html);

    if (typeof updateStickyHeights === "function") {
      updateStickyHeights();
    }
  });
});
</script>

</BODY>
</HTML>