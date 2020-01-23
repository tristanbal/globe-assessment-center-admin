@extends('layouts.app')

@section('content')

<div class="container">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{route('home')}}">Home</a></li>
            <li class="breadcrumb-item active" aria-current="page">Model Submissions</li>
        </ol>
    </nav>
    <div class="row justify-content-center">
        <ul class="nav nav-pills nav-secondary  nav-pills-no-bd nav-pills-icons justify-content-center mb-3" id="pills-tab" role="tablist">
            <li class="nav-item">
                <a class="nav-link active" id="pills-home-tab-icon" data-toggle="pill" href="#pills-home-icon" role="tab" aria-controls="pills-home-icon" aria-selected="true">
                <i class="flaticon-exclamation"></i>
                Pending &nbsp;
                @if($pendingModel)
                <span class="badge badge-warning">{{count($pendingModel)}}</span>
                @endif
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="pills-profile-tab-icon" data-toggle="pill" href="#pills-profile-icon" role="tab" aria-controls="pills-profile-icon" aria-selected="false">
                <i class="flaticon-hands"></i>
                Approved
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="pills-contact-tab-icon" data-toggle="pill" href="#pills-contact-icon" role="tab" aria-controls="pills-contact-icon" aria-selected="false">
                <i class="flaticon-hands-1"></i>
                Rejected
                </a>
            </li>
        </ul>
    </div>
    <div class="row justify-content-center">
        <div class="col-12">
            <div class="tab-content mb-3" id="pills-tabContent">
                <div class="tab-pane fade show active" id="pills-home-icon" role="tabpanel" aria-labelledby="pills-home-tab-icon">
                    <h1>Pending Models</h1>
                    <div class="table-responsive">
                        <table id="basic-datatables-2" class="display table table-striped table-hover" cellspacing="0" width="100%">
                            <thead>
                                <tr>
                                    <th>Ticket ID</th>
                                    <th>Employee ID</th>
                                    <th>Group</th>
                                    <th>Role Name</th>
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
                <div class="tab-pane fade" id="pills-profile-icon" role="tabpanel" aria-labelledby="pills-profile-tab-icon">
                    <h1>Approved Models</h1>
                    <div class="table-responsive">
                        <table id="basic-datatables-1" class="display table table-striped table-hover" cellspacing="0" width="100%">
                            <thead>
                                <tr>
                                    <th>Ticket ID</th>
                                    <th>Employee ID</th>
                                    <th>Group</th>
                                    <th>Role Name</th>
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
                <div class="tab-pane fade" id="pills-contact-icon" role="tabpanel" aria-labelledby="pills-contact-tab-icon">
                    <h1>Rejected Models</h1>
                    <div class="table-responsive">
                        <table id="basic-datatables-3" class="display table table-striped table-hover" cellspacing="0" width="100%">
                            <thead>
                                <tr>
                                    <th>Ticket ID</th>
                                    <th>Employee ID</th>
                                    <th>Group</th>
                                    <th>Role Name</th>
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

    </div>
            
    <div class="row justify-content-center">
        <div class="col-md-12">
            
            <br>
            
        </div>
    </div>
</div>


@endsection

@section('scripts')
    <script type="text/javascript">
        $(document).ready(function() {
            $('#basic-datatables-1').DataTable({
                "processing": true,
                "serverSide": true,
                "ajax": "{{route('models.submissions.approved.ajax')}}",
                "columns":[
                    { data: "ticketID", name: "order_models.ticketID"},
                    { data: "employeeID", name: "order_models.employeeID"},
                    { data: "groupName", name: "groups.name"},
                    { data: "roleName", name: "order_models.roleName"},
                    { data: "created_at", name: "order_models.created_at"},
                    { data: "updated_at", name: "order_models.updated_at"},
                    { 
                        data: "id",                   
                        "render": function ( data, type, row ) {
                            var view  = '<div style = "display: flex;"> <a style = "float: left;" href = "submission/approve/'+ row.id +'"><div class = "btn-info btn">VIEW</div></a></div>';
                            return view;
                        }
                    }
                    
                ]
            });
        });
        $(document).ready(function() {
            $('#basic-datatables-2').DataTable({
                "processing": true,
                "serverSide": true,
                "ajax": "{{route('models.submissions.pending-approval.ajax')}}",
                "columns":[
                    { data: "ticketID", name: "order_models.ticketID"},
                    { data: "employeeID", name: "order_models.employeeID"},
                    { data: "groupName", name: "groups.name"},
                    { data: "roleName", name: "order_models.roleName"},
                    { data: "created_at", name: "order_models.created_at"},
                    { data: "updated_at", name: "order_models.updated_at"},
                    { 
                        data: "id",                   
                        "render": function ( data, type, row ) {
                            var view  = '<div style = "display: flex;"> <a style = "float: left;" href = "submission/approve/'+ row.id +'"><div class = "btn-info btn">VIEW</div></a></div>';
                            return view;
                        }
                    }
                    
                ]
            });
        });
        $(document).ready(function() {
            $('#basic-datatables-3').DataTable({
                "processing": true,
                "serverSide": true,
                "ajax": "{{route('models.submissions.not-approved.ajax')}}",
                "columns":[
                    { data: "ticketID", name: "order_models.ticketID"},
                    { data: "employeeID", name: "order_models.employeeID"},
                    { data: "groupName", name: "groups.name"},
                    { data: "roleName", name: "order_models.roleName"},
                    { data: "created_at", name: "order_models.created_at"},
                    { data: "updated_at", name: "order_models.updated_at"},
                    { 
                        data: "id",                   
                        "render": function ( data, type, row ) {
                            var view  = '<div style = "display: flex;"> <a style = "float: left;" href = "submission/approve/'+ row.id +'"><div class = "btn-info btn">VIEW</div></a></div>';
                            return view ;
                        }
                    }
                    
                ]
            });
        });
    </script>
@endsection