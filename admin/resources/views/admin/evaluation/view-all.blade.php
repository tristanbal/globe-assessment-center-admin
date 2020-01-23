@extends('layouts.app')

@section('content')

<div class="container">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{route('home')}}">Home</a></li>
            <li class="breadcrumb-item active" aria-current="page">All Evaluation</li>
        </ol>
    </nav>
            
    <div class="row justify-content-center">
        <div class="col-md-12">
            <h1>Evaluations</h1>
            <div class="row">
                <div class="col-sm-4">
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="card bg-dark text-white">
                                <div class="card-img"  style="background-color:#0759A7; min-height:30vh" alt="Card image"></div>
                                <div class="card-img-overlay">
                                    <h5 class="card-title text-white">Assessment Individual Result</h5>
                                    <p class="card-text">This module allows you to see the result of an employee's assessment.</p>
                                    <p class="card-text"><a href="{{route('evaluations.employee')}}" class="btn btn-success">View</a></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="card bg-dark text-white">
                                <div class="card-img"  style="background-color:#0759A7; min-height:30vh" alt="Card image"></div>
                                <div class="card-img-overlay">
                                    <h5 class="card-title text-white">Assessment Group Result</h5>
                                    <p class="card-text">This module allows you to see the result of an employee's assessment.</p>
                                    <p class="card-text"></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="card bg-dark text-white">
                                <div class="card-img"  style="background-color:#574696; min-height:30vh" alt="Card image"></div>
                                <div class="card-img-overlay">
                                    <h5 class="card-title text-white">Raw Data Export</h5>
                                    <p class="card-text">This module allows you to export all raw data of the assessment center.</p>
                                    <p class="card-text"><a href="" class="btn btn-success">Expport</a></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-12">
                    <div class="card">
                        <div class="card-body">
                            <h3 class=" text-center text-uppercase"><b>Employee</b> -  Assessment Monitoring System</h3>
                            <h5 class=" text-center">All found answered assessments, whether complete or incomplete shall be displayed here.</h5>
                            <hr> 
                            <div class="table-responsive">
                                <table id="all-employee" class="display table table-striped table-hover" cellspacing="0" width="100%">
                                    <thead>
                                        <tr>
                                            <th>Time Stamp</th>
                                            <th>Employee ID</th>
                                            <th>First Name</th>
                                            <th>Last Name</th>
                                            <th>Email</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($employee as $employeeItem)
                                            <tr>
                                                <td>{{$employeeItem->updated_at}}</td>
                                                <td>{{$employeeItem->employeeID}}</td>
                                                <td>{{$employeeItem->firstname}}</td>
                                                <td>{{$employeeItem->lastname}}</td>
                                                <td>{{$employeeItem->email}}</td>
                                                <td><div style = "display: flex;"> <a style = "float: left;" href = "evaluation/view/{{$employeeItem->id}}"><div class = "btn-info btn">VIEW</div></a></div></td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-6">
                    
                    
                    
                </div>
                <div class="col-sm-6">
                    <div class="card">
                        <div class="card-body">
                            <h3 class=" text-center text-uppercase">Specific Assessment Search</h3>
                            <hr> 
                            <div class="table-responsive">
                                <table id="assessment-type-datatables" class="display table table-striped table-hover" cellspacing="0" width="100%">
                                    <thead>
                                        <tr>
                                            <th>Assessment Type</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($assessmentType as $item)
                                            <tr>
                                                <td>{{$item->name}}</td>
                                                <td><div style = "display: flex;"> <a style = "float: left;" href = "evaluation/{{$item->id}}"><div class = "btn-info btn">VIEW</div></a></td>
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
            $('#assessment-type-datatables').DataTable();
        });
        $(document).ready(function() {
            $('#all-employee').DataTable();
        });
        
    </script>
@endsection