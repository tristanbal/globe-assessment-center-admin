@extends('layouts.app')

@section('content')

<div class="container">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{route('home')}}">Home</a></li>
            <li class="breadcrumb-item"><a href="{{route('employee-relationships.index')}}">Employee Relationship</a></li>
            <li class="breadcrumb-item active" aria-current="page">{{$employeeSearchedDetails->firstname}} {{$employeeSearchedDetails->lastname}}</li>
            <li class="breadcrumb-item active" aria-current="page">
                @if ($takerID == 1)
                    Assessee
                @else
                    Assessor
                @endif
            </li>
        </ol>
    </nav>
            
    <div class="row justify-content-center">
        <div class="col-md-12">
            <h1>Search Results</h1>
            <h3>Employee Relationship results for {{$employeeSearchedDetails->firstname}} {{$employeeSearchedDetails->lastname}} as 
                @if ($takerID == 1)
                    Assessee.
                @else
                    Assessor.
                @endif
            </h3>
            <!-- Button trigger modal -->
            <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#exampleModal">
                Add Employee Relationship
            </button>
            <br><br>
            <!-- Modal -->
            <div class="modal fade" id="exampleModal"  role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Add an Employee Relationship</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            {{  Form::open(array('action' => 'EmployeeRelationshipController@store'))}}
                            <div class="row">
                                <div class="col-md-12">
                                <div class="form-group ">
                                    <label>Select an Assessee:</label>
                                    <select id="test1" class="form-control assessee" name="assesseeEmployeeID" style="width:100%;" required>
                                        @if(count($employeeDataAll) > 0)
                                            <option value = "" disabled selected>Select an Assessee</option>
                    
                                                @foreach($employeeDataAll as $row)
                                                    <option value = "{{$row->employeeID}}">{{$row->employeeID}} | {{$row->firstname}} {{$row->lastname}}</option>
                                                @endforeach
                                        @else
                                            <option value = "" disabled selected>No Assessee found</option>
                                        @endif
                                    </select>

                                    <label>Select an Assessor:</label>
                                    <select id="test2" class="form-control assessor" name="assessorEmployeeID" style="width:100%;" required>
                                        @if(count($employeeDataAll) > 0)
                                            <option value = "" disabled selected>Select an Assessor</option>
                    
                                                @foreach($employeeDataAll as $row)
                                                    <option value = "{{$row->employeeID}}">{{$row->employeeID}} | {{$row->firstname}} {{$row->lastname}}</option>
                                                @endforeach
                                        @else
                                            <option value = "" disabled selected>No Assessor found</option>
                                        @endif
                                    </select>

                                    <label>Select a Relationship Type:</label>
                                    <select id="test3" class="form-control relationship" name="relationshipID" style="width:100%;" required>
                                        @if(count($relationshipSummary) > 0)
                                            <option value = "" disabled selected>Select a relationship type</option>
                    
                                                @foreach($relationshipSummary as $row)
                                                    <option value = "{{$row->id}}">{{$row->name}}</option>
                                                @endforeach
                                        @else
                                            <option value = "" disabled selected>No relationship type found</option>
                                        @endif
                                    </select>
                                    <label>Set an Opposite Equivalency of Relationship Type (Optional):</label>
                                    <select id="test4" class="form-control relationship-opposite" name="oppositeRelationshipID" style="width:100%;" >
                                        @if(count($relationshipSummary) > 0)
                                            <option value = "" disabled selected>Select a relationship type</option>

                                                @foreach($relationshipSummary as $row)
                                                    <option value = "{{$row->id}}">{{$row->name}}</option>
                                                @endforeach
                                        @else
                                            <option value = "" disabled selected>No relationship type found</option>
                                        @endif
                                    </select>
                                </div>
                                </div>
                            </div>
                            
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button class=" btn btn-warning" type="reset" value="RESET">Reset</button>
                            <button class=" btn btn-success " type="submit">Add</button>
                        </div>
                        {{ Form::close() }}
                    </div>
                </div>
            </div>


            <!-- all employees -->
            <div class="table-responsive">
                <table id="basic-datatables" class="display table table-striped table-hover" cellspacing="0" width="100%">
                    <thead>
                        <tr>
                            <th>Employee ID</th>
                            <th>Employee Name</th>
                            <th>Relationship</th>
                            <th>Is Active</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($employeeRelationshipSummary as $item)
                        <tr>
                            <td>{{$item->employeeID}}</td>
                            <td>{{$item->firstname}} {{$item->lastname}}</td>
                            <td>{{$item->relationship}}</td>
                            <td>
                                @if ($item->is_active == 1)
                                    YES
                                @else
                                    NO
                                @endif
                            </td>
                            <td>
                                <div style = "display: flex;"> <a style = "float: left;" href = "{{route('employee-relationships.search.show',['id' => $item->id, 'takerID' => $takerID,'employeeID'=>$employeeSearchedDetails->id, 'relationshipID'=>$relationshipID ])}}"><div class = "btn-info btn">VIEW</div></a>
                                <a style = "float: right;" href = "{{route('employee-relationships.search.edit',['id' => $item->id, 'takerID' => $takerID,'employeeID'=>$employeeSearchedDetails->id, 'relationshipID'=>$relationshipID ])}}"><div class = "btn-success btn">EDIT</div></a>
                                <a style = "float: right;" href = "{{route('employee-relationships.search.destroy',['id' => $item->id, 'takerID' => $takerID,'employeeID'=>$employeeSearchedDetails->id, 'relationshipID'=>$relationshipID ])}}"><div class = "btn-danger btn">DELETE</div></a></div>
                            </td>
                        </tr>
                            
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>


@endsection

@section('scripts')
    <script>
    $(document).ready(function() {
        $('#basic-datatables').DataTable();
    });
    
    </script>
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
            $('.relationship-opposite').select2();
        });
        $(document).ready(function() {
            $('.searchEmployee').select2();
        }); 
        $(document).ready(function() {
            $('.selectTaker').select2();
        }); 
        $(document).ready(function() {
            $('.searchRelationship').select2();
        });
    </script>
@endsection