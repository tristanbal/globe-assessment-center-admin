@extends('layouts.app')

@section('content')

<div class="container">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{route('home')}}">Home</a></li>
            <li class="breadcrumb-item"><a href="{{route('competencyRoleTargets.index')}}">Competency-Role Target</a></li>
            <li class="breadcrumb-item active" aria-current="page">Create Competency-Role Target</li>
        </ol>
    </nav>
            
    <div class="row justify-content-center">
        <div class="col-md-12">
            <h1>Create A Competency-Role Target</h1>
        </div>
    </div>
    {{  Form::open(array('action' => ['CompetencyPerRoleTargetController@update',$competencyPerRoleTarget->id]))}}
        <div class="row">
            <div class="col-sm-6">
                <div class="form-group ">
                    <label>Select a Role:</label>
                    <select id="test1" class="form-control dropdown-role" name="roleID" style="width:100%;" required>
                        @if(count($role) > 0)
                            <option value = "" disabled selected>Select a Role</option>

                                @foreach($role as $row)
                                    <option value = "{{$row->id}}"
                                        
                                        @if ($row->id == $competencyPerRoleTarget->roleID)
                                            selected
                                            
                                        @endif
                                        >{{$row->name}}</option>
                                @endforeach
                        @else
                            <option value = "" disabled selected>No role found</option>
                        @endif
                    </select>
                </div>
            </div>
            <div class="col-sm-6">
                <div class="form-group ">
                    <label>Select a Competency:</label>
                    <select id="competency" class="form-control dropdown-competency" name="competencyID" style="width:100%;" required>
                        @if(count($competency) > 0)
                            <option value = "" disabled selected>Select a Role first</option>
    
                            @foreach($competency as $row)
                            <option value = "{{$row->id}}" 
                            @if ($row->id == $competencyPerRoleTarget->competencyID)
                                selected
                            @endif
                            >{{$row->name}} </option>
                            @endforeach
                        @else
                            <option value = "" disabled selected>No Role found</option>
                        @endif
                    </select>
                </div>
                
            </div>
        </div>
        <div class="row">
            <div class="col-sm-6">
                <div class="form-group ">
                    <label>Select a Target Level:</label>
                    <select id="test3" class="form-control dropdown-level" name="targetLevelID" style="width:100%;" required>
                        @if(count($level) > 0)
                            <option value = "" disabled selected>Select a Target Level</option>

                                @foreach($level as $row)
                                    <option value = "{{$row->id}}"
                                        @if ($row->id == $competencyPerRoleTarget->competencyTargetID)
                                            selected
                                        @endif
                                        >{{$row->weight}} | {{$row->name}}</option>
                                @endforeach
                        @else
                            <option value = "" disabled selected>No Target Level found</option>
                        @endif
                    </select>
                </div>
            </div>
            <div class="col-sm-6">
                <div class="form-group ">
                    <label>Select a Source:</label>
                    <select id="test4" class="form-control dropdown-target-source" name="targetSourceID" style="width:100%;" required>
                        @if(count($targetSource) > 0)
                            <option value = "" disabled selected>Select a Source</option>

                                @foreach($targetSource as $row)
                                    <option value = "{{$row->id}}"
                                        @if ($row->id == $competencyPerRoleTarget->sourceID)
                                            selected
                                        @endif>{{$row->name}}</option>
                                @endforeach
                        @else
                            <option value = "" disabled selected>No Competency found</option>
                        @endif
                    </select>
                </div>
            </div>
        </div>
        <button class=" btn btn-success " type="submit">Edit</button>
        {{Form::hidden('_method', 'PUT')}}
    {{ Form::close() }}
</div>


@endsection

@section('scripts')
<script>
    $(document).ready(function() {
        $('.dropdown-role').select2();
    }); 
    $(document).ready(function() {
        $('.dropdown-competency').select2();
    }); 
    $(document).ready(function() {
        $('.dropdown-level').select2();
    }); 
    $(document).ready(function() {
        $('.dropdown-target-source').select2();
    }); 
</script>


<script>
        $(document).ready(function(){
        
        var role = <?php echo  json_encode($role) ?>;
        var model = <?php echo json_encode($model) ?>;
        var competency = <?php echo json_encode($competency) ?>;

        //alert(model);
        $("[name='roleID']").change(function (e) {
            var selectedRole = $(this).find(':selected').val();
            // alert(selectedRole);
        
            //    $("[name='divisionsDropdown'] [data-groupID = '" +selectedGroup + "']").show();
            //     $("[name='divisionsDropdown'] [data-groupID != '" +selectedGroup + "']").hide();
        
                // var value = $(this).val();
                // .hide()
            $("#competency").html('').select2();
        
        
            // Populate subcluster dropdown
            for(var i = 0; i<model.length;i++){
                //
                for ( var j = 0; j<competency.length;j++){
                    if(model[i].roleID == selectedRole && model[i].competencyID == competency[j].id){
                    // /alert(model[i].roleID);
                    var newOption = new Option(competency[j].name, model[i].competencyID, false, false);
                    newOption.setAttribute("model",model[i].competencyID);
                    $('#competency').append(newOption).trigger('change');
                }
                }
                
            }
            });
        
        });
        
        
        
        
    </script>
@endsection