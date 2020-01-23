@extends('layouts.app')

@section('content')

<div class="container">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{route('home')}}">Home</a></li>
            <li class="breadcrumb-item active" aria-current="page">Employees</li>
        </ol>
    </nav>
            
    <div class="row justify-content-center">
        <div class="col-md-12">
            <h1>Employees</h1>
            <a href="{{route('employees.create')}}" class="btn btn-primary btn-sm" >
                    Add Employee
            </a>
            <br><br>
            <div class="table-responsive">
                <table id="basic-datatables" class="display table table-striped table-hover" cellspacing="0" width="100%">
                    <thead>
                        <tr>
                            <th>Employee ID</th>
                            <th>First Name</th>
                            <th>Last Name</th>
                            <th>Email</th>
                            <th>Created At</th>
                            <th>Updated At</th>
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


@endsection

@section('scripts')
<script type="text/javascript">
    $(document).ready(function() {
         $('#basic-datatables').DataTable({
            dom: 'Bfrtip',
                buttons: [
                    'copy', 'csv', 'excel', 'pdf', 'print'
                ],
            "processing": true,
            "serverSide": true,
            "ajax": "{{route('employees.ajaxdata')}}",
            "columns":[
                { data: "employeeID"},
                { data: "firstname"},
                { data: "lastname"},
                { data: "email"},
                { data: "created_at"},
                { data: "updated_at"},
                { 
                    data: "employeeID",                   
                    "render": function ( data, type, row ) {
                        var view  = '<div style = "display: flex;"> <a style = "float: left;" href = "employee/view/'+ row.id +'"><div class = "btn-info btn">VIEW</div></a>';
                        var edit =  '<a style = "float: right;" href = "employee/edit/'+ row.id +'"><div class = "btn-success btn">EDIT</div></a>';
                        var del =  '<a style = "float: right;" href = "employee/delete/'+ row.id +'"><div class = "btn-danger btn">DELETE</div></a></div>';
                        return view +  edit + del;
                    }
                }
                
            ]
         });
    });
</script>
@endsection