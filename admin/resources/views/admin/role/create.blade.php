@extends('layouts.app')

@section('content')

<div class="container">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{route('home')}}">Home</a></li>
            <li class="breadcrumb-item"><a href="{{route('roles.index')}}">Role</a></li>
            <li class="breadcrumb-item active" aria-current="page">Create Role</li>
        </ol>
    </nav>
            
    <div class="row justify-content-center">
        <div class="col-md-12">
            <h1>Create A Role</h1>
        </div>
    </div>
    {{  Form::open(array('action' => 'RoleController@store'))}}
    <div class="row">
        <div class="col-md-12">
            <div class="form-group form-floating-label">
                <input id="inputFloatingLabel"  name="name" type="text" class="form-control input-border-bottom" required>
                <label for="inputFloatingLabel" class="placeholder">Input New Role Name</label>
                <small id="emailHelp" class="form-text text-muted">Make sure that the name is unique.</small><br>
                <br>
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