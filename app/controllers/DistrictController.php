<?php

class DistrictController extends \BaseController {

    public function __construct() {
        $this->regions = array();
        $region = District::groupBy("region");
        foreach ($array as $key => $value) {
            $this->regions[$value->region] = $value->region;
        }
        $this->rules = array('name' => 'required|min:3', 'region' => 'required');
    }

//	private $regions;
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index() {
        $districts = District::all();
        return View::make('districts.index', array('districts' => $districts));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create() {
        return View::make('districts.create', array("region" => $this->regions));   //
    }
    public function showPeople($id) {
        $districts = District::find($id);
   
        $rawResult = (array) $DB::select("select u.* from cch_users u inner join cch_facility_user cfu on u.id=cfu.user_id and cfu.primary=1  inner join cch_facilities cf on cfu.facility_id = cf.id where cf.district=$id");
        $users = User::hydrate($rawResult);
 
        return View::make('districts.people', array('users' => $users));
    }
    
   

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store() {
        $validator = Validator::make(Input::all(), $this->rules);

      

        if ($validator->fails()) {
            return Redirect::to('/districts/create')
                            ->with('flash_error', 'true')
                            ->withErrors($validator);
        } else {
            $district = new District;
            $district->name = Input::get('name');

            $district->region = Input::get('region');
            $district->country = 'Ghana';
            $district->save();
            Session::flash('message', "{$district->name} created successfully");
            return Redirect::to('/districts');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id) {
//
        $district = District::find($id);
        return View::make('districts.edit', array("region" => $this->regions));   //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id) {
//
        $district = District::find($id);
        return View::make('districts.edit', array("region" => $this->regions));   //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function update($id) {
//
         $validator = Validator::make(Input::all(), $this->rules);

      

        if ($validator->fails()) {
            return Redirect::to('/district/'.$id.'edit')
                            ->with('flash_error', 'true')
                            ->withErrors($validator);
        } else {
            $district = District::find($id);
            $district->name = Input::get('name');

            $district->region = Input::get('region');
            $district->country = 'Ghana';
            $district->save();
            Session::flash('message', "{$district->name} edited successfully");
            return Redirect::to('/districts');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id) {
//
    }

}
