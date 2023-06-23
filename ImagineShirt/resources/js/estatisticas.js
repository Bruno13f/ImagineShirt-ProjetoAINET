document.addEventListener('DOMContentLoaded', function() {
    var earningsData = {!! json_encode($earningsData) !!};
    var months = earningsData.map(data => data.month);
    var earnings = earningsData.map(data => data.earnings);

    var ctx2 = document.getElementById('earningsChart').getContext('2d');

    new Chart(ctx2, {
        type: 'line',
        data: {
            labels: months,
            datasets: [{
                label: 'Ganhos',
                data: earnings,
                backgroundColor: 'rgba(0, 123, 255, 0.1)',
                borderColor: 'rgba(0, 123, 255, 1)',
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            scales: {
                y: {
                    beginAtZero: true
                }
            },
            plugins: {
                legend: {
                    display: false
                }
            },
            layout: {
                padding: {
                    top: 10,
                    bottom: 10,
                    left: 10,
                    right: 10
                }
            }
        }
    });
});

document.addEventListener('DOMContentLoaded', function() {
    var clientData = {!! json_encode($clientData) !!};
    var labels = clientData.map(data => data.label);
    var percentages = clientData.map(data => data.percentage);

    var ctx = document.getElementById('userDistributionChart').getContext('2d');

    new Chart(ctx, {
        type: 'pie',
        data: {
            labels: labels,
            datasets: [{
                data: percentages,
                backgroundColor: [
                    'rgba(75, 192, 192, 0.6)',
                    'rgba(255, 205, 86, 0.6)',
                    'rgba(255, 99, 132, 0.6)',
                ],
                borderColor: [
                    'rgba(75, 192, 192, 1)',
                    'rgba(255, 205, 86, 1)',
                    'rgba(255, 99, 132, 1)',
                ],
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'right'
                },
                tooltip: {
                    callbacks: {
                        label: function (context) {
                            var label = context.label || '';

                            if (label) {
                                label += ': ';
                            }
                            if (context.parsed && context.parsed.toFixed) {
                                label += context.parsed.toFixed(2) + '%';
                            }
                            return label;
                        }
                    }
                }
            }
        }
    });
});    