<?php

class UserController extends BaseController {

    public function __construct() {


        $this->beforeFilter('auth', array('except' => 'store'));
        $ruserRole = Auth::user()->role;
        if (strtolower($ruserRole) == 'district admin') {

            $facs = Facility::whereIn('id', function($query) {
                        $query->select('facility_id')
                                ->from(with(new FacilityUser)->getTable())
                                ->where('user_id', Auth::user()->id)
                                ->where('supervised', 1);
                    })->get()
            ;
            $this->groups = array('GHS' => 'GHS');
            $this->roles = array('GHS' => array('Nurse' => 'Nurse',
                    'Supervisor' => 'Supervisor',
                    'Sub-District Supervisor' => 'Sub-District Supervisor',
                    'District Supervisor' => 'District Supervisor',
                    'Regional Supervisor' => 'Regional Supervisor',
                    'National Supervisor' => 'National Supervisor',
//0                    'District Admin' => 'District Admin'
            ));
        } else {
            $facs = Facility::all();
            $this->groups = array('GHS' => 'GHS', 'CCH' => 'CCH');
            $this->roles = array('GHS' => array('Nurse' => 'Nurse',
                    'Supervisor' => 'Supervisor',
                    'Sub-District Supervisor' => 'Sub-District Supervisor',
                    'District Supervisor' => 'District Supervisor',
                    'Regional Supervisor' => 'Regional Supervisor',
                    'National Supervisor' => 'National Supervisor',
                //                 'District Admin' => 'District Admin'
                ),
                'CCH' => array('Researcher' => 'Researcher',
                    'GF' => 'GF', 'Concern' => 'Concern', 'Admin' => 'admin'));
        }
        $this->facilities = array();
        $this->pfacilities = array('Other' => 'Unknown');

        foreach ($facs as $k => $v) {
            if (in_array($v->district, array_keys($this->facilities))) {
                array_push($this->facilities[$v->district], $v);
                $this->pfacilities[$v->district][$v->id] = $v->name;
            } else {
                $this->facilities[$v->district] = array($v);
                $this->pfacilities[$v->district] = array($v->id => $v->name);
            }
        }




        $this->rules = array('username' => 'required|min:3|unique:cch_users',
            'password' => 'required|min:6',
            'confirmpassword' => 'required|same:password',
            'first_name' => 'required|min:2',
            'last_name' => 'required|min:2',
            'group' => 'required|min:2',
            'role' => 'required|min:2'
        );
    }

    public function showCalendar($id) {
        $events = array();

        $user = User::find($id);
        $logs = $user->tracklogs()->where('module', '=', 'Calendar')->get();

        foreach ($logs as $log) {
            $e = $this->createEventForJS($log->data, $log->start_time, $log->end_time);
            if ($e != null) {
                $s = serialize($e);
                $events[$s] = $e;
            }
        }
        return View::make('users.calendar', array('user' => $user, 'events' => $events));
    }

    public function showCourses($id) {
        $user = User::find($id);
        $courses = $user->courses();
        return View::make('users.courses', array('user' => $user, 'courses' => $courses));
    }

    public function index() {
        if (strtolower(Auth::user()->role) == 'district admin') {
            $user = User::find(Auth::user()->id);


            $rawResult = (array) DB::select("select u.* from cch_users u  inner join cch_facility_user fu on u.id=fu.user_id "
                            . " where fu.primary=? and  fu.facility_id in (select facility_id from cch_facility_user where user_id= ? and supervised=?)", array(1, $user->id, 1));
            $users = User::hydrate($rawResult);
        } else
            $users = User::all();
        return View::make('users.index', array('users' => $users));
    }

    public function indexDistrictAdmin() {



        $rawResult = (array) DB::select("select u.* from cch_users u  where u.role =? "
                        , array('District Admin'));
        $users = User::hydrate($rawResult);

        return View::make('users.index', array('users' => $users));
    }

    public function districtAdminCreate() {
        $d = Device::where('status', '=', 'unallocated')->get();
        $devices = array('0' => 'Unknown');
        foreach ($d as $k => $v) {
            $devices[$v->id] = $v->type . ' - ' . $v->tag;
        }
        $this->roles = array('GHS' => array(
                'District Admin' => 'District Admin'
        ));
        return View::make('users.create', array('groups' => $this->groups,
                    'roles' => $this->roles,
                    'devices' => $devices,
                    'pfacilities' => $this->pfacilities,
                    'facilities' => $this->facilities));
    }

    public function districtAdminList() {

        $user = User::find(Auth::user()->id);

        $rawResult = (array) DB::select("select u.* from cch_users u  inner join cch_facility_user fu on u.id=fu.user_id "
                        . " where fu.primary=? and  fu.facility_id in (select facility_id from cch_facility_user where user_id= ? and supervised=?)", array(1, $user->id, 1));
        $users = User::hydrate($rawResult);
        return View::make('users.index', array('users' => $users));
    }

    public function create() {
        $d = Device::where('status', '=', 'unallocated')->get();
        $devices = array('0' => 'Unknown');
        foreach ($d as $k => $v) {
            $devices[$v->id] = $v->type . ' - ' . $v->tag;
        }

        return View::make('users.create', array('groups' => $this->groups,
                    'roles' => $this->roles,
                    'devices' => $devices,
                    'pfacilities' => $this->pfacilities,
                    'facilities' => $this->facilities));
    }

    public function edit($id) {
//        $user = User::with('facilities')->find($id);
        $user = User::with(array('facilities' => function($query) {
                        $query->where('supervised', 1);
                    }))->find($id);
        $user->listAttributes($user, 'facilities');

        $user->primary_facility = $user->getPrimaryFacilityId();

        $d = Device::whereRaw('status = ? or id=?', array('unallocated', $user->device_id))->get();
        $devices = array('0' => 'Unknown');
        foreach ($d as $k => $v) {
            $devices[$v->id] = $v->type . ' - ' . $v->tag;
        }


        if (strtolower($user->role) == "district admin") {
            $this->roles = array('GHS' => array(
                    'District Admin' => 'District Admin'
            ));
        }

        return View::make('users.edit', array('user' => $user,
                    'groups' => $this->groups,
                    'roles' => $this->roles,
                    'devices' => $devices,
                    'pfacilities' => $this->pfacilities,
                    'facilities' => $this->facilities));
    }

    public function store() {
//            $checkloc = (Input::get('group')=='CCH' && preg_match('/.*?supervisor.*?/',strtolower(Input::get('role'))))

        $checkloc = ((preg_match('/.*?supervisor.*?/', strtolower(Input::get('role')))) || ("district admin" == strtolower(Input::get("role")))) ? true : false;

        if ($checkloc) {
            $this->rules['locations'] = 'required';
        }

        $validator = Validator::make(Input::all(), $this->rules);

        $validator->sometimes('title', 'min:3', function($input) {
            return $input->title <> '';
        });


        if ($validator->fails()) {
            //dd($validator->messages()->toJson());
            return Redirect::to('/users/create')
                            ->with('flash_error', 'true')
                            ->withInput()
                            ->withErrors($validator);
        } else {
            $user = new User;
            $user->username = Input::get('username');
            $user->password = Hash::make(Input::get('password'));
            $user->first_name = Input::get('first_name');
            $user->last_name = Input::get('last_name');
            $user->gender = Input::get('gender');
            $user->phone_number = Input::get('phone_number');
            $user->group = Input::get('group');
            $user->role = Input::get('role');
            $user->title = Input::get('title');
            $user->ischn = Input::get('ischn');
            $user->status = Input::get('status');
            $user->device_id = Input::get('device_id');
            $user->created_at = date('Y-m-d h:m:s');
            $user->modified_by = Auth::user()->id;
            $user->save();

            // Add associate user with facility
            if ($checkloc) {
                $var = Input::get('locations');
                $var[] = Input::get('primary_facility');
                //             
                $user->facilities()->sync($var);
//                Facility::where("user_id", $user->id)->whereIn("facility_id", Input::get('locations'))->update(array('supervised' => 1));
//                $user->facilities()->whereIn("facility_id", Input::get('locations'))->update(array('supervised' => 1));
                DB::update('UPDATE cch.cch_facility_user SET supervised=1 , `primary`=0 WHERE user_id = ? and facility_id  in ' . '(' . implode(",", Input::get('locations')) . ')', array($user->id));
            } else {
                $var[] = Input::get('primary_facility');
                $user->facilities()->sync($var);
            }
            DB::update('UPDATE cch.cch_facility_user SET `primary`=1 WHERE user_id = ? and facility_id=?', array($user->id, Input::get('primary_facility')));

            // Update device status.
            DB::update('UPDATE cch.cch_devices SET status="unallocated", user_id=0 WHERE user_id = ?', array($user->id));
            DB::update('UPDATE cch.cch_devices SET status="active", user_id=? WHERE id = ?', array($user->id, $user->device_id));

            // Add user to Oppia user's list
            $postdata = array('username' => $user->username,
                'password' => Input::get('password'),
                'passwordagain' => Input::get('password'),
                'email' => $user->username . '@cch.gh.com',
                'firstname' => $user->first_name,
                'lastname' => $user->last_name);

            $url = 'http://localhost/cch/oppia/api/v1/register/';
            $response = $this->curl_json_post($url, $postdata);

            Session::flash('message', "{$user->getName()} created successfully ");
            return Redirect::to('/users');
        }
    }

    public function update($id) {
        $this->rules = array(
//            'username' => 'required|min:3|unique:cch_users,username,' . $id,
            'password' => 'required|min:6',
            'confirmpassword' => 'required|same:password',
            'first_name' => 'required|min:2',
            'last_name' => 'required|min:2',
            'group' => 'required|min:2',
            'role' => 'required|min:2'
        );

        //Added to lower case for  comparism
        $checkloc = (preg_match('/.*?supervisor.*?/', strtolower(Input::get('role')))) || (('district admin' == strtolower(Input::get('role')))) ? true : false;
        if ($checkloc) {
            $this->rules['locations'] = 'required';
        }

        $validator = Validator::make(Input::all(), $this->rules);

        $validator->sometimes('title', 'min:3', function($input) {
            return $input->title <> '';
        });


        if ($validator->fails()) {
            return Redirect::to('users/' . $id . '/edit')
                            ->with('flash_error', 'true')
                            ->withInput()
                            ->withErrors($validator);
        } else {
            $user = User::find($id);
            $oldu = $user->username;
            $olddevice = $user->device_id;

//            $user->username = Input::get('username');
            $user->password = Hash::make(Input::get('password'));
            $user->first_name = Input::get('first_name');
            $user->last_name = Input::get('last_name');
            $user->gender = Input::get('gender');
            $user->phone_number = Input::get('phone_number');
            $user->group = Input::get('group');
            $user->role = Input::get('role');
            $user->title = Input::get('title');

            $user->status = Input::get('status');
            $user->ischn = Input::get('ischn');
            $user->device_id = Input::get('device_id');
            $user->modified_by = Auth::user()->id;
            $user->save();

            // Update device status.
            if ($olddevice != $user->device_id) {
                DB::update('UPDATE cch.cch_devices SET status="unallocated", user_id=0 WHERE (user_id = ? OR id= ?)', array($user->id, $olddevice));
                DB::update('UPDATE cch.cch_devices SET status="active", user_id=? WHERE id = ?', array($user->id, $user->device_id));
            }
            $var = array();
            // Add associate user with facility
            if ($checkloc) {
                $var = Input::get('locations');
                $var[] = Input::get('primary_facility');
                $user->facilities()->sync($var);
                DB::update('UPDATE cch.cch_facility_user SET supervised=1 , `primary`=0 WHERE user_id = ? and facility_id  in ' . '(' . implode(",", Input::get('locations')) . ')', array($user->id));
            } else {
                $var[] = Input::get('primary_facility');
                $user->facilities()->sync($var);
                DB::update('UPDATE cch.cch_facility_user SET supervised=0 , `primary`=1 WHERE user_id = ? and facility_id  in ' . '(' . implode(",", $var) . ')', array($user->id));
            }

            DB::update('UPDATE cch.cch_facility_user SET `primary`=1 WHERE user_id = ? and facility_id=?', array($user->id, Input::get('primary_facility')));

            Session::flash('message', "{$user->getName()} updated successfully ");
            if (strtolower(Auth::user()->role) == 'district admin')//Change
                return Redirect::to('/distusers');
            return Redirect::to('/users');
        }
    }

}
