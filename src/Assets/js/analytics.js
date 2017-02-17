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
                    "#36A2EB"
                ],
                hoverBackgroundColor: [
                    "#36A2EB"
                ]
            },
            {
                label: "Subscriptions",
                data: _chartData._subscriptions,
                backgroundColor: [
                    "#333333"
                ],
                hoverBackgroundColor: [
                    "#333333"
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
                    "#FF6384",
                    "#36A2EB"
                ],
                hoverBackgroundColor: [
                    "#FF6384",
                    "#36A2EB"
                ]
            }]
        }
    });
});
