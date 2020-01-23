@extends('layouts.app')

@section('content')

<div class="container">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{route('home')}}">Home</a></li>
            <li class="breadcrumb-item"><a href="{{route('proficiencies.index')}}">Proficiency</a></li>
            <li class="breadcrumb-item active" aria-current="page">Create Proficiency</li>
        </ol>
    </nav>
            
    <div class="row justify-content-center">
        <div class="col-md-12">
            <h1>Create A Proficiency</h1>
        </div>
    </div>
    {{  Form::open(array('action' => 'ProficiencyController@store'))}}
    <div class="row">
        <div class="col-md-12">
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
            <div class="form-group form-floating-label">
                
                <br>
                <button class=" btn btn-warning" type="reset" value="RESET">Reset</button>
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
            $('.dropdown-competency').select2();
        }); 
        $(document).ready(function() {
            $('.dropdown-level').select2();
        }); 
    </script>
@endsection