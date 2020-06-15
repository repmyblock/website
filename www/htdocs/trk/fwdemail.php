<?php	
	require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/common/verif_sec.php";	
	require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/funcs/general.php";
	require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/db/db_login.php";  
  require $_SERVER["DOCUMENT_ROOT"] . "/../statlib/Config/Vars.php";
	include $_SERVER["DOCUMENT_ROOT"] . "/headers/headers.php"; 
?>			

<P>
	<CENTER><H1>Forwarded Email</H1></CENTER>
</P>

<P>
	You were forwarded this email by ### PERSON WHO SENT IT ###
	because they believe that you would be a perfect person to 
	represent their block.
</P>


<?php include $_SERVER["DOCUMENT_ROOT"] . "/headers/footer.php";	?>