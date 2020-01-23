@extends('layouts.app')

@section('content')

<div class="container">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{route('home')}}">Home</a></li>
            <li class="breadcrumb-item active" aria-current="page">Groups Per Role Gap Analysis</li>
        </ol>
    </nav>
            
    <div class="row justify-content-center">
        <div class="col-md-12">{{-- 
            <button type="button" class="btn btn-primary float-right" data-toggle="modal" data-target="#settings">
              Report Settings
            </button> --}}
            <h1>Groups Per Role Gap Analysis</h1>
            <br>
            <div class="table-responsive">
                <table id="groupTable" class="display table table-striped table-hover" cellspacing="0" width="100%">
                    <thead>
                        <tr>
                            <th>Group Name</th>
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

@include('inc.settings')


@endsection

@section('scripts')
@include('inc.settingScript')
<script type="text/javascript">
    $(document).ready(function() {
         $('#groupTable').DataTable({
            "processing": true,
            "serverSide": true,
            "ajax": "{{route('groups.ajaxdata')}}",
            "columns":[
                { data: "name"},
                { 
                    data: "id",                   
                    "render": function ( data, type, row ) {
                        var view  = '<div style = "display: flex;"> <a style = "float: left;" href = "view-groups-per-role/'+row.id+'"><div class = "btn-info btn">VIEW</div></a>'; 
                        return view;
                    }
                }
                
            ]
         });
    });
</script>
@endsection