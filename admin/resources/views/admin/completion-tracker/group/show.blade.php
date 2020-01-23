@extends('layouts.app')

@section('content')

<div class="container">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{route('home')}}">Home</a></li>
            <li class="breadcrumb-item"><a href="{{route('completionTrackers.index')}}">Completion Tracker</a></li>
            <li class="breadcrumb-item"><a href="{{route('completionTrackers.groups.view', ['groupID' => $group->id])}}">{{$group->name}}</a></li>
            <li class="breadcrumb-item active" aria-current="page">Selected Roles Summary</li>
        </ol>
    </nav>
    <h1 class="text-uppercase ">{{$group->name}} </h1> 
    
    <div class="row">
        <div class="col-12">
            <ul class="nav nav-pills nav-secondary  nav-pills-no-bd nav-pills-icons justify-content-center mb-3" id="pills-tab" role="tablist">
                <li class="nav-item">
                    <a class="nav-link active" id="pills-home-tab-icon" data-toggle="pill" href="#pills-home-icon" role="tab" aria-controls="pills-home-icon" aria-selected="true">
                    <i class="fas fa-certificate"></i>
                    Summary
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="pills-profile-tab-icon" data-toggle="pill" href="#pills-profile-icon" role="tab" aria-controls="pills-profile-icon" aria-selected="false">
                    <i class="fas fa-chart-bar"></i>
                    Breakdown
                    </a>
                </li>
            </ul>
            <div class="tab-content mb-3" id="pills-tabContent">
                <div class="tab-pane fade show active" id="pills-home-icon" role="tabpanel" aria-labelledby="pills-home-tab-icon">
                    @if ($roles_selected)
                        <div class="card">
                            <div class="card-body text-center">
                                <h1 class="text-center">Summary of Roles Completion</h1>
                                <p class="text-center">This module tracks the completion rate of specific roles per assessment type found within the assessment portal.</p>
                                <form action="{{route('completionTrackers.export', ['groupID' => $group->id])}}" method="GET">
                                    <input type="text" value="{{$roles_selected_id}}" name="roles_selected_id" hidden>
                                    <button class="btn btn-success text-center" type="submit">Export Summary</button>
                                </form>
                            </div>
                        </div>
                        
                        @foreach ($roles_selected as $rsItem)
                            @foreach ($role as $roleItem)
                                @if ($rsItem == $roleItem->id)
                                    <div class="card">
                                        <div class="card-body">
                                            <h3 class="text-center">{{$roleItem->name}}</h3>
                                            <div class="table-responsive pb-4">
                                                <table id="role-summary-{{$roleItem->id}}" class="display table table-striped table-hover" cellspacing="0" width="100%">
                                                    <thead>
                                                        <tr>
                                                            <th>Assessment Type</th>
                                                            <th>Target</th>
                                                            <th>Assessed</th>
                                                            <th>Completion Rate</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @if ($arraySelection)
                                                            @foreach ($arraySelection as $arraySelectionItem)
                                                                @if ($arraySelectionItem->roleID == $roleItem->id )
                                                                    <tr>
                                                                        <td>{{$arraySelectionItem->assessmentType}}</td>
                                                                        <td>{{$arraySelectionItem->target}}</td>
                                                                        <td>{{$arraySelectionItem->assessed}}</td>
                                                                        <td>{{$arraySelectionItem->completion}}%</td>
                                                                    </tr>
                                                                    
                                                                @endif
                                                            @endforeach
                                                        @endif
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            @endforeach
                        @endforeach
                    @else 
                        <p>No roles were selected.</p>
                    @endif
                </div>
                <div class="tab-pane fade" id="pills-profile-icon" role="tabpanel" aria-labelledby="pills-profile-tab-icon">
                    @if ($roles_selected)

                        <div class="card">
                            <div class="card-body text-center">
                                <h1 class="text-center">Breakdown of Roles Completion</h1>
                                <p class="text-center">This module tracks the completion status of specific assessment per employee in a specific role cluster per assessment type.</p>
                                <form action="{{route('completionTrackers.export.breakdown', ['groupID' => $group->id])}}" method="GET">
                                    <input type="text" value="{{$roles_selected_id}}" name="roles_selected_id" hidden>
                                    <button class="btn btn-success text-center" type="submit">Export Breakdown</button>
                                </form>
                            </div>
                        </div>
                        @foreach ($roles_selected as $rsItem)
                            @foreach ($role as $roleItem)
                                @if ($rsItem == $roleItem->id)
                                    <div class="card">
                                        <div class="card-body">
                                            <h3 class="text-center">{{$roleItem->name}}</h3>
                                            <div class="table-responsive pb-4">
                                                <table id="role-breakdown-{{$roleItem->id}}" class="display table table-striped table-hover" cellspacing="0" width="100%">
                                                    <thead>
                                                        <tr>
                                                            <th>Assessment Type</th>
                                                            <th>Assessor</th>
                                                            <th>Assesseee</th>
                                                            <th>Completion Status</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @if ($arrayBreakdown)
                                                            @foreach ($arrayBreakdown as $arrayBreakdownItem)
                                                                @if ($arrayBreakdownItem->roleID == $roleItem->id )
                                                                    <tr>
                                                                        <td>{{$arrayBreakdownItem->assessmentType}}</td>
                                                                        <td>{{$arrayBreakdownItem->assessorEmployeeID}} | {{$arrayBreakdownItem->assessorName}}</td>
                                                                        <td>{{$arrayBreakdownItem->assesseeEmployeeID}} | {{$arrayBreakdownItem->assesseeName}}</td>
                                                                        <td class=" text-white 
                                                                        @if ($arrayBreakdownItem->completion  == 2)
                                                                            bg-warning
                                                                        @elseif($arrayBreakdownItem->completion == 0)
                                                                            bg-primary
                                                                        @else
                                                                            bg-success
                                                                        @endif
                                                                        
                                                                        ">
                                                                        @if ($arrayBreakdownItem->completion  == 2)
                                                                            On-Going
                                                                        @elseif($arrayBreakdownItem->completion == 0)
                                                                            Pending Assessment
                                                                        @else
                                                                            Completed
                                                                        @endif
                                                                        </td>
                                                                    </tr>
                                                                    
                                                                @endif
                                                            @endforeach
                                                        @endif
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            @endforeach
                        @endforeach
                    @else 
                        <p>No roles were selected.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">    
            
        </div>
    </div>
</div>


@endsection

@section('scripts')
    @if ($roles_selected)
        @foreach ($roles_selected as $rsItem)
            @foreach ($role as $roleItem)
                @if ($rsItem == $roleItem->id)
                    <script>
                        $(document).ready(function() {
                            $('#role-summary-{{$roleItem->id}}').DataTable();
                        });
                    </script>
                
                @endif
                
            @endforeach
        @endforeach
    @endif

    @if ($roles_selected)
        @foreach ($roles_selected as $rsItem)
            @foreach ($role as $roleItem)
                @if ($rsItem == $roleItem->id)

                    <script>
                        $(document).ready(function() {
                            $('#role-breakdown-{{$roleItem->id}}').DataTable();
                        });
                    </script>

                    
                @endif
            @endforeach
        @endforeach
    @endif
    
@endsection