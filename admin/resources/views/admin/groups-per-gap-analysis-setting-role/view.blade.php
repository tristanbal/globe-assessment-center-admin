@extends('layouts.app')

@section('content')

<div class="container">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{route('home')}}">Home</a></li>
            <li class="breadcrumb-item"><a href="{{route('groupsPerGapAnalysisSettingRoles.index')}}">Group Per Gap Analysis Setting Role</a></li>
            <li class="breadcrumb-item active" aria-current="page">{{$groupsPerGapAnalysisSettingRole->gpgas->name}} {{$groupsPerGapAnalysisSettingRole->role->name}}</li>
        </ol>
    </nav>
            
    <div class="row justify-content-center">
        <div class="col-md-12">
             <h1>{{$groupsPerGapAnalysisSettingRole->gpgas->name}}</h1>
             <p>{{$groupsPerGapAnalysisSettingRole->role->name}}</p>
        </div>
    </div>
</div>


@endsection

@section('scripts')

@endsection