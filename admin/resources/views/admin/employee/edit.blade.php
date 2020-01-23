@extends('layouts.app')

@section('content')

<div class="container">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{route('home')}}">Home</a></li>
            <li class="breadcrumb-item"><a href="{{route('employees.index')}}">Employees</a></li>
            <li class="breadcrumb-item active" aria-current="page">Update Employee</li>
        </ol>
    </nav>
            
    <div class="row justify-content-center">
        <div class="col-md-12">
            <h1>Update Employee</h1>
        </div>
    </div>
    {{  Form::open(array('action' => ['EmployeeDataController@update',$employee->id]))}}
    <div class="card">
        <div class="card-body">
            <h5 class="text-uppercase card-title">Personal Information</h5>
            <hr>
            <div class="row">
                <div class="col-sm-4">
                    <div class="form-floating-label">
                        <input id="firstname" name="firstname" value="{{$employee->firstname}}" type="text" class="form-control input-border-bottom" required>
                        <label for="firstname" class="placeholder">First Name</label>
                        <small id="emailHelp" class="form-text text-muted">Required</small>
                    </div>
                </div>
                <div class="col-sm-3">
                    <div class="form-floating-label">
                        <input id="middlename" name="middlename" value="{{$employee->middlename}}" type="text" class="form-control input-border-bottom" >
                        <label for="middlename" class="placeholder">Middle Name</label>
                        <small id="emailHelp" class="form-text text-muted">Optional</small>
                    </div>
                </div>
                <div class="col-sm-3">
                    <div class="form-floating-label">
                        <input id="lastname" name="lastname" value="{{$employee->lastname}}" type="text" class="form-control input-border-bottom" required>
                        <label for="lastname" class="placeholder">Last Name</label>
                        <small id="emailHelp" class="form-text text-muted">Required</small>
                    </div>
                </div>
                <div class="col-sm-2">
                    <div class="form-floating-label">
                        <input id="namesuffix" name="namesuffix" value="{{$employee->nameSuffix}}" type="text" class="form-control input-border-bottom" >
                        <label for="namesuffix" class="placeholder">Name Suffix</label>
                        <small id="emailHelp" class="form-text text-muted">Optional</small>
                    </div>
                </div>
                
            </div>
            <div class="row">
                <div class="col-sm-4">
                    <div class="form-floating-label">
                        <input id="employeeID" name="employeeID" value="{{$employee->employeeID}}" type="text" class="form-control input-border-bottom" required>
                        <label for="employeeID" class="placeholder">Employee ID</label>
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="form-floating-label">
                        <input id="email" name="email" type="email" value="{{$employee->email}}" class="form-control input-border-bottom" required>
                        <label for="email" class="placeholder">Email</label>
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="form-floating-label">
                        <input id="phone" name="phone" type="text" value="{{$employee->phone}}" class="form-control input-border-bottom" required>
                        <label for="phone" class="placeholder">Cellphone Number</label>
                    </div>
                </div>
            </div>
            <br>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-6">
            <div class="card">
                <div class="card-body">
                    <div class="form-group ">
                        <h5 class="text-uppercase card-title ">Designation Information</h5>
                        <hr>
                        <label>Supervisor:</label>
                        <select id="supervisorID" class="form-control supervisor" name="supervisorID" style="width:100%;" required>
                            @if(count($employeeList) > 0)
                                <option value = "" disabled selected>Select a Supervisor</option>
                                @foreach($employeeList as $row)
                                    <option value = "{{$row->employeeID}}" 
                                    @if ($row->employeeID == $employee->supervisorID)
                                        selected
                                    @endif
                                    >{{$row->employeeID}} | {{$row->firstname}} {{$row->lastname}} </option>
                                @endforeach
                            @else
                                <option value = "" disabled selected>No Supervisor found</option>
                            @endif
                        </select>
                        <label>Role:</label>
                        <select id="roleID" class="form-control role" name="roleID" style="width:100%;" required>
                            @if(count($role) > 0)
                                <option value = "" disabled selected>Select a Role</option>
                                @foreach($role as $row)
                                    <option value = "{{$row->id}}" 
                                    @if ($row->id == $employee->roleID)
                                        selected
                                    @endif
                                    >{{$row->name}} </option>
                                @endforeach
                            @else
                                <option value = "" disabled selected>No Role found</option>
                            @endif
                        </select>
                        <label>Job:</label>
                        <select id="jobID" class="form-control job" name="jobID" style="width:100%;" required>
                            @if(count($job) > 0)
                                <option value = "" disabled selected>Select a Job</option>
                                @foreach($job as $row)
                                    <option value = "{{$row->id}}" 
                                    @if ($row->id == $employee->jobID)
                                        selected
                                    @endif
                                    >{{$row->name}} </option>
                                @endforeach
                            @else
                                <option value = "" disabled selected>No Supervisor found</option>
                            @endif
                        </select>
                        <label>Band:</label>
                        <select id="bandID" class="form-control band" name="bandID" style="width:100%;" required>
                            @if(count($band) > 0)
                                <option value = "" disabled selected>Select a Band</option>
                                @foreach($band as $row)
                                    <option value = "{{$row->id}}" 
                                    @if ($row->id == $employee->bandID)
                                        selected
                                    @endif
                                    >{{$row->name}} </option>
                                @endforeach
                            @else
                                <option value = "" disabled selected>No Band found</option>
                            @endif
                        </select>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-6">
            <div class="card">
                <div class="card-body">
                    <div class="form-group">
                        <h5 class="text-uppercase card-title ">Organizational Information</h5>
                        <hr>
                        <label>Group:</label>
                        <select id="groupsDropdown" class="form-control group" name="groupsDropdown" style="width:100%;" required>
                            @if(count($group) > 0)
                                <option value = "" disabled selected>Select a Group</option>
        
                                @foreach($group as $row)
                                <option data-group = '{{$row->id}}' value = "{{$row->id}}" 
                                @if ($row->id == $employee->groupID)
                                   selected
                                @endif
                                >{{$row->name}} </option>
                                @endforeach
                            @else
                                <option value = "" disabled selected>No Groups found</option>
                            @endif
                        </select>
                        <br>
                        <label>Division:</label>
                        <select id="divisionsDropdown" class="form-control division" name="divisionsDropdown" style="width:100%;" required>
                            @if(count($division) > 0)
                                <option value = "" disabled selected>Select a Group first</option>
        
                                @foreach($division as $row)
                                <option value = "{{$row->id}}" 
                                @if ($row->id == $employee->divisionID)
                                   selected
                                @endif
                                >{{$row->name}} </option>
                                @endforeach
                            @else
                                <option value = "" disabled selected>No Division found</option>
                            @endif

                        </select>
                        <br>
                        <label>Department:</label>
                        <select id="departmentsDropdown" class="form-control department" name="departmentsDropdown" style="width:100%;" required>
                            @if(count($department) > 0)
                                <option value = "" disabled selected>Select a Group first</option>
        
                                @foreach($department as $row)
                                <option value = "{{$row->id}}" 
                                @if ($row->id == $employee->departmentID)
                                   selected
                                @endif
                                >{{$row->name}} </option>
                                @endforeach
                            @else
                                <option value = "" disabled selected>No Department found</option>
                            @endif    
                            
                        </select>
                        <br>
                        <label>Section:</label>
                        <select id="sectionsDropdown" class="form-control section" name="sectionsDropdown" style="width:100%;" required>
                            @if(count($section) > 0)
                                <option value = "" disabled selected>Select a Group first</option>
        
                                @foreach($section as $row)
                                <option value = "{{$row->id}}" 
                                @if ($row->id == $employee->sectionID)
                                   selected
                                @endif
                                >{{$row->name}} </option>
                                @endforeach
                            @else
                                <option value = "" disabled selected>No Section found</option>
                            @endif    
                            
                        </select>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="form-group">
                <a href="{{route('employees.delete',['id' => $employee->id])}}" class="btn btn-danger">DELETE</a>
                <button class=" btn btn-success " type="submit">UPDATE</button>
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
            $('.supervisor').select2();
        }); 
        $(document).ready(function() {
            $('.role').select2();
        }); 
        $(document).ready(function() {
            $('.job').select2();
        }); 
        $(document).ready(function() {
            $('.band').select2();
        }); 
        $(document).ready(function() {
            $('.group').select2();
        }); 
        $(document).ready(function() {
            $('.division').select2();
        }); 
        $(document).ready(function() {
            $('.department').select2();
        }); 
        $(document).ready(function() {
            $('.section').select2();
        }); 
        $(document).ready(function() {
            $('.js-example-basic-single').select2();
        }); 
    </script>
    <script>
        $(document).ready(function(){
        
        var departments = <?php echo json_encode($department) ?>;
        var sections = <?php echo json_encode($section) ?>;
        var divisions = <?php echo json_encode($division) ?>;
        
        $("[name='groupsDropdown']").change(function (e) {
            var selectedGroup = $(this).find(':selected').data('group');
            //alert(selectedGroup);
            $("#divisionsDropdown").html('').select2();
            // Populate divisions dropdown
            for(var i = 0; i<divisions.length;i++){
                if(divisions[i].groupID == selectedGroup){
                    var newOption = new Option(divisions[i].name, divisions[i].id, false, false);
                    newOption.setAttribute("division",divisions[i].id);
                    $('#divisionsDropdown').append(newOption).trigger('change');
                }
            }
            });
            $("[name='divisionsDropdown']").change(function (e) {
                var selectedGroup = $("[name='groupsDropdown']").find(':selected').data('group');
                var selectedDivision = $(this).find(':selected').val();
        
                // Clear Departments Dropdown
                $("[name='departmentsDropdown']").html('').select2();
                // Populate Departments dropdown
                for(var i = 0; i<departments.length;i++){
                    if(departments[i].groupID == selectedGroup && departments[i].divisionID == selectedDivision){
                        var newOption = new Option(departments[i].name, departments[i].id, false, false);
                        $("[name='departmentsDropdown']").append(newOption).trigger('change');
                    }
                }
            });
            $("[name='departmentsDropdown']").change(function (e) {
                var selectedGroup = $("[name='groupsDropdown']").find(':selected').data('group');
                var selectedDivision = $("[name='divisionsDropdown']").find(':selected').val();
                var selectedDepartment = $("[name='departmentsDropdown']").find(':selected').val();
        
                // Clear sections Dropdown
                $("[name='sectionsDropdown']").html('').select2();
                // Populate sections dropdown
                for(var i = 0; i<sections.length;i++){
                    if(sections[i].groupID == selectedGroup && sections[i].divisionID == selectedDivision && sections[i].departmentID == selectedDepartment){
                        var newOption = new Option(sections[i].name, sections[i].id, false, false);
                        $("[name='sectionsDropdown']").append(newOption).trigger('change');
                    }
                }
            });
        });
    </script>
@endsection