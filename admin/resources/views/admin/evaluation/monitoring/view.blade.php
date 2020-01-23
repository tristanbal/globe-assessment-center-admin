@extends('layouts.app')

@section('content')

<div class="container">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{route('home')}}">Home</a></li>
                <li class="breadcrumb-item"><a href="{{route('evaluations.index')}}">All Evaluation</a></li>
                <li class="breadcrumb-item active" aria-current="page">{{$assesseeEmployee->employeeID}} - {{$assesseeEmployee->firstname}} {{$assesseeEmployee->lastname}}</li>
        </ol>
    </nav>
    
    


    <div class="row justify-content-center">
        <div class="col-md-12">
            <h1><span class="text-uppercase">{{$assesseeEmployee->firstname}} {{$assesseeEmployee->middlename}} {{$assesseeEmployee->lastname}}</span>: {{$assesseeRole->name}}</h1>

            @if ($assessmentType)
                <div class="row" >
                    <div class="col-sm-3" >
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="nav flex-column nav-pills nav-secondary nav-pills-no-bd" id="v-pills-tab" role="tablist" aria-orientation="vertical">
                                    @foreach ($assessmentType as $assessmentTypeItem)
                                        <a class="nav-link 
                                            @if($assessmentTypeItem->id == 1)
                                                active
                                            @endif
                                            " id="v-pills-{{$assessmentTypeItem->id}}-tab-nobd" data-toggle="pill" href="#v-pills-{{$assessmentTypeItem->id}}-nobd" role="tab" aria-controls="v-pills-{{$assessmentTypeItem->id}}-nobd" aria-selected="false">{{$assessmentTypeItem->name}}</a>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                        <div class="row pt-2">
                            <div class="col-sm-12">
                                <div class="card" style="height:100%">
                                    <div class="card-body">
                                        <h3 class="text-center text-uppercase font-weight-bold">Settings</h3>

                                        <div class="row">
                                            <div class="col-12  text-center">
                                                @if ($assessmentType)
                                                    @foreach ($assessmentType as $assessmentTypeItem)
                                                        <div class="py-2">
                                                            <h5 class="text-center">{{$assessmentTypeItem->name}}</h5>
                                                            <a href="{{route('assessments.specific.update',['id' => $assessmentTypeItem->id, 'employeeID' => $assesseeEmployee->employeeID])}}" class="btn btn-primary btn-round text-center">Reset</a>
                                                        </div>
                                                        
                                                        
                                                    @endforeach
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                    </div>
                    <div class="col-sm-9">
                        <div class="tab-content " id="v-pills-tabContent">
                            @foreach ($assessmentType as $assessmentTypeItem)
                                <div class="tab-pane fade
                                    @if($assessmentTypeItem->id == 1)
                                        show active
                                    @endif" id="v-pills-{{$assessmentTypeItem->id}}-nobd" role="tabpanel" aria-labelledby="v-pills-{{$assessmentTypeItem->id}}-tab-nobd">
                                    <div class="card">
                                        <div class="card-body">
                                            <h3 class="text-uppercase py-2 text-center"><b>{{$assessmentTypeItem->name}}</b></h3>
                                            <p>{{$assessmentTypeItem->definition}}</p>

                                            {{  Form::open(array('action' =>[ 'AssessmentController@changeVersion',$assesseeEmployee->id]))}}
                                            <div class="row">
                                                <div class="col-sm-8">
                                                    <div class="form-group ">
                                                        <label>Current Assigned Versioning:</label>
                                                        <select id="test{{$assessmentTypeItem->id}}" class="form-control js-example-basic-single-{{$assessmentTypeItem->id}}" name="evaluationID" style="width:100%;" required>
                                                            @if(count($evaluation) > 0)
                                                                <option value = "" disabled selected>SELECT A VERSIONING</option>
                                        
                                                                @foreach ($evaluation as $item)
                                                                    @if ($item->assessment->assessmentTypeID == $assessmentTypeItem->id)
                                                                        <option value = "{{$item->id}}" 
                                                                                @if ($item->assessment->evaluationVersionID == $item->id)
                                                                                selected
                                                                                 
                                                                             @endif>
                                                                            ASM-{{$item->id}} | {{$item->assesseeRole->name}} 
                                                                        </option>
                                                                    @endif
                                                                @endforeach
                                                            @else
                                                                <option value = "" disabled selected>No Versioning found</option>
                                                            @endif
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-sm-4">
                                                    <div class="form-group ">
                                                        <input type="text" name="assessmentTypeID" value="{{$assessmentTypeItem->id}}" hidden>
                                                        <label>To Update Version, Click Here:</label>
                                                        <button class=" btn btn-success " type="submit">Change Version</button>
                                                    </div>
                                                    
                                                    
                                                </div>
                                            </div>
                                            {{Form::hidden('_method', 'POST')}}
                                            {{ Form::close() }}
                                            

                                            @if ($completionTrackerIndividual)
                                                @foreach ($completionTrackerIndividual as $item)
                                                    @if ($item->completion == 1 && $item->assessmentTypeID == $assessmentTypeItem->id)
                                                        <div class="alert alert-success" role="alert">
                                                            {{$item->assessmentType}} is completed. All competencies were answered.
                                                        </div>
                                                    @elseif ($item->completion == 2 && $item->assessmentTypeID == $assessmentTypeItem->id)
                                                        <div class="alert alert-warning" role="alert">
                                                            {{$item->assessmentType}} is in completed. Some competencies were unanswered.
                                                        </div>

                                                    @elseif ($item->completion == 0 && $item->assessmentTypeID == $assessmentTypeItem->id)
                                                        <div class="alert alert-danger" role="alert">
                                                            No assessment found, pending assessment.
                                                        </div>
                                                    @endif
                                                @endforeach
                                            @endif
                                            <br>
                                            @foreach ($employeeRelationshipList as $employeeRelationshipListRow)
                                                @if ($employeeRelationshipListRow->relationshipID == $assessmentTypeItem->relationshipID)
                                                <div class="table-responsive">
                                                    <table id="evaluation-datatables-{{$employeeRelationshipListRow->assessorEmployeeID}}" class="display table table-striped table-hover" cellspacing="0" width="100%">
                                                        <thead>
                                                            <tr>
                                                                <th>Competency</th>
                                                                <th>Weight - Level Attained</th>
                                                                <th>Verbatim</th>
                                                                <th>Action</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            @foreach ($answeredEvaluations as $answeredEvaluationRow)
                                                                @if ($answeredEvaluationRow->assessmentTypeID == $assessmentTypeItem->id && 
                                                                    $employeeRelationshipListRow->assessorEmployeeID == $answeredEvaluationRow->assessorEmployeeID )
                                                                    <tr>
                                                                        <td>{{$answeredEvaluationRow->competency}}</td>
                                                                        <td>{{$answeredEvaluationRow->answeredScore}}</td>
                                                                        <td>{{$answeredEvaluationRow->verbatim}}</td>
                                                                        <td><!-- Button trigger modal -->
                                                                            <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#exampleModal">
                                                                              Delete
                                                                            </button>
                                                                            
                                                                            <!-- Modal -->
                                                                            <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                                              <div class="modal-dialog" role="document">
                                                                                <div class="modal-content">
                                                                                  <div class="modal-header">
                                                                                    <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
                                                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                                      <span aria-hidden="true">&times;</span>
                                                                                    </button>
                                                                                  </div>
                                                                                  <div class="modal-body">
                                                                                    Are you sure you want to delete the answered competency of {{$answeredEvaluationRow->competency}}?
                                                                                  </div>
                                                                                  <div class="modal-footer">
                                                                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                                                    <a href="{{route('evaluationCompetencies.destroy', ['id' => $answeredEvaluationRow->id])}}" class="btn btn-danger">Delete</a>
                                                                                  </div>
                                                                                </div>
                                                                              </div>
                                                                            </div></td>
                                                                    </tr>
                                                                    
                                                                @endif
                                                            @endforeach 
                                                        </tbody>
                                                    </table>
                                                </div>
                                                
                                                @endif
                                                
                                            @endforeach
                                                    
                                            
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                            <!--
                            OLD COLD HERE
                            -->
                        </div>
                    </div>
                </div>
            @endif
            
        </div>
    </div>
</div>


@endsection

@section('scripts')
@foreach ($assessmentType as $assessmentTypeItem)
    <script>    
        $(document).ready(function() {
            $('.js-example-basic-single-{{$assessmentTypeItem->id}}').select2();
        }); 
    </script>
@endforeach


@if ($assessmentType)
    
    @foreach ($assessmentType as $assessmentTypeItem)
        @foreach ($employeeRelationshipList as $employeeRelationshipListRow)
            @if ($employeeRelationshipListRow->relationshipID == $assessmentTypeItem->relationshipID)
                <script>
                    $(document).ready(function() {
                        $('#evaluation-datatables-{{$employeeRelationshipListRow->assessorEmployeeID}}').DataTable();
                    });
                </script>
            @endif
            
        @endforeach
    @endforeach
@endif

@endsection