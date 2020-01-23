@extends('layouts.app')

@section('content')

<div class="container">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{route('home')}}">Home</a></li>
            <li class="breadcrumb-item active" aria-current="page">Level</li>
        </ol>
    </nav>
            
    <div class="row justify-content-center">
        <div class="col-md-12">
            <h1>Level</h1>
            <!-- Button trigger modal -->
            <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#exampleModal">
                Add Level
            </button>
            <br><br>
            <div class="table-responsive">
                <table id="basic-datatables" class="display table table-striped table-hover" cellspacing="0" width="100%">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Weight</th>
                            <th>Definition</th>
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
            <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Add a level</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            {{  Form::open(array('action' => 'LevelController@store'))}}
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group form-floating-label">
                                        <input id="inputFloatingLabel" name="name" type="text" class="form-control input-border-bottom" required>
                                        <label for="inputFloatingLabel" class="placeholder">Input Name</label>
                                        <small id="emailHelp" class="form-text text-muted">Make sure that the name is unique.</small>
                                    </div>
                                    <div class="form-group form-floating-label">
                                        <input id="inputFloatingLabel" name="weight" type="text" class="form-control input-border-bottom" required>
                                        <label for="inputFloatingLabel" class="placeholder">Input Weight</label>
                                        <small id="emailHelp" class="form-text text-muted">Make sure that the value inputted is a number.</small>
                                    </div>
                                    <div class="input-group">
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
<script type="text/javascript">
    $(document).ready(function() {
         $('#basic-datatables').DataTable({
            "processing": true,
            "serverSide": true,
            "ajax": "{{route('levels.ajaxdata')}}",
            "columns":[
                { data: "name"},
                { data: "weight"},
                { data: "definition"},
                { data: "created_at"},
                { data: "updated_at"},
                { 
                    data: "id",                   
                    "render": function ( data, type, row ) {
                        var view  = '<div style = "display: flex;"> <a style = "float: left;" href = "level/view/'+ row.id +'"><div class = "btn-info btn">VIEW</div></a>';
                        var edit =  '<a style = "float: right;" href = "level/edit/'+ row.id +'"><div class = "btn-success btn">EDIT</div></a>';  
                        var del =  '<a style = "float: right;" href = "level/delete/'+ row.id +'"><div class = "btn-danger btn">DELETE</div></a></div>';   
                        return view +  edit + del;
                    }
                }
                
            ]
         });
    });
    </script>
@endsection