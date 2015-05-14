<?php

class TrackerController extends BaseController {

    public function __construct() {
//$this->beforeFilter('auth',array('except'=>array('store','update')));
    }

    public function index() {
#$logs = Tracker::all();
        $logs = array();

//$browser = get_browser(null, true);
//if ($browser['browser']!='Default Browser') {
//	    return View::make('tracker.index',array('logs'=>$logs));
//} else {
        return Response::json(array(
                    'error' => false,
                    'logs' => $logs), 200
        );
//}
    }

    public function update() {
        $rules = array('data' => 'required');

        $validator = Validator::make(Input::all(), $rules);

        if ($validator->fails()) {
            $errors = $validator->messages();
            return Response::json(array('error' => true, 'messages' => $errors->toArray()), 200);
        } else {
            $input = Input::all();
            $data = json_decode($input['data']);
            if (sizeof($data->logs)) {
                foreach ($data->logs as $l) {
                    $log = new Tracker;
                    $log->username = $l->user_id;
                    $log->module = $l->module;
                    $log->data = $l->data;
                    $log->start_time = $l->start_time;
                    $log->end_time = $l->end_time;
                    $log->timetaken = (($l->end_time - $l->start_time) / 1000);
                    $log->created_at = date('Y-m-d h:m:s');
                    $log->modified_by = 1; // Tracker user id 
                    $log->save();
//Log::info("SavingLogUpdate: ".$log);
                }
            } else {
                return Response::json(array('error' => true, 'messages' => 'data missing'), 200);
            }
        }

        return Response::json(array('error' => false), 200);
    }

    public function store() {
        $rules = array('data' => 'required');

        $validator = Validator::make(Input::all(), $rules);

        if ($validator->fails()) {
            $errors = $validator->messages();
            return Response::json(array('error' => true, 'messages' => $errors->toArray()), 200);
        } else {
            $input = Input::all();
            $data = json_decode($input['data']);
            if (sizeof($data->logs)) {
                foreach ($data->logs as $l) {
                    $log = new Tracker;
                    $log->username = $l->user_id;
                    $log->module = $l->module;
                    $log->data = $l->data;
                    $log->start_time = $l->start_time;
                    $log->end_time = $l->end_time;
                    $log->timetaken = (($l->end_time - $l->start_time) / 1000);
                    $log->created_at = date('Y-m-d h:m:s');
                    $log->modified_by = 1; // Tracker user id 
                    try {
                        if($this->isJson($l->data)){
                            $data = json_decode($data);
                            $log->ver = $data->ver;
                            $log->battery = $data->battery;
                            $log->device = $data->device;
                            $log->imei = $data->imei;
                            
                        }else{
                            $log->page=$l->data;
                        }
                    } catch (Exception $exc) {
                        echo $exc->getMessage();
                    }

                    $log->save();
                }
            } else {

//Log::info("SavingLogError: ".$log);

                return Response::json(array('error' => true, 'messages' => 'data missing'), 200);
            }
        }

        return Response::json(array('error' => false), 200);
    }

    public function checkEventType($val) {
        $results = DB::select('select id from cch_event_type where name = ?', array($val));
        if (null == $results) {
            return false;
        } else if (count($results) > 0) {
            return true;
        }
        return false;
    }

    function loggingSave($log) {
        switch (strtolower($log->module)) {
            case "calendar":

                break;
            case "staying well":

                break;
            case "Event Planner":

            default:
            case "Target Setting":
                break;
            case "Achievement Center":
            case "Point of Care":
            case "Learning Center";



                break;
        }
    }
    /**
     * | id          | bigint(20)   | NO   | PRI | NULL                | auto_increment              |
| username    | varchar(255) | NO   | MUL | NULL                |                             |
| module      | varchar(20)  | NO   | MUL | NULL                |                             |
| data        | text         | NO   |     | NULL                |                             |
| start_time  | bigint(20)   | NO   |     | NULL                |                             |
| end_time    | bigint(20)   | NO   |     | NULL                |                             |
| timetaken   | int(11)      | NO   |     | NULL                |                             |
| modified_by | int(11)      | NO   |     | NULL                |                             |
| created_at  | timestamp    | NO   |     | 0000-00-00 00:00:00 |                             |
| updated_at  | timestamp    | NO   |     | CURRENT_TIMESTAMP   | on update CURRENT_TIMESTAMP |
| version     | varchar(100) | YES  |     |                     |                             |
| ver         | varchar(100) | YES  |     |                     |                             |
| battery     | varchar(100) | YES  |     |                     |                             |
| imei        | varchar(100) | YES  |     |                     |                             |
| device      | varchar(100) | YES  |     |                     |                             |
+-------------+--------------+------+-----+---------------------+-----------------------------+

     * @param type $log
     */

    function saveUnknownModule($log) {
        
        $pageAcc = new PageAccess;
        $pageAcc->log=$log->id;
        $pageAcc->username= $log->username;
        $pageAcc->start_time= date('Y-m-d H:i:s',$log->start_time);
        $pageAcc->end_time= date('Y-m-d H:i:s',$log->end_time);
        $pageAcc->timetaken= date('Y-m-d H:i:s',$log->end_time);
        if($this->isJson($log->data)){
            $pg = json_decode($log->data);
            $pageAcc->page = $pg->page;
            $pageAcc->ver =$pg->ver;
            $pageAcc->battery = $pg->page;
            $pageAcc->ver =$pg->ver;
            
        }
    }

    function isJson($string) {
        json_decode($string);
        return (json_last_error() == JSON_ERROR_NONE);
    }

}
