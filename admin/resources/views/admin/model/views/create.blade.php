@extends('layouts.app')

@section('content')

<div class="container">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{route('home')}}">Home</a></li>
            <li class="breadcrumb-item"><a href="{{route('listOfCompetenciesPerRoles.index')}}">Model</a></li>
            <li class="breadcrumb-item active" aria-current="page">Create Model</li>
        </ol>
    </nav>
            
    <div class="row justify-content-center">
        <div class="col-md-12">
            <h1>Create Model</h1>

            {{  Form::open(array('action' => 'ListOfCompetenciesPerRoleController@store'))}}
                <div class="row">
                    <div class="col-sm-6">
                        <label>Select a Group:</label>
                        <select id="test1" class="form-control dropdown-group" name="groupID" style="width:100%;" required>
                            @if(count($group) > 0)
                                <option value = "" disabled selected>Select a Group</option>
                                    @foreach($group as $row)
                                        <option value = "{{$row->id}}">{{$row->name}}</option>
                                    @endforeach
                            @else
                                <option value = "" disabled selected>No Group found</option>
                            @endif
                        </select>
                    </div>
                    <div class="col-sm-6">
                        <label>Select a Role:</label>
                        <select id="test2" class="form-control dropdown-role" name="roleID" style="width:100%;" required>
                            @if(count($role) > 0)
                                <option value = "" disabled selected>Select a Role</option>
                                @foreach($role as $row)
                                    <option value = "{{$row->id}}">{{$row->name}}</option>
                                @endforeach
                            @else
                                <option value = "" disabled selected>No Role found</option>
                            @endif
                        </select>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <label>Select a Competency:</label>
                        <select id="test3" class="form-control dropdown-competency" name="competencyID" style="width:100%;" required>
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
                </div>
                <div class="row">
                    <div class="col-sm-6">
                        <label>Select a Type:</label>
                        <select id="test5" class="form-control dropdown-competency-type" name="typeID" style="width:100%;" required>
                            @if(count($competencyType) > 0)
                                <option value = "" disabled selected>Select a Type</option>
                                    @foreach($competencyType as $row)
                                        <option value = "{{$row->id}}">{{$row->name}}</option>
                                    @endforeach
                            @else
                                <option value = "" disabled selected>No Type found</option>
                            @endif
                        </select>
                    </div>
                    <div class="col-sm-6">
                        <label>Select a Level / Weight:</label>
                        <select id="test6" class="form-control dropdown-level" name="levelID" style="width:100%;" required>
                            @if(count($level) > 0)
                                <option value = "" disabled selected>Select a Level / Weight</option>
                                @foreach($level as $row)
                                    <option value = "{{$row->id}}">{{$row->weight}} | {{$row->name}}</option>
                                @endforeach
                            @else
                                <option value = "" disabled selected>No Level found</option>
                            @endif
                        </select>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-12">
                        <br>
                        <button type="submit" class=" btn btn-success ">Submit</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>


@endsection

@section('scripts')
    <script>
        $(document).ready(function() {
            $('.dropdown-group').select2();
        }); 
        $(document).ready(function() {
            $('.dropdown-role').select2();
        }); 
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