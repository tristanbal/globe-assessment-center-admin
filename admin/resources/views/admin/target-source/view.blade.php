@extends('layouts.app')

@section('content')

<div class="container">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{route('home')}}">Home</a></li>
            <li class="breadcrumb-item"><a href="{{route('targetSources.index')}}">Target Source</a></li>
            <li class="breadcrumb-item active" aria-current="page">{{$targetSource->name}}</li>
        </ol>
    </nav>
            
    <div class="row justify-content-center">
        <div class="col-md-12">
            <h1>{{$targetSource->name}}</h1>
            
            <p>No content.</p>

        </div>
    </div>
</div>


@endsection

@section('scripts')
@endsection