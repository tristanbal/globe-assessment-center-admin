@extends('layouts.app')

@section('content')

<div class="container">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{route('home')}}">Home</a></li>
            <li class="breadcrumb-item active" aria-current="page">Proficiency</li>
        </ol>
    </nav>
            
    <div class="row justify-content-center">
        <div class="col-md-12">
            <h1>Proficiency</h1>
            <!-- Button trigger modal -->
            <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#exampleModal">
                Add Proficiency
            </button>
            <br><br>
            <div class="table-responsive">
                <table id="basic-datatables" class="display table table-striped table-hover" cellspacing="0" width="100%">
                    <thead>
                        <tr>
                            <th>Competency</th>
                            <th>Proficiency Level ID</th>
                            <th>Proficiency Definition</th>
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
            
            <!-- Modal -->
            <div class="modal fade" id="exampleModal"  role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Add a Proficiency</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            {{  Form::open(array('action' => 'ProficiencyController@store'))}}
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group ">
                                        <label>Select a Competency:</label>
                                        <select id="test1" class="form-control dropdown-competency" name="competencyID" style="width:100%;" required>
                                            @if(count($competency) > 0)
                                                <option value = "" disabled selected>Select a Competency</option>
                        
                                                    @foreach($competency as $row)
                                                        <option value = "{{$row->id}}">{{$row->name}}</option>
                                                    @endforeach
                                            @else
                                                <option value = "" disabled selected>No Competency found</option>
                                            @endif
                                        </select>

                                        <label>Select a Level/Weight:</label>
                                        <select id="test2" class="form-control dropdown-level" name="levelID" style="width:100%;" required>
                                            @if(count($level) > 0)
                                                <option value = "" disabled selected>Select a Level</option>
                        
                                                    @foreach($level as $row)
                                                        <option value = "{{$row->id}}">{{$row->weight}} | {{$row->name}}</option>
                                                    @endforeach
                                            @else
                                                <option value = "" disabled selected>No Level found</option>
                                            @endif
                                        </select>
                                    </div>
                                    <div class="form-group input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">Set Definition</span>
                                        </div>
                                        <textarea class="form-control" aria-label="With textarea" name="definition"></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
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
        $('.dropdown-competency').select2();
    }); 
    $(document).ready(function() {
        $('.dropdown-level').select2();
    }); 
</script>


<script type="text/javascript">
    $(document).ready(function() {
         $('#basic-datatables').DataTable({
            "processing": true,
            "serverSide": true,
            "ajax": "{{route('proficiencies.ajaxdata')}}",
            "columns":[
                { data: "competencyName",name: "competencies.name" },
                { data: "levelID",name: "proficiencies.levelID" },
                { data: "definition",name: "proficiencies.definition" },
                { data: "created_at",name: "proficiencies.created_at"},
                { data: "updated_at",name: "proficiencies.updated_at"},
                { 
                    data: "id",                   
                    "render": function ( data, type, row ) {
                        var view  = '<div style = "display: flex;"> <a style = "float: left;" href = "proficiency/view/'+ row.id +'"><div class = "btn-info btn">VIEW</div></a>';
                        var edit =  '<a style = "float: right;" href = "proficiency/edit/'+ row.id +'"><div class = "btn-success btn">EDIT</div></a>';  
                        var del =  '<a style = "float: right;" href = "proficiency/delete/'+ row.id +'"><div class = "btn-danger btn">DELETE</div></a></div>';   
                        return view +  edit + del;
                    }
                }
                
            ]
         });
    });
    </script>
@endsection