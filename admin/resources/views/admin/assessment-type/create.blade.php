@extends('layouts.app')

@section('content')

<div class="container">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{route('home')}}">Home</a></li>
            <li class="breadcrumb-item"><a href="{{route('assessmentTypes.index')}}">Assessment Type</a></li>
            <li class="breadcrumb-item active" aria-current="page">Create Assessment Type</li>
        </ol>
    </nav>
            
    <div class="row justify-content-center">
        <div class="col-md-12">
            <h1>Create An Assessment Type</h1>
        </div>
    </div>
    {{  Form::open(array('action' => 'AssessmentTypeController@store'))}}
    <div class="row">
        <div class="col-md-12">
            <div class="form-group form-floating-label">
                <input id="inputFloatingLabel" name="name" type="text"  class="form-control input-border-bottom" required>
                <label for="inputFloatingLabel" class="placeholder">Input a New Type Name</label>
                <small id="emailHelp" class="form-text text-muted">Make sure that the name is unique.</small>
            </div>
            <div class="form-group input-group"><br>
                <div class="input-group-prepend">
                    <span class="input-group-text">Set Definition</span>
                </div>
                <textarea class="form-control" aria-label="With textarea" name="definition"></textarea>
            </div>
            <div class="form-group">
                <label>Select a Relationship Type:</label>
                <select id="test" class="form-control js-example-basic-single" name="relationshipID" style="width:100%;" required>
                    @if(count($relationship) > 0)
                        <option value = "" disabled selected>Select Relationship</option>

                            @foreach($relationship as $row)
                                <option value = "{{$row->id}}">{{$row->name}}</option>
                            @endforeach
                    @else
                        <option value = "" disabled selected>No Groups found</option>
                    @endif
                </select>
    
                

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
    <script>    
        $(document).ready(function() {
            $('.js-example-basic-single').select2();
        }); 
    </script>
@endsection