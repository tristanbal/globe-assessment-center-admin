@extends('layouts.app')

@section('content')

<div class="container">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{route('home')}}">Home</a></li>
            <li class="breadcrumb-item"><a href="{{route('data-extract.index')}}">Data Extractor</a></li>
            <li class="breadcrumb-item active" aria-current="page">Raw Data Summary</li>
        </ol>
    </nav>
            
    <div class="row justify-content-center">
        <div class="col-md-12">
            <h1>Raw Data Summary</h1>
            <div class="table-responsive">
                <table id="employee-relationship-list" class="display table table-striped table-hover" cellspacing="0" width="100%">
                    <thead>
                        <tr>
                            <th>Group</th>
                            <th>Role</th>
                            <th>Assessment Type</th>
                            <th>Assessee Employee ID</th>
                            <th>Assessee Employee Name</th>
                            <th>Assessor Employee ID</th>
                            <th>Assessor Employee Name</th>
                            <th>Competency Type</th>
                            <th>Competency</th>
                            <th>Target</th>
                            <th>Wegiht</th>
                            <th>Verbatim</th>
                            <th>Additional File</th>
                            <th>Time Stamp</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($rawDataSummary as $item)
                            <tr>
                                <td>{{$item->group}}</td>
                                <td>{{$item->role}}</td>
                                <td>{{$item->assessmentType}}</td>
                                <td>{{$item->assesseeEmployeeID}}</td>
                                <td>{{$item->assesseeName}}</td>
                                <td>{{$item->assessorEmployeeID}}</td>
                                <td>{{$item->assessorName}}</td>
                                <td>{{$item->competencyType}}</td>
                                <td>{{$item->competency}}</td>
                                <td>{{$item->target}}</td>
                                <td>{{$item->weight}}</td>
                                <td>{{$item->verbatim}}</td>
                                <td>{{$item->additionalFile}}</td>
                                <td>{{$item->timestamp}}</td>
                                
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
                        title: 'Exported Raw Data'
                    },
                    {
                        extend: 'pdfHtml5',
                        title: 'Exported Raw Data'
                    },
                    {
                        extend: 'csvHtml5',
                        title: 'Exported Raw Data'
                    }
                ]
            });
        });
    </script>
@endsection