@extends('layouts.app')

@section('content')

<div class="container">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{route('home')}}">Home</a></li>
            <li class="breadcrumb-item active" aria-current="page">Models</li>
        </ol>
    </nav>
            
    <div class="row ">
        <h1>Add Model</h1>
        <!-- Button trigger modal 
        <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#exampleModal">
            Add Model
        </button>-->
        <a href="{{route('listOfCompetenciesPerRoles.create')}}" class="btn btn-primary btn-sm">
            Add Model
        </a>
        <br><br>
        <div class="table-responsive">
            <table id="basic-datatables" class="display table table-striped table-hover" cellspacing="0" width="100%">
                <thead>
                    <tr>
                        <th>Group</th>
                        <th>Role</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($allModel as $allModelItem)
                        <tr>
                            <td>{{$allModelItem->groupName}}</td>
                            <td>{{$allModelItem->roleName}}</td>
                            <td>
                                <div style = "display: flex;"> <a style = "float: left;" href = "model/view/{{$allModelItem->groupID}}/{{$allModelItem->roleID}}"><div class = "btn-info btn">VIEW</div></a>
                                <a style = "float: right;" href = "model/edit/{{$allModelItem->groupID}}/{{$allModelItem->roleID}}"><div class = "btn-success btn">EDIT</div></a>
                                <a style = "float: right;" href = "model/delete/{{$allModelItem->groupID}}/{{$allModelItem->roleID}}"><div class = "btn-danger btn">DELETE</div></a></div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Modal -->
        <div class="modal fade" id="exampleModal"  role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Add a Model</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form action="{{route('listOfCompetenciesPerRole.create')}}" method="get">
                        <div class="row">
                            <div class="col-md-12">
                                <label>Select a Group:</label>
                                <select id="test3" class="form-control dropdown-competency-type" name="groupID" style="width:100%;" required>
                                    @if(count($group) > 0)
                                        <option value = "" disabled selected>Select a Group</option>
                                            @foreach($group as $row)
                                                <option value = "{{$row->id}}">{{$row->name}}</option>
                                            @endforeach
                                    @else
                                        <option value = "" disabled selected>No Group found</option>
                                    @endif
                                </select>
                                <label>Select a Level/Weight:</label>
                                <select id="test2" class="form-control dropdown-level" name="roleID" style="width:100%;" required>
                                    @if(count($role) > 0)
                                        <option value = "" disabled selected>Select a Role</option>
                                        @foreach($role as $row)
                                            <option value = "{{$row->id}}">{{$row->weight}} | {{$row->name}}</option>
                                        @endforeach
                                    @else
                                        <option value = "" disabled selected>No Role found</option>
                                    @endif
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                        <button class=" btn btn-success " type="submit">Add</button>
                    </div>
                    
                        
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>


@endsection

@section('scripts')
    <script>
        $(document).ready(function() {
            $('.dropdown-competency-type').select2();
        }); 
        $(document).ready(function() {
            $('.dropdown-level').select2();
        }); 
    </script>
    <script>
        $(document).ready(function() {
              $('#basic-datatables').DataTable();
        });
    </script>
@endsection