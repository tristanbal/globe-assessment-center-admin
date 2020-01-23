@extends('layouts.app')

@section('content')
	<div class="container">
	    <nav aria-label="breadcrumb">
	        <ol class="breadcrumb">
	            <li class="breadcrumb-item"><a href="{{route('home')}}">Home</a></li>
	            <li class="breadcrumb-item active"><a href="{{url('/admin/report/group/view-all-groups')}}">Groups Per Role Gap Analysis</a></li>
	            <li class="breadcrumb-item active" aria-current="page">{{$group->name}}</li>
	        </ol>
	    </nav>
	            
	    <div class="row justify-content-center">
	        <div class="col-md-12">
	            <button class="btn btn-info float-right check" id="filteredbutton" data-toggle="modal" data-target="#selectedRoles">Selected Roles</button>
	            <h1>{{$group->name}} Roles</h1>
	            <br><br>
	            <div class="table-responsive">
	                <table id="rolesTable" class="display table table-striped table-hover" cellspacing="0" width="100%">
	                    <thead>
	                        <tr>
	                        	<th></th>
	                            <th>Role Name</th>
	                            <th>Group Name</th>
	                            <th>Actions</th>
	                        </tr>
	                    </thead>
	                    <tbody>
	                    	@foreach($roles as $role)
	                    	<tr>
	                    		<td><input type="checkbox" name="" onchange="check(this, {{$role->id}}, '{{$role->name}}')"></td>
	                    		<td>{{$role->name}}</td>
	                    		<td>{{$group->name}}</td>
	                    		<td><a href="{{url('/admin/report/group/viewRole',$role->id)}}" class="btn btn-primary">View</a></td>
	                    	</tr>
	                    	@endforeach
	                    </tbody>
	                </table>
	            </div>

	        </div>
	    </div>
	</div>
@include('inc.settings')

<!-- Modal -->
<form method="POST" action="{{route('filteredRoles')}}">
	@csrf
	<div class="modal fade" id="selectedRoles" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
		<div class="modal-dialog modal-lg" role="document">
			<div class="modal-content">
				{{-- <div class="modal-header"> --}}
					{{-- <h5 class="modal-title" id="exampleModalLabel">Roles</h5> --}}
					{{-- <button type="button" class="close" data-dismiss="modal" aria-label="Close"> --}}
						{{-- <span aria-hidden="true">&times;</span> --}}
					{{-- </button> --}}
				{{-- </div> --}}
				<div class="modal-body">

					<ul class="nav nav-tabs" id="myTab" role="tablist">
						<li class="nav-item">
							<a class="nav-link active" id="home-tab" data-toggle="tab" href="#table" role="tab" aria-controls="table" aria-selected="true">Roles Selected</a>
						</li>
						<li class="nav-item">
							<a class="nav-link" id="contact-tab" data-toggle="tab" href="#chart" role="tab" aria-controls="chart" aria-selected="false">Charts</a>
						</li>
					</ul>

					<div class="tab-content" id="myTabContent">
					<br>
						<div class="tab-pane fade show active" id="table" role="tabpanel" aria-labelledby="home-tab">
						<table id="filteredRolestable" class="display table table-striped table-hover" cellspacing="0" width="100%">
							<thead>
								<tr>
									<th>ID</th>
									<th>Name</th>
									<th>Action</th>
								</tr>
							</thead>
							<tbody id="filteredRoles">
							</tbody>
						</table>
					</div>

					<div class="tab-pane fade" id="chart" role="tabpanel" aria-labelledby="contact-tab">
					<br>
						<div class="form-group">
							<!-- <label class="form-label">Image Check</label> -->
							<div class="row">
								<div class="col-6 col-sm-4">
									<label class="imagecheck mb-4">
										<input name="chart[]" type="checkbox" value="population" class="imagecheck-input">
										<figure class="imagecheck-figure">
											<img src="https://www.amcharts.com/wp-content/uploads/2014/01/demo_3293_light-1024x485.jpg" alt="title" class="imagecheck-image">
										</figure>
										<h5 class="text-center">Verbatim</h5>
									</label>
								</div>
								<div class="col-6 col-sm-4">
									<label class="imagecheck mb-4">
										<input name="chart[]" type="checkbox" value="completion" class="imagecheck-input">
										<figure class="imagecheck-figure">
											<img src="https://www.amcharts.com/wp-content/uploads/2013/12/demo_7395_light-1024x485.jpg" alt="title" class="imagecheck-image">
										</figure>
										<h5 class="text-center">Completion Report</h5>
									</label>
								</div>
							</div>
						</div>
					</div>

					</div>

					
				</div>
				<div class="modal-footer">
					<button type="button" class="btn" data-dismiss="modal">Close</button>
					<button type="submit" class="btn btn-primary">Submit</button>
				</div>
			</div>
		</div>
	</div>
</form>

@endsection

@section('scripts')
@include('inc.settingScript')
<script>
	$(document).ready(function() {
		$('#rolesTable').DataTable();
	});

	// $(document).ready(function() {
	// 	$('#filteredRolestable').DataTable();
	// });

	function check(elem, id, name) {
		var table = document.getElementById("filteredRoles");
		var filteredButton = document.getElementById("filteredbutton");

		var ctr = $('.check:checked').length;

		if(elem.checked)
		{
			table.innerHTML += 	"<tr id='"+ctr+"'>"+
								"<td>"+id+"</td>"+
								"<td>"+name+"</td>"+
								"<td><input type='button' name='' class='btn btn-danger' onclick='removeRow("+ctr+")' value='X'></td>"+
								"<td><input type='text' name='selected[]' hidden value='"+id+"'></td>"+
								"</tr>";
			filteredButton.disabled = false;
		}
	}

	function removeRow(rows)
	{ 
		// var _row = rows.parentElement.parentElement;
		var filteredButton = document.getElementById("filteredbutton");
		var table = document.getElementById("filteredRoles");
	 //  	table.deleteRow(rows);
	 	$('table#filteredRolestable tr#'+rows+'').remove();

	 	// alert(rows);
	 	if(rows <= 1)
	 	{
	 		filteredButton.disabled = true;
	 	}
	}
</script>
@endsection