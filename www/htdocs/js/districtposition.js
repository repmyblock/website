			document.addEventListener("DOMContentLoaded", function () {

			  const select = document.getElementById("positionrunning");
			  const manualWrapper = document.getElementById("manualPositionWrapper");
			  const manualInput = document.getElementById("manualPositionInput");

			  if (!select) return;

			  /* =========================
			     Toggle Manual Field
			  ==========================*/
			  select.addEventListener("change", function () {

			    if (this.value === "MANUAL") {
			      manualWrapper.style.display = "block";
			      manualInput.focus();
			    } else {
			      manualWrapper.style.display = "none";
			      manualInput.value = "";
			    }
			  });

			  /* =========================
			     Before Submit
			  ==========================*/
			  select.closest("form").addEventListener("submit", function (e) {

			    if (select.value === "MANUAL") {

			      const value = manualInput.value.trim();

			      if (!value) {
			        alert("Please enter a district.");
			        e.preventDefault();
			        return;
			      }

			      // Replace select value with manual input
			      select.value = "CUSTOM-" + value;
			    }
			  });

			});
