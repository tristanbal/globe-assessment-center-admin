@extends('layouts.app')

@section('content')

<div class="container">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{route('home')}}">Home</a></li>
            <li class="breadcrumb-item"><a href="{{route('listOfCompetenciesPerRoles.index')}}">Model</a></li>
            <li class="breadcrumb-item active" aria-current="page">{{$group->name}} - {{$role->name}} Edit</li>
        </ol>
    </nav>
            
    <div class="row justify-content-center">
        <div class="col-md-12">
            <h1>{{$group->name}} - {{$role->name}}</h1>
            <!-- Button trigger modal -->
            <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#exampleModal">
                Add Competency
            </button>
            <br><br>
            <div class="row">
                <div class="col-sm-12">
                    <h3 class="">Employees Assigned to {{$role->name}}</h3>
                    <hr>
                    <div class="table-responsive">
                        <table id="employee-datatables" class="display table table-striped table-hover" cellspacing="0" width="100%">
                            <thead>
                                <tr>
                                    <th>Competency</th>
                                    <th>Type</th>
                                    <th>Target Level</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($modelCompetencies as $item)
                                    <tr>
                                        <td>{{$item->competencyName}}</td>
                                        <td>{{$item->competencyTypeName}}</td>
                                        <td>{{$item->targetLevelWeight}} - {{$item->targetLevelName}} </td>
                                        <td>
                                                <div style = "display: flex;"> <a style = "float: left;" href = "model/view/{{$group->id}}/{{$role->id}}"><div class = "btn-info btn">VIEW</div></a>
                                                <a style = "float: right;" href = "model/edit/{{$group->id}}/{{$role->id}}"><div class = "btn-success btn">EDIT</div></a>
                                                <a style = "float: right;" href = "model/delete/{{$group->id}}/{{$role->id}}"><div class = "btn-danger btn">DELETE</div></a></div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Modal -->
            <div class="modal fade" id="exampleModal"  role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Add a Competency</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form action="{{route('listOfCompetenciesPerRoles.edit.add.competency',['groupID'=>$group->id,'roleID'=>$role->id])}}" method="get">
                            <div class="row">
                                <div class="col-md-12">
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
                                    <label>Select a Type:</label>
                                    <select id="test3" class="form-control dropdown-competency-type" name="competencyTypeID" style="width:100%;" required>
                                        @if(count($competencyType) > 0)
                                            <option value = "" disabled selected>Select a Competency Type</option>
                    
                                                @foreach($competencyType as $row)
                                                    <option value = "{{$row->id}}">{{$row->name}}</option>
                                                @endforeach
                                        @else
                                            <option value = "" disabled selected>No Competency Type found</option>
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
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                            <button class=" btn btn-warning" type="reset" value="RESET">Reset</button>
                            <button class=" btn btn-success " type="submit">Add</button>
                        </div>
                        
                            
                        </form>
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
            $('.dropdown-competency-type').select2();
        }); 
        $(document).ready(function() {
            $('.dropdown-level').select2();
        }); 
    </script>
    
    <script>
        $(document).ready(function() {
              $('#employee-datatables').DataTable();
        });
    </script>
@endsection