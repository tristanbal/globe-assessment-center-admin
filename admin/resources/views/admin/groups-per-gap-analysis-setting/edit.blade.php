@extends('layouts.app')

@section('content')

<div class="container">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{route('home')}}">Home</a></li>
            <li class="breadcrumb-item"><a href="{{route('groupsPerGapAnalysisSettings.index')}}">Group Per Gap Analysis Setting</a></li>
            <li class="breadcrumb-item active" aria-current="page">Create An Assignment</li>
        </ol>
    </nav>
            
    <div class="row justify-content-center">
        <div class="col-md-12">
            <h1>Create An Assignment for Group Per Gap Analysis Setting</h1>
        </div>
    </div>
    {{  Form::open(array('action' => 'GroupsPerGapAnalysisSettingController@update'))}}
    <div class="row">
        <div class="col-md-12">
            <div class="row">
                <div class="col-12 form-group form-floating-label">
                    <input id="inputFloatingLabel"  name="name" type="text" class="form-control input-border-bottom" required>
                    <label for="inputFloatingLabel" class="placeholder">Input a Name for your Group:</label>
                    <small id="emailHelp" class="form-text text-muted">Make sure that the name is unique.</small>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-12 form-group">
                    <label>Type of Group:</label>
                    <select id="selectionDropdown" class="form-control group" name="selectionDropdown" style="width:100%;" >
                        <option value = "" disabled selected>Select a Group</option>
                        <option data-group = '1' value = "1">Group</option>
                        <option data-group = '2' value = "2">Division</option>
                        <option data-group = '3' value = "3">Department</option>
                        <option data-group = '4' value = "4">Section</option>
                    </select>
                </div>
            </div>
            <div class="row" id="group-selected">
                <div class="col-sm-12 form-group">
                    <label>Group:</label>
                    <select id="groupsDropdown-1" class="form-control group" name="dataSelectedID1" style="width:100%;" >
                        @if(count($group) > 0)
                            <option value = "" disabled selected>Select a Group</option>
    
                                @foreach($group as $row)
                                    <option data-group = '{{$row->id}}' value = "{{$row->id}}">{{$row->name}}</option>
                                @endforeach
                        @else
                            <option value = "" disabled selected>No Groups found</option>
                        @endif
                    </select>
                </div>
            </div>
            <div class="row" id="division-selected">
                <div class="col-sm-6 form-group">
                    <label>Group:</label>
                    <select id="groupsDropdown-2" class="form-control group" name="groupsDropdown-2" style="width:100%;" >
                        @if(count($group) > 0)
                            <option value = "" disabled selected>Select a Group</option>
    
                                @foreach($group as $row)
                                    <option data-group = '{{$row->id}}' value = "{{$row->id}}">{{$row->name}}</option>
                                @endforeach
                        @else
                            <option value = "" disabled selected>No Groups found</option>
                        @endif
                    </select>
                </div>
                <div class="col-sm-6 form-group">
                    <label>Division:</label>
                    <select id="divisionsDropdown-2" class="form-control group" name="dataSelectedID2" style="width:100%;" >
                        <option value = "" disabled selected>Select a Group first</option>
                    </select>
                </div>
            </div>
            <div id="department-selected">
                <div class="row">
                    <div class="col-sm-6 form-group">
                        <label>Group:</label>
                        <select id="groupsDropdown-3" class="form-control group" name="groupsDropdown-3" style="width:100%;" >
                            @if(count($group) > 0)
                                <option value = "" disabled selected>Select a Group</option>
        
                                    @foreach($group as $row)
                                        <option data-group = '{{$row->id}}' value = "{{$row->id}}">{{$row->name}}</option>
                                    @endforeach
                            @else
                                <option value = "" disabled selected>No Groups found</option>
                            @endif
                        </select>
                    </div>
                    <div class="col-sm-6 form-group">
                        <label>Division:</label>
                        <select id="divisionsDropdown-3" class="form-control group" name="divisionsDropdown-3" style="width:100%;" >
                            <option value = "" disabled selected>Select a Group first</option>
                        </select>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-12 form-group">
                        <label>Department:</label>
                        <select id="departmentsDropdown-3" class="form-control group" name="dataSelectedID3" style="width:100%;" >
                            <option value = "" disabled selected>Select a Group first</option>
                        </select>
                    </div>
                </div>
            </div>
            
            <div id="section-selected">
                <div class="row">
                    <div class="col-sm-6 form-group">
                        <label>Group:</label>
                        <select id="groupsDropdown-4" class="form-control group" name="groupsDropdown-4" style="width:100%;" >
                            @if(count($group) > 0)
                                <option value = "" disabled selected>Select a Group</option>
        
                                    @foreach($group as $row)
                                        <option data-group = '{{$row->id}}' value = "{{$row->id}}">{{$row->name}}</option>
                                    @endforeach
                            @else
                                <option value = "" disabled selected>No Groups found</option>
                            @endif
                        </select>
                    </div>
                    <div class="col-sm-6 form-group">
                        <label>Division:</label>
                        <select id="divisionsDropdown-4" class="form-control group" name="divisionsDropdown-4" style="width:100%;" >
                            <option value = "" disabled selected>Select a Group first</option>
                        </select>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-6 form-group">
                        <label>Department:</label>
                        <select id="departmentsDropdown-4" class="form-control group" name="departmentsDropdown-4" style="width:100%;" >
                            <option value = "" disabled selected>Select a Group first</option>
                        </select>
                    </div>
                    <div class="col-sm-6 form-group">
                        <label>Section:</label>
                        <select id="sectionsDropdown-4" class="form-control group" name="dataSelectedID4" style="width:100%;" >
                            <option value = "" disabled selected>Select a Group first</option>
                        </select>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-sm-12 form-group">
                    <label>Gap Analysis Setting:</label>
                    <select id="settingDropdown" class="form-control group" name="settingDropdown" style="width:100%;" >
                        @if(count($gapAnalysisSetting) > 0)
                            <option value = "" disabled selected>Select a Gap Analysis Setting</option>
    
                                @foreach($gapAnalysisSetting as $row)
                                    <option data-group = '{{$row->id}}' value = "{{$row->id}}">{{$row->name}} | {{$row->description}} </option>
                                @endforeach
                        @else
                            <option value = "" disabled selected>No Gap Analysis Setting found</option>
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
            $('#selectionDropdown').select2();
        }); 
        $(document).ready(function() {
            $('#groupsDropdown-1').select2();
        }); 
        $(document).ready(function() {
            $('#groupsDropdown-2').select2();
        }); 
        $(document).ready(function() {
            $('#divisionsDropdown-2').select2();
        });
        $(document).ready(function() {
            $('#groupsDropdown-3').select2();
        }); 
        $(document).ready(function() {
            $('#divisionsDropdown-3').select2();
        });
        $(document).ready(function() {
            $('#departmentsDropdown-3').select2();
        });
        $(document).ready(function() {
            $('#groupsDropdown-4').select2();
        }); 
        $(document).ready(function() {
            $('#divisionsDropdown-4').select2();
        });
        $(document).ready(function() {
            $('#departmentsDropdown-4').select2();
        });
        $(document).ready(function() {
            $('#sectionsDropdown-4').select2();
        });
        $(document).ready(function() {
            $('#settingDropdown').select2();
        });
    </script>

    <script>
    $(document).ready(function() {
        $("#division-selected").hide();
        $("#department-selected").hide();
        $("#section-selected").hide();
        $('#selectionDropdown').on('change', function() {
            if($('#selectionDropdown').val()=="1") {
                $("#group-selected").show();
                $("#division-selected").hide();
                $("#department-selected").hide();
                $("#section-selected").hide();
            }
            if($('#selectionDropdown').val()=="2") {
                $("#division-selected").show();
                $("#group-selected").hide();
                $("#department-selected").hide();
                $("#section-selected").hide();
            }
            if($('#selectionDropdown').val()=="3") {
                $("#department-selected").show();
                $("#division-selected").hide();
                $("#group-selected").hide();
                $("#section-selected").hide();
            }
            if($('#selectionDropdown').val()=="4") {
                $("#section-selected").show();
                $("#group-selected").hide();
                $("#department-selected").hide();
                $("#division-selected").hide();
            }
        });
    });
</script>

<script>
    $(document).ready(function(){
    
    var group = <?php echo json_encode($group) ?>;
    var department = <?php echo json_encode($department) ?>;
    var section = <?php echo json_encode($section) ?>;
    var division = <?php echo json_encode($division) ?>;
    
    //first dropdown

    $("[name='groupsDropdown-2']").change(function (e) {
        var selectedGroup = $(this).find(':selected').data('group');
            //alert(selectedGroup);
    
        //    $("[name='divisionsDropdown'] [data-groupID = '" +selectedGroup + "']").show();
        //     $("[name='divisionsDropdown'] [data-groupID != '" +selectedGroup + "']").hide();
    
            // var value = $(this).val();
            // .hide()
        $("#divisionsDropdown-2").html('').select2();
    
    
        // Populate divisions dropdown
        for(var i = 0; i<division.length;i++){
            if(division[i].groupID == selectedGroup){
                var newOption = new Option(division[i].name, division[i].id, false, false);
                newOption.setAttribute("division",division[i].id);
                $('#divisionsDropdown-2').append(newOption).trigger('change');
            }
        }
    });
    
    // second dropdown
    $("[name='groupsDropdown-3']").change(function (e) {
        var selectedGroup = $(this).find(':selected').data('group');
            //alert(selectedGroup);
    
        //    $("[name='divisionsDropdown'] [data-groupID = '" +selectedGroup + "']").show();
        //     $("[name='divisionsDropdown'] [data-groupID != '" +selectedGroup + "']").hide();
    
            // var value = $(this).val();
            // .hide()
        $("#divisionsDropdown-3").html('').select2();
    
    
        // Populate divisions dropdown
        for(var i = 0; i<division.length;i++){
            if(division[i].groupID == selectedGroup){
                var newOption = new Option(division[i].name, division[i].id, false, false);
                newOption.setAttribute("division",division[i].id);
                $('#divisionsDropdown-3').append(newOption).trigger('change');
            }
        }
    });
    
    
    $('#divisionsDropdown-3').change(function (e) {
        var selectedGroup = $("[name='groupsDropdown-3']").find(':selected').data('group');
        var selectedDivision = $(this).find(':selected').val();

        // Clear Departments Dropdown
        $('#divisionsDropdown-3').html('').select2();
        // Populate Departments dropdown
        for(var i = 0; i<department.length;i++){
            if(department[i].groupID == selectedGroup && department[i].divisionID == selectedDivision){
                var newOption = new Option(department[i].name, department[i].id, false, false);
                $('#divisionsDropdown-3').append(newOption).trigger('change');
            }
        }
    });
    // third dropdown
    $("[name='groupsDropdown-4']").change(function (e) {
        var selectedGroup = $(this).find(':selected').data('group');
            //alert(selectedGroup);
    
        //    $("[name='divisionsDropdown'] [data-groupID = '" +selectedGroup + "']").show();
        //     $("[name='divisionsDropdown'] [data-groupID != '" +selectedGroup + "']").hide();
    
            // var value = $(this).val();
            // .hide()
        $("#divisionsDropdown-4").html('').select2();
    
    
        // Populate divisions dropdown
        for(var i = 0; i<division.length;i++){
            if(division[i].groupID == selectedGroup){
                var newOption = new Option(division[i].name, division[i].id, false, false);
                newOption.setAttribute("division",division[i].id);
                $('#divisionsDropdown-4').append(newOption).trigger('change');
            }
        }
    });
    
    
    $("[name='divisionsDropdown-4']").change(function (e) {
        var selectedGroup = $("[name='groupsDropdown-4']").find(':selected').data('group');
        var selectedDivision = $(this).find(':selected').val();

        // Clear Departments Dropdown
        $("[name='departmentsDropdown-4']").html('').select2();
        // Populate Departments dropdown
        for(var i = 0; i<department.length;i++){
            if(department[i].groupID == selectedGroup && department[i].divisionID == selectedDivision){
                var newOption = new Option(department[i].name, department[i].id, false, false);
                $("[name='departmentsDropdown-4']").append(newOption).trigger('change');
            }
        }
    });
        
        $("[name='departmentsDropdown-4']").change(function (e) {
            var selectedGroup = $("[name='groupsDropdown-4']").find(':selected').data('group');
            var selectedDivision = $("[name='divisionsDropdown-4']").find(':selected').val();
            var selectedDepartment = $("[name='departmentsDropdown-4']").find(':selected').val();
    
            // Clear sections Dropdown
            $('#sectionsDropdown-4').html('').select2();
            // Populate sections dropdown
            for(var i = 0; i<section.length;i++){
                if(section[i].groupID == selectedGroup && section[i].divisionID == selectedDivision && section[i].departmentID == selectedDepartment){
                    var newOption = new Option(section[i].name, section[i].id, false, false);
                    $('#sectionsDropdown-4').append(newOption).trigger('change');
                }
            }
        });
        
    });
    
    

    
</script>
@endsection