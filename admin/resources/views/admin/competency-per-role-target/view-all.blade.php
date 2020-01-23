@extends('layouts.app')

@section('content')

<div class="container">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{route('home')}}">Home</a></li>
            <li class="breadcrumb-item active" aria-current="page">Competency-Role Target</li>
        </ol>
    </nav>
            
    <div class="row justify-content-center">
        <div class="col-md-12">
            <h1>Competency-Role Target</h1>
            <!-- Button trigger modal -->
            <a href="{{route('competencyRoleTargets.create')}}" class="btn btn-primary btn-sm" >
                Add Target
            </a>
            <br><br>
            <div class="table-responsive">
                <table id="basic-datatables" class="display table table-striped table-hover" cellspacing="0" width="100%">
                    <thead>
                        <tr>
                            <th>Role</th>
                            <th>Competency</th>
                            <th>Target</th>
                            <th>Source</th>
                            <th>Created At</th>
                            <th>Updated At</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($competencyPerRoleTarget as $item)
                            
                            <tr>
                                <td>{{$item->role->name}}</td>
                                <td>{{$item->competency->name}}</td>
                                <td>{{$item->competencyTarget->weight}}</td>
                                <td>{{$item->source->name}}</td>
                                <td>{{$item->created_at}}</td>
                                <td>{{$item->updated_at}}</td>
                                <td><div style = "display: flex;"> <a style = "float: left;" href = "competency-role-target/view/{{$item->id}}"><div class = "btn-info btn">VIEW</div></a>
                                    <a style = "float: right;" href = "competency-role-target/edit/{{$item->id}}"><div class = "btn-success btn">EDIT</div></a>
                                    <a style = "float: right;" href = "competency-role-target/delete/{{$item->id}}"><div class = "btn-danger btn">DELETE</div></a></div></td>
                            </tr> 
                        @endforeach
                    </tbody>
                </table>
            </div>

            <br>
        </div>
    </div>
</div>


@endsection

@section('scripts')


<script type="text/javascript">
    $(document).ready(function() {
            $('#basic-datatables').DataTable();
        });
    </script>


@endsection