@extends('layouts.app')

@section('content')

<div class="container">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{route('home')}}">Home</a></li>
            <li class="breadcrumb-item"><a href="{{route('interventions.index')}}">Intervention</a></li>
            <li class="breadcrumb-item active" aria-current="page">Create Intervention</li>
        </ol>
    </nav>
            
    <div class="row justify-content-center">
        <div class="col-md-12">
            <h1>Create Intervention</h1>
        </div>
    </div>
    {{  Form::open(array('action' => 'InterventionController@store'))}}
    <div class="row">
        <div class="col-md-12">
            <div class="row">
                <div class="col-md-12">
                <div class="form-group ">
                    <label>Select a Group:</label>
                    <select id="test3" class="form-control group-dropdown" name="groupID" style="width:100%;" required>
                        @if(count($group) > 0)
                            <option value = "" disabled selected>Select a Group</option>
    
                                @foreach($group as $row)
                                    <option value = "{{$row->id}}">{{$row->name}}</option>
                                @endforeach
                        @else
                            <option value = "" disabled selected>No Group found</option>
                        @endif
                    </select>
                </div>
                <div class="form-group ">
                    <label>Select a Division:</label>
                    <select id="test4" class="form-control division-dropdown" name="divisionID" style="width:100%;" required>
                        @if(count($division) > 0)
                            <option value = "" disabled selected>Select a Division</option>
    
                                @foreach($division as $row)
                                    <option value = "{{$row->id}}">{{$row->name}}</option>
                                @endforeach
                        @else
                            <option value = "" disabled selected>No Division found</option>
                        @endif
                    </select>
                </div>
                <div class="form-group ">
                    <label>Select a Competency:</label>
                    <select id="test" class="form-control competency-dropdown" name="competencyID" style="width:100%;" required>
                        @if(count($competency) > 0)
                            <option value = "" disabled selected>Select a Competency</option>
    
                                @foreach($competency as $row)
                                    <option value = "{{$row->id}}">{{$row->name}}</option>
                                @endforeach
                        @else
                            <option value = "" disabled selected>No Competency found</option>
                        @endif
                    </select>
                </div>
                <div class="form-group ">
                    <label>Select a Training:</label>
                    <select id="test2" class="form-control training-dropdown" name="trainingID" style="width:100%;" required>
                        @if(count($training) > 0)
                            <option value = "" disabled selected>Select a Training</option>
    
                                @foreach($training as $row)
                                    <option value = "{{$row->id}}">{{$row->name}}</option>
                                @endforeach
                        @else
                            <option value = "" disabled selected>No Training found</option>
                        @endif
                    </select>
                </div>
                </div>
            </div>
            <div class="form-group"><br>
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
            $('.competency-dropdown').select2();
        }); 
        $(document).ready(function() {
            $('.training-dropdown').select2();
        }); 
        $(document).ready(function() {
            $('.group-dropdown').select2();
        }); 
        $(document).ready(function() {
            $('.division-dropdown').select2();
        }); 
    </script>
    
@endsection