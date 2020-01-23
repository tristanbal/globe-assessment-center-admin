@extends('layouts.app')

@section('content')

<div class="container">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{route('home')}}">Home</a></li>
            <li class="breadcrumb-item"><a href="{{route('evaluations.index')}}">All Assessment</a></li>
            <li class="breadcrumb-item"><a href="{{route('evaluations.index')}}">Individual Assessment Result</a></li>
            <li class="breadcrumb-item active" aria-current="page">{{$employee->firstname}} {{$employee->lastname}}</li>
        </ol>
    </nav>
            
    <div class="row justify-content-center">
        <div class="col-md-12">
            <h1 class="text-uppervase">{{$employee->firstname}} {{$employee->lastname}}</h1>
            <p class="">{{$group->name}} - {{$role->name}}</p>
            
            
        </div>
    </div>
</div>


@endsection

@section('scripts')

@endsection