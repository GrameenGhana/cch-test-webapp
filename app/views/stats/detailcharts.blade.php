@extends('layouts.no_auth')
<?php

 //roles with count of users
 $usersByRole = DB::connection('mysql2')->select(DB::raw('SELECT role,count(username) as aggregate FROM users  GROUP BY role'));

//regions with count of users 
 $usersByRegion = DB::connection('mysql2')->select(DB::raw('SELECT region,count(username) as aggregate FROM users  GROUP BY region'));
 
//modules with count of users 
 $usersByModule = DB::connection('mysql2')->select(DB::raw('SELECT module,count(username) as aggregate FROM moduleusage  GROUP BY module'));

 //modules with count of time spent
 $timeByModule = DB::connection('mysql2')->select(DB::raw('SELECT module,sum(mins_spent) as aggregate FROM moduleusage  GROUP BY module'));

?>
@section('content')	

                <div class="row" id="roleBox">

                    <div id="users_role_container" class="col-md-8"></div>
                    
                </div>

                <hr class="space">

                <div class="row" id="regionBox">

                    <div id="users_region_container" class="col-md-8"></div>
                    
                </div>

                <hr class="space">

                <div class="row" id="usersmoduleBox">

                    <div id="users_module_container" class="col-md-8"></div>
                    
                </div>

                 <hr class="space">

                <div class="row" id="timespentmoduleBox">

                    <div id="time_module_container" class="col-md-8"></div>
                    
                </div>
@stop

@section('script')
<script type="text/javascript">


     $(function () {
     
      // users per role chart
          $('#users_role_container').highcharts({
              chart: {
                  type: 'column',
                  events: {
                      drilldown: function (e) {
                          if (!e.seriesOptions) {

                              var chart = this,
                                  drilldowns = {

                                  	 <?php foreach ($usersByRole as $value) {
       										 if ($value != "") {
           										 echo "'$value->role' : { 
           										 	name: '$value->role' ,
           										 	data : [ ";

           									$usersByRoleStatus = DB::connection('mysql2')->select(DB::raw("SELECT count(*) as aggregate,status FROM users WHERE role='$value->role' GROUP BY status"));

           									foreach ($usersByRoleStatus as $v) {
           										echo "['$v->status',$v->aggregate],";
           									}

                                                    echo "]},";
       											 }
   									 		} 

   									 ?>

                                  },
                                  series = drilldowns[e.point.name];

                              // Show the loading label
                              chart.showLoading('Loading data ...');

                              setTimeout(function () {
                                  chart.hideLoading();
                                  chart.addSeriesAsDrilldown(e.point, series);
                              }, 1000);
                          }

                      }
                  }
              },
              title: {
                  text: 'Users By Role'
              },
              xAxis: {
                  type: 'category'
              },

              legend: {
                  enabled: false
              },

               credits: {
                  enabled: false
              },

              plotOptions: {
                  series: {
                      borderWidth: 0,
                      dataLabels: {
                          enabled: true
                      }
                  }
              },

              series: [{
                  name: 'Roles',
                  colorByPoint: true,
                  data: [
                  <?php foreach ($usersByRole as $value) {
        					if ($value != "") {
           						 echo "{ name: '$value->role',y: $value->aggregate,drilldown: true },";
        					}
    					}
     				?>

                  ]
              }],

              drilldown: {
                  series: []
              }
          }); //


// users per region chart
          $('#users_region_container').highcharts({
              chart: {
                  type: 'column',
                  events: {
                      drilldown: function (e) {
                          if (!e.seriesOptions) {

                              var chart = this,
                                  drilldowns = {

                                  	 <?php 

                                  	 foreach ($usersByRegion as $value) {
       										 if ($value != "") {
           										 echo "'$value->region' : { 
           										 	name: '$value->region' ,
           										 	data : [ ";

           									$usersByRoleDistrict = DB::connection('mysql2')->select(DB::raw("SELECT count(*) as aggregate,district FROM users WHERE region='$value->region' GROUP BY district"));

           									foreach ($usersByRoleDistrict as $v) {
           										echo "{name: '$v->district',y: $v->aggregate,drilldown: '$v->district' },";
           									}

                                                echo "]},";
                                            
                                        }

                                    }
                                    
                                           
       									
       										
   									 		

   									 ?>

                                  },

                                  

                                series = drilldowns[e.point.name];

                              // Show the loading label
                              chart.showLoading('Loading data ...');

                              setTimeout(function () {
                                  chart.hideLoading();
                                  chart.addSeriesAsDrilldown(e.point, series);
                              }, 1000);
                          }

                      }
                  }
              },
              title: {
                  text: 'Users By Region'
              },
              xAxis: {
                  type: 'category'
              },

              legend: {
                  enabled: false
              },

              credits: {
                  enabled: false
              },

              plotOptions: {
                  series: {
                      borderWidth: 0,
                      dataLabels: {
                          enabled: true
                      }
                  }
              },

              series: [{
                  name: 'Region',
                  colorByPoint: true,
                  data: [
                  <?php foreach ($usersByRegion as $value) {
        					if ($value != "") {
           						 echo "{ name: '$value->region',y: $value->aggregate,drilldown: true },";
        					}
    					}
     				?>

                  ]
              }],

              drilldown: {
                  series: [

                  <?php 
                  							foreach ($usersByRegion as $value) {

                  								$usersByRoleDistrict = DB::connection('mysql2')->select(DB::raw("SELECT count(*) as aggregate,district FROM users WHERE region='$value->region' GROUP BY district"));

                                                   //query to get users by region by district and by facility 
                                           		foreach ($usersByRoleDistrict as $v) {
                                                   $usersByRoleDistrictFacility = DB::connection('mysql2')->select(DB::raw("SELECT count(*) as aggregate,facility_name FROM users WHERE district ='$v->district' GROUP BY facility_name"));
                                                   
                                                   echo "{ id : '$v->district' , name : '$v->district' , data : [ ";

                                                   foreach ($usersByRoleDistrictFacility as $vf) {
                  										//print_r( array('id'=>"$v->district","name"=>"$v->district", "data" => [array("name"=>"$vf->facility_name","y"=>"$vf->aggregate")]) );
                  										echo " { y: $vf->aggregate,name: '$vf->facility_name'  } ,";
                  									}

                  									echo " ] },";

                                           		}

                                           	}

                  ?>
                  ]
              }
          });


// users per module chart
          $('#users_module_container').highcharts({
              chart: {
                  type: 'column',
                  events: {
                      drilldown: function (e) {
                          if (!e.seriesOptions) {

                              var chart = this,
                                  drilldowns = {

                                  	 <?php 

                                  	 foreach ($usersByModule as $value) {
       										 if ($value != "") {
           										 echo "'$value->module' : { 
           										 	name: '$value->module' ,
           										 	data : [ ";

           									$usersByModuleDistrict = DB::connection('mysql2')->select(DB::raw("SELECT count(*) as aggregate,district FROM moduleusage WHERE module='$value->module' GROUP BY district"));

           									foreach ($usersByModuleDistrict as $v) {
           										echo "{name: '$v->district',y: $v->aggregate,drilldown: '$v->district' },";
           									}

                                                echo "]},";
                                            
                                        }

                                    }
                                    
                                           
       									
       										
   									 		

   									 ?>

                                  },

                                  

                                series = drilldowns[e.point.name];

                              // Show the loading label
                              chart.showLoading('Loading data ...');

                              setTimeout(function () {
                                  chart.hideLoading();
                                  chart.addSeriesAsDrilldown(e.point, series);
                              }, 1000);
                          }

                      }
                  }
              },
              title: {
                  text: 'Users By Module'
              },
              xAxis: {
                  type: 'category'
              },

              legend: {
                  enabled: false
              },

              credits: {
                  enabled: false
              },

              plotOptions: {
                  series: {
                      borderWidth: 0,
                      dataLabels: {
                          enabled: true
                      }
                  }
              },

              series: [{
                  name: 'Module',
                  colorByPoint: true,
                  data: [
                  <?php foreach ($usersByModule as $value) {
        					if ($value != "") {
           						 echo "{ name: '$value->module',y: $value->aggregate,drilldown: true },";
        					}
    					}
     				?>

                  ]
              }],

              drilldown: {
                  series: [

                  <?php 
                  							foreach ($usersByModule as $value) {

                  								$usersByModuleDistrict = DB::connection('mysql2')->select(DB::raw("SELECT count(*) as aggregate,district FROM moduleusage WHERE module='$value->module' GROUP BY district"));

                                                   //query to get users by module by facility type and by facility 
                                           		foreach ($usersByModuleDistrict as $v) {
                                                   $usersByModuleDistrictFacility = DB::connection('mysql2')->select(DB::raw("SELECT count(*) as aggregate,name FROM moduleusage WHERE district ='$v->district' GROUP BY name"));
                                                   
                                                   echo "{ id : '$v->district' , name : '$v->district' , data : [ ";

                                                   foreach ($usersByModuleDistrictFacility as $vf) {
                  										//print_r( array('id'=>"$v->district","name"=>"$v->district", "data" => [array("name"=>"$vf->facility_name","y"=>"$vf->aggregate")]) );
                  										echo " { y: $vf->aggregate,name: '$vf->name'  } ,";
                  									}

                  									echo " ] },";

                                           		}

                                           	}

                  ?>
                  ]
              }
          });


// time spent per module chart
          $('#time_module_container').highcharts({
              chart: {
                  type: 'column',
                  events: {
                      drilldown: function (e) {
                          if (!e.seriesOptions) {

                              var chart = this,
                                  drilldowns = {

                                  	 <?php 

                                  	 foreach ($timeByModule as $value) {
       										 if ($value != "") {
           										 echo "'$value->module' : { 
           										 	name: '$value->module' ,
           										 	data : [ ";

           									$timeByModuleDistrict = DB::connection('mysql2')->select(DB::raw("SELECT sum(mins_spent) as aggregate,district FROM moduleusage WHERE module='$value->module' GROUP BY district"));

           									foreach ($timeByModuleDistrict as $v) {
           										echo "{name: '$v->district',y: $v->aggregate,drilldown: '$v->district' },";
           									}

                                                echo "]},";
                                            
                                        }

                                    }
                                    
                                           
       									
       										
   									 		

   									 ?>

                                  },

                                  

                                series = drilldowns[e.point.name];

                              // Show the loading label
                              chart.showLoading('Loading data ...');

                              setTimeout(function () {
                                  chart.hideLoading();
                                  chart.addSeriesAsDrilldown(e.point, series);
                              }, 1000);
                          }

                      }
                  }
              },
              title: {
                  text: 'Time Spent By Module (mins)'
              },
              xAxis: {
                  type: 'category'
              },

              legend: {
                  enabled: false
              },

              credits: {
                  enabled: false
              },

              plotOptions: {
                  series: {
                      borderWidth: 0,
                      dataLabels: {
                          enabled: true
                      }
                  }
              },

              series: [{
                  name: 'Module',
                  colorByPoint: true,
                  data: [
                  <?php foreach ($timeByModule as $value) {
        					if ($value != "") {
           						 echo "{ name: '$value->module',y: $value->aggregate,drilldown: true },";
        					}
    					}
     				?>

                  ]
              }],

              drilldown: {
                  series: [

                  <?php 
                  							foreach ($timeByModule as $value) {

                  								$timeByModuleDistrict = DB::connection('mysql2')->select(DB::raw("SELECT sum(mins_spent) as aggregate,district FROM moduleusage WHERE module='$value->module' GROUP BY district"));

                                                   //query to get time spent by module by district and by facility 
                                           		foreach ($timeByModuleDistrict as $v) {
                                                   $timeByModuleDistrictFacility = DB::connection('mysql2')->select(DB::raw("SELECT sum(mins_spent) as aggregate,name FROM moduleusage WHERE district ='$v->district' GROUP BY name"));
                                                   
                                                   echo "{ id : '$v->district' , name : '$v->district' , data : [ ";

                                                   foreach ($timeByModuleDistrictFacility as $vf) {
                  										//print_r( array('id'=>"$v->district","name"=>"$v->district", "data" => [array("name"=>"$vf->facility_name","y"=>"$vf->aggregate")]) );
                  										echo " { y: $vf->aggregate,name: '$vf->name'  } ,";
                  									}

                  									echo " ] },";

                                           		}

                                           	}

                  ?>
                  ]
              }
          });




     });


</script>

@stop