<?php
	if ( ! empty ($k)) { $MenuLogin = "logged";  }  
	$Menu = "petitions";
	$BigMenu = "represent";	
	
	require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/common/verif_sec.php";	
	require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/db/db_repmyblock.php";  

  if (empty ($URIEncryptedString["SystemUser_ID"])) { goto_signoff(); }
	$rmb = new repmyblock();
	$rmbperson = $rmb->SearchUserVoterCard($URIEncryptedString["SystemUser_ID"]);
	
	if ( ! empty($_POST)) {
		
		// echo $URIEncryptedString["DataDistrict_ID"] . "<BR>";
		//$rmbwalksheet = $rmb->GetWalkSheetInfo($URIEncryptedString["DataDistrict_ID"]);
	
		$NewKEncrypt = CreateEncoded (array(
											"DataDistrict_ID" => $URIEncryptedString["DataDistrict_ID"],
											"PreparedFor" => $_POST["PetitionFor"],
											"ED" => $URIEncryptedString["ED"],
										  "AD" => $URIEncryptedString["AD"],
										  "Party" => $rmbperson["SystemUser_Party"]
										));
		
		header("Location: " . $FrontEndPDF . "/rmb/" . $NewKEncrypt . "/voterlist");	
		exit();
	}

	
	$Party = PrintParty($UserParty);

	if ( empty ($URIEncryptedString["MenuDescription"])) { $MenuDescription = "District Not Defined";}	

	include $_SERVER["DOCUMENT_ROOT"] . "/common/headers.php";
?>

<div class="row">
  <div class="main">
		<?php include $_SERVER["DOCUMENT_ROOT"] . "/common/menu.php"; ?>
			<div class="col-9 float-left">
    

				<div class="Subhead">
			  	<h2 class="Subhead-heading">Walksheets</h2>
				</div>
				
			
			  <div class="Box">
					<div class="Box-header pl-0">
						<div class="table-list-filters d-flex">
							<div class="table-list-header-toggle states flex-justify-start pl-3">Prepare a walksheet</div>
						</div>
			    </div>
			    
			    
			    <div class="Box-body py-6 js-collaborated-repos-empty">
			    	<FORM ACTION="" METHOD="POST">
				    	Download Walksheet for Assembly District
				    	<B><?= $URIEncryptedString["AD"] ?></B> 
				    	and Electoral District <B><?= $URIEncryptedString["ED"] ?></B>
				    	<BR>
				    	Enter the name of the person who will use the walk sheet:<BR>
				      <INPUT TYPE="TEXT" NAME="PetitionFor">
				      <button type="submit" class="btn btn-primary">Prepare the Walk Sheet</button>
				    </FORM>
			    		
			    
				</P>	
			    		
			    		
			    </div>
			
				</div>
			</div>

			
		</div>
	</DIV>
</DIV>

<?php include $_SERVER["DOCUMENT_ROOT"] . "/common/footer.php";	?>
