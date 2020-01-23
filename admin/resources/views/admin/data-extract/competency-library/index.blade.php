@extends('layouts.app')

@section('content')

<div class="container">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{route('home')}}">Home</a></li>
            <li class="breadcrumb-item"><a href="{{route('data-extract.index')}}">Data Extractor</a></li>
            <li class="breadcrumb-item active" aria-current="page">Competency Library</li>
        </ol>
    </nav>
            
    <div class="row justify-content-center">
        <div class="col-md-12">
            <h1>Competency Library</h1>
            <div class="table-responsive">
                <table id="employee-relationship-list" class="display table table-striped table-hover" cellspacing="0" width="100%">
                    <thead>
                        <tr>
                            <th>Cluster ID</th>
                            <th>Cluster</th>
                            <th>Subcluster</th>
                            <th>Talent Segment</th>
                            <th>Competency</th>
                            <th>Competency Element</th>
                            <th>Competency Definition</th>
                            <th>Proficiency Level One</th>
                            <th>Proficiency Level Two</th>
                            <th>Proficiency Level Three</th>
                            <th>Proficiency Level Four</th>
                            <th>Proficiency Level Five</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($finalCompetency as $item)
                            <tr>
                                <td>{{$item->clusterID}}</td>
                                <td>{{$item->cluster}}</td>
                                <td>{{$item->subcluster}}</td>
                                <td>{{$item->talentSegment}}</td>
                                <td>{{$item->competencyName}}</td>
                                <td>N/A</td>
                                <td>{!! nl2br($item->competencyDefinition) !!}</td>
                                <td>{!! nl2br($item->level1) !!}</td>
                                <td>{!! nl2br($item->level2) !!}</td>
                                <td>{!! nl2br($item->level3) !!}</td>
                                <td>{!! nl2br($item->level4) !!}</td>
                                <td>{!! nl2br($item->level5) !!}</td>
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
            var buttonCommon = {
                exportOptions: {
                    format: {
                        body: function ( data, row, column, node ) {
                            // Strip $ from salary column to make it numeric
                            return column === 5 ?
                            data.replace(/<br>/g,String.fromCharCode(10)) :
                                data;
                        }
                    }
                }
            };
            $('#employee-relationship-list').DataTable({
                dom: 'Bfrtip',
                buttons: [
                    {
                        extend: 'copyHtml5'
                    },
                    {
                        extend: 'excelHtml5',
                        title: 'Exported Competency Library',
                        exportOptions: {
                            columns: [ 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11 ]
                        }
                    },
                    {
                        extend: 'pdfHtml5',
                        title: 'Exported Competency Library',
                        exportOptions: {
                            columns: [ 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11 ]
                        }
                    },
                    {
                        extend: 'csvHtml5',
                        title: 'Exported Competency Library',
                        exportOptions: {
                            columns: [ 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11 ]
                        }
                    }
                ]
            });
        });
    </script>
@endsection