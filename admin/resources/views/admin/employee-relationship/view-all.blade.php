@extends('layouts.app')

@section('content')

<div class="container">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{route('home')}}">Home</a></li>
            <li class="breadcrumb-item active" aria-current="page">Employee Relationship</li>
        </ol>
    </nav>
            
    <div class="row justify-content-center">
        <div class="col-md-12">
            <h1>Employee Relationship</h1>
            <!-- Button trigger modal -->
            <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#exampleModal">
                Add Employee Relationship
            </button>
            <br><br>

            <ul class="nav nav-pills nav-secondary  nav-pills-no-bd nav-pills-icons justify-content-center mb-3" id="pills-tab" role="tablist">
                <li class="nav-item">
                    <a class="nav-link active" id="pills-home-tab-icon" data-toggle="pill" href="#pills-home-icon" role="tab" aria-controls="pills-home-icon" aria-selected="true">
                    <i class="flaticon-search"></i>
                    Search Bar
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="pills-profile-tab-icon" data-toggle="pill" href="#pills-profile-icon" role="tab" aria-controls="pills-profile-icon" aria-selected="false">
                    <i class="flaticon-list"></i>
                    Summary
                    </a>
                </li>
            </ul>
            <div class="tab-content mb-3" id="pills-tabContent">
                <div class="tab-pane fade show active" id="pills-home-icon" role="tabpanel" aria-labelledby="pills-home-tab-icon">
                    {{  Form::open(array('action' => 'EmployeeRelationshipController@searchEmployee'))}}
                    <div class="row">
                        <div class="col-sm-4">
                            <div class="form-group ">
                                <label>Select an Employee:</label>
                                <select id="searchEmployee" class="form-control searchEmployee" name="employeeID" style="width:100%;" required>
                                    @if(count($employee_data) > 0)
                                        <option value = "" disabled selected>Select an Employee</option>
                
                                            @foreach($employee_data as $row)
                                                <option value = "{{$row->id}}">{{$row->employeeID}} | {{$row->firstname}} {{$row->lastname}}</option>
                                            @endforeach
                                    @else
                                        <option value = "" disabled selected>No Employee found</option>
                                    @endif
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-3">
                            <div class="form-group">
                                <label>Assessee or Assessor:</label>
                                <select id="selectTaker" class="form-control selectTaker" name="selectTaker" style="width:100%;" required>
                                    <option value = "" disabled selected>Select if Assessee or Assessor</option>
                                    <option value = "1">Assessee</option>
                                    <option value = "2">Assessor</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-3">
                            <div class="form-group">
                                <label>Select a Relationship Type:</label>
                                <select id="searchRelationship" class="form-control searchRelationship" name="relationshipID" style="width:100%;" required>
                                    @if(count($relationship) > 0)
                                        <option value = "" disabled selected>Select a relationship type</option>
                
                                            @foreach($relationship as $row)
                                                <option value = "{{$row->id}}">{{$row->name}}</option>
                                            @endforeach
                                    @else
                                        <option value = "" disabled selected>No relationship type found</option>
                                    @endif
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-2">
                            <div class="form-group ">
                                    <label></label>
                            <button class="btn btn-success btn-block" type="submit">Search</button>
                            </div>
                        </div>
                        
                    </div>
                    {{ Form::close() }}
            
                </div>
                <div class="tab-pane fade" id="pills-profile-icon" role="tabpanel" aria-labelledby="pills-profile-tab-icon">
                    <div class="row">
                        <div class="col-12">
                            <div class="table-responsive">
                                <table id="basic-datatables" class="display table table-striped table-hover" cellspacing="0" width="100%">
                                    <thead>
                                        <tr>
                                            <th>Assessee Employee ID</th>
                                            <th>Assessor Employee ID</th>
                                            <th>Relationship Type</th>
                                            <th>Is Active</th>
                                            <th>Created At</th>
                                            <th>Updated At</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                </table>
                            </div>
                
                            <br>
                            
                            
                        </div>
                    </div>
                </div>
            </div>

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
                                        @if(count($employee_data) > 0)
                                            <option value = "" disabled selected>Select an Assessee</option>
                    
                                                @foreach($employee_data as $row)
                                                    <option value = "{{$row->id}}">{{$row->employeeID}} | {{$row->firstname}} {{$row->lastname}}</option>
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
                                                    <option value = "{{$row->id}}">{{$row->employeeID}} | {{$row->firstname}} {{$row->lastname}}</option>
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
                                                    <option value = "{{$row->id}}">{{$row->name}}</option>
                                                @endforeach
                                        @else
                                            <option value = "" disabled selected>No relationship type found</option>
                                        @endif
                                    </select>
                                    <label>Set an Opposite Equivalency of Relationship Type (Optional):</label>
                                    <select id="test4" class="form-control relationship-opposite" name="oppositeRelationshipID" style="width:100%;" >
                                        @if(count($relationship) > 0)
                                            <option value = "" disabled selected>Select a relationship type</option>

                                                @foreach($relationship as $row)
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

            

            
        </div>
    </div>
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


<script type="text/javascript">
    $(document).ready(function() {
         $('#basic-datatables').DataTable({
            "processing": true,
            "serverSide": true,
            "ajax": "{{route('employee-relationships.ajaxdata')}}",
            "columns":[
                { data: "assesseeEmployeeID",name: "employee_relationships.assesseeEmployeeID" },
                { data: "assessorEmployeeID",name: "employee_relationships.assessorEmployeeID" },
                { data: "relationshipName",name: "relationships.name" },
                { data: "is_active",name: "employee_relationships.is_active" },
                { data: "created_at",name: "employee_relationships.created_at"},
                { data: "updated_at",name: "employee_relationships.updated_at"},
                { 
                    data: "id",                   
                    "render": function ( data, type, row ) {
                        var view  = '<div style = "display: flex;"> <a style = "float: left;" href = "employee-relationship/view/'+ row.id +'"><div class = "btn-info btn">VIEW</div></a>';
                        var edit =  '<a style = "float: right;" href = "employee-relationship/edit/'+ row.id +'"><div class = "btn-success btn">EDIT</div></a>';  
                        var del =  '<a style = "float: right;" href = "employee-relationship/delete/'+ row.id +'"><div class = "btn-danger btn">DELETE</div></a></div>';   
                        return view +  edit + del;
                    }
                }
                
            ]
         });
    });
    </script>
@endsection