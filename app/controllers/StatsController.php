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
        
        
        
        $usersByGroup["chart"] = array("plotBackgroundColor" => null,"plotBorderWidth"=>1,"plotShadow"=>false);
        $usersByGroup["title"] = array("text" => " ");
        //$chartArray["tooltip"] = array("pointFormat" => "{series.name}: <b>{point.percentage:.1f}%</b>");
        $usersByGroup["legend"] = array("enabled" => true);
        $usersByGroup["credits"] = array("enabled" => false);
        $usersByGroup["plotOptions"] = array("pie" => array("allowPointSelect" => true, "cursor"=>"pointer","dataLabels" => array("enabled" => true,"format"=>"<b>{point.name}</b>: {point.percentage:.1f} % ({y})")));
        $usersByGroup["series"][] = array("type" => "pie", 'name' => "Users By Group", "data" => [array("name" => "GHS", "y" => $usersghs), array("name" => "CCH", "y" => $userscch), array("name" => "Test", "y" => $userstest) ]);
       
        


       $data = array("usersCount"=>$usersCount,"usersByGender"=>$usersByGender,'usersMale'=>$usersMale,'usersFemale'=>$usersFemale,'usersNotAssignedGender'=>$usersNotAssignedGender,
            'usersByGroup'=>$usersByGroup,'usersghs'=>$usersghs,'userscch'=>$userscch,'userstest'=>$userstest);
        
        
         return View::make('stats.generalcharts')->with($data);
    }

     public function showDetailedCharts()
    {
            return View::make('stats.detailcharts');
    }

    public function showTimeseriesCharts()
    {
            return View::make('stats.timeseriescharts');
    }

}