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
            <h1>{{$subcluster->name}}</h1>
            
            <p>Assigned Cluster: {{$cluster->name}}</p>

        </div>
    </div>
</div>


@endsection

@section('scripts')
@endsection