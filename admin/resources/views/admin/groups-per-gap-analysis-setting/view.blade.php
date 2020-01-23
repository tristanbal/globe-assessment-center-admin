@extends('layouts.app')

@section('content')

<div class="container">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{route('home')}}">Home</a></li>
            <li class="breadcrumb-item"><a href="{{route('groupsPerGapAnalysisSettings.index')}}">Group Per Gap Analysis Setting</a></li>
            <li class="breadcrumb-item active" aria-current="page">{{$groupsPerGapAnalysisSetting->name}}</li>
        </ol>
    </nav>
            
    <div class="row justify-content-center">
        <div class="col-md-12">
             <h1>{{$groupsPerGapAnalysisSetting->name}}</h1>
        </div>
    </div>
</div>


@endsection

@section('scripts')

@endsection