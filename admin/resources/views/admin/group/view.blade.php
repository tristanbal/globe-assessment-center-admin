@extends('layouts.app')

@section('content')

<div class="container">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{route('home')}}">Home</a></li>
            <li class="breadcrumb-item"><a href="{{route('groups.index')}}">Group</a></li>
            <li class="breadcrumb-item active" aria-current="page">{{$group->name}}</li>
        </ol>
    </nav>
            
    <div class="row justify-content-center">
        <div class="col-md-12">
            <h1 class="text-uppercase">{{$group->name}}</h1>
            <div id="task-complete"></div>

            <div class="row">
                <div class="col-sm-8">
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="card full-height">
                                <div class="card-body">
                                    <div class="card-title">Overall Statistics</div>
                                    <div class="card-category">The following data are the percentage of categories related to the group {{$group->name}} as shown from the assessment portal database:</div>
                                    <div class="d-flex flex-wrap justify-content-around pb-2 pt-4">
                                        <div class="px-2 pb-2 pb-md-0 text-center">
                                            <div id="division-chart"></div>
                                            <h6 class="fw-bold mt-3 mb-0">Divisions</h6>
                                        </div>
                                        <div class="px-2 pb-2 pb-md-0 text-center">
                                            <div id="employee-chart"></div>
                                            <h6 class="fw-bold mt-3 mb-0">Employees</h6>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12">
                            <h3 class="text-uppercase">Employees under {{$group->name}}</h3>
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
                </div>
                <div class="col-sm-4">
                    <div class="card full-height">
                        <div class="card-header">
                            <div class="card-title">Models Under the Group</div>
                        </div>
                        <div class="card-body">
                            <ol class="activity-feed">
                                @if(count($model)>0)
                                    @if ($role)
                                        @foreach ($model as $item)
                                            @foreach ($role as $col)
                                                @if ($item->roleID == $col->id)
                                                    <li class="feed-item feed-item-success">
                                                        <time class="date" datetime="9-24">{{date_format($item->created_at,"M d, Y")}}</time>
                                                        <span class="text">Added <a href="#">"{{$col->name}}"</a></span>
                                                    </li>
                                                @endif
                                            @endforeach
                                        @endforeach
                                    @else
                                        
                                    @endif
                                @else
                                    <li class="feed-item feed-item-danger">
                                        <span class="text">No Models found.</span>
                                    </li>
                                @endif
                                
                                
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-12">
                    <h3 class="text-uppercase">Attached Divisions</h3>
                    <div class="table-responsive">
                        <table id="group-datatables" class="display table table-striped table-hover" cellspacing="0" width="100%">
                            <thead>
                                <tr>
                                    <th>Division Name</th>
                                    <th>Created At</th>
                                    <th>Updated At</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($division as $item)
                                    <tr>
                                        <td>{{$item->name}}</td>
                                        <td>{{$item->created_at}}</td>
                                        <td>{{$item->updated_at}}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            

            
        </div>
    </div>
</div>


@endsection

@section('scripts')

<script>
    Circles.create({
        id:           'division-chart',
        radius:       80,
        value:        {{ number_format((count($division)/count($divisionOverall) * 100), 1)}},
        maxValue:     100,
        width:        10,
        text:         function(value){return value + '%';},
        colors:       ['#eee', '#177dff'],
        duration:     400,
        wrpClass:     'circles-wrp',
        textClass:    'circles-text',
        styleWrapper: true,
        styleText:    true
    })

    Circles.create({
        id:           'employee-chart',
        radius:       80,
        value:        {{ number_format((count($employee)/count($employeeOverall) * 100), 1)}},
        maxValue:     100,
        width:        10,
        text:         function(value){return value + '%';},
        colors:       ['#eee', '#177dff'],
        duration:     400,
        wrpClass:     'circles-wrp',
        textClass:    'circles-text',
        styleWrapper: true,
        styleText:    true
    })


    $(document).ready(function() {
          $('#group-datatables').DataTable();
    });

    var selectedGroup = @json($group->name);
    $(document).ready(function() {
        $('#employee-datatables').DataTable({
            dom: 'Bfrtip',
            buttons: [
                //'copy', 'csv', 'excel', 'pdf', 'print'
                {
                    extend: 'copyHtml5'
                },
                {
                    extend: 'excelHtml5',
                    title: selectedGroup + ' Employees'
                },
                {
                    extend: 'pdfHtml5',
                    title: selectedGroup + ' Employees'
                },
                {
                    extend: 'csvHtml5',
                    title: selectedGroup + ' Employees'
                }
            ]
        });
    });
</script>

@endsection