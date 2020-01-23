@extends('layouts.app')

@section('content')

<div class="container">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{route('home')}}">Home</a></li>
            <li class="breadcrumb-item active" aria-current="page">Group Per Gap Analysis Setting</li>
        </ol>
    </nav>
            
    <div class="row justify-content-center">
        <div class="col-md-12">
            <h1>Groups Per Gap Analysis Setting</h1>
            <a href="{{route('groupsPerGapAnalysisSettings.create')}}" class="btn btn-primary btn-sm">
                Add An Assignment
            </a>
            <br><br>
            <div class="table-responsive">
                <table id="basic-datatables" class="display table table-striped table-hover" cellspacing="0" width="100%">
                    <thead>
                        <tr>
                            <th>Nick Name</th>
                            <th>Data Type</th>
                            <th>Actual Name</th>
                            <th>Gap Analysis Setting ID</th>
                            <th>Created At</th>
                            <th>Updated At</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($GPASetting as $item)
                            <tr>
                                <td>{{$item->name}}</td>
                                <td>{{$item->selectedDataType}}</td>
                                <td>{{$item->dataTypeID}}</td>
                                <td>{{$item->gapAnalysisSettingID}}</td>
                                <td>{{$item->created_at}}</td>
                                <td>{{$item->updated_at}}</td>
                                <td>
                                        <div style = "display: flex;"> <a style = "float: left;" href = "{{route('groupsPerGapAnalysisSetting.show',['id'=>$item->id])}}"><div class = "btn-info btn">VIEW</div></a>
                                        <a style = "float: right;" href = "{{route('groupsPerGapAnalysisSetting.edit',['id'=>$item->id])}}"><div class = "btn-success btn">EDIT</div></a>  
                                        <a style = "float: right;" href = "{{route('groupsPerGapAnalysisSetting.destroy',['id'=>$item->id])}}"><div class = "btn-danger btn">DELETE</div></a></div>
                                </td>
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
          $('#basic-datatables').DataTable();
        });

    </script>
@endsection