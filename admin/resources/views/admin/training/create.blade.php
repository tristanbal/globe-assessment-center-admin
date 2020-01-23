@extends('layouts.app')

@section('content')

<div class="container">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{route('home')}}">Home</a></li>
            <li class="breadcrumb-item"><a href="{{route('training.index')}}">Training</a></li>
            <li class="breadcrumb-item active" aria-current="page">Create Training</li>
        </ol>
    </nav>
            
    <div class="row justify-content-center">
        <div class="col-md-12">
            <h1>Create Training</h1>
        </div>
    </div>
    {{  Form::open(array('action' => 'TrainingController@store'))}}
    <div class="row">
        <div class="col-md-12">
            <div class="form-group">
                <label for="typeName">Name:</label>
                <input type="text" class="form-control input-pill" id="typeName" name="name" placeholder="New Assessment Type">
                <small id="emailHelp" class="form-text text-muted">Make sure the assessment type is unique.</small><br>
                

                <br><br>
                <button class=" btn btn-warning" type="reset" value="RESET">Reset</button>
                <button class=" btn btn-success " type="submit">Add</button>
            </div>
        </div>
    </div>
        
    {{ Form::close() }}
</div>


@endsection

@section('scripts')
@endsection