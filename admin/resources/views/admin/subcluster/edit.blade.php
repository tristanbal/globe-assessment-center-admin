@extends('layouts.app')

@section('content')

<div class="container">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{route('home')}}">Home</a></li>
            <li class="breadcrumb-item"><a href="{{route('subclusters.index')}}">Sub-Cluster</a></li>
            <li class="breadcrumb-item active" aria-current="page">{{$subcluster->name}}</li>
        </ol>
    </nav>
            
    <div class="row justify-content-center">
        <div class="col-md-12">
            <h1>Update Sub-Cluster</h1>
        </div>
    </div>
    {{  Form::open(array('action' =>[ 'SubclusterController@update',$subcluster->id]))}}
    <div class="row">
        <div class="col-md-12">
            <div class="form-group form-floating-label">
                    <input id="inputFloatingLabel" name="name" type="text" value="{{$subcluster->name}}" class="form-control input-border-bottom" required>
                <label for="inputFloatingLabel" class="placeholder">Input New Sub-Cluster Name</label>
                <small id="emailHelp" class="form-text text-muted">Make sure that the name is unique.</small>
            </div>
            <div class="form-group">
                <label>Select a Cluster:</label>
                <select id="test" class="form-control js-example-basic-single" name="clusterID" style="width:100%;" required>
                    @if(count($cluster) > 0)
                        <option value = "" disabled selected>Select a Cluster</option>

                        @foreach($cluster as $row)
                        <option value = "{{$row->id}}" 
                        
                        @if ($row->id == $subcluster->clusterID)
                            selected
                            
                        @endif

                        >{{$row->name}} </option>
                        
                    @endforeach
                    @else
                        <option value = "" disabled selected>No Cluster found</option>
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
        $('.js-example-basic-single').select2();
    }); 
</script>
@endsection