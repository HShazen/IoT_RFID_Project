    <!-- Information Box -->
<div id="layoutSidenav_content">
    <main>
        <div class="container-fluid px-4">
            <h1 class="mt-4">Users Statistics</h1>
            <ol class="breadcrumb mb-4">
                <li class="breadcrumb-item active">Users Statistics</li>
            </ol>
            <div class="row">
                <div class="col-xl-6">
                    <div class="card mb-4">
                        <div class="card-header">
                            <i class="fas fa-chart-area me-1"></i>
                            Today Door Usage Over Time
                        </div>
                        <div class="card-body"><canvas id="log-line" width="100%" height="40"></canvas></div>
                    </div>
                </div>
                <div class="col-xl-6">
                    <div class="card mb-4">
                        <div class="card-header">
                            <i class="fas fa-chart-bar me-1"></i>
                            Daily Door Usage (Last Week)
                        </div>
                        <div class="card-body"><canvas id="log-bar" width="100%" height="40"></canvas></div>
                    </div>
                </div>
            </div>
            <div class="mb-3">
                <input type="text" id="searchInputLogs" class="form-control" placeholder="Search by User ID or Status" onkeyup="filterTable()">
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
                        <option value="first_name">First Name</option>
                        <option value="last_name">Last Name</option>
                        <option value="log_date" selected>Log Date</option>
                        <option value="status">Status</option>
                    </select>
                </div>


                    <table class="table table-striped table-hover" id="logsTable" >
                        <thead class="table-dark">
                            <tr>
                                <th onclick="sortTable('log_number')">Log Number</th>
                                <th onclick="sortTable('user_id_log')">User ID</th>
                                <th onclick="sortTable('first_name')">First Name</th>
                                <th onclick="sortTable('last_name')">Last Name</th>
                                <th onclick="sortTable('log_date')">Log Date</th>
                                <th> Used UID </th>
                                <th onclick="sortTable('status')">Status</th>
                                <th>Details</th> <!-- New Column for Details Button -->
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
    let logsData = [];
    let currentPage = 1;
    let pageSize = 10;
    let sortDirection = {}; // Initialize sorting direction

    // Fetch logs Data
    fetch('/users/get/get_all_logs.php')
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
        
    function filterTable() {
        let searchValue = document.getElementById("searchInputLogs").value.toLowerCase();
        console.log("Filtering logs with:", searchValue); // ✅ Debugging log

        currentPage = 1; // ✅ Reset page when filtering

        let filteredLogs = searchValue
            ? logsData.filter(log =>
                log.log_number.toString().includes(searchValue) ||
                log.user_id_log.toString().includes(searchValue) ||
                log.first_name.toLowerCase().includes(searchValue) ||
                log.last_name.toLowerCase().includes(searchValue) ||
                log.used_rfid_code.toLowerCase().includes(searchValue)
            )
            : logsData;

        console.log("Filtered Logs:", filteredLogs); // ✅ Debugging log

        filteredLogs.sort((a, b) => new Date(b.log_date) - new Date(a.log_date));
        displayPage(filteredLogs);
    }



    function displayPage(data = logsData) {
        const tableBody = document.querySelector("#logsTable tbody");
        tableBody.innerHTML = ""; // Clear previous data

        let start = (currentPage - 1) * pageSize;
        let end = start + pageSize;
        let paginatedLogs = data.slice(start, end); // ✅ Use passed data

        paginatedLogs.forEach(log => {
            let statusColor = log.status === "Granted" ? "#006600" : "#8B0000";
            tableBody.innerHTML += `<tr>
                <td>${log.log_number}</td>
                <td>${log.user_id_log}</td>
                <td>${log.first_name}</td>
                <td>${log.last_name}</td>
                <td>${log.log_date}</td>
                <td>${log.used_rfid_code}</td>
                <td><span style="background-color: ${statusColor}; color: white; padding: 3px 8px; border-radius: 5px;">${log.status}</span></td>
                <td>
                    <a href="/users/user_details.php?id=${log.user_id_log}" class="btn btn-info btn-sm">
                        <i class="fas fa-info-circle"></i> Details
                    </a>
                </td>
            </tr>`;
        });

        updatePagination(data); // ✅ Pass filtered data for correct pagination
    }

    function updatePagination(data = logsData) {
        document.getElementById("pageInfo").innerText = `Page ${currentPage} of ${Math.ceil(data.length / pageSize)}`;
        document.getElementById("prevPage").disabled = currentPage === 1;
        document.getElementById("nextPage").disabled = currentPage * pageSize >= data.length;
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


    function sortTable(column) {
        sortDirection[column] = sortDirection[column] === 'asc' ? 'desc' : 'asc';

        if (!logsData || logsData.length === 0) {
            console.warn("No data available to sort.");
            return;
        }

        logsData.sort((a, b) => {
            let valA = a[column];
            let valB = b[column];

            if (!isNaN(valA) && !isNaN(valB)) {
                return sortDirection[column] === 'asc' ? valA - valB : valB - valA;
            } else if (Date.parse(valA) && Date.parse(valB)) {
                return sortDirection[column] === 'asc' ? new Date(valA) - new Date(valB) : new Date(valB) - new Date(valA);
            } else {
                return sortDirection[column] === 'asc' ? valA.localeCompare(valB) : valB.localeCompare(valA);
            }
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

// Function to handle sorting via dropdown
function changeSorting() {
    let sortSelect = document.getElementById("sortSelect");
    let selectedSort = sortSelect.value; // Get selected column

    // Save sorting choice
    localStorage.setItem("currentSortColumn", selectedSort);

    selectSortTable(selectedSort);
}

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
/*
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
    fetch('/users/get/get_logs_line.php')
        .then(response => response.json())
        .then(data => {
            if (data.error) {
                console.error("Error:", data.error);
                return;
            }

            // ✅ Extract timestamps & log counts
            const labels = data.map(entry => entry.log_minute); // Time (minutes)
            const values = data.map(entry => entry.log_count);  // Log count

            renderLineChart('log-line', labels, values);
        })
        .catch(error => console.error("Error fetching logs:", error));
});

document.addEventListener("DOMContentLoaded", function () {
    fetch('/users/get/get_logs_bar.php')
        .then(response => response.json())
        .then(data => {
            if (data.error) {
                console.error("Error:", data.error);
                return;
            }

            // ✅ Extract dates & log counts
            const labels = data.map(entry => entry.log_day); // Date (day)
            const values = data.map(entry => entry.log_count); // Log count

            renderBarChart('log-bar', labels, values);
        })
        .catch(error => console.error("Error fetching logs:", error));
});

/*
function fetchLogsData() {
    fetch('/users/get/get_all_logs.php')
        .then(response => response.json())
        .then(data => {
            if (data.error) {
                console.error("Error:", data.error);
                return;
            }
            logsData = data;
            displayPage(); // Refresh table
        })
        .catch(error => console.error("Error fetching logs:", error));
    
    selectSortTable('log_date');
}
*/
function fetchLogsData() {
    fetch('/users/get/get_all_logs.php')
        .then(response => response.json())
        .then(data => {
            if (data.error) {
                console.error("Error:", data.error);
                return;
            }
            logsData = data;
            displayPage(); // Refresh table

            loadSortPreference(); // Apply saved sorting preference after fetching data
        })
        .catch(error => console.error("Error fetching logs:", error));
}
// Auto-refresh every 30 seconds
setInterval(fetchLogsData, 30000);
</script>
