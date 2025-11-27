document.addEventListener('DOMContentLoaded', function() {
    // Modern color palette
    var modernColors = {
        primary: {
            gradient: {
                start: 'rgba(102, 126, 234, 0.8)',
                end: 'rgba(118, 75, 162, 0.8)'
            },
            solid: '#667eea',
            light: 'rgba(102, 126, 234, 0.1)'
        },
        success: {
            gradient: {
                start: 'rgba(16, 185, 129, 0.8)',
                end: 'rgba(5, 150, 105, 0.8)'
            },
            solid: '#10b981',
            light: 'rgba(16, 185, 129, 0.1)'
        },
        warning: {
            gradient: {
                start: 'rgba(251, 191, 36, 0.8)',
                end: 'rgba(245, 158, 11, 0.8)'
            },
            solid: '#fbbf24',
            light: 'rgba(251, 191, 36, 0.1)'
        },
        info: {
            gradient: {
                start: 'rgba(59, 130, 246, 0.8)',
                end: 'rgba(37, 99, 235, 0.8)'
            },
            solid: '#3b82f6',
            light: 'rgba(59, 130, 246, 0.1)'
        }
    };

    // Helper function to create gradient
    function createGradient(ctx, colorStart, colorEnd) {
        var gradient = ctx.createLinearGradient(0, 0, 0, 400);
        gradient.addColorStop(0, colorStart);
        gradient.addColorStop(1, colorEnd);
        return gradient;
    }

    // Line Chart - Tasks Distribution
    var lineChartEl = document.getElementById('chart-sales-dark-id');
    if (lineChartEl) {
        // var lineChartData = {!! $lineChartData !!};
        var ctx = lineChartEl.getContext('2d');

        // Enhance datasets with modern styling
        if (lineChartData.datasets && lineChartData.datasets.length > 0) {
            lineChartData.datasets.forEach(function(dataset, index) {
                var colors = [
                    modernColors.primary,
                    modernColors.success,
                    modernColors.warning,
                    modernColors.info
                ];
                var color = colors[index % colors.length];

                dataset.borderColor = color.solid;
                dataset.backgroundColor = createGradient(ctx, color.gradient.start, color.gradient.end);
                dataset.borderWidth = 3;
                dataset.pointRadius = 6;
                dataset.pointHoverRadius = 8;
                dataset.pointBackgroundColor = '#ffffff';
                dataset.pointBorderColor = color.solid;
                dataset.pointBorderWidth = 2;
                dataset.pointHoverBackgroundColor = color.solid;
                dataset.pointHoverBorderColor = '#ffffff';
                dataset.pointHoverBorderWidth = 3;
                dataset.fill = true;
                dataset.tension = 0.4;
                dataset.cubicInterpolationMode = 'monotone';
            });
        }

        var lineChart = new Chart(lineChartEl, {
            type: 'line',
            data: lineChartData,
            options: {
                responsive: true,
                maintainAspectRatio: false,
                animation: {
                    duration: 2000,
                    easing: 'easeInOutQuart'
                },
                legend: {
                    display: true,
                    position: 'top',
                    labels: {
                        usePointStyle: true,
                        padding: 20,
                        fontFamily: "'Open Sans', sans-serif",
                        fontSize: 12,
                        fontColor: '#4a5568',
                        fontStyle: '600',
                        boxWidth: 12,
                        padding: 15
                    }
                },
                tooltips: {
                    enabled: true,
                    mode: 'index',
                    intersect: false,
                    backgroundColor: 'rgba(26, 32, 44, 0.95)',
                    titleFontFamily: "'Open Sans', sans-serif",
                    titleFontSize: 14,
                    titleFontStyle: '600',
                    titleFontColor: '#ffffff',
                    titleSpacing: 10,
                    titleMarginBottom: 10,
                    bodyFontFamily: "'Open Sans', sans-serif",
                    bodyFontSize: 13,
                    bodyFontColor: '#e2e8f0',
                    bodySpacing: 8,
                    padding: 16,
                    cornerRadius: 8,
                    displayColors: true,
                    callbacks: {
                        label: function(tooltipItem, data) {
                            var label = data.datasets[tooltipItem.datasetIndex].label || '';
                            if (label) {
                                label += ': ';
                            }
                            label += tooltipItem.yLabel;
                            return label;
                        }
                    }
                },
                scales: {
                    yAxes: [{
                        beginAtZero: true,
                        gridLines: {
                            color: 'rgba(0, 0, 0, 0.08)',
                            lineWidth: 1,
                            drawBorder: false,
                            zeroLineColor: 'rgba(0, 0, 0, 0.1)',
                            zeroLineWidth: 2
                        },
                        ticks: {
                            precision: 0,
                            fontFamily: "'Open Sans', sans-serif",
                            fontSize: 11,
                            fontColor: '#718096',
                            padding: 10,
                            beginAtZero: true
                        }
                    }],
                    xAxes: [{
                        gridLines: {
                            display: false,
                            drawBorder: false
                        },
                        ticks: {
                            fontFamily: "'Open Sans', sans-serif",
                            fontSize: 11,
                            fontColor: '#718096',
                            padding: 10
                        }
                    }]
                },
                elements: {
                    point: {
                        hoverRadius: 8,
                        hoverBorderWidth: 3
                    },
                    line: {
                        borderCapStyle: 'round',
                        borderJoinStyle: 'round'
                    }
                },
                plugins: {
                    filler: {
                        propagate: false
                    }
                }
            }
        });
        $(lineChartEl).data('chart', lineChart);
    }

    // Bar Chart - Performance
    var barChartEl = document.getElementById('chart-bars-id');
    if (barChartEl) {
        // var barChartData = {!! $barChartData !!};
        var ctx = barChartEl.getContext('2d');

        // Enhance datasets with modern styling
        if (barChartData.datasets && barChartData.datasets.length > 0) {
            barChartData.datasets.forEach(function(dataset, index) {
                var colors = [
                    modernColors.primary,
                    modernColors.success,
                    modernColors.warning,
                    modernColors.info
                ];
                var color = colors[index % colors.length];

                // Create gradient for bars
                var gradient = ctx.createLinearGradient(0, 0, 0, 400);
                gradient.addColorStop(0, color.gradient.start);
                gradient.addColorStop(1, color.gradient.end);

                dataset.backgroundColor = gradient;
                dataset.borderColor = color.solid;
                dataset.borderWidth = 2;
                dataset.borderRadius = 8;
                dataset.borderSkipped = false;
                dataset.barThickness = 'flex';
                dataset.maxBarThickness = 60;
            });
        }

        var barChart = new Chart(barChartEl, {
            type: 'bar',
            data: barChartData,
            options: {
                responsive: true,
                maintainAspectRatio: false,
                animation: {
                    duration: 2000,
                    easing: 'easeInOutQuart'
                },
                legend: {
                    display: true,
                    position: 'top',
                    labels: {
                        usePointStyle: true,
                        padding: 20,
                        fontFamily: "'Open Sans', sans-serif",
                        fontSize: 12,
                        fontColor: '#4a5568',
                        fontStyle: '600',
                        boxWidth: 12,
                        padding: 15
                    }
                },
                tooltips: {
                    enabled: true,
                    mode: 'index',
                    intersect: false,
                    backgroundColor: 'rgba(26, 32, 44, 0.95)',
                    titleFontFamily: "'Open Sans', sans-serif",
                    titleFontSize: 14,
                    titleFontStyle: '600',
                    titleFontColor: '#ffffff',
                    titleSpacing: 10,
                    titleMarginBottom: 10,
                    bodyFontFamily: "'Open Sans', sans-serif",
                    bodyFontSize: 13,
                    bodyFontColor: '#e2e8f0',
                    bodySpacing: 8,
                    padding: 16,
                    cornerRadius: 8,
                    displayColors: true,
                    callbacks: {
                        label: function(tooltipItem, data) {
                            var label = data.datasets[tooltipItem.datasetIndex].label || '';
                            if (label) {
                                label += ': ';
                            }
                            label += tooltipItem.yLabel;
                            return label;
                        }
                    }
                },
                scales: {
                    yAxes: [{
                        beginAtZero: true,
                        gridLines: {
                            color: 'rgba(0, 0, 0, 0.08)',
                            lineWidth: 1,
                            drawBorder: false,
                            zeroLineColor: 'rgba(0, 0, 0, 0.1)',
                            zeroLineWidth: 2
                        },
                        ticks: {
                            precision: 0,
                            fontFamily: "'Open Sans', sans-serif",
                            fontSize: 11,
                            fontColor: '#718096',
                            padding: 10,
                            beginAtZero: true
                        }
                    }],
                    xAxes: [{
                        gridLines: {
                            display: false,
                            drawBorder: false
                        },
                        ticks: {
                            fontFamily: "'Open Sans', sans-serif",
                            fontSize: 11,
                            fontColor: '#718096',
                            padding: 10
                        },
                        categoryPercentage: 0.6,
                        barPercentage: 0.8
                    }]
                },
                elements: {
                    rectangle: {
                        borderSkipped: false
                    }
                }
            }
        });
        $(barChartEl).data('chart', barChart);
    }
});
