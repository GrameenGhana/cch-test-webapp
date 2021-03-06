
<?php

class DeviceController extends BaseController {

    private $rules;

    public function __construct() {
        $this->beforeFilter('auth');

        $this->rules = array('type' => 'required', 'tag' => 'required|unique:cch_devices', 'imei' => 'required|unique:cch_devices', 'color' => 'required', 'status' => 'required');

        $this->status = array('unknown' => 'Unknown', 'unallocated' => 'In GF Office', 'active' => 'In Active Use', 'repair' => 'In Repair', 'deactivated' => 'Deactivated');
        $this->types = array('Core 2' => 'Core 2', 'Tab 4' => 'Tab 4');

        $this->users = User::usersByDistrict();
        $this->users['Unassigned'] = array('0' => 'Unassigned');
    }

    public function index() {
        if (strtolower(Auth::user()->role) == 'district admin') {
            $rawResult = (array) DB::select("
                    SELECT cd.* FROM `cch_devices` cd inner join cch_facility_user cfu
                    on cd.user_id =  cfu.user_id
                    WHERE cfu.primary=1 and cfu.facility_id in (select facility_id from cch_facility_user where supervised=1  and 
                    user_id=?) ", array(Auth::user()->id));
            $devices = Device::hydrate($rawResult);
        } else {
            $devices = Device::all();
        }
        return View::make('devices.index', array('devices' => $devices));
    }

    public function show($id) {
        $device = Device::find($id);
        return View::make('devices.show', array('device' => $device, 'status' => $this->status, 'types' => $this->types, 'users' => $this->users));
    }

    public function create() {
        return View::make('devices.create', array('status' => $this->status, 'types' => $this->types, 'users' => $this->users));
    }

    public function store() {
        $validator = Validator::make(Input::all(), $this->rules);

        if ($validator->fails()) {
            return Redirect::to('/devices/create')
                            ->with('flash_error', 'true')
                            ->withErrors($validator);
        } else {
            $device = new Device;
            $device->type = Input::get('type');
            $device->tag = Input::get('tag');
            $device->imei = Input::get('imei');
            $device->color = Input::get('color');
            $device->status = Input::get('status');
            $device->modified_by = Auth::user()->id;
            $device->user_id = Input::get('user');
            $device->created_at = date('Y-m-d h:m:s');
            $device->save();

            if (Input::get('user') != 0) {
                DB::update('UPDATE cch.cch_users SET device_id=? WHERE id = ?', array($device->id, Input::get('user')));
            }

            Session::flash('message', "{$device->tag} created successfully");
            return Redirect::to('/devices');
        }
    }

    public function edit($id) {
        $device = Device::find($id);
        return View::make('devices.edit', array('device' => $device, 'status' => $this->status, 'types' => $this->types, 'users' => $this->users));
    }

    public function update($id) {
        $this->rules = array('type' => 'required',
            'tag' => 'required|unique:cch_devices,tag,' . $id,
            'imei' => 'required|unique:cch_devices,imei,' . $id, 'color' => 'required', 'status' => 'required');
        $validator = Validator::make(Input::all(), $this->rules);

        if ($validator->fails()) {
            return Redirect::to('devices/' . $id . '/edit')
                            ->with('flash_error', 'true')
                            ->withInput()
                            ->withErrors($validator);
        } else {
            $device = Device::find($id);
            $oldu = $device->user_id;
            $device->type = Input::get('type');
            $device->tag = Input::get('tag');
            $device->imei = Input::get('imei');
            $device->color = Input::get('color');
            $device->status = Input::get('status');
            $device->user_id = Input::get('user');
            $device->modified_by = Auth::user()->id;
            $device->save();

            DB::update('UPDATE cch.cch_users SET device_id=0 WHERE id = ?', array($oldu));
            DB::update('UPDATE cch.cch_users SET device_id=? WHERE id = ?', array($device->id, Input::get('user')));

            Session::flash('message', "{$device->tag} updated successfully");
            return Redirect::to('devices');
        }
    }

    public function destroy() {
        $devs = Devices::all();
        return View::make('devices.index', array('devices' => $devs));
    }

}

