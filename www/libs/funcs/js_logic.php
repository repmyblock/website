<?php

// These set of script is to add JS Scripts to individual PHP pages.
function Search_TDCol() { ?>  
    <script>
      function filterTable(colIndex, searchValue) {
        const table = document.getElementById("dataTable");
        const rows = table.tBodies[0].rows;
        searchValue = searchValue.toLowerCase();

        for (let row of rows) {
          const cell = row.cells[colIndex];
          if (!cell) continue;

          const text = cell.textContent.toLowerCase();
          row.style.display = text.includes(searchValue) ? "" : "none";
        }
      }
    </script>
<?php } ?>