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

                        <input type="text" name="title" value="{{$page->title}}" class="form-control" />
                    </div>
                    <div class="form-group">
                        {{ Form::label('class_name','Class Name') }}

                        <input type="text" name="class_name" value="{{$page->class_name}}" class="form-control" />
                    </div>

                    <div class="form-group">
                        {{ Form::label('parent','Parent') }}
                        <select name="parent"  class="form-control">
                            <option value="">No Parent</option>
                            @foreach($pages as $k=>$v)
                            <option value="{{$v->id}}"
                                    @if($v->id == $page->parent)
                                    "selected='selected'"
                                    @endif
                                    >{{$v->title}}</option>
                            @endforeach
                        </select>
                    </div>



                    <div class="row">
                        <div class="col-xs-6">
                            <div class="form-group">

                                {{ Form::label('status','Status') }}

                                {{ Form::select('status',$status,$page->status,array('class'=>'form-control'))}}
                            </div>
                        </div>
                        <div class="col-xs-6">
                            <div class="form-group">
                                {{ Form::label('position','Position') }}

                                <input type="text" name="position" placeholder="eg 1" value="{{$page->position}}" class="form-control" />
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-6">
                            <div class="form-group">
                                {{ Form::label('page_type','Page Type') }}
                                {{ Form::select('page_type',$page_types,$page->page_type,array('class'=>'form-control'))}}
                            </div>
                        </div>
                        <div class="col-xs-6">
                            <div class="form-group">
                                {{ Form::label('linked_page','Link Page to') }}
                                <select name="linked_page"  class="form-control">
                                    <option value="">No Parent</option>
                                    @foreach($pages as $k=>$v)
                                    <option value="{{$v->id}}"
                                            @if($v->id == $page->linked_page)
                                            "selected='selected'"
                                            @endif
                                            >{{$v->title}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        {{ Form::label('tags','Tag') }}

                        <input type="text" name="tag" value="{{$page->tag}}" class="form-control" />
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
                        <?php $cnt = 0; ?>
                        @foreach($page->layouts as $key=>$val)
                        <?php $cnt++; ?>
                        <div id="layout_s{{$cnt}}">
                            <input type="hidden" name="layout_id_s{{$cnt}}" id="layout_id_s{{$cnt}}" value="{{$val->id}}" />
                            <div class="row">
                                <h1>#{{$cnt}} Layout</h1>
                                <div class="col-xs-6">
                                    <div class="form-group">
                                        {{ Form::label("element_type_s$cnt",'Element  Type') }}
                                        {{ Form::select("element_type_s$cnt",$page_element,$val->element_type,array('id'=>'element_type_s1','class'=>'form-control'))}}
                                    </div>
                                </div>
                                <div class="col-xs-6">
                                    <div class="form-group">
                                        {{ Form::label('properties','Properties') }}
                                        <input type="text" id="properties_s{{$cnt}}" name="properties_s{{$cnt}}" value="{{$val->properties}}" class="form-control" />
                                    </div>
                                    <a href="#" onclick="alignproperties('vert', '_s1')" class="label label-info">Align Vertical</a>
                                    <a href="#" onclick="alignproperties('hort', '_s1')" class="label label-success">Align Horizontal</a>
                                </div>
                            </div>
                            <legend style="margin-bottom: 0px">
                                <span class="right" style="float: right;padding: 5px">
                                    <a href="#" onclick="addNewElement('_s{{$cnt}}')" title="Add New Element"><i class="fa fa-plus-circle"></i></a>
                                </span>Layout Elements</legend>
                            <?php $ct = 0; ?>
                            @foreach($val->pageElements as $ele=>$element)
                            <?php
                            $ct++;

                            $addedToElement = "s$cnt" . "__$ct";
                            ?>
                            <div id="pelement_{{$addedToElement}}" style="">
                                <input type="hidden" value="{{$element->id}}" name="element_id_{{$addedToElement}}" />

                                <div class="" style="background-color: #f0f0f0;padding: 5px;border-bottom: solid 1px #ccc;margin-bottom: 5px" id="element_pages_s1__1">
                                    <h3>#<?php
                                        echo $ct;
                                        ?> Element</h3>
                                    <div class="row">
                                        <div class="col-xs-6">
                                            <div class="form-group">
                                                {{ Form::label("element_type_$addedToElement","Element Type") }}    
                                                {{ Form::select("element_type_$addedToElement",$element_type,$element->element_type,array('class'=>'form-control'))}}
                                            </div>
                                        </div>
                                        <div class="col-xs-6">
                                            <div class="form-group">
                                                {{ Form::label("properties_$addedToElement",'Properties') }}
                                                <input type="text" name="properties_{{$addedToElement}}" value="{{$element->properties}}" class="form-control" />
                                            </div>
                                        </div>

                                    </div>

                                    <div class="form-group">
                                        {{ Form::label("content_$addedToElement",'Content') }}
                                        <textarea name="content_{{$addedToElement}}"  placeholder="Element Content" class="form-control">{{$element->value}}</textarea>
                                    </div>

                                    <div class="row">
                                        <div class="col-xs-6">
                                            <div class="form-group">
                                                {{ Form::label("link_type_$addedToElement",'Link  Type') }}
                                                {{ Form::select("link_type_$addedToElement",$page_types,$element->page_type,array('class'=>'form-control'))}}
                                            </div>
                                        </div>
                                        <div class="col-xs-6">
                                            <div class="form-group">
                                                {{ Form::label("link_value_$addedToElement",'Link Value') }}
                                                <input type="text" name="link_value_{{$addedToElement}}" value="{{$element->link_value}}" class="form-control" />
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        {{ Form::label("position_$addedToElement",'Position') }}
                                        <input type="text" name="position_{{$addedToElement}}" value="{{$element->position}}" placeholder="Position"  class="form-control" />
                                    </div>
                                    <div class="row">

                                        <div class="col-xs-6">
                                            <div class="form-group">

                                                <label for="imageloc_{{$addedToElement}}">Image</label>
                                                <input type="text" name="image_{{$addedToElement}}" value="{{$element->image}}" class="form-control" />
                                            </div>
                                        </div>
                                        <div class="col-xs-6">
                                            <div class="form-group">
                                                {{ Form::label("imageloc_$addedToElement",'Image Location') }}
                                                {{ Form::select("image_loc_$addedToElement",$image_loc,$element->image_pos,array('class'=>'form-control'))}}
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>
                            @endforeach  
                            <input type="hidden" name="element_cnt_s{{$cnt}}" id="element_cnt_s{{$cnt}}" value="{{$cnt}}" />

                        </div>
                    </div>

                    @endforeach
                </fieldset>

            </div>
        </div>
    </div>  
    <input type="hidden" value="{{$cnt}}" name="layout_cnt" id="layout_cnt"/>
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
            $("#element_cnt" + idx).val(currentElementCnt);
            $("#pelement" + idx).append(firstContent);
    }

    function addLayoutItem() {
//        alert("Add layout Item");
    currentElementCnt = $("#layout_cnt").val();
            currentElementCnt++;
            firstContent = $("#layout_s1").html();
            firstContent = firstContent.replace(/_s1/g, '_s' + currentElementCnt);
            firstPitem = $("#element_pages_s1__1").html();
            firstPitem = firstPitem.replace(/_s1/g, '_s' + currentElementCnt);
            firstContent = firstContent.replace(/#1 Layout/g, '#' + currentElementCnt + " Layout");
            firstContent  ="<div id='layout_s"+currentElementCnt+"' >"+firstContent+"</div>";
            $(firstContent).find("input").val("");
            $(firstContent).find("h1").html("#" + currentElementCnt + " Layout");
            alert(firstPitem)
            $(firstContent).find("#pelement_s" + (currentElementCnt)).html(firstPitem);
            $(firstContent).find("select").val("");
            $(firstContent).find("textarea").val("");
            $("#layout_cnt").val(currentElementCnt);
            $("#layout_container").append(firstContent);
            $("#layout_s" + (currentElementCnt) + " input").val("")
            $("#layout_s" + (currentElementCnt) + " select").val("")
            $("#layout_s" + (currentElementCnt) + " textarea").val("")
    }

</script>

@stop