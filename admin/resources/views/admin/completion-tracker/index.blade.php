@extends('layouts.app')

@section('content')

<div class="container">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{route('home')}}">Home</a></li>
            <li class="breadcrumb-item active" aria-current="page">Completion Tracker</li>
        </ol>
    </nav>
            
    <div class="row justify-content-center">
        <div class="col-md-12">
            <h1 class="text-uppercase ">Completion Tracker</h1>
            <div class="row">
                <div class="col-sm-3">
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="nav flex-column nav-pills nav-secondary nav-pills-no-bd" id="v-pills-tab" role="tablist" aria-orientation="vertical">
                                <a class="nav-link active" id="v-pills-home-tab-nobd" data-toggle="pill" href="#v-pills-home-nobd" role="tab" aria-controls="v-pills-home-nobd" aria-selected="true">Summary</a>
                                <a class="nav-link" id="v-pills-profile-tab-nobd" data-toggle="pill" href="#v-pills-profile-nobd" role="tab" aria-controls="v-pills-profile-nobd" aria-selected="false">Specific</a>
                            </div>
                        </div>
                    </div>
                    <div class="row pt-3">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-body">
                                    <h5 class="card-title mb-3">Tracker Assignment</h5>
                                    <h6 class="card-subtitle mb-2 text-muted">(To assign to admin, set to Globe University)</h6>
                                    <p class="card-text">Tracker designed for supervisors, admins and other related personel who needs viewing of the assessment completion on a selected group.</p>
                                    <a href="{{route('completionTrackerAssignments.create')}}" class="card-link">Add Assignment</a>
                                    <a href="#" class="card-link">Another link</a>
                                </div>
                            </div>
                            
                        </div>
                    </div>
                    
                </div>
                <div class="col-sm-9">
                    <div class="tab-content" id="v-pills-tabContent">
                        <div class="tab-pane fade show active" id="v-pills-home-nobd" role="tabpanel" aria-labelledby="v-pills-home-tab-nobd">
                            <h3 class="">Summary</h3>                        
                            <div class="table-responsive">
                                <table id="all-groups-summary" class="display table table-striped table-hover" cellspacing="0" width="100%">
                                    <thead>
                                        <tr>
                                            <th>Group</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($group as $groupItem)
                                            <tr>
                                                <td>{{$groupItem->name}}</td>
                                                <td>
                                                    <div style = "display: flex;">
                                                        <a style = "float: left;" href = "{{route('completionTrackers.groups.view', ['groupID' => $groupItem->id])}}"><div class = "btn-success btn">VIEW</div></a>
                                                        <a style = "float: left;" href = "{{route('completionTrackers.oneDown', ['groupID' => $groupItem->id])}}"><div class = "btn-info btn">DIVISIONS</div></a>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="v-pills-profile-nobd" role="tabpanel" aria-labelledby="v-pills-profile-tab-nobd">
                            <h3 class="">Specific</h3>    
                            <div class="table-responsive">
                                <table id="basic-datatables" class="display table table-striped table-hover" cellspacing="0" width="100%">
                                    <thead>
                                        <tr>
                                            <th>Grouped </th>
                                            <th>Employee Assigned</th>
                                            <th>Timestamp</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($completionTrackerAssignment as $item)
                                            <tr>
                                                <td>{{$item->gpgas->name}}</td>
                                                <td>{{$item->employee->employeeID}} | {{$item->employee->firstname}} {{$item->employee->lastname}}</td>
                                                <td>{{$item->updated_at}}</td>
                                                <td>
                                                    <div style = "display: flex;"> <a style = "float: left;" href = "{{route('completionTrackerAssignments.show',['id'=>$item->id])}}"><div class = "btn-info btn">VIEW</div></a>
                                                    <a style = "float: right;" href = "{{route('completionTrackerAssignments.edit',['id'=>$item->id])}}"><div class = "btn-success btn">EDIT</div></a>  
                                                    <a style = "float: right;" href = "{{route('completionTrackerAssignments.delete',['id'=>$item->id])}}"><div class = "btn-danger btn">DELETE</div></a></div>
                                                </td>
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
    </div>
</div>


@endsection

@section('scripts')
    <script>
        $(document).ready(function() {
            $('#all-groups-summary').DataTable();
        });
        $(document).ready(function() {
            $('#basic-datatables').DataTable();
        });
        
    </script>
@endsection