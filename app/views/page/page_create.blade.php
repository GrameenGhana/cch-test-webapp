@extends('layouts.no_auth')

@section('content')
<div class="row">
    {{ Form::open(array('url'=> 'page','method'=>'post')) }}

    <div class="col-xs-6">
        <div class="box box-primary">
            <div class="box-body">

                <fieldset><legend>Page Details </legend>	
                    <div class="form-group">
                        {{ Form::label('title','Title') }}

                        <input type="text" name="title" value="" class="form-control" />
                    </div>
                    <div class="form-group">
                        {{ Form::label('class_name','Class Name') }}

                        <input type="text" name="class_name" value="" class="form-control" />
                    </div>

                    <div class="form-group">
                        {{ Form::label('parent','Parent') }}
                        <select name="parent"  class="form-control">
                            <option value="">No Parent</option>
                            @foreach($pages as $k=>$v)
                            <option value="{{$v->id}}">{{$v->title}}</option>
                            @endforeach
                        </select>
                    </div>



                    <div class="row">
                        <div class="col-xs-6">
                            <div class="form-group">

                                {{ Form::label('status','Status') }}

                                {{ Form::select('status',$status,'',array('class'=>'form-control'))}}
                            </div>
                        </div>
                        <div class="col-xs-6">
                            <div class="form-group">
                                {{ Form::label('position','Position') }}

                                <input type="text" name="position" placeholder="eg 1" value="" class="form-control" />
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-6">
                            <div class="form-group">
                                {{ Form::label('page_type','Page Type') }}
                                {{ Form::select('page_type',$page_types,'',array('class'=>'form-control'))}}
                            </div>
                        </div>
                        <div class="col-xs-6">
                            <div class="form-group">
                                {{ Form::label('linked_page','Link Page to') }}
                                <select name="linked_page"  class="form-control">
                                    <option value="">No Parent</option>
                                    @foreach($pages as $k=>$v)
                                    <option value="{{$v->id}}">{{$v->title}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        {{ Form::label('tags','Tag') }}

                        <input type="text" name="tag" value="" class="form-control" />
                    </div>

                    <div class="form-group">
                        <input type="submit" value="Create" class="form-control btn btn-info" />
                    </div>

                </fieldset>

            </div><!-- /.box-body -->
        </div>
    </div>


    <div class="col-md-6">
        <div class="box box-primary">
            <div class="box-body">

                <fieldset><legend>Default Layout and Content</legend>	
                    <div id="layout_container">
                        <span class="right" style="float: right;padding: 5px">
                                    <a href="#" onclick="addLayoutItem()" title="Add New Element"><i class="fa fa-plus-circle"></i></a>
                                </span>
                        <div id="layout_s1">
                            <div class="row">
                                <h1>#1 Layout</h1>
                                <div class="col-xs-6">
                                    <div class="form-group">
                                        {{ Form::label('element_type','Element  Type') }}
                                        {{ Form::select('element_type_s1',$page_element,'',array('id'=>'element_type_s1','class'=>'form-control'))}}
                                    </div>
                                </div>
                                <div class="col-xs-6">
                                    <div class="form-group">
                                        {{ Form::label('properties','Properties') }}
                                        <input type="text" id="properties_s1" name="properties_s1" value="" class="form-control" />
                                    </div>
                                    <a href="#" onclick="alignproperties('vert', '_s1')" class="label label-info">Align Vertical</a>
                                    <a href="#" onclick="alignproperties('hort', '_s1')" class="label label-success">Align Horizontal</a>
                                </div>
                            </div>
                            <legend style="margin-bottom: 0px">
                                <span class="right" style="float: right;padding: 5px">
                                    <a href="#" onclick="addNewElement('_s1')" title="Add New Element"><i class="fa fa-plus-circle"></i></a>
                                </span>Layout Elements</legend>
                            <div id="pelement_s1" style="">

                                <div class="" style="background-color: #f0f0f0;padding: 5px;border-bottom: solid 1px #ccc;margin-bottom: 5px" id="element_pages_s1__1">
                                    <h3>#1 Element</h3>
                                    <div class="row">
                                        <div class="col-xs-6">
                                            <div class="form-group">
                                                {{ Form::label('element_type_s1__1','Element Type') }}    
                                                {{ Form::select('element_type_s1__1',$element_type,'',array('class'=>'form-control'))}}
                                            </div>
                                        </div>
                                        <div class="col-xs-6">
                                            <div class="form-group">
                                                {{ Form::label('properties_s1__1','Properties') }}
                                                <input type="text" name="properties_s1__1" value="" class="form-control" />
                                            </div>
                                        </div>

                                    </div>

                                    <div class="form-group">
                                        {{ Form::label('content_s1__1','Content') }}
                                        <textarea name="content_s1__1"  placeholder="Element Content" class="form-control"> </textarea>
                                    </div>

                                    <div class="row">
                                        <div class="col-xs-6">
                                            <div class="form-group">
                                                {{ Form::label('link_type_s1__1','Link  Type') }}
                                                {{ Form::select('link_type_s1__1',$page_types,'',array('class'=>'form-control'))}}
                                            </div>
                                        </div>
                                        <div class="col-xs-6">
                                            <div class="form-group">
                                                {{ Form::label('link_value_s1__1','Link Value') }}
                                                <input type="text" name="link_value_s1__1" value="" class="form-control" />
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        {{ Form::label('position_s1__1','Position') }}
                                        <input type="text" name="position_s1__1" value="" placeholder="Position"  class="form-control" />
                                    </div>
                                    <div class="row">

                                        <div class="col-xs-6">
                                            <div class="form-group">
                                                {{ Form::label('image_s1__1','Image') }}
                                                <input type="text" name="image" value="" class="form-control" />
                                            </div>
                                        </div>
                                        <div class="col-xs-6">
                                            <div class="form-group">
                                                {{ Form::label('imageloc_s1__1','Image Location') }}
                                                {{ Form::select('image_loc_s1__1',$image_loc,'',array('class'=>'form-control'))}}
                                            </div>
                                        </div>
                                    </div>

                                </div>
                                <input type="hidden" name="element_cnt_s1" id="element_cnt_s1" value="1" />
                            </div>
                        </div>
                    </div>
                </fieldset>

            </div>
        </div>
    </div>  
    <input type="hidden" value="1" name="layout_cnt" id="layout_cnt"/>
    {{ Form::close()}}
</div>

@stop

@section('script')
<script type="text/javascript">
    function alignproperties(type, idx) {
        if (type == 'vert') {
            pid = "#properties" + idx;
            $(pid).val("android:alignment='vertical'")
        } else {
            $("#properties" + idx).val("android:alignment='horizontal'")
        }
    }
    function addNewElement(idx) {
        currentElementCnt = $("#element_cnt" + idx).val();
        currentElementCnt++;
        firstContent = $("#element_pages_s1__1").html();
        firstContent = firstContent.replace(/__1/g, '__' + currentElementCnt);
        firstContent = firstContent.replace(/#1 Element/g, '#' + currentElementCnt + " Element");
        $(firstContent).find("input").val("");
        $(firstContent).find("h3").html("#" + currentElementCnt + " Element");
        $(firstContent).find("select").val("");
        $(firstContent).find("textarea").val("");
        $("#element_cnt"+idx).val(currentElementCnt);
        $("#pelement"+idx).append(firstContent);
    }

    function addLayoutItem() {
//        alert("Add layout Item");
        currentElementCnt = $("#layout_cnt" ).val();
        currentElementCnt++;
        firstContent = $("#layout_s1").html();
        firstContent = firstContent.replace(/_s1/g, '_s' + currentElementCnt);
        firstPitem =$("#element_pages_s1__1").html();
        firstPitem = firstPitem.replace(/_s1/g, '_s' + currentElementCnt);
        
        firstContent = firstContent.replace(/#1 Layout/g, '#' + currentElementCnt + " Layout");
        $(firstContent).find("input").val("");
        $(firstContent).find("h1").html("#" + currentElementCnt + " Layout");
//        alert(firstPitem)
        $(firstContent).find("#pelement_s"+(currentElementCnt)).html(firstPitem);
        $(firstContent).find("select").val("");
        $(firstContent).find("textarea").val("");
        $("#layout_cnt").val(currentElementCnt);
        $("#layout_container").append(firstContent);
    }

</script>

@stop