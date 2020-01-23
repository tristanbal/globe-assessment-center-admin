@extends('layouts.app-home')

@section('content')

<div class="">
    <div class="content ">
        <div class="panel-header bg-primary-gradient ">
            <div class="page-inner py-5 ">
                <div class="d-flex align-items-left align-items-md-center flex-column flex-md-row">
                    <div>
                        <h2 class="text-white pb-2 fw-bold">Assessment Overall Tracker</h2>
                        <h5 class="text-white op-7 mb-2">Exported and processed data of the assessment center.</h5>
                    </div>
                    <div class="ml-md-auto py-2 py-md-0">
                        <a href="{{route('users.index')}}" class="btn btn-white btn-border btn-round mr-2">Manage Users</a>
                    </div>
                </div>
            </div>
        </div>
        <div class="page-inner mt--5">
            <div class="row mt--2 ">
                <div class="col-md-6">
                    
                </div>
                <div class="col-md-6 ">
                    
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
    <script>
        $(document).ready(function() {
            $('.js-example-basic-single').select2();
        }); 
        $(document).ready(function() {
            $('#employee-datatables').DataTable();
        });
        $(document).ready(function() {
            $('#model-count-datatables').DataTable();
        });
        $(document).ready(function() {
            $('#role-competency-datatables').DataTable();
        });
    </script>
@endsection
