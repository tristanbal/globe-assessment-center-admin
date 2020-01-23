@extends('layouts.app')

@section('content')

<div class="container">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{route('home')}}">Home</a></li>
            <li class="breadcrumb-item active" aria-current="page">Users</li>
        </ol>
    </nav>
            
    <div class="row justify-content-center">
        <div class="col-md-12">
            <h1>Users</h1>
            <!-- Button trigger modal -->
            <a href="{{route('users.create')}}" class="btn btn-primary btn-sm" >
                Register New User
            </a>
            <br><br>
            <div class="table-responsive">
                <table id="basic-datatables" class="display table table-striped table-hover" cellspacing="0" width="100%">
                    <thead>
                        <tr>
                            <th>Profile Image</th>
                            <th>Employee ID</th>
                            <th>Email</th>
                            <th>Created At</th>
                            <th>Updated At</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($users as $item)
                            <tr>
                                <td>
                                    <div class="avatar">
                                        <img src="
                                        @if($item->profileImage == 'no-image.png')
                                        {{asset('stock/'.auth()->user()->profileImage)}}
                                        @else
                                        {{$item->profileImage}}
                                        @endif
                                        " alt="..." class="avatar-img rounded-circle">
                                    </div>
                                </td>
                                <td>{{$item->employeeID}}</td>
                                <td>{{$item->email}}</td>
                                <td>{{$item->created_at}}</td>
                                <td>{{$item->updated_at}}</td>
                                <td>
                                    <div style = "display: flex;">
                                        <a style = "float: right;" href = "{{route('employee.show',['id'=>$item->employeeID])}}">
                                            <div class = "btn-primary btn">VIEW EMPLOYEE</div>
                                        </a>
                                        <a style = "float: right;" href = "user/delete/{{$item->id}}">
                                            <div class = "btn-danger btn">DELETE</div>
                                        </a>
                                    </div>
                                </td>
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