@extends('layouts.app')

@section('content')

<div class="container">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{route('home')}}">Home</a></li>
            <li class="breadcrumb-item"><a href="{{route('divisions.index')}}">Division</a></li>
            <li class="breadcrumb-item active" aria-current="page">Create Division</li>
        </ol>
    </nav>
            
    <div class="row justify-content-center">
        <div class="col-md-12">
            <h1>Create Division</h1>
        </div>
    </div>
    {{  Form::open(array('action' => 'DivisionController@store'))}}
    <div class="row">
        <div class="col-md-12">
            <div class="form-group form-floating-label">
                <input id="inputFloatingLabel" name="name" type="text" class="form-control input-border-bottom" required>
                <label for="inputFloatingLabel" class="placeholder">Input New Division Name</label>
                <small id="emailHelp" class="form-text text-muted">Make sure that the name is unique.</small>
            </div>
            <div class="form-group ">
                <label>Select a Group:</label>
                <select id="test" class="form-control js-example-basic-single" name="groupID" style="width:100%;" required>
                    @if(count($group) > 0)
                        <option value = "" disabled selected>Select a Group</option>

                            @foreach($group as $row)
                                <option value = "{{$row->id}}">{{$row->name}}</option>
                            @endforeach
                    @else
                        <option value = "" disabled selected>No Groups found</option>
                    @endif
                </select>
                
            </div>
            <div class="form-group"><br>
                <button class=" btn btn-warning" type="reset" value="RESET">Reset</button>
                <button class=" btn btn-success " type="submit">Add</button>
            </div>
        </div>
    </div>
        
    {{ Form::close() }}
</div>


@endsection

@section('scripts')
    <script>    
        $(document).ready(function() {
            $('.js-example-basic-single').select2();
        }); 
    </script>
@endsection