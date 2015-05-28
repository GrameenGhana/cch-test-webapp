@extends('layouts.no_auth')

<?php

 $useageByDay = DB::select(DB::raw('SELECT Count(*) as dailycount , DAYNAME(updated_at) as day From cch_tracker GROUP BY DAYNAME(updated_at)'));
 
            //var_dump($useageByDay);

?>


@section('content')

<div class="row" id="roleBox">
                    <center><h3></h3></center>

                    <div id="container2" class="col-md-10" ></div>
                    
                </div>

@stop


@section('script')

<script type="text/javascript">

  //User By Access day by day Time Series
      $(function () {
         $('#container2').highcharts({
             title: {
                 text: 'User By Access by day',
                 x: -20 //center
             },
            
             xAxis: {
                 categories: ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun']
             },
             yAxis: {
                 title: {
                     text: 'Usage'
                 },
                 plotLines: [{
                     value: 0,
                     width: 1,
                     color: '#808080'
                 }]
             },
            
             legend: {
                 layout: 'vertical',
                 align: 'right',
                 verticalAlign: 'middle',
                 borderWidth: 0
             },
             series: [ {
                 name: 'Usage',
                 data: [<?php
    foreach ($useageByDay as $value) {
        if ($value != "") {
            echo "$value->dailycount,";
        }
    }
    ?>]
             }]
         });
     });
     


</script>

@stop