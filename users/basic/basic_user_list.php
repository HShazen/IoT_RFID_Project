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

                        <!-- Sorting Select Dropdown -->
                        <label for="sortSelect" class="ms-3">Sort by:</label>
                        <select id="sortSelect" class="form-select w-auto" onchange="changeSorting()">
                            <option value="id_user">User ID</option>
                            <option value="first_name">First Name</option>
                            <option value="last_name">Last Name</option>
                            <option value="accesss_level">Access Level</option>
                            <option value="created_date" selected>Added Date</option>
                        </select>
                    </div>
                    <table class="table table-striped table-hover" id="userTable">
                        <thead class="table-dark">
                            <tr>
                                <th onclick="sortTable('id_user')">User ID</th>
                                <th onclick="sortTable('first_name')">First Name</th>
                                <th onclick="sortTable('last_name')">Last Name</th>
                                <th onclick="sortTable('birth_date')">Birth Date</th>
                                <th onclick="sortTable('rfid_code')">RFID</th>
                                <th onclick="sortTable('access_level')">Access Level</th>
                                <th onclick="sortTable('created_date')">Added Date</th>
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
    let sortDirection = {};

    // Fetch Users Data
    fetch('/users/get/get_users.php')
        .then(response => response.json())
        .then(data => {
            if (data.error) {
                console.error("Error:", data.error);
                return;
            }
            usersData = data;
            displayPage();
        })
        .catch(error => console.error("Error fetching Users:", error));

    function filterTable() {
        let searchValue = document.getElementById("searchInput").value.toLowerCase();

        // Restore original data when search input is empty
        let filteredUsers = searchValue
            ? usersData.filter(user =>
                user.id_user.toString().includes(searchValue) ||
                user.first_name.toLowerCase().includes(searchValue) ||
                user.last_name.toLowerCase().includes(searchValue) ||
                user.rfid_code.toLowerCase().includes(searchValue)
            )
            : usersData; // Reset to original data if search is empty

        // ✅ Sort after filtering to maintain correct order
        filteredUsers.sort((a, b) => new Date(b.add_date) - new Date(a.add_date));

        displayPage(filteredUsers); // Pass filtered data to display
    }

    // Modify displayPage to accept optional filtered data
    function displayPage(data = usersData) {
        const tableBody = document.querySelector("#userTable tbody");
        tableBody.innerHTML = ""; // Clear previous data

        let start = (currentPage - 1) * pageSize;
        let end = start + pageSize;
        let paginatedUsers = data.slice(start, end); // Use passed or original data

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
        updatePagination(data);
    }

    // Update pagination to work with filtered results
    function updatePagination(data = usersData) {
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

        if (!usersData || usersData.length === 0) {
            console.warn("No data available to sort.");
            return;
        }

        usersData.sort((a, b) => {
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


    function selectSortTable(column) {
        if (!usersData || usersData.length === 0) {
            console.warn("No data available to sort.");
            return;
        }

        usersData.sort((a, b) => {
            let valA = a[column];
            let valB = b[column];

            if (!isNaN(valA) && !isNaN(valB)) {
                return Number(valA) - Number(valB);
            } 
            else if (Date.parse(valA) && Date.parse(valB)) {
                return new Date(valB) - new Date(valA);
            } 
            else {
                return valA.toString().localeCompare(valB.toString());
            }
        });

        displayPage();
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
        let defaultSort = "created_date"; // Default sorting column

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
            if (usersDate && usersDate.length > 0) {
                loadSortPreference(); // Load saved sorting preference
            } else {
                console.warn("User data is not loaded yet.");
            }
        }, 100); // Delay ensures UsersData is available
    };

</script>
