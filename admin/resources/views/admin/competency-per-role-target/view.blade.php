@extends('layouts.app')

@section('content')

<div class="container">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{route('home')}}">Home</a></li>
            <li class="breadcrumb-item"><a href="{{route('competencyRoleTargets.index')}}">Competency-Role Target</a></li>
            <li class="breadcrumb-item active" aria-current="page">{{$role->name}} - {{$competency->name}}</li>
        </ol>
    </nav>
            
    <div class="row justify-content-center">
        <div class="col-md-12">
            <h1>{{$role->name}} - {{$competency->name}}</h1>
            <blockquote class="blockquote">
                <p class="mb-0">{{$level->weight}} - {{$level->name}}</p>
            </blockquote>
            <p>{!! nl2br($targetSource->name) !!}</p>

        </div>
    </div>
</div>


@endsection

@section('scripts')
@endsection