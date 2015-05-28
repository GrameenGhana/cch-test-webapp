@extends('layouts.no_auth')

<?php

 $useageByDay = DB::select(DB::raw('SELECT Count(*) as dailycount , DAYNAME(updated_at) as day From cch_tracker GROUP BY DAYNAME(updated_at)'));
 
 $useageByHour = DB::select(DB::raw('SELECT count(*) as timecount, EXTRACT(HOUR FROM updated_at) as houra FROM cch.cch_tracker GROUP BY EXTRACT(HOUR FROM updated_at)'));
 
           // var_dump($useageByHour);

?>


@section('content')

<div class="row" id="roleBox">
    <center><h3></h3></center>

    <div id="container2" class="col-md-10" ></div>

</div>

<div class="row" id="roleBox">
    <center><h3></h3></center>

    <div id="container3" class="col-md-10" ></div>

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
     

  //User By hour Series
      $(function () {
         $('#container3').highcharts({
             title: {
                 text: 'User By Hour of Day',
                 x: -20 //center
             },
            
             xAxis: {
                 categories: ['0', '1', '2', '3', '4', '5', '6','7','8','9','10',
                 '11','12','13','14','15','16','17','18','19','20','21','22','23']
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
    foreach ($useageByHour as $value) {
        if ($value != "") {
            echo "$value->timecount,";
        }
    }
    ?>]
             }]
         });
     });

</script>

@stop