@extends('layouts.app')

@section('content')

<div class="container">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{route('home')}}">Home</a></li>
            <li class="breadcrumb-item"><a href="{{route('employee-relationships.index')}}">Employee Relationship</a></li>
            <li class="breadcrumb-item active" aria-current="page">Update Employee Relationship</li>
        </ol>
    </nav>
            
    <div class="row justify-content-center">
        <div class="col-md-12">
            <h1>Update Employee Relationship</h1>
        </div>
    </div>
    {{  Form::open(array('action' =>[ 'EmployeeRelationshipController@update',$employeeRelationship->id]))}}
    <div class="row">
        <div class="col-md-12">
            <div class="form-group ">
                <label>Select an Assessee:</label>
                <select id="test1" class="form-control assessee" name="assesseeEmployeeID" style="width:100%;" required>
                    @if(count($employee_data) > 0)
                        <option value = "" disabled selected>Select an Assessee</option>

                        @foreach($employee_data as $row)
                        <option value = "{{$row->id}}" 
                        
                        @if ($row->id == $employeeRelationship->assesseeEmployeeID)
                           selected
                            
                        @endif

                        >{{$row->employeeID}} | {{$row->firstname}} {{$row->lastname}} </option>
                       
                    @endforeach
                    @else
                        <option value = "" disabled selected>No Assessee found</option>
                    @endif
                </select>

                <label>Select an Assessor:</label>
                <select id="test2" class="form-control assessor" name="assessorEmployeeID" style="width:100%;" required>
                    @if(count($employee_data) > 0)
                        <option value = "" disabled selected>Select an Assessor</option>

                        @foreach($employee_data as $row)
                        <option value = "{{$row->id}}" 
                        
                        @if ($row->id == $employeeRelationship->assessorEmployeeID)
                           selected
                            
                        @endif

                        >{{$row->employeeID}} | {{$row->firstname}} {{$row->lastname}} </option>
                       
                    @endforeach
                    @else
                        <option value = "" disabled selected>No Assessor found</option>
                    @endif
                </select>

                <label>Select a Relationship Type:</label>
                <select id="test3" class="form-control relationship" name="relationshipID" style="width:100%;" required>
                    @if(count($relationship) > 0)
                        <option value = "" disabled selected>Select a relationship type</option>

                        @foreach($relationship as $row)
                            <option value = "{{$row->id}}" 
                            
                            @if ($row->id == $employeeRelationship->relationshipID)
                            selected
                                
                            @endif

                            >{{$row->name}}</option>
                        
                        @endforeach
                    @else
                        <option value = "" disabled selected>No relationship type  found</option>
                    @endif
                </select>

                <label>Set Active Status:</label>
                <select id="test4" class="form-control is-active" name="is-active" style="width:100%;" required>
                        <option value = "" disabled selected>Select a status</option>

                        <option value = "1" 
                        @if ($employeeRelationship->is_active == 1)
                            selected
                        @endif
                        
                        >Active</option>

                        <option value="0"
                        @if ($employeeRelationship->is_active == 0)
                           selected
                        @endif
                        >Not Active</option>
                </select>

            </div>
            <div class="form-group"><br>
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
    <script>
        $(document).ready(function() {
            $('.assessee').select2();
        }); 
        $(document).ready(function() {
            $('.assessor').select2();
        }); 
        $(document).ready(function() {
            $('.relationship').select2();
        }); 
        $(document).ready(function() {
            $('.is-active').select2();
        }); 
    </script>
@endsection