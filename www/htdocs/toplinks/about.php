<?php 
	/***************************
	* File: about.php
	* Purpose: About page that explain what this software is about.
	* Author: Theo Chino
	*/
	
	$BigMenu = "about";
	if ( ! empty ($k)) { $MenuLogin = "logged"; }
	
	$HeaderTwitter = 1; /* This is needed to trigger the different header */
	$HeaderTwitterPicLink = "https://static.repmyblock.org/pics/paste/AboutPageNonPartisan.jpg";
	$HeaderTwitterDesc = "Get your nominating petition kit here! The County Committee is the most basic committee of the Democratic and Republican Parties; its their backbone. The &hellip; Continue reading Rep My Block &rarr;";
	$HeaderTwitterTitle = "Create your faction inside the Democratic or Republican party.";     
	
	require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/common/verif_sec.php";	
	require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/funcs/general.php";
	include $_SERVER["DOCUMENT_ROOT"] . "/common/headers.php"; 
	/* User is logged */
?>


<DIV class="main_wopad">
	<DIV class="intro center">
			<DIV class="tadpad">
				<P class="BlueBox w3-blue">
			Rep My Block is a non partisan website
		</P>
	</DIV>
	</DIV>
	
	<DIV CLASS="intro">
		<P class="f40 adpad">
			Rep My Block is a non-partisan effort to collect, organize, and make accessible the membership of local party 
			rosters across the United States. The basis of good local governance is transparency at every level.
		</P>
	</DIV>
	
		<P class="f80 center adpad"><A HREF="/<?= $middleuri ?>/register/user">Register on the Rep My Block website</A></P>
	
			<P class="BckGrndElement f80 center">WHAT IS THE COUNTY COMMITTEE</P>

	<P class="f60 adpad">
		<B>The County Committee is the body that elects the party county chair.</B>
	</P>
	
	<P class="adpad">
		<DIV class="videowrapper center">
	 		<iframe src="https://www.youtube.com/embed/CD3dwRtVY64?feature=oembed" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
	</DIV>
</P>
	
		<P class="f40 adpad">
		The most important responsibilities of a county committee member are to elect the chairperson of the party and to select a replacement for any state assembly member that
		resigns or that can no longer fulfill their duties as an assembly member. 
	</P>
	
	<P class="f40 adpad">
		<B>The time commitment is about 32 hours every two years or about 3 minutes a day.</B>
	</P>
							
							<P class="f80 center adpad"><A HREF="/<?= $middleuri ?>/register/user">Register on the Rep My Block website</A></P>
	
	<a name="higheroffice"></A> 
	<P class="BckGrndElement f80 center">RUNNING FOR HIGHER OFFICE</P>

	<P class="f40 adpad">
		<B>Sal Albanese</B>, <B>Badrun Khan</B>, <B>Ben Yee</B>, <B>Vittoria Fariello</B>, and <B>Jared Rich</B> discuss the 
		weaponization of the electoral process with Paperboy Love Prince in five one-hour candid chats. 
	</P>
	
	<P class="f40 adpad">
		<B><A HREF="/<?= $middleuri ?>/training/zoom/withpaperboy">These videos</A></B> were 
		recorded while Paperboy Love Prince was running for congress, and discovering first-hand, the different steps 
		involved in running for public office. The goal of these video chats is to demonstrate that there is hope, but 
		it will require every voter to participate in the political process by going beyond just showing up to the polls 
		to vote. <B>Democracy depends on it!</B>
	</P>

	
	<P class="adpad">
		<P class="center f80"><A HREF="/<?= $middleuri ?>/training/zoom/withpaperboy">Access the video chats</A></P>
	</P>
	
	<P class="f80 center adpad"><A HREF="/<?= $middleuri ?>/register/user">Register on the Rep My Block website</A></P>
	
	<a name="tendencies"></A>
	<P class="BckGrndElement f80 center">THE MAJOR POLITICAL TENDENCIES</P>
	
	<P class="f40 adpad">
		The world is run by various political ideologies competing against each other. Rep My Block 
		is non-partisan; therefore, we welcome all ideologies and help them contact the local 
		representatives of those ideologies.
	</P>
	
	<P class="f40 adpad">
		Rep My Block uses the European Model to describe the different between the Left and the Right. 
		<B>For more information
	visit <A TARGET="new" HREF="https://politicalcenter.org">https://politicalcenter.org</A></B>.
	</P>
	
<style>
	#party-container {
  text-align: center;
}

.button2-group {
  display: flex;
  justify-content: center;
  gap: 12px;
}

.party-row {
  display: flex;
  justify-content: center;
  gap: 16px;
}
</style>
	

	 <div>
		 

		  <div class="button2-group" style="padding-bottom: 15px;">
		    <button type="button" class="button2 model-btn" data-model="eu">European Model</button>
		    <button type="button" class="button2 model-btn" data-model="us">American Model</button>
		  </div>
		  
		  
		  <div class="button2-group" style="padding-bottom: 15px;">
		    <button type="button" class="button2 model-btn" data-model="eu" style="padding: 30px 150px 30px 150px">https://europeanmodel.org</button>
		    <button type="button" class="button2 model-btn" data-model="us" style="padding: 30px 150px  30px 150px"> https://americanmodel.org</button>
		  </div>
		  
	
		  <div class="button2-group" style="padding-bottom: 15px;">
				<button type="button" class="button2 axis-btn" data-axis="left">Left</button>
				<button type="button" class="button2 axis-btn" data-axis="center">Center</button>
				<button type="button" class="button2 axis-btn" data-axis="right">Right</button>
		  </div>
		</div>
		

  	<div id="party-container">
		  <div id="party-top" class="party-row">
		    <img class="candidate" id="pir" data-party="pir" alt="Pirate" src="/shared/teams/pirates/Pirate.png">
		    <img class="candidate" id="ipa" data-party="ipa" alt="International People's Party" src="/shared/teams/ipa/ipa.png">
		    <img class="candidate" id="isa" data-party="isa" alt="Socialist Alternative" src="/shared/teams/socalternative/ISAlternative.png">
		    <img class="candidate" id="com" data-party="com" alt="Communists" src="/shared/teams/communists/solidnet.png">
		    <img class="candidate" id="pri" data-party="pri" alt="Progressive International" src="/shared/teams/proginternational/ProgInternational.png">
		    <img class="candidate" id="gre" data-party="gre" alt="Greens" src="/shared/teams/greens/Greens.png">
		    <img class="candidate" id="soc" data-party="soc" alt="Socialists" src="/shared/teams/socialists/Socialists.png">
		    <img class="candidate" id="pra" data-party="pra" alt="Progressive Alliance" src="/shared/teams/progalliance/ProgAlliance.png">
		  </div>
								
			<div id="party-bottom" class="party-row">
        <IMG class="candidate" ALT="Liberals"  id="lib" class="candidate imglogo" SRC="/shared/teams/liberals/LiberalInternational.png">
        <IMG class="candidate" ALT="Christian Democrats"  id="cdu" class="candidate imglogo" SRC="/shared/teams/christiansdemocrats/IDC.png">
        <IMG class="candidate" ALT="Libertarians"  id="lbt" class="candidate imglogo" SRC="/shared/teams/libertarians/Libertarian.png">
        <IMG class="candidate" ALT="Democratic Union"  id="idu" class="candidate imglogo" SRC="/shared/teams/democrats/IDU.png">
        <IMG class="candidate" ALT="Indentity and Democracy"  id="con" class="candidate imglogo" SRC="/shared/teams/identity/Conservatives.png">
			</div>
		</div>						 									   
               					
           	    					
               					
               												
              
  <UL class="f40 adpad">
  	<B><A TARGET="political" TARGET="political" HREF="https://patriotcaucus.us">Patriots</A>:</B> Conservative Party USA: <A TARGET="political" HREF="https://conservativepartyusa.org">https://conservativepartyusa.org</A><BR>
    <B><A TARGET="political" TARGET="political" HREF="https://democraticcaucus.us">Democrat Union</A>:</B> Republican National Committee: <A TARGET="political" HREF="https://gop.com">https://gop.com</A><BR>
    <B><A TARGET="political" TARGET="political" HREF="https://libertariancaucus.us">International Alliance of Libertarian Parties</A>:</B> Libertarian: <A TARGET="political" HREF="https://www.lp.org">https://www.lp.org</A><BR>
    <B><A TARGET="political" TARGET="political" HREF="https://centristcaucus.us">Centrist Democrat</A>:</B> Frederick Douglass Freedom Alliance: <A TARGET="political" HREF="https://fdfalliance.org">https://fdfalliance.org</A><BR>
    <B><A TARGET="political" TARGET="political" HREF="https://liberalcaucus.us">Liberals and centrists</A>:</B> Center for New Liberalism: <A TARGET="political" HREF="https://cnliberalism.org">https://cnliberalism.org</A><BR>
    <B><A TARGET="political" TARGET="political" HREF="https://socialistcaucus.us">Progressive Alliance</A>:</B> Progressive Democrats of America: <A TARGET="political" HREF="https://pdamerica.org">https://pdamerica.org</A><BR>
    <B><A TARGET="political" TARGET="political" HREF="https://socialistcaucus.us">Social democrats and Socialists</A>:</B> Social Democrats of America: <A TARGET="political" HREF="https://socialists.us">https://socialists.us</A><BR>
    <B><A TARGET="political" TARGET="political" HREF="https://greencaucus.us">Greens and regionalists</A>:</B> Global Greens USA: <A TARGET="political" HREF="https://globalgreens.us">https://globalgreens.us</A><BR>
    <B><A TARGET="political" TARGET="political" HREF="https://progressivecaucus.us">Progressive International</A>:</B> Democrat Socialists of America: <A TARGET="political" HREF="https://www.dsausa.org">https://www.dsausa.org</A><BR>
    <B><A TARGET="political" TARGET="political" HREF="https://communistcaucus.us">Communists and Workers' parties</A>:</B> Communist Party USA: <A TARGET="political" HREF="https://www.cpusa.org">https://www.cpusa.org</A><BR>
    <B><A TARGET="political" TARGET="political" HREF="https://revolutionarycaucus.us">Socialists Alternative</A>:</B> Socialist Alternative: <A TARGET="political" HREF="https://socialistalternative.org">https://socialistalternative.org</A><BR>
		<B><A TARGET="political" TARGET="political" HREF="https://revolutionarycaucus.us">International People's Assembly</A>:</B> Party for Socialism and Liberation: <A TARGET="politital" HREF="https://pslweb.org">https://pslweb.org</A></A><BR>
    <B><A TARGET="political" TARGET="political" HREF="https://anarchistcaucus.us">Pirates Parties International</A>:</B> United States Pirate Party: <A TARGET="political" HREF="https://uspirates.org">https://uspirates.org</A><BR>
	</UL>
					

<script>
/* =========================================================
   DATA
   ========================================================= */

const MODELS = {
  eu: {
    top: ['pir','ipa','isa','com','pri','gre','soc','pra'],
    bottom: ['lib','cdu','lbt','idu','con']
  },
  us: {
    top: ['pir','ipa','isa','com','pri','gre','soc','pra','lib','cdu'],
    bottom: ['lbt','idu','con']
  }
};

const AXIS = {
  eu: {
    left:   ['pir','ipa','isa','com','pri','gre','soc','pra'],
    center: ['soc','pra','lib'],
    right:  ['lib','cdu','lbt','idu','con']
  },
  us: {
    left:   ['pir','ipa','isa','com','pri','gre','soc','pra','lib','cdu'],
    center: ['pra','lib','cdu'],
    right:  ['lbt','idu','con']
  }
};

const PARTY_INFO = {
  pir:{name:'Pirate Parties',desc:'Digital rights & transparency<BR><B>US:</B> Pirate Party'},
  ipa:{name:'People’s Party',desc:'International solidarity<BR><B>US:</B> Party for Socialism and Liberation'},
  isa:{name:'Socialist Alternative',desc:'Revolutionary socialism<BR><B>US:</B> Socialist Alternative'},
  com:{name:'Communists',desc:'Marxist traditions<BR><B>US:</B> Communist Party, USA'},
  pri:{name:'Progressive International',desc:'Global progressives<BR><B>US:</B> Democrat Socialists of America'},
  gre:{name:'Greens',desc:'Ecology & climate justice<BR><B>US:</B> Global Greens USA'},
  soc:{name:'Socialists',desc:'Social Democratic Socialism<BR><B>US:</B> Social Democrats of America'},
  pra:{name:'Progressive Alliance',desc:'Progressivism<BR><B>US:</B> Progressive Democrats of America'},
  lib:{name:'Liberals',desc:'Civil liberties & markets<BR><B>US:</B> Center for New Liberalism'},
  cdu:{name:'Christian Democrats',desc:'Social market economy<BR><B>US:</B> Frederick Douglass Foundation'},
  lbt:{name:'Libertarians',desc:'Individual liberty<BR><B>US:</B> Libertarian Party'},
  idu:{name:'Democratic Union',desc:'Conservative alliance<BR><B>US:</B> Republican National Committee'},
  con:{name:'Patriots',desc:'National conservatism<BR><B>US:</B> Conservative Party'}
};

/* =========================================================
   STATE
   ========================================================= */

let currentModel = null;
let currentAxis  = null;

/* =========================================================
   DOM
   ========================================================= */

const topRow   = document.getElementById('party-top');
const bottomRow= document.getElementById('party-bottom');
const tooltip  = document.getElementById('party-tooltip');

const modelBtns = document.querySelectorAll('.model-btn');
const axisBtns  = document.querySelectorAll('.axis-btn');
const candidates = document.querySelectorAll('.candidate');
const selectedInput = document.getElementById('SelectedParty');

/* =========================================================
   PARTY CLICK (POST FIX)
   ========================================================= */

candidates.forEach(img => {
  img.addEventListener('click', () => {

    // toggle logic
    if (img.classList.contains('selected')) {
      img.classList.remove('selected');
      selectedInput.value = '';
      return;
    }

    // single selection
    candidates.forEach(c => c.classList.remove('selected'));
    img.classList.add('selected');

    // 🔑 value sent via POST
    selectedInput.value = img.dataset.party || img.id;
  });

  // tooltip
  img.addEventListener('mouseenter', e => {
    const p = PARTY_INFO[img.id];
    if (!p) return;
    tooltip.innerHTML = `<strong>${p.name}</strong><br>${p.desc}`;
    tooltip.style.opacity = 1;
  });

  img.addEventListener('mousemove', e => {
    tooltip.style.left = e.clientX + 15 + 'px';
    tooltip.style.top  = e.clientY + 15 + 'px';
  });

  img.addEventListener('mouseleave', () => {
    tooltip.style.opacity = 0;
  });
});

/* =========================================================
   HELPERS
   ========================================================= */

function showAll() {
  candidates.forEach(c => c.classList.add('active'));
}

function setAxisEnabled(enabled) {
  axisBtns.forEach(b => {
    b.style.pointerEvents = enabled ? 'auto' : 'none';
    b.style.opacity = enabled ? '' : '0.35';
  });
}

function updateAxisColors(model) {
  const L = document.querySelector('[data-axis="left"]');
  const R = document.querySelector('[data-axis="right"]');

  L.classList.remove('axis-left-red','axis-left-blue');
  R.classList.remove('axis-right-red','axis-right-blue');

  if (model === 'us') {
    L.classList.add('axis-left-blue');
    R.classList.add('axis-right-red');
  } else {
    L.classList.add('axis-left-red');
    R.classList.add('axis-right-blue');
  }
}

function applyModel(model) {
  currentModel = model;

  const topFrag = document.createDocumentFragment();
  const bottomFrag = document.createDocumentFragment();

  MODELS[model].top.forEach(id => {
    const el = document.getElementById(id);
    if (el) topFrag.appendChild(el);
  });

  MODELS[model].bottom.forEach(id => {
    const el = document.getElementById(id);
    if (el) bottomFrag.appendChild(el);
  });

  // clear rows SAFELY
  while (topRow.firstChild) topRow.removeChild(topRow.firstChild);
  while (bottomRow.firstChild) bottomRow.removeChild(bottomRow.firstChild);

  // reattach
  topRow.appendChild(topFrag);
  bottomRow.appendChild(bottomFrag);

  updateAxisColors(model);

  if (currentAxis) {
    applyAxis(currentAxis);
  } else {
    showAll();
  }
}
function applyAxis(axis) {
  if (!currentModel) return;
  currentAxis = axis;

  const allowed = new Set(AXIS[currentModel][axis]);

  candidates.forEach(c => {
    c.classList.toggle('active', allowed.has(c.id));
  });
}

/* =========================================================
   EVENTS
   ========================================================= */

modelBtns.forEach(btn => {
  btn.onclick = () => {
    const model = btn.dataset.model;

    if (currentModel === model) {
      currentModel = null;
      modelBtns.forEach(b => b.classList.remove('active'));
      axisBtns.forEach(b => b.classList.remove('active'));
      setAxisEnabled(false);
      showAll();
      return;
    }

    modelBtns.forEach(b => b.classList.remove('active'));
    btn.classList.add('active');
    setAxisEnabled(true);
    applyModel(model);
  };
});

axisBtns.forEach(btn => {
  btn.onclick = () => {
    axisBtns.forEach(b => b.classList.remove('active'));
    btn.classList.add('active');
    applyAxis(btn.dataset.axis);
  };
});

/* =========================================================
   INIT
   ========================================================= */

showAll();
setAxisEnabled(false);
</script>


 	

	
	 <STYLE>
							/* =====================================================
   BUTTON BASE
   ===================================================== */
.button2 {
  border: none;
  cursor: pointer;
  display: inline-flex;
  align-items: center;
  justify-content: center;
  width: 140px;
  height: 28px;
  font-size: 15px;
  font-weight: 600;
  color: #fff;
  transition: opacity .2s, transform .15s;
}

.button2:hover {
  transform: scale(1.05);
}

.button2-group {
  display: flex;
  gap: 12px;
  flex-wrap: wrap;
}

/* =====================================================
   MODEL BUTTONS
   ===================================================== */
.model-btn {
  opacity: .35;
}

.model-btn[data-model="eu"] { background:#2b6cff; }
.model-btn[data-model="us"] { background:#cc0000; }

.model-btn.active {
  opacity: 1;
  border: 2px solid #000;
}

/* =====================================================
   AXIS BUTTONS
   ===================================================== */
.axis-btn {
  background:#6e6a6a;
  opacity:.35;
}

.axis-btn.active {
  opacity:1;
  border:2px solid #000;
}

/* axis colors (always present, visibility via opacity) */
.axis-left-red   { background:#cc0000; }
.axis-right-red  { background:#cc0000; }
.axis-left-blue  { background:#2b6cff; }
.axis-right-blue { background:#2b6cff; }

/* =====================================================
   PARTY GRID
   ===================================================== */
.party-row {
  display:flex;
  gap:16px;
  margin-bottom:12px;
}

.candidate {
  width: 64px;
  cursor: pointer;
  opacity: 0.35;
  transition: opacity .2s, transform .15s, box-shadow .15s;
}

.candidate.active {
  opacity: 1;
  /*   transform:scale(1.05); */
}

.candidate.selected {
  opacity: 1;
  transform: scale(1.1);
  box-shadow: 0 0 0 3px #000;
  border-radius: 6px;
  
  /*
   border:3px solid #000;
  padding:4px;
  box-sizing:border-box; 
  */
}


/* =====================================================
   TOOLTIP
   ===================================================== */
#party-tooltip {
  position:fixed;
  z-index:9999;
  background:#111;
  color:#fff;
  padding:10px 12px;
  border-radius:6px;
  max-width:260px;
  font-size:13px;
  opacity:0;
  pointer-events:none;
  transition:opacity .15s;
}

		</STYLE>
    
	
	
	<a name="vendors"></A>
	<P class="BckGrndElement f80 center">POLITICAL VENDORS</P>
	
	<P class="f40 adpad">
		Political campaigns has vendors that will help you organize your campaign. We provide this list 
		as is.
	</P>
	
	<P class="adpad">
		<P class="center f60"><A HREF="/<?= $middleuri ?>/vendors/list">Access the vendor list</A></P>
	</P>
	
	<P class="f40 adpad">
		The goal of Rep My Block is to suppress the role of money in the political conversation while 
		respecting each individual's ideology without judgment.
	</P>
	
		<P class="f80 center adpad"><A HREF="/<?= $middleuri ?>/register/user">Register on the Rep My Block website</A></P>
	
</div>

<?php include $_SERVER["DOCUMENT_ROOT"] . "/common/footer.php"; ?>
