<?php
	if ( ! empty ($k)) { $MenuLogin = "logged"; }
	$Menu = "admin";
	
	require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/common/verif_sec.php";
	require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/common/verif_admin.php";
	require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/db/db_repmyblock.php";

	if (empty ($URIEncryptedString["SystemUser_ID"])) { goto_signoff(); }
	if ( empty ($URIEncryptedString["MenuDescription"])) { $MenuDescription = "District Not Defined";}	
	$rmb = new repmyblock();	
	$rmbperson = $rmb->SearchUserVoterCard($URIEncryptedString["SystemUser_ID"]);
	$Party = PrintParty($URIEncryptedString["UserParty"]);
	
	if ( ! empty ($_POST)) {
		// header("Location: /" . $k  . "/admin/add_newdate")
		//	function ListElectionsDates ($limit = 50, $start = 0, $futureonly = false, $StateID = NULL) {
		$result = $rmb->ListElectionsDates(50, 0, true, $_POST["DataStateID"]);
	}

	$States = $rmb->ListStates();
	foreach($States as $Var) { $ListOfState[$Var["DataState_ID"]] = $Var["DataState_Name"]; }
	WriteStderr($result, "ListElections");
	
	$TopMenus = array ( 						
		array("k" => $k, "url" => "../admin/setup_elections", "text" => "Elections Dates"),
		array("k" => $k, "url" => "../admin/setup_dates", "text" => "Election Positions"),
		array("k" => $k, "url" => "../admin/setup_candidate", "text" => "Candidate")
	);
	
	include $_SERVER["DOCUMENT_ROOT"] . "/common/headers.php";
	if ( $MobileDisplay == true) { $Cols = "col-12"; } else { $Cols = "col-9"; }
?>
<div class="row">
  <div class="main">
		<?php include $_SERVER["DOCUMENT_ROOT"] . "/common/menu.php"; ?>
  		<div class="<?= $Cols ?> float-left">
    
			  <!-- Public Profile -->
			  <div class="Subhead mt-0 mb-0">
			    <h2 id="public-profile-heading" class="Subhead-heading">Candidate Profile</h2>
			  </div>
				
				<?php	PlurialMenu($k, $TopMenus); ?>    

			  <div class="clearfix gutter d-flex flex-shrink-0">
	
				<div class="row">
				  <div class="main">
						<FORM ACTION="" METHOD="POST">
							<INPUT TYPE="HIDDEN" NAME="setup_elections" VALUE="add">
						<div class="Box">
					  	<div class="Box-header pl-0">
					    	<div class="table-list-filters d-flex">
					  			<div CLASS="f60"><B>List of positions available</B></div>
					  		</div>
					    </div>
				    
					    <div class="" hidden="">
					      We don't know your district <a href="/voter">create one</a>?
					    </div>
					    
					    
					    <div id="resp-table">
								<div id="resp-table-header">
									<div class="table-header-cell">&nbsp;</div>
									<div class="table-header-cell">District</div>
									<div class="table-header-cell">Candidate</div>
									<div class="table-header-cell">Actions</div>
									<div class="table-header-cell">Election Date</div>
								</div>

								<div id="resp-table-header">
									<div class="table-header-cell">&nbsp;</div>
									<div class="table-header-cell">
										<SELECT NAME="DataStateID">
											<OPTION>&nbsp;</OPTION>
											<?php foreach ($States as $var) { ?>
												<OPTION VALUE="<?= $var["DataState_ID"] ?>"><?= $var["DataState_Name"] ?></OPTION>
											<?php } ?>
										</SELECT>
									</div>
									<div class="table-header-cell">&nbsp;</div>
									<div class="table-header-cell">&nbsp;</div>
									<div class="table-header-cell"><INPUT TYPE="TEXT" VALUE="" NAME="" PLACEHOLDER="date"></div>
								</div>
					    	
						<?php 			
							$Counter = 0;
							if ( ! empty ($result)) {
								foreach ($result as $var) { ?>
								<div class="resp-table-row">								
									<div class="table-body-cell"><A HREF="/<?= CreateEncoded (
										array(
											"SystemUser_ID" => $URIEncryptedString["SystemUser_ID"],	
											"SystemUser_Priv" => $URIEncryptedString["SystemUser_Priv"],
											"CandidatePositions_ID" => $var["DataState_ID"])); 
										?>/admin/elections/position">Select</A></div>
									<DIV CLASS="table-body-cell"><?= $var["DataState_Abbrev"] ?></DIV>
								 	<div class="table-body-cell"><?= $var["Elections_Text"] ?></div>
								  <div class="table-body-cell"><?= $var["Elections_Type"] ?></div>
								 	<div class="table-body-cell"><?= PrintDate($var["Elections_Date"]) ?></div>
								</div>
						<?php
								}
							} ?>
					
							</div>
							
							<DIV>
							<P class="f60">								
								<B>
									<?php $DataState = empty ($result[0]["DataState_ID"]) ? $_POST["DataStateID"] : $result[0]["DataState_ID"]; ?>
									<A HREF="/<?= MergeEncode(array(
														"DataState_ID" => $DataState,							
													)) ?>/admin/elections/addcanelection">Add an election for candidate petition 
									for <?= $ListOfState[$DataState] ?></A></B>
							</P>
							</DIV>
							
							<p><button type="submit" class="submitred">Search State Profile</button></p>
							
						</div>
						</FORM>
					</div>
				</DIV>
			</DIV>
		</DIV>
	</DIV>
</DIV>


<?php include $_SERVER["DOCUMENT_ROOT"] . "/common/footer.php";	?>