<?php
	$Menu = "voters";
	$BigMenu = "represent";	
	
	require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/common/verif_nolog.php";	
	require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/funcs/general.php";
	require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/db/db_trac.php";  

	include $_SERVER["DOCUMENT_ROOT"] . "/common/headers.php"; 	

	$bugnumber = 21;

?>	


<div class="main">
	<DIV CLASS="intro center">
		<P>
			<h1 CLASS="intro">Thanks for filling a bug report!</H1>
		</P>
		
		<P>
			This bug was assigned # <B><?= $bugnumber ?></B> and <B><A HREF="https://trac.repmyblock.nyc/ticket/<?= $bugnumber ?>">you can access your bug repport here</A></B><BR>
		</P>
		
		<P>
			This is the help that is required to make this website better and the more people 
			participate, the better it will get.
		</P>
		
		<P>
			I will work on fixing it as soon as possible and I'll send you an email as soon as it is fixed.<BR>
			<A><A HREF="https://trac.repmyblock.nyc/report/1">You can view the whole list of bugs here</A><BR>
		</P>
		
		<P>
			<h2>Th&eacute;o Chino</h2><BR>
			<I>Co-Founder of the Rep My Block website.</I>
		</P>
		
</DIV>

</div>
	<?php // print phpinfo(); ?>

<?php include $_SERVER["DOCUMENT_ROOT"] . "/common/footer.php"; ?>