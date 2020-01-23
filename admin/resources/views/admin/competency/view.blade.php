@extends('layouts.app')

@section('content')

<div class="container">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{route('home')}}">Home</a></li>
            <li class="breadcrumb-item"><a href="{{route('competencies.index')}}">Competency</a></li>
            <li class="breadcrumb-item active" aria-current="page">{{$competency->name}}</li>
        </ol>
    </nav>
            
    <div class="row justify-content-center">
        <div class="col-md-12">
            <h1>{{$competency->name}}</h1>
            <blockquote class="blockquote">
                <p class="mb-0">{{$cluster->name}} - {{$subcluster->name}}</p>
            </blockquote>
            <p>{!! nl2br($competency->definition) !!}</p>

            <div class="table-responsive">
                <table id="employee-datatables" class="display table table-striped table-hover" cellspacing="0" width="100%">
                    <thead>
                        <tr>
                            <th>Role</th>
                            <th>Timestamp</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($model as $item)
                            <tr>
                                <td>{{$item->role->name}}</td>
                                <td>{{$item->updated_at}}</td>
                                <td>
                                    <div style = "display: flex;"> <a style = "float: left;" href = "{{route('role.show', [ 'id' => $item->roleID])}}"><div class = "btn-info btn">VIEW</div></a></div>
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
        $('#employee-datatables').DataTable();
    });
</script>
@endsection