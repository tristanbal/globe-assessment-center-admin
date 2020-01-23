@extends('layouts.app')

@section('content')

<div class="container">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{route('home')}}">Home</a></li>
            <li class="breadcrumb-item active" aria-current="page">Group Per Gap Analysis Setting Role</li>
        </ol>
    </nav>
            
    <div class="row justify-content-center">
        <div class="col-md-12">
            <h1>Groups Per Gap Analysis Setting Role</h1>

            <a href="{{route('groupsPerGapAnalysisSettingRoles.create')}}" class="btn btn-primary btn-sm" >
                Add
            </a>
                <br><br>
            <div class="table-responsive">
                <table id="basic-datatables" class="display table table-striped table-hover" cellspacing="0" width="100%">
                    <thead>
                        <tr>
                            <th>Grouped Setting</th>
                            <th>Role</th>
                            <th>Created At</th>
                            <th>Updated At</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($groupsPerGapAnalysisSettingRole as $item)
                            <tr>
                                <td>{{$item->gpgas->name}}</td>
                                <td>{{$item->role->name}}</td>
                                <td>{{$item->created_at}}</td>
                                <td>{{$item->updated_at}}</td>
                                <td>
                                    <div style = "display: flex;"> <a style = "float: left;" href = "{{route('groupsPerGapAnalysisSettingRole.show',['id'=>$item->id])}}"><div class = "btn-info btn">VIEW</div></a>
                                    <a style = "float: right;" href = "{{route('groupsPerGapAnalysisSettingRole.edit',['id'=>$item->id])}}"><div class = "btn-success btn">EDIT</div></a>  
                                    <a style = "float: right;" href = "{{route('groupsPerGapAnalysisSettingRoles.delete',['id'=>$item->id])}}"><div class = "btn-danger btn">DELETE</div></a></div>
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