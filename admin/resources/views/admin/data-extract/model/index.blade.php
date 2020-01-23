@extends('layouts.app')

@section('content')

<div class="container">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{route('home')}}">Home</a></li>
            <li class="breadcrumb-item"><a href="{{route('data-extract.index')}}">Data Extractor</a></li>
            <li class="breadcrumb-item active" aria-current="page">Model</li>
        </ol>
    </nav>
            
    <div class="row justify-content-center">
        <div class="col-md-12">
            <h1>Competency Model</h1>
            <div class="table-responsive">
                <table id="employee-relationship-list" class="display table table-striped table-hover" cellspacing="0" width="100%">
                    <thead>
                        <tr>
                            <th>Group</th>
                            <th>Role</th>
                            <th>Competency</th>
                            <th>Priority</th>
                            <th>Target  Level</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($modelSummary as $item)
                            <tr>
                                <td>{{$item->group}}</td>
                                <td>{{$item->role}}</td>
                                <td>{{$item->competency}}</td>
                                <td>{{$item->priority}}</td>
                                <td>{{$item->target}}</td>
                                
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
                        title: 'Exported Model'
                    },
                    {
                        extend: 'pdfHtml5',
                        title: 'Exported Model'
                    },
                    {
                        extend: 'csvHtml5',
                        title: 'Exported Model'
                    }
                ]
            });
        });
    </script>
@endsection