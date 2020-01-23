@extends('layouts.app')

@section('content')

<div class="container">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{route('home')}}">Home</a></li>
            <li class="breadcrumb-item active" aria-current="page">Division</li>
        </ol>
    </nav>
            
    <div class="row justify-content-center">
        <div class="col-md-12">
            <h1>Intervention</h1>
            <!-- Button trigger modal -->
            <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#exampleModal">
                Add Intervention
            </button>
            <br><br>
            <div class="table-responsive">
                <table id="intervention-datatables" class="display table table-striped table-hover" cellspacing="0" width="100%">
                    <thead>
                        <tr>
                            <th>Group</th>
                            <th>Division</th>    
                            <th>Competency</th>
                            <th>Training</th>
                            <th>Created At</th>
                            <th>Updated At</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($data as $item)
                            <tr>
                                <td>{{$item->groupName}}</td>
                                <td>{{$item->divisionName}}</td>
                                <td>{{$item->competencyName}}</td>
                                <td>{{$item->trainingName}}</td>
                                <td>{{$item->created_at}}</td>
                                <td>{{$item->updated_at}}</td>
                                <td>
                                       <div style = "display: flex;"> <a style = "float: left;" href = "intervention/view/{{$item->id}}"><div class = "btn-info btn">VIEW</div></a>
                                       <a style = "float: right;" href = "intervention/edit/{{$item->id}}"><div class = "btn-success btn">EDIT</div></a>
                                       <a style = "float: right;" href = "intervention/delete/{{$item->id}}"><div class = "btn-danger btn">DELETE</div></a></div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <br>
            
            <!-- Modal -->
            <div class="modal fade" id="exampleModal"  role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Add a division</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            {{  Form::open(array('action' => 'InterventionController@store'))}}
                            <div class="row">
                                <div class="col-md-12">
                                <div class="form-group ">
                                    <label>Group:</label>
                                    <select id="groupsDropdown" class="form-control group" name="groupsDropdown" style="width:100%;" required>
                                        @if(count($group) > 0)
                                            <option value = "" disabled selected>Select a Group</option>
                    
                                                @foreach($group as $row)
                                                    <option data-group = '{{$row->id}}' value = "{{$row->id}}">{{$row->name}}</option>
                                                @endforeach
                                        @else
                                            <option value = "" disabled selected>No Groups found</option>
                                        @endif
                                    </select>
                                    <br><br>
                                    <label>Division:</label>
                                    <select id="divisionsDropdown" class="form-control division" name="divisionsDropdown" style="width:100%;" required>
                                            <option value = "" disabled selected>Select a Group first</option>
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
        dropdownParent: $('#exampleModal')
        $('.competency-dropdown').select2();
    }); 
    $(document).ready(function() {
        dropdownParent: $('#exampleModal')
        $('.training-dropdown').select2();
    }); 
    $(document).ready(function() {
            $('.group').select2();
        }); 
    $(document).ready(function() {
        $('.division').select2();
    }); 
</script>


<script type="text/javascript">
/*
    $(document).ready(function() {
         $('#basic-datatables').DataTable({
            "processing": true,
            "serverSide": true,
            "ajax": "{{route('interventions.ajaxdata')}}",
            "columns":[
                { data: "id",name: "interventions.id" },
                { data: "competencyName",name: "competencies.name" },
                { data: "trainingName",name: "trainings.name" },
                { data: "created_at",name: "interventions.created_at"},
                { data: "updated_at",name: "interventions.updated_at"},
                { 
                    data: "id",                   
                    "render": function ( data, type, row ) {
                        var view  = '<div style = "display: flex;"> <a style = "float: left;" href = "intervention/view/'+ row.id +'"><div class = "btn-info btn">VIEW</div></a>';
                        var edit =  '<a style = "float: right;" href = "intervention/edit/'+ row.id +'"><div class = "btn-success btn">EDIT</div></a>';  
                        var del =  '<a style = "float: right;" href = "intervention/delete/'+ row.id +'"><div class = "btn-danger btn">DELETE</div></a></div>';   
                        return view +  edit + del;
                    }
                }
                
            ]
         });
    });*/
    $(document).ready(function() {
        $('#intervention-datatables').DataTable();
    });
    </script>

<script>
        $(document).ready(function(){
        
        var group = <?php echo json_encode($group) ?>;
        var division = <?php echo json_encode($division) ?>;
        
        $("[name='groupsDropdown']").change(function (e) {
            var selectedGroup = $(this).find(':selected').data('group');
             //  alert(selectedGroup);
        
            //    $("[name='divisionsDropdown'] [data-groupID = '" +selectedGroup + "']").show();
            //     $("[name='divisionsDropdown'] [data-groupID != '" +selectedGroup + "']").hide();
        
                // var value = $(this).val();
                // .hide()
            $("#divisionsDropdown").html('').select2();
        
        
            // Populate divisions dropdown
            for(var i = 0; i<division.length;i++){
                if(division[i].groupID == selectedGroup){
                    var newOption = new Option(division[i].name, division[i].id, false, false);
                    newOption.setAttribute("division",division[i].id);
                    $('#divisionsDropdown').append(newOption).trigger('change');
                }
            }
            });
        
        
            
            
        });
        
        
        
        
    </script>
@endsection