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

// Set default sorting to 'log_date' in descending order when page loads
window.onload = () => {
    sortTable('log_date');  // Automatically sort by 'log_date' in descending order
};
