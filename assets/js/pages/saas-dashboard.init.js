// Pie chart
var chart;

$.ajax({
    url: '../../../application/views/admin/getChartDynamic.php',
    type: 'GET',
    dataType: 'json',
    success: function (data) {
        var options = {
            series: data.series,
            chart: {
                type: 'donut',
                height: 262,
            },
            labels: data.labels,
            colors: ['#556ee6', '#34c38f', '#f46a6a', '#5bc0de'], // Update colors if needed
            legend: {
                show: false,
            },
            plotOptions: {
                pie: {
                    donut: {
                        size: '70%',
                    },
                },
            },
        };

        // Create a new chart instance and render it
        chart = new ApexCharts(document.querySelector('#donut-chart'), options);
        chart.render();
    },
    error: function (xhr, status, error) {
        console.error('Error fetching data:', error);
    }
});
