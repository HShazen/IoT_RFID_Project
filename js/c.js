


function renderLineChart(lineId, labels, values) {
    const ctx = document.getElementById(lineId);

    if (!ctx) {
        console.error("Error: Canvas element  '" + lineId + "' not found.");
        return;
    }

    new Chart(ctx.getContext('2d'), { // Ensure 2D context
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
                x: { title: { display: true, text: 'Time (Minutes)' } },
                y: { title: { display: true, text: 'Number of Logs' },
                beginAtZero: true,  // ✅ Ensures Y-axis starts at 0
                min: 0,             // ✅ Forces Y-axis to always start at 0
                suggestedMin: 0,    // 🔹 Optional, but helps
                ticks: {
                    callback: function(value) {
                        return value.toFixed(0); // Ensure whole numbers
                    },
                    stepSize: 1, // ✅ Ensures only whole numbers appear
                    callback: function(value) {
                        return value; // ✅ Keep values as integers
                    }
                }
                }
            },
            plugins: {
                legend: {
                    display: false // ✅ This hides the legend
                }
            }
        }
    });
}

function renderBarChart(barId, labels, values) {
    const ctx = document.getElementById(barId);

    if (!ctx) {
        console.error("Error: Canvas element '" + barId + "' not found.");
        return;
    }

    new Chart(ctx.getContext('2d'), {
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
                x: { title: { display: true, text: 'Date' } },
                y: { title: { display: true, text: 'Number of Logs' }, 
                beginAtZero: true,  // ✅ Ensures Y-axis starts at 0
                min: 0,             // ✅ Forces Y-axis to always start at 0
                suggestedMin: 0,    // 🔹 Optional, but helps
                ticks: {
                    callback: function(value) {
                        return value.toFixed(0); // Ensure whole numbers
                    },
                    stepSize: 5, // ✅ Ensures only whole numbers appear
                    callback: function(value) {
                        return value; // ✅ Keep values as integers
                    }
                }
                }
            },
            plugins: {
                legend: {
                    display: false // ✅ This hides the legend
                }
            }
        }   
    });
}
/*


function renderLineChart(lineId, labels, values) {
    const ctx = document.getElementById(lineId);

    if (!ctx) {
        console.error("Error: Canvas element  '" + lineId + "' not found.");
        return;
    }

    new Chart(ctx.getContext('2d'), { // Ensure 2D context
        type: 'line',
        data: {
            labels: labels,
            datasets: [{
                label: 'Logs Per Minute',
                data: values,
                lineTension: 0.3,
                backgroundColor: "rgba(2,117,216,0.2)",
                borderColor: "rgba(2,117,216,1)",
                pointRadius: 5,
                pointBackgroundColor: "rgba(2,117,216,1)",
                pointBorderColor: "rgba(255,255,255,0.8)",
                pointHoverRadius: 5,
                pointHoverBackgroundColor: "rgba(2,117,216,1)",
                pointHitRadius: 50,
                pointBorderWidth: 2,
            }]
        },
        options: {
            //responsive: true,
            scales: {
                xAxes: [{ 
                    title: { display: true, text: 'Time (Minutes)' },
                    time: {
                        unit: 'hour'
                    },
                    gridLines: {
                        display: false
                    },
                    ticks: {
                        maxTicksLimit: 7
                    }
                }],
                yAxes: [{ 
                    title: { display: true, text: 'Number of Logs' },
                    ticks: {
                        min: 0,
                    },
                    gridLines: {
                        color: "rgba(0, 0, 0, .125)",
                    }
                }],
            },
            legend: {
                display: false
            }
        }
    });
}


function renderBarChart(barId, labels, values) {
    const ctx = document.getElementById(barId);

    if (!ctx) {
        console.error("Error: Canvas element '" + barId + "' not found.");
        return;
    }

    new Chart(ctx.getContext('2d'), {
        type: 'bar',
        data: {
            labels: labels,
            datasets: [{
                label: 'Logs Per Day',
                data: values,
                backgroundColor: "rgba(2,117,216,1)",
                borderColor: "rgba(2,117,216,1)",
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            scales: {
                xAxes: [{ 
                    title: { display: true, text: 'Date' },
                    time: {
                        unit: 'week'
                      },
                      gridLines: {
                        display: false
                      },
                      ticks: {
                        maxTicksLimit: 6
                      }
                }],
                yAxes: [{ 
                    title: { display: true, text: 'Date' },
                    ticks: {
                        min: 0
                    },
                    gridLines: {
                        display: true
                    }
                }],
            },
            legend: {
                display: false
            }
        }
    });
}
*/