@extends('layouts.app')

@section('content')

<div class="container">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{route('home')}}">Home</a></li>
            <li class="breadcrumb-item"><a href="{{route('levels.index')}}">Level</a></li>
            <li class="breadcrumb-item active" aria-current="page">{{$level->name}}</li>
        </ol>
    </nav>
            
    <div class="row justify-content-center">
        <div class="col-md-12">
            <h1>{{$level->name}}</h1>
            
            <p>Weight: {{$level->weight}}<br>
            Definition: {{$level->definition}}</p>

        </div>
    </div>
</div>


@endsection

@section('scripts')
@endsection