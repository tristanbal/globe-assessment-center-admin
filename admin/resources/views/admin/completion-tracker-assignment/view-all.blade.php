@extends('layouts.app')

@section('content')

<div class="container">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{route('home')}}">Home</a></li>
            <li class="breadcrumb-item active" aria-current="page">Completion Tracker Assignment</li>
        </ol>
    </nav>
            
    <div class="row justify-content-center">
        <div class="col-md-12">
            <h1>Completion Tracker Assignment</h1>
                <div class="row">
                    <div class="col-sm-9">
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
                    <div class="col-sm-3">

                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-4">
                        <a href="{{route('completionTrackerAssignments.create')}}" class="btn btn-primary btn-sm btn-block" >
                            Add An Assignment
                        </a>
                    </div>
                    <div class="col-sm-4">
                        <a href="{{route('completionTrackerAssignments.create')}}" class="btn btn-info btn-sm btn-block" >
                            Add Groups Per Gap Analysis Setting
                        </a>
                    </div>
                    <div class="col-sm-4">
                        <a href="{{route('completionTrackerAssignments.create')}}" class="btn btn-success btn-sm btn-block" >
                            Add Groups Per Gap Analysis Setting Role
                        </a>
                    </div>
                </div>
                <br>
                
            </div>
        </div>
    </div>
</div>


@endsection

@section('scripts')
    <script>
        $(document).ready(function() {
          $('#basic-datatables').DataTable();
        });

    </script>
@endsection