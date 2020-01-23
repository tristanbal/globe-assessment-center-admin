@extends('layouts.app')

@section('content')

<div class="container">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{route('home')}}">Home</a></li>
            <li class="breadcrumb-item"><a href="{{route('competencyTypes.index')}}">Competency Type</a></li>
            <li class="breadcrumb-item active" aria-current="page">{{$competencyType->name}}</li>
        </ol>
    </nav>
            
    <div class="row justify-content-center">
        <div class="col-md-12">
            <h1>Update Competency Type</h1>
        </div>
    </div>
    {{  Form::open(array('action' =>[ 'CompetencyTypeController@update',$competencyType->id]))}}
    <div class="row">
        <div class="col-md-12">
            <div class="form-group form-floating-label">
                <div class="form-group form-floating-label">
                    <input id="inputFloatingLabel" type="text" value="{{$competencyType->name}}" name="name" class="form-control input-border-bottom" required>
                    <label for="inputFloatingLabel" class="placeholder">Input Competency Type Name</label>
                </div>
                <div class="input-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text">Set Definition</span>
                    </div>
                    <textarea class="form-control" aria-label="With textarea" name="definition">{{$competencyType->definition}}</textarea>
                </div>
                <br>
                <button class=" btn btn-warning" type="reset" value="RESET">Reset</button>
                <button class=" btn btn-success " type="submit">Update</button>
            </div>
        </div>
    </div>
    {{Form::hidden('_method', 'PUT')}}
    {{ Form::close() }}
</div>


@endsection

@section('scripts')
@endsection