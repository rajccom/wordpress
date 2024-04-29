<?php
/**
 * @param job      job object - optional
*/
?>
<?php
    $protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";
?>

<div id='wpjobportal-center' class="wjportal-cp-graph-inner-wrp">
    <script src="<?php echo $protocol;?>www.google.com/jsapi?autoload={'modules':[{'name':'visualization','version':'1','packages':['corechart']}]}"></script>
    <script >
        google.charts.load('current', {'packages':['corechart']});
        google.setOnLoadCallback(drawStackChartHorizontal);
        function drawStackChartHorizontal() {
            var data = google.visualization.arrayToDataTable([
            	<?php
                    echo wpjobportal::$_data['stack_chart_horizontal']['title'] . ',';
                    echo wpjobportal::$_data['stack_chart_horizontal']['data'];
                ?>
	        ]);
            var view = new google.visualization.DataView(data);
            <?php if (wpjobportal::$theme_chk == 1) { ?>
                var options = {
                    title: 'Job Type',
                    'height':500,
                    isStacked: 'relative',
                    legend: {position: 'top'},
                    hAxis: {title: 'Month',  titleTextStyle: {color: '#333'}},
                    vAxis: {minValue: 0},
                };
            <?php } else { ?>
                var options = {
                    title: 'Job Type',
                    'height':400,
                    'width':734,
                    isStacked: 'relative',
                    legend: {position: 'top'},
                    hAxis: {title: 'Month',  titleTextStyle: {color: '#333'}},
                    vAxis: {minValue: 0},
                    chartArea: {
                        left: 65,
                        width: 640,
                    }
                };
            <?php } ?>
            var chart = new google.visualization.AreaChart(document.getElementById('chart_div'));
            chart.draw(data, options);
        }
    </script>
    <div id="chart_div" class="wjportal-cp-graph jobseeker"></div>
</div>
