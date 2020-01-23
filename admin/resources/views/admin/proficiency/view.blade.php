@extends('layouts.app')

@section('content')

<div class="container">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{route('home')}}">Home</a></li>
            <li class="breadcrumb-item"><a href="{{route('proficiencies.index')}}">Proficiency</a></li>
            <li class="breadcrumb-item active" aria-current="page">{{$competency->name}} - Level ID {{$proficiency->levelID}} </li>
        </ol>
    </nav>
            
    <div class="row justify-content-center">
        <div class="col-md-12">
            <h1>{{$level->weight}} | {{$level->name}}</h1>
            <blockquote class="blockquote">
                <p class="mb-0">Attached Competency: <b>{{$competency->name}}</b><br>
                Database Level ID: <b>{{$proficiency->levelID}}</b></p>
            </blockquote>

            <p>{!! nl2br($proficiency->definition) !!}</p>

        </div>
    </div>
</div>


@endsection

@section('scripts')
@endsection