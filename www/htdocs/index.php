<?php 
  $BigMenu = "home";
  if ( ! empty ($k)) { $MenuLogin = "logged"; }
  require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/common/verif_sec.php";  
  require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/funcs/general.php";
  include $_SERVER["DOCUMENT_ROOT"] . "/common/headers.php";
  
  $PBSLogo = "data:image/svg+xml;utf8,<svg xmlns='http://www.w3.org/2000/svg' width='135' " . 
             "height='35' viewBox='0 0 135 56'><path fill='%23fff' d='M126.155 24.889c-3.0" . 
             "72-1.595-5.522-2.878-5.522-5.328 0-1.75 1.478-2.8 4.006-2.8 2.955 0 5.6.972 " . 
             "7.622 2.178V12.6c-2.1-.894-5.017-1.672-7.622-1.672-7.389 0-10.695 4.394-10.6" . 
             "95 9.177 0 5.6 3.773 8.284 7.895 10.462 4.083 2.177 5.639 3.11 5.639 5.444 0" .
             " 1.983-1.711 3.111-4.589 3.111-4.006 0-6.806-1.828-8.672-3.305v6.727c1.711 1" . 
             ".206 5.405 2.645 8.594 2.645 7.156 0 11.706-3.733 11.706-9.761.038-6.3-5.289" . 
             "-8.945-8.362-10.54zM71.478 11.2h-8.867v33.6h6.611V34.106h1.323c8.283 0 13.41" . 
             "6-4.395 13.416-11.473.04-7.155-4.627-11.433-12.483-11.433zm-2.256 5.6h1.945c" . 
             "3.889 0 6.378 2.255 6.378 5.717 0 3.772-2.295 5.91-6.34 5.91h-1.983V16.8zM10" . 
             "5.117 26.717c2.256-1.556 3.344-3.85 3.344-6.923 0-5.289-3.888-8.594-10.189-8" . 
             ".594H88.006v33.6H98.7c8.206 0 11.939-5.289 11.939-10.189.039-3.85-2.1-6.844-" . 
             "5.522-7.894zm-7.35-9.84c2.606 0 4.278 1.595 4.278 4.123 0 2.528-1.828 4.161-" . 
             "4.628 4.161h-2.8v-8.244h3.15v-.04zM94.617 39.2V30.41h4.2c3.344 0 5.328 1.633" . 
             " 5.328 4.356 0 2.916-1.984 4.394-5.95 4.394h-3.578v.039zM56 28c0 15.478-12.5" . 
             "22 28-28 28S0 43.478 0 28 12.522 0 28 0s28 12.522 28 28z'/><path fill='%2326" . 
             "38C4' d='M48.416 28.272l-3.11.622v5.756c0 1.944-1.595 3.461-3.656 3.461h-1.5" . 
             "95V44.8h-5.133v-6.689h1.594c2.061 0 3.656-1.555 3.656-3.461v-5.756l3.111-.62" . 
             "2c.661-.155 1.011-.894.7-1.478L35.816 11.2h5.095l8.166 15.594c.35.584 0 1.36" .
             "1-.66 1.478z'/><path fill='%232638C4' d='M37.916 26.794L29.75 11.2h-8.44c-7." . 
             "66 0-14.194 6.261-14 13.961.118 5.717 3.812 9.995 8.945 11.628V44.8h12.6v-6." .
             "689h1.595c2.06 0 3.655-1.555 3.655-3.461v-5.756l3.111-.622c.7-.116 1.05-.894" . 
             ".7-1.478zM27.34 25.9a3.203 3.203 0 01-3.19-3.189 3.203 3.203 0 013.19-3.189 " . 
             "3.203 3.203 0 013.189 3.19 3.203 3.203 0 01-3.19 3.188z'/></svg>";  
?>



    <DIV class="main center">
      
      <P>
        Rep My Block is a free, end-to-end package for candidates running for office who lack 
        the resources to pay political consultants.
      </P>
      
      <P>
        We have build a series of video programs to 
        <A HREF="/<?= $middleuri ?>/training/steps/torun" class="">describe the problem</A>
        and what to expect when running
        <A HREF="/<?= $middleuri ?>/training/zoom/withpaperboy" class="">with Paperboy Love Prince</A>
      </P>
      
      
      <DIV class="tadpad BlueBox w3-blue">
      	<P class="nopad">
        	<A HREF="/<?= $middleuri ?>/training/steps/torun" class="w3-blue w3-hover-text-red">Run for County Committee !</a>
        </P>
        <P class="nopad">
        <A HREF="https://pbs.org/show/county" TARGET="PBS"><FONT COLOR="#FFFFFF">As seen on</FONT><IMG SRC="<?= $PBSLogo ?>"></a>  
        </P>
      </DIV>

      <DIV class="BckGrndElement f80">CANDIDATES VOTER & VOLUNTEER GUIDE</DIV>

      <DIV class="f40 adpad">
        <A HREF="/<?= $middleuri ?>/voter/guide">
          <H2>Download the RepMyBlock Voter & Volunteer Guide</H2>
        </a>
      </DIV>

      <DIV class="f40 adpad">
        These candidates are running for office and are looking for volunteers to help them.
      </DIV>

      <DIV class="BckGrndElement f80">REPRESENT YOUR BLOCK AT YOUR PARTY COMMITTEE</DIV>

      <DIV class="f60 adpad">
        <A class="action-runfor RunCC" HREF="/<?= $middleuri ?>/register/user"><img class="action-runfor" src="/images/options/RunFor.png" alt="RUN FOR COUNTY COMMITTEE"></A>
        <A class="action-runfor NomCandidate" HREF="/<?= $middleuri ?>/propose/nomination"><img class="action-runfor" src="/images/options/Nominate.png" alt="NOMINATE A CANDIDATE"></A>
      </DIV>
      
<?php $x = "52"; ?>

<?php
	$RunText['line1'] = "RUN FOR";
	$RunText['line2'] = "COUNTY";
	$RunText['line3'] = "COMMITTEE";

	$RunForCounty="<svg width='182' height='100' viewBox='0 0 200 100' " .
							  "xmlns='http://www.w3.org/2000/svg' role='img' " .
							  "aria-label='Nominate a Candidate'>" .
							  "<polygon points='89.5,95.4 7.9,95.4 34.8,35.5 99.5,26.8' fill='%23ED2B61'/>" .
							  "<text x='" . $x . "' y='54' text-anchor='start' " .
							  "font-family='Montserrat, Arial, sans-serif' " .
							  "font-size='14' font-weight='800' font-style='italic' fill='%2316317D' " .
							  ">" . $RunText['line1'] . "</text> " .
							  "<text x='" . $x . "' y='68' text-anchor='start' " .
							  "font-family='Montserrat, Arial, sans-serif' " .
							  "font-size='14' font-weight='800' font-style='italic' fill='%2316317D' " .
							  ">" . $RunText['line2'] . "</text>" .
							  "<text x='" . $x . "' y='84' text-anchor='start' " .
							  "font-family='Montserrat, Arial, sans-serif' " .
							  "font-size='14' font-weight='800' font-style='italic' fill='%2316317D' " .
							  ">" . $RunText['line3'] . "</text>" .
								"</svg>";
?>
      
<IMG SRC="data:image/svg+xml;utf8,<?= $RunForCounty ?>">

      

<svg
  width="182" height="100" viewBox="0 0 200 100" 
  xmlns="http://www.w3.org/2000/svg" role="img" 
  aria-label="Nominate a Candidate">

  <!-- Yellow background shape -->
  <polygon points="89.5,95.4 7.9,95.4 34.8,35.5 99.5,26.8" fill="#ED2B61"/>

  <!-- Text -->
  <text x="<?= $x ?>" y="54" text-anchor="start"
    font-family="Montserrat, Arial, sans-serif"
    font-size="14" font-weight="800" font-style="italic" fill="#16317D"
  >RUN FOR</text>

  <text x="<?= $x ?>" y="68" text-anchor="start"
    font-family="Montserrat, Arial, sans-serif"
    font-size="14" font-weight="800" font-style="italic" fill="#16317D"
  >COUNTY</text>

  <text x="<?= $x ?>" y="84" text-anchor="start"
    font-family="Montserrat, Arial, sans-serif"
    font-size="14" font-weight="800" font-style="italic" fill="#16317D"
  >COMMITTEE</text>
</svg>


<svg
  width="182" height="100" viewBox="0 0 200 100" 
  xmlns="http://www.w3.org/2000/svg" role="img" 
  aria-label="Nominate a Candidate">

  <!-- Yellow background shape -->
  <polygon points="89.5,95.4 7.9,95.4 34.8,35.5 99.5,26.8" fill="#ED2B61"/>

  <!-- Text -->
  <text x="<?= $x ?>" y="54" text-anchor="start"
    font-family="Montserrat, Arial, sans-serif"
    font-size="14" font-weight="800" font-style="italic" fill="#16317D"
  >RUN FOR</text>

  <text x="<?= $x ?>" y="68" text-anchor="start"
    font-family="Montserrat, Arial, sans-serif"
    font-size="14" font-weight="800" font-style="italic" fill="#16317D"
  >PRECINCT</text>

  <text x="<?= $x ?>" y="84" text-anchor="start"
    font-family="Montserrat, Arial, sans-serif"
    font-size="14" font-weight="800" font-style="italic" fill="#16317D"
  >CAPTAIN</text>
</svg>


<svg
  width="182" height="100" viewBox="0 0 200 100" 
  xmlns="http://www.w3.org/2000/svg" role="img" 
  aria-label="Nominate a Candidate">

  <!-- Yellow background shape -->
  <polygon points="89.5,95.4 7.9,95.4 34.8,35.5 99.5,26.8" fill="#FCED00"/>

  <!-- Text -->
  <text x="<?= $x ?>" y="58" text-anchor="start"
    font-family="Montserrat, Arial, sans-serif"
    font-size="14" font-weight="800" font-style="italic" fill="#16317D"
  >NOMINATE A</text>

  <text x="<?= $x ?>" y="74" text-anchor="start"
    font-family="Montserrat, Arial, sans-serif"
    font-size="14" font-weight="800" font-style="italic" fill="#16317D"
  >CANDIDATE</text>
</svg>



    </div>

<?php include $_SERVER["DOCUMENT_ROOT"] . "/common/footer.php"; ?>
