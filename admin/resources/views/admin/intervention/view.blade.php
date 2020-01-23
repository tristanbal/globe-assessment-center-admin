@extends('layouts.app')

@section('content')

<div class="container">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{route('home')}}">Home</a></li>
            <li class="breadcrumb-item"><a href="{{route('interventions.index')}}">Intervention</a></li>
            <li class="breadcrumb-item active" aria-current="page">{{$competency->name}} - {{$training->name}}</li>
        </ol>
    </nav>
            
    <div class="row justify-content-center">
        <div class="col-md-12">
            <h1>{{$competency->name}}</h1>
            <h3>Assigned training: {{$training->name}}</h3>

        </div>
    </div>
</div>


@endsection

@section('scripts')
@endsection