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
					
					<BR>
					
							<A HREF="https://pbs.org/show/county" TARGET="PBS">
								<FONT COLOR="#FFFFFF">As seen on</FONT>		        
		            <svg xmlns="http://www.w3.org/2000/svg" width="135" height="35" viewBox="0 0 135 56">
		            	<path fill="#fff" d="M126.155 24.889c-3.072-1.595-5.522-2.878-5.522-5.328 0-1.75 1.478-2.8 4.006-2.8 2.955 0 5.6.972 7.622 2.178V12.6c-2.1-.894-5.017-1.672-7.622-1.672-7.389 0-10.695 4.394-10.695 9.177 0 5.6 3.773 8.284 7.895 10.462 4.083 2.177 5.639 3.11 5.639 5.444 0 1.983-1.711 3.111-4.589 3.111-4.006 0-6.806-1.828-8.672-3.305v6.727c1.711 1.206 5.405 2.645 8.594 2.645 7.156 0 11.706-3.733 11.706-9.761.038-6.3-5.289-8.945-8.362-10.54zM71.478 11.2h-8.867v33.6h6.611V34.106h1.323c8.283 0 13.416-4.395 13.416-11.473.04-7.155-4.627-11.433-12.483-11.433zm-2.256 5.6h1.945c3.889 0 6.378 2.255 6.378 5.717 0 3.772-2.295 5.91-6.34 5.91h-1.983V16.8zM105.117 26.717c2.256-1.556 3.344-3.85 3.344-6.923 0-5.289-3.888-8.594-10.189-8.594H88.006v33.6H98.7c8.206 0 11.939-5.289 11.939-10.189.039-3.85-2.1-6.844-5.522-7.894zm-7.35-9.84c2.606 0 4.278 1.595 4.278 4.123 0 2.528-1.828 4.161-4.628 4.161h-2.8v-8.244h3.15v-.04zM94.617 39.2V30.41h4.2c3.344 0 5.328 1.633 5.328 4.356 0 2.916-1.984 4.394-5.95 4.394h-3.578v.039zM56 28c0 15.478-12.522 28-28 28S0 43.478 0 28 12.522 0 28 0s28 12.522 28 28z"/>
		            	<path fill="#2638C4" d="M48.416 28.272l-3.11.622v5.756c0 1.944-1.595 3.461-3.656 3.461h-1.595V44.8h-5.133v-6.689h1.594c2.061 0 3.656-1.555 3.656-3.461v-5.756l3.111-.622c.661-.155 1.011-.894.7-1.478L35.816 11.2h5.095l8.166 15.594c.35.584 0 1.361-.66 1.478z"/>
		            	<path fill="#2638C4" d="M37.916 26.794L29.75 11.2h-8.44c-7.66 0-14.194 6.261-14 13.961.118 5.717 3.812 9.995 8.945 11.628V44.8h12.6v-6.689h1.595c2.06 0 3.655-1.555 3.655-3.461v-5.756l3.111-.622c.7-.116 1.05-.894.7-1.478zM27.34 25.9a3.203 3.203 0 01-3.19-3.189 3.203 3.203 0 013.19-3.189 3.203 3.203 0 013.189 3.19 3.203 3.203 0 01-3.19 3.188z"/>
		            </svg>
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
