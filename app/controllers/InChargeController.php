
<?php

class InChargeController extends BaseController {

	public function index()
	{
       $data = array();

       $supervisors = User::Supervisor()->get();

       foreach($supervisors as $sup)
       {
            $s = $this->details($sup); 
            array_push($data,array('supervisor'=>$s));
       }

       return Response::json(array('error' => false, 'data' => $data), 200);
	}

    public function show($id)
    {
//        $sup = User::whereRaw('id=? and role="Supervisor"',array($id))->first();
     $sup = User::whereRaw('username=? and role like "%Supervisor%"',array($id))->first();

        if (is_null($sup)) {
		    $errors = array('Supervisor not found'); 
    		return Response::json(array('error' => true, 'messages'=>$errors), 200);
        } else {
            $s = $this->details($sup); 
    	return Response::json(array('error' => false, 'data' => array('supervisor'=>$s)), 200);
        }	    
    }
    
    public function store()
    {
        $data = Input::get('data',0);
        $data = json_decode($data);
        $id = $data->info[0]->id;
        return $this->show($id);
    }


    protected function details($sup)
    {
            $facs = array();
            foreach($sup->facilities as $k=>$v)
            {
                $nurses = array();
                foreach($v->nurses() as $n)
                {
               array_push($nurses, $n->toArray());
                }
         array_push($facs, array('name'=>$v->name,
                                 'id'=>$v->id,
                                 'district'=>$v->district,
                                'nurses'=>$nurses,
                                  ));
          }

            $s = array('name'=>$sup->getName(),
                       'username'=>$sup->username,
                       'facilities'=> $facs);

            return $s;
    }
}
