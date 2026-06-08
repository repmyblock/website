document.addEventListener("DOMContentLoaded", function () {

  const stateInput = document.getElementById("StateName");
  const stateBox = document.getElementById("stateSuggestions");
 
  const positionInput = document.getElementById("Position");
  const positionBox = document.getElementById("positionSuggestions");

	const profileInput = document.getElementById("DefinedProfile");
	const profileBox = document.getElementById("ProfileSuggestions");

  const stateIdField = document.getElementById("DataState_ID");
  const positionIdField = document.getElementById("ElectionsPosition_ID");
	const profileIdField = document.getElementById("DefinedProfile_ID");

  const electionDateField = document.getElementById("ElectionDate");

  const MANUAL_LABEL = "Not found — enter it manually";

  /* ===============================
     CLOSE MENUS
  =============================== */
  function closeAll() {
    stateBox.classList.add("hidden");
    positionBox.classList.add("hidden");
    profileBox.classList.add("hidden");
  }

  /* ===============================
     SET ELECTION DATE
  =============================== */
  function setElectionDate(stateId) {

    if (!stateId) {
      electionDateField.value = "";
      return;
    }

    const matches = rmbelectdates
      .filter(e => String(e.DataState_ID) === String(stateId))
      .sort((a, b) => new Date(a.Elections_Date) - new Date(b.Elections_Date));

    if (matches.length) {
      electionDateField.value = matches[0].Elections_Date;
    } else {
      electionDateField.value = "";
    }
  }

  /* ===============================
     BUILD STATE LIST
  =============================== */
  const states = {};
  rmbelectdates.forEach(e => {
    if (!states[e.DataState_ID]) {
      states[e.DataState_ID] = {
        name: e.DataState_Name,
        abbrev: e.DataState_Abbrev || ""
      };
    }
  });

  /* ===============================
     STATE AUTOCOMPLETE
  =============================== */
  function renderStates(value = "") {

    stateBox.innerHTML = "";
    const v = value.toLowerCase();

    Object.entries(states).forEach(([id, s]) => {

      if (!v || s.name.toLowerCase().includes(v) || s.abbrev.toLowerCase().includes(v)) {

        const div = document.createElement("div");
        div.textContent = `${s.name} (${s.abbrev})`;

        div.addEventListener("mousedown", function () {

          stateInput.value = div.textContent;
          stateIdField.value = id;

          positionInput.value = "";
          positionIdField.value = "";

          setElectionDate(id);
          closeAll();
        });

        stateBox.appendChild(div);
      }
    });

    stateBox.classList.toggle("hidden", !stateBox.children.length);
  }

  stateInput.addEventListener("focus", function () {
    renderStates(stateInput.value);
  });

  stateInput.addEventListener("input", function () {
    stateIdField.value = "";
    electionDateField.value = "";
    renderStates(stateInput.value);
  });

  /* ===============================
     POSITION AUTOCOMPLETE
  =============================== */
  function renderPositions(stateId, typed = "") {

    positionBox.innerHTML = "";

    if (!stateId) {
      positionBox.classList.add("hidden");
      return;
    }

    const t = typed.toLowerCase();
    const seen = new Set();

    rmbpositions
      .filter(p => String(p.DataState_ID) === String(stateId))
      .sort((a, b) => (a.ElectionsPosition_Order || 9999) - (b.ElectionsPosition_Order || 9999))
      .forEach(p => {

        if (seen.has(p.ElectionsPosition_Name)) return;
        if (t && !p.ElectionsPosition_Name.toLowerCase().includes(t)) return;

        seen.add(p.ElectionsPosition_Name);

        const div = document.createElement("div");
        div.textContent = p.ElectionsPosition_Name;

        div.addEventListener("mousedown", function () {

          positionInput.value = p.ElectionsPosition_Name;
          positionIdField.value = p.ElectionsPosition_ID;

          setElectionDate(stateId);
          closeAll();
        });

        positionBox.appendChild(div);
      });

    const manual = document.createElement("div");
    manual.textContent = MANUAL_LABEL;

    manual.addEventListener("mousedown", function () {
      positionIdField.value = 0;
      closeAll();
      openManualModal();
    });

    positionBox.appendChild(manual);

    positionBox.classList.toggle("hidden", !positionBox.children.length);
  }

  positionInput.addEventListener("focus", function () {
    renderPositions(stateIdField.value, positionInput.value);
  });

  positionInput.addEventListener("input", function () {
    renderPositions(stateIdField.value, positionInput.value);
  });
  
  function profileLabel(p) {
	  const election = p.Elections_Text || "";
	  const date = p.Elections_Date || "";
	  const position = p.CandidateElection_Text || "";
	  const name = p.Candidate_DispName || "";

	  return `${election} - ${date} - ${position} - ${name}`.replace(/\s+-\s+$/g, "").trim();
	}

	function profileId(p) {
  	// return p.CandidateProfile_ID || 
  	return p.Candidate_ID || "";
	}

	function renderProfiles(value = "") {
	  profileBox.innerHTML = "";

	  const v = value.toLowerCase();

	  rmbdefined
	    .filter(p => {
	      const label = profileLabel(p);
	      return label && (!v || label.toLowerCase().includes(v));
	    })
	    .sort((b, a) => profileLabel(a).localeCompare(profileLabel(b)))
	    .forEach(p => {
	      const div = document.createElement("div");
	      div.textContent = profileLabel(p);

	      div.addEventListener("mousedown", function () {
	        profileInput.value = profileLabel(p);
	        profileIdField.value = profileId(p);
	        closeAll();
	      });

	      profileBox.appendChild(div);
	    });

	  profileBox.classList.toggle("hidden", !profileBox.children.length);
	}

	profileInput.addEventListener("focus", function () {
	  renderProfiles(profileInput.value);
	});

	profileInput.addEventListener("input", function () {
	  profileIdField.value = "";
	  renderProfiles(profileInput.value);
	});

  /* ===============================
     CLICK OUTSIDE CLOSE
  =============================== */
  document.addEventListener("click", function (e) {
    if (!e.target.closest(".autocomplete")) {
      closeAll();
    }
  });

});
