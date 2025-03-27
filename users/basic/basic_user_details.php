<div id="layoutSidenav_content">
    <main>
        <div id="infoBox" class="card">
            <div class="card-header">
                <i class="fas fa-user me-1"></i> User Details
            </div>
            <div class="card-body">
                <div class="info-item">
                    <strong>User ID:</strong> <?= htmlspecialchars($user['id_user']) ?>
                </div>
                <div class="info-item">
                    <strong>First Name:</strong> <?= htmlspecialchars($user['first_name']) ?>
                </div>
                <div class="info-item">
                    <strong>Last Name:</strong> <?= htmlspecialchars($user['last_name']) ?>
                </div>
                <div class="info-item">
                    <strong>Birth Date:</strong> <?= htmlspecialchars($user['birth_date']) ?>
                </div>
                <div class="info-item">
                    <strong>UID:</strong> <?= htmlspecialchars($user['rfid_code']) ?>
                </div>
                <div class="info-item">
                    <strong>Access Level:</strong> <?= htmlspecialchars($user['access_level']) ?>
                </div>
                <div class="info-item">
                    <strong>Created Date:</strong> <?= htmlspecialchars($user['created_date']) ?>
                </div>
                <!-- Buttons (Unused for Now) -->
                <div class="info-buttons">
                    <button class="modify-user-btn">Modify</button>
                    <button class="delete-user-btn">Delete User</button>
                </div>
            </div>
        </div>
        <div class="row">
            <!-- Left Side: Chart -->
            <div class="col-md-6">
                <div class="card mb-4">
                    <div class="card-header">
                        <i class="fas fa-chart-bar me-1"></i>
                        User Today Door Usage
                    </div>
                    <div class="card-body">
                        <!-- Responsive Chart Container -->
                        <div class="chart-container" style="position: relative; width: 100%; height: 400px;">
                            <canvas id="log-user-line"></canvas>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Left Side: Chart -->
            <div class="col-md-6">
                <div class="card mb-4">
                    <div class="card-header">
                        <i class="fas fa-chart-bar me-1"></i>
                        User Statistics This Week
                    </div>
                    <div class="card-body">
                        <!-- Responsive Chart Container -->
                        <div class="chart-container" style="position: relative; width: 100%; height: 400px;">
                            <canvas id="log-user-bar"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="container-fluid px-4">
            <h1 class="mt-4">User Tracker</h1>
            <ol class="breadcrumb mb-4">
                <li class="breadcrumb-item active">User Tracker</li>
            </ol>

            <!-- Right Side: Table -->
            <div class="mb-3">
                <input type="text" id="searchInput" class="form-control" placeholder="Search by User ID or Status" onkeyup="filterTable()">
            </div>

            <div class="card mb-4">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <div>
                        <i class="fas fa-table me-1"></i>
                        Access Logs
                    </div>
                </div>
                <div class="card-body">
                    <!-- Page Size Selection -->
                    <div class="d-flex justify-content-between align-items-center mb-3">
                    <label for="pageSizeSelect" class="me-2">Show:</label>
                    <select id="pageSizeSelect" class="form-select w-auto" onchange="changePageSize()">
                        <option value="5">5</option>
                        <option value="10" selected>10</option>
                        <option value="20">20</option>
                        <option value="50">50</option>
                    </select>
                    <span>entries</span>
                    
                    <!-- Sorting Select Dropdown -->
                    <label for="sortSelect" class="ms-3">Sort by:</label>
                    <select id="sortSelect" class="form-select w-auto" onchange="changeSorting()">
                        <option value="log_number">Log Number</option>
                        <option value="user_id_log">User ID</option>
                        <option value="log_date" selected>Log Date</option>
                        <option value="status">Status</option>
                    </select>
                </div>


                    <table class="table table-striped table-hover" id="logsTable">
                        <thead class="table-dark">
                            <tr>
                                <th onclick="sortTable('log_number')">Log Number ⬍</th>
                                <th onclick="sortTable('user_id_log')">User ID ⬍</th>
                                <th onclick="sortTable('log_date')">Log Date ⬍</th>
                                <th>Used UID</th>
                                <th onclick="sortTable('status')">Status ⬍</th>
                            </tr>
                        </thead>
                        <tbody> <!-- Table will be dynamically populated --> </tbody>
                    </table>

                    <!-- Pagination Controls -->
                    <div class="d-flex justify-content-between align-items-center">
                        <button id="prevPage" class="btn btn-secondary btn-sm" onclick="changePage(-1)">Previous</button>
                        <span id="pageInfo"></span>
                        <button id="nextPage" class="btn btn-secondary btn-sm" onclick="changePage(1)">Next</button>
                    </div>
                </div>
            </div>          
        </div>
    </main>
    <?php include $_SERVER['DOCUMENT_ROOT'] . '/elements/foot.php'; ?>
</div>

<!-- JavaScript -->
<script>
    // Pass the logs data to JavaScript
    const logsData = <?= json_encode($logs); ?>;
    let currentPage = 1;
    let pageSize = 5;
    let sortDirection = {}; // Initialize sorting direction

    // Function to display logs data in the table
    function displayPage() {
        const tableBody = document.querySelector("#logsTable tbody");
        tableBody.innerHTML = ""; // Clear previous data

        let start = (currentPage - 1) * pageSize;
        let end = start + pageSize;
        let paginatedLogs = logsData.slice(start, end);

        paginatedLogs.forEach(log => {
            // ✅ Set label color based on status
            let statusColor = log.status === "Granted" ? "#006600" : "#8B0000";

            tableBody.innerHTML += `<tr>
                <td>${log.log_number}</td>
                <td>${log.user_id_log}</td>
                <td>${log.log_date}</td>
                <td>${log.used_rfid_code}</td>
                <td><span style="background-color: ${statusColor}; color: white; padding: 3px 8px; border-radius: 5px;">${log.status}</span></td>
            </tr>`;
        });

        updatePagination();
    }

        // Display the first page
        displayPage();
/*old 

   let logsData = [];
let currentPage = 1;
let pageSize = 10;
let sortDirection = {}; // Initialize sorting direction

// Fetch logs Data
const userId = < ?= json_encode($user['id_user']); ?>; 

fetch(`/trash/get_user_logs.php?id=${userId}`)
    .then(response => response.json())
    .then(data => {
        if (data.error) {
            console.error("Error:", data.error);
            return;
        }
        logsData = data;
        displayPage();
    })
    .catch(error => console.error("Error fetching logs:", error));

function displayPage() {
    const tableBody = document.querySelector("#logsTable tbody");
    tableBody.innerHTML = ""; // Clear previous data
    
    let start = (currentPage - 1) * pageSize;
    let end = start + pageSize;
    let paginatedLogs = logsData.slice(start, end);

    paginatedLogs.forEach(log => {
        tableBody.innerHTML += `<tr>
            <td>${log.log_number}</td>
            <td>${log.user_id_log}</td>
            <td>${log.log_date}</td>
            <td>${log.status}</td>
        </tr>`;
    });

    updatePagination();
}

*/
function updatePagination() {
    document.getElementById("pageInfo").innerText = `Page ${currentPage} of ${Math.ceil(logsData.length / pageSize)}`;
    document.getElementById("prevPage").disabled = currentPage === 1;
    document.getElementById("nextPage").disabled = currentPage * pageSize >= logsData.length;
}

function changePage(step) {
    currentPage += step;
    displayPage();
}

function changePageSize() {
    pageSize = parseInt(document.getElementById("pageSizeSelect").value);
    currentPage = 1; // Reset to first page
    displayPage();
}

// Function to Filter Table
function filterTable() {
    let searchValue = document.getElementById("searchInput").value.toLowerCase();
    let filteredLogs = logsData.filter(log =>
        log.log_number.toString().includes(searchValue) ||
        log.user_id_log.toString().includes(searchValue) ||
        log.log_date.toLowerCase().includes(searchValue) ||
        log.status.toLowerCase().includes(searchValue)
    );
    logsData = filteredLogs;
    currentPage = 1; // Reset to first page after filtering
    displayPage();
}

// Function to Sort Table
function sortTable(column) {
    // If no sort direction is set, default to descending for log_date
    if (!sortDirection[column]) {
        if (column === 'log_date') {
            sortDirection[column] = 'desc'; // Default to descending for log_date (recent first)
        } else {
            sortDirection[column] = 'asc'; // Default to ascending for other columns
        }
    } else {
        // Toggle between ascending and descending for other columns
        sortDirection[column] = sortDirection[column] === 'asc' ? 'desc' : 'asc';
    }

    // Sort the data based on the column and direction
    logsData.sort((a, b) => {
        let valA = a[column];
        let valB = b[column];

        // Handle numbers and dates correctly
        if (!isNaN(valA) && !isNaN(valB)) {
            valA = Number(valA);
            valB = Number(valB);
        } else if (column === "log_date" && Date.parse(valA) && Date.parse(valB)) {
            valA = new Date(valA);
            valB = new Date(valB);
        } else {
            valA = valA.toString().toLowerCase();
            valB = valB.toString().toLowerCase();
        }

        return sortDirection[column] === 'asc' ? (valA > valB ? 1 : -1) : (valA < valB ? 1 : -1);
    });

    displayPage();
}
/*
// Function to Sort Table (Smallest to Largest & Recent to Oldest)
function selectSortTable(column) {
    // Ensure logsData is not empty before sorting
    if (!logsData || logsData.length === 0) {
        console.warn("No data available to sort.");
        return;
    }

    logsData.sort((a, b) => {
        let valA = a[column];
        let valB = b[column];

        // Handle numbers (ascending order)
        if (!isNaN(valA) && !isNaN(valB)) {
            return Number(valA) - Number(valB);
        } 
        // Handle dates (most recent to oldest)
        else if (Date.parse(valA) && Date.parse(valB)) {
            return new Date(valB) - new Date(valA); // Reverse order for recent first
        } 
        // Handle strings (alphabetically)
        else {
            return valA.toString().localeCompare(valB.toString());
        }
    });

    displayPage(); // Refresh table with sorted data
}
/*
// Function to handle sorting via dropdown
function changeSorting() {
    let sortSelect = document.getElementById("sortSelect");
    let selectedSort = sortSelect.value; // Get selected column

    // Save sorting choice
    localStorage.setItem("currentSortColumn", selectedSort);

    selectSortTable(selectedSort);
}

// Wait for the window to load completely
window.onload = () => {
    setTimeout(() => {
        if (logsData && logsData.length > 0) {
            selectSortTable('log_date');  // Automatically sort by 'log_date' (Recent first)
        } else {
            console.warn("Logs data is not loaded yet.");
        }
    }, 100); // Delay ensures logsData is available
};
*/

// Function to Sort Table (Smallest to Largest & Recent to Oldest)
function selectSortTable(column) {
    if (!logsData || logsData.length === 0) {
        console.warn("No data available to sort.");
        return;
    }

    logsData.sort((a, b) => {
        let valA = a[column];
        let valB = b[column];

        // Handle numbers (ascending order)
        if (!isNaN(valA) && !isNaN(valB)) {
            return Number(valA) - Number(valB);
        } 
        // Handle dates (most recent to oldest)
        else if (Date.parse(valA) && Date.parse(valB)) {
            return new Date(valB) - new Date(valA); // Reverse order for recent first
        } 
        // Handle strings (alphabetically)
        else {
            return valA.toString().localeCompare(valB.toString());
        }
    });

    displayPage(); // Refresh table with sorted data
}

// Function to handle sorting via dropdown
function changeSorting() {
    let sortSelect = document.getElementById("sortSelect");
    let selectedSort = sortSelect.value; // Get selected column

    // Save sorting choice
    localStorage.setItem("currentSortColumn", selectedSort);

    selectSortTable(selectedSort);
}

// Function to load sorting preference on page load
function loadSortPreference() {
    let savedSortColumn = localStorage.getItem("currentSortColumn");
    let defaultSort = "log_date"; // Default sorting column

    if (savedSortColumn) {
        selectSortTable(savedSortColumn);
        document.getElementById("sortSelect").value = savedSortColumn; // Update dropdown
    } else {
        selectSortTable(defaultSort); // Use default if no preference is saved
    }
}

// Wait for the window to load completely
window.onload = () => {
    setTimeout(() => {
        if (logsData && logsData.length > 0) {
            loadSortPreference(); // Load saved sorting preference
        } else {
            console.warn("Logs data is not loaded yet.");
        }
    }, 100); // Delay ensures logsData is available
};

document.addEventListener("DOMContentLoaded", function () {
    // ✅ Logs data from PHP for Line and Bar Charts
    const logsLine = <?php echo json_encode($logsLine); ?>;
    const logsBar = <?php echo json_encode($logsBar); ?>;

    // ✅ Check if data is valid
    if (!logsLine || logsLine.length === 0) {
        console.error("No data available for Line Chart");
    } else {
        const labelsLine = logsLine.map(entry => entry.log_minute);
        const valuesLine = logsLine.map(entry => entry.log_count);
        renderLineChart('log-user-line', labelsLine, valuesLine);
    }

    if (!logsBar || logsBar.length === 0) {
        console.error("No data available for Bar Chart");
    } else {
        const labelsBar = logsBar.map(entry => entry.log_day);
        const valuesBar = logsBar.map(entry => entry.log_count_bar);
        renderBarChart('log-user-bar', labelsBar, valuesBar);
    }
});

</script>
