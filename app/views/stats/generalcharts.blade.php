@extends('layouts.no_auth')
<?php
// $useageByVersion = DB::table('cch_tracker')
//                    ->selectRaw('version','count(*) as versioncount')
//                    ->whereRaw('version is Not Null')
//                    ->groupBy('version')
//                    ->get();
 
 $useageByVersion = DB::select(DB::raw('SELECT version,count(*) as aggregate FROM `cch_tracker`  GROUP BY version'));
 
            //var_dump($useageByDay);

?>
@section('content')	

<div class="row">
                    <center><h3>Users By Gender</h3></center>

                    <div id="byGender" class="col-md-8"></div>

                    <div class="col-md-4">

                        <div class="box">
                            <div class="box-header">
                            </div><!-- /.box-header -->
                            <div class="box-body no-padding">
                                <table class="table table-striped">
                                    <tbody>
                                        <tr>
                                            <th>Gender</th>
                                            <th>Progress</th>
                                            <th style="width: 40px">Total</th>
                                        </tr>
                                        <tr>
                                            <td>Males</td>
                                            <td>
                                                <div class="progress xs">
                                                    <div class="progress-bar progress-bar-yellow" style="width: <?php echo (($usersMale * 100) / $usersCount ); ?>%"></div>
                                                </div>
                                            </td>
                                            <td><span class="badge bg-yellow">{{ $usersMale }}</span></td>
                                        </tr>
                                        <tr>
                                            <td>Females</td>
                                            <td>
                                                <div class="progress xs">
                                                    <div class="progress-bar progress-bar-success" style="width: <?php echo (($usersFemale * 100) / $usersCount ); ?>%"></div>
                                                </div>
                                            </td>
                                            <td><span class="badge bg-green">{{ $usersFemale }}</span></td>
                                        </tr>

                                        <tr>
                                            <td>Not Assigned</td>
                                            <td>
                                                <div class="progress xs progress-striped active">
                                                    <div class="progress-bar progress-bar-danger" style="width: <?php echo (($usersNotAssignedGender * 100) / $usersCount ); ?>%"></div>
                                                </div>
                                            </td>
                                            <td><span class="badge bg-red">{{ $usersNotAssignedGender }}</span></td>
                                        </tr>


                                    </tbody></table>
                            </div><!-- /.box-body -->
                        </div><!-- /.box -->

                    </div>
                </div>

                <hr class="space">

                <div class="row" id="groupBox">
                    <center><h3>Users By Group</h3></center>

                    <div id="byGroup" class="col-md-8"></div>

                    <div class="col-md-4">

                        <div class="box">
                            <div class="box-header">
                            </div><!-- /.box-header -->
                            <div class="box-body no-padding">
                                <table class="table table-striped">
                                    <tbody>
                                        <tr>
                                            <th>Group</th>
                                            <th>Progress</th>
                                            <th style="width: 40px">Total</th>
                                        </tr>
                                        <tr>
                                            <td>GHS - Ghana Health Service</td>
                                            <td>
                                                <div class="progress xs">
                                                    <div class="progress-bar progress-bar-yellow" style="width: <?php echo (($usersghs * 100) / $usersCount ); ?>%"></div>
                                                </div>
                                            </td>
                                            <td><span class="badge bg-yellow">{{ $usersghs }}</span></td>
                                        </tr>
                                        <tr>
                                            <td>CCH Team</td>
                                            <td>
                                                <div class="progress xs">
                                                    <div class="progress-bar progress-bar-success" style="width: <?php echo (($userscch * 100) / $usersCount ); ?>%"></div>
                                                </div>
                                            </td>
                                            <td><span class="badge bg-green">{{ $userscch }}</span></td>
                                        </tr>

                                        <tr>
                                            <td>Test Users</td>
                                            <td>
                                                <div class="progress xs progress-striped active">
                                                    <div class="progress-bar progress-bar-danger" style="width: <?php echo (($userstest * 100) / $usersCount ); ?>%"></div>
                                                </div>
                                            </td>
                                            <td><span class="badge bg-red">{{ $userstest }}</span></td>
                                        </tr>

                                       



                                    </tbody></table>
                            </div><!-- /.box-body -->
                        </div><!-- /.box -->

                    </div>
                </div>


                <hr class="space">

                <div class="row" id="roleBox">
                    <center><h3>Users By Role</h3></center>

                    <div id="byRole" class="col-md-8"></div>

                    <div class="col-md-4">

                        <div class="box">
                            <div class="box-header">
                            </div><!-- /.box-header -->
                            <div class="box-body no-padding">
                                <table class="table table-striped">
                                    <tbody>
                                        <tr>
                                            <th>Role</th>
                                            <th>Progress</th>
                                            <th style="width: 40px">Total</th>
                                        </tr>
                                        <tr>
                                            <td>Admin</td>
                                            <td>
                                                <div class="progress xs">
                                                    <div class="progress-bar progress-bar-yellow" style="width: <?php echo (($usersadmin * 100) / $usersCount ); ?>%"></div>
                                                </div>
                                            </td>
                                            <td><span class="badge bg-yellow">{{ $usersadmin }}</span></td>
                                        </tr>
                                        <tr>
                                            <td>Concern</td>
                                            <td>
                                                <div class="progress xs">
                                                    <div class="progress-bar progress-bar-yellow" style="width: <?php echo (($usersconcern * 100) / $usersCount ); ?>%"></div>
                                                </div>
                                            </td>
                                            <td><span class="badge bg-yellow">{{ $usersconcern }}</span></td>
                                        </tr>

                                        <tr>
                                            <td>District Admin</td>
                                            <td>
                                                <div class="progress xs progress-striped active">
                                                    <div class="progress-bar progress-bar-yellow" style="width: <?php echo (($usersdistrictadmin * 100) / $usersCount ); ?>%"></div>
                                                </div>
                                            </td>
                                            <td><span class="badge bg-yellow">{{ $usersdistrictadmin }}</span></td>
                                        </tr>

                                       <tr>
                                            <td>District Supervisor</td>
                                            <td>
                                                <div class="progress xs progress-striped active">
                                                    <div class="progress-bar progress-bar-yellow" style="width: <?php echo (($usersdistrictsupervisor * 100) / $usersCount ); ?>%"></div>
                                                </div>
                                            </td>
                                            <td><span class="badge bg-yellow">{{ $usersdistrictsupervisor }}</span></td>
                                        </tr>

                                        <tr>
                                            <td>National Supervisor</td>
                                            <td>
                                                <div class="progress xs progress-striped active">
                                                    <div class="progress-bar progress-bar-yellow" style="width: <?php echo (($usersnationalsupervisor * 100) / $usersCount ); ?>%"></div>
                                                </div>
                                            </td>
                                            <td><span class="badge bg-yellow">{{ $usersnationalsupervisor }}</span></td>
                                        </tr>

                                        <tr>
                                            <td>Regional Supervisor</td>
                                            <td>
                                                <div class="progress xs progress-striped active">
                                                    <div class="progress-bar progress-bar-yellow" style="width: <?php echo (($usersregionalsupervisor * 100) / $usersCount ); ?>%"></div>
                                                </div>
                                            </td>
                                            <td><span class="badge bg-yellow">{{ $usersregionalsupervisor }}</span></td>
                                        </tr>

                                        <tr>
                                            <td>Sub-district Supervisor</td>
                                            <td>
                                                <div class="progress xs progress-striped active">
                                                    <div class="progress-bar progress-bar-yellow" style="width: <?php echo (($usersdistrictsupervisor * 100) / $usersCount ); ?>%"></div>
                                                </div>
                                            </td>
                                            <td><span class="badge bg-yellow">{{ $userssubdistrictsupervisor }}</span></td>
                                        </tr>

                                        <tr>
                                            <td>Nurse</td>
                                            <td>
                                                <div class="progress xs progress-striped active">
                                                    <div class="progress-bar progress-bar-yellow" style="width: <?php echo (($usersnurse * 100) / $usersCount ); ?>%"></div>
                                                </div>
                                            </td>
                                            <td><span class="badge bg-yellow">{{ $usersnurse }}</span></td>
                                        </tr>

                                        <tr>
                                            <td>Researcher</td>
                                            <td>
                                                <div class="progress xs progress-striped active">
                                                    <div class="progress-bar progress-bar-yellow" style="width: <?php echo (($usersresearcher * 100) / $usersCount ); ?>%"></div>
                                                </div>
                                            </td>
                                            <td><span class="badge bg-yellow">{{ $usersresearcher }}</span></td>
                                        </tr>

                                        <tr>
                                            <td>Supervisor</td>
                                            <td>
                                                <div class="progress xs progress-striped active">
                                                    <div class="progress-bar progress-bar-yellow" style="width: <?php echo (($userssupervisor * 100) / $usersCount ); ?>%"></div>
                                                </div>
                                            </td>
                                            <td><span class="badge bg-yellow">{{ $userssupervisor }}</span></td>
                                        </tr>

                                        <tr>
                                            <td>System</td>
                                            <td>
                                                <div class="progress xs progress-striped active">
                                                    <div class="progress-bar progress-bar-yellow" style="width: <?php echo (($userssystem * 100) / $usersCount ); ?>%"></div>
                                                </div>
                                            </td>
                                            <td><span class="badge bg-yellow">{{ $userssystem }}</span></td>
                                        </tr>



                                    </tbody></table>
                            </div><!-- /.box-body -->
                        </div><!-- /.box -->

                    </div>
                    
                    
                    
                </div>
                
                <hr class="space">

                <div class="row" id="roleBox">
                    <center><h3>Usage By Version</h3></center>

                    <div id="container3" class="col-md-8"></div>
                    
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
     	
     	// Radialize the colors
 		Highcharts.getOptions().colors = Highcharts.map(Highcharts.getOptions().colors, function(color) {
 		    return {
 		        radialGradient: { cx: 0.5, cy: 0.3, r: 0.7 },
 		        stops: [
 		            [0, color],
 		            [1, Highcharts.Color(color).brighten(-0.3).get('rgb')] // darken
 		        ]
 		    };
		});
 		
 		// Build the chart
         $('#container3').highcharts({
             chart: {
                 plotBackgroundColor: null,
                 plotBorderWidth: null,
                 plotShadow: false
             },
             title: {
                 text: ''
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
                 name: 'Transactions',
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
     
     
     
     
    

</script>

@stop