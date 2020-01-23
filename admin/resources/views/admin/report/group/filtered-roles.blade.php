@extends('layouts.app')

@section('content')

<div class="container">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{route('home')}}">Home</a></li>
            <li class="breadcrumb-item active" aria-current="page">Groups</li>
        </ol>
    </nav>
            
    <div class="row justify-content-center">
        <div class="col-md-12">
            {{-- <h1>Groups</h1> --}}
            <br><br>
            <div class="col-md-10">
                <div class="card full-height">
                    <div class="card-body">
                        <div class="card-title">Roles</div>
                        <div class="row py-3">
                            <div class="col-md-4 d-flex flex-column justify-content-around">
                                @foreach($roleArray as $role)
                                <div>
                                    <h6 class="fw-bold text-uppercase op-8">{{$role->roleName}}</h6>
                                    <h3 class="fw-bold">{{$role->populationPerRole}}</h3>
                                </div>
                                @endforeach
                            </div>
                            <div class="col-md-8">
                                <div id="chartdiv" class="population"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @foreach($roleArray as $role)
        <div class="col-md-6">
            <div class="card full-height">
                <div class="card-body">
                    <div class="card-title">{{$role->roleName}}</div>
                    <div class="row py-3">
                        <div class="col-md-12 d-flex flex-column justify-content-around">
                            <div id="{{$role->roleName}}completion" class="completion"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <script>
            var chart = AmCharts.makeChart("{{$role->roleName}}completion", {
                "type": "serial",
                "theme": "light",
                // "color": "#000",
                // "marginRight": 70,
                "dataProvider": [{
                    "complete": "With Complete \nAssessment",
                    "target": "{{$role->completeAssess}}",
                    "color": "#e8b279"
                }, {
                    "complete": "Target Number",
                    "target": "{{$role->populationPerRole}}",
                    "color": "#eb721a"
                }],
                "startDuration": 1,
                "graphs": [{
                    "balloonText": "<b>[[category]]: [[value]]</b>",
                    "fillColorsField": "color",
                    "fillAlphas": 0.9,
                    "lineAlpha": 0.2,
                    "type": "column",
                    "labelText": "[[value]]",
                    "valueField": "target"
                }],
                "chartCursor": {
                    "categoryBalloonEnabled": false,
                    "cursorAlpha": 0,
                    "zoomable": false
                },
                "categoryField": "complete",
                "categoryAxis": {
                    "gridPosition": "start",
                    "labelRotation": 0
                },
                "export": {
                    "enabled": true
                }

            });
        </script>

        @endforeach

        

    </div>



</div>

<style>
    .population {
        width: 120%;
        height: 500px;
        margin-left: -120px;
    }

    .completion {
        width: 100%;
        height: 500px;
    }
</style>


@endsection

@section('scripts')
<script>
    var chart = AmCharts.makeChart( "chartdiv", {
        "type": "pie",
        "theme": "light",
        "labelText": "[[title]]: [[value]]",
        "dataProvider": [ 
        @foreach($roleArray as $role)
        {
            "name": "{{$role->roleName}}",
            "population": {{$role->populationPerRole}}
        },
        @endforeach
        ],
        "valueField": "population",
        "titleField": "name",
        "balloon":{
            "fixedPosition":true
        },
        "export": {
            "enabled": true
        }
    } );
</script>
@endsection