@extends('layouts.app')

@section('content')
	<div class="container">
	    <nav aria-label="breadcrumb">
	        <ol class="breadcrumb">
	            <li class="breadcrumb-item"><a href="{{route('home')}}">Home</a></li>
	            <li class="breadcrumb-item active"><a href="{{url('/admin/report/group/view-all-groups')}}">Groups</a></li>
	            <li class="breadcrumb-item active"><a href="{{url('/admin/report/group/view-groups-per-role', $groupID->groupID)}}">Roles</a></li>
	            <li class="breadcrumb-item active" aria-current="page">{{$role->name}}</li>
	        </ol>
	    </nav>
	            
	    <div class="row justify-content-center">
	        <div class="col-md-12">
	            <h1>{{$role->name}}</h1>
	            <br><br>
	            <div class="table-responsive">
	                <table id="roleTable" class="display table table-striped table-hover" cellspacing="0" width="100%">
	                    <thead>
	                        <tr>
	                        	<th>Group</th>
	                        	<th>Type</th>
	                        	<th>Competency</th>
	                        	<th>Role</th>
	                        	<th>Average Gap</th>
	                        	<th>Failed Tally</th>
	                        	<th>Passed Tally</th>
	                        	<th>Overall Tally</th>
	                        </tr>
	                    </thead>
	                    <tbody>
	                    	@foreach($listOfCompetenciesPerRoles as $listOfCompetenciesPerRole)
	                    		@if($gapAnalysis)
		                    	@foreach($gapAnalysis as $gap)
			                    	@if($gap->competencyID == $listOfCompetenciesPerRole->id)
			                    	<tr>
			                    		<td>{{$listOfCompetenciesPerRole->grpName}}</td>
			                    		<td>{{$listOfCompetenciesPerRole->compType}}</td>
			                    		<td>{{$listOfCompetenciesPerRole->competency}}</td>
			                    		<td>{{$listOfCompetenciesPerRole->roleName}}</td>
			                    		@if($gap->averageGap >= 0)
			                    			<td>{{$gap->averageGap}}</td>
			                    		@else 
			                    			<td style="background-color: red; color: white">{{$gap->averageGap}}</td>
			                    		@endif
			                    		<td>{{$gap->failedTally}}</td>
			                    		<td>{{$gap->passedTally}}</td>
			                    		<td>{{$gap->overallTally}}</td>
			                    	@endif
		                    	@endforeach
	                    		@endif
	                    	@endforeach
	                    </tbody>
	                </table>
	            </div>

	        </div>
	    </div>
	</div>
@endsection

@section('scripts')
<script>
	$(document).ready(function() {
		$('#roleTable').DataTable();
	});
</script>
@endsection