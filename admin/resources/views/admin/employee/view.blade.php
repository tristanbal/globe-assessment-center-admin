@extends('layouts.app')

@section('content')

<div class="container">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{route('home')}}">Home</a></li>
            <li class="breadcrumb-item"><a href="{{route('employees.index')}}">Employees</a></li>
            <li class="breadcrumb-item active" aria-current="page">{{$employeePersonal->employeeID}} - {{$employeePersonal->firstname}} {{$employeePersonal->lastname}}</li>
        </ol>
    </nav>

    <div class="row">
        <div class="col-sm-4">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-sm-12 d-flex justify-content-center">
                                    @if ($userAccess)
                                        <div class="avatar avatar-xxl">
                                            <img src="
                                            @if($userAccess->profileImage == 'no-image.png')
                                            {{asset('stock/no-image.png')}}
                                            @else
                                                {{$userAccess->profileImage}}
                                            @endif" alt="..." class="avatar-img rounded-circle">
                                        </div>
                                    @else
                                        <div class="avatar avatar-xxl">
                                            <img src="{{asset('stock/no-image.png')}}" alt="..." class="avatar-img rounded-circle">
                                        </div>
                                        
                                    @endif
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12">
                                    <h3 class="pt-4">{{$employeePersonal->firstname}} {{$employeePersonal->middlename}} {{$employeePersonal->lastname}} 
                                        @if ($employeePersonal->nameSuffix != 'N/A')
                                            {{$employeePersonal->nameSuffix}}
                                        @endif
                                    </h3>
                                    <h5><span class="font-weight-bold text-uppercase">Personal Information</span> </h5>
                                    <p>
                                        <i class="fas fa-address-book"></i> &nbsp {{$employeePersonal->employeeID}}<br>
                                        <i class="fab fa-google-plus"></i> &nbsp {{$employeePersonal->email}}<br>
                                        <i class="fas fa-phone"></i> &nbsp {{$employeePersonal->phone}}<br>
                                    </p>
                                    <h5><span class="font-weight-bold text-uppercase">Designation Information</span> </h5>
                                    <p>
                                        <i class="icon-people"></i> &nbsp {{$supervisor->employeeID}} | {{$supervisor->firstname}} {{$supervisor->lastname}}<br>
                                        <i class="fas fa-suitcase"></i> &nbsp {{$rolePersonal->name}}<br>
                                        @if($job)
                                        <i class="fas fa-hotel"></i> &nbsp {{$job->name}}<br>
                                        @else
                                        <i class="fas fa-hotel"></i> &nbsp N/A<br>
                                        @endif
                                        
                                        <i class="fas fa-dollar-sign"></i> &nbsp {{$band->name}}<br>
                                    </p>
                                    <h5><span class="font-weight-bold text-uppercase">Organizational Information</span> </h5>
                                    <p>
                                        <i class="fas fa-clipboard"></i> &nbsp {{$group->name}}<br>
                                        <i class="fas fa-clipboard-check"></i> &nbsp {{$division->name}}<br>
                                        <i class="fas fa-clipboard-list"></i> &nbsp {{$department->name}}<br>
                                        <i class="fas fa-code-branch"></i> &nbsp {{$section->name}} <br>
                                    </p>
                                </div>
                            </div>
                            
                        </div>
                    </div>
                </div>
            </div>
                
        </div>
        <div class="col-sm-8">
            <div class="row">
                <div class="col-sm-6">
                    <div class="card full-height">
                        <div class="card-body">
                            <h3>Access Information</h3>
                            <h5>First User Access: 
                                @if ($userAccess)
                                    {{$userAccess->updated_at}}
                                @else
                                    N/A 
                                @endif
                            </h5>
                            <h5>Email Used: 
                                @if ($userAccess)
                                    {{$userAccess->email}}
                                @else
                                    N/A 
                                @endif
                            </h5>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="card full-height">
                        <div class="card-body">
                            <h3>Assessment Status</h3>
                            @if ($employeeRelationship)
                                @if ($assessmentType)
                                    @foreach ($employeeRelationship as $employeeRelationshipItem)
                                        @foreach ($assessmentType as $assessmentTypeItem)    
                                            @if ($employeeRelationshipItem->relationshipID == $assessmentTypeItem->relationshipID)
                                                {{$assessmentTypeItem->name}}: N/A
                                                
                                            @endif
                                        @endforeach
                                    @endforeach
                                @endif
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="accordion accordion-secondary">
                <div class="card" style="-webkit-box-shadow: 1px 5px 7px 0px rgba(0,0,0,0.14);
                -moz-box-shadow: 1px 5px 7px 0px rgba(0,0,0,0.14);
                box-shadow: 1px 5px 7px 0px rgba(0,0,0,0.14);">
                    <div class="card-header collapsed" title="Click to view the assessment." id="heading-employee-relationship" data-toggle="collapse" data-target="#collapse-employee-relationship" aria-expanded="false" aria-controls="collapse">
                        <div class="avatar avatar-md mr-4">
                            <img src="{{asset('assessment-images/feedback 1.svg')}}" alt="..." class="avatar-img">
                        </div>
                        <h4 class="text-dark text-uppercase font-weight-bold">Employee Relationship</h4>
                            
                        <div class="span-mode text-dark"></div>
                    </div>
                    <div id="collapse-employee-relationship" class="collapse" aria-labelledby="heading-employee-relationship" data-parent="#accordion">
                        <div class="card-body">
                            <p>All Employees in relation to {{$employeePersonal->firstname}} is displayed here. </p>
                            <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#exampleModal">
                                Add Employee Relationship
                            </button>
                            <br><br>
                            @if ($employeeRelationshipListSummary)
                                <div class="table-responsive">
                                    <table id="employee-relationship-list" class="display table table-striped table-hover" cellspacing="0" width="100%">
                                        <thead>
                                            <tr>
                                                <th>Assessee</th>
                                                <th>Assessor</th>
                                                <th>Relationship</th>
                                                <th>Is Active</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($employeeRelationshipListSummary as $empRelListItem)
                                                <tr>
                                                    <td>{{$empRelListItem->assessee}}</td>
                                                    <td>{{$empRelListItem->assessor}}</td>
                                                    <td>{{$empRelListItem->relationship}}</td>
                                                    <td class="text-uppercase">{{$empRelListItem->isActive}}</td>
                                                    <td><a href="{{route('employee-relationship.edit',['id' => $empRelListItem->id])}}" class="btn btn-primary">EDIT</a></td>
                                                </tr>
                                            @endforeach
                                            
                                        </tbody>
                                    </table>
                                </div>
                            @else
                                
                            @endif
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
                                                                        <option value = "{{$row->employeeID}}">{{$row->employeeID}} | {{$row->firstname}} {{$row->lastname}}</option>
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
                                                                        <option value = "{{$row->employeeID}}">{{$row->employeeID}} | {{$row->firstname}} {{$row->lastname}}</option>
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
            </div>
            <h1 class="text-uppercase">User Sample View From Portal</h1>
            <div class="container">
                <div id="load-content" class="row">
                    <div class="col-sm-12">
                        @if ($employeeRelationship)
                            <div class="accordion accordion-secondary">
                                @if ($assessmentType)
                                    @foreach ($employeeRelationship as $employeeRelationshipItem)
                                        @foreach ($assessmentType as $assessmentTypeItem)    
                                            @if ($employeeRelationshipItem->relationshipID == $assessmentTypeItem->relationshipID)
                                                <div class="card" style="-webkit-box-shadow: 1px 5px 7px 0px rgba(0,0,0,0.14);
                                                -moz-box-shadow: 1px 5px 7px 0px rgba(0,0,0,0.14);
                                                box-shadow: 1px 5px 7px 0px rgba(0,0,0,0.14);">
                                                    <div class="card-header collapsed" title="Click to view the assessment." id="heading{{$assessmentTypeItem->id}}" data-toggle="collapse" data-target="#collapse{{$assessmentTypeItem->id}}" aria-expanded="false" aria-controls="collapse{{$assessmentTypeItem->id}}">
                                                        <div class="avatar avatar-md mr-4">
                                                            <img src="{{asset('assessment-images/feedback 1.svg')}}" alt="..." class="avatar-img">
                                                        </div>
                                                        <h4 class="text-dark text-uppercase font-weight-bold">{{$assessmentTypeItem->name}}</h4>
                                                            
                                                        <div class="span-mode text-dark"></div>
                                                    </div>
                                                    <div id="collapse{{$assessmentTypeItem->id}}" class="collapse" aria-labelledby="heading{{$assessmentTypeItem->id}}" data-parent="#accordion">
                                                        <div class="card-body">
                                                            <p>
                                                                {{$assessmentTypeItem->definition}}
                                                            </p>
                                                            @if ($employeeRelationshipList)
                                                                @if ($role)
                                                                    <div class="table-responsive">
                                                                        <table id="employee-datatables-{{$assessmentTypeItem->id}}" class="display table table-striped table-hover" cellspacing="0" width="100%">
                                                                            <thead>
                                                                                <tr>
                                                                                    <th>Employee ID</th>
                                                                                    <th>First Name</th>
                                                                                    <th>Last Name</th>
                                                                                    <th>Email</th>
                                                                                </tr>
                                                                            </thead>
                                                                            <tbody>
                                                                                @foreach ($employeeRelationshipList as $employeeRelationshipListItem)
                                                                                    @foreach ($employee as $employeeItem)
                                                                                            @if ($employeeRelationshipListItem->assesseeEmployeeID == $employeeItem->id &&
                                                                                                $employeeRelationshipListItem->relationshipID ==  $employeeRelationshipItem->relationshipID) 
                                                                                                @if ($employeeRelationshipListItem->assesseeEmployeeID != $employeePersonal->id)
                                                                                                    <tr>
                                                                                                        <td>{{$employeeItem->employeeID}}</td>
                                                                                                        <td>{{$employeeItem->firstname}}</td>
                                                                                                        <td>{{$employeeItem->lastname}}</td>
                                                                                                        <td><a href="my-assessment/{{$assessmentTypeItem->id}}/{{$employeeItem->id}}/start" class="btn btn-success">ASSESS</a></td>
                                                                                                    </tr>    
                                                                                                @else
                                                                                                    <tr>
                                                                                                        <td class="text-uppercase text-center" colspan="3">You are Assessing yourself</td>
                                                                                                        <td><a href="my-assessment/{{$assessmentTypeItem->id}}/{{$employeeItem->id}}/start" class="btn btn-success">ASSESS</a></td>
                                                                                                    </tr>    
                                                                                                @endif
                                                                                            @endif
                                                                                    @endforeach
                                                                                @endforeach
                                                                            </tbody>
                                                                        </table>
                                                                    </div>
                                                                    <script>
                                                                        $(document).ready(function() {
                                                                                $('#employee-datatables-{{$assessmentTypeItem->id}}').DataTable();
                                                                        });
                                                                    </script>
                                                                @endif
                                                            @endif
                                                        </div>
                                                    </div>
                                                </div>
                                            @endif
                                        @endforeach
                                    @endforeach
                                @endif
                            </div>
                        @else
                            
                            <div class="card">
                                <div class="card-body text-center">
                                    <h3 class="text-uppercase font-weight-bold">No Assessment</h3>
                                    <p>Please come back at another time.</p> 
    
                                    <hr>
                                    <p>If you think this is a mistake, please contact our administrator or give us an e-mail at globeuniversity@globe.com.ph</p>
                                </div>
                            </div>
                        @endif
                        
                    </div>
                </div>
            </div>
        </div>

    </div>
    
    <div class="row">
        <div class="col-md-12">
            <div class="form-group">
                <a href="{{route('employees.delete',['id' => $employeePersonal->id])}}" class="btn btn-danger">DELETE</a>
                <a style = "" href = "{{route('employees.edit', ['id' => $employeePersonal->id])}}}}'"><div class = "btn-primary btn">EDIT</div></a>
            </div>
        </div>
    </div>
</div>


@endsection

@section('scripts')
    <script>
        $(document).ready(function() {
            $('#employee-relationship-list').DataTable({
                dom: 'Bfrtip',
                buttons: [
                    'copy', 'csv', 'excel', 'pdf', 'print'
                ]
            });
        });
    </script>
@endsection