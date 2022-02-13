<?php
	if ( ! empty ($k)) { $MenuLogin = "logged"; }
	$Menu = "admin";
	$BigMenu = "represent";	
	
	require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/common/verif_sec.php";
	require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/common/verif_admin.php";
	require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/db/db_repmyblock.php";

	if (empty ($URIEncryptedString["SystemUser_ID"])) { goto_signoff(); }
	$rmb = new repmyblock();
	$Result = $rmb->SearchUsers();
	$TempResult = $rmb->SearchTempUsers();
	include $_SERVER["DOCUMENT_ROOT"] . "/common/headers.php";
?>

<div class="row">
  <div class="main">
		<?php include $_SERVER["DOCUMENT_ROOT"] . "/common/menu.php"; ?>
			<div class="col-9 float-left">
				<div class="Subhead">
			  	<h2 class="Subhead-heading">Rep My Block Users</h2>
				</div>

				<form class="edit_user" id="" action="" accept-charset="UTF-8" method="post">
				<div class="list-group-item filtered f60 hundred">
					<span><B>Rep My Block Users</B></span>  	          			
				</div>
					
			 	<DIV class="panels">	
				<?php

				if ( ! empty ($Result)) {
						foreach ($Result as $var) {
							if ( ! empty ($var)) { 
								
				?>
				
				<div class="list-group-item f60">
					<svg class="octicon octicon-organization" viewBox="0 0 16 16" version="1.1" width="16" height="16" aria-hidden="true"><path fill-rule="evenodd" d="M16 12.999c0 .439-.45 1-1 1H7.995c-.539 0-.994-.447-.995-.999H1c-.54 0-1-.561-1-1 0-2.634 3-4 3-4s.229-.409 0-1c-.841-.621-1.058-.59-1-3 .058-2.419 1.367-3 2.5-3s2.442.58 2.5 3c.058 2.41-.159 2.379-1 3-.229.59 0 1 0 1s1.549.711 2.42 2.088C9.196 9.369 10 8.999 10 8.999s.229-.409 0-1c-.841-.62-1.058-.59-1-3 .058-2.419 1.367-3 2.5-3s2.437.581 2.495 3c.059 2.41-.158 2.38-1 3-.229.59 0 1 0 1s3.005 1.366 3.005 4z"></path></svg>
					<?= $var["SystemUser_ID"] ?> Username: <FONT COLOR=BROWN><?= $var["SystemUser_username"] ?></FONT>&nbsp;Email:&nbsp;<FONT COLOR="BROWN"><?= $var["SystemUser_email"] ?></FONT>
					<A HREF="/<?= CreateEncoded ( array( 	
													"SystemUser_ID" => $URIEncryptedString["SystemUser_ID"],
													"SystemAdmin" => $URIEncryptedString["SystemAdmin"],
													"UserDetail" => $var["SystemUser_ID"],
													"MenuDescription" => $URIEncryptedString["MenuDescription"],						
													)); ?>/admin/userdetail">Get Detail</A>
				
				</div>
		
		
		
		
		
																	
			<?php
					
			}	 
		} 
	} else { ?>
			<div class="list-group-item f60">
				No user found.
			</div>
	<?php } ?>
	
	<BR>
	
</DIV>
				<form class="edit_user" id="" action="" accept-charset="UTF-8" method="post">
				<div class="list-group-item filtered f60 hundred">
					<span><B>Rep My Block Temp Users</B></span>  	          			
				</div>
					
			 	<DIV class="panels">	
				<?php

				if ( ! empty ($TempResult)) {
						foreach ($TempResult as $var) {
							if ( ! empty ($var)) { 
								
				?>
				
				<div class="list-group-item f60">
					<svg class="octicon octicon-organization" viewBox="0 0 16 16" version="1.1" width="16" height="16" aria-hidden="true"><path fill-rule="evenodd" d="M16 12.999c0 .439-.45 1-1 1H7.995c-.539 0-.994-.447-.995-.999H1c-.54 0-1-.561-1-1 0-2.634 3-4 3-4s.229-.409 0-1c-.841-.621-1.058-.59-1-3 .058-2.419 1.367-3 2.5-3s2.442.58 2.5 3c.058 2.41-.159 2.379-1 3-.229.59 0 1 0 1s1.549.711 2.42 2.088C9.196 9.369 10 8.999 10 8.999s.229-.409 0-1c-.841-.62-1.058-.59-1-3 .058-2.419 1.367-3 2.5-3s2.437.581 2.495 3c.059 2.41-.158 2.38-1 3-.229.59 0 1 0 1s3.005 1.366 3.005 4z"></path></svg>
					<?= $var["SystemTemporaryUser_ID"] ?> Email:&nbsp;<FONT COLOR="BROWN"><?= $var["SystemTemporaryUser_email"] ?></FONT>
					Reference:&nbsp;<FONT COLOR="BROWN"><?= $var["SystemTemporaryUser_reference"] ?></FONT>
					Made Permanent ID:&nbsp;<FONT COLOR="BROWN"><?= $var["SystemUser_ID"] ?></FONT>
					
					<A HREF="/<?= CreateEncoded ( array( 	
													"SystemUser_ID" => $URIEncryptedString["SystemUser_ID"],
													"SystemAdmin" => $URIEncryptedString["SystemAdmin"],
													"UserDetail" => $URIEncryptedString["SystemTempUser_ID"],
													"MenuDescription" => $URIEncryptedString["MenuDescription"],						
													)); ?>/admin/userdetail">Get Detail</A>
			
			<BR>
			
			
			
			
			
		</div>
		
		
		
		
		
																	
			<?php
					
			}	 
		} 
	} else { ?>
			<div class="list-group-item f60">
				No user found.
			</div>
	<?php } ?>
	
	<BR>
	
	<?php 
			
				$TheNewK = CreateEncoded ( array( 		
					"SystemUser_ID" => $URIEncryptedString["SystemUser_ID"],
					"&SystemAdmin" => $URIEncryptedString["SystemAdmin"],
					"&FirstName" => $URIEncryptedString["FirstName"],
					"&LastName" => $URIEncryptedString["LastName"],
					"&UniqNYSVoterID" => $URIEncryptedString["UniqNYSVoterID"],
					"&UserParty" => $URIEncryptedString["UserParty"],
					"&MenuDescription" => $URIEncryptedString["MenuDescription"]
					));
	?>
				
	<B><A HREF="/<?= $TheNewK ?>/lgd/team/admin">Look for a new voter</A></B>
	
			</DIV>
		</FORM>
		</DIV>
	</DIV>
</DIV>
<?php include $_SERVER["DOCUMENT_ROOT"] . "/common/footer.php";	?>
