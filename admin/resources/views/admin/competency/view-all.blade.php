@extends('layouts.app')

@section('content')

<div class="container">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{route('home')}}">Home</a></li>
            <li class="breadcrumb-item active" aria-current="page">Competency</li>
        </ol>
    </nav>
            
    <div class="row justify-content-center">
        <div class="col-md-12">
            <h1>Competency</h1>
            <!-- Button trigger modal -->
            <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#exampleModal">
                Add Competency
            </button>
            <br><br>
            <div class="table-responsive">
                <table id="basic-datatables" class="display table table-striped table-hover" cellspacing="0" width="100%">
                    <thead>
                        <tr>
                            <th>Name</th>
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
            <div class="modal fade" id="exampleModal" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Add a Competency</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            {{  Form::open(array('action' => 'CompetencyController@store'))}}
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group form-floating-label">
                                        <input id="inputFloatingLabel" name="name" type="text" class="form-control input-border-bottom" required>
                                        <label for="inputFloatingLabel" class="placeholder">Input New Competency Name</label>
                                        <small id="emailHelp" class="form-text text-muted">Make sure that the name is unique.</small>
                                    </div>
                                    <div class="form-group">
                                        <label>Cluster:</label>
                                        <select id="clusterDropdown" class="form-control clusterDropdown" name="clusterDropdown" style="width:100%;" required>
                                            @if(count($cluster) > 0)
                                                <option value = "" disabled selected>Select a Cluster</option>
                        
                                                    @foreach($cluster as $row)
                                                        <option data-group = '{{$row->id}}' value = "{{$row->id}}">{{$row->name}}</option>
                                                    @endforeach
                                            @else
                                                <option value = "" disabled selected>No Cluster found</option>
                                            @endif
                                        </select>
                                        <br>
                                    </div>
                                    
                                    <div class="form-group ">
                                        <label>Select a Subcluster:</label>
                                        <select id="subclustersDropdown" class="form-control subclustersDropdown" name="subclusterID" style="width:100%;" required>
                                                <option value = "" disabled selected>Select a Cluster first</option>
                                        </select>
                                    </div>
                                    <div class="form-group ">
                                        <label>Select a Talent Segment:</label>
                                        <select id="test4" class="form-control dropdown-talent" name="talentSegmentID" style="width:100%;" required>
                                            @if(count($talentSegment) > 0)
                                                <option value = "" disabled selected>Select a Talent Segment</option>
                        
                                                    @foreach($talentSegment as $row)
                                                        <option value = "{{$row->id}}">{{$row->name}}</option>
                                                    @endforeach
                                            @else
                                                <option value = "" disabled selected>No Talent Segment found</option>
                                            @endif
                                        </select>
                                    </div>
                                    <div class="form-group ">
                                        <label>Select a Minimum Level:</label>
                                        <select id="test2" class="form-control dropdown-minimum" name="minimumLevelID" style="width:100%;" required>
                                            @if(count($level) > 0)
                                                <option value = "" disabled selected>Select a Minimum Level</option>
                        
                                                    @foreach($level as $row)
                                                        <option value = "{{$row->id}}">{{$row->weight}} | {{$row->name}}</option>
                                                    @endforeach
                                            @else
                                                <option value = "" disabled selected>No Minimum Level found</option>
                                            @endif
                                        </select>
                                    </div>
                                    <div class="form-group ">
                                        <label>Select a Maximum Level:</label>
                                        <select id="test3" class="form-control dropdown-maximum" name="maximumLevelID" style="width:100%;" required>
                                            @if(count($level) > 0)
                                                <option value = "" disabled selected>Select a Maximum Level</option>
                        
                                                    @foreach($level as $row)
                                                        <option value = "{{$row->id}}">{{$row->weight}} | {{$row->name}}</option>
                                                    @endforeach
                                            @else
                                                <option value = "" disabled selected>No Maximum Level found</option>
                                            @endif
                                        </select>
                                    </div>
                                    <div class="form-group input-group"><br>
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">Set Definition</span>
                                        </div>
                                        <textarea class="form-control" aria-label="With textarea" name="definition"></textarea>
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
        $('.clusterDropdown').select2();
    }); 
    $(document).ready(function() {
        $('.subclustersDropdown').select2();
    }); 
    $(document).ready(function() {
        $('.dropdown-minimum').select2();
    }); 
    $(document).ready(function() {
        $('.dropdown-maximum').select2();
    }); 
    $(document).ready(function() {
        $('.dropdown-talent').select2();
    }); 
</script>

<script type="text/javascript">
    $(document).ready(function() {
         $('#basic-datatables').DataTable({
            "processing": true,
            "serverSide": true,
            "ajax": "{{route('competencies.ajaxdata')}}",
            "columns":[
                { data: "name"},
                { data: "created_at"},
                { data: "updated_at"},
                { 
                    data: "id",                   
                    "render": function ( data, type, row ) {
                        var view  = '<div style = "display: flex;"> <a style = "float: left;" href = "competency/view/'+ row.id +'"><div class = "btn-info btn">VIEW</div></a>';
                        var edit =  '<a style = "float: right;" href = "competency/edit/'+ row.id +'"><div class = "btn-success btn">EDIT</div></a>';  
                        var del =  '<a style = "float: right;" href = "competency/delete/'+ row.id +'"><div class = "btn-danger btn">DELETE</div></a></div>';   
                        return view +  edit + del;
                    }
                }
                
            ]
         });
    });
    </script>

    <script>
        $(document).ready(function(){
        
        var cluster = <?php echo  json_encode($cluster) ?>;
        var subcluster = <?php echo json_encode($subcluster) ?>;
        //alert(cluster);
        $("[name='clusterDropdown']").change(function (e) {
            var selectedCluster = $(this).find(':selected').val();
             //  alert(selectedCluster);
        
            //    $("[name='divisionsDropdown'] [data-groupID = '" +selectedGroup + "']").show();
            //     $("[name='divisionsDropdown'] [data-groupID != '" +selectedGroup + "']").hide();
        
                // var value = $(this).val();
                // .hide()
            $("#subclustersDropdown").html('').select2();
        
        
            // Populate subcluster dropdown
            for(var i = 0; i<subcluster.length;i++){
                if(subcluster[i].clusterID == selectedCluster){
                    var newOption = new Option(subcluster[i].name, subcluster[i].id, false, false);
                    newOption.setAttribute("subcluster",subcluster[i].id);
                    $('#subclustersDropdown').append(newOption).trigger('change');
                }
            }
            });
        
        });
        
        
        
        
    </script>
@endsection