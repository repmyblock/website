<?php
	$Menu = "admin";
	$BigMenu = "represent";	

	require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/common/verif_sec.php";	
	require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/common/verif_admin.php";	

	// Reset
	require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/db/db_admin.php";	
	if (empty ($URIEncryptedString["SystemUser_ID"])) { goto_signoff(); }
	
	if ( ! empty ($URIEncryptedString["ListStateID"])) {
		$StateID = $URIEncryptedString["ListStateID"];
	} else {
		$StateID = 1;
	}
	
	$rmb = new RMBAdmin(0);
	$rmbperson = $rmb->SearchUserVoterCard($URIEncryptedString["SystemUser_ID"]);
	
	if ( ! empty ($_POST)) {
		WriteStderr($_POST, "This is POST");	
		
		if ( ! empty ($_POST["DeadLine"]) ) {		
			
			// Check that it doesn't exist already.
			$result = $rmb->ListPartyCallForPositions(trim($_POST["ElectionDate"]), trim($_POST["ElectionPosition"]));
			
			if ( empty ($result)) {
				echo "Je suis la";
				$rmb->SavePartyCallForPosition(trim($_POST["ElectionDate"]), 
															trim($_POST["ElectionPosition"]), trim($_POST["DeadLine"]));
			}
			
		}
		
		header("Location: /" .	CreateEncoded(array(
																"ElectionDate_ID" => $_POST["ElectionDate"],	
																"SystemUser_ID" => $URIEncryptedString["SystemUser_ID"],
																"SystemUser_Priv" => $URIEncryptedString["SystemUser_Priv"],
															)). "/admin/partycalladd");
		exit();
		
	} 
	
	if ( ! empty ($URIEncryptedString["ElectionDate_ID"])) {
		$rmbpartycall = $rmb->ListPartyCallForPositions($URIEncryptedString["ElectionDate_ID"]);
	}
	
	
	$rmbpositions = $rmb->FindElectionsAvailable($StateID);	
	$rmbelectiondates = $rmb->ListAllElectionsDates("NOW", $StateID);
	WriteStderr($rmbelectiondates, "ListAllElectionsDates");	

	if ( ! empty ($ListPartyCall) ) {
		foreach ($ListPartyCall as $var) {
			if ( ! empty ($var) ) {
				$TotalCandidate += $var["ElectionsPartyCall_NumberUnixSex"];
			}
		}
	}
	
	$TopMenus = array ( 						
		array("k" => $k, "url" => "../admin/partycall", "text" => "Party Call"),
		array("k" => $k, "url" => "../admin/partycalladd", "text" => "Update Positions")
	);
	
	include $_SERVER["DOCUMENT_ROOT"] . "/common/headers.php";		
?>
<div class="row">
  <div class="main">
		<?php include $_SERVER["DOCUMENT_ROOT"] . "/common/menu.php"; ?>
  		<div class="<?= $Cols ?> float-left col-full">
    
			  <!-- Public Profile -->
			  <div class="Subhead mt-0 mb-0">
			    <h2 class="Subhead-heading">Party Call</h2>
				</DIV>
				<?php	PlurialMenu($k, $TopMenus); ?>   
			  <div class="clearfix gutter">
			  	<div class="row">
				  <div class="main">
			  	
				<DIV>
				<P class="f40">
		   		<B>Active state:</B> <?= $rmbpositions[0]["DataState_Name"] ?>
		   		- <A HREF="">Change active state</A>
		   		 
		   	<?php WriteStderr($rmbpositions, "RMB Positions"); ?>

     	</P>

				<FORM ACTION="" METHOD="POST">
					
						<div class="Box">
					  	<div class="Box-header pl-0">
					    	<div class="table-list-filters d-flex">
					  			<div class="table-list-header-toggle states flex-justify-start pl-3 f60">Create new a position</B></div>
					  		</div>
					    </div>
					    
					    
							
						<div class="Box-body js-collaborated-repos-empty">
							<div class="flex-items-left">	
								<span class="ml-0 flex-items-baseline ">
									
							 	<DIV>
							 		
							 			<dl class="form-group col-3 d-inline-block"> 
								<dt class="mobilemenu"><label for="user_profile_name">Election Date</label><DT>
								<dd>
									<SELECT  class="mobilebig" NAME="ElectionDate">
										<OPTION VALUE="Elections_Date">&nbsp;</OPTION>
										<?php foreach ($rmbelectiondates as $var) { ?>
											<OPTION VALUE="<?= $var["Elections_ID"] ?>"<?php if ($var["Elections_ID"]== $URIEncryptedString["ElectionDate_ID"]) { echo " SELECTED"; } ?>><?= PrintDate($var["Elections_Date"]) ?> (<?= $var["Elections_Text"] ?>)</OPTION>
										<?php } ?>
									
									</SELECT>
								</dd>
							</dl>
							 	
							 	<dl class="form-group col-3 d-inline-block"> 
								<dt class="mobilemenu"><label for="user_profile_name">Election Position</label><DT>
								<dd>
									<SELECT  class="mobilebig" NAME="ElectionPosition">
										<OPTION VALUE="Elections_Date">&nbsp;</OPTION>
										<?php foreach ($rmbpositions as $var) { ?>
											<OPTION VALUE="<?= $var["ElectionsPosition_ID"] ?>"><?= PrintPartyAdjective($var["ElectionsPosition_Party"]) ?> <?= $var["ElectionsPosition_Name"] ?> (<?= $var["ElectionsPosition_Type"] ?>)</OPTION>
										<?php } ?>
									</SELECT>
								</dd>
							</dl>
							 	
							</DIV>
							<DIV>
								<dl class="form-group col-3 d-inline-block"> 
								<dt class="mobilemenu"><label for="user_profile_name">Deadline to run</label><DT>
								<dd>
									<input class="form-control" type="text" Placeholder="Deadline Date" name="DeadLine" VALUE="<?= $FormFieldDTValue ?>" id="">
								</dd>
							</dl>
							
					
							
							<dl class="form-group col-3 d-inline-block"> 
								<dd>
									<button type="submit" class="submitred">Search User</button>
								</dd>
							</dl>
						</DIV>
								
							
									</DIV>
								<DIV class="f40">
									<div id="resp-table">
										<div id="resp-table-header">
											<div class="table-header-cell">Order</div>
											<div class="table-header-cell">DB Table</div>
											<div class="table-header-cell">Type</div>
											<div class="table-header-cell">Party</div>
											<div class="table-header-cell">Position</div>
											<div class="table-header-cell">Signup Deadline</div>
											<div class="table-header-cell">Unisex</div>
											<div class="table-header-cell">Female</div>
											<div class="table-header-cell">Male</div>
										</div>
														
															
									<?php 
			if ( ! empty ($rmbpartycall) ) {
				foreach ($rmbpartycall as $var) {
					if ( ! empty ($var) ) {					
		?>
										<div id="resp-table-body">
											<div class="resp-table-row">
												<div class="table-body-cell"><?= $var["ElectionsPosition_Order"] ?></div>
												<div class="table-body-cell"><?= $var["ElectionsPosition_DBTable"] ?></div>
												<div class="table-body-cell"><?= $var["ElectionsPosition_Type"] ?></div>
												<div class="table-body-cell"><?= $var["ElectionsPosition_Party"] ?></div>
												<div class="table-body-cell"><?= $var["ElectionsPosition_Name"] ?></div>
												<div class="table-body-cell"><?= PrintDateTime($var["ElectionsPartyCall_SignDeadline"]) ?></div>
												<div class="table-body-cell"><?= $var["ElectionsPartyCall_NumberUnixSex"] ?></div>
												<div class="table-body-cell"><?= $var["ElectionsPartyCall_NumberMale"] ?></div>
												<div class="table-body-cell"><?= $var["ElectionsPartyCall_NumberFemale"] ?></div>
											
												</div>
											</div>													
																	
								<?php }
									} 		
								} 
							?>
	</div>	
							</DIV>
	</DIV>
								
								
								
					</DIV>
				</DIV>
			</DIV>
		</DIV>

	</DIV>
	</DIV>
	</DIV>
	</DIV>

	</DIV>
	</FORM>
	</DIV>
</DIV>

<?php include $_SERVER["DOCUMENT_ROOT"] . "/common/footer.php";	?>