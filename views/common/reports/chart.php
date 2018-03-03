<div id="curve_chart" style="width: 1200px; height: 600px"></div>
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
<script type="text/javascript">
    google.charts.load('current', {'packages':['corechart']});
    google.charts.setOnLoadCallback(drawChart);
  
    function drawChart() {
        var chart_data = <?= json_encode($chart_data) ?>;
        var data = google.visualization.arrayToDataTable(chart_data);

        var options = {
            title: '<?= $title ?>',
            legend: { position: '<?= !empty($legend_position) ? $legend_position : 'bottom' ?>' }
        };

        var chart = new google.visualization.LineChart(document.getElementById('curve_chart'));

        chart.draw(data, options);
    }
</script>

