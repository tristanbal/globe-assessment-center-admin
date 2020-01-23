@extends('layouts.app')

@section('content')

<div class="container">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{route('home')}}">Home</a></li>
            <li class="breadcrumb-item"><a href="{{route('employee-relationships.index')}}">Employee Relationship</a></li>
            <li class="breadcrumb-item"><a href="{{route('employee-relationships.search.index',['employeeID'=>$employeeSearchedDetails->id,'taker'=>$takerID,'relationshipID'=>$relationshipID])}}">{{$employeeSearchedDetails->firstname}} {{$employeeSearchedDetails->lastname}}</a></li>
            <li class="breadcrumb-item"><a href="{{route('employee-relationships.search.index',['employeeID'=>$employeeSearchedDetails->id,'taker'=>$takerID,'relationshipID'=>$relationshipID])}}">
                @if ($takerID == 1)
                    Assessee
                @else
                    Assessor
                @endif
                </a>
            </li>
            <li class="breadcrumb-item active" aria-current="page">View</li>
        </ol>
    </nav>
            
    <div class="row justify-content-center">
        <div class="col-md-12">
            <h1>Employee Relationship View</h1>
            @if ($takerID==1)
                <h3>{{$employeeSearchedDetails->firstname}} {{$employeeSearchedDetails->lastname}} is being assessed by {{$employeeDataRow->firstname}} {{$employeeDataRow->lastname}}. <br> {{$employeeDataRow->firstname}} is the {{$relationship->name}}.</h3>
            @else
            <h3>{{$employeeSearchedDetails->firstname}} {{$employeeSearchedDetails->lastname}} is assessing {{$employeeDataRow->firstname}} {{$employeeDataRow->lastname}} as the {{$relationship->name}}.</h3>
            @endif

            <a href="{{route('employee-relationships.search.edit',['id' => $employeeRelationship->id, 'takerID' => $takerID,'employeeID'=>$employeeSearchedDetails->id, 'relationshipID'=>$relationshipID ])}}" class="btn btn-success">Edit</a>

        </div>
    </div>
</div>


@endsection

@section('scripts')
@endsection