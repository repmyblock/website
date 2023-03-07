<?php
	if ( ! empty ($k)) { $MenuLogin = "logged";  } 
	$Menu = "admin";
	$BigMenu = "represent";	
		 
	require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/common/verif_sec.php";	
	require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/common/verif_admin.php";	
	require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/db/db_repmyblock.php"; 
	
  if (empty ($URIEncryptedString["SystemUser_ID"])) { goto_signoff(); }
	if (empty ($URIEncryptedString["MenuDescription"])) { $MenuDescription = "District Not Defined";}	
	
	$rmb = new repmyblock();
	
	if (! empty($_POST)) {				
		$formdbvalue = $_POST["Value"];
		$formdbtable = $_POST["DBTABLE"];
		
		preg_match('/([^#]*)#(.*)/', $formdbtable, $matches, PREG_OFFSET_CAPTURE);
		
		$dbtable = $matches[1][0];
		$dbcols = $matches[2][0];

		$query_result = $rmb->database_custquery($dbtable, $dbcols, $formdbvalue);
	}

	
	
	$result = $rmb->database_showtables();
	
	$DabataBaseTables = array();
	if ( ! empty ($result)) {
		foreach ($result as $var) {
			if ( ! empty ($var)) {
				$res_cols = $rmb->database_showcolums($var["Tables_in_RepMyBlock"]);
				if ( ! empty ($res_cols)) {
					foreach ($res_cols as $index => $vor) {
						if ( ! empty ($vor)) {
							array_push($DabataBaseTables, $var["Tables_in_RepMyBlock"] . "#" . $vor["Field"]);
						}
					}
				}				
			}
		}
	}
	
	
	
	include $_SERVER["DOCUMENT_ROOT"] . "/common/headers.php";
?>

<div class="row">
  <div class="main">
		<?php include $_SERVER["DOCUMENT_ROOT"] . "/common/menu.php"; ?>
			<div class="<?= $DIVCol ?> float-left">

				<div class="Subhead">
			  	<h2 class="Subhead-heading">Database integrity</h2>
				</div>
			
			<?php 
				if ($VerifEmail == true) { 
					include $_SERVER["DOCUMENT_ROOT"] . "/common/warning_emailverif.php";
				} else if ($VerifVoter == true) {
					include $_SERVER["DOCUMENT_ROOT"] . "/common/warning_voterinfo.php";
				} 
			?>          
			
			<?php if (! empty ($URIEncryptedString["ErrorMsg"])) {
		    	
		    	echo "<FONT COLOR=BROWN SIZE=+1><B>" . $URIEncryptedString["ErrorMsg"] . "</B></FONT>";
		    	echo "<BR><BR>";	
		    } ?>
		
				<div class="clearfix gutter d-flex flex-shrink-0">			
				<div class="col-12">
				  <form class="edit_user" id="" action="" accept-charset="UTF-8" method="post">
						<div>
							<dl class="form-group col-48 d-inline-block"> 
								<dt class="mobilemenu"><label for="user_profile_name">Table Name</label><DT>
								<dd>
									<SELECT class="mobilebig" NAME="DBTABLE">
									<OPTION VALUE="">Select a table</OPTION>
									<?php foreach ($DabataBaseTables as $var) {
										if ( ! empty($var)) {
											$vor =  preg_replace("/#/", " - ", $var);
											print "<OPTION VALUE=\"". $var . "\"";
											if ( $var == $formdbtable ) echo " SELECTED";
											print ">" . $vor . "</OPTION>\n";
										}
									}	?>
									</SELECT>
								</dd>
							</dl>
							
							<dt class="mobilemenu"><label for="user_profile_name">Query Value</label><DT>
								<dd>
									<input class="form-control" type="text" Placeholder="Query Value" name="Value" VALUE="<?= $formdbvalue ?>" id="">
								</dd>
							</dl>
							
						</DIV>
						
						<div>						
							<dl class="form-group col-12 d-inline-block"> 	
						</div>

						<div>						
							<dl class="form-group col-12 d-inline-block"> 
								<dd>
									<button type="submit" class="redsubmit">Query the Table</button>
								</dd>
							</dl>
						</div>
					</form> 



				<h2>Query Results</h2>

				<?php 
					if ( ! empty ($query_result)) {
						echo "<TABLE>";

						foreach ($query_result as $var) {
							if ( ! empty ($var)) {
								foreach ($var as $index => $vor) {
									print "<TR><TH>" . $index . "</TH><TD>" . $vor . "</TD></TR>";
								}
							}					
						}
						
						echo "</TABLE>";
					}
					?>


				</div>
			</div>
		</div>
	</DIV>
</div>	

</DIV>
</DIV>
</DIV>
</DIV>






<?php include $_SERVER["DOCUMENT_ROOT"] . "/common/footer.php";	?>