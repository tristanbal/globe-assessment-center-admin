@extends('layouts.app')

@section('content')

<div class="container">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{route('home')}}">Home</a></li>
            <li class="breadcrumb-item"><a href="{{route('reports.view')}}">Invidual Gap Analysis</a></li>
            <li class="breadcrumb-item"><a href="{{url('admin/report/individual/view-all', $employee->groupID)}}">{{$group->name}}</a></li>
            <li class="breadcrumb-item active" aria-current="page">{{$employee->employeeID}} - {{$employee->firstname}} {{$employee->lastname}}</li>
        </ol>
	</nav>
	@if ($completionTrackerIndividual)
		@foreach ($completionTrackerIndividual as $item)
			@if ($item->completion == 1)
				<div class="alert alert-success" role="alert">
					{{$item->assessmentType}} is completed. All competencies were answered.
				</div>
			@elseif ($item->completion == 2 )
				<div class="alert alert-warning" role="alert">
					{{$item->assessmentType}} is in completed. Some competencies were unanswered.
				</div>

			@elseif ($item->completion == 0 )
				<div class="alert alert-danger" role="alert">
					No assessment found, pending assessment.
				</div>
			@endif
		@endforeach
	@endif
	<br>
    <img id="imgToExport" src="{{asset('GUicon.PNG')}}" style="display: none">
	    <a class="btn btn-default" style="cursor: pointer; float: right;" id="exportButton" value="Export to PDF" onclick="exportReport();"><i class="fas fa-file-signature"></i>
			INDIVIDUAL REPORT
		</a>
		<button style="float: right; display: none" id="showExportLoader" class="btn btn-default is-loading">
			Please Wait...
		</button>
    <h4 class="page-title">Gap analysis for:</h4>
  	<h1><strong>{{$employee->lastname}}, {{$employee->firstname}}</strong></h1>

  	<?php 
  		$ctrStr = 0;
  		$ctrDevA = 0;
  		$ctrCore = 0;
  		$ctrSupp = 0;
  		$ctrDev = 0;
  		$ctrAll = 0;
  		$role = " ";
  		// $supervisor = " ";
  		$countAss = 0;
  		$assessmentDate = " ";
  	?>

  	@if($competencies)
	@foreach($competencies as $competency)
    	@if($competency->gap <= 0)
		<?php $ctrStr++; ?>
		@endif
	@endforeach
	@endif

	@if($competencies)
	@foreach($competencies as $competency)
    	@if($competency->gap > 0)
		<?php $ctrDevA++; ?>
		@endif
	@endforeach
	@endif

	@if($competencies)
        @foreach($competencies as $competency)
	    	@if($competency->compTypeName == 'CORE')
            <?php  
            	$ctrCore++;
            	$ctrAll++;
            ?>
            @elseif($competency->compTypeName == 'SUPPORT')
            <?php  
            	$ctrSupp++;
            	$ctrAll++;
            ?>
            @elseif($competency->compTypeName == 'DEVELOPMENTAL')
            <?php  
            	$ctrDev++;
            	$ctrAll++;
            ?>
            @endif
        @endforeach               
	@endif

    <?php 
    	if($assessmentTypes)
    	{
    		$countAss = count($assessmentTypes);
    	}
    ?>
    <div class="row">
    	@if($assessmentTypes)
    	@foreach($assessmentTypes as $assessmentType)
    	<?php 
    		$role = $assessmentType->roleName 
    	?>
    	@if($countAss == 1)
        	<div class="col-md-12">
        @elseif($countAss)
        	<div class="col-md-6">
       	@endif
            <br><br>
            <div class="card">
                <div class="card-body">
                	<h2 style="text-align: center; letter-spacing: 3px">{{$assessmentType->name}}</h2>
                	<hr style="border: 3px solid black; width: 10%;">
                	<h4 style="text-align: center" class="box-title">For the (current) Role: {{$assessmentType->roleName}}<strong></strong></h4>
		            <div class="table-responsive">
		                <table id="assessment{{$assessmentType->id}}" class="display table table-striped table-hover" cellspacing="0" width="100%">
		                    <thead>
		                        <tr>
		                            <th>Competency</th>
		                            <th>Level Given</th>
		                            <th>Given Score</th>
		                        </tr>
		                    </thead>
		                    <tbody>
		                    @if($competencies)
			                    @if($gapanalysis)
			                    	@foreach($competencies as $competency)
			                    		@foreach($gapanalysis as $gap)
		                    				@if($competency->id == $gap->competencyID && $assessmentType->name == $gap->name)
					                    	<tr>
					                    		<td>{{$competency->name}}</td>
					                    		<td>{{$gap->levelName}}</td>
				                    			@if($gap->givenLevelID != 0)
				                    			<td>{{$gap->givenLevelID - 1}}</td>
				                    			@else
				                    			<td>{{$gap->givenLevelID}}</td>
				                    			@endif
					                    	</tr>
			                    			@endif
			                    		@endforeach
			                    	@endforeach
			                    @endif
		                   	@endif
		                    </tbody>
		                </table>
		            </div>
	           </div>
	        </div>
        </div>
        @endforeach
        @endif

        <br><br>
        <div class="col-md-12">
            <br><br>
            <div class="card">
                <div class="card-body">
		            <div class="table-responsive">
		                <table id="gapanalysis" class="display table table-striped table-hover" cellspacing="0" width="100%">
		                    <thead>
		                        <tr>
		                            <th>Competency</th>
		                            <th>Priority</th>
		                            @if($assessmentTypes)
    								@foreach($assessmentTypes as $assessmentType)
    									<th>{{$assessmentType->name}} score</th>
    									@if(strtoupper($assessmentType->name) != strtoupper('self-assessment'))
    									{{-- <th>{{$assessmentType->name}}</th> --}}
    									@endif
		                            @endforeach
		                            @endif
		                            <th>Target Score</th>
		                            <th>Total Weight</th>
		                            <th>Gap Analysis</th>
		                        </tr>
		                    </thead>
		                    <tbody>
		                    	@if($competencies)
		                    	@foreach($competencies as $competency)
		                    		<tr>
		                    			<td>{{$competency->name}}</td>
		                    			<td>{{$competency->compTypeName}}</td>
		                    			@if($assessmentTypes)
		                    			@foreach($assessmentTypes as $assessmentType)
			                    			<?php
			                                  $gapQuery = DB::select('select eval.id, ass_type.name, comp.name as competencyName, level.levelName as levelName, (gap_set_type.percentAssigned / 100 * eval_comp.givenLevelID) as weightScore, eval.assesseeEmployeeID, eval.assessorEmployeeID, eval.assesseeRoleID, eval.assessorRoleID, eval_comp.competencyID, eval_comp.givenLevelID, eval_comp.competencyTypeID, eval_comp.verbatim, empData.assEmpID, empData.empFirstName as assessorFirstName, empData.empLastname as assessorLastName, eval_comp.created_at as assDate from
			                                                  (select * from gap_analysis_settings where is_active = 1 and deleted_at is NULL) as gap_set
			                                                  join
			                                                  (select * from gap_analysis_setting_assessment_types where deleted_at is NULL) as gap_set_type
			                                                  on gap_set.id = gap_set_type.gas_id_foreign
			                                                  join
			                                                  (select * from assessments where assessments.employeeID = '.$employee->id.' and deleted_at is NULL) as ass
			                                                  on ass.assessmentTypeID = gap_set_type.assessmentTypeID
			                                                  join
			                                                  (select * from evaluations where deleted_at is NULL) as eval
			                                                  on ass.evaluationVersionID = eval.id
			                                                  join
			                                                  (select * from assessment_types where deleted_at is NULL) as ass_type
			                                                  on ass.assessmentTypeID = ass_type.id
			                                                  join
			                                                  (select * from evaluation_competencies where deleted_at is NULL) as eval_comp
			                                                  on eval_comp.evaluationID = eval.id
			                                                  join
			                                                  (select id, name as levelName, weight as weightLevel from levels where deleted_at is NULL) as level
			                                                  on level.id = eval_comp.givenLevelID
			                                                  join
			                                                  (select * from competencies where deleted_at is NULL) as comp
			                                                  on eval_comp.competencyID = comp.id
			                                                  join
			                                                  (select id, employeeID as assEmpID, firstname as empFirstName, lastname as empLastName from employee_datas where employee_datas.firstname <> "employee" and deleted_at is NULL) as empData
			                                                  on eval.assessorEmployeeID = empData.id WHERE eval_comp.competencyID = '.$competency->id.' and ass_type.name = "'.$assessmentType->name.'"');
			                                   ?>
		                                   	@if($gapQuery)
		                                       @if($gapQuery[0]->givenLevelID != 0)
		                                       <td>{{$gapQuery[0]->givenLevelID - 1}}</td>
		                                       @else
		                                       <td>{{$gapQuery[0]->givenLevelID}}</td>
		                                       @endif
	                                     	@else
	                                     	<td>0</td>
	                                     	@endif
	                                  	@endforeach
		                                @endif
		                                @if($competency->targetLevelID != 0)
		                                <td>{{$competency->targetLevelID - 1}}</td>
		                                @else
		                                <td>{{$competency->targetLevelID}}</td>
		                                @endif

		                                @if($competency->totalWeight != 0 )
		                    			<td>{{number_format($competency->totalWeight - 1, 2, '.', '')}}</td>
		                    			@else
		                    			<td>{{number_format($competency->totalWeight, 2, '.', '')}}</td>
		                    			@endif

										
										@if( number_format($competency->gap, 3, '.', '') > 0)
		                    			<td style="background-color: red; color: white">{{number_format($competency->gap, 3, '.', '') }}</td>
		                    			@else
		                    			<td>{{number_format($competency->gap, 3, '.', '') }}</td>
		                    			@endif
		                    		</tr>
		                    	@endforeach
		                    	@endif
		                    </tbody>
		                </table>
		            </div>
	           	</div>
	        </div>
        </div>

        <br><br>
        <div class="col-md-12">
            <br><br>
            <div class="card">
                <div class="card-body">
					@if($ctrStr > 0)
                	<h2 style="text-align: center; letter-spacing: 3px">Cluster chart for Strenghts</h2>
                	<hr style="border: 3px solid black; width: 10%;">
                	<div id="StrengthsClusterChart" class = "chartDiv"></div>
                	@else
                	<div class="alert alert-danger" role="alert">
					<i class="fas fa-window-close fa-lg"></i> Sorry! There's no cluster chart for Strenghts.
					</div>
                	@endif
                </div>
            </div>
        </div>

        <br><br>
        <div class="col-md-12">
            <br><br>
            <div class="card">
                <div class="card-body">
                	@if($ctrDevA > 0)
                	<h2 style="text-align: center; letter-spacing: 3px">Cluster chart for Developmental Areas</h2>
                	<hr style="border: 3px solid black; width: 10%;">
                	<div id="DevelopmentalAreasClusterChart" class = "chartDiv"></div>
                	@else
                	<div class="alert alert-danger" role="alert">
					<i class="fas fa-window-close fa-lg"></i> Sorry! There's no cluster chart for Developmental Areas.
					</div>
                	@endif
                </div>
            </div>
        </div>

        @if($competencyTypes)
        @foreach($competencyTypes as $competencyType)
    	<br><br>
        <div class="col-md-12">
            <br><br>
            <div class="card">
            	<br>
            	<h2 style="text-align: center; letter-spacing: 3px">{{$competencyType->name}}</h2>
            	<!-- <hr style="border: 3px solid black; width: 10%;"> -->
                <div class="card-body">
	            	<div class="accordion accordion-primary">
						<div class="card">
							<div class="card-header " id="headingOne" data-toggle="collapse" data-target="#{{$competencyType->name}}collapse" aria-expanded="true" aria-controls="collapseOne">
								<div class="span-icon">
									<div class="flaticon-box-1"></div>
								</div>
								<div class="span-title">
									{{$competencyType->name}} TABLE
								</div>
								<div class="span-mode"></div>
							</div>

							<div id="{{$competencyType->name}}collapse" class="collapse show" aria-labelledby="headingOne" data-parent="#accordion">
								<div class="card-body">
									<div class="table-responsive">
						                <table id="{{$competencyType->name}}specificChart" class="display table table-striped table-hover" cellspacing="0" width="100%">
						                    <thead>
						                        <tr>
						                            <th>Competency</th>
						                            <th>Priority</th>
						                            @if($assessmentTypes)
				    								@foreach($assessmentTypes as $assessmentType)
				    									<th>{{$assessmentType->name}} score</th>
						                            @endforeach
						                            @endif
						                            <th>Target Score</th>
						                            <th>Total Weight</th>
						                            <th>Gap Analysis</th>
						                        </tr>
						                    </thead>
						                    <tbody>
						                    	@if($competencies)
						                    	@foreach($competencies as $competency)
						                    		@if($competency->compTypeName == $competencyType->name)
						                    		<tr>
						                    			<td>{{$competency->name}}</td>
						                    			<td>{{$competency->compTypeName}}</td>
						                    			@if($assessmentTypes)
						                    			@foreach($assessmentTypes as $assessmentType)
							                    			<?php
							                                  $gapQuery = DB::select('select eval.id, ass_type.name, comp.name as competencyName, level.levelName as levelName, (gap_set_type.percentAssigned / 100 * eval_comp.givenLevelID) as weightScore, eval.assesseeEmployeeID, eval.assessorEmployeeID, eval.assesseeRoleID, eval.assessorRoleID, eval_comp.competencyID, eval_comp.givenLevelID, eval_comp.competencyTypeID, eval_comp.verbatim, empData.assEmpID, empData.empFirstName as assessorFirstName, empData.empLastname as assessorLastName, eval_comp.created_at as assDate from
							                                                  (select * from gap_analysis_settings where is_active = 1 and deleted_at is NULL) as gap_set
							                                                  join
							                                                  (select * from gap_analysis_setting_assessment_types where deleted_at is NULL) as gap_set_type
							                                                  on gap_set.id = gap_set_type.gas_id_foreign
							                                                  join
							                                                  (select * from assessments where assessments.employeeID = '.$employee->id.' and deleted_at is NULL) as ass
							                                                  on ass.assessmentTypeID = gap_set_type.assessmentTypeID
							                                                  join
							                                                  (select * from evaluations where deleted_at is NULL) as eval
							                                                  on ass.evaluationVersionID = eval.id
							                                                  join
							                                                  (select * from assessment_types where deleted_at is NULL) as ass_type
							                                                  on ass.assessmentTypeID = ass_type.id
							                                                  join
							                                                  (select * from evaluation_competencies where deleted_at is NULL) as eval_comp
							                                                  on eval_comp.evaluationID = eval.id
							                                                  join
							                                                  (select id, name as levelName, weight as weightLevel from levels where deleted_at is NULL) as level
							                                                  on level.id = eval_comp.givenLevelID
							                                                  join
							                                                  (select * from competencies where deleted_at is NULL) as comp
							                                                  on eval_comp.competencyID = comp.id
							                                                  join
							                                                  (select id, employeeID as assEmpID, firstname as empFirstName, lastname as empLastName from employee_datas where employee_datas.firstname <> "employee" and deleted_at is NULL) as empData
							                                                  on eval.assessorEmployeeID = empData.id WHERE eval_comp.competencyID = '.$competency->id.' and ass_type.name = "'.$assessmentType->name.'"');
							                                   ?>
						                                   	@if($gapQuery)
						                                       @if($gapQuery[0]->givenLevelID != 0)
						                                       <td>{{$gapQuery[0]->givenLevelID - 1}}</td>
						                                       @else
						                                       <td>{{$gapQuery[0]->givenLevelID}}</td>
						                                       @endif
					                                     	@else
					                                     	<td>0</td>
					                                     	@endif
					                                  	@endforeach
						                                @endif
						                                @if($competency->targetLevelID != 0)
						                                <td>{{$competency->targetLevelID - 1}}</td>
						                                @else
						                                <td>{{$competency->targetLevelID}}</td>
						                                @endif
						                    			@if($competency->totalWeight != 0  )
						                    			<td>{{number_format($competency->totalWeight - 1, 2, '.', '')}}</td>
						                    			@else
						                    			<td>{{number_format($competency->totalWeight, 2, '.', '')}}</td>
														@endif
														
														@if( number_format($competency->gap, 3, '.', '') > 0)
														<td style="background-color: red; color: white">{{number_format($competency->gap, 3, '.', '') }}</td>
														@else
														<td>{{number_format($competency->gap, 3, '.', '') }}</td>
														@endif
						                    		</tr>
						                    		@endif
						                    	@endforeach
						                    	@endif
						                    </tbody>
						                </table>
						            </div>
						            <br>
						            @if($competencies)
			                    	@foreach($competencies as $competency)
			                    		@if($competency->compTypeName == $competencyType->name)
			                    			@if($assessmentTypes)
			                    			@foreach($assessmentTypes as $assessmentType)
				                    			@if($gapanalysis)
												@foreach($gapanalysis as $gap)
				                    				@if($competency->id == $gap->competencyID && $assessmentType->name == $gap->name)
				    									@if($gap->verbatim != 'N/A')
				    									
				    										<div class="alert alert-info" role="alert">
																<blockquote class="blockquote mb-0">
																<p><strong>{{$competency->name}}</strong> - {{$gap->verbatim}}</p>
																<footer class="blockquote-footer">{{$assessmentType->name}} <cite title="Source Title">({{$gap->assessorFirstName}})</cite></footer>
																</blockquote>
															</div>

				    									@endif
			    									@endif
		    									@endforeach
			    								@endif
				                            @endforeach
				                            @endif
			                    		@endif
			                    	@endforeach
			                    	@endif
								</div>
							</div>
						</div>
					</div>
					<br><br>
                    @if($competencies)
                    <h4 style="text-align: center; letter-spacing: 3px">Radar chart for {{$competencyType->name}} competencies</h4>
                    <hr style="border: 3px solid black; width: 5%;"> 
                    <div id="{{$competencyType->name}}RadarChart" class = "chartDiv"></div>
                    @else
                    <div class="alert alert-danger" role="alert">
                    <i class="fas fa-window-close fa-lg"></i> Sorry! There's no radar chart for {{$competencyType->name}} competencies.
                    </div>
                    @endif

                    @if($competencies)
                    <br><br>
                    <h4 style="text-align: center; letter-spacing: 3px">Cluster chart for {{$competencyType->name}} competencies</h4>
                    <hr style="border: 3px solid black; width: 5%;"> 
					<div id="{{$competencyType->name}}ClusterChart" class = "chartDivCluster"></div>
					
					<!-- HTML -->
					<div id="{{$competencyType->name}}chartdiv" class="chartDivCluster" ></div>	
                    @else
                    <div class="alert alert-danger" role="alert">
                    <i class="fas fa-window-close fa-lg"></i> Sorry! There's no cluster chart for {{$competencyType->name}} competencies.
                    </div>
                    @endif
                	
				</div>
			</div>
        </div>

        <script>
        var chart = AmCharts.makeChart("{{$competencyType->name}}RadarChart", {
        // "titles": [
        //     {
        //         "text": "Radar Chart for {{$competencyType->name}} Competencies",
        //         "size": 15
        //     }
        // ],
        "type": "radar",
		"fontSize": 15,
        "theme": "light",
        "dataProvider": [
        @if($competencies)
	    	@foreach($competencies as $competency)
		    	@if($competency->compTypeName == $competencyType->name)
		    	<?php
              	$out = strlen($competency->name) > 30 ? substr($competency->name,0,30)."..." : $competency->name;
              	?>
				{
					"competency" : "{{trim(preg_replace('/\s+/', ' ', $out))}}",
				    @if($competency->targetLevelID != 0)
                        "target": {{$competency->targetLevelID - 1}},
                    @else
                        "target": {{$competency->targetLevelID}},
                    @endif

                    @if($competency->totalWeight != 0)
                        "attained":  {{$competency->totalWeight - 1}},
                    @else
                        "attained":  {{$competency->totalWeight}},
                    @endif

					@foreach($competencyTargets as $competencyTarget)
						@if($competency->competencyID == $competencyTarget->competencyID)
						"{{$competencyTarget->targetName}}":  {{$competencyTarget->competencyTargetID - 1}},
						@endif 
					@endforeach
				},
				@endif
			@endforeach
    	@endif
        ],
        "startDuration": 1,
        "graphs": [{
            "balloonText": "Competency Target Weight: [[value]]",
            "bullet": "round",
            "title": "Target Weight",
            "valueField": "target",
            "lineColor": "#0759A7"
        }, {
            "balloonText": "[[value]] Attained",
            "bullet": "square",
            "title": "Attained Weight",
            "valueField": "attained",
            "valueAxis": "v2",
            "lineColor": "#FFCC33",
        },
		@if($competencyTargetNames)
			@foreach($competencyTargetNames as $competencyTargetName)
			{
				"balloonText": "[[value]] Benchmark ({{$competencyTargetName->targetName}})",
				"bullet": "square",
				"title": "Benchmark ({{$competencyTargetName->targetName}})",
				"valueField": "{{$competencyTargetName->targetName}}",
				"valueAxis": "v3",
			},
			@endforeach
		@endif
		
		],
        "legend": {
		    "useGraphSettings": "true",
		    "align": "center",
	  	},
        "categoryField": "competency",
        "export": {
            "enabled": true
        },
        "responsive": {
	    	"enabled": true
	  	},"valueAxes": [
            {
                "id": "ValueAxis-1",
                "position": "top",
				"minimum": 0,
				"maximum": 5,
				"precision":0,
				
            }
        ],
    	});
    	</script>

    	<script>
        var chart = AmCharts.makeChart("{{$competencyType->name}}ClusterChart", {

            "type": "serial",
            "theme": "light",
            "categoryField": "competency",
            "rotate": true,
            "name": "{{$competencyType->name}}ClusterChart",
            "startDuration": 1,
            "categoryAxis": {
                "gridPosition": "start",
                "position": "left"
            },
            "trendLines": [],
            "graphs": [
                {
                    "balloonText": "Target Weight:[[value]]",
                    "fillAlphas": 0.8,
                    "lineAlpha": 0.2,
                    "columnWidth": 0.9,
                    "title": "Target",
                    "type": "column",
                    "valueField": "target",
                    // "fillColors": "#3366CC"
                },
                {
                    "balloonText": "Attained Weight:[[value]]",
                    "fillAlphas": 0.8,
                    "lineAlpha": 0.2,
                    "columnWidth": 0.9,
                    "title": "Attained",
                    "type": "column",
                    "valueField": "attained",
                    // "fillColors": "#FFCC33"
                },
				@if($competencyTargetNames)
					@foreach($competencyTargetNames as $competencyTargetName)
					{
	                    "balloonText": "Benchmark ({{$competencyTargetName->targetName}}):[[value]]",
	                    "fillAlphas": 0.8,
	                    "lineAlpha": 0.2,
                    "columnWidth": 0.9,
	                    "title": "Benchmark ({{$competencyTargetName->targetName}})",
	                    "type": "column",
	                    "valueField": "{{$competencyTargetName->targetName}}",
	                    // "fillColors": "green"
	                },
					@endforeach
				@endif
                @if($assessmentTypes)
					@foreach($assessmentTypes as $assessmentType)
					{
	                    "balloonText": "{{$assessmentType->name}} Score:[[value]]",
	                    "fillAlphas": 0.8,
	                    "lineAlpha": 0.2,
                    "columnWidth": 0.9,
	                    "title": "{{$assessmentType->name}} Score",
	                    "type": "column",
	                    "valueField": "{{$assessmentType->name}}",
	                    // "fillColors": "green"
	                },
                    @endforeach
                @endif
				
                
            ],
            "guides": [],
            "valueAxes": [
                {
                    "id": "ValueAxis-1",
                    "position": "top",
                    "axisAlpha": 0,
					"minimum": 0,
					"maximum": 5,
					"precision":0
                }
            ],
            "allLabels": [],
			"fontSize": 13,
            "balloon": {},
            "dataProvider": [
    		@if($competencies)
            @foreach($competencies as $competency)
		    	@if($competency->compTypeName == $competencyType->name)
                {
                "competency" : "{{$competency->name}}",
                @if($competency->targetLevelID != 0)
                    "target": {{$competency->targetLevelID - 1}},
                @else
                    "target": {{$competency->targetLevelID}},
                @endif

                @if($competency->totalWeight != 0)
                    "attained":  {{$competency->totalWeight - 1}},
                @else
                    "attained":  {{$competency->totalWeight}},
                @endif
                @if($assessmentTypes)
                @foreach($assessmentTypes as $assessmentType)
                    @if($gapanalysis)
                    @foreach($gapanalysis as $gap)
                        @if($competency->id == $gap->competencyID && $assessmentType->name == $gap->name)
                            "{{$assessmentType->name}}": {{$gap->givenLevelID - 1}},
							@foreach($competencyTargets as $competencyTarget)
								@if($competency->competencyID == $competencyTarget->competencyID)
								"{{$competencyTarget->targetName}}":  {{$competencyTarget->competencyTargetID - 1}},
								@endif 
							@endforeach
                        @endif      
                    @endforeach
                    @endif
                @endforeach
                @endif
                },  
                @endif
            @endforeach               
			@endif
            ],
            "export": {
                "enabled": true
            },
            "legend": {
			    "useGraphSettings": "true",
			    "align": "center",
			    "position": "right"
		  	},
	        "categoryField": "competency",
	        "export": {
	            "enabled": true
	        },
	        "responsive": {
		    	"enabled": true
		  	}

        });
		</script>
		<!-- Chart code -->
<script>
		var chart = AmCharts.makeChart("{{$competencyType->name}}chartdiv", {
		   "type": "serial",
		   "theme": "light",
		   "handDrawn":false,
		   "handDrawScatter":3,
		   "fontSize": 15,
		   "legend": {
			   "useGraphSettings": true,
			   "markerSize":12,
			   "valueWidth":0,
			   "verticalGap":0
		   },
		   "dataProvider": [
    		@if($competencies)
            @foreach($competencies as $competency)
		    	@if($competency->compTypeName == $competencyType->name)
                {
                "competency" : "{{$competency->name}}",
				@if($competency->targetLevelID != 0)
                    "target": {{$competency->targetLevelID - 1}},
                @else
                    "target": {{$competency->targetLevelID}},
                @endif

                @if($competency->totalWeight != 0)
                    "attained":  {{$competency->totalWeight - 1}},
                @else
                    "attained":  {{$competency->totalWeight}},
                @endif
                @if($assessmentTypes)
                @foreach($assessmentTypes as $assessmentType)
                    @if($gapanalysis)
                    @foreach($gapanalysis as $gap)
                        @if($competency->id == $gap->competencyID && $assessmentType->name == $gap->name)
                            "{{$assessmentType->name}}": {{$gap->givenLevelID - 1}},
							@foreach($competencyTargets as $competencyTarget)
								@if($competency->competencyID == $competencyTarget->competencyID)
								"{{$competencyTarget->targetName}}":  {{$competencyTarget->competencyTargetID - 1}},
								@endif 
							@endforeach
                        @endif      
                    @endforeach
                    @endif
                @endforeach
                @endif
                },  
                @endif
            @endforeach               
			@endif
            ],
		   "valueAxes": [
                {
                    "id": "ValueAxis-1",
                    "position": "top",
                    "axisAlpha": 0,
					"minimum": 0,
					"maximum": 5,
					"precision":0
                }
            ],
		   "startDuration": 1,
		   "graphs": [{
			   "balloonText": "<span style='font-size:13px;'>[[title]] in [[competency]]:<b>[[value]]</b></span>",
			   "title": "Attained",
			   "type": "column",
			   "fillAlphas": 0.8,
	   
			   "valueField": "attained"
		   }, {
			   "balloonText": "<span style='font-size:13px;'>[[title]] in [[competency]]:<b>[[value]]</b></span>",
			   "bullet": "round",
			   "bulletBorderAlpha": 1,
			   "bulletColor": "#FFFFFF",
			   "useLineColorForBulletBorder": true,
			   "fillAlphas": 0,
			   "lineThickness": 2,
			   "lineAlpha": 1,
			   "bulletSize": 7,
			   "title": "Target",
			   "valueField": "target"
		   },@if($competencyTargetNames)
					@foreach($competencyTargetNames as $competencyTargetName)
					{
	                    "balloonText": "Benchmark ({{$competencyTargetName->targetName}}):[[value]]",

						"bullet": "round",
						"bulletBorderAlpha": 1,
						//"bulletColor": "#FFFFFF",
						"useLineColorForBulletBorder": true,
						"fillAlphas": 0,
						"lineThickness": 2,
						"lineAlpha": 1,
						"bulletSize": 7,
						"title": "Benchmark ({{$competencyTargetName->targetName}})",
						"valueField": "{{$competencyTargetName->targetName}}"
	                },
					@endforeach
				@endif
                
		   ],
		   "rotate": true,
		   "categoryField": "competency",
		   "categoryAxis": {
			   "gridPosition": "start"
		   },
		   "export": {
			   "enabled": true
			}
	   
	   });
	   </script>
	   

        @endforeach
        @endif

    </div>

    <br><br>
    <div class="col-md-12">
        <br><br>
        <div class="card">
            <div class="card-body">
            	@if($competencies)
            	<h2 style="text-align: center; letter-spacing: 3px">Radar chart for All Competencies</h2>
            	<hr style="border: 3px solid black; width: 10%;">
            	<div id="allCompetenciesRadarChart" class = "chartDiv"></div>
            	@else
            	<div class="alert alert-danger" role="alert">
				<i class="fas fa-window-close fa-lg"></i> Sorry! There's no radar chart for All Competencies.
				</div>
            	@endif
            </div>
        </div>
    </div>

    <br><br>
    <div class="col-md-12">
        <br><br>
        <div class="card">
            <div class="card-body">
            	@if($competencies)
            	<h2 style="text-align: center; letter-spacing: 3px">Cluster chart for All Competencies</h2>
            	<hr style="border: 3px solid black; width: 10%;">
            	<div id="allCompetenciesClusterChart" class = "chartDivClusterAll"></div>
            	@else
            	<div class="alert alert-danger" role="alert">
				<i class="fas fa-window-close fa-lg"></i> Sorry! There's no cluster chart for All Competencies.
				</div>
            	@endif
            </div>
        </div>
    </div>
        

<style>
.chartDiv {
  width: 100%;
  height: 500px;
}

.chartDivCluster {
	width: 100%;
	height: 700px;
}

.chartDivClusterAll {
	width: 100%;
	height: 1000px;
}

.amcharts-export-menu-top-right {
  top: 10px;
  right: 0;
}
</style>

@endsection

@section('scripts')
	
	<script>
	@if($ctrStr > 0)
	var chart = AmCharts.makeChart("StrengthsClusterChart", {
	// "titles": [
	//     {
	//         "text": "Cluster Chart for Strengths",
	//         "size": 15
	//     }
	// ],
	"type": "serial",
	"theme": "light",
	"categoryField": "competency",
	"name": "Strengths",
  	"number": {{$ctrStr}},
	"panEventsEnabled": false,
	"rotate": true,
	"fontSize": 13,
	"startDuration": 1,
	"categoryAxis": {
		"gridPosition": "start",
		"position": "left"
	},
	"responsive": {
	    "enabled": true
	  },
	"trendLines": [],
	"graphs": [
	{
		"balloonText": "Target Proficiency:[[value]]",
		"fillAlphas": 0.8,
		"lineAlpha": 0.2,
		"title": "Target Proficiency",
		"type": "column",
		"valueField": "target",
	},	
	{
		"balloonText": "Weighted Score:[[value]]",
		"fillAlphas": 0.8,
		"lineAlpha": 0.2,
		"title": "Weighted Score",
		"type": "column",
		"valueField": "weighted",
	},
	],
	"guides": [],
	"valueAxes": [
	{
		"id": "ValueAxis-1",
		"position": "top",
		"axisAlpha": 0
	}
	],
	"allLabels": [],
	"fontSize": 13,
	"balloon": {},
	"dataProvider": [
	@if($competencies)
	@foreach($competencies as $competency)
    	@if($competency->gap <= 0)
		{
			"competency" : "{{$competency->name}}",
	     	@if($competency->targetLevelID != 0)
	        	"target": {{$competency->targetLevelID - 1}},
	      	@else
	        	"target": {{$competency->targetLevelID}},
	      	@endif

	      	@if($competency->totalWeight != 0)
	        	"weighted":  {{$competency->totalWeight - 1}},
	      	@else
	        	"weighted":  {{$competency->totalWeight}},
	      	@endif
		},
		@endif
	@endforeach
	@endif
    ],
	"export": {
		"enabled": true
	},
	"legend": {
	    "useGraphSettings": "true",
	    "align": "center",
  	},

	});
	@endif

	@if($ctrDevA > 0)
	var chart = AmCharts.makeChart("DevelopmentalAreasClusterChart", {
	// "titles": [
	//     {
	//         "text": "Cluster Chart for Developmental Areas",
	//         "size": 15
	//     }
	// ],
	"type": "serial",
	"theme": "light",
	"categoryField": "competency",
	"name": "DevelopmentalAreas",
	"panEventsEnabled": false,
	"rotate": true,
	"fontSize": 13,
	"startDuration": 1,
	"categoryAxis": {
		"gridPosition": "start",
		"position": "left"
	},
	"responsive": {
    	"enabled": true
  	},
	"trendLines": [],
	"graphs": [
	{
		"balloonText": "Target Proficiency:[[value]]",
		"fillAlphas": 0.8,
		"lineAlpha": 0.2,
		"title": "Target Proficiency",
		"type": "column",
		"valueField": "target",
	},	
	{
		"balloonText": "Weighted Score:[[value]]",
		"fillAlphas": 0.8,
		"lineAlpha": 0.2,
		"title": "Weighted Score",
		"type": "column",
		"valueField": "weighted",
	},
	],
	"guides": [],
	"valueAxes": [
	{
		"id": "ValueAxis-1",
		"position": "top",
		"axisAlpha": 0
	}
	],
	"allLabels": [],
	"fontSize": 13,
	"balloon": {},
	"dataProvider": [
	@if($competencies)
    	@foreach($competencies as $competency)
    	@if($competency->gap > 0)
		{
			"competency" : "{{$competency->name}}",
		    @if($competency->targetLevelID != 0)
	        	"target": {{$competency->targetLevelID - 1}},
	      	@else
	        	"target": {{$competency->targetLevelID}},
	      	@endif

	      	@if($competency->totalWeight != 0)
	        	"weighted":  {{$competency->totalWeight - 1}},
	      	@else
	        	"weighted":  {{$competency->totalWeight}},
	      	@endif
		},
		@endif
		@endforeach
	@endif
    ],
	"export": {
		"enabled": true
	},
	"legend": {
	    "useGraphSettings": "true",
	    "align": "center",
  	},

	});
	@endif
	</script>

	
    <script>
    var chart = AmCharts.makeChart("allCompetenciesRadarChart", {
    // "titles": [
    //     {
    //         "text": "Radar Chart for {{$competencyType->name}} Competencies",
    //         "size": 15
    //     }
    // ],
    "type": "radar",
	"fontSize": 15,
    "theme": "light",
    "dataProvider": [
    @if($competencies)
    	@foreach($competencies as $competency)
	    	<?php
          	$out = strlen($competency->name) > 35 ? substr($competency->name,0,35)."..." : $competency->name;
          	?>
			{
				"competency" : "{{trim(preg_replace('/\s+/', ' ', $out))}}",
			    "target": {{$competency->targetLevelID - 1}},
			    "attained":  {{$competency->totalWeight}},
			},
		@endforeach
	@endif
    ],
    "startDuration": 1,
    "graphs": [{
        "balloonText": "Competency Target Weight: [[value]]",
        "bullet": "round",
        "title": "Target Weight",
        "valueField": "target",
        // "lineColor": "#0759A7"
    }, {
        "balloonText": "[[value]] Attained",
        "bullet": "square",
        "title": "Attained Weight",
        "valueField": "attained",
        "valueAxis": "v2",
        "lineColor": "#FFCC33",
    }],
    "legend": {
	    "useGraphSettings": "true",
	    "align": "center",
  	},
    "categoryField": "competency",
    "export": {
        "enabled": true
    },
    "responsive": {
    	"enabled": true
  	},
	});
	</script>

	
	<script>
    var chart = AmCharts.makeChart("allCompetenciesClusterChart", {
        // "titles": [
        //     {
        //         "text": "Cluster Chart for {{$competencyType->name}} Competencies",
        //         "size": 15
        //     }
        // ],
        "type": "serial",
        "theme": "light",
        "categoryField": "competency",
        "rotate": true,
        "startDuration": 1,
        "categoryAxis": {
            "gridPosition": "start",
            "position": "left"
        },
        "trendLines": [],
        "graphs": [
            {
                "balloonText": "Target Weight:[[value]]",
                "fillAlphas": 0.8,
                "lineAlpha": 0.2,
                "title": "Target",
                "type": "column",
                "valueField": "target",
                // "fillColors": "#3366CC"
            },
            {
                "balloonText": "Attained Weight:[[value]]",
                "fillAlphas": 0.8,
                "lineAlpha": 0.2,
                "title": "Attained",
                "type": "column",
                "valueField": "attained",
                // "fillColors": "#FFCC33"
            },
            @if($assessmentTypes)
				@foreach($assessmentTypes as $assessmentType)
				{
                    "balloonText": "{{$assessmentType->name}} Score:[[value]]",
                    "fillAlphas": 0.8,
                    "lineAlpha": 0.2,
                    "title": "{{$assessmentType->name}} Score",
                    "type": "column",
                    "valueField": "{{$assessmentType->name}}",
                    // "fillColors": "green"
                },
                @endforeach
            @endif
            
        ],
        "guides": [],
        "valueAxes": [
            {
                "id": "ValueAxis-1",
                "position": "top",
                "axisAlpha": 0
            }
        ],
        "allLabels": [],
		"fontSize": 13,
        "balloon": {},
        "dataProvider": [
        @if($competencies)
        @foreach($competencies as $competency)
        {
        "competency" : "{{$competency->name}}",
        "target":  {{$competency->targetLevelID - 1}},
        "attained": {{$competency->totalWeight}},
        @if($assessmentTypes)
		@foreach($assessmentTypes as $assessmentType)
			@if($gapanalysis)
			@foreach($gapanalysis as $gap)
				@if($competency->id == $gap->competencyID && $assessmentType->name == $gap->name)
        		"{{$assessmentType->name}}": {{$gap->givenLevelID}},
				@endif		
			@endforeach
			@endif
    	@endforeach
        @endif
        },  
        @endforeach
        @endif               
        ],
        "export": {
            "enabled": true
        },
        "legend": {
		    "useGraphSettings": "true",
		    "align": "center",
		    "position": "right"
	  	},
        "categoryField": "competency",
        "export": {
            "enabled": true
        },
        "responsive": {
	    	"enabled": true
	  	}

    });
    </script>


	<script type="text/javascript">
		
		 	$(document).ready(function() {
	 		@if($assessmentTypes)
				@foreach($assessmentTypes as $assessmentType)
		     	$('#assessment{{$assessmentType->id}}').DataTable({
				});
				@endforeach
			@endif

			@if($competencyTypes)
				@foreach($competencyTypes as $competencyType)
				$('#{{$competencyType->name}}specificChart').DataTable({
					});
		    	@endforeach
	    	@endif

	    	$('#gapanalysis').DataTable({
				});

	    	$('#competencyTargetTable').DataTable({
				});
	    	});
    		
	</script>

	@include('inc.extractReportScript')

@endsection