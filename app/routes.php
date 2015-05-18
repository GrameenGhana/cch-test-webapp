<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the Closure to execute when that URI is requested.
|
*/

Route::get('/', function()
{
	return View::make('hello');
});
Route::group(array('prefix' => 'api/v1'), function()
{
    Route::any('pages', 'PageController@pageList');    
    Route::any('pages/viewall', 'PageController@serviceAllPageDetails');
    Route::any('pages/{id}', 'PageController@servicePageDetails');
});

<<<<<<< HEAD
//Stats Charts
Route::get('stats/generalcharts', array('uses' => 'StatsController@showGeneralCharts'));
Route::get('stats/detailedcharts', array('uses' => 'StatsController@showDetailedCharts'));
Route::get('stats/timeseriescharts', array('uses' => 'StatsController@showTimeseriesCharts'));
=======
Route::resource('page','PageController'); 
>>>>>>> 8ab42dcc212b4ac6a45ccf4f7655bcdd0c6ab71f
