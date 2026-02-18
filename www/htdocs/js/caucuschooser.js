/* =========================================================
   ======================= DATA ============================
   ========================================================= */

/* ------------------ CAUCUS ------------------ */

const CAUCUS_INFO = {
  cpc:{name:'Congressional Progressive Caucus',desc:'Center-left and left-wing Democrats.'},
  ndc:{name:'New Democrat Coalition',desc:'Socially liberal and fiscally moderate.'},
  blu:{name:'Blue Dog Coalition',desc:'Most conservative grouping of Democrats.'},
  rgg:{name:'Republican Governance Group',desc:'Moderate Republicans.'},
  msd:{name:'Main Street Caucus',desc:'Pragmatic conservative Republicans.'},
  rsc:{name:'Republican Study Committee',desc:'Largest conservative caucus.'},
  fre:{name:'Freedom Caucus',desc:'Most conservative bloc.'}
};

const CAUCUS = {
  dem: ['cpc','ndc','blu'],
  gop: ['rgg','msd','rsc','fre'],
  trp: null
};

const CAUCUS_BITS = {
  cpc:1, ndc:2, blu:4,
  rgg:8, msd:16, rsc:32, fre:64
};


/* ------------------ PERSUASION ------------------ */

const MODELS = {
  eu:{
    top:['pir','ipa','isa','com','pri','gre','soc','pra'],
    bottom:['lib','cdu','lbt','idu','con']
  },
  us:{
    top:['pir','ipa','isa','com','pri','gre','soc','pra','lib','cdu'],
    bottom:['lbt','idu','con']
  }
};

const AXIS = {
  eu:{
    left:['pir','ipa','isa','com','pri','gre','soc','pra'],
    center:['soc','pra','lib'],
    right:['lib','cdu','lbt','idu','con']
  },
  us:{
    left:['pir','ipa','isa','com','pri','gre','soc','pra','lib','cdu'],
    center:['pra','lib','cdu'],
    right:['lbt','idu','con']
  }
};

const PARTY_INFO = {
  pir:{name:'Pirate Parties',desc:'Digital rights & transparency'},
  ipa:{name:'People’s Party',desc:'International solidarity'},
  isa:{name:'Socialist Alternative',desc:'Revolutionary socialism'},
  com:{name:'Communists',desc:'Marxist traditions'},
  pri:{name:'Progressive International',desc:'Global progressives'},
  gre:{name:'Greens',desc:'Ecology & climate justice'},
  soc:{name:'Socialists',desc:'Social Democratic Socialism'},
  pra:{name:'Progressive Alliance',desc:'Progressivism'},
  lib:{name:'Liberals',desc:'Civil liberties & markets'},
  cdu:{name:'Christian Democrats',desc:'Social market economy'},
  lbt:{name:'Libertarians',desc:'Individual liberty'},
  idu:{name:'Democratic Union',desc:'Conservative alliance'},
  con:{name:'Patriots',desc:'National conservatism'}
};


/* =========================================================
   ======================== STATE ==========================
   ========================================================= */

let currentModel = null;
let currentAxis  = null;
let currentCaucusParty = null;


/* =========================================================
   ========================= DOM ===========================
   ========================================================= */

const tooltip = document.getElementById('party-tooltip');

const persuasionCandidates =
  document.querySelectorAll('.persuasion-candidate');

const caucusCandidates =
  document.querySelectorAll('.caucus-candidate');

const modelBtns = document.querySelectorAll('.model-btn');
const axisBtns  = document.querySelectorAll('.axis-btn');
const caucusBtns= document.querySelectorAll('.caucus-btn');

const topRow = document.getElementById('party-top');
const bottomRow = document.getElementById('party-bottom');

const selectedPartyInput = document.getElementById('SelectedParty');
const selectedCaucusMask = document.getElementById('SelectedCaucusMask');
const selectedCaucusParty= document.getElementById('SelectedCaucusParty');


/* =========================================================
   ======================== TOOLTIP ========================
   ========================================================= */

function attachTooltip(elements, source){
  elements.forEach(el=>{
    el.addEventListener('mouseenter',e=>{
      const info = source[el.id];
      if(!info) return;
      tooltip.innerHTML =
        `<strong>${info.name}</strong><br>${info.desc}`;
      tooltip.style.opacity = 1;
    });
    el.addEventListener('mousemove',e=>{
      tooltip.style.left = e.clientX+15+'px';
      tooltip.style.top  = e.clientY+15+'px';
    });
    el.addEventListener('mouseleave',()=>{
      tooltip.style.opacity = 0;
    });
  });
}


/* =========================================================
   ================== PERSUASION LOGIC =====================
   ========================================================= */

persuasionCandidates.forEach(img=>{
  img.addEventListener('click',()=>{
    persuasionCandidates.forEach(c=>c.classList.remove('selected'));
    img.classList.add('selected');
    selectedPartyInput.value = img.dataset.party || img.id;
  });
});

function showAllPersuasion(){
  persuasionCandidates.forEach(c=>c.classList.add('active'));
}

function updateAxisColors(model){
  const L = document.querySelector('[data-axis="left"]');
  const R = document.querySelector('[data-axis="right"]');

  L.classList.remove('axis-left-red','axis-left-blue');
  R.classList.remove('axis-right-red','axis-right-blue');

  if(model==='us'){
    L.classList.add('axis-left-blue');
    R.classList.add('axis-right-red');
  } else {
    L.classList.add('axis-left-red');
    R.classList.add('axis-right-blue');
  }
}




function applyModel(model){
  currentModel = model;
  updateAxisColors(model);

  const topFrag = document.createDocumentFragment();
  const bottomFrag = document.createDocumentFragment();

  MODELS[model].top.forEach(id=>{
    const el = document.getElementById(id);
    if(el) topFrag.appendChild(el);
  });

  MODELS[model].bottom.forEach(id=>{
    const el = document.getElementById(id);
    if(el) bottomFrag.appendChild(el);
  });

  topRow.innerHTML='';
  bottomRow.innerHTML='';
  topRow.appendChild(topFrag);
  bottomRow.appendChild(bottomFrag);

  showAllPersuasion();
}

function applyAxis(axis){
  currentAxis = axis;
  const allowed = new Set(AXIS[currentModel][axis]);
  persuasionCandidates.forEach(c=>{
    c.classList.toggle('active', allowed.has(c.id));
  });
}

modelBtns.forEach(btn=>{
  btn.onclick=()=>{
    modelBtns.forEach(b=>b.classList.remove('active'));
    btn.classList.add('active');
    applyModel(btn.dataset.model);
  };
});

axisBtns.forEach(btn=>{
  btn.onclick=()=>{
    axisBtns.forEach(b=>b.classList.remove('active'));
    btn.classList.add('active');
    if(currentModel) applyAxis(btn.dataset.axis);
  };
});


/* =========================================================
   ==================== CAUCUS LOGIC =======================
   ========================================================= */

function updateCaucusPost(){
  let mask = 0;
  document.querySelectorAll('#caucus-container .selected')
    .forEach(el=>{
      mask |= CAUCUS_BITS[el.id] || 0;
    });

  selectedCaucusMask.value = mask;
  selectedCaucusParty.value = currentCaucusParty || '';
}

/* Party buttons */

caucusBtns.forEach(btn=>{
  btn.addEventListener('click',()=>{
    const type = btn.dataset.caucus;

    if(currentCaucusParty===type){
      currentCaucusParty=null;
      caucusBtns.forEach(b=>b.classList.remove('active'));
      caucusCandidates.forEach(c=>{
        c.classList.remove('selected');
        c.classList.add('active');
      });
      updateCaucusPost();
      return;
    }

    currentCaucusParty=type;
    caucusBtns.forEach(b=>b.classList.remove('active'));
    btn.classList.add('active');

    caucusCandidates.forEach(c=>c.classList.remove('selected'));

    if(type==='trp'){
      caucusCandidates.forEach(c=>c.classList.add('active'));
    } else {
      const allowed = new Set(CAUCUS[type]);
      caucusCandidates.forEach(c=>{
        c.classList.toggle('active',allowed.has(c.id));
      });
    }

    updateCaucusPost();
  });
});

/* Logo click */

caucusCandidates.forEach((img,index)=>{
  img.addEventListener('click',()=>{
    if(!img.classList.contains('active')) return;

    const max =
      (currentCaucusParty==='dem'||currentCaucusParty==='gop')
        ?2:1;

    const selected =
      Array.from(document.querySelectorAll('#caucus-container .selected'));

    if(img.classList.contains('selected')){
      img.classList.remove('selected');
      updateCaucusPost();
      return;
    }

    if(max===1){
      caucusCandidates.forEach(c=>c.classList.remove('selected'));
      img.classList.add('selected');
      updateCaucusPost();
      return;
    }

    if(selected.length===0){
      img.classList.add('selected');
      updateCaucusPost();
      return;
    }

    if(selected.length===1){
      const firstIndex =
        Array.from(caucusCandidates).indexOf(selected[0]);
      if(Math.abs(firstIndex-index)===1){
        img.classList.add('selected');
      } else {
        selected[0].classList.remove('selected');
        img.classList.add('selected');
      }
      updateCaucusPost();
      return;
    }

    if(selected.length===2){
      const indices = selected.map(el =>
        Array.from(caucusCandidates).indexOf(el));

      const dist0=Math.abs(indices[0]-index);
      const dist1=Math.abs(indices[1]-index);

      if(dist0>dist1)
        selected[0].classList.remove('selected');
      else
        selected[1].classList.remove('selected');

      img.classList.add('selected');
      updateCaucusPost();
    }
  });
});


/* =========================================================
   ======================== INIT ===========================
   ========================================================= */

attachTooltip(persuasionCandidates, PARTY_INFO);
attachTooltip(caucusCandidates, CAUCUS_INFO);

/* Initial default state */
showAllPersuasion();
caucusCandidates.forEach(c => c.classList.add('active'));

/* ================= RESTORE PERSUASION ================= */

if (typeof SAVED_SELF_ASS !== 'undefined' && SAVED_SELF_ASS) {

  const savedEl = document.getElementById(SAVED_SELF_ASS);

  if (savedEl) {
    persuasionCandidates.forEach(c => c.classList.remove('selected'));
    savedEl.classList.add('selected');
    selectedPartyInput.value = SAVED_SELF_ASS;
  }
}

/* ================= RESTORE CAUCUS PARTY ================= */

if (typeof SAVED_SELF_PARTY !== 'undefined' && SAVED_SELF_PARTY) {

  const btn = document.querySelector(
    `.caucus-btn[data-caucus="${SAVED_SELF_PARTY}"]`
  );

  if (btn) {
    btn.click();   // triggers correct filtering logic
  }
}

/* ================= RESTORE CAUCUS MASK ================= */

if (typeof SAVED_SELF_CAUCUS !== 'undefined' && SAVED_SELF_CAUCUS > 0) {

  caucusCandidates.forEach(img => {

    const bit = CAUCUS_BITS[img.id];

    if (
      bit &&
      (SAVED_SELF_CAUCUS & bit) &&
      img.classList.contains('active')  // <- prevents illegal selection
    ) {
      img.classList.add('selected');
    }

  });

}
/* Final sync */
updateCaucusPost();
