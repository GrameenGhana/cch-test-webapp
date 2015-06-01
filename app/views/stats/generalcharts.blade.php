@extends('layouts.no_auth')
<?php
 
 $useageByVersion = DB::select(DB::raw('SELECT version,count(*) as aggregate FROM `cch_tracker`  GROUP BY version'));
 
 $deviceAssignmentByType = DB::select(DB::raw('SELECT type,count(*) as aggregate FROM `cch_devices`  GROUP BY type'));

 $deviceAssignmentByStatus = DB::select(DB::raw('SELECT status,count(*) as aggregate FROM `cch_devices`  GROUP BY status'));

?>
@section('content')	

                <div class="row">
                    <center><h3>Users By Gender</h3></center>

                    <div id="byGender" class="col-md-8"></div>

                </div>

                <hr class="space">

                <div class="row" id="groupBox">
                    <center><h3>Users By Group</h3></center>

                    <div id="byGroup" class="col-md-8"></div>

                </div>


                <hr class="space">

                <div class="row" id="roleBox">
                    <center><h3>Users By Role</h3></center>

                    <div id="byRole" class="col-md-8"></div>
                    
                </div>
                
                <hr class="space">

                <div class="row" id="usageVersionBox">
                    <center><h3>Usage By Version</h3></center>

                    <div id="usage_version_container" class="col-md-8"></div>
                    
                </div>

                <hr class="space">

                <div class="row" id="deviceTypeBox">
                    <center><h3>Device Assignment per Type</h3></center>

                    <div id="device_type_container" class="col-md-8"></div>
                    
                </div>

                <hr class="space">

                <div class="row" id="deviceStatusBox">
                    <center><h3>Device Assignment per Status</h3></center>

                    <div id="device_status_container" class="col-md-8"></div>
                    
                </div>
                
               
                
                
@stop

@section('script')

<script type="text/javascript">

$(function() {
    $('#byGender').highcharts(
    {{json_encode($usersByGender)}}
    )
    
    $('#byGroup').highcharts(
    {{json_encode($usersByGroup)}}
    )

     $('#byRole').highcharts(
    {{json_encode($usersByRole)}}
    )
  
});


//Usage By version  Pie Chart
     $(function () {
     	
 		
 		// Build the chart
         $('#usage_version_container').highcharts({
             chart: {
                 plotBackgroundColor: null,
                 plotBorderWidth: 1,
                 plotShadow: false
             },
             title: {
                 text: ''
             },
            credits: {
                  enabled: false
              },
             tooltip: {
         	    pointFormat: '{series.name}: <b>{point.y}</b>'
             },
             plotOptions: {
                 pie: {
                     allowPointSelect: true,
                     cursor: 'pointer',
                     dataLabels: {
                         enabled: true,
                         format: '<b>{point.name}</b>: {point.y} ',
                         style: {
                             color: (Highcharts.theme && Highcharts.theme.contrastTextColor) || 'black'
                         },
                         connectorColor: 'silver'
                     }
                 }
             },
             series: [{
                 type: 'pie',
                 name: 'Usage By Version',
                 data: [
    <?php foreach ($useageByVersion as $value) {
        if ($value != "") {
            echo "['$value->version',$value->aggregate],";
        }
    } ?>
                   
                 ]
                 
             }]
         });
     });
     
     
//Device Assignment Per Type Pie Chart
     $(function () {
        
        
        // Build the chart
         $('#device_type_container').highcharts({
             chart: {
                 plotBackgroundColor: null,
                 plotBorderWidth: 1,
                 plotShadow: false
             },
             title: {
                 text: ''
             },
            credits: {
                  enabled: false
              },
             tooltip: {
                pointFormat: '{series.name}: <b>{point.y}</b>'
             },
             plotOptions: {
                 pie: {
                     allowPointSelect: true,
                     cursor: 'pointer',
                     dataLabels: {
                         enabled: true,
                         format: '<b>{point.name}</b>: {point.y} ',
                         style: {
                             color: (Highcharts.theme && Highcharts.theme.contrastTextColor) || 'black'
                         },
                         connectorColor: 'silver'
                     }
                 }
             },
             series: [{
                 type: 'pie',
                 name: 'Device Assignment Per Type',
                 data: [
    <?php foreach ($deviceAssignmentByType as $value) {
        if ($value != "") {
            echo "['$value->type',$value->aggregate],";
        }
    } ?>
                   
                 ]
                 
             }]
         });
     });
     


//Device Assignment Per Status  Pie Chart
     $(function () {
        
       
        
        // Build the chart
         $('#device_status_container').highcharts({
             chart: {
                 plotBackgroundColor: null,
                 plotBorderWidth: 1,
                 plotShadow: false
             },
             title: {
                 text: ''
             },
             credits: {
                  enabled: false
              },
             tooltip: {
                pointFormat: '{series.name}: <b>{point.y}</b>'
             },
             plotOptions: {
                 pie: {
                     allowPointSelect: true,
                     cursor: 'pointer',
                     dataLabels: {
                         enabled: true,
                         format: '<b>{point.name}</b>: {point.y} ',
                         style: {
                             color: (Highcharts.theme && Highcharts.theme.contrastTextColor) || 'black'
                         },
                         connectorColor: 'silver'
                     }
                 }
             },
             series: [{
                 type: 'pie',
                 name: 'Device Assignment Per Status',
                 data: [
    <?php foreach ($deviceAssignmentByStatus as $value) {
        if ($value != "") {
            echo "['$value->status',$value->aggregate],";
        }
    } ?>
                   
                 ]
                 
             }]
         });
     });
     
     
    

</script>

@stop