@extends('layouts.app')

@section('content')

<div class="container">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{route('home')}}">Home</a></li>
            <li class="breadcrumb-item"><a href="{{route('completionTrackers.index')}}">Completion Tracker</a></li>
            <li class="breadcrumb-item active" aria-current="page">Create An Assignment</li>
        </ol>
    </nav>
            
    <div class="row justify-content-center">
        <div class="col-md-12">
            <h1>Create An Assignment for Completion Tracker</h1>
        </div>
    </div>
    {{  Form::open(array('action' => 'CompletionTrackerAssignmentController@store'))}}
    <div class="row">
        <div class="col-md-12">
            <div class="row">
                <div class="col-sm-12 form-group">
                    <label>Type of Group Gap Analysis Setting:</label>
                    <select id="gpgasDropdown" class="form-control group" name="gpgasDropdown" style="width:100%;" >
                        @if(count($groupsPerGapAnalysisSetting) > 0)
                            <option value = "" disabled selected>Select a Group Gap Analysis Setting</option>
    
                                @foreach($groupsPerGapAnalysisSetting as $row)
                                    <option data-group = '{{$row->id}}' value = "{{$row->id}}">{{$row->name}}</option>
                                @endforeach
                        @else
                            <option value = "" disabled selected>No Group Gap Analysis Setting found</option>
                        @endif
                    </select>
                </div>
            </div>

            <div class="row">
                <div class="col-sm-12 form-group">
                    <label>Employee:</label>
                    <select id="employeeDropdown" class="form-control group" name="employeeDropdown" style="width:100%;" >
                        @if(count($employee) > 0)
                            <option value = "" disabled selected>Select an Employee</option>
                                @foreach($employee as $row)
                                    <option data-group = '{{$row->id}}' value = "{{$row->id}}">{{$row->employeeID}} | {{$row->firstname}} {{$row->lastname}}</option>
                                @endforeach
                        @else
                            <option value = "" disabled selected>No Employee found</option>
                        @endif
                    </select>
                </div>
            </div>
            <br>
            <button class=" btn btn-warning" type="reset" value="RESET">Reset</button>
            <button class=" btn btn-success " type="submit">Add</button>
        </div>
    </div>
        
    {{ Form::close() }}
</div>


@endsection

@section('scripts')
    <script>
        $(document).ready(function() {
            $('#gpgasDropdown').select2();
        }); 
        $(document).ready(function() {
            $('#employeeDropdown').select2();
        }); 
    </script>

@endsection