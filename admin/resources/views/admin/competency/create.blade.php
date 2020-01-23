@extends('layouts.app')

@section('content')

<div class="container">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{route('home')}}">Home</a></li>
            <li class="breadcrumb-item"><a href="{{route('competencies.index')}}">Competency</a></li>
            <li class="breadcrumb-item active" aria-current="page">Create Competency</li>
        </ol>
    </nav>
            
    <div class="row justify-content-center">
        <div class="col-md-12">
            <h1>Create A Competency</h1>
        </div>
    </div>
    {{  Form::open(array('action' => 'CompetencyController@store'))}}
        <div class="row">
            <div class="col-md-12">
                <div class="form-group form-floating-label">
                    <input id="inputFloatingLabel" name="name" type="text" class="form-control input-border-bottom" required>
                    <label for="inputFloatingLabel" class="placeholder">Input New Competency Name</label>
                    <small id="emailHelp" class="form-text text-muted">Make sure that the name is unique.</small>
                </div>
                <div class="row">
                    <div class="col-sm-6">
                        <div class="form-group ">
                            <label>Select a Subcluster:</label>
                            <select id="test1" class="form-control dropdown-subcluster" name="subclusterID" style="width:100%;" required>
                                @if(count($subcluster) > 0)
                                    <option value = "" disabled selected>Select a Sub-Cluster</option>
            
                                        @foreach($subcluster as $row)
                                            <option value = "{{$row->id}}">{{$row->name}}</option>
                                        @endforeach
                                @else
                                    <option value = "" disabled selected>No Sub-Cluster found</option>
                                @endif
                            </select>
                        </div>
                    </div>
                    <div class="col-sm-6">
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
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-6">
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
                    </div>
                    <div class="col-sm-6">
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
                    </div>
                </div>
                <div class="form-group input-group"><br>
                    <div class="input-group-prepend">
                        <span class="input-group-text">Set Definition</span>
                    </div>
                    <textarea class="form-control" aria-label="With textarea" name="definition"></textarea>
                </div>
                <div class="form-group form-floating-label">
                    <a href="{{route('competencies.index')}}" class="btn btn-danger" data-dismiss="modal">Cancel</a>
                    <button class=" btn btn-success " type="submit">Add</button>
                </div>
                
            </div>
        </div>
    {{ Form::close() }}
</div>


@endsection

@section('scripts')
<script>
    $(document).ready(function() {
        $('.dropdown-subcluster').select2();
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
@endsection