<?php

/**
 * Description of PageController
 *
 * @author skwakwa
 */
class PageController extends Controller {
    /*
      |--------------------------------------------------------------------------
      | Home Controller
      |--------------------------------------------------------------------------
      |
      | This controller renders your application's "dashboard" for users that
      | are authenticated. Of course, you are free to change or remove the
      | controller as you wish. It is just here to get your app started!
      |
     */

    public function __construct() {
        $this->pageTypes = array('d' => "Dynamic", 's' => "Static");
        $this->status = array('1' => "Active", '0' => "In Active");
        $this->elementType = array("button" => "Button",
            "text_view" => "Text View",
            "image" => "Image",
            "video" => "Video",
            "linear" => "linear",
            "linear_list" => "Linear List");

        $this->pageElementType = array(
            "linear" => "linear",
            "linear_list" => "Linear List");

        $this->imageLoc = array('left' => "Left", 'right' => "Right");
        $this->rules = array('title' => 'required|min:3');
        $this->layoutRules = array('element_type' => 'required');
    }

    public function index() {
        $pages = Page::orderBy('title', 'asc')->paginate(100);
        return View::make('page.page_index', array('pages' => $pages));
    }

    function pageList() {
        $app = Input::get("app");
        $pageDet = Page::where("app", $app)->get();

        $pages = array();
        foreach ($pageDet as $key => $value) {
            $pages[] = array("id" => $value->id,
                "title" => $value->title,
                "className" => $value->className,
                "description" => $value->description,
                "status" => $value->status,
                "type" => $value->page_type,
                "parent" => $value->parent,
                "tag" => $value->tag,
                "linked_page" => $value->linked_page,
                "updated_at" => date('Y-m-d H:i:s', strtotime($value->updated_at))
            );
        }
        return json_encode(array("rc" => "00", "page" => $pages));
    }

    public function servicePageDetails($id) {
        $page = $this->pageDetail($id);
        if (count($page) > 0)
            $page["rc"] = "00";

        return json_encode($page);
    }

    function pageDetail($pageId) {
        $pageDetail = Page::find($pageId);

        return $this->pageDetailsByPage($pageDetail);
    }

    function pageDetailsByPage($pageDetail) {

        $page = array("id" => $pageDetail->id,
            "title" => $pageDetail->title,
            "className" => $pageDetail->className,
            "description" => $pageDetail->description,
            "status" => $pageDetail->status,
            "type" => $pageDetail->page_type,
            "parent" => $pageDetail->parent,
            "tag" => $pageDetail->tag,
            "linked_page" => $pageDetail->linked_page,
            "updated_at" => date('Y-m-d H:i:s', strtotime($pageDetail->updated_at))
        );

        $pageLayouts = $pageDetail->layouts;
        $layoutArray = array();
        foreach ($pageLayouts as $key => $value) {
            $layout = array("id" => $value->id,
                "page_id" => $value->page_id,
                "element_type" => $value->element_type,
                "properties" => $value->properties,
                "parent_element" => $value->parent_element,
                "status" => $value->status,
                "updated_at" => date('Y-m-d H:i:s', strtotime($value->updated_at))
            );

            $elements = $value->pageElements;
            $elementArray = array();
            foreach ($elements as $eleKey => $eleValue) {
                $elementArray [] = array("id" => $eleValue->id,
                    "layout_id" => $eleValue->layout_id,
                    "element_type" => $eleValue->element_type,
                    "properties" => $eleValue->properties,
                    "value" => $eleValue->value,
                    "link_value" => $eleValue->link_value,
                    "image" => $eleValue->image,
                    "image_pos" => $eleValue->image_pos,
                    "position" => $eleValue->position,
                    "status" => $eleValue->status,
                    "updated_at" => date('Y-m-d H:i:s', strtotime($eleValue->updated_at))
                );
            }
            $layout["elements"] = $elementArray;

            $layoutArray[] = $layout;
        }
        $page["layout"] = $layoutArray;
        return $page;
    }

    function serviceAllPageDetails() {
        $app = Input::get('app');
        $pages = Page::where('app', $app)->get();
        $pagesArray = array();
        foreach ($pages as $key => $value) {
            $pagesArray [] = $this->pageDetailsByPage($value);
        }

        return json_encode(array("rc" => "00", "pages" => $pagesArray));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create() {
        $parent = Input::get('parent');
        $page = Page::find($parent);

        $pages = Page::all();
        return View::make('page.page_create', array("parent" => $page,
                    "pages" => $pages,
                    'page_types' => $this->pageTypes,
                    'status' => $this->status,
                    "element_type" => $this->elementType,
                    "page_element" => $this->pageElementType,
                    "image_loc" => $this->imageLoc));   //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store() {
        $validator = Validator::make(Input::all(), $this->rules);



        if ($validator->fails()) {
            return Redirect::to('/page/create')
                            ->with('flash_error', 'true')
                            ->withInput()
                            ->withErrors($validator);
        } else {
            $layoutNo = Input::get('layout_cnt');
//            $laySequence = json_decode(Input::get('layoutSequence'));
//            foreach ($array as $key => $value) {
//                
//            }

            $page = new Page;
            $page->title = Input::get('title');
            $page->description = Input::get('description');
            $page->class_name = Input::get('class_name');
            $page->position = Input::get('position');
            $page->page_type = Input::get('page_type');
            $page->status = Input::get('status');
            $page->parent = Input::get('parent');
            $page->linked_page = Input::get('linked_page');
            $page->tag = Input::get('tag');
//            

            $page->save();

            for ($i = 1; $i <= $layoutNo; $i++) {
                $pageLayout = new PageLayout;
                $pageLayout->page_id = $page->id;
                $pageLayout->element_type = Input::get("element_type_s$i");
                $pageLayout->properties = Input::get("properties_s$i");
                $pageLayout->parent_element = 0; //Input::get("parent_$i")
                $pageLayout->status = 1;
                $layoutValidator = Validator::make(array('element_type' => Input::get("element_type_s$i")), $this->layoutRules);
                $pageLayout->save();
                $layoutElementCnt = Input::get("element_cnt_s$i");
                for ($k = 1; $k <= $layoutElementCnt; $k++) {
                    $element = new PageElement;
                    $ik = "_s$i" . "__$k";
                    $element->layout_id = $pageLayout->id;
                    $element->element_type = Input::get("element_type$ik");
                    $element->properties = Input::get("properties$ik");
                    $element->value = Input::get("content$ik");
                    $element->position = Input::get("position$ik");
                    $element->status = Input::get("status$ik");
                    $element->link_type = Input::get("link_type$ik");
                    $element->link_value = Input::get("link_value$ik");
                    $element->image = Input::get("image$ik");
                    $element->image_pos = Input::get("image_loc$ik");
                    $element->status = 1;
                    $element->save();
                }
            }
            try {
                Session::flash('message', "{$page->title}" . Lang::get('messages.added_successfully'));
            } catch (Exception $exc) {
                Session::flash('message', $exc->getMessage() . "Unable to");
            }

            return Redirect::to('/page');
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
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id) {
        //
$pages = Page::where("app","CCH")->orderBy('title', 'asc');
        $page = Page::find($id);
            return View::make('page.page_edit', array('page' => $page,"pages"=>$pages,
                'page_types' => $this->pageTypes,
                    'status' => $this->status,
                    "element_type" => $this->elementType,
                    "page_element" => $this->pageElementType,
                    "image_loc" => $this->imageLoc));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function update($id) {
        //
        $page = Page::find($id);

        $validator = Validator::make(Input::all(), $this->rules);


        if ($validator->fails()) {
//dd($validator->messages()->toJson());
            return Redirect::to('/page/' . $id . '/edit')
                            ->with('flash_error', 'true')
                            ->withInput()
                            ->withErrors($validator);
        } else {

            $page->page = Input::get('name');
            $page->regionid = Input::get('region');
            try {
                $page->save();
                Session::flash('message', "Page {$page->page}" . Lang::get('messages.edited_successfully'));
            } catch (Exception $exc) {
                Session::flash('message', $exc->getMessage() . "Unable to");
            }
            Session::flash('message', "{$page->page}" . Lang::get('messages.edit_successfully'));
            return Redirect::to('/page');
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
