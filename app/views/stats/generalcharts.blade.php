@extends('layouts.no_auth')

@section('content')	
<h1>General Charts Here!</h1>


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
  
});


</script>

@stop