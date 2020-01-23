@extends('layouts.app')

@section('content')

<div class="container">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{route('home')}}">Home</a></li>
            <li class="breadcrumb-item"><a href="{{route('employee-relationships.index')}}">Employee Relationship</a></li>
            <li class="breadcrumb-item active" aria-current="page">{{$employeeRelationship->assessorEmployeeID}} -> {{$employeeRelationship->assesseeEmployeeID}}</li>
        </ol>
    </nav>
            
    <div class="row justify-content-center">
        <div class="col-md-12">
            <h1>{{$employeeRelationship->assessorEmployeeID}} -> {{$employeeRelationship->assesseeEmployeeID}}</h1>
            
            <h3>Relationship Type: {{$relationship->name}}</h3>
            <p>
                Assessee: {{$assesseeEmployee->employeeID}} | {{$assesseeEmployee->firstname}}  {{$assesseeEmployee->lastname}} <br>
                Assessee: {{$assessorEmployee->employeeID}} | {{$assessorEmployee->firstname}}  {{$assessorEmployee->lastname}} 

            </p>

        </div>
    </div>
</div>


@endsection

@section('scripts')
@endsection