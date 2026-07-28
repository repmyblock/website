<?php 
	require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/db/db_voterfile.php";
	$r = new VoterFile();
	include $_SERVER["DOCUMENT_ROOT"] . "/headers/headers.php";
?>
  <section>
    <h1>Volunteer Survey</h1>
    
    <p>Thanks for answering the survey.</P>
    	
    <P>We'll contact you very soon.</P>
    
    <P>	
    The voter lists will be shared with 
    	<A HREF="https://www.progcode.org" TARGET="political">https://progcode.org</A>,
    	<A HREF="https://repmyblock.org" TARGET="political">https://repmyblock.org</A> and any
    	campaign that wants it.
    </P>
		 			 	
		 </P>
   
   
  </section>
</div>
  </body>
<?php include $_SERVER["DOCUMENT_ROOT"] . "/headers/fpoter.php"; ?>
