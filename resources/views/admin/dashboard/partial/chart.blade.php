<script>
    (function() {
        var options = {
            labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
            series: [{
                name: 'Users',
                data: @json($user_records)
            }, {
                name: 'Videos',
                data:@json($video_records)
            }],
            colors: [blue, green],
            chart: {
                height: '100%',
                type: 'line',
                toolbar: {
                    show: false
                }
            },
            grid: {
                borderColor: borderColor,
                strokeDashArray: 0,
                xaxis: {
                    lines: {
                        show: true
                    }
                },
                yaxis: {
                    lines: {
                        show: false
                    }
                },
                padding: {
                    top: 0,
                    left: 15,
                    right: 0,
                    bottom: 0
                }
            },
            stroke: {
                width: 3,
                curve: 'smooth'
            },
            xaxis: {
                axisBorder: {
                    show: false
                },
                axisTicks: {
                    show: false
                },
                tooltip: {
                    enabled: false
                }
            },
            legend: {
                show: false
            },
            dataLabels: {
                enabled: false
            },
            tooltip: {
                x: {
                    show: false
                }
            }
        };

        var chart = document.querySelector('#chart-sales-figures');
        if (chart != null) {
            new ApexCharts(chart, options).render();
        }
    })();
</script>
