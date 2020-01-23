@extends('layouts.app')

@section('content')

<div class="container">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{route('home')}}">Home</a></li>
            <li class="breadcrumb-item"><a href="{{route('evaluations.index')}}">All Assessment</a></li>
            <li class="breadcrumb-item active" aria-current="page">Specific Assessment Type</li>
        </ol>
    </nav>
            
    <div class="row justify-content-center">
        <div class="col-md-12">
            <h1>Evaluations</h1>
            <div class="row">
                <div class="col-sm-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="table-responsive">
                                <table id="assessment-type-datatables" class="display table table-striped table-hover" cellspacing="0" width="100%">
                                    <thead>
                                        <tr>
                                            <th>EmployeeID</th>
                                            <th>First Name</th>
                                            <th>Last Name</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
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
<script type="text/javascript">
    $(document).ready(function() {
         $('#assessment-type-datatables').DataTable({
            "processing": true,
            "serverSide": true,
            "ajax": "{{route('evaluations.assessment.ajaxdata',['id'=>$id])}}",
            "columns":[
                { data: "employeeID",name:"employee_datas.employeeID"},
                { data: "firstname",name:"employee_datas.firstname"},
                { data: "lastname",name:"employee_datas.lastname"},
                { 
                    data: "id",                   
                    "render": function ( data, type, row ) {
                        var view  = '<div style = "display: flex;"> <a style = "float: left;" href = "'+ {{$id}} +'/'+ row.employeeID + '"><div class = "btn-info btn">VIEW</div></a></div>';   
                        return view;
                    }
                }
                
            ]
         });
    });
</script>

@endsection