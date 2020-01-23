@extends('layouts.app')

@section('content')

<div class="container">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{route('home')}}">Home</a></li>
            <li class="breadcrumb-item"><a href="{{route('interventions.index')}}">Intervention</a></li>
            <li class="breadcrumb-item active" aria-current="page">Update Intervetnion</li>
        </ol>
    </nav>
            
    <div class="row justify-content-center">
        <div class="col-md-12">
            <h1>Update Intervention</h1>
        </div>
    </div>
    {{  Form::open(array('action' =>[ 'InterventionController@update',$intervention->id]))}}
    <div class="row">
        <div class="col-md-12">
            <div class="form-group ">
                <label>Group:</label>
                <select id="groupsDropdown" class="form-control group" name="groupsDropdown" style="width:100%;" required>
                    @if(count($group) > 0)
                        <option value = "" disabled selected>No Group found</option>

                        @foreach($group as $row)
                            <option value = "{{$row->id}}" 
                            
                            @if ($row->id == $intervention->groupID)
                            selected
                                
                            @endif

                            >{{$row->name}} </option>
                       
                        @endforeach
                    @else
                        <option value = "" disabled selected>No Group found</option>
                    @endif
                </select>
                <br><br>
                <label>Division:</label>
                <select id="divisionsDropdown" class="form-control division" name="divisionsDropdown" style="width:100%;" required>
                    @if(count($division) > 0)
                        <option value = "" disabled selected>No Division found</option>

                        @foreach($division as $row)
                            <option value = "{{$row->id}}" 
                            
                            @if ($row->id == $intervention->divisionID)
                            selected
                                
                            @endif

                            >{{$row->name}} </option>
                       
                        @endforeach
                    @else
                        <option value = "" disabled selected>No Division found</option>
                    @endif
                </select>
            </div>
            <div class="form-group ">
                <label>Select a Competency:</label>
                <select id="test1" class="form-control competency-dropdown" name="competencyID" style="width:100%;" required>
                    @if(count($competency) > 0)
                        <option value = "" disabled selected>No Competency found</option>

                        @foreach($competency as $row)
                            <option value = "{{$row->id}}" 
                            
                            @if ($row->id == $intervention->competencyID)
                            selected
                                
                            @endif

                            >{{$row->name}} </option>
                       
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
                        <option value = "" disabled selected>No Training found</option>

                        @foreach($training as $row)
                        <option value = "{{$row->id}}" 
                        
                        @if ($row->id == $intervention->trainingID)
                            selected
                            
                        @endif

                        >{{$row->name}} </option>
                        
                    @endforeach
                    @else
                        <option value = "" disabled selected>No Training found</option>
                    @endif
                </select>
            </div>
            <div class="form-group"> <br>
                <button class=" btn btn-warning" type="reset" value="RESET">Reset</button>
                <button class=" btn btn-success " type="submit">Update</button>
            </div>
        </div>
    </div>
    {{Form::hidden('_method', 'PUT')}}
    {{ Form::close() }}
</div>


@endsection

@section('scripts')
    <script>    
        $(document).ready(function() {
            $('.competency-dropdown').select2();
        }); 
        $(document).ready(function() {
            $('.training-dropdown').select2();
        }); 
        $(document).ready(function() {
            $('.group').select2();
        }); 
    $(document).ready(function() {
        $('.division').select2();
    }); 
    </script>
@endsection