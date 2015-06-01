<?php

class StatsController extends BaseController {

    public function showGeneralCharts(){
        
           //getting all users so as to get the count
        //$subs = 'Select count(*) From cch_users';
        $usersCount = DB::table('cch_users')     
                ->count();
        
        // gender chart data
        $sqlmale = ' gender = "male" ';
        $sqlfemale = ' gender = "female" ';
        
        //Male Users 
        $usersMale = DB::table('cch_users')
                ->whereRaw($sqlmale)
                ->count();
        
         //Female Users 
        $usersFemale = DB::table('cch_users')
                ->whereRaw($sqlfemale)
                ->count();
        
         // Number of not-assigned Users
        $usersNotAssignedGender = DB::table('cch_users')
                ->whereRaw('gender  NOT IN ("male","female") ')
                ->count();
        
        $usersByGender["chart"] = array("plotBackgroundColor" => null,"plotBorderWidth"=>1,"plotShadow"=>false);
        $usersByGender["title"] = array("text" => " ");
        //$chartArray["tooltip"] = array("pointFormat" => "{series.name}: <b>{point.percentage:.1f}%</b>");
        $usersByGender["legend"] = array("enabled" => true);
        $usersByGender["credits"] = array("enabled" => false);
        $usersByGender["plotOptions"] = array("pie" => array("allowPointSelect" => true, "cursor"=>"pointer","dataLabels" => array("enabled" => true,"format"=>"<b>{point.name}</b>: {point.percentage:.1f} % ({y})")));
        $usersByGender["series"][] = array("type" => "pie", 'name' => "Users By Gender", "data" => [array("name" => "Males", "y" => $usersMale), array("name" => "Females", "y" => $usersFemale), array("name" => "Not Assigned", "y" => $usersNotAssignedGender) ]);
       
       

         // group chart data
        $sqlghs = '  c.group = "GHS" ';
        $sqlcch = '  c.group = "CCH" ';
        $sqltest = ' c.group = "Test" ';
        
        //ghs users 
        $usersghs = DB::table('cch_users as c')
                ->whereRaw($sqlghs)
                ->count();
        
        //cch users 
        $userscch = DB::table('cch_users as c')
                ->whereRaw($sqlcch)
                ->count();
        
        //test  users 
        $userstest = DB::table('cch_users as c')
                ->whereRaw( $sqltest)
                ->count();
        
        
        
        $usersByGroup["chart"] = array("plotBackgroundColor" => null,"plotBorderWidth"=>1,"plotShadow"=>true);
        $usersByGroup["title"] = array("text" => " ");
        //$chartArray["tooltip"] = array("pointFormat" => "{series.name}: <b>{point.percentage:.1f}%</b>");
        $usersByGroup["legend"] = array("enabled" => true);
        $usersByGroup["credits"] = array("enabled" => false);
        $usersByGroup["plotOptions"] = array("pie" => array("allowPointSelect" => true, "cursor"=>"pointer","dataLabels" => array("enabled" => true,"format"=>"<b>{point.name}</b>: {point.percentage:.1f} % ({y})")));
        $usersByGroup["series"][] = array("type" => "pie", 'name' => "Users By Group", "data" => [array("name" => "GHS", "y" => $usersghs), array("name" => "CCH", "y" => $userscch), array("name" => "Test", "y" => $userstest) ]);



        // role chart data
        $sqladmin = '  role = "Admin" ';
        $sqlconcern = '  role = "Concern" ';
        $sqldistrictadmin = ' role = "District Admin" ';
        $sqldistrictsupervisor = ' role = "District Supervisor" ';
        $sqlnationalsupervisor = ' role = "National Supervisor" ';
        $sqlregionalsupervisor = '  role = "Regional Supervisor" ';
        $sqlsubdistrictsupervisor = '  role = "Sub-District Supervisor" ';
        $sqlresearcher = '  role = "Researcher" ';
        $sqlnurse = '  role = "Nurse" ';
        $sqlsupervisor = '  role = "Supervisor" ';
        $sqlsystem = '  role = "system" ';
        
        //admin users 
        $usersadmin = DB::table('cch_users')
                ->whereRaw($sqladmin)
                ->count();
        
        //concern users 
        $usersconcern = DB::table('cch_users')
                ->whereRaw($sqlconcern)
                ->count();
        
        //districtadmin  users 
        $usersdistrictadmin = DB::table('cch_users')
                ->whereRaw( $sqldistrictadmin)
                ->count();
    
        //districtsupervisor  users 
        $usersdistrictsupervisor = DB::table('cch_users')
                ->whereRaw( $sqldistrictsupervisor)
                ->count();

        //nationalsupervisor  users 
        $usersnationalsupervisor = DB::table('cch_users')
                ->whereRaw( $sqlnationalsupervisor)
                ->count();

        //regionalsupervisor  users 
        $usersregionalsupervisor = DB::table('cch_users')
                ->whereRaw( $sqlregionalsupervisor)
                ->count();

        //subdistrictsupervisor   users 
        $userssubdistrictsupervisor  = DB::table('cch_users')
                ->whereRaw( $sqlsubdistrictsupervisor )
                ->count();

        //researcher  users 
        $usersresearcher = DB::table('cch_users')
                ->whereRaw( $sqlresearcher)
                ->count();

        //nurse  users 
        $usersnurse = DB::table('cch_users')
                ->whereRaw( $sqlnurse)
                ->count();

         //supervisor  users 
        $userssupervisor = DB::table('cch_users')
                ->whereRaw( $sqlsupervisor)
                ->count();

         //system  users 
        $userssystem = DB::table('cch_users')
                ->whereRaw( $sqlsystem)
                ->count();
        
        
        
        $usersByRole["chart"] = array("plotBackgroundColor" => null,"plotBorderWidth"=>1,"plotShadow"=>false);
        $usersByRole["title"] = array("text" => " ");
        //$chartArray["tooltip"] = array("pointFormat" => "{series.name}: <b>{point.percentage:.1f}%</b>");
        $usersByRole["legend"] = array("enabled" => true);
        $usersByRole["credits"] = array("enabled" => false);
        $usersByRole["plotOptions"] = array("pie" => array("allowPointSelect" => true, "cursor"=>"pointer","dataLabels" => array("enabled" => true,"format"=>"<b>{point.name}</b>: {point.percentage:.1f} % ({y})")));
        $usersByRole["series"][] = array("type" => "pie", 'name' => "Users By Role", "data" => [array("name" => "Admin", "y" => $usersadmin), array("name" => "Concern", "y" => $usersconcern), array("name" => "District Admin", "y" => $usersdistrictadmin), array("name" => "District Supervisor", "y" => $usersdistrictsupervisor), array("name" => "National Supervisor", "y" => $usersnationalsupervisor), array("name" => "Regional Supervisor", "y" => $usersregionalsupervisor), array("name" => "Sub-District Supervisor", "y" => $userssubdistrictsupervisor), array("name" => "Researcher", "y" => $usersresearcher), array("name" => "Nurse", "y" => $usersnurse), array("name" => "Supervisor", "y" => $userssupervisor), array("name" => "system", "y" => $userssystem) ]);

       

       $data = array("usersCount"=>$usersCount,"usersByGender"=>$usersByGender,'usersMale'=>$usersMale,'usersFemale'=>$usersFemale,'usersNotAssignedGender'=>$usersNotAssignedGender,
            'usersByGroup'=>$usersByGroup,'usersghs'=>$usersghs,'userscch'=>$userscch,'userstest'=>$userstest,

            'usersByRole'=>$usersByRole,'usersadmin'=>$usersadmin,'usersconcern'=>$usersconcern,'usersdistrictadmin'=>$usersdistrictadmin,'usersdistrictsupervisor'=>$usersdistrictsupervisor,'usersnationalsupervisor'=>$usersnationalsupervisor,'usersregionalsupervisor'=>$usersregionalsupervisor,'userssubdistrictsupervisor'=>$userssubdistrictsupervisor,'usersnurse'=>$usersnurse,'usersresearcher'=>$usersresearcher,'userssupervisor'=>$userssupervisor,'userssystem'=>$userssystem);
        
        

         return View::make('stats.generalcharts')->with($data);
    }

    public function getUserRoles(){
            $roles = DB::table('cch_users')
                    ->select('role')
                    ->groupBy('role')
                    ->get();

            return $roles;
    }

     public function showDetailedCharts()
    {



            return View::make('stats.detailcharts');
    }

    public function getUsersVyRoleData(){
         $usersByRole = DB::connection('mysql2')->select(DB::raw('SELECT role,count(username) as aggregate FROM users  GROUP BY role'));
         $data= array();
        foreach ($usersByRole as $value) {
            if ($value != "") {
            $data[] = array($value->role,$value->aggregate);
            }
        } 

        return $usersByRole;
    }

    public function showTimeseriesCharts()
    {
            return View::make('stats.timeseriescharts');
    }

}