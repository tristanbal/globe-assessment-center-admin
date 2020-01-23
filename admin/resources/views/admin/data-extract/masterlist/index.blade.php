@extends('layouts.app')

@section('content')

<div class="container">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{route('home')}}">Home</a></li>
            <li class="breadcrumb-item"><a href="{{route('data-extract.index')}}">Data Extractor</a></li>
            <li class="breadcrumb-item active" aria-current="page">Masterlist</li>
        </ol>
    </nav>
            
    <div class="row justify-content-center">
        <div class="col-md-12">
            <h1>Masterlist</h1>
            <div class="table-responsive">
                <table id="employee-relationship-list" class="display table table-striped table-hover" cellspacing="0" width="100%">
                    <thead>
                        <tr>
                            <th>Employee ID</th>
                            <th>Group</th>
                            <th>Division</th>
                            <th>Department</th>
                            <th>Section</th>
                            <th>First Name</th>
                            <th>Last Name</th>
                            <th>Middle Name</th>
                            <th>Name Suffix</th>
                            <th>Role</th>
                            <th>Band</th>
                            <th>Supervisor ID</th>
                            <th>Email</th>
                            <th>Phone</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($employeeDataSummary as $item)
                            <tr>
                                <td>{{$item->employeeID}}</td>
                                <td>{{$item->group}}</td>
                                <td>{{$item->division}}</td>
                                <td>{{$item->department}}</td>
                                <td>{{$item->section}}</td>
                                <td>{{$item->firstname}}</td>
                                <td>{{$item->lastname}}</td>
                                <td>{{$item->middlename}}</td>
                                <td>{{$item->namesuffix}}</td>
                                <td>{{$item->role}}</td>
                                <td>{{$item->band}}</td>
                                <td>{{$item->supervisorID}}</td>
                                <td>{{$item->email}}</td>
                                <td>{{$item->phone}}</td>
                                
                            </tr>
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
            $('#employee-relationship-list').DataTable({
                dom: 'Bfrtip',
                buttons: [
                    {
                        extend: 'copyHtml5'
                    },
                    {
                        extend: 'excelHtml5',
                        title: 'Exported Masterlist'
                    },
                    {
                        extend: 'pdfHtml5',
                        title: 'Exported Masterlist'
                    },
                    {
                        extend: 'csvHtml5',
                        title: 'Exported Masterlist'
                    }
                ]
            });
        });
    </script>
@endsection