$(function () {
    var options = {};
    var lineChart = document.getElementById("lineGraph");
    var pieChart = document.getElementById("pieGraph");
    var lineGraph = new Chart(lineChart, {
        type: 'line',
        data: {
            labels: _chartData._days,
            datasets: [{
                label: "Transactions",
                data: _chartData._transactions,
                backgroundColor: [
                    "#0074e8"
                ],
                hoverBackgroundColor: [
                    "#0074e8"
                ]
            },
            {
                label: "Subscriptions",
                data: _chartData._subscriptions,
                backgroundColor: [
                    "#00e874"
                ],
                hoverBackgroundColor: [
                    "#00e874"
                ]
            }]
        },
        options: {
            scales: {
                yAxes: [{
                    ticks: {
                        beginAtZero: true
                    }
                }]
            }
        }
    });

    var pieGraph = new Chart(pieChart, {
        type: 'pie',
        data: {
            labels: ['Refunds', 'Income'],
            datasets: [{
                label: "Transactions",
                data: _chartData._balanceValues,
                backgroundColor: [
                    "#e80000",
                    "#0074e8"
                ],
                hoverBackgroundColor: [
                    "#e80000",
                    "#0074e8"
                ]
            }]
        }
    });
});
