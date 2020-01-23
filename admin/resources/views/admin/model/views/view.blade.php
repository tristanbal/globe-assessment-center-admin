@extends('layouts.app')

@section('content')

<div class="container">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{route('home')}}">Home</a></li>
            <li class="breadcrumb-item"><a href="{{route('listOfCompetenciesPerRoles.index')}}">Model</a></li>
            <li class="breadcrumb-item active" aria-current="page">{{$group->name}} - {{$role->name}}</li>
        </ol>
    </nav>
            
    <div class="row justify-content-center">
        <div class="col-md-12">
            <h1>{{$group->name}} - {{$role->name}}</h1>

            <div class="row">
                <div class="col-sm-3">
                    <div class="card card-primary bg-primary-gradient">
                        <div class="card-body">
                            <h4 class="mt-3 b-b1 pb-2 mb-4 fw-bold">Number of Employees</h4>
                            <h1 class="mb-4 fw-bold">{{count($employee)}}</h1>
                            <h4 class="mt-3 b-b1 pb-2 mb-4 fw-bold">Number of Competencies</h4>
                            <h1 class="mb-4 fw-bold">{{count($modelCompetencies)}}</h1>
                            <h4 class="mt-5 pb-3 mb-0 fw-bold">Last Evaluation</h4>
                            <ul class="list-unstyled">
                                <li class="d-flex justify-content-between pb-1 pt-1"><small>Sample Name</small> <span>Date-Time</span></li>
                                <li class="d-flex justify-content-between pb-1 pt-1"><small>Sample Name</small> <span>Date-Time</span></li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col-sm-9">
                    <h3 class="">Employees Assigned to {{$role->name}}</h3>
                    <hr>
                    <div class="table-responsive">
                        <table id="employee-datatables" class="display table table-striped table-hover" cellspacing="0" width="100%">
                            <thead>
                                <tr>
                                    <th>Employee ID</th>
                                    <th>First Name</th>
                                    <th>Last Name</th>
                                    <th>Email</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($employee as $item)
                                    <tr>
                                        <td>{{$item->employeeID}}</td>
                                        <td>{{$item->firstname}}</td>
                                        <td>{{$item->lastname}}</td>
                                        <td>{{$item->email}}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <h3>Competency Library</h3>
            @if (count($type)<=3 && count($type)>0)
            <div class="row">
                @foreach ($type as $types)
                    <div class="col-sm-4">
                        <div class="card">
                            <div class="card-header">
                                <div class="card-title">{{$types->name}}</div>
                            </div>
                            <div class="card-body pb-0">
                                @foreach ($modelCompetencies as $item)
                                    @if ($item->competencyTypeID == $types->id)
                                        <div class="d-flex">
                                            <div class="avatar">
                                                <img src="{{asset('img/logoproduct.svg')}}" alt="..." class="avatar-img rounded-circle">
                                            </div>
                                            <div class="flex-1 pt-1 ml-2">
                                                <h6 class="fw-bold mb-1">{{$item->competencyName}}</h6>
                                                <small class="text-muted">{!! nl2br($item->competencyDefinition) !!}</small>
                                            </div>
                                            <div class="d-flex ml-auto align-items-center">
                                                <h3 class="text-info text-justify fw-bold">L{{$item->targetLevelWeight}}</h3>
                                            </div>
                                        </div>
                                        <div class="separator-dashed"></div>
                                    @endif
                                @endforeach
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
                
            @elseif(count($type)>3)
                
            @endif
            
        </div>
    </div>
</div>


@endsection

@section('scripts')
    <script>
        $(document).ready(function() {
              $('#employee-datatables').DataTable();
        });
    </script>
@endsection