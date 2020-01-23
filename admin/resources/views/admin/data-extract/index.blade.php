@extends('layouts.app')

@section('content')

<div class="container">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{route('home')}}">Home</a></li>
            <li class="breadcrumb-item active" aria-current="page">Data Extractor</li>
        </ol>
    </nav>
            
    <div class="row justify-content-center">
        <div class="col-md-12">
            <h1>Data Extractor</h1>
            <div class="row">
                <div class="col-sm-4">
                    <div class="card full-height bg-primary">
                        <div class="card-body text-white">
                            <h3>Competency Library</h3>
                            <p>Exportables of all competencies with corresponding cluster, subcluster, talent segment and proficiency.</p>
                            <a href="{{route('data-extract.competency-library')}}" class="btn btn-lg btn-block btn-info">Export</a>
                        </div>
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="card full-height bg-primary">
                        <div class="card-body text-white">
                            <h3>Competency Models</h3>
                            <p>Exportables of all models in the assessment portal.</p>
                            <a href="{{route('data-extract.model')}}" class="btn btn-lg btn-block btn-info">Export</a>
                        </div>
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="card full-height bg-primary">
                        <div class="card-body text-white">
                            <h3>Masterlist Library</h3>
                            <p>Exportables of all existing employees in the library with their corresponding group, division, role etc.</p>
                            <a href="{{route('data-extract.masterlist')}}" class="btn btn-lg btn-block btn-info">Export</a>
                        </div>
                    </div>
                </div>
                
            </div>
            <div class="row">
                <div class="col-sm-4">
                    <div class="card full-height bg-primary">
                        <div class="card-body text-white">
                            <h3>Evaluation Raw Data</h3>
                            <p>Exportables of all active evaluations in the assessment portal.</p>
                            <a href="{{route('data-extract.evaluation-raw-data')}}" class="btn btn-lg btn-block btn-info">Export</a>
                        </div>
                    </div>
                </div>
                
                
            </div>

        </div>
    </div>
</div>


@endsection

@section('scripts')
@endsection