@extends('layouts.app')

@section('content')

<div class="container">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{route('home')}}">Home</a></li>
            <li class="breadcrumb-item active" aria-current="page">Sub-Cluster</li>
        </ol>
    </nav>
            
    <div class="row justify-content-center">
        <div class="col-md-12">
            <h1>Sub-Cluster</h1>
            <!-- Button trigger modal -->
            <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#exampleModal">
                Add Sub-Cluster
            </button>
            <br><br>
            <div class="table-responsive">
                <table id="basic-datatables" class="display table table-striped table-hover" cellspacing="0" width="100%">
                    <thead>
                        <tr>
                            <th>Sub-Cluster Name</th>
                            <th>Cluster</th>
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
                            <h5 class="modal-title" id="exampleModalLabel">Add a division</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            {{  Form::open(array('action' => 'SubclusterController@store'))}}
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group form-floating-label">
                                        <input id="inputFloatingLabel" name="name" type="text" class="form-control input-border-bottom" required>
                                        <label for="inputFloatingLabel" class="placeholder">Input New Sub-Cluster Name</label>
                                        <small id="emailHelp" class="form-text text-muted">Make sure that the name is unique.</small>
                                    </div>
                                    <div class="form-group ">
                                        <label>Select a Cluster:</label>
                                        <select id="test" class="form-control js-example-basic-single" name="clusterID" style="width:100%;" required>
                                            @if(count($cluster) > 0)
                                                <option value = "" disabled selected>Select a Cluster</option>
                        
                                                    @foreach($cluster as $row)
                                                        <option value = "{{$row->id}}">{{$row->name}}</option>
                                                    @endforeach
                                            @else
                                                <option value = "" disabled selected>No Cluster found</option>
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
        $('.js-example-basic-single').select2();
    }); 
</script>
    
<script type="text/javascript">
    $(document).ready(function() {
         $('#basic-datatables').DataTable({
            "processing": true,
            "serverSide": true,
            "ajax": "{{route('subclusters.ajaxdata')}}",
            "columns":[
                { data: "subclusterName",name: "subclusters.name" },
                { data: "clusterName",name: "clusters.name" },
                { data: "created_at",name: "subclusters.created_at"},
                { data: "updated_at",name: "subclusters.updated_at"},
                { 
                    data: "id",                   
                    "render": function ( data, type, row ) {
                        var view  = '<div style = "display: flex;"> <a style = "float: left;" href = "subcluster/view/'+ row.id +'"><div class = "btn-info btn">VIEW</div></a>';
                        var edit =  '<a style = "float: right;" href = "subcluster/edit/'+ row.id +'"><div class = "btn-success btn">EDIT</div></a>';  
                        var del =  '<a style = "float: right;" href = "subcluster/delete/'+ row.id +'"><div class = "btn-danger btn">DELETE</div></a></div>';   
                        return view +  edit + del;
                    }
                }
                
            ]
         });
    });
    </script>
@endsection