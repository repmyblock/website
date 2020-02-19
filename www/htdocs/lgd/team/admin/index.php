<?php
	if ( ! empty ($k)) { $MenuLogin = "logged";  }  
	$Menu = "team";
	$BigMenu = "represent";	
	 
  require $_SERVER["DOCUMENT_ROOT"] . "/../statlib/Config/Vars.php";
	require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/common/verif_sec.php";	
	require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/common/verif_admin.php";	
	require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/funcs/general.php";
	require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/db/db_repmyblock.php"; 

  if (empty ($SystemUser_ID)) { goto_signoff(); }
	$rmb = new repmyblock();

	if ( empty ($MenuDescription)) { $MenuDescription = "District Not Defined";}	
	$Party = NewYork_PrintParty($UserParty);
	
	if (!empty($_POST)) {		
		$EncryptURL = $Decrypted_k . "&Query_FirstName=" . urlencode($_POST["FirstName"]) . 
									"&Query_LastName=" . urlencode($_POST["LastName"]) .
									"&AD=" . urlencode($_POST["AD"]) . "&ED=" . urlencode($_POST["ED"]);
		header("Location: voterlist/?k=" . EncryptURL($EncryptURL));		
		exit();
	}

	include $_SERVER["DOCUMENT_ROOT"] . "/headers/headers.php";
?>

<div class="row">
  <div class="main">



<?php include $_SERVER["DOCUMENT_ROOT"] . "/headers/menu.php"; ?>


		<div class="col-9 float-left">

			<div class="Subhead">
		  	<h2 class="Subhead-heading">Admin</h2>
			</div>
			
			<?php 
				if ($VerifEmail == true) { 
					include $_SERVER["DOCUMENT_ROOT"] . "/warnings/emailverif.php";
				} else if ($VerifVoter == true) {
					include $_SERVER["DOCUMENT_ROOT"] . "/warnings/voterinfo.php";
				} 
			?>          
		
		    
<div class="clearfix gutter d-flex flex-shrink-0">
				<div class="col-16">
				  <form class="edit_user" id="" action="" accept-charset="UTF-8" method="post">
						<div>
							<dl class="form-group col-3 d-inline-block"> 
								<dt><label for="user_profile_name">First Name</label><DT>
								<dd>
									<input class="form-control" type="text" Placeholder="First" name="FirstName" VALUE="" id="">
								</dd>
							</dl>

							<dl class="form-group col-3 d-inline-block"> 
								<dt><label for="user_profile_name">Last Name</label><DT>
								<dd>
									<input class="form-control" type="text" Placeholder="Last" name="LastName" VALUE="" id="">
								</dd>
							</dl>
							
							</div>
								<div>
							
							<dl class="form-group col-3 d-inline-block"> 
								<dt><label for="user_profile_name">Assembly District</label><DT>
								<dd>
									<input class="form-control" type="text" Placeholder="Assembly District" name="AD" VALUE="" id="">
								</dd>
							</dl>

							<dl class="form-group col-3 d-inline-block"> 
								<dt><label for="user_profile_name">Electoral District</label><DT>
								<dd>
									<input class="form-control" type="text" Placeholder="Electoral District" name="ED" VALUE="" id="">
								</dd>
							</dl>
							
								</div>
								<div>
							
							<dl class="form-group col-3 d-inline-block"> 
								<dd>
									<button type="submit" class="btn btn-primary">Search Voter Registration</button>
								</dd>
							</dl>
						</div>
					</form> 


				</div>
			</div>
		</div>
	</DIV>
</div>	

</DIV>
</DIV>
</DIV>
</DIV>






<?php include $_SERVER["DOCUMENT_ROOT"] . "/headers/footer.php";	?>