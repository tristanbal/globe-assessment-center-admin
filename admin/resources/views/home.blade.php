@extends('layouts.app-home')

@section('content')

<div class="">
    <div class="content ">
        <div class="panel-header bg-primary-gradient ">
            <div class="page-inner py-5 ">
                <div class="d-flex align-items-left align-items-md-center flex-column flex-md-row">
                    <div>
                        <h2 class="text-white pb-2 fw-bold">Assessment Portal Administrator</h2>
                        <h5 class="text-white op-7 mb-2">Welcome to the admin side of the assessment center.</h5>
                    </div>
                    <div class="ml-md-auto py-2 py-md-0">
                        <a href="{{route('users.index')}}" class="btn btn-white btn-border btn-round mr-2">Manage Users</a>
                    </div>
                </div>
            </div>
        </div>
        <div class="page-inner mt--5">
            <div class="row mt--2 ">
                <div class="col-md-6">
                    <div class="row">
                        <div class="col-12">
                            <div class="card ">
                                <div class="card-body">
                                    <div class="card-title">Models Submission</div>
                                    <div class="card-category">Overview of the latest model submissions for the model builder. <a href="{{route('models.submissions.index')}}">View More >></a></div>
                                    <div class="d-flex flex-wrap justify-content-around pb-2 pt-4">
                                        <div class="px-2 pb-2 pb-md-0 text-center">
                                            <div id="circles-1"></div>
                                            <h6 class="fw-bold mt-3 mb-0">Pending Models</h6>
                                        </div>
                                        <div class="px-2 pb-2 pb-md-0 text-center">
                                            <div id="circles-2"></div>
                                            <h6 class="fw-bold mt-3 mb-0">Models Approved</h6>
                                        </div>
                                        <div class="px-2 pb-2 pb-md-0 text-center">
                                            <div id="circles-3"></div>
                                            <h6 class="fw-bold mt-3 mb-0">Models Rejected</h6>
                                        </div>
                                    </div>                         
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="card full-height ">
                                <div class="row">
                                    <div class="col-sm-12">
                                        <div class="card-body">
                                            <div class="card-title">Data Extraction</div>
                                            <div class="card-category">Extract different types of Data (Raw, Masterlist, Library,) for ETL and other uses. <a href="{{route('users.index')}}">View More >></a></div>          
                                            <div class="card-body d-flex align-items-center justify-content-center" style="height:100%;width:100%">
                                                
                                            <a href="{{route('data-extract.index')}}" class="btn btn-lg btn-block btn-primary">View Module</a>    
                                            </div>
                                        </div>
                                    </div>
                                </div>     
                                
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="card full-height ">
                                <div class="row">
                                    <div class="col-sm-12">
                                        <div class="card-body">
                                            <div class="card-title">Evaluation Feedback Form</div>
                                            <div class="card-category">A shortcut to the evaluation feedback form created in google drive, attached at the end of an assessment.</div>          
                                            <div class="card-body d-flex align-items-center justify-content-center" style="height:100%;width:100%">
                                                <!-- Large modal -->
                                                <a href="https://docs.google.com/forms/d/1dUknvc3knbBckRBkB9MSDO8QZBPK-WJ_fOZ0zrwLm00/edit" class="btn btn-lg btn-block btn-primary">View Evaluation Form</a>
    
                                            </div>
                                        </div>
                                    </div>
                                </div>     
                                
                            </div>
                        </div>
                    </div>
                    
                </div>
                <div class="col-md-6 ">
                    <div class="card ">
                        <div class="card-body">
                            <div class="card-title">Latest Evaluations</div>
                            <div class="card-category">Daily information about the latest evaluations in the assessment center. <a href="{{route('evaluations.index')}}">View More >></a></div>
                            <ol class="activity-feed">
                                @foreach ($latestFiveAssessee as $item)
                                    <li 
                                    @if($item->status == 1)
                                            class="feed-item feed-item-success"
                                    @else
                                        class="feed-item feed-item-warning"
                                    @endif>
                                        <time class="date" datetime="9-25">{{ date('M d, Y H:i:s', strtotime($item->updated_at)) }}</time>
                                        @if ($item->assessmentTypeID == 1)
                                            @if ($item->status == 1)
                                                <span class="text"><span class="text-uppercase">{{$item->firstname}} {{$item->lastname}} </span>finished taking the {{$item->assessmentType}} for the role <a href="{{route('evaluations.search.employee',['employeeID' => $item->employeeID])}}">{{$item->role}}.</a></span> 
                                            @else
                                                <span class="text"><span class="text-uppercase">{{$item->firstname}} {{$item->lastname}} </span> is currently taking the {{$item->assessmentType}} for the role <a href="{{route('evaluations.search.employee',['employeeID' => $item->employeeID])}}">{{$item->role}}.</a></span> 
                                            @endif
                                        
                                        @else
                                            @if ($item->status == 1)
                                                <span class="text"><span class="text-uppercase">{{$item->firstname}} {{$item->lastname}} </span>receives a completed {{$item->assessmentType}} for the role <a href="{{route('evaluations.search.employee',['employeeID' => $item->employeeID])}}">{{$item->role}}.</a></span>    
                                            @else
                                                <span class="text"><span class="text-uppercase">{{$item->firstname}} {{$item->lastname}}'s </span>{{$item->assessmentType}} for the role <a href="{{route('evaluations.search.employee',['employeeID' => $item->employeeID])}}">{{$item->role}}</a> is currently taken.</span>    
                                            @endif
                                        
                                        @endif
                                    </li>
                                @endforeach
                                
                            </ol> 
                            
                        </div>
                    </div>
                </div>
                
            </div>
            <div class="row">
                <div class="col-sm-4">
                    <div class="card">
                        <div class="card-header">
                            <div class="card-title">Competency Library</div>
                            <p>To view all competencies, kindly <a href="{{route('competencies.index')}}">click here.</a> </p>
                        </div>
                        <div class="card-body">
                            <ol class="activity-feed">
                            @if ($competencyLatest)
                                @foreach ($competencyLatest as $item)
                                    <li class="feed-item feed-item-prumary">
                                        <time class="date" datetime="9-25">{{$item->name}}</time>
                                        <span class="text">Timestamp: {{$item->created_at}}</span>
                                    </li>
                                @endforeach
                            @else
                                <li class="feed-item feed-item-success">
                                    <time class="date" datetime="9-24">Sep 24</time>
                                    <span class="text">Added an interest <a href="#">"Volunteer Activities"</a></span>
                                </li>
                            @endif
                            </ol>
                            
                        </div>
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title">Completion Reports</h5>
                            <p>To select a specific completion report, kindly <a href="{{route('completionTrackers.index')}}">click here.</a> </p>
                            
                        </div>
                        <div class="card-body pb-0">
                            @if ($group)
                                @foreach ($group as $item)
                                    <div class="d-flex">
                                        <div class="avatar">
                                            <img src="{{asset('img/logoproduct.svg')}}" alt="..." class="avatar-img rounded-circle">
                                        </div>
                                        <div class="flex-1 pt-1 ml-2">
                                            <h6 class="fw-bold mb-1">{{$item->name}}</h6>
                                            <small class="text-muted">See all roles</small>
                                        </div>
                                    </div>
                                    <div class="separator-dashed"></div>
                                @endforeach    
                            @else
                                <div class="d-flex">
                                    <div class="avatar">
                                        <img src="{{asset('img/logoproduct.svg')}}" alt="..." class="avatar-img rounded-circle">
                                    </div>
                                    <div class="flex-1 pt-1 ml-2">
                                        <h6 class="fw-bold mb-1">CSS</h6>
                                        <small class="text-muted">Cascading Style Sheets</small>
                                    </div>
                                    <div class="d-flex ml-auto align-items-center">
                                        <h3 class="text-info fw-bold">+$17</h3>
                                    </div>
                                </div>
                                <div class="separator-dashed"></div>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="card">
                        <div class="card-body">
                            <div class="card-title fw-mediumbold">Latest User Access</div>
                            @if ($userLatest)
                                @foreach ($userLatest as $item)
                                    <div class="card-list">
                                        <div class="item-list">
                                            <div class="avatar">
                                                <img src="{{$item->profileImage}}" alt="..." class="avatar-img rounded-circle">
                                            </div>
                                            <div class="info-user ml-3">
                                                <div class="username">{{$item->email}}</div>
                                                <div class="status">Access Time: {{$item->updated_at}}</div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            @else
                                <div class="card-list">
                                    <div class="item-list">
                                        <div class="avatar">
                                            <img src="../assets/img/jm_denis.jpg" alt="..." class="avatar-img rounded-circle">
                                        </div>
                                        <div class="info-user ml-3">
                                            <div class="username">Jimmy Denis</div>
                                            <div class="status">Graphic Designer</div>
                                        </div>
                                        <button class="btn btn-icon btn-primary btn-round btn-xs">
                                            <i class="fa fa-plus"></i>
                                        </button>
                                    </div>
                                </div>
                            @endif
                            <!-- Large modal -->
                            <a href="{{route('users.index')}}" class="btn btn-lg btn-block btn-primary" >View All User Access</a>
    
                            
                        </div>
                    </div>
                </div>
                
                
            </div>
            <div class="row">
                <div class="col-sm-4">
                    <div class="card card-cascade narrower">

                        <!-- Card image -->
                        <div class="view view-cascade overlay">
                            <img  class="card-img-top pt-4" src="{{asset('assessment-images/iphone laptop.png')}}" alt="Card image cap">
                            <a>
                            <div class="mask rgba-white-slight"></div>
                            </a>
                        </div>
                        
                        <!-- Card content -->
                        <div class="card-body card-body-cascade" >
                            <!-- Title -->
                            <h4 class="font-weight-bold card-title">Model Counter</h4>
                            <!-- Text -->
                            <p class="card-text">Check all model counters found in the assessment portal.</p>
                            <!-- Large modal -->
                            <button type="button" class="btn btn-info btn-block" data-toggle="modal" data-target=".role-competency-count-modal">Role-Competency Counter</button>
                            <button type="button" class="btn btn-info btn-block" data-toggle="modal" data-target=".group-role-count-modal">Model-Role Counter</button>

                            <div class="modal fade role-competency-count-modal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
                                <div class="modal-dialog modal-lg">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="exampleModalLabel">Role-Competency Counter</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                            </div>
                                            <div class="modal-body">
                                                <div class="table-responsive">
                                                    <table id="role-competency-datatables" class="display table table-striped table-hover" cellspacing="0" width="100%">
                                                        <thead>
                                                            <tr>
                                                                <th>Role</th>
                                                                <th># Of Competencies</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            @foreach ($modelListCount as $item)
                                                                <tr>
                                                                    <td>{{$item->roleName}}</td>
                                                                    <td>{{$item->total}}</td>
                                                                </tr>
                                                            @endforeach
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                            <button type="button" class="btn btn-primary" data-dismiss="modal">Close</button>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Large modal -->
                            <div class="modal fade group-role-count-modal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
                                <div class="modal-dialog modal-lg">
                                    <div class="modal-content">
                                        ...
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-8">
                    <div class="row">
                        <div class="col-12">
                            <div class="card full-height">
                                <div class="card-header">
                                    <div class="card-head-row">
                                        <div class="card-title">Site Maps, Trackers and Statistics</div>
                                        <div class="card-tools">
                                            <ul class="nav nav-pills nav-secondary nav-pills-no-bd nav-sm" id="pills-tab" role="tablist">
                                                <li class="nav-item">
                                                    <a class="nav-link active" id="pills-site-tab" data-toggle="pill" href="#pills-site" role="tab" aria-selected="true">Site Map</a>
                                                </li>
                                                <li class="nav-item">
                                                    <a class="nav-link " id="pills-today-tab" data-toggle="pill" href="#pills-today" role="tab" aria-selected="true">Completion Tracker</a>
                                                </li>
                                                <li class="nav-item">
                                                    <a class="nav-link " id="pills-week-tab" data-toggle="pill" href="#pills-week" role="tab" aria-selected="false">Masterlist</a>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <div class="tab-content mb-3" id="pills-tabContent">
                                <div class="tab-pane fade show active" id="pills-site" role="tabpanel" aria-labelledby="pills-home-tab-nobd">
                                    <h3>Site Map Shortcuts are available below:</h3>
                                    <div class="row">
                                        <div class="col-sm-4">
                                            <div class="card full-height">
                                                <div class="card-body">
                                                    <h5 class="font-weight-bold font-italic">
                                                        Library
                                                    </h5>
                                                    <ul class="list-inline">
                                                        <li class="list-inline-item"><a href="{{route('competency.index')}}">Competency</a></li>
                                                        <li class="list-inline-item"><a href="{{route('clusters.index')}}">Cluster</a> </li>
                                                        <li class="list-inline-item"><a href="{{route('subcluster.index')}}">Subcluster</a> </li>
                                                        <li class="list-inline-item"><a href="{{route('talentSegments.index')}}">Talent Segment</a></li>
                                                        <li class="list-inline-item"><a href="{{route('proficiencies.index')}}">Proficiency</a>  </li>
                                                        <li class="list-inline-item"><a href="{{route('targetSources.index')}}">Target Source</a> </li>
                                                        <li class="list-inline-item"><a href="{{route('competencyRoleTargets.index')}}">Competency Per Role Target</a></li>
                                                        <li class="list-inline-item"><a href="{{route('competencyTypes.index')}}">Competency Type</a></li>
                                                        <li class="list-inline-item"><a href="{{route('levels.index')}}">Level</a></li>
                                                        <li class="list-inline-item"><a href="{{route('interventions.index')}}">Intervention</a></li>
                                                        <li class="list-inline-item"><a href="{{route('training.index')}}">Training</a></li>
                                                    </ul>
                                                    <h5 class="font-weight-bold font-italic">
                                                        Evaluations
                                                    </h5>
                                                    <ul class="list-inline">
                                                        <li class="list-inline-item"><a href="{{route('evaluations.index')}}">All Evaluations</a></li>
                                                        <li class="list-inline-item"><a href="{{route('completionTrackers.index')}}">Completion Tracker</a></li>
                                                        <li class="list-inline-item"><a href="{{route('reports.view')}}">Gap Analysis Per Employee</a></li>
                                                        <li class="list-inline-item"><a href="{{route('reports.group.view')}}">Gap Analysis Groups</a></li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-4">
                                            <div class="card full-height bg-info">
                                                <div class="card-body text-white">
                                                    <h5 class="font-weight-bold font-italic">
                                                        Model
                                                    </h5>
                                                    <ul class="list-inline">
                                                        <li class="list-inline-item"><a href="{{route('roles.index')}}" class="text-white">Role</a></li>
                                                        <li class="list-inline-item"><a href="{{route('listOfCompetenciesPerRoles.index')}}" class="text-white">Models</a></li>
                                                        <li class="list-inline-item"><a href="{{route('models.submissions.index')}}" class="text-white">Model Submission</a></li>
                                                        <li class="list-inline-item"><a href="https://globeuniversity.globe.com.ph/assessment-model/" class="text-white">Model Builder</a></li>
                                                    </ul>
                                                    <h5 class="font-weight-bold font-italic">
                                                        Uploader
                                                    </h5>
                                                    <ul class="list-inline">
                                                        <li class="list-inline-item"><a href="{{route('uploader.masterlist')}}" class="text-white">Masterlist</a></li>
                                                        <li class="list-inline-item"><a href="{{route('uploader.library')}}" class="text-white">Library</a></li>
                                                        <li class="list-inline-item"><a href="{{route('uploader.model')}}" class="text-white">Model</a></li>
                                                        <li class="list-inline-item"><a href="{{route('uploader.intervention')}}" class="text-white">Intervention</a></li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-4">
                                            <div class="card full-height bg-primary">
                                                <div class="card-body text-white">
                                                    <h5 class="font-weight-bold font-italic">
                                                        Masterlist
                                                    </h5>
                                                    <ul class="list-inline">
                                                        <li class="list-inline-item"><a href="{{route('employees.index')}}" class="text-white">Employee</a></li>
                                                        <li class="list-inline-item"> <a href="{{route('groups.index')}}" class="text-white">Group</a></li>
                                                        <li class="list-inline-item"><a href="{{route('divisions.index')}}" class="text-white">Division</a></li>
                                                        <li class="list-inline-item"><a href="{{route('bands.index')}}" class="text-white">Band</a></li>
                                                        <li class="list-inline-item"><a href="{{route('users.index')}}" class="text-white">User</a></li>
                                                        <li class="list-inline-item"><a href="{{route('jobs.index')}}" class="text-white">Job</a> </li>
                                                    </ul>
                                                    <h5 class="font-weight-bold font-italic">
                                                        Assessment Settings
                                                    </h5>
                                                    <ul class="list-inline">
                                                        <li class="list-inline-item"><a href="{{route('employee-relationships.index')}}" class="text-white">Employee Relationship</a> </li>
                                                        <li class="list-inline-item"><a href="{{route('assessmentTypes.index')}}" class="text-white">Assessment Type</a></li>
                                                        <li class="list-inline-item"><a href="{{route('relationshipTypes.index')}}" class="text-white">Relationship Type</a></li>
                                                    </ul>
                                                    <h5 class="font-weight-bold font-italic">
                                                        Completion Tracker
                                                    </h5>
                                                    <ul class="list-inline">
                                                        <li class="list-inline-item"><a href="{{route('completionTrackerAssignments.index')}}" class="text-white">Completion Tracker Assignment</a> </li>
                                                        <li class="list-inline-item"><a href="{{route('groupsPerGapAnalysisSettings.index')}}" class="text-white">Groups per Gap Analysis Setting</a></li>
                                                        <li class="list-inline-item"><a href="{{route('groupsPerGapAnalysisSettingRoles.index')}}" class="text-white">Groups per Gap Analysis Setting Role</a></li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane fade show" id="pills-today" role="tabpanel" aria-labelledby="pills-home-tab-nobd">
                                    <h1>Overall Completion Tracker</h1>
                                    TBA
                                </div>
                                <div class="tab-pane fade" id="pills-week" role="tabpanel" aria-labelledby="pills-profile-tab-nobd">
                                    <h1>Masterlist Statistics</h1>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                    
            </div>
            <div class="row">
                <div class="col-md-8">
                    <div class="card">
                        <div class="card-header">
                            <div class="card-head-row">
                                <div class="card-title">Report Generators</div>
                                <div class="card-tools">
                                    <a href="#" class="btn btn-info btn-border btn-round btn-sm mr-2">
                                        <span class="btn-label">
                                            <i class="fa fa-pencil"></i>
                                        </span>
                                        Export
                                    </a>
                                    <a href="#" class="btn btn-info btn-border btn-round btn-sm">
                                        <span class="btn-label">
                                            <i class="fa fa-print"></i>
                                        </span>
                                        Print
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="chart-container" style="min-height: 35vh;">
                                <div class="row">
                                    <div class="col-sm-4">
                                        <div style="min-height:28vh;"  class="pb-4">
                                            <h3 class="font-weight-bold">Current Assinged Computation:</h3>
                                            <h5><u>{{$gapAnalysisSetting->name}}</u> </h5>
                                            
                                            <p>{{$gapAnalysisSetting->description}}</p>
                                        </div>
                                        <a href="{{route('reports.view')}}" class="btn btn-info btn-block">Change Computation</a>
                                    </div>
                                    <div class="col-sm-4">
                                        <div style="min-height:28vh;" class="pb-4">
                                            <h3 class="font-weight-bold">Individual Reports:</h3>
                                            <h5 ><u>Auto-Generation PDF File Per Employee</u> </h5>
                                            
                                        </div>
                                        <a href="{{route('reports.view')}}" class="btn btn-info btn-block">Generate New PDF</a>
                                    </div>
                                    <div class="col-sm-4">
                                        <div style="min-height:28vh;" class="pb-4">
                                            <h3 class="font-weight-bold">Group Reports:</h3>
                                            <h5 ><u>Auto-Generation PPT File Per Groups Per Role</u> </h5>
                                        </div>
                                        <a href="{{route('reports.group.view')}}" class="btn btn-info btn-block" disabled>Generate New PPT</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card card-primary">
                        <div class="card-header">
                            <div class="card-title">Model Count</div>
                            <div class="card-category">Models uploaded accross all group. <a href="{{route('listOfCompetenciesPerRoles.index')}}" class="text-white"><u>See all Models >></u></a></div>
                        </div>
                        <div class="card-body pb-0">
                            <div class="mb-4 mt-2">
                                <h1>{{count($modelsAcross)}} Models</h1>
                            </div>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-body pb-0">
                            <div class="h1 fw-bold float-right text-warning">+{{$percentageEmployee}}%</div>
                            <h2 class="mb-2">{{number_format(count($allEmployees),0,".",",")}}</h2>
                            <p class="text-muted">Employees Count <a href="{{route('employees.index')}}"> (View All)</a> </p>
                            <div class="pull-in sparkline-fix">
                                <div id="lineChart"></div>
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
            $('.js-example-basic-single').select2();
        }); 
        $(document).ready(function() {
            $('#employee-datatables').DataTable();
        });
        $(document).ready(function() {
            $('#model-count-datatables').DataTable();
        });
        $(document).ready(function() {
            $('#role-competency-datatables').DataTable();
        });
        
        
    </script>

    @if ($totalModels == '0')
    <script>
            Circles.create({
                id:'circles-1',
                radius:45,
                value:100,
                maxValue:100,
                width:7,
                text: {!! json_encode($pendingModels, JSON_HEX_TAG) !!},
                colors:['#f1f1f1', '#FF9E27'],
                duration:400,
                wrpClass:'circles-wrp',
                textClass:'circles-text',
                styleWrapper:true,
                styleText:true
            })
            Circles.create({
                id:'circles-2',
                radius:45,
                value:100,
                maxValue:100,
                width:7,
                text: {!! json_encode($approvedModels, JSON_HEX_TAG) !!},
                colors:['#f1f1f1', '#2BB930'],
                duration:400,
                wrpClass:'circles-wrp',
                textClass:'circles-text',
                styleWrapper:true,
                styleText:true
            })
    
            Circles.create({
                id:'circles-3',
                radius:45,
                value:100,
                maxValue:100,
                width:7,
                text: {!! json_encode($pendingModels, JSON_HEX_TAG) !!},
                colors:['#f1f1f1', '#F25961'],
                duration:400,
                wrpClass:'circles-wrp',
                textClass:'circles-text',
                styleWrapper:true,
                styleText:true
            })
            
        </script>
    @else
    <script>
            Circles.create({
                id:'circles-1',
                radius:45,
                value:{!! json_encode($pendingModels, JSON_HEX_TAG) !!},
                maxValue:{!! json_encode($totalModels, JSON_HEX_TAG) !!},
                width:7,
                text: {!! json_encode($pendingModels, JSON_HEX_TAG) !!},
                colors:['#f1f1f1', '#FF9E27'],
                duration:400,
                wrpClass:'circles-wrp',
                textClass:'circles-text',
                styleWrapper:true,
                styleText:true
            })
            Circles.create({
                id:'circles-2',
                radius:45,
                value:{!! json_encode($approvedModels, JSON_HEX_TAG) !!},
                maxValue:{!! json_encode($totalModels, JSON_HEX_TAG) !!},
                width:7,
                text: {!! json_encode($approvedModels, JSON_HEX_TAG) !!},
                colors:['#f1f1f1', '#2BB930'],
                duration:400,
                wrpClass:'circles-wrp',
                textClass:'circles-text',
                styleWrapper:true,
                styleText:true
            })
    
            Circles.create({
                id:'circles-3',
                radius:45,
                value:{!! json_encode($pendingModels, JSON_HEX_TAG) !!},
                maxValue:{!! json_encode($totalModels, JSON_HEX_TAG) !!},
                width:7,
                text: {!! json_encode($pendingModels, JSON_HEX_TAG) !!},
                colors:['#f1f1f1', '#F25961'],
                duration:400,
                wrpClass:'circles-wrp',
                textClass:'circles-text',
                styleWrapper:true,
                styleText:true
            })
            
        </script>
    @endif
    
    <script>

        function getCol(matrix, col){
            var column = [];
            for(var i=0; i<matrix.length; i++){
                column.push(matrix[i][col]);
            }
            return column;
        }

        
        var modelName = @json($modelListCount);

        //alert(getCol(modelName,'roleName'));

        var myBarChart = new Chart(barChart, {
			type: 'bar',
			data: {
				labels: getCol(modelName,'roleName'),
				datasets : [{
					label: "Competencies",
					backgroundColor: 'rgb(23, 125, 255)',
					borderColor: 'rgb(23, 125, 255)',
					data: getCol(modelName,'total'),
				}],
			},
			options: {
				responsive: true, 
				maintainAspectRatio: false,
				scales: {
					yAxes: [{
						ticks: {
							beginAtZero:true
						}
					}]
				},
			}
		});
        var myMultipleBarChart = new Chart(multipleBarChart, {
			type: 'bar',
			data: {
				labels: ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"],
				datasets : [{
					label: "First time visitors",
					backgroundColor: '#59d05d',
					borderColor: '#59d05d',
					data: [95, 100, 112, 101, 144, 159, 178, 156, 188, 190, 210, 245],
				},{
					label: "Visitors",
					backgroundColor: '#fdaf4b',
					borderColor: '#fdaf4b',
					data: [145, 256, 244, 233, 210, 279, 287, 253, 287, 299, 312,356],
				}, {
					label: "Pageview",
					backgroundColor: '#177dff',
					borderColor: '#177dff',
					data: [185, 279, 273, 287, 234, 312, 322, 286, 301, 320, 346, 399],
				}],
			},
			options: {
				responsive: true, 
				maintainAspectRatio: false,
				legend: {
					position : 'bottom'
				},
				title: {
					display: true,
					text: 'Traffic Stats'
				},
				tooltips: {
					mode: 'index',
					intersect: false
				},
				responsive: true,
				scales: {
					xAxes: [{
						stacked: true,
					}],
					yAxes: [{
						stacked: true
					}]
				}
			}
		});
    </script>
@endsection
