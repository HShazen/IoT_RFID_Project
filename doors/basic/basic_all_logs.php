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
                            All Users Statistics for all users today
                        </div>
                        <div class="card-body"><canvas id="log-line" width="100%" height="40"></canvas></div>
                    </div>
                </div>
                <div class="col-xl-6">
                    <div class="card mb-4">
                        <div class="card-header">
                            <i class="fas fa-chart-bar me-1"></i>
                            All Users Statistics This Week
                        </div>
                        <div class="card-body"><canvas id="log-bar" width="100%" height="40"></canvas></div>
                    </div>
                </div>
            </div>
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
                    </div>

                    <table class="table table-striped table-hover" id="logsTable">
                        <thead class="table-dark">
                            <tr>
                                <th onclick="sortTable('log_number')">Log Number ⬍</th>
                                <th onclick="sortTable('user_id_log')">User ID ⬍</th>
                                <th onclick="sortTable('first_name')">First Name ⬍</th>
                                <th onclick="sortTable('last_name')">Last Name ⬍</th>
                                <th onclick="sortTable('log_date')">Log Date ⬍</th>
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

function displayPage() {
    const tableBody = document.querySelector("#logsTable tbody");
    tableBody.innerHTML = ""; // Clear previous data
    
    let start = (currentPage - 1) * pageSize;
    let end = start + pageSize;
    let paginatedLogs = logsData.slice(start, end);

    paginatedLogs.forEach(log => {
        // ✅ Set label color based on status
        let statusColor = log.status === "Access Granted" ? "green" : "red";
        tableBody.innerHTML += `<tr>
            <td>${log.log_number}</td>
            <td>${log.user_id_log}</td>
            <td>${log.first_name}</td>
            <td>${log.last_name}</td>
            <td>${log.log_date}</td>
            <td><span style="background-color: ${statusColor}; color: white; padding: 3px 8px; border-radius: 5px;">${log.status}</span></td>
        </tr>`;
    });

    updatePagination();
}

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
    
    logsData.sort((a, b) => {
        let valA = a[column];
        let valB = b[column];

        // Handle numbers and dates correctly
        if (!isNaN(valA) && !isNaN(valB)) {
            valA = Number(valA);
            valB = Number(valB);
        } else if (Date.parse(valA) && Date.parse(valB)) {
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

// Set default sorting to 'log_date' in descending order when page loads
window.onload = () => {
    sortTable('log_date');  // Automatically sort by 'log_date' in descending order
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

            renderLogChart(labels, values);
        })
        .catch(error => console.error("Error fetching logs:", error));
});

function renderLogChart(labels, values) {
    const ctx = document.getElementById('log-line');

    if (!ctx) {
        console.error("Error: Canvas element 'log-line' not found.");
        return;
    }

    new Chart(ctx, {
        type: 'line',
        data: {
            labels: labels,
            datasets: [{
                label: 'Logs Per Minute',
                data: values,
                borderColor: 'blue',
                backgroundColor: 'rgba(0, 0, 255, 0.2)',
                borderWidth: 2,
                fill: true,
                tension: 0.3 // Smooth curves
            }]
        },
        options: {
            responsive: true,
            scales: {
                x: {
                    title: { display: true, text: 'Time (Minutes)' }
                },
                y: {
                    title: { display: true, text: 'Number of Logs' },
                    beginAtZero: true
                }
            }
        }
    });
}

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

            renderBarChart(labels, values);
        })
        .catch(error => console.error("Error fetching logs:", error));
});

function renderBarChart(labels, values) {
    const ctx = document.getElementById('log-bar');

    if (!ctx) {
        console.error("Error: Canvas element 'log-bar' not found.");
        return;
    }

    new Chart(ctx, {
        type: 'bar',
        data: {
            labels: labels,
            datasets: [{
                label: 'Logs Per Day',
                data: values,
                backgroundColor: 'rgba(255, 99, 132, 0.5)', // Red bars
                borderColor: 'rgba(255, 99, 132, 1)',
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            scales: {
                x: {
                    title: { display: true, text: 'Date' }
                },
                y: {
                    title: { display: true, text: 'Number of Logs' },
                    beginAtZero: true
                }
            }
        }
    });
}

</script>
