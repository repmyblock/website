<?php
	if ( ! empty ($k)) { $MenuLogin = "logged";  }  
	$Menu = "electors";
	$BigMenu = "represent";	
	
	require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/common/verif_sec.php";	
	require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/funcs/general.php";
	require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/db/db_login.php";  
  require $_SERVER["DOCUMENT_ROOT"] . "/../statlib/Config/Vars.php";

	$r = new login();
	$URLToEncrypt = "SystemUser_ID=" . $result["SystemUser_ID"] . "&RawVoterID=" . $RawVoterID . 
										"&DatedFiles=" . $DatedFiles . 
										"&ElectionDistrict=" . $ElectionDistrict . "&AssemblyDistrict=" . $AssemblyDistrict . 
										"&FirstName=" . $FirstName . "&LastName=" . $LastName;

	$Party = "Democrats";
	$ElectionDistrict = "10";
	$AssemblyDistrict = "75";
	$MenuDescription = "AD" . $AssemblyDistrict . " / ED". $ElectionDistrict;


	$Electors["640 Riverside Drive"][0]["Elector_ID"] = "2039";
	$Electors["640 Riverside Drive"][0]["Elector_FirstName"] = "Theo";
	$Electors["640 Riverside Drive"][0]["Elector_LastName"] = "Chino";	
	$Electors["640 Riverside Drive"][0]["Elector_Address"] = "640 Riverside Drive, Apt 10B, New York, NY 10031";	

	$Electors["640 Riverside Drive"][1]["Elector_ID"] = "2040";
	$Electors["640 Riverside Drive"][1]["Elector_FirstName"] = "Sean";
	$Electors["640 Riverside Drive"][1]["Elector_LastName"] = "Bronzell";	
	$Electors["640 Riverside Drive"][1]["Elector_Address"] = "640 Riverside Drive, Apt 10A, New York, NY 10031";	
	
	$Electors["640 Riverside Drive"][2]["Elector_ID"] = "2041";
	$Electors["640 Riverside Drive"][2]["Elector_FirstName"] = "Maria Josefa";
	$Electors["640 Riverside Drive"][2]["Elector_LastName"] = "Malaga Aragon";	
	$Electors["640 Riverside Drive"][2]["Elector_Address"] = "640 Riverside Drive, Apt 10C, New York, NY 10031";	

	$Electors["640 Riverside Drive"][3]["Elector_ID"] = "2042";
	$Electors["640 Riverside Drive"][3]["Elector_FirstName"] = "Laura";
	$Electors["640 Riverside Drive"][3]["Elector_LastName"] = "Turman";	
	$Electors["640 Riverside Drive"][3]["Elector_Address"] = "640 Riverside Drive, Apt 10D, New York, NY 10031";	
							
	$Electors["644 Riverside Drive"][0]["Elector_ID"] = "2043";
	$Electors["644 Riverside Drive"][0]["Elector_FirstName"] = "Johnny";
	$Electors["644 Riverside Drive"][0]["Elector_LastName"] = "GOuchty";	
	$Electors["644 Riverside Drive"][0]["Elector_Address"] = "644 Riverside Drive, Apt 10C, New York, NY 10031";	
	
	$Electors["644 Riverside Drive"][1]["Elector_ID"] = "2044";
	$Electors["644 Riverside Drive"][1]["Elector_FirstName"] = "Laura";
	$Electors["644 Riverside Drive"][1]["Elector_LastName"] = "Bloodman";	
	$Electors["644 Riverside Drive"][1]["Elector_Address"] = "644 Riverside Drive, Apt 10D, New York, NY 10031";	
				
	include $_SERVER["DOCUMENT_ROOT"] . "/headers/headers.php";
?>

<div class="row">
  <div class="main">

<?php include $_SERVER["DOCUMENT_ROOT"] . "/headers/menu.php"; ?>


<div class="col-9 float-left">
	
	<div class="Subhead">
  	<h2 class="Subhead-heading">Electors</h2>
	</div>

	<div class="Box">
  	<div class="Box-header pl-0">
    	<div class="table-list-filters d-flex">
  			<div class="table-list-header-toggle states flex-justify-start pl-3">First Name Last Name Address</div>
  		</div>
    </div>
    
    <div class="Box-body text-center py-6 js-collaborated-repos-empty" hidden="">
      We don't know your district <a href="/voter">create one</a>?
    </div>
	
	
	<div id="example1" class="row">
			
			
<?php if ( ! empty ($Electors)) {
			 	foreach ($Electors as $Address => $Elector) {
			 		if ( ! empty ($Address)) {
			 			?>
<div class="list-group-item Box-row simple public js-collab-repo" data-repo-id="122408775" data-owner-id="5959961">
<span class="ml-2"><?= $Address ?></span>
</div>
<?php
		
			 		foreach ($Elector as $Elect) {
				 		if (! empty ($Elect)) { 
?>
			 			
<div class="list-group-item Box-row simple public js-collab-repo" data-repo-id="122408775" data-owner-id="5959961">
<?= $Elect["Elector_FirstName"] ?> <?= $Elect["Elector_LastName"] ?>
<span class="ml-2"><?= $Elect["Elector_Address"] ?></span>
<svg class="octicon octicon-organization" viewBox="0 0 16 16" version="1.1" width="16" height="16" aria-hidden="true"><path fill-rule="evenodd" d="M16 12.999c0 .439-.45 1-1 1H7.995c-.539 0-.994-.447-.995-.999H1c-.54 0-1-.561-1-1 0-2.634 3-4 3-4s.229-.409 0-1c-.841-.621-1.058-.59-1-3 .058-2.419 1.367-3 2.5-3s2.442.58 2.5 3c.058 2.41-.159 2.379-1 3-.229.59 0 1 0 1s1.549.711 2.42 2.088C9.196 9.369 10 8.999 10 8.999s.229-.409 0-1c-.841-.62-1.058-.59-1-3 .058-2.419 1.367-3 2.5-3s2.437.581 2.495 3c.059 2.41-.158 2.38-1 3-.229.59 0 1 0 1s3.005 1.366 3.005 4z"></path></svg>
<svg class="octicon octicon-repo mr-1" viewBox="0 0 12 16" version="1.1" width="12" height="16" aria-hidden="true"><path fill-rule="evenodd" d="M4 9H3V8h1v1zm0-3H3v1h1V6zm0-2H3v1h1V4zm0-2H3v1h1V2zm8-1v12c0 .55-.45 1-1 1H6v2l-1.5-1.5L3 16v-2H1c-.55 0-1-.45-1-1V1c0-.55.45-1 1-1h10c.55 0 1 .45 1 1zm-1 10H1v2h2v-1h3v1h5v-2zm0-10H2v9h9V1z"></path></svg>
<a class="mr-1" href="/lgd/petitions/organize/">Petition #<?= $Elect["Elector_ID"] ?></a>		
</div>
		
<?php		} 
			}
		}
	}
}
?>
 
</div>
</div>
	

	


		
		
	
</div>
</div>
</DIV>
</DIV>
</DIV>


<script async type="text/javascript" src="/external/Sortable/Sortable.js"></script>    
  
  <script>
  	// Default SortableJS
		//import Sortable from 'sortablejs';

		// Core SortableJS (without default plugins)
		// import Sortable from 'sortablejs/modular/sortable.core.esm.js';

		// Complete SortableJS (with all plugins)
		// import Sortable from 'sortablejs/modular/sortable.complete.esm.js';
		
		var example1 = document.getElementById('example1');

		// Example 1 - Simple list
		new Sortable(example1, {
			animation: 150,
			ghostClass: 'blue-background-class'
		});

</script>


<?php include $_SERVER["DOCUMENT_ROOT"] . "/get-involved/headers/footer.php";	?>