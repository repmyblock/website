<?php
	if ( ! empty ($k)) { $MenuLogin = "logged";  }  
	$Menu = "admin";
	// $BigMenu = "represent";	
	
	require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/common/verif_sec.php";	
	require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/common/verif_admin.php";	
	require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/db/db_repmyblock.php";  
  if (empty ($URIEncryptedString["SystemUser_ID"])) { goto_signoff(); }

	if ( empty ($URIEncryptedString["MenuDescription"])) { $MenuDescription = "District Not Defined";}	
	$Party = PrintParty($URIEncryptedString["UserParty"]);

	$rmb = new RepMyBlock();	
	$rmbperson = $rmb->SearchUserVoterCard($URIEncryptedString["SystemUser_ID"]);
	$result = $rmb->GetAdminStats();
			
	include $_SERVER["DOCUMENT_ROOT"] . "/common/headers.php";
	if ($MobileDisplay == true) { $Cols = "col-12"; } else { $Cols = "col-9"; }
?>

<div class="row">
  <div class="main">



<?php include $_SERVER["DOCUMENT_ROOT"] . "/common/menu.php"; ?>


<div class="<?= $Cols ?> float-left">
	
	<div class="Subhead">
  	<h2 class="Subhead-heading">Statistics</h2>
	</div>

	<?php 
		if ($VerifEmail == true) { 
			include $_SERVER["DOCUMENT_ROOT"] . "/common/warning_emailverif.php";
		} else if ($VerifVoter == true) {
			include $_SERVER["DOCUMENT_ROOT"] . "/common/warning_voterinfo.php";
		} 
	?>

	<div class="Box">
  	<div class="Box-header pl-0">
    	<div class="table-list-filters d-flex">
  			<div class="table-list-header-toggle states flex-justify-start pl-3">Registrations</div>
  		</div>
    </div>
    
    <?php if ( $VerifVoter == true) {  ?>
			    <div class="Box-body text-center py-6 js-collaborated-repos-empty">
			      Before you can organise your voter list, 
			    	<a href=/lgd/profile/voter/?k=<?= $k ?>">you need to verify your voter information</a> so we can figure which list to list.
			    </div>
			<?php } ?>
    
  
		<div id="voters" >
	
	
	
	<script type="text/javascript" src="https://www.google.com/jsapi"></script>
    <script type="text/javascript">
      google.load("visualization", "1", {packages:["corechart"]});
      google.setOnLoadCallback(drawChart);
      function drawChart() {
      	
        var data = google.visualization.arrayToDataTable([
        ['Dates', 'New Regs', 'Temp Conv', 'Final Conv'], 
        <?php 
        	if ( ! empty ($result)) {
        		foreach ($result as $var) {
        			if ( ! empty ($var)) {        				
        				echo "['" . $var["SystemStats_Date"] . "'," . $var["SystemStats_EmailRcvd"] . "," . $var["SystemStats_EmailTempConv"] . "," . $var["SystemStats_EmailPermConv"] . "],\n";
        			}
        		}
        	}
        ?>]);

	      var options = {
	      	title: 'New Registrations',
	        curveType: 'function',
	        //width: 1000,
	        //height: 563,
	        
	        hAxis: {
	          title: 'Dates'
	        },
	        vAxis: {
	          title: 'New Regs'
	        }
	      };
      
        var chart = new google.visualization.LineChart(document.getElementById('chart_div'));

        chart.draw(data, options);
      }
    </script> 
 	 		
 		

    <div id="chart_div" style="width: 100%;"></div>
			
			
<?php

			$Counter = 0;
			if ( ! empty ($Electors)) {
				foreach ($Electors as $Address => $Elector) {
					if ( ! empty ($Address)) { ?>
						<div class="list-group-item filtered f60 hundred">
							<A CLASS="pad40" HREF="open/?k=<?= $k ?>"><i class="fas fa-folder handle"></i></A>							
							
							
							<?php /* INPUT TYPE="checkbox" NAME="SelectAllAddresses" VALUE="<?= $Address ?>">&nbsp;&nbsp;
							<button class="accordeonbutton" id="<?= $Counter++ ?>">Open</button>	
							*/ ?>
							<span><B><?= $Address ?></B></span>  	          			
						</div>
<?php /*							
					 <DIV class="panels">
<?php				foreach ($Elector as $Elect) {
					 		if (! empty ($Elect)) { ?>
								<div class="list-group-item f60"><?php
									?>&nbsp;&nbsp;&nbsp;&nbsp;<i class="fas fa-arrows-alt handle"></i>&nbsp;&nbsp;<?php
									?><INPUT TYPE="checkbox" NAME="CreateID[]" VALUE="<?= $Elect["Elector_ID"] ?>">&nbsp;&nbsp;<?php
									?><svg class="octicon octicon-organization" viewBox="0 0 16 16" version="1.1" width="16" height="16" aria-hidden="true"><path fill-rule="evenodd" d="M16 12.999c0 .439-.45 1-1 1H7.995c-.539 0-.994-.447-.995-.999H1c-.54 0-1-.561-1-1 0-2.634 3-4 3-4s.229-.409 0-1c-.841-.621-1.058-.59-1-3 .058-2.419 1.367-3 2.5-3s2.442.58 2.5 3c.058 2.41-.159 2.379-1 3-.229.59 0 1 0 1s1.549.711 2.42 2.088C9.196 9.369 10 8.999 10 8.999s.229-.409 0-1c-.841-.62-1.058-.59-1-3 .058-2.419 1.367-3 2.5-3s2.437.581 2.495 3c.059 2.41-.158 2.38-1 3-.229.59 0 1 0 1s3.005 1.366 3.005 4z"></path></svg><?php
									?>&nbsp;<?= $Elect["Elector_FullName"] ?><?php
									?><span class="ml-1"><?= $Elect["Elector_Address"] ?></span> <?php
									?><svg class="octicon octicon-repo mr-1" viewBox="0 0 12 16" version="1.1" width="12" height="16" aria-hidden="true"><path fill-rule="evenodd" d="M4 9H3V8h1v1zm0-3H3v1h1V6zm0-2H3v1h1V4zm0-2H3v1h1V2zm8-1v12c0 .55-.45 1-1 1H6v2l-1.5-1.5L3 16v-2H1c-.55 0-1-.45-1-1V1c0-.55.45-1 1-1h10c.55 0 1 .45 1 1zm-1 10H1v2h2v-1h3v1h5v-2zm0-10H2v9h9V1z"></path></svg><?php
									?>Petition <a class="mr-1" href="/lgd/petitions/organize/">#<?= $Elect["Petition_ID"] ?></a><?php		
								?></div>			
<?php					}	 
						} ?>
						</DIV>
						*/ ?>
						
						
<?php			}
				}
			} ?>
	 
		</div>
	</div>
</div>

</div>
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
	
	var voters = document.getElementById('voters');	
	
	new Sortable(voters, {
		animation: 150,
		// handle: '.handle', // handle's class
		ghostClass: 'blue-background-class',
		//filter: '.filtered'
	});
	
	
	console.log("Console ... \n");
	


</script>
<?php include $_SERVER["DOCUMENT_ROOT"] . "/common/footer.php";	?>
