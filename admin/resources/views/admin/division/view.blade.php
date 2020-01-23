@extends('layouts.app')

@section('content')

<div class="container">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{route('home')}}">Home</a></li>
            <li class="breadcrumb-item"><a href="{{route('divisions.index')}}">Division</a></li>
            <li class="breadcrumb-item active" aria-current="page">{{$division->name}}</li>
        </ol>
    </nav>
            
    <div class="row justify-content-center">
        <div class="col-md-12">
            <h1>{{$division->name}}</h1>
            <h3>Assigned Group: {{$group->name}}</h3>
            <h3 class="">Employees under {{$division->name}}</h3>
                <div class="table-responsive">
                    <table id="employee-datatables" class="display table table-striped table-hover" cellspacing="0" width="100%">
                        <thead>
                            <tr>
                                <th>Employee ID</th>
                                <th>First Name</th>
                                <th>Last Name</th>
                                <th>Email</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($employee as $item)
                                <tr>
                                    <td>{{$item->employeeID}}</td>
                                    <td>{{$item->firstname}}</td>
                                    <td>{{$item->lastname}}</td>
                                    <td>{{$item->email}}</td>
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
    var selectedDivision = @json($division->name);
    $(document).ready(function() {
        $('#employee-datatables').DataTable({
            dom: 'Bfrtip',
            buttons: [
                //'copy', 'csv', 'excel', 'pdf', 'print'
                {
                    extend: 'copyHtml5'
                },
                {
                    extend: 'excelHtml5',
                    title: selectedDivision + ' Employees'
                },
                {
                    extend: 'pdfHtml5',
                    title: selectedDivision + ' Employees'
                },
                {
                    extend: 'csvHtml5',
                    title: selectedDivision + ' Employees'
                }
            ]
        });
    });
</script>
@endsection