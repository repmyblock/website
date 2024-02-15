<?php 
	$BigMenu = "home";
	if ( ! empty ($k)) { $MenuLogin = "logged"; }

	require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/common/verif_sec.php";	
	
	require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/funcs/general.php";
	include $_SERVER["DOCUMENT_ROOT"] . "/common/headers.php";
	/* User is logged */
?>


<script src="/js/video.js"></script>

<div class="main_wopad center">

<?php /*
<script src="/js/swiper-bundle.min.js"></script>
<link rel="stylesheet" href="/css/swiper-bundle.min.css"/>
<link rel="stylesheet" href="/css/Video.css"/>

<div class="gallery-slider">
  <div class="swiper-container">
    <div class="swiper-wrapper">
	    <div class="swiper-slide">
				*/ ?>
				
						<DIV class="tadpad">
						<P class="BlueBox">
							<A HREF="/<?= $middleuri ?>/training/steps/torun" class="w3-blue w3-hover-text-red">
								Run for County Committee !
								<?php /* <BR>Click here! - Deadline March 31<SUP>st</SUP>, 2023. */ ?>
							</a>
						</P>
					</DIV>
	
						<P class="BckGrndElement f80">CANDIDATES VOTER & VOLUNTEER GUIDE</P>

							<P class="f40 adpad">
								<A HREF="/<?= $middleuri ?>/voter/guide">
									<H2>Download the RepMyBlock Voter & Volunteer Guide</H2>
								</a>
							</P>
							
							<P class="f40 adpad">
								These candidates are running for office and are looking for volunteers to help them.
							</P>
							
		 
					<P class="BckGrndElement f80">REPRESENT YOUR BLOCK AT YOUR PARTY COMMITTEE</P>


			
					
					
					<DIV class="f60 adpad">
						<A class="action-runfor" HREF="/<?= $middleuri ?>/register/user" class="RunCC"><img class="action-runfor" src="/images/options/RunFor.png" alt="RUN FOR COUNTY COMMITTEE"></A>
						<A class="action-runfor" HREF="/<?= $middleuri ?>/propose/nomination" class="NomCandidate"><img class="action-runfor" src="/images/options/Nominate.png" alt="NOMINATE A CANDIDATE"></A>
					</DIV>
					

					
					<BR>
				
<?php /* 	
		  </div>  
		   <div class="swiper-slide">
		  
		  
		
						
	
		  </div>
		  
		  
		</div>
	</DIV>
	  
	   <!-- Add Arrows -->
  <div class="swiper-button-next -dark" video-buttons></div>
  <div class="swiper-button-prev -dark" video-buttons></div>

</DIV>
      
	 */ ?>

		

	
	
	
	

	
	
</div>

<?php include $_SERVER["DOCUMENT_ROOT"] . "/common/footer.php"; ?>
