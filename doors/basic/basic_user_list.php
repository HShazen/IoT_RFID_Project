<div id="layoutSidenav_content">
    <main>
        <div class="container-fluid px-4">
            <h1 class="mt-4">Users List</h1>
            <ol class="breadcrumb mb-4">
                <li class="breadcrumb-item active">Users List</li>
            </ol>

            <!-- Search Field -->
            <div class="mb-3">
                <input type="text" id="searchInput" class="form-control" placeholder="Search by First or Last Name" onkeyup="filterTable()">
            </div>

            <div class="card mb-4">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <div>
                        <i class="fas fa-table me-1"></i>
                        Users Table
                    </div>
                    <button class="btn btn-primary btn-sm px-4" onclick="window.location.href='/users/add_user.php'">
                        <i class="fas fa-user-plus me-1"></i> Add User
                    </button>
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
                    <table class="table table-striped table-hover" id="userTable">
                        <thead class="table-dark">
                            <tr>
                                <th onclick="sortTable('id_user')">User ID ⬍</th>
                                <th onclick="sortTable('first_name')">First Name ⬍</th>
                                <th onclick="sortTable('last_name')">Last Name ⬍</th>
                                <th onclick="sortTable('birth_date')">Birth Date ⬍</th>
                                <th onclick="sortTable('rfid_code')">RFID ⬍</th>
                                <th onclick="sortTable('access_level')">Access Level ⬍</th>
                                <th onclick="sortTable('created_date')">Added Date ⬍</th>
                                <th>Details</th> <!-- New Column for Details Button -->
                            </tr>
                        </thead>
                        <tbody> <!-- Table will be filled dynamically --> </tbody>
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
   let usersData = []; // Store all users
    let currentPage = 1;
    let pageSize = 10;

    // Fetch Users Data
    fetch('/users/get/get_users.php')
        .then(response => response.json())
        .then(data => {
            usersData = data;
            displayPage();
        })
        .catch(error => console.error("Error fetching users:", error));

    function displayPage() {
        const tableBody = document.querySelector("#userTable tbody");
        tableBody.innerHTML = ""; // Clear previous data
        
        let start = (currentPage - 1) * pageSize;
        let end = start + pageSize;
        let paginatedUsers = usersData.slice(start, end);
        paginatedUsers.forEach(user => {
            tableBody.innerHTML += `<tr>
                <td>${user.id_user}</td>
                <td>${user.first_name}</td>
                <td>${user.last_name}</td>
                <td>${user.birth_date}</td>
                <td>${user.rfid_code}</td>
                <td>${user.access_level}</td>
                <td>${user.created_date}</td>
                <td>
                    <a href="/users/user_details.php?id=${user.id_user}" class="btn btn-info btn-sm">
                        <i class="fas fa-info-circle"></i> Details
                    </a>
                </td>
            </tr>`;
        });
        updatePagination();
    }

    function updatePagination() {
        document.getElementById("pageInfo").innerText = `Page ${currentPage} of ${Math.ceil(usersData.length / pageSize)}`;
        document.getElementById("prevPage").disabled = currentPage === 1;
        document.getElementById("nextPage").disabled = currentPage * pageSize >= usersData.length;
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
        let filteredUsers = usersData.filter(user =>
            user.first_name.toLowerCase().includes(searchValue) || 
            user.last_name.toLowerCase().includes(searchValue)
        );
        populateTable(filteredUsers);
    }

    // Function to Sort Table
    function sortTable(column) {
        if (!sortDirection[column]) {
            sortDirection[column] = 'asc'; // Default sorting order
        } else {
            sortDirection[column] = sortDirection[column] === 'asc' ? 'desc' : 'asc';
        }

        let sortedData = [...usersData].sort((a, b) => {
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

        populateTable(sortedData);
    }
</script>
