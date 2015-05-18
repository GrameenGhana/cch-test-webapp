@extends('layouts.no_auth')

@section('content')	
<table id="distable" class="table table-bordered table-striped">
    <thead>
        <tr>
            <th>id</th> 
            <th>Title</th>
            <th>Classname</th>
            <th>tag</th>
            <th>Status</th>
            <th>parent</th>
            <th>position</th>
            <th>action</th>
        </tr>
    </thead>
    <tbody>

        @foreach($pages as $key=>$value)
        <tr>
            <td> {{ $value->id }} </td>
            <td> {{ $value->title}} </td>
            <td> {{ $value->class_name}} </td>
            <td> {{ $value->tag}} </td>
            <td> {{ $value->status}} </td>
            <td> {{ $value->parent}} </td>
            <td> {{ $value->position}} </td>
            <td> {{ count($value->layouts)}} </td>
            <td>   
               </td>
        </tr>
        @endforeach

    </tbody>
</table>
@stop
