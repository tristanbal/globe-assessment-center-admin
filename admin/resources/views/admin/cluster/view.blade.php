@extends('layouts.app')

@section('content')

<div class="container">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{route('home')}}">Home</a></li>
            <li class="breadcrumb-item"><a href="{{route('clusters.index')}}">Cluster</a></li>
            <li class="breadcrumb-item active" aria-current="page">{{$cluster->name}}</li>
        </ol>
    </nav>
            
    <div class="row justify-content-center">
        <div class="col-md-12">
            <h1>{{$cluster->name}}</h1>
            
            <p>No content.</p>

        </div>
    </div>
</div>


@endsection

@section('scripts')
@endsection